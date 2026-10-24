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
                                <input type="text" id="contact_phone" name="contact_phone" class="admin-form-input modern-input" value="{{ old('contact_phone', $settings['contact_phone']) }}" placeholder="+855 12 345 678" required>
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

                    <form action="{{ route('admin.settings.payments') }}" method="POST" class="settings-modern-form">
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

                            <div class="gateway-subconfig-box" style="margin-top: -10px; margin-bottom: 16px;">
                                <div class="admin-form-group">
                                    <label class="admin-form-label" for="aba_merchant_id">ABA / Bakong Merchant Account ID</label>
                                    <input type="text" id="aba_merchant_id" name="aba_merchant_id" class="admin-form-input modern-input" value="{{ old('aba_merchant_id', $settings['aba_merchant_id'] ?? 'DARA_MARKET_KHQR') }}" placeholder="DARA_MARKET_KHQR">
                                    <span class="field-hint">Merchant ID សម្រាប់បង្កើត dynamic KHQR scan & pay។</span>
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
                                    <input type="text" id="wing_account_number" name="wing_account_number" class="admin-form-input modern-input" value="{{ old('wing_account_number', $settings['wing_account_number'] ?? '012 345 678') }}" placeholder="012 345 678">
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

            <!-- Tab 5: Admin Credentials & Security -->
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
                            <span>📞</span> <span id="mockPhoneVal">{{ $settings['contact_phone'] ?? '+855 12 345 678' }}</span>
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
            const val = this.value.trim() || '+855 12 345 678';
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
