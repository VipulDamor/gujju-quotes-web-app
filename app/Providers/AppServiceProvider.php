<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Auto-detect public path for Hostinger vs Local
        $possiblePaths = [
            base_path('public_html'),
            base_path('public'),
            base_path(),
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path . '/build/manifest.json')) {
                $this->app->usePublicPath($path);
                break;
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Define Rate Limiters
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinutes(10, 3)->by($request->ip());
        });
    }
}
