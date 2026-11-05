@extends('store.layouts.app')

@section('title', $translations['account']['login_title'].' | Collection Trend')

@section('content')
    <div class="container auth-page">
        <!-- Left Showcase Panel -->
        <section class="auth-showcase">
            <div class="auth-showcase-decor-circle circle-1" aria-hidden="true"></div>
            <div class="auth-showcase-decor-circle circle-2" aria-hidden="true"></div>

            <div class="auth-showcase-header">
                <a class="brand auth-brand" href="{{ route('store.home') }}">
                    <span class="brand-mark" aria-hidden="true"><img src="{{ asset('images/logo-icon.svg') }}?v=1793854612" alt="Collection Trend Logo" width="40" height="40"></span>
                    <span class="brand-copy">collection<span>-trend</span></span>
                </a>
                <span class="auth-showcase-tag">ហាងទំនិញផ្លូវការ</span>
            </div>

            <div class="auth-showcase-content">
                <div class="auth-showcase-badge">
                    <span class="sparkle-icon" aria-hidden="true">✦</span>
                    <span>{{ $translations['account']['benefit_badge'] ?? 'អត្ថប្រយោជន៍សមាជិកពិសេស' }}</span>
                </div>
                <h2>{{ $translations['account']['showcase_title'] }}</h2>
                <p>{{ $translations['account']['showcase_description'] }}</p>

                <div class="auth-benefits-list">
                    <div class="auth-benefit-card">
                        <div class="benefit-icon-box">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                        <div class="benefit-card-text">
                            <strong>{{ $translations['account']['benefit_delivery_title'] ?? 'ដឹកជញ្ជូនរហ័ស & ឥតគិតថ្លៃ' }}</strong>
                            <small>{{ $translations['account']['benefit_delivery_desc'] ?? 'ដឹកជញ្ជូនដល់គេហដ្ឋាន និងតាមដានទំនិញបានគ្រប់ពេលវេលា' }}</small>
                        </div>
                    </div>

                    <div class="auth-benefit-card">
                        <div class="benefit-icon-box">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>
                        </div>
                        <div class="benefit-card-text">
                            <strong>{{ $translations['account']['benefit_quality_title'] ?? 'គុណភាពធានា ១០០%' }}</strong>
                            <small>{{ $translations['account']['benefit_quality_desc'] ?? 'ផលិតផលសុទ្ធល្អ មានស្តង់ដារ និងការត្រួតពិនិត្យច្បាស់លាស់' }}</small>
                        </div>
                    </div>

                    <div class="auth-benefit-card">
                        <div class="benefit-icon-box">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                        </div>
                        <div class="benefit-card-text">
                            <strong>{{ $translations['account']['benefit_rewards_title'] ?? 'កាដូ & ពិន្ទុរង្វាន់សន្សំ' }}</strong>
                            <small>{{ $translations['account']['benefit_rewards_desc'] ?? 'សន្សំពិន្ទុរាល់ការទិញ និងទទួលបានប័ណ្ណបញ្ចុះតម្លៃពិសេស' }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Proof Widget -->
            <div class="auth-showcase-proof">
                <div class="proof-avatars">
                    <span class="proof-avatar" style="background:#52b788;">S</span>
                    <span class="proof-avatar" style="background:#40916c;">V</span>
                    <span class="proof-avatar" style="background:#2d6a4f;">K</span>
                    <span class="proof-avatar" style="background:#1b4332;">+</span>
                </div>
                <div class="proof-text">
                    <div class="proof-rating">★★★★★ <span>4.9 / 5</span></div>
                    <small>{{ $translations['account']['trusted_stat'] ?? 'អតិថិជនជាង ១០,០០០+ នាក់ជឿទុកចិត្ត' }}</small>
                </div>
            </div>
        </section>

        <!-- Right Form Card -->
        <section class="auth-card" aria-labelledby="auth-title">
            <div class="auth-card-nav">
                <a class="auth-back-link" href="{{ route('store.home') }}">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span>{{ $translations['account']['back_to_home'] ?? 'ត្រឡប់ទៅទំព័រដើម' }}</span>
                </a>
                <span class="auth-free-badge">✨ ចូលប្រើប្រាស់</span>
            </div>

            <div class="auth-card-header">
                <h1 id="auth-title">{{ $translations['account']['login_title'] }}</h1>
                <p class="auth-card-subtitle">{{ $translations['account']['login_subtitle'] ?? 'សូមបញ្ចូលអ៊ីមែល និងពាក្យសម្ងាត់របស់អ្នកដើម្បីចូលប្រើប្រាស់' }}</p>
            </div>

            <!-- Social Sign-In & Quick Demo -->
            <div class="auth-social-actions">
                <a class="google-auth-button" href="{{ route('google.redirect') }}" title="ចូលដោយប្រើគណនី Google">
                    <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" style="flex-shrink: 0;"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                    <span>{{ $translations['account']['google_continue'] }}</span>
                </a>

                <form action="{{ route('demo.login') }}" method="POST" class="auth-demo-form" style="display: none !important;">
                    @csrf
                    <button type="submit" class="auth-demo-btn" title="ចូលគណនីសាកល្បងភ្លាមៗដោយមិនបាច់បំពេញព័ត៌មាន">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>{{ $translations['account']['demo_quick_login'] ?? 'ចូលគណនីសាកល្បងរហ័ស' }}</span>
                    </button>

                </form>
            </div>

            @if(session('info'))
                <div class="auth-alert-banner warning" style="background:#fef3c7; border:1px solid #f59e0b; color:#92400e; padding:12px 16px; border-radius:10px; margin-bottom:16px; display:flex; align-items:center; gap:10px;" role="alert">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <strong>{{ session('info') }}</strong>
                </div>
            @endif

            @error('google')
                <div class="auth-alert-banner warning" role="alert">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <div class="auth-alert-content">
                        <strong>កំណត់សម្គាល់ Google Sign-In</strong>
                        <p>{{ $message }}</p>
                    </div>
                </div>
            @enderror

            <div class="auth-divider">
                <span>{{ $translations['account']['or_email'] }}</span>
            </div>

            <!-- Login Form -->
            <form class="auth-form" id="loginForm" action="{{ route('login.store') }}" method="POST" novalidate>
                @csrf

                <!-- Email Field -->
                <div class="form-field-group @error('email') has-error @enderror">
                    <label for="email">
                        <span>{{ $translations['account']['email'] }}</span>
                        <span class="required-star">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                        <span class="input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="20" height="20" aria-label="Gmail" style="flex-shrink:0;"><path d="M1.5 6.5v11c0 1.1.9 2 2 2h3.5v-9L1.5 6.5z" fill="#4285f4"/><path d="M22.5 6.5v11c0 1.1-.9 2-2 2H17v-9l5.5-4z" fill="#34a853"/><path d="M1.5 6.5L12 14.5l10.5-8V5c0-1.5-1.7-2.4-2.9-1.5L12 9.2 4.4 3.5C3.2 2.6 1.5 3.5 1.5 5v1.5z" fill="#ea4335"/><path d="M7 10.5v9h10v-9L12 14.5 7 10.5z" fill="#fbbc04"/></svg>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" placeholder="collection-trend123@gmail.com" required autofocus>
                    </div>
                    @error('email')
                        <span class="auth-error-msg" role="alert">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-field-group @error('password') has-error @enderror">
                    <div class="field-label-row">
                        <label for="password">
                            <span>{{ $translations['account']['password'] }}</span>
                            <span class="required-star">*</span>
                        </label>
                    </div>
                    <div class="auth-input-wrapper">
                        <span class="input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </span>
                        <input id="password" name="password" type="password" autocomplete="current-password" placeholder="{{ $translations['account']['password_placeholder'] ?? 'បញ្ចូលពាក្យសម្ងាត់' }}" required>
                        <button type="button" class="auth-pwd-toggle" onclick="togglePasswordVisibility('password', this)" aria-label="Toggle password view" tabindex="-1">
                            <svg class="eye-open" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="7" r="3"></circle></svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
    
                    </div>
                    @error('password')
                        <span class="auth-error-msg" role="alert">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="auth-remember-row">
                    <label class="auth-checkbox-label" for="remember">
                        <input id="remember" name="remember" type="checkbox" value="1" @checked(old('remember'))>
                        <span class="custom-checkbox" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <span>{{ $translations['account']['remember'] }}</span>
                    </label>
                </div>

                <!-- Submit Button with Spinner -->
                <button class="button auth-submit-btn" id="loginSubmitBtn" type="submit">
                    <span class="btn-text">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        <span>{{ $translations['account']['login'] }}</span>
                    </span>
                    <span class="btn-spinner" style="display:none;">
                        <span class="spinner-ring"></span>
                        <span>{{ $translations['account']['submit_processing'] ?? 'កំពុងដំណើរការ...' }}</span>
                    </span>
                </button>
            </form>

            <!-- Bottom Switch -->
            <p class="auth-switch">
                {{ $translations['account']['no_account'] }}
                <a href="{{ route('register') }}" class="auth-switch-link">{{ $translations['account']['register_link'] }} →</a>
            </p>

            <div class="auth-trust-note">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>{{ $translations['account']['security_notice'] ?? 'ព័ត៌មានរបស់អ្នកត្រូវបានការពារដោយបច្ចេកវិទ្យា 256-bit SSL' }}</span>
            </div>
        </section>
    </div>

    <script>
                function togglePasswordVisibility(fieldId, btn) {
            const input = document.getElementById(fieldId);
            if (!input) return;
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }

        document.getElementById('loginForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('loginSubmitBtn');
            if (btn) {
                btn.classList.add('is-submitting');
                btn.querySelector('.btn-text').style.display = 'none';
                btn.querySelector('.btn-spinner').style.display = 'inline-flex';
            }
        });
    </script>

    <style>
        /* Premium Luxury Auth Styling */
        .auth-page {
            max-width: 1040px;
            margin: 40px auto;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px -15px rgba(23, 62, 44, 0.18), 0 0 1px rgba(0, 0, 0, 0.1);
        }

        .auth-card {
            padding: 44px 48px;
            background: #ffffff;
        }

        /* Modern Official Google / Gmail Button */
        .google-auth-button {
            min-height: 50px;
            background: #ffffff !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 14px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
            font-size: 14.5px !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
            text-decoration: none !important;
            width: 100% !important;
        }

        .google-auth-button:hover {
            background: #ffffff !important;
            border-color: #4285f4 !important;
            box-shadow: 0 6px 22px rgba(66, 133, 244, 0.2) !important;
            transform: translateY(-2px) !important;
            color: #1a56db !important;
        }

        .google-auth-button:active {
            transform: translateY(0) !important;
        }

        /* Divider */
        .auth-divider {
            margin: 24px 0 !important;
            position: relative !important;
            text-align: center !important;
        }

        .auth-divider::before {
            content: "" !important;
            position: absolute !important;
            top: 50% !important;
            left: 0 !important;
            right: 0 !important;
            height: 1px !important;
            background: linear-gradient(90deg, transparent, #e2e8f0 20%, #e2e8f0 80%, transparent) !important;
        }

        .auth-divider span {
            position: relative !important;
            background: #ffffff !important;
            padding: 0 16px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #94a3b8 !important;
        }

        /* Input Fields Luxury Polish */
        .form-field-group label {
            font-weight: 600 !important;
            font-size: 13.5px !important;
            color: #1e293b !important;
            margin-bottom: 7px !important;
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
        }

        .auth-input-wrapper {
            position: relative !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 14px !important;
            background: #f8fafc !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
            overflow: hidden !important;
        }

        .auth-input-wrapper:hover {
            border-color: #cbd5e1 !important;
            background: #ffffff !important;
        }

        .auth-input-wrapper:focus-within {
            border-color: #245943 !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 4px rgba(36, 89, 67, 0.12), 0 4px 12px rgba(36, 89, 67, 0.06) !important;
        }

        .auth-input-wrapper .input-icon {
            position: absolute !important;
            left: 14px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            pointer-events: none !important;
            z-index: 2 !important;
        }

        .auth-input-wrapper input {
            width: 100% !important;
            height: 48px !important;
            padding: 10px 14px 10px 46px !important;
            border: none !important;
            background: transparent !important;
            font-size: 14px !important;
            color: #0f172a !important;
            outline: none !important;
            font-family: inherit !important;
        }

        .auth-input-wrapper input::placeholder {
            color: #94a3b8 !important;
            font-size: 13.5px !important;
        }

        /* Password Eye Toggle */
        .auth-pwd-toggle {
            position: absolute !important;
            right: 12px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            background: none !important;
            border: none !important;
            color: #94a3b8 !important;
            cursor: pointer !important;
            padding: 6px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.2s ease !important;
        }

        .auth-pwd-toggle:hover {
            color: #245943 !important;
            background: rgba(36, 89, 67, 0.08) !important;
        }

        /* Submit Button */
        .auth-submit-btn {
            width: 100% !important;
            min-height: 50px !important;
            border-radius: 14px !important;
            background: linear-gradient(135deg, #1b4d3e 0%, #245943 55%, #1f6b4e 100%) !important;
            color: #ffffff !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            border: none !important;
            box-shadow: 0 4px 18px rgba(36, 89, 67, 0.35) !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
            margin-top: 20px !important;
        }

        .auth-submit-btn:hover {
            box-shadow: 0 8px 25px rgba(36, 89, 67, 0.48) !important;
            transform: translateY(-2px) !important;
            filter: brightness(1.04) !important;
        }

        .auth-submit-btn:active {
            transform: translateY(0) !important;
        }

        /* Bottom switch */
        .auth-switch {
            margin-top: 22px !important;
            text-align: center !important;
            font-size: 14px !important;
            color: #64748b !important;
        }

        .auth-switch-link {
            color: #245943 !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            margin-left: 4px !important;
            transition: color 0.2s !important;
        }

        .auth-switch-link:hover {
            color: #173e2c !important;
            text-decoration: underline !important;
        }
    </style>
@endsection


