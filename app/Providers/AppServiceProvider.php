<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::defaultView('admin.partials.pagination');

        // Share persistent store settings globally with all views
        try {
            $settings = \App\Services\StoreSettingService::all();
            \Illuminate\Support\Facades\View::share('storeSettings', $settings);
        } catch (\Throwable $e) {
            // Fallback in case storage or database isn't initialized yet
            \Illuminate\Support\Facades\View::share('storeSettings', \App\Services\StoreSettingService::defaults());
        }
    }
}
