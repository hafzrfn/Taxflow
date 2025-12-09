<?php

namespace App\Providers;

use App\Models\ObjekPajak;
use App\Observers\ObjekPajakObserver;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\App\Providers\DukcapilServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ObjekPajak::observe(ObjekPajakObserver::class);

        // Ensure admin user always exists in development/staging
        try {
            // Ensure admin exists and has the hardcoded password (development only)
            User::updateOrCreate(
                ['email' => 'admin@demo.test'],
                [
                    'name' => 'Administrator',
                    'password' => bcrypt('secret123'),
                ]
            );
        } catch (\Exception $e) {
            // avoid breaking boot if DB not ready
        }
    }
}
