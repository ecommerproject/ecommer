@extends('store.layouts.app')

@section('title', ($locale === 'km' ? 'ការកុម្ម៉ង់ជោគជ័យ' : 'Order Confirmed') . ' #' . $order->order_number . ' | Dara Market')

@section('content')
<div class="order-success-page">
    <div class="container success-inner">
        <!-- Confirmed Hero Header -->
        <div class="success-hero-card">
            <div class="success-badge-icon">
                <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="#16a34a" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h1 class="success-title">{{ $locale === 'km' ? 'ការកុម្ម៉ង់របស់អ្នកទទួលបានជោគជ័យ!' : 'Thank You! Your Order is Confirmed' }}</h1>
            <p class="success-sub">
                {{ $locale === 'km' ? 'លេខសម្គាល់ការកុម្ម៉ង់ (Order ID):' : 'Order ID Number:' }}
                <strong class="order-id-tag">#{{ $order->order_number }}</strong>
                <button type="button" class="btn-copy-order-id" onclick="copyOrderNumber('{{ $order->order_number }}')" title="ចម្លងលេខកុម្ម៉ង់">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    <span id="copyOrderLabel">ចម្លង</span>
                </button>
            </p>
            <div class="success-quick-status">
                <span class="status-dot"></span>
                <span>{{ $locale === 'km' ? 'ស្ថានភាព៖ ' : 'Status: ' }}<strong>{{ ucfirst($order->order_status) }} ({{ $order->payment_status === 'paid' ? 'Paid / បានទូទាត់' : 'Payment on Delivery / Awaiting Payment' }})</strong></span>
            </div>
        </div>

        @php
            $isPaid = $order->payment_status === 'paid';
            $st = $order->order_status; // pending, processing, shipped, delivered, cancelled
            $isPackingDone = in_array($st, ['shipped', 'delivered']);
            $isPackingActive = ($st === 'processing');
            $isDeliveryDone = ($st === 'delivered');
            $isDeliveryActive = ($st === 'shipped');
        @endphp
        <!-- NEW: Interactive 4-Step Order Progress Stepper -->
        <div class="order-stepper-card">
            <div class="stepper-track">
                <!-- Step 1: Placed -->
                <div class="step-node is-done">
                    <div class="step-icon-wrap">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div class="step-text">
                        <strong class="step-label">{{ $locale === 'km' ? 'បានកុម្ម៉ង់' : 'Order Placed' }}</strong>
                        <small class="step-time">{{ $order->created_at ? $order->created_at->format('h:i A') : 'Today' }}</small>
                    </div>
                </div>

                <div class="step-connector {{ $isPaid ? 'is-done' : 'is-active' }}"></div>

                <!-- Step 2: Payment -->
                <div class="step-node {{ $isPaid ? 'is-done' : 'is-active' }}">
                    <div class="step-icon-wrap">
                        @if($isPaid)
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        @else
                            <span class="step-num-icon">2</span>
                        @endif
                    </div>
                    <div class="step-text">
                        <strong class="step-label">{{ $locale === 'km' ? 'ទូទាត់ប្រាក់' : 'Payment' }}</strong>
                        <small class="step-time" id="stepperPaymentStatus">{{ $isPaid ? ($locale === 'km' ? 'រួចរាល់' : 'Paid') : ($locale === 'km' ? 'រង់ចាំស្កេន' : 'Pending') }}</small>
                    </div>
                </div>

                <div class="step-connector {{ $isPackingDone ? 'is-done' : ($isPackingActive ? 'is-active' : '') }}"></div>

                <!-- Step 3: Packing -->
                <div class="step-node {{ $isPackingDone ? 'is-done' : ($isPackingActive ? 'is-active' : '') }}">
                    <div class="step-icon-wrap">
                        @if($isPackingDone)
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        @else
                            <span class="step-num-icon">3</span>
                        @endif
                    </div>
                    <div class="step-text">
                        <strong class="step-label">{{ $locale === 'km' ? 'រៀបចំទំនិញ' : 'Packaging' }}</strong>
                        <small class="step-time">{{ $isPackingDone ? ($locale === 'km' ? 'បានវេចខ្ចប់' : 'Packed') : ($isPackingActive ? ($locale === 'km' ? 'កំពុងរៀបចំ' : 'In Progress') : ($locale === 'km' ? 'ដំណាក់កាលបន្ទាប់' : 'Next Step')) }}</small>
                    </div>
                </div>

                <div class="step-connector {{ $isDeliveryDone ? 'is-done' : ($isDeliveryActive ? 'is-active' : '') }}"></div>

                <!-- Step 4: Out for delivery -->
                <div class="step-node {{ $isDeliveryDone ? 'is-done' : ($isDeliveryActive ? 'is-active' : '') }}">
                    <div class="step-icon-wrap">
                        @if($isDeliveryDone)
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        @else
                            <span class="step-num-icon">4</span>
                        @endif
                    </div>
                    <div class="step-text">
                        <strong class="step-label">{{ $locale === 'km' ? 'ដឹកជញ្ជូន' : 'Delivery' }}</strong>
                        <small class="step-time">{{ $isDeliveryDone ? ($locale === 'km' ? 'បានដឹកដល់ដៃ' : 'Delivered') : ($isDeliveryActive ? ($locale === 'km' ? 'កំពុងដឹកជញ្ជូន' : 'On the Way') : '2 - 4 hours') }}</small>
                    </div>
                </div>
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
                                        <h4 class="ordered-item-name">{!! html_entity_decode($item['name']) !!}</h4>
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
                <div class="success-actions-wrap">
                    <button type="button" onclick="openTrackOrderModalWithCode('{{ $order->order_number }}', '{{ $order->customer_phone }}')" class="btn-primary-action">
                        🚚 {{ $locale === 'km' ? 'តាមដានការដឹកជញ្ជូន (Track Order)' : 'Track Order' }}
                    </button>
                    <div class="success-actions-row">
                        <a href="{{ route('store.home') }}" class="btn-sec-action">
                            🏠 {{ $locale === 'km' ? 'ត្រឡប់ទៅទំព័រដើម' : 'Home' }}
                        </a>
                        <a href="{{ route('account.show') }}#orders" class="btn-sec-action">
                            👤 {{ $locale === 'km' ? 'ប្រវត្តិបញ្ជាទិញ' : 'My Orders' }}
                        </a>
                        <button type="button" class="btn-sec-action btn-invoice-action" onclick="openInvoicePreviewModal()">
                            📄 {{ $locale === 'km' ? 'មើលវិក្កយបត្រ' : 'Preview' }}
                        </button>
                        <button type="button" class="btn-sec-action btn-print-highlight" onclick="printOfficialInvoice()">
                            🖨️ {{ $locale === 'km' ? 'បោះពុម្ពវិក្កយបត្រ' : 'Print' }}
                        </button>
                    </div>
                </div>

                <!-- NEW: Fast Customer Support Assistance Card -->
                <div class="support-contact-banner">
                    <div class="support-left">
                        <span class="support-icon-ring">💬</span>
                        <div>
                            <strong>{{ $locale === 'km' ? 'ត្រូវការជំនួយ ឬចង់សាកសួរព័ត៌មានបន្ថែម?' : 'Need Help With Your Order?' }}</strong>
                            <p>{{ $locale === 'km' ? 'ទាក់ទងមកក្រុមការងារយើងភ្លាមៗតាម Telegram ឬទូរស័ព្ទដៃ' : 'Reach our direct customer care team via Telegram or Hotline' }}</p>
                        </div>
                    </div>
                    <div class="support-actions">
                        <a href="https://t.me/daramarket" target="_blank" class="btn-telegram-support" title="Chat on Telegram">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.52 2.77-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                            <span>Telegram</span>
                        </a>
                        <a href="tel:0714504547" class="btn-hotline-support" title="Call Hotline">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span>071 450 4547</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive ABA KHQR Scan Card & Proof Upload -->
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
                        <!-- Live Expiry Countdown Timer -->
                        <div class="khqr-timer-pill" id="khqrTimerWrapper" title="រយៈពេលសុពលភាពនៃកូដស្កេន">
                            <span class="timer-pulse-dot"></span>
                            <span class="timer-text">{{ $locale === 'km' ? 'សុពលភាព QR៖' : 'QR Valid:' }} <strong id="khqrCountdown">15:00</strong></span>
                        </div>

                        <div class="merchant-name-title">{{ $settings['store_name_km'] ?? $settings['store_name_en'] ?? 'DARA MARKET STORE' }}</div>
                        <div class="khqr-amount-display">${{ number_format($order->total_amount, 2) }}</div>
                        <div class="khqr-amount-khr">≈ {{ number_format($totalKhr) }} KHR (៛)</div>
                        <small class="currency-tag">{{ $locale === 'km' ? 'ស្កេនទូទាត់បានទាំងប្រាក់ដុល្លារ ($) និងប្រាក់រៀល (៛)' : 'Accepts both USD ($) and KHR (៛)' }}</small>

                        <!-- Dynamic Genuine NBC KHQR Code with Zoom Lightbox Trigger -->
                        <div class="qr-code-box" onclick="openQrLightbox()" title="{{ $locale === 'km' ? 'ចុចដើម្បីពង្រីក QR ឱ្យធំ' : 'Click to enlarge QR Code' }}">
                            <img
                                src="{{ $khqrImageUrl }}"
                                alt="ABA KHQR Code"
                                id="khqrActualImage"
                                class="actual-qr-image"
                            >
                            <div class="qr-center-logo">
                                <span>KHQR</span>
                            </div>
                            <span class="qr-zoom-hint">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                                {{ $locale === 'km' ? 'ពង្រីក' : 'Enlarge' }}
                            </span>
                        </div>

                        <!-- Bank & Account Detail Strip -->
                        <div class="merchant-bank-box">
                            <div class="bank-row">
                                <span class="bank-lbl">{{ $locale === 'km' ? 'ធនាគារ (Bank):' : 'Bank:' }}</span>
                                <strong class="bank-val">ABA Bank (KHQR)</strong>
                            </div>
                            <div class="bank-row">
                                <span class="bank-lbl">{{ $locale === 'km' ? 'លេខគណនី (Acc No):' : 'Acc No:' }}</span>
                                <strong class="bank-val" id="bankAccNumberText">{{ $settings['aba_account_number'] ?? '001 888 999' }}</strong>
                                <button type="button" class="btn-copy-acc" onclick="copyBankAccountNumber()" title="ចម្លងលេខកុង">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    <span id="copyAccLabel">ចម្លង</span>
                                </button>
                            </div>
                            <div class="bank-row">
                                <span class="bank-lbl">{{ $locale === 'km' ? 'ម្ចាស់គណនី (Name):' : 'Name:' }}</span>
                                <span class="bank-val font-semibold">{{ $settings['aba_account_name'] ?? 'DARA MARKET CO., LTD' }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons: Download QR & Save Image -->
                        <div class="khqr-actions-row">
                            <a href="{{ $khqrImageUrl }}" download="DARA_MARKET_KHQR_{{ $order->order_number }}.png" target="_blank" class="btn-qr-action">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>{{ $locale === 'km' ? 'ទាញយករូប QR' : 'Save QR Image' }}</span>
                            </a>
                            <button type="button" class="btn-qr-action secondary" onclick="openQrLightbox()">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <span>{{ $locale === 'km' ? 'ពង្រីកស្កេន' : 'Full Screen' }}</span>
                            </button>
                        </div>

                        <div class="qr-scan-instructions">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:-2px; margin-right:4px;"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                            <span>{{ $locale === 'km' ? 'បើកកម្មវិធីធនាគារណាមួយខាងក្រោមដើម្បីស្កេន៖' : 'Scan with any of these Mobile Banking apps:' }}</span>
                        </div>

                        <!-- Interactive Banking App Pills with Tip Popover -->
                        <div class="bank-logos-row">
                            <span class="b-pill aba" onclick="showBankTip('ABA Mobile')">ABA Mobile</span>
                            <span class="b-pill bakong" onclick="showBankTip('Bakong')">Bakong</span>
                            <span class="b-pill wing" onclick="showBankTip('Wing')">Wing</span>
                            <span class="b-pill acleda" onclick="showBankTip('ACLEDA')">ACLEDA</span>
                        </div>

                        <div class="payment-status-pill {{ $order->payment_status === 'paid' ? 'is-paid' : 'is-pending' }}" id="paymentStatusBadge">
                            @if($order->payment_status === 'paid')
                                <span class="chk">✓</span> {{ $locale === 'km' ? 'ការទូទាត់ត្រូវបានបញ្ជាក់ជោគជ័យ' : 'Payment Confirmed' }}
                            @else
                                <span class="wait">⏳</span> {{ $locale === 'km' ? 'រង់ចាំការទូទាត់ / រង់ចាំផ្ញើបង្កាន់ដៃ' : 'Awaiting Payment Confirmation' }}
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Proof of Payment / Receipt Upload Card -->
                <div class="receipt-upload-card" id="receiptUploadCard">
                    <div class="card-head-row">
                        <span class="card-icon">🧾</span>
                        <h3 class="card-sec-title">{{ $locale === 'km' ? 'ផ្ញើបង្កាន់ដៃបង់ប្រាក់ (Payment Receipt)' : 'Upload Payment Slip' }}</h3>
                    </div>

                    @if(!empty($order->payment_proof))
                        <div class="receipt-success-view">
                            <div class="receipt-approved-alert">
                                <span>✓</span>
                                <div>
                                    <strong>{{ $locale === 'km' ? 'បានទទួលបង្កាន់ដៃបង់ប្រាក់រួចរាល់!' : 'Payment Receipt Submitted!' }}</strong>
                                    <p>{{ $locale === 'km' ? 'ក្រុមការងារកំពុងត្រួតពិនិត្យ និងរៀបចំទំនិញដឹកជញ្ជូនជូនអ្នក។' : 'Our team is preparing your package for fast delivery.' }}</p>
                                </div>
                            </div>
                            <div class="receipt-preview-wrap">
                                <a href="{{ $order->payment_proof }}" target="_blank" title="ចុចដើម្បីមើលរូបធំ">
                                    <img src="{{ $order->payment_proof }}" alt="Payment Receipt" class="receipt-slip-img">
                                </a>
                            </div>
                            @if($order->transaction_ref)
                                <div class="receipt-ref-display">
                                    <span>លេខប្រតិបត្តិការ (Ref ID):</span>
                                    <strong>#{{ $order->transaction_ref }}</strong>
                                </div>
                            @endif
                        </div>
                    @else
                        <form id="receiptUploadForm" onsubmit="submitPaymentReceipt(event)" enctype="multipart/form-data">
                            @csrf
                            <p class="receipt-instructions">
                                {{ $locale === 'km' ? 'បន្ទាប់ពីស្កេនទូទាត់តាម ABA ឬ Bakong រួចរាល់ សូមភ្ជាប់រូបភាពបង្កាន់ដៃ (Screenshot) នៅទីនេះ៖' : 'After completing payment via your banking app, please upload the transaction screenshot below:' }}
                            </p>

                            <div class="upload-dropzone" id="dropzoneBox" onclick="document.getElementById('receiptFileInput').click()">
                                <input type="file" id="receiptFileInput" name="payment_proof" accept="image/*,.pdf" style="display:none;" onchange="handleReceiptFileSelect(this)" required>
                                
                                <div class="dropzone-inner" id="dropzonePrompt">
                                    <div class="dropzone-icon-ring">
                                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="#245943" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                    </div>
                                    <span class="dropzone-text"><strong>{{ $locale === 'km' ? 'ចុចជ្រើសរើសរូបបង្កាន់ដៃ (ឬទម្លាក់រូបទីនេះ)' : 'Click to select screenshot or drag & drop' }}</strong></span>
                                    <small>{{ $locale === 'km' ? 'គាំទ្រ JPG, PNG, WEBP (អតិបរមា 10MB)' : 'Supports JPG, PNG, WEBP (Max 10MB)' }}</small>
                                </div>

                                <div class="dropzone-preview" id="dropzonePreview" style="display:none;">
                                    <img src="" id="slipPreviewImg" alt="Receipt preview">
                                    <div class="preview-meta">
                                        <span id="slipFileName"></span>
                                        <button type="button" class="btn-remove-slip" onclick="removeSelectedSlip(event)">✕ {{ $locale === 'km' ? 'ប្តូររូបថ្មី' : 'Change' }}</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 14px; margin-bottom: 14px;">
                                <label for="trans_ref" style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 5px;">
                                    <span>{{ $locale === 'km' ? 'លេខកូដប្រតិបត្តិការ (Transaction ID / Ref)' : 'Transaction ID / Ref Number' }}</span>
                                    <span style="font-weight: normal; color: #94a3b8;">{{ $locale === 'km' ? 'មិនទាមទារ' : 'Optional' }}</span>
                                </label>
                                <input
                                    type="text"
                                    id="trans_ref"
                                    name="transaction_ref"
                                    class="checkout-input"
                                    placeholder="{{ $locale === 'km' ? 'ឧ. 102938475 ឬ 0714504547' : 'e.g. 102938475' }}"
                                    style="padding: 10px 14px; font-size: 13.5px; border-radius: 8px;"
                                >
                            </div>

                            <button type="submit" id="btnSubmitReceipt" class="btn-submit-receipt">
                                <span class="btn-text">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:-2px; margin-right:6px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    {{ $locale === 'km' ? 'បញ្ជាក់ការបង់ប្រាក់ឥឡូវនេះ (Submit Receipt)' : 'Submit Proof of Payment' }}
                                </span>
                                <span class="btn-spinner" style="display:none;">
                                    <svg class="spin-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"></path></svg>
                                    {{ $locale === 'km' ? 'កំពុងផ្ញើ...' : 'Uploading...' }}
                                </span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================
     QR LIGHTBOX MODAL (ENLARGED QR CODE)
     ======================================================== -->
<div id="qrLightboxModal" class="qr-lightbox-backdrop" onclick="closeQrLightbox(event)">
    <div class="qr-lightbox-box">
        <div class="qr-lightbox-header">
            <div class="lightbox-title-wrap">
                <span class="lightbox-khqr-tag">KHQR</span>
                <strong>{{ $settings['store_name_km'] ?? 'ផ្សារតារា' }} · ${{ number_format($order->total_amount, 2) }}</strong>
            </div>
            <button type="button" class="lightbox-close-btn" onclick="closeQrLightbox()">✕</button>
        </div>
        <div class="qr-lightbox-body">
            <div class="qr-lightbox-zoom-wrap">
                <img src="{{ $khqrImageUrl }}" alt="KHQR Large" class="qr-lightbox-img">
                <div class="qr-lightbox-center-badge">KHQR</div>
            </div>
            <div class="qr-lightbox-amount-row">
                <span class="lightbox-usd">${{ number_format($order->total_amount, 2) }}</span>
                <span class="lightbox-khr">≈ {{ number_format($totalKhr) }} ៛</span>
            </div>
            <p class="qr-lightbox-instructions">
                {{ $locale === 'km' ? 'ស្កេនដោយផ្ទាល់ជាមួយកម្មវិធី ABA, Bakong, Wing, ACLEDA ឬកម្មវិធីធនាគារផ្សេងៗក្នុងប្រទេសកម្ពុជា' : 'Scan directly with any Cambodian Mobile Banking application' }}
            </p>
            <div class="lightbox-actions">
                <a href="{{ $khqrImageUrl }}" download="KHQR_{{ $order->order_number }}.png" class="btn-lightbox-download">
                    📥 {{ $locale === 'km' ? 'ទាញយករូបភាព QR' : 'Save QR Image' }}
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================================
     INVOICE PREVIEW MODAL (ON SCREEN INTERACTION)
     ========================================================== -->
<div id="invoicePreviewModal" class="invoice-preview-backdrop" style="display: none;" onclick="if(event.target===this) closeInvoicePreviewModal()">
    <div class="invoice-preview-dialog">
        <div class="invoice-preview-topbar">
            <div class="preview-topbar-title">
                <span class="preview-doc-icon">📄</span>
                <div class="preview-title-wrap">
                    <strong>{{ $locale === 'km' ? 'គំរូវិក្កយបត្រផ្លូវការ' : 'Official Commercial Invoice' }}</strong>
                    <span class="preview-ord-tag">#{{ $order->order_number }}</span>
                </div>
            </div>
            <div class="preview-topbar-actions">
                <button type="button" class="btn-modal-print-action desktop-print-btn" onclick="printOfficialInvoice()">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>{{ $locale === 'km' ? 'បោះពុម្ព / PDF' : 'Print / PDF' }}</span>
                </button>
                <button type="button" class="btn-modal-close-icon" onclick="closeInvoicePreviewModal()" aria-label="Close">✕</button>
            </div>
        </div>
        <div class="invoice-preview-body">
            <div class="invoice-paper-sheet">
                @include('store.pages.partials.official-invoice', ['order' => $order, 'settings' => $settings, 'totalKhr' => $totalKhr, 'locale' => $locale])
            </div>
        </div>
        <!-- Mobile Sticky Bottom Floating Action Bar -->
        <div class="invoice-preview-mobile-footer">
            <button type="button" class="btn-mobile-floating-print" onclick="printOfficialInvoice()">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>{{ $locale === 'km' ? 'បោះពុម្ពវិក្កយបត្រ (Print / Save as PDF)' : 'Print / Save as PDF' }}</span>
            </button>
        </div>
    </div>
</div>

<!-- ==========================================================
     STANDALONE PRINTABLE INVOICE (TARGETED BY @MEDIA PRINT)
     ========================================================== -->
<div id="printableInvoice" class="official-invoice-sheet" style="display: none;">
    @include('store.pages.partials.official-invoice', ['order' => $order, 'settings' => $settings, 'totalKhr' => $totalKhr, 'locale' => $locale])
</div>

<!-- Confetti Canvas for Celebration -->
<canvas id="confettiCanvas" style="position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:999999; display:none;"></canvas>

<!-- Interactive Toast Element -->
<div id="successToast" class="success-interactive-toast" style="display:none;">
    <span class="toast-icon">✓</span>
    <span class="toast-message" id="toastMessage">បានចម្លងជោគជ័យ!</span>
</div>

<style>
/* ==========================================================
   ORDER SUCCESS PAGE STYLING (MODERN LUXURY & MOBILE FIRST)
   ========================================================== */
.order-success-page {
    background: #f8faf9;
    padding: 24px 0 100px 0;
    min-height: 85vh;
    box-sizing: border-box;
    width: 100%;
    overflow-x: hidden;
}
.success-inner {
    max-width: 1060px;
    margin: 0 auto;
    padding: 0 16px;
    box-sizing: border-box;
    width: 100%;
    min-width: 0;
}

/* Confirmed Hero Header */
.success-hero-card {
    background: linear-gradient(180deg, #ffffff 0%, #f4fbf6 100%);
    border: 1.5px solid #bbf7d0;
    border-radius: 20px;
    padding: 26px 20px;
    text-align: center;
    margin-bottom: 20px;
    box-shadow: 0 4px 20px rgba(16, 41, 31, 0.05);
    position: relative;
    overflow: hidden;
    box-sizing: border-box;
    width: 100%;
}
.success-hero-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #10b981, #059669, #047857);
}
.success-badge-icon {
    width: 58px;
    height: 58px;
    background: #dcfce7;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    box-shadow: 0 4px 14px rgba(22, 163, 74, 0.18);
}
.success-title {
    font-size: 23px;
    font-weight: 800;
    color: #10291f;
    margin: 0 0 8px 0;
    letter-spacing: -0.01em;
    line-height: 1.35;
}
.success-sub {
    font-size: 13.5px;
    color: #64748b;
    margin: 0 0 12px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}
.order-id-tag {
    color: #10291f;
    background: #eef6f1;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 14.5px;
    font-weight: 800;
    border: 1.5px solid #a7f3d0;
}
.btn-copy-order-id {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
}
.btn-copy-order-id:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #94a3b8;
}
.success-quick-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12.5px;
    color: #15803d;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    padding: 6px 16px;
    border-radius: 999px;
    font-weight: 600;
    max-width: 100%;
    box-sizing: border-box;
}
.status-dot {
    width: 8px;
    height: 8px;
    background: #16a34a;
    border-radius: 50%;
    animation: successPulse 2s infinite;
    flex-shrink: 0;
}
@keyframes successPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.3; transform: scale(1.3); }
}

/* ==========================================================
   ORDER STEPPER TRACKER
   ========================================================== */
.order-stepper-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 18px 22px;
    margin-bottom: 22px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    box-sizing: border-box;
    width: 100%;
}
.stepper-track {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    width: 100%;
    box-sizing: border-box;
}
.step-node {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
    z-index: 2;
    flex-shrink: 0;
}
.step-icon-wrap {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f8fafc;
    color: #64748b;
    display: grid;
    place-items: center;
    font-size: 12px;
    font-weight: 800;
    border: 2px solid #e2e8f0;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.step-node.is-done .step-icon-wrap {
    background: #10b981;
    color: #ffffff;
    border-color: #10b981;
}
.step-node.is-active .step-icon-wrap {
    background: #245943;
    color: #ffffff;
    border-color: #245943;
    box-shadow: 0 0 0 4px rgba(36, 89, 67, 0.18);
    animation: activeStepPulse 2s infinite;
}
@keyframes activeStepPulse {
    0%, 100% { box-shadow: 0 0 0 4px rgba(36, 89, 67, 0.18); }
    50% { box-shadow: 0 0 0 8px rgba(36, 89, 67, 0.08); }
}
.step-text {
    display: flex;
    flex-direction: column;
}
.step-label {
    font-size: 13px;
    color: #1e293b;
    font-weight: 700;
}
.step-time {
    font-size: 11px;
    color: #64748b;
}
.step-connector {
    flex: 1;
    height: 2px;
    background: #e2e8f0;
    margin: 0 10px;
    position: relative;
}
.step-connector.is-done {
    background: #10b981;
}
.step-connector.is-active {
    background: linear-gradient(90deg, #10b981 0%, #245943 100%);
}

@media (max-width: 640px) {
    .order-stepper-card {
        padding: 18px 8px 18px 8px;
        border-radius: 18px;
        margin-bottom: 20px;
        height: auto;
    }
    .stepper-track {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        position: relative;
        width: 100%;
        box-sizing: border-box;
    }
    .stepper-track::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 12%;
        right: 12%;
        height: 2px;
        background: #e2e8f0;
        z-index: 1;
    }
    .step-connector {
        display: none;
    }
    .step-node {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 6px;
        position: relative;
        z-index: 2;
        border: none !important;
        border-radius: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
    .step-icon-wrap {
        width: 28px !important;
        height: 28px !important;
        border-radius: 50% !important;
        font-size: 10px;
        margin: 0 auto;
        background: #ffffff;
        border-width: 2px;
        flex-shrink: 0 !important;
    }
    .step-text {
        align-items: center;
        text-align: center;
        width: 100%;
    }
    .step-label {
        font-size: 10.5px;
        line-height: 1.25;
        white-space: normal;
        text-align: center;
        color: #1e293b;
        font-weight: 700;
    }
    .step-time {
        font-size: 9px;
        color: #64748b;
        margin-top: 2px;
        display: block;
    }
}

/* ==========================================================
   CONTENT GRID
   ========================================================== */
.success-content-grid {
    display: grid;
    grid-template-columns: 1.24fr 1fr;
    gap: 22px;
    align-items: start;
    width: 100%;
    min-width: 0;
    box-sizing: border-box;
}
@media (max-width: 880px) {
    .success-content-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }
}
.success-left-col,
.success-right-col {
    min-width: 0;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

.success-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 16px rgba(16, 41, 31, 0.04);
    box-sizing: border-box;
    width: 100%;
    min-width: 0;
}
@media (max-width: 640px) {
    .success-card {
        padding: 16px 14px;
        border-radius: 16px;
    }
}
.card-head-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
}
.card-icon {
    font-size: 18px;
}
.card-sec-title {
    font-size: 15px;
    font-weight: 700;
    color: #10291f;
    margin: 0;
    flex: 1;
}
.items-count-badge {
    font-size: 11px;
    font-weight: 700;
    color: #166534;
    background: #eef6f1;
    padding: 3px 10px;
    border-radius: 999px;
    border: 1px solid #c2e0cf;
}
.recipient-details {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.detail-row {
    display: flex;
    font-size: 13.5px;
    gap: 8px;
    align-items: flex-start;
}
.detail-label {
    width: 90px;
    color: #64748b;
    flex-shrink: 0;
    font-size: 12.5px;
}
.detail-val {
    color: #1e293b;
    font-weight: 500;
    flex: 1;
    min-width: 0;
    word-break: break-word;
}
.detail-val.text-phone {
    font-weight: 800;
    color: #15803d;
}
.detail-val.italic {
    font-style: italic;
    color: #475569;
}

/* Purchased Items */
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
    padding-bottom: 12px;
    border-bottom: 1px dashed #e2e8f0;
}
.ordered-item-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.ordered-item-thumb {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    object-fit: cover;
    background: #f8fafc;
    flex-shrink: 0;
    border: 1px solid #e2e8f0;
}
.ordered-item-info {
    flex: 1;
    min-width: 0;
}
.ordered-item-name {
    font-size: 13.5px;
    font-weight: 600;
    color: #10291f;
    margin: 0 0 3px 0;
    white-space: normal;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.ordered-item-unit {
    font-size: 12px;
    color: #64748b;
}
.ordered-item-total {
    font-size: 14.5px;
    font-weight: 800;
    color: #10291f;
    flex-shrink: 0;
    white-space: nowrap;
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
    font-size: 13.5px;
    color: #64748b;
    gap: 8px;
}
.inv-grand-total {
    font-size: 22px;
    font-weight: 800;
    color: #10291f;
    flex-shrink: 0;
}
.inv-payment-badge {
    background: #eef6f1;
    color: #166534;
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 12px;
    border: 1px solid #bbf7d0;
}

/* Action Buttons */
.success-actions-wrap {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
    width: 100%;
    box-sizing: border-box;
}
.btn-primary-action {
    width: 100%;
    box-sizing: border-box;
    background: linear-gradient(135deg, #10291f 0%, #245943 100%);
    color: #ffffff;
    padding: 13px 18px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(16, 41, 31, 0.2);
    transition: all 0.2s ease;
}
.btn-primary-action:hover {
    background: linear-gradient(135deg, #163d2e 0%, #2c6e53 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(36, 89, 67, 0.25);
}
.success-actions-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
    width: 100%;
    box-sizing: border-box;
}
@media (min-width: 768px) {
    .success-actions-row {
        grid-template-columns: repeat(4, 1fr);
    }
}
.btn-sec-action {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #334155;
    padding: 10px 8px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    text-align: center;
    transition: all 0.2s ease;
    box-sizing: border-box;
}
.btn-sec-action:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #0f172a;
}

/* Customer Support Banner */
.support-contact-banner {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    box-shadow: 0 4px 14px rgba(0,0,0,0.02);
    box-sizing: border-box;
    width: 100%;
}
.support-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.support-icon-ring {
    width: 40px;
    height: 40px;
    background: #eef6f1;
    border-radius: 50%;
    display: grid;
    place-items: center;
    font-size: 20px;
    flex-shrink: 0;
}
.support-left strong {
    display: block;
    font-size: 13.5px;
    color: #10291f;
}
.support-left p {
    margin: 2px 0 0 0;
    font-size: 12px;
    color: #64748b;
}
.support-actions {
    display: flex;
    gap: 8px;
}
.btn-telegram-support {
    background: #0088cc;
    color: #ffffff;
    padding: 9px 14px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}
.btn-telegram-support:hover {
    background: #0077b5;
    color: #ffffff;
}
.btn-hotline-support {
    background: #245943;
    color: #ffffff;
    padding: 9px 14px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}
.btn-hotline-support:hover {
    background: #173e2c;
    color: #ffffff;
}
@media (max-width: 640px) {
    .support-contact-banner {
        flex-direction: column;
        align-items: stretch;
        padding: 16px 14px;
        border-radius: 16px;
    }
    .support-actions {
        width: 100%;
        margin-top: 6px;
    }
    .btn-telegram-support,
    .btn-hotline-support {
        flex: 1;
        justify-content: center;
    }
}

/* ==========================================================
   AUTHENTIC BAKONG KHQR CARD
   ========================================================== */
.khqr-interactive-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(16, 41, 31, 0.06);
    border: 1px solid #e2e8f0;
    position: relative;
    margin-bottom: 20px;
    box-sizing: border-box;
    width: 100%;
}
.khqr-header-strip {
    background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
    color: #ffffff;
    padding: 14px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(225, 29, 72, 0.25);
}
.khqr-branding {
    display: flex;
    align-items: baseline;
    gap: 8px;
}
.khqr-tag {
    font-size: 20px;
    font-weight: 900;
    letter-spacing: 0.08em;
}
.khqr-tag-sub {
    font-size: 11.5px;
    opacity: 0.95;
    font-weight: 500;
}
.aba-pill-logo {
    background: #ffffff;
    color: #004d71;
    font-size: 12px;
    font-weight: 900;
    padding: 3px 10px;
    border-radius: 6px;
    letter-spacing: 0.05em;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
.khqr-body {
    padding: 20px 16px 22px 16px;
    text-align: center;
    box-sizing: border-box;
    width: 100%;
}

/* Timer Pill */
.khqr-timer-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff1f2;
    border: 1px solid #fecdd3;
    color: #e11d48;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px;
    margin-bottom: 12px;
}
.timer-pulse-dot {
    width: 7px;
    height: 7px;
    background: #e11d48;
    border-radius: 50%;
    animation: successPulse 1.5s infinite;
}

.merchant-name-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #64748b;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}
.khqr-amount-display {
    font-size: 32px;
    font-weight: 900;
    color: #10291f;
    line-height: 1.1;
}
.khqr-amount-khr {
    font-size: 15px;
    font-weight: 700;
    color: #059669;
    margin-top: 4px;
}
.currency-tag {
    font-size: 11.5px;
    color: #94a3b8;
    display: block;
    margin-bottom: 16px;
}

/* QR Code Box */
.qr-code-box {
    position: relative;
    width: 210px;
    height: 210px;
    margin: 0 auto 16px auto;
    border: 2.5px solid #10291f;
    border-radius: 16px;
    padding: 6px;
    background: #ffffff;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    transition: all 0.25s ease;
    box-sizing: border-box;
    max-width: 100%;
}
.qr-code-box:hover {
    transform: scale(1.02);
    border-color: #245943;
    box-shadow: 0 8px 24px rgba(36, 89, 67, 0.18);
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
    width: 38px;
    height: 38px;
    background: #10291f;
    color: #ffffff;
    font-size: 11px;
    font-weight: 900;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2.5px solid #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
.qr-zoom-hint {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(16, 41, 31, 0.85);
    color: #ffffff;
    font-size: 10.5px;
    padding: 2px 6px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
    opacity: 0.85;
    pointer-events: none;
}
.qr-code-box:hover .qr-zoom-hint {
    opacity: 1;
    background: #10291f;
}

/* Merchant Bank Box */
.merchant-bank-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 12px 14px;
    margin-bottom: 14px;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 8px;
    box-sizing: border-box;
    width: 100%;
}
.bank-row {
    display: flex;
    align-items: center;
    font-size: 12.5px;
    gap: 8px;
}
.bank-lbl {
    color: #64748b;
    width: 100px;
    flex-shrink: 0;
}
.bank-val {
    color: #1e293b;
    flex: 1;
    min-width: 0;
    word-break: break-all;
}
.btn-copy-acc {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    transition: all 0.15s ease;
    flex-shrink: 0;
}
.btn-copy-acc:hover {
    background: #eef6f1;
    color: #245943;
    border-color: #245943;
}

/* KHQR Actions */
.khqr-actions-row {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
    width: 100%;
    box-sizing: border-box;
}
.btn-qr-action {
    flex: 1;
    background: #245943;
    color: #ffffff;
    padding: 10px 12px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    box-sizing: border-box;
}
.btn-qr-action:hover {
    background: #173e2c;
    color: #ffffff;
}
.btn-qr-action.secondary {
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #cbd5e1;
}
.btn-qr-action.secondary:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.qr-scan-instructions {
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 10px;
    line-height: 1.4;
}
.bank-logos-row {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}
.b-pill {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 999px;
    background: #f1f5f9;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s ease;
}
.b-pill:hover {
    transform: translateY(-1px);
}
.b-pill.aba { background: rgba(0,77,113,0.1); color: #004d71; }
.b-pill.aba:hover { background: #004d71; color: #ffffff; }
.b-pill.bakong { background: rgba(216,30,40,0.1); color: #d81e28; }
.b-pill.bakong:hover { background: #d81e28; color: #ffffff; }
.b-pill.wing { background: rgba(133,194,38,0.15); color: #4d7a0b; }
.b-pill.wing:hover { background: #85c226; color: #ffffff; }
.b-pill.acleda { background: rgba(14,57,116,0.1); color: #0e3974; }
.b-pill.acleda:hover { background: #0e3974; color: #ffffff; }

.payment-status-pill {
    display: block;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 700;
    transition: all 0.3s ease;
    box-sizing: border-box;
    width: 100%;
}
.payment-status-pill.is-pending {
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fde68a;
}
.payment-status-pill.is-paid {
    background: #f0fdf4;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

/* ==========================================================
   RECEIPT UPLOAD CARD (DRAG & DROP)
   ========================================================== */
.receipt-upload-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 20px 18px;
    box-shadow: 0 4px 16px rgba(16, 41, 31, 0.04);
    box-sizing: border-box;
    width: 100%;
}
@media (max-width: 640px) {
    .receipt-upload-card {
        padding: 16px 14px;
        border-radius: 16px;
    }
}
.receipt-instructions {
    font-size: 12.5px;
    color: #64748b;
    margin: 0 0 12px 0;
    line-height: 1.5;
}

.upload-dropzone {
    border: 2px dashed #94a3b8;
    border-radius: 14px;
    padding: 22px 14px;
    text-align: center;
    background: #f8fafc;
    cursor: pointer;
    transition: all 0.25s ease;
    position: relative;
    box-sizing: border-box;
    width: 100%;
}
.upload-dropzone:hover, .upload-dropzone.is-dragover {
    border-color: #10b981;
    background: #f0fdf4;
}
.dropzone-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}
.dropzone-icon-ring {
    width: 48px;
    height: 48px;
    background: #eef6f1;
    border-radius: 50%;
    display: grid;
    place-items: center;
    margin-bottom: 2px;
}
.dropzone-text {
    font-size: 13.5px;
    color: #1e293b;
    line-height: 1.4;
}
.dropzone-inner small {
    font-size: 11.5px;
    color: #94a3b8;
}
.dropzone-preview {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
#slipPreviewImg {
    max-height: 160px;
    max-width: 100%;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.preview-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12px;
    color: #475569;
}
.btn-remove-slip {
    background: #fee2e2;
    border: 1px solid #fca5a5;
    color: #b91c1c;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
}

.checkout-input {
    width: 100%;
    box-sizing: border-box;
    max-width: 100%;
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    transition: all 0.2s ease;
}
.checkout-input:focus {
    border-color: #10b981;
    outline: none;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
}

.btn-submit-receipt {
    width: 100%;
    box-sizing: border-box;
    background: linear-gradient(135deg, #10291f 0%, #245943 100%);
    color: #ffffff;
    border: none;
    padding: 14px 16px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(16, 41, 31, 0.18);
    margin-top: 10px;
    white-space: normal;
    text-align: center;
}
.btn-submit-receipt:hover:not(:disabled) {
    background: linear-gradient(135deg, #163d2e 0%, #2c6e53 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(36, 89, 67, 0.25);
}
.btn-submit-receipt:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
.spin-icon {
    animation: spin 1s linear infinite;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Submitted Receipt View */
.receipt-success-view {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.receipt-approved-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 12px 14px;
    font-size: 12.5px;
    color: #15803d;
}
.receipt-approved-alert span {
    font-size: 18px;
    font-weight: 900;
    color: #16a34a;
}
.receipt-approved-alert strong {
    display: block;
    font-size: 13.5px;
    margin-bottom: 2px;
}
.receipt-approved-alert p {
    margin: 0;
    color: #166534;
}
.receipt-preview-wrap {
    text-align: center;
}
.receipt-slip-img {
    max-height: 220px;
    max-width: 100%;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    cursor: pointer;
    transition: transform 0.2s ease;
}
.receipt-slip-img:hover {
    transform: scale(1.02);
}
.receipt-ref-display {
    font-size: 12.5px;
    color: #475569;
    text-align: center;
    background: #f8fafc;
    padding: 6px 12px;
    border-radius: 6px;
}

/* ==========================================================
   QR LIGHTBOX MODAL
   ========================================================== */
.qr-lightbox-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.qr-lightbox-box {
    background: #ffffff;
    border-radius: 20px;
    width: 100%;
    max-width: 420px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
    animation: zoomModalIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes zoomModalIn {
    from { opacity: 0; transform: scale(0.92); }
    to { opacity: 1; transform: scale(1); }
}
.qr-lightbox-header {
    background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
    color: #ffffff;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.lightbox-khqr-tag {
    background: #ffffff;
    color: #e11d48;
    font-weight: 900;
    font-size: 12px;
    padding: 2px 7px;
    border-radius: 4px;
    margin-right: 8px;
}
.lightbox-close-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: #ffffff;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 14px;
    display: grid;
    place-items: center;
}
.lightbox-close-btn:hover {
    background: rgba(255, 255, 255, 0.35);
}
.qr-lightbox-body {
    padding: 24px;
    text-align: center;
}
.qr-lightbox-zoom-wrap {
    position: relative;
    width: 260px;
    height: 260px;
    margin: 0 auto 16px auto;
    border: 3px solid #10291f;
    border-radius: 16px;
    padding: 8px;
    background: #ffffff;
}
.qr-lightbox-img {
    width: 100%;
    height: 100%;
    display: block;
}
.qr-lightbox-center-badge {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 44px;
    height: 44px;
    background: #10291f;
    color: #ffffff;
    font-size: 13px;
    font-weight: 900;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #ffffff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}
.qr-lightbox-amount-row {
    margin-bottom: 10px;
}
.lightbox-usd {
    font-size: 28px;
    font-weight: 900;
    color: #10291f;
    margin-right: 8px;
}
.lightbox-khr {
    font-size: 16px;
    font-weight: 700;
    color: #059669;
}
.qr-lightbox-instructions {
    font-size: 12.5px;
    color: #64748b;
    margin: 0 0 16px 0;
    line-height: 1.4;
}
.lightbox-actions {
    display: flex;
    justify-content: center;
}
.btn-lightbox-download {
    background: #245943;
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
}
.btn-lightbox-download:hover {
    background: #173e2c;
    color: #ffffff;
}

/* Toast */
.success-interactive-toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #10291f;
    color: #ffffff;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
    z-index: 9999999;
    animation: toastPop 0.25s ease;
}
@keyframes toastPop {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ==========================================================
   OFFICIAL INVOICE STYLING (MODAL & PRINT)
   ========================================================== */
.invoice-preview-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: fadeIn 0.2s ease;
}

.invoice-preview-dialog {
    background: #ffffff;
    width: 100%;
    max-width: 900px;
    max-height: 94vh;
    border-radius: 18px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

.invoice-preview-topbar {
    background: linear-gradient(135deg, #0d2a1c 0%, #173e2c 50%, #245943 100%);
    color: #ffffff;
    padding: 16px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 2px solid #d8a962;
    position: relative;
    z-index: 10;
}
.preview-topbar-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
}
.preview-doc-icon {
    font-size: 20px;
}
.preview-ord-tag {
    display: inline-block;
    background: rgba(255, 255, 255, 0.18);
    color: #ffffff;
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    margin-left: 6px;
    font-family: monospace;
}
.preview-topbar-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.btn-modal-print-action {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #ffffff;
    color: #064e3b;
    border: none;
    padding: 8px 18px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
.btn-modal-print-action:hover {
    background: #f0fdf4;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}
.btn-modal-close-icon {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.btn-modal-close-icon:hover {
    background: #ef4444;
    color: #ffffff;
}

.invoice-preview-body {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    background: #f1f5f9;
}

.invoice-paper-sheet {
    background: #ffffff;
    max-width: 820px;
    margin: 0 auto;
    padding: 36px 40px;
    border-radius: 10px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
    color: #0f172a;
    font-family: 'Kantumruy Pro', 'DM Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    font-size: 13px;
    line-height: 1.5;
}

/* Base Invoice Layout */
.inv-container-inner {
    width: 100%;
}
.inv-head-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
}
.inv-head-brand {
    flex: 1;
}
.inv-brand-logo-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
}
.inv-brand-symbol {
    font-size: 34px;
}
.inv-brand-names {
    display: flex;
    flex-direction: column;
}
.inv-brand-title {
    font-size: 24px;
    font-weight: 800;
    color: #064e3b;
    margin: 0;
    letter-spacing: 0.5px;
    line-height: 1.1;
}
.inv-brand-kh {
    font-size: 12px;
    color: #059669;
    font-weight: 600;
}
.inv-store-info {
    font-size: 11.5px;
    color: #475569;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.inv-info-item {
    display: flex;
    align-items: center;
    gap: 6px;
}
.inv-phone-highlight {
    font-weight: 700;
    color: #0f172a;
}

.inv-head-meta {
    width: 270px;
    text-align: right;
}
.inv-title-badge {
    background: #064e3b;
    color: #ffffff;
    padding: 8px 14px;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 8px;
}
.inv-badge-main {
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 1px;
}
.inv-badge-sub {
    font-size: 10px;
    font-weight: 600;
    opacity: 0.9;
    letter-spacing: 1.5px;
}
.inv-meta-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 14px;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 5px;
    font-size: 12px;
}
.meta-card-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.m-lbl {
    color: #64748b;
}
.m-val.text-ord {
    color: #064e3b;
    font-family: monospace;
    font-size: 13px;
    font-weight: 700;
}
.m-status-pill {
    font-size: 11px;
    padding: 2px 7px;
    border-radius: 5px;
    font-weight: 700;
}
.m-status-pill.is-paid {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #86efac;
}
.m-status-pill.is-unpaid {
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
}

.inv-decor-divider {
    height: 3px;
    background: linear-gradient(90deg, #064e3b 0%, #10b981 50%, #e2e8f0 100%);
    margin: 16px 0;
    border-radius: 2px;
}

.inv-parties-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 18px;
}
.inv-box-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 14px;
}
.inv-box-header {
    font-size: 12px;
    font-weight: 700;
    color: #064e3b;
    margin-bottom: 8px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.inv-box-body {
    display: flex;
    flex-direction: column;
    gap: 5px;
    font-size: 12px;
}
.box-row {
    display: flex;
    align-items: flex-start;
    gap: 6px;
}
.box-lbl {
    color: #64748b;
    min-width: 95px;
    flex-shrink: 0;
}
.box-val {
    color: #0f172a;
}
.box-val.text-phone {
    font-weight: 700;
    color: #064e3b;
}
.badge-order-st {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 11px;
    padding: 1px 6px;
    border-radius: 4px;
    font-weight: 600;
}

/* Items Table */
.inv-table-frame {
    margin-bottom: 18px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    overflow: hidden;
}
.inv-official-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}
.inv-official-table thead tr {
    background: #064e3b;
    color: #ffffff;
}
.inv-official-table th {
    padding: 9px 12px;
    font-weight: 700;
    font-size: 11.5px;
    letter-spacing: 0.3px;
    border: none;
}
.inv-official-table tbody tr {
    border-bottom: 1px solid #e2e8f0;
}
.inv-official-table tbody tr:nth-child(even) {
    background: #f8fafc;
}
.inv-official-table tbody tr:last-child {
    border-bottom: none;
}
.inv-official-table td {
    padding: 10px 12px;
    vertical-align: middle;
}
.col-num {
    text-align: center;
    width: 45px;
    color: #64748b;
}
.col-desc {
    text-align: left;
}
.col-qty {
    text-align: center;
    width: 85px;
}
.col-price {
    text-align: right;
    width: 110px;
    color: #475569;
}
.col-tot {
    text-align: right;
    width: 120px;
    color: #0f172a;
}
.item-name-txt {
    font-weight: 600;
    color: #0f172a;
}

/* Calculation & Payment Section */
.inv-calc-section {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 20px;
    page-break-inside: avoid;
}
.inv-calc-memo {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.inv-bank-box {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: 9px 12px;
}
.bank-head-title {
    font-size: 11.5px;
    font-weight: 700;
    color: #166534;
    margin-bottom: 4px;
}
.bank-grid {
    display: flex;
    flex-direction: column;
    gap: 3px;
    font-size: 11.5px;
    color: #14532d;
}
.acc-num-txt {
    font-family: monospace;
    font-size: 12.5px;
    color: #064e3b;
}
.inv-policy-alert {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 8px;
    padding: 7px 10px;
    display: flex;
    gap: 7px;
    font-size: 11px;
    color: #475569;
    line-height: 1.4;
}

.inv-calc-totals {
    width: 290px;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    position: relative;
}
.calc-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
}
.calc-lbl {
    color: #64748b;
}
.calc-val {
    color: #0f172a;
}
.calc-val.text-free {
    color: #16a34a;
    font-weight: 700;
}
.calc-divider {
    height: 1px;
    background: #cbd5e1;
    margin: 3px 0;
}
.grand-total-usd {
    font-size: 14px;
}
.text-primary-sum {
    color: #064e3b;
    font-size: 18px;
    font-weight: 800;
}
.grand-total-khr {
    font-size: 11.5px;
}
.text-khr-sum {
    color: #15803d;
    font-weight: 700;
}

/* PAID Rubber Stamp Effect */
.inv-paid-seal-stamp {
    margin-top: 8px;
    padding: 5px;
    border: 2px dashed #16a34a;
    border-radius: 8px;
    background: rgba(22, 163, 74, 0.05);
    text-align: center;
}
.seal-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.seal-mark {
    font-size: 14px;
    font-weight: 900;
    color: #16a34a;
    letter-spacing: 2px;
}
.seal-khmer {
    font-size: 10.5px;
    font-weight: 700;
    color: #15803d;
}
.seal-date {
    font-size: 10px;
    color: #16a34a;
    font-family: monospace;
}

/* Signatures */
.inv-signatures-strip {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 14px;
    margin-bottom: 18px;
    text-align: center;
    page-break-inside: avoid;
}
.sig-col {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 6px;
}
.sig-header {
    font-size: 11px;
    font-weight: 700;
    color: #0f172a;
}
.sig-blank-space {
    height: 42px;
}
.sig-dotted {
    color: #94a3b8;
    font-size: 9px;
    letter-spacing: 2px;
    overflow: hidden;
}
.sig-role {
    font-size: 10.5px;
    color: #64748b;
    margin-top: 3px;
}

/* Bottom Note */
.inv-bottom-note {
    text-align: center;
    border-top: 1px solid #e2e8f0;
    padding-top: 10px;
    font-size: 11px;
    color: #64748b;
    display: flex;
    flex-direction: column;
    gap: 3px;
    page-break-inside: avoid;
}
.thank-msg {
    font-weight: 700;
    color: #064e3b;
    font-size: 12px;
}

/* ==========================================================
   OFFICIAL INVOICE MODAL MOBILE RESPONSIVE ENHANCEMENTS
   ========================================================== */
.invoice-preview-mobile-footer {
    display: none;
}

.inv-table-swipe-indicator {
    display: none;
    margin-bottom: 8px;
    padding: 6px 12px;
    background: #eef6f1;
    border: 1px dashed #a7f3d0;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    color: #166534;
    text-align: center;
}

@media (max-width: 900px) {
    .invoice-preview-backdrop {
        padding: 0;
        align-items: stretch;
        justify-content: stretch;
    }
    .invoice-preview-dialog {
        width: 100%;
        max-width: 100%;
        height: 100%;
        max-height: 100vh;
        border-radius: 0;
        border: none;
        box-shadow: none;
    }
    .invoice-preview-topbar {
        padding: 12px 16px;
        background: linear-gradient(135deg, #0d2a1c 0%, #173e2c 50%, #245943 100%);
        border-bottom: 2px solid #d8a962;
    }
    .preview-topbar-title {
        font-size: 13.5px;
        gap: 8px;
    }
    .preview-ord-tag {
        font-size: 11px;
        padding: 2px 6px;
        margin-left: 4px;
        background: rgba(216, 169, 98, 0.2);
        border: 1px solid #d8a962;
        color: #f6d186;
    }
    .desktop-print-btn {
        display: none !important;
    }
    .btn-modal-close-icon {
        width: 36px;
        height: 36px;
        font-size: 16px;
        background: rgba(255, 255, 255, 0.2);
    }
    .invoice-preview-body {
        padding: 12px 10px 80px 10px;
        background: #f1f5f9;
        -webkit-overflow-scrolling: touch;
    }
    .invoice-paper-sheet {
        padding: 20px 14px;
        border-radius: 14px;
        margin: 0 auto;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        max-width: 100%;
        box-sizing: border-box;
    }
    .invoice-preview-mobile-footer {
        display: block;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 12px 16px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        box-shadow: 0 -4px 18px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        flex-shrink: 0;
    }
    .btn-mobile-floating-print {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 50px;
        border-radius: 999px;
        background: linear-gradient(135deg, #0d2a1c 0%, #173e2c 50%, #245943 100%);
        color: #ffffff;
        border: 1.5px solid #d8a962;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(13, 42, 28, 0.28);
        transition: all 0.2s ease;
    }
    .btn-mobile-floating-print:active {
        transform: scale(0.98);
    }
    
    /* Header row responsive */
    .inv-head-row {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
    }
    .inv-head-brand {
        width: 100%;
    }
    .inv-brand-title {
        font-size: 20px;
    }
    .inv-head-meta {
        width: 100%;
        text-align: left;
    }
    .inv-title-badge {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        background: linear-gradient(135deg, #0d2a1c 0%, #245943 100%);
        border-radius: 12px;
        border: 1.5px solid #d8a962;
        margin-bottom: 8px;
    }
    .inv-badge-main {
        font-size: 16px;
    }
    .inv-badge-sub {
        font-size: 10px;
    }
    .inv-meta-card {
        padding: 12px 14px;
        border-radius: 12px;
        font-size: 12.5px;
        background: #fbfdfc;
        border: 1px solid #dce8dd;
    }
    
    /* Parties grid responsive */
    .inv-parties-grid {
        grid-template-columns: 1fr;
        gap: 12px;
        margin-bottom: 16px;
    }
    .inv-box-card {
        padding: 12px 14px;
        border-radius: 12px;
        border: 1.5px solid #dce8dd;
        background: #fbfdfc;
    }
    .inv-box-header {
        font-size: 12.5px;
        font-weight: 800;
        color: #0d2a1c;
        margin-bottom: 8px;
        border-bottom: 1.5px solid #f1f5f9;
        padding-bottom: 6px;
    }
    .box-row {
        font-size: 12px;
        line-height: 1.5;
    }
    .box-lbl {
        min-width: 95px;
    }
    
    /* Table responsive with swipe indicator */
    .inv-table-swipe-indicator {
        display: block;
    }
    .inv-table-frame {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 12px;
        margin-bottom: 16px;
        border: 1.5px solid #cbd5e1;
    }
    .inv-official-table {
        min-width: 480px;
        font-size: 12px;
    }
    .inv-official-table th {
        padding: 10px 12px;
        background: #0d2a1c;
        font-size: 11.5px;
        white-space: nowrap;
    }
    .inv-official-table td {
        padding: 10px 12px;
    }
    
    /* Calculations responsive */
    .inv-calc-section {
        flex-direction: column;
        gap: 14px;
        margin-bottom: 18px;
    }
    .inv-calc-memo {
        width: 100%;
    }
    .inv-bank-box {
        border-radius: 12px;
        padding: 12px 14px;
        border: 1.5px solid #bbf7d0;
        background: #f0fdf4;
    }
    .inv-policy-alert {
        border-radius: 12px;
        padding: 10px 12px;
    }
    .inv-calc-totals {
        width: 100%;
        box-sizing: border-box;
        border-radius: 12px;
        padding: 14px 16px;
        border: 1.5px solid #e2e8f0;
        background: #fbfdfc;
    }
    .text-primary-sum {
        font-size: 18px;
    }
    
    /* Signatures strip responsive */
    .inv-signatures-strip {
        grid-template-columns: 1fr 1fr 1fr;
        gap: 6px;
        margin-bottom: 14px;
    }
    .sig-col {
        padding: 8px 4px;
        border-radius: 8px;
    }
    .sig-header {
        font-size: 10px;
    }
    .sig-blank-space {
        height: 28px;
    }
    .sig-role {
        font-size: 9.5px;
    }
}

/* ==========================================================
   PRINT SPECIFIC RULES (@media print)
   ========================================================== */
@media print {
    /* Hide the entire website interface */
    header,
    footer,
    .announcement,
    .site-header,
    .main-header,
    .site-footer,
    .order-success-page,
    .cart-drawer,
    .cart-drawer-overlay,
    .modal,
    .order-track-modal,
    #confettiCanvas,
    #successToast,
    #qrLightboxModal,
    #bankTipPopover,
    #invoicePreviewModal {
        display: none !important;
        visibility: hidden !important;
    }

    body {
        background: #ffffff !important;
        color: #0f172a !important;
        margin: 0 !important;
        padding: 0 !important;
        font-family: 'Kantumruy Pro', 'DM Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        font-size: 10.5pt !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* Target the standalone printable invoice */
    #printableInvoice {
        display: block !important;
        visibility: visible !important;
        position: relative !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
        border: none !important;
        page-break-after: avoid !important;
        page-break-inside: avoid !important;
    }

    #printableInvoice * {
        visibility: visible !important;
    }

    .inv-container-inner {
        padding: 0 !important;
    }

    /* Prevent page breaks inside critical blocks */
    .inv-table-frame,
    .inv-calc-section,
    .inv-signatures-strip,
    .inv-bottom-note {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    @page {
        size: A4 portrait;
        margin: 8mm 12mm;
    }
}
</style>

<script>
// ==========================================================
// ORDER SUCCESS SCRIPTS & FEATURES
// ==========================================================

// 1. Live 15-Minute Countdown Timer
let countdownDuration = 15 * 60; // 15 minutes
const countdownEl = document.getElementById('khqrCountdown');

function startKhqrTimer() {
    const timerInterval = setInterval(() => {
        if (countdownDuration <= 0) {
            clearInterval(timerInterval);
            if (countdownEl) countdownEl.textContent = 'ផុតសុពលភាព';
            return;
        }
        countdownDuration--;
        const mins = Math.floor(countdownDuration / 60);
        const secs = countdownDuration % 60;
        if (countdownEl) {
            countdownEl.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }
    }, 1000);
}
startKhqrTimer();

// 2. Copy Account Number with Haptic Toast
function copyBankAccountNumber() {
    const accEl = document.getElementById('bankAccNumberText');
    const labelEl = document.getElementById('copyAccLabel');
    if (!accEl) return;

    const text = accEl.textContent.trim().replace(/\s+/g, '');
    navigator.clipboard.writeText(text).then(() => {
        if (labelEl) {
            const original = labelEl.textContent;
            labelEl.textContent = '✓ ចម្លងរួច!';
            setTimeout(() => {
                labelEl.textContent = original;
            }, 2000);
        }
        showCustomToast('បានចម្លងលេខគណនី ABA (' + text + ') រួចរាល់!');
    }).catch(err => {
        console.error('Failed to copy account number:', err);
    });
}

// 3. Copy Order ID
function copyOrderNumber(orderNum) {
    navigator.clipboard.writeText(orderNum).then(() => {
        const lbl = document.getElementById('copyOrderLabel');
        if (lbl) {
            lbl.textContent = '✓';
            setTimeout(() => { lbl.textContent = 'ចម្លង'; }, 2000);
        }
        showCustomToast('បានចម្លងលេខសម្គាល់កុម្ម៉ង់ #' + orderNum + ' រួចរាល់!');
    });
}

// 4. Custom Toast Notification
function showCustomToast(msg) {
    const toast = document.getElementById('successToast');
    const msgEl = document.getElementById('toastMessage');
    if (!toast || !msgEl) return;
    msgEl.textContent = msg;
    toast.style.display = 'flex';
    clearTimeout(window.toastTimer);
    window.toastTimer = setTimeout(() => {
        toast.style.display = 'none';
    }, 2800);
}

// 5. QR Lightbox (Enlarge QR Code)
function openQrLightbox() {
    const modal = document.getElementById('qrLightboxModal');
    if (modal) modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeQrLightbox(e) {
    if (e && e.target && e.target.id !== 'qrLightboxModal' && !e.target.classList.contains('lightbox-close-btn')) {
        return;
    }
    const modal = document.getElementById('qrLightboxModal');
    if (modal) modal.style.display = 'none';
    document.body.style.overflow = '';
}

// 6. Bank Tips Popover
function showBankTip(bankName) {
    showCustomToast('សូមបើកកម្មវិធី ' + bankName + ' រួចចុចលើ Scan QR ដើម្បីស្កេនទូទាត់ភ្លាមៗ!');
}

// 7. Drag & Drop File Handling
const dropzone = document.getElementById('dropzoneBox');
if (dropzone) {
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('is-dragover');
        }, false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('is-dragover');
        }, false);
    });
    dropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        const fileInput = document.getElementById('receiptFileInput');
        if (files && files[0] && fileInput) {
            fileInput.files = files;
            handleReceiptFileSelect(fileInput);
        }
    }, false);
}

function handleReceiptFileSelect(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const previewBox = document.getElementById('dropzonePreview');
    const promptBox = document.getElementById('dropzonePrompt');
    const previewImg = document.getElementById('slipPreviewImg');
    const fileName = document.getElementById('slipFileName');

    if (previewBox && promptBox && previewImg && fileName) {
        fileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.style.display = 'none';
        }
        promptBox.style.display = 'none';
        previewBox.style.display = 'flex';
    }
}

function removeSelectedSlip(e) {
    e.stopPropagation();
    const fileInput = document.getElementById('receiptFileInput');
    const previewBox = document.getElementById('dropzonePreview');
    const promptBox = document.getElementById('dropzonePrompt');
    if (fileInput) fileInput.value = '';
    if (previewBox) previewBox.style.display = 'none';
    if (promptBox) promptBox.style.display = 'flex';
}

// 8. Submit Payment Receipt with AJAX & Confetti
async function submitPaymentReceipt(e) {
    e.preventDefault();
    const form = document.getElementById('receiptUploadForm');
    const fileInput = document.getElementById('receiptFileInput');
    if (!fileInput || !fileInput.files || !fileInput.files[0]) {
        alert('សូមជ្រើសរើសរូបបង្កាន់ដៃបង់ប្រាក់ជាមុនសិន!');
        return;
    }

    const btn = document.getElementById('btnSubmitReceipt');
    const btnText = btn.querySelector('.btn-text');
    const btnSpinner = btn.querySelector('.btn-spinner');

    btn.disabled = true;
    if (btnText) btnText.style.display = 'none';
    if (btnSpinner) btnSpinner.style.display = 'inline-flex';

    const formData = new FormData(form);

    try {
        const response = await fetch("{{ route('store.order.upload-receipt', $order->id) }}", {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData,
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // Trigger Confetti!
            triggerConfetti();

            // Update UI to success state
            const uploadCard = document.getElementById('receiptUploadCard');
            if (uploadCard) {
                uploadCard.innerHTML = `
                    <div class="card-head-row">
                        <span class="card-icon">🧾</span>
                        <h3 class="card-sec-title">{{ $locale === 'km' ? 'បង្កាន់ដៃបង់ប្រាក់ (Payment Receipt)' : 'Payment Receipt' }}</h3>
                    </div>
                    <div class="receipt-success-view">
                        <div class="receipt-approved-alert">
                            <span>✓</span>
                            <div>
                                <strong>{{ $locale === 'km' ? 'បានទទួលបង្កាន់ដៃបង់ប្រាក់រួចរាល់!' : 'Payment Receipt Submitted!' }}</strong>
                                <p>{{ $locale === 'km' ? 'ក្រុមការងារកំពុងត្រួតពិនិត្យ និងរៀបចំទំនិញដឹកជញ្ជូនជូនអ្នក។' : 'Our team is preparing your package for fast delivery.' }}</p>
                            </div>
                        </div>
                        <div class="receipt-preview-wrap">
                            <a href="${data.proof_url}" target="_blank" title="ចុចដើម្បីមើលរូបធំ">
                                <img src="${data.proof_url}" alt="Payment Receipt" class="receipt-slip-img">
                            </a>
                        </div>
                        ${data.transaction_ref ? `<div class="receipt-ref-display"><span>លេខប្រតិបត្តិការ (Ref ID):</span> <strong>#${data.transaction_ref}</strong></div>` : ''}
                    </div>
                `;
            }

            // Update badge in KHQR card
            const badge = document.getElementById('paymentStatusBadge');
            if (badge) {
                badge.className = 'payment-status-pill is-paid';
                badge.innerHTML = `<span class="chk">✓</span> {{ $locale === 'km' ? 'ការទូទាត់ត្រូវបានបញ្ជាក់ជោគជ័យ' : 'Payment Confirmed' }}`;
            }

            // Update Stepper
            const stepPayment = document.getElementById('stepperPaymentStatus');
            if (stepPayment) stepPayment.textContent = "{{ $locale === 'km' ? 'រួចរាល់' : 'Paid' }}";

            showCustomToast('បង្កាន់ដៃបង់ប្រាក់ត្រូវបានបញ្ជូនដោយជោគជ័យ!');
        } else {
            alert(data.message || 'មានបញ្ហាក្នុងការផ្ញើបង្កាន់ដៃ សូមព្យាយាមម្តងទៀត។');
            btn.disabled = false;
            if (btnText) btnText.style.display = 'inline-flex';
            if (btnSpinner) btnSpinner.style.display = 'none';
        }
    } catch (err) {
        console.error('Receipt upload error:', err);
        alert('មានបញ្ហាបច្ចេកទេស សូមព្យាយាមម្តងទៀត!');
        btn.disabled = false;
        if (btnText) btnText.style.display = 'inline-flex';
        if (btnSpinner) btnSpinner.style.display = 'none';
    }
}

// 9. Confetti Particle Animation
function triggerConfetti() {
    const canvas = document.getElementById('confettiCanvas');
    if (!canvas) return;
    canvas.style.display = 'block';
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const particles = [];
    const colors = ['#10b981', '#3b82f6', '#f59e0b', '#ec4899', '#8b5cf6', '#e11d48'];

    for (let i = 0; i < 90; i++) {
        particles.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height - canvas.height,
            size: Math.random() * 8 + 4,
            speedY: Math.random() * 4 + 2,
            speedX: Math.random() * 3 - 1.5,
            color: colors[Math.floor(Math.random() * colors.length)],
            rotation: Math.random() * 360,
            rotationSpeed: Math.random() * 10 - 5
        });
    }

    let frames = 0;
    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => {
            p.y += p.speedY;
            p.x += p.speedX;
            p.rotation += p.rotationSpeed;

            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate((p.rotation * Math.PI) / 180);
            ctx.fillStyle = p.color;
            ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size);
            ctx.restore();
        });

        frames++;
        if (frames < 140) {
            requestAnimationFrame(animate);
        } else {
            canvas.style.display = 'none';
        }
    }
    animate();
}

// Remember this successful order for quick tracking across Home & Account
try {
    localStorage.setItem('dara_last_order', '{{ $order->order_number }}');
    localStorage.setItem('dara_last_order_phone', '{{ $order->customer_phone }}');
} catch (e) {}

function openTrackOrderModalWithCode(orderNumber, phone = '') {
    if (typeof openTrackOrderModal === 'function') {
        openTrackOrderModal();
        const ordInput = document.getElementById('track_order_number');
        const phoneInput = document.getElementById('track_phone');
        if (ordInput) ordInput.value = orderNumber;
        if (phoneInput && phone) phoneInput.value = phone;

        // Auto trigger search immediately
        const form = document.getElementById('trackOrderForm');
        if (form) {
            form.dispatchEvent(new Event('submit', { cancelable: true }));
        }
    }
}

// 10. Official Invoice Preview & Print Modal Handlers
function openInvoicePreviewModal() {
    const modal = document.getElementById('invoicePreviewModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeInvoicePreviewModal() {
    const modal = document.getElementById('invoicePreviewModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function printOfficialInvoice() {
    window.print();
}

// Close invoice preview on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeInvoicePreviewModal();
    }
});
</script>
@endsection
