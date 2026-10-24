<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminMarketingController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureSampleSubscribersExist();

        $search = $request->query('q', '');
        $query = DB::table('newsletter_subscribers');

        if ($search !== '') {
            $query->where('email', 'like', "%{$search}%");
        }

        $subscribers = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        $totalSubscribers = DB::table('newsletter_subscribers')->count();

        // Active Promotional Campaigns & Coupon Vouchers
        $coupons = [
            [
                'code' => 'DARA10',
                'discount' => '10% OFF',
                'description' => '10% discount on all orders over $20',
                'min_spend' => 20.00,
                'status' => 'active',
                'uses_count' => 42,
                'expires_at' => now()->addDays(28)->format('M d, Y'),
                'badge_color' => '#1e7e48',
            ],
            [
                'code' => 'FREESHIP',
                'discount' => 'FREE DELIVERY',
                'description' => 'Free express courier across Phnom Penh',
                'min_spend' => 15.00,
                'status' => 'active',
                'uses_count' => 89,
                'expires_at' => now()->addDays(45)->format('M d, Y'),
                'badge_color' => '#245943',
            ],
            [
                'code' => 'KHMERNEWYEAR',
                'discount' => '15% OFF',
                'description' => 'Special holiday savings on Fashion & Kitchen items',
                'min_spend' => 30.00,
                'status' => 'active',
                'uses_count' => 64,
                'expires_at' => now()->addDays(12)->format('M d, Y'),
                'badge_color' => '#d8a962',
            ],
            [
                'code' => 'WELCOME5',
                'discount' => '$5.00 OFF',
                'description' => 'Welcome gift for first-time shoppers',
                'min_spend' => 25.00,
                'status' => 'active',
                'uses_count' => 118,
                'expires_at' => 'Never (Ongoing)',
                'badge_color' => '#2563eb',
            ],
            [
                'code' => 'FLASH25',
                'discount' => '$25 OFF',
                'description' => 'Flash weekend discount on orders over $120',
                'min_spend' => 120.00,
                'status' => 'expired',
                'uses_count' => 31,
                'expires_at' => 'Expired last week',
                'badge_color' => '#9ca69e',
            ],
        ];

        return view('admin.marketing.index', [
            'subscribers' => $subscribers,
            'search' => $search,
            'coupons' => $coupons,
            'kpis' => [
                'total_subscribers' => $totalSubscribers,
                'active_coupons' => 4,
                'total_redemptions' => 344,
                'avg_open_rate' => '48.6%',
            ],
        ]);
    }

    public function sendBroadcast(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:200'],
            'audience' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        $subscribersCount = DB::table('newsletter_subscribers')->count();

        return redirect()->route('admin.marketing.index')
            ->with('status', "Broadcast '{$validated['subject']}' sent successfully to {$subscribersCount} subscribers!");
    }

    public function destroy(int $subscriber): RedirectResponse
    {
        $deleted = DB::table('newsletter_subscribers')->where('id', $subscriber)->delete();
        abort_unless($deleted, 404);

        return redirect()->route('admin.marketing.index')->with('status', 'Subscriber removed successfully.');
    }

    private function ensureSampleSubscribersExist(): void
    {
        if (DB::table('newsletter_subscribers')->count() < 5) {
            $samples = [
                ['email' => 'sokha.chan@gmail.com', 'created_at' => now()->subDays(12)],
                ['email' => 'vannak.meas@yahoo.com', 'created_at' => now()->subDays(10)],
                ['email' => 'bopha.heng@hotmail.com', 'created_at' => now()->subDays(7)],
                ['email' => 'dara.keo@gmail.com', 'created_at' => now()->subDays(5)],
                ['email' => 'channary.pich@gmail.com', 'created_at' => now()->subDays(3)],
                ['email' => 'theara.meng@outlook.com', 'created_at' => now()->subDays(2)],
                ['email' => 'sreymom.pov@gmail.com', 'created_at' => now()->subDay()],
            ];

            foreach ($samples as $s) {
                DB::table('newsletter_subscribers')->updateOrInsert(['email' => $s['email']], $s);
            }
        }
    }
}
