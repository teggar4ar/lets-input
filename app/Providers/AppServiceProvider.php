<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\PendudukService;
use App\Services\ExportService;
use App\Repositories\PendudukRepository;
use App\Repositories\ReferenceDataRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register repositories
        $this->app->bind(PendudukRepository::class, function ($app) {
            return new PendudukRepository($app->make(\App\Models\Penduduk::class));
        });

        $this->app->bind(ReferenceDataRepository::class, function ($app) {
            return new ReferenceDataRepository();
        });

        // Register services
        $this->app->bind(PendudukService::class, function ($app) {
            return new PendudukService(
                $app->make(PendudukRepository::class),
                $app->make(ReferenceDataRepository::class)
            );
        });

        $this->app->bind(ExportService::class, function ($app) {
            return new ExportService($app->make(PendudukRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for MySQL "Specified key was too long" error
        Schema::defaultStringLength(191);
    }
}
