@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')
<div class="admin-analytics-view">
    <!-- Header with Breadcrumb & Time Range Filter -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">STORE PERFORMANCE & INTELLIGENCE</span>
            <h1>Business Analytics</h1>
            <p>Track live sales revenue, average order value, conversion trends, and top-selling product categories.</p>
        </div>
        <div class="heading-actions">
            <!-- Time Range Selector Pills -->
            <div class="analytics-range-selector">
                <a href="{{ route('admin.analytics.index', ['range' => '7d']) }}" class="range-pill {{ $range === '7d' ? 'is-active' : '' }}">Last 7 Days</a>
                <a href="{{ route('admin.analytics.index', ['range' => '30d']) }}" class="range-pill {{ $range === '30d' ? 'is-active' : '' }}">Last 30 Days</a>
                <a href="{{ route('admin.analytics.index', ['range' => 'this_month']) }}" class="range-pill {{ $range === 'this_month' ? 'is-active' : '' }}">This Month</a>
                <a href="{{ route('admin.analytics.index', ['range' => 'all']) }}" class="range-pill {{ $range === 'all' ? 'is-active' : '' }}">All Time</a>
            </div>

            <a href="{{ route('admin.report.export') }}" class="admin-secondary-button">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export Report</span>
            </a>
        </div>
    </div>

    <!-- Financial & Growth KPI Cards -->
    <div class="analytics-kpi-grid">
        <div class="analytics-kpi-card highlight-revenue">
            <div class="kpi-header">
                <span class="kpi-label">Gross Revenue</span>
                <span class="kpi-growth-badge positive">↗ +18.4%</span>
            </div>
            <div class="kpi-value">${{ number_format($kpis['total_revenue'], 2) }}</div>
            <div class="kpi-subtext">From {{ $kpis['total_orders'] }} customer orders</div>
        </div>

        <div class="analytics-kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Total Orders</span>
                <span class="kpi-growth-badge neutral">Active</span>
            </div>
            <div class="kpi-value">{{ $kpis['total_orders'] }}</div>
            <div class="kpi-subtext">Completed & processing</div>
        </div>

        <div class="analytics-kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Avg. Order Value (AOV)</span>
                <span class="kpi-growth-badge positive">↗ +$12.50</span>
            </div>
            <div class="kpi-value">${{ number_format($kpis['avg_order_value'], 2) }}</div>
            <div class="kpi-subtext">Average spend per buyer</div>
        </div>

        <div class="analytics-kpi-card">
            <div class="kpi-header">
                <span class="kpi-label">Fulfillment Rate</span>
                <span class="kpi-growth-badge positive">{{ $kpis['completion_rate'] }}%</span>
            </div>
            <div class="kpi-value">{{ $kpis['completion_rate'] }}%</div>
            <div class="kpi-subtext">Delivered on schedule</div>
        </div>
    </div>

    <!-- Revenue & Sales Trend Chart Panel -->
    <section class="admin-panel analytics-chart-panel">
        <div class="chart-panel-header">
            <div>
                <h3 class="chart-title">Revenue & Sales Trends</h3>
                <p class="chart-subtitle">Daily sales volume in USD over the selected period ({{ $range === '30d' ? '30 Days' : ($range === 'this_month' ? 'This Month' : 'Last 7 Days') }})</p>
            </div>
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-dot" style="background: var(--food-primary);"></span>
                    <span>Daily Sales ($)</span>
                </div>
            </div>
        </div>

        <!-- Interactive CSS Bar Chart -->
        <div class="analytics-barchart-wrap">
            <div class="barchart-container">
                @foreach ($chartData as $bar)
                    <div class="barchart-col" title="{{ $bar['label'] }}: ${{ number_format($bar['revenue'], 2) }} ({{ $bar['orders'] }} orders)">
                        <div class="bar-value-tooltip">${{ number_format($bar['revenue'], 0) }}</div>
                        <div class="barchart-bar-track">
                            <div class="barchart-bar-fill {{ $bar['revenue'] > 0 ? 'has-sales' : '' }}" style="height: {{ $bar['height_pct'] }}%;"></div>
                        </div>
                        <div class="barchart-label">{{ $bar['day_name'] ?? $bar['label'] }}</div>
                        <div class="barchart-date-sub">{{ explode(' ', $bar['label'])[1] ?? '' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Two-Column Analytics Grid: Breakdown & Top Sellers -->
    <div class="analytics-two-col-grid">
        <!-- Left Column: Category Performance & Payment Methods -->
        <div class="analytics-col-stack">
            <!-- Category Revenue Share -->
            <section class="admin-panel analytics-card">
                <div class="card-header-simple">
                    <h3>Category Revenue Share</h3>
                    <span class="badge-subtle">By Catalog Volume</span>
                </div>
                <div class="category-breakdown-list">
                    @foreach ($categoryBreakdown as $cat)
                        <div class="category-stat-row">
                            <div class="cat-stat-head">
                                <div class="cat-stat-name">
                                    <span class="cat-color-dot" style="background-color: {{ $cat['color'] }};"></span>
                                    <span class="cat-title">{{ $cat['name'] }}</span>
                                </div>
                                <div class="cat-stat-numbers">
                                    <span class="cat-revenue">${{ number_format($cat['revenue'], 2) }}</span>
                                    <span class="cat-pct">({{ $cat['share_pct'] }}%)</span>
                                </div>
                            </div>
                            <div class="cat-progress-track">
                                <div class="cat-progress-bar" style="width: {{ $cat['share_pct'] }}%; background-color: {{ $cat['color'] }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Payment Methods Share -->
            <section class="admin-panel analytics-card">
                <div class="card-header-simple">
                    <h3>Payment Methods Distribution</h3>
                    <span class="badge-subtle">Customer Preference</span>
                </div>
                <div class="payment-methods-grid">
                    @foreach ($paymentBreakdown as $pay)
                        <div class="payment-method-box">
                            <div class="pay-method-top">
                                <span class="pay-dot" style="background: {{ $pay['color'] }};"></span>
                                <span class="pay-title">{{ $pay['method'] }}</span>
                            </div>
                            <div class="pay-stat-pct">{{ $pay['percentage'] }}%</div>
                            <div class="pay-orders-count">{{ $pay['count'] }} orders</div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Right Column: Top Performing Products -->
        <div class="analytics-col-stack">
            <section class="admin-panel analytics-card">
                <div class="card-header-simple">
                    <h3>Top Performing Products</h3>
                    <a href="{{ route('admin.products.index') }}" class="view-all-link">View All Products →</a>
                </div>

                <div class="top-products-list">
                    @foreach ($topProducts as $item)
                        <div class="top-product-row">
                            <div class="product-rank-badge rank-{{ $item['rank'] }}">
                                #{{ $item['rank'] }}
                            </div>
                            <div class="top-product-thumb">
                                <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name_en }}" loading="lazy" onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'50\' height=\'50\' viewBox=\'0 0 50 50\'><rect width=\'50\' height=\'50\' fill=\'%23edf5ed\'/><text x=\'25\' y=\'30\' font-size=\'18\' text-anchor=\'middle\'>🛍️</text></svg>';">
                            </div>
                            <div class="top-product-details">
                                <a href="{{ route('admin.products.edit', $item['product']) }}" class="top-product-name">{{ $item['product']->name_en }}</a>
                                <span class="top-product-cat">{{ ucfirst($item['product']->category) }}</span>
                            </div>
                            <div class="top-product-sales">
                                <span class="units-sold">{{ $item['units'] }} sold</span>
                                <span class="sales-rev">${{ number_format($item['revenue'], 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Regional Shipping Distribution -->
            <section class="admin-panel analytics-card">
                <div class="card-header-simple">
                    <h3>Regional Deliveries</h3>
                    <span class="badge-subtle">Cambodia Provinces</span>
                </div>
                <div class="region-stats-list">
                    <div class="region-row">
                        <span class="region-name">📍 Phnom Penh (Capital)</span>
                        <div class="region-bar-wrap">
                            <div class="region-bar" style="width: 72%; background: var(--food-primary);"></div>
                        </div>
                        <span class="region-pct">72%</span>
                    </div>
                    <div class="region-row">
                        <span class="region-name">📍 Siem Reap</span>
                        <div class="region-bar-wrap">
                            <div class="region-bar" style="width: 14%; background: var(--food-accent);"></div>
                        </div>
                        <span class="region-pct">14%</span>
                    </div>
                    <div class="region-row">
                        <span class="region-name">📍 Battambang</span>
                        <div class="region-bar-wrap">
                            <div class="region-bar" style="width: 8%; background: #2563eb;"></div>
                        </div>
                        <span class="region-pct">8%</span>
                    </div>
                    <div class="region-row">
                        <span class="region-name">📍 Sihanoukville</span>
                        <div class="region-bar-wrap">
                            <div class="region-bar" style="width: 6%; background: #7d8981;"></div>
                        </div>
                        <span class="region-pct">6%</span>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
