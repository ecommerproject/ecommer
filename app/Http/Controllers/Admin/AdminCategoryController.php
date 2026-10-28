<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categoriesConfig = config('store.categories');
        $allProducts = Product::all();

        $categoryMetadata = [
            'perfumes' => [
                'icon' => 'sparkles',
                'color' => '#d946ef',
                'bg' => '#fdf4ff',
                'description_en' => 'Luxury designer perfumes from Chanel, Dior, YSL, and Tom Ford with long-lasting scents.',
                'description_km' => 'ទឹកអប់ម៉ាកល្បីៗ Chanel, Dior, YSL, Versace ក្លិនក្រអូបប្រណីតជាប់បានយូរ ២៤ ម៉ោង។',
            ],
            'phones' => [
                'icon' => 'devices',
                'color' => '#3b82f6',
                'bg' => '#eff6ff',
                'description_en' => 'Flagship smartphones: iPhone 16 Pro Max, Samsung Galaxy S24 Ultra & Google Pixel 9.',
                'description_km' => 'ស្មាតហ្វូនស៊េរីថ្មី iPhone 16 Pro, Samsung S24, Pixel 9 កាមេរ៉ាគុណភាពខ្ពស់ និងបន្ទះឈីប AI។',
            ],
            'computers' => [
                'icon' => 'desktop',
                'color' => '#6366f1',
                'bg' => '#eef2ff',
                'description_en' => 'High-performance laptops: MacBook Pro M3, ROG Gaming, Dell XPS & ThinkPad.',
                'description_km' => 'កុំព្យូទ័រយួរដៃ Apple MacBook Pro M3, ROG Gaming, Dell XPS សម្រាប់ធ្វើការ ឌីហ្សាញ និងលេងហ្គេម។',
            ],
            'fashion' => [
                'icon' => 'shirt',
                'color' => '#ec4899',
                'bg' => '#fdf2f8',
                'description_en' => 'Streetwear heavyweight hoodies, graphic tees, raw denim jeans, and jackets.',
                'description_km' => 'សម្លៀកបំពាក់ អាវរងា Hoodie អាវយឺត ខោខូវប៊យ និងអាវក្រៅ Bomber ទាន់សម័យ។',
            ],
            'beauty' => [
                'icon' => 'sparkles',
                'color' => '#10b981',
                'bg' => '#ecfdf5',
                'description_en' => 'Botanical skincare, hydrating hyaluronic serums, night repair oils, and SPF50+ sunscreens.',
                'description_km' => 'ផលិតផលថែរក្សាសម្រស់ សេរ៉ូមបំប៉នស្បែក គ្រីមផ្តល់សំណើម និងឡេការពារកម្ដៅថ្ងៃធម្មជាតិ ១០០%។',
            ],
        ];

        $totalProdCount = $allProducts->count();

        $categories = collect($categoriesConfig)->map(function (string $key) use ($allProducts, $categoryMetadata, $totalProdCount): array {
            $prods = $allProducts->where('category', $key);
            $activeCount = $prods->where('is_active', true)->count();
            $hiddenCount = $prods->where('is_active', false)->count();
            $newCount = $prods->where('is_new', true)->count();
            $meta = $categoryMetadata[$key] ?? [
                'icon' => 'tag',
                'color' => '#245943',
                'bg' => '#edf5ed',
                'description_en' => 'Explore items in this store category.',
                'description_km' => 'ស្វែងរកផលិតផលក្នុងជំពូកនេះ។',
            ];

            return [
                'key' => $key,
                'name_en' => __('store.categories.'.$key, [], 'en'),
                'name_km' => __('store.categories.'.$key, [], 'km'),
                'description_en' => $meta['description_en'],
                'description_km' => $meta['description_km'],
                'color' => $meta['color'],
                'bg' => $meta['bg'],
                'total_products' => $prods->count(),
                'active_products' => $activeCount,
                'hidden_products' => $hiddenCount,
                'new_products' => $newCount,
                'percentage' => $totalProdCount > 0 ? round(($prods->count() / $totalProdCount) * 100, 1) : 0,
                'min_price' => $prods->count() ? (float) $prods->min('price') : 0.0,
                'max_price' => $prods->count() ? (float) $prods->max('price') : 0.0,
                'avg_rating' => $prods->count() ? round((float) $prods->avg('rating'), 1) : 5.0,
                'sample_products' => $prods->take(6)->values(),
            ];
        });

        $topCategory = $categories->sortByDesc('total_products')->first();

        return view('admin.categories.index', [
            'categories' => $categories,
            'stats' => [
                'total_categories' => $categories->count(),
                'total_products' => $allProducts->count(),
                'active_products' => $allProducts->where('is_active', true)->count(),
                'top_category' => $topCategory['name_en'] ?? 'None',
            ],
        ]);
    }

    public function exportCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $categoriesConfig = config('store.categories');
        $allProducts = Product::all();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="dara-market-categories-'.now()->format('Ymd-His').'.csv"',
        ];

        return response()->stream(function () use ($categoriesConfig, $allProducts) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['Category Key', 'Department (EN)', 'Department (KM)', 'Total Items', 'Active / Live', 'Hidden / Draft', 'Catalog Share (%)', 'Price Min ($)', 'Price Max ($)', 'Avg Rating']);

            $total = $allProducts->count();
            foreach ($categoriesConfig as $cat) {
                $prods = $allProducts->where('category', $cat);
                $pct = $total > 0 ? round(($prods->count() / $total) * 100, 1) : 0;
                fputcsv($handle, [
                    $cat,
                    __('store.categories.'.$cat, [], 'en'),
                    __('store.categories.'.$cat, [], 'km'),
                    $prods->count(),
                    $prods->where('is_active', true)->count(),
                    $prods->where('is_active', false)->count(),
                    $pct.'%',
                    $prods->count() ? (float) $prods->min('price') : 0.0,
                    $prods->count() ? (float) $prods->max('price') : 0.0,
                    $prods->count() ? round((float) $prods->avg('rating'), 1) : 5.0,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
