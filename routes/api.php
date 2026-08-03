<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;


use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\QuoteReportController;

// API Routes for Categories
Route::resource('categories', CategoryController::class);

// API Routes for Quotes
Route::resource('quotes', QuoteController::class);
Route::get('quotes/category/{category_id}', [QuoteController::class, 'getQuotesByCategory']);
Route::get('quote-of-the-day', [QuoteController::class, 'quoteOfTheDay']);
Route::get('/random-quote', [QuoteController::class, 'randomQuote']);
Route::get('/quotebycategory', [QuoteController::class, 'randomQuoteByCateogry']);



// API Routes for Quote Reports
Route::resource('quotes/report', QuoteReportController::class);
