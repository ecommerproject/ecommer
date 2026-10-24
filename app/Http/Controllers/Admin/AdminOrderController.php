<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureTableAndSeedSampleOrders();

        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', Rule::in(['all', 'pending', 'processing', 'shipped', 'delivered', 'cancelled'])],
            'payment' => ['nullable', 'string', Rule::in(['all', 'paid', 'pending', 'failed'])],
        ]);

        $query = Order::query();

        if (! empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function (Builder $q) use ($search): void {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('order_status', $filters['status']);
        }

        if (! empty($filters['payment']) && $filters['payment'] !== 'all') {
            $query->where('payment_status', $filters['payment']);
        }

        $allOrders = Order::all();
        $totalOrders = $allOrders->count();
        $totalRevenue = (float) $allOrders->where('payment_status', 'paid')->sum('total_amount');
        $pendingCount = $allOrders->where('order_status', 'pending')->count();
        $processingCount = $allOrders->where('order_status', 'processing')->count();
        $shippedCount = $allOrders->where('order_status', 'shipped')->count();
        $deliveredCount = $allOrders->where('order_status', 'delivered')->count();
        $cancelledCount = $allOrders->where('order_status', 'cancelled')->count();

        $orders = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => array_merge(['status' => 'all', 'payment' => 'all'], $filters),
            'stats' => [
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
                'pending_count' => $pendingCount,
                'processing_count' => $processingCount,
                'shipped_count' => $shippedCount,
                'delivered_count' => $deliveredCount,
                'cancelled_count' => $cancelledCount,
            ],
        ]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'total_amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'max:100'],
            'payment_status' => ['required', 'string', Rule::in(['paid', 'pending', 'failed'])],
            'order_status' => ['required', 'string', Rule::in(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])],
            'notes' => ['nullable', 'string', 'max:1000'],
            'items' => ['nullable', 'array'],
        ]);

        $orderNumber = 'ORD-2026-' . str_pad((string) mt_rand(1050, 9999), 4, '0', STR_PAD_LEFT);
        $email = !empty($validated['customer_email']) ? trim($validated['customer_email']) : ('shopper.' . preg_replace('/[^0-9]/', '', $validated['customer_phone']) . '@daramarket.com');

        // Auto-link/create customer in users
        $customerUser = \App\Models\User::where('email', $email)
            ->orWhere('phone', $validated['customer_phone'])
            ->first();

        if (!$customerUser) {
            \App\Models\User::create([
                'name' => $validated['customer_name'],
                'email' => $email,
                'phone' => $validated['customer_phone'],
                'address' => $validated['shipping_address'],
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12)),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]);
        }

        $items = !empty($validated['items']) ? $validated['items'] : [
            [
                'name' => 'Custom Order Item',
                'price' => (float) $validated['total_amount'],
                'quantity' => 1,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80',
            ]
        ];

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $email,
            'customer_phone' => $validated['customer_phone'],
            'shipping_address' => $validated['shipping_address'],
            'total_amount' => (float) $validated['total_amount'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_status'],
            'order_status' => $validated['order_status'],
            'items' => $items,
            'notes' => $validated['notes'] ?? null,
        ]);

        $msg = "Order #{$order->order_number} for {$order->customer_name} created successfully!";

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'order' => $order,
            ]);
        }

        return redirect()->route('admin.orders.index')->with('status', $msg);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => ['nullable', 'string', Rule::in(['pending', 'processing', 'shipped', 'delivered', 'cancelled'])],
            'payment_status' => ['nullable', 'string', Rule::in(['paid', 'pending', 'failed', 'refunded'])],
        ]);

        $order->update(array_filter($validated));

        $allOrders = Order::all();
        $stats = [
            'total_orders' => $allOrders->count(),
            'total_revenue' => (float) $allOrders->where('payment_status', 'paid')->sum('total_amount'),
            'pending_count' => $allOrders->where('order_status', 'pending')->count(),
            'processing_count' => $allOrders->where('order_status', 'processing')->count(),
            'shipped_count' => $allOrders->where('order_status', 'shipped')->count(),
            'delivered_count' => $allOrders->where('order_status', 'delivered')->count(),
            'cancelled_count' => $allOrders->where('order_status', 'cancelled')->count(),
        ];

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Order #{$order->order_number} status updated to ".ucfirst($order->order_status).".",
                'order' => $order,
                'stats' => $stats,
            ]);
        }

        return back()->with('status', "Order #{$order->order_number} status updated to ".ucfirst($order->order_status).".");
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => ['required', Rule::in(['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'delete'])],
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:orders,id'],
        ]);

        $count = count($validated['ids']);
        if ($validated['action'] === 'delete') {
            Order::whereIn('id', $validated['ids'])->delete();
            $msg = "{$count} orders deleted.";
        } else {
            Order::whereIn('id', $validated['ids'])->update(['order_status' => $validated['action']]);
            $msg = "{$count} orders updated to ".ucfirst($validated['action']).".";
        }

        $allOrders = Order::all();
        $stats = [
            'total_orders' => $allOrders->count(),
            'total_revenue' => (float) $allOrders->where('payment_status', 'paid')->sum('total_amount'),
            'pending_count' => $allOrders->where('order_status', 'pending')->count(),
            'processing_count' => $allOrders->where('order_status', 'processing')->count(),
            'shipped_count' => $allOrders->where('order_status', 'shipped')->count(),
            'delivered_count' => $allOrders->where('order_status', 'delivered')->count(),
            'cancelled_count' => $allOrders->where('order_status', 'cancelled')->count(),
        ];

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'stats' => $stats,
            ]);
        }

        return back()->with('status', $msg);
    }

    public function exportCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="dara-market-orders-'.now()->format('Ymd-His').'.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['Order #', 'Customer Name', 'Customer Email', 'Customer Phone', 'Shipping Address', 'Total Amount ($)', 'Payment Method', 'Payment Status', 'Fulfillment Status', 'Date']);

            Order::orderByDesc('id')->chunk(100, function ($orders) use ($handle) {
                foreach ($orders as $o) {
                    fputcsv($handle, [
                        $o->order_number,
                        $o->customer_name,
                        $o->customer_email,
                        $o->customer_phone ?? '',
                        $o->shipping_address ?? '',
                        $o->total_amount,
                        $o->payment_method,
                        $o->payment_status,
                        $o->order_status,
                        $o->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    public function destroy(Order $order): RedirectResponse
    {
        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()->route('admin.orders.index')->with('status', "Order #{$orderNumber} deleted successfully.");
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

        if (Order::count() === 0) {
            require_once database_path('seeders/RealStoreSeeder.php');
            (new \Database\Seeders\RealStoreSeeder())->run();
        }
    }
}
