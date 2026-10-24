@extends('store.layouts.app')

@section('title', $translations['meta']['title'])

@section('content')
    <div class="container page-layout">
@php
    $catSvgs = [
        'all' => '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>',
        'electronics' => '<svg viewBox="0 0 24 24"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>',
        'fashion' => '<svg viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>',
        'kitchen' => '<svg viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>',
        'beauty' => '<svg viewBox="0 0 24 24"><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3Z"></path></svg>',
    ];
@endphp

        <aside class="sidebar sidebar-left" aria-label="{{ $translations['sidebar']['categories'] }}">
            <!-- 1. Category Filter Card -->
            <section class="sidebar-card category-sidebar" id="categories">
                <div class="sidebar-header-row">
                    <button class="sidebar-title" type="button" aria-expanded="false">
                        <span>{{ $translations['sidebar']['categories'] }}</span>
                        <span class="sidebar-title-badge">HOT</span>
                    </button>
                </div>
                <div class="category-links-list">
                    <button class="category-link selected" type="button" data-filter="all">
                        <span class="cat-link-left">
                            <span class="cat-icon-disk">{!! $catSvgs['all'] !!}</span>
                            <span class="cat-name">{{ $translations['categories']['all'] }}</span>
                        </span>
                        <span class="cat-count-pill">{{ str_pad((string) $productCount, 2, '0', STR_PAD_LEFT) }}</span>
                    </button>
                    @foreach ($categories as $category)
                        <button class="category-link" type="button" data-filter="{{ $category }}">
                            <span class="cat-link-left">
                                <span class="cat-icon-disk">{!! $catSvgs[$category] ?? '<svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>' !!}</span>
                                <span class="cat-name">{{ $translations['categories'][$category] }}</span>
                            </span>
                            <span class="cat-count-pill">{{ str_pad((string) $categoryCounts[$category], 2, '0', STR_PAD_LEFT) }}</span>
                        </button>
                    @endforeach
                </div>
            </section>

            <!-- 2. Flash Deal Of The Day Widget -->
            <section class="sidebar-card daily-deal-widget">
                <div class="deal-widget-header">
                    <span class="deal-kicker">
                        <svg class="deal-icon-svg" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>{{ $locale === 'km' ? 'ប្រូម៉ូសិនពិសេសថ្ងៃនេះ' : 'DEAL OF THE DAY' }}</span>
                    </span>
                    <span class="deal-live-tag">LIVE</span>
                </div>
                <div class="deal-product-preview">
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=400&q=80" alt="Deal Product" class="deal-img">
                    <div class="deal-product-details">
                        <span class="deal-product-title">{{ $locale === 'km' ? 'កាសស្ដាប់ត្រចៀកឥតខ្សែ' : 'Wireless Pro Headphones' }}</span>
                        <div class="deal-price-row">
                            <strong class="deal-price">$32.00</strong>
                            <del class="deal-old-price">$42.00</del>
                            <span class="deal-discount-badge">-24%</span>
                        </div>
                    </div>
                </div>
                <div class="deal-progress-wrap">
                    <div class="deal-progress-bar"><div class="deal-progress-fill" style="width: 78%;"></div></div>
                    <div class="deal-progress-text">
                        <small>{{ $locale === 'km' ? 'លក់ដាច់ 78% (សល់ 5 គ្រឿង)' : 'Sold 78% • Only 5 left' }}</small>
                    </div>
                </div>
                <a href="#featured" class="deal-action-btn">
                    <span>{{ $locale === 'km' ? 'បញ្ជាទិញឥឡូវនេះ' : 'Grab Deal Now' }}</span>
                    <span>→</span>
                </a>
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
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=600&q=80" alt="{{ $translations['sidebar']['spotlight_alt'] }}" loading="lazy">
                <div class="spotlight-overlay">
                    <span class="spotlight-tag">
                        <svg viewBox="0 0 24 24" width="10" height="10" fill="currentColor" style="display:inline-block; vertical-align:-1px; margin-right:3px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        {{ $locale === 'km' ? 'ជម្រើសពេញនិយម' : 'STORE SPOTLIGHT' }}
                    </span>
                    <small>{{ $translations['sidebar']['spotlight_caption'] }}</small>
                    <strong>{{ $translations['sidebar']['spotlight_title'] }}</strong>
                    <a href="#featured" class="spotlight-btn">{{ $translations['sidebar']['spotlight_link'] }} <span>→</span></a>
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
                                @if ($category === 'electronics')
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                                @elseif ($category === 'fashion')
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                @elseif ($category === 'kitchen')
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"></path><path d="M7 2v20"></path><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"></path></svg>
                                @elseif ($category === 'beauty')
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                                @endif
                                <span>{{ $translations['categories'][$category] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="product-grid" id="featured-grid">
                    @foreach ($featuredProducts as $product)
                        @include('store.partials.product-card', ['product' => $product])
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

            <!-- VIP Rewards & Deals Club Interactive Showcase -->
            <section class="vip-club-showcase" id="vipClubBanner">
                <!-- Background ambient decorative lights -->
                <div class="vip-decor-glow glow-1" aria-hidden="true"></div>
                <div class="vip-decor-glow glow-2" aria-hidden="true"></div>

                <div class="vip-showcase-inner">
                    <!-- Left Content -->
                    <div class="vip-showcase-info">
                        <div class="vip-badge-row">
                            <span class="vip-pill-badge">
                                <span class="vip-sparkle">✦</span>
                                <span>{{ $translations['products']['newsletter_kicker'] }}</span>
                            </span>
                            <span class="vip-live-indicator">
                                <span class="live-dot"></span>
                                <span>{{ $translations['products']['newsletter_social_proof'] }}</span>
                            </span>
                        </div>

                        <h2 class="vip-showcase-title">
                            {{ $translations['products']['newsletter_title'] }}
                        </h2>

                        <p class="vip-showcase-desc">
                            {{ $translations['products']['newsletter_description'] }}
                        </p>

                        <!-- Benefit Badges -->
                        <div class="vip-benefits-row">
                            <div class="vip-benefit-pill">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path></svg>
                                <span>{{ $translations['products']['newsletter_benefit_1'] }}</span>
                            </div>
                            <div class="vip-benefit-pill">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <span>{{ $translations['products']['newsletter_benefit_2'] }}</span>
                            </div>
                            <div class="vip-benefit-pill">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                                <span>{{ $translations['products']['newsletter_benefit_3'] }}</span>
                            </div>
                        </div>

                        <!-- Quick Popular Coupon Tags -->
                        <div class="vip-tags-row">
                            <span class="vip-tags-label">{{ $translations['products']['newsletter_popular_tags'] }}:</span>
                            <button type="button" class="vip-coupon-tag" onclick="copyVipCoupon('FLASH30', this)" title="ចុចដើម្បីចម្លងកូដ FLASH30">
                                <span class="tag-icon">⚡</span>
                                <code>FLASH30</code>
                                <span class="tag-discount">-30%</span>
                            </button>
                            <button type="button" class="vip-coupon-tag" onclick="copyVipCoupon('FREESHIP', this)" title="ចុចដើម្បីចម្លងកូដ FREESHIP">
                                <span class="tag-icon">🚚</span>
                                <code>FREESHIP</code>
                                <span class="tag-discount">Free</span>
                            </button>
                            <button type="button" class="vip-coupon-tag" onclick="copyVipCoupon('NEW2026', this)" title="ចុចដើម្បីចម្លងកូដ NEW2026">
                                <span class="tag-icon">✨</span>
                                <code>NEW2026</code>
                                <span class="tag-discount">-$10</span>
                            </button>
                        </div>
                    </div>

                    <!-- Right Interactive Box -->
                    <div class="vip-showcase-action">
                        <!-- Default Form View -->
                        <div class="vip-form-card" id="vipFormCard">
                            <div class="vip-card-header">
                                <div class="vip-ticket-icon">
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><circle cx="12" cy="12" r="2"></circle></svg>
                                </div>
                                <div>
                                    <h3>$15.00 OFF</h3>
                                    <small>សម្រាប់សមាជិកចុះឈ្មោះថ្មី</small>
                                </div>
                            </div>

                            <form id="vipNewsletterForm" onsubmit="handleVipNewsletter(event)">
                                @csrf
                                <div class="vip-input-box">
                                    <svg class="vip-input-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    <input type="email" id="vipEmailInput" name="email" placeholder="{{ $translations['products']['newsletter_input_placeholder'] }}" required autocomplete="email">
                                </div>
                                <button type="submit" class="vip-submit-btn" id="vipSubmitBtn">
                                    <span class="btn-text">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                        <span>{{ $translations['products']['newsletter_btn'] }}</span>
                                    </span>
                                    <span class="btn-spinner" style="display: none;">
                                        <span class="spinner-ring"></span>
                                        <span>កំពុងដោះសោ...</span>
                                    </span>
                                </button>
                            </form>
                            <p class="vip-privacy-note">🔒 គ្មានសារឥតប្រយោជន៍ (No spam). អ្នកអាចឈប់ជាវបានគ្រប់ពេល។</p>
                        </div>

                        <!-- Unlocked Voucher Card (Hidden until submitted) -->
                        <div class="vip-unlocked-card" id="vipUnlockedCard" style="display: none;">
                            <div class="unlocked-ribbon">✓ ដោះសោបានជោគជ័យ</div>
                            <div class="unlocked-amount">$15.00 OFF</div>
                            <h4>{{ $translations['products']['newsletter_unlocked_title'] }}</h4>
                            <p>{{ $translations['products']['newsletter_unlocked_desc'] }}</p>

                            <div class="unlocked-coupon-box">
                                <div class="coupon-code-wrap">
                                    <small>កូដបញ្ចុះតម្លៃ:</small>
                                    <strong id="unlockedCodeText">DARA-VIP15</strong>
                                </div>
                                <button type="button" class="unlocked-copy-btn" id="unlockedCopyBtn" onclick="copyVipCoupon('DARA-VIP15', this)">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    <span>{{ $translations['products']['newsletter_copy_code'] }}</span>
                                </button>
                            </div>
                            <small class="unlocked-exp">សុពលភាព៖ 30 ថ្ងៃបន្ទាប់ពីដោះសោ</small>
                        </div>
                    </div>
                </div>
            </section>
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

            <!-- 2. Exclusive Voucher Coupon Card (NEW FEATURE) -->
            <section class="sidebar-card voucher-coupon-card">
                <div class="voucher-top-tag">
                    <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path></svg>
                    <span>{{ $locale === 'km' ? 'ប័ណ្ណបញ្ចុះតម្លៃពិសេស' : 'SPECIAL VOUCHER' }}</span>
                </div>
                <h3>$20.00 OFF</h3>
                <p>{{ $locale === 'km' ? 'បញ្ចុះតម្លៃ $20 លើការទិញចាប់ពី $80 ឡើងទៅ' : 'For orders over $80 on all categories' }}</p>
                <div class="coupon-code-box">
                    <code id="sidebarCouponCode">DARA20</code>
                    <button type="button" class="coupon-copy-btn" onclick="copySidebarVoucher('DARA20', this)">Copy</button>
                </div>
            </section>

            <!-- 3. Side Feature Banner -->
            <section class="sidebar-card side-feature">
                <div class="side-feature-img-wrap">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=600&q=80" alt="{{ $translations['sidebar']['style_alt'] }}" loading="lazy">
                    <span class="side-feature-pill">NEW IN</span>
                </div>
                <div class="side-feature-copy">
                    <span class="section-kicker">{{ $translations['sidebar']['style_kicker'] }}</span>
                    <h2>{{ $translations['sidebar']['style_title'] }}</h2>
                    <a class="text-link" href="#featured">{{ $translations['sidebar']['style_link'] }} <span>→</span></a>
                </div>
            </section>

            <!-- 4. Popular Tags Card -->
            <section class="sidebar-card">
                <h2 class="sidebar-heading">{{ $translations['sidebar']['popular_categories'] }}</h2>
                <div class="popular-tags-v2">
                    @foreach ($categories as $category)
                        <button type="button" data-filter="{{ $category }}" class="popular-tag-btn">
                            {!! $catSvgs[$category] ?? '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle></svg>' !!}
                            <span>{{ $translations['categories'][$category] }}</span>
                        </button>
                    @endforeach
                </div>
            </section>

            <!-- 5. Need Help Card -->
            <section class="help-card-v2">
                <span class="help-icon-bubble">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                </span>
                <h2>{{ $translations['sidebar']['need_help'] }}</h2>
                <p>{{ $translations['sidebar']['help_description'] }}</p>
                <a href="tel:+85512345678" class="help-call-btn">
                    <span>{{ $translations['sidebar']['call_us'] }}</span>
                    <span>→</span>
                </a>
            </section>
        </aside>
    </div>

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
        startHeroTimer();
    }

    // Sidebar Voucher One-Click Copy
    function copySidebarVoucher(code, btn) {
        navigator.clipboard.writeText(code).then(() => {
            const originalText = btn.textContent;
            btn.textContent = '✓ Copied!';
            btn.style.background = '#245943';
            btn.style.color = '#ffffff';
            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.background = '#d8a962';
                btn.style.color = '#10291f';
            }, 2000);
        });
    }

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
