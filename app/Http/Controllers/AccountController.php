<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AccountController extends Controller
{
    public function loginForm(Request $request): View
    {
        $this->setLocale($request);

        return view('store.pages.auth.login', [
            'locale' => app()->getLocale(),
            'translations' => __('store'),
            'googleEnabled' => $this->googleConfigured(),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('store.account.invalid_credentials'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('store.home'))->with('success', __('store.account.login_success'));
    }

    public function registerForm(Request $request): View
    {
        $this->setLocale($request);

        return view('store.pages.auth.register', [
            'locale' => app()->getLocale(),
            'translations' => __('store'),
            'googleEnabled' => $this->googleConfigured(),
        ]);
    }

    public function redirectToGoogle(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        if (! $this->googleConfigured()) {
            return back()->withErrors([
                'google' => __('store.account.google_not_configured'),
            ]);
        }

        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        if ($request->filled('error') || ! $request->filled('code')) {
            return redirect()->route('login')->withErrors([
                'google' => __('store.account.google_cancelled'),
            ]);
        }

        $googleUser = Socialite::driver('google')->user();
        $rawUser = $googleUser->getRaw();
        $googleId = $googleUser->getId();
        $email = $googleUser->getEmail();

        if (
            ! is_string($googleId)
            || $googleId === ''
            || ! is_string($email)
            || filter_var($email, FILTER_VALIDATE_EMAIL) === false
            || ($rawUser['verified_email'] ?? false) !== true
        ) {
            return redirect()->route('login')->withErrors([
                'google' => __('store.account.google_unverified'),
            ]);
        }

        $user = User::query()->where('google_id', $googleId)->first()
            ?? User::query()->where('email', $email)->first();

        if ($user !== null && $user->google_id !== null && $user->google_id !== $googleId) {
            return redirect()->route('login')->withErrors([
                'google' => __('store.account.google_link_conflict'),
            ]);
        }

        if ($user === null) {
            $name = $googleUser->getName();
            $user = new User([
                'name' => is_string($name) && trim($name) !== ''
                    ? $name
                    : Str::before($email, '@'),
                'email' => $email,
                'google_id' => $googleId,
                'password' => Str::random(64),
            ]);
            $user->forceFill(['email_verified_at' => now()])->save();
        } elseif ($user->google_id === null) {
            $user->forceFill([
                'google_id' => $googleId,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('store.home'))->with('success', __('store.account.login_success'));
    }

    public function register(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($validated);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('store.home'))->with('success', __('store.account.register_success'));
    }

    public function demoLogin(Request $request): RedirectResponse
    {
        $this->setLocale($request);

        $user = User::firstOrCreate(
            ['email' => 'demo.customer@daramarket.com'],
            [
                'name' => 'សុខ សំណាង (Demo Customer)',
                'password' => 'DemoCustomer123!',
                'is_admin' => false,
            ]
        );

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('store.home'))->with('success', __('store.account.login_success'));
    }

    public function show(Request $request): View
    {
        $this->setLocale($request);
        $user = $request->user();

        $orders = Order::query()
            ->where('customer_email', $user->email)
            ->latest()
            ->take(8)
            ->get();

        $totalOrders = Order::query()->where('customer_email', $user->email)->count();
        $totalSpent = Order::query()->where('customer_email', $user->email)->sum('total_amount');

        return view('store.pages.auth.account', [
            'locale' => app()->getLocale(),
            'translations' => __('store'),
            'user' => $user,
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'totalSpent' => $totalSpent,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $this->setLocale($request);
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update($validated);

        $msg = app()->getLocale() === 'km' 
            ? 'ព័ត៌មានគណនីរបស់អ្នកត្រូវបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ!' 
            : 'Your profile has been updated successfully!';

        return back()->with('success', $msg);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $this->setLocale($request);
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $msg = app()->getLocale() === 'km' 
            ? 'ពាក្យសម្ងាត់របស់អ្នកត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ!' 
            : 'Your password has been changed successfully!';

        return back()->with('success', $msg);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('store.home');
    }

    private function setLocale(Request $request): void
    {
        $locale = $request->session()->get('store_locale', config('store.default_locale'));
        app()->setLocale($locale);
    }

    private function googleConfigured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }
}
