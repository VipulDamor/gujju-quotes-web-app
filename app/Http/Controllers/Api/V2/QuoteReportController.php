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
        $request->validate([
            'quote_id' => 'required|exists:quotes,id',
            'report_option_id' => 'required|integer',
            'additional_details' => 'nullable|string',
        ]);

        $report = QuoteReport::create([
            'quote_id' => $request->quote_id,
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
