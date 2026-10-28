<div class="inv-container-inner">
    <!-- Invoice Top Header -->
    <div class="inv-head-row">
        <div class="inv-head-brand">
            <div class="inv-brand-logo-wrap">
                <span class="inv-brand-symbol">🛍️</span>
                <div class="inv-brand-names">
                    <h2 class="inv-brand-title">DARA MARKET</h2>
                    <span class="inv-brand-kh">{{ $settings['store_name_km'] ?? 'ដារ៉ា ម៉ាត - ហាងទំនិញអនឡាញឈានមុខ' }}</span>
                </div>
            </div>
            <div class="inv-store-info">
                <div class="inv-info-item">
                    <span class="info-icon">📍</span>
                    <span><strong>អាសយដ្ឋាន៖</strong> រាជធានីភ្នំពេញ, ព្រះរាជាណាចក្រកម្ពុជា</span>
                </div>
                <div class="inv-info-item">
                    <span class="info-icon">📞</span>
                    <span><strong>ទូរស័ព្ទ៖</strong> <span class="inv-phone-highlight">071 450 4547</span> | <strong>Telegram:</strong> @daramarket</span>
                </div>
                <div class="inv-info-item">
                    <span class="info-icon">✉️</span>
                    <span><strong>អ៊ីមែល៖</strong> contact@daramarket.com | <strong>វេបសាយ៖</strong> {{ request()->getHost() }}</span>
                </div>
            </div>
        </div>

        <div class="inv-head-meta">
            <div class="inv-title-badge">
                <div class="inv-badge-main">វិក្កយបត្រ</div>
                <div class="inv-badge-sub">OFFICIAL INVOICE</div>
            </div>
            <div class="inv-meta-card">
                <div class="meta-card-line">
                    <span class="m-lbl">លេខវិក្កយបត្រ:</span>
                    <strong class="m-val text-ord">#{{ $order->order_number }}</strong>
                </div>
                <div class="meta-card-line">
                    <span class="m-lbl">កាលបរិច្ឆេទ:</span>
                    <span class="m-val">{{ $order->created_at ? $order->created_at->format('d/m/Y - h:i A') : date('d/m/Y - h:i A') }}</span>
                </div>
                <div class="meta-card-line">
                    <span class="m-lbl">វិធីទូទាត់:</span>
                    <span class="m-val font-semibold">{{ $order->payment_method }}</span>
                </div>
                <div class="meta-card-line">
                    <span class="m-lbl">ស្ថានភាព:</span>
                    @if($order->payment_status === 'paid')
                        <span class="m-status-pill is-paid">✓ PAID (បានទូទាត់)</span>
                    @else
                        <span class="m-status-pill is-unpaid">⏳ COD (ទូទាត់ពេលដឹក)</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Divider Strip -->
    <div class="inv-decor-divider"></div>

    <!-- Customer & Delivery Two-Column Box -->
    <div class="inv-parties-grid">
        <!-- Customer Details -->
        <div class="inv-box-card">
            <div class="inv-box-header">
                <span class="box-icon">👤</span>
                <strong>ព័ត៌មានអតិថិជន (BILL / SHIP TO):</strong>
            </div>
            <div class="inv-box-body">
                <div class="box-row">
                    <span class="box-lbl">ឈ្មោះអតិថិជន៖</span>
                    <strong class="box-val">{{ $order->customer_name }}</strong>
                </div>
                <div class="box-row">
                    <span class="box-lbl">លេខទូរស័ព្ទ៖</span>
                    <strong class="box-val text-phone">{{ $order->customer_phone }}</strong>
                </div>
                <div class="box-row">
                    <span class="box-lbl">អាសយដ្ឋានដឹក៖</span>
                    <span class="box-val">{{ $order->shipping_address }}</span>
                </div>
                @if($order->notes)
                    <div class="box-row">
                        <span class="box-lbl">ចំណាំបន្ថែម៖</span>
                        <span class="box-val italic">"{{ $order->notes }}"</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Dispatch & Shipping Details -->
        <div class="inv-box-card">
            <div class="inv-box-header">
                <span class="box-icon">🚚</span>
                <strong>ព័ត៌មានដឹកជញ្ជូន (DISPATCH & ORDER):</strong>
            </div>
            <div class="inv-box-body">
                <div class="box-row">
                    <span class="box-lbl">លេខកូដកុម្ម៉ង់៖</span>
                    <strong class="box-val">#{{ $order->order_number }}</strong>
                </div>
                <div class="box-row">
                    <span class="box-lbl">ភ្នាក់ងារដឹក៖</span>
                    <span class="box-val">Dara Express Fast Delivery</span>
                </div>
                <div class="box-row">
                    <span class="box-lbl">រយៈពេលដឹក៖</span>
                    <span class="box-val">២ - ៤ ម៉ោង (ភ្នំពេញ) / ១-២ ថ្ងៃ (ខេត្ត)</span>
                </div>
                <div class="box-row">
                    <span class="box-lbl">ស្ថានភាពបញ្ជាទិញ៖</span>
                    <span class="box-val badge-order-st">{{ ucfirst($order->order_status) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="inv-table-swipe-indicator">
        <span>↔️ {{ $locale === 'km' ? 'អូសតារាងដើម្បីមើលតម្លៃ និងចំនួនទំនិញពេញលេញ' : 'Swipe table horizontally for full prices & qty' }}</span>
    </div>
    <div class="inv-table-frame">
        <table class="inv-official-table">
            <thead>
                <tr>
                    <th class="col-num">ល.រ</th>
                    <th class="col-desc">ការពិពណ៌នាទំនិញ (Description & Item Name)</th>
                    <th class="col-qty">ចំនួន (Qty)</th>
                    <th class="col-price">តម្លៃរាយ (Unit Price)</th>
                    <th class="col-tot">សរុប (Amount)</th>
                </tr>
            </thead>
            <tbody>
                @php $totalItemsQty = 0; @endphp
                @if(is_array($order->items) && count($order->items) > 0)
                    @foreach ($order->items as $idx => $item)
                        @php $totalItemsQty += ($item['quantity'] ?? 1); @endphp
                        <tr>
                            <td class="col-num">{{ $idx + 1 }}</td>
                            <td class="col-desc">
                                <div class="item-name-wrap">
                                    <span class="item-name-txt">{!! html_entity_decode($item['name']) !!}</span>
                                </div>
                            </td>
                            <td class="col-qty"><strong>{{ $item['quantity'] }}</strong></td>
                            <td class="col-price">${{ number_format($item['price'], 2) }}</td>
                            <td class="col-tot"><strong>${{ number_format($item['price'] * $item['quantity'], 2) }}</strong></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 18px; color: #64748b;">
                            មិនមានមុខទំនិញ
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Calculation & Payment Row -->
    <div class="inv-calc-section">
        <!-- Left Memo -->
        <div class="inv-calc-memo">
            <div class="inv-bank-box">
                <div class="bank-head-title">💳 គណនីទូទាត់ប្រាក់ផ្លូវការ (Official Bank Account)</div>
                <div class="bank-grid">
                    <div>ធនាគារ៖ <strong>ABA Bank (KHQR)</strong></div>
                    <div>លេខគណនី៖ <strong class="acc-num-txt">{{ $settings['aba_account_number'] ?? '001 888 999' }}</strong></div>
                    <div>ឈ្មោះគណនី៖ <strong>{{ $settings['aba_account_name'] ?? 'DARA MARKET CO., LTD' }}</strong></div>
                </div>
            </div>

            <div class="inv-policy-alert">
                <span class="policy-icon">🛡️</span>
                <div class="policy-txt">
                    <strong>ការធានា និងប្តូរទំនិញ៖</strong> រាល់ទំនិញអាចប្តូរបានក្នុងរយៈពេល <strong>៧ ថ្ងៃ</strong> គិតចាប់ពីថ្ងៃទទួល ប្រសិនបើមានបញ្ហាបច្ចេកទេស ឬខុសទំហំ (សូមរក្សាទុកវិក្កយបត្រនេះ)។
                </div>
            </div>
        </div>

        <!-- Right Calculation Summary -->
        <div class="inv-calc-totals">
            <div class="calc-line">
                <span class="calc-lbl">សរុបរង (Subtotal):</span>
                <strong class="calc-val">${{ number_format($order->total_amount, 2) }}</strong>
            </div>
            <div class="calc-line">
                <span class="calc-lbl">ថ្លៃដឹកជញ្ជូន (Shipping):</span>
                <span class="calc-val text-free">ឥតគិតថ្លៃ (Free)</span>
            </div>
            <div class="calc-divider"></div>
            <div class="calc-line grand-total-usd">
                <span class="calc-lbl">សរុបរួម (Grand Total):</span>
                <strong class="calc-val text-primary-sum">${{ number_format($order->total_amount, 2) }}</strong>
            </div>
            <div class="calc-line grand-total-khr">
                <span class="calc-lbl">សរុបជាប្រាក់រៀល (KHR):</span>
                <strong class="calc-val text-khr-sum">≈ {{ number_format($totalKhr) }} ៛ KHR</strong>
            </div>

            @if($order->payment_status === 'paid')
                <div class="inv-paid-seal-stamp">
                    <div class="seal-inner">
                        <span class="seal-mark">✓ PAID</span>
                        <span class="seal-khmer">បានទូទាត់រួចរាល់</span>
                        <span class="seal-date">{{ $order->created_at ? $order->created_at->format('d M Y') : date('d M Y') }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Signatures Block -->
    <div class="inv-signatures-strip">
        <div class="sig-col">
            <div class="sig-header">អ្នករៀបចំទំនិញ (Prepared By)</div>
            <div class="sig-blank-space"></div>
            <div class="sig-dotted">....................................................</div>
            <div class="sig-role">ផ្នែកឃ្លាំង / Store Staff</div>
        </div>

        <div class="sig-col">
            <div class="sig-header">អ្នកដឹកជញ្ជូន (Delivered By)</div>
            <div class="sig-blank-space"></div>
            <div class="sig-dotted">....................................................</div>
            <div class="sig-role">ភ្នាក់ងារដឹក / Delivery Rider</div>
        </div>

        <div class="sig-col">
            <div class="sig-header">ហត្ថលេខាអ្នកទទួល (Customer)</div>
            <div class="sig-blank-space"></div>
            <div class="sig-dotted">....................................................</div>
            <div class="sig-role">{{ $order->customer_name }}</div>
        </div>
    </div>

    <!-- Footer Strip -->
    <div class="inv-bottom-note">
        <div class="thank-msg">✨ សូមអរគុណយ៉ាងជ្រាលជ្រៅចំពោះការគាំទ្រ DARA MARKET! ✨</div>
        <div class="contact-msg">ផ្នែកបម្រើអតិថិជន ២៤/៧៖ <strong>071 450 4547</strong> | Telegram: <strong>@daramarket</strong> | គេហទំព័រ៖ {{ request()->getHost() }}</div>
    </div>
</div>
