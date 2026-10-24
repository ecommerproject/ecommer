<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminProductController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', Rule::in(array_merge(['all'], config('store.categories')))],
            'status' => ['nullable', 'string', Rule::in(['all', 'active', 'hidden', 'new'])],
        ]);

        $totalCount = Product::count();
        $activeCount = Product::where('is_active', true)->count();
        $hiddenCount = Product::where('is_active', false)->count();
        $newCount = Product::where('is_new', true)->count();

        return view('admin.products.index', [
            'products' => Product::query()
                ->when($filters['q'] ?? null, function (Builder $query, string $search): void {
                    $query->where(function (Builder $query) use ($search): void {
                        $query->where('name_en', 'like', "%{$search}%")
                            ->orWhere('name_km', 'like', "%{$search}%")
                            ->orWhere('badge', 'like', "%{$search}%");
                    });
                })
                ->when(($filters['category'] ?? 'all') !== 'all', fn (Builder $query) => $query->where('category', $filters['category']))
                ->when(($filters['status'] ?? 'all') !== 'all', function (Builder $query) use ($filters): void {
                    if ($filters['status'] === 'active') {
                        $query->where('is_active', true);
                    } elseif ($filters['status'] === 'hidden') {
                        $query->where('is_active', false);
                    } elseif ($filters['status'] === 'new') {
                        $query->where('is_new', true);
                    }
                })
                ->orderBy('sort_order')
                ->orderBy('id')
                ->paginate(12)
                ->withQueryString(),
            'categories' => config('store.categories'),
            'filters' => array_merge(['category' => 'all', 'status' => 'all'], $filters),
            'stats' => [
                'total' => $totalCount,
                'active' => $activeCount,
                'hidden' => $hiddenCount,
                'new' => $newCount,
            ],
        ]);
    }

    public function toggleStatus(Request $request, Product $product)
    {
        $product->update([
            'is_active' => ! $product->is_active,
        ]);

        $state = $product->is_active ? 'visible in storefront' : 'hidden from storefront';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => (bool) $product->is_active,
                'message' => "Product '{$product->name_en}' is now {$state}.",
                'stats' => [
                    'total' => Product::count(),
                    'active' => Product::where('is_active', true)->count(),
                    'hidden' => Product::where('is_active', false)->count(),
                    'new' => Product::where('is_new', true)->count(),
                ],
            ]);
        }

        return back()->with('status', "Product '{$product->name_en}' is now {$state}.");
    }

    public function toggleNew(Request $request, Product $product)
    {
        $product->update([
            'is_new' => ! $product->is_new,
        ]);

        $state = $product->is_new ? 'marked as new arrival' : 'unmarked from new arrivals';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_new' => (bool) $product->is_new,
                'message' => "Product '{$product->name_en}' is {$state}.",
                'stats' => [
                    'total' => Product::count(),
                    'active' => Product::where('is_active', true)->count(),
                    'hidden' => Product::where('is_active', false)->count(),
                    'new' => Product::where('is_new', true)->count(),
                ],
            ]);
        }

        return back()->with('status', "Product '{$product->name_en}' is {$state}.");
    }

    public function duplicate(Request $request, Product $product)
    {
        $newProduct = $product->replicate();
        $newProduct->name_en = $product->name_en . ' (Copy)';
        $newProduct->name_km = $product->name_km . ' (ចម្លង)';
        $newProduct->sort_order = $product->sort_order + 1;
        $newProduct->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Product '{$newProduct->name_en}' duplicated successfully.",
            ]);
        }

        return redirect()->route('admin.products.index')->with('status', "Product '{$newProduct->name_en}' duplicated successfully.");
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', Rule::in(['activate', 'hide', 'delete'])],
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:products,id'],
        ]);

        $count = count($validated['ids']);
        if ($validated['action'] === 'activate') {
            Product::whereIn('id', $validated['ids'])->update(['is_active' => true]);
            $msg = "{$count} products activated.";
        } elseif ($validated['action'] === 'hide') {
            Product::whereIn('id', $validated['ids'])->update(['is_active' => false]);
            $msg = "{$count} products hidden.";
        } elseif ($validated['action'] === 'delete') {
            Product::whereIn('id', $validated['ids'])->delete();
            $msg = "{$count} products deleted.";
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'stats' => [
                    'total' => Product::count(),
                    'active' => Product::where('is_active', true)->count(),
                    'hidden' => Product::where('is_active', false)->count(),
                    'new' => Product::where('is_new', true)->count(),
                ],
            ]);
        }

        return back()->with('status', $msg);
    }

    public function exportCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="dara-market-products-'.now()->format('Ymd-His').'.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['ID', 'SKU', 'Name (EN)', 'Name (KM)', 'Category', 'Price ($)', 'Old Price ($)', 'Stock', 'Rating', 'Status', 'New Arrival', 'Badge']);

            Product::orderBy('sort_order')->chunk(100, function ($products) use ($handle) {
                foreach ($products as $p) {
                    fputcsv($handle, [
                        $p->id,
                        $p->sku,
                        $p->name_en,
                        $p->name_km,
                        $p->category,
                        $p->price,
                        $p->old_price,
                        $p->stock ?? 45,
                        $p->rating,
                        $p->is_active ? 'Active' : 'Hidden',
                        $p->is_new ? 'Yes' : 'No',
                        $p->badge ?? '',
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product(['rating' => 5, 'is_active' => true]),
            'categories' => config('store.categories'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedProduct($request);
        $product = Product::create($validated);

        if ($request->has('save_and_add_another')) {
            return redirect()->route('admin.products.create')
                ->with('status', 'ផលិតផល "' . $product->name_en . '" ត្រូវបានបង្កើតជោគជ័យ! សូមបន្តបញ្ចូលផលិតផលបន្ទាប់។ (Product created, ready for next)');
        }

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    public function storeBatch(Request $request): RedirectResponse
    {
        $rows = $request->input('products', []);
        if (!is_array($rows) || empty($rows)) {
            return back()->withErrors(['products' => 'សូមបញ្ចូលទិន្នន័យផលិតផលយ៉ាងហោចណាស់មួយជួរ (Please enter at least one product row)']);
        }

        $validCategories = config('store.categories');
        $createdCount = 0;
        $maxSort = (int) Product::max('sort_order');

        foreach ($rows as $index => $row) {
            $nameEn = trim((string)($row['name_en'] ?? ''));
            $nameKm = trim((string)($row['name_km'] ?? ''));
            if ($nameEn === '' && $nameKm === '') {
                continue; // Skip empty rows
            }

            $cat = trim((string)($row['category'] ?? ''));
            if (!in_array($cat, $validCategories, true)) {
                $cat = $validCategories[0] ?? 'electronics';
            }

            $price = (float)($row['price'] ?? 0);
            $oldPrice = !empty($row['old_price']) ? (float)$row['old_price'] : null;
            $stock = isset($row['stock']) && $row['stock'] !== '' ? (int)$row['stock'] : 45;
            $imageUrl = '';
            if ($request->hasFile("products.{$index}.image_file")) {
                $file = $request->file("products.{$index}.image_file");
                $filename = time() . "_{$index}_" . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('products', $filename, 'public');
                $imageUrl = asset('storage/' . $path);
            } else {
                $imageUrl = trim((string)($row['image_url'] ?? ''));
            }

            if ($imageUrl === '') {
                $imageUrl = 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80';
            }

            Product::create([
                'name_en' => $nameEn !== '' ? $nameEn : $nameKm,
                'name_km' => $nameKm !== '' ? $nameKm : $nameEn,
                'category' => $cat,
                'price' => $price,
                'old_price' => $oldPrice,
                'stock' => $stock,
                'rating' => !empty($row['rating']) ? (float)$row['rating'] : 5.0,
                'image_url' => $imageUrl,
                'badge' => !empty($row['badge']) ? trim((string)$row['badge']) : null,
                'is_active' => !empty($row['is_active']),
                'is_new' => !empty($row['is_new']),
                'sort_order' => $maxSort + $index + 1,
            ]);
            $createdCount++;
        }

        if ($createdCount === 0) {
            return back()->withErrors(['products' => 'មិនមានទិន្នន័យផលិតផលដែលត្រឹមត្រូវសម្រាប់បញ្ចូលឡើយ (No valid products to create)']);
        }

        return redirect()->route('admin.products.index')
            ->with('status', "ជោគជ័យ! មុខទំនិញថ្មីចំនួន {$createdCount} ត្រូវបានបញ្ចូលទៅក្នុងប្រព័ន្ធដោយជោគជ័យក្នុងពេលតែមួយ! ({$createdCount} products created successfully at once!)");
    }

    public function uploadImage(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,gif,svg', 'max:5120'],
        ]);

        $file = $request->file('image');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('products', $filename, 'public');
        $url = asset('storage/' . $path);

        return response()->json([
            'success' => true,
            'url' => $url,
            'filename' => $file->getClientOriginalName(),
            'message' => 'Image uploaded successfully.',
        ]);
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => config('store.categories'),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validatedProduct($request));

        return redirect()->route('admin.products.index')->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted successfully.');
    }

    private function validatedProduct(Request $request): array
    {
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('products', $filename, 'public');
            $request->merge(['image_url' => asset('storage/' . $path)]);
        }

        return $request->validate([
            'name_km' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::in(config('store.categories'))],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'old_price' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'stock' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif,svg', 'max:5120'],
            'image_url' => ['required', 'string', 'max:2048'],
            'badge' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:1000000'],
            'is_active' => ['nullable', 'boolean'],
            'is_new' => ['nullable', 'boolean'],
        ]) + [
            'stock' => (int) $request->input('stock', 45),
            'is_active' => $request->boolean('is_active'),
            'is_new' => $request->boolean('is_new'),
        ];
    }
}
