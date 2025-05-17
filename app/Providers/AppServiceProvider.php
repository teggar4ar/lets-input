<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

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
        // Fix for MySQL "Specified key was too long" error
        Schema::defaultStringLength(191);

        // Only force HTTPS if specifically configured
        if (config('app.env') === 'production' && config('app.force_https', false)) {
            URL::forceScheme('https');
            Config::set('session.secure', true);
        }
    }
}
