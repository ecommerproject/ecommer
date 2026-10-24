@extends('store.layouts.app')

@section('title', ($locale === 'km' ? 'ការកុម្ម៉ង់ជោគជ័យ' : 'Order Confirmed') . ' #' . $order->order_number . ' | Dara Market')

@section('content')
<div class="order-success-page">
    <div class="container success-inner">
        <!-- Confirmed Hero Header -->
        <div class="success-hero-card">
            <div class="success-badge-icon">
                <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#16a34a" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h1 class="success-title">{{ $locale === 'km' ? 'ការកុម្ម៉ង់របស់អ្នកទទួលបានជោគជ័យ!' : 'Thank You! Your Order is Confirmed' }}</h1>
            <p class="success-sub">
                {{ $locale === 'km' ? 'លេខសម្គាល់ការកុម្ម៉ង់ (Order ID):' : 'Order ID Number:' }}
                <strong class="order-id-tag">#{{ $order->order_number }}</strong>
            </p>
            <div class="success-quick-status">
                <span class="status-dot"></span>
                <span>{{ $locale === 'km' ? 'ស្ថានភាព៖ ' : 'Status: ' }}<strong>{{ ucfirst($order->order_status) }} ({{ $order->payment_status === 'paid' ? 'Paid / បានទូទាត់' : 'Payment on Delivery' }})</strong></span>
            </div>
        </div>

        <div class="success-content-grid">
            <!-- Left Column: Order Items & Delivery Details -->
            <div class="success-left-col">
                <!-- Shipping Address Card -->
                <div class="success-card">
                    <div class="card-head-row">
                        <span class="card-icon">📍</span>
                        <h3 class="card-sec-title">{{ $locale === 'km' ? 'ព័ត៌មានដឹកជញ្ជូន (Delivery Address)' : 'Delivery Information' }}</h3>
                    </div>
                    <div class="recipient-details">
                        <div class="detail-row">
                            <span class="detail-label">{{ $locale === 'km' ? 'អ្នកទទួល៖' : 'Recipient:' }}</span>
                            <strong class="detail-val">{{ $order->customer_name }}</strong>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">{{ $locale === 'km' ? 'ទូរស័ព្ទ៖' : 'Phone:' }}</span>
                            <span class="detail-val text-phone">{{ $order->customer_phone }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">{{ $locale === 'km' ? 'អាសយដ្ឋាន៖' : 'Address:' }}</span>
                            <span class="detail-val">{{ $order->shipping_address }}</span>
                        </div>
                        @if ($order->notes)
                            <div class="detail-row">
                                <span class="detail-label">{{ $locale === 'km' ? 'កំណត់ចំណាំ៖' : 'Notes:' }}</span>
                                <span class="detail-val italic">"{{ $order->notes }}"</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Purchased Items Card -->
                <div class="success-card">
                    <div class="card-head-row">
                        <span class="card-icon">📦</span>
                        <h3 class="card-sec-title">{{ $locale === 'km' ? 'ទំនិញដែលបានកុម្ម៉ង់ (Purchased Items)' : 'Order Items' }}</h3>
                        <span class="items-count-badge">{{ count($order->items ?? []) }} {{ $locale === 'km' ? 'មុខទំនិញ' : 'items' }}</span>
                    </div>

                    <div class="ordered-items-list">
                        @if(is_array($order->items))
                            @foreach ($order->items as $item)
                                <div class="ordered-item-row">
                                    <img src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80' }}" alt="{{ $item['name'] }}" class="ordered-item-thumb">
                                    <div class="ordered-item-info">
                                        <h4 class="ordered-item-name">{{ $item['name'] }}</h4>
                                        <span class="ordered-item-unit">${{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="ordered-item-total">
                                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Total Breakdown -->
                    <div class="invoice-summary-bar">
                        <div class="inv-row">
                            <span>{{ $locale === 'km' ? 'សរុបទឹកប្រាក់ (Total Amount):' : 'Grand Total:' }}</span>
                            <strong class="inv-grand-total">${{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                        <div class="inv-row">
                            <span>{{ $locale === 'km' ? 'វិធីសាស្ត្រទូទាត់:' : 'Payment Method:' }}</span>
                            <span class="inv-payment-badge">{{ $order->payment_method }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="success-actions-row">
                    <a href="{{ route('store.products') }}" class="btn-sec-action">
                        ← {{ $locale === 'km' ? 'បន្តទិញទំនិញផ្សេងទៀត' : 'Continue Shopping' }}
                    </a>
                    <button type="button" class="btn-sec-action" onclick="window.print()">
                        🖨️ {{ $locale === 'km' ? 'បោះពុម្ពវិក្កយបត្រ (Print Receipt)' : 'Print Receipt' }}
                    </button>
                    <a href="{{ route('store.home') }}#track-order" onclick="openTrackOrderModalWithCode('{{ $order->order_number }}')" class="btn-primary-action">
                        🚚 {{ $locale === 'km' ? 'តាមដានការដឹកជញ្ជូន (Track Order)' : 'Track Order' }}
                    </a>
                </div>
            </div>

            <!-- Right Column: Interactive ABA KHQR Scan Card -->
            <div class="success-right-col">
                <div class="khqr-interactive-card">
                    <div class="khqr-header-strip">
                        <div class="khqr-branding">
                            <span class="khqr-tag">KHQR</span>
                            <span class="khqr-tag-sub">Bakong Accepted</span>
                        </div>
                        <span class="aba-pill-logo">ABA</span>
                    </div>

                    <div class="khqr-body">
                        <div class="merchant-name-title">DARA MARKET STORE</div>
                        <div class="khqr-amount-display">${{ number_format($order->total_amount, 2) }}</div>
                        <small class="currency-tag">USD • Cambodian Riel accepted</small>

                        <!-- Simulated Ultra-Sharp Dynamic QR Code -->
                        <div class="qr-code-box">
                            <img
                                src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://daramarket.com/pay/{{ $order->order_number }}?amount={{ $order->total_amount }}"
                                alt="ABA KHQR Code"
                                class="actual-qr-image"
                            >
                            <div class="qr-center-logo">
                                <span>DM</span>
                            </div>
                        </div>

                        <div class="qr-scan-instructions">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px; margin-right:4px;"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                            <span>{{ $locale === 'km' ? 'ស្កេនទូទាត់ជាមួយកម្មវិធីធនាគារណាក៏បាន' : 'Scan to pay with any Mobile Banking App' }}</span>
                        </div>

                        <div class="bank-logos-row">
                            <span class="b-pill aba">ABA Mobile</span>
                            <span class="b-pill bakong">Bakong</span>
                            <span class="b-pill wing">Wing</span>
                            <span class="b-pill acleda">ACLEDA</span>
                        </div>

                        <div class="payment-status-pill {{ $order->payment_status === 'paid' ? 'is-paid' : 'is-pending' }}">
                            @if($order->payment_status === 'paid')
                                <span class="chk">✓</span> {{ $locale === 'km' ? 'ការទូទាត់ត្រូវបានបញ្ជាក់ជោគជ័យ' : 'Payment Confirmed' }}
                            @else
                                <span class="wait">⏳</span> {{ $locale === 'km' ? 'រង់ចាំការទូទាត់ / ទូទាត់ពេលដឹកជញ្ជូន' : 'Awaiting Payment on Delivery' }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-success-page {
    background: #f7f9f7;
    padding: 36px 0 64px 0;
    min-height: 85vh;
}
.success-inner {
    max-width: 1040px;
    margin: 0 auto;
    padding: 0 16px;
}
.success-hero-card {
    background: #ffffff;
    border: 1px solid #bbf7d0;
    border-radius: 16px;
    padding: 32px 24px;
    text-align: center;
    margin-bottom: 24px;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.05);
}
.success-badge-icon {
    width: 64px;
    height: 64px;
    background: #dcfce7;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
}
.success-title {
    font-size: 26px;
    font-weight: 800;
    color: #10291f;
    margin: 0 0 8px 0;
}
.success-sub {
    font-size: 15px;
    color: #64748b;
    margin: 0 0 12px 0;
}
.order-id-tag {
    color: #245943;
    background: rgba(36, 89, 67, 0.08);
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 16px;
}
.success-quick-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #15803d;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    padding: 4px 14px;
    border-radius: 999px;
}
.status-dot {
    width: 8px;
    height: 8px;
    background: #16a34a;
    border-radius: 50%;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(1.3); }
}

.success-content-grid {
    display: grid;
    grid-template-columns: 1.35fr 1fr;
    gap: 24px;
    align-items: start;
}
@media (max-width: 860px) {
    .success-content-grid {
        grid-template-columns: 1fr;
    }
}
.success-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 22px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.card-head-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f1f5f9;
}
.card-icon {
    font-size: 18px;
}
.card-sec-title {
    font-size: 16px;
    font-weight: 700;
    color: #10291f;
    margin: 0;
    flex: 1;
}
.items-count-badge {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    background: #f1f5f9;
    padding: 2px 8px;
    border-radius: 999px;
}
.recipient-details {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.detail-row {
    display: flex;
    font-size: 13px;
    gap: 8px;
}
.detail-label {
    width: 100px;
    color: #64748b;
    flex-shrink: 0;
}
.detail-val {
    color: #1e293b;
    font-weight: 500;
}
.detail-val.text-phone {
    font-weight: 700;
    color: #245943;
}
.detail-val.italic {
    font-style: italic;
    color: #475569;
}

/* Items */
.ordered-items-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 16px;
}
.ordered-item-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 10px;
    border-bottom: 1px dashed #f1f5f9;
}
.ordered-item-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.ordered-item-thumb {
    width: 52px;
    height: 52px;
    border-radius: 8px;
    object-fit: cover;
    background: #f1f5f9;
    flex-shrink: 0;
}
.ordered-item-info {
    flex: 1;
    min-width: 0;
}
.ordered-item-name {
    font-size: 14px;
    font-weight: 600;
    color: #10291f;
    margin: 0 0 3px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ordered-item-unit {
    font-size: 12px;
    color: #64748b;
}
.ordered-item-total {
    font-size: 14px;
    font-weight: 700;
    color: #10291f;
}

.invoice-summary-bar {
    border-top: 1.5px solid #f1f5f9;
    padding-top: 14px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.inv-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #64748b;
}
.inv-grand-total {
    font-size: 22px;
    font-weight: 800;
    color: #245943;
}
.inv-payment-badge {
    background: #f1f5f9;
    color: #1e293b;
    padding: 2px 8px;
    border-radius: 6px;
    font-weight: 600;
}

.success-actions-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.btn-sec-action {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #334155;
    padding: 10px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-sec-action:hover {
    background: #f8fafc;
    border-color: #94a3b8;
}
.btn-primary-action {
    background: #10291f;
    color: #ffffff;
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-primary-action:hover {
    background: #1e4636;
}

/* KHQR Card */
.khqr-interactive-card {
    background: #ffffff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
}
.khqr-header-strip {
    background: #d81e28;
    color: #ffffff;
    padding: 14px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.khqr-branding {
    display: flex;
    align-items: baseline;
    gap: 8px;
}
.khqr-tag {
    font-size: 18px;
    font-weight: 900;
    letter-spacing: 0.05em;
}
.khqr-tag-sub {
    font-size: 11px;
    opacity: 0.9;
}
.aba-pill-logo {
    background: #ffffff;
    color: #004d71;
    font-size: 12px;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 6px;
}
.khqr-body {
    padding: 24px;
    text-align: center;
}
.merchant-name-title {
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}
.khqr-amount-display {
    font-size: 32px;
    font-weight: 900;
    color: #10291f;
}
.currency-tag {
    font-size: 11px;
    color: #94a3b8;
    display: block;
    margin-bottom: 18px;
}
.qr-code-box {
    position: relative;
    width: 200px;
    height: 200px;
    margin: 0 auto 16px auto;
    border: 3px solid #10291f;
    border-radius: 12px;
    padding: 6px;
    background: #ffffff;
}
.actual-qr-image {
    width: 100%;
    height: 100%;
    display: block;
}
.qr-center-logo {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 36px;
    height: 36px;
    background: #10291f;
    color: #ffffff;
    font-size: 12px;
    font-weight: 800;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
}
.qr-scan-instructions {
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 14px;
}
.bank-logos-row {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-bottom: 18px;
}
.b-pill {
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 999px;
    background: #f1f5f9;
    color: #475569;
}
.b-pill.aba { background: rgba(0,77,113,0.1); color: #004d71; }
.b-pill.bakong { background: rgba(216,30,40,0.1); color: #d81e28; }
.payment-status-pill {
    display: block;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
}
.payment-status-pill.is-paid {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}
.payment-status-pill.is-pending {
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fde68a;
}
</style>

<script>
function openTrackOrderModalWithCode(orderNumber) {
    if (typeof openTrackOrderModal === 'function') {
        openTrackOrderModal();
        const input = document.getElementById('trackOrderInput');
        if (input) input.value = orderNumber;
    }
}
</script>
@endsection
