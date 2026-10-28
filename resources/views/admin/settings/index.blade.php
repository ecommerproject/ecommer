@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<div class="admin-settings-view">
    <!-- Header with Breadcrumbs & Quick Actions -->
    <div class="admin-page-heading">
        <div class="heading-content">
            <span class="admin-eyebrow">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 4px;">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
                SYSTEM & STORE PREFERENCES
            </span>
            <h1>Store Configuration & Settings</h1>
            <p>គ្រប់គ្រងព័ត៌មានហាង អត្រាប្តូរប្រាក់រៀល តម្លៃដឹកជញ្ជូន វិធីទូទាត់ KHQR និងសុវត្ថិភាពគណនី Admin។</p>
        </div>
        <div class="heading-actions">
            <a href="{{ route('store.home') }}" target="_blank" class="admin-secondary-button">
                <span>View Storefront</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="7" y1="17" x2="17" y2="7"></line>
                    <polyline points="7 7 17 7 17 17"></polyline>
                </svg>
            </a>
            <form action="{{ route('admin.settings.reset') }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់កំណត់ទិន្នន័យត្រឡប់ទៅជាស្តង់ដារដើមមែនទេ? (Are you sure you want to reset all settings to defaults?)')" style="display: inline-block;">
                @csrf
                <button type="submit" class="admin-danger-outline-button" title="កំណត់ឡើងវិញ">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                    </svg>
                    <span>Reset Defaults</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Store KPI Overview Strip -->
    <div class="settings-kpi-strip">
        <div class="settings-kpi-item">
            <div class="kpi-icon-pill icon-store">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
            <div class="kpi-text-block">
                <span class="kpi-label">Store Identity (ឈ្មោះហាង)</span>
                <strong class="kpi-value" id="kpiStoreName">{{ $settings['store_name_km'] }}</strong>
                <span class="kpi-sub">{{ $settings['store_name_en'] }}</span>
            </div>
        </div>

        <div class="settings-kpi-item">
            <div class="kpi-icon-pill icon-currency">
                <span class="kpi-currency-symbol">៛</span>
            </div>
            <div class="kpi-text-block">
                <span class="kpi-label">Exchange Rate (អត្រាប្តូរប្រាក់)</span>
                <strong class="kpi-value" id="kpiExchangeRate">1 USD = {{ number_format((float)$settings['exchange_rate']) }} KHR</strong>
                <span class="kpi-sub">បម្លែងប្រាក់រៀលស្វ័យប្រវត្តិ</span>
            </div>
        </div>

        <div class="settings-kpi-item">
            <div class="kpi-icon-pill icon-shipping">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="3" width="15" height="13"></rect>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
            </div>
            <div class="kpi-text-block">
                <span class="kpi-label">Free Delivery Tier (ដឹកឥតគិតថ្លៃ)</span>
                <strong class="kpi-value" id="kpiFreeShipping">ចាប់ពី ${{ number_format((float)$settings['free_shipping_threshold'], 2) }}</strong>
                <span class="kpi-sub">ភ្នំពេញ: ${{ number_format((float)$settings['delivery_pp'], 2) }} | ខេត្ត: ${{ number_format((float)$settings['delivery_province'], 2) }}</span>
            </div>
        </div>

        <div class="settings-kpi-item">
            <div class="kpi-icon-pill icon-payment">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
            </div>
            <div class="kpi-text-block">
                <span class="kpi-label">Payment Methods (វិធីទូទាត់)</span>
                <strong class="kpi-value text-primary" id="kpiGateways">{{ $stats['active_gateways'] }}</strong>
                <span class="kpi-sub">KHQR, Wing, ACLEDA, COD</span>
            </div>
        </div>
    </div>

    <!-- Enhanced Navigation Tabs Bar -->
    <div class="settings-nav-bar-modern">
        <a href="{{ route('admin.settings.index', ['tab' => 'general']) }}" class="settings-modern-tab {{ $tab === 'general' ? 'is-active' : '' }}">
            <div class="tab-icon-wrap">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
            <div class="tab-label-group">
                <span class="tab-title">General Profile</span>
                <span class="tab-desc">អត្តសញ្ញាណ & ព័ត៌មានទូទៅ</span>
            </div>
        </a>

        <a href="{{ route('admin.settings.index', ['tab' => 'shipping']) }}" class="settings-modern-tab {{ $tab === 'shipping' ? 'is-active' : '' }}">
            <div class="tab-icon-wrap">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="3" width="15" height="13"></rect>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
            </div>
            <div class="tab-label-group">
                <span class="tab-title">Shipping & Logistics</span>
                <span class="tab-desc">សេវាដឹកជញ្ជូន 25 ខេត្ត/ក្រុង</span>
            </div>
        </a>

        <a href="{{ route('admin.settings.index', ['tab' => 'payments']) }}" class="settings-modern-tab {{ $tab === 'payments' ? 'is-active' : '' }}">
            <div class="tab-icon-wrap">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
            </div>
            <div class="tab-label-group">
                <span class="tab-title">Payment Gateways</span>
                <span class="tab-desc">ABA KHQR, Wing, ACLEDA, COD</span>
            </div>
        </a>

        <a href="{{ route('admin.settings.index', ['tab' => 'announcements']) }}" class="settings-modern-tab {{ $tab === 'announcements' ? 'is-active' : '' }}">
            <div class="tab-icon-wrap">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
            </div>
            <div class="tab-label-group">
                <span class="tab-title">Announcements</span>
                <span class="tab-desc">របារដំណឹង & កូដបញ្ចុះតម្លៃ</span>
            </div>
        </a>

        <a href="{{ route('admin.settings.index', ['tab' => 'storefront']) }}" class="settings-modern-tab {{ $tab === 'storefront' ? 'is-active' : '' }}">
            <div class="tab-icon-wrap">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
            </div>
            <div class="tab-label-group">
                <span class="tab-title">Storefront & Widgets</span>
                <span class="tab-desc">Deal of Day, Vouchers & Support</span>
            </div>
        </a>

        <a href="{{ route('admin.settings.index', ['tab' => 'profile']) }}" class="settings-modern-tab {{ $tab === 'profile' ? 'is-active' : '' }}">
            <div class="tab-icon-wrap">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="tab-label-group">
                <span class="tab-title">Admin Credentials</span>
                <span class="tab-desc">គណនី & ពាក្យសម្ងាត់ Admin</span>
            </div>
        </a>
    </div>

    <!-- Main Workspace Split Grid: Form (Left) & Real-time Live Preview Widget (Right) -->
    <div class="settings-workspace-grid">
        <!-- Main Form Column -->
        <div class="settings-form-column">

            <!-- Tab 1: General Store Profile -->
            @if ($tab === 'general')
                <section class="admin-panel settings-premium-card">
                    <div class="settings-card-header">
                        <div class="header-icon-badge">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                        <div class="header-text-content">
                            <h3>Store Identity & Regional Configuration</h3>
                            <p>គ្រប់គ្រងឈ្មោះហាងជាភាសាខ្មែរ និងអង់គ្លេស ពាក្យស្លោក លេខទូរស័ព្ទទាន់ហេតុការណ៍ អ៊ីមែល និងអត្រាប្តូរប្រាក់រៀល។</p>
                        </div>
                        <span class="badge-status-pill badge-active">🟢 Active in Storefront</span>
                    </div>

                    <form action="{{ route('admin.settings.general') }}" method="POST" class="settings-modern-form">
                        @csrf
                        @method('PUT')

                        <div class="form-section-title">
                            <h4>ឈ្មោះ និងស្លាកយីហោ (Branding Identity)</h4>
                            <p>ព័ត៌មានដែលអតិថិជននឹងឃើញនៅគ្រប់ទំព័រលើគេហទំព័រ Dara Market</p>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="store_name_km">
                                    <span class="label-flag">🇰🇭</span> Store Name (Khmer ឈ្មោះហាង) *
                                </label>
                                <div class="input-with-icon">
                                    <input type="text" id="store_name_km" name="store_name_km" class="admin-form-input modern-input" value="{{ old('store_name_km', $settings['store_name_km']) }}" placeholder="ឧ. ផ្សារតារា" required>
                                </div>
                                <span class="field-hint">បង្ហាញនៅលើ Header និងវិក្កយបត្រជាភាសាខ្មែរ។</span>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="store_name_en">
                                    <span class="label-flag">🇬🇧</span> Store Name (English) *
                                </label>
                                <div class="input-with-icon">
                                    <input type="text" id="store_name_en" name="store_name_en" class="admin-form-input modern-input" value="{{ old('store_name_en', $settings['store_name_en']) }}" placeholder="e.g. Dara Market" required>
                                </div>
                                <span class="field-hint">Used for SEO titles, international buyers, and receipts.</span>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label" for="store_slogan">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                Store Slogan / Tagline (ពាក្យស្លោកផ្សារ)
                            </label>
                            <input type="text" id="store_slogan" name="store_slogan" class="admin-form-input modern-input" value="{{ old('store_slogan', $settings['store_slogan']) }}" placeholder="e.g. Fresh Living, Electronics & Fashion Store in Cambodia">
                            <span class="field-hint">បង្ហាញនៅក្រោមឈ្មោះហាង និងលើទំព័រដើម។</span>
                        </div>

                        <div class="form-section-title">
                            <h4>ព័ត៌មានទំនាក់ទំនង & ទីតាំង (Contact & Headquarters)</h4>
                            <p>ខ្សែទូរស័ព្ទជំនួយ និងអាសយដ្ឋានសម្រាប់អតិថិជនទាក់ទងមកហាង</p>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="contact_phone">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    Customer Hotline / Phone *
                                </label>
                                <input type="text" id="contact_phone" name="contact_phone" class="admin-form-input modern-input" value="{{ old('contact_phone', $settings['contact_phone']) }}" placeholder="+855 71 450 4547" required>
                                <span class="field-hint">បង្ហាញនៅលើ Topbar Hotline និងបាត Footer។</span>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="contact_email">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    Support Email Address *
                                </label>
                                <input type="email" id="contact_email" name="contact_email" class="admin-form-input modern-input" value="{{ old('contact_email', $settings['contact_email']) }}" placeholder="contact@daramarket.com" required>
                                <span class="field-hint">ទទួលសារសាកសួរពីទំព័រទំនាក់ទំនង Contact Us។</span>
                            </div>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="store_address">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    Physical Headquarters / Address *
                                </label>
                                <textarea id="store_address" name="store_address" class="admin-form-textarea modern-input" rows="2" placeholder="អាសយដ្ឋានទីស្នាក់ការកណ្តាលរបស់ហាង..." required>{{ old('store_address', $settings['store_address']) }}</textarea>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="business_hours">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    Business Working Hours (ម៉ោងធ្វើការ)
                                </label>
                                <input type="text" id="business_hours" name="business_hours" class="admin-form-input modern-input" value="{{ old('business_hours', $settings['business_hours'] ?? 'ច័ន្ទ - អាទិត្យ 7:00 AM - 9:00 PM') }}" placeholder="ច័ន្ទ - អាទិត្យ 7:00 AM - 9:00 PM">
                                <span class="field-hint">ម៉ោងប្រតិបត្តិការបម្រើអតិថិជន។</span>
                            </div>
                        </div>

                        <div class="form-section-title">
                            <h4>រូបិយប័ណ្ណ & ភាសាដើម (Currency & Localization)</h4>
                            <p>កំណត់អត្រាប្តូរប្រាក់រៀលស្វ័យប្រវត្តិនៅលើការទូទាត់ និងវិក្កយបត្រ</p>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="exchange_rate">
                                    <span class="label-currency-khr">៛</span> KHR Exchange Rate (1 USD = ? Riels) *
                                </label>
                                <div class="input-currency-group">
                                    <input type="number" id="exchange_rate" name="exchange_rate" class="admin-form-input modern-input highlight-rate" value="{{ old('exchange_rate', $settings['exchange_rate']) }}" min="3000" max="5000" step="10" required>
                                    <span class="currency-tag">KHR / $1 USD</span>
                                </div>
                                <span class="field-hint">អត្រាស្តង់ដារបច្ចុប្បន្ននៅកម្ពុជាចន្លោះពី ៤,០០០៛ ដល់ ៤,១៥០៛។</span>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="default_language">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                    Default Customer Language
                                </label>
                                <select id="default_language" name="default_language" class="admin-form-select modern-input">
                                    <option value="km" @selected($settings['default_language'] === 'km')>🇰🇭 ភាសាខ្មែរ (Khmer - Default)</option>
                                    <option value="en" @selected($settings['default_language'] === 'en')>🇬🇧 English (International)</option>
                                </select>
                                <span class="field-hint">ភាសាដែលបង្ហាញដំបូងពេលអតិថិជនចូលមកកាន់ហាង។</span>
                            </div>
                        </div>

                        <div class="form-actions-bar-modern">
                            <button type="submit" class="admin-primary-button button-with-glow">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>
                                <span>Save General Store Profile</span>
                            </button>
                        </div>
                    </form>
                </section>

            <!-- Tab 2: Shipping & Logistics -->
            @elseif ($tab === 'shipping')
                <section class="admin-panel settings-premium-card">
                    <div class="settings-card-header">
                        <div class="header-icon-badge badge-orange">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="3" width="15" height="13"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                        </div>
                        <div class="header-text-content">
                            <h3>Shipping Tariffs & Logistics Rules</h3>
                            <p>កំណត់តម្លៃសេវាដឹកជញ្ជូនរាជធានីភ្នំពេញ បណ្តាខេត្ត និងលក្ខខណ្ឌដឹកឥតគិតថ្លៃ (Free Shipping Threshold)។</p>
                        </div>
                        <span class="badge-status-pill badge-info">🚚 25 Provinces Covered</span>
                    </div>

                    <form action="{{ route('admin.settings.shipping') }}" method="POST" class="settings-modern-form">
                        @csrf
                        @method('PUT')

                        <div class="form-section-title">
                            <h4>តម្លៃសេវាដឹកជញ្ជូន (Delivery Rates)</h4>
                            <p>គណនាស្វ័យប្រវត្តិនៅលើផ្ទាំងកន្ត្រកទំនិញ (Cart & Checkout Drawer)</p>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="delivery_pp">
                                    <span class="location-badge">📍 Phnom Penh</span> Delivery Fee ($) *
                                </label>
                                <div class="input-currency-group">
                                    <span class="currency-tag">$</span>
                                    <input type="number" step="0.01" id="delivery_pp" name="delivery_pp" class="admin-form-input modern-input" value="{{ old('delivery_pp', $settings['delivery_pp']) }}" required>
                                </div>
                                <span class="field-hint">ថ្លៃដឹកជញ្ជូនរហ័សក្នុងរាជធានីភ្នំពេញ (Default $1.50)</span>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="delivery_province">
                                    <span class="location-badge">🗺️ Provinces</span> Express Courier Fee ($) *
                                </label>
                                <div class="input-currency-group">
                                    <span class="currency-tag">$</span>
                                    <input type="number" step="0.01" id="delivery_province" name="delivery_province" class="admin-form-input modern-input" value="{{ old('delivery_province', $settings['delivery_province']) }}" required>
                                </div>
                                <span class="field-hint">ថ្លៃបញ្ញើតាមឡានក្រុង ឬក្រុមហ៊ុនដឹកជញ្ជូនទៅបណ្តាខេត្ត (Default $2.50)</span>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label" for="free_shipping_threshold">
                                <span class="badge-discount-tag">🎁 FREE SHIPPING</span>
                                Minimum Order Amount ($) *
                            </label>
                            <div class="input-currency-group highlight-box">
                                <span class="currency-tag">$</span>
                                <input type="number" step="0.01" id="free_shipping_threshold" name="free_shipping_threshold" class="admin-form-input modern-input" value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold']) }}" required>
                            </div>
                            <span class="field-hint">រាល់ការបញ្ជាទិញចាប់ពីចំនួនទឹកប្រាក់នេះឡើងទៅ នឹងទទួលបានការដឹកជញ្ជូនឥតគិតថ្លៃដោយស្វ័យប្រវត្តិ!</span>
                        </div>

                        <div class="form-section-title">
                            <h4>ពេលវេលានៃការដឹកជញ្ជូន (Delivery Timelines)</h4>
                            <p>បង្ហាញជូនអតិថិជននៅទំព័រ Checkout និងព័ត៌មានលម្អិតផលិតផល</p>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="delivery_window_pp">Phnom Penh Delivery Window *</label>
                                <input type="text" id="delivery_window_pp" name="delivery_window_pp" class="admin-form-input modern-input" value="{{ old('delivery_window_pp', $settings['delivery_window_pp']) }}" placeholder="Same-Day (2 - 4 hours)" required>
                                <span class="field-hint">ឧទាហរណ៍: ដឹកក្នុងថ្ងៃតែមួយ (២ ទៅ ៤ ម៉ោង)</span>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="delivery_window_province">Province Delivery Window *</label>
                                <input type="text" id="delivery_window_province" name="delivery_window_province" class="admin-form-input modern-input" value="{{ old('delivery_window_province', $settings['delivery_window_province']) }}" placeholder="1 - 2 Business Days via Express Courier" required>
                                <span class="field-hint">ឧទាហរណ៍: ១ ទៅ ២ ថ្ងៃធ្វើការ តាមរថយន្តឈ្នួល ឬក្រុមហ៊ុនបញ្ញើ</span>
                            </div>
                        </div>

                        <div class="form-actions-bar-modern">
                            <button type="submit" class="admin-primary-button button-with-glow">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                </svg>
                                <span>Save Shipping Settings</span>
                            </button>
                        </div>
                    </form>
                </section>

            <!-- Tab 3: Payment Gateways -->
            @elseif ($tab === 'payments')
                <section class="admin-panel settings-premium-card">
                    <div class="settings-card-header">
                        <div class="header-icon-badge badge-blue">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                        <div class="header-text-content">
                            <h3>National KHQR & Cambodian Payment Gateways</h3>
                            <p>បើក ឬបិទច្រកទូទាត់ប្រាក់តាមប្រព័ន្ធបាគង KHQR ធនាគារ ABA, Wing, អេស៊ីលីដា និងសេវាទូទាត់ប្រាក់ពេលទំនិញទៅដល់ (COD)។</p>
                        </div>
                        <span class="badge-status-pill badge-active">🇰🇭 Bakong Standard</span>
                    </div>

                    <form action="{{ route('admin.settings.payments') }}" method="POST" enctype="multipart/form-data" class="settings-modern-form">
                        @csrf
                        @method('PUT')

                        <div class="gateways-card-list">
                            <!-- 1. ABA KHQR -->
                            <div class="modern-gateway-item {{ !empty($settings['enable_aba']) ? 'is-enabled' : '' }}">
                                <div class="gateway-brand-col">
                                    <div class="gateway-logo-pill logo-aba">
                                        <span>ABA</span>
                                    </div>
                                    <div class="gateway-meta">
                                        <div class="gateway-heading">
                                            <strong>ABA KHQR (Bakong National QR)</strong>
                                            <span class="gateway-badge badge-bakong">Bakong Certified</span>
                                        </div>
                                        <p>ទទួលការទូទាត់ប្រាក់ភ្លាមៗពី ABA Mobile App និងគ្រប់កម្មវិធីធនាគារសមាជិកបាគងទាំងអស់នៅកម្ពុជា។</p>
                                    </div>
                                </div>
                                <div class="gateway-control-col">
                                    <label class="modern-toggle-switch">
                                        <input type="checkbox" name="enable_aba" value="1" id="toggle_aba" @checked($settings['enable_aba'] ?? true) onchange="updateGatewayPreview()">
                                        <span class="modern-toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="gateway-subconfig-box" style="margin-top: -10px; margin-bottom: 16px; display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                                <div class="admin-form-group">
                                    <label class="admin-form-label" for="bakong_account_id">Bakong Account ID / Phone</label>
                                    <input type="text" id="bakong_account_id" name="bakong_account_id" class="admin-form-input modern-input" value="{{ old('bakong_account_id', $settings['bakong_account_id'] ?? 'dara_market@abaa') }}" placeholder="e.g. 0714504547@abaa ឬ username@abaa">
                                    <span class="field-hint">Bakong Account សម្រាប់បង្កើត EMV KHQR Code ស្កេនបង់លុយពិតប្រាកដ។</span>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label" for="aba_merchant_id">Merchant / Shop Display Name</label>
                                    <input type="text" id="aba_merchant_id" name="aba_merchant_id" class="admin-form-input modern-input" value="{{ old('aba_merchant_id', $settings['aba_merchant_id'] ?? 'DARA MARKET') }}" placeholder="DARA MARKET">
                                    <span class="field-hint">ឈ្មោះហាងដែលបង្ហាញនៅលើអេក្រង់ស្កេន KHQR។</span>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label" for="aba_account_number">ABA Account Number (លេខកុងធនាគារ)</label>
                                    <input type="text" id="aba_account_number" name="aba_account_number" class="admin-form-input modern-input" value="{{ old('aba_account_number', $settings['aba_account_number'] ?? '001 888 999') }}" placeholder="001 888 999">
                                    <span class="field-hint">បង្ហាញជូនអតិថិជនពេលចង់ផ្ទេរប្រាក់ផ្ទាល់តាមលេខគណនី។</span>
                                </div>
                                <div class="admin-form-group">
                                    <label class="admin-form-label" for="aba_account_name">Account Holder Name (ឈ្មោះម្ចាស់គណនី)</label>
                                    <input type="text" id="aba_account_name" name="aba_account_name" class="admin-form-input modern-input" value="{{ old('aba_account_name', $settings['aba_account_name'] ?? 'DARA MARKET CO., LTD') }}" placeholder="DARA MARKET CO., LTD">
                                    <span class="field-hint">ឈ្មោះម្ចាស់គណនីធនាគារ (Account Holder)។</span>
                                </div>
                                <div class="admin-form-group" style="grid-column: 1 / -1;">
                                    <label class="admin-form-label" for="custom_khqr_image">Custom Official Standee QR Image (រូប QR ផ្លូវការរបស់ហាង បើមាន)</label>
                                    <input type="file" id="custom_khqr_image" name="custom_khqr_image" class="admin-form-input modern-input" accept="image/*">
                                    @if(!empty($settings['custom_khqr_image']))
                                        <div style="margin-top: 6px; display: flex; align-items: center; gap: 10px;">
                                            <img src="{{ $settings['custom_khqr_image'] }}" alt="Current QR" style="width: 50px; height: 50px; object-fit: contain; border: 1px solid #cbd5e1; border-radius: 6px;">
                                            <span style="font-size: 12px; color: #16a34a; font-weight: 600;">✓ រូប QR ផ្លូវការត្រូវបានរក្សាទុក</span>
                                        </div>
                                    @endif
                                    <span class="field-hint">អ្នកអាច Upload រូប KHQR ផ្លូវការរបស់ហាងដែលទាញយកពី ABA ឬធនាគារផ្ទាល់បាន។</span>
                                </div>
                            </div>

                            <!-- 2. Wing Bank -->
                            <div class="modern-gateway-item {{ !empty($settings['enable_wing']) ? 'is-enabled' : '' }}">
                                <div class="gateway-brand-col">
                                    <div class="gateway-logo-pill logo-wing">
                                        <span>WING</span>
                                    </div>
                                    <div class="gateway-meta">
                                        <div class="gateway-heading">
                                            <strong>Wing Bank & Wing KHQR</strong>
                                            <span class="gateway-badge badge-wing">Mobile Wallet</span>
                                        </div>
                                        <p>គាំទ្រការទូទាត់ពីកាបូបលុយ Wing Bank App និង Wing QR សម្រាប់អតិថិជនរាប់លាននាក់។</p>
                                    </div>
                                </div>
                                <div class="gateway-control-col">
                                    <label class="modern-toggle-switch">
                                        <input type="checkbox" name="enable_wing" value="1" id="toggle_wing" @checked($settings['enable_wing'] ?? true) onchange="updateGatewayPreview()">
                                        <span class="modern-toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="gateway-subconfig-box" style="margin-top: -10px; margin-bottom: 16px;">
                                <div class="admin-form-group">
                                    <label class="admin-form-label" for="wing_account_number">Wing Merchant Account Number / Phone</label>
                                    <input type="text" id="wing_account_number" name="wing_account_number" class="admin-form-input modern-input" value="{{ old('wing_account_number', $settings['wing_account_number'] ?? '071 450 4547') }}" placeholder="071 450 4547">
                                </div>
                            </div>

                            <!-- 3. ACLEDA Mobile -->
                            <div class="modern-gateway-item {{ !empty($settings['enable_acleda']) ? 'is-enabled' : '' }}">
                                <div class="gateway-brand-col">
                                    <div class="gateway-logo-pill logo-acleda">
                                        <span>ACL</span>
                                    </div>
                                    <div class="gateway-meta">
                                        <div class="gateway-heading">
                                            <strong>ACLEDA Mobile & ACLEDA KHQR</strong>
                                            <span class="gateway-badge badge-acleda">ACLEDA Pay</span>
                                        </div>
                                        <p>ការទូទាត់ប្រាក់តាមប្រព័ន្ធធនាគារពាណិជ្ជឈានមុខគេ ACLEDA Bank Plc។</p>
                                    </div>
                                </div>
                                <div class="gateway-control-col">
                                    <label class="modern-toggle-switch">
                                        <input type="checkbox" name="enable_acleda" value="1" id="toggle_acleda" @checked($settings['enable_acleda'] ?? true) onchange="updateGatewayPreview()">
                                        <span class="modern-toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="gateway-subconfig-box" style="margin-top: -10px; margin-bottom: 16px;">
                                <div class="admin-form-group">
                                    <label class="admin-form-label" for="acleda_account_name">ACLEDA Business Account Name</label>
                                    <input type="text" id="acleda_account_name" name="acleda_account_name" class="admin-form-input modern-input" value="{{ old('acleda_account_name', $settings['acleda_account_name'] ?? 'DARA MARKET CO., LTD') }}" placeholder="DARA MARKET CO., LTD">
                                </div>
                            </div>

                            <!-- 4. Cash on Delivery (COD) -->
                            <div class="modern-gateway-item {{ !empty($settings['enable_cod']) ? 'is-enabled' : '' }}">
                                <div class="gateway-brand-col">
                                    <div class="gateway-logo-pill logo-cod">
                                        <span>💵</span>
                                    </div>
                                    <div class="gateway-meta">
                                        <div class="gateway-heading">
                                            <strong>Cash on Delivery (COD ទូទាត់ពេលទំនិញដល់ដៃ)</strong>
                                            <span class="gateway-badge badge-cod">Customer Favorite</span>
                                        </div>
                                        <p>អនុញ្ញាតឱ្យអតិថិជនទូទាត់ជាសាច់ប្រាក់សុទ្ធ ឬស្កេន QR ផ្ទាល់ជាមួយអ្នកដឹកជញ្ជូនពេលទំនិញទៅដល់។</p>
                                    </div>
                                </div>
                                <div class="gateway-control-col">
                                    <label class="modern-toggle-switch">
                                        <input type="checkbox" name="enable_cod" value="1" id="toggle_cod" @checked($settings['enable_cod'] ?? true) onchange="updateGatewayPreview()">
                                        <span class="modern-toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="gateway-subconfig-box" style="margin-top: -10px; margin-bottom: 16px;">
                                <div class="admin-form-group">
                                    <label class="admin-form-label" for="cod_max_amount">Maximum Allowed Order Value for COD ($)</label>
                                    <input type="number" step="1" id="cod_max_amount" name="cod_max_amount" class="admin-form-input modern-input" value="{{ old('cod_max_amount', $settings['cod_max_amount'] ?? 500) }}" placeholder="500">
                                    <span class="field-hint">ដើម្បីការពារសុវត្ថិភាព ការបញ្ជាទិញលើសពីចំនួននេះតម្រូវឱ្យទូទាត់មុនតាម KHQR។</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions-bar-modern">
                            <button type="submit" class="admin-primary-button button-with-glow">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                </svg>
                                <span>Save Payment Gateways</span>
                            </button>
                        </div>
                    </form>
                </section>

            <!-- Tab 4: Announcements & Storefront Promo -->
            @elseif ($tab === 'announcements')
                <section class="admin-panel settings-premium-card">
                    <div class="settings-card-header">
                        <div class="header-icon-badge badge-purple">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                        </div>
                        <div class="header-text-content">
                            <h3>Storefront Announcements & Promo Banner</h3>
                            <p>គ្រប់គ្រងរបារដំណឹងផ្នែកខាងលើគេបង្អស់ (Top Announcement Ticker) និងកូដប័ណ្ណបញ្ចុះតម្លៃ Promo Code។</p>
                        </div>
                        <span class="badge-status-pill badge-active">📢 Live Ticker</span>
                    </div>

                    <form action="{{ route('admin.settings.announcements') }}" method="POST" class="settings-modern-form">
                        @csrf
                        @method('PUT')

                        <div class="admin-form-group">
                            <div class="toggle-row-card">
                                <div>
                                    <strong>Enable Top Announcement Bar</strong>
                                    <p class="field-hint" style="margin: 4px 0 0 0;">បើករបារដំណឹង និងកម្មវិធីពិសេសនៅផ្នែកខាងលើនៃគេហទំព័រ</p>
                                </div>
                                <label class="modern-toggle-switch">
                                    <input type="checkbox" name="announcement_active" value="1" @checked($settings['announcement_active'] ?? true)>
                                    <span class="modern-toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label" for="announcement_promo">
                                <span class="badge-discount-tag">🎟️ PROMO CODE</span>
                                Featured Promo Voucher Code
                            </label>
                            <input type="text" id="announcement_promo" name="announcement_promo" class="admin-form-input modern-input uppercase-code" value="{{ old('announcement_promo', $settings['announcement_promo'] ?? 'DARA2026') }}" placeholder="DARA2026" required>
                            <span class="field-hint">បង្ហាញនៅក្នុងប៊ូតុង Quick Copy នៅលើរបារខាងលើ។</span>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="announcement_text_km">
                                    <span class="label-flag">🇰🇭</span> សារជូនដំណឹងជាភាសាខ្មែរ (Khmer Ticker)
                                </label>
                                <input type="text" id="announcement_text_km" name="announcement_text_km" class="admin-form-input modern-input" value="{{ old('announcement_text_km', $settings['announcement_text_km'] ?? 'ដឹកជញ្ជូនឥតគិតថ្លៃ រាល់ការកម្ម៉ង់ចាប់ពី $35 ឡើងទៅ!') }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="announcement_text_en">
                                    <span class="label-flag">🇬🇧</span> Announcement Text in English
                                </label>
                                <input type="text" id="announcement_text_en" name="announcement_text_en" class="admin-form-input modern-input" value="{{ old('announcement_text_en', $settings['announcement_text_en'] ?? 'Free Shipping on all orders over $35!') }}" required>
                            </div>
                        </div>

                        <div class="form-actions-bar-modern">
                            <button type="submit" class="admin-primary-button button-with-glow">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                </svg>
                                <span>Save Announcement Settings</span>
                            </button>
                        </div>
                    </form>
                </section>

            <!-- Tab 5: Storefront & Widgets (Customizer for entire app) -->
            @elseif ($tab === 'storefront')
                <section class="admin-panel settings-premium-card">
                    <div class="settings-card-header">
                        <div class="header-icon-badge" style="background: rgba(22, 83, 55, 0.1); color: #165337;">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                        </div>
                        <div class="header-text-content">
                            <h3>Storefront Components & Sidebar Widgets Customizer</h3>
                            <p>កែប្រែគ្រប់ Widget និងផ្នែកទាំងអស់នៃគេហទំព័រ (Deal of the Day, Voucher Coupon, Spotlight, Side Banner និងព័ត៌មានជំនួយ)។</p>
                        </div>
                        <span class="badge-status-pill badge-active">🎨 Live App Customizer</span>
                    </div>

                    <form action="{{ route('admin.settings.storefront') }}" method="POST" enctype="multipart/form-data" class="settings-modern-form">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Flash Deal of the Day Widget -->
                        <div class="form-section-title">
                            <h4>⚡ 1. Flash Deal of the Day (ប្រូម៉ូសិនពិសេសប្រចាំថ្ងៃ)</h4>
                            <p>Widget បង្ហាញនៅខាងឆ្វេងក្រោមប្រភេទមុខទំនិញ ជាមួយកម្មវិធីរាប់ថយក្រោយ</p>
                        </div>

                        <div class="admin-form-group">
                            <div class="toggle-row-card">
                                <div>
                                    <strong>Enable Deal of the Day Widget</strong>
                                    <p class="field-hint" style="margin: 4px 0 0 0;">បើកបង្ហាញប្រអប់ប្រូម៉ូសិនពិសេសប្រចាំថ្ងៃនៅលើគេហទំព័រ</p>
                                </div>
                                <label class="modern-toggle-switch">
                                    <input type="checkbox" name="deal_active" value="1" @checked($settings['deal_active'] ?? true)>
                                    <span class="modern-toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="deal_kicker_km">ចំណងជើងផ្នែកខាងលើ (Kicker Badge)</label>
                                <input type="text" id="deal_kicker_km" name="deal_kicker_km" class="admin-form-input modern-input" value="{{ old('deal_kicker_km', $settings['deal_kicker_km'] ?? 'ប្រូម៉ូសិនពិសេសថ្ងៃនេះ') }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="deal_title_km">ឈ្មោះទំនិញ Deal (Product Title) *</label>
                                <input type="text" id="deal_title_km" name="deal_title_km" class="admin-form-input modern-input" value="{{ old('deal_title_km', $settings['deal_title_km'] ?? 'កាសស្ដាប់ត្រចៀកឥតខ្សែ') }}" required>
                            </div>
                        </div>

                        <div class="form-row-three-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="deal_price">តម្លៃប្រូម៉ូសិន Sale Price ($) *</label>
                                <input type="number" step="0.01" min="0" id="deal_price" name="deal_price" class="admin-form-input modern-input" value="{{ old('deal_price', $settings['deal_price'] ?? 32.00) }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="deal_old_price">តម្លៃដើម Original Price ($) *</label>
                                <input type="number" step="0.01" min="0" id="deal_old_price" name="deal_old_price" class="admin-form-input modern-input" value="{{ old('deal_old_price', $settings['deal_old_price'] ?? 42.00) }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="deal_discount">ស្លាកបញ្ចុះតម្លៃ Discount Badge</label>
                                <input type="text" id="deal_discount" name="deal_discount" class="admin-form-input modern-input" value="{{ old('deal_discount', $settings['deal_discount'] ?? '-24%') }}" required>
                            </div>
                        </div>

                        <div class="form-row-three-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="deal_sold_percent">ភាគរយលក់ដាច់ (% Sold)</label>
                                <input type="number" min="0" max="100" id="deal_sold_percent" name="deal_sold_percent" class="admin-form-input modern-input" value="{{ old('deal_sold_percent', $settings['deal_sold_percent'] ?? 78) }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="deal_stock_left">ចំនួនទំនិញនៅសល់ (Stock Left)</label>
                                <input type="number" min="1" id="deal_stock_left" name="deal_stock_left" class="admin-form-input modern-input" value="{{ old('deal_stock_left', $settings['deal_stock_left'] ?? 5) }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="deal_countdown_hours">ម៉ោងរាប់ថយក្រោយ (Countdown Hours)</label>
                                <input type="number" min="1" max="72" id="deal_countdown_hours" name="deal_countdown_hours" class="admin-form-input modern-input" value="{{ old('deal_countdown_hours', $settings['deal_countdown_hours'] ?? 6) }}" required>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label" for="deal_image">រូបភាពទំនិញ Deal Image URL</label>
                            <input type="url" id="deal_image" name="deal_image" class="admin-form-input modern-input" value="{{ old('deal_image', $settings['deal_image'] ?? 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=400&q=80') }}" placeholder="https://...">
                            <span class="field-hint">ឬផ្ទុករូបភាពឡើងពីកុំព្យូទ័ររបស់អ្នក៖</span>
                            <input type="file" name="deal_image_file" accept="image/*" class="admin-form-input modern-input" style="margin-top: 6px;">
                        </div>

                        <!-- Section 2: Special Voucher Coupon Card -->
                        <div class="form-divider-modern">
                            <div class="divider-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                    <path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path>
                                </svg>
                            </div>
                            <div class="divider-text">
                                <h4>🎟 2. Exclusive Voucher Coupon (ប័ណ្ណបញ្ចុះតម្លៃពិសេស)</h4>
                                <p>Widget បង្ហាញនៅខាងស្ដាំជាមួយប៊ូតុង Copy កូដ និងបញ្ចុះតម្លៃ</p>
                            </div>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="voucher_code">
                                    <span class="badge-discount-tag">VOUCHER CODE</span>
                                    កូដប័ណ្ណបញ្ចុះតម្លៃ *
                                </label>
                                <input type="text" id="voucher_code" name="voucher_code" class="admin-form-input modern-input uppercase-code" value="{{ old('voucher_code', $settings['voucher_code'] ?? 'DARA20') }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="voucher_amount_text">ចំនួនបញ្ចុះតម្លៃ (Discount Heading) *</label>
                                <input type="text" id="voucher_amount_text" name="voucher_amount_text" class="admin-form-input modern-input" value="{{ old('voucher_amount_text', $settings['voucher_amount_text'] ?? '$20.00 OFF') }}" required>
                            </div>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="voucher_desc_km">ការពិពណ៌នាជាភាសាខ្មែរ *</label>
                                <input type="text" id="voucher_desc_km" name="voucher_desc_km" class="admin-form-input modern-input" value="{{ old('voucher_desc_km', $settings['voucher_desc_km'] ?? 'បញ្ចុះតម្លៃ $20 លើការទិញចាប់ពី $80 ឡើងទៅ') }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="voucher_min_spend">ការចំណាយអប្បបរមា Min Spend ($)</label>
                                <input type="number" step="0.01" min="0" id="voucher_min_spend" name="voucher_min_spend" class="admin-form-input modern-input" value="{{ old('voucher_min_spend', $settings['voucher_min_spend'] ?? 80.00) }}" required>
                            </div>
                        </div>

                        <!-- Section 3: Spotlight & Side Feature Banners -->
                        <div class="form-divider-modern">
                            <div class="divider-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                            <div class="divider-text">
                                <h4>🌟 3. Spotlight & Side Feature Banners (ផ្ទាំងផ្សាយពាណិជ្ជកម្មចំហៀង)</h4>
                                <p>ផ្ទាំងរូបភាពផ្សាយពាណិជ្ជកម្មនៅចំហៀងឆ្វេង និងស្តាំ</p>
                            </div>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="spotlight_title_km">ចំណងជើង Spotlight (ឆ្វេង) *</label>
                                <input type="text" id="spotlight_title_km" name="spotlight_title_km" class="admin-form-input modern-input" value="{{ old('spotlight_title_km', $settings['spotlight_title_km'] ?? 'ទិញបានយ៉ាងងាយស្រួល') }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="spotlight_caption_km">ពាក្យស្លោក Spotlight Caption</label>
                                <input type="text" id="spotlight_caption_km" name="spotlight_caption_km" class="admin-form-input modern-input" value="{{ old('spotlight_caption_km', $settings['spotlight_caption_km'] ?? 'ហាងអនឡាញដែលអ្នកទុកចិត្ត') }}" required>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label" for="spotlight_image">រូបភាព Spotlight Image URL</label>
                            <input type="url" id="spotlight_image" name="spotlight_image" class="admin-form-input modern-input" value="{{ old('spotlight_image', $settings['spotlight_image'] ?? 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=600&q=80') }}">
                            <input type="file" name="spotlight_image_file" accept="image/*" class="admin-form-input modern-input" style="margin-top: 6px;">
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="side_feature_title_km">ចំណងជើង Side Feature (ស្តាំ) *</label>
                                <input type="text" id="side_feature_title_km" name="side_feature_title_km" class="admin-form-input modern-input" value="{{ old('side_feature_title_km', $settings['side_feature_title_km'] ?? 'បន្ថែមភាពស្រស់ស្អាតក្នុងថ្ងៃរបស់អ្នក') }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="side_feature_kicker_km">ស្លាក Kicker</label>
                                <input type="text" id="side_feature_kicker_km" name="side_feature_kicker_km" class="admin-form-input modern-input" value="{{ old('side_feature_kicker_km', $settings['side_feature_kicker_km'] ?? 'ស្ទីលថ្មី') }}" required>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label" for="side_feature_image">រូបភាព Side Feature Image URL</label>
                            <input type="url" id="side_feature_image" name="side_feature_image" class="admin-form-input modern-input" value="{{ old('side_feature_image', $settings['side_feature_image'] ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=600&q=80') }}">
                            <input type="file" name="side_feature_image_file" accept="image/*" class="admin-form-input modern-input" style="margin-top: 6px;">
                        </div>

                        <!-- Section 4: Customer Support & Social Channels -->
                        <div class="form-divider-modern">
                            <div class="divider-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div class="divider-text">
                                <h4>📞 4. Need Help Card & Social Links (ជំនួយអតិថិជន & បណ្តាញសង្គម)</h4>
                                <p>គ្រប់គ្រងការទាក់ទងមកកាន់ហាង លេខទូរស័ព្ទ និងតេឡេក្រាមជំនួយ</p>
                            </div>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="help_title_km">ចំណងជើងប្រអប់ជំនួយ *</label>
                                <input type="text" id="help_title_km" name="help_title_km" class="admin-form-input modern-input" value="{{ old('help_title_km', $settings['help_title_km'] ?? 'ត្រូវការជំនួយមែនទេ?') }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="telegram_support">Telegram Support Link (តំណភ្ជាប់តេឡេក្រាម) *</label>
                                <input type="url" id="telegram_support" name="telegram_support" class="admin-form-input modern-input" value="{{ old('telegram_support', $settings['telegram_support'] ?? 'https://t.me/daramarket_support') }}" placeholder="https://t.me/..." required>
                            </div>
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label" for="help_desc_km">ការពិពណ៌នាប្រអប់ជំនួយ *</label>
                            <input type="text" id="help_desc_km" name="help_desc_km" class="admin-form-input modern-input" value="{{ old('help_desc_km', $settings['help_desc_km'] ?? 'ក្រុមការងារយើងរីករាយជួយអ្នកជ្រើសរើសទំនិញ។') }}" required>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="facebook_link">Facebook Page URL</label>
                                <input type="url" id="facebook_link" name="facebook_link" class="admin-form-input modern-input" value="{{ old('facebook_link', $settings['facebook_link'] ?? 'https://facebook.com/daramarket') }}">
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="tiktok_link">TikTok Profile URL</label>
                                <input type="url" id="tiktok_link" name="tiktok_link" class="admin-form-input modern-input" value="{{ old('tiktok_link', $settings['tiktok_link'] ?? 'https://tiktok.com/@daramarket') }}">
                            </div>
                        </div>

                        <div class="form-actions-bar-modern">
                            <button type="submit" class="admin-primary-button button-with-glow">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                </svg>
                                <span>Save All Storefront & Widget Settings</span>
                            </button>
                        </div>
                    </form>
                </section>

            <!-- Tab 6: Admin Credentials & Security -->
            @elseif ($tab === 'profile')
                <section class="admin-panel settings-premium-card">
                    <div class="settings-card-header">
                        <div class="header-icon-badge badge-dark">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div class="header-text-content">
                            <h3>Store Manager Credentials & Password Security</h3>
                            <p>កែប្រែឈ្មោះអ្នកគ្រប់គ្រង អ៊ីមែលសម្រាប់ចូលគណនី និងផ្លាស់ប្តូរពាក្យសម្ងាត់សុវត្ថិភាព។</p>
                        </div>
                        <span class="badge-status-pill badge-primary">🛡️ SUPER ADMINISTRATOR</span>
                    </div>

                    <form action="{{ route('admin.settings.profile') }}" method="POST" class="settings-modern-form">
                        @csrf
                        @method('PUT')

                        <div class="admin-profile-hero">
                            <div class="profile-big-avatar">
                                <span>{{ strtoupper(substr(auth()->user()?->name ?? 'D', 0, 1)) }}</span>
                            </div>
                            <div class="profile-meta-info">
                                <h4>{{ auth()->user()?->name ?? 'Dara Admin' }}</h4>
                                <span class="profile-email-badge">{{ auth()->user()?->email ?? 'admin@daramarket.com' }}</span>
                                <span class="role-chip">System Administrator &bull; Full Privileges</span>
                            </div>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="admin-name">Admin Display Name *</label>
                                <input type="text" id="admin-name" name="name" class="admin-form-input modern-input" value="{{ old('name', $user->name ?? 'Dara Admin') }}" required>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="admin-email">Admin Login Email Address *</label>
                                <input type="email" id="admin-email" name="email" class="admin-form-input modern-input" value="{{ old('email', $user->email ?? 'admin@daramarket.com') }}" required>
                            </div>
                        </div>

                        <div class="form-divider-modern">
                            <div class="divider-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <div class="divider-text">
                                <h4>ផ្លាស់ប្តូរពាក្យសម្ងាត់សុវត្ថិភាព (Change Security Password)</h4>
                                <p>ទុកប្រអប់នេះទំនេរ ប្រសិនបើអ្នកមិនចង់ប្តូរពាក្យសម្ងាត់ចាស់របស់អ្នក។</p>
                            </div>
                        </div>

                        <div class="form-row-two-col">
                            <div class="admin-form-group">
                                <label class="admin-form-label" for="admin-pass">New Password (ពាក្យសម្ងាត់ថ្មី)</label>
                                <div class="password-input-group">
                                    <input type="password" id="admin-pass" name="password" class="admin-form-input modern-input" placeholder="បញ្ចូលពាក្យសម្ងាត់ថ្មី (យ៉ាងហោចណាស់ ៦ តួអក្សរ)">
                                    <button type="button" class="btn-toggle-eye" onclick="togglePasswordVisibility('admin-pass', this)" title="បង្ហាញ/លាក់">👁️</button>
                                </div>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label" for="admin-pass-confirm">Confirm Password (បញ្ជាក់ពាក្យសម្ងាត់)</label>
                                <div class="password-input-group">
                                    <input type="password" id="admin-pass-confirm" name="password_confirmation" class="admin-form-input modern-input" placeholder="វាយបញ្ចូលពាក្យសម្ងាត់ថ្មីម្តងទៀត">
                                    <button type="button" class="btn-toggle-eye" onclick="togglePasswordVisibility('admin-pass-confirm', this)" title="បង្ហាញ/លាក់">👁️</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions-bar-modern">
                            <button type="submit" class="admin-primary-button button-with-glow">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <span>Update Administrator Credentials</span>
                            </button>
                        </div>
                    </form>
                </section>
            @endif

        </div>

        <!-- Sticky Sidebar: Live Storefront Preview & Interactive Calculator -->
        <aside class="settings-preview-column">
            <div class="preview-sticky-card">
                <div class="preview-card-head">
                    <div class="live-pulse-dot"></div>
                    <div>
                        <h4 class="preview-title">Live Storefront Preview</h4>
                        <span class="preview-subtitle">ផ្ទាំងបង្ហាញជាក់ស្តែងលើ Store</span>
                    </div>
                </div>

                <!-- Mini Mock Storefront Card -->
                <div class="storefront-mini-mock">
                    <!-- Mini Announcement Topbar -->
                    <div class="mock-topbar">
                        <span class="mock-ticker" id="mockTickerText">{{ $settings['announcement_text_km'] ?? 'ដឹកជញ្ជូនឥតគិតថ្លៃ រាល់ការកម្ម៉ង់ចាប់ពី $' . $settings['free_shipping_threshold'] . ' ឡើងទៅ!' }}</span>
                        <span class="mock-promo-pill" id="mockPromoPill">{{ $settings['announcement_promo'] ?? 'DARA2026' }}</span>
                    </div>

                    <!-- Mini Store Header -->
                    <div class="mock-store-header">
                        <div class="mock-brand">
                            <div class="mock-brand-mark">d</div>
                            <div>
                                <strong class="mock-store-name" id="mockStoreNameEn">{{ $settings['store_name_en'] ?? 'Dara Market' }}</strong>
                                <small class="mock-store-km" id="mockStoreNameKm">{{ $settings['store_name_km'] ?? 'ផ្សារតារា' }}</small>
                            </div>
                        </div>
                        <div class="mock-phone-pill" id="mockPhone">
                            <span>📞</span> <span id="mockPhoneVal">{{ $settings['contact_phone'] ?? '+855 71 450 4547' }}</span>
                        </div>
                    </div>

                    <!-- Mini Store Info Badges -->
                    <div class="mock-badges-strip">
                        <div class="mock-badge-pill">
                            <span class="badge-icon">💱</span>
                            <span id="mockRateVal">1 USD = {{ number_format((float)$settings['exchange_rate']) }} ៛</span>
                        </div>
                        <div class="mock-badge-pill">
                            <span class="badge-icon">🚚</span>
                            <span id="mockFreeShipVal">Free &gt; ${{ number_format((float)$settings['free_shipping_threshold'], 0) }}</span>
                        </div>
                    </div>

                    <!-- Supported Payments Mini Row -->
                    <div class="mock-payments-row">
                        <span class="mock-payments-label">Accepted Payments:</span>
                        <div class="mock-bank-chips">
                            <span class="mock-chip chip-aba {{ !empty($settings['enable_aba']) ? 'active' : 'dimmed' }}" id="chipAba">ABA</span>
                            <span class="mock-chip chip-wing {{ !empty($settings['enable_wing']) ? 'active' : 'dimmed' }}" id="chipWing">Wing</span>
                            <span class="mock-chip chip-acleda {{ !empty($settings['enable_acleda']) ? 'active' : 'dimmed' }}" id="chipAcleda">ACLEDA</span>
                            <span class="mock-chip chip-cod {{ !empty($settings['enable_cod']) ? 'active' : 'dimmed' }}" id="chipCod">COD</span>
                        </div>
                    </div>
                </div>

                <!-- Interactive Currency Test Calculator -->
                <div class="currency-quick-calculator">
                    <div class="calc-head">
                        <span class="calc-icon">⚡</span>
                        <strong>Quick Riel Conversion Test</strong>
                    </div>
                    <p class="calc-desc">សាកល្បងគណនាប្រាក់ដុល្លារ ($) ទៅប្រាក់រៀល (៛) តាមអត្រាប្តូរប្រាក់បច្ចុប្បន្ន៖</p>

                    <div class="calc-input-row">
                        <div class="calc-field">
                            <label>USD Amount ($)</label>
                            <input type="number" id="testUsdInput" value="25" min="1" step="1" oninput="calculateRielConversion()">
                        </div>
                        <div class="calc-equals">=</div>
                        <div class="calc-field">
                            <label>KHR Equivalent (៛)</label>
                            <input type="text" id="testKhrOutput" value="{{ number_format(25 * (float)$settings['exchange_rate']) }} ៛" readonly>
                        </div>
                    </div>
                </div>

                <!-- Storage Status Card -->
                <div class="storage-health-card">
                    <div class="health-icon">💾</div>
                    <div class="health-info">
                        <strong>Persistent Storage Active</strong>
                        <small>Saved to <code>storage/app/settings.json</code> & Laravel Memory Cache.</small>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
// Dynamic live preview updating as the admin types
document.addEventListener('DOMContentLoaded', function() {
    const storeNameEnInput = document.getElementById('store_name_en');
    const storeNameKmInput = document.getElementById('store_name_km');
    const phoneInput = document.getElementById('contact_phone');
    const rateInput = document.getElementById('exchange_rate');
    const freeShipInput = document.getElementById('free_shipping_threshold');
    const promoInput = document.getElementById('announcement_promo');
    const tickerKmInput = document.getElementById('announcement_text_km');

    if (storeNameEnInput) {
        storeNameEnInput.addEventListener('input', function() {
            const val = this.value.trim() || 'Dara Market';
            const el = document.getElementById('mockStoreNameEn');
            if (el) el.textContent = val;
        });
    }

    if (storeNameKmInput) {
        storeNameKmInput.addEventListener('input', function() {
            const val = this.value.trim() || 'ផ្សារតារា';
            const el = document.getElementById('mockStoreNameKm');
            const kpi = document.getElementById('kpiStoreName');
            if (el) el.textContent = val;
            if (kpi) kpi.textContent = val;
        });
    }

    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            const val = this.value.trim() || '+855 71 450 4547';
            const el = document.getElementById('mockPhoneVal');
            if (el) el.textContent = val;
        });
    }

    if (rateInput) {
        rateInput.addEventListener('input', function() {
            const rate = parseFloat(this.value) || 4100;
            const el = document.getElementById('mockRateVal');
            const kpi = document.getElementById('kpiExchangeRate');
            if (el) el.textContent = '1 USD = ' + rate.toLocaleString() + ' ៛';
            if (kpi) kpi.textContent = '1 USD = ' + rate.toLocaleString() + ' KHR';
            calculateRielConversion();
        });
    }

    if (freeShipInput) {
        freeShipInput.addEventListener('input', function() {
            const val = parseFloat(this.value) || 35;
            const el = document.getElementById('mockFreeShipVal');
            const kpi = document.getElementById('kpiFreeShipping');
            if (el) el.textContent = 'Free > $' + val.toFixed(0);
            if (kpi) kpi.textContent = 'ចាប់ពី $' + val.toFixed(2);
        });
    }

    if (promoInput) {
        promoInput.addEventListener('input', function() {
            const val = this.value.trim().toUpperCase() || 'DARA2026';
            const el = document.getElementById('mockPromoPill');
            if (el) el.textContent = val;
        });
    }

    if (tickerKmInput) {
        tickerKmInput.addEventListener('input', function() {
            const val = this.value.trim() || 'ដឹកជញ្ជូនឥតគិតថ្លៃ រាល់ការកម្ម៉ង់ចាប់ពី $35 ឡើងទៅ!';
            const el = document.getElementById('mockTickerText');
            if (el) el.textContent = val;
        });
    }
});

function updateGatewayPreview() {
    const toggleAba = document.getElementById('toggle_aba');
    const toggleWing = document.getElementById('toggle_wing');
    const toggleAcleda = document.getElementById('toggle_acleda');
    const toggleCod = document.getElementById('toggle_cod');

    const chipAba = document.getElementById('chipAba');
    const chipWing = document.getElementById('chipWing');
    const chipAcleda = document.getElementById('chipAcleda');
    const chipCod = document.getElementById('chipCod');

    if (toggleAba && chipAba) chipAba.className = toggleAba.checked ? 'mock-chip chip-aba active' : 'mock-chip chip-aba dimmed';
    if (toggleWing && chipWing) chipWing.className = toggleWing.checked ? 'mock-chip chip-wing active' : 'mock-chip chip-wing dimmed';
    if (toggleAcleda && chipAcleda) chipAcleda.className = toggleAcleda.checked ? 'mock-chip chip-acleda active' : 'mock-chip chip-acleda dimmed';
    if (toggleCod && chipCod) chipCod.className = toggleCod.checked ? 'mock-chip chip-cod active' : 'mock-chip chip-cod dimmed';
}

function calculateRielConversion() {
    const usdInput = document.getElementById('testUsdInput');
    const rateInput = document.getElementById('exchange_rate');
    const khrOutput = document.getElementById('testKhrOutput');

    const rate = rateInput ? (parseFloat(rateInput.value) || 4100) : {{ (float)$settings['exchange_rate'] }};
    const usd = usdInput ? (parseFloat(usdInput.value) || 0) : 25;

    const khr = Math.round(usd * rate);
    if (khrOutput) {
        khrOutput.value = khr.toLocaleString() + ' ៛';
    }
}

function togglePasswordVisibility(fieldId, btn) {
    const field = document.getElementById(fieldId);
    if (!field) return;
    if (field.type === 'password') {
        field.type = 'text';
        btn.textContent = '🙈';
    } else {
        field.type = 'password';
        btn.textContent = '👁️';
    }
}
</script>
@endsection
