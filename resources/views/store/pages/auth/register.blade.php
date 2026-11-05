@extends('store.layouts.app')

@section('title', $translations['account']['register_title'].' | Collection Trend')

@section('content')
    <div class="container auth-page">
        <!-- Left Showcase Panel -->
        <section class="auth-showcase">
            <div class="auth-showcase-decor-circle circle-1" aria-hidden="true"></div>
            <div class="auth-showcase-decor-circle circle-2" aria-hidden="true"></div>
            <div class="auth-showcase-decor-circle circle-3" aria-hidden="true"></div>

            <div class="auth-showcase-header">
                <a class="auth-brand-logo" href="{{ route('store.home') }}" title="Collection Trend">
                    <span class="auth-logo-badge" aria-hidden="true">
                        <img src="{{ asset('images/logo-icon.svg') }}?v={{ time() }}" alt="Collection Trend Logo" width="38" height="36">
                    </span>
                    <div class="auth-brand-text">
                        <div class="auth-brand-name">collection<span>-trend</span></div>
                        <small class="auth-brand-tagline">STORE &amp; LIVING</small>
                    </div>
                </a>
                <span class="auth-verified-pill">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>{{ $locale === 'km' ? 'ហាងទំនិញផ្លូវការ' : 'Official Store' }}</span>
                </span>
            </div>

            <div class="auth-showcase-content">
                <div class="auth-showcase-badge">
                    <span class="sparkle-icon" aria-hidden="true">✦</span>
                    <span>{{ $translations['account']['benefit_badge'] ?? ($locale === 'km' ? 'អត្ថប្រយោជន៍សមាជិកពិសេស' : 'Exclusive VIP Benefits') }}</span>
                </div>
                <h2 class="auth-showcase-headline">{{ $translations['account']['showcase_title'] }}</h2>
                <p class="auth-showcase-desc">{{ $translations['account']['showcase_description'] }}</p>

                <div class="auth-benefits-list">
                    <div class="auth-benefit-card">
                        <div class="benefit-icon-box emerald-disk">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                        <div class="benefit-card-text">
                            <strong>{{ $translations['account']['benefit_delivery_title'] ?? ($locale === 'km' ? 'ដឹកជញ្ជូនរហ័ស & ឥតគិតថ្លៃ' : 'Fast & Free Delivery') }}</strong>
                            <small>{{ $translations['account']['benefit_delivery_desc'] ?? ($locale === 'km' ? 'ដឹកជញ្ជូនដល់គេហដ្ឋាន និងតាមដានទំនិញបានគ្រប់ពេលវេលា' : 'Direct home delivery with real-time tracking') }}</small>
                        </div>
                    </div>

                    <div class="auth-benefit-card">
                        <div class="benefit-icon-box gold-disk">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="M9 12l2 2 4-4"></path></svg>
                        </div>
                        <div class="benefit-card-text">
                            <strong>{{ $locale === 'km' ? 'ធានាគុណភាព 100% សុទ្ធពិត' : '100% Certified Authentic' }}</strong>
                            <small>{{ $translations['account']['benefit_quality_desc'] ?? ($locale === 'km' ? 'ផលិតផលសុទ្ធល្អ មានស្តង់ដារ និងការត្រួតពិនិត្យច្បាស់លាស់' : 'Genuine brand products with strict inspection') }}</small>
                        </div>
                    </div>

                    <div class="auth-benefit-card">
                        <div class="benefit-icon-box amber-disk">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                        </div>
                        <div class="benefit-card-text">
                            <strong>{{ $translations['account']['benefit_rewards_title'] ?? ($locale === 'km' ? 'កាដូ & ពិន្ទុរង្វាន់សន្សំ' : 'Gifts & VIP Rewards') }}</strong>
                            <small>{{ $translations['account']['benefit_rewards_desc'] ?? ($locale === 'km' ? 'សន្សំពិន្ទុរាល់ការទិញ និងទទួលបានប័ណ្ណបញ្ចុះតម្លៃ $15' : 'Earn reward points and unlock a welcome coupon') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Proof Widget -->
            <div class="auth-showcase-proof">
                <div class="proof-avatars">
                    <span class="proof-avatar" style="background: linear-gradient(135deg, #10b981, #047857);">S</span>
                    <span class="proof-avatar" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">V</span>
                    <span class="proof-avatar" style="background: linear-gradient(135deg, #f59e0b, #b45309);">K</span>
                    <span class="proof-avatar plus-avatar">+</span>
                </div>
                <div class="proof-text">
                    <div class="proof-rating">
                        <span class="stars">★★★★★</span>
                        <strong class="rating-val">4.9 / 5</strong>
                    </div>
                    <small>{{ $translations['account']['trusted_stat'] ?? ($locale === 'km' ? 'អតិថិជនជាង ១០,០០០+ នាក់ជឿទុកចិត្ត' : 'Trusted by 10,000+ happy customers') }}</small>
                </div>
            </div>
        </section>

        <!-- Right Form Card -->
        <section class="auth-card" aria-labelledby="auth-title">
            <div class="auth-card-nav">
                <a class="auth-back-link" href="{{ route('store.home') }}">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span>{{ $translations['account']['back_to_home'] ?? 'ត្រឡប់ទៅទំព័រដើម' }}</span>
                </a>
                <span class="auth-free-badge">✨ {{ $locale === 'km' ? 'ឥតគិតថ្លៃ 100%' : '100% Free' }}</span>
            </div>

            <div class="auth-card-header">
                <h1 id="auth-title">{{ $translations['account']['register_title'] }}</h1>
                <p class="auth-card-subtitle">{{ $translations['account']['register_subtitle'] ?? 'សូមបញ្ចូលព័ត៌មានខាងក្រោមដើម្បីបង្កើតគណនី និងចាប់ផ្តើមទិញទំនិញ' }}</p>
            </div>

            <!-- Google Sign-In Action -->
            <div class="auth-social-actions">
                <a class="google-auth-button" href="{{ route('google.redirect') }}" title="ចុះឈ្មោះដោយប្រើគណនី Google">
                    <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" style="flex-shrink: 0;"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                    <span>{{ $translations['account']['google_continue'] }}</span>
                </a>
            </div>

            <div class="auth-divider">
                <span>{{ $translations['account']['or_email'] }}</span>
            </div>

            <!-- Register Form -->
            <form class="auth-form" id="registerForm" action="{{ route('register.store') }}" method="POST" novalidate>
                @csrf

                <!-- Name Field -->
                <div class="form-field-group @error('name') has-error @enderror">
                    <label for="name">
                        <span>{{ $translations['account']['name'] }}</span>
                        <span class="required-star">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                        <span class="input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </span>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="255" placeholder="{{ $translations['account']['name_placeholder'] ?? 'ឧ. សុខ វិសាល / Sok Visal' }}" required autofocus>
                    </div>
                    @error('name')
                        <span class="auth-error-msg" role="alert">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="form-field-group @error('email') has-error @enderror">
                    <label for="email">
                        <span>{{ $translations['account']['email'] }}</span>
                        <span class="required-star">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                        <span class="input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="19" height="19" aria-label="Email"><path d="M1.5 6.5v11c0 1.1.9 2 2 2h3.5v-9L1.5 6.5z" fill="#4285f4"/><path d="M22.5 6.5v11c0 1.1-.9 2-2 2H17v-9l5.5-4z" fill="#34a853"/><path d="M1.5 6.5L12 14.5l10.5-8V5c0-1.5-1.7-2.4-2.9-1.5L12 9.2 4.4 3.5C3.2 2.6 1.5 3.5 1.5 5v1.5z" fill="#ea4335"/><path d="M7 10.5v9h10v-9L12 14.5 7 10.5z" fill="#fbbc04"/></svg>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" placeholder="{{ $translations['account']['email_placeholder'] ?? 'example@gmail.com' }}" required>
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
                    <label for="password">
                        <span>{{ $translations['account']['password'] }}</span>
                        <span class="required-star">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                        <span class="input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </span>
                        <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" placeholder="{{ $translations['account']['password_placeholder'] ?? 'យ៉ាងហោចណាស់ ៨ តួអក្សរ' }}" required oninput="evaluatePasswordStrength(this.value)">
                        <button type="button" class="auth-pwd-toggle" onclick="togglePasswordVisibility('password', this)" aria-label="Toggle password view" tabindex="-1">
                            <svg class="eye-open" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>

                    <!-- Password strength visual meter -->
                    <div class="pwd-strength-meter" id="pwdStrengthMeter">
                        <div class="meter-bars">
                            <span class="bar bar-1"></span>
                            <span class="bar bar-2"></span>
                            <span class="bar bar-3"></span>
                            <span class="bar bar-4"></span>
                        </div>
                        <div class="meter-status">
                            <span class="meter-label">{{ $translations['account']['password_strength'] ?? 'កម្រិតសុវត្ថិភាព' }}:</span>
                            <strong class="meter-value" id="meterText">-</strong>
                        </div>
                    </div>

                    @error('password')
                        <span class="auth-error-msg" role="alert">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <span>{{ $message }}</span>
                        </span>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="form-field-group">
                    <label for="password_confirmation">
                        <span>{{ $translations['account']['password_confirmation'] }}</span>
                        <span class="required-star">*</span>
                    </label>
                    <div class="auth-input-wrapper">
                        <span class="input-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </span>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" placeholder="{{ $translations['account']['password_confirm_placeholder'] ?? 'បញ្ចូលពាក្យសម្ងាត់ម្តងទៀត' }}" required oninput="checkPasswordMatch()">
                        <button type="button" class="auth-pwd-toggle" onclick="togglePasswordVisibility('password_confirmation', this)" aria-label="Toggle confirm password view" tabindex="-1">
                            <svg class="eye-open" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                    <!-- Password Match Alert -->
                    <div class="pwd-match-badge" id="pwdMatchBadge" style="display:none;"></div>
                </div>

                <!-- Terms and Conditions Checkbox -->
                <div class="auth-terms-group">
                    <label class="auth-checkbox-label" for="terms_agreed">
                        <input id="terms_agreed" name="terms_agreed" type="checkbox" required checked>
                        <span class="custom-checkbox" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <span class="terms-text">
                            {{ $translations['account']['terms_agree'] ?? 'ខ្ញុំយល់ព្រមតាម' }}
                            <a href="#" onclick="event.preventDefault();">{{ $translations['account']['terms_service'] ?? 'លក្ខខណ្ឌប្រើប្រាស់' }}</a>
                            {{ $translations['account']['and'] ?? 'និង' }}
                            <a href="#" onclick="event.preventDefault();">{{ $translations['account']['privacy_policy'] ?? 'គោលការណ៍ឯកជនភាព' }}</a>
                        </span>
                    </label>
                </div>

                <!-- Submit Button with Clean Spinner -->
                <button class="button auth-submit-btn" id="submitBtn" type="submit">
                    <span class="btn-text">
                        <span>{{ $translations['account']['submit_register'] ?? 'បង្កើតគណនីឥឡូវនេះ' }}</span>
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </span>
                    <span class="btn-spinner">
                        <span class="spinner-ring"></span>
                        <span>{{ $translations['account']['submit_processing'] ?? 'កំពុងដំណើរការ...' }}</span>
                    </span>
                </button>
            </form>

            <!-- Bottom Switch and Trust -->
            <p class="auth-switch">
                {{ $translations['account']['has_account'] }}
                <a href="{{ route('login') }}" class="auth-switch-link">{{ $translations['account']['login_link'] }} →</a>
            </p>

            <div class="auth-trust-note">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>{{ $translations['account']['security_notice'] ?? 'ព័ត៌មានរបស់អ្នកត្រូវបានការពារដោយបច្ចេកវិទ្យា 256-bit SSL Encryption' }}</span>
            </div>
        </section>
    </div>

    <!-- Client-side Interactive Logic for Password, Validation, and Submit -->
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

        function evaluatePasswordStrength(val) {
            const meter = document.getElementById('pwdStrengthMeter');
            const text = document.getElementById('meterText');
            if (!meter || !text) return;

            if (!val || val.length === 0) {
                meter.className = 'pwd-strength-meter';
                text.textContent = '-';
                return;
            }

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val) || /[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            if (val.length >= 12) score++;

            meter.className = 'pwd-strength-meter';
            if (val.length < 8) {
                meter.classList.add('level-weak');
                text.textContent = '{{ $translations['account']['strength_weak'] ?? 'ខ្សោយ (យ៉ាងតិច ៨ តួអក្សរ)' }}';
            } else if (score <= 2) {
                meter.classList.add('level-fair');
                text.textContent = '{{ $translations['account']['strength_fair'] ?? 'មធ្យម' }}';
            } else if (score === 3) {
                meter.classList.add('level-good');
                text.textContent = '{{ $translations['account']['strength_good'] ?? 'ល្អ' }}';
            } else {
                meter.classList.add('level-strong');
                text.textContent = '{{ $translations['account']['strength_strong'] ?? 'ខ្លាំង (ល្អឥតខ្ចោះ)' }}';
            }

            checkPasswordMatch();
        }

        function checkPasswordMatch() {
            const pwd = document.getElementById('password')?.value;
            const confirm = document.getElementById('password_confirmation')?.value;
            const badge = document.getElementById('pwdMatchBadge');
            if (!badge) return;

            if (!confirm || confirm.length === 0) {
                badge.style.display = 'none';
                return;
            }

            badge.style.display = 'inline-flex';
            if (pwd === confirm) {
                badge.className = 'pwd-match-badge match-success';
                badge.innerHTML = '<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> <span>{{ $translations['account']['password_match'] ?? 'ពាក្យសម្ងាត់ត្រូវគ្នា' }}</span>';
            } else {
                badge.className = 'pwd-match-badge match-danger';
                badge.innerHTML = '<svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> <span>{{ $translations['account']['password_mismatch'] ?? 'ពាក្យសម្ងាត់មិនទាន់ត្រូវគ្នាទេ' }}</span>';
            }
        }

        document.getElementById('registerForm')?.addEventListener('submit', function(e) {
            const pwd = document.getElementById('password')?.value;
            const confirm = document.getElementById('password_confirmation')?.value;
            const terms = document.getElementById('terms_agreed');

            if (pwd && confirm && pwd !== confirm) {
                e.preventDefault();
                checkPasswordMatch();
                document.getElementById('password_confirmation')?.focus();
                return false;
            }

            if (terms && !terms.checked) {
                e.preventDefault();
                alert('សូមយល់ព្រមតាមលក្ខខណ្ឌប្រើប្រាស់ជាមុនសិន។');
                return false;
            }

            const btn = document.getElementById('submitBtn');
            if (btn) {
                btn.classList.add('is-submitting');
                btn.querySelector('.btn-text').style.display = 'none';
                btn.querySelector('.btn-spinner').style.display = 'inline-flex';
            }
        });
    </script>

    <style>
        /* ========================================================
           ULTRA-CLEAN LUXURY AUTHENTICATION (COMPACT & BALANCED)
           ======================================================== */
        .auth-page {
            max-width: 980px !important;
            margin: 28px auto 44px !important;
            border-radius: 22px !important;
            overflow: hidden !important;
            display: grid !important;
            grid-template-columns: minmax(340px, 0.95fr) minmax(400px, 1.15fr) !important;
            border: 1px solid rgba(16, 41, 31, 0.12) !important;
            box-shadow: 0 20px 60px -15px rgba(16, 41, 31, 0.2), 0 0 0 1px rgba(255, 255, 255, 0.9) inset !important;
            background: #ffffff !important;
        }

        /* --- Left Showcase Panel --- */
        .auth-showcase {
            position: relative !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            min-height: auto !important;
            padding: 34px 32px !important;
            background: radial-gradient(circle at 100% 0%, rgba(216, 169, 98, 0.18) 0%, transparent 45%),
                        radial-gradient(circle at 0% 100%, rgba(36, 107, 79, 0.28) 0%, transparent 50%),
                        linear-gradient(155deg, #092017 0%, #10291f 42%, #174230 100%) !important;
            color: #ffffff !important;
            overflow: hidden !important;
            z-index: 1 !important;
        }

        .auth-showcase-decor-circle {
            position: absolute !important;
            border-radius: 50% !important;
            pointer-events: none !important;
            z-index: 0 !important;
        }
        .auth-showcase-decor-circle.circle-1 {
            top: -60px !important;
            right: -60px !important;
            width: 240px !important;
            height: 240px !important;
            background: radial-gradient(circle, rgba(216, 169, 98, 0.22) 0%, transparent 70%) !important;
        }
        .auth-showcase-decor-circle.circle-2 {
            bottom: -80px !important;
            left: -60px !important;
            width: 260px !important;
            height: 260px !important;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.18) 0%, transparent 70%) !important;
        }

        /* Brand Row in Showcase */
        .auth-showcase-header {
            position: relative !important;
            z-index: 2 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 10px !important;
        }

        .auth-brand-logo {
            display: inline-flex !important;
            align-items: center !important;
            gap: 10px !important;
            text-decoration: none !important;
            transition: transform 0.2s ease !important;
        }
        .auth-brand-logo:hover {
            transform: translateY(-1px) !important;
        }

        .auth-logo-badge {
            width: 44px !important;
            height: 44px !important;
            border-radius: 12px !important;
            background: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25) !important;
            flex-shrink: 0 !important;
        }
        .auth-logo-badge img {
            width: 32px !important;
            height: 30px !important;
            object-fit: contain !important;
        }

        .auth-brand-text {
            display: flex !important;
            flex-direction: column !important;
            line-height: 1.15 !important;
        }
        .auth-brand-name {
            font-size: 21px !important;
            font-weight: 800 !important;
            color: #ffffff !important;
            letter-spacing: -0.5px !important;
            font-family: 'DM Sans', -apple-system, sans-serif !important;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.25) !important;
        }
        .auth-brand-name span {
            color: #d8a962 !important;
        }
        .auth-brand-tagline {
            font-size: 9.5px !important;
            font-weight: 700 !important;
            color: #a8c4b2 !important;
            letter-spacing: 1.8px !important;
            margin-top: 3px !important;
            font-family: 'DM Sans', -apple-system, sans-serif !important;
        }

        .auth-verified-pill {
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            padding: 4px 11px !important;
            border-radius: 999px !important;
            background: rgba(216, 169, 98, 0.16) !important;
            border: 1px solid rgba(216, 169, 98, 0.38) !important;
            color: #ffd899 !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            letter-spacing: 0.2px !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12) !important;
            backdrop-filter: blur(8px) !important;
            flex-shrink: 0 !important;
        }

        /* Showcase Content */
        .auth-showcase-content {
            position: relative !important;
            z-index: 2 !important;
            margin: 28px 0 20px !important;
        }

        .auth-showcase-badge {
            display: inline-flex !important;
            align-items: center !important;
            gap: 7px !important;
            padding: 5px 12px !important;
            border-radius: 999px !important;
            background: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            backdrop-filter: blur(10px) !important;
            color: #f7df99 !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            letter-spacing: 0.3px !important;
            margin-bottom: 14px !important;
        }
        .auth-showcase-badge .sparkle-icon {
            color: #e5b35a !important;
            font-size: 13px !important;
        }

        .auth-showcase-headline {
            position: relative !important;
            z-index: 2 !important;
            max-width: 380px !important;
            margin: 0 0 10px !important;
            color: #ffffff !important;
            font-size: clamp(24px, 2.6vw, 30px) !important;
            font-weight: 800 !important;
            line-height: 1.38 !important;
            letter-spacing: -0.02em !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.22) !important;
        }

        .auth-showcase-desc {
            position: relative !important;
            z-index: 2 !important;
            max-width: 380px !important;
            margin: 0 0 24px !important;
            color: rgba(255, 255, 255, 0.78) !important;
            font-size: 13.5px !important;
            line-height: 1.65 !important;
        }

        /* Benefit Cards */
        .auth-benefits-list {
            position: relative !important;
            z-index: 2 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }
        .auth-benefit-card {
            display: flex !important;
            align-items: center !important;
            gap: 14px !important;
            padding: 12px 16px !important;
            border-radius: 14px !important;
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.14) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            transition: all 0.22s ease !important;
        }
        .auth-benefit-card:hover {
            transform: translateX(4px) !important;
            background: rgba(255, 255, 255, 0.13) !important;
            border-color: rgba(216, 169, 98, 0.45) !important;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15) !important;
        }

        .benefit-icon-box {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            flex-shrink: 0 !important;
            border-radius: 12px !important;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15) !important;
        }
        .benefit-icon-box.emerald-disk {
            background: linear-gradient(135deg, rgba(52, 211, 153, 0.25), rgba(16, 185, 129, 0.35)) !important;
            border: 1px solid rgba(52, 211, 153, 0.35) !important;
            color: #6ee7b7 !important;
        }
        .benefit-icon-box.gold-disk {
            background: linear-gradient(135deg, rgba(216, 169, 98, 0.25), rgba(245, 158, 11, 0.35)) !important;
            border: 1px solid rgba(216, 169, 98, 0.45) !important;
            color: #fcd34d !important;
        }
        .benefit-icon-box.amber-disk {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.25), rgba(217, 119, 6, 0.35)) !important;
            border: 1px solid rgba(251, 191, 36, 0.4) !important;
            color: #fef08a !important;
        }

        .benefit-card-text {
            display: flex !important;
            flex-direction: column !important;
            gap: 2px !important;
        }
        .benefit-card-text strong {
            color: #ffffff !important;
            font-size: 13.5px !important;
            font-weight: 700 !important;
            line-height: 1.3 !important;
        }
        .benefit-card-text small {
            color: #c7ddd0 !important;
            font-size: 11.5px !important;
            line-height: 1.4 !important;
        }

        /* Social Proof */
        .auth-showcase-proof {
            position: relative !important;
            z-index: 2 !important;
            display: flex !important;
            align-items: center !important;
            gap: 14px !important;
            padding-top: 18px !important;
            border-top: 1px solid rgba(255, 255, 255, 0.14) !important;
            margin-top: 14px !important;
        }
        .proof-avatars {
            display: flex !important;
            align-items: center !important;
        }
        .proof-avatar {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 29px !important;
            height: 29px !important;
            margin-left: -8px !important;
            border-radius: 50% !important;
            border: 2px solid #10291f !important;
            color: #ffffff !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25) !important;
        }
        .proof-avatar:first-child {
            margin-left: 0 !important;
        }
        .proof-avatar.plus-avatar {
            background: linear-gradient(135deg, #d8a962, #996e2a) !important;
            color: #10291f !important;
            font-weight: 800 !important;
        }
        .proof-text {
            display: flex !important;
            flex-direction: column !important;
            gap: 1px !important;
        }
        .proof-rating {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
        }
        .proof-rating .stars {
            color: #f59e0b !important;
            font-size: 13px !important;
            letter-spacing: 1px !important;
        }
        .proof-rating .rating-val {
            color: #ffffff !important;
            font-weight: 800 !important;
            font-size: 12px !important;
            font-family: 'DM Sans', sans-serif !important;
        }
        .proof-text small {
            color: #b7cebe !important;
            font-size: 11px !important;
            line-height: 1.3 !important;
        }

        /* --- Right Form Card --- */
        .auth-card {
            padding: 44px 44px !important;
            background: #ffffff !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
        }

        .auth-card-nav {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            margin-bottom: 14px !important;
        }
        .auth-back-link {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            padding: 5px 12px !important;
            border-radius: 999px !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
        }
        .auth-back-link:hover {
            background: #f1f5f9 !important;
            color: #173e2c !important;
            border-color: #cbd5e1 !important;
            transform: translateX(-2px) !important;
        }

        .auth-free-badge {
            padding: 4px 11px !important;
            border-radius: 999px !important;
            background: rgba(36, 89, 67, 0.08) !important;
            border: 1px solid rgba(36, 89, 67, 0.25) !important;
            color: #173e2c !important;
            font-size: 11px !important;
            font-weight: 700 !important;
        }

        .auth-card-header {
            margin-bottom: 20px !important;
        }
        .auth-card-header h1 {
            margin: 0 0 6px !important;
            font-size: 26px !important;
            font-weight: 800 !important;
            color: #0f271d !important;
            letter-spacing: -0.3px !important;
        }
        .auth-card-subtitle {
            margin: 0 !important;
            font-size: 13.5px !important;
            color: #64748b !important;
            line-height: 1.55 !important;
        }

        /* Google Action */
        .auth-social-actions {
            display: block !important;
            margin-bottom: 18px !important;
        }
        .google-auth-button {
            width: 100% !important;
            min-height: 48px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            padding: 0 16px !important;
            border-radius: 13px !important;
            background: #ffffff !important;
            border: 1.5px solid #e2e8f0 !important;
            color: #1e293b !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03) !important;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .google-auth-button:hover {
            background: #ffffff !important;
            border-color: #4285f4 !important;
            color: #1a56db !important;
            box-shadow: 0 6px 18px rgba(66, 133, 244, 0.15) !important;
            transform: translateY(-1px) !important;
        }

        /* Divider */
        .auth-divider {
            position: relative !important;
            text-align: center !important;
            margin: 18px 0 20px !important;
        }
        .auth-divider::before {
            content: "" !important;
            position: absolute !important;
            top: 50% !important;
            left: 0 !important;
            right: 0 !important;
            height: 1px !important;
            background: #e2e8f0 !important;
        }
        .auth-divider span {
            position: relative !important;
            background: #ffffff !important;
            padding: 0 14px !important;
            font-size: 12.5px !important;
            font-weight: 500 !important;
            color: #94a3b8 !important;
        }

        /* Form Inputs */
        .form-field-group {
            margin-bottom: 14px !important;
        }
        .form-field-group label {
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            margin-bottom: 6px !important;
        }
        .required-star {
            color: #ef4444 !important;
            font-weight: 800 !important;
        }

        .auth-input-wrapper {
            position: relative !important;
            border: 1.5px solid #e2e8f0 !important;
            border-radius: 13px !important;
            background: #f8fafc !important;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
            overflow: hidden !important;
        }
        .auth-input-wrapper:hover {
            border-color: #cbd5e1 !important;
            background: #ffffff !important;
        }
        .auth-input-wrapper:focus-within {
            border-color: #173e2c !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 3.5px rgba(23, 62, 44, 0.12) !important;
        }

        .auth-input-wrapper .input-icon {
            position: absolute !important;
            left: 14px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #64748b !important;
            pointer-events: none !important;
            z-index: 2 !important;
        }

        .auth-input-wrapper input {
            width: 100% !important;
            height: 46px !important;
            padding: 10px 14px 10px 44px !important;
            border: none !important;
            background: transparent !important;
            font-size: 14px !important;
            color: #0f172a !important;
            outline: none !important;
            font-family: inherit !important;
        }
        .auth-input-wrapper input::placeholder {
            color: #94a3b8 !important;
            font-size: 13px !important;
        }

        /* Fix Autofill Blue Box */
        .auth-input-wrapper input:-webkit-autofill,
        .auth-input-wrapper input:-webkit-autofill:hover, 
        .auth-input-wrapper input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #0f172a !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Password Show/Hide Toggle */
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
            color: #173e2c !important;
            background: rgba(23, 62, 44, 0.08) !important;
        }

        /* Password Strength Meter */
        .pwd-strength-meter {
            margin-top: 8px !important;
        }
        .meter-bars {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 6px !important;
            margin-bottom: 5px !important;
        }
        .meter-bars .bar {
            height: 4px !important;
            border-radius: 999px !important;
            background: #e2e8f0 !important;
            transition: background 0.25s ease !important;
        }
        .meter-status {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            font-size: 11.5px !important;
            color: #64748b !important;
        }
        .meter-value {
            font-weight: 700 !important;
        }

        .level-weak .bar-1 { background: #ef4444 !important; }
        .level-weak .meter-value { color: #ef4444 !important; }

        .level-fair .bar-1, .level-fair .bar-2 { background: #f59e0b !important; }
        .level-fair .meter-value { color: #f59e0b !important; }

        .level-good .bar-1, .level-good .bar-2, .level-good .bar-3 { background: #3b82f6 !important; }
        .level-good .meter-value { color: #3b82f6 !important; }

        .level-strong .bar { background: #16a34a !important; }
        .level-strong .meter-value { color: #16a34a !important; }

        /* Password Match Badge */
        .pwd-match-badge {
            margin-top: 6px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            font-size: 11.5px !important;
            font-weight: 700 !important;
            padding: 3px 8px !important;
            border-radius: 6px !important;
        }
        .pwd-match-badge.match-success {
            background: #dcfce7 !important;
            color: #15803d !important;
        }
        .pwd-match-badge.match-danger {
            background: #fee2e2 !important;
            color: #dc2626 !important;
        }

        /* Terms & Checkbox */
        .auth-terms-group {
            margin: 14px 0 16px !important;
        }
        .auth-checkbox-label {
            display: inline-flex !important;
            align-items: flex-start !important;
            gap: 8px !important;
            font-size: 13px !important;
            color: #475569 !important;
            cursor: pointer !important;
            user-select: none !important;
        }
        .auth-checkbox-label input {
            position: absolute !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
        .custom-checkbox {
            width: 18px !important;
            height: 18px !important;
            border-radius: 6px !important;
            border: 1.5px solid #cbd5e1 !important;
            background: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            transition: all 0.18s ease !important;
            flex-shrink: 0 !important;
            margin-top: 2px !important;
        }
        .auth-checkbox-label input:checked + .custom-checkbox {
            background: #173e2c !important;
            border-color: #173e2c !important;
        }
        .terms-text {
            font-size: 12.5px !important;
            color: #475569 !important;
            line-height: 1.45 !important;
        }
        .terms-text a {
            color: #173e2c !important;
            font-weight: 700 !important;
            text-decoration: underline !important;
        }

        /* Submit Button */
        .auth-submit-btn, #submitBtn {
            width: 100% !important;
            min-height: 48px !important;
            border-radius: 13px !important;
            background: linear-gradient(135deg, #0d281c 0%, #173e2c 50%, #225741 100%) !important;
            color: #ffffff !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            border: none !important;
            box-shadow: 0 6px 20px rgba(23, 62, 44, 0.32) !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
            margin-top: 16px !important;
        }
        .auth-submit-btn:hover, #submitBtn:hover {
            box-shadow: 0 10px 28px rgba(23, 62, 44, 0.45) !important;
            transform: translateY(-2px) !important;
            filter: brightness(1.05) !important;
        }
        .auth-submit-btn:active, #submitBtn:active {
            transform: translateY(0) !important;
        }

        .auth-submit-btn .btn-text {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 7px !important;
        }

        .auth-submit-btn .btn-spinner {
            display: none !important;
        }

        .auth-submit-btn.is-submitting .btn-text {
            display: none !important;
        }

        .auth-submit-btn.is-submitting .btn-spinner {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
        }
        .spinner-ring {
            width: 16px !important;
            height: 16px !important;
            border: 2px solid rgba(255, 255, 255, 0.3) !important;
            border-top-color: #ffffff !important;
            border-radius: 50% !important;
            animation: authSpin 0.7s linear infinite !important;
        }
        @keyframes authSpin {
            to { transform: rotate(360deg); }
        }

        /* Bottom Switch */
        .auth-switch {
            margin-top: 20px !important;
            text-align: center !important;
            font-size: 13.5px !important;
            color: #64748b !important;
        }
        .auth-switch-link {
            color: #173e2c !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            margin-left: 5px !important;
            transition: all 0.15s ease !important;
        }
        .auth-switch-link:hover {
            color: #245943 !important;
            text-decoration: underline !important;
        }

        /* Trust Note */
        .auth-trust-note {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 7px !important;
            margin-top: 18px !important;
            padding-top: 16px !important;
            border-top: 1px dashed #e2e8f0 !important;
            font-size: 11.5px !important;
            color: #64748b !important;
        }
        .auth-trust-note svg {
            color: #16a34a !important;
            flex-shrink: 0 !important;
        }

        /* Error States */
        .auth-error-msg {
            display: flex !important;
            align-items: center !important;
            gap: 5px !important;
            color: #dc2626 !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            margin-top: 6px !important;
        }
        .form-field-group.has-error .auth-input-wrapper {
            border-color: #ef4444 !important;
            background: #fffafa !important;
        }

        /* Responsive Breakpoints */
        @media (max-width: 860px) {
            .auth-page {
                grid-template-columns: 1fr !important;
                margin: 20px auto 40px !important;
                border-radius: 20px !important;
            }
            .auth-showcase {
                min-height: auto !important;
                padding: 30px 24px !important;
            }
            .auth-card {
                padding: 32px 24px !important;
            }
            .auth-showcase-headline {
                font-size: 22px !important;
            }
            .auth-benefits-list {
                gap: 10px !important;
            }
        }
    </style>
@endsection
