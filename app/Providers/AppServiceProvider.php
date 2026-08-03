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
        // 1. Array of possible relative paths to the manifest from the project root
        $manifestRelativePaths = [
            'public/build/manifest.json',
            'public_html/build/manifest.json',
            'build/manifest.json',
        ];

        foreach ($manifestRelativePaths as $relativePath) {
            if (file_exists(base_path($relativePath))) {
                // Set the public path to the directory containing the 'build' folder
                $publicDir = dirname(str_replace('/manifest.json', '', base_path($relativePath)));
                $this->app->usePublicPath($publicDir);
                return;
            }
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
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
