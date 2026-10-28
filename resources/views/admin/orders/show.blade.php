@extends('admin.layouts.app')

@section('title', 'Order #'.$order->order_number)

@section('content')
<div class="admin-order-detail-view">
    <!-- Header with Back Button and Print -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">ORDER INVOICE & DETAILS</span>
            <h1>Order #{{ $order->order_number }}</h1>
            <p>Placed on {{ $order->created_at->format('l, d F Y \a\t h:i A') }}</p>
        </div>
        <div class="heading-actions">
            <button onclick="window.print()" class="admin-secondary-button">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span>Print Invoice</span>
            </button>
            <a class="admin-secondary-button" href="{{ route('admin.orders.index') }}">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Orders</span>
            </a>
        </div>
    </div>

    <!-- Main Order Details Grid -->
    <div class="order-detail-layout">
        <!-- Left: Items & Summary -->
        <div class="order-main-col">
            <section class="admin-panel order-items-panel">
                <div class="panel-section-title">
                    <h3>Purchased Items ({{ $order->items_count }})</h3>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table order-items-table">
                        <thead>
                            <tr>
                                <th>Item Details</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th style="text-align: right;">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (is_array($order->items))
                                @foreach ($order->items as $it)
                                    <tr>
                                        <td>
                                            <div class="order-item-cell">
                                                @if (!empty($it['image']))
                                                    <img src="{{ $it['image'] }}" alt="" class="order-item-img" onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\' viewBox=\'0 0 40 40\'><rect width=\'40\' height=\'40\' fill=\'%23edf5ed\'/><text x=\'20\' y=\'25\' font-size=\'14\' text-anchor=\'middle\'>🛍️</text></svg>';">
                                                @endif
                                                <strong class="item-name">{{ $it['name'] ?? 'Product Item' }}</strong>
                                            </div>
                                        </td>
                                        <td>${{ number_format((float) ($it['price'] ?? 0), 2) }}</td>
                                        <td><span class="qty-pill">x{{ $it['quantity'] ?? 1 }}</span></td>
                                        <td style="text-align: right;">
                                            <strong>${{ number_format(((float) ($it['price'] ?? 0)) * ((int) ($it['quantity'] ?? 1)), 2) }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Totals Breakdown -->
                <div class="order-totals-breakdown">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span>${{ number_format((float) $order->total_amount, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span>Standard Delivery:</span>
                        <span class="text-success">Free Delivery</span>
                    </div>
                    <div class="total-row total-highlight">
                        <strong>Grand Total:</strong>
                        <strong class="total-grand-amount">${{ number_format((float) $order->total_amount, 2) }}</strong>
                    </div>
                </div>
            </section>

            @if ($order->notes)
                <section class="admin-panel order-notes-panel">
                    <div class="panel-section-title">
                        <h3>Customer Delivery Notes</h3>
                    </div>
                    <p class="customer-note-text">“{{ $order->notes }}”</p>
                </section>
            @endif
        </div>

        <!-- Right: Status Update & Customer Info -->
        <aside class="order-side-col">
            <!-- Status Update Box -->
            <section class="admin-panel order-control-panel">
                <div class="panel-section-title">
                    <h3>Update Status</h3>
                </div>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="order-update-form">
                    @csrf
                    @method('PATCH')

                    <label class="admin-field">
                        <span>Fulfillment Status</span>
                        <select name="order_status" class="order-status-select status-{{ $order->order_status }}">
                            <option value="pending" @selected($order->order_status === 'pending')>⏳ Pending</option>
                            <option value="processing" @selected($order->order_status === 'processing')>⚙ Processing</option>
                            <option value="shipped" @selected($order->order_status === 'shipped')>🚚 Shipped</option>
                            <option value="delivered" @selected($order->order_status === 'delivered')>✓ Delivered</option>
                            <option value="cancelled" @selected($order->order_status === 'cancelled')>✕ Cancelled</option>
                        </select>
                    </label>

                    <label class="admin-field">
                        <span>Payment Status</span>
                        <select name="payment_status">
                            <option value="paid" @selected($order->payment_status === 'paid')>✓ Paid</option>
                            <option value="pending" @selected($order->payment_status === 'pending')>⏳ Pending</option>
                            <option value="failed" @selected($order->payment_status === 'failed')>✕ Failed</option>
                            <option value="refunded" @selected($order->payment_status === 'refunded')>↩ Refunded</option>
                        </select>
                    </label>

                    <button type="submit" class="admin-primary-button" style="width: 100%; justify-content: center; margin-top: 8px;">
                        <span>Save Status</span>
                    </button>
                </form>
            </section>

            <!-- Customer & Shipping Information -->
            <section class="admin-panel customer-info-panel">
                <div class="panel-section-title">
                    <h3>Customer & Shipping</h3>
                </div>

                <div class="info-block">
                    <span class="info-label">Customer Name</span>
                    <strong class="info-val">{{ $order->customer_name }}</strong>
                </div>

                <div class="info-block">
                    <span class="info-label">Email Address</span>
                    <span class="info-val"><a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a></span>
                </div>

                @if ($order->customer_phone)
                    <div class="info-block">
                        <span class="info-label">Phone Number</span>
                        <strong class="info-val"><a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a></strong>
                    </div>
                @endif

                <div class="info-block">
                    <span class="info-label">Shipping Destination</span>
                    <p class="shipping-addr-text">{{ $order->shipping_address ?? 'Phnom Penh, Cambodia' }}</p>
                </div>

                <div class="info-block">
                    <span class="info-label">Payment Method</span>
                    <span class="info-val pay-method-badge">{{ $order->payment_method }}</span>
                </div>

                @if ($order->payment_proof)
                    <div class="info-block" style="border-top: 1px dashed #e2e8f0; padding-top: 12px; margin-top: 12px;">
                        <span class="info-label">📸 Bank Payment Receipt (បង្កាន់ដៃបង់ប្រាក់)</span>
                        <div style="margin-top: 8px;">
                            <a href="{{ $order->payment_proof }}" target="_blank" title="View Full Receipt">
                                <img src="{{ $order->payment_proof }}" alt="Payment Receipt" style="width: 100%; max-height: 180px; object-fit: contain; border-radius: 8px; border: 1px solid #cbd5e1; background: #f8fafc;">
                            </a>
                            <div style="margin-top: 6px; font-size: 11px; color: #16a34a; font-weight: 700;">
                                ✓ Customer Attached Slip
                            </div>
                        </div>
                    </div>
                @endif

                @if ($order->transaction_ref)
                    <div class="info-block">
                        <span class="info-label">Bank Transaction ID / Ref</span>
                        <strong class="info-val" style="color: #245943; font-family: monospace;">#{{ $order->transaction_ref }}</strong>
                    </div>
                @endif
            </section>
        </aside>
    </div>
</div>
@endsection
