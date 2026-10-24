@extends('store.layouts.app')

@section('title', $translations['about_page']['title'])

@section('content')
<div class="about-page">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="catalog-breadcrumb" aria-label="{{ $translations['catalog']['breadcrumb_label'] }}">
            <a href="{{ route('store.home') }}">{{ $translations['nav']['home'] }}</a>
            <span class="catalog-breadcrumb-sep">/</span>
            <span aria-current="page">{{ $translations['nav']['about'] }}</span>
        </nav>

        {{-- Luxury Emerald Hero Banner --}}
        <header class="catalog-luxury-header about-luxury-header">
            <div class="catalog-header-glow"></div>
            <div class="catalog-header-content">
                <span class="catalog-kicker-badge">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                    <span>{{ $translations['about_page']['eyebrow'] }}</span>
                </span>
                <h1 class="catalog-title">{{ $translations['about_page']['heading'] }}</h1>
                <p class="catalog-description">{{ $translations['about_page']['description'] }}</p>
            </div>

            <div class="catalog-header-stats">
                <div class="catalog-stat-card">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ធានាសុទ្ធពិត' : 'Certified Authentic' }}</span>
                </div>
                <div class="catalog-stat-card">
                    <span class="stat-number text-amber">24-48h</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ដឹកជញ្ជូនរហ័ស' : 'Fast Delivery' }}</span>
                </div>
                <div class="catalog-stat-card highlight">
                    <span class="stat-badge-icon">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </span>
                    <span class="stat-label">4.9 ★ Rating</span>
                </div>
            </div>
        </header>

        {{-- Brand Story Split Section --}}
        <section class="about-story-grid">
            <div class="about-story-card">
                <div class="about-section-badge">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                    <span>{{ $locale === 'km' ? 'បេសកកម្មរបស់យើង' : 'Our Brand Mission' }}</span>
                </div>
                <h2 class="about-card-title">{{ $translations['about_page']['story_heading'] }}</h2>
                <p class="about-card-desc">{{ $translations['about_page']['story'] }}</p>

                <div class="about-story-points">
                    <div class="story-point-item">
                        <div class="point-icon">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="point-text">
                            <strong>{{ $locale === 'km' ? 'ប្រភពផ្គត់ផ្គង់ច្បាស់លាស់' : 'Direct & Verified Sourcing' }}</strong>
                            <span>{{ $locale === 'km' ? 'ទំនិញគ្រប់មុខត្រូវបាននាំចូល និងសម្រាំងពីក្រុមហ៊ុនផលិតផ្ទាល់' : 'Every product is sourced directly from trusted manufacturers' }}</span>
                        </div>
                    </div>
                    <div class="story-point-item">
                        <div class="point-icon">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="point-text">
                            <strong>{{ $locale === 'km' ? 'ត្រួតពិនិត្យគុណភាព 100%' : '100% Quality Inspection' }}</strong>
                            <span>{{ $locale === 'km' ? 'ត្រួតពិនិត្យយ៉ាងហ្មត់ចត់មុនពេលវេចខ្ចប់ និងផ្ញើជូនអតិថិជន' : 'Thorough inspection before packaging and dispatch' }}</span>
                        </div>
                    </div>
                    <div class="story-point-item">
                        <div class="point-icon">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <div class="point-text">
                            <strong>{{ $locale === 'km' ? 'ធានាប្តូរក្នុងរយៈពេល ៧ ថ្ងៃ' : '7-Day Easy Return Policy' }}</strong>
                            <span>{{ $locale === 'km' ? 'បើមិនពេញចិត្ត ឬមានបញ្ហា អាចប្តូរទំនិញវិញបានដោយទំនុកចិត្ត' : 'Hassle-free replacement policy for ultimate peace of mind' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about-visual-card">
                <img
                    src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1000&q=85"
                    alt="Dara Market Store Lifestyle"
                    class="about-visual-img"
                    loading="lazy"
                >
                <div class="about-visual-overlay"></div>
                <div class="about-glass-card">
                    <div class="glass-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                    </div>
                    <div>
                        <strong>DARA MARKET LIVING</strong>
                        <p>{{ $locale === 'km' ? 'ជម្រើសទំនិញប្រចាំថ្ងៃ គុណភាពខ្ពស់ និងសោភ័ណភាពទាន់សម័យ' : 'Curated premium lifestyle essentials for modern living' }}</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Core Values Grid (4 Columns) --}}
        <section class="about-values-section" aria-label="Core Values">
            <div class="about-values-header">
                <span class="catalog-kicker-badge" style="color: #047857; background: #ecfdf5; border-color: #a7f3d0;">
                    {{ $locale === 'km' ? 'គុណតម្លៃស្នូលរបស់យើង' : 'OUR CORE VALUES' }}
                </span>
                <h2>{{ $locale === 'km' ? 'មូលហេតុដែលអតិថិជនជឿទុកចិត្តលើ Dara Market' : 'Why Customers Trust Dara Market' }}</h2>
            </div>

            <div class="about-values-grid">
                {{-- Card 1: Quality --}}
                <article class="about-val-card">
                    <div class="val-icon-wrap emerald">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <h3>{{ $translations['about_page']['quality_heading'] }}</h3>
                    <p>{{ $translations['about_page']['quality'] }}</p>
                </article>

                {{-- Card 2: Delivery --}}
                <article class="about-val-card">
                    <div class="val-icon-wrap blue">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <h3>{{ $translations['about_page']['delivery_heading'] }}</h3>
                    <p>{{ $translations['about_page']['delivery'] }}</p>
                </article>

                {{-- Card 3: Customer Care --}}
                <article class="about-val-card">
                    <div class="val-icon-wrap pink">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    </div>
                    <h3>{{ $translations['about_page']['service_heading'] }}</h3>
                    <p>{{ $translations['about_page']['service'] }}</p>
                </article>

                {{-- Card 4: Secure Payment --}}
                <article class="about-val-card">
                    <div class="val-icon-wrap amber">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    </div>
                    <h3>{{ $locale === 'km' ? 'ទូទាត់ប្រាក់មានសុវត្ថិភាព' : '100% Secure Payments' }}</h3>
                    <p>{{ $locale === 'km' ? 'គាំទ្រ KHQR, Bakong, Visa, MasterCard និងការទូទាត់ពេលទំនិញដល់ដៃ។' : 'Multiple secure payment options including KHQR, Cards, and Cash on Delivery.' }}</p>
                </article>
            </div>
        </section>

        {{-- Statistics Counter Strip --}}
        <section class="about-metrics-strip">
            <div class="about-metric-item">
                <strong>22+</strong>
                <span>{{ $locale === 'km' ? 'មុខទំនិញសម្រាំង' : 'Curated Products' }}</span>
            </div>
            <div class="about-metric-sep"></div>
            <div class="about-metric-item">
                <strong>5,000+</strong>
                <span>{{ $locale === 'km' ? 'អតិថិជនពេញចិត្ត' : 'Happy Customers' }}</span>
            </div>
            <div class="about-metric-sep"></div>
            <div class="about-metric-item">
                <strong>99.8%</strong>
                <span>{{ $locale === 'km' ? 'ការឆ្លើយតបវិជ្ជមាន' : 'Positive Feedback' }}</span>
            </div>
            <div class="about-metric-sep"></div>
            <div class="about-metric-item">
                <strong>7 ថ្ងៃ</strong>
                <span>{{ $locale === 'km' ? 'ធានាប្តូរទំនិញ' : 'Return Guarantee' }}</span>
            </div>
        </section>

        {{-- Interactive FAQ Accordion --}}
        <section class="about-faq-section">
            <div class="faq-section-header">
                <span class="catalog-kicker-badge" style="color: #047857; background: #ecfdf5; border-color: #a7f3d0;">FAQ</span>
                <h2>{{ $locale === 'km' ? 'សំណួរដែលត្រូវបានសួរញឹកញាប់' : 'Frequently Asked Questions' }}</h2>
            </div>

            <div class="about-faq-accordion">
                <details class="about-faq-item" open>
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើទំនិញនៅ Dara Market ធានាសុទ្ធ 100% ដែរឬទេ?' : 'Are all products 100% authentic?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'ពិតប្រាកដណាស់! រាល់ទំនិញទាំងអស់ត្រូវបានជ្រើសរើស និងនាំចូលដោយផ្ទាល់ពីម៉ាកផលិតផល និងអ្នកចែកចាយស្របច្បាប់។ យើងធានា 100% លើគុណភាព និងភាពពិតប្រាកដនៃទំនិញ។' : 'Absolutely. Every product in our store is sourced directly from brand owners and certified distributors, backed by our 100% authenticity guarantee.' }}</p>
                    </div>
                </details>

                <details class="about-faq-item">
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើរយៈពេលដឹកជញ្ជូនចំណាយពេលប៉ុន្មានថ្ងៃ?' : 'How long does delivery take?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'សម្រាប់ការកុម្ម៉ង់ក្នុងរាជធានីភ្នំពេញ ទំនិញនឹងត្រូវដឹកជូនក្នុងរយៈពេល ២៤ ម៉ោង។ សម្រាប់បណ្តាខេត្តនានា ចំណាយពេល ២៤ ទៅ ៤៨ ម៉ោងតាមរយៈដៃគូដឹកជញ្ជូនរហ័សទាន់ចិត្ត។' : 'Deliveries in Phnom Penh are completed within 24 hours. For provinces, delivery takes 24 to 48 hours via trusted express logistics partners.' }}</p>
                    </div>
                </details>

                <details class="about-faq-item">
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើខ្ញុំអាចប្តូរទំនិញវិញបានទេ ប្រសិនបើទំហំមិនត្រូវ?' : 'Can I exchange items if the size does not fit?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'លោកអ្នកអាចស្នើសុំប្តូរទំហំ ឬប្តូរម៉ូតទំនិញបានក្នុងរយៈពេល ៧ ថ្ងៃ គិតចាប់ពីថ្ងៃទទួលទំនិញ ដោយគ្រាន់តែរក្សាទំនិញឱ្យនៅស្ថានភាពដើម។' : 'Yes, you can request an exchange within 7 days of receiving your item, as long as it remains in its original condition with tags.' }}</p>
                    </div>
                </details>
            </div>
        </section>

        {{-- Luxury Call-To-Action Banner --}}
        <section class="about-cta-banner">
            <div class="cta-banner-content">
                <h2>{{ $locale === 'km' ? 'ត្រៀមខ្លួនទិញទំនិញគុណភាពខ្ពស់ហើយឬនៅ?' : 'Ready to discover premium everyday essentials?' }}</h2>
                <p>{{ $locale === 'km' ? 'រុករកបណ្តុំទំនិញដែលបានជ្រើសរើសយ៉ាងយកចិត្តទុកដាក់សម្រាប់រាល់ថ្ងៃរបស់អ្នក។' : 'Explore our curated catalog and upgrade your everyday lifestyle with Dara Market.' }}</p>
            </div>
            <div class="cta-banner-buttons">
                <a href="{{ route('store.products') }}" class="cta-btn-primary">
                    <span>{{ $translations['about_page']['shop'] }}</span>
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.contact') }}" class="cta-btn-secondary">
                    <span>{{ $translations['about_page']['contact'] }}</span>
                </a>
            </div>
        </section>

        <a class="catalog-back-link" href="{{ route('store.home') }}">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>{{ $translations['catalog']['back_home'] }}</span>
        </a>
    </div>
</div>
@endsection
