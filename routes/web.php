<?php
use App\Http\Controllers\Api\QuoteController;
/* use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

use App\Http\Controllers\Api\QuoteReportController;

// Category Routes
Route::resource('api/categories', CategoryController::class);

// Quote Routes
Route::resource('api/quotes', QuoteController::class);
Route::get('api/quotes/category/{category_id}', [QuoteController::class, 'getQuotesByCategory']);
Route::get('api/quote-of-the-day', [QuoteController::class, 'quoteOfTheDay']);
//Route::get('api/quotes/search', [QuoteController::class, 'searchQuoteByName']);
Route::get('quotes/search/', [QuoteController::class, 'searchQuoteByName']);

// QuoteReport Routes
Route::resource('api/quotereports', QuoteReportController::class);

Route::fallback(function () {
    return response()->json(['message' => 'Route not found in Laravel'], 404);
});
 */
use Illuminate\Support\Facades\Route;

Route::get('quotes/search/', [QuoteController::class, 'searchQuoteByName']);

Route::get('/', function () {
    return "API is running. You can access the API endpoints through /api routes.";
});
/* Route::get('/', function () {
    return view('welcome');
}); */
