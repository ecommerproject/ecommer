@extends('admin.layouts.app')

@section('title', 'Customers & CRM | Dara Market')

@section('content')
<div class="admin-customers-view">
    <!-- Header with Action Buttons -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">STORE ACCOUNTS & CRM • គ្រប់គ្រងអតិថិជន</span>
            <h1>Customers Management</h1>
            <p>Monitor customer lifetime value, manage buyer profiles, track order history, and handle account credentials.</p>
        </div>
        <div class="heading-actions customers-head-actions">
            <button type="button" class="cust-btn-add" onclick="openAddCustomerModal()">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                <span>+ Add Customer</span>
            </button>
            <a href="{{ route('admin.customers.export') }}" class="cust-btn-export" title="Export customers data as UTF-8 CSV">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="admin-secondary-button">
                <span>View Orders</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
    </div>

    <!-- Luxury CRM KPI Cards -->
    <div class="customers-stats-grid">
        <div class="cust-stat-card card-primary">
            <div class="cust-stat-icon icon-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="cust-stat-info">
                <span class="cust-stat-label">Total Customers • សមាជិកសរុប</span>
                <div class="cust-stat-val-row">
                    <span class="cust-stat-num" id="stat-total-cust">{{ $stats['total'] }}</span>
                    <span class="cust-stat-badge badge-green">+{{ $stats['new_this_month'] }} new</span>
                </div>
                <span class="cust-stat-sub">Registered buyer accounts</span>
            </div>
        </div>

        <div class="cust-stat-card card-gold">
            <div class="cust-stat-icon icon-gold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
            <div class="cust-stat-info">
                <span class="cust-stat-label">Customer Lifetime Value • ចំណូលសរុប</span>
                <div class="cust-stat-val-row">
                    <span class="cust-stat-num text-success">${{ number_format($stats['total_revenue'], 2) }}</span>
                </div>
                <span class="cust-stat-sub">Total revenue across all customers</span>
            </div>
        </div>

        <div class="cust-stat-card card-blue">
            <div class="cust-stat-icon icon-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
            </div>
            <div class="cust-stat-info">
                <span class="cust-stat-label">Active Buyers • អ្នកបញ្ជាទិញសកម្ម</span>
                <div class="cust-stat-val-row">
                    <span class="cust-stat-num">{{ $stats['buyers'] }}</span>
                    @php
                        $buyerPct = $stats['total'] > 0 ? round(($stats['buyers'] / $stats['total']) * 100) : 0;
                    @endphp
                    <span class="cust-stat-badge badge-green">{{ $buyerPct }}% active</span>
                </div>
                <span class="cust-stat-sub">{{ $stats['vip'] }} VIP high-value members</span>
            </div>
        </div>

        <div class="cust-stat-card card-emerald">
            <div class="cust-stat-icon icon-emerald">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    <polyline points="9 12 11 14 15 10"></polyline>
                </svg>
            </div>
            <div class="cust-stat-info">
                <span class="cust-stat-label">Verified Accounts • គណនីផ្ទៀងផ្ទាត់</span>
                <div class="cust-stat-val-row">
                    <span class="cust-stat-num">{{ $stats['verified'] }}</span>
                    <span class="cust-stat-badge badge-green">Protected</span>
                </div>
                <span class="cust-stat-sub">Verified email addresses</span>
            </div>
        </div>
    </div>

    <!-- Segment Tabs Navigation -->
    <div class="customers-tabs-container">
        <button type="button" class="cust-tab-btn {{ $activeTab === 'all' ? 'active' : '' }}" onclick="switchCustomerTab('all', this)">
            <span>All Customers</span>
            <span class="tab-badge" id="tab-count-all">{{ $stats['total'] }}</span>
        </button>
        <button type="button" class="cust-tab-btn {{ $activeTab === 'buyers' ? 'active' : '' }}" onclick="switchCustomerTab('buyers', this)">
            <span>Active Buyers</span>
            <span class="tab-badge" id="tab-count-buyers">{{ $stats['buyers'] }}</span>
        </button>
        <button type="button" class="cust-tab-btn {{ $activeTab === 'vip' ? 'active' : '' }}" onclick="switchCustomerTab('vip', this)">
            <span>VIP Spenders ⭐</span>
            <span class="tab-badge" id="tab-count-vip">{{ $stats['vip'] }}</span>
        </button>
        <button type="button" class="cust-tab-btn {{ $activeTab === 'verified' ? 'active' : '' }}" onclick="switchCustomerTab('verified', this)">
            <span>Verified</span>
            <span class="tab-badge" id="tab-count-verified">{{ $stats['verified'] }}</span>
        </button>
        <button type="button" class="cust-tab-btn {{ $activeTab === 'new' ? 'active' : '' }}" onclick="switchCustomerTab('new', this)">
            <span>New Members</span>
            <span class="tab-badge" id="tab-count-new">{{ $stats['new_this_month'] }}</span>
        </button>
    </div>

    <!-- Main Customers CRM Card -->
    <section class="admin-panel admin-customers-card">
        <!-- Live Search and Action Bar -->
        <div class="cust-filter-bar">
            <div class="cust-search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input id="customer-live-search" class="cust-search-input" type="search" placeholder="Search customer by name, email, phone, location or member #..." autocomplete="off">
                <button type="button" id="clear-search-btn" class="cust-search-clear" onclick="clearLiveSearch()" title="Clear search">✕</button>
            </div>

            <div class="filter-controls-row">
                <span class="admin-count-pill" id="showing-counter">
                    Showing <strong id="visible-count">{{ $customers->count() }}</strong> of {{ $stats['total'] }} customers
                </span>
            </div>
        </div>

        <!-- Customers Table -->
        <div class="admin-table-wrap">
            <table class="admin-table modern-products-table" id="customers-table">
                <thead>
                    <tr>
                        <th style="width: 44px; text-align: center;">
                            <input type="checkbox" id="select-all-customers" onchange="toggleSelectAllCustomers(this)" title="Select all customers">
                        </th>
                        <th style="width: 250px;">Customer Profile</th>
                        <th style="width: 240px;">Contact Details</th>
                        <th>Delivery Location</th>
                        <th style="width: 140px;">Orders & LTV</th>
                        <th style="width: 130px;">Account Status</th>
                        <th style="width: 140px;">Joined</th>
                        <th style="text-align: right; width: 170px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="customers-table-body">
                    @php
                        $avatarGradients = [
                            'linear-gradient(135deg, #10b981 0%, #047857 100%)',
                            'linear-gradient(135deg, #6366f1 0%, #4338ca 100%)',
                            'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
                            'linear-gradient(135deg, #ec4899 0%, #be185d 100%)',
                            'linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%)',
                            'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)',
                            'linear-gradient(135deg, #14b8a6 0%, #0f766e 100%)',
                        ];
                    @endphp

                    @forelse ($customers as $index => $customer)
                        @php
                            $grad = $avatarGradients[$customer->id % count($avatarGradients)];
                            $initials = strtoupper(substr($customer->name, 0, 1));
                            $isVip = $customer->is_vip ?? false;
                            $hasOrders = ($customer->orders_count ?? 0) > 0;
                            $isVerified = !empty($customer->email_verified_at);
                            $isNew = $customer->created_at >= now()->subDays(30);

                            // Customer JSON payload for instant zero-latency modals
                            $customerData = [
                                'id' => $customer->id,
                                'name' => $customer->name,
                                'email' => $customer->email,
                                'phone' => $customer->phone ?? '',
                                'address' => $customer->address ?? '',
                                'is_verified' => $isVerified,
                                'orders_count' => $customer->orders_count ?? 0,
                                'total_spent' => $customer->total_spent ?? 0,
                                'paid_spent' => $customer->paid_spent ?? 0,
                                'is_vip' => $isVip,
                                'joined_date' => $customer->created_at?->format('d M Y, h:i A') ?? 'N/A',
                                'avatar_bg' => $grad,
                                'initials' => $initials,
                                'orders' => $customer->customer_orders ?? [],
                            ];
                        @endphp
                        <tr class="customer-row" 
                            id="cust-row-{{ $customer->id }}"
                            data-id="{{ $customer->id }}"
                            data-name="{{ strtolower($customer->name) }}"
                            data-email="{{ strtolower($customer->email) }}"
                            data-phone="{{ strtolower($customer->phone ?? '') }}"
                            data-address="{{ strtolower($customer->address ?? '') }}"
                            data-has-orders="{{ $hasOrders ? '1' : '0' }}"
                            data-is-vip="{{ $isVip ? '1' : '0' }}"
                            data-is-verified="{{ $isVerified ? '1' : '0' }}"
                            data-is-new="{{ $isNew ? '1' : '0' }}"
                            data-customer='@json($customerData)'>
                            
                            <td style="text-align: center;">
                                <input type="checkbox" class="cust-row-check" value="{{ $customer->id }}" onchange="handleCustCheckChange()">
                            </td>

                            <td>
                                <div class="customer-cell">
                                    <div class="customer-avatar-box">
                                        <div class="cust-avatar" style="background: {{ $grad }};">
                                            {{ $initials }}
                                        </div>
                                        @if ($isVip)
                                            <span class="cust-vip-star" title="VIP High-Value Customer">⭐</span>
                                        @endif
                                    </div>
                                    <div class="cust-info-col">
                                        <div class="cust-name-line">
                                            <strong class="cust-name-text row-name">{{ $customer->name }}</strong>
                                            @if ($isVip)
                                                <span class="badge-vip-pill">VIP</span>
                                            @endif
                                        </div>
                                        <small class="cust-member-id">ID #{{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="cust-contact-cell">
                                    <div class="cust-email-row">
                                        <a href="mailto:{{ $customer->email }}" class="cust-email-link row-email">{{ $customer->email }}</a>
                                        <button type="button" class="btn-copy-email" onclick="copyToClipboard('{{ $customer->email }}', this)" title="Copy email address">
                                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @if ($customer->phone)
                                        <div class="cust-phone-row">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                            </svg>
                                            <a href="tel:{{ $customer->phone }}" class="row-phone" style="color: inherit; text-decoration: none;">{{ $customer->phone }}</a>
                                        </div>
                                    @else
                                        <div class="cust-phone-row text-muted" style="font-style: italic;">No phone recorded</div>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="cust-location-cell">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    <span class="row-address" title="{{ $customer->address }}">
                                        {{ $customer->address ? Str::limit($customer->address, 48) : 'Not provided yet' }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                <div class="cust-spend-cell">
                                    <div class="cust-orders-badge {{ $customer->orders_count > 0 ? '' : 'no-orders' }}">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                        <span>{{ $customer->orders_count }} {{ Str::plural('order', $customer->orders_count) }}</span>
                                    </div>
                                    <div class="cust-spent-amount">
                                        ${{ number_format($customer->total_spent, 2) }}
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if ($isVerified)
                                    <span class="cust-status-badge verified" id="cust-status-pill-{{ $customer->id }}">
                                        <span class="dot"></span>
                                        <span>Verified</span>
                                    </span>
                                @else
                                    <span class="cust-status-badge unverified" id="cust-status-pill-{{ $customer->id }}">
                                        <span class="dot"></span>
                                        <span>Standard</span>
                                    </span>
                                @endif
                            </td>

                            <td>
                                <span class="order-date-text">
                                    {{ $customer->created_at?->format('d M Y') }}<br>
                                    <small>{{ $customer->created_at?->format('h:i A') }}</small>
                                </span>
                            </td>

                            <td style="text-align: right;">
                                <div class="cust-action-buttons">
                                    <button type="button" class="btn-cust-history" onclick="openCustomer360({{ $customer->id }})" title="Customer 360 & Order History">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <span>Orders</span>
                                    </button>

                                    <button type="button" class="btn-cust-edit" onclick="openEditCustomerModal({{ $customer->id }})" title="Edit customer details">
                                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        <span>Edit</span>
                                    </button>

                                    <button type="button" class="btn-cust-del" onclick="deleteCustomerAjax({{ $customer->id }}, '{{ addslashes($customer->name) }}')" title="Delete Customer Account">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-tr-row">
                            <td colspan="8" class="admin-empty-state">
                                <div class="empty-state-wrap">
                                    <div class="empty-icon">👥</div>
                                    <h3>No customers found</h3>
                                    <p>We couldn't find any registered customer accounts in this view.</p>
                                    <div class="empty-actions">
                                        <button type="button" onclick="openAddCustomerModal()" class="admin-primary-button">+ Add First Customer</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($customers->hasPages())
            <div class="admin-pagination-footer" id="cust-pagination">
                <span class="pagination-summary">
                    Showing <strong>{{ $customers->firstItem() ?? 0 }}</strong> to <strong>{{ $customers->lastItem() ?? 0 }}</strong> of <strong>{{ $customers->total() }}</strong> customers
                </span>
                <div class="pagination-links">
                    {{ $customers->links('admin.partials.pagination') }}
                </div>
            </div>
        @endif
    </section>
</div>

<!-- ========================================================
     CUSTOMER 360 & ORDER HISTORY MODAL
     ======================================================== -->
<div id="customer360Modal" class="cust-modal-backdrop" onclick="handleBackdropClick(event, 'customer360Modal')">
    <div class="cust-modal-box">
        <div class="cust-modal-header">
            <h3>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" style="color: #245943;">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>Customer 360 Profile & Orders</span>
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('customer360Modal')">✕</button>
        </div>

        <div class="cust-modal-body">
            <!-- Hero Info Banner -->
            <div class="cust-360-hero">
                <div id="c360-avatar" class="hero-avatar">S</div>
                <div class="hero-details">
                    <div class="hero-name">
                        <span id="c360-name">Customer Name</span>
                        <span id="c360-vip-badge" class="badge-vip-pill" style="display: none;">VIP ⭐</span>
                    </div>
                    <div class="hero-meta">
                        <span>
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <a id="c360-email" href="#" style="color: inherit; text-decoration: underline;">email@domain.com</a>
                        </span>
                        <span id="c360-phone-wrap">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span id="c360-phone">071 450 4547</span>
                        </span>
                    </div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 3px; display: flex; align-items: center; gap: 4px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span id="c360-address">Delivery Address</span>
                    </div>
                </div>
            </div>

            <!-- Mini Metrics Row -->
            <div class="cust-360-stats-row">
                <div class="cust-360-stat-box">
                    <span class="c360-stat-lbl">Lifetime Spend</span>
                    <span id="c360-total-spent" class="c360-stat-val text-success">$0.00</span>
                </div>
                <div class="cust-360-stat-box">
                    <span class="c360-stat-lbl">Total Orders</span>
                    <span id="c360-orders-count" class="c360-stat-val">0</span>
                </div>
                <div class="cust-360-stat-box">
                    <span class="c360-stat-lbl">Account Status</span>
                    <span id="c360-verified-pill" class="c360-stat-val" style="font-size: 14px; margin-top: 2px;">Verified</span>
                </div>
            </div>

            <!-- Orders Timeline -->
            <div class="cust-orders-timeline">
                <div class="timeline-title">
                    <span>Purchase History & Order Packages</span>
                    <small id="c360-orders-badge" class="badge-vip-pill" style="background: #f1f5f9; color: #475569; border-color: #e2e8f0;">0 Records</small>
                </div>

                <div id="c360-orders-container" style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- Populated by JavaScript -->
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="admin-secondary-button" onclick="closeModal('customer360Modal')">Close</button>
            <button type="button" id="c360-edit-shortcut-btn" class="admin-primary-button">
                Edit Profile
            </button>
        </div>
    </div>
</div>

<!-- ========================================================
     ADD NEW CUSTOMER MODAL
     ======================================================== -->
<div id="addCustomerModal" class="cust-modal-backdrop" onclick="handleBackdropClick(event, 'addCustomerModal')">
    <div class="cust-modal-box" style="max-width: 520px;">
        <div class="cust-modal-header">
            <h3>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" style="color: #245943;">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                <span>Add New Customer Account</span>
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('addCustomerModal')">✕</button>
        </div>

        <form id="addCustomerForm" onsubmit="submitAddCustomerForm(event)">
            @csrf
            <div class="cust-modal-body">
                <div class="cust-form-grid">
                    <label class="cust-input-label full-span">
                        <span>Full Name <strong class="req-star" style="color: #ef4444;">*</strong></span>
                        <input type="text" name="name" placeholder="e.g. Sokha Chan" required maxlength="255">
                    </label>

                    <label class="cust-input-label full-span">
                        <span>Email Address <strong class="req-star" style="color: #ef4444;">*</strong></span>
                        <input type="email" name="email" placeholder="customer@example.com" required maxlength="255">
                    </label>

                    <label class="cust-input-label">
                        <span>Phone Number</span>
                        <input type="tel" name="phone" placeholder="071 450 4547" maxlength="50">
                    </label>

                    <label class="cust-input-label">
                        <span>Password (Optional)</span>
                        <input type="text" name="password" placeholder="Default: password123">
                    </label>

                    <label class="cust-input-label full-span">
                        <span>Shipping / Delivery Address</span>
                        <textarea name="address" rows="2" placeholder="e.g. St 271, Sangkat Boeng Tumpun, Khan Meanchey, Phnom Penh" maxlength="500"></textarea>
                    </label>

                    <div class="full-span">
                        <label class="cust-checkbox-label">
                            <input type="checkbox" name="is_verified" value="1" checked>
                            <span>Mark email as verified immediately</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="admin-secondary-button" onclick="closeModal('addCustomerModal')">Cancel</button>
                <button type="submit" id="add-cust-submit-btn" class="admin-primary-button">Create Customer</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     EDIT CUSTOMER MODAL
     ======================================================== -->
<div id="editCustomerModal" class="cust-modal-backdrop" onclick="handleBackdropClick(event, 'editCustomerModal')">
    <div class="cust-modal-box" style="max-width: 520px;">
        <div class="cust-modal-header">
            <h3>
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" style="color: #245943;">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                <span>Edit Customer Account</span>
            </h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('editCustomerModal')">✕</button>
        </div>

        <form id="editCustomerForm" onsubmit="submitEditCustomerForm(event)">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_cust_id" name="customer_id">

            <div class="cust-modal-body">
                <div class="cust-form-grid">
                    <label class="cust-input-label full-span">
                        <span>Full Name <strong class="req-star" style="color: #ef4444;">*</strong></span>
                        <input id="edit_cust_name" type="text" name="name" required maxlength="255">
                    </label>

                    <label class="cust-input-label full-span">
                        <span>Email Address <strong class="req-star" style="color: #ef4444;">*</strong></span>
                        <input id="edit_cust_email" type="email" name="email" required maxlength="255">
                    </label>

                    <label class="cust-input-label full-span">
                        <span>Phone Number</span>
                        <input id="edit_cust_phone" type="tel" name="phone" placeholder="071 450 4547" maxlength="50">
                    </label>

                    <label class="cust-input-label full-span">
                        <span>Shipping / Delivery Address</span>
                        <textarea id="edit_cust_address" name="address" rows="2" placeholder="Delivery street, khan, province..." maxlength="500"></textarea>
                    </label>

                    <div class="full-span">
                        <label class="cust-checkbox-label">
                            <input id="edit_cust_verified" type="checkbox" name="is_verified" value="1">
                            <span>Email address is verified</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="admin-secondary-button" onclick="closeModal('editCustomerModal')">Cancel</button>
                <button type="submit" id="edit-cust-submit-btn" class="admin-primary-button">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     FLOATING BULK ACTION TOOLBAR
     ======================================================== -->
<div id="cust-bulk-toolbar" class="bulk-action-bar" style="display: none;">
    <div class="bulk-inner">
        <span class="bulk-counter">
            <span id="cust-selected-count">0</span> customers selected
        </span>
        <div class="bulk-actions">
            <button type="button" class="bulk-btn" onclick="executeCustBulk('verify')">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span>Verify Selected</span>
            </button>
            <button type="button" class="bulk-btn" onclick="executeCustBulk('unverify')">
                <span>Mark Unverified</span>
            </button>
            <button type="button" class="bulk-btn bulk-btn-danger" onclick="executeCustBulk('delete')">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                <span>Delete Selected</span>
            </button>
            <button type="button" class="bulk-close-btn" onclick="clearCustSelection()" title="Dismiss selection">✕</button>
        </div>
    </div>
</div>

<!-- Toast Feedback Notification -->
<div id="cust-toast" class="admin-toast" style="display: none;">
    <span class="toast-icon">✓</span>
    <span id="cust-toast-msg" class="toast-msg">Action completed</span>
</div>

<script>
// Customer Client-side State
let activeFilterTab = 'all';

// Open / Close Modals
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('open');
    }
}

function handleBackdropClick(event, modalId) {
    if (event.target.id === modalId) {
        closeModal(modalId);
    }
}

// ---------------------------------------------------------------------
// Customer 360 & Order History
// ---------------------------------------------------------------------
function openCustomer360(customerId) {
    const row = document.getElementById('cust-row-' + customerId);
    if (!row) return;

    const data = JSON.parse(row.dataset.customer);

    document.getElementById('c360-avatar').textContent = data.initials;
    document.getElementById('c360-avatar').style.background = data.avatar_bg;
    document.getElementById('c360-name').textContent = data.name;
    document.getElementById('c360-email').textContent = data.email;
    document.getElementById('c360-email').href = 'mailto:' + data.email;

    const phoneEl = document.getElementById('c360-phone');
    if (data.phone) {
        phoneEl.textContent = data.phone;
        document.getElementById('c360-phone-wrap').style.display = 'inline-flex';
    } else {
        document.getElementById('c360-phone-wrap').style.display = 'none';
    }

    document.getElementById('c360-address').textContent = data.address || 'No specific shipping address registered';
    document.getElementById('c360-total-spent').textContent = '$' + Number(data.total_spent).toFixed(2);
    document.getElementById('c360-orders-count').textContent = data.orders_count;

    const vipBadge = document.getElementById('c360-vip-badge');
    vipBadge.style.display = data.is_vip ? 'inline-block' : 'none';

    const verifiedPill = document.getElementById('c360-verified-pill');
    if (data.is_verified) {
        verifiedPill.textContent = '✓ Verified Account';
        verifiedPill.style.color = '#047857';
    } else {
        verifiedPill.textContent = 'Standard Member';
        verifiedPill.style.color = '#64748b';
    }

    // Render Orders Timeline
    const container = document.getElementById('c360-orders-container');
    const ordersBadge = document.getElementById('c360-orders-badge');
    container.innerHTML = '';

    const orders = data.orders || [];
    ordersBadge.textContent = orders.length + ' Orders';

    if (orders.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 28px 16px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px;">
                <div style="font-size: 28px; margin-bottom: 6px;">🛍️</div>
                <strong style="color: #334155; font-size: 14px;">No purchase orders yet</strong>
                <p style="color: #64748b; font-size: 12.5px; margin: 4px 0 0;">This member hasn't completed an order checkout yet.</p>
            </div>
        `;
    } else {
        orders.forEach(ord => {
            const items = Array.isArray(ord.items) ? ord.items : [];
            let itemsHtml = '';
            
            if (items.length > 0) {
                const itemSummary = items.map(it => `${it.quantity || 1}x ${it.name}`).join(', ');
                const thumb = items[0].image || 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100&auto=format&fit=crop&q=80';
                
                itemsHtml = `
                    <div class="history-items-row">
                        <img src="${thumb}" alt="Product" class="history-item-thumb">
                        <div class="history-item-desc">
                            <strong>${itemSummary}</strong>
                        </div>
                    </div>
                `;
            }

            const ordCard = document.createElement('div');
            ordCard.className = 'order-history-card';
            ordCard.innerHTML = `
                <div class="history-card-top">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span class="history-ord-num">#${ord.order_number}</span>
                        <span class="history-status-pill ${ord.order_status}">${ord.order_status}</span>
                    </div>
                    <span class="history-ord-date">${new Date(ord.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}</span>
                </div>
                ${itemsHtml}
                <div class="history-card-bottom">
                    <div>
                        <span style="font-size: 11.5px; color: #64748b;">Total:</span>
                        <span class="history-total">$${Number(ord.total_amount).toFixed(2)}</span>
                        <span style="font-size: 11px; color: #94a3b8; margin-left: 6px;">(${ord.payment_method})</span>
                    </div>
                    <a href="{{ url('/admin/orders') }}?q=${ord.order_number}" class="btn-view-order-link" target="_blank">
                        <span>Inspect Order</span>
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                </div>
            `;
            container.appendChild(ordCard);
        });
    }

    // Set Edit shortcut
    const editBtn = document.getElementById('c360-edit-shortcut-btn');
    editBtn.onclick = function() {
        closeModal('customer360Modal');
        openEditCustomerModal(customerId);
    };

    document.getElementById('customer360Modal').classList.add('open');
}

// ---------------------------------------------------------------------
// Add New Customer Modal
// ---------------------------------------------------------------------
function openAddCustomerModal() {
    document.getElementById('addCustomerForm').reset();
    document.getElementById('addCustomerModal').classList.add('open');
}

async function submitAddCustomerForm(e) {
    e.preventDefault();
    const btn = document.getElementById('add-cust-submit-btn');
    const form = document.getElementById('addCustomerForm');
    const formData = new FormData(form);

    btn.disabled = true;
    btn.textContent = 'Saving...';

    try {
        const response = await fetch("{{ route('admin.customers.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message || 'Customer created successfully!');
            closeModal('addCustomerModal');
            setTimeout(() => {
                window.location.reload();
            }, 600);
        } else {
            alert(data.message || 'Error creating customer. Please check input data.');
        }
    } catch (err) {
        console.error(err);
        alert('Network or server error while adding customer.');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Create Customer';
    }
}

// ---------------------------------------------------------------------
// Edit Customer Modal
// ---------------------------------------------------------------------
function openEditCustomerModal(customerId) {
    const row = document.getElementById('cust-row-' + customerId);
    if (!row) return;

    const data = JSON.parse(row.dataset.customer);

    document.getElementById('edit_cust_id').value = data.id;
    document.getElementById('edit_cust_name').value = data.name;
    document.getElementById('edit_cust_email').value = data.email;
    document.getElementById('edit_cust_phone').value = data.phone || '';
    document.getElementById('edit_cust_address').value = data.address || '';
    document.getElementById('edit_cust_verified').checked = !!data.is_verified;

    document.getElementById('editCustomerModal').classList.add('open');
}

async function submitEditCustomerForm(e) {
    e.preventDefault();
    const btn = document.getElementById('edit-cust-submit-btn');
    const customerId = document.getElementById('edit_cust_id').value;
    const form = document.getElementById('editCustomerForm');
    const formData = new FormData(form);

    btn.disabled = true;
    btn.textContent = 'Saving...';

    try {
        const response = await fetch("{{ url('/admin/customers') }}/" + customerId, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message || 'Customer details updated.');
            closeModal('editCustomerModal');

            // Update row in DOM
            const row = document.getElementById('cust-row-' + customerId);
            if (row) {
                const currentData = JSON.parse(row.dataset.customer);
                currentData.name = data.customer.name;
                currentData.email = data.customer.email;
                currentData.phone = data.customer.phone;
                currentData.address = data.customer.address;
                currentData.is_verified = data.customer.is_verified;
                currentData.initials = data.customer.name.charAt(0).toUpperCase();

                row.dataset.customer = JSON.stringify(currentData);
                row.dataset.name = data.customer.name.toLowerCase();
                row.dataset.email = data.customer.email.toLowerCase();
                row.dataset.phone = (data.customer.phone || '').toLowerCase();
                row.dataset.address = (data.customer.address || '').toLowerCase();
                row.dataset.isVerified = data.customer.is_verified ? '1' : '0';

                // Update row visible content
                row.querySelector('.row-name').textContent = data.customer.name;
                row.querySelector('.row-email').textContent = data.customer.email;
                row.querySelector('.row-email').href = 'mailto:' + data.customer.email;
                row.querySelector('.cust-avatar').textContent = currentData.initials;

                const phoneEl = row.querySelector('.row-phone');
                if (phoneEl) {
                    phoneEl.textContent = data.customer.phone || 'No phone recorded';
                }

                const addressEl = row.querySelector('.row-address');
                if (addressEl) {
                    addressEl.textContent = data.customer.address || 'Not provided yet';
                    addressEl.title = data.customer.address || '';
                }

                const statusPill = document.getElementById('cust-status-pill-' + customerId);
                if (statusPill) {
                    if (data.customer.is_verified) {
                        statusPill.className = 'cust-status-badge verified';
                        statusPill.innerHTML = '<span class="dot"></span><span>Verified</span>';
                    } else {
                        statusPill.className = 'cust-status-badge unverified';
                        statusPill.innerHTML = '<span class="dot"></span><span>Standard</span>';
                    }
                }
            }
        } else {
            alert(data.message || 'Failed to update customer.');
        }
    } catch (err) {
        console.error(err);
        alert('Error updating customer account.');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Save Changes';
    }
}

// ---------------------------------------------------------------------
// Single Customer AJAX Delete
// ---------------------------------------------------------------------
async function deleteCustomerAjax(customerId, name) {
    if (!confirm(`Are you sure you want to delete customer account for "${name}"?\nAll member history and active sessions will be removed.`)) {
        return;
    }

    try {
        const response = await fetch("{{ url('/admin/customers') }}/" + customerId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message || 'Customer deleted.');
            const row = document.getElementById('cust-row-' + customerId);
            if (row) {
                row.style.opacity = '0';
                row.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    row.remove();
                    updateVisibleCounter();
                }, 250);
            }
        } else {
            alert(data.message || 'Failed to delete customer.');
        }
    } catch (err) {
        console.error(err);
        alert('Network error while deleting customer.');
    }
}

// ---------------------------------------------------------------------
// Live Instant Search & Tabs Filtering
// ---------------------------------------------------------------------
const liveSearchInput = document.getElementById('customer-live-search');
const clearSearchBtn = document.getElementById('clear-search-btn');

liveSearchInput.addEventListener('input', function() {
    filterCustomerRows();
});

function clearLiveSearch() {
    liveSearchInput.value = '';
    clearSearchBtn.style.display = 'none';
    filterCustomerRows();
    liveSearchInput.focus();
}

function switchCustomerTab(tabName, btn) {
    activeFilterTab = tabName;
    document.querySelectorAll('.cust-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    filterCustomerRows();
}

function filterCustomerRows() {
    const q = liveSearchInput.value.trim().toLowerCase();
    clearSearchBtn.style.display = q.length > 0 ? 'block' : 'none';

    const rows = document.querySelectorAll('.customer-row');
    let visibleCount = 0;

    rows.forEach(row => {
        let matchesSearch = true;
        let matchesTab = true;

        if (q.length > 0) {
            const name = row.dataset.name || '';
            const email = row.dataset.email || '';
            const phone = row.dataset.phone || '';
            const address = row.dataset.address || '';
            const id = row.dataset.id || '';

            matchesSearch = name.includes(q) || email.includes(q) || phone.includes(q) || address.includes(q) || id.includes(q);
        }

        if (activeFilterTab === 'buyers') {
            matchesTab = row.dataset.hasOrders === '1';
        } else if (activeFilterTab === 'vip') {
            matchesTab = row.dataset.isVip === '1';
        } else if (activeFilterTab === 'verified') {
            matchesTab = row.dataset.isVerified === '1';
        } else if (activeFilterTab === 'new') {
            matchesTab = row.dataset.isNew === '1';
        }

        if (matchesSearch && matchesTab) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const countEl = document.getElementById('visible-count');
    if (countEl) countEl.textContent = visibleCount;
}

function updateVisibleCounter() {
    const visibleRows = document.querySelectorAll('.customer-row:not([style*="display: none"])');
    const countEl = document.getElementById('visible-count');
    if (countEl) countEl.textContent = visibleRows.length;
}

// ---------------------------------------------------------------------
// Copy to Clipboard Utility
// ---------------------------------------------------------------------
function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const origSvg = btn.innerHTML;
        btn.innerHTML = '✓';
        btn.style.color = '#047857';
        setTimeout(() => {
            btn.innerHTML = origSvg;
            btn.style.color = '';
        }, 1200);
        showToast(`Copied ${text}`);
    });
}

// ---------------------------------------------------------------------
// Bulk Selection Actions
// ---------------------------------------------------------------------
function toggleSelectAllCustomers(master) {
    const checkboxes = document.querySelectorAll('.cust-row-check');
    checkboxes.forEach(cb => {
        const row = cb.closest('.customer-row');
        if (row && row.style.display !== 'none') {
            cb.checked = master.checked;
        }
    });
    handleCustCheckChange();
}

function handleCustCheckChange() {
    const checked = document.querySelectorAll('.cust-row-check:checked');
    const toolbar = document.getElementById('cust-bulk-toolbar');
    const countSpan = document.getElementById('cust-selected-count');

    if (checked.length > 0) {
        countSpan.textContent = checked.length;
        toolbar.style.display = 'block';
    } else {
        toolbar.style.display = 'none';
        document.getElementById('select-all-customers').checked = false;
    }
}

function clearCustSelection() {
    document.querySelectorAll('.cust-row-check').forEach(cb => cb.checked = false);
    document.getElementById('select-all-customers').checked = false;
    document.getElementById('cust-bulk-toolbar').style.display = 'none';
}

async function executeCustBulk(action) {
    const checked = Array.from(document.querySelectorAll('.cust-row-check:checked')).map(cb => cb.value);
    if (checked.length === 0) return;

    if (action === 'delete') {
        if (!confirm(`Are you sure you want to delete ${checked.length} selected customer accounts? This cannot be undone.`)) {
            return;
        }
    }

    try {
        const response = await fetch("{{ route('admin.customers.bulk') }}", {
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
            clearCustSelection();
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
// Toast Notification
// ---------------------------------------------------------------------
let toastTimer = null;
function showToast(msg) {
    const toast = document.getElementById('cust-toast');
    const msgEl = document.getElementById('cust-toast-msg');
    if (!toast || !msgEl) return;

    msgEl.textContent = msg;
    toast.style.display = 'flex';
    toast.style.opacity = '1';

    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.style.display = 'none', 300);
    }, 2800);
}
</script>
@endsection

