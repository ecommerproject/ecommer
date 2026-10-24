<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminCustomerController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureSampleCustomersExist();

        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'tab' => ['nullable', 'string', 'in:all,buyers,vip,verified,new'],
        ]);

        $search = $filters['q'] ?? '';
        $activeTab = $filters['tab'] ?? 'all';

        $query = User::query()->where('is_admin', false);

        if ($search !== '') {
            $query->where(function (Builder $q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $allCustomers = User::where('is_admin', false)->orderByDesc('id')->get();
        $allOrders = Order::orderByDesc('id')->get();
        $ordersByEmail = $allOrders->groupBy(fn ($o) => strtolower(trim($o->customer_email)));

        // Attach calculated order metrics to all customers
        $allCustomers->each(function ($customer) use ($ordersByEmail): void {
            $email = strtolower(trim($customer->email));
            $orders = $ordersByEmail->get($email, collect());
            $customer->orders_count = $orders->count();
            $customer->total_spent = (float) $orders->sum('total_amount');
            $customer->paid_spent = (float) $orders->where('payment_status', 'paid')->sum('total_amount');
            $customer->customer_orders = $orders->values();
            $customer->is_vip = ($customer->total_spent >= 100 || $customer->orders_count >= 2);
        });

        // Tab counts
        $totalCount = $allCustomers->count();
        $verifiedCount = $allCustomers->whereNotNull('email_verified_at')->count();
        $buyersCount = $allCustomers->where('orders_count', '>', 0)->count();
        $vipCount = $allCustomers->where('is_vip', true)->count();
        $recentCount = $allCustomers->where('created_at', '>=', now()->subDays(30))->count();
        $totalSpentAll = (float) $allCustomers->sum('total_spent');

        // Apply tab filtering if requested via server
        if ($activeTab === 'buyers') {
            $query->whereIn('email', $allOrders->pluck('customer_email')->unique()->toArray());
        } elseif ($activeTab === 'verified') {
            $query->whereNotNull('email_verified_at');
        } elseif ($activeTab === 'new') {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        $customers = $query->orderByDesc('id')->paginate(15)->withQueryString();

        // Attach metrics for the paginated collection
        $customers->getCollection()->transform(function ($customer) use ($ordersByEmail) {
            $email = strtolower(trim($customer->email));
            $orders = $ordersByEmail->get($email, collect());
            $customer->orders_count = $orders->count();
            $customer->total_spent = (float) $orders->sum('total_amount');
            $customer->paid_spent = (float) $orders->where('payment_status', 'paid')->sum('total_amount');
            $customer->customer_orders = $orders->values();
            $customer->is_vip = ($customer->total_spent >= 100 || $customer->orders_count >= 2);

            return $customer;
        });

        return view('admin.customers.index', [
            'customers' => $customers,
            'search' => $search,
            'activeTab' => $activeTab,
            'stats' => [
                'total' => $totalCount,
                'verified' => $verifiedCount,
                'buyers' => $buyersCount,
                'vip' => $vipCount,
                'total_revenue' => $totalSpentAll,
                'new_this_month' => $recentCount,
            ],
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:6'],
            'is_verified' => ['nullable', 'boolean'],
        ]);

        $password = ! empty($validated['password']) ? $validated['password'] : Str::random(10);

        $customer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'password' => Hash::make($password),
            'is_admin' => false,
            'email_verified_at' => ! empty($validated['is_verified']) ? now() : null,
        ]);

        $msg = "Customer account for {$customer->name} created successfully.";

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'customer' => $customer,
            ]);
        }

        return redirect()->route('admin.customers.index')->with('status', $msg);
    }

    public function update(Request $request, User $user): JsonResponse|RedirectResponse
    {
        abort_unless(! $user->is_admin, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_verified' => ['nullable'],
        ]);

        $emailChanged = $user->email !== $validated['email'];
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;

        $isVerified = filter_var($request->input('is_verified'), FILTER_VALIDATE_BOOLEAN);

        if ($emailChanged) {
            $user->email_verified_at = $isVerified ? now() : null;
            DB::table('password_reset_tokens')->where('email', $user->getOriginal('email'))->delete();
        } else {
            if ($isVerified && ! $user->email_verified_at) {
                $user->email_verified_at = now();
            } elseif (! $isVerified) {
                $user->email_verified_at = null;
            }
        }

        $user->save();

        $msg = "Customer {$user->name}'s details updated successfully.";

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'customer' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'is_verified' => (bool) $user->email_verified_at,
                ],
            ]);
        }

        return redirect()->route('admin.customers.index')->with('status', $msg);
    }

    public function destroy(Request $request, User $user): JsonResponse|RedirectResponse
    {
        abort_unless(! $user->is_admin, 404);

        $userName = $user->name;
        DB::table('sessions')->where('user_id', $user->id)->delete();
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        $user->delete();

        $msg = "Customer account for {$userName} deleted.";

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return redirect()->route('admin.customers.index')->with('status', $msg);
    }

    public function bulkAction(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:users,id'],
            'action' => ['required', 'string', 'in:delete,verify,unverify'],
        ]);

        $users = User::whereIn('id', $validated['ids'])->where('is_admin', false);
        $count = $users->count();

        if ($validated['action'] === 'delete') {
            DB::table('sessions')->whereIn('user_id', $validated['ids'])->delete();
            $users->delete();
            $msg = "{$count} customer accounts deleted successfully.";
        } elseif ($validated['action'] === 'verify') {
            $users->update(['email_verified_at' => now()]);
            $msg = "{$count} customer accounts marked as verified.";
        } elseif ($validated['action'] === 'unverify') {
            $users->update(['email_verified_at' => null]);
            $msg = "{$count} customer accounts marked as unverified.";
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg ?? 'Bulk action completed.',
            ]);
        }

        return redirect()->route('admin.customers.index')->with('status', $msg ?? 'Bulk action completed.');
    }

    public function exportCsv(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="dara-market-customers-'.now()->format('Ymd-His').'.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM for Excel Khmer support
            fputcsv($handle, [
                'Customer ID',
                'Full Name',
                'Email Address',
                'Phone Number',
                'Shipping Address',
                'Orders Count',
                'Total Spent ($)',
                'Account Status',
                'Registered Date',
            ]);

            $allOrders = Order::all()->groupBy(fn ($o) => strtolower(trim($o->customer_email)));

            User::where('is_admin', false)->orderByDesc('id')->chunk(100, function ($users) use ($handle, $allOrders) {
                foreach ($users as $u) {
                    $email = strtolower(trim($u->email));
                    $orders = $allOrders->get($email, collect());
                    $ordersCount = $orders->count();
                    $totalSpent = (float) $orders->sum('total_amount');
                    $status = $u->email_verified_at ? 'Verified' : 'Standard Member';
                    if ($totalSpent >= 100 || $ordersCount >= 2) {
                        $status .= ' (VIP)';
                    }

                    fputcsv($handle, [
                        $u->id,
                        $u->name,
                        $u->email,
                        $u->phone ?? 'N/A',
                        $u->address ?? 'N/A',
                        $ordersCount,
                        number_format($totalSpent, 2, '.', ''),
                        $status,
                        $u->created_at?->format('Y-m-d H:i:s') ?? '',
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    private function ensureSampleCustomersExist(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        if (User::where('is_admin', false)->count() === 0) {
            require_once database_path('seeders/RealStoreSeeder.php');
            (new \Database\Seeders\RealStoreSeeder())->run();
        }
    }
}

