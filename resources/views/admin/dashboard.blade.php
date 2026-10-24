@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="food-dashboard">
    <!-- Top Greeting & Action Header -->
    <section class="food-welcome-section">
        <div class="welcome-left">
            <h1 class="welcome-title">Good Morning, {{ \Illuminate\Support\Str::before(auth()->user()?->name ?? 'Admin', ' (') }}! 👋</h1>
            <p class="welcome-sub">Here’s what’s happening with Dara Market today. System is running at optimal performance.</p>
        </div>
        <div class="welcome-right">
            <div class="date-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span>{{ now()->format('d M Y') }}</span>
            </div>
            <a href="{{ route('admin.report.export') }}" class="btn-download-report" title="Export inventory report as CSV">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Download Report</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn-add-item">
                <span class="plus-icon">＋</span>
                <span>Add Product</span>
            </a>
        </div>
    </section>

    <!-- Top 4 KPI Metrics -->
    <section class="food-kpi-grid">
        <!-- 1. Total Revenue -->
        <div class="kpi-card" tabindex="0">
            <div class="kpi-header">
                <div class="kpi-icon-wrap icon-revenue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>
                <span class="kpi-title">Total Revenue</span>
            </div>
            <div class="kpi-body">
                <div class="kpi-metric-info">
                    <div class="kpi-value">${{ number_format($totalRevenue, 2) }}</div>
                    <div class="kpi-trend trend-up">
                        <span class="trend-arrow">↑</span> 8.2% <span class="trend-comp">vs Yesterday</span>
                    </div>
                </div>
                <!-- Sparkline Chart -->
                <div class="kpi-sparkline">
                    <svg viewBox="0 0 90 40" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradRev" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#245943" stop-opacity="0.38" />
                                <stop offset="100%" stop-color="#245943" stop-opacity="0.0" />
                            </linearGradient>
                        </defs>
                        <path d="M 0,32 Q 20,28 35,30 T 60,18 T 90,8 L 90,40 L 0,40 Z" fill="url(#gradRev)" />
                        <path d="M 0,32 Q 20,28 35,30 T 60,18 T 90,8" fill="none" stroke="#245943" stroke-width="2.2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- 2. Total Orders -->
        <a href="{{ route('admin.orders.index') }}" class="kpi-card kpi-card-link" tabindex="0">
            <div class="kpi-header">
                <div class="kpi-icon-wrap icon-orders">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div>
                <span class="kpi-title">Total Orders</span>
            </div>
            <div class="kpi-body">
                <div class="kpi-metric-info">
                    <div class="kpi-value">{{ number_format($totalOrders) }}</div>
                    <div class="kpi-trend trend-orange">
                        <span class="trend-arrow">↑</span> 6.2% <span class="trend-comp">vs Yesterday</span>
                    </div>
                </div>
                <!-- Sparkline Chart -->
                <div class="kpi-sparkline">
                    <svg viewBox="0 0 90 40" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradOrd" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#d8a962" stop-opacity="0.4" />
                                <stop offset="100%" stop-color="#d8a962" stop-opacity="0.0" />
                            </linearGradient>
                        </defs>
                        <path d="M 0,35 Q 25,32 40,25 T 65,30 T 90,12 L 90,40 L 0,40 Z" fill="url(#gradOrd)" />
                        <path d="M 0,35 Q 25,32 40,25 T 65,30 T 90,12" fill="none" stroke="#d8a962" stroke-width="2.2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- 3. New Customers -->
        <a href="{{ route('admin.customers.index') }}" class="kpi-card kpi-card-link" tabindex="0">
            <div class="kpi-header">
                <div class="kpi-icon-wrap icon-customers">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <span class="kpi-title">Customers</span>
            </div>
            <div class="kpi-body">
                <div class="kpi-metric-info">
                    <div class="kpi-value">{{ number_format($userCount ?? 52) }}</div>
                    <div class="kpi-trend trend-up">
                        <span class="trend-arrow">↑</span> 4.1% <span class="trend-comp">vs Yesterday</span>
                    </div>
                </div>
                <!-- Sparkline Chart -->
                <div class="kpi-sparkline">
                    <svg viewBox="0 0 90 40" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradCust" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#245943" stop-opacity="0.38" />
                                <stop offset="100%" stop-color="#245943" stop-opacity="0.0" />
                            </linearGradient>
                        </defs>
                        <path d="M 0,33 Q 20,33 40,28 T 65,15 T 90,10 L 90,40 L 0,40 Z" fill="url(#gradCust)" />
                        <path d="M 0,33 Q 20,33 40,28 T 65,15 T 90,10" fill="none" stroke="#245943" stroke-width="2.2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- 4. Average Order Value -->
        <div class="kpi-card" tabindex="0">
            <div class="kpi-header">
                <div class="kpi-icon-wrap icon-aov">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <span class="kpi-title">Avg. Order Value</span>
            </div>
            <div class="kpi-body">
                <div class="kpi-metric-info">
                    <div class="kpi-value">${{ number_format($avgOrderValue, 2) }}</div>
                    <div class="kpi-trend trend-up">
                        <span class="trend-arrow">↑</span> 2.4% <span class="trend-comp">vs Yesterday</span>
                    </div>
                </div>
                <!-- Sparkline Chart -->
                <div class="kpi-sparkline">
                    <svg viewBox="0 0 90 40" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradAov" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#b48234" stop-opacity="0.38" />
                                <stop offset="100%" stop-color="#b48234" stop-opacity="0.0" />
                            </linearGradient>
                        </defs>
                        <path d="M 0,32 Q 25,30 45,22 T 70,30 T 90,14 L 90,40 L 0,40 Z" fill="url(#gradAov)" />
                        <path d="M 0,32 Q 25,30 45,22 T 70,30 T 90,14" fill="none" stroke="#b48234" stroke-width="2.2" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Middle Row: Interactive Charts -->
    <div class="food-charts-grid">
        <!-- Interactive Revenue & Orders Trend -->
        <section class="food-card card-trend">
            <div class="card-head">
                <div>
                    <h3 class="card-title">Revenue & Orders Trend</h3>
                    <small style="color: var(--food-muted); font-size: 11px;">Interactive timeline performance tracking</small>
                </div>
                <div class="card-select-wrap">
                    <select class="card-select" id="trendPeriodSelect" onchange="changeTrendPeriod(this.value)">
                        <option value="today">Today</option>
                        <option value="week" selected>This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
            </div>

            <!-- Filter Controls and Legend -->
            <div class="trend-controls-bar">
                <div class="trend-tabs">
                    <button type="button" class="trend-tab" id="tabBtn-today" onclick="changeTrendPeriod('today')">Today</button>
                    <button type="button" class="trend-tab is-active" id="tabBtn-week" onclick="changeTrendPeriod('week')">This Week</button>
                    <button type="button" class="trend-tab" id="tabBtn-month" onclick="changeTrendPeriod('month')">This Month</button>
                </div>
                <div class="trend-legend">
                    <span class="legend-item"><span class="legend-bar bar-green"></span> Revenue ($)</span>
                    <span class="legend-item"><span class="legend-bar bar-orange"></span> Orders</span>
                </div>
            </div>

            <!-- Interactive Area/Line Chart -->
            <div class="trend-svg-container" style="position: relative;">
                <!-- Chart Hover Tooltip -->
                <div id="chartTooltip" class="chart-tooltip" style="display: none; position: absolute; pointer-events: none; z-index: 50;">
                    <div class="tooltip-time" id="ttTime">12 PM</div>
                    <div class="tooltip-metric"><span class="dot-green"></span> Revenue: <strong id="ttRev">$5,600</strong></div>
                    <div class="tooltip-metric"><span class="dot-orange"></span> Orders: <strong id="ttOrd">28</strong></div>
                </div>

                <!-- Y-Labels Left -->
                <div class="chart-y-left" id="chartYLabels">
                    <span>8K</span>
                    <span>6K</span>
                    <span>4K</span>
                    <span>2K</span>
                    <span>0</span>
                </div>

                <div class="chart-svg-wrap">
                    <svg viewBox="0 0 680 180" class="trend-svg" id="mainTrendSvg" preserveAspectRatio="none">
                        <defs>
                            <!-- Revenue Gradient (Forest Green) -->
                            <linearGradient id="foodRevArea" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#245943" stop-opacity="0.35" />
                                <stop offset="70%" stop-color="#245943" stop-opacity="0.08" />
                                <stop offset="100%" stop-color="#245943" stop-opacity="0.0" />
                            </linearGradient>
                            <!-- Orders Gradient (Accent Gold) -->
                            <linearGradient id="foodOrdArea" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#d8a962" stop-opacity="0.32" />
                                <stop offset="70%" stop-color="#d8a962" stop-opacity="0.06" />
                                <stop offset="100%" stop-color="#d8a962" stop-opacity="0.0" />
                            </linearGradient>
                        </defs>

                        <!-- Grid Horizontal Lines -->
                        <line x1="0" y1="18" x2="680" y2="18" stroke="#E8ECE8" stroke-width="1" stroke-dasharray="3 3"></line>
                        <line x1="0" y1="55" x2="680" y2="55" stroke="#E8ECE8" stroke-width="1" stroke-dasharray="3 3"></line>
                        <line x1="0" y1="92" x2="680" y2="92" stroke="#E8ECE8" stroke-width="1" stroke-dasharray="3 3"></line>
                        <line x1="0" y1="130" x2="680" y2="130" stroke="#E8ECE8" stroke-width="1" stroke-dasharray="3 3"></line>
                        <line x1="0" y1="165" x2="680" y2="165" stroke="#E8ECE8" stroke-width="1"></line>

                        <!-- Revenue Area & Path (Dynamic) -->
                        <path id="svgRevArea" d="M 0,145 C 50,145 100,135 150,130 C 200,125 250,120 300,105 C 330,70 360,25 380,25 C 410,25 430,95 470,105 C 520,118 560,70 590,75 C 630,85 650,115 680,125 L 680,165 L 0,165 Z" fill="url(#foodRevArea)" />
                        <path id="svgRevLine" d="M 0,145 C 50,145 100,135 150,130 C 200,125 250,120 300,105 C 330,70 360,25 380,25 C 410,25 430,95 470,105 C 520,118 560,70 590,75 C 630,85 650,115 680,125" fill="none" stroke="#245943" stroke-width="2.6" stroke-linecap="round" />

                        <!-- Orders Area & Path (Dynamic) -->
                        <path id="svgOrdArea" d="M 0,160 C 50,160 100,155 150,152 C 200,148 250,142 300,132 C 330,105 360,65 380,65 C 410,65 430,125 470,135 C 520,145 560,110 590,115 C 630,125 650,145 680,152 L 680,165 L 0,165 Z" fill="url(#foodOrdArea)" />
                        <path id="svgOrdLine" d="M 0,160 C 50,160 100,155 150,152 C 200,148 250,142 300,132 C 330,105 360,65 380,65 C 410,65 430,125 470,135 C 520,145 560,110 590,115 C 630,125 650,145 680,152" fill="none" stroke="#d8a962" stroke-width="2.4" stroke-linecap="round" />

                        <!-- Peak Tag Badge -->
                        <g id="svgPeakRevTag" transform="translate(362, 5)">
                            <rect x="0" y="0" width="50" height="20" rx="4" fill="#245943" />
                            <text id="svgPeakRevText" x="25" y="14" fill="#FFFFFF" font-size="11" font-weight="700" text-anchor="middle">$5.6K</text>
                            <circle cx="25" cy="24" r="3.5" fill="#245943" stroke="#FFFFFF" stroke-width="2" />
                        </g>

                        <!-- Interactive Invisible Hover Columns -->
                        <g id="chartHoverColumns">
                            <!-- Injected by JavaScript -->
                        </g>
                    </svg>

                    <!-- X-Axis Labels -->
                    <div class="chart-x-labels" id="chartXLabels">
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                        <span>Sun</span>
                    </div>
                </div>

                <!-- Y-Labels Right (Orders) -->
                <div class="chart-y-right">
                    <span>50</span>
                    <span>35</span>
                    <span>20</span>
                    <span>10</span>
                    <span>0</span>
                </div>
            </div>

            <!-- Bottom Highlights Inside Trend Card -->
            <div class="trend-stats-footer">
                <div class="trend-stat-col">
                    <span class="stat-icon">🛍️</span>
                    <div class="stat-meta">
                        <span class="stat-label" id="hlLabel1">Period Revenue</span>
                        <strong class="stat-num" id="hlVal1">${{ number_format($totalRevenue, 2) }}</strong>
                    </div>
                </div>
                <div class="trend-stat-col">
                    <span class="stat-icon">🎁</span>
                    <div class="stat-meta">
                        <span class="stat-label" id="hlLabel2">Period Orders</span>
                        <strong class="stat-num" id="hlVal2">{{ number_format($totalOrders) }}</strong>
                    </div>
                </div>
                <div class="trend-stat-col">
                    <span class="stat-icon">💳</span>
                    <div class="stat-meta">
                        <span class="stat-label" id="hlLabel3">Peak Revenue</span>
                        <strong class="stat-num" id="hlVal3">$5,600 <small>| Sat</small></strong>
                    </div>
                </div>
                <div class="trend-stat-col">
                    <span class="stat-icon">🛵</span>
                    <div class="stat-meta">
                        <span class="stat-label" id="hlLabel4">Peak Orders</span>
                        <strong class="stat-num" id="hlVal4">46 <small>| Sat</small></strong>
                    </div>
                </div>
            </div>
        </section>

        <!-- Orders by Category (Dara Market Categories) -->
        <section class="food-card card-category">
            <div class="card-head">
                <div>
                    <h3 class="card-title">Orders by Category</h3>
                    <small style="color: var(--food-muted); font-size: 11px;">Real-time catalog distribution</small>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="card-link-view">Manage</a>
            </div>

            <div class="category-donut-row">
                <!-- Donut Chart -->
                <div class="donut-container" style="position: relative;">
                    <svg class="donut-chart" viewBox="0 0 140 140">
                        <!-- Track Background -->
                        <circle cx="70" cy="70" r="54" fill="none" stroke="#E8ECE8" stroke-width="15"></circle>

                        <!-- Electronics: 45% (Forest Green #245943) -->
                        <circle cx="70" cy="70" r="54" fill="none" stroke="#245943" stroke-width="15"
                                stroke-dasharray="152.68 339.29" stroke-dashoffset="0"
                                transform="rotate(-90 70 70)" class="donut-slice" data-cat="Electronics" data-count="76"></circle>

                        <!-- Fashion: 30% (Accent Gold #d8a962) -->
                        <circle cx="70" cy="70" r="54" fill="none" stroke="#d8a962" stroke-width="15"
                                stroke-dasharray="101.78 339.29" stroke-dashoffset="-152.68"
                                transform="rotate(-90 70 70)" class="donut-slice" data-cat="Fashion" data-count="50"></circle>

                        <!-- Kitchen: 15% (Sage Green #5b8d6f) -->
                        <circle cx="70" cy="70" r="54" fill="none" stroke="#5b8d6f" stroke-width="15"
                                stroke-dasharray="50.89 339.29" stroke-dashoffset="-254.46"
                                transform="rotate(-90 70 70)" class="donut-slice" data-cat="Kitchen" data-count="26"></circle>

                        <!-- Beauty: 10% (Soft Sage #8cae8e) -->
                        <circle cx="70" cy="70" r="54" fill="none" stroke="#8cae8e" stroke-width="15"
                                stroke-dasharray="33.93 339.29" stroke-dashoffset="-305.35"
                                transform="rotate(-90 70 70)" class="donut-slice" data-cat="Beauty" data-count="16"></circle>
                    </svg>
                    <div class="donut-center-info">
                        <strong class="donut-count" id="donutCenterCount">{{ $totalOrders }}</strong>
                        <span class="donut-sub" id="donutCenterLabel">TOTAL ORDERS</span>
                    </div>
                </div>

                <!-- Category Breakdown List for Dara Market -->
                <div class="category-breakdown-list">
                    <a href="{{ route('admin.products.index', ['category' => 'Electronics']) }}" class="cat-item" onmouseenter="highlightDonut('Electronics', 76)" onmouseleave="resetDonut()">
                        <span class="cat-bullet" style="background: #245943;"></span>
                        <div class="cat-details">
                            <span class="cat-name">Electronics (អេឡិចត្រូនិក)</span>
                            <small class="cat-orders">76 Orders • Popular</small>
                        </div>
                        <span class="cat-pct">45%</span>
                    </a>
                    <a href="{{ route('admin.products.index', ['category' => 'Fashion']) }}" class="cat-item" onmouseenter="highlightDonut('Fashion', 50)" onmouseleave="resetDonut()">
                        <span class="cat-bullet" style="background: #d8a962;"></span>
                        <div class="cat-details">
                            <span class="cat-name">Fashion (ម៉ូដសម្លៀកបំពាក់)</span>
                            <small class="cat-orders">50 Orders</small>
                        </div>
                        <span class="cat-pct">30%</span>
                    </a>
                    <a href="{{ route('admin.products.index', ['category' => 'Kitchen']) }}" class="cat-item" onmouseenter="highlightDonut('Kitchen', 26)" onmouseleave="resetDonut()">
                        <span class="cat-bullet" style="background: #5b8d6f;"></span>
                        <div class="cat-details">
                            <span class="cat-name">Kitchen (សម្ភារៈផ្ទះបាយ)</span>
                            <small class="cat-orders">26 Orders</small>
                        </div>
                        <span class="cat-pct">15%</span>
                    </a>
                    <a href="{{ route('admin.products.index', ['category' => 'Beauty']) }}" class="cat-item" onmouseenter="highlightDonut('Beauty', 16)" onmouseleave="resetDonut()">
                        <span class="cat-bullet" style="background: #8cae8e;"></span>
                        <div class="cat-details">
                            <span class="cat-name">Beauty (ថែរក្សាសម្រស់)</span>
                            <small class="cat-orders">16 Orders</small>
                        </div>
                        <span class="cat-pct">10%</span>
                    </a>
                </div>
            </div>

            <!-- Top Category Alert Banner -->
            <div class="category-top-banner">
                <div class="crown-icon-wrap">👑</div>
                <div class="top-banner-copy">
                    <strong>Top Category: Electronics</strong>
                    <p>Accounts for 45% of total orders this week across Dara Market.</p>
                </div>
            </div>
        </section>
    </div>

    <!-- Bottom Row: 3 Columns -->
    <div class="food-bottom-grid">
        <!-- 1. Top Selling Products (Live Products with Direct Edit) -->
        <section class="food-card card-top-dishes">
            <div class="card-head">
                <div>
                    <h3 class="card-title">Top Selling Products</h3>
                    <small style="color: var(--food-muted); font-size: 11px;">Based on verified customer sales</small>
                </div>
                <a href="{{ route('admin.products.index') }}" class="card-link-view">View Catalog →</a>
            </div>

            <div class="dishes-list">
                @if(isset($topSellingProducts) && $topSellingProducts->count() > 0)
                    @foreach ($topSellingProducts as $idx => $prod)
                        <a href="{{ route('admin.products.edit', $prod->id) }}" class="dish-row product-admin-row" title="Click to edit product">
                            <span class="dish-rank {{ $idx < 3 ? 'rank-'.($idx + 1) : '' }}">{{ $idx + 1 }}</span>
                            <img src="{{ $prod->image_url ?? $prod->image ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=160&auto=format&fit=crop&q=80' }}" alt="{{ $prod->name_en }}" class="dish-thumb" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\'><rect width=\'40\' height=\'40\' rx=\'8\' fill=\'%23edf5ed\'/><text x=\'20\' y=\'26\' font-size=\'18\' text-anchor=\'middle\'>🛍️</text></svg>'">
                            <div class="dish-info">
                                <strong class="dish-name">{{ $prod->name_en }}</strong>
                                <small class="dish-orders">⭐ {{ number_format($prod->rating ?? 5.0, 1) }} • {{ $prod->name_km }}</small>
                            </div>
                            <span class="dish-price">${{ number_format($prod->price, 2) }}</span>
                        </a>
                    @endforeach
                @else
                    @php
                        $daraTopItems = [
                            ['name' => 'Daily Backpack', 'name_km' => 'កាតាបប្រចាំថ្ងៃ', 'orders' => 124, 'price' => '$32.00', 'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=160&auto=format&fit=crop&q=80'],
                            ['name' => 'Wireless Headphones', 'name_km' => 'កាសប៊្លូធូសឥតខ្សែ', 'orders' => 98, 'price' => '$42.00', 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=160&auto=format&fit=crop&q=80'],
                            ['name' => 'Modern Smart Watch', 'name_km' => 'នាឡិកាដៃឆ្លាតវៃ', 'orders' => 76, 'price' => '$65.00', 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=160&auto=format&fit=crop&q=80'],
                            ['name' => 'Sport Sneakers', 'name_km' => 'ស្បែកជើងកីឡា', 'orders' => 58, 'price' => '$48.00', 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=160&auto=format&fit=crop&q=80'],
                            ['name' => 'Compact Camera', 'name_km' => 'កាមេរ៉ាឌីជីថល', 'orders' => 38, 'price' => '$120.00', 'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=160&auto=format&fit=crop&q=80'],
                        ];
                    @endphp
                    @foreach ($daraTopItems as $idx => $item)
                        <div class="dish-row">
                            <span class="dish-rank {{ $idx < 3 ? 'rank-'.($idx + 1) : '' }}">{{ $idx + 1 }}</span>
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="dish-thumb" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\'><rect width=\'40\' height=\'40\' rx=\'8\' fill=\'%23edf5ed\'/><text x=\'20\' y=\'26\' font-size=\'18\' text-anchor=\'middle\'>🛍️</text></svg>'">
                            <div class="dish-info">
                                <strong class="dish-name">{{ $item['name'] }}</strong>
                                <small class="dish-orders">{{ $item['orders'] }} Sold • {{ $item['name_km'] }}</small>
                            </div>
                            <span class="dish-price">{{ $item['price'] }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>

        <!-- 2. Dynamic Order Status Gauge -->
        <section class="food-card card-order-status">
            <div class="card-head">
                <div>
                    <h3 class="card-title">Order Status</h3>
                    <small style="color: var(--food-muted); font-size: 11px;">Fulfillment progression breakdown</small>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="card-link-view">View Orders →</a>
            </div>

            <!-- Gauge Semi-Circle Speedometer SVG with Dynamic Percentages -->
            @php
                $pctComp = $orderStats['percentages']['completed'] ?? 64;
                $pctProc = $orderStats['percentages']['processing'] ?? 22;
                $pctPend = $orderStats['percentages']['pending'] ?? 10;
                $pctCanc = $orderStats['percentages']['cancelled'] ?? 4;

                $arcComp = round(($pctComp / 100) * 251.32, 1);
                $arcProc = round(($pctProc / 100) * 251.32, 1);
                $arcPend = round(($pctPend / 100) * 251.32, 1);
                $arcCanc = round(($pctCanc / 100) * 251.32, 1);

                $offProc = -($arcComp);
                $offPend = -($arcComp + $arcProc);
                $offCanc = -($arcComp + $arcProc + $arcPend);
            @endphp

            <div class="gauge-container">
                <svg viewBox="0 0 200 115" class="gauge-svg">
                    <!-- Gauge Background Track -->
                    <path d="M 20,100 A 80,80 0 0,1 180,100" fill="none" stroke="#E8ECE8" stroke-width="16" stroke-linecap="round"></path>

                    <!-- Completed (Forest Green #245943) -->
                    <path d="M 20,100 A 80,80 0 0,1 180,100" fill="none" stroke="#245943" stroke-width="16"
                          stroke-dasharray="{{ $arcComp }} 251.32" stroke-dashoffset="0" stroke-linecap="round"></path>

                    <!-- Processing (Accent Gold #d8a962) -->
                    <path d="M 20,100 A 80,80 0 0,1 180,100" fill="none" stroke="#d8a962" stroke-width="16"
                          stroke-dasharray="{{ $arcProc }} 251.32" stroke-dashoffset="{{ $offProc }}"></path>

                    <!-- Pending (Terracotta #c86142) -->
                    <path d="M 20,100 A 80,80 0 0,1 180,100" fill="none" stroke="#c86142" stroke-width="16"
                          stroke-dasharray="{{ $arcPend }} 251.32" stroke-dashoffset="{{ $offPend }}"></path>

                    <!-- Cancelled (Muted Slate #7d8981) -->
                    <path d="M 20,100 A 80,80 0 0,1 180,100" fill="none" stroke="#7d8981" stroke-width="16"
                          stroke-dasharray="{{ $arcCanc }} 251.32" stroke-dashoffset="{{ $offCanc }}" stroke-linecap="round"></path>
                </svg>
            </div>

            <!-- Status Pill Counters Linked Directly to Order Views -->
            <div class="status-pill-grid">
                <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="status-pill status-pill-interactive" title="Filter Delivered Orders">
                    <span class="status-badge badge-green">{{ $pctComp }}%</span>
                    <strong class="status-count">{{ $orderStats['completed'] ?? 108 }}</strong>
                    <span class="status-label">Delivered</span>
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="status-pill status-pill-interactive" title="Filter Processing Orders">
                    <span class="status-badge badge-amber">{{ $pctProc }}%</span>
                    <strong class="status-count">{{ $orderStats['processing'] ?? 37 }}</strong>
                    <span class="status-label">Processing</span>
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="status-pill status-pill-interactive" title="Filter Pending Orders">
                    <span class="status-badge badge-red">{{ $pctPend }}%</span>
                    <strong class="status-count">{{ $orderStats['pending'] ?? 17 }}</strong>
                    <span class="status-label">Pending</span>
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="status-pill status-pill-interactive" title="Filter Cancelled Orders">
                    <span class="status-badge badge-dark">{{ $pctCanc }}%</span>
                    <strong class="status-count">{{ $orderStats['cancelled'] ?? 6 }}</strong>
                    <span class="status-label">Cancelled</span>
                </a>
            </div>
        </section>

        <!-- 3. Business Insights & Quick Actions -->
        <section class="food-card card-insights">
            <div class="card-head">
                <h3 class="card-title">
                    <span class="bulb-icon">💡</span> Business Insights
                </h3>
            </div>

            <div class="insights-matrix">
                <!-- Row 1: Left -->
                <div class="insight-cell">
                    <span class="insight-label">Revenue Growth</span>
                    <div class="insight-highlight color-green">
                        <span class="trend-arrow">↑</span> 8.2%
                    </div>
                    <small class="insight-sub">vs Last Period</small>
                </div>

                <!-- Row 1: Right -->
                <div class="insight-cell">
                    <span class="insight-label">Top Category</span>
                    <strong class="insight-name">Electronics</strong>
                    <small class="insight-sub">45% of orders</small>
                </div>

                <!-- Row 2: Left -->
                <div class="insight-cell">
                    <span class="insight-label">Best Seller</span>
                    <strong class="insight-name">Daily Backpack</strong>
                    <small class="insight-sub">124 units sold</small>
                </div>

                <!-- Row 2: Right -->
                <div class="insight-cell">
                    <span class="insight-label">Peak Order Time</span>
                    <strong class="insight-name">1:00 PM – 4:00 PM</strong>
                    <small class="insight-sub">Highest conversion</small>
                </div>
            </div>

            <!-- Quick Management Shortcuts -->
            <div class="insights-actions-row">
                <a href="{{ route('admin.products.create') }}" class="btn-insight-action">
                    <span>＋ Product</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn-insight-action">
                    <span>📦 Orders</span>
                </a>
                <a href="{{ route('admin.customers.index') }}" class="btn-insight-action">
                    <span>👥 Customers</span>
                </a>
                <a href="{{ route('store.home') }}" target="_blank" class="btn-insight-action" style="border-color: #d8a962; color: #856121; background: #fffcf5;">
                    <span>🛍️ Live Store ↗</span>
                </a>
            </div>
        </section>
    </div>
</div>

<!-- Interactive Chart Script -->
<script>
const trendDatasets = {
    today: {
        xLabels: ['12 AM', '4 AM', '8 AM', '12 PM', '4 PM', '8 PM', '11 PM'],
        yLabels: ['6K', '4.5K', '3K', '1.5K', '0'],
        revD: "M 0,150 C 60,150 120,140 180,120 C 240,100 300,60 360,30 C 420,50 480,90 540,110 C 600,130 640,145 680,150",
        revArea: "M 0,150 C 60,150 120,140 180,120 C 240,100 300,60 360,30 C 420,50 480,90 540,110 C 600,130 640,145 680,150 L 680,165 L 0,165 Z",
        ordD: "M 0,160 C 60,160 120,150 180,135 C 240,110 300,75 360,60 C 420,80 480,110 540,130 C 600,145 640,155 680,160",
        ordArea: "M 0,160 C 60,160 120,150 180,135 C 240,110 300,75 360,60 C 420,80 480,110 540,130 C 600,145 640,155 680,160 L 680,165 L 0,165 Z",
        peakX: 342,
        peakY: 10,
        peakText: "$5.6K",
        hl1: "$8,020.00",
        hl2: "32",
        hl3: "$5,600 | 4 PM",
        hl4: "28 | 4 PM",
        hlLabel1: "Today's Revenue",
        hlLabel2: "Today's Orders",
        points: [
            { label: '12 AM', rev: '$420', ord: 2 },
            { label: '4 AM', rev: '$180', ord: 1 },
            { label: '8 AM', rev: '$1,250', ord: 6 },
            { label: '12 PM', rev: '$3,800', ord: 16 },
            { label: '4 PM', rev: '$5,600', ord: 28 },
            { label: '8 PM', rev: '$2,100', ord: 11 },
            { label: '11 PM', rev: '$670', ord: 4 }
        ]
    },
    week: {
        xLabels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        yLabels: ['10K', '7.5K', '5K', '2.5K', '0'],
        revD: "M 0,145 C 50,145 100,135 150,130 C 200,125 250,120 300,105 C 330,70 360,25 380,25 C 410,25 430,95 470,105 C 520,118 560,70 590,75 C 630,85 650,115 680,125",
        revArea: "M 0,145 C 50,145 100,135 150,130 C 200,125 250,120 300,105 C 330,70 360,25 380,25 C 410,25 430,95 470,105 C 520,118 560,70 590,75 C 630,85 650,115 680,125 L 680,165 L 0,165 Z",
        ordD: "M 0,160 C 50,160 100,155 150,152 C 200,148 250,142 300,132 C 330,105 360,65 380,65 C 410,65 430,125 470,135 C 520,145 560,110 590,115 C 630,125 650,145 680,152",
        ordArea: "M 0,160 C 50,160 100,155 150,152 C 200,148 250,142 300,132 C 330,105 360,65 380,65 C 410,65 430,125 470,135 C 520,145 560,110 590,115 C 630,125 650,145 680,152 L 680,165 L 0,165 Z",
        peakX: 362,
        peakY: 5,
        peakText: "$8.4K",
        hl1: "${{ number_format($totalRevenue, 2) }}",
        hl2: "{{ number_format($totalOrders) }}",
        hl3: "$8,420 | Sat",
        hl4: "46 | Sat",
        hlLabel1: "Weekly Revenue",
        hlLabel2: "Weekly Orders",
        points: [
            { label: 'Monday', rev: '$3,800', ord: 18 },
            { label: 'Tuesday', rev: '$4,200', ord: 22 },
            { label: 'Wednesday', rev: '$5,100', ord: 26 },
            { label: 'Thursday', rev: '$4,800', ord: 24 },
            { label: 'Friday', rev: '$6,200', ord: 32 },
            { label: 'Saturday', rev: '$8,420', ord: 46 },
            { label: 'Sunday', rev: '$5,930', ord: 30 }
        ]
    },
    month: {
        xLabels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        yLabels: ['40K', '30K', '20K', '10K', '0'],
        revD: "M 0,135 C 100,120 180,95 240,75 C 320,50 420,20 480,20 C 540,20 620,80 680,95",
        revArea: "M 0,135 C 100,120 180,95 240,75 C 320,50 420,20 480,20 C 540,20 620,80 680,95 L 680,165 L 0,165 Z",
        ordD: "M 0,150 C 100,135 180,110 240,90 C 320,70 420,55 480,55 C 540,55 620,115 680,125",
        ordArea: "M 0,150 C 100,135 180,110 240,90 C 320,70 420,55 480,55 C 540,55 620,115 680,125 L 680,165 L 0,165 Z",
        peakX: 460,
        peakY: 2,
        peakText: "$38.5K",
        hl1: "$128,600.00",
        hl2: "680",
        hl3: "$38,500 | Wk 3",
        hl4: "210 | Wk 3",
        hlLabel1: "Monthly Revenue",
        hlLabel2: "Monthly Orders",
        points: [
            { label: 'Week 1', rev: '$26,400', ord: 142 },
            { label: 'Week 2', rev: '$31,800', ord: 168 },
            { label: 'Week 3', rev: '$38,500', ord: 210 },
            { label: 'Week 4', rev: '$31,900', ord: 160 }
        ]
    }
};

let currentPeriod = 'week';

function changeTrendPeriod(period) {
    if (!trendDatasets[period]) return;
    currentPeriod = period;

    // Synchronize UI buttons & dropdown
    ['today', 'week', 'month'].forEach(p => {
        const btn = document.getElementById('tabBtn-' + p);
        if (btn) btn.classList.toggle('is-active', p === period);
    });
    const sel = document.getElementById('trendPeriodSelect');
    if (sel && sel.value !== period) sel.value = period;

    const data = trendDatasets[period];

    // Update SVG paths
    const revLine = document.getElementById('svgRevLine');
    const revArea = document.getElementById('svgRevArea');
    const ordLine = document.getElementById('svgOrdLine');
    const ordArea = document.getElementById('svgOrdArea');
    const peakTag = document.getElementById('svgPeakRevTag');
    const peakTxt = document.getElementById('svgPeakRevText');

    if (revLine) revLine.setAttribute('d', data.revD);
    if (revArea) revArea.setAttribute('d', data.revArea);
    if (ordLine) ordLine.setAttribute('d', data.ordD);
    if (ordArea) ordArea.setAttribute('d', data.ordArea);

    if (peakTag) peakTag.setAttribute('transform', `translate(${data.peakX}, ${data.peakY})`);
    if (peakTxt) peakTxt.textContent = data.peakText;

    // Update X-axis labels
    const xLabelsContainer = document.getElementById('chartXLabels');
    if (xLabelsContainer) {
        xLabelsContainer.innerHTML = data.xLabels.map(l => `<span>${l}</span>`).join('');
    }

    // Update Y-axis labels
    const yLabelsContainer = document.getElementById('chartYLabels');
    if (yLabelsContainer) {
        yLabelsContainer.innerHTML = data.yLabels.map(l => `<span>${l}</span>`).join('');
    }

    // Update bottom stats
    const hl1 = document.getElementById('hlVal1');
    const hl2 = document.getElementById('hlVal2');
    const hl3 = document.getElementById('hlVal3');
    const hl4 = document.getElementById('hlVal4');
    const hlbl1 = document.getElementById('hlLabel1');
    const hlbl2 = document.getElementById('hlLabel2');

    if (hl1) hl1.textContent = data.hl1;
    if (hl2) hl2.textContent = data.hl2;
    if (hl3) hl3.innerHTML = data.hl3;
    if (hl4) hl4.innerHTML = data.hl4;
    if (hlbl1) hlbl1.textContent = data.hlLabel1;
    if (hlbl2) hlbl2.textContent = data.hlLabel2;

    renderHoverColumns(data);
}

function renderHoverColumns(data) {
    const group = document.getElementById('chartHoverColumns');
    if (!group) return;
    const colWidth = 680 / data.points.length;
    
    group.innerHTML = data.points.map((pt, i) => {
        const x = i * colWidth;
        return `
            <rect x="${x}" y="0" width="${colWidth}" height="180" fill="transparent" 
                  style="cursor: pointer;"
                  onmouseenter="showChartTooltip(event, '${pt.label}', '${pt.rev}', '${pt.ord}')"
                  onmouseleave="hideChartTooltip()" />
        `;
    }).join('');
}

function showChartTooltip(e, label, rev, ord) {
    const tt = document.getElementById('chartTooltip');
    if (!tt) return;
    document.getElementById('ttTime').textContent = label;
    document.getElementById('ttRev').textContent = rev;
    document.getElementById('ttOrd').textContent = ord;

    const rect = e.target.getBoundingClientRect();
    const parentRect = e.target.closest('.trend-svg-container').getBoundingClientRect();
    const left = (rect.left - parentRect.left) + (rect.width / 2) - 50;

    tt.style.left = Math.max(10, Math.min(parentRect.width - 120, left)) + 'px';
    tt.style.top = '25px';
    tt.style.display = 'block';
}

function hideChartTooltip() {
    const tt = document.getElementById('chartTooltip');
    if (tt) tt.style.display = 'none';
}

// Donut Interaction
function highlightDonut(cat, count) {
    const countEl = document.getElementById('donutCenterCount');
    const labelEl = document.getElementById('donutCenterLabel');
    if (countEl) countEl.textContent = count;
    if (labelEl) labelEl.textContent = cat.toUpperCase();
}

function resetDonut() {
    const countEl = document.getElementById('donutCenterCount');
    const labelEl = document.getElementById('donutCenterLabel');
    if (countEl) countEl.textContent = "{{ $totalOrders }}";
    if (labelEl) labelEl.textContent = "TOTAL ORDERS";
}

// Initialize on page load
window.addEventListener('DOMContentLoaded', function() {
    renderHoverColumns(trendDatasets.week);
});
</script>
@endsection
