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
        <div class="account-hero-card" style="display: block !important; padding: 0 !important; overflow: hidden !important; background: #ffffff !important; border-radius: 22px !important; border: 1px solid #dce8dd !important; box-shadow: 0 6px 24px rgba(16, 41, 31, 0.05) !important;">
            <div class="account-hero-cover" style="display: block !important; width: 100% !important; height: 90px !important; background: linear-gradient(135deg, #0d2a1c 0%, #173e2c 50%, #245943 100%) !important; position: relative !important; border-bottom: 2.5px solid #d8a962 !important; overflow: hidden !important;">
                <div class="cover-pattern" style="position: absolute !important; inset: 0 !important; opacity: 0.15 !important; background-image: radial-gradient(#d8a962 1.5px, transparent 1.5px) !important; background-size: 14px 14px !important;"></div>
                <div class="cover-shine" style="position: absolute !important; top: 0 !important; left: 0 !important; right: 0 !important; height: 100% !important; background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(216,169,98,0.2) 50%, rgba(255,255,255,0) 100%) !important;"></div>
            </div>
            <div class="account-hero-body" style="padding: 0 20px 20px 20px !important;">
                <div class="hero-left">
                    <div class="hero-avatar-wrap" style="position: relative !important; margin-top: -38px !important; flex-shrink: 0 !important;">
                        <div class="hero-avatar-ring" style="width: 78px !important; height: 78px !important; border-radius: 50% !important; overflow: hidden !important; border: 3.5px solid #ffffff !important; outline: 2.5px solid #d8a962 !important; background: linear-gradient(135deg, #245943 0%, #10291f 100%) !important; color: #ffffff !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 6px 18px rgba(16, 41, 31, 0.25) !important;">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="hero-avatar-img" referrerpolicy="no-referrer" style="width: 100% !important; height: 100% !important; object-fit: cover !important; border-radius: 50% !important; display: block !important;">
                            @else
                                <span class="hero-avatar-letter" style="font-size: 28px !important; font-weight: 800 !important; line-height: 1 !important;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            @endif
                        </div>
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
                        <div class="hero-user-meta">
                            <span class="meta-pill">✉️ {{ $user->email }}</span>
                            @if($user->phone)
                                <span class="meta-pill">📞 {{ $user->phone }}</span>
                            @endif
                            <span class="meta-pill">📅 {{ $locale === 'km' ? 'សមាជិកតាំងពី' : 'Member since' }} {{ $user->created_at ? $user->created_at->format('M Y') : '2026' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Profile Summary Metrics -->
                <div class="hero-stats-row">
                    <div class="hero-stat-box">
                        <span class="stat-icon stat-orders">📦</span>
                        <div>
                            <strong class="stat-value">{{ $totalOrders }}</strong>
                            <small class="stat-label">{{ $locale === 'km' ? 'ការកុម្ម៉ង់សរុប' : 'Total Orders' }}</small>
                        </div>
                    </div>

                    <div class="hero-stat-box">
                        <span class="stat-icon stat-spent">💳</span>
                        <div>
                            <strong class="stat-value">${{ number_format($totalSpent, 2) }}</strong>
                            <small class="stat-label">{{ $locale === 'km' ? 'ទឹកប្រាក់ទិញសរុប' : 'Total Spent' }}</small>
                        </div>
                    </div>

                    <div class="hero-stat-box">
                        <span class="stat-icon stat-coupon">🎁</span>
                        <div>
                            <strong class="stat-value">DARA2026</strong>
                            <small class="stat-label">{{ $locale === 'km' ? 'ប័ណ្ណបញ្ចុះតម្លៃ' : 'Active Coupon' }}</small>
                        </div>
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
                    <a href="tel:0714504547" class="help-phone-btn">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span>071 450 4547</span>
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
                        <div class="panel-header-left">
                            <span class="panel-pill-badge">
                                <span class="badge-dot"></span>
                                {{ $locale === 'km' ? 'ព័ត៌មានផ្លូវការ' : 'Official Record' }}
                            </span>
                            <h2>{{ $locale === 'km' ? 'កែប្រែព័ត៌មានគណនី' : 'Edit Profile Information' }}</h2>
                            <p>{{ $locale === 'km' ? 'ធ្វើបច្ចុប្បន្នភាពឈ្មោះ អ៊ីមែល លេខទូរស័ព្ទ និងអាសយដ្ឋានដឹកជញ្ជូនរបស់អ្នក' : 'Update your personal name, email, phone number, and delivery address' }}</p>
                        </div>
                        <div class="panel-header-right">
                            <span class="security-badge-shield">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                <span>{{ $locale === 'km' ? 'សុវត្ថិភាព 100%' : '100% Encrypted' }}</span>
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('account.profile.update') }}" method="POST" class="portal-form">
                        @csrf
                        @method('PUT')

                        <div class="form-row-2">
                            <div class="portal-input-group">
                                <label for="profile_name">
                                    <span class="lbl-text">{{ $locale === 'km' ? 'ឈ្មោះពេញ' : 'Full Name' }}</span>
                                    <span class="req">*</span>
                                </label>
                                <div class="input-with-icon">
                                    <div class="input-icon-box">
                                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    </div>
                                    <input type="text" id="profile_name" name="name" value="{{ old('name', $user->name) }}" required placeholder="សុខ សំណាង">
                                </div>
                                @error('name')
                                    <small class="portal-err">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="portal-input-group">
                                <label for="profile_email">
                                    <span class="lbl-text">{{ $locale === 'km' ? 'អាសយដ្ឋានអ៊ីមែល' : 'Email Address' }}</span>
                                    <span class="req">*</span>
                                </label>
                                <div class="input-with-icon">
                                    <div class="input-icon-box">
                                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    </div>
                                    <input type="email" id="profile_email" name="email" value="{{ old('email', $user->email) }}" required placeholder="example@email.com">
                                </div>
                                @error('email')
                                    <small class="portal-err">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row-2">
                            <div class="portal-input-group">
                                <label for="profile_phone">
                                    <span class="lbl-text">{{ $locale === 'km' ? 'លេខទូរស័ព្ទទំនាក់ទំនង' : 'Phone Number' }}</span>
                                    <small class="lbl-hint">({{ $locale === 'km' ? 'សម្រាប់អ្នកដឹកជញ្ជូន' : 'For delivery' }})</small>
                                </label>
                                <div class="input-with-icon">
                                    <div class="input-icon-box">
                                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    </div>
                                    <input type="tel" id="profile_phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="071 450 4547">
                                </div>
                                @error('phone')
                                    <small class="portal-err">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="portal-input-group">
                                <label>
                                    <span class="lbl-text">{{ $locale === 'km' ? 'ប្រភេទគណនី និងសិទ្ធិ' : 'Account & Membership Tier' }}</span>
                                </label>
                                <div class="account-tier-card {{ $user->is_admin ? 'tier-admin' : 'tier-vip' }}">
                                    <div class="tier-card-left">
                                        <span class="tier-badge-icon">{{ $user->is_admin ? '👑' : '⭐' }}</span>
                                        <div class="tier-card-text">
                                            <strong>{{ $user->is_admin ? ($locale === 'km' ? 'អ្នកគ្រប់គ្រងហាង (Store Administrator)' : 'Store Administrator') : ($locale === 'km' ? 'សមាជិកក្លឹប VIP (Dara Club Member)' : 'Dara Club VIP Member') }}</strong>
                                            <small>{{ $user->is_admin ? ($locale === 'km' ? 'សិទ្ធិគ្រប់គ្រងទំនិញ និងការលក់ពេញលេញ' : 'Full access & administrative control') : ($locale === 'km' ? 'បញ្ចុះតម្លៃពិសេស & សន្សំពិន្ទុ' : 'Exclusive VIP club discounts') }}</small>
                                        </div>
                                    </div>
                                    <span class="tier-status-pill">
                                        <span class="tier-dot"></span>
                                        {{ $locale === 'km' ? 'ផ្ទៀងផ្ទាត់' : 'Active' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="portal-input-group">
                            <label for="profile_address">
                                <span class="lbl-text">{{ $locale === 'km' ? 'អាសយដ្ឋានដឹកជញ្ជូនលំនាំដើម' : 'Default Delivery Address' }}</span>
                            </label>
                            <div class="input-with-icon textarea-icon">
                                <div class="input-icon-box textarea-icon-box">
                                    <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                </div>
                                <textarea id="profile_address" name="address" rows="3" placeholder="{{ $locale === 'km' ? 'ផ្ទះលេខ ផ្លូវ សង្កាត់ ខណ្ឌ រាជធានី/ខេត្ត...' : 'House No, Street, Sangkat, Khan, City/Province...' }}">{{ old('address', $user->address) }}</textarea>
                            </div>
                            @error('address')
                                <small class="portal-err">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-actions-bar">
                            <button type="submit" class="btn-save-primary">
                                <div class="btn-shine-light"></div>
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
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
                <!-- Mobile Logout and Support Bar -->
                <div class="mobile-portal-footer">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="portal-logout-btn">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            <span>{{ $locale === 'km' ? 'ចាកចេញពីគណនី (Sign Out)' : 'Sign Out' }}</span>
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>

<style>
/* ==========================================================
   DARA MARKET ACCOUNT & PROFILE PORTAL (LUXURY MODERN)
   ========================================================== */
.account-portal-wrapper {
    background: #f8faf9;
    min-height: calc(100vh - 180px);
    padding: 20px 0 100px;
    box-sizing: border-box;
    width: 100%;
    overflow-x: hidden;
}

.account-nav-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 12px;
    flex-wrap: wrap;
}

.account-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 999px;
    color: #10291f;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
}

.account-back-btn:hover {
    border-color: #10b981;
    color: #065f46;
    background: #f0fdf4;
    transform: translateX(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
}

.account-badge-group {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.account-member-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eef6f1;
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}

.account-admin-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #10291f 0%, #245943 100%);
    color: #ffffff;
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 3px 10px rgba(16, 41, 31, 0.2);
    transition: all 0.2s ease;
}

.account-admin-badge:hover {
    background: linear-gradient(135deg, #163d2e 0%, #2c6e53 100%);
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(36, 89, 67, 0.3);
}

/* ==========================================================
   HERO PROFILE CARD (LUXURY BANNER + AVATAR)
   ========================================================== */
.account-hero-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 6px 24px rgba(16, 41, 31, 0.05);
    margin-bottom: 24px;
    box-sizing: border-box;
    width: 100%;
    display: block !important;
    padding: 0 !important;
}

.account-hero-cover {
    height: 90px;
    width: 100%;
    background: linear-gradient(135deg, #0d2a1c 0%, #173e2c 50%, #245943 100%) !important;
    position: relative;
    border-bottom: 2px solid #d8a962;
    overflow: hidden;
}

.cover-pattern {
    position: absolute;
    inset: 0;
    opacity: 0.12;
    background-image: radial-gradient(#d8a962 1px, transparent 1px);
    background-size: 14px 14px;
}

.cover-shine {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(216,169,98,0.15) 50%, rgba(255,255,255,0) 100%);
}

.account-hero-body {
    padding: 0 24px 22px 24px;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
    position: relative;
    box-sizing: border-box;
    width: 100%;
}

.hero-left {
    display: flex;
    align-items: flex-end;
    gap: 18px;
    flex: 1 1 360px;
    min-width: 0;
}

.hero-avatar-wrap {
    position: relative;
    margin-top: -44px;
    flex-shrink: 0;
}

.hero-avatar-ring {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    background: linear-gradient(135deg, #245943 0%, #10291f 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 800;
    box-shadow: 0 6px 20px rgba(16, 41, 31, 0.25);
    border: 3.5px solid #ffffff;
    outline: 2.5px solid #d8a962;
    overflow: hidden;
    box-sizing: border-box;
}

.hero-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    display: block;
}

.hero-avatar-letter {
    font-size: 32px;
    font-weight: 800;
    color: #ffffff;
}

.hero-online-status {
    position: absolute;
    bottom: 3px;
    right: 3px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #10b981;
    border: 2.5px solid #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    z-index: 3;
}

.hero-user-details {
    flex: 1;
    min-width: 0;
    padding-bottom: 4px;
}

.hero-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 6px;
}

.hero-user-name {
    margin: 0;
    font-size: 21px;
    font-weight: 800;
    color: #10291f;
    letter-spacing: -0.3px;
    line-height: 1.25;
}

.hero-role-pill {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
}

.hero-role-pill.role-vip {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
}

.hero-role-pill.role-admin {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.hero-user-meta {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #475569;
    padding: 3px 9px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
}

/* Metric boxes */
.hero-stats-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 6px;
}

.hero-stat-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8faf9;
    border: 1px solid #e2e8f0;
    padding: 10px 14px;
    border-radius: 14px;
    box-sizing: border-box;
    transition: all 0.2s ease;
}

.hero-stat-box:hover {
    border-color: #a7f3d0;
    background: #f0fdf4;
}

.stat-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: grid;
    place-items: center;
    font-size: 16px;
    flex-shrink: 0;
}

.stat-icon.stat-orders { background: #eef6f1; color: #166534; }
.stat-icon.stat-spent { background: #eff6ff; color: #2563eb; }
.stat-icon.stat-coupon { background: #fef3c7; color: #b45309; }

.stat-value {
    display: block;
    font-size: 15px;
    font-weight: 800;
    color: #10291f;
    line-height: 1.2;
}

.stat-label {
    display: block;
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
}

/* ==========================================================
   PORTAL GRID & TABS
   ========================================================== */
.portal-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 24px;
    align-items: start;
    width: 100%;
    box-sizing: border-box;
}

.portal-sidebar {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 16px;
    box-shadow: 0 4px 16px rgba(16, 41, 31, 0.03);
    box-sizing: border-box;
}

.portal-tab-nav {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.tab-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 12px;
    border: none;
    background: transparent;
    font-size: 13.5px;
    font-weight: 700;
    color: #475569;
    cursor: pointer;
    text-align: left;
    width: 100%;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.tab-btn:hover {
    background: #f0fdf4;
    color: #166534;
}

.tab-btn.is-active {
    background: linear-gradient(135deg, #10291f 0%, #245943 100%);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(16, 41, 31, 0.2);
}

.tab-btn.is-active svg {
    color: #ffffff;
}

.tab-badge {
    margin-left: auto;
    background: #d8a962;
    color: #10291f;
    font-size: 11px;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 10px;
}

.sidebar-help-box {
    margin-top: 18px;
    padding: 16px;
    background: #f8faf9;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    text-align: center;
}

.help-box-icon {
    font-size: 24px;
    margin-bottom: 6px;
}

.sidebar-help-box h4 {
    margin: 0 0 4px;
    font-size: 13.5px;
    font-weight: 800;
    color: #10291f;
}

.sidebar-help-box p {
    margin: 0 0 10px;
    font-size: 11.5px;
    color: #64748b;
    line-height: 1.4;
}

.help-phone-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 8px 0;
    border-radius: 999px;
    background: #ffffff;
    border: 1px solid #bbf7d0;
    color: #166534;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.15s ease;
}

.help-phone-btn:hover {
    background: #166534;
    color: #ffffff;
}

.portal-logout-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    height: 46px;
    border-radius: 999px;
    background: #fff1f2;
    border: 1.5px solid #fecdd3;
    color: #e11d48;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(225, 29, 72, 0.08);
}

.portal-logout-btn:hover {
    background: #ffe4e6;
    border-color: #fb7185;
    color: #be123c;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(225, 29, 72, 0.15);
}

.mobile-portal-footer {
    display: none;
    margin-top: 24px;
    padding-top: 18px;
    border-top: 1px dashed #e2e8f0;
}

/* ==========================================================
   PANEL CONTENT & LUXURY EDIT PROFILE SECTION
   ========================================================== */
.portal-content {
    min-width: 0;
    box-sizing: border-box;
}

.portal-panel {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 24px;
    padding: 28px 32px;
    box-shadow: 0 10px 30px rgba(16, 41, 31, 0.04);
    box-sizing: border-box;
    width: 100%;
    position: relative;
    overflow: hidden;
    transition: all 0.2s ease;
}

.portal-panel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3.5px;
    background: linear-gradient(90deg, #10b981 0%, #d8a962 50%, #059669 100%);
}

.panel-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 18px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.panel-header-left {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.panel-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(16, 185, 129, 0.08);
    border: 1px solid rgba(16, 185, 129, 0.25);
    color: #065f46;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
    margin-bottom: 4px;
    width: fit-content;
}

.panel-pill-badge .badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #10b981;
    animation: successPulse 2s infinite;
}

.security-badge-shield {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
}

.panel-header h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 800;
    color: #0d2a1c;
    letter-spacing: -0.01em;
}

.panel-header p {
    margin: 0;
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
}

.btn-track-quick {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eef6f1;
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
}

.btn-track-quick:hover {
    background: #166534;
    color: #ffffff;
}

.portal-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.portal-input-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.portal-input-group label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
}

.portal-input-group label .lbl-text {
    display: inline-flex;
    align-items: center;
}

.portal-input-group label .lbl-hint {
    font-size: 11px;
    font-weight: 500;
    color: #64748b;
}

.portal-input-group label .req {
    color: #ef4444;
    margin-left: 3px;
    font-weight: 800;
}

.input-with-icon {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
}

.input-icon-box {
    position: absolute;
    left: 8px;
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
    transition: all 0.25s ease;
    z-index: 2;
}

.input-with-icon input,
.input-with-icon textarea {
    width: 100%;
    height: 52px;
    padding: 0 16px 0 54px;
    border: 1.5px solid #dce8dd;
    border-radius: 16px;
    background: #fbfdfc;
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    outline: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-sizing: border-box;
    font-family: 'Kantumruy Pro', 'DM Sans', -apple-system, sans-serif;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
}

.input-with-icon input:hover,
.input-with-icon textarea:hover {
    border-color: #a7f3d0;
    background: #ffffff;
}

.input-with-icon input:focus,
.input-with-icon textarea:focus {
    border-color: #10b981;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15), 0 4px 12px rgba(16, 185, 129, 0.08);
}

.input-with-icon:focus-within .input-icon-box {
    background: linear-gradient(135deg, #0d2a1c 0%, #173e2c 100%);
    color: #d8a962;
    border-color: #d8a962;
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(13, 42, 28, 0.2);
}

.input-with-icon.textarea-icon {
    align-items: flex-start;
}

.input-icon-box.textarea-icon-box {
    top: 9px;
    left: 8px;
}

.input-with-icon textarea {
    height: auto;
    min-height: 105px;
    padding-top: 14px;
    padding-bottom: 14px;
    resize: vertical;
    line-height: 1.6;
}

/* Membership Tier Card */
.account-tier-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 16px;
    border-radius: 16px;
    gap: 12px;
    min-height: 52px;
    box-sizing: border-box;
    transition: all 0.2s ease;
}

.account-tier-card.tier-admin {
    background: linear-gradient(135deg, #0d2a1c 0%, #173e2c 50%, #245943 100%);
    border: 1.5px solid #d8a962;
    box-shadow: 0 4px 14px rgba(13, 42, 28, 0.2);
}

.account-tier-card.tier-vip {
    background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #fefce8 100%);
    border: 1.5px solid #a7f3d0;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.08);
}

.tier-card-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 0;
}

.tier-badge-icon {
    font-size: 24px;
    line-height: 1;
    flex-shrink: 0;
}

.tier-card-text {
    flex: 1;
    min-width: 0;
}

.tier-admin .tier-card-text strong {
    display: block;
    font-size: 13.5px;
    font-weight: 800;
    color: #f6d186;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: 0.2px;
}

.tier-admin .tier-card-text small {
    display: block;
    font-size: 11px;
    color: #a7f3d0;
    margin-top: 1px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.tier-vip .tier-card-text strong {
    display: block;
    font-size: 13.5px;
    font-weight: 800;
    color: #14532d;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.tier-vip .tier-card-text small {
    display: block;
    font-size: 11px;
    color: #047857;
    margin-top: 1px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.tier-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
    flex-shrink: 0;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.tier-vip .tier-status-pill {
    background: #15803d;
    color: #ffffff;
    border: none;
}

.tier-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #86efac;
    animation: successPulse 1.5s infinite;
}

.form-actions-bar {
    margin-top: 14px;
    display: flex;
    justify-content: flex-end;
}

.btn-save-primary {
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    height: 52px;
    padding: 0 34px;
    border-radius: 999px;
    background: linear-gradient(135deg, #0d2a1c 0%, #173e2c 50%, #245943 100%);
    color: #ffffff;
    border: 1.5px solid #d8a962;
    font-size: 14.5px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(13, 42, 28, 0.28);
    transition: all 0.25s ease;
    letter-spacing: 0.2px;
}

.btn-save-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(13, 42, 28, 0.38);
    border-color: #f6d186;
}

.btn-save-primary:active {
    transform: translateY(0);
}

.btn-shine-light {
    position: absolute;
    inset: 0;
    opacity: 0.22;
    background: linear-gradient(90deg, transparent 0%, #ffffff 50%, transparent 100%);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
    pointer-events: none;
}

.btn-save-primary:hover .btn-shine-light {
    transform: translateX(100%);
}

/* ==========================================================
   MOBILE RESPONSIVENESS
   ========================================================== */
@media (max-width: 900px) {
    .portal-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .form-row-2 {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .portal-sidebar {
        background: transparent;
        border: none;
        box-shadow: none;
        padding: 0;
        margin-bottom: 4px;
    }
    .portal-tab-nav {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        padding: 4px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        gap: 6px;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }
    .portal-tab-nav::-webkit-scrollbar {
        display: none;
    }
    .tab-btn {
        flex: 0 0 auto;
        white-space: nowrap;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 12.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: auto;
    }
    .sidebar-help-box {
        display: none;
    }
    .portal-sidebar form {
        display: none;
    }
    .mobile-portal-footer {
        display: block;
    }
}

@media (max-width: 768px) {
    .account-hero-cover {
        height: 75px;
    }
    .account-hero-body {
        padding: 0 16px 18px 16px;
        flex-direction: column;
        align-items: flex-start;
    }
    .hero-left {
        width: 100%;
        align-items: center;
        gap: 14px;
    }
    .hero-avatar-wrap {
        margin-top: -36px;
    }
    .hero-avatar-ring {
        width: 72px;
        height: 72px;
        font-size: 26px;
    }
    .hero-user-name {
        font-size: 18px;
    }
    .hero-stats-row {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }
    .hero-stat-box {
        padding: 8px 4px;
        flex-direction: column;
        text-align: center;
        gap: 4px;
    }
    .stat-icon {
        width: 32px;
        height: 32px;
        font-size: 14px;
        margin: 0 auto;
    }
    .stat-value {
        font-size: 13.5px;
    }
    .stat-label {
        font-size: 10px;
    }
    .portal-panel {
        padding: 20px 16px;
        border-radius: 20px;
    }
    .panel-header {
        margin-bottom: 18px;
        padding-bottom: 14px;
    }
    .panel-header h2 {
        font-size: 18px;
    }
    .btn-save-primary {
        width: 100%;
        height: 50px;
    }
    .portal-logout-btn {
        height: 48px;
        font-size: 13.5px;
    }
}
</style>

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
