<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AdminReviewController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureTableAndSeedReviews();

        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'rating' => ['nullable', 'string', Rule::in(['all', '5', '4', '3', '2', '1'])],
            'status' => ['nullable', 'string', Rule::in(['all', 'approved', 'pending', 'rejected'])],
        ]);

        $query = Review::with('product');

        if (! empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function (Builder $q) use ($search): void {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('review_title', 'like', "%{$search}%")
                    ->orWhere('review_body', 'like', "%{$search}%")
                    ->orWhereHas('product', function (Builder $pq) use ($search): void {
                        $pq->where('name_en', 'like', "%{$search}%")
                            ->orWhere('name_km', 'like', "%{$search}%");
                    });
            });
        }

        if (! empty($filters['rating']) && $filters['rating'] !== 'all') {
            $query->where('rating', (int) $filters['rating']);
        }

        if (! empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        $allReviews = Review::all();
        $totalReviews = $allReviews->count();
        $avgRating = $totalReviews > 0 ? round($allReviews->avg('rating'), 1) : 5.0;
        $pendingCount = $allReviews->where('status', 'pending')->count();
        $fiveStarCount = $allReviews->where('rating', 5)->count();
        $satisfactionRate = $totalReviews > 0 ? round(($fiveStarCount / $totalReviews) * 100, 1) : 100;

        $reviews = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'filters' => array_merge(['rating' => 'all', 'status' => 'all'], $filters),
            'stats' => [
                'total_reviews' => $totalReviews,
                'avg_rating' => $avgRating,
                'pending_count' => $pendingCount,
                'satisfaction_rate' => $satisfactionRate,
            ],
        ]);
    }

    public function approve(Review $review): RedirectResponse
    {
        $review->update(['status' => 'approved']);

        return back()->with('status', "Review from {$review->customer_name} has been approved.");
    }

    public function reject(Review $review): RedirectResponse
    {
        $review->update(['status' => 'rejected']);

        return back()->with('status', "Review from {$review->customer_name} marked as rejected.");
    }

    public function reply(Request $request, Review $review): RedirectResponse
    {
        $validated = $request->validate([
            'admin_reply' => ['required', 'string', 'max:1000'],
        ]);

        $review->update([
            'admin_reply' => $validated['admin_reply'],
            'status' => 'approved',
        ]);

        return back()->with('status', "Reply posted to {$review->customer_name}'s review.");
    }

    public function destroy(Review $review): RedirectResponse
    {
        $name = $review->customer_name;
        $review->delete();

        return back()->with('status', "Review from {$name} deleted successfully.");
    }

    private function ensureTableAndSeedReviews(): void
    {
        if (! Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
                $table->string('customer_name');
                $table->string('customer_email');
                $table->unsignedTinyInteger('rating')->default(5);
                $table->string('review_title')->nullable();
                $table->text('review_body');
                $table->string('status')->default('approved');
                $table->boolean('is_verified_buyer')->default(true);
                $table->text('admin_reply')->nullable();
                $table->timestamps();
            });
        }

        if (Review::count() === 0) {
            $products = Product::all();
            if ($products->isEmpty()) {
                return;
            }

            $sampleReviews = [
                [
                    'product_id' => $products[1]->id ?? $products[0]->id,
                    'customer_name' => 'Sokha Chan',
                    'customer_email' => 'sokha.chan@gmail.com',
                    'rating' => 5,
                    'review_title' => 'Amazing sound quality and fast delivery!',
                    'review_body' => 'I ordered these wireless headphones yesterday and received them this morning in Phnom Penh. The sound clarity and bass are phenomenal. Highly recommend Dara Market!',
                    'status' => 'approved',
                    'is_verified_buyer' => true,
                    'admin_reply' => 'Thank you for your wonderful feedback, Sokha! We are delighted that you love the sound quality.',
                    'created_at' => now()->subHours(5),
                ],
                [
                    'product_id' => $products[0]->id,
                    'customer_name' => 'Vannak Meas',
                    'customer_email' => 'vannak.meas@yahoo.com',
                    'rating' => 5,
                    'review_title' => 'កាបូបស្អាត មាំល្អណាស់ (Great backpack!)',
                    'review_body' => 'កាបូបនេះសាច់ក្រណាត់មាំ និងមិនជ្រាបទឹក ងាយស្រួលដាក់ Laptop និងរបស់របរធ្វើការរាល់ថ្ងៃ។ សេវាកម្មដឹកជញ្ជូនរហ័សទាន់ចិត្ត។',
                    'status' => 'approved',
                    'is_verified_buyer' => true,
                    'admin_reply' => null,
                    'created_at' => now()->subDay(),
                ],
                [
                    'product_id' => $products[2]->id ?? $products[0]->id,
                    'customer_name' => 'Bopha Heng',
                    'customer_email' => 'bopha.heng@hotmail.com',
                    'rating' => 4,
                    'review_title' => 'Keeps water cold all day long',
                    'review_body' => 'Very sleek design and keeps ice water cold for over 12 hours. Only gave 4 stars because the delivery was delayed by a couple of hours, but the product itself is top notch.',
                    'status' => 'approved',
                    'is_verified_buyer' => true,
                    'admin_reply' => 'Hi Bopha, thank you for the feedback. We apologize for the minor delivery delay and will improve our logistics times!',
                    'created_at' => now()->subDays(2),
                ],
                [
                    'product_id' => $products[3]->id ?? $products[0]->id,
                    'customer_name' => 'Dara Keo',
                    'customer_email' => 'dara.keo@gmail.com',
                    'rating' => 5,
                    'review_title' => 'ពាក់ស្រួលជើងណាស់ ស្រាលស្រទន់',
                    'review_body' => 'ស្បែកជើងពាក់រត់ហាត់ប្រាណស្រួលណាស់ មិនឈឺជើង ទំហំត្រូវស្តង់ដារល្អ។ នឹងគាំទ្រទំនិញដទៃទៀតនៅ Dara Market!',
                    'status' => 'approved',
                    'is_verified_buyer' => true,
                    'admin_reply' => null,
                    'created_at' => now()->subDays(3),
                ],
                [
                    'product_id' => $products[4]->id ?? $products[0]->id,
                    'customer_name' => 'Channary Pich',
                    'customer_email' => 'channary.pich@gmail.com',
                    'rating' => 5,
                    'review_title' => 'Super clear photos, very portable',
                    'review_body' => 'Great camera for weekend trips and vlogging. The autofocus is sharp and easy to handle.',
                    'status' => 'pending',
                    'is_verified_buyer' => true,
                    'admin_reply' => null,
                    'created_at' => now()->subDays(4),
                ],
                [
                    'product_id' => $products[1]->id ?? $products[0]->id,
                    'customer_name' => 'Theara Meng',
                    'customer_email' => 'theara.meng@gmail.com',
                    'rating' => 3,
                    'review_title' => 'Decent product, average battery',
                    'review_body' => 'Works fine for regular music, but battery life is around 4-5 hours rather than the advertised 7 hours. Decent value for money though.',
                    'status' => 'pending',
                    'is_verified_buyer' => false,
                    'admin_reply' => null,
                    'created_at' => now()->subDays(5),
                ],
            ];

            foreach ($sampleReviews as $data) {
                Review::create($data);
            }
        }
    }
}
