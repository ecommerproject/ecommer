<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StoreSettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSettingController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'general');
        $validTabs = ['general', 'shipping', 'payments', 'announcements', 'storefront', 'profile'];
        if (!in_array($tab, $validTabs, true)) {
            $tab = 'general';
        }

        $settings = StoreSettingService::all();
        $user = auth()->user();

        // Calculate overview stats for the settings page
        $activeGatewaysCount = 0;
        if (!empty($settings['enable_aba'])) $activeGatewaysCount++;
        if (!empty($settings['enable_wing'])) $activeGatewaysCount++;
        if (!empty($settings['enable_acleda'])) $activeGatewaysCount++;
        if (!empty($settings['enable_cod'])) $activeGatewaysCount++;

        $stats = [
            'store_name' => $settings['store_name_km'] . ' (' . $settings['store_name_en'] . ')',
            'exchange_rate' => number_format((float)$settings['exchange_rate']) . ' KHR / $1',
            'free_shipping' => '$' . number_format((float)$settings['free_shipping_threshold'], 2),
            'active_gateways' => $activeGatewaysCount . ' / 4 Gateways Active',
        ];

        return view('admin.settings.index', [
            'tab' => $tab,
            'settings' => $settings,
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    public function updateGeneral(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_name_en' => ['required', 'string', 'max:100'],
            'store_name_km' => ['required', 'string', 'max:100'],
            'store_slogan' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:100'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'store_address' => ['required', 'string', 'max:255'],
            'business_hours' => ['nullable', 'string', 'max:100'],
            'exchange_rate' => ['required', 'numeric', 'min:3000', 'max:5000'],
            'default_language' => ['required', 'in:km,en'],
        ]);

        StoreSettingService::update($validated);

        return redirect()->route('admin.settings.index', ['tab' => 'general'])
            ->with('status', 'ព័ត៌មានទូទៅរបស់ហាងត្រូវបានរក្សាទុកដោយជោគជ័យ! (General store information updated and persisted)');
    }

    public function updateShipping(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'delivery_pp' => ['required', 'numeric', 'min:0'],
            'delivery_province' => ['required', 'numeric', 'min:0'],
            'free_shipping_threshold' => ['required', 'numeric', 'min:0'],
            'delivery_window_pp' => ['required', 'string', 'max:100'],
            'delivery_window_province' => ['required', 'string', 'max:100'],
        ]);

        StoreSettingService::update($validated);

        return redirect()->route('admin.settings.index', ['tab' => 'shipping'])
            ->with('status', 'ថ្លៃដឹកជញ្ជូន និងពេលវេលាដឹកត្រូវបានរក្សាទុកដោយជោគជ័យ! (Shipping and logistics rates saved)');
    }

    public function updatePayments(Request $request): RedirectResponse
    {
        $payload = [
            'enable_aba' => $request->boolean('enable_aba'),
            'aba_merchant_id' => $request->input('aba_merchant_id', 'DARA_MARKET_KHQR'),
            'bakong_account_id' => $request->input('bakong_account_id', 'dara_market@abaa'),
            'aba_account_number' => $request->input('aba_account_number', '001 888 999'),
            'aba_account_name' => $request->input('aba_account_name', 'DARA MARKET CO., LTD'),
            'enable_wing' => $request->boolean('enable_wing'),
            'wing_account_number' => $request->input('wing_account_number', '071 450 4547'),
            'enable_acleda' => $request->boolean('enable_acleda'),
            'acleda_account_name' => $request->input('acleda_account_name', 'DARA MARKET CO., LTD'),
            'enable_cod' => $request->boolean('enable_cod'),
            'cod_max_amount' => (float)$request->input('cod_max_amount', 500),
        ];

        if ($request->hasFile('custom_khqr_image')) {
            $path = $request->file('custom_khqr_image')->store('khqr', 'public');
            $payload['custom_khqr_image'] = '/storage/' . $path;
        } elseif ($request->filled('custom_khqr_image_url')) {
            $payload['custom_khqr_image'] = $request->input('custom_khqr_image_url');
        }

        StoreSettingService::update($payload);

        return redirect()->route('admin.settings.index', ['tab' => 'payments'])
            ->with('status', 'ប្រព័ន្ធទូទាត់ KHQR និងធនាគារត្រូវបានធ្វើបច្ចុប្បន្នភាព! (Payment gateways updated successfully)');
    }

    public function updateAnnouncements(Request $request): RedirectResponse
    {
        $payload = [
            'announcement_active' => $request->boolean('announcement_active'),
            'announcement_promo' => strtoupper(trim((string)$request->input('announcement_promo', 'DARA2026'))),
            'announcement_text_km' => $request->input('announcement_text_km', 'ដឹកជញ្ជូនឥតគិតថ្លៃ រាល់ការកម្ម៉ង់ចាប់ពី $35 ឡើងទៅ!'),
            'announcement_text_en' => $request->input('announcement_text_en', 'Free Shipping on all orders over $35!'),
        ];

        StoreSettingService::update($payload);

        return redirect()->route('admin.settings.index', ['tab' => 'announcements'])
            ->with('status', 'របារដំណឹង និងប័ណ្ណបញ្ចុះតម្លៃត្រូវបានធ្វើបច្ចុប្បន្នភាព! (Store announcements updated)');
    }

    public function updateStorefront(Request $request): RedirectResponse
    {
        $payload = [
            // Deal of the Day
            'deal_active' => $request->boolean('deal_active'),
            'deal_kicker_km' => $request->input('deal_kicker_km', 'ប្រូម៉ូសិនពិសេសថ្ងៃនេះ'),
            'deal_title_km' => $request->input('deal_title_km', 'កាសស្ដាប់ត្រចៀកឥតខ្សែ'),
            'deal_price' => (float)$request->input('deal_price', 32.00),
            'deal_old_price' => (float)$request->input('deal_old_price', 42.00),
            'deal_discount' => $request->input('deal_discount', '-24%'),
            'deal_sold_percent' => (int)$request->input('deal_sold_percent', 78),
            'deal_stock_left' => (int)$request->input('deal_stock_left', 5),
            'deal_countdown_hours' => (int)$request->input('deal_countdown_hours', 6),

            // Voucher Coupon
            'voucher_active' => $request->boolean('voucher_active'),
            'voucher_badge_km' => $request->input('voucher_badge_km', 'ប័ណ្ណបញ្ចុះតម្លៃពិសេស'),
            'voucher_amount_text' => $request->input('voucher_amount_text', '$20.00 OFF'),
            'voucher_desc_km' => $request->input('voucher_desc_km', 'បញ្ចុះតម្លៃ $20 លើការទិញចាប់ពី $80 ឡើងទៅ'),
            'voucher_code' => strtoupper(trim((string)$request->input('voucher_code', 'DARA20'))),
            'voucher_min_spend' => (float)$request->input('voucher_min_spend', 80.00),

            // Spotlight Banner
            'spotlight_active' => $request->boolean('spotlight_active'),
            'spotlight_tag_km' => $request->input('spotlight_tag_km', 'ជម្រើសពេញនិយម'),
            'spotlight_caption_km' => $request->input('spotlight_caption_km', 'ហាងអនឡាញដែលអ្នកទុកចិត្ត'),
            'spotlight_title_km' => $request->input('spotlight_title_km', 'ទិញបានយ៉ាងងាយស្រួល'),
            'spotlight_link' => $request->input('spotlight_link', '#featured'),

            // Side Feature Banner
            'side_feature_active' => $request->boolean('side_feature_active'),
            'side_feature_pill_km' => $request->input('side_feature_pill_km', 'NEW IN'),
            'side_feature_kicker_km' => $request->input('side_feature_kicker_km', 'ស្ទីលថ្មី'),
            'side_feature_title_km' => $request->input('side_feature_title_km', 'បន្ថែមភាពស្រស់ស្អាតក្នុងថ្ងៃរបស់អ្នក'),
            'side_feature_link' => $request->input('side_feature_link', '#featured'),

            // Support & Socials
            'help_active' => $request->boolean('help_active'),
            'help_title_km' => $request->input('help_title_km', 'ត្រូវការជំនួយមែនទេ?'),
            'help_desc_km' => $request->input('help_desc_km', 'ក្រុមការងារយើងរីករាយជួយអ្នកជ្រើសរើសទំនិញ។'),
            'telegram_support' => $request->input('telegram_support', 'https://t.me/daramarket_support'),
            'facebook_link' => $request->input('facebook_link', 'https://facebook.com/daramarket'),
            'tiktok_link' => $request->input('tiktok_link', 'https://tiktok.com/@daramarket'),
        ];

        // Handle Image uploads or URL inputs
        if ($request->hasFile('deal_image_file')) {
            $path = $request->file('deal_image_file')->store('storefront', 'public');
            $payload['deal_image'] = '/storage/' . $path;
        } elseif ($request->filled('deal_image')) {
            $payload['deal_image'] = $request->input('deal_image');
        }

        if ($request->hasFile('spotlight_image_file')) {
            $path = $request->file('spotlight_image_file')->store('storefront', 'public');
            $payload['spotlight_image'] = '/storage/' . $path;
        } elseif ($request->filled('spotlight_image')) {
            $payload['spotlight_image'] = $request->input('spotlight_image');
        }

        if ($request->hasFile('side_feature_image_file')) {
            $path = $request->file('side_feature_image_file')->store('storefront', 'public');
            $payload['side_feature_image'] = '/storage/' . $path;
        } elseif ($request->filled('side_feature_image')) {
            $payload['side_feature_image'] = $request->input('side_feature_image');
        }

        StoreSettingService::update($payload);

        return redirect()->route('admin.settings.index', ['tab' => 'storefront'])
            ->with('status', 'ផ្ទាំងទំព័រមុខ & Widgets ត្រូវបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ! (Storefront widgets updated successfully)');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.settings.index', ['tab' => 'profile'])
            ->with('status', 'គណនីគ្រប់គ្រងត្រូវបានកែប្រែដោយជោគជ័យ! (Admin credentials updated successfully)');
    }

    public function resetDefaults(): RedirectResponse
    {
        StoreSettingService::reset();

        return redirect()->route('admin.settings.index')
            ->with('status', 'ការកំណត់ទាំងអស់ត្រូវបានត្រឡប់ទៅជាស្តង់ដារដើម! (All settings have been restored to defaults)');
    }
}
