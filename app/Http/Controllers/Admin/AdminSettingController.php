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
        $validTabs = ['general', 'shipping', 'payments', 'announcements', 'profile'];
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
            'enable_wing' => $request->boolean('enable_wing'),
            'wing_account_number' => $request->input('wing_account_number', '012 345 678'),
            'enable_acleda' => $request->boolean('enable_acleda'),
            'acleda_account_name' => $request->input('acleda_account_name', 'DARA MARKET CO., LTD'),
            'enable_cod' => $request->boolean('enable_cod'),
            'cod_max_amount' => (float)$request->input('cod_max_amount', 500),
        ];

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
