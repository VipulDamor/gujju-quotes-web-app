<?php


namespace App\Providers;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $namespace = 'App\\Http\\Controllers';
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Fix for Vite manifest and public paths on Hostinger shared hosting
        if ($this->app->environment('production')) {
            $this->app->bind('path.public', function () {
                return base_path('public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::prefix('api')
        ->middleware('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/api.php')); // Specify path to api.php

    // Register the Web Routes
    Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/web.php')); // Specify path to web.php
    }
}
