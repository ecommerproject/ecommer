@extends('store.layouts.app')

@section('title', $translations['contact_page']['title'])

@section('content')
<div class="about-page contact-page">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="catalog-breadcrumb" aria-label="{{ $translations['catalog']['breadcrumb_label'] }}">
            <a href="{{ route('store.home') }}">{{ $translations['nav']['home'] }}</a>
            <span class="catalog-breadcrumb-sep">/</span>
            <span aria-current="page">{{ $translations['nav']['contact'] }}</span>
        </nav>

        {{-- Luxury Emerald Hero Banner --}}
        <header class="catalog-luxury-header contact-luxury-header">
            <div class="catalog-header-glow"></div>
            <div class="catalog-header-content">
                <span class="catalog-kicker-badge">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"/></svg>
                    <span>{{ $translations['contact_page']['eyebrow'] }}</span>
                </span>
                <h1 class="catalog-title">{{ $translations['contact_page']['heading'] }}</h1>
                <p class="catalog-description">{{ $translations['contact_page']['description'] }}</p>
            </div>

            <div class="catalog-header-stats">
                <div class="catalog-stat-card">
                    <span class="stat-number">&lt; 15m</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ឆ្លើយតបរហ័សទាន់ចិត្ត' : 'Rapid Response' }}</span>
                </div>
                <div class="catalog-stat-card">
                    <span class="stat-number text-amber">7 ថ្ងៃ</span>
                    <span class="stat-label">{{ $locale === 'km' ? 'បម្រើការរាល់ថ្ងៃ' : '7 Days Support' }}</span>
                </div>
                <div class="catalog-stat-card highlight">
                    <span class="stat-badge-icon">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    </span>
                    <span class="stat-label">{{ $locale === 'km' ? 'ជំនួយ 24/7' : '24/7 Live Care' }}</span>
                </div>
            </div>
        </header>

        {{-- 4 Quick Action Contact Cards --}}
        <section class="contact-channels-grid" aria-label="{{ $translations['nav']['contact'] }}">
            {{-- Phone Card --}}
            <article class="contact-ch-card">
                <div class="ch-icon-wrap emerald">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                </div>
                <div class="ch-card-body">
                    <span class="ch-tag">{{ $locale === 'km' ? 'ទូរស័ព្ទបន្ទាន់' : 'Direct Line' }}</span>
                    <h2>{{ $translations['contact_page']['phone_heading'] }}</h2>
                    <p><a href="tel:+855714504547" class="ch-link-main">{{ $translations['contact_page']['phone'] }}</a></p>
                    <a class="contact-card-btn emerald" href="tel:+855714504547">
                        <span>{{ $translations['contact_page']['call_action'] }}</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            {{-- Email Card --}}
            <article class="contact-ch-card">
                <div class="ch-icon-wrap blue">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </div>
                <div class="ch-card-body">
                    <span class="ch-tag">{{ $locale === 'km' ? 'អ៊ីមែលផ្លូវការ' : 'Official Email' }}</span>
                    <h2>{{ $translations['contact_page']['email_heading'] }}</h2>
                    <p><a href="mailto:hello@daramarket.com" class="ch-link-main">{{ $translations['contact_page']['email'] }}</a></p>
                    <a class="contact-card-btn blue" href="mailto:hello@daramarket.com">
                        <span>{{ $translations['contact_page']['email_action'] }}</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </article>

            {{-- Location Card --}}
            <article class="contact-ch-card">
                <div class="ch-icon-wrap amber">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <div class="ch-card-body">
                    <span class="ch-tag">{{ $locale === 'km' ? 'Showroom ផ្ទាល់' : 'Store Showroom' }}</span>
                    <h2>{{ $translations['contact_page']['location_heading'] }}</h2>
                    <p class="ch-text-main">{{ $translations['contact_page']['location'] }}</p>
                    <a class="contact-card-btn amber" href="https://maps.google.com/?q=Phnom+Penh+Cambodia" target="_blank" rel="noopener">
                        <span>{{ $locale === 'km' ? 'មើលទីតាំងលើ Map' : 'View on Map' }}</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </a>
                </div>
            </article>

            {{-- Working Hours Card --}}
            <article class="contact-ch-card">
                <div class="ch-icon-wrap pink">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div class="ch-card-body">
                    <div class="ch-live-indicator">
                        <span class="pulse-dot"></span>
                        <span>{{ $locale === 'km' ? 'កំពុងបើកដំណើរការ' : 'Open Today' }}</span>
                    </div>
                    <h2>{{ $translations['contact_page']['hours_heading'] }}</h2>
                    <p class="ch-text-main">{{ $translations['contact_page']['hours'] }}</p>
                    <span class="ch-subtext">{{ $locale === 'km' ? 'ទទួលការកម្ម៉ង់ 24 ម៉ោងលើ Online' : '24/7 Online Orders Accepted' }}</span>
                </div>
            </article>
        </section>

        {{-- Main Interactive Split: Contact Form + Direct Channels & Map --}}
        <section class="contact-main-grid">
            {{-- Left: Working Contact Form --}}
            <div class="contact-form-card">
                <div class="contact-form-header">
                    <span class="catalog-kicker-badge" style="color: #047857; background: #ecfdf5; border-color: #a7f3d0;">
                        {{ $locale === 'km' ? 'ទម្រង់ផ្ញើសាររហ័ស' : 'QUICK INQUIRY' }}
                    </span>
                    <h2>{{ $locale === 'km' ? 'ផ្ញើសារមកកាន់យើងខ្ញុំ' : 'Send Us a Direct Message' }}</h2>
                    <p>{{ $locale === 'km' ? 'បំពេញព័ត៌មានខាងក្រោម ក្រុមការងារយើងនឹងទាក់ទងមកអ្នកវិញក្នុងរយៈពេលយ៉ាងឆាប់រហ័ស។' : 'Leave your inquiry below and our support team will reply within 15 minutes.' }}</p>
                </div>

                {{-- Success Flash Alert --}}
                <div id="contactSuccessAlert" class="contact-alert success {{ session('contact_success') ? 'is-visible' : '' }}" role="alert">
                    <div class="alert-icon">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div class="alert-content">
                        <strong>{{ $locale === 'km' ? 'ផ្ញើសារបានជោគជ័យ!' : 'Message Sent Successfully!' }}</strong>
                        <p id="contactSuccessText">{{ session('contact_success') ?? ($locale === 'km' ? 'សាររបស់អ្នកត្រូវបានផ្ញើដោយជោគជ័យ! ក្រុមការងារយើងនឹងទាក់ទងមកអ្នកវិញក្នុងពេលឆាប់បំផុត។' : 'Your message has been sent successfully! Our team will get back to you shortly.') }}</p>
                    </div>
                </div>

                {{-- Error Alert --}}
                <div id="contactErrorAlert" class="contact-alert error" role="alert" style="display: none;">
                    <div class="alert-icon">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    </div>
                    <div class="alert-content">
                        <strong>{{ $locale === 'km' ? 'សូមពិនិត្យព័ត៌មានឡើងវិញ' : 'Please check your inputs' }}</strong>
                        <p id="contactErrorText">{{ $locale === 'km' ? 'សូមបំពេញរាល់ព័ត៌មានដែលតម្រូវ។' : 'Please fill in all required fields properly.' }}</p>
                    </div>
                </div>

                <form id="contactForm" action="{{ route('store.contact.submit') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact_name" class="form-label">
                                {{ $locale === 'km' ? 'ឈ្មោះពេញ' : 'Your Full Name' }} <span class="req">*</span>
                            </label>
                            <div class="input-icon-wrap">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input
                                    type="text"
                                    id="contact_name"
                                    name="name"
                                    class="contact-input"
                                    placeholder="{{ $locale === 'km' ? 'ឧ. ជា សុខា' : 'e.g. John Doe' }}"
                                    required
                                    value="{{ old('name') }}"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_phone_or_email" class="form-label">
                                {{ $locale === 'km' ? 'លេខទូរស័ព្ទ ឬ អ៊ីមែល' : 'Phone or Email' }} <span class="req">*</span>
                            </label>
                            <div class="input-icon-wrap">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <input
                                    type="text"
                                    id="contact_phone_or_email"
                                    name="phone_or_email"
                                    class="contact-input"
                                    placeholder="{{ $locale === 'km' ? '071 450 4547 ឬ email@example.com' : '+855 71 450 4547 or email' }}"
                                    required
                                    value="{{ old('phone_or_email') }}"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact_subject" class="form-label">
                            {{ $locale === 'km' ? 'ប្រធានបទសាកសួរ' : 'Inquiry Subject' }}
                        </label>
                        <select id="contact_subject" name="subject" class="contact-select">
                            <option value="general">{{ $locale === 'km' ? 'សាកសួរព័ត៌មានទូទៅ (General Inquiry)' : 'General Inquiry' }}</option>
                            <option value="order">{{ $locale === 'km' ? 'តាមដានការបញ្ជាទិញ ឬដឹកជញ្ជូន (Order & Delivery)' : 'Order & Delivery Status' }}</option>
                            <option value="product">{{ $locale === 'km' ? 'សាកសួរអំពីទំហំ ឬគុណភាពផលិតផល (Product Details)' : 'Product Details & Sizing' }}</option>
                            <option value="return">{{ $locale === 'km' ? 'ស្នើសុំប្តូរទំនិញ (Return & Exchange)' : 'Return & Exchange Request' }}</option>
                            <option value="feedback">{{ $locale === 'km' ? 'មតិកែលម្អ ឬសំណូមពរ (Feedback & Suggestions)' : 'Feedback & Suggestions' }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contact_message" class="form-label">
                            {{ $locale === 'km' ? 'សារ ឬសំណួររបស់អ្នក' : 'Your Message' }} <span class="req">*</span>
                        </label>
                        <textarea
                            id="contact_message"
                            name="message"
                            rows="4"
                            class="contact-textarea"
                            placeholder="{{ $locale === 'km' ? 'សូមសរសេរសំណួរ ឬព័ត៌មានដែលអ្នកចង់ដឹងនៅទីនេះ...' : 'Please describe your inquiry or feedback here...' }}"
                            required
                        >{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" id="contactSubmitBtn" class="contact-submit-btn">
                        <span class="btn-text">{{ $locale === 'km' ? 'ផ្ញើសារឥឡូវនេះ' : 'Send Message Now' }}</span>
                        <svg class="btn-arrow" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        <span class="btn-spinner" style="display: none;">
                            <svg class="spin-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"></path></svg>
                        </span>
                    </button>
                </form>
            </div>

            {{-- Right: Direct Live Chat & Showroom Card --}}
            <div class="contact-side-card">
                {{-- Live Chat Channels Box --}}
                <div class="chat-channels-box">
                    <span class="ch-badge">{{ $locale === 'km' ? 'ឆាតផ្ទាល់ជាមួយក្រុមការងារ' : 'DIRECT LIVE CHAT' }}</span>
                    <h3>{{ $locale === 'km' ? 'ត្រូវការចម្លើយភ្លាមៗ?' : 'Need Instant Assistance?' }}</h3>
                    <p>{{ $locale === 'km' ? 'ឆាតមកកាន់ក្រុមការងារយើងតាមរយៈ Telegram ឬ Messenger សម្រាប់ការពិគ្រោះយោបល់រហ័ស។' : 'Connect with our live agents on Telegram or Messenger for immediate answers.' }}</p>

                    <div class="chat-buttons-list">
                        <a href="https://t.me/daramarket" target="_blank" rel="noopener" class="chat-btn telegram">
                            <div class="chat-btn-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 0 0-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.52 2.77-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                            </div>
                            <div class="chat-btn-info">
                                <strong>Telegram Support</strong>
                                <span>@daramarket_support (ឆ្លើយតប &lt; 5 នាទី)</span>
                            </div>
                            <svg class="chat-arrow" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                        <a href="https://m.me/daramarket" target="_blank" rel="noopener" class="chat-btn messenger">
                            <div class="chat-btn-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2C6.48 2 2 6.03 2 11c0 2.87 1.45 5.43 3.72 7.04V22l3.81-2.09c.79.22 1.62.34 2.47.34 5.52 0 10-4.03 10-9s-4.48-9-10-9zm1.09 12.13l-2.55-2.72-4.97 2.72 5.46-5.8 2.61 2.72 4.91-2.72-5.46 5.8z"/></svg>
                            </div>
                            <div class="chat-btn-info">
                                <strong>Facebook Messenger</strong>
                                <span>m.me/daramarket</span>
                            </div>
                            <svg class="chat-arrow" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Showroom Showcase Card --}}
                <div class="showroom-card">
                    <div class="showroom-header">
                        <div class="showroom-badge">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polygon points="12 8 8 12 12 16 12 8"></polygon></svg>
                            <span>{{ $locale === 'km' ? 'ទីតាំង Showroom ផ្ទាល់' : 'PHYSICAL SHOWROOM' }}</span>
                        </div>
                        <h4>Dara Market Flagship Store</h4>
                        <p class="showroom-address">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span>{{ $locale === 'km' ? 'មហាវិថីព្រះមុនីវង្ស, សង្កាត់បឹងកេងកង១, ខណ្ឌចំការមន, ភ្នំពេញ' : 'Preah Monivong Blvd, BKK1, Chamkarmon, Phnom Penh' }}</span>
                        </p>
                    </div>

                    {{-- Map Visual Representation --}}
                    <div class="showroom-map-wrap">
                        <iframe
                            title="Dara Market Location Map"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.887661556822!2d104.9221!3d11.5564!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109513dc76a6be3%3A0x9c010a300d0061e8!2sPhnom%20Penh!5e0!3m2!1sen!2skh!4v1680000000000!5m2!1sen!2skh"
                            width="100%"
                            height="180"
                            style="border:0; border-radius: 12px; display: block;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>

                    <a href="https://maps.google.com/?q=Phnom+Penh+Cambodia" target="_blank" rel="noopener" class="showroom-map-link">
                        <span>{{ $locale === 'km' ? 'បើកមើលក្នុង Google Maps ពេញលេញ' : 'Open in Google Maps' }}</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- Contact FAQ Accordion --}}
        <section class="about-faq-section" style="margin-top: 48px;">
            <div class="faq-section-header">
                <span class="catalog-kicker-badge" style="color: #047857; background: #ecfdf5; border-color: #a7f3d0;">HELP CENTER</span>
                <h2>{{ $locale === 'km' ? 'សំណួរដែលសួរញឹកញាប់អំពីការទាក់ទង' : 'Common Customer Support Questions' }}</h2>
            </div>

            <div class="about-faq-accordion">
                <details class="about-faq-item" open>
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើខ្ញុំអាចទាក់ទងបន្ទាន់បំផុតតាមរយៈមធ្យោបាយណា?' : 'What is the fastest way to get immediate support?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'សម្រាប់បញ្ហាបន្ទាន់ លោកអ្នកអាចទូរស័ព្ទមកកាន់លេខ +855 71 450 4547 ឬឆាតផ្ទាល់ទៅកាន់ Telegram (@daramarket)។ ក្រុមការងារយើងនឹងឆ្លើយតបក្នុងរយៈពេលក្រោម ៥ នាទី។' : 'For urgent queries, call us directly at +855 71 450 4547 or message us on Telegram (@daramarket). Our agents typically reply in under 5 minutes.' }}</p>
                    </div>
                </details>

                <details class="about-faq-item">
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើហាងបើកដំណើរការនៅថ្ងៃអាទិត្យ និងថ្ងៃបុណ្យជាតិដែរឬទេ?' : 'Is customer care available on Sundays and holidays?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'បាទ/ចាស! សេវាបម្រើអតិថិជនតាមប្រព័ន្ធ Online និងការទទួលកុម្ម៉ង់បើកដំណើរការ ៧ ថ្ងៃក្នុងមួយសប្តាហ៍ (រួមទាំងថ្ងៃអាទិត្យ និងថ្ងៃឈប់សម្រាកបុណ្យជាតិ)។' : 'Yes! Our online support and order processing operate 7 days a week, including Sundays and public holidays.' }}</p>
                    </div>
                </details>

                <details class="about-faq-item">
                    <summary class="about-faq-question">
                        <span>{{ $locale === 'km' ? 'តើខ្ញុំត្រូវធ្វើដូចម្តេចប្រសិនបើទំនិញមានបញ្ហា ឬទំហំមិនត្រូវ?' : 'What should I do if my received product is damaged or incorrect?' }}</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </summary>
                    <div class="about-faq-answer">
                        <p>{{ $locale === 'km' ? 'លោកអ្នកគ្រាន់តែថតរូបភាពទំនិញ និងផ្ញើមកកាន់លេខ Telegram របស់យើង រួមជាមួយលេខបញ្ជាទិញ (Order Number)។ ក្រុមការងារនឹងរៀបចំប្តូរទំនិញថ្មីជូនភ្លាមៗដោយឥតគិតថ្លៃដឹកជញ្ជូនបន្ថែម។' : 'Simply snap photos of the product and send them to our Telegram along with your Order Number. We will arrange a free exchange immediately.' }}</p>
                    </div>
                </details>
            </div>
        </section>

        {{-- Back Home Link --}}
        <a class="catalog-back-link" href="{{ route('store.home') }}">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>← {{ $translations['contact_page']['back_home'] }}</span>
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const contactForm = document.getElementById('contactForm');
    if (!contactForm) return;

    const submitBtn = document.getElementById('contactSubmitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnArrow = submitBtn.querySelector('.btn-arrow');
    const btnSpinner = submitBtn.querySelector('.btn-spinner');
    const successAlert = document.getElementById('contactSuccessAlert');
    const successText = document.getElementById('contactSuccessText');
    const errorAlert = document.getElementById('contactErrorAlert');
    const errorText = document.getElementById('contactErrorText');

    contactForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // UI Loading state
        submitBtn.disabled = true;
        btnText.style.opacity = '0.7';
        btnArrow.style.display = 'none';
        btnSpinner.style.display = 'inline-flex';
        errorAlert.style.display = 'none';

        const formData = new FormData(contactForm);

        fetch(contactForm.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token')
            },
            body: formData
        })
        .then(async response => {
            const data = await response.json().catch(() => null);
            if (!response.ok) {
                let errMessage = '{{ $locale === "km" ? "សូមបំពេញព័ត៌មានឱ្យបានត្រឹមត្រូវ។" : "Please check your inputs." }}';
                if (data && data.errors) {
                    const firstKey = Object.keys(data.errors)[0];
                    errMessage = data.errors[firstKey][0];
                } else if (data && data.message) {
                    errMessage = data.message;
                }
                throw new Error(errMessage);
            }
            return data;
        })
        .then(data => {
            // Success
            contactForm.reset();
            successText.textContent = data.message || '{{ $locale === "km" ? "សាររបស់អ្នកត្រូវបានផ្ញើដោយជោគជ័យ! ក្រុមការងារយើងនឹងទាក់ទងមកអ្នកវិញក្នុងពេលឆាប់បំផុត។" : "Your message has been sent successfully!" }}';
            successAlert.classList.add('is-visible');
            successAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        })
        .catch(err => {
            errorText.textContent = err.message;
            errorAlert.style.display = 'flex';
            errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        })
        .finally(() => {
            submitBtn.disabled = false;
            btnText.style.opacity = '1';
            btnArrow.style.display = 'inline-block';
            btnSpinner.style.display = 'none';
        });
    });
});
</script>
@endsection
