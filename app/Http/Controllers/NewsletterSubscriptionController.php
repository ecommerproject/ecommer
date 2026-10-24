<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $locale = $request->session()->get('store_locale', 'km');
        app()->setLocale($locale);

        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => __('store.footer.email_invalid'),
            'email.email' => __('store.footer.email_invalid'),
            'email.max' => __('store.footer.email_invalid'),
        ]);

        $email = $request->input('email');
        $exists = DB::table('newsletter_subscribers')->where('email', $email)->exists();

        if (! $exists) {
            DB::table('newsletter_subscribers')->insert([
                'email' => $email,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'voucher_code' => 'DARA-VIP15',
            'discount' => '$15.00',
            'already_subscribed' => $exists,
            'message' => $exists
                ? ($locale === 'en' ? 'Welcome back! Here is your VIP voucher code.' : 'សូមស្វាគមន៍មកវិញ! នេះជាលេខកូដបញ្ចុះតម្លៃ VIP របស់អ្នក។')
                : __('store.footer.newsletter_success'),
        ], 200);
    }
}
