<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Category;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a paginated listing of all quotes.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 20);
        $quotes = Quote::with('category:id,name')
            ->select('id', 'category_id', 'quote')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $quotes->items(),
            'meta' => [
                'current_page' => $quotes->currentPage(),
                'last_page' => $quotes->lastPage(),
                'per_page' => $quotes->perPage(),
                'total' => $quotes->total(),
            ]
        ]);
    }

    /**
     * Display a paginated listing of quotes by category.
     */
    public function getByCategory(Request $request, $categoryId)
    {
        $perPage = $request->query('per_page', 20);
        $quotes = Quote::where('category_id', $categoryId)
            ->with('category:id,name')
            ->select('id', 'category_id', 'quote')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $quotes->items(),
            'meta' => [
                'current_page' => $quotes->currentPage(),
                'last_page' => $quotes->lastPage(),
                'per_page' => $quotes->perPage(),
                'total' => $quotes->total(),
            ]
        ]);
    }

    /**
     * Get a random quote.
     */
    public function random()
    {
        $quote = Quote::with('category:id,name')
            ->select('id', 'category_id', 'quote')
            ->inRandomOrder()
            ->first();

        return response()->json([
            'status' => 'success',
            'data' => $quote
        ]);
    }

    /**
     * Display the specified quote.
     */
    public function show($id)
    {
        $quote = Quote::with('category:id,name')
            ->select('id', 'category_id', 'quote')
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $quote
        ]);
    }

    /**
     * Get the quote of the day.
     */
    public function quoteOfTheDay()
    {
        $dayOfYear = now()->dayOfYear;
        $cacheKey = 'qotd_v2_' . now()->format('Y_m_d');

        $quote = \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addDay(), function () use ($dayOfYear) {
            return Quote::with('category:id,name')
                ->select('id', 'category_id', 'quote')
                ->whereNotIn('category_id', [5, 6, 10, 12, 13, 15, 16, 17, 18])
                ->orderByRaw("RAND($dayOfYear)")
                ->first();
        });

        return response()->json([
            'status' => 'success',
            'data' => $quote
        ]);
    }

    /**
     * Get a set of random quotes grouped by category (Explore View).
     */
    public function explore()
    {
        $categories = Category::all();
        $formattedResponse = [];

        foreach ($categories as $category) {
            $quotes = Quote::where('category_id', $category->id)
                           ->inRandomOrder()
                           ->limit(6)
                           ->get(['id as quoteid', 'quote as quotetext']);

            if ($quotes->isNotEmpty()) {
                $formattedResponse[] = [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'quoteslist' => $quotes
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $formattedResponse
        ]);
    }
}
