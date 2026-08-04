<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\QuoteReportController;

// --- V1 API ROUTES (Backward Compatibility) ---
Route::resource('categories', CategoryController::class);
Route::resource('quotes', QuoteController::class);
Route::get('quotes/category/{category_id}', [QuoteController::class, 'getQuotesByCategory']);
Route::get('quote-of-the-day', [QuoteController::class, 'quoteOfTheDay']);
Route::get('/random-quote', [QuoteController::class, 'randomQuote']);
Route::get('/quotebycategory', [QuoteController::class, 'randomQuoteByCateogry']);
Route::resource('quotes/report', QuoteReportController::class);


// --- V2 API ROUTES (Highly Secure & Paginated) ---
use App\Http\Controllers\Api\V2\CategoryController as V2Category;
use App\Http\Controllers\Api\V2\QuoteController as V2Quote;
use App\Http\Controllers\Api\V2\QuoteReportController as V2Report;

Route::prefix('v2')->middleware('api.key')->group(function () {

    // Categories (No pagination)
    Route::get('categories', [V2Category::class, 'index']);
    Route::get('categories/{id}', [V2Category::class, 'show']);

    // Quotes (With Pagination)
    Route::get('quotes', [V2Quote::class, 'index']);
    Route::get('quotes/random', [V2Quote::class, 'random']);
    Route::get('quotes/search', [V2Quote::class, 'search']);
    Route::get('quotes/category/{id}', [V2Quote::class, 'getByCategory']);
    Route::get('quotes/{id}', [V2Quote::class, 'show']);

    // Specialized Logic
    Route::get('quote-of-the-day', [V2Quote::class, 'quoteOfTheDay']);
    Route::get('explore', [V2Quote::class, 'explore']); // Replaces /quotebycategory

    // Reports
    Route::post('reports', [V2Report::class, 'store']);

});
