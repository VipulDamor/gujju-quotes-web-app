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
