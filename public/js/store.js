const cartStorageKey = 'dara-market-cart';
const favoritesStorageKey = 'dara-market-favorites';
const toast = document.querySelector('.toast-message');
const translations = window.storeTranslations;
const catalogGrid = document.querySelector('.catalog-grid');
const searchInput = document.querySelector('#store-search');
const requestedCategory = new URLSearchParams(window.location.search).get('category');
const productFilters = {
    category: catalogGrid?.dataset.selectedCategory
        || (requestedCategory && document.querySelector(`.category-tab[data-filter="${CSS.escape(requestedCategory)}"]`) ? requestedCategory : 'all'),
    search: searchInput?.value.trim().toLocaleLowerCase() || '',
    favoritesOnly: false,
    sort: 'featured',
};
let toastTimeout;

function readCart() {
    try {
        const cart = JSON.parse(localStorage.getItem(cartStorageKey) || '{"count":0,"total":0,"items":[]}');
        if (Number.isFinite(cart.count) && Number.isFinite(cart.total)) {
            if (!Array.isArray(cart.items)) cart.items = [];
            return cart;
        }
    } catch (error) {
        console.error('Could not read saved cart.', error);
    }

    return { count: 0, total: 0, items: [] };
}

function updateCart(cart) {
    document.querySelectorAll('.cart-count').forEach((element) => {
        element.textContent = String(cart.count);
    });
    document.querySelectorAll('.cart-total').forEach((element) => {
        element.textContent = cart.total.toFixed(2);
    });
    localStorage.setItem(cartStorageKey, JSON.stringify(cart));
    if (typeof window.renderMiniCart === 'function') {
        window.renderMiniCart();
    }
}

function readFavorites() {
    try {
        const favorites = JSON.parse(localStorage.getItem(favoritesStorageKey) || '[]');
        if (Array.isArray(favorites) && favorites.every((id) => typeof id === 'string')) {
            return new Set(favorites);
        }
        console.error('Saved favorites are invalid; starting with an empty list.');
    } catch (error) {
        console.error('Could not read saved favorites.', error);
    }

    return new Set();
}

const favoriteIds = readFavorites();

function saveFavorites() {
    localStorage.setItem(favoritesStorageKey, JSON.stringify([...favoriteIds]));
}

function showToast(message) {
    if (!toast) return;

    toast.textContent = message;
    toast.classList.add('visible');
    window.clearTimeout(toastTimeout);
    toastTimeout = window.setTimeout(() => toast.classList.remove('visible'), 2600);
}
window.showToast = showToast;

function renderProducts() {
    let visibleProducts = 0;

    document.querySelectorAll('.product-grid').forEach((grid) => {
        const cards = [...grid.querySelectorAll('.product-card')];
        cards.sort((first, second) => {
            if (productFilters.sort === 'price-asc') {
                return Number(first.dataset.price) - Number(second.dataset.price);
            }
            if (productFilters.sort === 'price-desc') {
                return Number(second.dataset.price) - Number(first.dataset.price);
            }
            if (productFilters.sort === 'rating') {
                return Number(second.dataset.rating) - Number(first.dataset.rating);
            }
            return Number(first.dataset.order) - Number(second.dataset.order);
        });

        const isFeaturedGrid = grid.id === 'featured-grid';
        const maxLimit = isFeaturedGrid ? 4 : Infinity;
        let countInGrid = 0;

        cards.forEach((card) => {
            const matchesCategory = isFeaturedGrid || catalogGrid
                ? (productFilters.category === 'all' || card.dataset.category === productFilters.category)
                : true;
            const matchesSearch = card.dataset.search.toLocaleLowerCase().includes(productFilters.search);
            const matchesFavorite = !productFilters.favoritesOnly || favoriteIds.has(card.dataset.productId);
            const matches = matchesCategory && matchesSearch && matchesFavorite;

            if (matches && countInGrid < maxLimit) {
                card.hidden = false;
                countInGrid += 1;
                visibleProducts += 1;
            } else {
                card.hidden = true;
            }
            grid.append(card);
        });
    });

    document.querySelectorAll('.category-tab, .category-link').forEach((button) => {
        const active = button.dataset.filter === productFilters.category;
        button.classList.toggle('active', active);
        button.classList.toggle('selected', active);
    });

    document.querySelectorAll('.favorite-button').forEach((button) => {
        const card = button.closest('.product-card');
        const isFavorite = favoriteIds.has(card.dataset.productId);
        button.setAttribute('aria-pressed', String(isFavorite));
        button.setAttribute('aria-label', isFavorite ? button.dataset.labelRemove : button.dataset.labelAdd);
    });

    const favoriteFilter = document.querySelector('.wishlist-filter');
    if (favoriteFilter) {
        favoriteFilter.setAttribute('aria-pressed', String(productFilters.favoritesOnly));
        favoriteFilter.querySelector('.wishlist-filter-label').textContent = productFilters.favoritesOnly
            ? favoriteFilter.dataset.labelSaved
            : favoriteFilter.dataset.labelAll;
        favoriteFilter.querySelector('.wishlist-count').textContent = String(favoriteIds.size);
    }

    const productCount = document.querySelector('.product-count');
    if (productCount) {
        const label = visibleProducts === 1 ? productCount.dataset.singular : productCount.dataset.plural;
        productCount.textContent = `${visibleProducts} ${label}`;
    }

    const emptyResults = document.querySelector('.empty-results');
    if (emptyResults) {
        emptyResults.hidden = visibleProducts !== 0;
        emptyResults.textContent = productFilters.favoritesOnly
            ? emptyResults.dataset.emptyFavorites
            : emptyResults.dataset.emptySearch;
    }
}

document.addEventListener('click', (event) => {
    const filterButton = event.target.closest('[data-filter]');
    if (filterButton) {
        productFilters.category = filterButton.dataset.filter;
        if (catalogGrid) {
            const url = new URL(window.location.href);
            if (productFilters.category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', productFilters.category);
            }
            window.history.replaceState({}, '', url);
        }
        renderProducts();
        document.querySelector('.category-sidebar')?.classList.remove('is-expanded');
    }

    const addButton = event.target.closest('.quick-add');
    if (addButton) {
        const cart = readCart();
        const card = addButton.closest('.product-card');
        const productId = card ? card.dataset.productId : (addButton.dataset.id || String(Date.now()));
        const productName = addButton.dataset.name || 'Product';
        const productPrice = Number(addButton.dataset.price) || 0;
        const productImg = card?.querySelector('.product-image')?.getAttribute('src') || '';

        if (!Array.isArray(cart.items)) {
            cart.items = [];
        }

        const existingItem = cart.items.find((item) => String(item.id) === String(productId));
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.items.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImg,
                quantity: 1
            });
        }

        cart.count = cart.items.reduce((sum, item) => sum + item.quantity, 0);
        cart.total = cart.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        updateCart(cart);
        showToast(`${productName}${translations.added_suffix}`);
    }

    const favoriteButton = event.target.closest('.favorite-button');
    if (favoriteButton) {
        const productId = favoriteButton.closest('.product-card').dataset.productId;
        const isFavorite = favoriteIds.has(productId);
        if (isFavorite) {
            favoriteIds.delete(productId);
        } else {
            favoriteIds.add(productId);
        }
        saveFavorites();
        renderProducts();
        showToast(isFavorite ? translations.removed_favorite : translations.added_favorite);
    }

    const wishlistFilter = event.target.closest('.wishlist-filter');
    if (wishlistFilter) {
        productFilters.favoritesOnly = !productFilters.favoritesOnly;
        renderProducts();
    }

    const scrollButton = event.target.closest('[data-scroll-target]');
    if (scrollButton) {
        document.getElementById(scrollButton.dataset.scrollTarget)?.scrollBy({ left: 240, behavior: 'smooth' });
    }
});

searchInput?.addEventListener('input', (event) => {
    productFilters.search = event.target.value.trim().toLocaleLowerCase();
    renderProducts();
});

document.querySelector('#product-sort')?.addEventListener('change', (event) => {
    productFilters.sort = event.target.value;
    renderProducts();
});

// Note: .menu-toggle is handled globally by window.toggleMobileNav(event) in app.blade.php

document.querySelector('.category-sidebar .sidebar-title')?.addEventListener('click', (event) => {
    const sidebar = document.querySelector('.category-sidebar');
    const isExpanded = sidebar.classList.toggle('is-expanded');
    event.currentTarget.setAttribute('aria-expanded', String(isExpanded));
});

document.querySelector('.newsletter-form')?.addEventListener('submit', async (event) => {
    event.preventDefault();

    const form = event.currentTarget;
    const message = document.querySelector('.newsletter-message');
    const button = form.querySelector('button[type="submit"]');
    const formData = new FormData(form);

    if (message) {
        message.textContent = '';
        message.classList.remove('error', 'success');
    }
    if (button) button.disabled = true;

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
        const result = await response.json();

        if (!response.ok) {
            const validationMessage = result.errors?.email?.[0];
            if (message) {
                message.textContent = validationMessage || result.message || translations.newsletter_error;
                message.classList.add('error');
            }
            return;
        }

        if (message) {
            message.textContent = result.message || translations.newsletter_success;
            message.classList.add('success');
        }
        form.reset();
    } catch (error) {
        console.error('Could not submit newsletter subscription.', error);
        if (message) {
            message.textContent = translations.newsletter_error;
            message.classList.add('error');
        }
    } finally {
        if (button) button.disabled = false;
    }
});

updateCart(readCart());
renderProducts();

// Modern Real-time Category Sidebar Quick Search
const catSidebarSearch = document.getElementById('catSidebarSearch');
if (catSidebarSearch) {
    catSidebarSearch.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        const categoryButtons = document.querySelectorAll('.category-links-list .category-link');
        let matchedCount = 0;

        categoryButtons.forEach((btn) => {
            const name = (btn.dataset.categoryName || btn.textContent).toLowerCase();
            const matches = !query || name.includes(query);
            btn.style.display = matches ? 'flex' : 'none';
            if (matches) matchedCount++;
        });

        const badge = document.querySelector('.cat-search-badge');
        if (badge) {
            badge.textContent = String(matchedCount);
        }
    });
}

