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
            'electronics' => [
                'icon' => 'devices',
                'color' => '#3b82f6',
                'bg' => '#eef3ff',
                'description_en' => 'Smart devices, headphones, audio equipment, and digital lifestyle accessories.',
                'description_km' => 'ឧបករណ៍ឆ្លាតវៃ កាសស្តាប់ នាឡិកា និងគ្រឿងអេឡិចត្រូនិចទាន់សម័យ។',
            ],
            'fashion' => [
                'icon' => 'shirt',
                'color' => '#ec4899',
                'bg' => '#fdf2f8',
                'description_en' => 'Bags, backpacks, sneakers, eyewear, and contemporary apparel.',
                'description_km' => 'កាបូបស្ពាយ ស្បែកជើង វ៉ែនតា និងសម្លៀកបំពាក់ទាន់សម័យ។',
            ],
            'kitchen' => [
                'icon' => 'coffee',
                'color' => '#d97706',
                'bg' => '#fef3c7',
                'description_en' => 'Insulated bottles, ceramic mugs, drinkware, and dining essentials.',
                'description_km' => 'ដបទឹកកម្ដៅ កែវសេរ៉ាមិច និងសម្ភារៈផ្ទះបាយប្រណិត។',
            ],
            'beauty' => [
                'icon' => 'sparkles',
                'color' => '#a855f7',
                'bg' => '#f3e8ff',
                'description_en' => 'Skincare products, daily cosmetics, personal wellness, and self-care.',
                'description_km' => 'ផលិតផលថែរក្សាស្បែក គ្រឿងសម្អាង និងការថែទាំសម្រស់ប្រចាំថ្ងៃ។',
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
