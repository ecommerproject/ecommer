@extends('admin.layouts.app')

@section('title', 'Inventory Management | Dara Market')

@section('content')
<div class="admin-inventory-view">
    <!-- Header with Action Buttons -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">STOCK CONTROL & WAREHOUSE • គ្រប់គ្រងស្តុកទំនិញ</span>
            <h1>Inventory Management</h1>
            <p>Monitor live warehouse inventory levels, adjust stock quantities with 0ms latency, and track overall stock valuation.</p>
        </div>
        <div class="heading-actions customers-head-actions">
            <a href="{{ route('admin.inventory.export') }}" class="cust-btn-export" title="Export inventory report as UTF-8 CSV">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export CSV</span>
            </a>
            <a class="cust-btn-add" href="{{ route('admin.products.create') }}">
                <span style="font-size: 16px; line-height: 1;">＋</span>
                <span>Add Product</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="admin-secondary-button">
                <span>View Products</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
    </div>

    <!-- Luxury Inventory KPI Cards -->
    <div class="inv-stats-grid">
        <div class="inv-stat-card card-primary" onclick="switchInventoryTab('all', document.getElementById('tab-btn-all'))">
            <div class="inv-stat-icon icon-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <div class="inv-stat-info">
                <span class="inv-stat-label">Total Units in Stock • ស្តុកសរុប</span>
                <div class="inv-stat-val-row">
                    <span class="inv-stat-num" id="stat-total-units">{{ number_format($stats['total_units']) }}</span>
                    <span class="inv-stat-badge badge-green">{{ $stats['total_products'] }} SKUs</span>
                </div>
                <span class="inv-stat-sub">Across all warehouse categories</span>
            </div>
        </div>

        <div class="inv-stat-card card-gold">
            <div class="inv-stat-icon icon-gold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
            <div class="inv-stat-info">
                <span class="inv-stat-label">Stock Valuation • តម្លៃស្តុកសរុប</span>
                <div class="inv-stat-val-row">
                    <span class="inv-stat-num text-success" id="stat-total-val">${{ number_format($stats['total_valuation'], 2) }}</span>
                </div>
                <span class="inv-stat-sub">Retail value of warehouse goods</span>
            </div>
        </div>

        <div class="inv-stat-card card-warning" onclick="switchInventoryTab('low_stock', document.getElementById('tab-btn-low'))">
            <div class="inv-stat-icon icon-warning">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <div class="inv-stat-info">
                <span class="inv-stat-label">Low Stock Alerts • ជិតអស់ពីស្តុក</span>
                <div class="inv-stat-val-row">
                    <span class="inv-stat-num text-amber" id="stat-low-stock">{{ $stats['low_stock_count'] }}</span>
                    @if ($stats['low_stock_count'] > 0)
                        <span class="inv-stat-badge badge-alert-amber">Needs Restock</span>
                    @endif
                </div>
                <span class="inv-stat-sub">Items with ≤ 10 units left</span>
            </div>
        </div>

        <div class="inv-stat-card card-danger" onclick="switchInventoryTab('out_of_stock', document.getElementById('tab-btn-out'))">
            <div class="inv-stat-icon icon-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="inv-stat-info">
                <span class="inv-stat-label">Out of Stock • អស់ពីស្តុក</span>
                <div class="inv-stat-val-row">
                    <span class="inv-stat-num {{ $stats['out_of_stock_count'] > 0 ? 'text-red' : 'text-muted' }}" id="stat-out-stock">{{ $stats['out_of_stock_count'] }}</span>
                    @if ($stats['out_of_stock_count'] > 0)
                        <span class="inv-stat-badge badge-alert-red">Critical</span>
                    @else
                        <span class="inv-stat-badge badge-green">Healthy</span>
                    @endif
                </div>
                <span class="inv-stat-sub">Products unavailable to order</span>
            </div>
        </div>
    </div>

    <!-- Segment Filter Tabs -->
    <div class="inventory-tabs-container">
        <button type="button" id="tab-btn-all" class="inv-tab-btn active" onclick="switchInventoryTab('all', this)">
            <span>All Inventory</span>
            <span class="tab-badge" id="tab-count-all">{{ $stats['total_products'] }}</span>
        </button>
        <button type="button" id="tab-btn-low" class="inv-tab-btn" onclick="switchInventoryTab('low_stock', this)">
            <span>Low Stock Alerts ⚠️</span>
            <span class="tab-badge" id="tab-count-low">{{ $stats['low_stock_count'] }}</span>
        </button>
        <button type="button" id="tab-btn-out" class="inv-tab-btn" onclick="switchInventoryTab('out_of_stock', this)">
            <span>Out of Stock 🚨</span>
            <span class="tab-badge" id="tab-count-out">{{ $stats['out_of_stock_count'] }}</span>
        </button>
        <button type="button" id="tab-btn-healthy" class="inv-tab-btn" onclick="switchInventoryTab('in_stock', this)">
            <span>Well Stocked (>10) ✓</span>
            <span class="tab-badge" id="tab-count-healthy">{{ $stats['healthy_count'] }}</span>
        </button>
    </div>

    <!-- Main Inventory Card -->
    <section class="admin-panel admin-inventory-card" style="padding: 20px 24px;">
        <!-- Filter and Search Bar -->
        <div class="cust-filter-bar">
            <div class="cust-search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input id="inv-live-search" class="cust-search-input" type="search" placeholder="Search inventory by product name, Khmer title, SKU code..." autocomplete="off">
                <button type="button" id="clear-inv-search" class="cust-search-clear" onclick="clearInvSearch()" title="Clear search">✕</button>
            </div>

            <div class="filter-controls-row">
                <div class="filter-select-wrapper">
                    <label class="filter-label">Category</label>
                    <select id="inv-category-select" onchange="filterInventoryRows()">
                        <option value="all">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}">{{ __('store.categories.'.$cat, [], 'en') }}</option>
                        @endforeach
                    </select>
                </div>

                <span class="admin-count-pill" id="showing-counter">
                    Showing <strong id="inv-visible-count">{{ $products->count() }}</strong> of {{ $stats['total_products'] }} items
                </span>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="admin-table-wrap">
            <table class="admin-table modern-products-table" id="inventory-table">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">
                            <input type="checkbox" id="select-all-inv" onchange="toggleSelectAllInv(this)" title="Select all items">
                        </th>
                        <th style="width: 320px;">Product & Category</th>
                        <th style="width: 130px;">SKU Code</th>
                        <th style="width: 100px;">Unit Price</th>
                        <th style="width: 220px;">Current Stock & Adjustment</th>
                        <th style="width: 170px;">Status</th>
                        <th style="width: 130px;">Stock Valuation</th>
                        <th style="text-align: right; width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="inventory-table-body">
                    @forelse ($products as $product)
                        @php
                            $stock = (int) ($product->stock ?? 0);
                            $price = (float) $product->price;
                            $val = $stock * $price;
                            $status = $stock <= 0 ? 'out_of_stock' : ($stock <= 10 ? 'low_stock' : 'in_stock');
                            $pct = min(100, round(($stock / 50) * 100));
                        @endphp
                        <tr class="inventory-row"
                            id="inv-row-{{ $product->id }}"
                            data-id="{{ $product->id }}"
                            data-name="{{ strtolower($product->name_en) }}"
                            data-name-km="{{ strtolower($product->name_km) }}"
                            data-sku="{{ strtolower($product->sku) }}"
                            data-category="{{ $product->category }}"
                            data-stock="{{ $stock }}"
                            data-price="{{ $price }}"
                            data-status="{{ $status }}">
                            
                            <td style="text-align: center;">
                                <input type="checkbox" class="inv-row-check" value="{{ $product->id }}" onchange="handleInvCheckChange()">
                            </td>

                            <td>
                                <div class="admin-product-cell">
                                    <div class="product-thumb-wrap" onclick="openImageLightbox('{{ $product->image_url }}', '{{ addslashes($product->name_en) }}', '{{ $product->sku }}')" style="cursor: pointer;" title="Click to preview image">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name_en }}" loading="lazy" onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'50\' height=\'50\' viewBox=\'0 0 50 50\'><rect width=\'50\' height=\'50\' fill=\'%23edf5ed\'/><text x=\'25\' y=\'30\' font-size=\'18\' text-anchor=\'middle\'>🛍️</text></svg>';">
                                    </div>
                                    <div class="product-info-text">
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="product-name-en" title="Edit product">{{ $product->name_en }}</a>
                                            <a href="{{ route('store.products.show', $product) }}" target="_blank" class="storefront-link" title="View product on storefront">↗</a>
                                        </div>
                                        <span class="product-name-km">{{ $product->name_km }}</span>
                                        <span class="category-badge-pill" style="font-size: 10px; margin-top: 3px; display: inline-block;">{{ ucfirst($product->category) }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="sku-code-badge">{{ $product->sku }}</span>
                            </td>

                            <td>
                                <span class="price-current">${{ number_format($price, 2) }}</span>
                            </td>

                            <td>
                                <div class="inv-stock-col">
                                    <div class="inv-stepper">
                                        <button type="button" class="btn-stock-step" onclick="changeStockStep({{ $product->id }}, -1)" title="Reduce stock by 1">−</button>
                                        <input type="number" 
                                               id="stock-input-{{ $product->id }}" 
                                               value="{{ $stock }}" 
                                               min="0" 
                                               max="1000000" 
                                               class="stock-qty-input" 
                                               onchange="saveStockAjax({{ $product->id }}, this.value)"
                                               onkeydown="if(event.key==='Enter'){ this.blur(); }">
                                        <button type="button" class="btn-stock-step" onclick="changeStockStep({{ $product->id }}, 1)" title="Add 1 to stock">＋</button>
                                    </div>

                                    <!-- Visual Stock Health Progress Bar -->
                                    <div class="stock-bar-track" title="{{ $stock }} units in warehouse">
                                        <div id="stock-bar-{{ $product->id }}" 
                                             class="stock-bar-fill {{ $status === 'in_stock' ? 'healthy' : ($status === 'low_stock' ? 'low' : 'out') }}" 
                                             style="width: {{ $pct }}%;"></div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div id="stock-pill-container-{{ $product->id }}">
                                    @if ($stock <= 0)
                                        <span class="stock-status-pill is-out-of-stock">
                                            <span class="status-dot"></span>
                                            <span>Out of Stock</span>
                                        </span>
                                    @elseif ($stock <= 10)
                                        <span class="stock-status-pill is-low-stock">
                                            <span class="status-dot"></span>
                                            <span>Low Stock ({{ $stock }} left)</span>
                                        </span>
                                    @else
                                        <span class="stock-status-pill is-in-stock">
                                            <span class="status-dot"></span>
                                            <span>In Stock ({{ $stock }})</span>
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <strong class="order-total-price" id="stock-val-{{ $product->id }}">
                                    ${{ number_format($val, 2) }}
                                </strong>
                            </td>

                            <td style="text-align: right;">
                                <div class="cust-action-buttons">
                                    <button type="button" class="btn-quick-restock" onclick="openQuickRestockModal({{ $product->id }}, '{{ addslashes($product->name_en) }}', {{ $stock }})" title="Quick restock warehouse shipment">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                        <span>Restock</span>
                                    </button>

                                    <a class="action-btn-edit" href="{{ route('admin.products.edit', $product) }}" title="Edit Full Product Details">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-empty-state">
                                <div class="empty-state-wrap">
                                    <div class="empty-icon">🏢</div>
                                    <h3>No inventory items found</h3>
                                    <p>There are no products matching your selected stock criteria.</p>
                                    <div class="empty-actions">
                                        <a href="{{ route('admin.inventory.index') }}" class="admin-secondary-button">Reset filters</a>
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
            <div class="admin-pagination-footer" id="inv-pagination">
                <span class="pagination-summary">
                    Showing <strong>{{ $products->firstItem() ?? 0 }}</strong> to <strong>{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> items
                </span>
                <div class="pagination-links">
                    {{ $products->links('admin.partials.pagination') }}
                </div>
            </div>
        @endif
    </section>
</div>

<!-- ========================================================
     QUICK RESTOCK SHIPMENT MODAL
     ======================================================== -->
<div id="quickRestockModal" class="cust-modal-backdrop" onclick="handleBackdropClick(event, 'quickRestockModal')">
    <div class="cust-modal-box" style="max-width: 480px;">
        <div class="cust-modal-header">
            <h3>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" style="color: #245943;">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                <span>Receive Warehouse Stock</span>
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('quickRestockModal')">✕</button>
        </div>

        <form id="quickRestockForm" onsubmit="submitQuickRestock(event)">
            @csrf
            <input type="hidden" id="restock_prod_id">
            <div class="cust-modal-body">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 16px;">
                    <strong id="restock_prod_name" style="font-size: 14.5px; color: #1e293b; display: block;">Product Name</strong>
                    <span style="font-size: 12.5px; color: #64748b; margin-top: 2px; display: block;">
                        Current Stock: <strong id="restock_current_qty" style="color: #245943;">0</strong> units
                    </span>
                </div>

                <div style="margin-top: 10px;">
                    <label class="cust-input-label">
                        <span>Quantity to Add (+ Units)</span>
                        <input type="number" id="restock_add_qty" min="1" max="100000" value="10" required>
                    </label>

                    <div class="restock-chips-grid">
                        <button type="button" class="restock-chip" onclick="setRestockQty(5)">+5</button>
                        <button type="button" class="restock-chip active" onclick="setRestockQty(10)">+10</button>
                        <button type="button" class="restock-chip" onclick="setRestockQty(25)">+25</button>
                        <button type="button" class="restock-chip" onclick="setRestockQty(50)">+50</button>
                        <button type="button" class="restock-chip" onclick="setRestockQty(100)">+100</button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="admin-secondary-button" onclick="closeModal('quickRestockModal')">Cancel</button>
                <button type="submit" id="restock-submit-btn" class="admin-primary-button">Confirm Shipment</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     PRODUCT IMAGE ZOOM LIGHTBOX
     ======================================================== -->
<div id="imageLightboxModal" class="product-lightbox-backdrop" onclick="closeImageLightbox(event)" style="display: none;">
    <div class="product-lightbox-content">
        <button type="button" class="lightbox-close-btn" onclick="closeImageLightboxDirect()">✕</button>
        <img id="lightbox-img" src="" alt="Product Preview">
        <div class="lightbox-caption">
            <h4 id="lightbox-title">Product Title</h4>
            <span id="lightbox-sku">SKU Code</span>
        </div>
    </div>
</div>

<!-- ========================================================
     FLOATING BULK ACTION TOOLBAR
     ======================================================== -->
<div id="inv-bulk-toolbar" class="bulk-action-bar" style="display: none;">
    <div class="bulk-inner">
        <span class="bulk-counter">
            <span id="inv-selected-count">0</span> products selected
        </span>
        <div class="bulk-actions">
            <button type="button" class="bulk-btn" onclick="executeInvBulk('add_10')">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+10 Stock Each</span>
            </button>
            <button type="button" class="bulk-btn" onclick="executeInvBulk('add_50')">
                <span>+50 Stock Each</span>
            </button>
            <button type="button" class="bulk-btn bulk-btn-danger" onclick="executeInvBulk('set_zero')">
                <span>Set Out of Stock (0)</span>
            </button>
            <button type="button" class="bulk-close-btn" onclick="clearInvSelection()" title="Dismiss selection">✕</button>
        </div>
    </div>
</div>

<!-- Toast Feedback Notification -->
<div id="inv-toast" class="admin-toast" style="display: none;">
    <span class="toast-icon">✓</span>
    <span id="inv-toast-msg" class="toast-msg">Stock updated successfully</span>
</div>

<script>
// Inventory Client State
let activeInvTab = 'all';

function closeModal(id) {
    const el = document.getElementById(id);
    if (el) el.classList.remove('open');
}

function handleBackdropClick(e, id) {
    if (e.target.id === id) closeModal(id);
}

// ---------------------------------------------------------------------
// Instant AJAX Stock Stepper & Edit
// ---------------------------------------------------------------------
function changeStockStep(productId, delta) {
    const input = document.getElementById('stock-input-' + productId);
    if (!input) return;

    let current = parseInt(input.value) || 0;
    let next = Math.max(0, current + delta);
    input.value = next;
    saveStockAjax(productId, next);
}

async function saveStockAjax(productId, newQty) {
    const qty = Math.max(0, parseInt(newQty) || 0);
    const input = document.getElementById('stock-input-' + productId);
    if (input) input.value = qty;

    try {
        const response = await fetch("{{ url('/admin/inventory') }}/" + productId + "/stock", {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ stock: qty })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message);

            // Update row dataset
            const row = document.getElementById('inv-row-' + productId);
            if (row) {
                row.dataset.stock = data.product.stock;
                row.dataset.status = data.product.status;

                // Update Valuation
                const valEl = document.getElementById('stock-val-' + productId);
                if (valEl) {
                    valEl.textContent = '$' + Number(data.product.stock_value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                // Update Progress Bar
                const bar = document.getElementById('stock-bar-' + productId);
                if (bar) {
                    const pct = Math.min(100, Math.round((data.product.stock / 50) * 100));
                    bar.style.width = pct + '%';
                    bar.className = 'stock-bar-fill ' + (data.product.status === 'in_stock' ? 'healthy' : (data.product.status === 'low_stock' ? 'low' : 'out'));
                }

                // Update Status Pill
                const pillContainer = document.getElementById('stock-pill-container-' + productId);
                if (pillContainer) {
                    if (data.product.stock <= 0) {
                        pillContainer.innerHTML = '<span class="stock-status-pill is-out-of-stock"><span class="status-dot"></span><span>Out of Stock</span></span>';
                    } else if (data.product.stock <= 10) {
                        pillContainer.innerHTML = `<span class="stock-status-pill is-low-stock"><span class="status-dot"></span><span>Low Stock (${data.product.stock} left)</span></span>`;
                    } else {
                        pillContainer.innerHTML = `<span class="stock-status-pill is-in-stock"><span class="status-dot"></span><span>In Stock (${data.product.stock})</span></span>`;
                    }
                }
            }

            // Update Global Stats
            if (data.stats) {
                document.getElementById('stat-total-units').textContent = Number(data.stats.total_units).toLocaleString();
                document.getElementById('stat-total-val').textContent = '$' + Number(data.stats.total_valuation).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                document.getElementById('stat-low-stock').textContent = data.stats.low_stock_count;
                document.getElementById('stat-out-stock').textContent = data.stats.out_of_stock_count;

                document.getElementById('tab-count-low').textContent = data.stats.low_stock_count;
                document.getElementById('tab-count-out').textContent = data.stats.out_of_stock_count;
                document.getElementById('tab-count-healthy').textContent = data.stats.healthy_count;
            }
        } else {
            alert(data.message || 'Error updating stock.');
        }
    } catch (err) {
        console.error(err);
        alert('Network error updating stock level.');
    }
}

// ---------------------------------------------------------------------
// Quick Restock Modal
// ---------------------------------------------------------------------
function openQuickRestockModal(productId, productName, currentStock) {
    document.getElementById('restock_prod_id').value = productId;
    document.getElementById('restock_prod_name').textContent = productName;
    document.getElementById('restock_current_qty').textContent = currentStock;
    document.getElementById('restock_add_qty').value = 10;
    setRestockQty(10);

    document.getElementById('quickRestockModal').classList.add('open');
}

function setRestockQty(qty) {
    document.getElementById('restock_add_qty').value = qty;
    document.querySelectorAll('.restock-chip').forEach(ch => {
        ch.classList.toggle('active', ch.textContent.trim() === '+' + qty);
    });
}

async function submitQuickRestock(e) {
    e.preventDefault();
    const productId = document.getElementById('restock_prod_id').value;
    const current = parseInt(document.getElementById('restock_current_qty').textContent) || 0;
    const addQty = parseInt(document.getElementById('restock_add_qty').value) || 0;
    const newTotal = current + addQty;

    const btn = document.getElementById('restock-submit-btn');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    await saveStockAjax(productId, newTotal);
    closeModal('quickRestockModal');
    btn.disabled = false;
    btn.textContent = 'Confirm Shipment';
}

// ---------------------------------------------------------------------
// Live Search & Category & Tabs Filtering
// ---------------------------------------------------------------------
const invSearchInput = document.getElementById('inv-live-search');
const clearSearchBtn = document.getElementById('clear-inv-search');
const categorySelect = document.getElementById('inv-category-select');

invSearchInput.addEventListener('input', filterInventoryRows);

function clearInvSearch() {
    invSearchInput.value = '';
    clearSearchBtn.style.display = 'none';
    filterInventoryRows();
    invSearchInput.focus();
}

function switchInventoryTab(tabName, btn) {
    activeInvTab = tabName;
    document.querySelectorAll('.inv-tab-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    filterInventoryRows();
}

function filterInventoryRows() {
    const q = invSearchInput.value.trim().toLowerCase();
    const cat = categorySelect.value;
    clearSearchBtn.style.display = q.length > 0 ? 'block' : 'none';

    const rows = document.querySelectorAll('.inventory-row');
    let visibleCount = 0;

    rows.forEach(row => {
        let matchesSearch = true;
        let matchesCat = true;
        let matchesTab = true;

        if (q.length > 0) {
            const name = row.dataset.name || '';
            const nameKm = row.dataset.nameKm || '';
            const sku = row.dataset.sku || '';
            matchesSearch = name.includes(q) || nameKm.includes(q) || sku.includes(q);
        }

        if (cat !== 'all') {
            matchesCat = row.dataset.category === cat;
        }

        if (activeInvTab === 'low_stock') {
            matchesTab = row.dataset.status === 'low_stock';
        } else if (activeInvTab === 'out_of_stock') {
            matchesTab = row.dataset.status === 'out_of_stock';
        } else if (activeInvTab === 'in_stock') {
            matchesTab = row.dataset.status === 'in_stock';
        }

        if (matchesSearch && matchesCat && matchesTab) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const countEl = document.getElementById('inv-visible-count');
    if (countEl) countEl.textContent = visibleCount;
}

// ---------------------------------------------------------------------
// Bulk Inventory Actions
// ---------------------------------------------------------------------
function toggleSelectAllInv(master) {
    const checkboxes = document.querySelectorAll('.inv-row-check');
    checkboxes.forEach(cb => {
        const row = cb.closest('.inventory-row');
        if (row && row.style.display !== 'none') {
            cb.checked = master.checked;
        }
    });
    handleInvCheckChange();
}

function handleInvCheckChange() {
    const checked = document.querySelectorAll('.inv-row-check:checked');
    const toolbar = document.getElementById('inv-bulk-toolbar');
    const countSpan = document.getElementById('inv-selected-count');

    if (checked.length > 0) {
        countSpan.textContent = checked.length;
        toolbar.style.display = 'block';
    } else {
        toolbar.style.display = 'none';
        document.getElementById('select-all-inv').checked = false;
    }
}

function clearInvSelection() {
    document.querySelectorAll('.inv-row-check').forEach(cb => cb.checked = false);
    document.getElementById('select-all-inv').checked = false;
    document.getElementById('inv-bulk-toolbar').style.display = 'none';
}

async function executeInvBulk(action) {
    const checked = Array.from(document.querySelectorAll('.inv-row-check:checked')).map(cb => cb.value);
    if (checked.length === 0) return;

    if (action === 'set_zero') {
        if (!confirm(`Set stock to 0 (Out of stock) for ${checked.length} selected products?`)) {
            return;
        }
    }

    try {
        const response = await fetch("{{ route('admin.inventory.bulk') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                ids: checked,
                action: action
            })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message);
            clearInvSelection();
            setTimeout(() => {
                window.location.reload();
            }, 600);
        } else {
            alert(data.message || 'Bulk operation failed.');
        }
    } catch (err) {
        console.error(err);
        alert('Network error executing bulk action.');
    }
}

// ---------------------------------------------------------------------
// Lightbox Zoom Modal
// ---------------------------------------------------------------------
function openImageLightbox(imageUrl, title, sku) {
    const modal = document.getElementById('imageLightboxModal');
    document.getElementById('lightbox-img').src = imageUrl;
    document.getElementById('lightbox-title').textContent = title;
    document.getElementById('lightbox-sku').textContent = 'SKU: ' + sku;
    modal.style.display = 'flex';
}

function closeImageLightbox(e) {
    if (e.target.id === 'imageLightboxModal') {
        closeImageLightboxDirect();
    }
}

function closeImageLightboxDirect() {
    document.getElementById('imageLightboxModal').style.display = 'none';
}

// ---------------------------------------------------------------------
// Toast Notification
// ---------------------------------------------------------------------
let invToastTimer = null;
function showToast(msg) {
    const toast = document.getElementById('inv-toast');
    const msgEl = document.getElementById('inv-toast-msg');
    if (!toast || !msgEl) return;

    msgEl.textContent = msg;
    toast.style.display = 'flex';
    toast.style.opacity = '1';

    if (invToastTimer) clearTimeout(invToastTimer);
    invToastTimer = setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.style.display = 'none', 300);
    }, 2800);
}
</script>
@endsection

