@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="admin-categories-view">
    <!-- Header with Action Buttons -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">STORE TAXONOMY & INVENTORY</span>
            <h1>Categories <span style="font-size: 16px; font-weight: 600; color: var(--food-muted); vertical-align: middle;">({{ $categories->count() }} departments)</span></h1>
            <p>Manage product classifications, monitor inventory distribution, and organize store departments.</p>
        </div>
        <div class="heading-actions">
            <a href="{{ route('admin.categories.export') }}" class="admin-export-button" title="Export categories distribution as UTF-8 CSV">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('store.categories') }}" target="_blank" class="admin-secondary-button" title="Open Storefront Categories page in new tab">
                <span>View Storefront</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="7" y1="17" x2="17" y2="7"></line>
                    <polyline points="7 7 17 7 17 17"></polyline>
                </svg>
            </a>
            <a class="admin-primary-button" href="{{ route('admin.products.create') }}">
                <span class="btn-plus">＋</span>
                <span>Add Product</span>
            </a>
        </div>
    </div>

    <!-- Category Stats Overview Cards -->
    <div class="categories-stats-grid">
        <div class="stat-pill-card">
            <div class="stat-pill-icon icon-all">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                </svg>
            </div>
            <div class="stat-pill-info">
                <span class="stat-pill-label">Total Categories</span>
                <span class="stat-pill-num">{{ $stats['total_categories'] }}</span>
            </div>
        </div>

        <div class="stat-pill-card">
            <div class="stat-pill-icon icon-active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
            </div>
            <div class="stat-pill-info">
                <span class="stat-pill-label">Total Items</span>
                <span class="stat-pill-num text-success">{{ $stats['total_products'] }}</span>
            </div>
        </div>

        <div class="stat-pill-card">
            <div class="stat-pill-icon icon-new">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
            </div>
            <div class="stat-pill-info">
                <span class="stat-pill-label">Live In Store</span>
                <span class="stat-pill-num text-amber" style="display: flex; align-items: center; gap: 6px;">
                    <span>{{ $stats['active_products'] }}</span>
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block; box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);"></span>
                </span>
            </div>
        </div>

        <div class="stat-pill-card">
            <div class="stat-pill-icon icon-hidden">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
            <div class="stat-pill-info">
                <span class="stat-pill-label">Top Department</span>
                <span class="stat-pill-num text-muted" style="font-size: 15px; margin-top: 4px; font-weight: 700; color: var(--food-ink);">{{ $stats['top_category'] }}</span>
            </div>
        </div>
    </div>

    <!-- Interactive Department Distribution Bar -->
    <div class="category-distribution-card">
        <div class="distribution-head">
            <h3 class="distribution-title">
                <span>📊 Department Catalog Balance</span>
                <small style="color: var(--food-muted); font-size: 11px; font-weight: 500;">(Click any segment to jump to that category)</small>
            </h3>
            <span style="font-size: 12px; font-weight: 700; color: var(--food-primary);">{{ $stats['total_products'] }} Total Products</span>
        </div>

        <!-- Stacked Horizontal Bar -->
        <div class="distribution-bar-track">
            @foreach ($categories as $cat)
                @if ($cat['percentage'] > 0)
                    <div class="distribution-segment" 
                         style="width: {{ $cat['percentage'] }}%; background: {{ $cat['color'] }};" 
                         title="{{ $cat['name_en'] }}: {{ $cat['total_products'] }} items ({{ $cat['percentage'] }}%)"
                         onclick="focusCategoryCard('{{ $cat['key'] }}')"></div>
                @endif
            @endforeach
        </div>

        <!-- Legend Chips -->
        <div class="distribution-legend">
            @foreach ($categories as $cat)
                <div class="legend-chip" onclick="focusCategoryCard('{{ $cat['key'] }}')">
                    <span class="legend-dot" style="background: {{ $cat['color'] }};"></span>
                    <span>{{ $cat['name_en'] }}</span>
                    <strong style="color: {{ $cat['color'] }}; font-size: 11px;">{{ $cat['percentage'] }}% ({{ $cat['total_products'] }})</strong>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Live Category Search & Filter Bar -->
    <div class="category-search-filter">
        <div class="cat-search-box">
            <svg class="search-field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="search" id="categorySearchInput" placeholder="Filter categories or departments in real-time..." oninput="filterCategories()">
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <button type="button" class="admin-secondary-button" onclick="resetCategoryFilter()" style="padding: 6px 12px; font-size: 11.5px;">Show All</button>
            <a href="{{ route('admin.products.index') }}" class="admin-primary-button" style="padding: 6px 14px; font-size: 11.5px;">View Full Catalog</a>
        </div>
    </div>

    <!-- Category Cards Showcase Grid -->
    <div class="category-cards-grid" id="categoryCardsGrid">
        @foreach ($categories as $cat)
            <div class="category-card" id="catCard-{{ $cat['key'] }}" data-name="{{ strtolower($cat['name_en'].' '.$cat['name_km']) }}">
                <div class="category-card-top">
                    <div class="category-brand-badge" style="background: {{ $cat['bg'] }}; color: {{ $cat['color'] }};">
                        @if ($cat['key'] === 'electronics')
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                                <rect x="9" y="9" width="6" height="6"></rect>
                                <line x1="9" y1="1" x2="9" y2="4"></line>
                                <line x1="15" y1="1" x2="15" y2="4"></line>
                                <line x1="9" y1="20" x2="9" y2="23"></line>
                                <line x1="15" y1="20" x2="15" y2="23"></line>
                                <line x1="20" y1="9" x2="23" y2="9"></line>
                                <line x1="20" y1="14" x2="23" y2="14"></line>
                                <line x1="1" y1="9" x2="4" y2="9"></line>
                                <line x1="1" y1="14" x2="4" y2="14"></line>
                            </svg>
                        @elseif ($cat['key'] === 'fashion')
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        @elseif ($cat['key'] === 'kitchen')
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                                <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                                <line x1="6" y1="1" x2="6" y2="4"></line>
                                <line x1="10" y1="1" x2="10" y2="4"></line>
                                <line x1="14" y1="1" x2="14" y2="4"></line>
                            </svg>
                        @else
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                        @endif
                    </div>
                    <div class="category-header-titles">
                        <h3 class="cat-name-en">{{ $cat['name_en'] }}</h3>
                        <span class="cat-name-km">{{ $cat['name_km'] }}</span>
                    </div>
                    <span class="cat-count-pill" style="background: {{ $cat['bg'] }}; color: {{ $cat['color'] }};">
                        {{ $cat['total_products'] }} {{ Str::plural('item', $cat['total_products']) }}
                    </span>
                </div>

                <!-- Internal Progress proportion -->
                <div class="cat-progress-container">
                    <div class="cat-progress-header">
                        <span>Share of Catalog</span>
                        <span>{{ $cat['percentage'] }}%</span>
                    </div>
                    <div class="cat-progress-track">
                        <div class="cat-progress-fill" style="width: {{ $cat['percentage'] }}%; background: {{ $cat['color'] }};"></div>
                    </div>
                </div>

                <p class="category-desc">{{ $cat['description_en'] }}</p>

                <!-- Metric mini cards -->
                <div class="category-metrics-mini">
                    <div class="mini-metric">
                        <span class="mini-label">Active / Live</span>
                        <strong class="mini-val text-success" style="display: flex; align-items: center; gap: 4px;">
                            <span>{{ $cat['active_products'] }}</span>
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                        </strong>
                    </div>
                    <div class="mini-metric">
                        <span class="mini-label">Price Range</span>
                        <strong class="mini-val">${{ number_format($cat['min_price'], 2) }} – ${{ number_format($cat['max_price'], 2) }}</strong>
                    </div>
                    <div class="mini-metric">
                        <span class="mini-label">Avg Rating</span>
                        <strong class="mini-val text-amber">★ {{ number_format($cat['avg_rating'], 1) }}</strong>
                    </div>
                </div>

                <!-- Product thumbnails preview -->
                <div class="category-thumbs-row">
                    <span class="thumbs-title">Sample Products:</span>
                    <div class="thumbs-list">
                        @forelse ($cat['sample_products'] as $item)
                            <div class="cat-thumb-link" 
                                 onclick="previewImage('{{ $item->image_url }}', '{{ addslashes($item->name_en) }} - ${{ number_format((float)$item->price, 2) }}')" 
                                 title="{{ $item->name_en }} (${{ number_format((float)$item->price, 2) }}) - Click to zoom">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name_en }}" loading="lazy" onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\' viewBox=\'0 0 40 40\'><rect width=\'40\' height=\'40\' fill=\'%23edf5ed\'/><text x=\'20\' y=\'25\' font-size=\'14\' text-anchor=\'middle\'>🛍️</text></svg>';">
                            </div>
                        @empty
                            <span class="no-thumbs-notice">No products in this category yet.</span>
                        @endforelse
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="category-card-actions">
                    <a href="{{ route('admin.products.index', ['category' => $cat['key']]) }}" class="cat-btn-browse">
                        <span>Browse Products ({{ $cat['total_products'] }})</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                    <div class="cat-action-group-right">
                        <a href="{{ route('store.products', ['category' => $cat['key']]) }}" target="_blank" class="cat-btn-store" title="Open {{ $cat['name_en'] }} in Live Customer Storefront ↗">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                        </a>
                        <a href="{{ route('admin.products.create', ['category' => $cat['key']]) }}" class="cat-btn-add" title="Add new product to {{ $cat['name_en'] }}">
                            <span>＋ Add Item</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick Overview Table Section -->
    <section class="admin-panel admin-categories-table-panel">
        <div class="table-panel-header">
            <div>
                <h3>All Store Categories Summary</h3>
                <p>Quick tabular view of catalog distribution across departments.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="admin-secondary-button">View All Products →</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table modern-products-table" id="categoriesSummaryTable">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Khmer Name</th>
                        <th>Total Items</th>
                        <th>Share</th>
                        <th>Live In Store</th>
                        <th>Draft / Hidden</th>
                        <th>Avg Rating</th>
                        <th>Price Range</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $cat)
                        <tr class="cat-table-row" data-name="{{ strtolower($cat['name_en'].' '.$cat['name_km']) }}">
                            <td>
                                <div class="admin-cat-cell" style="display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $cat['color'] }}; display: inline-block;"></span>
                                    <span class="category-tag category-{{ $cat['key'] }}">
                                        {{ $cat['name_en'] }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="cat-name-km">{{ $cat['name_km'] }}</span>
                            </td>
                            <td>
                                <strong>{{ $cat['total_products'] }}</strong>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: {{ $cat['color'] }}; font-size: 11.5px;">{{ $cat['percentage'] }}%</span>
                            </td>
                            <td>
                                <span class="status-toggle-pill is-active" style="cursor: default;">
                                    <span class="status-dot"></span>
                                    <span>{{ $cat['active_products'] }} Live</span>
                                </span>
                            </td>
                            <td>
                                <span class="status-toggle-pill is-hidden" style="cursor: default;">
                                    <span class="status-dot"></span>
                                    <span>{{ $cat['hidden_products'] }} Hidden</span>
                                </span>
                            </td>
                            <td>
                                <div class="rating-cell">
                                    <span class="star-icon">★</span>
                                    <span class="rating-num">{{ number_format($cat['avg_rating'], 1) }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="price-current">${{ number_format($cat['min_price'], 2) }} – ${{ number_format($cat['max_price'], 2) }}</span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                    <a href="{{ route('admin.products.index', ['category' => $cat['key']]) }}" class="action-btn-edit" title="Manage products in {{ $cat['name_en'] }}">
                                        <span>Manage</span>
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </a>
                                    <a href="{{ route('store.products', ['category' => $cat['key']]) }}" target="_blank" class="action-btn-store" title="View {{ $cat['name_en'] }} on Storefront ↗">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>

<!-- Image Lightbox Modal -->
<div id="imageLightboxModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); backdrop-filter: blur(4px); z-index: 10000; align-items: center; justify-content: center; cursor: pointer;" onclick="closeImageLightbox()">
    <div style="background: #ffffff; border-radius: 16px; padding: 16px; max-width: 480px; width: 90%; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.3); position: relative;" onclick="event.stopPropagation()">
        <img id="lightboxImg" src="" alt="Product" style="width: 100%; height: 320px; object-fit: cover; border-radius: 12px; background: #f3f4f6;">
        <h4 id="lightboxTitle" style="margin: 12px 0 4px; font-size: 15px; font-weight: 700; color: var(--food-ink);"></h4>
        <button type="button" onclick="closeImageLightbox()" style="margin-top: 10px; background: var(--food-primary); color: #fff; border: none; padding: 7px 18px; border-radius: 8px; font-weight: 700; cursor: pointer;">Close Preview</button>
    </div>
</div>

<script>
// 1. Focus & Highlight Category Card from Distribution Bar or Legend
function focusCategoryCard(key) {
    const card = document.getElementById('catCard-' + key);
    if (!card) return;

    // Remove previous highlights
    document.querySelectorAll('.category-card').forEach(c => c.classList.remove('is-highlighted'));
    
    // Add highlight class
    card.classList.add('is-highlighted');

    // Smooth scroll to card
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });

    // Auto remove highlight after 3.5 seconds
    setTimeout(() => {
        card.classList.remove('is-highlighted');
    }, 3500);
}

// 2. Client-side Real-time Category Search
function filterCategories() {
    const query = document.getElementById('categorySearchInput').value.toLowerCase().trim();
    
    // Filter Category Cards
    document.querySelectorAll('.category-card').forEach(card => {
        const name = card.getAttribute('data-name') || '';
        card.style.display = (query === '' || name.includes(query)) ? 'flex' : 'none';
    });

    // Filter Table Rows
    document.querySelectorAll('.cat-table-row').forEach(row => {
        const name = row.getAttribute('data-name') || '';
        row.style.display = (query === '' || name.includes(query)) ? '' : 'none';
    });
}

function resetCategoryFilter() {
    document.getElementById('categorySearchInput').value = '';
    filterCategories();
}

// 3. Image Lightbox
function previewImage(src, title) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxTitle').textContent = title;
    const modal = document.getElementById('imageLightboxModal');
    modal.style.display = 'flex';
}

function closeImageLightbox() {
    document.getElementById('imageLightboxModal').style.display = 'none';
}
</script>
@endsection
