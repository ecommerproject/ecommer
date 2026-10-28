@extends('store.layouts.app')

@section('title', ($locale === 'km' ? 'ទូទាត់ប្រាក់ (Checkout)' : 'Checkout') . ' | Dara Market')

@section('content')
<div class="checkout-page-container">
    <div class="container checkout-inner">
        <!-- Breadcrumbs & Heading -->
        <nav class="checkout-breadcrumbs" aria-label="Breadcrumb">
            <a href="{{ route('store.home') }}">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px; margin-right:4px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                {{ $locale === 'km' ? 'ទំព័រដើម' : 'Home' }}
            </a>
            <span class="sep">/</span>
            <a href="{{ route('store.products') }}">{{ $locale === 'km' ? 'ទំនិញ' : 'Products' }}</a>
            <span class="sep">/</span>
            <span class="current">{{ $locale === 'km' ? 'ទូទាត់ប្រាក់' : 'Checkout' }}</span>
        </nav>

        <div class="checkout-heading-box">
            <div class="checkout-badge-strip">
                <span class="checkout-eyebrow">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" style="margin-right: 4px;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    FAST & SECURE CHECKOUT • ទូទាត់រហ័ស & សុវត្ថិភាព 100%
                </span>
            </div>
            <h1 class="checkout-title">{{ $locale === 'km' ? 'ការទូទាត់ប្រាក់ & បញ្ជាក់ការកុម្ម៉ង់' : 'Order Checkout & Payment' }}</h1>
            <p class="checkout-subtitle">{{ $locale === 'km' ? 'សូមបំពេញព័ត៌មានដឹកជញ្ជូនរបស់អ្នកទទួល និងជ្រើសរើសវិធីសាស្ត្រទូទាត់ប្រាក់ខាងក្រោម' : 'Please provide recipient shipping details and choose your preferred payment method.' }}</p>
        </div>

        <form id="checkoutForm" class="checkout-grid" onsubmit="submitCheckoutOrder(event)">
            @csrf

            <!-- Left Column: Shipping & Payment Details -->
            <div class="checkout-form-column">
                <!-- 1. Customer Information Card -->
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <div class="card-step-badge">1</div>
                        <div class="card-title-group">
                            <h2 class="card-step-title">{{ $locale === 'km' ? 'ព័ត៌មានអ្នកទទួល (Customer Details)' : 'Contact & Delivery Info' }}</h2>
                            <span class="card-step-sub">{{ $locale === 'km' ? 'ព័ត៌មាននេះប្រើសម្រាប់ទាក់ទង និងដឹកជញ្ជូនទំនិញដល់ផ្ទះអ្នក' : 'Used for contact & package delivery' }}</span>
                        </div>
                    </div>

                    <div class="checkout-fields-grid">
                        <div class="form-group full-width">
                            <label for="cust_name">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>{{ $locale === 'km' ? 'ឈ្មោះពេញរបស់អ្នកទទួល' : 'Full Name' }} <span class="req-star">*</span></span>
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
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <span>{{ $locale === 'km' ? 'លេខទូរស័ព្ទ (Phone / Telegram)' : 'Phone Number' }} <span class="req-star">*</span></span>
                            </label>
                            <input
                                type="tel"
                                id="cust_phone"
                                name="customer_phone"
                                class="checkout-input"
                                placeholder="071 450 4547"
                                value="{{ auth()->user()?->phone ?? '' }}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="cust_email">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span>{{ $locale === 'km' ? 'អ៊ីមែល (Email) - មិនទាមទារ' : 'Email Address (Optional)' }}</span>
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
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>{{ $locale === 'km' ? 'រាជធានី / ខេត្ត' : 'City / Province' }} <span class="req-star">*</span></span>
                            </label>
                            <select id="cust_province" name="province" class="checkout-select" onchange="calculateShippingByProvince(this.value)" required>
                                <option value="រាជធានីភ្នំពេញ (Phnom Penh)" selected>រាជធានីភ្នំពេញ (Phnom Penh) — ដឹកជញ្ជូន $1.50 (ឥតគិតថ្លៃចាប់ពី $35)</option>
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
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>{{ $locale === 'km' ? 'អាសយដ្ឋានលម្អិត (ផ្ទះលេខ, ផ្លូវ, សង្កាត់, ខណ្ឌ)' : 'Street Address / Sangkat / Khan' }} <span class="req-star">*</span></span>
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
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <span>{{ $locale === 'km' ? 'កំណត់ចំណាំផ្សេងៗ (Order Notes) - មិនទាមទារ' : 'Delivery Notes (Optional)' }}</span>
                            </label>
                            <input
                                type="text"
                                id="cust_notes"
                                name="notes"
                                class="checkout-input"
                                placeholder="{{ $locale === 'km' ? 'ឧ. សូមទូរស័ព្ទមុនដឹកជញ្ជូន 15 នាទី' : 'e.g. Please call 15 mins before arriving' }}"
                            >
                        </div>
                    </div>
                </div>

                <!-- 2. Payment Method Selector Card -->
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <div class="card-step-badge">2</div>
                        <div class="card-title-group">
                            <h2 class="card-step-title">{{ $locale === 'km' ? 'វិធីសាស្ត្រទូទាត់ប្រាក់ (Payment Method)' : 'Payment Method' }}</h2>
                            <span class="card-step-sub">{{ $locale === 'km' ? 'ទូទាត់ងាយស្រួលតាម KHQR ធនាគារ ឬទូទាត់ពេលទំនិញដល់ដៃ' : 'Scan KHQR with any bank or pay cash on arrival' }}</span>
                        </div>
                    </div>

                    <div class="payment-options-list">
                        <!-- Option 1: ABA PAY KHQR -->
                        <label class="payment-option-card is-selected" onclick="selectPaymentMethod('aba_pay')">
                            <div class="payment-radio-wrap">
                                <input type="radio" name="payment_method" value="aba_pay" checked>
                                <span class="custom-radio-circle"></span>
                            </div>
                            <div class="payment-card-body">
                                <div class="payment-head-row">
                                    <div class="payment-brand">
                                        <span class="pay-logo-badge logo-aba">ABA</span>
                                        <strong>ABA PAY (KHQR)</strong>
                                        <span class="pay-tag-popular">{{ $locale === 'km' ? 'ណែនាំ' : 'Recommended' }}</span>
                                    </div>
                                    <span class="pay-checkmark-icon">✓</span>
                                </div>
                                <p class="payment-desc">
                                    {{ $locale === 'km' ? 'ស្កេនទូទាត់ភ្លាមៗជាមួយ ABA Mobile ឬកម្មវិធីធនាគារណាក៏បាន (Bakong, ACLEDA, Wing...) ដោយសុវត្ថិភាព 100%' : 'Scan instantly with ABA Mobile or any Bakong banking app in Cambodia.' }}
                                </p>
                                <div class="payment-bank-chips">
                                    <span class="chip-bank chip-aba">ABA Mobile</span>
                                    <span class="chip-bank">Bakong</span>
                                    <span class="chip-bank">ACLEDA</span>
                                    <span class="chip-bank">Wing</span>
                                </div>
                            </div>
                        </label>

                        <!-- Option 2: Bakong / All Banking -->
                        <label class="payment-option-card" onclick="selectPaymentMethod('bakong')">
                            <div class="payment-radio-wrap">
                                <input type="radio" name="payment_method" value="bakong">
                                <span class="custom-radio-circle"></span>
                            </div>
                            <div class="payment-card-body">
                                <div class="payment-head-row">
                                    <div class="payment-brand">
                                        <span class="pay-logo-badge logo-bakong">KHQR</span>
                                        <strong>Bakong / Wing / ACLEDA</strong>
                                    </div>
                                    <span class="pay-checkmark-icon">✓</span>
                                </div>
                                <p class="payment-desc">
                                    {{ $locale === 'km' ? 'ទូទាត់តាមប្រព័ន្ធបាគង ឬធនាគារក្នុងស្រុកទាំងអស់ដោយសុវត្ថិភាពខ្ពស់' : 'Support all National Bakong member banks and e-wallets.' }}
                                </p>
                                <div class="payment-bank-chips">
                                    <span class="chip-bank chip-bakong">National KHQR</span>
                                    <span class="chip-bank">All Banks</span>
                                </div>
                            </div>
                        </label>

                        <!-- Option 3: Cash on Delivery (COD) -->
                        <label class="payment-option-card" onclick="selectPaymentMethod('cod')">
                            <div class="payment-radio-wrap">
                                <input type="radio" name="payment_method" value="cod">
                                <span class="custom-radio-circle"></span>
                            </div>
                            <div class="payment-card-body">
                                <div class="payment-head-row">
                                    <div class="payment-brand">
                                        <span class="pay-logo-badge logo-cod">💵</span>
                                        <strong>{{ $locale === 'km' ? 'ទូទាត់ពេលទទួលទំនិញ (Cash on Delivery)' : 'Cash on Delivery (COD)' }}</strong>
                                    </div>
                                    <span class="pay-checkmark-icon">✓</span>
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
                    <div class="summary-card-header">
                        <div class="summary-title-row">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#245943" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            <h3 class="summary-card-title">{{ $locale === 'km' ? 'សេចក្តីសង្ខេបនៃការកុម្ម៉ង់' : 'Order Summary' }}</h3>
                        </div>
                    </div>

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
                            <strong id="summarySubtotal" class="subtotal-val">$0.00</strong>
                        </div>
                        <div class="breakdown-row">
                            <span>{{ $locale === 'km' ? 'សេវាដឹកជញ្ជូន (Delivery)' : 'Delivery Fee' }}</span>
                            <span id="summaryShipping" class="shipping-fee-pill">$0.00</span>
                        </div>
                        <div class="breakdown-row total-row">
                            <div>
                                <span class="total-lbl">{{ $locale === 'km' ? 'ទឹកប្រាក់ត្រូវទូទាត់សរុប (Total)' : 'Grand Total' }}</span>
                                <small class="total-tax-note">{{ $locale === 'km' ? 'រួមបញ្ចូលពន្ធ និងសេវាដឹក' : 'Includes all taxes & delivery' }}</small>
                            </div>
                            <div class="total-values-block">
                                <strong id="summaryTotal" class="grand-total-num">$0.00</strong>
                                <span id="summaryTotalKhr" class="grand-total-khr">≈ 0 ៛</span>
                            </div>
                        </div>
                    </div>

                    <!-- Place Order Submit Button -->
                    <button type="submit" id="placeOrderBtn" class="btn-place-order">
                        <span class="btn-text">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>{{ $locale === 'km' ? 'បញ្ជាក់ការកុម្ម៉ង់ឥឡូវនេះ (Place Order)' : 'Confirm & Place Order' }}</span>
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
                            <span>{{ $locale === 'km' ? 'ទំនិញសុទ្ធ 100% ធានាសុវត្ថិភាព' : '100% Authentic Guarantee' }}</span>
                        </div>
                        <div class="trust-item">
                            <span class="trust-icon">⚡</span>
                            <span>{{ $locale === 'km' ? 'ដឹកជញ្ជូនរហ័ស 24-48 ម៉ោង' : 'Fast Delivery 24-48h' }}</span>
                        </div>
                        <div class="trust-item">
                            <span class="trust-icon">🔒</span>
                            <span>{{ $locale === 'km' ? 'ទូទាត់តាម KHQR មានសុវត្ថិភាពខ្ពស់' : 'Bank-Grade Secure KHQR' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.checkout-page-container {
    background: #f8fafc;
    background-image: radial-gradient(at 0% 0%, rgba(36, 89, 67, 0.05) 0px, transparent 50%),
                      radial-gradient(at 100% 100%, rgba(0, 77, 113, 0.05) 0px, transparent 50%);
    padding: 28px 0 96px 0;
    min-height: 85vh;
    overflow-x: hidden;
    width: 100%;
    box-sizing: border-box;
}
.checkout-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 20px;
    box-sizing: border-box;
    width: 100%;
}
.checkout-breadcrumbs {
    display: inline-flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 22px;
    padding: 6px 14px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    max-width: 100%;
}
.checkout-breadcrumbs a {
    color: #475569;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: color 0.15s ease;
}
.checkout-breadcrumbs a:hover {
    color: #173e2c;
}
.checkout-breadcrumbs .sep {
    color: #94a3b8;
    font-size: 11px;
}
.checkout-breadcrumbs .current {
    color: #0f172a;
    font-weight: 800;
}
.checkout-heading-box {
    margin-bottom: 28px;
}
.checkout-badge-strip {
    margin-bottom: 10px;
}
.checkout-eyebrow {
    display: inline-flex;
    align-items: center;
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: 0.05em;
    color: #065f46;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    padding: 5px 14px;
    border-radius: 999px;
    box-shadow: 0 1px 3px rgba(16, 185, 129, 0.08);
    max-width: 100%;
    word-break: break-word;
}
.checkout-title {
    font-size: 28px;
    font-weight: 900;
    color: #0f172a;
    letter-spacing: -0.025em;
    margin: 0 0 8px 0;
    line-height: 1.25;
}
.checkout-subtitle {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    line-height: 1.5;
}

/* Grid Layout */
.checkout-grid {
    display: grid;
    grid-template-columns: 1.35fr 1fr;
    gap: 32px;
    align-items: start;
    width: 100%;
    box-sizing: border-box;
}
.checkout-form-column,
.checkout-summary-column {
    min-width: 0;
    max-width: 100%;
    width: 100%;
    box-sizing: border-box;
}

/* Modern Card */
.checkout-card {
    background: #ffffff;
    border: 1px solid #e2ece3;
    border-radius: 22px;
    padding: 26px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
    box-sizing: border-box;
    width: 100%;
    max-width: 100%;
    transition: all 0.25s ease;
}
.checkout-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 8px 30px -4px rgba(15, 23, 42, 0.06);
}
.checkout-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 22px;
    padding-bottom: 16px;
    border-bottom: 1.5px solid #f1f5f9;
}
.card-step-badge {
    width: 36px;
    height: 36px;
    border-radius: 12px;
    background: linear-gradient(135deg, #173e2c, #245943);
    color: #ffffff;
    font-weight: 800;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(23, 62, 44, 0.25);
}
.card-title-group {
    flex: 1;
    min-width: 0;
}
.card-step-title {
    font-size: 17px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 3px 0;
    line-height: 1.35;
}
.card-step-sub {
    font-size: 12.5px;
    color: #64748b;
    line-height: 1.4;
}

/* Fields Grid & Inputs */
.checkout-fields-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    width: 100%;
    box-sizing: border-box;
}
.form-group {
    min-width: 0;
    width: 100%;
    box-sizing: border-box;
}
.form-group.full-width {
    grid-column: 1 / -1;
}
.form-group label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 7px;
    flex-wrap: wrap;
}
.form-group label svg {
    color: #64748b;
    flex-shrink: 0;
}
.req-star {
    color: #ef4444;
    font-weight: 800;
}
.checkout-input, .checkout-select, .checkout-textarea {
    width: 100%;
    max-width: 100%;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 12px 14px;
    font-size: 14px;
    font-family: inherit;
    color: #0f172a;
    background: #f8fafc;
    box-sizing: border-box;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.checkout-select {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364748b' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 36px;
    appearance: none;
    -webkit-appearance: none;
}
.checkout-input::placeholder, .checkout-textarea::placeholder {
    color: #94a3b8;
}
.checkout-input:hover, .checkout-select:hover, .checkout-textarea:hover {
    border-color: #cbd5e1;
    background: #ffffff;
}
.checkout-input:focus, .checkout-select:focus, .checkout-textarea:focus {
    outline: none;
    border-color: #173e2c;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(23, 62, 44, 0.12);
}
.checkout-textarea {
    resize: vertical;
    min-height: 68px;
    line-height: 1.5;
    word-break: break-word;
}

/* Payment Option Cards */
.payment-options-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 100%;
    box-sizing: border-box;
}
.payment-option-card {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    box-sizing: border-box;
    width: 100%;
    max-width: 100%;
}
.payment-option-card:hover {
    border-color: #94a3b8;
    background: #fbfdfc;
    transform: translateY(-1px);
}
.payment-option-card.is-selected {
    border-color: #173e2c;
    background: linear-gradient(180deg, #f7faf8 0%, #ffffff 100%);
    box-shadow: 0 6px 18px rgba(23, 62, 44, 0.08);
}
.payment-radio-wrap {
    position: relative;
    width: 20px;
    height: 20px;
    margin-top: 2px;
    flex-shrink: 0;
}
.payment-radio-wrap input[type="radio"] {
    opacity: 0;
    position: absolute;
    width: 100%;
    height: 100%;
    margin: 0;
    cursor: pointer;
}
.custom-radio-circle {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid #cbd5e1;
    background: #ffffff;
    transition: all 0.2s ease;
    pointer-events: none;
}
.payment-option-card.is-selected .custom-radio-circle {
    border-color: #173e2c;
    border-width: 6px;
}
.payment-card-body {
    flex: 1;
    min-width: 0;
}
.payment-head-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    flex-wrap: wrap;
}
.payment-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    flex-wrap: wrap;
    min-width: 0;
}
.pay-logo-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 6px;
    letter-spacing: 0.04em;
    flex-shrink: 0;
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
    background: #f1f5f9;
    color: #0f172a;
    font-size: 14px;
}
.pay-tag-popular {
    font-size: 10.5px;
    font-weight: 700;
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
    padding: 2px 7px;
    border-radius: 999px;
}
.pay-checkmark-icon {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #173e2c;
    color: #ffffff;
    font-size: 11px;
    font-weight: 800;
    display: none;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.payment-option-card.is-selected .pay-checkmark-icon {
    display: flex;
}
.payment-desc {
    font-size: 12.5px;
    color: #64748b;
    margin: 0 0 10px 0;
    line-height: 1.45;
    word-break: break-word;
}
.payment-bank-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.chip-bank {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 999px;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}
.chip-bank.chip-aba {
    background: rgba(0, 77, 113, 0.08);
    color: #004d71;
    border-color: rgba(0, 77, 113, 0.2);
}
.chip-bank.chip-bakong {
    background: rgba(216, 30, 40, 0.08);
    color: #d81e28;
    border-color: rgba(216, 30, 40, 0.2);
}

/* Order Summary Box (Luxury Right Side) */
.checkout-summary-card {
    background: #ffffff;
    border: 1px solid #e2ece3;
    border-radius: 22px;
    padding: 24px;
    box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 24px;
    box-sizing: border-box;
    width: 100%;
    max-width: 100%;
}
.summary-card-header {
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1.5px solid #f1f5f9;
}
.summary-title-row {
    display: flex;
    align-items: center;
    gap: 8px;
}
.summary-card-title {
    font-size: 17px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}
.checkout-items-list {
    max-height: 320px;
    overflow-y: auto;
    margin-bottom: 18px;
    padding-right: 4px;
}
.checkout-items-list::-webkit-scrollbar {
    width: 4px;
}
.checkout-items-list::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.checkout-item-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px dashed #e2e8f0;
    width: 100%;
    box-sizing: border-box;
}
.checkout-item-row:last-child {
    border-bottom: none;
}
.checkout-item-thumb {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    object-fit: cover;
    background: #0f172a;
    border: 1px solid #e2e8f0;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
}
.checkout-item-info {
    flex: 1;
    min-width: 0;
}
.checkout-item-name {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.35;
    margin-bottom: 4px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.checkout-item-meta {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 500;
}
.checkout-item-price {
    font-size: 14.5px;
    font-weight: 800;
    color: #0f172a;
    text-align: right;
    white-space: nowrap;
    flex-shrink: 0;
}

/* Free shipping progress bar */
.free-shipping-bar-box {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 18px;
    box-sizing: border-box;
    width: 100%;
}
.fs-text-row {
    font-size: 12px;
    font-weight: 700;
    color: #15803d;
    margin-bottom: 8px;
}
.fs-progress-track {
    height: 6px;
    background: #dcfce7;
    border-radius: 999px;
    overflow: hidden;
    width: 100%;
    box-sizing: border-box;
}
.fs-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #16a34a, #22c55e);
    border-radius: 999px;
    transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Breakdown */
.summary-breakdown {
    border-top: 1.5px solid #f1f5f9;
    padding-top: 16px;
    margin-bottom: 20px;
    width: 100%;
    box-sizing: border-box;
}
.breakdown-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 10px;
    width: 100%;
    box-sizing: border-box;
}
.subtotal-val {
    color: #0f172a;
    font-weight: 700;
    white-space: nowrap;
}
.shipping-fee-pill {
    font-weight: 800;
    color: #16a34a;
    white-space: nowrap;
}
.breakdown-row.total-row {
    border-top: 1.5px dashed #cbd5e1;
    padding-top: 14px;
    margin-top: 12px;
    margin-bottom: 0;
}
.total-lbl {
    font-size: 15px;
    font-weight: 800;
    color: #0f172a;
    display: block;
}
.total-tax-note {
    font-size: 11px;
    color: #94a3b8;
    display: block;
}
.total-values-block {
    text-align: right;
    white-space: nowrap;
    flex-shrink: 0;
}
.grand-total-num {
    font-size: 24px;
    font-weight: 900;
    color: #173e2c;
    display: block;
    line-height: 1.1;
}
.grand-total-khr {
    font-size: 12.5px;
    font-weight: 700;
    color: #059669;
    display: block;
    margin-top: 2px;
}

/* Place order button (Hero Element) */
.btn-place-order {
    width: 100%;
    background: linear-gradient(135deg, #0f172a 0%, #173e2c 100%);
    color: #ffffff;
    border: 1px solid rgba(216, 169, 98, 0.4);
    border-radius: 9999px;
    padding: 15px 20px;
    font-size: 15px;
    font-weight: 800;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 6px 20px rgba(15, 23, 42, 0.25);
    position: relative;
    overflow: hidden;
    box-sizing: border-box;
}
.btn-place-order:hover {
    background: linear-gradient(135deg, #000000 0%, #0f2c1f 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 26px rgba(15, 23, 42, 0.35);
}
.btn-place-order:active {
    transform: translateY(0);
}
.btn-place-order:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
.btn-place-order svg {
    margin-right: 6px;
    vertical-align: -2px;
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
    border-top: 1.5px solid #f1f5f9;
    display: flex;
    flex-direction: column;
    gap: 9px;
}
.trust-item {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 12px;
    color: #64748b;
    font-weight: 500;
}
.trust-icon {
    font-size: 14px;
}

/* Tablet & Mobile Responsiveness */
@media (max-width: 960px) {
    .checkout-grid {
        grid-template-columns: 100%;
        gap: 20px;
    }
    .checkout-summary-card {
        position: static;
        top: auto;
    }
}

@media (max-width: 640px) {
    .checkout-page-container {
        padding: 16px 0 96px 0;
    }
    .checkout-inner {
        padding: 0 12px;
    }
    .checkout-breadcrumbs {
        font-size: 12px;
        padding: 5px 12px;
        margin-bottom: 14px;
        gap: 6px;
    }
    .checkout-heading-box {
        margin-bottom: 18px;
    }
    .checkout-eyebrow {
        font-size: 10.5px;
        padding: 4px 10px;
    }
    .checkout-title {
        font-size: 22px;
        margin-bottom: 4px;
    }
    .checkout-subtitle {
        font-size: 13px;
    }
    .checkout-card {
        padding: 18px 14px;
        border-radius: 18px;
        margin-bottom: 16px;
    }
    .checkout-card-header {
        margin-bottom: 14px;
        padding-bottom: 12px;
        gap: 10px;
    }
    .card-step-badge {
        width: 32px;
        height: 32px;
        font-size: 14px;
        border-radius: 10px;
    }
    .card-step-title {
        font-size: 15px;
    }
    .checkout-fields-grid {
        grid-template-columns: 100%;
        gap: 12px;
    }
    .checkout-input, .checkout-select, .checkout-textarea {
        font-size: 13.5px;
        padding: 11px 12px;
        border-radius: 12px;
    }
    .payment-option-card {
        padding: 14px 12px;
        border-radius: 14px;
        gap: 10px;
    }
    .payment-brand {
        font-size: 13.5px;
    }
    .payment-desc {
        font-size: 12px;
    }
    .checkout-summary-card {
        padding: 18px 14px;
        border-radius: 18px;
    }
    .grand-total-num {
        font-size: 22px;
    }
    .btn-place-order {
        padding: 14px 16px;
        font-size: 14px;
    }
    .checkout-trust-box {
        margin-top: 14px;
        padding-top: 12px;
        gap: 8px;
    }
    .trust-item {
        font-size: 11.5px;
    }
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
    @if(!empty($directItem))
        // Direct Buy Item from server
        const directFromPhp = @json($directItem);
        currentCartItems = [directFromPhp];
        try {
            localStorage.setItem('dara-market-cart', JSON.stringify({
                count: directFromPhp.quantity,
                total: directFromPhp.price * directFromPhp.quantity,
                items: [directFromPhp]
            }));
            localStorage.setItem('dara_store_cart_items', JSON.stringify([directFromPhp]));
        } catch (e) {}
    @else
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
    @endif

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

    const khrEl = document.getElementById('summaryTotalKhr');
    if (khrEl) {
        const rate = {{ (float)($settings['exchange_rate'] ?? 4100) }};
        const khrAmount = Math.round(grandTotal * rate);
        khrEl.textContent = '≈ ' + khrAmount.toLocaleString() + ' ៛ (KHR)';
    }
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
