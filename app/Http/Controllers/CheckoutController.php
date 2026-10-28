<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\BakongKhqrService;
use App\Services\StoreSettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout(Request $request): View
    {
        $locale = $this->resolveLocale($request);
        $user = auth()->user();
        $settings = StoreSettingService::all();

        $directItem = null;
        if ($request->filled('product_id')) {
            $product = Product::find($request->input('product_id'));
            if ($product) {
                $qty = max(1, (int) $request->input('qty', 1));
                $optionDesc = [];
                if ($request->filled('color')) $optionDesc[] = $request->input('color');
                if ($request->filled('size')) $optionDesc[] = $request->input('size');
                $name = $product->name . (!empty($optionDesc) ? ' (' . implode(', ', $optionDesc) . ')' : '');

                $directItem = [
                    'id' => (string) $product->id,
                    'name' => $name,
                    'price' => (float) $product->price,
                    'quantity' => $qty,
                    'image' => $request->input('image') ?: $product->main_image,
                ];
            }
        }

        return view('store.pages.checkout', [
            'locale' => $locale,
            'user' => $user,
            'translations' => __('store'),
            'settings' => $settings,
            'directItem' => $directItem,
        ]);
    }

    public function placeOrder(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'min:2', 'max:100'],
            'customer_phone' => ['required', 'string', 'min:8', 'max:25'],
            'customer_email' => ['nullable', 'email', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'street_address' => ['required', 'string', 'min:3', 'max:255'],
            'payment_method' => ['required', 'string', 'in:aba_pay,bakong,cod'],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.image' => ['nullable', 'string', 'max:500'],
            'items.*.id' => ['nullable'],
        ]);

        // Calculate Subtotal & Shipping
        $subtotal = 0;
        $orderItems = [];
        foreach ($validated['items'] as $it) {
            $price = (float) $it['price'];
            $qty = (int) $it['quantity'];
            $subtotal += ($price * $qty);

            $orderItems[] = [
                'id' => $it['id'] ?? null,
                'name' => $it['name'],
                'price' => $price,
                'quantity' => $qty,
                'image' => $it['image'] ?? 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80',
            ];

            // If ID matches product, decrease stock
            if (!empty($it['id'])) {
                $product = Product::find($it['id']);
                if ($product && $product->stock > 0) {
                    $product->decrement('stock', min($product->stock, $qty));
                }
            }
        }

        $isPhnomPenh = str_contains(strtolower($validated['province']), 'phnom penh') || str_contains($validated['province'], 'ភ្នំពេញ');
        $shippingFee = ($subtotal >= 35.00) ? 0.00 : ($isPhnomPenh ? 1.50 : 2.50);
        $totalAmount = round($subtotal + $shippingFee, 2);

        // Build full shipping address
        $fullAddress = trim($validated['street_address'] . ', ' . $validated['province']);

        // Determine payment method label & status
        $paymentMethodLabels = [
            'aba_pay' => 'ABA PAY (KHQR)',
            'bakong' => 'Bakong KHQR',
            'cod' => 'Cash on Delivery (COD)',
        ];
        $paymentMethodName = $paymentMethodLabels[$validated['payment_method']] ?? 'ABA PAY (KHQR)';

        // For ABA / Bakong simulation, mark as paid so revenue updates, COD is pending
        $paymentStatus = in_array($validated['payment_method'], ['aba_pay', 'bakong']) ? 'paid' : 'pending';
        $orderStatus = 'processing';

        // Auto-associate or create Customer Account in Users table
        $currentUser = auth()->user();
        if ($currentUser) {
            $email = $currentUser->email;
            $customerUser = $currentUser;
            $customerUser->update([
                'name' => $validated['customer_name'] ?: $currentUser->name,
                'phone' => $validated['customer_phone'] ?: $currentUser->phone,
                'address' => $fullAddress ?: $currentUser->address,
            ]);
        } else {
            $email = !empty($validated['customer_email']) ? trim($validated['customer_email']) : ('shopper.' . preg_replace('/[^0-9]/', '', $validated['customer_phone']) . '@daramarket.com');
            $customerUser = User::where('email', $email)
                ->orWhere('phone', $validated['customer_phone'])
                ->first();

            if (!$customerUser) {
                $customerUser = User::create([
                    'name' => $validated['customer_name'],
                    'email' => $email,
                    'phone' => $validated['customer_phone'],
                    'address' => $fullAddress,
                    'password' => Hash::make(Str::random(12)),
                    'is_admin' => false,
                    'email_verified_at' => now(),
                ]);
            } else {
                // Update phone / address if empty
                $customerUser->update([
                    'name' => $validated['customer_name'],
                    'phone' => $validated['customer_phone'],
                    'address' => $fullAddress,
                ]);
            }
        }

        // Generate unique order number
        $orderNumber = 'ORD-2026-' . str_pad((string) mt_rand(1050, 9999), 4, '0', STR_PAD_LEFT);

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $email,
            'customer_phone' => $validated['customer_phone'],
            'shipping_address' => $fullAddress,
            'total_amount' => $totalAmount,
            'payment_method' => $paymentMethodName,
            'payment_status' => $paymentStatus,
            'order_status' => $orderStatus,
            'items' => $orderItems,
            'notes' => $validated['notes'] ?? null,
        ]);

        $redirectUrl = route('store.order.success', $order->id);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'ការបញ្ជាទិញទទួលបានជោគជ័យ!',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => number_format($totalAmount, 2),
                'payment_method' => $paymentMethodName,
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect($redirectUrl);
    }

    public function orderSuccess(Request $request, Order $order): View
    {
        $locale = $this->resolveLocale($request);
        $settings = StoreSettingService::all();
        $exchangeRate = (float)($settings['exchange_rate'] ?? 4100);
        $totalKhr = round((float) $order->total_amount * $exchangeRate);

        // Generate genuine NBC KHQR EMV payload
        $bakongId = $settings['bakong_account_id'] ?? 'dara_market@abaa';
        $merchantName = $settings['store_name_en'] ?? 'DARA MARKET';

        $khqrPayload = BakongKhqrService::generateKhqr(
            bakongId: $bakongId,
            merchantName: $merchantName,
            merchantCity: 'Phnom Penh',
            amount: (float) $order->total_amount,
            currency: 'USD',
            billNumber: $order->order_number,
            mobileNumber: $order->customer_phone
        );

        $khqrImageUrl = !empty($settings['custom_khqr_image'])
            ? $settings['custom_khqr_image']
            : BakongKhqrService::getQrImageUrl($khqrPayload, 350);

        return view('store.pages.order-success', [
            'locale' => $locale,
            'order' => $order,
            'translations' => __('store'),
            'settings' => $settings,
            'khqrPayload' => $khqrPayload,
            'khqrImageUrl' => $khqrImageUrl,
            'totalKhr' => $totalKhr,
        ]);
    }

    public function uploadReceipt(Request $request, Order $order): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpeg,png,jpg,webp,pdf', 'max:10240'],
            'transaction_ref' => ['nullable', 'string', 'max:100'],
        ]);

        $file = $request->file('payment_proof');
        $path = $file->store('receipts', 'public');

        $order->update([
            'payment_proof' => '/storage/' . $path,
            'transaction_ref' => $validated['transaction_ref'] ?? $order->transaction_ref,
            'payment_status' => 'paid',
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'បានផ្ញើបង្កាន់ដៃបង់ប្រាក់ជោគជ័យ! ក្រុមការងារយើងនឹងរៀបចំទំនិញដឹកជញ្ជូន។',
                'proof_url' => '/storage/' . $path,
                'transaction_ref' => $order->transaction_ref,
            ]);
        }

        return back()->with('success', 'បានផ្ញើបង្កាន់ដៃបង់ប្រាក់ជោគជ័យ!');
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
}
