<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#10291f">
    <meta name="description" content="{{ $translations['meta']['description'] }}">
    <title>@yield('title', $translations['meta']['title'])</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/store.css') }}?v={{ filemtime(public_path('css/store.css')) }}">
    <script>window.storeTranslations = @json($translations['js']);</script>
    <script src="{{ asset('js/store.js') }}?v={{ filemtime(public_path('js/store.js')) }}" defer></script>
</head>
<body>
    <!-- Enhanced Top Announcement & Utility Bar -->
    <div class="announcement">
        <div class="container announcement-inner">
            <!-- Left: Rotating Announcement Ticker -->
            <div class="announcement-ticker" id="announcementTicker">
                <div class="ticker-track">
                    <div class="ticker-item is-active">
                        <span class="ticker-badge">🚚</span>
                        <span class="ticker-text">{{ $locale === 'km' ? ($storeSettings['announcement_text_km'] ?? 'ដឹកជញ្ជូនឥតគិតថ្លៃ រាល់ការកម្ម៉ង់ចាប់ពី $35 ឡើងទៅ!') : ($storeSettings['announcement_text_en'] ?? 'Free Shipping on all orders over $35!') }}</span>
                    </div>
                    <div class="ticker-item">
                        <span class="ticker-badge">⚡</span>
                        <span class="ticker-text">{{ $locale === 'km' ? 'Flash Sale ពិសេស: បញ្ចុះតម្លៃរហូតដល់ 30% លើទំនិញពេញនិយម' : 'Flash Sale: Up to 30% OFF on Top Picks' }}</span>
                    </div>
                    <div class="ticker-item">
                        <span class="ticker-badge">🎁</span>
                        <span class="ticker-text">{{ $locale === 'km' ? 'កាដូស្វាគមន៍: សមាជិកថ្មីទទួលបានប័ណ្ណបញ្ចុះតម្លៃ $15 ភ្លាមៗ' : 'Welcome Gift: New members get $15 voucher instantly' }}</span>
                    </div>
                    <div class="ticker-item">
                        <span class="ticker-badge">🇰🇭</span>
                        <span class="ticker-text">{{ $locale === 'km' ? 'សេវាដឹករហ័ស ២៤-៤៨ ម៉ោង ទូទាំង ២៥ ខេត្ត-ក្រុង' : 'Fast 24-48h Delivery across all 25 provinces' }}</span>
                    </div>
                </div>
                <div class="ticker-nav-controls">
                    <button type="button" class="ticker-nav-btn" onclick="prevTickerItem()" aria-label="Previous announcement" title="សារមុន">‹</button>
                    <button type="button" class="ticker-nav-btn" onclick="nextTickerItem()" aria-label="Next announcement" title="សារបន្ទាប់">›</button>
                </div>
            </div>

            <!-- Center: Flash Sale Live Countdown Timer -->
            <a href="#flash-deals" class="announcement-flash-sale" title="ចុចដើម្បីមើលទំនិញ Flash Sale">
                <span class="flash-icon" aria-hidden="true">🔥</span>
                <span class="flash-label">Flash Sale:</span>
                <span class="flash-timer" id="topbarTimer">
                    <span class="time-box" id="tbHours">05</span><span class="time-colon">:</span>
                    <span class="time-box" id="tbMins">22</span><span class="time-colon">:</span>
                    <span class="time-box" id="tbSecs">15</span>
                </span>
                <span class="flash-pill-tag">-30%</span>
            </a>

            <!-- Right: Interactive Actions & Utilities -->
            <div class="announcement-actions">
                <!-- Promo Code Quick Copy -->
                <button type="button" class="announcement-coupon-btn" onclick="copyPromoCode('{{ $storeSettings['announcement_promo'] ?? 'DARA2026' }}', this)" title="ចុចដើម្បីចម្លងកូដប័ណ្ណ">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><circle cx="12" cy="12" r="1.5"></circle></svg>
                    <span class="coupon-label">{{ $locale === 'km' ? 'កូដ' : 'Code' }}:</span>
                    <strong class="coupon-code">{{ $storeSettings['announcement_promo'] ?? 'DARA2026' }}</strong>
                    <span class="copy-hint" id="couponHint">{{ $locale === 'km' ? 'ចម្លង' : 'Copy' }}</span>
                </button>

                <!-- Hotline Phone Link (NEW) -->
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $storeSettings['contact_phone'] ?? '0714504547') }}" class="announcement-utility-link topbar-hotline" title="ទាក់ទងផ្នែកបម្រើអតិថិជន">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span>{{ $storeSettings['contact_phone'] ?? '071 450 4547' }}</span>
                </a>

                <!-- Track Order Quick Button -->
                <button type="button" class="announcement-utility-link track-order-btn" onclick="openTrackOrderModal()" title="តាមដានកញ្ចប់ទំនិញរបស់អ្នក">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                    </svg>
                    <span>{{ $locale === 'km' ? 'តាមដានការកម្មង់' : 'Track Order' }}</span>
                </button>

                <!-- Offers Link with glowing pill -->
                <a class="announcement-offers-link" href="{{ route('store.new-arrivals') }}">
                    <span>{{ $translations['announcement']['link'] }}</span>
                    <span aria-hidden="true">↗</span>
                </a>

                <!-- Custom Modern Language Switcher -->
                <form class="language-switcher" action="{{ url()->current() }}" method="GET">
                    @foreach(request()->except(['lang']) as $key => $val)
                        @if(is_string($val))
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                        @endif
                    @endforeach
                    <label class="sr-only" for="store-language">{{ $translations['language']['label'] }}</label>
                    <div class="custom-lang-select-wrap">
                        <select id="store-language" name="lang" aria-label="{{ $translations['language']['label'] }}" onchange="this.form.submit()">
                            <option value="km" @selected($locale === 'km')>🇰🇭 ខ្មែរ</option>
                            <option value="en" @selected($locale === 'en')>🇬🇧 English</option>
                        </select>
                        <svg class="lang-chevron" viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <header class="site-header">
        <div class="container header-main">
            <button class="icon-button menu-toggle" id="mobileMenuToggle" type="button" onclick="toggleMobileNav(event)" aria-label="{{ $translations['nav']['label'] }}" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <a class="brand" href="{{ route('store.home') }}" aria-label="{{ $translations['language']['label'] }}: {{ $translations['meta']['home'] }}">
                <span class="brand-mark" aria-hidden="true">d</span>
                <div class="brand-copy">
                    <div class="brand-copy-title">dara<span>market</span></div>
                    <small>STORE &amp; LIVING</small>
                </div>
            </a>

            <!-- Right Header Actions -->
            <div class="header-actions">
                @if (auth()->check() && auth()->user()->is_admin)
                    <a class="admin-pill-badge" href="{{ route('admin.dashboard') }}" title="Open Store Management Dashboard">
                        <span class="admin-pill-icon">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        </span>
                        <span class="admin-pill-text">
                            <small>{{ $translations['account']['admin_label'] }}</small>
                            <strong>Dashboard ↗</strong>
                        </span>
                    </a>
                @endif

                <!-- Account Dropdown Menu -->
                <div class="account-dropdown-wrapper">
                    <button type="button" class="account-pill-button" onclick="handleAccountButtonClick(event)" aria-expanded="false" title="Account Menu">
                        <div class="account-avatar-circle">
                            @if(auth()->check() && auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="account-avatar-img" referrerpolicy="no-referrer">
                            @else
                                <span>{{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}</span>
                            @endif
                            @if(auth()->check())
                                <span class="avatar-online-dot"></span>
                            @endif
                        </div>
                        <div class="account-text-wrap">
                            <small>{{ auth()->check() ? ($locale === 'km' ? 'សួស្តី,' : 'Hello,') : ($locale === 'km' ? 'សូមស្វាគមន៍' : 'Welcome') }}</small>
                            <strong>{{ auth()->check() ? auth()->user()->name : ($locale === 'km' ? 'គណនី' : 'Account') }}</strong>
                        </div>
                        <svg class="account-chevron" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>

                    <div id="accountDropdownMenu" class="account-dropdown-menu" style="display: none;">
                        @if(auth()->check())
                            <div class="account-menu-profile-card">
                                <div class="menu-avatar-wrap">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="menu-avatar-img" referrerpolicy="no-referrer">
                                    @else
                                        <span class="menu-avatar-letter">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    @endif
                                    <span class="menu-online-badge" title="Online"></span>
                                </div>
                                <div class="menu-profile-details">
                                    <h4 class="menu-user-name">{{ auth()->user()->name }}</h4>
                                    <span class="menu-user-email">{{ auth()->user()->email }}</span>
                                    <div class="menu-tier-pill">
                                        @if(auth()->user()->is_admin)
                                            <span class="tier-tag tier-admin">🛡️ Store Admin</span>
                                        @else
                                            <span class="tier-tag tier-vip">⭐ VIP Member</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="account-menu-list">
                                <a href="{{ route('account.show') }}" class="account-menu-item">
                                    <span class="menu-item-icon icon-profile">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    </span>
                                    <div class="menu-item-content">
                                        <strong>{{ $locale === 'km' ? 'ព័ត៌មានគណនី (My Profile)' : 'My Profile' }}</strong>
                                        <small>{{ $locale === 'km' ? 'កែប្រែទិន្នន័យ & អាសយដ្ឋាន' : 'Personal info & address' }}</small>
                                    </div>
                                    <span class="menu-item-arrow">›</span>
                                </a>

                                <a href="{{ route('account.show') }}#orders" class="account-menu-item">
                                    <span class="menu-item-icon icon-orders">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                    </span>
                                    <div class="menu-item-content">
                                        <strong>{{ $locale === 'km' ? 'ប្រវត្តិការកម្ម៉ង់' : 'My Orders' }}</strong>
                                        <small>{{ $locale === 'km' ? 'ពិនិត្យទំនិញដែលបានទិញ' : 'View order history' }}</small>
                                    </div>
                                    <span class="menu-item-arrow">›</span>
                                </a>

                                <button type="button" class="account-menu-item" onclick="openTrackOrderModal(); toggleAccountMenu();">
                                    <span class="menu-item-icon icon-track">
                                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                                    </span>
                                    <div class="menu-item-content">
                                        <strong>{{ $locale === 'km' ? 'តាមដានការដឹកជញ្ជូន' : 'Track Order' }}</strong>
                                        <small>{{ $locale === 'km' ? 'ពិនិត្យទីតាំងកញ្ចប់ទំនិញ' : 'Live shipment status' }}</small>
                                    </div>
                                    <span class="menu-item-arrow">›</span>
                                </button>

                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="account-menu-item admin-highlight">
                                        <span class="menu-item-icon icon-admin">
                                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                        </span>
                                        <div class="menu-item-content">
                                            <strong>{{ $locale === 'km' ? 'ផ្ទាំងគ្រប់គ្រង Admin' : 'Admin Dashboard' }}</strong>
                                            <small>{{ $locale === 'km' ? 'គ្រប់គ្រងហាង និងទំនិញ' : 'Manage store & orders' }}</small>
                                        </div>
                                        <span class="menu-item-arrow">↗</span>
                                    </a>
                                @endif

                                <div class="account-menu-divider"></div>

                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="account-menu-item logout-btn">
                                        <span class="menu-item-icon icon-logout">
                                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        </span>
                                        <div class="menu-item-content">
                                            <strong>{{ $locale === 'km' ? 'ចាកចេញពីគណនី' : 'Sign Out' }}</strong>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Guest Shopper Menu -->
                            <div class="account-menu-guest-header">
                                <div class="guest-icon">👋</div>
                                <div>
                                    <h4>{{ $locale === 'km' ? 'សូមស្វាគមន៍' : 'Welcome to Dara Market' }}</h4>
                                    <p>{{ $locale === 'km' ? 'ចូលគណនីដើម្បីទទួលបានប័ណ្ណបញ្ចុះតម្លៃ' : 'Sign in to access VIP club deals & orders' }}</p>
                                </div>
                            </div>

                            <div class="guest-cta-buttons">
                                <a href="{{ route('login') }}" class="guest-btn-signin">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                                    <span>{{ $locale === 'km' ? 'ចូលគណនី' : 'Sign In' }}</span>
                                </a>
                                <a href="{{ route('register') }}" class="guest-btn-register">
                                    <span>{{ $locale === 'km' ? 'ចុះឈ្មោះ' : 'Create Account' }}</span>
                                    <span class="guest-bonus-tag">+$15</span>
                                </a>
                            </div>

                            <div class="account-menu-list guest-links">
                                <form action="{{ route('demo.login') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="account-menu-item demo-login-item">
                                        <span class="menu-item-icon icon-demo">⚡</span>
                                        <div class="menu-item-content">
                                            <strong>{{ $locale === 'km' ? 'សាកល្បង Demo (1-Click)' : '1-Click Demo Login' }}</strong>
                                            <small>{{ $locale === 'km' ? 'ចូលភ្លាមៗមិនបាច់វាយពាក្យសម្ងាត់' : 'Instant test account' }}</small>
                                        </div>
                                        <span class="menu-item-arrow">›</span>
                                    </button>
                                </form>

                                <button type="button" class="account-menu-item" onclick="openTrackOrderModal(); toggleAccountMenu();">
                                    <span class="menu-item-icon icon-track">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                                    </span>
                                    <div class="menu-item-content">
                                        <strong>{{ $locale === 'km' ? 'តាមដានការបញ្ជាទិញ' : 'Track Order' }}</strong>
                                    </div>
                                    <span class="menu-item-arrow">›</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Shopping Cart Pill Button -->
                <button type="button" class="cart-pill-button" onclick="openCartDrawer()" title="{{ $locale === 'km' ? 'កន្ត្រកទំនិញ' : 'Shopping Cart' }}" aria-label="Shopping Cart">
                    <span class="cart-icon-wrap">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.9a2 2 0 0 0 1.9-1.5L22 8H6"></path><circle cx="10" cy="20" r="1.2"></circle><circle cx="18" cy="20" r="1.2"></circle></svg>
                        <span class="cart-count" id="headerCartCount" aria-live="polite">0</span>
                    </span>
                    <span class="cart-info-wrap">
                        <small>{{ $translations['cart']['label'] ?? ($locale === 'km' ? 'កន្ត្រក' : 'Cart') }}</small>
                        <strong>$<span class="cart-total" id="headerCartTotal">0.00</span></strong>
                    </span>
                </button>
            </div>

            <!-- Upgraded Search Box with Category Selector & Live Dropdown -->
            <div class="search-box-wrapper">
                <form class="search-box" action="{{ route('store.products') }}" method="GET" role="search" id="headerSearchForm">
                    <div class="search-category-select">
                        <select name="category" id="searchCategorySelect" aria-label="Filter category">
                            <option value="all">All Categories</option>
                            @foreach (config('store.categories') as $cat)
                                <option value="{{ $cat }}" @selected(($selectedCategory ?? 'all') === $cat)>{{ __('store.categories.'.$cat, [], 'en') }}</option>
                            @endforeach
                        </select>
                        <svg class="search-cat-chevron" viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>

                    <input id="store-search" name="q" type="search" value="{{ $search ?? '' }}" placeholder="{{ $translations['search']['placeholder'] }}" autocomplete="off" onfocus="showSearchSuggest()" oninput="handleSearchInput(this.value)">

                    <button type="button" id="searchClearBtn" class="search-clear-btn" style="display: {{ !empty($search) ? 'grid' : 'none' }};" onclick="clearSearchInput()">✕</button>

                    <button type="submit" class="search-submit-btn" aria-label="{{ $translations['search']['button'] }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 5 5"></path></svg>
                    </button>
                </form>

                <!-- Search Suggestions Dropdown -->
                <div id="searchSuggestBox" class="search-suggestions-dropdown" style="display: none;">
                    <div class="search-trending-section">
                        <span class="trending-title">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#f97316" stroke-width="2" style="vertical-align:-2px; margin-right:3px;"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 3z"></path></svg>
                            Trending:
                        </span>
                        <div class="trending-tags">
                            <button type="button" class="trending-tag" onclick="quickFillSearch('Headphones')">Headphones</button>
                            <button type="button" class="trending-tag" onclick="quickFillSearch('Backpack')">Backpack</button>
                            <button type="button" class="trending-tag" onclick="quickFillSearch('Watch')">Watch</button>
                            <button type="button" class="trending-tag" onclick="quickFillSearch('Shoes')">Shoes</button>
                        </div>
                    </div>
                    <div id="searchLiveResults" class="search-live-results"></div>
                </div>
            </div>
        </div>

        <nav class="main-nav" aria-label="{{ $translations['nav']['label'] }}">
            <div class="container nav-inner">
                <!-- Mobile Drawer Header (Visible on Mobile Only) -->
                <div class="mobile-drawer-header">
                    <div class="drawer-brand">
                        <span class="brand-mark" style="width: 32px; height: 32px; font-size: 18px; border-radius: 9px;">d</span>
                        <div class="brand-copy" style="font-size: 18px;">
                            <div class="brand-copy-title">dara<span>market</span></div>
                        </div>
                    </div>
                    <button type="button" class="drawer-close-btn" onclick="document.querySelector('.main-nav').classList.remove('is-open')" aria-label="Close menu">✕</button>
                </div>

                <!-- 1. All Categories Mega Dropdown Trigger -->
                <div class="nav-category-dropdown-wrapper">
                    <button type="button" class="nav-category-trigger-btn" id="navCategoryBtn" onclick="toggleNavCategoryMenu()" aria-expanded="false" aria-haspopup="true">
                        <span class="nav-category-hamburger" aria-hidden="true">
                            <span></span><span></span><span></span>
                        </span>
                        <span class="nav-category-label">{{ $locale === 'km' ? 'ប្រភេទទំនិញទាំងអស់' : 'All Categories' }}</span>
                        <svg class="nav-category-chevron" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>

                    <!-- Rich Mega Dropdown Card -->
                    <div class="nav-mega-menu" id="navMegaMenu" style="display: none;">
                        <div class="mega-menu-grid">
                            <div class="mega-menu-categories">
                                <a href="{{ route('store.products', ['category' => 'electronics']) }}" class="mega-cat-item">
                                    <div class="mega-cat-icon-box">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>
                                    </div>
                                    <div class="mega-cat-info">
                                        <div class="mega-cat-title-row">
                                            <strong>{{ $locale === 'km' ? 'គ្រឿងអេឡិចត្រូនិច' : 'Electronics & Tech' }}</strong>
                                            <span class="mega-badge hot">HOT</span>
                                        </div>
                                        <small>{{ $locale === 'km' ? 'កាស, នាឡិកា, កាមេរ៉ា' : 'Headphones, Watches, Cameras' }}</small>
                                    </div>
                                    <span class="mega-cat-arrow">→</span>
                                </a>

                                <a href="{{ route('store.products', ['category' => 'fashion']) }}" class="mega-cat-item">
                                    <div class="mega-cat-icon-box">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                    </div>
                                    <div class="mega-cat-info">
                                        <div class="mega-cat-title-row">
                                            <strong>{{ $locale === 'km' ? 'ម៉ូដសម្លៀកបំពាក់ & ស្ទីល' : 'Fashion & Apparel' }}</strong>
                                            <span class="mega-badge popular">TREND</span>
                                        </div>
                                        <small>{{ $locale === 'km' ? 'កាបូប, ស្បែកជើង, វ៉ែនតា' : 'Backpacks, Shoes, Sunglasses' }}</small>
                                    </div>
                                    <span class="mega-cat-arrow">→</span>
                                </a>

                                <a href="{{ route('store.products', ['category' => 'home']) }}" class="mega-cat-item">
                                    <div class="mega-cat-icon-box">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                    </div>
                                    <div class="mega-cat-info">
                                        <div class="mega-cat-title-row">
                                            <strong>{{ $locale === 'km' ? 'គេហដ្ឋាន និងការរស់នៅ' : 'Home & Living' }}</strong>
                                        </div>
                                        <small>{{ $locale === 'km' ? 'គ្រឿងតុបតែង, សម្ភារៈប្រើប្រាស់' : 'Decor, Essentials & Comfort' }}</small>
                                    </div>
                                    <span class="mega-cat-arrow">→</span>
                                </a>

                                <a href="{{ route('store.categories') }}" class="mega-cat-item mega-cat-all">
                                    <div class="mega-cat-icon-box">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>
                                    </div>
                                    <div class="mega-cat-info">
                                        <div class="mega-cat-title-row">
                                            <strong>{{ $locale === 'km' ? 'មើលប្រភេទទំនិញទាំងអស់' : 'View All Categories' }}</strong>
                                        </div>
                                        <small>{{ $locale === 'km' ? 'រុករកកាតាឡុកទំនិញពេញលេញ' : 'Explore full collection' }}</small>
                                    </div>
                                    <span class="mega-cat-arrow">↗</span>
                                </a>
                            </div>

                            <!-- Mega Menu Featured Promo Card -->
                            <div class="mega-menu-promo-card">
                                <div class="mega-promo-badge">WEEKEND OFFER</div>
                                <h4>{{ $locale === 'km' ? 'បញ្ចុះតម្លៃរហូតដល់ 30%' : 'Save Up To 30% OFF' }}</h4>
                                <p>{{ $locale === 'km' ? 'ទទួលបានការបញ្ចុះតម្លៃពិសេសលើទំនិញថ្មីៗជាច្រើនមុខ!' : 'Special deals on newly arrived lifestyle and tech essentials.' }}</p>
                                <a href="{{ route('store.products') }}" class="mega-promo-btn">
                                    <span>{{ $locale === 'km' ? 'ទិញឥឡូវនេះ' : 'Explore Deals' }}</span>
                                    <span>→</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Primary Navigation Links with Badges -->
                <div class="nav-links-track">
                    <a class="nav-link-pill {{ request()->routeIs('store.home') ? 'active' : '' }}" href="{{ route('store.home') }}">
                        <span class="nav-pill-icon"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></span>
                        <span>{{ $translations['nav']['home'] }}</span>
                    </a>

                    <a class="nav-link-pill {{ request()->routeIs('store.products') ? 'active' : '' }}" href="{{ route('store.products') }}">
                        <span class="nav-pill-icon"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg></span>
                        <span>{{ $translations['nav']['products'] }}</span>
                    </a>

                    <a class="nav-link-pill {{ request()->routeIs('store.categories') ? 'active' : '' }}" href="{{ route('store.categories') }}">
                        <span class="nav-pill-icon"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg></span>
                        <span>{{ $translations['nav']['categories'] }}</span>
                    </a>

                    <a class="nav-link-pill {{ request()->routeIs('store.new-arrivals') ? 'active' : '' }}" href="{{ route('store.new-arrivals') }}">
                        <span class="nav-pill-icon"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3Z"></path></svg></span>
                        <span>{{ $translations['nav']['new'] }}</span>
                        <span class="nav-micro-badge badge-new">NEW</span>
                    </a>

                    <a class="nav-link-pill nav-deal-pill" href="{{ route('store.products') }}#featured">
                        <span class="nav-pill-icon"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg></span>
                        <span>{{ $locale === 'km' ? 'ប្រូម៉ូសិនពិសេស' : 'Flash Sale' }}</span>
                        <span class="nav-micro-badge badge-discount">-30%</span>
                    </a>

                    <button type="button" class="nav-link-pill nav-track-btn" onclick="openTrackOrderModal()" title="Track Your Order">
                        <span class="nav-pill-icon"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg></span>
                        <span>{{ $locale === 'km' ? 'តាមដានឥវ៉ាន់' : 'Track Order' }}</span>
                    </button>

                    <a class="{{ request()->routeIs('store.about') ? 'nav-item active' : 'nav-item' }}" href="{{ route('store.about') }}">
                        <span>{{ $translations['nav']['about'] }}</span>
                    </a>

                    <a class="{{ request()->routeIs('store.contact') ? 'nav-item active' : 'nav-item' }}" href="{{ route('store.contact') }}">
                        <span>{{ $translations['nav']['contact'] }}</span>
                    </a>
                </div>

                <!-- 3. Right Side: Live Store Hours & Hotline Pill -->
                <div class="nav-right-utility">
                    <div class="nav-status-chip" title="Store Operating Hours">
                        <span class="status-pulse-dot" aria-hidden="true"></span>
                        <span class="status-chip-text">
                            <span class="status-open-label">{{ $locale === 'km' ? 'កំពុងបើកដំណើរការ' : 'Open Now' }}</span>
                            <span class="status-hours-time">{{ $translations['nav']['hours'] }}</span>
                        </span>
                    </div>

                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $storeSettings['contact_phone'] ?? '+855714504547') }}" class="nav-hotline-pill" title="Need help? Call us!">
                        <span class="hotline-icon"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></span>
                        <span class="hotline-text">
                            <small>{{ $locale === 'km' ? 'សេវាជំនួយ' : 'Support' }}</small>
                            <strong>{{ $storeSettings['contact_phone'] ?? '071 450 4547' }}</strong>
                        </span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer" id="footer">
        <div class="container footer-grid">
            <div class="footer-about">
                <a class="brand footer-brand" href="{{ route('store.home') }}">
                    <span class="brand-mark" aria-hidden="true">d</span>
                    <span class="brand-copy">dara<span>market</span><small class="footer-tagline-text">{{ $translations['footer']['tagline'] }}</small></span>
                </a>
                <p>{{ $translations['footer']['about'] }}</p>
                <div class="social-links" aria-label="{{ $translations['footer']['social'] }}">
                    <a href="#footer" aria-label="Facebook" class="social-btn facebook" title="Facebook">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03.26-1.5 1.5-1.5h2V2.14A26 26 0 0 0 14.5 2C11.77 2 10 3.65 10 6.7v2.8H7v4h3V22h4v-8.5z"/></svg>
                    </a>
                    <a href="#footer" aria-label="Telegram" class="social-btn telegram" title="Telegram">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 0 0-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.52 2.77-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .37z"/></svg>
                    </a>
                    <a href="#footer" aria-label="Instagram" class="social-btn instagram" title="Instagram">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="#footer" aria-label="TikTok" class="social-btn tiktok" title="TikTok">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.89 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.35 0 .68.06.99.16V9.45a6.37 6.37 0 0 0-.99-.08A6.34 6.34 0 0 0 3 15.67 6.34 6.34 0 0 0 9.34 22a6.34 6.34 0 0 0 6.34-6.33V9.26c1.28.91 2.83 1.45 4.51 1.48V7.29a4.88 4.88 0 0 1-.6-.6z"/></svg>
                    </a>
                </div>
            </div>
            <div class="footer-column footer-service-col">
                <h2>{{ $translations['footer']['customer_service'] }}</h2>
                <ul class="footer-links-list">
                    <li><a href="#featured"><span>{{ $translations['footer']['how_to_order'] }}</span> <svg class="footer-link-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a></li>
                    <li><a href="#why-us"><span>{{ $translations['footer']['shipping'] }}</span> <svg class="footer-link-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a></li>
                    <li><a href="#why-us"><span>{{ $translations['footer']['returns'] }}</span> <svg class="footer-link-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a></li>
                    <li><a href="mailto:hello@daramarket.com?subject={{ rawurlencode($translations['footer']['faq']) }}"><span>{{ $translations['footer']['faq'] }}</span> <svg class="footer-link-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a></li>
                </ul>
            </div>
            <div class="footer-column footer-contact-col">
                <h2>{{ $translations['footer']['contact'] }}</h2>
                <div class="footer-contact-list">
                    <a class="contact-link" href="tel:{{ preg_replace('/[^0-9+]/', '', $storeSettings['contact_phone'] ?? '+855714504547') }}">
                        <span class="contact-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </span>
                        <div class="contact-details">
                            <span class="contact-label">{{ $locale === 'km' ? 'ទូរស័ព្ទដៃ' : 'Phone' }}</span>
                            <span class="contact-value">{{ $storeSettings['contact_phone'] ?? '+855 71 450 4547' }}</span>
                        </div>
                    </a>
                    <a class="contact-link" href="mailto:{{ $storeSettings['contact_email'] ?? 'hello@daramarket.com' }}">
                        <span class="contact-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <div class="contact-details">
                            <span class="contact-label">{{ $locale === 'km' ? 'អ៊ីមែល' : 'Email' }}</span>
                            <span class="contact-value">{{ $storeSettings['contact_email'] ?? 'hello@daramarket.com' }}</span>
                        </div>
                    </a>
                    <div class="contact-link contact-info-item">
                        <span class="contact-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </span>
                        <div class="contact-details">
                            <span class="contact-label">{{ $locale === 'km' ? 'ទីតាំង' : 'Location' }}</span>
                            <span class="contact-value">{{ $storeSettings['store_address'] ?? ($translations['footer']['location'] ?? 'ភ្នំពេញ កម្ពុជា') }}</span>
                        </div>
                    </div>
                    <div class="contact-link contact-info-item">
                        <span class="contact-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </span>
                        <div class="contact-details">
                            <span class="contact-label">{{ $locale === 'km' ? 'ម៉ោងធ្វើការ' : 'Hours' }}</span>
                            <span class="contact-value">{{ $storeSettings['business_hours'] ?? ($translations['footer']['hours'] ?? 'ច័ន្ទ - អាទិត្យ 7:00 AM - 9:00 PM') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-newsletter">
                <div class="newsletter-kicker-wrap">
                    <span class="footer-kicker">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                        {{ $translations['products']['newsletter_kicker'] }}
                    </span>
                </div>
                <h2>{{ $translations['footer']['newsletter'] }}</h2>
                <p>{{ $translations['footer']['newsletter_description'] }}</p>
                <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <label class="sr-only" for="newsletter-email">{{ $translations['footer']['email_label'] }}</label>
                    <div class="newsletter-input-group">
                        <span class="newsletter-input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <input id="newsletter-email" name="email" type="email" placeholder="{{ $translations['footer']['email_placeholder'] }}" autocomplete="email" maxlength="255" required>
                        <button type="submit" aria-label="{{ $translations['footer']['subscribe'] }}">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>
                </form>
                <span class="newsletter-message" role="status" aria-live="polite"></span>
                <div class="newsletter-trust-tags">
                    <span>
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        {{ $locale === 'km' ? 'សុវត្ថិភាព 100%' : '100% Safe' }}
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        {{ $locale === 'km' ? 'គ្មានសាររំខាន' : 'No Spam' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container footer-bottom-inner">
                <div class="footer-copy-text">
                    <span>© {{ date('Y') }} Dara Market. {{ $translations['footer']['copyright'] }}</span>
                    <span class="footer-dot-divider">•</span>
                    <span class="footer-tagline-muted">{{ $translations['footer']['tagline'] }}</span>
                </div>
                <div class="footer-payment-badges" aria-label="{{ $locale === 'km' ? 'វិធីសាស្ត្រទូទាត់ប្រាក់' : 'Payment Methods' }}">
                    <span class="pay-badge" title="Bakong KHQR">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        KHQR
                    </span>
                    <span class="pay-badge" title="Visa">VISA</span>
                    <span class="pay-badge" title="Mastercard">MasterCard</span>
                    <span class="pay-badge" title="Cash on Delivery">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                        COD
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <div class="toast-message" role="status" aria-live="polite"></div>

    <!-- Track Order Interactive Modal -->
    <div id="trackOrderModal" class="store-modal-backdrop" style="display: none;" onclick="if(event.target === this) closeTrackOrderModal()">
        <div class="store-modal-card">
            <div class="store-modal-header">
                <h3>
                    <span>📦</span>
                    <span>{{ $locale === 'km' ? 'តាមដានស្ថានភាពការកុម្ម៉ង់' : 'Track Your Order' }}</span>
                </h3>
                <button type="button" class="store-modal-close" onclick="closeTrackOrderModal()">✕</button>
            </div>
            <div class="store-modal-body">
                <form id="trackOrderForm" onsubmit="handleTrackOrder(event)">
                    <div class="track-input-group">
                        <label for="track_order_number">{{ $locale === 'km' ? 'លេខសម្គាល់ការកុម្ម៉ង់ (Order Number)' : 'Order Number' }}</label>
                        <input id="track_order_number" type="text" placeholder="e.g. ORD-2026-6208 ឬ 6208" required autocomplete="off">
                    </div>
                    <div class="track-input-group">
                        <label for="track_phone">{{ $locale === 'km' ? 'លេខទូរស័ព្ទ (ស្រេចចិត្ត)' : 'Phone Number (Optional)' }}</label>
                        <input id="track_phone" type="tel" placeholder="e.g. 071 450 4547" autocomplete="off">
                    </div>
                    <button type="submit" id="trackSubmitBtn" class="track-submit-btn">
                        <span>🔍</span>
                        <span>{{ $locale === 'km' ? 'ពិនិត្យមើលស្ថានភាព' : 'Check Order Status' }}</span>
                    </button>
                </form>

                <div id="trackResultContainer" style="display: none;"></div>
            </div>
        </div>
    </div>

    <style>
    /* Modern Track Order Modal Enhancements */
    .store-modal-card {
        max-height: 92vh;
        display: flex;
        flex-direction: column;
    }
    .store-modal-body {
        overflow-y: auto;
        max-height: calc(92vh - 65px);
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f8fafc;
    }
    .track-result-box {
        margin-top: 18px;
        padding: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
    }
    .track-timeline-wrapper {
        position: relative;
        margin: 22px 0 16px;
        padding: 0 4px;
    }
    .track-timeline-wrapper::before {
        content: "";
        position: absolute;
        top: 15px;
        left: 24px;
        right: 24px;
        height: 4px;
        background: #e2e8f0;
        border-radius: 999px;
        z-index: 1;
    }
    .track-timeline-bar {
        position: absolute;
        top: 15px;
        left: 24px;
        max-width: calc(100% - 48px);
        height: 4px;
        background: linear-gradient(90deg, #16a34a, #22c55e);
        border-radius: 999px;
        z-index: 2;
        transition: width 0.4s ease;
    }
    .track-timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 3;
    }
    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        flex: 1;
        text-align: center;
    }
    .timeline-step .step-node {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ffffff;
        border: 2.5px solid #cbd5e1;
        color: #64748b;
        font-weight: 800;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.06);
    }
    .timeline-step.is-done .step-node {
        background: #16a34a;
        border-color: #16a34a;
        color: #ffffff;
    }
    .timeline-step.is-current .step-node {
        background: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.25);
        animation: pulseStepNode 1.8s infinite;
    }
    @keyframes pulseStepNode {
        0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
        70% { box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
        100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }
    .timeline-step .step-title {
        font-size: 11.5px;
        font-weight: 700;
        color: #334155;
        line-height: 1.2;
    }
    .timeline-step .step-sub {
        font-size: 9.5px;
        color: #94a3b8;
    }
    .timeline-step.is-done .step-title,
    .timeline-step.is-current .step-title {
        color: #0f172a;
    }
    .track-cancelled-alert {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 14px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin: 16px 0;
    }
    .cancelled-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ef4444;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 800;
        flex-shrink: 0;
    }
    .track-status-note {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 12px 14px;
        margin: 16px 0;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .note-icon {
        font-size: 18px;
        line-height: 1.2;
    }
    .note-km {
        margin: 0;
        font-size: 12.5px;
        font-weight: 700;
        color: #166534;
        line-height: 1.4;
    }
    .note-en {
        margin: 3px 0 0;
        font-size: 11px;
        color: #15803d;
        opacity: 0.85;
    }
    .track-items-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 14px;
    }
    .track-items-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        padding-bottom: 8px;
        border-bottom: 1px dashed #e2e8f0;
        margin-bottom: 8px;
    }
    .track-item-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 0;
    }
    .track-item-row:not(:last-child) {
        border-bottom: 1px solid #f1f5f9;
    }
    .track-item-img {
        width: 38px;
        height: 38px;
        border-radius: 6px;
        object-fit: cover;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }
    .track-item-details {
        flex: 1;
        min-width: 0;
    }
    .track-item-name {
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .track-item-meta {
        font-size: 11px;
        color: #64748b;
    }
    .track-item-price {
        font-size: 12.5px;
        font-weight: 700;
        color: #0f172a;
    }
    .track-info-summary {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 12px;
    }
    .summary-col {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
    }
    .summary-lbl {
        color: #64748b;
        font-weight: 600;
        flex-shrink: 0;
    }
    .summary-val {
        color: #1e293b;
        text-align: right;
        font-weight: 500;
    }
    .total-col {
        border-top: 1px dashed #e2e8f0;
        padding-top: 8px;
        margin-top: 2px;
    }
    .summary-val-total {
        font-size: 16px;
        font-weight: 800;
        color: #16a34a;
    }
    .track-action-bar {
        display: flex;
        gap: 10px;
        margin-top: 14px;
    }
    .btn-track-refresh {
        flex: 1;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 9px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.15s ease;
    }
    .btn-track-refresh:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .btn-track-call {
        flex: 1;
        background: #173e2c;
        color: #ffffff;
        border: none;
        padding: 9px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.15s ease;
    }
    .btn-track-call:hover {
        background: #245943;
        color: #ffffff;
    }
    .status-tag-pending { background: #fef3c7; color: #b45309; }
    .status-tag-processing { background: #dbeafe; color: #1d4ed8; }
    .status-tag-shipped { background: #ede9fe; color: #6d28d9; }
    .status-tag-delivered { background: #dcfce7; color: #15803d; }
    .status-tag-cancelled { background: #fee2e2; color: #b91c1c; }
    .track-error-box {
        margin-top: 16px;
        padding: 14px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    </style>

    <!-- Announcement & Modal Scripts -->
    <script>
    // 1. Rotating Announcement Ticker
    let currentTickerIdx = 0;
    const tickerItems = document.querySelectorAll('.ticker-item');
    let tickerInterval = null;

    function showTickerItem(idx) {
        if (!tickerItems.length) return;
        tickerItems.forEach(el => el.classList.remove('is-active'));
        currentTickerIdx = (idx + tickerItems.length) % tickerItems.length;
        tickerItems[currentTickerIdx].classList.add('is-active');
    }

    function nextTickerItem() {
        showTickerItem(currentTickerIdx + 1);
    }

    function prevTickerItem() {
        showTickerItem(currentTickerIdx - 1);
    }

    function startTickerTimer() {
        if (tickerInterval) clearInterval(tickerInterval);
        tickerInterval = setInterval(nextTickerItem, 4000);
    }

    const tickerEl = document.getElementById('announcementTicker');
    if (tickerEl) {
        tickerEl.addEventListener('mouseenter', () => clearInterval(tickerInterval));
        tickerEl.addEventListener('mouseleave', startTickerTimer);
        startTickerTimer();
    }

    // 2. Flash Sale Countdown Timer
    function startFlashCountdown() {
        let totalSeconds = (5 * 3600) + (28 * 60) + 42;
        const hrsEl = document.getElementById('tbHours');
        const minEl = document.getElementById('tbMins');
        const secEl = document.getElementById('tbSecs');

        setInterval(() => {
            if (totalSeconds > 0) {
                totalSeconds--;
                const hrs = Math.floor(totalSeconds / 3600);
                const mins = Math.floor((totalSeconds % 3600) / 60);
                const secs = totalSeconds % 60;
                if (hrsEl) hrsEl.textContent = String(hrs).padStart(2, '0');
                if (minEl) minEl.textContent = String(mins).padStart(2, '0');
                if (secEl) secEl.textContent = String(secs).padStart(2, '0');
            }
        }, 1000);
    }
    startFlashCountdown();

    // 3. One-Click Copy Coupon Code
    function copyPromoCode(code, btn) {
        navigator.clipboard.writeText(code).then(() => {
            const hint = btn.querySelector('.copy-hint');
            const orig = hint.textContent;
            hint.textContent = '✓ Copied!';
            hint.style.background = '#245943';
            hint.style.color = '#fff';
            setTimeout(() => {
                hint.textContent = orig;
                hint.style.background = '#d8a962';
                hint.style.color = '#10291f';
            }, 2000);
        });
    }

    // 4. Track Order Modal & AJAX
    function openTrackOrderModal() {
        const modal = document.getElementById('trackOrderModal');
        if (modal) {
            modal.style.display = 'flex';
            const input = document.getElementById('track_order_number');
            const phoneInput = document.getElementById('track_phone');
            if (input && !input.value.trim()) {
                const savedOrder = localStorage.getItem('dara_last_order');
                if (savedOrder) input.value = savedOrder;
            }
            if (phoneInput && !phoneInput.value.trim()) {
                const savedPhone = localStorage.getItem('dara_last_order_phone');
                if (savedPhone) phoneInput.value = savedPhone;
            }
            if (input) input.focus();
        }
    }

    function closeTrackOrderModal() {
        const modal = document.getElementById('trackOrderModal');
        if (modal) modal.style.display = 'none';
    }

    async function handleTrackOrder(e) {
        if (e && typeof e.preventDefault === 'function') e.preventDefault();
        const orderNum = document.getElementById('track_order_number').value.trim();
        const phone = document.getElementById('track_phone').value.trim();
        const resBox = document.getElementById('trackResultContainer');
        const submitBtn = document.getElementById('trackSubmitBtn');

        if (!orderNum) return;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>⏳</span><span>កំពុងស្វែងរក... (Searching)</span>';

        try {
            const url = `{{ route('store.track-order') }}?order_number=${encodeURIComponent(orderNum)}&phone=${encodeURIComponent(phone)}`;
            const resp = await fetch(url);
            const data = await resp.json();

            if (data.success && data.order) {
                const ord = data.order;
                const status = (ord.status || 'pending').toLowerCase();
                const isCancelled = (status === 'cancelled');

                const statusLabels = {
                    'pending': { text: '⏳ រង់ចាំការបញ្ជាក់', sub: 'Pending Confirmation', class: 'status-tag-pending' },
                    'processing': { text: '⚙️ កំពុងរៀបចំទំនិញ', sub: 'Processing & Packing', class: 'status-tag-processing' },
                    'shipped': { text: '🚚 កំពុងដឹកជញ្ជូន', sub: 'Out for Delivery', class: 'status-tag-shipped' },
                    'delivered': { text: '✓ ដឹកជញ្ជូនជោគជ័យ', sub: 'Delivered', class: 'status-tag-delivered' },
                    'cancelled': { text: '✕ បានលុបចោល', sub: 'Cancelled', class: 'status-tag-cancelled' }
                };

                const currentStatusInfo = statusLabels[status] || statusLabels['pending'];

                // Fulfillment steps
                const steps = ['pending', 'processing', 'shipped', 'delivered'];
                const curIdx = steps.indexOf(status);

                // Progress line width
                let progressPercent = 0;
                if (curIdx === 0) progressPercent = 12;
                else if (curIdx === 1) progressPercent = 42;
                else if (curIdx === 2) progressPercent = 75;
                else if (curIdx === 3) progressPercent = 100;

                let timelineHtml = '';
                if (isCancelled) {
                    timelineHtml = `
                        <div class="track-cancelled-alert">
                            <div class="cancelled-icon">✕</div>
                            <div class="cancelled-content">
                                <strong style="color: #991b1b; font-size: 13.5px;">ការបញ្ជាទិញនេះត្រូវបានលុបចោល (Order Cancelled)</strong>
                                <p style="margin: 4px 0 0; font-size: 12px; color: #b91c1c;">${ord.status_note?.km || 'សូមទាក់ទងមកកាន់យើងខ្ញុំតាម 071 450 4547 ប្រសិនបើមានចម្ងល់។'}</p>
                            </div>
                        </div>
                    `;
                } else {
                    timelineHtml = `
                        <div class="track-timeline-wrapper">
                            <div class="track-timeline-bar" style="width: ${progressPercent}%;"></div>
                            <div class="track-timeline">
                                <div class="timeline-step ${curIdx >= 0 ? 'is-done' : ''} ${curIdx === 0 ? 'is-current' : ''}">
                                    <div class="step-node">${curIdx > 0 ? '✓' : '1'}</div>
                                    <span class="step-title">បានកុម្ម៉ង់</span>
                                    <small class="step-sub">Placed</small>
                                </div>
                                <div class="timeline-step ${curIdx >= 1 ? 'is-done' : ''} ${curIdx === 1 ? 'is-current' : ''}">
                                    <div class="step-node">${curIdx > 1 ? '✓' : '2'}</div>
                                    <span class="step-title">កំពុងរៀបចំ</span>
                                    <small class="step-sub">Processing</small>
                                </div>
                                <div class="timeline-step ${curIdx >= 2 ? 'is-done' : ''} ${curIdx === 2 ? 'is-current' : ''}">
                                    <div class="step-node">${curIdx > 2 ? '✓' : '3'}</div>
                                    <span class="step-title">កំពុងដឹក</span>
                                    <small class="step-sub">Shipped</small>
                                </div>
                                <div class="timeline-step ${curIdx >= 3 ? 'is-done' : ''} ${curIdx === 3 ? 'is-current' : ''}">
                                    <div class="step-node">${curIdx >= 3 ? '✓' : '4'}</div>
                                    <span class="step-title">បានដឹកដល់</span>
                                    <small class="step-sub">Delivered</small>
                                </div>
                            </div>
                        </div>
                    `;
                }

                // Render purchased items if available
                let itemsHtml = '';
                if (ord.items && ord.items.length > 0) {
                    itemsHtml = `
                        <div class="track-items-box">
                            <div class="track-items-title">
                                <span>📦 ទំនិញក្នុងកញ្ចប់ (${ord.items.length} មុខ)</span>
                                <small style="color: #64748b;">${ord.date}</small>
                            </div>
                            <div class="track-items-list">
                                ${ord.items.map(it => `
                                    <div class="track-item-row">
                                        <img src="${it.image}" alt="${it.name}" class="track-item-img" onerror="this.src='https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80'">
                                        <div class="track-item-details">
                                            <div class="track-item-name">${it.name}</div>
                                            <div class="track-item-meta">ចំនួន: <strong>x${it.quantity}</strong> · $${it.price} / មួយ</div>
                                        </div>
                                        <div class="track-item-price">$${(it.quantity * parseFloat(it.price)).toFixed(2)}</div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                // Payment method label
                const payMethodMap = {
                    'aba_pay': 'ABA PAY (KHQR)',
                    'bakong': 'Bakong KHQR',
                    'cod': 'Cash on Delivery (COD)'
                };
                const payMethodName = payMethodMap[ord.payment_method] || ord.payment_method || 'ABA PAY (KHQR)';
                const isPaid = (ord.payment_status === 'paid');

                resBox.innerHTML = `
                    <div class="track-result-box">
                        <div class="result-header">
                            <div>
                                <span class="result-order-num">#${ord.order_number}</span>
                                <small style="display:block; color:#64748b; font-size:11.5px; margin-top:2px;">
                                    អតិថិជន: <strong>${ord.customer_name}</strong> · 📞 <strong>${ord.customer_phone || ''}</strong>
                                </small>
                            </div>
                            <div style="text-align: right;">
                                <span class="result-status-tag ${currentStatusInfo.class}">${currentStatusInfo.text}</span>
                                <small style="display:block; font-size:10px; color:#64748b; margin-top:3px;">${currentStatusInfo.sub}</small>
                            </div>
                        </div>

                        ${timelineHtml}

                        <!-- Status Description Note -->
                        <div class="track-status-note">
                            <span class="note-icon">📢</span>
                            <div class="note-body">
                                <p class="note-km">${ord.status_note?.km || ''}</p>
                                <p class="note-en">${ord.status_note?.en || ''}</p>
                            </div>
                        </div>

                        ${itemsHtml}

                        <!-- Delivery and Payment Summary -->
                        <div class="track-info-summary">
                            <div class="summary-col">
                                <span class="summary-lbl">📍 អាសយដ្ឋានដឹកជញ្ជូន:</span>
                                <span class="summary-val">${ord.shipping_address || 'រាជធានីភ្នំពេញ'}</span>
                            </div>
                            <div class="summary-col">
                                <span class="summary-lbl">💳 ការទូទាត់ប្រាក់:</span>
                                <span class="summary-val">
                                    ${payMethodName} · 
                                    <strong style="color: ${isPaid ? '#16a34a' : '#d97706'};">
                                        ${isPaid ? '✓ បានទូទាត់ (Paid)' : '⏳ រង់ចាំទូទាត់ (Pending)'}
                                    </strong>
                                </span>
                            </div>
                            <div class="summary-col total-col">
                                <span class="summary-lbl">សរុបទឹកប្រាក់:</span>
                                <span class="summary-val-total">$${ord.total_amount}</span>
                            </div>
                        </div>

                        <!-- Live Action Bar -->
                        <div class="track-action-bar">
                            <button type="button" class="btn-track-refresh" onclick="handleTrackOrder(event)" title="ពិនិត្យស្ថានភាពចុងក្រោយ">
                                🔄 ពិនិត្យឡើងវិញ (Refresh)
                            </button>
                            <a href="tel:0714504547" class="btn-track-call">
                                📞 Call Hotline: 071 450 4547
                            </a>
                        </div>
                    </div>
                `;
                resBox.style.display = 'block';
            } else {
                resBox.innerHTML = `
                    <div class="track-error-box">
                        <span style="font-size: 20px;">⚠️</span>
                        <div>
                            <strong style="color: #991b1b; font-size: 13px;">រកមិនឃើញការកុម្ម៉ង់!</strong>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #b91c1c;">
                                ${data.message || 'សូមពិនិត្យលេខកុម្ម៉ង់ (#ORD-xxxx) រួចព្យាយាមម្តងទៀត។'}
                            </p>
                        </div>
                    </div>
                `;
                resBox.style.display = 'block';
            }
        } catch (err) {
            console.error(err);
            resBox.innerHTML = `
                <div class="track-error-box">
                    <span style="font-size: 20px;">⚠️</span>
                    <div>
                        <strong style="color: #991b1b; font-size: 13px;">មានបញ្ហាក្នុងការស្វែងរក!</strong>
                        <p style="margin: 4px 0 0 0; font-size: 12px; color: #b91c1c;">
                            សូមពិនិត្យការតភ្ជាប់អ៊ីនធឺណិត ឬទាក់ទងមកកាន់ 071 450 4547។
                        </p>
                    </div>
                </div>
            `;
            resBox.style.display = 'block';
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>🔍</span><span>{{ $locale === 'km' ? 'ពិនិត្យមើលស្ថានភាព' : 'Check Order Status' }}</span>';
        }
    }

    // 5. Account Menu Dropdown
    function toggleAccountMenu() {
        const menu = document.getElementById('accountDropdownMenu');
        if (menu) {
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }
    }

    // 6. Mini-Cart Drawer Logic
    function getStoredCartData() {
        try {
            const raw = localStorage.getItem('dara-market-cart');
            if (raw) {
                const parsed = JSON.parse(raw);
                if (!parsed.items || !Array.isArray(parsed.items)) {
                    parsed.items = [];
                    if (parsed.count > 0 && parsed.total > 0) {
                        parsed.items.push({
                            id: 1,
                            name: 'Everyday backpack',
                            price: parsed.total / parsed.count,
                            image: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80',
                            quantity: parsed.count
                        });
                    }
                }
                return parsed;
            }
        } catch (e) {
            console.error(e);
        }
        return { count: 0, total: 0, items: [] };
    }

    function saveCartData(cart) {
        localStorage.setItem('dara-market-cart', JSON.stringify(cart));
        document.querySelectorAll('.cart-count').forEach(el => el.textContent = String(cart.count));
        document.querySelectorAll('.cart-total').forEach(el => el.textContent = cart.total.toFixed(2));
    }

    function openMiniCart() {
        if (typeof openCartDrawer === 'function') {
            openCartDrawer();
        }
    }

    function closeMiniCart() {
        if (typeof closeCartDrawer === 'function') {
            closeCartDrawer();
        }
    }

    function renderMiniCart() {
        if (typeof renderCartDrawerItems === 'function' && typeof getStoredCart === 'function') {
            renderCartDrawerItems(getStoredCart());
        }
    }
    window.renderMiniCart = renderMiniCart;

    function clearFullCart() {
        if (!confirm('Are you sure you want to clear your cart?')) return;
        if (typeof saveStoredCart === 'function') {
            saveStoredCart({ count: 0, total: 0, items: [] });
        }
    }

    // 7. Live Instant Search Suggestions
    let searchDebounceTimer = null;

    function showSearchSuggest() {
        const box = document.getElementById('searchSuggestBox');
        if (box) box.style.display = 'block';
    }

    function clearSearchInput() {
        const input = document.getElementById('store-search');
        const clearBtn = document.getElementById('searchClearBtn');
        const liveRes = document.getElementById('searchLiveResults');
        if (input) { input.value = ''; input.focus(); }
        if (clearBtn) clearBtn.style.display = 'none';
        if (liveRes) liveRes.innerHTML = '';
    }

    function quickFillSearch(term) {
        const input = document.getElementById('store-search');
        if (input) {
            input.value = term;
            handleSearchInput(term);
        }
    }

    function handleSearchInput(query) {
        const clearBtn = document.getElementById('searchClearBtn');
        const liveRes = document.getElementById('searchLiveResults');
        const box = document.getElementById('searchSuggestBox');
        if (clearBtn) clearBtn.style.display = query.trim() ? 'grid' : 'none';
        if (box) box.style.display = 'block';

        if (searchDebounceTimer) clearTimeout(searchDebounceTimer);

        if (!query.trim()) {
            if (liveRes) liveRes.innerHTML = '';
            return;
        }

        searchDebounceTimer = setTimeout(async () => {
            const cat = document.getElementById('searchCategorySelect')?.value || 'all';
            try {
                const resp = await fetch(`{{ route('store.api.search') }}?q=${encodeURIComponent(query)}&category=${encodeURIComponent(cat)}`);
                const data = await resp.json();

                if (data.products && data.products.length > 0) {
                    liveRes.innerHTML = data.products.map(p => `
                        <a href="{{ route('store.products') }}?q=${encodeURIComponent(p.name_en)}" class="search-live-item">
                            <img src="${p.image_url}" alt="${p.name_en}" class="search-live-thumb" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'40\\' height=\\'40\\'><rect width=\\'40\\' height=\\'40\\' fill=\\'%23edf5ed\\'/><text x=\\'20\\' y=\\'25\\' font-size=\\'14\\' text-anchor=\\'middle\\'>🛍️</text></svg>'">
                            <div class="search-live-info">
                                <div class="search-live-title">${p.name_en}</div>
                                <div class="search-live-cat">${p.category}</div>
                            </div>
                            <span class="search-live-price">$${Number(p.price).toFixed(2)}</span>
                        </a>
                    `).join('');
                } else {
                    liveRes.innerHTML = `
                        <div style="padding:14px 16px; font-size:12px; color:#839487; text-align:center;">
                            No matching products found. Press Enter to view catalog.
                        </div>
                    `;
                }
            } catch (err) {
                console.error(err);
            }
        }, 220);
    }

    // 8. Navigation Category Mega Menu
    function toggleNavCategoryMenu() {
        const menu = document.getElementById('navMegaMenu');
        const btn = document.getElementById('navCategoryBtn');
        if (menu) {
            const isHidden = menu.style.display === 'none';
            menu.style.display = isHidden ? 'block' : 'none';
            if (btn) btn.classList.toggle('is-open', isHidden);
        }
    }

    // Global outside click handler to close dropdowns
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-box-wrapper')) {
            const suggestBox = document.getElementById('searchSuggestBox');
            if (suggestBox) suggestBox.style.display = 'none';
        }
        if (!e.target.closest('.account-dropdown-wrapper') && !e.target.closest('.account-pill-button') && !e.target.closest('.bottom-nav-account-trigger') && !e.target.closest('.mobile-account-sheet')) {
            const accMenu = document.getElementById('accountDropdownMenu');
            if (accMenu) accMenu.style.display = 'none';
        }
        if (!e.target.closest('.nav-category-dropdown-wrapper')) {
            const megaMenu = document.getElementById('navMegaMenu');
            const catBtn = document.getElementById('navCategoryBtn');
            if (megaMenu) megaMenu.style.display = 'none';
            if (catBtn) catBtn.classList.remove('is-open');
        }
    });

    @if(session('success'))
        window.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (typeof window.showToast === 'function') {
                    window.showToast(@json(session('success')));
                }
            }, 300);
        });
    @elseif(session('error'))
        window.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (typeof window.showToast === 'function') {
                    window.showToast(@json(session('error')));
                }
            }, 300);
        });
    @endif
    </script>
    <!-- Slide-Out Shopping Cart Drawer -->
    <div id="cartDrawerBackdrop" class="cart-drawer-backdrop" onclick="closeCartDrawer()" style="display: none;"></div>
    <aside id="cartDrawerPanel" class="cart-drawer-panel" style="display: none;" aria-label="Shopping Cart Drawer">
        <div class="cart-drawer-header">
            <div class="cart-drawer-title-box">
                <span class="drawer-header-icon">🛍️</span>
                <h3>{{ $locale === 'km' ? 'កន្ត្រកទំនិញ' : 'Shopping Cart' }}</h3>
                <span class="drawer-count-badge" id="drawerCartCountBadge">0 មុខ</span>
            </div>
            <div class="cart-drawer-header-actions">
                <button type="button" class="btn-drawer-clear" id="drawerClearBtn" onclick="clearWholeCart()" style="display: none;" title="សម្អាតកន្ត្រកទាំងអស់">
                    🗑️ {{ $locale === 'km' ? 'សម្អាត' : 'Clear' }}
                </button>
                <button type="button" class="cart-drawer-close" onclick="closeCartDrawer()" aria-label="Close Cart">✕</button>
            </div>
        </div>

        <!-- Free Delivery Tracker -->
        <div class="drawer-free-shipping-bar" id="drawerShippingBar">
            <div class="drawer-fs-header">
                <span id="drawerFsText">🚚 {{ $locale === 'km' ? 'ដឹកជញ្ជូនឥតគិតថ្លៃសម្រាប់ការកុម្ម៉ង់ចាប់ពី $35.00 ឡើងទៅ' : 'Free Delivery on orders ≥ $35.00' }}</span>
                <span id="drawerFsPercentBadge" class="drawer-fs-badge">0%</span>
            </div>
            <div class="drawer-fs-track">
                <div class="drawer-fs-fill" id="drawerFsFill" style="width: 0%;"></div>
            </div>
        </div>

        <!-- Cart Items List Container -->
        <div class="cart-drawer-body" id="cartDrawerBody">
            <div id="cartDrawerItems" class="drawer-items-list">
                <!-- Injected via JavaScript -->
            </div>

            <!-- Enhanced Modern Empty State -->
            <div id="cartDrawerEmpty" class="drawer-empty-box" style="display: none;">
                <div class="drawer-empty-art">
                    <div class="empty-art-glow"></div>
                    <div class="empty-art-icon">🛍️</div>
                </div>
                <h4>{{ $locale === 'km' ? 'កន្ត្រករបស់អ្នកកំពុងរង់ចាំ!' : 'Your cart is empty!' }}</h4>
                <p>{{ $locale === 'km' ? 'មិនទាន់មានទំនិញក្នុងកន្ត្រកនៅឡើយទេ។ សូមចាប់ផ្តើមស្វែងរកទំនិញពេញនិយម ឬទំនិញបញ្ចុះតម្លៃពិសេសថ្ងៃនេះ!' : 'Explore our catalog and find the best deals curated just for you.' }}</p>
                
                <!-- Quick Category Tags -->
                <div class="empty-quick-tags">
                    <a href="{{ route('store.products') }}?filter=sale" class="empty-cat-pill" onclick="closeCartDrawer()">
                        🏷️ {{ $locale === 'km' ? 'បញ្ចុះតម្លៃ' : 'Hot Deals' }}
                    </a>
                    <a href="{{ route('store.products') }}?category=electronics" class="empty-cat-pill" onclick="closeCartDrawer()">
                        🎧 {{ $locale === 'km' ? 'អេឡិចត្រូនិក' : 'Electronics' }}
                    </a>
                    <a href="{{ route('store.products') }}?category=fashion" class="empty-cat-pill" onclick="closeCartDrawer()">
                        👕 {{ $locale === 'km' ? 'ម៉ូដសម្លៀកបំពាក់' : 'Fashion' }}
                    </a>
                </div>

                <a href="{{ route('store.products') }}" class="btn-drawer-browse" onclick="closeCartDrawer()">
                    ✨ {{ $locale === 'km' ? 'ចាប់ផ្តើមទិញទំនិញឥឡូវនេះ' : 'Start Shopping Now' }}
                </a>

                <!-- Trending Recommendations Inside Drawer -->
                <div class="drawer-recommendations">
                    <div class="rec-title">
                        <span>🔥 {{ $locale === 'km' ? 'ទំនិញពេញនិយមណែនាំ' : 'Recommended For You' }}</span>
                    </div>
                    <div class="rec-list">
                        <div class="rec-card">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=150&q=80" alt="Amber Gold ANC Headphones" class="rec-img">
                            <div class="rec-info">
                                <div class="rec-name">{{ $locale === 'km' ? 'កាសប៊្លូធូស Amber Gold ANC' : 'Amber Gold ANC Headphones' }}</div>
                                <div class="rec-price">$42.00 <span class="rec-old-price">$55.00</span></div>
                            </div>
                            <button type="button" class="btn-rec-add" onclick="storeAddToCart('1', 'កាសប៊្លូធូស Amber Gold & Black, ANC', 42.00, 1, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1000&q=85')">
                                + {{ $locale === 'km' ? 'បន្ថែម' : 'Add' }}
                            </button>
                        </div>
                        <div class="rec-card">
                            <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=150&q=80" alt="Everyday Backpack" class="rec-img">
                            <div class="rec-info">
                                <div class="rec-name">{{ $locale === 'km' ? 'កាតាបស្ពាយ Canvas Backpack' : 'Modern Canvas Backpack' }}</div>
                                <div class="rec-price">$28.50 <span class="rec-old-price">$38.00</span></div>
                            </div>
                            <button type="button" class="btn-rec-add" onclick="storeAddToCart('2', 'កាតាបស្ពាយ Canvas Backpack', 28.50, 1, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1000&q=80')">
                                + {{ $locale === 'km' ? 'បន្ថែម' : 'Add' }}
                            </button>
                        </div>
                        <div class="rec-card">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=150&q=80" alt="Smart Watch Pro" class="rec-img">
                            <div class="rec-info">
                                <div class="rec-name">{{ $locale === 'km' ? 'នាឡិកាឆ្លាតវៃ Smart Watch Pro' : 'Smart Fitness Watch Pro' }}</div>
                                <div class="rec-price">$35.00 <span class="rec-old-price">$45.00</span></div>
                            </div>
                            <button type="button" class="btn-rec-add" onclick="storeAddToCart('3', 'នាឡិកាឆ្លាតវៃ Smart Watch Pro', 35.00, 1, 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1000&q=80')">
                                + {{ $locale === 'km' ? 'បន្ថែម' : 'Add' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Footer -->
        <div class="cart-drawer-footer" id="cartDrawerFooter">
            <!-- Promo Coupon Code Strip -->
            <div class="drawer-coupon-wrap">
                <div class="drawer-coupon-input-group">
                    <span class="coupon-icon">🏷️</span>
                    <input type="text" id="drawerCouponInput" placeholder="{{ $locale === 'km' ? 'កូដបញ្ចុះតម្លៃ (ឧ. DARA10)' : 'Promo Code (e.g. DARA10)' }}" autocomplete="off">
                    <button type="button" id="btnApplyDrawerCoupon" onclick="applyDrawerCoupon()">
                        {{ $locale === 'km' ? 'អនុវត្ត' : 'Apply' }}
                    </button>
                </div>
                <div id="drawerCouponNotice" class="coupon-notice" style="display: none;"></div>
            </div>

            <div class="drawer-summary-card">
                <div class="drawer-subtotal-row">
                    <span>{{ $locale === 'km' ? 'តម្លៃទំនិញសរុប (Subtotal)' : 'Subtotal' }}</span>
                    <div style="text-align: right;">
                        <strong id="drawerSubtotal">$0.00</strong>
                        <small id="drawerSubtotalKhr" style="display: block; font-size: 11px; color: #16a34a; font-weight: 700;">≈ 0 KHR</small>
                    </div>
                </div>
                <div id="drawerDiscountRow" class="drawer-subtotal-row" style="display: none; color: #dc2626;">
                    <span>{{ $locale === 'km' ? 'បញ្ចុះតម្លៃ (Discount)' : 'Discount' }}</span>
                    <strong id="drawerDiscountAmount">-$0.00</strong>
                </div>
                <div class="drawer-subtotal-row delivery-row">
                    <span>{{ $locale === 'km' ? 'ការដឹកជញ្ជូន (Delivery)' : 'Delivery' }}</span>
                    <span id="drawerDeliveryNotice" class="delivery-val-pill">Calculated at checkout</span>
                </div>
            </div>

            <a href="{{ route('store.checkout') }}" class="btn-drawer-checkout">
                <span class="checkout-label">{{ $locale === 'km' ? 'បន្តទៅទូទាត់ប្រាក់ (Checkout)' : 'Proceed to Checkout' }} ➔</span>
                <span id="drawerCheckoutTotal" class="drawer-btn-total">$0.00</span>
            </a>

            <!-- Security & Trust Badges Strip -->
            <div class="drawer-trust-badges">
                <span>🛡️ {{ $locale === 'km' ? 'ទូទាត់សុវត្ថិភាព 100%' : 'Secure Checkout' }}</span>
                <span>⚡ {{ $locale === 'km' ? 'ដឹកជញ្ជូនរហ័ស' : 'Fast Shipping' }}</span>
                <span>🔄 {{ $locale === 'km' ? 'ប្តូរទំនិញ 7 ថ្ងៃ' : '7-Day Return' }}</span>
            </div>

            <button type="button" class="btn-drawer-continue" onclick="closeCartDrawer()">
                ← {{ $locale === 'km' ? 'បន្តការទិញទំនិញផ្សេងទៀត' : 'Continue Shopping' }}
            </button>
        </div>
    </aside>

    <style>
    /* Header Cart Button */
    .header-cart-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        padding: 6px 14px;
        border-radius: 999px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .header-cart-button:hover {
        border-color: #245943;
        background: rgba(36, 89, 67, 0.04);
        transform: translateY(-1px);
    }
    .cart-icon-box {
        position: relative;
        display: inline-flex;
        align-items: center;
        color: #10291f;
    }
    .cart-count-bubble {
        position: absolute;
        top: -6px;
        right: -8px;
        background: #d81e28;
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        min-width: 17px;
        height: 17px;
        line-height: 17px;
        text-align: center;
        border-radius: 999px;
        padding: 0 4px;
        border: 2px solid #ffffff;
    }
    .cart-text-wrap {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        line-height: 1.1;
    }
    .cart-text-wrap small {
        font-size: 10px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 700;
    }
    .header-cart-total {
        font-size: 13px;
        color: #10291f;
        font-weight: 800;
    }

    /* Cart Drawer Overhaul */
    .cart-drawer-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        z-index: 9998;
        animation: fadeInBackdrop 0.25s ease;
    }
    @keyframes fadeInBackdrop {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .cart-drawer-panel {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        width: 440px;
        max-width: 95vw;
        background: #ffffff;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        box-shadow: -12px 0 40px rgba(0, 0, 0, 0.18);
        animation: slideInRightDrawer 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes slideInRightDrawer {
        from { transform: translateX(100%); }
        to { transform: translateX(0); }
    }
    .cart-drawer-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
    }
    .cart-drawer-title-box {
        display: flex;
        align-items: center;
        gap: 9px;
    }
    .drawer-header-icon {
        font-size: 20px;
        display: inline-flex;
    }
    .cart-drawer-title-box h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }
    .drawer-count-badge {
        background: #173e2c;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 9px;
        border-radius: 999px;
    }
    .cart-drawer-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-drawer-clear {
        background: #fef2f2;
        border: 1px solid #fee2e2;
        color: #dc2626;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-drawer-clear:hover {
        background: #fee2e2;
        color: #b91c1c;
    }
    .cart-drawer-close {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        color: #64748b;
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .cart-drawer-close:hover {
        background: #ef4444;
        border-color: #ef4444;
        color: #ffffff;
        transform: rotate(90deg);
    }

    /* Free Shipping Gamification Bar */
    .drawer-free-shipping-bar {
        background: #f0fdf4;
        border-bottom: 1px solid #dcfce7;
        padding: 12px 20px;
    }
    .drawer-fs-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        font-weight: 700;
        color: #15803d;
        line-height: 1.3;
    }
    .drawer-fs-badge {
        font-size: 10.5px;
        font-weight: 800;
        background: #dcfce7;
        color: #166534;
        padding: 1px 7px;
        border-radius: 999px;
    }
    .drawer-fs-track {
        height: 6px;
        background: #e2e8f0;
        border-radius: 999px;
        margin-top: 8px;
        overflow: hidden;
        position: relative;
    }
    .drawer-fs-fill {
        height: 100%;
        background: linear-gradient(90deg, #16a34a 0%, #22c55e 100%);
        border-radius: 999px;
        transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }
    .drawer-fs-fill::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: fsShimmer 2s infinite;
    }
    @keyframes fsShimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Drawer Body */
    .cart-drawer-body {
        flex: 1;
        overflow-y: auto;
        padding: 14px 18px;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f8fafc;
    }
    .drawer-item-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        margin-bottom: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        transition: all 0.2s ease;
    }
    .drawer-item-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .drawer-item-img {
        width: 64px;
        height: 64px;
        border-radius: 10px;
        object-fit: cover;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }
    .drawer-item-card:hover .drawer-item-img {
        transform: scale(1.03);
    }
    .drawer-item-info {
        flex: 1;
        min-width: 0;
    }
    .drawer-item-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
    }
    .drawer-item-price-row {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }
    .drawer-item-price {
        font-size: 13.5px;
        font-weight: 800;
        color: #10291f;
    }
    .drawer-item-unit {
        font-size: 11px;
        color: #64748b;
    }
    .drawer-qty-stepper {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        margin-top: 6px;
        background: #f8fafc;
        overflow: hidden;
    }
    .stepper-btn {
        background: transparent;
        border: none;
        width: 26px;
        height: 26px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #334155;
        transition: background 0.15s;
    }
    .stepper-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .stepper-val {
        font-size: 12.5px;
        font-weight: 800;
        padding: 0 8px;
        color: #0f172a;
        min-width: 22px;
        text-align: center;
    }
    .drawer-item-remove {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #94a3b8;
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .drawer-item-remove:hover {
        color: #ef4444;
        background: #fee2e2;
        border-color: #fecaca;
    }

    /* Modern Empty State */
    .drawer-empty-box {
        text-align: center;
        padding: 24px 12px;
    }
    .drawer-empty-art {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .empty-art-glow {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle, rgba(22, 163, 74, 0.2) 0%, rgba(22, 163, 74, 0) 70%);
        border-radius: 50%;
        animation: pulseArtGlow 2.5s infinite;
    }
    @keyframes pulseArtGlow {
        0%, 100% { transform: scale(0.9); opacity: 0.6; }
        50% { transform: scale(1.2); opacity: 1; }
    }
    .empty-art-icon {
        font-size: 46px;
        position: relative;
        z-index: 2;
        animation: floatBag 3s ease-in-out infinite;
    }
    @keyframes floatBag {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    .drawer-empty-box h4 {
        font-size: 16.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px 0;
    }
    .drawer-empty-box p {
        font-size: 12.5px;
        color: #64748b;
        margin: 0 0 16px 0;
        line-height: 1.45;
        max-width: 320px;
        margin-left: auto;
        margin-right: auto;
    }
    .empty-quick-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
        margin-bottom: 18px;
    }
    .empty-cat-pill {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .empty-cat-pill:hover {
        background: #173e2c;
        border-color: #173e2c;
        color: #ffffff;
        transform: translateY(-1px);
    }
    .btn-drawer-browse {
        display: block;
        background: #173e2c;
        color: #ffffff;
        font-weight: 800;
        font-size: 13.5px;
        padding: 12px 20px;
        border-radius: 12px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(23, 62, 44, 0.25);
        transition: all 0.2s ease;
    }
    .btn-drawer-browse:hover {
        background: #245943;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Recommendations inside empty drawer */
    .drawer-recommendations {
        margin-top: 26px;
        text-align: left;
        border-top: 1px dashed #e2e8f0;
        padding-top: 18px;
    }
    .rec-title {
        font-size: 12.5px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .rec-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .rec-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.15s ease;
    }
    .rec-card:hover {
        border-color: #cbd5e1;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .rec-img {
        width: 46px;
        height: 46px;
        border-radius: 8px;
        object-fit: cover;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }
    .rec-info {
        flex: 1;
        min-width: 0;
    }
    .rec-name {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
    }
    .rec-price {
        font-size: 12.5px;
        font-weight: 800;
        color: #16a34a;
        margin-top: 2px;
    }
    .rec-old-price {
        font-size: 11px;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 500;
        margin-left: 3px;
    }
    .btn-rec-add {
        background: #ffffff;
        border: 1.5px solid #173e2c;
        color: #173e2c;
        font-size: 11.5px;
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .btn-rec-add:hover {
        background: #173e2c;
        color: #ffffff;
    }

    /* Drawer Footer Overhaul */
    .cart-drawer-footer {
        padding: 16px 20px 20px;
        border-top: 1px solid #f1f5f9;
        background: #ffffff;
        box-shadow: 0 -4px 16px rgba(0,0,0,0.03);
    }
    .drawer-coupon-wrap {
        margin-bottom: 12px;
    }
    .drawer-coupon-input-group {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 3px 5px 3px 10px;
        transition: border-color 0.2s;
    }
    .drawer-coupon-input-group:focus-within {
        border-color: #173e2c;
        background: #ffffff;
    }
    .coupon-icon {
        font-size: 14px;
        margin-right: 6px;
    }
    .drawer-coupon-input-group input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        padding: 6px 0;
    }
    .drawer-coupon-input-group button {
        background: #173e2c;
        color: #ffffff;
        border: none;
        font-size: 11.5px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 7px;
        cursor: pointer;
        transition: background 0.15s;
    }
    .drawer-coupon-input-group button:hover {
        background: #245943;
    }
    .coupon-notice {
        font-size: 11.5px;
        font-weight: 700;
        margin-top: 6px;
        padding: 4px 8px;
        border-radius: 6px;
    }
    .coupon-notice.success {
        background: #dcfce7;
        color: #15803d;
    }
    .coupon-notice.error {
        background: #fee2e2;
        color: #dc2626;
    }
    .drawer-summary-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 12px;
    }
    .drawer-subtotal-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: #475569;
        margin-bottom: 4px;
    }
    .drawer-subtotal-row strong {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
    }
    .delivery-row {
        font-size: 12px;
        margin-bottom: 0;
        padding-top: 4px;
        border-top: 1px dashed #e2e8f0;
    }
    .delivery-val-pill {
        color: #16a34a;
        font-weight: 700;
        font-size: 11.5px;
    }
    .btn-drawer-checkout {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #173e2c 0%, #245943 100%);
        color: #ffffff;
        text-decoration: none;
        padding: 14px 18px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 14px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 16px rgba(23, 62, 44, 0.28);
    }
    .btn-drawer-checkout:hover {
        background: linear-gradient(135deg, #1a4934 0%, #2b6a50 100%);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(23, 62, 44, 0.35);
    }
    .drawer-btn-total {
        background: rgba(255,255,255,0.22);
        padding: 3px 10px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 800;
        letter-spacing: 0.3px;
    }
    .drawer-trust-badges {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 10.5px;
        color: #64748b;
        font-weight: 600;
        margin-top: 10px;
        padding: 0 4px;
    }
    .btn-drawer-continue {
        width: 100%;
        background: transparent;
        border: none;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        padding: 10px 0 0 0;
        cursor: pointer;
        text-align: center;
        transition: color 0.15s;
    }
    .btn-drawer-continue:hover {
        color: #173e2c;
    }
    </style>

    <script>
    // Cart Drawer Management & Enhancements
    let appliedDiscountPct = 0;

    function getStoredCart() {
        try {
            const data = JSON.parse(localStorage.getItem('dara-market-cart') || '{"count":0,"total":0,"items":[]}');
            if (Array.isArray(data.items)) return data;
        } catch (e) {}
        return { count: 0, total: 0, items: [] };
    }

    function saveStoredCart(cart) {
        cart.count = cart.items.reduce((acc, it) => acc + (parseInt(it.quantity, 10) || 1), 0);
        cart.total = cart.items.reduce((acc, it) => acc + ((parseFloat(it.price) || 0) * (parseInt(it.quantity, 10) || 1)), 0);
        localStorage.setItem('dara-market-cart', JSON.stringify(cart));
        localStorage.setItem('dara_store_cart_items', JSON.stringify(cart.items));
        updateHeaderCartUI(cart);
        renderCartDrawerItems(cart);
    }

    function updateHeaderCartUI(cart) {
        const count = cart.count || 0;
        const total = (cart.total || 0).toFixed(2);

        const headerCount = document.getElementById('headerCartCount');
        const headerTotal = document.getElementById('headerCartTotal');
        const drawerCount = document.getElementById('drawerCartCountBadge');

        if (headerCount) headerCount.textContent = count;
        if (headerTotal) headerTotal.textContent = total;
        if (drawerCount) drawerCount.textContent = count + ' មុខ';

        document.querySelectorAll('.cart-count').forEach(el => el.textContent = count);
        document.querySelectorAll('.cart-total').forEach(el => el.textContent = total);
    }

    function openCartDrawer() {
        const cart = getStoredCart();
        renderCartDrawerItems(cart);
        const backdrop = document.getElementById('cartDrawerBackdrop');
        const panel = document.getElementById('cartDrawerPanel');
        if (backdrop) backdrop.style.display = 'block';
        if (panel) panel.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeCartDrawer() {
        const backdrop = document.getElementById('cartDrawerBackdrop');
        const panel = document.getElementById('cartDrawerPanel');
        if (backdrop) backdrop.style.display = 'none';
        if (panel) panel.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeCartDrawer();
    });

    function renderCartDrawerItems(cart) {
        const itemsContainer = document.getElementById('cartDrawerItems');
        const emptyBox = document.getElementById('cartDrawerEmpty');
        const footer = document.getElementById('cartDrawerFooter');
        const subtotalEl = document.getElementById('drawerSubtotal');
        const subtotalKhrEl = document.getElementById('drawerSubtotalKhr');
        const checkoutTotalEl = document.getElementById('drawerCheckoutTotal');
        const clearBtn = document.getElementById('drawerClearBtn');
        const fsText = document.getElementById('drawerFsText');
        const fsFill = document.getElementById('drawerFsFill');
        const fsBadge = document.getElementById('drawerFsPercentBadge');
        const discountRow = document.getElementById('drawerDiscountRow');
        const discountAmtEl = document.getElementById('drawerDiscountAmount');
        const dlvNotice = document.getElementById('drawerDeliveryNotice');

        if (!itemsContainer) return;

        if (!cart.items || cart.items.length === 0) {
            itemsContainer.innerHTML = '';
            if (emptyBox) emptyBox.style.display = 'block';
            if (footer) footer.style.display = 'none';
            if (clearBtn) clearBtn.style.display = 'none';
            if (fsText) fsText.innerHTML = '🚚 {{ $locale === "km" ? "ដឹកជញ្ជូនឥតគិតថ្លៃសម្រាប់ការកុម្ម៉ង់ចាប់ពី $35.00 ឡើងទៅ" : "Free Delivery on orders ≥ $35.00" }}';
            if (fsFill) fsFill.style.width = '0%';
            if (fsBadge) fsBadge.textContent = '0%';
            return;
        }

        if (emptyBox) emptyBox.style.display = 'none';
        if (footer) footer.style.display = 'block';
        if (clearBtn) clearBtn.style.display = 'inline-block';

        let html = '';
        cart.items.forEach(item => {
            const price = parseFloat(item.price) || 0;
            const qty = parseInt(item.quantity, 10) || 1;
            const img = item.image || 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80';
            const safeName = item.name.replace(/"/g, '&quot;');

            html += `
                <div class="drawer-item-card">
                    <img src="${img}" alt="${safeName}" class="drawer-item-img" onerror="this.src='https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80'">
                    <div class="drawer-item-info">
                        <div class="drawer-item-title" title="${safeName}">${item.name}</div>
                        <div class="drawer-item-price-row">
                            <span class="drawer-item-price">$${(price * qty).toFixed(2)}</span>
                            <span class="drawer-item-unit">($${price.toFixed(2)} / មួយ)</span>
                        </div>
                        <div class="drawer-qty-stepper">
                            <button type="button" class="stepper-btn" onclick="modifyDrawerQty('${item.id}', -1)" title="បន្ថយ">−</button>
                            <span class="stepper-val">${qty}</span>
                            <button type="button" class="stepper-btn" onclick="modifyDrawerQty('${item.id}', 1)" title="បន្ថែម">+</button>
                        </div>
                    </div>
                    <button type="button" class="drawer-item-remove" onclick="removeDrawerItem('${item.id}')" title="លុបទំនិញ">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                </div>
            `;
        });

        itemsContainer.innerHTML = html;

        // Subtotal & Calculations
        const rawTotal = cart.total || 0;
        const discountVal = (appliedDiscountPct > 0) ? (rawTotal * (appliedDiscountPct / 100)) : 0;
        const finalTotal = Math.max(0, rawTotal - discountVal);
        const khrTotal = Math.round(finalTotal * 4100).toLocaleString();

        if (subtotalEl) subtotalEl.textContent = '$' + rawTotal.toFixed(2);
        if (subtotalKhrEl) subtotalKhrEl.textContent = `≈ ${khrTotal} KHR`;

        if (appliedDiscountPct > 0 && discountRow && discountAmtEl) {
            discountRow.style.display = 'flex';
            discountAmtEl.textContent = `-$${discountVal.toFixed(2)} (${appliedDiscountPct}%)`;
        } else if (discountRow) {
            discountRow.style.display = 'none';
        }

        if (checkoutTotalEl) checkoutTotalEl.textContent = '$' + finalTotal.toFixed(2);

        // Free shipping progression
        if (rawTotal >= 35.00) {
            if (fsText) fsText.innerHTML = '🎉 <strong>{{ $locale === "km" ? "អបអរសាទរ! ដឹកជញ្ជូនឥតគិតថ្លៃ" : "FREE Delivery Unlocked!" }}</strong>';
            if (fsFill) fsFill.style.width = '100%';
            if (fsBadge) fsBadge.textContent = '100% ✓';
            if (dlvNotice) {
                dlvNotice.textContent = '{{ $locale === "km" ? "ឥតគិតថ្លៃ (FREE)" : "FREE" }}';
                dlvNotice.style.color = '#16a34a';
            }
        } else {
            const diff = 35.00 - rawTotal;
            if (fsText) fsText.innerHTML = `🚚 {{ $locale === "km" ? "ទិញថែម" : "Add" }} <strong>$${diff.toFixed(2)}</strong> {{ $locale === "km" ? "ទៀត ដើម្បីទទួលបាន ដឹកជញ្ជូនឥតគិតថ្លៃ!" : "more for FREE Delivery!" }}`;
            const pct = Math.min(100, Math.round((rawTotal / 35.00) * 100));
            if (fsFill) fsFill.style.width = pct + '%';
            if (fsBadge) fsBadge.textContent = pct + '%';
            if (dlvNotice) {
                dlvNotice.textContent = '{{ $locale === "km" ? "គណនាក្នុងទំព័រ Checkout" : "Calculated at checkout" }}';
                dlvNotice.style.color = '#64748b';
            }
        }
    }

    function modifyDrawerQty(id, delta) {
        const cart = getStoredCart();
        const item = cart.items.find(it => String(it.id) === String(id));
        if (item) {
            item.quantity = (parseInt(item.quantity, 10) || 1) + delta;
            if (item.quantity <= 0) {
                cart.items = cart.items.filter(it => String(it.id) !== String(id));
            }
            saveStoredCart(cart);
        }
    }

    function removeDrawerItem(id) {
        const cart = getStoredCart();
        cart.items = cart.items.filter(it => String(it.id) !== String(id));
        saveStoredCart(cart);
    }

    function clearWholeCart() {
        if (confirm('{{ $locale === "km" ? "តើលោកអ្នកពិតជាចង់សម្អាតទំនិញទាំងអស់ចេញពីកន្ត្រកមែនទេ?" : "Are you sure you want to clear all items in your cart?" }}')) {
            const emptyCart = { count: 0, total: 0, items: [] };
            appliedDiscountPct = 0;
            saveStoredCart(emptyCart);
        }
    }

    // Apply Coupon Code
    function applyDrawerCoupon() {
        const input = document.getElementById('drawerCouponInput');
        const notice = document.getElementById('drawerCouponNotice');
        if (!input || !notice) return;

        const code = input.value.trim().toUpperCase();
        if (!code) return;

        if (code === 'DARA10') {
            appliedDiscountPct = 10;
            notice.className = 'coupon-notice success';
            notice.textContent = '✓ {{ $locale === "km" ? "ទទួលបានការបញ្ចុះតម្លៃ 10% ដោយជោគជ័យ!" : "10% Discount applied successfully!" }}';
            notice.style.display = 'block';
        } else if (code === 'FREESHIP') {
            appliedDiscountPct = 5;
            notice.className = 'coupon-notice success';
            notice.textContent = '✓ {{ $locale === "km" ? "ទទួលបានការបញ្ចុះតម្លៃពិសេស $1.50!" : "Special Free Shipping coupon applied!" }}';
            notice.style.display = 'block';
        } else {
            appliedDiscountPct = 0;
            notice.className = 'coupon-notice error';
            notice.textContent = '✕ {{ $locale === "km" ? "កូដមិនត្រឹមត្រូវ ឬផុតកំណត់!" : "Invalid or expired coupon code." }}';
            notice.style.display = 'block';
        }

        renderCartDrawerItems(getStoredCart());
    }

    // Global Add To Cart Bridge
    window.storeAddToCart = function(id, name, price, qty, image) {
        const cart = getStoredCart();
        const existing = cart.items.find(it => String(it.id) === String(id) && it.name === name);
        if (existing) {
            existing.quantity += (parseInt(qty, 10) || 1);
        } else {
            cart.items.push({
                id: String(id),
                name: name,
                price: parseFloat(price) || 0,
                quantity: parseInt(qty, 10) || 1,
                image: image || ''
            });
        }
        saveStoredCart(cart);
        openCartDrawer();
        if (typeof showToast === 'function') {
            showToast(`${name} {{ $locale === "km" ? "បានបញ្ចូលទៅកន្ត្រក!" : "added to cart!" }}`);
        }
    };

    // Robust Global Mobile Nav Drawer Toggle
    window.toggleMobileNav = function(forceOrEvent) {
        if (forceOrEvent && forceOrEvent.preventDefault) {
            forceOrEvent.preventDefault();
            forceOrEvent.stopPropagation();
        }
        const nav = document.querySelector('.main-nav');
        const btn = document.querySelector('.menu-toggle');
        const header = document.querySelector('.site-header');
        if (!nav) return;
        const willOpen = (typeof forceOrEvent === 'boolean') ? forceOrEvent : !nav.classList.contains('is-open');
        nav.classList.toggle('is-open', willOpen);
        if (header) {
            header.classList.toggle('has-menu-open', willOpen);
        }
        if (btn) {
            btn.classList.toggle('is-active', willOpen);
            btn.setAttribute('aria-expanded', String(willOpen));
        }
        document.body.style.overflow = willOpen ? 'hidden' : '';
    };

    window.closeMobileNav = function() {
        window.toggleMobileNav(false);
    };

    // Mobile Account Bottom Sheet Toggle
    window.toggleMobileAccountSheet = function(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        if (window.innerWidth > 768) {
            toggleAccountMenu();
            return;
        }
        const sheet = document.getElementById('mobileAccountSheet');
        const backdrop = document.getElementById('mobileAccountBackdrop');
        if (!sheet) return;
        const isVisible = sheet.style.display !== 'none';
        if (isVisible) {
            sheet.style.display = 'none';
            if (backdrop) backdrop.style.display = 'none';
            document.body.style.overflow = '';
        } else {
            sheet.style.display = 'flex';
            if (backdrop) backdrop.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeMobileAccountSheet = function() {
        const sheet = document.getElementById('mobileAccountSheet');
        const backdrop = document.getElementById('mobileAccountBackdrop');
        if (sheet) sheet.style.display = 'none';
        if (backdrop) backdrop.style.display = 'none';
        document.body.style.overflow = '';
    };

    window.handleAccountButtonClick = function(event) {
        if (window.innerWidth <= 768) {
            toggleMobileAccountSheet(event);
        } else {
            toggleAccountMenu();
        }
    };

    window.handleBottomNavDeals = function(e) {
        const featured = document.getElementById('featured');
        const currentPath = window.location.pathname;
        if (featured && (currentPath === '/' || currentPath.endsWith('/home') || currentPath === '')) {
            e.preventDefault();
            featured.scrollIntoView({ behavior: 'smooth', block: 'start' });
            window.closeMobileNav();
        }
    };

    // Close mobile nav drawer when tapping outside on backdrop
    document.querySelector('.main-nav')?.addEventListener('click', function(e) {
        if (e.target === this) {
            window.closeMobileNav();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            window.closeMobileNav();
            window.closeMobileAccountSheet();
        }
    });

    // Initialize UI on load
    document.addEventListener('DOMContentLoaded', function() {
        const cart = getStoredCart();
        updateHeaderCartUI(cart);
    });
    </script>

    <!-- Mobile Account Bottom Sheet Modal -->
    <div id="mobileAccountBackdrop" class="mobile-account-backdrop" onclick="closeMobileAccountSheet()" style="display: none;"></div>
    <div id="mobileAccountSheet" class="mobile-account-sheet" style="display: none;" role="dialog" aria-modal="true" aria-label="Account details">
        <div class="mobile-sheet-drag-handle"></div>
        <div class="mobile-sheet-header">
            <h3 class="mobile-sheet-title">{{ auth()->check() ? ($locale === 'km' ? 'គណនីរបស់អ្នក' : 'My Account') : ($locale === 'km' ? 'សូមស្វាគមន៍មកកាន់ Dara Market' : 'Welcome to Dara Market') }}</h3>
            <button type="button" class="mobile-sheet-close" onclick="closeMobileAccountSheet()" aria-label="Close">✕</button>
        </div>
        <div class="mobile-sheet-body">
            @if(auth()->check())
                <div class="account-menu-profile-card">
                    <div class="menu-avatar-wrap">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="menu-avatar-img" referrerpolicy="no-referrer">
                        @else
                            <span class="menu-avatar-letter">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        @endif
                        <span class="menu-online-badge" title="Online"></span>
                    </div>
                    <div class="menu-profile-details">
                        <h4 class="menu-user-name">{{ auth()->user()->name }}</h4>
                        <span class="menu-user-email">{{ auth()->user()->email }}</span>
                        <div class="menu-tier-pill">
                            @if(auth()->user()->is_admin)
                                <span class="tier-tag tier-admin">🛡️ Store Admin</span>
                            @else
                                <span class="tier-tag tier-vip">⭐ VIP Member</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="account-menu-list">
                    <a href="{{ route('account.show') }}" class="account-menu-item" onclick="closeMobileAccountSheet()">
                        <span class="menu-item-icon icon-profile">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </span>
                        <div class="menu-item-content">
                            <strong>{{ $locale === 'km' ? 'ព័ត៌មានគណនី (My Profile)' : 'My Profile' }}</strong>
                            <small>{{ $locale === 'km' ? 'កែប្រែទិន្នន័យ & អាសយដ្ឋាន' : 'Personal info & address' }}</small>
                        </div>
                        <span class="menu-item-arrow">›</span>
                    </a>

                    <a href="{{ route('account.show') }}#orders" class="account-menu-item" onclick="closeMobileAccountSheet()">
                        <span class="menu-item-icon icon-orders">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        </span>
                        <div class="menu-item-content">
                            <strong>{{ $locale === 'km' ? 'ប្រវត្តិការកម្ម៉ង់' : 'My Orders' }}</strong>
                            <small>{{ $locale === 'km' ? 'ពិនិត្យទំនិញដែលបានទិញ' : 'View order history' }}</small>
                        </div>
                        <span class="menu-item-arrow">›</span>
                    </a>

                    <button type="button" class="account-menu-item" onclick="closeMobileAccountSheet(); openTrackOrderModal();">
                        <span class="menu-item-icon icon-track">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                        </span>
                        <div class="menu-item-content">
                            <strong>{{ $locale === 'km' ? 'តាមដានការដឹកជញ្ជូន' : 'Track Order' }}</strong>
                            <small>{{ $locale === 'km' ? 'ពិនិត្យទីតាំងកញ្ចប់ទំនិញ' : 'Live shipment status' }}</small>
                        </div>
                        <span class="menu-item-arrow">›</span>
                    </button>

                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="account-menu-item admin-highlight" onclick="closeMobileAccountSheet()">
                            <span class="menu-item-icon icon-admin">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            </span>
                            <div class="menu-item-content">
                                <strong>{{ $locale === 'km' ? 'ផ្ទាំងគ្រប់គ្រង Admin' : 'Admin Dashboard' }}</strong>
                                <small>{{ $locale === 'km' ? 'គ្រប់គ្រងហាង និងទំនិញ' : 'Manage store & orders' }}</small>
                            </div>
                            <span class="menu-item-arrow">↗</span>
                        </a>
                    @endif

                    <div class="account-menu-divider"></div>

                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="account-menu-item logout-btn">
                            <span class="menu-item-icon icon-logout">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            </span>
                            <div class="menu-item-content">
                                <strong>{{ $locale === 'km' ? 'ចាកចេញពីគណនី' : 'Sign Out' }}</strong>
                            </div>
                        </button>
                    </form>
                </div>
            @else
                <!-- Guest VIP Welcome Banner -->
                <div class="mobile-guest-vip-card">
                    <div class="vip-card-glow"></div>
                    <div class="vip-badge-row">
                        <span class="vip-star-badge">⭐ {{ $locale === 'km' ? 'កាដូស្វាគមន៍សមាជិកថ្មី' : 'VIP Welcome Offer' }}</span>
                        <span class="vip-amount-badge">+$15</span>
                    </div>
                    <h4>{{ $locale === 'km' ? 'ចុះឈ្មោះថ្ងៃនេះ ទទួលបាន $15 ភ្លាមៗ' : 'Claim $15 OFF Your First Order' }}</h4>
                    <p>{{ $locale === 'km' ? 'ចូលរួមជាសមាជិកដើម្បីទទួលបានការបញ្ចុះតម្លៃពិសេស សន្សំពិន្ទុ និងតាមដានការបញ្ជាទិញ' : 'Join VIP club for secret discounts, rewards points & fast shipment tracking.' }}</p>
                </div>

                <div class="guest-cta-buttons-stacked">
                    <a href="{{ route('register') }}" class="guest-btn-register-primary" onclick="closeMobileAccountSheet()">
                        <span>✨ {{ $locale === 'km' ? 'ចុះឈ្មោះបង្កើតគណនី (Create Account)' : 'Create New Account' }}</span>
                        <span class="guest-bonus-pill">+$15</span>
                    </a>
                    <a href="{{ route('login') }}" class="guest-btn-signin-secondary" onclick="closeMobileAccountSheet()">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        <span>{{ $locale === 'km' ? 'ចូលគណនីដែលមានស្រាប់ (Sign In)' : 'Sign In to Your Account' }}</span>
                    </a>
                </div>

                <div class="account-menu-list guest-links">
                    <form action="{{ route('demo.login') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="account-menu-item demo-login-item">
                            <span class="menu-item-icon icon-demo">⚡</span>
                            <div class="menu-item-content">
                                <strong>{{ $locale === 'km' ? 'សាកល្បង Demo (1-Click)' : '1-Click Demo Login' }}</strong>
                                <small>{{ $locale === 'km' ? 'ចូលភ្លាមៗមិនបាច់វាយពាក្យសម្ងាត់' : 'Instant test account' }}</small>
                            </div>
                            <span class="menu-item-arrow">›</span>
                        </button>
                    </form>

                    <button type="button" class="account-menu-item" onclick="closeMobileAccountSheet(); openTrackOrderModal();">
                        <span class="menu-item-icon icon-track">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                        </span>
                        <div class="menu-item-content">
                            <strong>{{ $locale === 'km' ? 'តាមដានការបញ្ជាទិញ' : 'Track Order' }}</strong>
                        </div>
                        <span class="menu-item-arrow">›</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Mobile Bottom Navigation Bar (Phones Only) -->
    <nav class="mobile-bottom-nav" aria-label="Mobile Navigation">
        <a href="{{ route('store.home') }}" class="bottom-nav-item {{ request()->routeIs('store.home') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>{{ $locale === 'km' ? 'ទំព័រដើម' : 'Home' }}</span>
        </a>

        <a href="{{ route('store.categories') }}" class="bottom-nav-item {{ request()->routeIs('store.categories') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>
            <span>{{ $locale === 'km' ? 'ប្រភេទទំនិញ' : 'Categories' }}</span>
        </a>

        <a href="{{ route('store.home') }}#featured" onclick="handleBottomNavDeals(event)" class="bottom-nav-item bottom-nav-highlight">
            <span class="bottom-nav-deal-badge">🔥</span>
            <span>{{ $locale === 'km' ? 'ប្រូម៉ូសិន' : 'Deals' }}</span>
        </a>

        <button type="button" class="bottom-nav-item" onclick="openCartDrawer()" title="{{ $locale === 'km' ? 'កន្ត្រកទំនិញ' : 'Shopping Cart' }}">
            <span class="bottom-nav-cart-wrap">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.9a2 2 0 0 0 1.9-1.5L22 8H6"></path><circle cx="10" cy="20" r="1.2"></circle><circle cx="18" cy="20" r="1.2"></circle></svg>
                <span class="bottom-cart-badge cart-count">0</span>
            </span>
            <span>{{ $locale === 'km' ? 'កន្ត្រក' : 'Cart' }}</span>
        </button>

        <button type="button" class="bottom-nav-item bottom-nav-account-trigger" onclick="toggleMobileAccountSheet(event)" title="{{ $locale === 'km' ? 'គណនី' : 'Account' }}">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <span>{{ auth()->check() ? (explode(' ', auth()->user()->name)[0]) : ($locale === 'km' ? 'គណនី' : 'Account') }}</span>
        </button>
    </nav>
</body>
</html>
