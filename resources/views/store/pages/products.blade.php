@extends('store.layouts.app')

@section('title', ($isNewArrivals ?? false) ? $translations['catalog']['new_title'] : $translations['catalog']['title'])

@section('content')
<div class="catalog-page">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="catalog-breadcrumb" aria-label="{{ $translations['catalog']['breadcrumb_label'] }}">
            <a href="{{ route('store.home') }}">{{ $translations['nav']['home'] }}</a>
            <span class="catalog-breadcrumb-sep">/</span>
            <span aria-current="page">{{ ($isNewArrivals ?? false) ? $translations['nav']['new'] : $translations['nav']['products'] }}</span>
        </nav>

        {{-- Luxury Hero Banner --}}
        <header class="catalog-luxury-header">
            <div class="catalog-header-glow"></div>
            <div class="catalog-header-content">
                <span class="catalog-kicker-badge">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                    <span>{{ ($isNewArrivals ?? false) ? $translations['products']['new_kicker'] : $translations['catalog']['eyebrow'] }}</span>
                </span>
                <h1 class="catalog-title">{{ ($isNewArrivals ?? false) ? $translations['products']['new_title'] : $translations['catalog']['heading'] }}</h1>
                <p class="catalog-description">{{ ($isNewArrivals ?? false) ? $translations['catalog']['new_description'] : $translations['catalog']['description'] }}</p>
            </div>

            <div class="catalog-header-stats">
                <div class="catalog-stat-card">
                    <span class="stat-number" id="catalog-header-total">{{ $totalCount ?? count($products) }}</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'មុខទំនិញសរុប' : 'Total Items' }}</span>
                </div>
                <div class="catalog-stat-card">
                    <span class="stat-number text-amber">4.9 ★</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ពិន្ទុគុណភាព' : 'Top Quality' }}</span>
                </div>
                <div class="catalog-stat-card highlight">
                    <span class="stat-badge-icon">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ធានាសុទ្ធ 100%' : '100% Authentic' }}</span>
                </div>
            </div>
        </header>

        {{-- Interactive Filter & Toolbar Control Center --}}
        <section class="catalog-panel" aria-label="Product Catalog">
            {{-- Category Filter Pills with Icons & Live Counts --}}
            <div class="catalog-categories-bar">
                <span class="catalog-filter-title">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                    <span>{{ $translations['products']['filter_label'] }}</span>
                </span>
                
                <div class="category-tabs" role="tablist" aria-label="Filter by Category">
                    {{-- All Categories Tab --}}
                    <button
                        class="category-tab {{ $selectedCategory === 'all' ? 'active' : '' }}"
                        type="button"
                        data-filter="all"
                        role="tab"
                    >
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>{{ $translations['products']['all'] }}</span>
                        <span class="category-pill-count">{{ $totalCount ?? count($products) }}</span>
                    </button>

                    @foreach ($categories as $cat)
                        @php
                            $catCount = $categoryCounts[$cat] ?? 0;
                        @endphp
                        <button
                            class="category-tab {{ $selectedCategory === $cat ? 'active' : '' }}"
                            type="button"
                            data-filter="{{ $cat }}"
                            role="tab"
                        >
                            @if ($cat === 'fashion')
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z"/></svg>
                            @elseif ($cat === 'electronics')
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>
                            @elseif ($cat === 'kitchen')
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                            @elseif ($cat === 'beauty')
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            @endif
                            <span>{{ $translations['categories'][$cat] ?? ucfirst($cat) }}</span>
                            <span class="category-pill-count">{{ $catCount }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Secondary Toolbar: Search, Price Filters, Wishlist, Sort --}}
            <div class="catalog-secondary-toolbar">
                {{-- Quick Filter Chips --}}
                <div class="catalog-quick-filters">
                    {{-- In-catalog Instant Search Input --}}
                    <div class="catalog-search-wrap">
                        <svg class="search-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input
                            type="search"
                            id="catalog-quick-search"
                            placeholder="{{ $locale === 'km' ? 'ស្វែងរកឈ្មោះ ឬប្រភេទ...' : 'Search in products...' }}"
                            aria-label="Filter products"
                        >
                        <button type="button" class="search-clear-btn" id="catalog-search-clear" hidden aria-label="Clear search">&times;</button>
                    </div>

                    {{-- Price Filter Chips --}}
                    <div class="price-chips-group" role="group" aria-label="Price range filter">
                        <button type="button" class="price-chip active" data-price-range="all">
                            {{ $locale === 'km' ? 'តម្លៃទាំងអស់' : 'All Prices' }}
                        </button>
                        <button type="button" class="price-chip" data-price-range="under30">
                            {{ $locale === 'km' ? 'ក្រោម $30' : '< $30' }}
                        </button>
                        <button type="button" class="price-chip" data-price-range="30to60">
                            $30 - $60
                        </button>
                        <button type="button" class="price-chip" data-price-range="over60">
                            {{ $locale === 'km' ? 'លើសពី $60' : '> $60' }}
                        </button>
                    </div>

                    {{-- Discount Only Chip --}}
                    <button type="button" class="discount-chip" id="discount-filter-btn" aria-pressed="false">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82zM7 5a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>
                        <span>{{ $locale === 'km' ? 'បញ្ចុះតម្លៃ' : 'On Sale' }}</span>
                    </button>
                </div>

                {{-- Action Buttons: Wishlist & Sort Dropdown --}}
                <div class="catalog-actions-group">
                    <button
                        class="wishlist-filter-btn wishlist-filter"
                        type="button"
                        aria-pressed="false"
                        data-label-all="{{ $translations['products']['wishlist_all'] }}"
                        data-label-saved="{{ $translations['products']['wishlist_saved'] }}"
                    >
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 8.8c0 5.1-8.8 10-8.8 10s-8.8-4.9-8.8-10a4.6 4.6 0 0 1 8.8-1.9 4.6 4.6 0 0 1 8.8 1.9Z"></path></svg>
                        <span class="wishlist-filter-label">{{ $translations['products']['wishlist_all'] }}</span>
                        <span class="wishlist-count-badge wishlist-count">0</span>
                    </button>

                    <div class="product-sort-wrapper">
                        <svg class="sort-icon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M6 12h12m-9 6h6"/></svg>
                        <select id="product-sort" aria-label="{{ $translations['products']['sort_label'] }}">
                            <option value="featured">{{ $translations['products']['sort_featured'] }}</option>
                            <option value="price-asc">{{ $translations['products']['sort_price_low'] }}</option>
                            <option value="price-desc">{{ $translations['products']['sort_price_high'] }}</option>
                            <option value="rating">{{ $translations['products']['sort_rating'] }}</option>
                        </select>
                        <svg class="sort-arrow" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>

                    {{-- Reset Filters Button (Visible when filters applied) --}}
                    <button type="button" class="reset-filters-btn" id="catalog-reset-filters" hidden>
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 0 1 15-6.7L21 8M21 3v5h-5M21 12a9 9 0 0 1-15 6.7L3 16M3 21v-5h5"/></svg>
                        <span>{{ $locale === 'km' ? 'កំណត់ឡើងវិញ' : 'Reset' }}</span>
                    </button>
                </div>
            </div>

            {{-- Results Counter & Active Filter Pills Strip --}}
            <div class="catalog-meta-strip">
                <div class="catalog-live-count">
                    <span>{{ $locale === 'km' ? 'បង្ហាញ' : 'Showing' }}</span>
                    <strong id="catalog-visible-count">{{ count($products) }}</strong>
                    <span>{{ $locale === 'km' ? 'នៃ' : 'of' }}</span>
                    <span id="catalog-total-indicator">{{ count($products) }}</span>
                    <span>{{ $translations['products']['product_plural'] }}</span>
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="catalog-results">
                <div class="product-grid catalog-grid" data-selected-category="{{ $selectedCategory }}">
                    @foreach ($products as $product)
                        @include('store.partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Empty State (Luxury Design) --}}
                <div class="catalog-empty-state" id="catalog-empty-view" hidden>
                    <div class="empty-icon-wrap">
                        <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            <line x1="8" y1="11" x2="14" y2="11"></line>
                        </svg>
                    </div>
                    <h3>{{ $locale === 'km' ? 'រកមិនឃើញទំនិញដែលត្រូវនឹងការស្វែងរកទេ' : 'No products found matching your filters' }}</h3>
                    <p>{{ $locale === 'km' ? 'សូមសាកល្បងជ្រើសរើសប្រភេទផ្សេង ឬលុបការច្រោះដើម្បីមើលទំនិញទាំងអស់ឡើងវិញ។' : 'Try adjusting your search criteria, price range, or category filter to discover available items.' }}</p>
                    <button type="button" class="btn-clear-filters" id="empty-clear-filters-btn">
                        {{ $locale === 'km' ? 'លុបការច្រោះទាំងអស់ (Clear Filters)' : 'Clear All Filters' }}
                    </button>
                </div>
            </div>
        </section>

        <a class="catalog-back-link" href="{{ route('store.home') }}">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>{{ $translations['catalog']['back_home'] }}</span>
        </a>
    </div>
</div>

{{-- Enhanced Real-time Filter & Sort Controller --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const grid = document.querySelector('.catalog-grid');
    if (!grid) return;

    const cards = [...grid.querySelectorAll('.product-card')];
    const categoryTabs = document.querySelectorAll('.catalog-categories-bar .category-tab');
    const priceChips = document.querySelectorAll('.price-chip');
    const discountChip = document.getElementById('discount-filter-btn');
    const wishlistBtn = document.querySelector('.wishlist-filter-btn');
    const sortSelect = document.getElementById('product-sort');
    const searchInput = document.getElementById('catalog-quick-search');
    const clearSearchBtn = document.getElementById('catalog-search-clear');
    const resetBtn = document.getElementById('catalog-reset-filters');
    const emptyClearBtn = document.getElementById('empty-clear-filters-btn');
    const visibleCountEl = document.getElementById('catalog-visible-count');
    const emptyView = document.getElementById('catalog-empty-view');

    // State
    let currentCategory = '{{ $selectedCategory ?? "all" }}';
    let currentPriceRange = 'all';
    let onlyDiscount = false;
    let onlyWishlist = false;
    let searchQuery = '';
    let currentSort = 'featured';

    function getFavorites() {
        try {
            return new Set(JSON.parse(localStorage.getItem('dara_store_favorites') || '[]'));
        } catch (e) {
            return new Set();
        }
    }

    function updateFilters() {
        const favorites = getFavorites();
        let visibleCount = 0;
        const hasActiveFilters = currentCategory !== 'all' || currentPriceRange !== 'all' || onlyDiscount || onlyWishlist || searchQuery !== '';

        if (resetBtn) resetBtn.hidden = !hasActiveFilters;

        // Sort cards
        cards.sort((a, b) => {
            const pA = parseFloat(a.dataset.price) || 0;
            const pB = parseFloat(b.dataset.price) || 0;
            const rA = parseFloat(a.dataset.rating) || 0;
            const rB = parseFloat(b.dataset.rating) || 0;
            const oA = parseInt(a.dataset.order, 10) || 0;
            const oB = parseInt(b.dataset.order, 10) || 0;

            if (currentSort === 'price-asc') return pA - pB;
            if (currentSort === 'price-desc') return pB - pA;
            if (currentSort === 'rating') return rB - rA;
            return oA - oB;
        });

        cards.forEach(card => {
            const cardCat = card.dataset.category;
            const cardPrice = parseFloat(card.dataset.price) || 0;
            const cardSearch = (card.dataset.search || '').toLowerCase();
            const cardId = card.dataset.productId;
            const isDiscount = card.querySelector('.discount-badge, .pdp-hero-badge.discount') !== null || (card.querySelector('del') !== null);

            let matchCategory = currentCategory === 'all' || cardCat === currentCategory;
            let matchSearch = searchQuery === '' || cardSearch.includes(searchQuery);
            let matchWishlist = !onlyWishlist || favorites.has(cardId);
            let matchDiscount = !onlyDiscount || isDiscount;

            let matchPrice = true;
            if (currentPriceRange === 'under30') matchPrice = cardPrice < 30;
            else if (currentPriceRange === '30to60') matchPrice = cardPrice >= 30 && cardPrice <= 60;
            else if (currentPriceRange === 'over60') matchPrice = cardPrice > 60;

            const isVisible = matchCategory && matchSearch && matchWishlist && matchDiscount && matchPrice;

            if (isVisible) {
                card.style.display = '';
                card.removeAttribute('hidden');
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
                visibleCount++;
            } else {
                card.style.display = 'none';
                card.setAttribute('hidden', '');
            }
            grid.appendChild(card);
        });

        if (visibleCountEl) visibleCountEl.textContent = visibleCount;
        if (emptyView) emptyView.hidden = visibleCount > 0;

        // Update wishlist count in header pill
        if (wishlistBtn) {
            const badge = wishlistBtn.querySelector('.wishlist-count');
            if (badge) badge.textContent = favorites.size;
        }
    }

    // Category click
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            categoryTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.getAttribute('data-filter') || 'all';

            // Update URL without reload
            const url = new URL(window.location.href);
            if (currentCategory === 'all') url.searchParams.delete('category');
            else url.searchParams.set('category', currentCategory);
            window.history.replaceState({}, '', url);

            updateFilters();
        });
    });

    // Price range click
    priceChips.forEach(chip => {
        chip.addEventListener('click', function () {
            priceChips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            currentPriceRange = this.getAttribute('data-price-range') || 'all';
            updateFilters();
        });
    });

    // Discount chip click
    if (discountChip) {
        discountChip.addEventListener('click', function () {
            onlyDiscount = !onlyDiscount;
            this.classList.toggle('active', onlyDiscount);
            this.setAttribute('aria-pressed', String(onlyDiscount));
            updateFilters();
        });
    }

    // Wishlist filter click
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function () {
            onlyWishlist = !onlyWishlist;
            this.classList.toggle('active', onlyWishlist);
            this.setAttribute('aria-pressed', String(onlyWishlist));
            updateFilters();
        });
    }

    // Sort select change
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            currentSort = this.value;
            updateFilters();
        });
    }

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            if (clearSearchBtn) clearSearchBtn.hidden = searchQuery === '';
            updateFilters();
        });
    }

    if (clearSearchBtn && searchInput) {
        clearSearchBtn.addEventListener('click', function () {
            searchInput.value = '';
            searchQuery = '';
            clearSearchBtn.hidden = true;
            updateFilters();
        });
    }

    // Reset filters
    function resetAll() {
        currentCategory = 'all';
        currentPriceRange = 'all';
        onlyDiscount = false;
        onlyWishlist = false;
        searchQuery = '';

        categoryTabs.forEach(t => t.classList.toggle('active', t.getAttribute('data-filter') === 'all'));
        priceChips.forEach(c => c.classList.toggle('active', c.getAttribute('data-price-range') === 'all'));
        if (discountChip) {
            discountChip.classList.remove('active');
            discountChip.setAttribute('aria-pressed', 'false');
        }
        if (wishlistBtn) {
            wishlistBtn.classList.remove('active');
            wishlistBtn.setAttribute('aria-pressed', 'false');
        }
        if (searchInput) searchInput.value = '';
        if (clearSearchBtn) clearSearchBtn.hidden = true;

        const url = new URL(window.location.href);
        url.searchParams.delete('category');
        window.history.replaceState({}, '', url);

        updateFilters();
    }

    if (resetBtn) resetBtn.addEventListener('click', resetAll);
    if (emptyClearBtn) emptyClearBtn.addEventListener('click', resetAll);

    // Initial run
    updateFilters();
});
</script>
@endsection
