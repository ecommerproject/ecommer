@extends('admin.layouts.app')

@section('title', 'Marketing & Promotions')

@section('content')
<div class="admin-marketing-view">
    <!-- Header with Breadcrumbs & Action Buttons -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">PROMOTIONS & AUDIENCE GROWTH</span>
            <h1>Marketing & Campaigns</h1>
            <p>Manage promotional discount coupons, launch newsletter email broadcasts, and grow your customer audience.</p>
        </div>
        <div class="heading-actions">
            <button type="button" class="admin-secondary-button" onclick="document.getElementById('broadcast-composer-section').scrollIntoView({behavior: 'smooth'})">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
                <span>New Broadcast</span>
            </button>
            <a href="{{ route('admin.reports.export.customers') }}" class="admin-primary-button">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export Audience</span>
            </a>
        </div>
    </div>

    <!-- Marketing Metric KPI Cards -->
    <div class="marketing-kpi-grid">
        <div class="marketing-kpi-card">
            <div class="marketing-kpi-icon icon-subscribers">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
            <div class="marketing-kpi-info">
                <span class="marketing-kpi-label">Total Subscribers</span>
                <span class="marketing-kpi-val">{{ $kpis['total_subscribers'] }}</span>
            </div>
        </div>

        <div class="marketing-kpi-card">
            <div class="marketing-kpi-icon icon-coupons">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                    <line x1="7" y1="8" x2="17" y2="8"></line>
                    <line x1="7" y1="12" x2="17" y2="12"></line>
                    <line x1="7" y1="16" x2="12" y2="16"></line>
                </svg>
            </div>
            <div class="marketing-kpi-info">
                <span class="marketing-kpi-label">Active Promotion Codes</span>
                <span class="marketing-kpi-val text-success">{{ $kpis['active_coupons'] }} Promo Codes</span>
            </div>
        </div>

        <div class="marketing-kpi-card">
            <div class="marketing-kpi-icon icon-redemptions">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <div class="marketing-kpi-info">
                <span class="marketing-kpi-label">Coupon Redemptions</span>
                <span class="marketing-kpi-val text-amber">{{ $kpis['total_redemptions'] }} used</span>
            </div>
        </div>

        <div class="marketing-kpi-card">
            <div class="marketing-kpi-icon icon-openrate">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="marketing-kpi-info">
                <span class="marketing-kpi-label">Avg. Open Engagement</span>
                <span class="marketing-kpi-val">{{ $kpis['avg_open_rate'] }}</span>
            </div>
        </div>
    </div>

    <!-- Active Promo Codes Grid -->
    <section class="admin-panel marketing-section-panel">
        <div class="panel-section-header">
            <div>
                <h3 class="panel-section-title">Active Promotional Vouchers & Discount Codes</h3>
                <p class="panel-section-sub">Promo codes that customers can enter during checkout to apply discounts.</p>
            </div>
        </div>

        <div class="coupons-grid">
            @foreach ($coupons as $coupon)
                <div class="coupon-card {{ $coupon['status'] === 'expired' ? 'is-expired' : '' }}">
                    <div class="coupon-top">
                        <span class="coupon-discount-badge" style="background: {{ $coupon['badge_color'] }};">
                            {{ $coupon['discount'] }}
                        </span>
                        <span class="coupon-status-tag status-{{ $coupon['status'] }}">
                            {{ ucfirst($coupon['status']) }}
                        </span>
                    </div>

                    <div class="coupon-code-wrap">
                        <span class="coupon-code-display">{{ $coupon['code'] }}</span>
                        <button type="button" class="btn-copy-code" onclick="navigator.clipboard.writeText('{{ $coupon['code'] }}'); alert('Copied coupon code: {{ $coupon['code'] }}');" title="Click to copy code">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                            <span>Copy</span>
                        </button>
                    </div>

                    <p class="coupon-description">{{ $coupon['description'] }}</p>

                    <div class="coupon-footer">
                        <div class="coupon-meta-item">
                            <span class="meta-label">Min. Spend</span>
                            <span class="meta-val">${{ number_format($coupon['min_spend'], 2) }}</span>
                        </div>
                        <div class="coupon-meta-item">
                            <span class="meta-label">Redeemed</span>
                            <span class="meta-val">{{ $coupon['uses_count'] }} times</span>
                        </div>
                        <div class="coupon-meta-item">
                            <span class="meta-label">Validity</span>
                            <span class="meta-val">{{ $coupon['expires_at'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Two-Column Layout: Broadcast Composer + Subscribers Table -->
    <div class="marketing-two-col-grid">
        <!-- Broadcast Composer Form -->
        <section id="broadcast-composer-section" class="admin-panel composer-panel">
            <div class="panel-section-header">
                <div>
                    <h3 class="panel-section-title">📢 Launch Newsletter Broadcast</h3>
                    <p class="panel-section-sub">Send promotional emails and new arrival announcements directly to your audience.</p>
                </div>
            </div>

            <form action="{{ route('admin.marketing.broadcast') }}" method="POST" class="broadcast-form">
                @csrf
                <div class="admin-form-group">
                    <label class="admin-form-label" for="broadcast-subject">Email Subject Line *</label>
                    <input type="text" id="broadcast-subject" name="subject" class="admin-form-input" required placeholder="e.g., 🎉 Weekend Special: 15% Off All Electronics & Fashion!" value="🎉 Exclusive weekend deals just for you!">
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="broadcast-audience">Target Audience Segment</label>
                    <select id="broadcast-audience" name="audience" class="admin-form-select">
                        <option value="all">All Active Subscribers ({{ $kpis['total_subscribers'] }} members)</option>
                        <option value="vip">Frequent Buyers & VIPs</option>
                        <option value="new">New Subscribers (Past 30 Days)</option>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="broadcast-message">Email Announcement Message *</label>
                    <textarea id="broadcast-message" name="message" class="admin-form-textarea" rows="4" required placeholder="Write your promotion message here...">Hello valued customer,

We're excited to offer you an exclusive discount this weekend at Dara Market! Use promo code DARA10 at checkout to enjoy 10% off your entire order.

Shop the freshest arrivals now!</textarea>
                </div>

                <div class="broadcast-submit-row">
                    <button type="submit" class="admin-primary-button">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                        <span>Send Broadcast Now</span>
                    </button>
                    <span class="delivery-notice">Sent via Dara Market Mail Gateway</span>
                </div>
            </form>
        </section>

        <!-- Subscribers List Panel -->
        <section class="admin-panel subscribers-panel">
            <div class="panel-section-header">
                <div>
                    <h3 class="panel-section-title">Newsletter Community ({{ $subscribers->total() }})</h3>
                    <p class="panel-section-sub">Verified emails signed up for store announcements.</p>
                </div>
            </div>

            <!-- Search Bar -->
            <form action="{{ route('admin.marketing.index') }}" method="GET" class="subscribers-search-bar">
                <div class="search-input-group">
                    <svg class="search-field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <label class="sr-only" for="sub-search">Search subscribers</label>
                    <input id="sub-search" type="search" name="q" value="{{ $search }}" placeholder="Search subscriber email...">
                </div>
                <button type="submit" class="admin-primary-button" style="padding: 7px 14px;">Find</button>
                @if ($search !== '')
                    <a href="{{ route('admin.marketing.index') }}" class="admin-secondary-button">Reset</a>
                @endif
            </form>

            <!-- Subscribers Table -->
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Email Address</th>
                            <th>Subscribed Date</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscribers as $sub)
                            <tr>
                                <td>
                                    <div class="sub-email-cell">
                                        <span class="sub-avatar-circle">{{ strtoupper(substr($sub->email, 0, 1)) }}</span>
                                        <span class="sub-email-text">{{ $sub->email }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="sub-date">{{ \Illuminate\Support\Carbon::parse($sub->created_at)->format('M d, Y') }}</span>
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.marketing.subscribers.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Remove subscriber {{ $sub->email }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove-sub" title="Unsubscribe">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="admin-empty-state">
                                    <p>No subscribers found matching your search.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($subscribers->hasPages())
                <div class="admin-pagination-footer">
                    {{ $subscribers->links() }}
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
