@extends('store.layouts.app')

@section('title', $translations['meta']['title'])

@section('content')
    <div class="container page-layout">
        <aside class="sidebar sidebar-left" aria-label="{{ $translations['sidebar']['categories'] }}">
            <!-- 1. Category Filter Card (Clean Minimalist Luxury Edition) -->
            <section class="sidebar-card category-sidebar" id="categories">
                <div class="sidebar-header-row">
                    <div class="sidebar-title-clean">
                        <span class="sidebar-heading-text">{{ $translations['sidebar']['categories'] }}</span>
                        <span class="sidebar-count-badge">{{ $productCount }}</span>
                    </div>
                </div>

                <!-- Clean Minimal Search Bar -->
                <div class="cat-search-bar">
                    <svg class="cat-search-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" class="cat-search-input" id="catSidebarSearch" placeholder="{{ $locale === 'km' ? 'ស្វែងរកប្រភេទ...' : 'Search categories...' }}" aria-label="Search categories">
                </div>

                <div class="category-links-list">
                    <button class="category-link selected" type="button" data-filter="all" data-category-name="{{ $translations['categories']['all'] }} all ទាំងអស់">
                        <span class="cat-name">{{ $translations['categories']['all'] }}</span>
                        <span class="cat-count-pill">{{ $productCount }}</span>
                    </button>
                    @foreach ($categories as $category)
                        <button class="category-link" type="button" data-filter="{{ $category }}" data-category-name="{{ $translations['categories'][$category] }} {{ $category }}">
                            <span class="cat-name">{{ $translations['categories'][$category] }}</span>
                            <span class="cat-count-pill">{{ $categoryCounts[$category] ?? 0 }}</span>
                        </button>
                    @endforeach
                </div>
            </section>

            <!-- 2. Flash Deal Of The Day Widget (Dynamic & Interactive) -->
            <section class="sidebar-card daily-deal-widget" id="dailyDealWidget">
                <div class="deal-widget-header">
                    <span class="deal-kicker">
                        <svg class="deal-icon-svg" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>{{ $locale === 'km' ? ($storeSettings['deal_kicker_km'] ?? 'ប្រូម៉ូសិនពិសេសថ្ងៃនេះ') : ($storeSettings['deal_kicker_en'] ?? 'DEAL OF THE DAY') }}</span>
                    </span>
                    <div class="deal-status-group">
                        <span class="deal-live-tag"><span class="deal-pulse-dot"></span> LIVE</span>
                    </div>
                </div>

                <!-- Deal Countdown Timer -->
                <div class="deal-countdown-box" title="ពេលវេលានៅសល់">
                    <span class="deal-timer-label">{{ $locale === 'km' ? 'នៅសល់ត្រឹម' : 'Ends in' }}:</span>
                    <strong class="deal-timer-digits" id="dealCountdownTimer">05 : 42 : 18</strong>
                </div>

                <div class="deal-product-preview">
                    <img src="{{ $storeSettings['deal_image'] ?? 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=400&q=80' }}" alt="Deal Product" class="deal-img" id="dealProductImg">
                    <div class="deal-product-details">
                        <span class="deal-product-title" id="dealProductTitle">{{ $locale === 'km' ? ($storeSettings['deal_title_km'] ?? 'កាសស្ដាប់ត្រចៀកឥតខ្សែ') : ($storeSettings['deal_title_en'] ?? 'Wireless Pro Headphones') }}</span>
                        <div class="deal-price-row">
                            <strong class="deal-price" id="dealProductPrice">${{ number_format((float)($storeSettings['deal_price'] ?? 32.00), 2) }}</strong>
                            <del class="deal-old-price" id="dealProductOldPrice">${{ number_format((float)($storeSettings['deal_old_price'] ?? 42.00), 2) }}</del>
                            <span class="deal-discount-badge" id="dealDiscountBadge">{{ $storeSettings['deal_discount'] ?? '-24%' }}</span>
                        </div>
                    </div>
                </div>

                <div class="deal-progress-wrap">
                    <div class="deal-progress-bar">
                        <div class="deal-progress-fill" style="width: {{ $storeSettings['deal_sold_percent'] ?? 78 }}%;"></div>
                    </div>
                    <div class="deal-progress-text">
                        <small>{{ $locale === 'km' ? ('លក់ដាច់ ' . ($storeSettings['deal_sold_percent'] ?? 78) . '% (សល់ ' . ($storeSettings['deal_stock_left'] ?? 5) . ' គ្រឿង)') : ('Sold ' . ($storeSettings['deal_sold_percent'] ?? 78) . '% • ' . ($storeSettings['deal_stock_left'] ?? 5) . ' left') }}</small>
                    </div>
                </div>

                <button type="button" class="deal-action-btn" id="dealQuickBuyBtn" onclick="quickAddDealProduct(this)">
                    <span>{{ $locale === 'km' ? 'បញ្ជាទិញឥឡូវនេះ' : 'Grab Deal Now' }}</span>
                    <span>→</span>
                </button>
            </section>

            <!-- 3. Why Shop With Us Card -->
            <section class="sidebar-card why-us-card">
                <h2 class="sidebar-heading">{{ $translations['sidebar']['why_us'] }}</h2>
                <div class="sidebar-benefit-list">
                    <div class="sidebar-benefit">
                        <span class="benefit-icon-disk emerald-bg">
                            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </span>
                        <div>
                            <strong>{{ $translations['sidebar']['quality'] }}</strong>
                            <small>{{ $translations['sidebar']['quality_description'] }}</small>
                        </div>
                    </div>
                    <div class="sidebar-benefit">
                        <span class="benefit-icon-disk gold-bg">
                            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </span>
                        <div>
                            <strong>{{ $translations['sidebar']['delivery'] }}</strong>
                            <small>{{ $translations['sidebar']['delivery_description'] }}</small>
                        </div>
                    </div>
                    <div class="sidebar-benefit">
                        <span class="benefit-icon-disk teal-bg">
                            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        </span>
                        <div>
                            <strong>{{ $translations['sidebar']['friendly_service'] }}</strong>
                            <small>{{ $translations['sidebar']['friendly_service_description'] }}</small>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4. Category Spotlight Card -->
            <section class="sidebar-card category-spotlight">
                <img src="{{ $storeSettings['spotlight_image'] ?? 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $storeSettings['spotlight_title_km'] ?? $translations['sidebar']['spotlight_alt'] }}" loading="lazy">
                <div class="spotlight-overlay">
                    <span class="spotlight-tag">
                        <svg viewBox="0 0 24 24" width="10" height="10" fill="currentColor" style="display:inline-block; vertical-align:-1px; margin-right:3px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        {{ $locale === 'km' ? ($storeSettings['spotlight_tag_km'] ?? 'ជម្រើសពេញនិយម') : 'STORE SPOTLIGHT' }}
                    </span>
                    <small>{{ $storeSettings['spotlight_caption_km'] ?? $translations['sidebar']['spotlight_caption'] }}</small>
                    <strong>{{ $storeSettings['spotlight_title_km'] ?? $translations['sidebar']['spotlight_title'] }}</strong>
                    <a href="{{ $storeSettings['spotlight_link'] ?? '#featured' }}" class="spotlight-btn">{{ $translations['sidebar']['spotlight_link'] }} <span>→</span></a>
                </div>
            </section>
        </aside>

        <div class="store-content">
            <!-- Multi-Slide Interactive Hero Carousel -->
            <section class="hero-carousel-wrapper" id="homeHeroCarousel" aria-label="Featured Collections">
                <div class="hero-slides-track">
                    <!-- Slide 1 -->
                    <div class="hero-slide active" data-slide="0">
                        <div class="hero-copy">
                            <span class="eyebrow">
                                <span class="eyebrow-dot"></span>
                                {{ $translations['hero']['label'] }}
                            </span>
                            <h1>{!! $translations['hero']['title'] !!}</h1>
                            <p>{{ $translations['hero']['description'] }}</p>
                            <div class="hero-actions-row">
                                <a class="button button-light" href="{{ route('store.products') }}">
                                    <span>{{ $translations['hero']['shop_now'] }}</span>
                                    <span aria-hidden="true">→</span>
                                </a>
                                <a class="button button-outline" href="#featured">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 3z"></path></svg>
                                    <span>{{ $locale === 'km' ? 'ទំនិញលក់ដាច់' : 'Hot Deals' }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="hero-image-wrap">
                            <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1200&q=85" alt="{{ $translations['hero']['alt'] }}" class="hero-main-img">
                            <div class="hero-glass-badge">
                                <span class="badge-star">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
                                </span>
                                <div>
                                    <strong>{{ $translations['hero']['note_title'] }}</strong>
                                    <small>{{ $translations['hero']['note_description'] }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="hero-slide" data-slide="1">
                        <div class="hero-copy">
                            <span class="eyebrow">
                                <span class="eyebrow-dot" style="background:#eab308;"></span>
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#eab308" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                {{ $locale === 'km' ? 'បច្ចេកវិទ្យា & ឧបករណ៍ទំនើប' : 'SMART TECH & AUDIO' }}
                            </span>
                            <h1>{{ $locale === 'km' ? 'ឧបករណ៍បច្ចេកវិទ្យាឆ្លាតវៃ' : 'Next-Gen Sound & Smart Gear' }}</h1>
                            <p>{{ $locale === 'km' ? 'បញ្ចុះតម្លៃរហូតដល់ 35% លើកាសស្ដាប់ត្រចៀក និងនាឡិកាដៃឆ្លាតវៃ។' : 'Enjoy up to 35% discount on high-fidelity wireless audio & lifestyle watches.' }}</p>
                            <div class="hero-actions-row">
                                <a class="button button-light" href="{{ route('store.products', ['category' => 'electronics']) }}">
                                    <span>{{ $locale === 'km' ? 'ស្វែងរកឧបករណ៍ →' : 'Explore Gadgets →' }}</span>
                                </a>
                                <span class="hero-pill-info">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px; margin-right:3px;"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                    35% OFF Applied
                                </span>
                            </div>
                        </div>
                        <div class="hero-image-wrap">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=85" alt="Smart Tech" class="hero-main-img">
                            <div class="hero-glass-badge">
                                <span class="badge-star" style="color: #3b82f6;">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>
                                </span>
                                <div>
                                    <strong>Premium Audio</strong>
                                    <small>Noise-canceling & wireless</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="hero-slide" data-slide="2">
                        <div class="hero-copy">
                            <span class="eyebrow">
                                <span class="eyebrow-dot" style="background:#06b6d4;"></span>
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#06b6d4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                {{ $locale === 'km' ? 'ម៉ូដសម្លៀកបំពាក់ & កាបូប' : 'MODERN LIFESTYLE STYLE' }}
                            </span>
                            <h1>{{ $locale === 'km' ? 'កាបូបស្ពាយរចនាយ៉ាងប្រណីត' : 'Everyday Backpacks & Wear' }}</h1>
                            <p>{{ $locale === 'km' ? 'ទម្ងន់ស្រាល ធន់មិនជ្រាបទឹក សាកសមសម្រាប់ការធ្វើដំណើរ និងធ្វើការ។' : 'Water-resistant, lightweight ergonomics crafted for work, travel and daily life.' }}</p>
                            <div class="hero-actions-row">
                                <a class="button button-light" href="{{ route('store.products', ['category' => 'fashion']) }}">
                                    <span>{{ $locale === 'km' ? 'មើលម៉ូដថ្មីៗ →' : 'View Collection →' }}</span>
                                </a>
                                <span class="hero-pill-info">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px; margin-right:3px;"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                    Free Shipping
                                </span>
                            </div>
                        </div>
                        <div class="hero-image-wrap">
                            <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1200&q=85" alt="Fashion Bags" class="hero-main-img">
                            <div class="hero-glass-badge">
                                <span class="badge-star" style="color: #eab308;">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                </span>
                                <div>
                                    <strong>Rated 4.9 / 5</strong>
                                    <small>1,200+ verified buyers</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Unified Hero Controls Dock -->
                <div class="hero-controls-dock" aria-label="Carousel navigation">
                    <button type="button" class="hero-dock-arrow prev" onclick="changeHeroSlide(-1)" aria-label="Previous slide" title="Previous">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <div class="hero-pagination-dots" id="heroPaginationDots">
                        <button type="button" class="hero-dot active" onclick="goToHeroSlide(0)" aria-label="Slide 1"></button>
                        <button type="button" class="hero-dot" onclick="goToHeroSlide(1)" aria-label="Slide 2"></button>
                        <button type="button" class="hero-dot" onclick="goToHeroSlide(2)" aria-label="Slide 3"></button>
                    </div>
                    <button type="button" class="hero-dock-arrow next" onclick="changeHeroSlide(1)" aria-label="Next slide" title="Next">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                    <span class="hero-slide-counter" id="heroSlideCounter">01 / 03</span>
                </div>
            </section>

            <!-- Modern 4-Card Trust Benefit Strip -->
            <section class="benefit-strip-v2" id="why-us" aria-label="{{ $translations['benefits']['label'] }}">
                <div class="benefit-card-v2">
                    <div class="benefit-icon-bubble green">
                        <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <div class="benefit-text">
                        <strong>{{ $translations['benefits']['free_shipping'] }}</strong>
                        <small>{{ $translations['benefits']['free_shipping_description'] }}</small>
                    </div>
                </div>
                <div class="benefit-card-v2">
                    <div class="benefit-icon-bubble gold">
                        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
                    </div>
                    <div class="benefit-text">
                        <strong>{{ $translations['benefits']['quality'] }}</strong>
                        <small>{{ $translations['benefits']['quality_description'] }}</small>
                    </div>
                </div>
                <div class="benefit-card-v2">
                    <div class="benefit-icon-bubble blue">
                        <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                    </div>
                    <div class="benefit-text">
                        <strong>{{ $translations['benefits']['returns'] }}</strong>
                        <small>{{ $translations['benefits']['returns_description'] }}</small>
                    </div>
                </div>
                <div class="benefit-card-v2">
                    <div class="benefit-icon-bubble teal">
                        <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    </div>
                    <div class="benefit-text">
                        <strong>{{ $locale === 'km' ? 'ទូទាត់រហ័ស & សុវត្ថិភាព' : 'Fast & Secure Checkout' }}</strong>
                        <small>{{ $locale === 'km' ? 'គាំទ្រ KHQR Bakong, កាត និង COD' : 'Bakong KHQR, Cards & COD' }}</small>
                    </div>
                </div>
            </section>

            <section class="product-section" id="featured">
                <div class="product-section-header">
                    <div class="section-title-wrap">
                        <span class="section-kicker">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                            {{ $translations['products']['section_kicker'] }}
                        </span>
                        <h2>{{ $translations['products']['popular'] }}</h2>
                    </div>

                    <div class="section-actions-bar">
                        <label class="product-sort">
                            <span class="sr-only">{{ $translations['products']['sort_label'] }}</span>
                            <span class="sort-icon-box" aria-hidden="true">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M6 12h12M10 18h4"/></svg>
                            </span>
                            <select id="product-sort" aria-label="{{ $translations['products']['sort_label'] }}">
                                <option value="featured">{{ $translations['products']['sort_featured'] }}</option>
                                <option value="price-asc">{{ $translations['products']['sort_price_low'] }}</option>
                                <option value="price-desc">{{ $translations['products']['sort_price_high'] }}</option>
                                <option value="rating">{{ $translations['products']['sort_rating'] }}</option>
                            </select>
                        </label>
                        <button class="wishlist-filter" type="button" aria-pressed="false" data-label-all="{{ $translations['products']['wishlist_all'] }}" data-label-saved="{{ $translations['products']['wishlist_saved'] }}" title="{{ $translations['products']['wishlist_all'] }}">
                            <svg class="wishlist-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 8.8c0 5.1-8.8 10-8.8 10s-8.8-4.9-8.8-10a4.6 4.6 0 0 1 8.8-1.9 4.6 4.6 0 0 1 8.8 1.9Z"/></svg>
                            <span class="wishlist-filter-label">{{ $translations['products']['wishlist_all'] }}</span>
                            <span class="wishlist-count">0</span>
                        </button>
                        <a class="view-all-pill" href="{{ route('store.products') }}">
                            <span>{{ $translations['products']['view_all'] }}</span>
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                <div class="category-filter-bar">
                    <div class="category-tabs" role="group" aria-label="{{ $translations['products']['filter_label'] }}">
                        <button class="category-tab active" type="button" data-filter="all">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>
                            <span>{{ $translations['products']['all'] }}</span>
                        </button>
                        @foreach ($categories as $category)
                            <button class="category-tab" type="button" data-filter="{{ $category }}">
                                @if ($category === 'perfumes')
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M8 6h8M9 10h6l2 11H7l2-11zM12 14v4"></path></svg>
                                @elseif ($category === 'phones')
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                                @elseif ($category === 'computers')
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                                @elseif ($category === 'fashion')
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                @elseif ($category === 'beauty')
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                                @endif
                                <span>{{ $translations['categories'][$category] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="product-grid" id="featured-grid">
                    @foreach ($products as $index => $product)
                        @include('store.partials.product-card', ['product' => $product, 'isHidden' => $index >= 4])
                    @endforeach
                </div>
            </section>

            <section class="promo-banner">
                <div>
                    <span class="section-kicker">{{ $translations['products']['promotion_kicker'] }}</span>
                    <h2>{!! $translations['products']['promotion_title'] !!}</h2>
                    <p>{{ $translations['products']['promotion_description'] }}</p>
                    <a href="{{ route('store.new-arrivals') }}">{{ $translations['products']['promotion_link'] }} <span>→</span></a>
                </div>
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=900&q=85" alt="{{ $translations['products']['promotion_kicker'] }}" loading="lazy">
                <span class="promo-sticker">{{ $translations['products']['up_to'] }}<br><strong>25%</strong><br>{{ $translations['products']['off'] }}</span>
            </section>

            <section class="product-section new-arrivals" id="new-arrivals">
                <div class="section-heading">
                    <div><span class="section-kicker">{{ $translations['products']['new_kicker'] }}</span><h2>{{ $translations['products']['new_title'] }}</h2></div>
                    <a class="text-link" href="{{ route('store.new-arrivals') }}">{{ $translations['products']['view_all'] }} <span>→</span></a>
                </div>
                <div class="product-grid">
                    @foreach ($newProducts as $product)
                        @include('store.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </section>
            <p class="product-count" aria-live="polite" data-singular="{{ $translations['products']['product_singular'] }}" data-plural="{{ $translations['products']['product_plural'] }}"></p>
            <p class="empty-results" hidden data-empty-search="{{ $translations['products']['empty'] }}" data-empty-favorites="{{ $translations['products']['empty_favorites'] }}">{{ $translations['products']['empty'] }}</p>
        </div>

        <aside class="sidebar sidebar-right" aria-label="{{ $translations['sidebar']['trust_title'] }}">
            <!-- 1. Shop With Confidence Card -->
            <section class="sidebar-card trust-card">
                <h2 class="sidebar-heading">{{ $translations['sidebar']['trust_title'] }}</h2>
                <div class="trust-item-v2">
                    <span class="trust-icon-bubble green">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </span>
                    <div>
                        <strong>{{ $translations['sidebar']['safe_payment'] }}</strong>
                        <small>{{ $translations['sidebar']['safe_payment_description'] }}</small>
                    </div>
                </div>
                <div class="trust-item-v2">
                    <span class="trust-icon-bubble gold">
                        <svg viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                    </span>
                    <div>
                        <strong>{{ $translations['sidebar']['easy_returns'] }}</strong>
                        <small>{{ $translations['sidebar']['easy_returns_description'] }}</small>
                    </div>
                </div>
                <div class="trust-item-v2">
                    <span class="trust-icon-bubble teal">
                        <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    </span>
                    <div>
                        <strong>{{ $translations['sidebar']['support'] }}</strong>
                        <small>{{ $translations['sidebar']['support_description'] }}</small>
                    </div>
                </div>
            </section>

            <!-- 2. Exclusive Voucher Coupon Card (Dynamic & Functional) -->
            <section class="sidebar-card voucher-coupon-card" id="sidebarVoucherCard">
                <div class="voucher-top-tag">
                    <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path></svg>
                    <span>{{ $locale === 'km' ? ($storeSettings['voucher_badge_km'] ?? 'ប័ណ្ណបញ្ចុះតម្លៃពិសេស') : ($storeSettings['voucher_badge_en'] ?? 'SPECIAL VOUCHER') }}</span>
                </div>
                <h3>{{ $storeSettings['voucher_amount_text'] ?? '$20.00 OFF' }}</h3>
                <p>{{ $locale === 'km' ? ($storeSettings['voucher_desc_km'] ?? 'បញ្ចុះតម្លៃ $20 លើការទិញចាប់ពី $80 ឡើងទៅ') : ($storeSettings['voucher_desc_en'] ?? 'For orders over $80 on all categories') }}</p>
                <div class="coupon-code-box">
                    <code id="sidebarCouponCode">{{ $storeSettings['voucher_code'] ?? 'DARA20' }}</code>
                    <button type="button" class="coupon-copy-btn" onclick="copySidebarVoucher('{{ $storeSettings['voucher_code'] ?? 'DARA20' }}', this)" title="ចុចដើម្បីចម្លង">
                        <span>Copy</span>
                    </button>
                </div>
            </section>

            <!-- 3. Side Feature Banner -->
            <section class="sidebar-card side-feature">
                <div class="side-feature-img-wrap">
                    <img src="{{ $storeSettings['side_feature_image'] ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $storeSettings['side_feature_title_km'] ?? $translations['sidebar']['style_alt'] }}" loading="lazy">
                    <span class="side-feature-pill">{{ $storeSettings['side_feature_pill_km'] ?? 'NEW IN' }}</span>
                </div>
                <div class="side-feature-copy">
                    <span class="section-kicker">{{ $storeSettings['side_feature_kicker_km'] ?? $translations['sidebar']['style_kicker'] }}</span>
                    <h2>{{ $storeSettings['side_feature_title_km'] ?? $translations['sidebar']['style_title'] }}</h2>
                    <a class="text-link" href="{{ $storeSettings['side_feature_link'] ?? '#featured' }}">{{ $translations['sidebar']['style_link'] }} <span>→</span></a>
                </div>
            </section>

            <!-- 4. Clean Minimalist Popular Categories (No Cluttered Icons) -->
            <section class="sidebar-card popular-tags-card">
                <h2 class="sidebar-heading">{{ $translations['sidebar']['popular_categories'] }}</h2>
                <div class="popular-tags-v2">
                    @foreach ($categories as $category)
                        <button type="button" data-filter="{{ $category }}" class="popular-tag-btn">
                            <span>{{ $translations['categories'][$category] }}</span>
                        </button>
                    @endforeach
                </div>
            </section>

            <!-- 5. Need Help Card (Dynamic & Interactive with Hotline + Telegram) -->
            <section class="help-card-v2">
                <div class="help-card-header">
                    <span class="help-icon-bubble">
                        <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    </span>
                    <span class="help-live-dot-tag">
                        <span class="deal-pulse-dot"></span> 24/7 Support
                    </span>
                </div>
                <h2>{{ $storeSettings['help_title_km'] ?? $translations['sidebar']['need_help'] }}</h2>
                <p>{{ $storeSettings['help_desc_km'] ?? $translations['sidebar']['help_description'] }}</p>
                <div class="help-actions-row">
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $storeSettings['contact_phone'] ?? '0714504547') }}" class="help-call-btn" title="ហៅទូរស័ព្ទ">
                        <span>{{ $locale === 'km' ? 'ហៅមកយើង' : 'Call us' }}</span>
                        <span>→</span>
                    </a>
                    @if (!empty($storeSettings['telegram_support']))
                        <a href="{{ $storeSettings['telegram_support'] }}" target="_blank" rel="noopener" class="help-tg-btn" title="ផ្ញើសារតាម Telegram">
                            <span>Telegram</span>
                        </a>
                    @endif
                </div>
            </section>
        </aside>
    </div>

    <!-- ========================================================
         FULL-WIDTH LUXURY VIP REWARDS & DEALS CLUB SHOWCASE
         ======================================================== -->
    <style>
    @media (max-width: 860px) {
        #vipClubBanner,
        .vip-fullwidth-section,
        .vip-fullwidth-container {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }
    }
    </style>
    <section class="vip-fullwidth-section desktop-only" id="vipClubBanner">
        <div class="container vip-fullwidth-container">
            <div class="vip-fullwidth-card">
                <!-- Ambient decorative gradient orbs & gold shimmer -->
                <div class="vip-orb orb-1" aria-hidden="true"></div>
                <div class="vip-orb orb-2" aria-hidden="true"></div>
                <div class="vip-mesh-pattern" aria-hidden="true"></div>

                <div class="vip-fullwidth-content">
                    <!-- Left Column: Rich VIP Club Invitation -->
                    <div class="vip-left-col">
                        <div class="vip-badges-strip">
                            <span class="vip-crown-badge">
                                <span class="crown-icon">👑</span>
                                <span>{{ $translations['products']['newsletter_kicker'] ?? 'ក្លឹបសមាជិក VIP DARA MARKET' }}</span>
                            </span>
                            <span class="vip-live-pulse-badge">
                                <span class="pulse-point"></span>
                                <span>{{ $translations['products']['newsletter_social_proof'] ?? 'អតិថិជនជាង 4,250+ នាក់បានចុះឈ្មោះក្នុងសប្តាហ៍នេះ!' }}</span>
                            </span>
                            <span class="vip-gift-flag">
                                <span>🎁 $15.00 Welcome Voucher</span>
                            </span>
                        </div>

                        <h2 class="vip-hero-heading">
                            {{ $translations['products']['newsletter_title'] ?? 'ទទួលបានប័ណ្ណបញ្ចុះតម្លៃ $15 + ដំណឹងពិសេសមុនគេ!' }}
                        </h2>

                        <p class="vip-hero-sub">
                            {{ $translations['products']['newsletter_description'] ?? 'ចុះឈ្មោះជាសមាជិក VIP ផ្លូវការរបស់ DARA MARKET ថ្ងៃនេះ ដើម្បីដោះសោកាដូស្វាគមន៍ $15.00 OFF ភ្លាមៗ សិទ្ធិទិញទំនិញ Flash Sale មុនគេ និងការដឹកជញ្ជូនឥតគិតថ្លៃរៀងរាល់ចុងសប្តាហ៍!' }}
                        </p>

                        <!-- 4 Premium 3D Benefit Glass Cards (2x2 Grid) -->
                        <div class="vip-benefits-grid">
                            <div class="benefit-card">
                                <div class="benefit-icon-disk gold">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path></svg>
                                </div>
                                <div class="benefit-texts">
                                    <strong>{{ $translations['products']['newsletter_benefit_1'] ?? 'ប័ណ្ណបញ្ចុះតម្លៃ $15' }}</strong>
                                    <small>{{ $locale === 'km' ? 'បញ្ចុះតម្លៃលើការកុម្ម៉ង់ដំបូង' : 'Applied on your first order' }}</small>
                                </div>
                            </div>

                            <div class="benefit-card">
                                <div class="benefit-icon-disk emerald">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                </div>
                                <div class="benefit-texts">
                                    <strong>{{ $translations['products']['newsletter_benefit_2'] ?? 'VIP Flash Sale មុនគេ' }}</strong>
                                    <small>{{ $locale === 'km' ? 'ដឹងដំណឹងប្រូម៉ូសិនមុន 2 ម៉ោង' : '2 hours early secret deals access' }}</small>
                                </div>
                            </div>

                            <div class="benefit-card">
                                <div class="benefit-icon-disk teal">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                                </div>
                                <div class="benefit-texts">
                                    <strong>{{ $translations['products']['newsletter_benefit_3'] ?? 'កាដូ & ពិន្ទុទ្វេដង' }}</strong>
                                    <small>{{ $locale === 'km' ? 'កាដូថ្ងៃកំណើត & Double Coins' : 'Birthday rewards & 2x coins' }}</small>
                                </div>
                            </div>

                            <div class="benefit-card">
                                <div class="benefit-icon-disk blue">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                </div>
                                <div class="benefit-texts">
                                    <strong>{{ $locale === 'km' ? 'សេវាដឹករហ័ស ២៤-៤៨ ម៉ោង' : 'Fast 24-48h Delivery' }}</strong>
                                    <small>{{ $locale === 'km' ? 'Free Shipping ចុងសប្តាហ៍' : 'Free weekend shipping perks' }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Popular Instant Voucher Coupons Strip -->
                        <div class="vip-coupons-bar">
                            <span class="coupons-bar-label">
                                <span class="sparkle-gold">⚡</span>
                                <span>{{ $translations['products']['newsletter_popular_tags'] ?? 'កូដប្រូម៉ូសិនពេញនិយម' }}:</span>
                            </span>
                            <div class="coupons-pills-list">
                                <button type="button" class="coupon-chip" onclick="copyVipCoupon('FLASH30', this)" title="ចុចចម្លងកូដ FLASH30">
                                    <span class="chip-icon">⚡</span>
                                    <code>FLASH30</code>
                                    <span class="chip-badge">-30%</span>
                                </button>
                                <button type="button" class="coupon-chip" onclick="copyVipCoupon('FREESHIP', this)" title="ចុចចម្លងកូដ FREESHIP">
                                    <span class="chip-icon">🚚</span>
                                    <code>FREESHIP</code>
                                    <span class="chip-badge free">Free</span>
                                </button>
                                <button type="button" class="coupon-chip" onclick="copyVipCoupon('NEW2026', this)" title="ចុចចម្លងកូដ NEW2026">
                                    <span class="chip-icon">✨</span>
                                    <code>NEW2026</code>
                                    <span class="chip-badge discount">-$10</span>
                                </button>
                                <button type="button" class="coupon-chip" onclick="copyVipCoupon('DARA10', this)" title="ចុចចម្លងកូដ DARA10">
                                    <span class="chip-icon">💎</span>
                                    <code>DARA10</code>
                                    <span class="chip-badge discount">-$10</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Luxury Gold VIP Ticket Voucher -->
                    <div class="vip-right-col">
                        <!-- Default Ticket Form -->
                        <div class="vip-ticket-card" id="vipFormCard">
                            <!-- Left & Right Ticket Perforated Notches -->
                            <div class="ticket-notch notch-left"></div>
                            <div class="ticket-notch notch-right"></div>

                            <div class="ticket-head">
                                <div class="ticket-icon-disc">
                                    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><circle cx="12" cy="12" r="2.2"></circle></svg>
                                </div>
                                <div class="ticket-head-titles">
                                    <span class="ticket-tag">VIP VOUCHER PASS</span>
                                    <h3 class="ticket-discount-val">$15.00 OFF</h3>
                                    <span class="ticket-for-who">{{ $locale === 'km' ? 'កាដូស្វាគមន៍សម្រាប់សមាជិកចុះឈ្មោះថ្មី' : 'Instant welcome gift for new members' }}</span>
                                </div>
                            </div>

                            <div class="ticket-dashed-line"></div>

                            <form id="vipNewsletterForm" onsubmit="handleVipNewsletter(event)" class="ticket-form">
                                @csrf
                                <div class="ticket-input-field">
                                    <svg class="ticket-input-svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    <input type="email" id="vipEmailInput" name="email" placeholder="{{ $translations['products']['newsletter_input_placeholder'] ?? 'បញ្ចូលអ៊ីមែលរបស់អ្នកដើម្បីដោះសោកាដូ...' }}" required autocomplete="email">
                                </div>

                                <button type="submit" class="ticket-submit-btn" id="vipSubmitBtn">
                                    <span class="btn-text">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                        <span>{{ $translations['products']['newsletter_btn'] ?? 'ដោះសោប័ណ្ណ $15 ឥឡូវនេះ' }}</span>
                                    </span>
                                    <span class="btn-spinner" style="display: none;">
                                        <span class="spinner-ring"></span>
                                        <span>កំពុងដំណើរការ...</span>
                                    </span>
                                </button>
                            </form>

                            <div class="ticket-trust-footer">
                                <span class="trust-lock">🔒</span>
                                <span>{{ $locale === 'km' ? 'យើងគោរពសិទ្ធិឯកជនភាព (100% No Spam) • អាចឈប់ជាវវិញបានគ្រប់ពេល' : '100% Privacy Protected • Zero spam • Unsubscribe anytime' }}</span>
                            </div>
                        </div>

                        <!-- Unlocked Voucher Card (Hidden until submitted) -->
                        <div class="vip-unlocked-card" id="vipUnlockedCard" style="display: none;">
                            <div class="ticket-notch notch-left"></div>
                            <div class="ticket-notch notch-right"></div>

                            <div class="unlocked-ribbon-tag">✓ ដោះសោប័ណ្ណបានជោគជ័យ!</div>
                            <div class="unlocked-big-amount">$15.00 OFF</div>
                            <h4 class="unlocked-congrats">{{ $translations['products']['newsletter_unlocked_title'] ?? 'សូមអបអរសាទរ! កាដូស្វាគមន៍របស់អ្នក' }}</h4>
                            <p class="unlocked-desc-p">{{ $translations['products']['newsletter_unlocked_desc'] ?? 'ប្រើប្រាស់កូដបញ្ចុះតម្លៃនេះនៅពេលទូទាត់ប្រាក់ ដើម្បីទទួលបានការបញ្ចុះតម្លៃ $15.00 ភ្លាមៗ' }}</p>

                            <div class="unlocked-code-box">
                                <div class="code-info">
                                    <small>{{ $locale === 'km' ? 'កូដបញ្ចុះតម្លៃ VIP:' : 'VIP Coupon Code:' }}</small>
                                    <strong id="unlockedCodeText">DARA-VIP15</strong>
                                </div>
                                <button type="button" class="btn-copy-unlocked" id="unlockedCopyBtn" onclick="copyVipCoupon('DARA-VIP15', this)">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    <span>{{ $translations['products']['newsletter_copy_code'] ?? 'ចម្លងកូដ' }}</span>
                                </button>
                            </div>
                            <small class="unlocked-validity">⏳ មានសុពលភាព 30 ថ្ងៃគិតចាប់ពីថ្ងៃនេះតទៅ</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Home Page Interactive Script -->
    <script>
    // Hero Carousel Script
    let currentHeroSlide = 0;
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroDots = document.querySelectorAll('.hero-dot');
    let heroAutoTimer = null;

    function goToHeroSlide(idx) {
        if (!heroSlides.length) return;
        heroSlides.forEach(s => s.classList.remove('active'));
        heroDots.forEach(d => d.classList.remove('active'));

        currentHeroSlide = (idx + heroSlides.length) % heroSlides.length;
        heroSlides[currentHeroSlide].classList.add('active');
        if (heroDots[currentHeroSlide]) heroDots[currentHeroSlide].classList.add('active');
        const counter = document.getElementById('heroSlideCounter');
        if (counter) counter.textContent = `0${currentHeroSlide + 1} / 0${heroSlides.length}`;
    }

    function changeHeroSlide(delta) {
        goToHeroSlide(currentHeroSlide + delta);
    }

    function startHeroTimer() {
        if (heroAutoTimer) clearInterval(heroAutoTimer);
        heroAutoTimer = setInterval(() => changeHeroSlide(1), 5000);
    }

    const heroWrap = document.getElementById('homeHeroCarousel');
    if (heroWrap) {
        heroWrap.addEventListener('mouseenter', () => clearInterval(heroAutoTimer));
        heroWrap.addEventListener('mouseleave', startHeroTimer);

        // Mobile Touch Swipe Navigation
        let touchStartX = 0;
        let touchStartY = 0;
        heroWrap.addEventListener('touchstart', function(e) {
            if (e.touches && e.touches.length > 0) {
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
                if (heroAutoTimer) clearInterval(heroAutoTimer);
            }
        }, { passive: true });

        heroWrap.addEventListener('touchend', function(e) {
            if (e.changedTouches && e.changedTouches.length > 0) {
                const diffX = e.changedTouches[0].clientX - touchStartX;
                const diffY = e.changedTouches[0].clientY - touchStartY;
                // Check if horizontal swipe was dominant
                if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
                    if (diffX < 0) {
                        changeHeroSlide(1); // Swipe left -> Next
                    } else {
                        changeHeroSlide(-1); // Swipe right -> Prev
                    }
                }
                startHeroTimer();
            }
        }, { passive: true });

        startHeroTimer();
    }

    // Live Ticking Deal of the Day Countdown Timer
    (function initDealCountdown() {
        const timerEl = document.getElementById('dealCountdownTimer');
        if (!timerEl) return;
        
        let totalSeconds = ({{ (int)($storeSettings['deal_countdown_hours'] ?? 6) }} * 3600) + 2542;
        
        function updateTimer() {
            if (totalSeconds <= 0) {
                totalSeconds = 8 * 3600;
            }
            totalSeconds--;
            
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            
            const pad = (n) => String(n).padStart(2, '0');
            timerEl.textContent = `${pad(hours)} : ${pad(minutes)} : ${pad(seconds)}`;
        }
        
        updateTimer();
        setInterval(updateTimer, 1000);
    })();

    // Quick Add Deal Product to Cart
    function quickAddDealProduct(btn) {
        const title = "{{ addslashes($locale === 'km' ? ($storeSettings['deal_title_km'] ?? 'កាសស្ដាប់ត្រចៀកឥតខ្សែ') : ($storeSettings['deal_title_en'] ?? 'Wireless Pro Headphones')) }}";
        const price = {{ (float)($storeSettings['deal_price'] ?? 32.00) }};
        const image = "{{ addslashes($storeSettings['deal_image'] ?? 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=400&q=80') }}";
        const dealId = 999999;
        
        if (typeof window.storeAddToCart === 'function') {
            window.storeAddToCart(dealId, title, price, 1, image);
        } else {
            const cart = JSON.parse(localStorage.getItem('dara_cart') || '[]');
            const existing = cart.find(item => item.id === dealId);
            if (existing) {
                existing.quantity += 1;
            } else {
                cart.push({ id: dealId, name: title, price: price, quantity: 1, image: image });
            }
            localStorage.setItem('dara_cart', JSON.stringify(cart));
            window.dispatchEvent(new Event('cart-updated'));
        }

        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<span>✓ បានបញ្ចូលកន្ត្រក!</span>';
        btn.style.background = '#15803d';
        
        if (typeof window.showToast === 'function') {
            window.showToast('✓ បានបញ្ចូល ' + title + ' ទៅកន្ត្រកដោយជោគជ័យ!');
        }

        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.style.background = '';
        }, 2200);

        if (typeof window.openCartDrawer === 'function') {
            window.openCartDrawer();
        }
    }

    // Sidebar Voucher One-Click Copy
    function copySidebarVoucher(code, btn) {
        navigator.clipboard.writeText(code).then(() => {
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<span>✓ Copied!</span>';
            btn.style.background = '#15803d';
            btn.style.color = '#ffffff';
            if (typeof window.showToast === 'function') {
                window.showToast('🎟 បានចម្លងកូដប័ណ្ណ ' + code + ' រួចរាល់! អាចប្រើបានពេលទូទាត់ប្រាក់');
            }
            try { sessionStorage.setItem('applied_voucher', code); } catch(e) {}
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.style.background = '';
                btn.style.color = '';
            }, 2200);
        });
    }

    // Popular Tags Quick Filtering
    document.querySelectorAll('.popular-tag-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            const mainCatBtn = document.querySelector(`.category-link[data-category="${filter}"]`);
            if (mainCatBtn) {
                mainCatBtn.click();
            } else {
                const catalogFilterBtn = document.querySelector(`[data-catalog-category="${filter}"]`);
                if (catalogFilterBtn) catalogFilterBtn.click();
            }
            
            const featuredSection = document.getElementById('featured');
            if (featuredSection) {
                featuredSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // VIP Club Newsletter & Voucher Claim
    function handleVipNewsletter(event) {
        event.preventDefault();
        const form = event.target;
        const input = document.getElementById('vipEmailInput');
        const btn = document.getElementById('vipSubmitBtn');
        if (!input || !input.value) return;

        btn.disabled = true;
        btn.querySelector('.btn-text').style.display = 'none';
        btn.querySelector('.btn-spinner').style.display = 'inline-flex';

        fetch('{{ route('newsletter.subscribe') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')?.value
            },
            body: JSON.stringify({ email: input.value.trim() })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success || data.message) {
                const formCard = document.getElementById('vipFormCard');
                const unlockedCard = document.getElementById('vipUnlockedCard');
                if (formCard && unlockedCard) {
                    formCard.style.display = 'none';
                    unlockedCard.style.display = 'flex';
                }
                if (typeof window.showToast === 'function') {
                    window.showToast(data.message || 'ដោះសោប័ណ្ណបញ្ចុះតម្លៃ $15 បានជោគជ័យ!');
                }
            }
        })
        .catch(err => {
            console.error(err);
            if (typeof window.showToast === 'function') {
                window.showToast('សូមពិនិត្យអ៊ីមែលរបស់អ្នកឡើងវិញ');
            }
        })
        .finally(() => {
            btn.disabled = false;
            btn.querySelector('.btn-text').style.display = 'inline-flex';
            btn.querySelector('.btn-spinner').style.display = 'none';
        });
    }

    function copyVipCoupon(code, btn) {
        navigator.clipboard.writeText(code).then(() => {
            const originalHtml = btn.innerHTML;
            btn.classList.add('copied');
            if (typeof window.showToast === 'function') {
                window.showToast('បានចម្លងកូដ ' + code + ' រួចរាល់! ✓');
            }
            setTimeout(() => {
                btn.classList.remove('copied');
            }, 2200);
        });
    }
    </script>
@endsection
