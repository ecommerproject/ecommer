@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="admin-products-view">
    <!-- Header with Breadcrumbs & Action Buttons -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">YOUR CATALOG</span>
            <h1>Products <span style="font-size: 16px; font-weight: 600; color: var(--food-muted); vertical-align: middle;">({{ $products->total() }})</span></h1>
            <p>Update product details, control inventory, and manage storefront visibility.</p>
        </div>
        <div class="heading-actions">
            <a href="{{ route('admin.products.export') }}" class="admin-export-button" title="Export product catalog as UTF-8 CSV">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('store.home') }}" target="_blank" class="admin-secondary-button" title="Open Storefront Homepage in new tab">
                <span>View Storefront</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="7" y1="17" x2="17" y2="7"></line>
                    <polyline points="7 7 17 7 17 17"></polyline>
                </svg>
            </a>
            <a class="admin-primary-button" href="{{ route('admin.products.create') }}">
                <span class="btn-plus">＋</span>
                <span>Add product</span>
            </a>
        </div>
    </div>

    <!-- Catalog Quick Stat Cards (Harmonized with Luxury Inventory Style) -->
    <div class="inv-stats-grid products-stats-grid">
        <a href="{{ route('admin.products.index', ['status' => 'all']) }}" class="inv-stat-card card-primary {{ ($filters['status'] ?? 'all') === 'all' ? 'is-selected' : '' }}">
            <div class="inv-stat-icon icon-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
            </div>
            <div class="inv-stat-info">
                <span class="inv-stat-label">Total Catalog • ទំនិញសរុប</span>
                <div class="inv-stat-val-row">
                    <span class="inv-stat-num" id="statCountTotal">{{ $stats['total'] ?? $products->total() }}</span>
                    <span class="inv-stat-badge badge-green">All SKUs</span>
                </div>
                <span class="inv-stat-sub">Total products in store catalog</span>
            </div>
        </a>

        <a href="{{ route('admin.products.index', ['status' => 'active']) }}" class="inv-stat-card card-primary {{ ($filters['status'] ?? '') === 'active' ? 'is-selected' : '' }}">
            <div class="inv-stat-icon icon-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="inv-stat-info">
                <span class="inv-stat-label">Active (Live) • កំពុងដាក់លក់</span>
                <div class="inv-stat-val-row">
                    <span class="inv-stat-num text-success" id="statCountActive">{{ $stats['active'] ?? 0 }}</span>
                    <span class="inv-stat-badge badge-green">Visible</span>
                </div>
                <span class="inv-stat-sub">Live & purchasable on storefront</span>
            </div>
        </a>

        <a href="{{ route('admin.products.index', ['status' => 'hidden']) }}" class="inv-stat-card card-gold {{ ($filters['status'] ?? '') === 'hidden' ? 'is-selected' : '' }}">
            <div class="inv-stat-icon icon-gold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>
            </div>
            <div class="inv-stat-info">
                <span class="inv-stat-label">Hidden / Draft • បានលាក់</span>
                <div class="inv-stat-val-row">
                    <span class="inv-stat-num text-muted" id="statCountHidden">{{ $stats['hidden'] ?? 0 }}</span>
                    <span class="inv-stat-badge {{ ($stats['hidden'] ?? 0) > 0 ? 'badge-alert-amber' : 'badge-green' }}">{{ ($stats['hidden'] ?? 0) > 0 ? 'Draft' : 'None' }}</span>
                </div>
                <span class="inv-stat-sub">Unpublished or hidden items</span>
            </div>
        </a>

        <a href="{{ route('admin.products.index', ['status' => 'new']) }}" class="inv-stat-card card-warning {{ ($filters['status'] ?? '') === 'new' ? 'is-selected' : '' }}">
            <div class="inv-stat-icon icon-warning">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
            <div class="inv-stat-info">
                <span class="inv-stat-label">New Arrivals • ទំនិញទើបមកដល់</span>
                <div class="inv-stat-val-row">
                    <span class="inv-stat-num text-amber" id="statCountNew">{{ $stats['new'] ?? 0 }}</span>
                    <span class="inv-stat-badge badge-alert-amber">Featured</span>
                </div>
                <span class="inv-stat-sub">Marked as new arrivals</span>
            </div>
        </a>
    </div>

    <!-- Main Products Table Card -->
    <section class="admin-panel admin-products-card">
        <!-- Floating / Sticky Bulk Action Toolbar -->
        <div id="bulkToolbar" class="admin-bulk-toolbar">
            <div class="bulk-count-badge">
                <span id="bulkSelectedCount">0</span>
                <span>products selected</span>
            </div>
            <div class="bulk-actions-buttons">
                <button type="button" class="btn-bulk btn-bulk-activate" onclick="executeBulkAction('activate')">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Activate</span>
                </button>
                <button type="button" class="btn-bulk btn-bulk-hide" onclick="executeBulkAction('hide')">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                    <span>Hide</span>
                </button>
                <button type="button" class="btn-bulk btn-bulk-delete" onclick="executeBulkAction('delete')">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path></svg>
                    <span>Delete</span>
                </button>
                <button type="button" class="btn-bulk btn-bulk-cancel" onclick="clearAllSelections()">
                    <span>Cancel</span>
                </button>
            </div>
        </div>

        <!-- Filter and Search Bar -->
        <form class="admin-filter-bar modern-filter-bar" action="{{ route('admin.products.index') }}" method="GET">
            <div class="search-input-group">
                <svg class="search-field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <label class="sr-only" for="product-search-input">Search products</label>
                <input id="product-search-input" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search products by name, Khmer name, or SKU...">
            </div>

            <div class="filter-controls-row">
                <div class="filter-select-wrapper">
                    <label class="filter-label">Category</label>
                    <select name="category" onchange="this.form.submit()">
                        <option value="all">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(($filters['category'] ?? 'all') === $category)>{{ __('store.categories.'.$category, [], 'en') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-select-wrapper">
                    <label class="filter-label">Visibility</label>
                    <select name="status" onchange="this.form.submit()">
                        <option value="all" @selected(($filters['status'] ?? 'all') === 'all')>All status</option>
                        <option value="active" @selected(($filters['status'] ?? 'all') === 'active')>Visible only</option>
                        <option value="hidden" @selected(($filters['status'] ?? 'all') === 'hidden')>Hidden only</option>
                        <option value="new" @selected(($filters['status'] ?? 'all') === 'new')>New arrivals</option>
                    </select>
                </div>

                <button class="admin-primary-button filter-submit-btn" type="submit">Apply filters</button>
                @if (($filters['q'] ?? '') !== '' || ($filters['category'] ?? 'all') !== 'all' || ($filters['status'] ?? 'all') !== 'all')
                    <a class="admin-secondary-button filter-clear-btn" href="{{ route('admin.products.index') }}">Clear</a>
                @endif
            </div>
        </form>

        <!-- Products Table -->
        <div class="admin-table-wrap">
            <table class="admin-table modern-products-table">
                <thead>
                    <tr>
                        <th class="col-check">
                            <input type="checkbox" id="selectAllCheckbox" class="custom-checkbox" title="Select all products" onchange="toggleSelectAll(this)">
                        </th>
                        <th style="min-width: 240px;">Product</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>New Arrival</th>
                        <th>Order</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr id="productRow-{{ $product->id }}" class="product-row {{ ! $product->is_active ? 'is-row-dimmed' : '' }}">
                            <td class="col-check">
                                <input type="checkbox" class="custom-checkbox row-checkbox" value="{{ $product->id }}" onchange="onRowCheckboxChange()">
                            </td>
                            <td>
                                <div class="admin-product-cell">
                                    <div class="product-thumb-wrap" onclick="previewImage('{{ $product->image_url }}', '{{ addslashes($product->name_en) }}')" title="Click to zoom image">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name_en }}" loading="lazy" onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'50\' height=\'50\' viewBox=\'0 0 50 50\'><rect width=\'50\' height=\'50\' fill=\'%23f3f4f6\'/><text x=\'25\' y=\'30\' font-size=\'18\' text-anchor=\'middle\'>🛍️</text></svg>';">
                                        @if ($product->badge)
                                            @php($isBadgeDiscount = str_contains($product->badge, '%') || str_contains($product->badge, '-') || str_contains($product->badge, '⚡'))
                                            <span class="thumb-badge {{ $isBadgeDiscount ? 'badge-discount-red' : '' }}">{{ $product->badge }}</span>
                                        @endif
                                    </div>
                                    <div class="product-info-text">
                                        <div class="product-title-line">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="product-name-en" title="Edit this product">{{ $product->name_en }}</a>
                                            <span class="product-sku-pill">{{ $product->sku }}</span>
                                            <a href="{{ route('store.products.show', $product) }}" target="_blank" class="product-live-link" title="Open product in Storefront ↗">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2">
                                                    <line x1="7" y1="17" x2="17" y2="7"></line>
                                                    <polyline points="7 7 17 7 17 17"></polyline>
                                                </svg>
                                            </a>
                                        </div>
                                        <span class="product-name-km">{{ $product->name_km }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="category-tag category-{{ $product->category }}">
                                    {{ __('store.categories.'.$product->category, [], 'en') }}
                                </span>
                            </td>
                            <td>
                                @if (($product->stock ?? 45) <= 0)
                                    <span class="stock-tag stock-tag-out">✕ Out</span>
                                @elseif (($product->stock ?? 45) <= 10)
                                    <span class="stock-tag stock-tag-low">⚠ {{ $product->stock ?? 10 }} left</span>
                                @else
                                    <span class="stock-tag stock-tag-in">✓ {{ $product->stock ?? 45 }} in stock</span>
                                @endif
                            </td>
                            <td>
                                <div class="price-cell">
                                    <span class="price-current">${{ number_format((float) $product->price, 2) }}</span>
                                    @if ($product->old_price && $product->old_price > $product->price)
                                        <span class="price-original">${{ number_format((float) $product->old_price, 2) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="rating-cell">
                                    <span class="star-icon">★</span>
                                    <span class="rating-num">{{ number_format((float) $product->rating, 1) }}</span>
                                </div>
                            </td>
                            <td>
                                <button type="button" 
                                        id="statusToggleBtn-{{ $product->id }}"
                                        onclick="toggleProductStatus({{ $product->id }}, this)" 
                                        class="status-toggle-pill {{ $product->is_active ? 'is-active' : 'is-hidden' }}" 
                                        title="Click to instantly toggle visibility on storefront">
                                    <span class="status-dot"></span>
                                    <span class="status-text">{{ $product->is_active ? 'Active' : 'Hidden' }}</span>
                                </button>
                            </td>
                            <td>
                                <button type="button" 
                                        id="newToggleBtn-{{ $product->id }}"
                                        onclick="toggleProductNew({{ $product->id }}, this)" 
                                        class="new-toggle-btn {{ $product->is_new ? 'is-featured' : 'is-standard' }}" 
                                        title="Click to toggle New Arrival tag">
                                    @if ($product->is_new)
                                        <span class="new-arrival-pill">✦ New arrival</span>
                                    @else
                                        <span class="standard-pill">Featured</span>
                                    @endif
                                </button>
                            </td>
                            <td>
                                <span class="sort-order-badge">#{{ $product->sort_order }}</span>
                            </td>
                            <td style="text-align: right;">
                                <div class="admin-row-actions">
                                    <a class="action-btn-edit" href="{{ route('admin.products.edit', $product) }}" title="Edit Product">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <button type="button" class="action-btn-copy" onclick="cloneProduct({{ $product->id }}, '{{ addslashes($product->name_en) }}')" title="Duplicate product">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                        <span>Clone</span>
                                    </button>

                                    <a href="{{ route('store.products.show', $product) }}" target="_blank" class="action-btn-store" title="Preview on live Storefront">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product: {{ addslashes($product->name_en) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-btn-delete" type="submit" title="Delete Product">
                                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="admin-empty-state">
                                <div class="empty-state-wrap">
                                    <div class="empty-icon">📦</div>
                                    <h3>No products found</h3>
                                    <p>We couldn't find any products matching your search criteria.</p>
                                    <div class="empty-actions">
                                        <a href="{{ route('admin.products.create') }}" class="admin-primary-button">＋ Add your first product</a>
                                        <a href="{{ route('admin.products.index') }}" class="admin-secondary-button">Reset filters</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="admin-pagination-footer">
                <span class="pagination-summary">
                    Showing <strong>{{ $products->firstItem() ?? 0 }}</strong> to <strong>{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> products
                </span>
                <div class="pagination-links">
                    {{ $products->links('admin.partials.pagination') }}
                </div>
            </div>
        @endif
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

<!-- Floating Toast Container -->
<div id="adminToastContainer" class="admin-toast-container"></div>

<!-- Interactive Client-side Script -->
<script>
const csrfToken = '{{ csrf_token() }}';

// 1. Instant Status Toggle (Active / Hidden)
async function toggleProductStatus(id, btn) {
    btn.disabled = true;
    btn.style.opacity = '0.6';

    try {
        const response = await fetch(`/admin/products/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();
        if (data.success) {
            const isNowActive = data.is_active;
            btn.classList.toggle('is-active', isNowActive);
            btn.classList.toggle('is-hidden', !isNowActive);
            btn.querySelector('.status-text').textContent = isNowActive ? 'Active' : 'Hidden';

            const row = document.getElementById(`productRow-${id}`);
            if (row) {
                row.classList.toggle('is-row-dimmed', !isNowActive);
            }

            if (data.stats) {
                updateStats(data.stats);
            }

            showToast(data.message, isNowActive ? '✓' : '👁️');
        }
    } catch (err) {
        console.error(err);
        showToast('Error updating product status', '⚠️');
    } finally {
        btn.disabled = false;
        btn.style.opacity = '1';
    }
}

// 2. Instant New Arrival Toggle
async function toggleProductNew(id, btn) {
    btn.disabled = true;
    btn.style.opacity = '0.6';

    try {
        const response = await fetch(`/admin/products/${id}/toggle-new`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();
        if (data.success) {
            const isNew = data.is_new;
            btn.innerHTML = isNew 
                ? '<span class="new-arrival-pill">✦ New arrival</span>' 
                : '<span class="standard-pill">Featured</span>';

            if (data.stats) {
                updateStats(data.stats);
            }

            showToast(data.message, '✦');
        }
    } catch (err) {
        console.error(err);
        showToast('Error updating new arrival tag', '⚠️');
    } finally {
        btn.disabled = false;
        btn.style.opacity = '1';
    }
}

// 3. Clone Product via AJAX
async function cloneProduct(id, name) {
    if (!confirm(`Duplicate product "${name}"?`)) return;

    try {
        const response = await fetch(`/admin/products/${id}/duplicate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();
        if (data.success) {
            showToast(data.message, '📋');
            setTimeout(() => window.location.reload(), 800);
        }
    } catch (err) {
        // Fallback to standard form submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/products/${id}/duplicate`;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// 4. Update Top Stat Cards
function updateStats(stats) {
    if (stats.total !== undefined) document.getElementById('statCountTotal').textContent = stats.total;
    if (stats.active !== undefined) document.getElementById('statCountActive').textContent = stats.active;
    if (stats.hidden !== undefined) document.getElementById('statCountHidden').textContent = stats.hidden;
    if (stats.new !== undefined) document.getElementById('statCountNew').textContent = stats.new;
}

// 5. Bulk Selection & Actions
function toggleSelectAll(master) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = master.checked;
        const row = document.getElementById(`productRow-${cb.value}`);
        if (row) row.classList.toggle('is-selected-row', cb.checked);
    });
    updateBulkToolbar();
}

function onRowCheckboxChange() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
    const master = document.getElementById('selectAllCheckbox');
    
    if (master) {
        master.checked = checkedCount === checkboxes.length && checkboxes.length > 0;
        master.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
    }

    checkboxes.forEach(cb => {
        const row = document.getElementById(`productRow-${cb.value}`);
        if (row) row.classList.toggle('is-selected-row', cb.checked);
    });

    updateBulkToolbar();
}

function updateBulkToolbar() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const toolbar = document.getElementById('bulkToolbar');
    const countBadge = document.getElementById('bulkSelectedCount');

    if (checkedBoxes.length > 0) {
        countBadge.textContent = checkedBoxes.length;
        toolbar.classList.add('is-visible');
    } else {
        toolbar.classList.remove('is-visible');
    }
}

function clearAllSelections() {
    document.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.checked = false;
        const row = document.getElementById(`productRow-${cb.value}`);
        if (row) row.classList.remove('is-selected-row');
    });
    const master = document.getElementById('selectAllCheckbox');
    if (master) {
        master.checked = false;
        master.indeterminate = false;
    }
    updateBulkToolbar();
}

async function executeBulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => parseInt(cb.value));
    if (selectedIds.length === 0) return;

    if (action === 'delete') {
        if (!confirm(`Are you sure you want to delete ${selectedIds.length} selected products? This action cannot be undone.`)) {
            return;
        }
    }

    try {
        const response = await fetch('/admin/products/bulk-action', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: action,
                ids: selectedIds
            })
        });

        const data = await response.json();
        if (data.success) {
            showToast(data.message, '✓');
            setTimeout(() => window.location.reload(), 600);
        }
    } catch (err) {
        console.error(err);
        showToast('Bulk action failed', '⚠️');
    }
}

// 6. Image Lightbox Modal
function previewImage(src, title) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxTitle').textContent = title;
    const modal = document.getElementById('imageLightboxModal');
    modal.style.display = 'flex';
}

function closeImageLightbox() {
    document.getElementById('imageLightboxModal').style.display = 'none';
}

// 7. Toast Notification Utility
function showToast(message, icon = '✓') {
    const container = document.getElementById('adminToastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = 'admin-toast';
    toast.innerHTML = `<span class="admin-toast-icon">${icon}</span><span>${message}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(8px)';
        setTimeout(() => toast.remove(), 300);
    }, 3200);
}
</script>
@endsection
