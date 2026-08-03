<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Quote;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;  // Import Log for error handling

class QuoteController extends Controller
{
    public function index()
    {
        // Fetch all quotes with their categories and reports
        $quotes = Quote::with('category', 'quotereports')->get();
         return ResponseHelper::success([
            'quotes' => $quotes
        ], 'Quotes fetched successfully');
    }

    public function store(Request $request)
    {
        // Validate request data (optional step for better input validation)
        $request->validate([
            'quote' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        // Create the new quote
        $quote = Quote::create($request->all());

        // Return success response with the created quote
        return ResponseHelper::success($quote, 'Quote created successfully', 201);
    }

    public function show($id)
    {
        // Find the quote by ID along with its related category and quote reports
        $quote = Quote::with('category', 'quotereports')->findOrFail($id);

        // Return success response with the found quote
         return ResponseHelper::success([
            'quotes' => $quotes
        ], 'Quotes fetched successfully');
    }

    public function getQuotesByCategory($category_id)
    {
        // Get quotes for the specified category
        $quotes = Quote::where('category_id', $category_id)->get();

        // Return the quotes as a JSON response
         return ResponseHelper::success([
            'quotes' => $quotes
        ], 'Quotes fetched successfully');
    }

    public function quoteOfTheDay()
{
    // Generate a cache key based on today's date (e.g., 'quote_of_the_day_2025_01_02')
    $cacheKey = 'quote_of_the_day_' . now()->format('Y_m_d');  // Use the current date

    // Try to retrieve the cached quote for today
    $quote = Cache::get($cacheKey);

    if (!$quote) {
        // Query the quote if it's not found in the cache
        $dayOfYear = now()->dayOfYear;

        // Fetch the random quote for the day
        $quote = Quote::whereNotIn('category_id', [5, 6, 10, 12, 13, 15, 16, 17, 18])
                      ->orderByRaw("RAND($dayOfYear)")  // Make it stable based on the day
                      ->first();

        // If quote is found, store it in the cache for 24 hours
        if ($quote) {
            Cache::put($cacheKey, $quote, now()->addDay());
        }
    }

    // If no quote is found, return an appropriate error message
    if (!$quote) {
        return response()->json([
            "status" => "error",
            "message" => "No quotes found matching the search term",
            "data" => null,
        ], 404);
    }

    // Structure the response with the quote data
    return response()->json([
        "status" => "success",
        "message" => "",
        "data" => [
            "quote" => [
                "id" => $quote->id,
                "category_id" => $quote->category_id,
                "quote" => $quote->quote,
            ],
        ],
    ]);
}

    public function update(Request $request, $id)
    {
        // Find the existing quote by ID
        $quote = Quote::findOrFail($id);

        // Update the quote with the new data
        $quote->update($request->all());

        // Return success response with the updated quote
        return ResponseHelper::success($quote, 'Quote updated successfully');
    }

    public function destroy($id)
    {
        // Delete the quote by ID
        Quote::destroy($id);

        // Return success response indicating that the quote was deleted
        return ResponseHelper::success(null, 'Quote deleted successfully', 204);
    }

    public function searchQuoteByName(Request $request)
    {
        try {
            // Validate that 'name' query parameter is provided
            $request->validate([
                'name' => 'required|string|min:1',
            ]);

            // Get the 'name' query parameter
            $name = $request->query('name');

            // Search quotes containing the provided name (case-insensitive)
            $quotes = Quote::where('quote', 'LIKE', '%' . $name . '%')->get();

            // Check if any quotes are found
            if ($quotes->isEmpty()) {
                return ResponseHelper::error('No quotes found matching the search term', 404);
            }

            // Return the found quotes as a JSON response
             return ResponseHelper::success([
            'quotes' => $quotes
        ], 'Quotes fetched successfully');
        } catch (\Exception $e) {
            // Log the exception message and stack trace
            Log::error('Error occurred while searching for quote: ' . $e->getMessage(), [
                'exception' => $e,
                'name' => $request->query('name'),
            ]);

            // Return a generic error response
            return ResponseHelper::error('An error occurred while processing your request', 500);
        }
    }
    public function randomQuote()
{
    // Fetch a random quote from the database
    $quote = Quote::inRandomOrder()  // Randomly selects a quote
                  ->first();

    // If no quote is found, return an error response
    if (!$quote) {
        return response()->json([
            "status" => "error",
            "message" => "No quotes found",
            "data" => null,
        ], 404);
    }

    // Return the random quote in the desired response format
    return response()->json([
        "status" => "success",
        "message" => "",
        "data" => [
            "quote" => [
                "id" => $quote->id,
                "category_id" => $quote->category_id,
                "quote" => $quote->quote,
            ],
        ],
    ]);
}


public function randomQuoteByCateogry()
{
    // Fetch all categories from the database
    $categories = Category::all();

    // Initialize an empty array to store the formatted data
    $formattedResponse = [];

    // Loop through each category
    foreach ($categories as $category) {
        // Fetch 20 random quotes for the current category
        $quotes = Quote::where('category_id', $category->id)
                       ->inRandomOrder()
                       ->limit(6)
                       ->get();

        // If no quotes are found for the category, skip to the next category
        if ($quotes->isEmpty()) {
            continue;
        }

        // Format the category and its quotes
        $categoryData = [
            "category_id" => $category->id,
            "category_name" => $category->name ?? "Unknown",
            "quoteslist" => $quotes->map(function ($quote) {
                return [
                    "quoteid" => $quote->id,
                    "quotetext" => $quote->quote,
                ];
            })->toArray(),
        ];

        // Add the category data to the response array
        $formattedResponse[] = ["category" => $categoryData];
    }

    // If no categories have quotes, return an error response
    if (empty($formattedResponse)) {
        return response()->json([
            "success" => false,
            "message" => "No categories or quotes found",
            "data" => null,
        ], 404);
    }

    // Build the final response
    $response = [
        "success" => true,
        "message" => "",
        "data" => $formattedResponse,
    ];

    // Return the formatted JSON response
    return response()->json($response, 200);
}



}
