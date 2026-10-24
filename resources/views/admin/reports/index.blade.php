@extends('admin.layouts.app')

@section('title', 'Reports & Data Exports')

@section('content')
<div class="admin-reports-view">
    <!-- Header with Breadcrumbs & Print/Export Actions -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">EXPORT & AUDIT INTELLIGENCE</span>
            <h1>Reports & Data Exports</h1>
            <p>Generate verified accounting, inventory valuation, and transaction audit reports with instant CSV downloads.</p>
        </div>
        <div class="heading-actions">
            <button type="button" onclick="window.print()" class="admin-secondary-button">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span>Print Document</span>
            </button>
            <a href="{{ route('admin.reports.export.'.$type) }}" class="admin-primary-button">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Download Active CSV</span>
            </a>
        </div>
    </div>

    <!-- Summary KPI Metric Cards -->
    <div class="reports-kpi-grid">
        <div class="report-kpi-card">
            <div class="report-kpi-icon icon-revenue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
            </div>
            <div class="report-kpi-info">
                <span class="report-kpi-label">Gross Revenue (Period)</span>
                <span class="report-kpi-val text-success">${{ number_format($kpis['total_revenue'], 2) }}</span>
            </div>
        </div>

        <div class="report-kpi-card">
            <div class="report-kpi-icon icon-orders">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </div>
            <div class="report-kpi-info">
                <span class="report-kpi-label">Orders Logged</span>
                <span class="report-kpi-val">{{ $kpis['total_orders'] }}</span>
            </div>
        </div>

        <div class="report-kpi-card">
            <div class="report-kpi-icon icon-inventory">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <div class="report-kpi-info">
                <span class="report-kpi-label">Inventory Asset Value</span>
                <span class="report-kpi-val text-amber">${{ number_format($kpis['total_valuation'], 2) }}</span>
            </div>
        </div>

        <div class="report-kpi-card">
            <div class="report-kpi-icon icon-customers">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                </svg>
            </div>
            <div class="report-kpi-info">
                <span class="report-kpi-label">Active Customers</span>
                <span class="report-kpi-val">{{ $kpis['total_customers'] }}</span>
            </div>
        </div>
    </div>

    <!-- 4 Report Suite Catalog Cards -->
    <div class="report-types-grid">
        <!-- Report 1: Sales & Revenue -->
        <div class="report-type-card {{ $type === 'sales' ? 'is-selected' : '' }}">
            <div class="report-card-top">
                <div class="report-card-icon icon-sales-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <span class="report-badge badge-finance">FINANCIAL</span>
            </div>
            <h3 class="report-card-title">Sales & Revenue Report</h3>
            <p class="report-card-desc">Detailed accounting breakdown of paid orders, customer expenditures, shipping fees, and net revenue.</p>
            <div class="report-card-actions">
                <a href="{{ route('admin.reports.index', ['type' => 'sales', 'range' => $range]) }}" class="btn-report-preview {{ $type === 'sales' ? 'is-current' : '' }}">
                    <span>Preview On-Screen</span>
                </a>
                <a href="{{ route('admin.reports.export.sales') }}" class="btn-report-csv" title="Download CSV">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>CSV</span>
                </a>
            </div>
        </div>

        <!-- Report 2: Inventory Valuation -->
        <div class="report-type-card {{ $type === 'inventory' ? 'is-selected' : '' }}">
            <div class="report-card-top">
                <div class="report-card-icon icon-inv-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <span class="report-badge badge-warehouse">WAREHOUSE</span>
            </div>
            <h3 class="report-card-title">Inventory Valuation</h3>
            <p class="report-card-desc">Complete catalog audit with SKU codes, unit costs, stock reserves, low-stock alerts, and asset valuations.</p>
            <div class="report-card-actions">
                <a href="{{ route('admin.reports.index', ['type' => 'inventory', 'range' => $range]) }}" class="btn-report-preview {{ $type === 'inventory' ? 'is-current' : '' }}">
                    <span>Preview On-Screen</span>
                </a>
                <a href="{{ route('admin.reports.export.inventory') }}" class="btn-report-csv" title="Download CSV">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>CSV</span>
                </a>
            </div>
        </div>

        <!-- Report 3: Customer Orders Audit -->
        <div class="report-type-card {{ $type === 'orders' ? 'is-selected' : '' }}">
            <div class="report-card-top">
                <div class="report-card-icon icon-ord-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <span class="report-badge badge-ops">OPERATIONS</span>
            </div>
            <h3 class="report-card-title">Customer Orders Audit</h3>
            <p class="report-card-desc">Tracking numbers, delivery addresses, customer contacts, payment status flags, and timestamps.</p>
            <div class="report-card-actions">
                <a href="{{ route('admin.reports.index', ['type' => 'orders', 'range' => $range]) }}" class="btn-report-preview {{ $type === 'orders' ? 'is-current' : '' }}">
                    <span>Preview On-Screen</span>
                </a>
                <a href="{{ route('admin.reports.export.orders') }}" class="btn-report-csv" title="Download CSV">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>CSV</span>
                </a>
            </div>
        </div>

        <!-- Report 4: Customers & CRM -->
        <div class="report-type-card {{ $type === 'customers' ? 'is-selected' : '' }}">
            <div class="report-card-top">
                <div class="report-card-icon icon-crm-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                </div>
                <span class="report-badge badge-crm">DIRECTORY</span>
            </div>
            <h3 class="report-card-title">Customers Directory</h3>
            <p class="report-card-desc">Registered buyer accounts, email verification states, registration dates, and security privilege audits.</p>
            <div class="report-card-actions">
                <a href="{{ route('admin.reports.index', ['type' => 'customers', 'range' => $range]) }}" class="btn-report-preview {{ $type === 'customers' ? 'is-current' : '' }}">
                    <span>Preview On-Screen</span>
                </a>
                <a href="{{ route('admin.reports.export.customers') }}" class="btn-report-csv" title="Download CSV">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>CSV</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Live Report Preview Panel -->
    <section class="admin-panel report-preview-panel">
        <div class="report-preview-header">
            <div>
                <h3 class="report-preview-title">
                    @if ($type === 'inventory')
                        📦 Product Inventory Valuation Report ({{ $reportData->count() }} items)
                    @elseif ($type === 'orders')
                        📑 Customer Orders Audit Log ({{ $reportData->count() }} records)
                    @elseif ($type === 'customers')
                        👥 Registered Customers Directory ({{ $reportData->count() }} accounts)
                    @else
                        📊 Sales & Revenue Accounting Report ({{ $reportData->count() }} transactions)
                    @endif
                </h3>
                <p class="report-preview-sub">Generated live on {{ now()->format('M d, Y - h:i A') }} • Filtered for current view</p>
            </div>

            <!-- Range Filter Form -->
            <form action="{{ route('admin.reports.index') }}" method="GET" class="report-filter-form">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="filter-select-wrapper">
                    <label class="filter-label">Period</label>
                    <select name="range" onchange="this.form.submit()">
                        <option value="today" @selected($range === 'today')>Today</option>
                        <option value="last_7_days" @selected($range === 'last_7_days')>Last 7 Days</option>
                        <option value="this_month" @selected($range === 'this_month')>This Month</option>
                        <option value="last_month" @selected($range === 'last_month')>Last Month</option>
                        <option value="all_time" @selected($range === 'all_time')>All Time</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Table View depending on report type -->
        <div class="admin-table-wrap">
            @if ($type === 'inventory')
                <!-- Inventory Report Table -->
                <table class="admin-table modern-products-table">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Unit Price</th>
                            <th>Stock Units</th>
                            <th>Status</th>
                            <th>Total Asset Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reportData as $product)
                            <tr>
                                <td><span class="sku-code-badge">{{ $product->sku }}</span></td>
                                <td>
                                    <strong>{{ $product->name_en }}</strong>
                                    <div style="font-size: 11px; color: var(--food-muted);">{{ $product->name_km }}</div>
                                </td>
                                <td><span class="cat-badge cat-{{ $product->category }}">{{ ucfirst($product->category) }}</span></td>
                                <td><span class="price-current">${{ number_format((float) $product->price, 2) }}</span></td>
                                <td><strong>{{ $product->stock ?? 45 }} units</strong></td>
                                <td>
                                    @if (($product->stock ?? 45) <= 0)
                                        <span class="stock-status-pill is-out-of-stock"><span class="status-dot"></span>Out of stock</span>
                                    @elseif (($product->stock ?? 45) <= 10)
                                        <span class="stock-status-pill is-low-stock"><span class="status-dot"></span>Low stock</span>
                                    @else
                                        <span class="stock-status-pill is-in-stock"><span class="status-dot"></span>In stock</span>
                                    @endif
                                </td>
                                <td><strong class="order-total-price">${{ number_format(((float) $product->price) * ($product->stock ?? 45), 2) }}</strong></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="admin-empty-state">No inventory records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>

            @elseif ($type === 'orders')
                <!-- Orders Audit Table -->
                <table class="admin-table modern-products-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>City / Address</th>
                            <th>Payment Method</th>
                            <th>Order Status</th>
                            <th>Total Amount</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reportData as $order)
                            <tr>
                                <td><strong class="order-number-text">{{ $order->order_number }}</strong></td>
                                <td>
                                    <strong>{{ $order->customer_name }}</strong>
                                    <div style="font-size: 11px; color: var(--food-muted);">{{ $order->customer_email }}</div>
                                </td>
                                <td style="max-width: 200px; font-size: 11.5px; color: var(--food-ink-light);">{{ $order->shipping_address ?? 'Phnom Penh' }}</td>
                                <td><span class="payment-method-pill">{{ $order->payment_method }}</span></td>
                                <td><span class="order-status-badge status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span></td>
                                <td><strong class="order-total-price">${{ number_format((float) $order->total_amount, 2) }}</strong></td>
                                <td style="font-size: 11.5px; color: var(--food-muted);">{{ $order->created_at?->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="admin-empty-state">No order transactions found for this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>

            @elseif ($type === 'customers')
                <!-- Customers Table -->
                <table class="admin-table modern-products-table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Customer Name</th>
                            <th>Email Address</th>
                            <th>Account Role</th>
                            <th>Email Verification</th>
                            <th>Registered Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reportData as $cust)
                            <tr>
                                <td><span class="sku-code-badge">USR-{{ str_pad($cust->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td><strong>{{ $cust->name }}</strong></td>
                                <td><a href="mailto:{{ $cust->email }}" style="color: var(--food-primary);">{{ $cust->email }}</a></td>
                                <td><span class="report-badge badge-crm">{{ $cust->is_admin ? 'Admin' : 'Customer' }}</span></td>
                                <td>
                                    @if ($cust->email_verified_at)
                                        <span class="stock-status-pill is-in-stock"><span class="status-dot"></span>Verified</span>
                                    @else
                                        <span class="stock-status-pill is-low-stock"><span class="status-dot"></span>Unverified</span>
                                    @endif
                                </td>
                                <td style="font-size: 11.5px; color: var(--food-muted);">{{ $cust->created_at?->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="admin-empty-state">No registered customers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>

            @else
                <!-- Sales & Revenue Table -->
                <table class="admin-table modern-products-table">
                    <thead>
                        <tr>
                            <th>Transaction</th>
                            <th>Customer Name</th>
                            <th>Payment Gateway</th>
                            <th>Payment Status</th>
                            <th>Gross Sale</th>
                            <th>Fulfillment</th>
                            <th>Recorded Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reportData as $order)
                            <tr>
                                <td><strong class="order-number-text">{{ $order->order_number }}</strong></td>
                                <td>
                                    <strong>{{ $order->customer_name }}</strong>
                                    <div style="font-size: 11px; color: var(--food-muted);">{{ $order->customer_phone ?? 'N/A' }}</div>
                                </td>
                                <td><span class="payment-method-pill">{{ $order->payment_method }}</span></td>
                                <td><span class="payment-status-badge payment-paid">✓ Paid</span></td>
                                <td><strong class="order-total-price">${{ number_format((float) $order->total_amount, 2) }}</strong></td>
                                <td><span class="order-status-badge status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span></td>
                                <td style="font-size: 11.5px; color: var(--food-muted);">{{ $order->created_at?->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="admin-empty-state">No paid sales recorded in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
    </section>
</div>
@endsection
