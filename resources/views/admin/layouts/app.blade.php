<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#245943">
    <title>@yield('title', 'Dashboard') | Dara Market Store Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Kantumruy+Pro:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="food-admin-body {{ request()->routeIs('admin.dashboard') ? 'is-dashboard-view' : '' }}">
    @php($isAdmin = auth()->user()?->is_admin ?? false)

    <!-- Sidebar -->
    <aside class="food-sidebar">
        <!-- Brand Logo matched with Dara Market -->
        <a class="food-brand" href="{{ route('admin.dashboard') }}">
            <div class="food-brand-icon dara-brand-mark">
                <span>{{ strtolower(substr($storeSettings['store_name_en'] ?? 'dara', 0, 1)) }}</span>
            </div>
            <div class="food-brand-text">
                <div class="food-brand-title"><span class="brand-dark">{{ strtolower(\Illuminate\Support\Str::words($storeSettings['store_name_en'] ?? 'dara market', 1, '')) }}</span><span class="brand-orange">{{ strtolower(trim(str_replace(\Illuminate\Support\Str::words($storeSettings['store_name_en'] ?? 'dara market', 1, ''), '', $storeSettings['store_name_en'] ?? 'market'))) }}</span></div>
                <small class="food-brand-sub">{{ $storeSettings['store_name_km'] ?? 'STORE MANAGEMENT' }}</small>
            </div>
        </a>

        <!-- Main Navigation Links -->
        <nav class="food-nav" aria-label="Main Navigation">
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                    </svg>
                </span>
                <span class="nav-label">Dashboard</span>
            </a>

            <a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </span>
                <span class="nav-label">Products</span>
            </a>

            <a class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                </span>
                <span class="nav-label">Categories</span>
            </a>

            <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        <path d="M9 14l2 2 4-4"></path>
                    </svg>
                </span>
                <span class="nav-label">Orders</span>
            </a>

            <a class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </span>
                <span class="nav-label">Customers</span>
            </a>

            <a class="{{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}" href="{{ route('admin.inventory.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </span>
                <span class="nav-label">Inventory</span>
            </a>

            <a class="{{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}" href="{{ route('admin.analytics.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        <polyline points="17 6 23 6 23 12"></polyline>
                    </svg>
                </span>
                <span class="nav-label">Analytics</span>
            </a>

            <a class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </span>
                <span class="nav-label">Reports</span>
            </a>

            <a class="{{ request()->routeIs('admin.marketing.*') || request()->routeIs('admin.subscribers.*') ? 'active' : '' }}" href="{{ route('admin.marketing.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </span>
                <span class="nav-label">Marketing</span>
            </a>

            <a class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                </span>
                <span class="nav-label">Reviews</span>
            </a>

            <a class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                <span class="nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                </span>
                <span class="nav-label">Settings</span>
            </a>
        </nav>

        <!-- Modern Live Store Hub Widget -->
        <div class="sidebar-live-hub">
            <!-- Hub Header with Live Pulse -->
            <div class="live-hub-header">
                <div class="live-hub-status">
                    <span class="hub-pulse-dot"></span>
                    <span class="hub-status-text">STORE LIVE</span>
                </div>
                <div class="live-hub-clock" id="sidebarCambodiaClock" title="Cambodia Local Time (ICT)">
                    🇰🇭 --:--:--
                </div>
            </div>

            <!-- Hub Brand / Identity -->
            <div class="live-hub-identity">
                <div class="hub-avatar">
                    <span class="hub-mark">{{ strtolower(substr($storeSettings['store_name_en'] ?? 'Dara', 0, 1)) }}</span>
                </div>
                <div class="hub-text">
                    <strong class="hub-name">{{ $storeSettings['store_name_km'] ?? 'ផ្សារតារា' }}</strong>
                    <span class="hub-sub">{{ $storeSettings['store_name_en'] ?? 'Dara Market Live' }}</span>
                </div>
            </div>

            <!-- Live Real-time Micro Metrics -->
            <div class="live-hub-metrics">
                <div class="hub-metric-chip" title="Total Orders Recorded">
                    <span class="chip-label">Orders</span>
                    <strong class="chip-val">{{ \App\Models\Order::count() }}</strong>
                </div>
                <div class="hub-metric-chip" title="Active Products in Store">
                    <span class="chip-label">Products</span>
                    <strong class="chip-val">{{ \App\Models\Product::where('is_active', true)->count() }}</strong>
                </div>
                <div class="hub-metric-chip" title="Exchange Rate (USD to KHR)">
                    <span class="chip-label">Rate (៛)</span>
                    <strong class="chip-val">{{ number_format((float)($storeSettings['exchange_rate'] ?? 4100)) }}</strong>
                </div>
            </div>

            <!-- Primary Action: View Storefront -->
            <a href="{{ route('store.home') }}" target="_blank" class="hub-primary-btn" title="View Customer Storefront">
                <span>View Storefront</span>
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="7" y1="17" x2="17" y2="7"></line>
                    <polyline points="7 7 17 7 17 17"></polyline>
                </svg>
            </a>

            <!-- Quick Interactive Tools (New Features) -->
            <div class="hub-quick-tools">
                <button type="button" class="hub-tool-btn" onclick="copyStoreUrl(this)" title="Copy Storefront URL">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    <span id="copyUrlBtnText">Copy Link</span>
                </button>

                <button type="button" class="hub-tool-btn" onclick="openQrModal()" title="Scan QR Code on Phone to Preview Mobile Storefront">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Mobile QR</span>
                </button>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="food-main-wrapper">
        <!-- Topbar Header -->
        <header class="food-topbar">
            <div class="food-topbar-title">
                <h2>@yield('title', 'Dashboard')</h2>
            </div>

            <!-- Global Search Bar -->
            <form class="food-search-box" action="{{ request()->routeIs('admin.orders.*') ? route('admin.orders.index') : route('admin.products.index') }}" method="GET">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ request()->routeIs('admin.orders.*') ? 'Search orders by # or customer...' : 'Search products, catalog...' }}" aria-label="Search">
            </form>

            <!-- Topbar Actions -->
            <div class="food-topbar-actions">
                <!-- View Store Button -->
                <a href="{{ route('store.home') }}" target="_blank" class="topbar-store-btn" title="View Customer Storefront">
                    <span>View Store</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="7" y1="17" x2="17" y2="7"></line>
                        <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                </a>

                <!-- Notifications Dropdown -->
                <div class="topbar-dropdown-wrapper" style="position: relative;">
                    <button type="button" id="notifDropdownBtn" class="topbar-icon-btn has-badge" aria-label="Notifications" onclick="toggleNotifMenu()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span id="notifBadge" class="badge-count">3</span>
                    </button>

                    <div id="notifDropdownMenu" class="topbar-dropdown-menu" style="display: none;">
                        <div class="dropdown-header">
                            <h4>Store Notifications</h4>
                            <button type="button" class="dropdown-mark-read" onclick="clearNotifBadge()">Mark all read</button>
                        </div>
                        <div class="dropdown-list">
                            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="dropdown-item">
                                <span class="item-icon icon-order">🛍️</span>
                                <div class="item-content">
                                    <strong>New Order Received</strong>
                                    <p>Order #ORD-8937 requires packing & fulfillment.</p>
                                    <small>10 mins ago</small>
                                </div>
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="dropdown-item">
                                <span class="item-icon icon-alert">⚠️</span>
                                <div class="item-content">
                                    <strong>Low Inventory Alert</strong>
                                    <p>Wireless headphones is down to 8 units in stock.</p>
                                    <small>1 hour ago</small>
                                </div>
                            </a>
                            <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="dropdown-item">
                                <span class="item-icon icon-order">✓</span>
                                <div class="item-content">
                                    <strong>Order Delivered</strong>
                                    <p>Order #ORD-8938 marked delivered to Dara Keo.</p>
                                    <small>Today, 07:25 AM</small>
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-footer">
                            <a href="{{ route('admin.orders.index') }}">View All Orders →</a>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <a href="{{ route('admin.settings.index') }}" class="topbar-icon-btn" aria-label="Settings" title="Admin Settings">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                </a>

                <!-- User Profile -->
                <div class="food-user-profile-wrapper" style="position: relative;">
                    <div class="food-user-profile" onclick="toggleProfileMenu()" style="cursor: pointer;">
                        <span class="user-avatar dara-user-avatar">{{ strtoupper(substr(auth()->user()?->name ?? 'D', 0, 1)) }}</span>
                        <div class="user-info">
                            <span class="user-name" title="{{ auth()->user()?->name }}">{{ \Illuminate\Support\Str::before(auth()->user()?->name ?? 'Dara Admin', ' (') }}</span>
                            <span class="user-role">{{ auth()->user()?->is_admin ? 'Store Owner' : 'Manager' }}</span>
                        </div>
                        <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>

                    <div id="profileDropdownMenu" class="topbar-dropdown-menu" style="display: none; width: 220px; right: 0;">
                        <div class="dropdown-header">
                            <div>
                                <strong>{{ auth()->user()?->name ?? 'Dara Admin' }}</strong>
                                <small style="display: block; color: var(--food-muted); font-size: 11px;">{{ auth()->user()?->email ?? 'admin@daramarket.com' }}</small>
                            </div>
                        </div>
                        <div class="dropdown-list" style="padding: 6px 0;">
                            <a href="{{ route('admin.settings.index') }}" class="dropdown-item" style="padding: 8px 16px;">
                                <span>⚙ Settings</span>
                            </a>
                            <a href="{{ route('store.home') }}" target="_blank" class="dropdown-item" style="padding: 8px 16px;">
                                <span>🛍️ View Storefront ↗</span>
                            </a>
                            @if(auth()->check())
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="width: 100%; border: none; background: none; text-align: left; cursor: pointer; color: #dc2626; padding: 8px 16px; font-weight: 600;">
                                        <span>🚪 Sign Out</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if (session('status'))
            <div class="food-alert food-alert-success">{{ session('status') }}</div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="food-alert food-alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Body Content -->
        <main class="food-content">
            @yield('content')
        </main>
    </div>

    <!-- Storefront Mobile QR Preview Modal (New Feature) -->
    <div id="storeQrModal" class="admin-qr-modal-backdrop" style="display: none;" onclick="handleModalBackdropClick(event)">
        <div class="admin-qr-modal-dialog">
            <div class="qr-modal-head">
                <div class="qr-head-left">
                    <span class="qr-device-icon">📱</span>
                    <div>
                        <h4 class="qr-modal-title">Mobile Storefront Preview</h4>
                        <span class="qr-modal-sub">ស្កេនមើលទម្រង់ទូរស័ព្ទដៃជាក់ស្តែង</span>
                    </div>
                </div>
                <button type="button" class="qr-modal-close" onclick="closeQrModal()" title="Close">&times;</button>
            </div>
            <div class="qr-modal-body">
                <div class="qr-code-frame">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(route('store.home')) }}&bgcolor=ffffff&color=10291f&margin=2" alt="Dara Market Storefront QR" class="qr-image" width="180" height="180">
                </div>
                <p class="qr-desc">ប្រើកាមេរ៉ាទូរស័ព្ទរបស់អ្នក ដើម្បីស្កេនបើកមើលទំព័រហាង Dara Market លើទូរស័ព្ទដៃបានភ្លាមៗ។</p>
                <div class="qr-url-box">
                    <input type="text" value="{{ route('store.home') }}" readonly id="modalStoreUrlInput">
                    <button type="button" onclick="copyModalUrl(this)">Copy Link</button>
                </div>
            </div>
            <div class="qr-modal-foot">
                <a href="{{ route('store.home') }}" target="_blank" class="qr-open-btn">
                    <span>Open in Browser ↗</span>
                </a>
            </div>
        </div>
    </div>

    <script>
    function toggleNotifMenu() {
        const menu = document.getElementById('notifDropdownMenu');
        const profMenu = document.getElementById('profileDropdownMenu');
        if (profMenu) profMenu.style.display = 'none';
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }

    function clearNotifBadge() {
        const badge = document.getElementById('notifBadge');
        if (badge) badge.style.display = 'none';
    }

    function toggleProfileMenu() {
        const menu = document.getElementById('profileDropdownMenu');
        const notifMenu = document.getElementById('notifDropdownMenu');
        if (notifMenu) notifMenu.style.display = 'none';
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.topbar-dropdown-wrapper') && !e.target.closest('.food-user-profile-wrapper')) {
            const notifMenu = document.getElementById('notifDropdownMenu');
            const profMenu = document.getElementById('profileDropdownMenu');
            if (notifMenu) notifMenu.style.display = 'none';
            if (profMenu) profMenu.style.display = 'none';
        }
    });

    // Cambodia Live Clock in Sidebar
    function updateCambodiaClock() {
        const el = document.getElementById('sidebarCambodiaClock');
        if (!el) return;
        try {
            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-US', {
                timeZone: 'Asia/Phnom_Penh',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });
            el.textContent = '🇰🇭 ' + formatter.format(now);
        } catch (err) {
            const now = new Date();
            el.textContent = '🇰🇭 ' + now.toLocaleTimeString();
        }
    }
    setInterval(updateCambodiaClock, 1000);
    updateCambodiaClock();

    // Copy Storefront Link Helper
    function copyStoreUrl(btn) {
        const url = '{{ route('store.home') }}';
        navigator.clipboard.writeText(url).then(() => {
            const span = document.getElementById('copyUrlBtnText');
            if (span) span.textContent = 'Copied! ✓';
            btn.classList.add('is-copied');
            setTimeout(() => {
                if (span) span.textContent = 'Copy Link';
                btn.classList.remove('is-copied');
            }, 2000);
        }).catch(() => {
            alert('Store URL: ' + url);
        });
    }

    function copyModalUrl(btn) {
        const input = document.getElementById('modalStoreUrlInput');
        if (!input) return;
        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            const old = btn.textContent;
            btn.textContent = 'Copied! ✓';
            setTimeout(() => { btn.textContent = old; }, 2000);
        });
    }

    // QR Code Modal Dialog
    function openQrModal() {
        const modal = document.getElementById('storeQrModal');
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeQrModal() {
        const modal = document.getElementById('storeQrModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    function handleModalBackdropClick(e) {
        if (e.target.id === 'storeQrModal') {
            closeQrModal();
        }
    }
    </script>
</body>
</html>
