@extends('admin.layouts.app')

@section('title', $product->exists ? 'Edit product: '.$product->name_en : 'Add Products')

@section('content')
<div class="admin-products-view">
    <!-- Top Page Heading with Back Button -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 4px;">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
                CATALOG & MASS PRODUCT MANAGEMENT
            </span>
            <h1>{{ $product->exists ? 'Edit Product' : 'Add Products to Catalog' }}</h1>
            <p>គ្រប់គ្រងការបញ្ចូលមុខទំនិញថ្មីៗ អាចបញ្ចូលមួយៗ ឬបញ្ចូលម្តងច្រើនមុខក្នុងពេលតែមួយយ៉ាងឆាប់រហ័ស។</p>
        </div>
        <div class="heading-actions">
            <a class="admin-secondary-button" href="{{ route('admin.products.index') }}">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to products</span>
            </a>
        </div>
    </div>

    @if (!$product->exists)
        <!-- Prominent Glowing Segmented Mode Switcher -->
        <div class="product-mode-master-bar">
            <div class="mode-switcher-container">
                <button type="button" class="master-mode-btn is-active" id="tabBtnBatch" onclick="switchProductMode('batch')">
                    <div class="mode-icon-circle bg-amber">⚡</div>
                    <div class="mode-btn-text">
                        <strong>Batch Multi-Add (បញ្ចូលម្តងច្រើនមុខ)</strong>
                        <small>តារាងបញ្ចូលទំនិញ 3, 5, 10+ មុខដំណាលគ្នា រក្សាទុកក្នុង 1 Click</small>
                    </div>
                    <span class="mode-active-pill">DEFAULT</span>
                </button>

                <button type="button" class="master-mode-btn" id="tabBtnSingle" onclick="switchProductMode('single')">
                    <div class="mode-icon-circle bg-green">📝</div>
                    <div class="mode-btn-text">
                        <strong>Single Product (បញ្ចូលទោលមួយៗ)</strong>
                        <small>ទម្រង់លម្អិតមួយៗជាមួយផ្ទាំង Live Storefront Preview</small>
                    </div>
                </button>

                <button type="button" class="master-mode-btn" id="tabBtnPaste" onclick="switchProductMode('paste')">
                    <div class="mode-icon-circle bg-blue">📋</div>
                    <div class="mode-btn-text">
                        <strong>Excel / CSV Paste (បិទភ្ជាប់ពី Excel)</strong>
                        <small>Copy & Paste ទិន្នន័យពី Excel/Sheets មកបម្លែងចូលតារាង</small>
                    </div>
                </button>
            </div>
        </div>
    @endif

    @if (!$product->exists)
        <!-- ========================================================
             MODE 1 (DEFAULT): BATCH MULTI-ADD TABLE
             ======================================================== -->
        <div id="sectionBatchProduct" class="product-mode-content">
            <section class="admin-panel batch-products-card">
                <!-- Card Header -->
                <div class="batch-card-header">
                    <div class="batch-head-left">
                        <div class="header-icon-mini icon-lightning">⚡</div>
                        <div>
                            <h3 class="batch-title">Mass Product Creator (តារាងបញ្ចូលទំនិញម្តងច្រើន)</h3>
                            <p class="batch-sub">វាយបញ្ចូលទំនិញតាមជួរនីមួយៗខាងក្រោម ហើយចុច Save តែម្តង នោះទំនិញទាំងអស់នឹងចូលក្នុងហាងភ្លាមៗ!</p>
                        </div>
                    </div>

                    <!-- Quick Tools Toolbar -->
                    <div class="batch-toolbar">
                        <button type="button" class="btn-batch-tool" onclick="addBatchRow()" title="បន្ថែម ១ ជួរ">
                            <span class="btn-icon">➕</span> Add +1 Row
                        </button>
                        <button type="button" class="btn-batch-tool" onclick="addBatchRows(5)" title="បន្ថែម ៥ ជួរ">
                            <span class="btn-icon">➕</span> Add +5 Rows
                        </button>
                        <button type="button" class="btn-batch-tool btn-sample" onclick="fillSampleProducts()" title="សាកល្បងបញ្ចូលទិន្នន័យគំរូ ៥ មុខ">
                            <span class="btn-icon">✨</span> Fill 5 Demo Products
                        </button>
                        <button type="button" class="btn-batch-tool btn-danger-soft" onclick="clearBatchRows()" title="សម្អាតជួរទាំងអស់">
                            <span class="btn-icon">🧹</span> Clear Rows
                        </button>
                    </div>
                </div>

                <form action="{{ route('admin.products.batch') }}" method="POST" id="batchProductsForm" enctype="multipart/form-data">
                    @csrf

                    <!-- Multi-Row Grid Table Container -->
                    <div class="batch-table-container">
                        <table class="batch-table" id="batchTable">
                            <thead>
                                <tr>
                                    <th width="40" class="text-center">#</th>
                                    <th width="280">Product Names (ឈ្មោះទំនិញ EN & KM) *</th>
                                    <th width="150">Category (ប្រភេទ) *</th>
                                    <th width="130">Sale Price ($) *</th>
                                    <th width="110">Old ($)</th>
                                    <th width="90">Stock</th>
                                    <th width="280">Image (រូបភាព PC ឬ URL) *</th>
                                    <th width="80" class="text-center">Active</th>
                                    <th width="50" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="batchTableBody">
                                @php
                                    $presetSampleImages = [
                                        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=80',
                                        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop&q=80',
                                        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&auto=format&fit=crop&q=80',
                                        'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&auto=format&fit=crop&q=80',
                                        'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=500&auto=format&fit=crop&q=80',
                                    ];
                                @endphp
                                @for ($i = 0; $i < 5; $i++)
                                    @php
                                        $initialCat = $categories[$i % count($categories)] ?? 'electronics';
                                        $initialImg = $presetSampleImages[$i % count($presetSampleImages)];
                                    @endphp
                                    <tr class="batch-row" id="batchRow_{{ $i }}">
                                        <td class="row-num">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="batch-dual-input">
                                                <div class="input-with-flag">
                                                    <span class="cell-flag">🇬🇧</span>
                                                    <input type="text" name="products[{{ $i }}][name_en]" placeholder="Product Name in English *" class="batch-input input-bold" required>
                                                </div>
                                                <div class="input-with-flag">
                                                    <span class="cell-flag">🇰🇭</span>
                                                    <input type="text" name="products[{{ $i }}][name_km]" placeholder="ឈ្មោះផលិតផលជាភាសាខ្មែរ *" class="batch-input" required>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <select name="products[{{ $i }}][category]" class="batch-select">
                                                @foreach ($categories as $c)
                                                    <option value="{{ $c }}" @selected($c === $initialCat)>{{ ucfirst($c) }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="batch-num-wrap">
                                                <span class="p-symbol">$</span>
                                                <input type="number" step="0.01" min="0" name="products[{{ $i }}][price]" placeholder="25.00" class="batch-input batch-price" required oninput="updateRowKhr({{ $i }}, this.value)">
                                            </div>
                                            <small class="batch-row-riel" id="rowRiel_{{ $i }}"></small>
                                        </td>
                                        <td>
                                            <div class="batch-num-wrap">
                                                <span class="p-symbol">$</span>
                                                <input type="number" step="0.01" min="0" name="products[{{ $i }}][old_price]" placeholder="35.00" class="batch-input">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" min="0" name="products[{{ $i }}][stock]" value="50" class="batch-input batch-stock">
                                        </td>
                                        <td>
                                            <div class="batch-img-cell">
                                                <div class="batch-thumb-wrapper" onclick="triggerRowUpload({{ $i }})" title="ជ្រើសរើសរូបពីកុំព្យូទ័រ (Click to upload from PC)">
                                                    <img src="{{ $initialImg }}" class="batch-thumb-preview" id="thumbPreview_{{ $i }}" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'44\' height=\'44\'><rect width=\'44\' height=\'44\' fill=\'%23edf5ed\'/><text x=\'22\' y=\'28\' font-size=\'18\' text-anchor=\'middle\'>🛍️</text></svg>'">
                                                    <div class="thumb-hover-overlay">
                                                        <span>📷</span>
                                                    </div>
                                                    <span class="thumb-source-tag is-web" id="sourceBadge_{{ $i }}">URL</span>
                                                </div>

                                                <div class="batch-img-detail">
                                                    <div class="input-with-icon">
                                                        <span class="cell-input-icon" id="inputIcon_{{ $i }}">🔗</span>
                                                        <input type="text" name="products[{{ $i }}][image_url]" value="{{ $initialImg }}" placeholder="Paste Image URL or Upload..." class="batch-input batch-img-url" id="imgUrlInput_{{ $i }}" oninput="handleManualUrlChange({{ $i }}, this.value)">
                                                    </div>

                                                    <div class="batch-img-actions">
                                                        <input type="file" name="products[{{ $i }}][image_file]" id="fileInput_{{ $i }}" class="hidden-file-input" accept="image/*" onchange="handleBatchFileSelect({{ $i }}, this)">

                                                        <button type="button" class="btn-batch-media btn-pc-upload" onclick="triggerRowUpload({{ $i }})" title="Upload រូបពីកុំព្យូទ័រ (Select image from PC)">
                                                            <span>💻 Upload PC</span>
                                                        </button>

                                                        <button type="button" class="btn-batch-media btn-preset-cycle" onclick="cycleRowImage({{ $i }})" title="ផ្លាស់ប្តូររូបគំរូ (Cycle preset photo)">
                                                            <span>🎨 Preset</span>
                                                        </button>

                                                        <button type="button" class="btn-batch-media btn-clear-img" onclick="clearRowImage({{ $i }})" title="លុបរូបចេញ (Clear image)">
                                                            <span>✕</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <label class="modern-mini-toggle">
                                                <input type="checkbox" name="products[{{ $i }}][is_active]" value="1" checked>
                                                <span class="mini-toggle-slider"></span>
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <div class="row-action-btns">
                                                <button type="button" class="btn-row-action btn-del-row" onclick="deleteBatchRow({{ $i }})" title="លុបជួរនេះ">&times;</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Summary & Massive Glowing Save Button -->
                    <div class="batch-footer-bar">
                        <div class="batch-counter-text">
                            <span>Ready to save:</span>
                            <strong id="batchRowsCount" class="badge-count-highlight">5</strong>
                            <span>products into store database</span>
                        </div>

                        <div class="batch-submit-actions">
                            <button type="button" class="admin-secondary-button" onclick="switchProductMode('single')">Switch to Single Form</button>
                            <button type="submit" class="admin-primary-button submit-lg button-with-glow">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>
                                <span id="batchSubmitBtnText">Save All 5 Products at Once</span>
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    @endif

    <!-- ========================================================
         MODE 2: SINGLE PRODUCT FORM
         ======================================================== -->
    <div id="sectionSingleProduct" class="product-mode-content" style="{{ !$product->exists ? 'display: none;' : '' }}">
        <div class="product-form-layout">
            <!-- Form Section -->
            <section class="admin-panel admin-form-panel">
                <form class="admin-form" id="productForm" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($product->exists)
                        @method('PUT')
                    @endif

                    <div class="form-section-header">
                        <div class="header-icon-mini icon-box">📦</div>
                        <div>
                            <h3>Basic Product Information (ព័ត៌មានទូទៅ)</h3>
                            <p>បញ្ចូលឈ្មោះជាភាសាអង់គ្លេស និងភាសាខ្មែរ រួចជ្រើសរើសប្រភេទមុខទំនិញ</p>
                        </div>
                    </div>

                    <div class="admin-form-grid">
                        <label class="admin-field">
                            <span><span class="flag-icon">🇬🇧</span> Product name (English) <strong class="req-star">*</strong></span>
                            <input id="input_name_en" name="name_en" type="text" maxlength="255" value="{{ old('name_en', $product->name_en) }}" placeholder="e.g. Wireless Noise-Cancelling Headphones" required>
                            @error('name_en')<small class="admin-field-error">{{ $message }}</small>@enderror
                        </label>

                        <label class="admin-field">
                            <span><span class="flag-icon">🇰🇭</span> Product name (Khmer ឈ្មោះខ្មែរ) <strong class="req-star">*</strong></span>
                            <input id="input_name_km" name="name_km" type="text" maxlength="255" value="{{ old('name_km', $product->name_km) }}" placeholder="ឧ. កាសស្តាប់ឥតខ្សែបំបាត់សំឡេងរំខាន" required>
                            @error('name_km')<small class="admin-field-error">{{ $message }}</small>@enderror
                        </label>

                        <label class="admin-field">
                            <span>Store Category (ប្រភេទផលិតផល) <strong class="req-star">*</strong></span>
                            <select id="input_category" name="category" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}" @selected(old('category', request('category', $product->category)) === $category)>{{ __('store.categories.'.$category, [], 'en') }} ({{ __('store.categories.'.$category, [], 'km') }})</option>
                                @endforeach
                            </select>
                            @error('category')<small class="admin-field-error">{{ $message }}</small>@enderror
                        </label>

                        <label class="admin-field">
                            <span>Badge / Promotion Tag (Optional)</span>
                            <input id="input_badge" name="badge" type="text" maxlength="80" placeholder="e.g. Best Seller, -20%, Popular" value="{{ old('badge', $product->badge) }}">
                            @error('badge')<small class="admin-field-error">{{ $message }}</small>@enderror
                        </label>
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-section-header">
                        <div class="header-icon-mini icon-pricing">💲</div>
                        <div>
                            <h3>Pricing & Inventory (តម្លៃ និងចំនួនក្នុងស្តុក)</h3>
                            <p>កំណត់តម្លៃលក់ជាដុល្លារ ($) និងចំនួនទំនិញក្នុងស្តុក (Stock Count)</p>
                        </div>
                    </div>

                    <div class="admin-form-grid">
                        <label class="admin-field">
                            <span>Sale Price (USD) <strong class="req-star">*</strong></span>
                            <div class="input-with-prefix">
                                <span class="currency-prefix">$</span>
                                <input id="input_price" name="price" type="number" min="0" max="99999999" step="0.01" value="{{ old('price', $product->price) }}" placeholder="29.99" required oninput="calcSingleKhrPrice()">
                            </div>
                            <span class="riel-price-hint" id="rielPricePreview">≈ 0 ៛ (អត្រា 1$ = {{ number_format((float)($storeSettings['exchange_rate'] ?? 4100)) }}៛)</span>
                            @error('price')<small class="admin-field-error">{{ $message }}</small>@enderror
                        </label>

                        <label class="admin-field">
                            <span>Original Price (USD, Optional)</span>
                            <div class="input-with-prefix">
                                <span class="currency-prefix">$</span>
                                <input id="input_old_price" name="old_price" type="number" min="0" max="99999999" step="0.01" value="{{ old('old_price', $product->old_price) }}" placeholder="39.99">
                            </div>
                            <small class="admin-field-help">តម្លៃដើមសម្រាប់បង្ហាញការបញ្ចុះតម្លៃ (-% Discount)</small>
                            @error('old_price')<small class="admin-field-error">{{ $message }}</small>@enderror
                        </label>

                        <label class="admin-field">
                            <span>Stock Quantity (ចំនួនក្នុងស្តុក) <strong class="req-star">*</strong></span>
                            <input id="input_stock" name="stock" type="number" min="0" max="1000000" step="1" value="{{ old('stock', $product->stock ?? 45) }}" required>
                            <small class="admin-field-help">បរិមាណទំនិញដែលត្រៀមរួចជាស្រេចសម្រាប់លក់</small>
                            @error('stock')<small class="admin-field-error">{{ $message }}</small>@enderror
                        </label>

                        <label class="admin-field">
                            <span>Customer Rating (0.0 – 5.0) <strong class="req-star">*</strong></span>
                            <input id="input_rating" name="rating" type="number" min="0" max="5" step="0.1" value="{{ old('rating', $product->rating ?? 5.0) }}" required>
                            @error('rating')<small class="admin-field-error">{{ $message }}</small>@enderror
                        </label>

                        <label class="admin-field">
                            <span>Display Order Priority <strong class="req-star">*</strong></span>
                            <input name="sort_order" type="number" min="0" max="1000000" step="1" value="{{ old('sort_order', $product->sort_order ?? 0) }}" required>
                            <small class="admin-field-help">លេខកាន់តែតូច នឹងបង្ហាញមុនគេក្នុង Catalog</small>
                            @error('sort_order')<small class="admin-field-error">{{ $message }}</small>@enderror
                        </label>
                    </div>

                    <div class="form-divider"></div>

                    <!-- Image Section with Dual Source Tabs (PC Upload or URL) -->
                    <div class="form-section-header">
                        <div class="header-icon-mini icon-photo">🖼️</div>
                        <div>
                            <h3>Product Image (រូបភាពទំនិញ)</h3>
                            <p>ជ្រើសរើសរូបភាពពីកុំព្យូទ័រ (Upload from PC) ឬបញ្ចូលតំណភ្ជាប់ Web URL</p>
                        </div>
                    </div>

                    <div class="admin-form-group">
                        <!-- Dual Source Switcher -->
                        <div class="media-source-tabs">
                            <button type="button" class="btn-source-tab is-active" id="btnSingleTabPc" onclick="switchSingleImageMode('pc')">
                                <span>💻 Upload from Computer (រូបភាពពីម៉ាស៊ីន)</span>
                            </button>
                            <button type="button" class="btn-source-tab" id="btnSingleTabUrl" onclick="switchSingleImageMode('url')">
                                <span>🔗 Web Image URL (តំណភ្ជាប់ Web)</span>
                            </button>
                        </div>

                        <!-- Panel A: Computer File Upload Dropzone -->
                        <div id="singlePanelPc" class="single-image-panel">
                            <div class="dropzone-upload-box" onclick="document.getElementById('single_file_input').click()">
                                <input type="file" name="image_file" id="single_file_input" class="hidden-file-input" accept="image/*" onchange="handleSingleFileSelect(this)">
                                <div class="dropzone-icon">📁</div>
                                <div class="dropzone-title" id="dropzoneTitle">Click to choose image from your computer</div>
                                <div class="dropzone-hint">Supports PNG, JPG, WEBP, GIF up to 5MB (បង្ហាញ Preview លើ Mockup ភ្លាមៗ)</div>
                            </div>
                        </div>

                        <!-- Panel B: Web URL Input -->
                        <div id="singlePanelUrl" class="single-image-panel" style="display: none;">
                            <label class="admin-field admin-field-full">
                                <span>Product Image URL</span>
                                <input id="input_image_url" name="image_url" type="text" maxlength="2048" placeholder="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80" value="{{ old('image_url', $product->image_url) }}">
                                <small class="admin-field-help">បញ្ចូលតំណភ្ជាប់រូបភាពច្បាស់ (High resolution image URL)</small>
                                @error('image_url')<small class="admin-field-error">{{ $message }}</small>@enderror
                            </label>
                        </div>

                        <!-- Quick Unsplash Preset Gallery -->
                        <div class="quick-preset-gallery">
                            <span class="preset-label">⚡ រូបភាពគំរូពេញនិយម (Click to apply image instantly):</span>
                            <div class="preset-items-row">
                                <button type="button" class="preset-thumb-btn" onclick="applyImagePreset('https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80')" title="Wireless Headphones">
                                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100&auto=format&fit=crop&q=80" alt="Headphones">
                                    <span>Headphones</span>
                                </button>
                                <button type="button" class="preset-thumb-btn" onclick="applyImagePreset('https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80')" title="Smart Watch">
                                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&auto=format&fit=crop&q=80" alt="Watch">
                                    <span>Smartwatch</span>
                                </button>
                                <button type="button" class="preset-thumb-btn" onclick="applyImagePreset('https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&auto=format&fit=crop&q=80')" title="Sport Sneakers">
                                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100&auto=format&fit=crop&q=80" alt="Sneakers">
                                    <span>Sneakers</span>
                                </button>
                                <button type="button" class="preset-thumb-btn" onclick="applyImagePreset('https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&auto=format&fit=crop&q=80')" title="Daily Bag">
                                    <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=100&auto=format&fit=crop&q=80" alt="Bag">
                                    <span>Backpack</span>
                                </button>
                                <button type="button" class="preset-thumb-btn" onclick="applyImagePreset('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&auto=format&fit=crop&q=80')" title="Digital Camera">
                                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=100&auto=format&fit=crop&q=80" alt="Camera">
                                    <span>Camera</span>
                                </button>
                                <button type="button" class="preset-thumb-btn" onclick="applyImagePreset('https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=600&auto=format&fit=crop&q=80')" title="Thermos Bottle">
                                    <img src="https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=100&auto=format&fit=crop&q=80" alt="Bottle">
                                    <span>Bottle</span>
                                </button>
                                <button type="button" class="preset-thumb-btn" onclick="applyImagePreset('https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=600&auto=format&fit=crop&q=80')" title="Sunglasses">
                                    <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=100&auto=format&fit=crop&q=80" alt="Sunglasses">
                                    <span>Sunglasses</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-section-header">
                        <div class="header-icon-mini icon-eye">👁️</div>
                        <div>
                            <h3>Visibility & Badging</h3>
                            <p>កំណត់ការបង្ហាញលើគេហទំព័រ Dara Market</p>
                        </div>
                    </div>

                    <div class="admin-switches-group">
                        <label class="switch-toggle-card">
                            <input id="input_is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $product->exists ? $product->is_active : true))>
                            <span class="switch-slider"></span>
                            <div class="switch-text">
                                <strong>Visible in Storefront (បង្ហាញលើហាង)</strong>
                                <small>អនុញ្ញាតឱ្យអតិថិជនមើលឃើញ និងបញ្ជាទិញទំនិញនេះបាន។</small>
                            </div>
                        </label>

                        <label class="switch-toggle-card">
                            <input id="input_is_new" name="is_new" type="checkbox" value="1" @checked(old('is_new', $product->is_new ?? false))>
                            <span class="switch-slider"></span>
                            <div class="switch-text">
                                <strong>Mark as New Arrival (ទំនិញមកដល់ថ្មី)</strong>
                                <small>បង្ហាញផ្លាក "New Arrival" និងដាក់លើទំព័រដើម</small>
                            </div>
                        </label>
                    </div>

                    <div class="admin-form-actions-extended">
                        <button class="admin-primary-button submit-lg" type="submit">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span>{{ $product->exists ? 'Save Changes' : 'Create Product' }}</span>
                        </button>

                        @if (!$product->exists)
                            <button class="admin-secondary-button-action" type="submit" name="save_and_add_another" value="1" title="រក្សាទុក ហើយបន្តបញ្ចូលទំនិញថ្មីមួយទៀត">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <span>Save & Add Another</span>
                            </button>
                        @endif

                        <a class="admin-secondary-button" href="{{ route('admin.products.index') }}">Cancel</a>
                    </div>
                </form>
            </section>

            <!-- Live Preview Card Section -->
            <aside class="product-preview-sidebar">
                <div class="preview-sticky-card">
                    <div class="preview-card-header">
                        <span class="preview-badge">LIVE STOREFRONT PREVIEW</span>
                        <small>Real-time customer view</small>
                    </div>

                    <div class="customer-product-mockup">
                        <div class="mockup-img-wrap">
                            <img id="preview_img" src="{{ old('image_url', $product->image_url ?? '') }}" alt="Preview" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'240\' viewBox=\'0 0 300 240\'><rect width=\'300\' height=\'240\' fill=\'%23edf5ed\'/><text x=\'150\' y=\'120\' font-size=\'48\' text-anchor=\'middle\'>🛍️</text><text x=\'150\' y=\'150\' font-size=\'14\' fill=\'%237d8981\' text-anchor=\'middle\'>No image URL</text></svg>'">
                            <span id="preview_badge" class="mockup-badge {{ old('badge', $product->badge) ? '' : 'is-hidden' }}">{{ old('badge', $product->badge ?? '') }}</span>
                        </div>
                        <div class="mockup-body">
                            <div class="mockup-meta">
                                <span id="preview_category" class="mockup-cat">{{ ucfirst(old('category', $product->category ?? 'electronics')) }}</span>
                                <div class="mockup-rating">
                                    <span class="star">★</span>
                                    <span id="preview_rating">{{ number_format((float) old('rating', $product->rating ?? 5.0), 1) }}</span>
                                </div>
                            </div>
                            <h4 id="preview_name_en" class="mockup-title-en">{{ old('name_en', $product->name_en ?? 'Product Name (English)') }}</h4>
                            <p id="preview_name_km" class="mockup-title-km">{{ old('name_km', $product->name_km ?? 'ឈ្មោះផលិតផល (ភាសាខ្មែរ)') }}</p>
                            <div class="mockup-footer">
                                <div class="mockup-pricing">
                                    <span class="mockup-currency">$</span><span id="preview_price" class="mockup-price-num">{{ number_format((float) old('price', $product->price ?? 0), 2) }}</span>
                                    <span id="preview_old_price" class="mockup-old-price {{ old('old_price', $product->old_price) ? '' : 'is-hidden' }}">${{ number_format((float) old('old_price', $product->old_price ?? 0), 2) }}</span>
                                </div>
                                <span id="preview_status_pill" class="mockup-status-tag {{ old('is_active', $product->exists ? $product->is_active : true) ? 'is-live' : 'is-hidden-tag' }}">
                                    {{ old('is_active', $product->exists ? $product->is_active : true) ? '✓ Live in Store' : 'Draft / Hidden' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="preview-tips">
                        <p>💡 <strong>Tip:</strong> Products marked as <em>Active</em> will appear immediately on the Dara Market home and catalog pages.</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    @if (!$product->exists)
        <!-- ========================================================
             MODE 3: EXCEL / CSV QUICK PASTE
             ======================================================== -->
        <div id="sectionPasteProduct" class="product-mode-content" style="display: none;">
            <section class="admin-panel batch-products-card">
                <div class="batch-card-header">
                    <div class="batch-head-left">
                        <div class="header-icon-mini icon-excel">📋</div>
                        <div>
                            <h3 class="batch-title">Paste Directly from Excel or Google Sheets (បិទភ្ជាប់ទិន្នន័យ)</h3>
                            <p class="batch-sub">ចម្លងទិន្នន័យពីតារាង Excel ឬ Google Sheet (Copy & Paste) ហើយចុចបម្លែងចូលតារាង Batch Add ភ្លាមៗ!</p>
                        </div>
                    </div>
                    <button type="button" class="btn-batch-tool btn-sample" onclick="loadSamplePasteText()">
                        <span>✨ Load Sample Template</span>
                    </button>
                </div>

                <div class="paste-tool-body">
                    <div class="paste-instructions">
                        <span class="inst-tag">Format គំរូ:</span>
                        <code>Name (English) [Tab/Comma] Name (Khmer) [Tab/Comma] Category [Tab/Comma] Price [Tab/Comma] Old Price [Tab/Comma] Stock</code>
                    </div>

                    <textarea id="rawPasteInput" class="paste-textarea" rows="8" placeholder="ឧទាហរណ៍៖
Wireless Mouse, កណ្តុរឥតខ្សែ, electronics, 15.00, 20.00, 50
Canvas Tote Bag, កាបូបយួរស្ពាយ, fashion, 18.50, 25.00, 40
Ceramic Coffee Mug, កែវកាហ្វេសេរ៉ាមិក, kitchen, 8.00, 12.00, 60"></textarea>

                    <div class="paste-actions-bar">
                        <button type="button" class="admin-primary-button button-with-glow" onclick="parsePasteIntoBatch()">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span>Convert & Load into Table (បម្លែងចូលតារាង Batch Add)</span>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    @endif
</div>

<script>
const STORE_EXCHANGE_RATE = {{ (float)($storeSettings['exchange_rate'] ?? 4100) }};
const CATEGORIES_LIST = @json($categories);

// Switch Modes (Batch / Single / Paste)
function switchProductMode(mode) {
    const secSingle = document.getElementById('sectionSingleProduct');
    const secBatch = document.getElementById('sectionBatchProduct');
    const secPaste = document.getElementById('sectionPasteProduct');

    const btnSingle = document.getElementById('tabBtnSingle');
    const btnBatch = document.getElementById('tabBtnBatch');
    const btnPaste = document.getElementById('tabBtnPaste');

    if (secSingle) secSingle.style.display = mode === 'single' ? 'block' : 'none';
    if (secBatch) secBatch.style.display = mode === 'batch' ? 'block' : 'none';
    if (secPaste) secPaste.style.display = mode === 'paste' ? 'block' : 'none';

    if (btnSingle) btnSingle.className = mode === 'single' ? 'master-mode-btn is-active' : 'master-mode-btn';
    if (btnBatch) btnBatch.className = mode === 'batch' ? 'master-mode-btn is-active' : 'master-mode-btn';
    if (btnPaste) btnPaste.className = mode === 'paste' ? 'master-mode-btn is-active' : 'master-mode-btn';
}

// Quick apply Unsplash preset image
function applyImagePreset(url) {
    const input = document.getElementById('input_image_url');
    const preview = document.getElementById('preview_img');
    if (input) input.value = url;
    if (preview) preview.src = url;
}

// Calculate Khmer Riel Price for Single Mode
function calcSingleKhrPrice() {
    const priceInput = document.getElementById('input_price');
    const previewEl = document.getElementById('rielPricePreview');
    if (!priceInput || !previewEl) return;
    const usd = parseFloat(priceInput.value) || 0;
    const khr = Math.round(usd * STORE_EXCHANGE_RATE);
    previewEl.textContent = '≈ ' + khr.toLocaleString() + ' ៛ (អត្រា 1$ = ' + STORE_EXCHANGE_RATE.toLocaleString() + '៛)';
}

// ========================================================
// BATCH GRID DYNAMIC ENGINE
// ========================================================
let batchRowCounter = 5;

const CURATED_SAMPLE_IMAGES = [
    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=500&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=500&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=500&auto=format&fit=crop&q=80',
    'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&auto=format&fit=crop&q=80'
];

function createBatchRowHtml(index, data = {}) {
    const nameEn = data.name_en || '';
    const nameKm = data.name_km || '';
    const category = data.category || CATEGORIES_LIST[index % CATEGORIES_LIST.length] || 'electronics';
    const price = data.price !== undefined ? data.price : '';
    const oldPrice = data.old_price !== undefined ? data.old_price : '';
    const stock = data.stock !== undefined ? data.stock : 50;
    const img = data.image_url || CURATED_SAMPLE_IMAGES[index % CURATED_SAMPLE_IMAGES.length];
    const isActive = data.is_active !== undefined ? data.is_active : true;

    let catOptions = '';
    CATEGORIES_LIST.forEach(cat => {
        catOptions += `<option value="${cat}" ${cat === category ? 'selected' : ''}>${cat.charAt(0).toUpperCase() + cat.slice(1)}</option>`;
    });

    const khrEstimate = price ? Math.round(parseFloat(price) * STORE_EXCHANGE_RATE).toLocaleString() + ' ៛' : '';

    return `
    <tr class="batch-row" id="batchRow_${index}">
        <td class="row-num">${index + 1}</td>
        <td>
            <div class="batch-dual-input">
                <div class="input-with-flag">
                    <span class="cell-flag">🇬🇧</span>
                    <input type="text" name="products[${index}][name_en]" value="${nameEn}" placeholder="Product Name in English *" class="batch-input input-bold" required>
                </div>
                <div class="input-with-flag">
                    <span class="cell-flag">🇰🇭</span>
                    <input type="text" name="products[${index}][name_km]" value="${nameKm}" placeholder="ឈ្មោះផលិតផលជាភាសាខ្មែរ *" class="batch-input" required>
                </div>
            </div>
        </td>
        <td>
            <select name="products[${index}][category]" class="batch-select">
                ${catOptions}
            </select>
        </td>
        <td>
            <div class="batch-num-wrap">
                <span class="p-symbol">$</span>
                <input type="number" step="0.01" min="0" name="products[${index}][price]" value="${price}" placeholder="25.00" class="batch-input batch-price" required oninput="updateRowKhr(${index}, this.value)">
            </div>
            <small class="batch-row-riel" id="rowRiel_${index}">${khrEstimate}</small>
        </td>
        <td>
            <div class="batch-num-wrap">
                <span class="p-symbol">$</span>
                <input type="number" step="0.01" min="0" name="products[${index}][old_price]" value="${oldPrice}" placeholder="35.00" class="batch-input">
            </div>
        </td>
        <td>
            <input type="number" min="0" name="products[${index}][stock]" value="${stock}" class="batch-input batch-stock">
        </td>
        <td>
            <div class="batch-img-cell">
                <div class="batch-thumb-wrapper" onclick="triggerRowUpload(${index})" title="ជ្រើសរើសរូបពីកុំព្យូទ័រ (Click to upload from PC)">
                    <img src="${img}" class="batch-thumb-preview" id="thumbPreview_${index}" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'44\\' height=\\'44\\'><rect width=\\'44\\' height=\\'44\\' fill=\\'%23edf5ed\\'/><text x=\\'22\\' y=\\'28\\' font-size=\\'18\\' text-anchor=\\'middle\\'>🛍️</text></svg>'">
                    <div class="thumb-hover-overlay">
                        <span>📷</span>
                    </div>
                    <span class="thumb-source-tag is-web" id="sourceBadge_${index}">URL</span>
                </div>

                <div class="batch-img-detail">
                    <div class="input-with-icon">
                        <span class="cell-input-icon" id="inputIcon_${index}">🔗</span>
                        <input type="text" name="products[${index}][image_url]" value="${img}" placeholder="Paste Image URL or Upload..." class="batch-input batch-img-url" id="imgUrlInput_${index}" oninput="handleManualUrlChange(${index}, this.value)">
                    </div>

                    <div class="batch-img-actions">
                        <input type="file" name="products[${index}][image_file]" id="fileInput_${index}" class="hidden-file-input" accept="image/*" onchange="handleBatchFileSelect(${index}, this)">

                        <button type="button" class="btn-batch-media btn-pc-upload" onclick="triggerRowUpload(${index})" title="Upload រូបពីកុំព្យូទ័រ (Select image from PC)">
                            <span>💻 Upload PC</span>
                        </button>

                        <button type="button" class="btn-batch-media btn-preset-cycle" onclick="cycleRowImage(${index})" title="ផ្លាស់ប្តូររូបគំរូ (Cycle preset photo)">
                            <span>🎨 Preset</span>
                        </button>

                        <button type="button" class="btn-batch-media btn-clear-img" onclick="clearRowImage(${index})" title="លុបរូបចេញ (Clear image)">
                            <span>✕</span>
                        </button>
                    </div>
                </div>
            </div>
        </td>
        <td class="text-center">
            <label class="modern-mini-toggle">
                <input type="checkbox" name="products[${index}][is_active]" value="1" ${isActive ? 'checked' : ''}>
                <span class="mini-toggle-slider"></span>
            </label>
        </td>
        <td class="text-center">
            <div class="row-action-btns">
                <button type="button" class="btn-row-action btn-del-row" onclick="deleteBatchRow(${index})" title="លុបជួរនេះ">&times;</button>
            </div>
        </td>
    </tr>
    `;
}

function updateRowKhr(index, val) {
    const el = document.getElementById(`rowRiel_${index}`);
    if (!el) return;
    const num = parseFloat(val);
    if (!isNaN(num) && num > 0) {
        el.textContent = Math.round(num * STORE_EXCHANGE_RATE).toLocaleString() + ' ៛';
    } else {
        el.textContent = '';
    }
}

function triggerRowUpload(index) {
    const fileInput = document.getElementById(`fileInput_${index}`);
    if (fileInput) fileInput.click();
}

function handleBatchFileSelect(index, input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    
    const thumb = document.getElementById(`thumbPreview_${index}`);
    if (thumb) {
        thumb.src = URL.createObjectURL(file);
    }
    
    const badge = document.getElementById(`sourceBadge_${index}`);
    const icon = document.getElementById(`inputIcon_${index}`);
    const urlInput = document.getElementById(`imgUrlInput_${index}`);
    
    if (badge) {
        badge.textContent = 'PC ⏳';
        badge.className = 'thumb-source-tag is-uploading';
    }
    if (icon) icon.textContent = '📁';
    if (urlInput) urlInput.value = `Uploading: ${file.name}...`;
    
    const formData = new FormData();
    formData.append('image', file);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch('{{ route('admin.products.upload-image') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.url) {
            if (urlInput) urlInput.value = data.url;
            if (thumb) thumb.src = data.url;
            if (badge) {
                badge.textContent = 'PC ✓';
                badge.className = 'thumb-source-tag is-pc';
            }
        } else {
            throw new Error(data.message || 'Upload failed');
        }
    })
    .catch(err => {
        console.warn('Fallback to multipart submit', err);
        if (urlInput) urlInput.value = `[File]: ${file.name}`;
        if (badge) {
            badge.textContent = 'PC 📁';
            badge.className = 'thumb-source-tag is-pc';
        }
    });
}

function handleManualUrlChange(index, val) {
    const thumb = document.getElementById(`thumbPreview_${index}`);
    const badge = document.getElementById(`sourceBadge_${index}`);
    const icon = document.getElementById(`inputIcon_${index}`);
    if (thumb && val) {
        thumb.src = val;
    }
    if (badge) {
        badge.textContent = 'URL';
        badge.className = 'thumb-source-tag is-web';
    }
    if (icon) icon.textContent = '🔗';
}

function clearRowImage(index) {
    const thumb = document.getElementById(`thumbPreview_${index}`);
    const urlInput = document.getElementById(`imgUrlInput_${index}`);
    const fileInput = document.getElementById(`fileInput_${index}`);
    const badge = document.getElementById(`sourceBadge_${index}`);
    const icon = document.getElementById(`inputIcon_${index}`);
    if (thumb) thumb.src = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44"><rect width="44" height="44" fill="%23edf5ed"/><text x="22" y="28" font-size="18" text-anchor="middle">🛍️</text></svg>';
    if (urlInput) urlInput.value = '';
    if (fileInput) fileInput.value = '';
    if (badge) {
        badge.textContent = 'NONE';
        badge.className = 'thumb-source-tag is-none';
    }
    if (icon) icon.textContent = '🔗';
}

function cycleRowImage(index) {
    const randomUrl = CURATED_SAMPLE_IMAGES[Math.floor(Math.random() * CURATED_SAMPLE_IMAGES.length)];
    const urlInput = document.getElementById(`imgUrlInput_${index}`);
    const thumb = document.getElementById(`thumbPreview_${index}`);
    const badge = document.getElementById(`sourceBadge_${index}`);
    const icon = document.getElementById(`inputIcon_${index}`);
    if (urlInput) urlInput.value = randomUrl;
    if (thumb) thumb.src = randomUrl;
    if (badge) {
        badge.textContent = 'PRESET';
        badge.className = 'thumb-source-tag is-preset';
    }
    if (icon) icon.textContent = '🎨';
}

function switchSingleImageMode(mode) {
    const btnPc = document.getElementById('btnSingleTabPc');
    const btnUrl = document.getElementById('btnSingleTabUrl');
    const panelPc = document.getElementById('singlePanelPc');
    const panelUrl = document.getElementById('singlePanelUrl');
    if (!btnPc || !btnUrl) return;

    if (mode === 'pc') {
        btnPc.classList.add('is-active');
        btnUrl.classList.remove('is-active');
        if (panelPc) panelPc.style.display = 'block';
        if (panelUrl) panelUrl.style.display = 'none';
    } else {
        btnUrl.classList.add('is-active');
        btnPc.classList.remove('is-active');
        if (panelUrl) panelUrl.style.display = 'block';
        if (panelPc) panelPc.style.display = 'none';
    }
}

function handleSingleFileSelect(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const preview = document.getElementById('preview_img');
    const dropzoneTitle = document.getElementById('dropzoneTitle');
    const inputUrl = document.getElementById('input_image_url');
    
    if (preview) {
        preview.src = URL.createObjectURL(file);
    }
    if (dropzoneTitle) {
        dropzoneTitle.textContent = `✓ Selected: ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
    }
    
    const formData = new FormData();
    formData.append('image', file);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch('{{ route('admin.products.upload-image') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.url) {
            if (inputUrl) inputUrl.value = data.url;
            if (preview) preview.src = data.url;
            if (dropzoneTitle) dropzoneTitle.textContent = `✓ Uploaded: ${file.name}`;
        }
    })
    .catch(err => {
        console.warn('Fallback to multipart form upload on submit', err);
    });
}

function refreshBatchCounter() {
    const tbody = document.getElementById('batchTableBody');
    const counterEl = document.getElementById('batchRowsCount');
    const submitBtn = document.getElementById('batchSubmitBtnText');
    const count = tbody ? tbody.children.length : 0;
    if (counterEl) counterEl.textContent = count;
    if (submitBtn) submitBtn.textContent = `Save All ${count} Products at Once`;

    // Re-number rows
    if (tbody) {
        Array.from(tbody.children).forEach((row, idx) => {
            const numCell = row.querySelector('.row-num');
            if (numCell) numCell.textContent = idx + 1;
        });
    }
}

function fillSampleProducts() {
    clearBatchRows();
    const demoItems = [
        {
            name_en: 'Wireless Noise-Cancelling Headphones Pro',
            name_km: 'កាសស្តាប់ឥតខ្សែបំបាត់សំឡេងរំខានស៊េរីថ្មី',
            category: 'electronics',
            price: 49.00,
            old_price: 65.00,
            stock: 35,
            image_url: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop&q=80',
            is_active: true
        },
        {
            name_en: 'Minimalist Smart Fitness Watch',
            name_km: 'នាឡិកាឆ្លាតវៃតាមដានសុខភាព និងកីឡា',
            category: 'electronics',
            price: 69.00,
            old_price: 89.00,
            stock: 25,
            image_url: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop&q=80',
            is_active: true
        },
        {
            name_en: 'Sport Breathable Running Sneakers',
            name_km: 'ស្បែកជើងរត់ហាត់ប្រាណខ្យល់ស្រួលជើង',
            category: 'fashion',
            price: 45.00,
            old_price: 58.00,
            stock: 40,
            image_url: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&auto=format&fit=crop&q=80',
            is_active: true
        },
        {
            name_en: 'Classic Canvas Laptop Backpack',
            name_km: 'កាតាបស្ពាយធ្វើដំណើរដាក់កុំព្យូទ័រ',
            category: 'fashion',
            price: 29.50,
            old_price: 39.00,
            stock: 50,
            image_url: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&auto=format&fit=crop&q=80',
            is_active: true
        },
        {
            name_en: 'Stainless Steel Insulated Thermal Tumbler',
            name_km: 'ដបទឹកដែកអ៊ីណុកក្តៅត្រជាក់ ២៤ម៉ោង',
            category: 'kitchen',
            price: 18.00,
            old_price: 24.00,
            stock: 60,
            image_url: 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=500&auto=format&fit=crop&q=80',
            is_active: true
        }
    ];

    demoItems.forEach(item => addBatchRow(item));
}

// Parse Raw Text from Excel/CSV Paste
function loadSamplePasteText() {
    const textarea = document.getElementById('rawPasteInput');
    if (!textarea) return;
    textarea.value = `Wireless Gaming Mouse, កណ្តុរហ្គេមឥតខ្សែ, electronics, 22.50, 30.00, 45\nSport Running Shoes, ស្បែកជើងរត់ហាត់ប្រាណ, fashion, 42.00, 55.00, 35\nThermal Travel Flask, ដបទឹកក្តៅត្រជាក់រក្សាសីតុណ្ហភាព, kitchen, 16.00, 22.00, 60\nNatural Face Hydrating Serum, សេរ៉ូមបំប៉នស្បែកមុខធម្មជាតិ, beauty, 24.00, 32.00, 40\nCompact 4K Action Camera, កាមេរ៉ាខ្នាតតូច 4K, electronics, 85.00, 110.00, 20`;
}

function parsePasteIntoBatch() {
    const textarea = document.getElementById('rawPasteInput');
    if (!textarea || !textarea.value.trim()) {
        alert('សូមបិទភ្ជាប់ (Paste) ទិន្នន័យផលិតផលសិន (Please paste product lines first)');
        return;
    }

    const lines = textarea.value.trim().split('\n');
    let imported = 0;

    lines.forEach(line => {
        const trimmed = line.trim();
        if (!trimmed) return;

        // Split by tab or comma
        const parts = trimmed.includes('\t') ? trimmed.split('\t') : trimmed.split(',');
        if (parts.length >= 2) {
            const item = {
                name_en: (parts[0] || '').trim(),
                name_km: (parts[1] || '').trim(),
                category: (parts[2] || 'electronics').trim().toLowerCase(),
                price: parseFloat((parts[3] || '0').trim()) || 0,
                old_price: parts[4] ? parseFloat(parts[4].trim()) : null,
                stock: parts[5] ? parseInt(parts[5].trim()) : 50,
            };
            addBatchRow(item);
            imported++;
        }
    });

    if (imported > 0) {
        switchProductMode('batch');
        alert(`ជោគជ័យ! ទិន្នន័យចំនួន ${imported} ជួរត្រូវបានបម្លែងចូលតារាង Batch Add រួចរាល់។`);
    } else {
        alert('មិនអាចបម្លែងទិន្នន័យបានទេ។ សូមពិនិត្យទម្រង់ Format ឡើងវិញ។');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    @if (!$product->exists)
        refreshBatchCounter();
        const tbody = document.getElementById('batchTableBody');
        if (tbody && tbody.children.length === 0) {
            addBatchRows(5);
        }
    @endif

    calcSingleKhrPrice();

    const inputNameEn = document.getElementById('input_name_en');
    const inputNameKm = document.getElementById('input_name_km');
    const inputCategory = document.getElementById('input_category');
    const inputBadge = document.getElementById('input_badge');
    const inputPrice = document.getElementById('input_price');
    const inputOldPrice = document.getElementById('input_old_price');
    const inputRating = document.getElementById('input_rating');
    const inputImg = document.getElementById('input_image_url');
    const inputIsActive = document.getElementById('input_is_active');

    const previewNameEn = document.getElementById('preview_name_en');
    const previewNameKm = document.getElementById('preview_name_km');
    const previewCategory = document.getElementById('preview_category');
    const previewBadge = document.getElementById('preview_badge');
    const previewPrice = document.getElementById('preview_price');
    const previewOldPrice = document.getElementById('preview_old_price');
    const previewRating = document.getElementById('preview_rating');
    const previewImg = document.getElementById('preview_img');
    const previewStatusPill = document.getElementById('preview_status_pill');

    function updatePreview() {
        if (inputNameEn && previewNameEn) {
            previewNameEn.textContent = inputNameEn.value.trim() || 'Product Name (English)';
        }
        if (inputNameKm && previewNameKm) {
            previewNameKm.textContent = inputNameKm.value.trim() || 'ឈ្មោះផលិតផល (ភាសាខ្មែរ)';
        }
        if (inputCategory && previewCategory) {
            previewCategory.textContent = inputCategory.options[inputCategory.selectedIndex]?.text.split(' ')[0] || 'Category';
        }
        if (inputBadge && previewBadge) {
            const val = inputBadge.value.trim();
            if (val) {
                previewBadge.textContent = val;
                previewBadge.classList.remove('is-hidden');
            } else {
                previewBadge.classList.add('is-hidden');
            }
        }
        if (inputPrice && previewPrice) {
            const num = parseFloat(inputPrice.value);
            previewPrice.textContent = isNaN(num) ? '0.00' : num.toFixed(2);
        }
        if (inputOldPrice && previewOldPrice) {
            const num = parseFloat(inputOldPrice.value);
            if (!isNaN(num) && num > 0) {
                previewOldPrice.textContent = '$' + num.toFixed(2);
                previewOldPrice.classList.remove('is-hidden');
            } else {
                previewOldPrice.classList.add('is-hidden');
            }
        }
        if (inputRating && previewRating) {
            const num = parseFloat(inputRating.value);
            previewRating.textContent = isNaN(num) ? '5.0' : num.toFixed(1);
        }
        if (inputImg && previewImg) {
            const url = inputImg.value.trim();
            if (url) {
                previewImg.src = url;
            }
        }
        if (inputIsActive && previewStatusPill) {
            if (inputIsActive.checked) {
                previewStatusPill.textContent = '✓ Live in Store';
                previewStatusPill.className = 'mockup-status-tag is-live';
            } else {
                previewStatusPill.textContent = 'Draft / Hidden';
                previewStatusPill.className = 'mockup-status-tag is-hidden-tag';
            }
        }
    }

    [inputNameEn, inputNameKm, inputCategory, inputBadge, inputPrice, inputOldPrice, inputRating, inputImg].forEach(el => {
        if (el) {
            el.addEventListener('input', updatePreview);
            el.addEventListener('change', updatePreview);
        }
    });

    if (inputIsActive) {
        inputIsActive.addEventListener('change', updatePreview);
    }
});
</script>
@endsection
