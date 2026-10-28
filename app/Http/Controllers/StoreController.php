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

        $baseQuery = Product::active()->where('id', '!=', $product->id)->where('category', $product->category);

        if ($product->category === 'fashion') {
            if ($isShirt) {
                $relatedQuery = (clone $baseQuery)->where(function ($q): void {
                    $q->where('name_en', 'like', '%shirt%')
                        ->orWhere('name_en', 'like', '%hoodie%')
                        ->orWhere('name_en', 'like', '%tee%')
                        ->orWhere('name_en', 'like', '%polo%');
                });
            } elseif ($isShoe) {
                $relatedQuery = (clone $baseQuery)->where(function ($q): void {
                    $q->where('name_en', 'like', '%shoe%')
                        ->orWhere('name_en', 'like', '%sneaker%')
                        ->orWhere('name_en', 'like', '%runner%')
                        ->orWhere('name_en', 'like', '%pegasus%');
                });
            } elseif ($isBag) {
                $relatedQuery = (clone $baseQuery)->where(function ($q): void {
                    $q->where('name_en', 'like', '%bag%')
                        ->orWhere('name_en', 'like', '%backpack%')
                        ->orWhere('name_en', 'like', '%duffle%');
                });
            } else {
                $relatedQuery = clone $baseQuery;
            }
        } elseif ($product->category === 'beauty') {
            $isPerfume = str_contains($nameLower, 'parfum') || str_contains($nameLower, 'perfume') || str_contains($nameLower, 'eau') || str_contains($nameLower, 'noir') || str_contains($nameLower, 'fragrance') || str_contains($nameLower, 'sauvage') || str_contains($product->name_km, 'ទឹកអប់');
            if ($isPerfume) {
                // If perfume, prioritize other perfumes in Beauty first!
                $relatedQuery = (clone $baseQuery)->where(function ($q): void {
                    $q->where('name_en', 'like', '%parfum%')
                        ->orWhere('name_en', 'like', '%perfume%')
                        ->orWhere('name_en', 'like', '%fragrance%')
                        ->orWhere('name_en', 'like', '%eau%')
                        ->orWhere('name_en', 'like', '%sauvage%')
                        ->orWhere('name_km', 'like', '%ទឹកអប់%');
                });
            } else {
                $relatedQuery = clone $baseQuery;
            }
        } else {
            $relatedQuery = clone $baseQuery;
        }

        $relatedList = $relatedQuery->orderBy('sort_order')->take(4)->get();

        // Fill remaining slots ONLY from the SAME CATEGORY (Never mix from other categories!)
        if ($relatedList->count() < 4) {
            $existingIds = array_merge([$product->id], $relatedList->pluck('id')->all());
            $fillers = (clone $baseQuery)
                ->whereNotIn('id', $existingIds)
                ->orderBy('sort_order')
                ->take(4 - $relatedList->count())
                ->get();
            $relatedList = $relatedList->concat($fillers);
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
            'perfumes' => [
                'icon' => 'perfumes',
                'description_km' => 'ទឹកអប់ម៉ាកល្បីៗ Chanel, Dior, YSL, Versace ក្លិនក្រអូបប្រណីតជាប់បានយូរ ២៤ ម៉ោង',
                'description_en' => 'Luxury designer perfumes from Chanel, Dior, YSL & Tom Ford with 24h lasting scent',
                'tags_km' => ['ទឹកអប់បុរស', 'ទឹកអប់នារី', 'Chanel', 'Dior'],
                'tags_en' => ['Parfum', 'Fragrance', 'Chanel', 'Dior'],
                'gradient' => 'linear-gradient(135deg, rgba(236, 72, 153, 0.08) 0%, rgba(219, 39, 119, 0.02) 100%)',
                'badge' => $locale === 'km' ? 'ប្រណីត ១០០%' : '100% Authentic',
            ],
            'phones' => [
                'icon' => 'phones',
                'description_km' => 'ទូរស័ព្ទស្មាតហ្វូនស៊េរីថ្មី iPhone 16 Pro Max, Samsung Galaxy S24, Pixel 9 Pro',
                'description_en' => 'Latest flagship smartphones: iPhone 16 Pro Max, Samsung S24 Ultra & Pixel 9',
                'tags_km' => ['iPhone 16', 'Galaxy AI', 'Pixel 9', '5G AI'],
                'tags_en' => ['iPhone', 'Galaxy AI', 'Smartphones', '5G'],
                'gradient' => 'linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(37, 99, 235, 0.02) 100%)',
                'badge' => $locale === 'km' ? 'ធានា ១ ឆ្នាំ' : '1 Year Warranty',
            ],
            'computers' => [
                'icon' => 'computers',
                'description_km' => 'កុំព្យូទ័រយួរដៃ Apple MacBook Pro M3, ROG Gaming, Dell XPS, ThinkPad',
                'description_en' => 'High-performance laptops: MacBook Pro M3, ROG Gaming, Dell XPS & ThinkPad',
                'tags_km' => ['MacBook M3', 'Gaming RTX', 'Dell XPS', 'Ultrabook'],
                'tags_en' => ['MacBook', 'Gaming Laptops', 'OLED', 'Workstations'],
                'gradient' => 'linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(67, 56, 202, 0.02) 100%)',
                'badge' => $locale === 'km' ? 'កម្លាំងខ្លាំង' : 'Pro Performance',
            ],
            'fashion' => [
                'icon' => 'fashion',
                'description_km' => 'សម្លៀកបំពាក់ អាវរងា Hoodie អាវយឺត ខោខូវប៊យ និងអាវក្រៅ Bomber',
                'description_en' => 'Trendy streetwear hoodies, graphic tees, raw denim jeans & bomber jackets',
                'tags_km' => ['Hoodie', 'អាវយឺត', 'ខូវប៊យ', 'អាវក្រៅ'],
                'tags_en' => ['Hoodies', 'T-Shirts', 'Denim', 'Jackets'],
                'gradient' => 'linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.02) 100%)',
                'badge' => $locale === 'km' ? 'ស្ទីលទាន់សម័យ' : 'Streetwear Style',
            ],
            'beauty' => [
                'icon' => 'beauty',
                'description_km' => 'ផលិតផលថែរក្សាសម្រស់ សេរ៉ូមបំប៉នស្បែក គ្រីមផ្តល់សំណើម និងឡេការពារកម្ដៅថ្ងៃ',
                'description_en' => 'Dermatologist-tested skincare: botanical serums, hydra-creams & SPF50+ sunscreens',
                'tags_km' => ['សេរ៉ូមមុខ', 'គ្រីមផ្តល់សំណើម', 'ឡេការពារកម្តៅថ្ងៃ', 'Organic'],
                'tags_en' => ['Hydrating Serums', 'Night Repair', 'Sunscreen', 'Organic'],
                'gradient' => 'linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(217, 119, 6, 0.02) 100%)',
                'badge' => $locale === 'km' ? 'សរីរាង្គ ១០០%' : '100% Organic',
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
                'message' => 'សូមបញ្ចូលលេខសម្គាល់ការកុម្ម៉ង់ (Please enter an order number).',
            ], 422);
        }

        $cleanNumber = trim(ltrim($orderNumber, '#'));

        $query = \App\Models\Order::query()
            ->where(function ($q) use ($cleanNumber): void {
                $q->where('order_number', $cleanNumber)
                    ->orWhere('order_number', 'ORD-'.$cleanNumber)
                    ->orWhere('order_number', 'ORD-2026-'.$cleanNumber)
                    ->orWhere('order_number', 'like', '%'.$cleanNumber);
            });

        if ($phone !== '') {
            $digitsPhone = preg_replace('/[^0-9]/', '', $phone);
            if (strlen($digitsPhone) >= 6) {
                $lastDigits = substr($digitsPhone, -7);
                $query->where(function ($q) use ($phone, $lastDigits): void {
                    $q->where('customer_phone', 'like', "%{$phone}%")
                        ->orWhere('customer_phone', 'like', "%{$lastDigits}%");
                });
            }
        }

        $order = $query->latest()->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'រកមិនឃើញការកុម្ម៉ង់នេះទេ! សូមពិនិត្យលេខកុម្ម៉ង់ (#ORD-xxxx) រួចព្យាយាមម្តងទៀត។ (Order not found. Please verify your order number and try again.)',
            ], 404);
        }

        $items = [];
        if (is_array($order->items)) {
            foreach ($order->items as $it) {
                $items[] = [
                    'name' => html_entity_decode($it['name'] ?? 'Item', ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                    'price' => number_format((float) ($it['price'] ?? 0), 2),
                    'quantity' => (int) ($it['quantity'] ?? 1),
                    'image' => $it['image'] ?? 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80',
                ];
            }
        }

        $statusNotes = [
            'pending' => [
                'km' => 'ការបញ្ជាទិញត្រូវបានកត់ត្រាទុកក្នុងប្រព័ន្ធ។ ក្រុមការងារយើងនឹងទាក់ទងបញ្ជាក់ក្នុងពេលឆាប់ៗ។',
                'en' => 'Order placed successfully. Our team will verify and confirm shortly.',
            ],
            'processing' => [
                'km' => 'ទំនិញរបស់អ្នកកំពុងត្រូវបានត្រួតពិនិត្យគុណភាព និងវេចខ្ចប់យ៉ាងយកចិត្តទុកដាក់ក្នុងស្តុក។',
                'en' => 'Your items are being carefully inspected and packed for dispatch.',
            ],
            'shipped' => [
                'km' => 'ទំនិញបានចេញដំណើរហើយ! អ្នកដឹកជញ្ជូននឹងទាក់ទងតាមទូរស័ព្ទមុនពេលទៅដល់។',
                'en' => 'Your order is on the way! The courier will call you prior to arrival.',
            ],
            'delivered' => [
                'km' => 'ទំនិញត្រូវបានប្រគល់ជូនរួចរាល់ដោយជោគជ័យ។ សូមអរគុណសម្រាប់ការគាំទ្រ!',
                'en' => 'Order successfully delivered. Thank you for shopping with Dara Market!',
            ],
            'cancelled' => [
                'km' => 'ការបញ្ជាទិញត្រូវបានលុបចោល។ សូមទាក់ទងមកកាន់យើងខ្ញុំតាម 071 450 4547 ប្រសិនបើមានចម្ងល់។',
                'en' => 'This order has been cancelled. Please contact 071 450 4547 for assistance.',
            ],
        ];

        return response()->json([
            'success' => true,
            'order' => [
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'shipping_address' => $order->shipping_address,
                'status' => $order->order_status,
                'payment_status' => $order->payment_status,
                'payment_method' => $order->payment_method,
                'total_amount' => number_format((float) $order->total_amount, 2),
                'items_count' => $order->items_count,
                'items' => $items,
                'status_note' => $statusNotes[$order->order_status] ?? $statusNotes['pending'],
                'date' => $order->created_at->format('d M Y, h:i A'),
                'updated_at' => $order->updated_at ? $order->updated_at->format('d M Y, h:i A') : $order->created_at->format('d M Y, h:i A'),
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
        } elseif ($categoryKey === 'perfumes') {
            $brand = 'Maison De Luxe';
            if (str_contains($nameLower, 'chanel')) {
                $brand = 'Chanel Paris';
            } elseif (str_contains($nameLower, 'dior')) {
                $brand = 'Dior Beauty';
            } elseif (str_contains($nameLower, 'tom ford')) {
                $brand = 'Tom Ford Private Blend';
            } elseif (str_contains($nameLower, 'versace')) {
                $brand = 'Versace Fragrances';
            } elseif (str_contains($nameLower, 'ysl') || str_contains($nameLower, 'laurent')) {
                $brand = 'Yves Saint Laurent';
            } elseif (str_contains($nameLower, 'armani')) {
                $brand = 'Giorgio Armani';
            }
            $brandLogo = 'fragrance';
            $subtitle = $locale === 'km' ? 'ទឹកអប់ក្លិនក្រអូបប្រណីតជាប់បានយូរ ២៤ ម៉ោង' : 'Long-Lasting 24H Luxury Eau De Parfum';
            $breadcrumbs = $locale === 'km'
                ? ['ទឹកអប់', 'ទឹកអប់ប្រណីត', $brand]
                : ['Perfumes', 'Luxury Fragrances', $brand];
            $sizes = ['30ml (Travel)', '50ml (Standard)', '100ml (Deluxe)'];
            $defaultSize = '50ml (Standard)';
            $sizeType = 'volume';
            $colors = [
                [
                    'name' => $locale === 'km' ? 'ក្លិនដើម Noir Classic' : 'Noir Classic',
                    'code' => '#18181b',
                    'image' => $product->image_url,
                ],
            ];
            $gallery = [
                $product->image_url,
                'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=1000&q=85',
                'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=1000&q=85',
            ];
        } elseif ($categoryKey === 'phones') {
            $brand = 'Apple Flagship';
            if (str_contains($nameLower, 'samsung')) {
                $brand = 'Samsung Galaxy';
            } elseif (str_contains($nameLower, 'pixel')) {
                $brand = 'Google Pixel';
            } elseif (str_contains($nameLower, 'xiaomi')) {
                $brand = 'Xiaomi Leica';
            } elseif (str_contains($nameLower, 'oneplus')) {
                $brand = 'OnePlus Never Settle';
            }
            $brandLogo = 'phone';
            $subtitle = $locale === 'km' ? 'ស្មាតហ្វូនស៊េរីថ្មី កាមេរ៉ាគុណភាពខ្ពស់ និងបន្ទះឈីប AI ល្បឿនលឿន' : 'Flagship 5G Smartphone with Pro Camera & AI';
            $breadcrumbs = $locale === 'km'
                ? ['ទូរស័ព្ទ', 'ស្មាតហ្វូន', $brand]
                : ['Phones', 'Smartphones', $brand];
            $sizes = ['128GB Storage', '256GB Storage', '512GB Storage', '1TB Pro'];
            $defaultSize = '256GB Storage';
            $sizeType = 'storage';
            $colors = [
                [
                    'name' => $locale === 'km' ? 'ពណ៌ដើម Titanium / Onyx' : 'Titanium / Onyx',
                    'code' => '#374151',
                    'image' => $product->image_url,
                ],
                [
                    'name' => $locale === 'km' ? 'ពណ៌ Midnight' : 'Midnight Blue',
                    'code' => '#1e3a8a',
                    'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=1000&q=85',
                ],
            ];
            $gallery = [
                $product->image_url,
                'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=1000&q=85',
                'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&w=1000&q=85',
            ];
        } elseif ($categoryKey === 'computers') {
            $brand = 'Apple Silicon';
            if (str_contains($nameLower, 'rog') || str_contains($nameLower, 'asus')) {
                $brand = 'ASUS Republic of Gamers';
            } elseif (str_contains($nameLower, 'dell') || str_contains($nameLower, 'xps')) {
                $brand = 'Dell Precision';
            } elseif (str_contains($nameLower, 'thinkpad') || str_contains($nameLower, 'lenovo')) {
                $brand = 'Lenovo ThinkPad';
            } elseif (str_contains($nameLower, 'spectre') || str_contains($nameLower, 'hp')) {
                $brand = 'HP Premium';
            } elseif (str_contains($nameLower, 'razer')) {
                $brand = 'Razer Blade Chroma';
            } elseif (str_contains($nameLower, 'surface') || str_contains($nameLower, 'microsoft')) {
                $brand = 'Microsoft Surface';
            } elseif (str_contains($nameLower, 'predator') || str_contains($nameLower, 'acer')) {
                $brand = 'Acer Predator';
            }
            $brandLogo = 'computer';
            $subtitle = $locale === 'km' ? 'កុំព្យូទ័រយួរដៃកម្លាំងខ្លាំង សម្រាប់ធ្វើការ ឌីហ្សាញ និងលេងហ្គេម' : 'High-Performance Workstation & Gaming Laptop';
            $breadcrumbs = $locale === 'km'
                ? ['កុំព្យូទ័រ', 'Laptops & PCs', $brand]
                : ['Computers', 'Laptops', $brand];
            $sizes = ['16GB RAM / 512GB SSD', '32GB RAM / 1TB SSD', '64GB RAM / 2TB SSD'];
            $defaultSize = '32GB RAM / 1TB SSD';
            $sizeType = 'configuration';
            $colors = [
                [
                    'name' => $locale === 'km' ? 'ពណ៌ Space Black / Gray' : 'Space Black / Gray',
                    'code' => '#18181b',
                    'image' => $product->image_url,
                ],
                [
                    'name' => $locale === 'km' ? 'ពណ៌ Silver Aluminum' : 'Silver Aluminum',
                    'code' => '#9ca3af',
                    'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1000&q=85',
                ],
            ];
            $gallery = [
                $product->image_url,
                'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1000&q=85',
                'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=1000&q=85',
            ];
        } elseif ($categoryKey === 'beauty') {
            $brand = 'Lumière Botanical Skincare';
            $brandLogo = 'beauty';
            $subtitle = $locale === 'km' ? 'សេរ៉ូម និងគ្រីមបំប៉នស្បែកធម្មជាតិ 100% Organic Dermatologist Tested' : '100% Organic Dermatologist Tested Botanical Formula';
            $breadcrumbs = $locale === 'km'
                ? ['ថែរក្សាសម្រស់', 'ថែរក្សាស្បែកមុខ', 'Lumière']
                : ['Beauty & Skincare', 'Facial Care', 'Lumière'];
            $sizes = ['30ml (Standard)', '50ml (Value Size)', '100ml (Jumbo)'];
            $defaultSize = '50ml (Value Size)';
            $sizeType = 'volume';
            $colors = [
                [
                    'name' => $locale === 'km' ? 'រូបមន្តដើម Pure Glow' : 'Pure Glow',
                    'code' => '#10b981',
                    'image' => $product->image_url,
                ],
            ];
            $gallery = [
                $product->image_url,
                'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?auto=format&fit=crop&w=1000&q=85',
                'https://images.unsplash.com/photo-1608248597359-597495b54d3d?auto=format&fit=crop&w=1000&q=85',
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
            'badge_color' => $product->badge_color,
            'badge_style' => $product->badge_style ?? 'solid',
        ];
    }
}
