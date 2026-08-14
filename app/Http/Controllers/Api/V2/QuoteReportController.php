<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\QuoteReport;
use Illuminate\Http\Request;

class QuoteReportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Use manual validation to ensure we return JSON even if Accept header is missing
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'quote_id' => 'required',
            'report_option_id' => 'required|integer',
            'additional_details' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if quote_id is numeric. If the app sends a string like "quote_123", we might want to extract the ID.
        $quoteId = $request->quote_id;
        if (!is_numeric($quoteId)) {
            // Check if it's in the format "quote_X_..."
            if (preg_match('/quote_(\d+)/', $quoteId, $matches)) {
                $quoteId = $matches[1];
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid quote ID format. Expected numeric ID.',
                ], 422);
            }
        }

        // Verify quote exists
        if (!\App\Models\Quote::where('id', $quoteId)->exists()) {
             return response()->json([
                'status' => 'error',
                'message' => 'Quote not found.',
            ], 404);
        }

        $report = QuoteReport::create([
            'quote_id' => $quoteId,
            'report_option_id' => $request->report_option_id,
            'additional_details' => strip_tags($request->additional_details),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Report submitted successfully. Thank you for keeping our community safe.',
            'data' => $report
        ], 201);
    }
}
