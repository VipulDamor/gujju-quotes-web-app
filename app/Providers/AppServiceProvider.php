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
        // 1. Log the current paths to help debug on Hostinger
        \Illuminate\Support\Facades\Log::debug('Deployment Debug:', [
            'base_path' => base_path(),
            'public_path_default' => public_path(),
            'manifest_exists_in_root' => file_exists(base_path('build/manifest.json')),
            'manifest_exists_in_public' => file_exists(base_path('public/build/manifest.json')),
            'current_directory' => getcwd(),
        ]);

        // 2. Set the public path
        if (file_exists(base_path('build/manifest.json'))) {
            $this->app->usePublicPath(base_path());
        } else {
            $this->app->usePublicPath(base_path('public'));
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
