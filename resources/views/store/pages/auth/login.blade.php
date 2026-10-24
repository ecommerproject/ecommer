@extends('store.layouts.app')

@section('title', $translations['account']['login_title'].' | Dara Market')

@section('content')
    <div class="container auth-page">
        <!-- Left Showcase Panel -->
        <section class="auth-showcase">
            <div class="auth-showcase-decor-circle circle-1" aria-hidden="true"></div>
            <div class="auth-showcase-decor-circle circle-2" aria-hidden="true"></div>

            <div class="auth-showcase-header">
                <a class="brand auth-brand" href="{{ route('store.home') }}">
                    <span class="brand-mark" aria-hidden="true">d</span>
                    <span class="brand-copy">dara<span>market</span></span>
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
                    <svg viewBox="0 0 48 48" aria-hidden="true"><path fill="#FFC107" d="M43.6 24.5c0-1.4-.1-2.8-.4-4.1H24v7.8h11a9.4 9.4 0 0 1-4.1 6.2v5.1h6.6c3.9-3.6 6.1-8.8 6.1-15Z"/><path fill="#4CAF50" d="M24 44c5.5 0 10.1-1.8 13.5-4.8l-6.6-5.1c-1.8 1.2-4.1 1.9-6.9 1.9-5.3 0-9.8-3.6-11.4-8.4H5.8v5.3A20 20 0 0 0 24 44Z"/><path fill="#1976D2" d="M12.6 27.6a12 12 0 0 1 0-7.2v-5.3H5.8a20 20 0 0 0 0 17.8l6.8-5.3Z"/><path fill="#FF3D00" d="M24 12c3 0 5.7 1 7.8 3.1l5.9-5.9C34.1 5.8 29.5 4 24 4A20 20 0 0 0 5.8 15.1l6.8 5.3C14.2 15.6 18.7 12 24 12Z"/></svg>
                    <span>{{ $translations['account']['google_continue'] }}</span>
                </a>

                <form action="{{ route('demo.login') }}" method="POST" class="auth-demo-form">
                    @csrf
                    <button type="submit" class="auth-demo-btn" title="ចូលគណនីសាកល្បងភ្លាមៗដោយមិនបាច់បំពេញព័ត៌មាន">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>{{ $translations['account']['demo_quick_login'] ?? 'ចូលគណនីសាកល្បងរហ័ស' }}</span>
                    </button>
                </form>
            </div>

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
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" placeholder="{{ $translations['account']['email_placeholder'] ?? 'example@gmail.com' }}" required autofocus>
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
@endsection
