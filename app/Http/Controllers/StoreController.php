<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index(Request $request): View
    {
        $locale = $this->resolveLocale($request);
        $products = $this->catalogProducts();
        $featuredProductsCount = config('store.featured_products_count');
        $featuredProducts = array_slice(
            array_values(array_filter($products, static fn (array $product): bool => ! $product['is_new'])),
            0,
            $featuredProductsCount,
        );
        $newProducts = array_values(array_filter($products, static fn (array $product): bool => $product['is_new']));
        $categoryCounts = array_fill_keys(config('store.categories'), 0);

        foreach ($products as $product) {
            $categoryCounts[$product['filter_key']]++;
        }

        return view('store.pages.home', [
            'locale' => $locale,
            'categories' => config('store.categories'),
            'categoryCounts' => $categoryCounts,
            'productCount' => count($products),
            'translations' => __('store'),
            'products' => $products,
            'featuredProducts' => $featuredProducts,
            'newProducts' => $newProducts,
        ]);
    }

    public function products(Request $request): View
    {
        $locale = $this->resolveLocale($request);
        $selectedCategory = $request->query('category');
        $categories = config('store.categories');
        $search = $request->query('q');
        $search = is_string($search) ? trim($search) : '';
        $products = $this->catalogProducts();
        $categoryCounts = array_fill_keys($categories, 0);
        $discountCount = 0;
        $topRatedCount = 0;

        foreach ($products as $prod) {
            if (isset($categoryCounts[$prod['filter_key']])) {
                $categoryCounts[$prod['filter_key']]++;
            }
            if (!empty($prod['old_price']) && $prod['old_price'] > $prod['price']) {
                $discountCount++;
            }
            if (($prod['rating'] ?? 0) >= 4.8) {
                $topRatedCount++;
            }
        }

        if ($search !== '') {
            $normalizedSearch = Str::lower($search);
            $products = array_values(array_filter(
                $products,
                static fn (array $product): bool => str_contains(
                    Str::lower($product['name'].' '.$product['category']),
                    $normalizedSearch,
                ),
            ));
        }

        return view('store.pages.products', [
            'locale' => $locale,
            'categories' => $categories,
            'categoryCounts' => $categoryCounts,
            'discountCount' => $discountCount,
            'topRatedCount' => $topRatedCount,
            'totalCount' => count($products),
            'selectedCategory' => is_string($selectedCategory) && in_array($selectedCategory, $categories, true)
                ? $selectedCategory
                : 'all',
            'search' => $search,
            'translations' => __('store'),
            'products' => $products,
        ]);
    }

    public function show(Request $request, Product $product): View
    {
        abort_unless($product->is_active, 404);

        $locale = $this->resolveLocale($request);
        $details = $this->buildProductDetails($product, $locale);

        $nameLower = strtolower($product->name_en);
        $isShirt = str_contains($nameLower, 'shirt') || str_contains($nameLower, 't-shirt') || str_contains($nameLower, 'hoodie') || str_contains($nameLower, 'tee') || str_contains($nameLower, 'polo');
        $isShoe = str_contains($nameLower, 'shoe') || str_contains($nameLower, 'sneaker') || str_contains($nameLower, 'pegasus') || str_contains($nameLower, 'runner');
        $isBag = str_contains($nameLower, 'bag') || str_contains($nameLower, 'backpack') || str_contains($nameLower, 'duffle');

        $baseQuery = Product::active()->where('id', '!=', $product->id);

        if ($product->category === 'fashion') {
            if ($isShirt) {
                $relatedQuery = (clone $baseQuery)->where('category', 'fashion')
                    ->where(function ($q): void {
                        $q->where('name_en', 'like', '%shirt%')
                            ->orWhere('name_en', 'like', '%hoodie%')
                            ->orWhere('name_en', 'like', '%tee%')
                            ->orWhere('name_en', 'like', '%polo%');
                    });
            } elseif ($isShoe) {
                $relatedQuery = (clone $baseQuery)->where('category', 'fashion')
                    ->where(function ($q): void {
                        $q->where('name_en', 'like', '%shoe%')
                            ->orWhere('name_en', 'like', '%sneaker%')
                            ->orWhere('name_en', 'like', '%runner%')
                            ->orWhere('name_en', 'like', '%pegasus%');
                    });
            } elseif ($isBag) {
                $relatedQuery = (clone $baseQuery)->where('category', 'fashion')
                    ->where(function ($q): void {
                        $q->where('name_en', 'like', '%bag%')
                            ->orWhere('name_en', 'like', '%backpack%')
                            ->orWhere('name_en', 'like', '%duffle%');
                    });
            } else {
                $relatedQuery = (clone $baseQuery)->where('category', 'fashion');
            }
        } else {
            $relatedQuery = (clone $baseQuery)->where('category', $product->category);
        }

        $relatedList = $relatedQuery->orderBy('sort_order')->take(4)->get();

        if ($relatedList->count() < 4) {
            $existingIds = array_merge([$product->id], $relatedList->pluck('id')->all());
            $fillers = (clone $baseQuery)->where('category', $product->category)
                ->whereNotIn('id', $existingIds)
                ->orderBy('sort_order')
                ->take(4 - $relatedList->count())
                ->get();
            $relatedList = $relatedList->concat($fillers);
        }

        if ($relatedList->count() < 4) {
            $existingIds = array_merge([$product->id], $relatedList->pluck('id')->all());
            $allFillers = (clone $baseQuery)->whereNotIn('id', $existingIds)
                ->take(4 - $relatedList->count())
                ->get();
            $relatedList = $relatedList->concat($allFillers);
        }

        $relatedProducts = $relatedList->values()->map(
            fn (Product $p, int $idx): array => $p->toCatalogArray($locale, $idx)
        )->all();

        return view('store.pages.product-detail', [
            'locale' => $locale,
            'product' => $details,
            'rawProduct' => $product,
            'relatedProducts' => $relatedProducts,
            'translations' => __('store'),
        ]);
    }

    public function newArrivals(Request $request): View
    {
        $locale = $this->resolveLocale($request);
        $products = array_values(array_filter(
            $this->catalogProducts(),
            static fn (array $product): bool => $product['is_new'],
        ));

        $categories = config('store.categories');
        $categoryCounts = array_fill_keys($categories, 0);
        $discountCount = 0;
        $topRatedCount = 0;

        foreach ($products as $prod) {
            if (isset($categoryCounts[$prod['filter_key']])) {
                $categoryCounts[$prod['filter_key']]++;
            }
            if (!empty($prod['old_price']) && $prod['old_price'] > $prod['price']) {
                $discountCount++;
            }
            if (($prod['rating'] ?? 0) >= 4.8) {
                $topRatedCount++;
            }
        }

        return view('store.pages.products', [
            'locale' => $locale,
            'categories' => $categories,
            'categoryCounts' => $categoryCounts,
            'discountCount' => $discountCount,
            'topRatedCount' => $topRatedCount,
            'totalCount' => count($products),
            'selectedCategory' => 'all',
            'search' => '',
            'isNewArrivals' => true,
            'translations' => __('store'),
            'products' => $products,
        ]);
    }

    public function categories(Request $request): View
    {
        $locale = $this->resolveLocale($request);
        $products = $this->catalogProducts();

        $metaConfig = [
            'fashion' => [
                'icon' => 'fashion',
                'description_km' => 'សម្លៀកបំពាក់ អាវយឺត ស្បែកជើង និងកាបូបស្ពាយរចនាបទប្រណីត',
                'description_en' => 'Trendy apparel, urban sneakers, premium backpacks & bags',
                'tags_km' => ['អាវយឺត', 'ស្បែកជើង', 'កាបូប', 'Hoodie'],
                'tags_en' => ['Shirts', 'Sneakers', 'Bags', 'Hoodies'],
                'gradient' => 'linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.02) 100%)',
                'badge' => $locale === 'km' ? 'ពេញនិយមបំផុត' : 'Most Popular',
            ],
            'electronics' => [
                'icon' => 'electronics',
                'description_km' => 'កាសស្តាប់ត្រចៀកឥតខ្សែ ឧបករណ៍សម្លេង Hi-Res និងកាមេរ៉ាទំនើប',
                'description_en' => 'Hi-Res wireless audio, studio headphones, and tech gadgets',
                'tags_km' => ['កាស Bluetooth', 'Hi-Res Audio', 'កាមេរ៉ា'],
                'tags_en' => ['Wireless Audio', 'Noise Cancelling', 'Cameras'],
                'gradient' => 'linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(37, 99, 235, 0.02) 100%)',
                'badge' => $locale === 'km' ? 'បច្ចេកវិទ្យាថ្មី' : 'Smart Tech',
            ],
            'kitchen' => [
                'icon' => 'kitchen',
                'description_km' => 'សម្ភារៈផ្ទះបាយ កែវកាហ្វេសេរ៉ាមិច និងដបទឹករក្សាកម្តៅ',
                'description_en' => 'Artisan ceramics, insulated tumblers & modern dining',
                'tags_km' => ['ដបទឹករក្សាកម្ដៅ', 'កែវ Ceramic', 'សម្ភារៈផ្ទះបាយ'],
                'tags_en' => ['Drinkware', 'Ceramics', 'Kitchenware'],
                'gradient' => 'linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(217, 119, 6, 0.02) 100%)',
                'badge' => $locale === 'km' ? 'ផ្ទះទំនើប' : 'Home Living',
            ],
            'beauty' => [
                'icon' => 'beauty',
                'description_km' => 'សេរ៉ូមបំប៉នស្បែក គ្រីមផ្តល់សំណើម និងទឹកអប់ក្លិនក្រអូបប្រណីត',
                'description_en' => 'Botanical serums, hydrating moisturizers & artisan perfumes',
                'tags_km' => ['សេរ៉ូមមុខ', 'ទឹកអប់', 'គ្រីមផ្តល់សំណើម'],
                'tags_en' => ['Facial Serums', 'Perfumes', 'Skincare'],
                'gradient' => 'linear-gradient(135deg, rgba(236, 72, 153, 0.08) 0%, rgba(219, 39, 119, 0.02) 100%)',
                'badge' => $locale === 'km' ? 'សរីរាង្គ 100%' : '100% Organic',
            ],
        ];

        $categories = array_map(static function (string $category) use ($products, $metaConfig, $locale): array {
            $categoryProducts = array_values(array_filter(
                $products,
                static fn (array $product): bool => $product['filter_key'] === $category,
            ));
            $firstProduct = $categoryProducts[0] ?? null;
            $meta = $metaConfig[$category] ?? [];

            $thumbnails = array_slice(
                array_map(static fn (array $p): string => $p['image'], $categoryProducts),
                0,
                4
            );

            $prices = array_map(static fn (array $p): float => (float) $p['price'], $categoryProducts);
            $minPrice = count($prices) > 0 ? min($prices) : 0;

            return [
                'key' => $category,
                'count' => count($categoryProducts),
                'image' => $firstProduct['image'] ?? asset('images/store-placeholder.svg'),
                'product_name' => $firstProduct['name'] ?? null,
                'min_price' => $minPrice,
                'thumbnails' => $thumbnails,
                'icon' => $meta['icon'] ?? 'star',
                'description' => $locale === 'km' ? ($meta['description_km'] ?? '') : ($meta['description_en'] ?? ''),
                'tags' => $locale === 'km' ? ($meta['tags_km'] ?? []) : ($meta['tags_en'] ?? []),
                'badge' => $meta['badge'] ?? null,
                'gradient' => $meta['gradient'] ?? 'transparent',
            ];
        }, config('store.categories'));

        return view('store.pages.categories', [
            'locale' => $locale,
            'categories' => $categories,
            'totalCategories' => count($categories),
            'totalProducts' => count($products),
            'translations' => __('store'),
        ]);
    }

    public function about(Request $request): View
    {
        $locale = $this->resolveLocale($request);

        return view('store.pages.about', [
            'locale' => $locale,
            'translations' => __('store'),
        ]);
    }

    public function contact(Request $request): View
    {
        $locale = $this->resolveLocale($request);

        return view('store.pages.contact', [
            'locale' => $locale,
            'translations' => __('store'),
        ]);
    }

    public function submitContact(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'phone_or_email' => ['required', 'string', 'min:5', 'max:100'],
            'subject' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        \Illuminate\Support\Facades\DB::table('contact_messages')->insert([
            'name' => $validated['name'],
            'phone_or_email' => $validated['phone_or_email'],
            'subject' => $validated['subject'] ?? 'general',
            'message' => $validated['message'],
            'status' => 'unread',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $locale = $this->resolveLocale($request);
        $successMessage = $locale === 'km'
            ? 'សាររបស់អ្នកត្រូវបានផ្ញើដោយជោគជ័យ! ក្រុមការងារយើងនឹងទាក់ទងមកអ្នកវិញក្នុងពេលឆាប់បំផុត។'
            : 'Your message has been sent successfully! Our team will get back to you shortly.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
            ]);
        }

        return back()->with('contact_success', $successMessage);
    }

    public function trackOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        $orderNumber = trim((string) $request->query('order_number', ''));
        $phone = trim((string) $request->query('phone', ''));

        if ($orderNumber === '') {
            return response()->json([
                'success' => false,
                'message' => 'Please enter an order number.',
            ], 422);
        }

        $cleanNumber = ltrim($orderNumber, '#');

        $query = \App\Models\Order::query()
            ->where(function ($q) use ($cleanNumber): void {
                $q->where('order_number', $cleanNumber)
                    ->orWhere('order_number', 'ORD-'.$cleanNumber);
            });

        if ($phone !== '') {
            $query->where('customer_phone', 'like', "%{$phone}%");
        }

        $order = $query->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found. Please verify your order number (#ORD-xxxx) and try again.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => [
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'status' => $order->order_status,
                'payment_status' => $order->payment_status,
                'payment_method' => $order->payment_method,
                'total_amount' => number_format((float) $order->total_amount, 2),
                'items_count' => $order->items_count,
                'date' => $order->created_at->format('d M Y, h:i A'),
            ],
        ]);
    }

    public function searchApi(Request $request): \Illuminate\Http\JsonResponse
    {
        $q = trim((string) $request->query('q', ''));
        $cat = trim((string) $request->query('category', 'all'));

        $products = Product::active()
            ->when($cat !== 'all', fn ($query) => $query->where('category', $cat))
            ->when($q !== '', function ($query) use ($q): void {
                $query->where(function ($sub) use ($q): void {
                    $sub->where('name_en', 'like', "%{$q}%")
                        ->orWhere('name_km', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%");
                });
            })
            ->take(6)
            ->get(['id', 'name_en', 'name_km', 'category', 'price', 'image_url', 'badge']);

        return response()->json([
            'products' => $products,
        ]);
    }

    private function resolveLocale(Request $request): string
    {
        $requestedLocale = $request->query('lang');

        if (is_string($requestedLocale) && in_array($requestedLocale, config('store.supported_locales'), true)) {
            $request->session()->put('store_locale', $requestedLocale);
        }

        $locale = $request->session()->get('store_locale', config('store.default_locale'));
        app()->setLocale($locale);

        return $locale;
    }

    private function catalogProducts(): array
    {
        return Product::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Product $product, int $index): array => $product->toCatalogArray(app()->getLocale(), $index))
            ->all();
    }

    private function buildProductDetails(Product $product, string $locale): array
    {
        $name = $locale === 'en' ? $product->name_en : $product->name_km;
        $categoryKey = $product->category;
        $categoryName = __('store.products_data.'.$categoryKey, [], $locale);
        $nameLower = strtolower($product->name_en);

        if ($categoryKey === 'fashion') {
            if (str_contains($nameLower, 'shoe') || str_contains($nameLower, 'sneaker') || str_contains($nameLower, 'comfort')) {
                $brand = 'Nike';
                $brandLogo = 'nike';
                $subtitle = $locale === 'km' ? "ស្បែកជើងរត់ និងកីឡាសម្រាំងពិសេស" : "Women's & Men's Running Shoes";
                $breadcrumbs = $locale === 'km'
                    ? ['សម្លៀកបំពាក់ និងស្បែកជើង', 'ស្បែកជើង', 'Nike']
                    : ['Clothes and shoes', 'Shoes', 'Nike'];
                $sizes = ['39', '40', '40.5', '41', '42', '43', '43.5', '44', '45'];
                $defaultSize = '41';
                $sizeType = 'shoes';
                $colors = [
                    [
                        'name' => $locale === 'km' ? 'ស / បៃតង (White/Green)' : 'White / Volt Green',
                        'code' => '#65a30d',
                        'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ក្រហម Crimson Red' : 'Crimson Red',
                        'code' => '#dc2626',
                        'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ពណ៌ស Triple White' : 'Triple White',
                        'code' => '#f4f4f5',
                        'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ផ្កាឈូក Hot Pink' : 'Hot Pink',
                        'code' => '#ec4899',
                        'image' => 'https://images.unsplash.com/photo-1579338559194-a162d19bf842?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ខ្មៅ Midnight Black' : 'Midnight Black',
                        'code' => '#18181b',
                        'image' => 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&w=1000&q=85',
                    ],
                ];
                $gallery = [
                    'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?auto=format&fit=crop&w=1000&q=85',
                ];
            } elseif (str_contains($nameLower, 'shirt') || str_contains($nameLower, 'cotton') || str_contains($nameLower, 't-shirt')) {
                $brand = 'Dara Apparel';
                $brandLogo = 'apparel';
                $subtitle = $locale === 'km' ? 'អាវយឺតកប្បាសធម្មជាតិ 100% ទន់ស្រួលពាក់' : '100% Organic Heavyweight Cotton';
                $breadcrumbs = $locale === 'km'
                    ? ['សម្លៀកបំពាក់', 'អាវយឺត និងសឺមី', 'Dara Apparel']
                    : ['Clothes and fashion', 'Shirts & Tops', 'Dara Apparel'];
                $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL'];
                $defaultSize = 'L';
                $sizeType = 'clothing';
                $colors = [
                    [
                        'name' => $locale === 'km' ? 'ពណ៌ស Classic White' : 'Classic White',
                        'code' => '#ffffff',
                        'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ពណ៌ខ្មៅ Pitch Black' : 'Pitch Black',
                        'code' => '#18181b',
                        'image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'បៃតង Military Olive' : 'Military Olive',
                        'code' => '#4d5b40',
                        'image' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ប្រផេះ Heather Gray' : 'Heather Gray',
                        'code' => '#9ca3af',
                        'image' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?auto=format&fit=crop&w=1000&q=85',
                    ],
                ];
                $gallery = [
                    'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?auto=format&fit=crop&w=1000&q=85',
                ];
            } elseif (str_contains($nameLower, 'bag') || str_contains($nameLower, 'backpack')) {
                $brand = 'Dara Classic';
                $brandLogo = 'bag';
                $subtitle = $locale === 'km' ? 'កាបូបស្ពាយការពារជ្រាបទឹក និងដាក់ Laptop បាន' : 'Urban Minimalist Commuter Backpack';
                $breadcrumbs = $locale === 'km'
                    ? ['ម៉ូដ និងគ្រឿងបន្ថែម', 'កាបូប', 'Dara Classic']
                    : ['Bags and Accessories', 'Backpacks', 'Dara Classic'];
                $sizes = ['16L (Compact)', '20L (Everyday)', '26L (Pro Travel)'];
                $defaultSize = '20L (Everyday)';
                $sizeType = 'capacity';
                $colors = [
                    [
                        'name' => $locale === 'km' ? 'ពណ៌ខៀវ Navy Blue' : 'Navy Blue',
                        'code' => '#1e3a8a',
                        'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ពណ៌ខ្មៅ Stealth Black' : 'Stealth Black',
                        'code' => '#0f172a',
                        'image' => 'https://images.unsplash.com/photo-1581605405669-fcdf81165afa?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'បៃតងចាស់ Olive Green' : 'Olive Green',
                        'code' => '#14532d',
                        'image' => 'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?auto=format&fit=crop&w=1000&q=85',
                    ],
                ];
                $gallery = [
                    'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1581605405669-fcdf81165afa?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1546938576-6e6a64f317cc?auto=format&fit=crop&w=1000&q=85',
                ];
            } else {
                $brand = 'RayShade Optics';
                $brandLogo = 'optics';
                $subtitle = $locale === 'km' ? 'វ៉ែនតាការពារកាំរស្មី UV400 Polarized' : 'Polarized UV400 Protection Sunglasses';
                $breadcrumbs = $locale === 'km'
                    ? ['ម៉ូដ និងគ្រឿងបន្ថែម', 'វ៉ែនតា', 'RayShade']
                    : ['Accessories', 'Eyewear', 'RayShade'];
                $sizes = ['Standard (52mm)', 'Wide Fit (55mm)'];
                $defaultSize = 'Standard (52mm)';
                $sizeType = 'fit';
                $colors = [
                    [
                        'name' => $locale === 'km' ? 'ស៊ុមខ្មៅ Black Lens' : 'Matte Black',
                        'code' => '#18181b',
                        'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ស៊ុមមាស Tortoise Gold' : 'Tortoise Gold',
                        'code' => '#b45309',
                        'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=1000&q=85',
                    ],
                ];
                $gallery = [
                    'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=1000&q=85',
                ];
            }
        } elseif ($categoryKey === 'electronics') {
            if (str_contains($nameLower, 'headphone')) {
                $brand = 'AudioMax Wireless';
                $brandLogo = 'audio';
                $subtitle = $locale === 'km' ? 'កាសបំពាក់ប្រព័ន្ធកាត់សម្លេងរំខាន ANC & Hi-Res Sound' : 'Hi-Res Active Noise Cancelling Headphones';
                $breadcrumbs = $locale === 'km'
                    ? ['អេឡិចត្រូនិច', 'ឧបករណ៍សម្លេង', 'AudioMax']
                    : ['Electronics', 'Audio', 'AudioMax'];
                $sizes = ['Standard Bluetooth', 'ANC Noise-Cancelling', 'Studio Pro Edition'];
                $defaultSize = 'ANC Noise-Cancelling';
                $sizeType = 'edition';
                $colors = [
                    [
                        'name' => $locale === 'km' ? 'ខ្មៅមាស Amber Gold & Black' : 'Amber Gold & Black',
                        'code' => '#b45309',
                        'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ពណ៌សសុទ្ធ Pure Pearl White' : 'Pure Pearl White',
                        'code' => '#f4f4f5',
                        'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ពណ៌ខៀវ Midnight Blue' : 'Midnight Blue',
                        'code' => '#1e3a8a',
                        'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=1000&q=85',
                    ],
                ];
                $gallery = [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=1000&q=85',
                ];
            } elseif (str_contains($nameLower, 'watch')) {
                $brand = 'Chronos Time';
                $brandLogo = 'watch';
                $subtitle = $locale === 'km' ? 'នាឡិកាដៃឆ្លាតវៃអេក្រង់ច្បាស់ និងថាមពលថ្មបានយូរ' : 'Minimalist Smart Activity Watch';
                $breadcrumbs = $locale === 'km'
                    ? ['អេឡិចត្រូនិច', 'នាឡិកាឆ្លាតវៃ', 'Chronos']
                    : ['Electronics', 'Wearables', 'Chronos'];
                $sizes = ['40mm Silicone', '44mm Silicone Sport', '44mm Leather Classic'];
                $defaultSize = '44mm Silicone Sport';
                $sizeType = 'edition';
                $colors = [
                    [
                        'name' => $locale === 'km' ? 'ពណ៌ស Frost White' : 'Frost White',
                        'code' => '#e4e4e7',
                        'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ប្រផេះ Space Gray' : 'Space Gray',
                        'code' => '#4b5563',
                        'image' => 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&w=1000&q=85',
                    ],
                    [
                        'name' => $locale === 'km' ? 'ពណ៌មាស Rose Gold' : 'Rose Gold',
                        'code' => '#fb7185',
                        'image' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=1000&q=85',
                    ],
                ];
                $gallery = [
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&w=1000&q=85',
                    'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=1000&q=85',
                ];
            } else {
                $brand = 'AlphaOptic 4K';
                $brandLogo = 'camera';
                $subtitle = $locale === 'km' ? 'កាមេរ៉ាឌីជីថលទំហំតូច និងថតវីដេអូ 4K 60fps' : 'Ultra-compact 4K 60fps Creator Camera';
                $breadcrumbs = $locale === 'km'
                    ? ['អេឡិចត្រូនិច', 'កាមេរ៉ា និងថតរូប', 'AlphaOptic']
                    : ['Electronics', 'Cameras', 'AlphaOptic'];
                $sizes = ['Body Only', 'Lens Kit (24-70mm)', 'Creator Vlogging Kit'];
                $defaultSize = 'Lens Kit (24-70mm)';
                $sizeType = 'bundle';
                $colors = [
                    [
                        'name' => $locale === 'km' ? 'ខ្មៅ Matte Black' : 'Matte Black',
                        'code' => '#18181b',
                        'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=1000&q=85',
                    ],
                ];
                $gallery = [
                    'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=1000&q=85',
                ];
            }
        } elseif ($categoryKey === 'kitchen') {
            $brand = 'EcoKitchen Living';
            $brandLogo = 'home';
            $subtitle = $locale === 'km' ? 'សម្ភារៈផ្ទះបាយ និងកែវទំនើបប្រកបដោយសោភ័ណភាព' : 'Premium Stainless & Artisan Ceramics';
            $breadcrumbs = $locale === 'km'
                ? ['ផ្ទះបាយ', 'សម្ភារៈប្រើប្រាស់', 'EcoKitchen']
                : ['Kitchen & Dining', 'Drinkware', 'EcoKitchen'];
            $sizes = ['350ml (Small)', '500ml (Standard)', '750ml (Large)'];
            $defaultSize = '500ml (Standard)';
            $sizeType = 'capacity';
            $colors = [
                [
                    'name' => $locale === 'km' ? 'ប្រផេះ Matte Slate' : 'Matte Slate',
                    'code' => '#64748b',
                    'image' => $product->image_url,
                ],
                [
                    'name' => $locale === 'km' ? 'សមុទ្រ Ocean Navy' : 'Ocean Navy',
                    'code' => '#1e3a8a',
                    'image' => 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?auto=format&fit=crop&w=1000&q=85',
                ],
            ];
            $gallery = [
                $product->image_url,
                'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?auto=format&fit=crop&w=1000&q=85',
            ];
        } else {
            $brand = 'Dara Selection';
            $brandLogo = 'star';
            $subtitle = $locale === 'km' ? 'ទំនិញគុណភាពខ្ពស់ ធានាសុវត្ថិភាព 100%' : 'High Quality Everyday Selection';
            $breadcrumbs = [$categoryName, $name];
            $sizes = ['Standard Option'];
            $defaultSize = 'Standard Option';
            $sizeType = 'standard';
            $colors = [
                ['name' => 'Default', 'code' => '#1e3a8a', 'image' => $product->image_url],
            ];
            $gallery = [$product->image_url];
        }

        return [
            'id' => (string) $product->id,
            'name' => $name,
            'brand' => $brand,
            'subtitle' => $subtitle,
            'category_key' => $categoryKey,
            'category_name' => $categoryName,
            'breadcrumbs' => $breadcrumbs,
            'price' => (float) $product->price,
            'old_price' => $product->old_price === null ? null : (float) $product->old_price,
            'discount_percent' => $product->old_price ? round((($product->old_price - $product->price) / $product->old_price) * 100) : null,
            'rating' => (float) $product->rating,
            'reviews_count' => 38 + ($product->id * 4),
            'stock' => $product->stock ?? 45,
            'sku' => $product->sku,
            'main_image' => $gallery[0] ?? $product->image_url,
            'gallery' => $gallery,
            'colors' => $colors,
            'sizes' => $sizes,
            'default_size' => $defaultSize,
            'size_type' => $sizeType,
            'badge' => $product->badge,
        ];
    }
}
