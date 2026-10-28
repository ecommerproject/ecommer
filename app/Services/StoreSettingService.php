<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class StoreSettingService
{
    private const CACHE_KEY = 'dara_market_settings';
    private const STORAGE_FILE = 'settings.json';

    /**
     * Default store settings schema
     */
    public static function defaults(): array
    {
        return [
            // General Profile
            'store_name_en' => 'Dara Market',
            'store_name_km' => 'ផ្សារតារា',
            'store_slogan' => 'Fresh Living, Electronics & Fashion Store in Cambodia',
            'contact_email' => 'contact@daramarket.com',
            'contact_phone' => '+855 71 450 4547',
            'store_address' => 'Russian Federation Blvd, Sangkat Teuk Thla, Khan Sen Sok, Phnom Penh, Cambodia',
            'business_hours' => 'ច័ន្ទ - អាទិត្យ 7:00 AM - 9:00 PM',
            'currency' => 'USD ($)',
            'exchange_rate' => 4100,
            'default_language' => 'km',
            'timezone' => 'Asia/Phnom_Penh (GMT+7)',

            // Shipping & Logistics
            'delivery_pp' => 1.50,
            'delivery_province' => 2.50,
            'free_shipping_threshold' => 35.00,
            'delivery_window_pp' => 'Same-Day (2 - 4 hours)',
            'delivery_window_province' => '1 - 2 Business Days via Express Courier',

            // Payment Gateways & KHQR
            'enable_aba' => true,
            'aba_merchant_id' => 'DARA_MARKET_KHQR',
            'bakong_account_id' => 'dara_market@abaa',
            'aba_account_number' => '001 888 999',
            'aba_account_name' => 'DARA MARKET CO., LTD',
            'custom_khqr_image' => '',
            'enable_wing' => true,
            'wing_account_number' => '071 450 4547',
            'enable_acleda' => true,
            'acleda_account_name' => 'DARA MARKET CO., LTD',
            'enable_cod' => true,
            'cod_max_amount' => 500,

            // Announcements & Storefront Promo
            'announcement_active' => true,
            'announcement_promo' => 'DARA2026',
            'announcement_text_km' => 'ដឹកជញ្ជូនឥតគិតថ្លៃ រាល់ការកម្ម៉ង់ចាប់ពី $35 ឡើងទៅ!',
            'announcement_text_en' => 'Free Shipping on all orders over $35!',

            // Maintenance & Operational Flags
            'maintenance_mode' => false,
            'enable_reviews' => true,

            // Global App-Wide Active Promotion Campaign
            'active_campaign' => null,

            // Storefront Widgets & Features (Edit everything across app)
            'deal_active' => true,
            'deal_kicker_km' => 'ប្រូម៉ូសិនពិសេសថ្ងៃនេះ',
            'deal_kicker_en' => 'DEAL OF THE DAY',
            'deal_title_km' => 'កាសស្ដាប់ត្រចៀកឥតខ្សែ',
            'deal_title_en' => 'Wireless Pro Headphones',
            'deal_price' => 32.00,
            'deal_old_price' => 42.00,
            'deal_discount' => '-24%',
            'deal_image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=400&q=80',
            'deal_sold_percent' => 78,
            'deal_stock_left' => 5,
            'deal_countdown_hours' => 6,

            'voucher_active' => true,
            'voucher_badge_km' => 'ប័ណ្ណបញ្ចុះតម្លៃពិសេស',
            'voucher_badge_en' => 'SPECIAL VOUCHER',
            'voucher_amount_text' => '$20.00 OFF',
            'voucher_desc_km' => 'បញ្ចុះតម្លៃ $20 លើការទិញចាប់ពី $80 ឡើងទៅ',
            'voucher_desc_en' => 'Get $20 off on orders over $80 across all categories',
            'voucher_code' => 'DARA20',
            'voucher_min_spend' => 80.00,

            'spotlight_active' => true,
            'spotlight_tag_km' => 'ជម្រើសពេញនិយម',
            'spotlight_caption_km' => 'ហាងអនឡាញដែលអ្នកទុកចិត្ត',
            'spotlight_title_km' => 'ទិញបានយ៉ាងងាយស្រួល',
            'spotlight_image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=600&q=80',
            'spotlight_link' => '#featured',

            'side_feature_active' => true,
            'side_feature_pill_km' => 'NEW IN',
            'side_feature_kicker_km' => 'ស្ទីលថ្មី',
            'side_feature_title_km' => 'បន្ថែមភាពស្រស់ស្អាតក្នុងថ្ងៃរបស់អ្នក',
            'side_feature_image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=600&q=80',
            'side_feature_link' => '#featured',

            'help_active' => true,
            'help_title_km' => 'ត្រូវការជំនួយមែនទេ?',
            'help_desc_km' => 'ក្រុមការងារយើងរីករាយជួយអ្នកជ្រើសរើសទំនិញ។',
            'telegram_support' => 'https://t.me/daramarket_support',
            'facebook_link' => 'https://facebook.com/daramarket',
            'tiktok_link' => 'https://tiktok.com/@daramarket',
        ];
    }

    /**
     * Retrieve all settings with file-persistence fallback
     */
    public static function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $path = storage_path('app/' . self::STORAGE_FILE);
            if (File::exists($path)) {
                $decoded = json_decode(File::get($path), true);
                if (is_array($decoded)) {
                    return array_merge(self::defaults(), $decoded);
                }
            }
            return self::defaults();
        });
    }

    /**
     * Get a specific setting value
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = self::all();
        return $all[$key] ?? $default;
    }

    /**
     * Update settings and persist to both physical storage and cache
     */
    public static function update(array $values): array
    {
        $current = self::all();
        $merged = array_merge($current, $values);

        // Ensure storage directory exists
        $storageDir = storage_path('app');
        if (!File::isDirectory($storageDir)) {
            File::makeDirectory($storageDir, 0755, true);
        }

        // Write to physical JSON file for durability
        File::put(
            storage_path('app/' . self::STORAGE_FILE),
            json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // Refresh Cache
        Cache::forget(self::CACHE_KEY);
        Cache::forever(self::CACHE_KEY, $merged);

        return $merged;
    }

    /**
     * Reset settings to original defaults
     */
    public static function reset(): array
    {
        $defaults = self::defaults();
        File::put(
            storage_path('app/' . self::STORAGE_FILE),
            json_encode($defaults, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
        Cache::forget(self::CACHE_KEY);
        Cache::forever(self::CACHE_KEY, $defaults);

        return $defaults;
    }
}
