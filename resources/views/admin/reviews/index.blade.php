@extends('admin.layouts.app')

@section('title', 'Reviews & Ratings')

@section('content')
<div class="admin-reviews-view">
    <!-- Header with Breadcrumbs & Action Buttons -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">CUSTOMER FEEDBACK & REPUTATION</span>
            <h1>Customer Reviews & Ratings</h1>
            <p>Moderate customer testimonials, audit product satisfaction scores, and publish official store replies.</p>
        </div>
        <div class="heading-actions">
            @if ($stats['pending_count'] > 0)
                <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="admin-secondary-button pending-alert-btn">
                    <span class="status-dot-amber"></span>
                    <span>{{ $stats['pending_count'] }} Pending Approvals</span>
                </a>
            @endif
            <a href="{{ route('store.products') }}" target="_blank" class="admin-primary-button">
                <span>View Storefront</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="7" y1="17" x2="17" y2="7"></line>
                    <polyline points="7 7 17 7 17 17"></polyline>
                </svg>
            </a>
        </div>
    </div>

    <!-- Review Metric KPI Cards -->
    <div class="reviews-kpi-grid">
        <div class="review-kpi-card highlight-rating">
            <div class="review-kpi-icon icon-star">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
            <div class="review-kpi-info">
                <span class="review-kpi-label">Average Store Rating</span>
                <span class="review-kpi-val text-amber">{{ number_format($stats['avg_rating'], 1) }} / 5.0</span>
            </div>
        </div>

        <div class="review-kpi-card">
            <div class="review-kpi-icon icon-reviews">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <div class="review-kpi-info">
                <span class="review-kpi-label">Total Reviews</span>
                <span class="review-kpi-val">{{ $stats['total_reviews'] }}</span>
            </div>
        </div>

        <div class="review-kpi-card">
            <div class="review-kpi-icon icon-pending">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 14 14"></polyline>
                </svg>
            </div>
            <div class="review-kpi-info">
                <span class="review-kpi-label">Needs Moderation</span>
                <span class="review-kpi-val {{ $stats['pending_count'] > 0 ? 'text-amber' : 'text-muted' }}">{{ $stats['pending_count'] }} pending</span>
            </div>
        </div>

        <div class="review-kpi-card">
            <div class="review-kpi-icon icon-satisfaction">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                </svg>
            </div>
            <div class="review-kpi-info">
                <span class="review-kpi-label">5-Star Satisfaction</span>
                <span class="review-kpi-val text-success">{{ $stats['satisfaction_rate'] }}%</span>
            </div>
        </div>
    </div>

    <!-- Filter and Search Bar -->
    <section class="admin-panel admin-reviews-panel">
        <form class="admin-filter-bar modern-filter-bar" action="{{ route('admin.reviews.index') }}" method="GET">
            <div class="search-input-group">
                <svg class="search-field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <label class="sr-only" for="review-search">Search reviews</label>
                <input id="review-search" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search by customer name, product, or comment keyword...">
            </div>

            <div class="filter-controls-row">
                <div class="filter-select-wrapper">
                    <label class="filter-label">Star Rating</label>
                    <select name="rating" onchange="this.form.submit()">
                        <option value="all">All Ratings</option>
                        <option value="5" @selected(($filters['rating'] ?? '') === '5')>★★★★★ (5 Stars)</option>
                        <option value="4" @selected(($filters['rating'] ?? '') === '4')>★★★★☆ (4 Stars)</option>
                        <option value="3" @selected(($filters['rating'] ?? '') === '3')>★★★☆☆ (3 Stars)</option>
                        <option value="2" @selected(($filters['rating'] ?? '') === '2')>★★☆☆☆ (2 Stars)</option>
                        <option value="1" @selected(($filters['rating'] ?? '') === '1')>★☆☆☆☆ (1 Star)</option>
                    </select>
                </div>

                <div class="filter-select-wrapper">
                    <label class="filter-label">Status</label>
                    <select name="status" onchange="this.form.submit()">
                        <option value="all" @selected(($filters['status'] ?? 'all') === 'all')>All Statuses</option>
                        <option value="approved" @selected(($filters['status'] ?? '') === 'approved')>Approved</option>
                        <option value="pending" @selected(($filters['status'] ?? '') === 'pending')>Pending Moderation</option>
                        <option value="rejected" @selected(($filters['status'] ?? '') === 'rejected')>Rejected / Hidden</option>
                    </select>
                </div>

                <button class="admin-primary-button filter-submit-btn" type="submit">Filter</button>
                @if (($filters['q'] ?? '') !== '' || ($filters['rating'] ?? 'all') !== 'all' || ($filters['status'] ?? 'all') !== 'all')
                    <a class="admin-secondary-button filter-clear-btn" href="{{ route('admin.reviews.index') }}">Reset</a>
                @endif
            </div>
        </form>

        <!-- Reviews Moderation Feed -->
        <div class="reviews-list-container">
            @forelse ($reviews as $review)
                <div class="review-item-card status-border-{{ $review->status }}">
                    <div class="review-card-header">
                        <div class="reviewer-meta-box">
                            <span class="reviewer-avatar">{{ strtoupper(substr($review->customer_name, 0, 1)) }}</span>
                            <div class="reviewer-details">
                                <div class="reviewer-name-row">
                                    <strong class="reviewer-name">{{ $review->customer_name }}</strong>
                                    @if ($review->is_verified_buyer)
                                        <span class="verified-badge">✓ Verified Buyer</span>
                                    @endif
                                </div>
                                <span class="reviewer-email">{{ $review->customer_email }} • {{ $review->created_at?->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="review-status-rating">
                            <!-- Star Rating -->
                            <div class="review-stars-wrap">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star-icon {{ $i <= $review->rating ? 'is-filled' : 'is-empty' }}">★</span>
                                @endfor
                                <span class="rating-number">({{ $review->rating }}.0)</span>
                            </div>

                            <!-- Moderation Badge -->
                            <span class="review-status-pill status-{{ $review->status }}">
                                <span class="status-dot"></span>
                                <span>{{ ucfirst($review->status) }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Associated Product Info Bar -->
                    @if ($review->product)
                        <div class="review-product-bar">
                            <div class="product-mini-thumb">
                                <img src="{{ $review->product->image_url }}" alt="{{ $review->product->name_en }}" loading="lazy" onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\' viewBox=\'0 0 40 40\'><rect width=\'40\' height=\'40\' fill=\'%23edf5ed\'/><text x=\'20\' y=\'24\' font-size=\'14\' text-anchor=\'middle\'>🛍️</text></svg>';">
                            </div>
                            <div class="product-mini-info">
                                <a href="{{ route('admin.products.edit', $review->product) }}" class="product-mini-name">{{ $review->product->name_en }}</a>
                                <span class="product-mini-cat">{{ ucfirst($review->product->category) }} • ${{ number_format((float) $review->product->price, 2) }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Review Content Body -->
                    <div class="review-content-body">
                        @if ($review->review_title)
                            <h4 class="review-title-text">{{ $review->review_title }}</h4>
                        @endif
                        <p class="review-body-text">{{ $review->review_body }}</p>
                    </div>

                    <!-- Store Admin Reply Display -->
                    @if ($review->admin_reply)
                        <div class="admin-reply-box">
                            <div class="admin-reply-head">
                                <span class="store-badge">🏪 Dara Market Store Manager</span>
                                <span class="reply-time">Official Response</span>
                            </div>
                            <p class="admin-reply-text">{{ $review->admin_reply }}</p>
                        </div>
                    @endif

                    <!-- Moderation Actions Toolbar -->
                    <div class="review-actions-toolbar">
                        <div class="left-actions">
                            @if ($review->status !== 'approved')
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action-approve">✓ Approve & Publish</button>
                                </form>
                            @endif

                            @if ($review->status !== 'rejected')
                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action-reject">⊘ Reject</button>
                                </form>
                            @endif

                            <button type="button" class="btn-action-toggle-reply" onclick="const f = document.getElementById('reply-form-{{ $review->id }}'); f.style.display = f.style.display === 'none' ? 'block' : 'none';">
                                💬 {{ $review->admin_reply ? 'Edit Reply' : 'Reply as Store' }}
                            </button>
                        </div>

                        <div class="right-actions">
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-delete">Delete</button>
                            </form>
                        </div>
                    </div>

                    <!-- Inline Reply Form (Collapsed by default) -->
                    <form id="reply-form-{{ $review->id }}" action="{{ route('admin.reviews.reply', $review) }}" method="POST" class="inline-reply-form" style="display: none;">
                        @csrf
                        <label class="sr-only" for="reply-input-{{ $review->id }}">Your reply</label>
                        <textarea id="reply-input-{{ $review->id }}" name="admin_reply" class="admin-form-textarea" rows="2" placeholder="Write an official response from Dara Market..." required>{{ $review->admin_reply }}</textarea>
                        <div class="reply-form-actions">
                            <button type="submit" class="admin-primary-button" style="padding: 6px 14px; font-size: 12px;">Publish Response</button>
                            <button type="button" class="admin-secondary-button" style="padding: 6px 14px; font-size: 12px;" onclick="document.getElementById('reply-form-{{ $review->id }}').style.display = 'none';">Cancel</button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="admin-empty-state">
                    <div class="empty-state-wrap">
                        <div class="empty-icon">⭐</div>
                        <h3>No reviews found</h3>
                        <p>There are no customer reviews matching your selected criteria.</p>
                        <div class="empty-actions">
                            <a href="{{ route('admin.reviews.index') }}" class="admin-secondary-button">Reset filters</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($reviews->hasPages())
            <div class="admin-pagination-footer">
                <span class="pagination-summary">
                    Showing <strong>{{ $reviews->firstItem() ?? 0 }}</strong> to <strong>{{ $reviews->lastItem() ?? 0 }}</strong> of <strong>{{ $reviews->total() }}</strong> reviews
                </span>
                <div class="pagination-links">
                    {{ $reviews->links() }}
                </div>
            </div>
        @endif
    </section>
</div>
@endsection
