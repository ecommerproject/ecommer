@extends('store.layouts.app')

@section('title', ($locale === 'km' ? 'ព័ត៌មានគណនីរបស់ខ្ញុំ' : 'My Account & Profile').' | Dara Market')

@section('content')
<div class="account-portal-wrapper">
    <div class="container">
        <!-- Top Nav Breadcrumb -->
        <div class="account-nav-bar">
            <a class="account-back-btn" href="{{ route('store.home') }}">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>{{ $locale === 'km' ? 'ត្រឡប់ទៅទំព័រដើម' : 'Back to Storefront' }}</span>
            </a>
            <div class="account-badge-group">
                <span class="account-member-badge">
                    <span class="badge-dot"></span>
                    {{ $locale === 'km' ? 'សមាជិកផ្លូវការ' : 'Verified Member' }}
                </span>
                @if($user->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="account-admin-badge" target="_blank">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>{{ $locale === 'km' ? 'ផ្ទាំងគ្រប់គ្រង Admin ↗' : 'Admin Dashboard ↗' }}</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Hero Header Profile Banner -->
        <div class="account-hero-card">
            <div class="hero-left">
                <div class="hero-avatar-ring">
                    <span class="hero-avatar-letter">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    <span class="hero-online-status" title="Active Account"></span>
                </div>
                <div class="hero-user-details">
                    <div class="hero-title-row">
                        <h1 class="hero-user-name">{{ $user->name }}</h1>
                        @if($user->is_admin)
                            <span class="hero-role-pill role-admin">👑 Admin</span>
                        @else
                            <span class="hero-role-pill role-vip">🌟 VIP Club</span>
                        @endif
                    </div>
                    <p class="hero-user-meta">
                        <span>✉️ {{ $user->email }}</span>
                        @if($user->phone)
                            <span>📞 {{ $user->phone }}</span>
                        @endif
                        <span>📅 {{ $locale === 'km' ? 'សមាជិកតាំងពី' : 'Member since' }} {{ $user->created_at ? $user->created_at->format('M Y') : '2026' }}</span>
                    </p>
                </div>
            </div>

            <!-- Profile Summary Metrics -->
            <div class="hero-stats-row">
                <div class="hero-stat-box">
                    <span class="stat-icon" style="background: #eef6f1; color: #245943;">📦</span>
                    <div>
                        <strong class="stat-value">{{ $totalOrders }}</strong>
                        <small class="stat-label">{{ $locale === 'km' ? 'ការកម្ម៉ង់សរុប' : 'Total Orders' }}</small>
                    </div>
                </div>

                <div class="hero-stat-box">
                    <span class="stat-icon" style="background: #eff6ff; color: #2563eb;">💳</span>
                    <div>
                        <strong class="stat-value">${{ number_format($totalSpent, 2) }}</strong>
                        <small class="stat-label">{{ $locale === 'km' ? 'ទឹកប្រាក់ទិញសរុប' : 'Total Spent' }}</small>
                    </div>
                </div>

                <div class="hero-stat-box">
                    <span class="stat-icon" style="background: #fef3c7; color: #b45309;">🎁</span>
                    <div>
                        <strong class="stat-value">DARA2026</strong>
                        <small class="stat-label">{{ $locale === 'km' ? 'ប័ណ្ណបញ្ចុះតម្លៃ' : 'Active Coupon' }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Portal Layout: Sidebar Navigation + Content Panes -->
        <div class="portal-grid">
            <!-- Left Tabs Sidebar -->
            <aside class="portal-sidebar">
                <nav class="portal-tab-nav" aria-label="Account Tabs">
                    <button type="button" class="tab-btn is-active" onclick="switchAccountTab('profile', this)">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>{{ $locale === 'km' ? 'ព័ត៌មានផ្ទាល់ខ្លួន' : 'Profile Information' }}</span>
                    </button>

                    <button type="button" class="tab-btn" onclick="switchAccountTab('security', this)">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <span>{{ $locale === 'km' ? 'សុវត្ថិភាព & ពាក្យសម្ងាត់' : 'Security & Password' }}</span>
                    </button>

                    <button type="button" class="tab-btn" onclick="switchAccountTab('orders', this)" id="ordersTabBtn">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>{{ $locale === 'km' ? 'ប្រវត្តិការកម្ម៉ង់' : 'Order History' }}</span>
                        @if($totalOrders > 0)
                            <span class="tab-badge">{{ $totalOrders }}</span>
                        @endif
                    </button>

                    <button type="button" class="tab-btn" onclick="switchAccountTab('vouchers', this)">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><circle cx="12" cy="12" r="1.5"></circle></svg>
                        <span>{{ $locale === 'km' ? 'ប័ណ្ណបញ្ចុះតម្លៃ' : 'My Coupons & Deals' }}</span>
                    </button>
                </nav>

                <!-- Quick Help / Support Box -->
                <div class="sidebar-help-box">
                    <div class="help-box-icon">🎧</div>
                    <h4>{{ $locale === 'km' ? 'ត្រូវការជំនួយ?' : 'Need Assistance?' }}</h4>
                    <p>{{ $locale === 'km' ? 'ទាក់ទងមកកាន់ផ្នែកបម្រើអតិថិជនរៀងរាល់ថ្ងៃ ៨:០០ ព្រឹក - ៩:០០ យប់' : 'Customer service hotline daily 8:00 AM - 9:00 PM' }}</p>
                    <a href="tel:012345678" class="help-phone-btn">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span>012 345 678</span>
                    </a>
                </div>

                <!-- Sign Out Action -->
                <form action="{{ route('logout') }}" method="POST" style="margin-top: 14px;">
                    @csrf
                    <button type="submit" class="portal-logout-btn">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span>{{ $locale === 'km' ? 'ចាកចេញពីគណនី' : 'Sign Out' }}</span>
                    </button>
                </form>
            </aside>

            <!-- Right Content Panels -->
            <main class="portal-content">
                <!-- TAB 1: Edit Profile (FUNCTIONAL REAL UPDATE) -->
                <div id="tab-profile" class="portal-panel is-active">
                    <div class="panel-header">
                        <div>
                            <h2>{{ $locale === 'km' ? 'កែប្រែព័ត៌មានគណនី' : 'Edit Profile Information' }}</h2>
                            <p>{{ $locale === 'km' ? 'ធ្វើបច្ចុប្បន្នភាពឈ្មោះ អ៊ីមែល លេខទូរស័ព្ទ និងអាសយដ្ឋានដឹកជញ្ជូនរបស់អ្នក' : 'Update your personal name, email, phone number, and delivery address' }}</p>
                        </div>
                    </div>

                    <form action="{{ route('account.profile.update') }}" method="POST" class="portal-form">
                        @csrf
                        @method('PUT')

                        <div class="form-row-2">
                            <div class="portal-input-group">
                                <label for="profile_name">{{ $locale === 'km' ? 'ឈ្មោះពេញ' : 'Full Name' }} <span class="req">*</span></label>
                                <div class="input-with-icon">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input type="text" id="profile_name" name="name" value="{{ old('name', $user->name) }}" required placeholder="សុខ សំណាង">
                                </div>
                                @error('name')
                                    <small class="portal-err">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="portal-input-group">
                                <label for="profile_email">{{ $locale === 'km' ? 'អាសយដ្ឋានអ៊ីមែល' : 'Email Address' }} <span class="req">*</span></label>
                                <div class="input-with-icon">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    <input type="email" id="profile_email" name="email" value="{{ old('email', $user->email) }}" required placeholder="example@email.com">
                                </div>
                                @error('email')
                                    <small class="portal-err">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row-2">
                            <div class="portal-input-group">
                                <label for="profile_phone">{{ $locale === 'km' ? 'លេខទូរស័ព្ទទំនាក់ទំនង' : 'Phone Number' }}</label>
                                <div class="input-with-icon">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <input type="tel" id="profile_phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="012 345 678">
                                </div>
                                @error('phone')
                                    <small class="portal-err">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="portal-input-group">
                                <label for="profile_role">{{ $locale === 'km' ? 'ប្រភេទគណនី' : 'Account Type' }}</label>
                                <div class="input-with-icon">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    <input type="text" id="profile_role" value="{{ $user->is_admin ? ($locale === 'km' ? 'អ្នកគ្រប់គ្រងហាង (Store Administrator)' : 'Store Administrator') : ($locale === 'km' ? 'សមាជិកក្លឹប VIP (Dara Club Member)' : 'Dara Club VIP Member') }}" readonly style="background: #f8faf8; color: #475a4e; font-weight: 600;">
                                </div>
                            </div>
                        </div>

                        <div class="portal-input-group">
                            <label for="profile_address">{{ $locale === 'km' ? 'អាសយដ្ឋានដឹកជញ្ជូនលំនាំដើម' : 'Default Delivery Address' }}</label>
                            <div class="input-with-icon textarea-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <textarea id="profile_address" name="address" rows="3" placeholder="{{ $locale === 'km' ? 'ផ្ទះលេខ ផ្លូវ សង្កាត់ ខណ្ឌ រាជធានី/ខេត្ត...' : 'House No, Street, Sangkat, Khan, City/Province...' }}">{{ old('address', $user->address) }}</textarea>
                            </div>
                            @error('address')
                                <small class="portal-err">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-actions-bar">
                            <button type="submit" class="btn-save-primary">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                                <span>{{ $locale === 'km' ? 'រក្សាទុកការផ្លាស់ប្តូរ' : 'Save Profile Changes' }}</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- TAB 2: Change Password (FUNCTIONAL REAL UPDATE) -->
                <div id="tab-security" class="portal-panel" style="display: none;">
                    <div class="panel-header">
                        <div>
                            <h2>{{ $locale === 'km' ? 'សុវត្ថិភាព & ពាក្យសម្ងាត់' : 'Security & Password' }}</h2>
                            <p>{{ $locale === 'km' ? 'ប្តូរពាក្យសម្ងាត់ដើម្បីការពារសុវត្ថិភាពគណនីរបស់អ្នក' : 'Ensure your account stays protected by using a strong password' }}</p>
                        </div>
                    </div>

                    <form action="{{ route('account.password.update') }}" method="POST" class="portal-form">
                        @csrf
                        @method('PUT')

                        <div class="portal-input-group">
                            <label for="current_password">{{ $locale === 'km' ? 'ពាក្យសម្ងាត់បច្ចុប្បន្ន' : 'Current Password' }} <span class="req">*</span></label>
                            <div class="input-with-icon password-field">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <input type="password" id="current_password" name="current_password" required placeholder="••••••••">
                                <button type="button" class="eye-toggle-btn" onclick="togglePasswordVis('current_password', this)" aria-label="Toggle password visibility">👁️</button>
                            </div>
                            @error('current_password')
                                <small class="portal-err">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-row-2">
                            <div class="portal-input-group">
                                <label for="new_password">{{ $locale === 'km' ? 'ពាក្យសម្ងាត់ថ្មី (យ៉ាងហោចណាស់ ៨ តួ)' : 'New Password (min 8 chars)' }} <span class="req">*</span></label>
                                <div class="input-with-icon password-field">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                                    <input type="password" id="new_password" name="password" required minlength="8" placeholder="••••••••">
                                    <button type="button" class="eye-toggle-btn" onclick="togglePasswordVis('new_password', this)" aria-label="Toggle password visibility">👁️</button>
                                </div>
                                @error('password')
                                    <small class="portal-err">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="portal-input-group">
                                <label for="password_confirmation">{{ $locale === 'km' ? 'ផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់ថ្មី' : 'Confirm New Password' }} <span class="req">*</span></label>
                                <div class="input-with-icon password-field">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" placeholder="••••••••">
                                    <button type="button" class="eye-toggle-btn" onclick="togglePasswordVis('password_confirmation', this)" aria-label="Toggle password visibility">👁️</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions-bar">
                            <button type="submit" class="btn-save-primary">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <span>{{ $locale === 'km' ? 'ផ្លាស់ប្តូរពាក្យសម្ងាត់' : 'Update Password' }}</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- TAB 3: Real Orders List -->
                <div id="tab-orders" class="portal-panel" style="display: none;">
                    <div class="panel-header">
                        <div>
                            <h2>{{ $locale === 'km' ? 'ប្រវត្តិការបញ្ជាទិញរបស់អ្នក' : 'Your Order History' }}</h2>
                            <p>{{ $locale === 'km' ? 'ពិនិត្យបញ្ជីទំនិញដែលបានទិញ និងតាមដានស្ថានភាពដឹកជញ្ជូន' : 'Review recent purchases, invoices, and real-time delivery status' }}</p>
                        </div>
                        <button type="button" class="btn-track-quick" onclick="openTrackOrderModal()">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                            <span>{{ $locale === 'km' ? 'តាមដានកញ្ចប់ទំនិញ' : 'Track Package' }}</span>
                        </button>
                    </div>

                    @if($orders->count() > 0)
                        <div class="portal-orders-list">
                            @foreach($orders as $ord)
                                <div class="order-card-row">
                                    <div class="order-card-main">
                                        <div class="order-id-badge">
                                            <strong>#{{ $ord->order_number }}</strong>
                                            <small>{{ $ord->created_at ? $ord->created_at->format('d M Y, h:i A') : 'Recently' }}</small>
                                        </div>

                                        <div class="order-amount-pill">
                                            <span class="order-total-price">${{ number_format($ord->total_amount, 2) }}</span>
                                            <span class="order-pay-method">{{ strtoupper($ord->payment_method) }} ({{ ucfirst($ord->payment_status) }})</span>
                                        </div>

                                        <div class="order-status-badge status-{{ $ord->order_status }}">
                                            <span class="status-dot"></span>
                                            <span>{{ ucfirst($ord->order_status) }}</span>
                                        </div>
                                    </div>

                                    <div class="order-card-actions">
                                        <button type="button" class="btn-order-track" onclick="trackSpecificOrder('{{ $ord->order_number }}', '{{ $ord->customer_phone ?? '' }}')">
                                            <span>🔍 {{ $locale === 'km' ? 'តាមដានលម្អិត' : 'Track Details' }}</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="portal-empty-orders">
                            <div class="empty-icon">🛍️</div>
                            <h3>{{ $locale === 'km' ? 'មិនទាន់មានការបញ្ជាទិញនៅឡើយទេ' : 'No Orders Placed Yet' }}</h3>
                            <p>{{ $locale === 'km' ? 'រាល់ការទិញទំនិញរបស់អ្នកជាមួយ Dara Market នឹងត្រូវបានបង្ហាញនៅទីនេះ។' : 'Your purchases will show up here once you make your first order.' }}</p>
                            <a href="{{ route('store.products') }}" class="btn-start-shopping">
                                <span>{{ $locale === 'km' ? 'ស្វែងរកទំនិញឥឡូវនេះ' : 'Explore Catalog Now' }}</span>
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- TAB 4: My Coupons & Rewards -->
                <div id="tab-vouchers" class="portal-panel" style="display: none;">
                    <div class="panel-header">
                        <div>
                            <h2>{{ $locale === 'km' ? 'ប័ណ្ណបញ្ចុះតម្លៃ & VIP Rewards' : 'My Coupons & VIP Rewards' }}</h2>
                            <p>{{ $locale === 'km' ? 'ប័ណ្ណបញ្ចុះតម្លៃពិសេសសម្រាប់សមាជិក Dara Market' : 'Exclusive discount codes and club benefits ready to apply at checkout' }}</p>
                        </div>
                    </div>

                    <div class="vouchers-grid">
                        <!-- Voucher Card 1 -->
                        <div class="voucher-card">
                            <div class="voucher-left">
                                <span class="voucher-type">FLASH PROMO</span>
                                <strong class="voucher-amount">10% OFF</strong>
                                <small>No minimum spend required</small>
                            </div>
                            <div class="voucher-right">
                                <div class="voucher-code-wrap">
                                    <code>DARA2026</code>
                                    <button type="button" class="btn-copy-voucher" onclick="copyPromoCode('DARA2026', this)">
                                        <span class="copy-hint">{{ $locale === 'km' ? 'ចម្លង' : 'Copy' }}</span>
                                    </button>
                                </div>
                                <span class="voucher-exp">⚡ Valid for all store products</span>
                            </div>
                        </div>

                        <!-- Voucher Card 2 -->
                        <div class="voucher-card highlight-gold">
                            <div class="voucher-left">
                                <span class="voucher-type">VIP WELCOME</span>
                                <strong class="voucher-amount">$15.00 OFF</strong>
                                <small>On orders over $80</small>
                            </div>
                            <div class="voucher-right">
                                <div class="voucher-code-wrap">
                                    <code>DARA-VIP15</code>
                                    <button type="button" class="btn-copy-voucher" onclick="copyPromoCode('DARA-VIP15', this)">
                                        <span class="copy-hint">{{ $locale === 'km' ? 'ចម្លង' : 'Copy' }}</span>
                                    </button>
                                </div>
                                <span class="voucher-exp">🎁 Exclusive VIP Member Gift</span>
                            </div>
                        </div>

                        <!-- Benefit Card -->
                        <div class="voucher-card free-ship-card">
                            <div class="voucher-left">
                                <span class="voucher-type">MEMBER PERK</span>
                                <strong class="voucher-amount">FREE DELIVERY</strong>
                                <small>Across all 25 provinces</small>
                            </div>
                            <div class="voucher-right">
                                <p style="margin:0 0 8px; font-size:12px; font-weight:700; color:#14532d;">🚚 Auto-unlocked on orders $50+</p>
                                <span class="voucher-exp">✓ Automatically applied at checkout</span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<script>
function switchAccountTab(tabName, btn) {
    document.querySelectorAll('.portal-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('is-active'));
    
    const target = document.getElementById('tab-' + tabName);
    if (target) {
        target.style.display = 'block';
    }
    if (btn) {
        btn.classList.add('is-active');
    }
}

function togglePasswordVis(inputId, btn) {
    const inp = document.getElementById(inputId);
    if (!inp) return;
    if (inp.type === 'password') {
        inp.type = 'text';
        btn.textContent = '🙈';
    } else {
        inp.type = 'password';
        btn.textContent = '👁️';
    }
}

function trackSpecificOrder(orderNum, phone) {
    openTrackOrderModal();
    const ordInput = document.getElementById('track_order_number');
    const phoneInput = document.getElementById('track_phone');
    if (ordInput) ordInput.value = orderNum;
    if (phoneInput && phone) phoneInput.value = phone;
    
    // Auto submit track order
    const form = document.getElementById('trackOrderForm');
    if (form) {
        form.dispatchEvent(new Event('submit', { cancelable: true }));
    }
}

// Auto open orders tab if URL has #orders
window.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash === '#orders') {
        const orderBtn = document.getElementById('ordersTabBtn');
        if (orderBtn) {
            switchAccountTab('orders', orderBtn);
        }
    }
});
</script>
@endsection
