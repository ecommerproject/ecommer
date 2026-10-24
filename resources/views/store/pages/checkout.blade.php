@extends('store.layouts.app')

@section('title', ($locale === 'km' ? 'ទូទាត់ប្រាក់ (Checkout)' : 'Checkout') . ' | Dara Market')

@section('content')
<div class="checkout-page-container">
    <div class="container checkout-inner">
        <!-- Breadcrumbs & Heading -->
        <nav class="checkout-breadcrumbs" aria-label="Breadcrumb">
            <a href="{{ route('store.home') }}">{{ $locale === 'km' ? 'ទំព័រដើម' : 'Home' }}</a>
            <span class="sep">/</span>
            <a href="{{ route('store.products') }}">{{ $locale === 'km' ? 'ទំនិញ' : 'Products' }}</a>
            <span class="sep">/</span>
            <span class="current">{{ $locale === 'km' ? 'ទូទាត់ប្រាក់' : 'Checkout' }}</span>
        </nav>

        <div class="checkout-heading-box">
            <span class="checkout-eyebrow">⚡ FAST & SECURE CHECKOUT • ទូទាត់រហ័ស & សុវត្ថិភាព 100%</span>
            <h1 class="checkout-title">{{ $locale === 'km' ? 'ការទូទាត់ប្រាក់ & បញ្ជាក់ការកុម្ម៉ង់' : 'Order Checkout & Payment' }}</h1>
            <p class="checkout-subtitle">{{ $locale === 'km' ? 'សូមបំពេញព័ត៌មានរបស់អ្នកទទួលទំនិញ និងជ្រើសរើសវិធីសាស្ត្រទូទាត់ប្រាក់' : 'Enter shipping details and choose your preferred payment method.' }}</p>
        </div>

        <form id="checkoutForm" class="checkout-grid" onsubmit="submitCheckoutOrder(event)">
            @csrf

            <!-- Left Column: Shipping & Payment Details -->
            <div class="checkout-form-column">
                <!-- 1. Customer Information Card -->
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <span class="card-step-num">1</span>
                        <div>
                            <h2 class="card-step-title">{{ $locale === 'km' ? 'ព័ត៌មានអ្នកទទួល (Customer Details)' : 'Contact & Delivery Info' }}</h2>
                            <small class="card-step-sub">{{ $locale === 'km' ? 'ព័ត៌មាននេះប្រើសម្រាប់ទាក់ទង និងដឹកជញ្ជូនទំនិញ' : 'Used for contact & package delivery' }}</small>
                        </div>
                    </div>

                    <div class="checkout-fields-grid">
                        <div class="form-group full-width">
                            <label for="cust_name">
                                {{ $locale === 'km' ? 'ឈ្មោះពេញរបស់អ្នកទទួល *' : 'Full Name *' }}
                            </label>
                            <input
                                type="text"
                                id="cust_name"
                                name="customer_name"
                                class="checkout-input"
                                placeholder="{{ $locale === 'km' ? 'ឧ. សុខ ចាន់ថា' : 'e.g. Chantha Sok' }}"
                                value="{{ auth()->user()?->name ?? '' }}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="cust_phone">
                                {{ $locale === 'km' ? 'លេខទូរស័ព្ទ (Phone / Telegram) *' : 'Phone Number / Telegram *' }}
                            </label>
                            <input
                                type="tel"
                                id="cust_phone"
                                name="customer_phone"
                                class="checkout-input"
                                placeholder="012 345 678"
                                value="{{ auth()->user()?->phone ?? '' }}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="cust_email">
                                {{ $locale === 'km' ? 'អ៊ីមែល (Email) - មិនទាមទារ' : 'Email Address (Optional)' }}
                            </label>
                            <input
                                type="email"
                                id="cust_email"
                                name="customer_email"
                                class="checkout-input"
                                placeholder="name@example.com"
                                value="{{ auth()->user()?->email ?? '' }}"
                            >
                        </div>

                        <div class="form-group full-width">
                            <label for="cust_province">
                                {{ $locale === 'km' ? 'រាជធានី / ខេត្ត *' : 'City / Province *' }}
                            </label>
                            <select id="cust_province" name="province" class="checkout-select" onchange="calculateShippingByProvince(this.value)" required>
                                <option value="រាជធានីភ្នំពេញ (Phnom Penh)" selected>រាជធានីភ្នំពេញ (Phnom Penh) — Delivery $1.50 (Free ≥$35)</option>
                                <option value="ខេត្តកណ្ដាល (Kandal)">ខេត្តកណ្ដាល (Kandal)</option>
                                <option value="ខេត្តសៀមរាប (Siem Reap)">ខេត្តសៀមរាប (Siem Reap)</option>
                                <option value="ខេត្តបាត់ដំបង (Battambang)">ខេត្តបាត់ដំបង (Battambang)</option>
                                <option value="ខេត្តព្រះសីហនុ (Sihanoukville)">ខេត្តព្រះសីហនុ (Sihanoukville)</option>
                                <option value="ខេត្តកំពង់ចាម (Kampong Cham)">ខេត្តកំពង់ចាម (Kampong Cham)</option>
                                <option value="ខេត្តកំពត (Kampot)">ខេត្តកំពត (Kampot)</option>
                                <option value="ខេត្តបន្ទាយមានជ័យ (Banteay Meanchey)">ខេត្តបន្ទាយមានជ័យ (Banteay Meanchey)</option>
                                <option value="ខេត្តស្វាយរៀង (Svay Rieng)">ខេត្តស្វាយរៀង (Svay Rieng)</option>
                                <option value="ខេត្តផ្សេងៗ (Other Province)">ខេត្តផ្សេងៗ (Other Province)</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label for="cust_address">
                                {{ $locale === 'km' ? 'អាសយដ្ឋានលម្អិត (ផ្ទះលេខ, ផ្លូវ, សង្កាត់, ខណ្ឌ) *' : 'Street Address / Sangkat / Khan *' }}
                            </label>
                            <textarea
                                id="cust_address"
                                name="street_address"
                                class="checkout-textarea"
                                rows="2"
                                placeholder="{{ $locale === 'km' ? 'ឧ. ផ្ទះលេខ 42B, ផ្លូវ 310, សង្កាត់បឹងកេងកង 1, ខណ្ឌបឹងកេងកង' : 'e.g. #42B, St. 310, Sangkat BKK1, Khan BKK' }}"
                                required
                            >{{ auth()->user()?->address ?? '' }}</textarea>
                        </div>

                        <div class="form-group full-width">
                            <label for="cust_notes">
                                {{ $locale === 'km' ? 'កំណត់ចំណាំផ្សេងៗ (Order Notes)' : 'Delivery Notes' }}
                            </label>
                            <input
                                type="text"
                                id="cust_notes"
                                name="notes"
                                class="checkout-input"
                                placeholder="{{ $locale === 'km' ? 'ឧ. សូមទូរស័ព្ទមុនដឹកជញ្ជូន 15 នាទី' : 'e.g. Please call before arriving' }}"
                            >
                        </div>
                    </div>
                </div>

                <!-- 2. Payment Method Selector Card -->
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <span class="card-step-num">2</span>
                        <div>
                            <h2 class="card-step-title">{{ $locale === 'km' ? 'វិធីសាស្ត្រទូទាត់ប្រាក់ (Payment Method)' : 'Payment Method' }}</h2>
                            <small class="card-step-sub">{{ $locale === 'km' ? 'ទូទាត់ងាយស្រួលតាម KHQR ឬទូទាត់ពេលទំនិញដល់ដៃ' : 'Scan KHQR with any bank or pay cash on arrival' }}</small>
                        </div>
                    </div>

                    <div class="payment-options-list">
                        <!-- Option 1: ABA PAY KHQR -->
                        <label class="payment-option-card is-selected">
                            <input type="radio" name="payment_method" value="aba_pay" checked onchange="selectPaymentMethod('aba_pay')">
                            <div class="payment-card-body">
                                <div class="payment-head-row">
                                    <div class="payment-brand">
                                        <span class="pay-logo-badge logo-aba">ABA</span>
                                        <strong>ABA PAY (KHQR)</strong>
                                        <span class="pay-tag-popular">{{ $locale === 'km' ? 'ណែនាំ' : 'Recommended' }}</span>
                                    </div>
                                    <span class="pay-checkmark">✓</span>
                                </div>
                                <p class="payment-desc">
                                    {{ $locale === 'km' ? 'ស្កេនទូទាត់ភ្លាមៗជាមួយ ABA Mobile ឬកម្មវិធីធនាគារណាក៏បាន (Bakong, ACLEDA, Wing...)' : 'Scan instantly with ABA Mobile or any Bakong banking app in Cambodia.' }}
                                </p>
                            </div>
                        </label>

                        <!-- Option 2: Bakong / All Banking -->
                        <label class="payment-option-card">
                            <input type="radio" name="payment_method" value="bakong" onchange="selectPaymentMethod('bakong')">
                            <div class="payment-card-body">
                                <div class="payment-head-row">
                                    <div class="payment-brand">
                                        <span class="pay-logo-badge logo-bakong">KHQR</span>
                                        <strong>Bakong / Wing / ACLEDA</strong>
                                    </div>
                                    <span class="pay-checkmark">✓</span>
                                </div>
                                <p class="payment-desc">
                                    {{ $locale === 'km' ? 'ទូទាត់តាមប្រព័ន្ធបាគង ឬធនាគារក្នុងស្រុកទាំងអស់ដោយសុវត្ថិភាពខ្ពស់' : 'Support all National Bakong member banks and e-wallets.' }}
                                </p>
                            </div>
                        </label>

                        <!-- Option 3: Cash on Delivery (COD) -->
                        <label class="payment-option-card">
                            <input type="radio" name="payment_method" value="cod" onchange="selectPaymentMethod('cod')">
                            <div class="payment-card-body">
                                <div class="payment-head-row">
                                    <div class="payment-brand">
                                        <span class="pay-logo-badge logo-cod">💵</span>
                                        <strong>{{ $locale === 'km' ? 'ទូទាត់ពេលទទួលទំនិញ (Cash on Delivery)' : 'Cash on Delivery (COD)' }}</strong>
                                    </div>
                                    <span class="pay-checkmark">✓</span>
                                </div>
                                <p class="payment-desc">
                                    {{ $locale === 'km' ? 'ពិនិត្យមើលទំនិញរួចរាល់ ទើបប្រគល់ប្រាក់ជូនបុគ្គលិកដឹកជញ្ជូន' : 'Inspect package upon delivery and pay cash to the courier.' }}
                                </p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary & Placement -->
            <div class="checkout-summary-column">
                <div class="checkout-summary-card">
                    <h3 class="summary-card-title">{{ $locale === 'km' ? 'សេចក្តីសង្ខេបនៃការកុម្ម៉ង់' : 'Order Summary' }}</h3>

                    <!-- Cart Items Review List -->
                    <div id="checkoutItemsList" class="checkout-items-list">
                        <!-- Populated by JavaScript from local cart -->
                        <div class="checkout-empty-state" id="checkoutEmptyNotice" style="display: none; padding: 20px 0; text-align: center; color: #64748b;">
                            <p>កន្ត្រកទំនិញរបស់អ្នកនៅទទេ (Cart is empty)</p>
                            <a href="{{ route('store.products') }}" class="btn-continue-shop" style="display: inline-block; margin-top: 10px; color: #245943; font-weight: 700;">← ទៅកាន់ទំនិញ (Browse Products)</a>
                        </div>
                    </div>

                    <!-- Free Delivery Progress Pill -->
                    <div class="free-shipping-bar-box" id="shippingProgressBar">
                        <div class="fs-text-row">
                            <span id="fsStatusText">🚚 Free Delivery on orders ≥ $35.00</span>
                        </div>
                        <div class="fs-progress-track">
                            <div class="fs-progress-fill" id="fsProgressFill" style="width: 100%;"></div>
                        </div>
                    </div>

                    <!-- Cost Breakdown Details -->
                    <div class="summary-breakdown">
                        <div class="breakdown-row">
                            <span>{{ $locale === 'km' ? 'តម្លៃទំនិញសរុប (Subtotal)' : 'Subtotal' }}</span>
                            <strong id="summarySubtotal">$0.00</strong>
                        </div>
                        <div class="breakdown-row">
                            <span>{{ $locale === 'km' ? 'សេវាដឹកជញ្ជូន (Delivery)' : 'Delivery Fee' }}</span>
                            <span id="summaryShipping" class="shipping-fee-pill">$0.00</span>
                        </div>
                        <div class="breakdown-row total-row">
                            <span>{{ $locale === 'km' ? 'ទឹកប្រាក់ត្រូវទូទាត់សរុប (Total)' : 'Grand Total' }}</span>
                            <strong id="summaryTotal" class="grand-total-num">$0.00</strong>
                        </div>
                    </div>

                    <!-- Place Order Submit Button -->
                    <button type="submit" id="placeOrderBtn" class="btn-place-order">
                        <span class="btn-text">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:-3px; margin-right:6px;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            {{ $locale === 'km' ? 'បញ្ជាក់ការកុម្ម៉ង់ឥឡូវនេះ (Place Order)' : 'Confirm & Place Order' }}
                        </span>
                        <span class="btn-spinner" style="display: none;">
                            <svg class="spin-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"></path></svg>
                            <span>{{ $locale === 'km' ? 'កំពុងដំណើរការ...' : 'Processing...' }}</span>
                        </span>
                    </button>

                    <!-- Trust & Guarantee Badge -->
                    <div class="checkout-trust-box">
                        <div class="trust-item">
                            <span class="trust-icon">🛡️</span>
                            <span>{{ $locale === 'km' ? 'ទំនិញសុទ្ធ 100% ធានាសុវត្ថិភាព' : '100% Authentic & Secure Guarantee' }}</span>
                        </div>
                        <div class="trust-item">
                            <span class="trust-icon">⚡</span>
                            <span>{{ $locale === 'km' ? 'ដឹកជញ្ជូនរហ័ស 24-48 ម៉ោង' : 'Fast Delivery 24-48h Nationwide' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.checkout-page-container {
    background: #f7f9f7;
    padding: 32px 0 64px 0;
    min-height: 80vh;
}
.checkout-inner {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 16px;
}
.checkout-breadcrumbs {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 16px;
}
.checkout-breadcrumbs a {
    color: #475569;
    text-decoration: none;
}
.checkout-breadcrumbs a:hover {
    color: #10291f;
}
.checkout-breadcrumbs .current {
    color: #10291f;
    font-weight: 600;
}
.checkout-heading-box {
    margin-bottom: 28px;
}
.checkout-eyebrow {
    display: inline-block;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    color: #245943;
    background: rgba(36, 89, 67, 0.08);
    padding: 4px 10px;
    border-radius: 999px;
    margin-bottom: 8px;
}
.checkout-title {
    font-size: 26px;
    font-weight: 800;
    color: #10291f;
    margin: 0 0 6px 0;
}
.checkout-subtitle {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}
.checkout-grid {
    display: grid;
    grid-template-columns: 1.35fr 1fr;
    gap: 28px;
    align-items: start;
}
@media (max-width: 900px) {
    .checkout-grid {
        grid-template-columns: 1fr;
    }
}
.checkout-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.checkout-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
}
.card-step-num {
    width: 32px;
    height: 32px;
    background: #10291f;
    color: #ffffff;
    font-weight: 800;
    font-size: 15px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card-step-title {
    font-size: 17px;
    font-weight: 700;
    color: #10291f;
    margin: 0 0 2px 0;
}
.card-step-sub {
    font-size: 12px;
    color: #64748b;
}
.checkout-fields-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 600px) {
    .checkout-fields-grid {
        grid-template-columns: 1fr;
    }
}
.form-group.full-width {
    grid-column: 1 / -1;
}
.form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.checkout-input, .checkout-select, .checkout-textarea {
    width: 100%;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 14px;
    font-family: inherit;
    color: #0f172a;
    background: #ffffff;
    box-sizing: border-box;
    transition: all 0.2s ease;
}
.checkout-input:focus, .checkout-select:focus, .checkout-textarea:focus {
    outline: none;
    border-color: #245943;
    box-shadow: 0 0 0 3px rgba(36, 89, 67, 0.12);
}
.payment-options-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.payment-option-card {
    display: flex;
    align-items: flex-start;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.2s ease;
}
.payment-option-card:hover {
    border-color: #cbd5e1;
    background: #fafcfb;
}
.payment-option-card.is-selected {
    border-color: #245943;
    background: rgba(36, 89, 67, 0.03);
    box-shadow: 0 0 0 1px #245943;
}
.payment-option-card input[type="radio"] {
    margin-top: 4px;
    margin-right: 12px;
    accent-color: #245943;
    width: 17px;
    height: 17px;
}
.payment-card-body {
    flex: 1;
}
.payment-head-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
}
.payment-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    color: #10291f;
}
.pay-logo-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 5px;
}
.logo-aba {
    background: #004d71;
    color: #ffffff;
}
.logo-bakong {
    background: #d81e28;
    color: #ffffff;
}
.logo-cod {
    background: #e2e8f0;
    font-size: 14px;
}
.pay-tag-popular {
    font-size: 10px;
    font-weight: 700;
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
    padding: 1px 6px;
    border-radius: 999px;
}
.pay-checkmark {
    color: #245943;
    font-weight: 800;
    font-size: 16px;
    display: none;
}
.payment-option-card.is-selected .pay-checkmark {
    display: inline;
}
.payment-desc {
    font-size: 12px;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
}

/* Summary Box */
.checkout-summary-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    position: sticky;
    top: 24px;
}
.summary-card-title {
    font-size: 18px;
    font-weight: 800;
    color: #10291f;
    margin: 0 0 16px 0;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}
.checkout-items-list {
    max-height: 280px;
    overflow-y: auto;
    margin-bottom: 16px;
    padding-right: 4px;
}
.checkout-item-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px dashed #f1f5f9;
}
.checkout-item-row:last-child {
    border-bottom: none;
}
.checkout-item-thumb {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
    background: #f1f5f9;
    flex-shrink: 0;
}
.checkout-item-info {
    flex: 1;
    min-width: 0;
}
.checkout-item-name {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.checkout-item-meta {
    font-size: 12px;
    color: #64748b;
}
.checkout-item-price {
    font-size: 14px;
    font-weight: 700;
    color: #10291f;
    text-align: right;
}

/* Free shipping progress bar */
.free-shipping-bar-box {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 16px;
}
.fs-text-row {
    font-size: 12px;
    font-weight: 700;
    color: #15803d;
    margin-bottom: 6px;
}
.fs-progress-track {
    height: 6px;
    background: #dcfce7;
    border-radius: 999px;
    overflow: hidden;
}
.fs-progress-fill {
    height: 100%;
    background: #16a34a;
    border-radius: 999px;
    transition: width 0.3s ease;
}

/* Breakdown */
.summary-breakdown {
    border-top: 1px solid #f1f5f9;
    padding-top: 14px;
    margin-bottom: 20px;
}
.breakdown-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 8px;
}
.shipping-fee-pill {
    font-weight: 700;
    color: #16a34a;
}
.breakdown-row.total-row {
    border-top: 1px dashed #cbd5e1;
    padding-top: 12px;
    margin-top: 10px;
    font-size: 16px;
    color: #10291f;
}
.grand-total-num {
    font-size: 22px;
    font-weight: 800;
    color: #10291f;
}

/* Place order button */
.btn-place-order {
    width: 100%;
    background: #10291f;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    padding: 15px;
    font-size: 16px;
    font-weight: 800;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(16, 41, 31, 0.25);
}
.btn-place-order:hover {
    background: #1b4534;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(16, 41, 31, 0.3);
}
.btn-place-order:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}
.spin-icon {
    animation: spin 1s linear infinite;
    vertical-align: -3px;
    margin-right: 8px;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.checkout-trust-box {
    margin-top: 18px;
    padding-top: 14px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.trust-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #64748b;
}
</style>

<script>
let currentShippingFee = 1.50;
let currentSubtotal = 0;
let currentCartItems = [];

document.addEventListener('DOMContentLoaded', function () {
    loadCheckoutCart();
});

function loadCheckoutCart() {
    try {
        const storageKey = 'dara-market-cart';
        const cart = JSON.parse(localStorage.getItem(storageKey) || '{"count":0,"total":0,"items":[]}');
        currentCartItems = Array.isArray(cart.items) ? cart.items : [];

        // Fallback to secondary storage key if empty
        if (currentCartItems.length === 0) {
            const fallbackItems = JSON.parse(localStorage.getItem('dara_store_cart_items') || '[]');
            if (Array.isArray(fallbackItems) && fallbackItems.length > 0) {
                currentCartItems = fallbackItems;
            }
        }
    } catch (e) {
        currentCartItems = [];
    }

    renderCheckoutSummary();
}

function renderCheckoutSummary() {
    const listContainer = document.getElementById('checkoutItemsList');
    const emptyNotice = document.getElementById('checkoutEmptyNotice');
    const placeBtn = document.getElementById('placeOrderBtn');

    if (!currentCartItems || currentCartItems.length === 0) {
        if (emptyNotice) emptyNotice.style.display = 'block';
        if (placeBtn) placeBtn.disabled = true;
        document.getElementById('summarySubtotal').textContent = '$0.00';
        document.getElementById('summaryTotal').textContent = '$0.00';
        return;
    }

    if (emptyNotice) emptyNotice.style.display = 'none';
    if (placeBtn) placeBtn.disabled = false;

    let subtotal = 0;
    let itemsHtml = '';

    currentCartItems.forEach((item, index) => {
        const price = parseFloat(item.price) || 0;
        const qty = parseInt(item.quantity, 10) || 1;
        const lineTotal = price * qty;
        subtotal += lineTotal;

        const img = item.image || 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80';

        itemsHtml += `
            <div class="checkout-item-row">
                <img src="${img}" alt="${item.name}" class="checkout-item-thumb">
                <div class="checkout-item-info">
                    <div class="checkout-item-name" title="${item.name}">${item.name}</div>
                    <div class="checkout-item-meta">$${price.toFixed(2)} × ${qty}</div>
                </div>
                <div class="checkout-item-price">$${lineTotal.toFixed(2)}</div>
            </div>
        `;
    });

    listContainer.innerHTML = itemsHtml;
    currentSubtotal = subtotal;

    // Check free shipping threshold ($35)
    const provinceSelect = document.getElementById('cust_province');
    calculateShippingByProvince(provinceSelect ? provinceSelect.value : 'Phnom Penh');
}

function calculateShippingByProvince(provinceValue) {
    const isPhnomPenh = provinceValue.includes('Phnom Penh') || provinceValue.includes('ភ្នំពេញ');
    const standardFee = isPhnomPenh ? 1.50 : 2.50;

    if (currentSubtotal >= 35.00) {
        currentShippingFee = 0.00;
        document.getElementById('summaryShipping').innerHTML = '<span style="color:#16a34a; font-weight:800;">FREE (ឥតគិតថ្លៃ)</span>';
        document.getElementById('fsStatusText').textContent = '🎉 Congratulations! You unlocked Free Delivery!';
        document.getElementById('fsProgressFill').style.width = '100%';
    } else {
        currentShippingFee = standardFee;
        document.getElementById('summaryShipping').textContent = '$' + currentShippingFee.toFixed(2);
        const needed = 35.00 - currentSubtotal;
        document.getElementById('fsStatusText').textContent = `🚚 Add $${needed.toFixed(2)} more for FREE Delivery!`;
        const pct = Math.min(100, Math.round((currentSubtotal / 35.00) * 100));
        document.getElementById('fsProgressFill').style.width = pct + '%';
    }

    const grandTotal = currentSubtotal + currentShippingFee;
    document.getElementById('summarySubtotal').textContent = '$' + currentSubtotal.toFixed(2);
    document.getElementById('summaryTotal').textContent = '$' + grandTotal.toFixed(2);
}

function selectPaymentMethod(method) {
    document.querySelectorAll('.payment-option-card').forEach(card => {
        card.classList.remove('is-selected');
    });
    const radio = document.querySelector(`input[name="payment_method"][value="${method}"]`);
    if (radio) {
        radio.closest('.payment-option-card').classList.add('is-selected');
        radio.checked = true;
    }
}

async function submitCheckoutOrder(e) {
    e.preventDefault();

    if (!currentCartItems || currentCartItems.length === 0) {
        alert('សូមជ្រើសរើសទំនិញចូលកន្ត្រកជាមុនសិន! (Please add items to cart first)');
        return;
    }

    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('placeOrderBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnSpinner = submitBtn.querySelector('.btn-spinner');

    submitBtn.disabled = true;
    btnText.style.display = 'none';
    btnSpinner.style.display = 'inline-flex';

    const formData = {
        customer_name: form.customer_name.value.trim(),
        customer_phone: form.customer_phone.value.trim(),
        customer_email: form.customer_email.value.trim(),
        province: form.province.value,
        street_address: form.street_address.value.trim(),
        payment_method: form.payment_method.value,
        notes: form.notes.value.trim(),
        items: currentCartItems,
    };

    try {
        const response = await fetch("{{ route('store.checkout.place') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // Clear shopping cart
            localStorage.removeItem('dara-market-cart');
            localStorage.removeItem('dara_store_cart_items');
            if (typeof updateCart === 'function') {
                updateCart({ count: 0, total: 0, items: [] });
            }

            // Redirect to success page
            window.location.href = data.redirect_url;
        } else {
            alert(data.message || 'មានបញ្ហាក្នុងការកុម្ម៉ង់ សូមព្យាយាមម្តងទៀត។ (Failed to place order)');
            submitBtn.disabled = false;
            btnText.style.display = 'inline-flex';
            btnSpinner.style.display = 'none';
        }
    } catch (err) {
        console.error('Order submission error:', err);
        alert('មានបញ្ហាបច្ចេកទេស សូមព្យាយាមម្តងទៀត! (Network error, please try again)');
        submitBtn.disabled = false;
        btnText.style.display = 'inline-flex';
        btnSpinner.style.display = 'none';
    }
}
</script>
@endsection
