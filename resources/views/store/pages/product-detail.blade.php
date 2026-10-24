@extends('store.layouts.app')

@section('title', $product['name'] . ' - ' . config('app.name'))

@section('content')
<div class="product-detail-page">
    <div class="container">
        {{-- Breadcrumb Navigation (Nike Style) --}}
        <nav class="pdp-breadcrumbs" aria-label="Breadcrumb">
            <a href="{{ route('store.home') }}">{{ $translations['nav']['home'] ?? 'Home' }}</a>
            <span class="pdp-crumb-separator">•</span>
            <a href="{{ route('store.products') }}?category={{ $product['category_key'] }}">{{ $product['category_name'] }}</a>
            @if (!empty($product['breadcrumbs']))
                @foreach ($product['breadcrumbs'] as $crumb)
                    <span class="pdp-crumb-separator">•</span>
                    <span class="pdp-crumb-active">{{ $crumb }}</span>
                @endforeach
            @endif
        </nav>

        {{-- Main Product Showcase Grid --}}
        <div class="pdp-layout">
            {{-- Left Column: Interactive Multi-Angle Gallery --}}
            <div class="pdp-gallery-container">
                {{-- Vertical Thumbnails Strip (Left on Desktop) --}}
                <div class="pdp-thumbnails-strip" id="pdp-thumbnails" role="tablist" aria-label="Product image angles">
                    @foreach ($product['gallery'] as $index => $imgUrl)
                        <button
                            type="button"
                            class="pdp-thumb-btn {{ $index === 0 ? 'active' : '' }}"
                            data-img-src="{{ $imgUrl }}"
                            data-index="{{ $index }}"
                            aria-label="View angle {{ $index + 1 }}"
                        >
                            <img src="{{ $imgUrl }}" alt="{{ $product['name'] }} thumbnail {{ $index + 1 }}" loading="lazy">
                        </button>
                    @endforeach
                </div>

                {{-- Hero Active Image View --}}
                <div class="pdp-main-image-wrap">
                    @if ($product['badge'])
                        @php
                            $isDiscount = str_contains($product['badge'], '%') || str_contains($product['badge'], '-');
                            $badgeLabel = $product['badge'];
                            if ($badgeLabel === 'best_seller') {
                                $badgeLabel = $locale === 'km' ? 'លក់ដាច់បំផុត' : 'Best Seller';
                            } elseif ($badgeLabel === 'popular') {
                                $badgeLabel = $locale === 'km' ? 'ពេញនិយម' : 'Popular';
                            }
                        @endphp
                        <span class="pdp-hero-badge {{ $isDiscount ? 'discount' : 'bestseller' }}">
                            @if ($isDiscount)
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82zM7 5a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                            @endif
                            <span>{{ $badgeLabel }}</span>
                        </span>
                    @endif

                    <img
                        id="pdp-hero-image"
                        class="pdp-hero-image"
                        src="{{ $product['main_image'] }}"
                        alt="{{ $product['name'] }}"
                    >

                    <button type="button" class="pdp-zoom-indicator" aria-label="Zoom image" id="pdp-zoom-trigger">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                    </button>
                </div>
            </div>

            {{-- Right Column: Brand, Title, Swatches, Sizes & Purchase Actions --}}
            <div class="pdp-details-container">
                {{-- Brand Row (Nike Logo Badge) --}}
                <div class="pdp-brand-row">
                    <div class="pdp-brand-badge">
                        @if (strtolower($product['brand']) === 'nike')
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                <path d="M21.707 5.293c-.27-.27-.69-.32-1.01-.12L4.35 15.39c-1.35.84-1.92 2.51-1.31 3.99.58 1.41 1.99 2.29 3.51 2.29 1.15 0 2.29-.5 3.12-1.42L21.71 6.71c.39-.39.39-1.02 0-1.42z"/>
                            </svg>
                        @elseif (str_contains(strtolower($product['brand']), 'apparel') || str_contains(strtolower($product['brand']), 'cloth'))
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z"/></svg>
                        @else
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                        @endif
                    </div>
                    <span class="pdp-brand-name">{{ $product['brand'] }}</span>
                </div>

                {{-- Product Title & Subtitle --}}
                <h1 class="pdp-title">{{ $product['name'] }}</h1>
                <p class="pdp-subtitle">{{ $product['subtitle'] }}</p>

                {{-- Rating Stars & Review Count --}}
                <div class="pdp-rating-row">
                    <div class="pdp-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="{{ $i <= round($product['rating']) ? '#eab308' : '#d1d5db' }}">
                                <path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="pdp-rating-val">{{ number_format($product['rating'], 1) }}</span>
                    <span class="pdp-reviews-count">{{ $product['reviews_count'] }} {{ $locale === 'km' ? 'ការវាយតម្លៃ' : 'reviews' }}</span>
                </div>

                {{-- Price Block --}}
                <div class="pdp-price-row">
                    <span class="pdp-price">${{ number_format($product['price'], 2) }}</span>
                    @if ($product['old_price'] !== null)
                        <del class="pdp-old-price">${{ number_format($product['old_price'], 2) }}</del>
                        @if ($product['discount_percent'])
                            <span class="pdp-save-badge">-{{ $product['discount_percent'] }}%</span>
                        @endif
                    @endif
                </div>

                {{-- Color Swatches Strip (Matching Image 2 Miniature Preview Style) --}}
                @if (!empty($product['colors']) && count($product['colors']) > 1)
                    <div class="pdp-section pdp-color-swatches-section">
                        <div class="pdp-section-header">
                            <span class="pdp-section-title">{{ $locale === 'km' ? 'ជ្រើសរើសពណ៌' : 'Select Color' }}:</span>
                            <span class="pdp-selected-color-label" id="pdp-current-color-name">{{ $product['colors'][0]['name'] }}</span>
                        </div>
                        <div class="pdp-color-swatches-grid" id="pdp-color-swatches" role="radiogroup" aria-label="Color options">
                            @foreach ($product['colors'] as $cIndex => $col)
                                <button
                                    type="button"
                                    class="pdp-color-card {{ $cIndex === 0 ? 'selected' : '' }}"
                                    data-color-name="{{ $col['name'] }}"
                                    data-color-img="{{ $col['image'] }}"
                                    role="radio"
                                    aria-checked="{{ $cIndex === 0 ? 'true' : 'false' }}"
                                    title="{{ $col['name'] }}"
                                >
                                    <img src="{{ $col['image'] }}" alt="{{ $col['name'] }}" loading="lazy">
                                    <span class="pdp-color-dot" style="background-color: {{ $col['code'] }};"></span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Size Selection (Matching Image 2 Nike Grid Style) --}}
                @if (!empty($product['sizes']))
                    <div class="pdp-section pdp-sizes-section">
                        <div class="pdp-section-header">
                            <span class="pdp-section-title">
                                @if ($product['size_type'] === 'shoes')
                                    {{ $locale === 'km' ? 'ជ្រើសរើសទំហំស្បែកជើង' : 'Select Size' }}
                                @elseif ($product['size_type'] === 'clothing')
                                    {{ $locale === 'km' ? 'ជ្រើសរើសទំហំអាវ' : 'Select Size' }}
                                @elseif ($product['size_type'] === 'capacity')
                                    {{ $locale === 'km' ? 'ជ្រើសរើសចំណុះ' : 'Select Capacity' }}
                                @else
                                    {{ $locale === 'km' ? 'ជម្រើស' : 'Option' }}
                                @endif
                            </span>
                            <button type="button" class="pdp-size-guide-btn" id="pdp-size-guide-trigger">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                <span>{{ $locale === 'km' ? 'តារាងទំហំ Size Guide' : 'Size Guide' }}</span>
                            </button>
                        </div>

                        <div class="pdp-sizes-grid" id="pdp-sizes-grid" role="radiogroup" aria-label="Available sizes">
                            @foreach ($product['sizes'] as $sIndex => $sz)
                                <button
                                    type="button"
                                    class="pdp-size-pill {{ $sz === $product['default_size'] ? 'selected' : '' }}"
                                    data-size="{{ $sz }}"
                                    role="radio"
                                    aria-checked="{{ $sz === $product['default_size'] ? 'true' : 'false' }}"
                                >
                                    {{ $sz }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Quantity + Add to Cart + Wishlist --}}
                <div class="pdp-purchase-actions">
                    <div class="pdp-qty-stepper">
                        <button type="button" class="qty-btn" id="pdp-qty-minus" aria-label="Decrease quantity">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </button>
                        <input type="number" id="pdp-qty-input" value="1" min="1" max="99" aria-label="Quantity">
                        <button type="button" class="qty-btn" id="pdp-qty-plus" aria-label="Increase quantity">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </button>
                    </div>

                    {{-- Main Add to Cart Button (Nike Black Pill) --}}
                    <button
                        type="button"
                        class="pdp-btn-add-cart"
                        id="pdp-add-to-cart-btn"
                        data-product-id="{{ $product['id'] }}"
                        data-product-name="{{ $product['name'] }}"
                        data-product-price="{{ $product['price'] }}"
                        data-product-image="{{ $product['main_image'] }}"
                    >
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <span>{{ $translations['cart']['add'] ?? 'Add to cart' }}</span>
                    </button>

                    {{-- Favorite Wishlist Toggle Button --}}
                    <button
                        type="button"
                        class="pdp-btn-wishlist favorite-button"
                        data-product-id="{{ $product['id'] }}"
                        data-label-add="{{ $translations['js']['add_favorite'] ?? 'Add to wishlist' }}"
                        data-label-remove="{{ $translations['js']['remove_favorite'] ?? 'Remove wishlist' }}"
                        aria-label="Add to wishlist"
                    >
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.8 8.8c0 5.1-8.8 10-8.8 10s-8.8-4.9-8.8-10a4.6 4.6 0 0 1 8.8-1.9 4.6 4.6 0 0 1 8.8 1.9Z"></path>
                        </svg>
                    </button>
                </div>

                {{-- Delivery & Guarantee Badges (Matching Image 2 Bottom Strip) --}}
                <div class="pdp-guarantee-box">
                    <div class="pdp-guarantee-item">
                        <div class="pdp-guarantee-icon">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                        </div>
                        <div class="pdp-guarantee-text">
                            <strong>{{ $locale === 'km' ? 'ដឹកជញ្ជូនឥតគិតថ្លៃសម្រាប់ការកុម្ម៉ង់លើសពី $30.00' : 'Free delivery on order over $30.00' }}</strong>
                            <span>{{ $locale === 'km' ? 'បញ្ជូនទូទាំងប្រទេសរហ័សទាន់ចិត្តក្នុង 24-48 ម៉ោង' : 'Standard delivery 2-4 business days nationwide' }}</span>
                        </div>
                    </div>
                    <div class="pdp-guarantee-item">
                        <div class="pdp-guarantee-icon">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <div class="pdp-guarantee-text">
                            <strong>{{ $locale === 'km' ? 'ទំនិញសុទ្ធ 100% & ធានាដូរវិញក្នុងរយៈពេល 7 ថ្ងៃ' : '100% Authentic Guarantee & 7-day returns' }}</strong>
                            <span>{{ $locale === 'km' ? 'ត្រួតពិនិត្យទំនិញមុនទូទាត់ប្រាក់ដោយទំនុកចិត្ត' : 'Check product upon arrival with money-back guarantee' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Accordion Tabs: Description & Specifications --}}
                <div class="pdp-accordion-group">
                    <details class="pdp-accordion-item" open>
                        <summary class="pdp-accordion-summary">
                            <span>{{ $locale === 'km' ? 'ព័ត៌មានលម្អិតនៃផលិតផល' : 'Product Details & Description' }}</span>
                            <svg class="pdp-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </summary>
                        <div class="pdp-accordion-content">
                            <p>
                                @if ($locale === 'km')
                                    ផលិតផលម៉ាក {{ $product['brand'] }} រចនាឡើងយ៉ាងប្រណីតដោយផ្តោតលើភាពធន់ និងសោភ័ណភាពទាន់សម័យ។ សាកសមបំផុតសម្រាប់ការប្រើប្រាស់ប្រចាំថ្ងៃ ផ្ដល់ផាសុកភាពខ្ពស់ និងភាពជឿជាក់។
                                @else
                                    Crafted with high-grade premium materials for exceptional durability, comfort, and versatile style. Designed to seamlessly fit into your modern lifestyle.
                                @endif
                            </p>
                            <ul class="pdp-feature-list">
                                <li><strong>SKU:</strong> {{ $product['sku'] ?? 'DR-'.strtoupper(substr(md5($product['name']), 0, 8)) }}</li>
                                <li><strong>{{ $locale === 'km' ? 'ស្ថានភាពស្តុក' : 'Availability' }}:</strong> {{ $product['stock'] }} {{ $locale === 'km' ? 'គ្រឿងក្នុងស្តុក' : 'in stock' }}</li>
                                <li><strong>{{ $locale === 'km' ? 'សម្ភារៈ' : 'Material' }}:</strong> {{ $locale === 'km' ? 'វត្ថុធាតុដើមសម្រាំងកម្រិតខ្ពស់' : 'Premium Certified Construction' }}</li>
                            </ul>
                        </div>
                    </details>
                </div>
            </div>
        </div>

        {{-- Related Products Section (Shows items from the same category - "រើសអាវចេញមកតែអាវ") --}}
        @if (!empty($relatedProducts) && count($relatedProducts) > 0)
            <section class="pdp-related-section" aria-label="Related Products">
                <div class="pdp-related-header">
                    <div class="pdp-related-heading-group">
                        <span class="pdp-related-kicker">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                            <span>{{ $locale === 'km' ? 'ជម្រើសពិសេសសម្រាប់អ្នក' : 'RECOMMENDED FOR YOU' }}</span>
                        </span>
                        <h2 class="pdp-related-title">
                            @if ($locale === 'km')
                                ទំនិញក្នុងក្រុម {{ $product['category_name'] }}
                            @else
                                More in {{ $product['category_name'] }}
                            @endif
                        </h2>
                        <p class="pdp-related-desc">
                            {{ $locale === 'km' ? 'ផលិតផលដែលមានគុណភាពខ្ពស់ និងរចនាបថស្របតាមតម្រូវការរបស់អ្នក' : 'Curated premium items with matching style and quality' }}
                        </p>
                    </div>
                    <a href="{{ route('store.products') }}?category={{ $product['category_key'] }}" class="pdp-see-all-pill">
                        <span>{{ $locale === 'km' ? 'មើលទាំងអស់' : 'View all' }}</span>
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="product-grid pdp-related-grid">
                    @foreach ($relatedProducts as $relProduct)
                        @include('store.partials.product-card', ['product' => $relProduct])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>

{{-- Size Guide Modal --}}
<div class="pdp-modal-backdrop" id="pdp-size-modal" hidden>
    <div class="pdp-modal-card" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="pdp-modal-header">
            <h3 id="modal-title">{{ $locale === 'km' ? 'តារាងទំហំផ្លូវការ (Size Guide)' : 'Standard Sizing Chart' }}</h3>
            <button type="button" class="pdp-modal-close" id="pdp-modal-close" aria-label="Close size guide">&times;</button>
        </div>
        <div class="pdp-modal-body">
            @if ($product['size_type'] === 'clothing')
                <table class="pdp-size-table">
                    <thead>
                        <tr><th>Size</th><th>Chest (in)</th><th>Length (in)</th><th>Shoulder (in)</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>S</strong></td><td>36 - 38</td><td>28</td><td>17.5</td></tr>
                        <tr><td><strong>M</strong></td><td>38 - 40</td><td>29</td><td>18.5</td></tr>
                        <tr><td><strong>L</strong></td><td>40 - 42</td><td>30</td><td>19.5</td></tr>
                        <tr><td><strong>XL</strong></td><td>42 - 44</td><td>31</td><td>20.5</td></tr>
                        <tr><td><strong>2XL</strong></td><td>44 - 46</td><td>32</td><td>21.5</td></tr>
                    </tbody>
                </table>
            @elseif ($product['size_type'] === 'shoes')
                <table class="pdp-size-table">
                    <thead>
                        <tr><th>EU</th><th>US Men</th><th>US Women</th><th>Foot (cm)</th></tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>40</strong></td><td>7</td><td>8.5</td><td>25.0</td></tr>
                        <tr><td><strong>41</strong></td><td>8</td><td>9.5</td><td>26.0</td></tr>
                        <tr><td><strong>42</strong></td><td>8.5</td><td>10</td><td>26.5</td></tr>
                        <tr><td><strong>43</strong></td><td>9.5</td><td>11</td><td>27.5</td></tr>
                        <tr><td><strong>44</strong></td><td>10</td><td>11.5</td><td>28.0</td></tr>
                        <tr><td><strong>45</strong></td><td>11</td><td>12.5</td><td>29.0</td></tr>
                    </tbody>
                </table>
            @else
                <p>{{ $locale === 'km' ? 'ទំនិញនេះមានទំហំស្តង់ដារអន្តរជាតិ សមស្របសម្រាប់មនុស្សទូទៅ។' : 'Standard international sizing suitable for universal everyday use.' }}</p>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const heroImage = document.getElementById('pdp-hero-image');
    const thumbButtons = document.querySelectorAll('.pdp-thumb-btn');
    const colorSwatches = document.querySelectorAll('.pdp-color-card');
    const colorNameLabel = document.getElementById('pdp-current-color-name');
    const sizePills = document.querySelectorAll('.pdp-size-pill');
    const qtyInput = document.getElementById('pdp-qty-input');
    const qtyMinus = document.getElementById('pdp-qty-minus');
    const qtyPlus = document.getElementById('pdp-qty-plus');
    const addToCartBtn = document.getElementById('pdp-add-to-cart-btn');
    const sizeGuideBtn = document.getElementById('pdp-size-guide-trigger');
    const sizeModal = document.getElementById('pdp-size-modal');
    const modalClose = document.getElementById('pdp-modal-close');

    let selectedSize = '{{ $product["default_size"] ?? "" }}';
    let selectedColor = '{{ $product["colors"][0]["name"] ?? "" }}';

    // Thumbnail switching with smooth fade transition
    thumbButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            thumbButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const newSrc = this.getAttribute('data-img-src');
            if (heroImage && newSrc) {
                heroImage.style.opacity = '0.3';
                heroImage.style.transform = 'scale(0.97)';
                setTimeout(() => {
                    heroImage.src = newSrc;
                    heroImage.style.opacity = '1';
                    heroImage.style.transform = 'scale(1)';
                }, 120);
            }
        });
    });

    // Color Swatches switching
    colorSwatches.forEach(swatch => {
        swatch.addEventListener('click', function () {
            colorSwatches.forEach(s => {
                s.classList.remove('selected');
                s.setAttribute('aria-checked', 'false');
            });
            this.classList.add('selected');
            this.setAttribute('aria-checked', 'true');

            const colorName = this.getAttribute('data-color-name');
            const colorImg = this.getAttribute('data-color-img');
            selectedColor = colorName;

            if (colorNameLabel) {
                colorNameLabel.textContent = colorName;
            }

            if (heroImage && colorImg) {
                heroImage.style.opacity = '0.3';
                heroImage.style.transform = 'scale(0.97)';
                setTimeout(() => {
                    heroImage.src = colorImg;
                    heroImage.style.opacity = '1';
                    heroImage.style.transform = 'scale(1)';
                }, 120);
            }
        });
    });

    // Size Pills Selection
    sizePills.forEach(pill => {
        pill.addEventListener('click', function () {
            sizePills.forEach(p => {
                p.classList.remove('selected');
                p.setAttribute('aria-checked', 'false');
            });
            this.classList.add('selected');
            this.setAttribute('aria-checked', 'true');
            selectedSize = this.getAttribute('data-size');
        });
    });

    // Quantity Stepper
    if (qtyMinus && qtyInput) {
        qtyMinus.addEventListener('click', () => {
            const current = parseInt(qtyInput.value, 10) || 1;
            if (current > 1) qtyInput.value = current - 1;
        });
    }
    if (qtyPlus && qtyInput) {
        qtyPlus.addEventListener('click', () => {
            const current = parseInt(qtyInput.value, 10) || 1;
            if (current < 99) qtyInput.value = current + 1;
        });
    }

    // Modal size guide
    if (sizeGuideBtn && sizeModal) {
        sizeGuideBtn.addEventListener('click', () => {
            sizeModal.removeAttribute('hidden');
        });
    }
    if (modalClose && sizeModal) {
        modalClose.addEventListener('click', () => {
            sizeModal.setAttribute('hidden', '');
        });
    }
    if (sizeModal) {
        sizeModal.addEventListener('click', (e) => {
            if (e.target === sizeModal) sizeModal.setAttribute('hidden', '');
        });
    }

    // Add To Cart Action
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function () {
            const pid = this.getAttribute('data-product-id');
            const name = this.getAttribute('data-product-name');
            const price = parseFloat(this.getAttribute('data-product-price')) || 0;
            const img = heroImage ? heroImage.src : this.getAttribute('data-product-image');
            const qty = parseInt(qtyInput ? qtyInput.value : 1, 10) || 1;

            const fullName = selectedSize ? `${name} (${selectedSize}, ${selectedColor})` : name;

            // Trigger global store addToCart if available or dispatch custom event
            if (typeof window.storeAddToCart === 'function') {
                window.storeAddToCart(pid, fullName, price, qty, img);
                return;
            }
                // Dispatch native custom event that store.js listens to
                window.dispatchEvent(new CustomEvent('product:added-to-cart', {
                    detail: {
                        id: pid,
                        name: fullName,
                        price: price,
                        qty: qty,
                        image: img
                    }
                }));

                // Fallback direct localStorage cart injection
                try {
                    const storageKey = 'dara_store_cart_items';
                    let items = JSON.parse(localStorage.getItem(storageKey) || '[]');
                    const existingIndex = items.findIndex(it => it.id === pid && it.name === fullName);
                    if (existingIndex > -1) {
                        items[existingIndex].quantity = (items[existingIndex].quantity || 1) + qty;
                    } else {
                        items.push({
                            id: pid,
                            name: fullName,
                            price: price,
                            quantity: qty,
                            image: img
                        });
                    }
                    localStorage.setItem(storageKey, JSON.stringify(items));

                    // Show success feedback
                    const originalHtml = addToCartBtn.innerHTML;
                    addToCartBtn.innerHTML = `
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>{{ $locale === 'km' ? 'បានបញ្ចូលជោគជ័យ!' : 'Added to Cart!' }}</span>
                    `;
                    addToCartBtn.style.background = '#059669';

                    setTimeout(() => {
                        addToCartBtn.innerHTML = originalHtml;
                        addToCartBtn.style.background = '';
                    }, 1800);

                    // Update store cart count in header if element exists
                    const countBadge = document.querySelector('.cart-count, .cart-bubble, [data-cart-counter]');
                    if (countBadge) {
                        const totalCount = items.reduce((sum, item) => sum + (item.quantity || 1), 0);
                        countBadge.textContent = totalCount;
                        countBadge.style.display = totalCount > 0 ? 'flex' : 'none';
                    }
                } catch (e) {
                    console.error('Error saving cart:', e);
                }
            }
        });
    }
});
</script>
@endsection
