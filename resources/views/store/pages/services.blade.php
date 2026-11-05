@extends('store.layouts.app')

@section('title', $translations['services_page']['title'] ?? ($locale === 'km' ? 'ការធានា & សេវាកម្ម | Collection Trend' : 'Warranty & Services | Collection Trend'))

@section('content')
<div class="about-page services-page">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="catalog-breadcrumb" aria-label="{{ $translations['catalog']['breadcrumb_label'] }}">
            <a href="{{ route('store.home') }}">{{ $translations['nav']['home'] }}</a>
            <span class="catalog-breadcrumb-sep">/</span>
            <span aria-current="page">{{ $translations['nav']['guarantee'] ?? ($locale === 'km' ? 'ការធានា&សេវា' : 'Warranty & Services') }}</span>
        </nav>

        {{-- Luxury Emerald Hero Banner --}}
        <header class="catalog-luxury-header services-luxury-header">
            <div class="catalog-header-glow"></div>
            <div class="catalog-header-content">
                <span class="catalog-kicker-badge">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>{{ $translations['services_page']['eyebrow'] ?? ($locale === 'km' ? 'ទំនុកចិត្ត និងគុណភាពខ្ពស់' : 'TRUST & PREMIUM QUALITY') }}</span>
                </span>
                <h1 class="catalog-title">{{ $translations['services_page']['heading'] ?? ($locale === 'km' ? 'ការធានាគុណភាព & សេវាកម្មអតិថិជន' : 'Warranty & Customer Services') }}</h1>
                <p class="catalog-description">
                    {{ $translations['services_page']['description'] ?? ($locale === 'km' ? 'យើងផ្តល់នូវការធានាគុណភាព ១០០% សេវាដឹកជញ្ជូនរហ័ស គោលការណ៍ប្តូរទំនិញ ៧ ថ្ងៃ និងការបម្រើអតិថិជនដោយយកចិត្តទុកដាក់បំផុត។' : 'We offer 100% genuine quality guarantee, fast nationwide delivery, 7-day hassle-free returns, and dedicated VIP customer support.') }}
                </p>
            </div>

            <div class="catalog-header-stats">
                <div class="catalog-stat-card">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ធានាសុទ្ធពិត' : 'Certified Authentic' }}</span>
                </div>
                <div class="catalog-stat-card">
                    <span class="stat-number text-amber">7 ថ្ងៃ</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ប្តូរទំនិញងាយស្រួល' : 'Easy Returns' }}</span>
                </div>
                <div class="catalog-stat-card highlight">
                    <span class="stat-badge-icon">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ជំនួយ 24/7' : '24/7 VIP Care' }}</span>
                </div>
            </div>
        </header>

        {{-- 4 Pillars of Warranty & Service --}}
        <section class="about-values-section" id="pillars" aria-label="Core Pillars">
            <div class="about-values-header">
                <span class="catalog-kicker-badge" style="color: #047857; background: #ecfdf5; border-color: #a7f3d0;">
                    {{ $locale === 'km' ? 'សសរស្តម្ភនៃទំនុកចិត្ត' : 'PILLARS OF TRUST' }}
                </span>
                <h2>{{ $locale === 'km' ? 'ការប្តេជ្ញាចិត្តខ្ពស់បំផុតចំពោះអតិថិជន Collection Trend' : 'Our Highest Commitment to Every Customer' }}</h2>
            </div>

            <div class="about-values-grid">
                {{-- Card 1: 100% Genuine Quality --}}
                <article class="about-val-card service-pillar-card">
                    <div class="val-icon-wrap emerald">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <h3>{{ $locale === 'km' ? 'ធានាគុណភាព ១០០% សុទ្ធពិត' : '100% Genuine Quality' }}</h3>
                    <p>{{ $locale === 'km' ? 'រាល់ផលិតផលទាំងអស់ត្រូវបាននាំចូលដោយផ្ទាល់ពីក្រុមហ៊ុន ឬតំណាងចែកចាយស្របច្បាប់ មានប្រភព និងស្តង់ដារត្រួតពិនិត្យច្បាស់លាស់។' : 'All items are sourced directly from authorized manufacturers and verified distributors with strict QC checks.' }}</p>
                    <div class="pillar-subtag">
                        <span>✓ {{ $locale === 'km' ? 'មិនលក់ទំនិញក្លែងក្លាយ' : 'Authenticity Guarantee' }}</span>
                    </div>
                </article>

                {{-- Card 2: 7-Day Hassle-Free Returns --}}
                <article class="about-val-card service-pillar-card" id="returns">
                    <div class="val-icon-wrap blue">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M8 16H3v5"></path></svg>
                    </div>
                    <h3>{{ $locale === 'km' ? 'គោលការណ៍ប្តូរទំនិញ ៧ ថ្ងៃ' : '7-Day Return & Exchange' }}</h3>
                    <p>{{ $locale === 'km' ? 'ប្រសិនបើទំនិញមានបញ្ហាបច្ចេកទេស ខូចខាតពេលដឹក ឬមិនត្រូវតាមការកុម្ម៉ង់ លោកអ្នកអាចស្នើសុំប្តូរថ្មីបានក្នុងរយៈពេល ៧ ថ្ងៃ។' : 'If your product is defective, damaged during transit, or incorrect, request an exchange within 7 days easily.' }}</p>
                    <div class="pillar-subtag">
                        <span>✓ {{ $locale === 'km' ? 'ប្តូរជូនយ៉ាងរហ័ស' : 'Hassle-Free Process' }}</span>
                    </div>
                </article>

                {{-- Card 3: Fast Nationwide Shipping --}}
                <article class="about-val-card service-pillar-card" id="shipping">
                    <div class="val-icon-wrap amber">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <h3>{{ $locale === 'km' ? 'ដឹកជញ្ជូនរហ័ស & ឥតគិតថ្លៃ' : 'Express Delivery & Free Shipping' }}</h3>
                    <p>{{ $locale === 'km' ? 'ដឹកជញ្ជូនរហ័ស ២៤-៤៨ ម៉ោង ទូទាំង ២៥ រាជធានី-ខេត្ត។ ពិសេសឥតគិតថ្លៃដឹកជញ្ជូនសម្រាប់ការកុម្ម៉ង់ចាប់ពី $35.00 ឡើងទៅ!' : 'Fast 24-48h nationwide shipping. Free standard shipping applies to all orders of $35.00 and above!' }}</p>
                    <div class="pillar-subtag">
                        <span>✓ {{ $locale === 'km' ? 'Free លើ $35 ឡើងទៅ' : 'Free Over $35' }}</span>
                    </div>
                </article>

                {{-- Card 4: 100% Secure Payment --}}
                <article class="about-val-card service-pillar-card">
                    <div class="val-icon-wrap pink">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    </div>
                    <h3>{{ $locale === 'km' ? 'សុវត្ថិភាពទូទាត់ប្រាក់ ១០០%' : '100% Secure Payments' }}</h3>
                    <p>{{ $locale === 'km' ? 'គាំទ្រ Bakong KHQR គ្រប់ធនាគារ, Visa, Mastercard និងជម្រើសទូទាត់ប្រាក់ពេលទំនិញដល់ដៃ (Cash on Delivery)។' : 'Pay safely via Bakong KHQR from any local banking app, Visa, Mastercard, or Cash on Delivery at your door.' }}</p>
                    <div class="pillar-subtag">
                        <span>✓ {{ $locale === 'km' ? 'Bakong KHQR & COD' : 'KHQR & COD' }}</span>
                    </div>
                </article>
            </div>
        </section>

        {{-- 3-Step Return & Claim Process --}}
        <section class="services-process-section" id="order-guide" aria-label="Claim Process">
            <div class="process-section-header">
                <span class="catalog-kicker-badge" style="color: #047857; background: #ecfdf5; border-color: #a7f3d0;">
                    {{ $locale === 'km' ? 'ដំណើរការងាយស្រួល' : 'SIMPLE 3-STEP PROCESS' }}
                </span>
                <h2>{{ $locale === 'km' ? 'របៀបស្នើសុំការធានា ឬប្តូរទំនិញ' : 'How to Claim Warranty or Request an Exchange' }}</h2>
                <p>{{ $locale === 'km' ? 'ដំណើរការរហ័ស ងាយស្រួល និងមានទំនុកចិត្តខ្ពស់បំផុត ត្រឹមតែ ៣ ជំហានប៉ុណ្ណោះ' : 'Fast and stress-free replacement in 3 straightforward steps' }}</p>
            </div>

            <div class="process-steps-grid">
                <div class="process-step-card">
                    <div class="step-badge-number">1</div>
                    <div class="step-icon-box">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    </div>
                    <h4>{{ $locale === 'km' ? 'ជំហានទី ១: ទាក់ទងមកយើង' : 'Step 1: Contact Support' }}</h4>
                    <p>{{ $locale === 'km' ? 'ទូរស័ព្ទមកកាន់ Hotline ឬផ្ញើសារតាម Telegram ដោយបញ្ជាក់លេខសម្គាល់ការកុម្ម៉ង់ (Order #)។' : 'Reach out to our Hotline or Telegram support with your order number.' }}</p>
                </div>

                <div class="process-step-card">
                    <div class="step-badge-number">2</div>
                    <div class="step-icon-box">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                    <h4>{{ $locale === 'km' ? 'ជំហានទី ២: ផ្ញើរូបភាព ឬវីដេអូ' : 'Step 2: Share Photo / Video' }}</h4>
                    <p>{{ $locale === 'km' ? 'ថតរូបភាព ឬវីដេអូនូវស្ថានភាពទំនិញ ឬបញ្ហាដែលលោកអ្នកជួបប្រទះ ដើម្បីក្រុមការងារផ្ទៀងផ្ទាត់។' : 'Send photos or a short video showing the issue or defect on the product.' }}</p>
                </div>

                <div class="process-step-card">
                    <div class="step-badge-number">3</div>
                    <div class="step-icon-box">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <h4>{{ $locale === 'km' ? 'ជំហានទី ៣: ប្តូរជូនភ្លាមៗ' : 'Step 3: Instant Replacement' }}</h4>
                    <p>{{ $locale === 'km' ? 'ក្រោយការផ្ទៀងផ្ទាត់ ក្រុមការងារនឹងរៀបចំផ្ញើទំនិញថ្មីជូនលោកអ្នកភ្លាមៗដោយគ្មានការរង់ចាំយូរ។' : 'Once verified, our team will immediately dispatch a fresh replacement to your address.' }}</p>
                </div>
            </div>
        </section>

        {{-- Detailed Warranty Terms Strip --}}
        <section class="warranty-terms-strip">
            <div class="terms-card">
                <div class="terms-card-header">
                    <span class="terms-icon">📋</span>
                    <h3>{{ $locale === 'km' ? 'លក្ខខណ្ឌនៃការប្តូរទំនិញ (Return Eligibility)' : 'Return & Exchange Conditions' }}</h3>
                </div>
                <ul class="terms-list">
                    <li><span class="check-dot">✓</span> {{ $locale === 'km' ? 'ទំនិញត្រូវតែស្ថិតក្នុងស្ថានភាពដើម មិនទាន់ប្រើប្រាស់ និងមានប្រអប់/ស្លាកសញ្ញាពេញលេញ' : 'Item must be unused, in original packaging with intact brand tags' }}</li>
                    <li><span class="check-dot">✓</span> {{ $locale === 'km' ? 'ស្នើសុំក្នុងកំឡុងពេល ៧ ថ្ងៃគិតចាប់ពីកាលបរិច្ឆេទទទួលទំនិញ' : 'Request must be submitted within 7 calendar days of delivery' }}</li>
                    <li><span class="check-dot">✓</span> {{ $locale === 'km' ? 'មានវិក្កយបត្រ ឬលេខសម្គាល់ការកុម្ម៉ង់ (Order ID) សម្រាប់ផ្ទៀងផ្ទាត់' : 'Proof of purchase (invoice or Order ID) is required' }}</li>
                    <li><span class="check-dot">✓</span> {{ $locale === 'km' ? 'ចំពោះផលិតផលខូចខាតពេលដឹកជញ្ជូន Collection Trend ទទួលខុសត្រូវថ្លៃដឹកទាំងស្រុង' : 'Collection Trend covers 100% of return shipping costs for transit damages' }}</li>
                </ul>
            </div>
            <div class="terms-card">
                <div class="terms-card-header">
                    <span class="terms-icon">⚡</span>
                    <h3>{{ $locale === 'km' ? 'ការធានាលើផលិតផលអេឡិចត្រូនិក & នាឡិកា' : 'Electronics & Hardware Warranty' }}</h3>
                </div>
                <ul class="terms-list">
                    <li><span class="check-dot">✓</span> {{ $locale === 'km' ? 'ធានាជួសជុល ឬប្តូរថ្មីពី ៣ ទៅ ១២ ខែ (ទៅតាមប្រភេទផលិតផលនីមួយៗ)' : 'Hardware warranty between 3 to 12 months depending on item type' }}</li>
                    <li><span class="check-dot">✓</span> {{ $locale === 'km' ? 'ធានាលើបញ្ហាបច្ចេកទេស និងកំហុសរោងចក្រផលិត' : 'Covers internal technical malfunctions and factory defects' }}</li>
                    <li><span class="check-dot">✓</span> {{ $locale === 'km' ? 'មិនគ្របដណ្តប់លើការធ្លាក់បែក ជ្រាបទឹក ឬការកែច្នៃខុសលក្ខណៈបច្ចេកទេសឡើយ' : 'Does not cover physical damage, water ingress, or unauthorized alterations' }}</li>
                    <li><span class="check-dot">✓</span> {{ $locale === 'km' ? 'មានសេវាពិនិត្យ និងប្រឹក្សាបច្ចេកទេសឥតគិតថ្លៃពីអ្នកជំនាញ' : 'Complimentary technical inspection and support from specialists' }}</li>
                </ul>
            </div>
        </section>

        {{-- FAQ Accordion --}}
        <section class="about-faq-section" id="faq">
            <div class="faq-section-header">
                <span class="catalog-kicker-badge" style="color: #047857; background: #ecfdf5; border-color: #a7f3d0;">FAQ</span>
                <h2>{{ $locale === 'km' ? 'សំណួរដែលសួរញឹកញាប់អំពីការធានា & សេវាកម្ម' : 'Frequently Asked Questions on Warranty & Services' }}</h2>
            </div>

            <div class="about-faq-accordion">
                <details class="about-faq-item" open>
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើទំនិញនៅ Collection Trend ធានាសុទ្ធ ១០០% ដែរឬទេ?' : 'Are all products at Collection Trend 100% authentic?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'ពិតប្រាកដណាស់! រាល់ផលិតផលទាំងអស់ត្រូវបានជ្រើសរើស និងនាំចូលដោយផ្ទាល់ពីម៉ាកផលិតផល និងអ្នកចែកចាយស្របច្បាប់។ យើងធានា ១០០% លើគុណភាព និងភាពពិតប្រាកដនៃទំនិញ។ ប្រសិនបើពិនិត្យឃើញថាមិនសុទ្ធ យើងនឹងសងប្រាក់ជូនទ្វេដង។' : 'Absolutely. Every product in our store is sourced directly from verified manufacturers and authorized distributors, backed by our 100% authenticity guarantee.' }}</p>
                    </div>
                </details>

                <details class="about-faq-item">
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើរយៈពេលដឹកជញ្ជូនចំណាយពេលប៉ុន្មានថ្ងៃ?' : 'How long does delivery take?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'សម្រាប់ការកុម្ម៉ង់ក្នុងរាជធានីភ្នំពេញ ទំនិញនឹងត្រូវដឹកជូនក្នុងរយៈពេល ២៤ ម៉ោង។ សម្រាប់បណ្តាខេត្តនានា ចំណាយពេល ២៤ ទៅ ៤៨ ម៉ោងតាមរយៈដៃគូដឹកជញ្ជូនរហ័សទាន់ចិត្ត។ ពិសេសឥតគិតថ្លៃដឹកសម្រាប់ការកុម្ម៉ង់ចាប់ពី $35.00 ឡើងទៅ។' : 'Deliveries in Phnom Penh arrive within 24 hours. For all provinces, delivery takes 24 to 48 hours via express courier partners. Free shipping applies on orders of $35.00 or more.' }}</p>
                    </div>
                </details>

                <details class="about-faq-item">
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើខ្ញុំអាចពិនិត្យទំនិញមុនពេលទូទាត់ប្រាក់បានដែរឬទេ?' : 'Can I inspect the package before paying?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'លោកអ្នកអាចពិនិត្យមើលកញ្ចប់ទំនិញខាងក្រៅ និងផ្ទៀងផ្ទាត់ឈ្មោះទំនិញជាមួយអ្នកដឹកជញ្ជូនមុនពេលទូទាត់ប្រាក់។ ប្រសិនបើទំនិញខូចខាត ឬមិនត្រូវតាមការកុម្ម៉ង់ លោកអ្នកអាចបដិសេធមិនទទួលយកបានភ្លាមៗ។' : 'Yes, you may inspect the package and verify item details with the courier before paying with Cash on Delivery or KHQR.' }}</p>
                    </div>
                </details>

                <details class="about-faq-item">
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើខ្ញុំត្រូវធ្វើដូចម្តេចប្រសិនបើទំនិញមានបញ្ហាក្រោយពេលទិញ?' : 'What should I do if an issue arises after purchase?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'សូមទាក់ទងមកកាន់ Hotline: 071 450 4547 ឬផ្ញើសារមក Telegram របស់យើង ដោយភ្ជាប់ជាមួយលេខសម្គាល់ការកុម្ម៉ង់។ ក្រុមការងារយើងនឹងជួយសម្របសម្រួលដោះស្រាយ ឬប្តូរទំនិញថ្មីជូនលោកអ្នកយ៉ាងលឿនបំផុត។' : 'Simply call our hotline at +855 71 450 4547 or contact us via Telegram with your Order ID. Our customer support team will assist you with an exchange or resolution promptly.' }}</p>
                    </div>
                </details>
            </div>
        </section>

        {{-- Luxury Call-To-Action Banner --}}
        <section class="about-cta-banner">
            <div class="cta-banner-content">
                <h2>{{ $locale === 'km' ? 'ត្រូវការជំនួយ ឬចង់តាមដានការកុម្ម៉ង់?' : 'Need Help or Want to Track Your Order?' }}</h2>
                <p>{{ $locale === 'km' ? 'ក្រុមការងារបម្រើអតិថិជន Collection Trend ត្រៀមខ្លួនជួយលោកអ្នករៀងរាល់ថ្ងៃ ២៤/៧។' : 'Collection Trend VIP support is available daily to assist you with tracking, warranty, and inquiries.' }}</p>
            </div>
            <div class="cta-banner-buttons">
                <button type="button" class="cta-btn-primary" onclick="openTrackOrderModal()">
                    <span>📦 {{ $locale === 'km' ? 'តាមដានការកុម្ម៉ង់' : 'Track My Order' }}</span>
                </button>
                <a href="tel:+855714504547" class="cta-btn-secondary">
                    <span>📞 {{ $locale === 'km' ? 'ទូរស័ព្ទមក Hotline' : 'Call Hotline' }}</span>
                </a>
            </div>
        </section>

        <a class="catalog-back-link" href="{{ route('store.home') }}">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>{{ $translations['catalog']['back_home'] }}</span>
        </a>
    </div>
</div>

<style>
/* Dedicated Services & Warranty Styling */
.services-luxury-header {
    margin-bottom: 36px;
}
.service-pillar-card {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.pillar-subtag {
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px dashed rgba(0, 0, 0, 0.08);
}
.pillar-subtag span {
    display: inline-block;
    font-size: 11.5px;
    font-weight: 700;
    color: #15803d;
    background: #dcfce7;
    padding: 3px 10px;
    border-radius: 999px;
}
.services-process-section {
    margin: 48px 0;
    padding: 36px 28px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 20px;
}
.process-section-header {
    text-align: center;
    max-width: 600px;
    margin: 0 auto 32px;
}
.process-section-header h2 {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 8px 0;
}
.process-section-header p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}
.process-steps-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
}
.process-step-card {
    position: relative;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 26px 20px;
    text-align: center;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
}
.process-step-card:hover {
    transform: translateY(-3px);
    border-color: #245943;
    box-shadow: 0 10px 24px rgba(36, 89, 67, 0.08);
}
.step-badge-number {
    position: absolute;
    top: -12px;
    left: 20px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #173e2c;
    color: #ffffff;
    font-size: 13px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(23, 62, 44, 0.3);
}
.step-icon-box {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: rgba(36, 89, 67, 0.08);
    color: #173e2c;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
}
.process-step-card h4 {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 8px;
}
.process-step-card p {
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
    margin: 0;
}
.warranty-terms-strip {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 22px;
    margin: 36px 0;
}
.terms-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.terms-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1.5px solid #f1f5f9;
}
.terms-icon {
    font-size: 20px;
}
.terms-card-header h3 {
    font-size: 16px;
    font-weight: 800;
    color: #10291f;
    margin: 0;
}
.terms-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.terms-list li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 13px;
    color: #475569;
    line-height: 1.45;
}
.check-dot {
    color: #16a34a;
    font-weight: 800;
    font-size: 13px;
    flex-shrink: 0;
    margin-top: 1px;
}
</style>
@endsection

