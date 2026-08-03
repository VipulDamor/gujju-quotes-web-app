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
        // Robust Public Path Detection for Hostinger & Local
        if (file_exists(base_path('public_html/build/manifest.json'))) {
            $this->app->usePublicPath(base_path('public_html'));
        } elseif (file_exists(base_path('build/manifest.json'))) {
            $this->app->usePublicPath(base_path());
        } elseif (is_dir(base_path('public_html'))) {
            $this->app->usePublicPath(base_path('public_html'));
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
