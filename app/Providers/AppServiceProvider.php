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
        // 1. Detect if we are on Hostinger (checking for specific directory structure)
        $isHostinger = str_contains(base_path(), 'public_html');

        // 2. Set the public path automatically
        if ($isHostinger) {
            $this->app->usePublicPath(base_path());
        } else {
            $this->app->usePublicPath(base_path('public'));
        }

        // 3. Force Vite to look in the correct manifest location
        $this->app->singleton(\Illuminate\Foundation\Vite::class, function ($app) use ($isHostinger) {
            $vite = new \Illuminate\Foundation\Vite;
            if ($isHostinger) {
                // On Hostinger, we serve from root, so we tell Vite manifest is in /build
                return $vite->useBuildDirectory('build');
            }
            return $vite;
        });
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
