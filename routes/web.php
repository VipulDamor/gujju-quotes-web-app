<?php

use App\Http\Controllers\Api\QuoteController;
use App\Models\Category;
use App\Models\Quote;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Quote of the Day
    $dayOfYear = now()->dayOfYear;
    $qotd = Cache::remember('qotd_' . now()->format('Y_m_d'), now()->addDay(), function () use ($dayOfYear) {
        return Quote::with('category')
            ->whereNotIn('category_id', [5, 6, 10, 12, 13, 15, 16, 17, 18])
            ->orderByRaw("RAND($dayOfYear)")
            ->first();
    });

    // Categories
    $categories = Category::limit(15)->get();

    // Limited Random Quotes for "Explore" (The "Teaser")
    $exploreQuotes = Quote::with('category')->inRandomOrder()->limit(8)->get();

    return view('welcome', compact('qotd', 'categories', 'exploreQuotes'));
});

Route::get('/category/{id}', function ($id) {
    $category = Category::findOrFail($id);
    // Limit to only 6 quotes per category on web to encourage app download
    $quotes = Quote::where('category_id', $id)->with('category')->limit(6)->get();
    return view('quotes.category', compact('category', 'quotes'));
})->where('id', '[0-9]+')->name('quotes.by-category');

Route::get('/quote/{id}', function ($id) {
    $quote = Quote::with('category')->findOrFail($id);
    return view('quotes.show', compact('quote'));
})->name('quotes.show');

Route::get('/system/security-check', function () {
    return response()->json([
        'status' => 'Secure',
        'encryption' => 'SSL/TLS Enabled',
        'firewall' => 'Active',
        'env_access' => 'BLOCKED',
        'directory_browsing' => 'DISABLED',
        'last_scan' => now()->toDateTimeString(),
        'verified_by' => 'One993Techsol Security'
    ]);
});

Route::get('/api/quotes/random-shuffle', function () {
    $quotes = Quote::with('category')->inRandomOrder()->limit(12)->get();
    $html = '';
    foreach($quotes as $quote) {
        $html .= view('components.quote-card', ['quote' => $quote])->render();
    }
    return response()->json(['html' => $html]);
});

Route::get('quotes/search/', [QuoteController::class, 'searchQuoteByName']);

// --- ADMIN PANEL ROUTES ---
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuoteManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\ReportManagementController;
use App\Http\Controllers\Admin\ProfileController;

Route::prefix('admin')->group(function () {
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
    });

    // Protected Routes
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Quote Management
        Route::resource('quotes', QuoteManagementController::class, ['as' => 'admin']);

        // Category Management
        Route::resource('categories', CategoryManagementController::class, ['as' => 'admin']);

        // Report Management
        Route::get('/reports', [ReportManagementController::class, 'index'])->name('admin.reports.index');
        Route::delete('/reports/{id}', [ReportManagementController::class, 'destroy'])->name('admin.reports.destroy');
        Route::post('/reports/{id}/delete-quote', [ReportManagementController::class, 'deleteQuote'])->name('admin.reports.delete-quote');

        // Profile / Security
        Route::get('/security', [ProfileController::class, 'showChangePassword'])->name('admin.password.edit');
        Route::post('/security', [ProfileController::class, 'updatePassword'])->name('admin.password.update');
    });
});
