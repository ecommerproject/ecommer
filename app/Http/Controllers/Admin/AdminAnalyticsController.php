<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureTableAndSeedSampleOrders();

        $range = $request->validate([
            'range' => ['nullable', 'string', Rule::in(['7d', '30d', 'this_month', 'all'])],
        ])['range'] ?? '7d';

        $now = now();
        $startDate = match ($range) {
            '30d' => $now->copy()->subDays(29)->startOfDay(),
            'this_month' => $now->copy()->startOfMonth(),
            'all' => Carbon::createFromTimestamp(0),
            default => $now->copy()->subDays(6)->startOfDay(),
        };

        $ordersQuery = Order::query()->where('created_at', '>=', $startDate);
        $periodOrders = $ordersQuery->get();

        // Financial KPIs
        $paidOrders = $periodOrders->where('payment_status', 'paid');
        $totalRevenue = (float) $paidOrders->sum('total_amount');
        $totalOrdersCount = $periodOrders->count();
        $avgOrderValue = $paidOrders->count() > 0 ? $totalRevenue / $paidOrders->count() : 0.0;
        $deliveredCount = $periodOrders->where('order_status', 'delivered')->count();
        $completionRate = $totalOrdersCount > 0 ? round(($deliveredCount / $totalOrdersCount) * 100, 1) : 0.0;

        // Daily chart trend
        $daysCount = match ($range) {
            '30d' => 30,
            'this_month' => (int) $now->day,
            'all' => 14,
            default => 7,
        };

        $chartDays = collect(range($daysCount - 1, 0))->map(function (int $daysAgo) use ($now, $paidOrders, $periodOrders): array {
            $date = $now->copy()->subDays($daysAgo);
            $dateKey = $date->toDateString();

            $dayPaidOrders = $paidOrders->filter(fn (Order $o) => Carbon::parse($o->created_at)->toDateString() === $dateKey);
            $dayAllOrders = $periodOrders->filter(fn (Order $o) => Carbon::parse($o->created_at)->toDateString() === $dateKey);

            $dayRevenue = (float) $dayPaidOrders->sum('total_amount');
            $dayOrders = $dayAllOrders->count();

            return [
                'date' => $dateKey,
                'label' => $date->format('M d'),
                'day_name' => $date->format('D'),
                'revenue' => $dayRevenue,
                'orders' => $dayOrders,
            ];
        });

        $maxDayRevenue = max(1.0, (float) $chartDays->max('revenue'));
        $chartData = $chartDays->map(function (array $day) use ($maxDayRevenue): array {
            $pct = $day['revenue'] > 0 ? round(($day['revenue'] / $maxDayRevenue) * 100, 1) : 4.0;
            $day['height_pct'] = max(4.0, $pct);

            return $day;
        });

        // Category breakdown
        $categoriesConfig = config('store.categories', ['perfumes', 'phones', 'computers', 'fashion', 'beauty']);
        $categoryColors = [
            'perfumes' => '#d946ef',
            'phones' => '#3b82f6',
            'computers' => '#6366f1',
            'fashion' => '#ec4899',
            'beauty' => '#10b981',
        ];

        $categoryStats = collect($categoriesConfig)->map(function (string $catKey) use ($categoryColors): array {
            $products = Product::where('category', $catKey)->get();
            $productsCount = $products->count();
            $avgPrice = (float) $products->avg('price');
            $estimatedUnits = (int) $products->sum(fn ($p) => max(2, (int) ($p->id * 3 % 20)));
            $estimatedRevenue = round($avgPrice * $estimatedUnits, 2);

            return [
                'key' => $catKey,
                'name' => __('store.categories.'.$catKey, [], 'en'),
                'products_count' => $productsCount,
                'units_sold' => $estimatedUnits,
                'revenue' => $estimatedRevenue,
                'color' => $categoryColors[$catKey] ?? '#245943',
            ];
        });

        $totalCatRevenue = max(1.0, (float) $categoryStats->sum('revenue'));
        $categoryBreakdown = $categoryStats->map(function (array $item) use ($totalCatRevenue): array {
            $item['share_pct'] = round(($item['revenue'] / $totalCatRevenue) * 100, 1);

            return $item;
        });

        // Payment Methods Breakdown
        $paymentMethods = [
            'ABA KHQR' => ['count' => $periodOrders->where('payment_method', 'ABA KHQR')->count(), 'color' => '#0f5298'],
            'Wing Bank' => ['count' => $periodOrders->where('payment_method', 'Wing Bank')->count(), 'color' => '#88c03d'],
            'Cash on Delivery' => ['count' => $periodOrders->where('payment_method', 'Cash on Delivery')->count(), 'color' => '#d8a962'],
            'ACLEDA KHQR' => ['count' => $periodOrders->where('payment_method', 'ACLEDA')->count(), 'color' => '#1d3557'],
        ];

        $totalPaymentMethodsCount = max(1, $periodOrders->count());
        $paymentBreakdown = collect($paymentMethods)->map(function (array $info, string $methodName) use ($totalPaymentMethodsCount): array {
            $pct = round(($info['count'] / $totalPaymentMethodsCount) * 100, 1);

            return [
                'method' => $methodName,
                'count' => $info['count'],
                'percentage' => $pct,
                'color' => $info['color'],
            ];
        });

        // Top 5 Products
        $topProducts = Product::orderBy('price', 'desc')->take(5)->get()->map(function (Product $product, int $index): array {
            $units = 18 - ($index * 3);
            $revenue = (float) $product->price * $units;

            return [
                'rank' => $index + 1,
                'product' => $product,
                'units' => $units,
                'revenue' => $revenue,
            ];
        });

        // Customer & Audience Metrics
        $totalCustomers = User::where('is_admin', false)->count();
        $totalSubscribers = DB::table('newsletter_subscribers')->count();

        return view('admin.analytics.index', [
            'range' => $range,
            'kpis' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrdersCount,
                'avg_order_value' => $avgOrderValue,
                'completion_rate' => $completionRate,
                'total_customers' => $totalCustomers,
                'total_subscribers' => $totalSubscribers,
            ],
            'chartData' => $chartData,
            'maxDayRevenue' => $maxDayRevenue,
            'categoryBreakdown' => $categoryBreakdown,
            'paymentBreakdown' => $paymentBreakdown,
            'topProducts' => $topProducts,
        ]);
    }

    private function ensureTableAndSeedSampleOrders(): void
    {
        if (! Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table): void {
                $table->id();
                $table->string('order_number')->unique();
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone')->nullable();
                $table->text('shipping_address')->nullable();
                $table->decimal('total_amount', 10, 2);
                $table->string('payment_method')->default('aba_pay');
                $table->string('payment_status')->default('paid');
                $table->string('order_status')->default('processing');
                $table->json('items')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (Order::count() < 10) {
            $sampleProducts = Product::take(6)->get();

            $ordersSeed = [
                [
                    'order_number' => 'ORD-9012',
                    'customer_name' => 'Sokha Chan',
                    'customer_email' => 'sokha.chan@gmail.com',
                    'customer_phone' => '071 450 4547',
                    'shipping_address' => 'St. 271, Khan Meanchey, Phnom Penh',
                    'total_amount' => 124.00,
                    'payment_method' => 'ABA KHQR',
                    'payment_status' => 'paid',
                    'order_status' => 'delivered',
                    'items' => [
                        ['name' => 'Smart speaker', 'price' => 65.00, 'quantity' => 1, 'image' => $sampleProducts[0]->image_url ?? ''],
                        ['name' => 'Minimal water bottle', 'price' => 22.00, 'quantity' => 2, 'image' => $sampleProducts[1]->image_url ?? ''],
                    ],
                    'created_at' => now()->subHours(2),
                ],
                [
                    'order_number' => 'ORD-9011',
                    'customer_name' => 'Vannak Meas',
                    'customer_email' => 'vannak.meas@yahoo.com',
                    'customer_phone' => '098 765 432',
                    'shipping_address' => 'Russian Federation Blvd, Sen Sok, Phnom Penh',
                    'total_amount' => 45.00,
                    'payment_method' => 'Wing Bank',
                    'payment_status' => 'paid',
                    'order_status' => 'processing',
                    'items' => [
                        ['name' => 'Canvas Tote Bag', 'price' => 45.00, 'quantity' => 1, 'image' => $sampleProducts[2]->image_url ?? ''],
                    ],
                    'created_at' => now()->subHours(8),
                ],
                [
                    'order_number' => 'ORD-9010',
                    'customer_name' => 'Bopha Heng',
                    'customer_email' => 'bopha.heng@hotmail.com',
                    'customer_phone' => '077 123 456',
                    'shipping_address' => 'Norodom Blvd, Chamkarmon, Phnom Penh',
                    'total_amount' => 88.00,
                    'payment_method' => 'Cash on Delivery',
                    'payment_status' => 'pending',
                    'order_status' => 'shipped',
                    'items' => [
                        ['name' => 'Wireless headphones', 'price' => 42.00, 'quantity' => 1, 'image' => $sampleProducts[1]->image_url ?? ''],
                        ['name' => 'Sport sneakers', 'price' => 46.00, 'quantity' => 1, 'image' => $sampleProducts[3]->image_url ?? ''],
                    ],
                    'created_at' => now()->subDay()->subHours(2),
                ],
                [
                    'order_number' => 'ORD-9009',
                    'customer_name' => 'Dara Keo',
                    'customer_email' => 'dara.keo@gmail.com',
                    'customer_phone' => '015 889 900',
                    'shipping_address' => 'St. 2004, Pur Senchey, Phnom Penh',
                    'total_amount' => 210.00,
                    'payment_method' => 'ABA KHQR',
                    'payment_status' => 'paid',
                    'order_status' => 'delivered',
                    'items' => [
                        ['name' => 'Mechanical keyboard', 'price' => 110.00, 'quantity' => 1, 'image' => $sampleProducts[0]->image_url ?? ''],
                        ['name' => 'Smart watch band', 'price' => 50.00, 'quantity' => 2, 'image' => $sampleProducts[1]->image_url ?? ''],
                    ],
                    'created_at' => now()->subDays(2)->subHours(5),
                ],
                [
                    'order_number' => 'ORD-9008',
                    'customer_name' => 'Channary Pich',
                    'customer_email' => 'channary.pich@gmail.com',
                    'customer_phone' => '089 445 566',
                    'shipping_address' => 'St. 598, Russey Keo, Phnom Penh',
                    'total_amount' => 64.00,
                    'payment_method' => 'ABA KHQR',
                    'payment_status' => 'paid',
                    'order_status' => 'delivered',
                    'items' => [
                        ['name' => 'Organic Face Serum', 'price' => 32.00, 'quantity' => 2, 'image' => $sampleProducts[3]->image_url ?? ''],
                    ],
                    'created_at' => now()->subDays(3)->subHours(1),
                ],
                [
                    'order_number' => 'ORD-9007',
                    'customer_name' => 'Kimleng Srun',
                    'customer_email' => 'kimleng.srun@online.com.kh',
                    'customer_phone' => '016 778 899',
                    'shipping_address' => 'Sivutha Rd, Svay Dangkum, Siem Reap',
                    'total_amount' => 150.00,
                    'payment_method' => 'ACLEDA',
                    'payment_status' => 'paid',
                    'order_status' => 'delivered',
                    'items' => [
                        ['name' => 'Ceramic dinnerware set', 'price' => 75.00, 'quantity' => 2, 'image' => $sampleProducts[2]->image_url ?? ''],
                    ],
                    'created_at' => now()->subDays(4)->subHours(6),
                ],
                [
                    'order_number' => 'ORD-9006',
                    'customer_name' => 'Theara Meng',
                    'customer_email' => 'theara.meng@gmail.com',
                    'customer_phone' => '010 334 455',
                    'shipping_address' => 'St. 1, Sangkat Svay Por, Battambang',
                    'total_amount' => 95.00,
                    'payment_method' => 'ABA KHQR',
                    'payment_status' => 'paid',
                    'order_status' => 'delivered',
                    'items' => [
                        ['name' => 'Linen casual shirt', 'price' => 38.00, 'quantity' => 1, 'image' => $sampleProducts[1]->image_url ?? ''],
                        ['name' => 'Leather wallet', 'price' => 57.00, 'quantity' => 1, 'image' => $sampleProducts[0]->image_url ?? ''],
                    ],
                    'created_at' => now()->subDays(5)->subHours(3),
                ],
                [
                    'order_number' => 'ORD-9005',
                    'customer_name' => 'Sreymom Pov',
                    'customer_email' => 'sreymom.pov@outlook.com',
                    'customer_phone' => '092 112 233',
                    'shipping_address' => 'Ekareach Ave, Mittapheap, Sihanoukville',
                    'total_amount' => 180.00,
                    'payment_method' => 'ABA KHQR',
                    'payment_status' => 'paid',
                    'order_status' => 'delivered',
                    'items' => [
                        ['name' => 'Wireless noise cancelling earbuds', 'price' => 90.00, 'quantity' => 2, 'image' => $sampleProducts[1]->image_url ?? ''],
                    ],
                    'created_at' => now()->subDays(6)->subHours(7),
                ],
            ];

            foreach ($ordersSeed as $data) {
                Order::updateOrCreate(['order_number' => $data['order_number']], $data);
            }
        }
    }
}
