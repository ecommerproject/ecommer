@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="admin-orders-view">
    <!-- Header with Breadcrumbs & Action Buttons -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">SALES & FULFILLMENT</span>
            <h1>Orders Management <span style="font-size: 16px; font-weight: 600; color: var(--food-muted); vertical-align: middle;">({{ $orders->total() }})</span></h1>
            <p>Track customer orders, manage shipping and fulfillment, and monitor real-time revenue.</p>
        </div>
        <div class="heading-actions">
            <button type="button" class="admin-primary-button" onclick="openCreateOrderModal()" style="background:#245943; color:#ffffff; border:none; padding:9px 16px; border-radius:10px; font-weight:700; font-size:13px; display:inline-flex; align-items:center; gap:6px; cursor:pointer;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Create Order</span>
            </button>
            <a href="{{ route('admin.orders.export') }}" class="admin-export-button" title="Export orders catalog as UTF-8 CSV">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('store.home') }}" target="_blank" class="admin-secondary-button" title="Open Storefront Homepage in new tab">
                <span>View Storefront</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="7" y1="17" x2="17" y2="7"></line>
                    <polyline points="7 7 17 7 17 17"></polyline>
                </svg>
            </a>
        </div>
    </div>

    <!-- Orders Metric KPI Cards -->
    <div class="orders-stats-grid">
        <div class="stat-pill-card {{ ($filters['status'] ?? 'all') === 'all' ? 'is-selected' : '' }}">
            <div class="stat-pill-icon icon-all">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                    <path d="M9 14l2 2 4-4"></path>
                </svg>
            </div>
            <div class="stat-pill-info">
                <span class="stat-pill-label">Total Orders</span>
                <span class="stat-pill-num" id="statTotalOrders">{{ $stats['total_orders'] }}</span>
            </div>
        </div>

        <div class="stat-pill-card">
            <div class="stat-pill-icon icon-revenue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
            </div>
            <div class="stat-pill-info">
                <span class="stat-pill-label">Paid Revenue</span>
                <span class="stat-pill-num text-success" id="statPaidRevenue">${{ number_format($stats['total_revenue'], 2) }}</span>
            </div>
        </div>

        <div class="stat-pill-card">
            <div class="stat-pill-icon icon-pending">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="stat-pill-info">
                <span class="stat-pill-label">Needs Processing</span>
                <span class="stat-pill-num text-amber" id="statProcessingCount">{{ $stats['processing_count'] }}</span>
            </div>
        </div>

        <div class="stat-pill-card">
            <div class="stat-pill-icon icon-delivered">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="stat-pill-info">
                <span class="stat-pill-label">Delivered Orders</span>
                <span class="stat-pill-num text-success" id="statDeliveredCount">{{ $stats['delivered_count'] }}</span>
            </div>
        </div>
    </div>

    <!-- Orders Status Quick Tabs -->
    <div class="orders-quick-tabs">
        <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'all'])) }}" class="quick-tab-item {{ ($filters['status'] ?? 'all') === 'all' ? 'is-active' : '' }}">
            <span>All Orders</span>
            <span class="tab-count" id="tabCountAll">{{ $stats['total_orders'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'pending'])) }}" class="quick-tab-item {{ ($filters['status'] ?? '') === 'pending' ? 'is-active' : '' }}">
            <span>⏳ Pending</span>
            <span class="tab-count count-amber" id="tabCountPending">{{ $stats['pending_count'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'processing'])) }}" class="quick-tab-item {{ ($filters['status'] ?? '') === 'processing' ? 'is-active' : '' }}">
            <span>⚙ Processing</span>
            <span class="tab-count count-blue" id="tabCountProcessing">{{ $stats['processing_count'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'shipped'])) }}" class="quick-tab-item {{ ($filters['status'] ?? '') === 'shipped' ? 'is-active' : '' }}">
            <span>🚚 Shipped</span>
            <span class="tab-count" id="tabCountShipped">{{ $stats['shipped_count'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'delivered'])) }}" class="quick-tab-item {{ ($filters['status'] ?? '') === 'delivered' ? 'is-active' : '' }}">
            <span>✓ Delivered</span>
            <span class="tab-count count-green" id="tabCountDelivered">{{ $stats['delivered_count'] }}</span>
        </a>
        <a href="{{ route('admin.orders.index', array_merge(request()->except('page'), ['status' => 'cancelled'])) }}" class="quick-tab-item {{ ($filters['status'] ?? '') === 'cancelled' ? 'is-active' : '' }}">
            <span>✕ Cancelled</span>
            <span class="tab-count count-muted" id="tabCountCancelled">{{ $stats['cancelled_count'] }}</span>
        </a>
    </div>

    <!-- Orders Management Card -->
    <section class="admin-panel admin-orders-card">
        <!-- Floating Bulk Action Toolbar -->
        <div id="bulkToolbar" class="admin-bulk-toolbar">
            <div class="bulk-count-badge">
                <span id="bulkSelectedCount">0</span>
                <span>orders selected</span>
            </div>
            <div class="bulk-actions-buttons">
                <button type="button" class="btn-bulk btn-bulk-activate" onclick="executeBulkOrderAction('delivered')">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Mark Delivered</span>
                </button>
                <button type="button" class="btn-bulk btn-bulk-activate" style="background: #7c3aed;" onclick="executeBulkOrderAction('shipped')">
                    <span>🚚 Shipped</span>
                </button>
                <button type="button" class="btn-bulk btn-bulk-activate" style="background: #2563eb;" onclick="executeBulkOrderAction('processing')">
                    <span>⚙ Processing</span>
                </button>
                <button type="button" class="btn-bulk btn-bulk-delete" onclick="executeBulkOrderAction('delete')">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path></svg>
                    <span>Delete</span>
                </button>
                <button type="button" class="btn-bulk btn-bulk-cancel" onclick="clearAllOrderSelections()">
                    <span>Cancel</span>
                </button>
            </div>
        </div>

        <!-- Filter and Search Bar -->
        <form class="admin-filter-bar modern-filter-bar" action="{{ route('admin.orders.index') }}" method="GET">
            <input type="hidden" name="status" value="{{ $filters['status'] ?? 'all' }}">
            <div class="search-input-group">
                <svg class="search-field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <label class="sr-only" for="order-search-input">Search orders</label>
                <input id="order-search-input" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search by Order #, Customer name, email or phone..." oninput="filterOrdersClientSide(this.value)">
            </div>

            <div class="filter-controls-row">
                <div class="filter-select-wrapper">
                    <label class="filter-label">Payment</label>
                    <select name="payment" onchange="this.form.submit()">
                        <option value="all" @selected(($filters['payment'] ?? 'all') === 'all')>All Payments</option>
                        <option value="paid" @selected(($filters['payment'] ?? '') === 'paid')>Paid only</option>
                        <option value="pending" @selected(($filters['payment'] ?? '') === 'pending')>Pending payment</option>
                    </select>
                </div>

                <button class="admin-primary-button filter-submit-btn" type="submit">Filter</button>
                @if (($filters['q'] ?? '') !== '' || ($filters['status'] ?? 'all') !== 'all' || ($filters['payment'] ?? 'all') !== 'all')
                    <a class="admin-secondary-button filter-clear-btn" href="{{ route('admin.orders.index') }}">Reset</a>
                @endif
            </div>
        </form>

        <!-- Orders Table -->
        <div class="admin-table-wrap">
            <table class="admin-table modern-products-table" id="ordersTable">
                <thead>
                    <tr>
                        <th class="col-check">
                            <input type="checkbox" id="selectAllOrdersCheckbox" class="custom-checkbox" title="Select all orders" onchange="toggleSelectAllOrders(this)">
                        </th>
                        <th style="width: 130px;">Order ID</th>
                        <th style="width: 220px;">Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Fulfillment</th>
                        <th>Date</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr id="orderRow-{{ $order->id }}" class="order-row" data-search="{{ strtolower($order->order_number.' '.$order->customer_name.' '.$order->customer_phone.' '.$order->customer_email) }}">
                            <td class="col-check">
                                <input type="checkbox" class="custom-checkbox order-checkbox" value="{{ $order->id }}" onchange="onOrderCheckboxChange()">
                            </td>
                            <td>
                                <a href="javascript:void(0)" onclick="openOrderInvoiceModal({{ $order->id }})" class="order-id-badge" title="Click to view Quick Invoice">
                                    #{{ $order->order_number }}
                                </a>
                            </td>
                            <td>
                                <div class="customer-cell">
                                    <span class="customer-avatar" style="background: {{ ['#245943', '#1e3a8a', '#d97706', '#9333ea', '#059669'][$order->id % 5] }};">
                                        {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                                    </span>
                                    <div class="customer-text">
                                        <strong class="cust-name">{{ $order->customer_name }}</strong>
                                        <small class="cust-contact">{{ $order->customer_phone ?? $order->customer_email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="order-items-preview">
                                    <span class="items-count-badge">{{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}</span>
                                    <div class="items-thumbs-mini">
                                        @if (is_array($order->items))
                                            @foreach (array_slice($order->items, 0, 3) as $it)
                                                <span class="mini-order-thumb" 
                                                      onclick="previewImage('{{ $it['image'] ?? '' }}', '{{ addslashes($it['name'] ?? 'Product') }} (x{{ $it['quantity'] ?? 1 }})')" 
                                                      title="{{ $it['name'] ?? 'Product' }} (x{{ $it['quantity'] ?? 1 }}) - Click to zoom">
                                                    @if (!empty($it['image']))
                                                        <img src="{{ $it['image'] }}" alt="" onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'30\' height=\'30\' viewBox=\'0 0 30 30\'><rect width=\'30\' height=\'30\' fill=\'%23edf5ed\'/><text x=\'15\' y=\'20\' font-size=\'12\' text-anchor=\'middle\'>🛍️</text></svg>';">
                                                    @else
                                                        📦
                                                    @endif
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="order-amount-cell">
                                    <strong class="order-total-price">${{ number_format((float) $order->total_amount, 2) }}</strong>
                                    <span class="pay-method-tag">{{ $order->payment_method }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="pay-status-pill pay-{{ $order->payment_status }}">
                                    @if ($order->payment_status === 'paid')
                                        ✓ Paid
                                    @elseif ($order->payment_status === 'pending')
                                        ⏳ Pending
                                    @else
                                        ✕ {{ ucfirst($order->payment_status) }}
                                    @endif
                                </span>
                                @if ($order->payment_proof)
                                    <div style="margin-top: 4px;">
                                        <a href="{{ $order->payment_proof }}" target="_blank" style="font-size: 11px; color: #245943; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;" title="View Payment Proof Slip">
                                            📸 Slip
                                        </a>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <select id="orderStatusSelect-{{ $order->id }}" 
                                        onchange="updateFulfillmentStatus({{ $order->id }}, this)" 
                                        class="order-status-select status-{{ $order->order_status }}"
                                        title="Click to instantly update status">
                                    <option value="pending" @selected($order->order_status === 'pending')>⏳ Pending</option>
                                    <option value="processing" @selected($order->order_status === 'processing')>⚙ Processing</option>
                                    <option value="shipped" @selected($order->order_status === 'shipped')>🚚 Shipped</option>
                                    <option value="delivered" @selected($order->order_status === 'delivered')>✓ Delivered</option>
                                    <option value="cancelled" @selected($order->order_status === 'cancelled')>✕ Cancelled</option>
                                </select>
                            </td>
                            <td>
                                <span class="order-date-text">{{ $order->created_at->format('d M Y') }}<br><small>{{ $order->created_at->format('h:i A') }}</small></span>
                            </td>
                            <td style="text-align: right;">
                                <div class="admin-row-actions">
                                    <button type="button" class="action-btn-edit" onclick="openOrderInvoiceModal({{ $order->id }})" title="View Quick Invoice">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                        <span>Invoice</span>
                                    </button>

                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete order #{{ $order->order_number }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-btn-delete" type="submit" title="Delete Order">
                                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Order Data for Quick Invoice Modal -->
                        <script type="application/json" id="orderDataJson-{{ $order->id }}">
                            {!! json_encode([
                                'id' => $order->id,
                                'order_number' => $order->order_number,
                                'customer_name' => $order->customer_name,
                                'customer_email' => $order->customer_email,
                                'customer_phone' => $order->customer_phone,
                                'shipping_address' => $order->shipping_address,
                                'total_amount' => (float) $order->total_amount,
                                'payment_method' => $order->payment_method,
                                'payment_status' => $order->payment_status,
                                'order_status' => $order->order_status,
                                'items' => $order->items ?? [],
                                'notes' => $order->notes,
                                'date' => $order->created_at->format('l, d F Y \a\t h:i A'),
                                'view_url' => route('admin.orders.show', $order)
                            ]) !!}
                        </script>
                    @empty
                        <tr>
                            <td colspan="9" class="admin-empty-state">
                                <div class="empty-state-wrap">
                                    <div class="empty-icon">📋</div>
                                    <h3>No orders found</h3>
                                    <p>There are currently no customer orders matching your selected filters.</p>
                                    <div class="empty-actions">
                                        <a href="{{ route('admin.orders.index') }}" class="admin-secondary-button">Reset filters</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($orders->hasPages())
            <div class="admin-pagination-footer">
                <span class="pagination-summary">
                    Showing <strong>{{ $orders->firstItem() ?? 0 }}</strong> to <strong>{{ $orders->lastItem() ?? 0 }}</strong> of <strong>{{ $orders->total() }}</strong> orders
                </span>
                <div class="pagination-links">
                    {{ $orders->links('admin.partials.pagination') }}
                </div>
            </div>
        @endif
    </section>
</div>

<!-- Quick Invoice & Receipt Modal -->
<div id="orderInvoiceModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); z-index: 10000; align-items: center; justify-content: center; padding: 20px;" onclick="closeOrderInvoiceModal()">
    <div style="background: #ffffff; border-radius: 16px; width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px rgba(0,0,0,0.25); position: relative; padding: 28px;" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div style="display: flex; align-items: flex-start; justify-content: space-between; border-bottom: 1px solid var(--food-border); padding-bottom: 16px; margin-bottom: 20px;">
            <div>
                <span style="font-size: 10.5px; font-weight: 800; color: var(--food-primary); letter-spacing: 0.5px; text-transform: uppercase;">DARA MARKET OFFICIAL INVOICE</span>
                <h2 id="invOrderNumber" style="margin: 4px 0 2px; font-size: 20px; font-weight: 800; color: var(--food-ink);">#ORD-0000</h2>
                <small id="invDate" style="color: var(--food-muted); font-size: 11.5px;"></small>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span id="invStatusBadge" class="pay-status-pill pay-paid">✓ Delivered</span>
                <button type="button" onclick="closeOrderInvoiceModal()" style="border: none; background: #f3f4f6; width: 30px; height: 30px; border-radius: 50%; font-size: 16px; cursor: pointer; color: #4b5563;">✕</button>
            </div>
        </div>

        <!-- Customer & Delivery Info -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; background: #fbfdfb; border: 1px solid var(--food-border); border-radius: 12px; padding: 14px 16px; margin-bottom: 20px;">
            <div>
                <small style="font-size: 10px; font-weight: 700; color: var(--food-muted); text-transform: uppercase;">CUSTOMER DETAILS</small>
                <div id="invCustomerName" style="font-size: 13.5px; font-weight: 700; color: var(--food-ink); margin-top: 2px;"></div>
                <div id="invCustomerPhone" style="font-size: 12px; color: var(--food-muted);"></div>
                <div id="invCustomerEmail" style="font-size: 11.5px; color: var(--food-faint);"></div>
            </div>
            <div>
                <small style="font-size: 10px; font-weight: 700; color: var(--food-muted); text-transform: uppercase;">PAYMENT & DELIVERY</small>
                <div id="invPaymentMethod" style="font-size: 13px; font-weight: 700; color: var(--food-primary); margin-top: 2px;"></div>
                <div id="invShippingAddress" style="font-size: 11.5px; color: var(--food-muted); margin-top: 2px; line-height: 1.35;"></div>
            </div>
        </div>

        <!-- Items Table -->
        <h4 style="margin: 0 0 10px; font-size: 13px; font-weight: 700; color: var(--food-ink);">Ordered Items</h4>
        <div style="border: 1px solid var(--food-border); border-radius: 10px; overflow: hidden; margin-bottom: 16px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 12.5px;">
                <thead>
                    <tr style="background: #f8faf8; border-bottom: 1px solid var(--food-border); text-align: left;">
                        <th style="padding: 8px 12px; font-size: 10.5px; color: var(--food-muted);">Item</th>
                        <th style="padding: 8px 12px; font-size: 10.5px; color: var(--food-muted); text-align: center;">Qty</th>
                        <th style="padding: 8px 12px; font-size: 10.5px; color: var(--food-muted); text-align: right;">Price</th>
                        <th style="padding: 8px 12px; font-size: 10.5px; color: var(--food-muted); text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody id="invItemsList">
                    <!-- Populated dynamically -->
                </tbody>
            </table>
        </div>

        <!-- Grand Total Row -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed var(--food-border); padding-top: 12px; margin-bottom: 20px;">
            <span style="font-size: 14px; font-weight: 700; color: var(--food-ink);">Grand Total:</span>
            <span id="invGrandTotal" style="font-size: 20px; font-weight: 800; color: var(--food-primary);">$0.00</span>
        </div>

        <!-- Modal Actions -->
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
            <a id="invFullPageBtn" href="#" class="admin-secondary-button" style="font-size: 12px;">Full Details Page →</a>
            <div style="display: flex; gap: 8px;">
                <button type="button" onclick="window.print()" class="admin-primary-button" style="font-size: 12px; padding: 8px 16px;">
                    <span>🖨️ Print Receipt</span>
                </button>
                <button type="button" onclick="closeOrderInvoiceModal()" class="admin-secondary-button" style="font-size: 12px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Image Lightbox Modal -->
<div id="imageLightboxModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); backdrop-filter: blur(4px); z-index: 10000; align-items: center; justify-content: center; cursor: pointer;" onclick="closeImageLightbox()">
    <div style="background: #ffffff; border-radius: 16px; padding: 16px; max-width: 480px; width: 90%; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.3); position: relative;" onclick="event.stopPropagation()">
        <img id="lightboxImg" src="" alt="Product" style="width: 100%; height: 320px; object-fit: cover; border-radius: 12px; background: #f3f4f6;">
        <h4 id="lightboxTitle" style="margin: 12px 0 4px; font-size: 15px; font-weight: 700; color: var(--food-ink);"></h4>
        <button type="button" onclick="closeImageLightbox()" style="margin-top: 10px; background: var(--food-primary); color: #fff; border: none; padding: 7px 18px; border-radius: 8px; font-weight: 700; cursor: pointer;">Close Preview</button>
    </div>
</div>

<!-- Floating Toast Container -->
<div id="adminToastContainer" class="admin-toast-container"></div>

<!-- Interactive Client-side Script -->
<script>
const csrfToken = '{{ csrf_token() }}';

// 1. Instant Fulfillment Status Update via AJAX
async function updateFulfillmentStatus(id, selectEl) {
    const newStatus = selectEl.value;
    selectEl.disabled = true;
    selectEl.style.opacity = '0.6';

    try {
        const response = await fetch(`/admin/orders/${id}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                order_status: newStatus
            })
        });

        const data = await response.json();
        if (data.success) {
            // Update class name on the select dropdown
            selectEl.className = `order-status-select status-${newStatus}`;

            // Update top stats and tabs
            if (data.stats) {
                updateOrderStats(data.stats);
            }

            showToast(data.message, '✓');
        }
    } catch (err) {
        console.error(err);
        showToast('Failed to update order status', '⚠️');
    } finally {
        selectEl.disabled = false;
        selectEl.style.opacity = '1';
    }
}

// 2. Update Top Stat Cards & Tabs
function updateOrderStats(stats) {
    if (stats.total_orders !== undefined) {
        document.getElementById('statTotalOrders').textContent = stats.total_orders;
        const tabAll = document.getElementById('tabCountAll');
        if (tabAll) tabAll.textContent = stats.total_orders;
    }
    if (stats.total_revenue !== undefined) {
        document.getElementById('statPaidRevenue').textContent = '$' + Number(stats.total_revenue).toLocaleString('en-US', { minimumFractionDigits: 2 });
    }
    if (stats.processing_count !== undefined) {
        document.getElementById('statProcessingCount').textContent = stats.processing_count;
        const tabProc = document.getElementById('tabCountProcessing');
        if (tabProc) tabProc.textContent = stats.processing_count;
    }
    if (stats.delivered_count !== undefined) {
        document.getElementById('statDeliveredCount').textContent = stats.delivered_count;
        const tabDeliv = document.getElementById('tabCountDelivered');
        if (tabDeliv) tabDeliv.textContent = stats.delivered_count;
    }
    if (stats.pending_count !== undefined) {
        const tabPend = document.getElementById('tabCountPending');
        if (tabPend) tabPend.textContent = stats.pending_count;
    }
    if (stats.shipped_count !== undefined) {
        const tabShip = document.getElementById('tabCountShipped');
        if (tabShip) tabShip.textContent = stats.shipped_count;
    }
    if (stats.cancelled_count !== undefined) {
        const tabCanc = document.getElementById('tabCountCancelled');
        if (tabCanc) tabCanc.textContent = stats.cancelled_count;
    }
}

// 3. Bulk Order Selection & Actions
function toggleSelectAllOrders(master) {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = master.checked;
        const row = document.getElementById(`orderRow-${cb.value}`);
        if (row) row.classList.toggle('is-selected-row', cb.checked);
    });
    updateBulkOrderToolbar();
}

function onOrderCheckboxChange() {
    const checkboxes = document.querySelectorAll('.order-checkbox');
    const checkedCount = document.querySelectorAll('.order-checkbox:checked').length;
    const master = document.getElementById('selectAllOrdersCheckbox');

    if (master) {
        master.checked = checkedCount === checkboxes.length && checkboxes.length > 0;
        master.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
    }

    checkboxes.forEach(cb => {
        const row = document.getElementById(`orderRow-${cb.value}`);
        if (row) row.classList.toggle('is-selected-row', cb.checked);
    });

    updateBulkOrderToolbar();
}

function updateBulkOrderToolbar() {
    const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
    const toolbar = document.getElementById('bulkToolbar');
    const countBadge = document.getElementById('bulkSelectedCount');

    if (checkedBoxes.length > 0) {
        countBadge.textContent = checkedBoxes.length;
        toolbar.classList.add('is-visible');
    } else {
        toolbar.classList.remove('is-visible');
    }
}

function clearAllOrderSelections() {
    document.querySelectorAll('.order-checkbox').forEach(cb => {
        cb.checked = false;
        const row = document.getElementById(`orderRow-${cb.value}`);
        if (row) row.classList.remove('is-selected-row');
    });
    const master = document.getElementById('selectAllOrdersCheckbox');
    if (master) {
        master.checked = false;
        master.indeterminate = false;
    }
    updateBulkOrderToolbar();
}

async function executeBulkOrderAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.order-checkbox:checked')).map(cb => parseInt(cb.value));
    if (selectedIds.length === 0) return;

    if (action === 'delete') {
        if (!confirm(`Are you sure you want to delete ${selectedIds.length} selected orders? This action cannot be undone.`)) {
            return;
        }
    }

    try {
        const response = await fetch('/admin/orders/bulk-action', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: action,
                ids: selectedIds
            })
        });

        const data = await response.json();
        if (data.success) {
            showToast(data.message, '✓');
            setTimeout(() => window.location.reload(), 600);
        }
    } catch (err) {
        console.error(err);
        showToast('Bulk action failed', '⚠️');
    }
}

// 4. Quick Order Invoice Modal
function openOrderInvoiceModal(orderId) {
    const jsonEl = document.getElementById('orderDataJson-' + orderId);
    if (!jsonEl) return;

    const order = JSON.parse(jsonEl.textContent);
    document.getElementById('invOrderNumber').textContent = '#' + order.order_number;
    document.getElementById('invDate').textContent = 'Placed on ' + order.date;
    document.getElementById('invCustomerName').textContent = order.customer_name;
    document.getElementById('invCustomerPhone').textContent = order.customer_phone || 'No phone provided';
    document.getElementById('invCustomerEmail').textContent = order.customer_email || '';
    document.getElementById('invPaymentMethod').textContent = order.payment_method + ' (' + order.payment_status.toUpperCase() + ')';
    document.getElementById('invShippingAddress').textContent = order.shipping_address || 'Standard store delivery';
    document.getElementById('invGrandTotal').textContent = '$' + Number(order.total_amount).toFixed(2);
    document.getElementById('invFullPageBtn').href = order.view_url;

    // Status pill
    const statusBadge = document.getElementById('invStatusBadge');
    statusBadge.textContent = order.order_status.toUpperCase();
    statusBadge.className = `pay-status-pill pay-${order.order_status === 'delivered' ? 'paid' : (order.order_status === 'pending' ? 'pending' : 'paid')}`;

    // Items list
    const tbody = document.getElementById('invItemsList');
    tbody.innerHTML = '';
    if (Array.isArray(order.items)) {
        order.items.forEach(it => {
            const tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid #f1f4f1';
            tr.innerHTML = `
                <td style="padding: 10px 12px; display: flex; align-items: center; gap: 8px;">
                    ${it.image ? `<img src="${it.image}" style="width: 32px; height: 32px; border-radius: 6px; object-fit: cover;">` : ''}
                    <strong>${it.name || 'Item'}</strong>
                </td>
                <td style="padding: 10px 12px; text-align: center;">x${it.quantity || 1}</td>
                <td style="padding: 10px 12px; text-align: right;">$${Number(it.price || 0).toFixed(2)}</td>
                <td style="padding: 10px 12px; text-align: right; font-weight: 700;">$${(Number(it.price || 0) * (it.quantity || 1)).toFixed(2)}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    const modal = document.getElementById('orderInvoiceModal');
    modal.style.display = 'flex';
}

function closeOrderInvoiceModal() {
    document.getElementById('orderInvoiceModal').style.display = 'none';
}

// 5. Client-side Real-time Search Filter
function filterOrdersClientSide(q) {
    const query = q.toLowerCase().trim();
    document.querySelectorAll('.order-row').forEach(row => {
        const text = row.getAttribute('data-search') || '';
        row.style.display = (query === '' || text.includes(query)) ? '' : 'none';
    });
}

// 6. Image Lightbox
function previewImage(src, title) {
    if (!src) return;
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxTitle').textContent = title;
    const modal = document.getElementById('imageLightboxModal');
    modal.style.display = 'flex';
}

function closeImageLightbox() {
    document.getElementById('imageLightboxModal').style.display = 'none';
}

// 7. Toast Notification Utility
function showToast(message, icon = '✓') {
    const container = document.getElementById('adminToastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = 'admin-toast';
    toast.innerHTML = `<span class="admin-toast-icon">${icon}</span><span>${message}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(8px)';
// 8. Create Order Modal handlers
function openCreateOrderModal() {
    const modal = document.getElementById('createOrderModal');
    if (modal) modal.style.display = 'flex';
}

function closeCreateOrderModal() {
    const modal = document.getElementById('createOrderModal');
    if (modal) modal.style.display = 'none';
}

async function submitAdminCreateOrder(e) {
    e.preventDefault();
    const form = document.getElementById('createOrderForm');
    const btn = document.getElementById('saveOrderBtn');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    const payload = {
        customer_name: form.customer_name.value.trim(),
        customer_phone: form.customer_phone.value.trim(),
        customer_email: form.customer_email.value.trim(),
        shipping_address: form.shipping_address.value.trim(),
        total_amount: parseFloat(form.total_amount.value) || 0,
        payment_method: form.payment_method.value,
        payment_status: form.payment_status.value,
        order_status: form.order_status.value,
        notes: form.notes.value.trim(),
        items: [
            {
                name: form.item_name.value.trim(),
                price: parseFloat(form.total_amount.value) || 0,
                quantity: 1,
                image: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80'
            }
        ]
    };

    try {
        const response = await fetch("{{ route('admin.orders.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();
        if (response.ok && data.success) {
            showToast('Order #' + data.order.order_number + ' created successfully!');
            setTimeout(() => window.location.reload(), 800);
        } else {
            alert(data.message || 'Failed to create order.');
            btn.disabled = false;
            btn.textContent = 'Create Order';
        }
    } catch (err) {
        console.error(err);
        alert('Server connection error.');
        btn.disabled = false;
        btn.textContent = 'Create Order';
    }
}
</script>

<!-- Create Order Modal -->
<div id="createOrderModal" class="modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div class="modal-card" style="background: #ffffff; border-radius: 16px; width: 620px; max-width: 100%; max-height: 90vh; overflow-y: auto; padding: 26px; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 24px;">📝</span>
                <div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: #10291f;">Create New Customer Order</h3>
                    <small style="color: #64748b; font-size: 12px;">Record phone call, Telegram, or Facebook buyer transactions</small>
                </div>
            </div>
            <button type="button" onclick="closeCreateOrderModal()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; padding: 4px;">✕</button>
        </div>

        <form id="createOrderForm" onsubmit="submitAdminCreateOrder(event)">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Customer Name (ឈ្មោះអតិថិជន) *</label>
                    <input type="text" name="customer_name" required placeholder="e.g. Sok Chantha" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 12px; font-size: 13px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Customer Phone (លេខទូរស័ព្ទ / Telegram) *</label>
                    <input type="tel" name="customer_phone" required placeholder="071 450 4547" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 12px; font-size: 13px; box-sizing: border-box;">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Email (Optional)</label>
                <input type="email" name="customer_email" placeholder="customer@gmail.com" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 12px; font-size: 13px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Shipping Address (អាសយដ្ឋានដឹកជញ្ជូន) *</label>
                <textarea name="shipping_address" required rows="2" placeholder="e.g. St. 310, Sangkat BKK1, Khan BKK, Phnom Penh" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 12px; font-size: 13px; box-sizing: border-box;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Product Item Name *</label>
                    <input type="text" name="item_name" value="Everyday Urban Backpack" required style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 12px; font-size: 13px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Total Order Amount ($) *</label>
                    <input type="number" step="0.01" name="total_amount" value="28.00" required style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 12px; font-size: 13px; box-sizing: border-box;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Payment Method</label>
                    <select name="payment_method" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 10px; font-size: 13px; box-sizing: border-box;">
                        <option value="ABA PAY (KHQR)">ABA PAY (KHQR)</option>
                        <option value="Bakong KHQR">Bakong KHQR</option>
                        <option value="Wing Bank">Wing Bank</option>
                        <option value="Cash on Delivery (COD)">Cash on Delivery</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Payment Status</label>
                    <select name="payment_status" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 10px; font-size: 13px; box-sizing: border-box;">
                        <option value="paid" selected>Paid (បានទូទាត់)</option>
                        <option value="pending">Pending (មិនទាន់ទូទាត់)</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Order Status</label>
                    <select name="order_status" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 10px; font-size: 13px; box-sizing: border-box;">
                        <option value="processing" selected>Processing</option>
                        <option value="pending">Pending</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 5px;">Internal Notes</label>
                <input type="text" name="notes" placeholder="e.g. Phone order via Telegram" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 9px 12px; font-size: 13px; box-sizing: border-box;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeCreateOrderModal()" style="background: #f1f5f9; color: #475569; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: pointer;">Cancel</button>
                <button type="submit" id="saveOrderBtn" style="background: #245943; color: #ffffff; border: none; padding: 10px 22px; border-radius: 8px; font-weight: 700; cursor: pointer;">Create Order</button>
            </div>
        </form>
    </div>
</div>
@endsection
