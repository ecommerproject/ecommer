<article class="product-card" data-product-id="{{ $product['id'] }}" data-order="{{ $product['order'] }}" data-price="{{ $product['price'] }}" data-rating="{{ $product['rating'] }}" data-category="{{ $product['filter_key'] }}" data-search="{{ $product['name'] }} {{ $product['category'] }}" {{ !empty($isHidden) ? 'hidden' : '' }}>
    <div class="product-image-wrap">
        <a href="{{ route('store.products.show', $product['id']) }}" class="product-image-link" aria-label="{{ $product['name'] }}">
            <img
                class="product-image"
                src="{{ $product['image'] }}"
                alt="{{ $product['name'] }}"
                loading="lazy"
                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=640&q=85';"
            >
        </a>
        @if ($product['badge'])
            @php
                $isDiscount = str_contains($product['badge'], '%') || str_contains($product['badge'], '-');
                $badgeLabel = $product['badge'];
                if ($badgeLabel === 'best_seller') {
                    $badgeLabel = app()->getLocale() === 'km' ? 'លក់ដាច់បំផុត' : 'Best Seller';
                } elseif ($badgeLabel === 'popular') {
                    $badgeLabel = app()->getLocale() === 'km' ? 'ពេញនិយម' : 'Popular';
                }
                $customColor = $product['badge_color'] ?? null;
                $isPulse = ($product['badge_style'] ?? '') === 'pulse';
            @endphp
            <span class="product-badge {{ $isDiscount ? 'discount-badge' : 'highlight-badge' }} {{ $isPulse ? 'badge-pulse-glow' : '' }}"
                @if ($customColor)
                    style="background: {{ $customColor }}; border-color: rgba(255,255,255,0.4); color: #ffffff;"
                @endif
            >
                @if ($isDiscount)
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82zM7 5a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>
                @else
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                @endif
                <span>{{ $badgeLabel }}</span>
            </span>
        @endif
        <button class="favorite-button" type="button" aria-label="{{ $translations['js']['add_favorite'] }}" data-label-add="{{ $translations['js']['add_favorite'] }}" data-label-remove="{{ $translations['js']['remove_favorite'] }}" aria-pressed="false" title="{{ $translations['js']['add_favorite'] }}">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.8 8.8c0 5.1-8.8 10-8.8 10s-8.8-4.9-8.8-10a4.6 4.6 0 0 1 8.8-1.9 4.6 4.6 0 0 1 8.8 1.9Z"></path></svg>
        </button>
        <button class="quick-add" type="button" data-id="{{ $product['id'] }}" data-price="{{ $product['price'] }}" data-name="{{ $product['name'] }}" data-image="{{ $product['image'] }}" onclick="if(window.storeAddToCart){ event.preventDefault(); event.stopPropagation(); window.storeAddToCart('{{ $product['id'] }}', '{{ addslashes($product['name']) }}', {{ $product['price'] }}, 1, '{{ $product['image'] }}'); }">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.9a2 2 0 0 0 1.9-1.5L22 8H6"></path><circle cx="10" cy="20" r="1.2"></circle><circle cx="18" cy="20" r="1.2"></circle></svg>
            <span>{{ $translations['cart']['add'] }}</span>
        </button>
    </div>
    <div class="product-info">
        <span class="product-category">{{ $product['category'] }}</span>
        <h3><a href="{{ route('store.products.show', $product['id']) }}" class="product-title-link">{{ $product['name'] }}</a></h3>
        <div class="product-meta">
            <span class="rating">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="#eab308"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                <strong>{{ $product['rating'] }}</strong>
            </span>
            <span class="price">
                <strong>${{ number_format($product['price'], 2) }}</strong>
                @if ($product['old_price'] !== null)
                    <del>${{ number_format($product['old_price'], 2) }}</del>
                @endif
            </span>
        </div>
    </div>
</article>
