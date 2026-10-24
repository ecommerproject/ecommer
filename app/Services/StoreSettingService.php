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
            'contact_phone' => '+855 12 345 678',
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
            'enable_wing' => true,
            'wing_account_number' => '012 345 678',
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
