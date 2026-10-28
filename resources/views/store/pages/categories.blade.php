@extends('store.layouts.app')

@section('title', $translations['category_page']['title'])

@section('content')
<div class="category-page">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="catalog-breadcrumb" aria-label="{{ $translations['catalog']['breadcrumb_label'] }}">
            <a href="{{ route('store.home') }}">{{ $translations['nav']['home'] }}</a>
            <span class="catalog-breadcrumb-sep">/</span>
            <span aria-current="page">{{ $translations['nav']['categories'] }}</span>
        </nav>

        {{-- Luxury Emerald Header --}}
        <header class="catalog-luxury-header category-luxury-header">
            <div class="catalog-header-glow"></div>
            <div class="catalog-header-content">
                <span class="catalog-kicker-badge">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                    <span>{{ $translations['category_page']['eyebrow'] }}</span>
                </span>
                <h1 class="catalog-title">{{ $translations['category_page']['heading'] }}</h1>
                <p class="catalog-description">{{ $translations['category_page']['description'] }}</p>
            </div>

            <div class="catalog-header-stats">
                <div class="catalog-stat-card">
                    <span class="stat-number">{{ $totalCategories ?? count($categories) }}</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ប្រភេទទំនិញធំៗ' : 'Categories' }}</span>
                </div>
                <div class="catalog-stat-card">
                    <span class="stat-number text-amber">{{ $totalProducts ?? 22 }}</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'មុខទំនិញសរុប' : 'Total Products' }}</span>
                </div>
                <div class="catalog-stat-card highlight">
                    <span class="stat-badge-icon">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ធានាសុទ្ធ 100%' : '100% Authentic' }}</span>
                </div>
            </div>
        </header>

        {{-- Interactive Search Filter for Categories --}}
        <div class="category-toolbar-strip">
            <div class="category-search-box">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input
                    type="search"
                    id="category-search-input"
                    placeholder="{{ $locale === 'km' ? 'ស្វែងរកឈ្មោះប្រភេទទំនិញ ឬស្លាក...' : 'Search categories or tags...' }}"
                    aria-label="Search categories"
                >
            </div>
            <div class="category-filter-tags">
                <button type="button" class="cat-filter-chip active" data-cat-filter="all">{{ $locale === 'km' ? 'ទាំងអស់' : 'All' }}</button>
                @foreach ($categories as $cat)
                    <button type="button" class="cat-filter-chip" data-cat-filter="{{ $cat['key'] }}">
                        {{ $translations['categories'][$cat['key']] ?? ucfirst($cat['key']) }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Luxury Category Cards Grid --}}
        <section class="category-showcase-grid" id="category-cards-container" aria-label="{{ $translations['nav']['categories'] }}">
            @foreach ($categories as $cat)
                <article class="cat-showcase-card" data-cat-key="{{ $cat['key'] }}">
                    {{-- Media Cover with Gradient & Badges --}}
                    <a href="{{ route('store.products', ['category' => $cat['key']]) }}" class="cat-media-wrap">
                        <img
                            src="{{ $cat['image'] }}"
                            alt="{{ $translations['categories'][$cat['key']] }}"
                            class="cat-media-img"
                            loading="lazy"
                        >
                        <div class="cat-media-overlay"></div>

                        @if (!empty($cat['badge']))
                            <span class="cat-badge-pill">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                                <span>{{ $cat['badge'] }}</span>
                            </span>
                        @endif

                        <div class="cat-media-bottom">
                            <span class="cat-count-badge">
                                {{ $cat['count'] }} {{ $translations['products']['product_plural'] }}
                            </span>
                            @if ($cat['min_price'] > 0)
                                <span class="cat-price-from">
                                    {{ $locale === 'km' ? 'ចាប់ពី' : 'From' }} ${{ number_format($cat['min_price'], 2) }}
                                </span>
                            @endif
                        </div>
                    </a>

                    {{-- Content Section --}}
                    <div class="cat-content-wrap">
                        <div class="cat-header-row">
                            <div class="cat-icon-badge">
                                @if ($cat['key'] === 'perfumes')
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M8 6h8M9 10h6l2 11H7l2-11zM12 14v4"></path></svg>
                                @elseif ($cat['key'] === 'phones')
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                                @elseif ($cat['key'] === 'computers')
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                                @elseif ($cat['key'] === 'fashion')
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                @elseif ($cat['key'] === 'beauty')
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3Z"></path></svg>
                                @else
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                                @endif
                            </div>
                            <div class="cat-titles">
                                <span class="cat-eyebrow">{{ $translations['category_page']['collection'] }}</span>
                                <h2 class="cat-main-title">
                                    <a href="{{ route('store.products', ['category' => $cat['key']]) }}">
                                        {{ $translations['categories'][$cat['key']] ?? ucfirst($cat['key']) }}
                                    </a>
                                </h2>
                            </div>
                        </div>

                        <p class="cat-description">{{ $cat['description'] }}</p>

                        {{-- Sub-category Tag Chips (Direct links into category filter) --}}
                        @if (!empty($cat['tags']))
                            <div class="cat-tags-row">
                                @foreach ($cat['tags'] as $tag)
                                    <a href="{{ route('store.products', ['category' => $cat['key'], 'q' => $tag]) }}" class="cat-subtag">
                                        {{ $tag }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        {{-- Miniature Preview Thumbnails of Products in this Category --}}
                        @if (!empty($cat['thumbnails']) && count($cat['thumbnails']) > 0)
                            <div class="cat-preview-strip">
                                <span class="cat-preview-label">{{ $locale === 'km' ? 'ទំនិញពេញនិយម:' : 'Popular items:' }}</span>
                                <div class="cat-thumbnails-group">
                                    @foreach ($cat['thumbnails'] as $tIndex => $thumbUrl)
                                        <div class="cat-mini-thumb" title="{{ $cat['product_name'] }}">
                                            <img src="{{ $thumbUrl }}" alt="Preview {{ $tIndex + 1 }}" loading="lazy">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Footer CTA Link --}}
                        <div class="cat-footer-action">
                            <a href="{{ route('store.products', ['category' => $cat['key']]) }}" class="cat-explore-btn">
                                <span>{{ $translations['category_page']['browse'] }} {{ $translations['categories'][$cat['key']] }}</span>
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <a class="catalog-back-link" href="{{ route('store.home') }}">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>{{ $translations['catalog']['back_home'] }}</span>
        </a>
    </div>
</div>

{{-- Interactive Category Filter Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.cat-showcase-card');
    const searchInput = document.getElementById('category-search-input');
    const filterChips = document.querySelectorAll('.cat-filter-chip');

    let activeFilter = 'all';
    let searchQuery = '';

    function filterCards() {
        cards.forEach(card => {
            const key = card.getAttribute('data-cat-key');
            const text = card.textContent.toLowerCase();

            const matchCategory = activeFilter === 'all' || key === activeFilter;
            const matchSearch = searchQuery === '' || text.includes(searchQuery);

            if (matchCategory && matchSearch) {
                card.style.display = '';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            } else {
                card.style.display = 'none';
            }
        });
    }

    filterChips.forEach(chip => {
        chip.addEventListener('click', function () {
            filterChips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.getAttribute('data-cat-filter');
            filterCards();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            filterCards();
        });
    }
});
</script>
@endsection
