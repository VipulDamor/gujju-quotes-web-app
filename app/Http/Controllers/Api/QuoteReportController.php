<?php

namespace App\Http\Controllers\Api;

use App\Models\QuoteReport;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;  // Import Log for error handling

class QuoteReportController extends Controller
{
    public function index()
    {
        // Fetch all quote reports
        $quoteReports = QuoteReport::all();

        // Return success response with quote reports
        return ResponseHelper::success($quoteReports, 'Quote reports fetched successfully');
    }

 


    public function show($id)
    {
        // Find the quote report by ID
        $quoteReport = QuoteReport::findOrFail($id);

        // Return success response with the found quote report
        return ResponseHelper::success($quoteReport, 'Quote report fetched successfully');
    }

    public function update(Request $request, $id)
    {
        // Find the existing quote report by ID
        $quoteReport = QuoteReport::findOrFail($id);

        // Validate the incoming request data (optional but recommended)
        $request->validate([
            'quote_id' => 'required|integer|exists:quotes,id',  // Example validation rule
            'user_id' => 'required|integer|exists:users,id',    // Example validation rule
            // Add other validation rules as necessary
        ]);

        // Update the quote report with the new data
        $quoteReport->update($request->all());

        // Return success response with the updated quote report
        return ResponseHelper::success($quoteReport, 'Quote report updated successfully');
    }

    public function destroy($id)
    {
        // Find and delete the quote report by ID
        QuoteReport::destroy($id);

        // Return success response indicating the quote report was deleted
        return ResponseHelper::success(null, 'Quote report deleted successfully', 204);
    }
    


public function store(Request $request)
{
    try {
        // Validate request data
        $validated = $request->validate([
            'quote_id' => 'required|integer',
            'report_option_id' => 'required|integer',
            'additional_details' => 'nullable|string',
        ]);

        // Create the new QuoteReport instance
        $quoteReport = new QuoteReport([
            'quote_id' => $validated['quote_id'],
            'report_option_id' => $validated['report_option_id'],
            'additional_details' => $validated['additional_details'] ?? null,
            // 'timestamp' will be automatically handled in the model's boot method
        ]);

        // Save the new QuoteReport
        $quoteReport->save();

        // Return success response
         return ResponseHelper::success(
            ['message' => 'Your quote report has been successfully submitted. We will review it carefully.']
        );
    } catch (QueryException $e) {
        // Log the database error
        Log::error('Database error: ' . $e->getMessage(), [
            'sql' => $e->getSql(),
            'bindings' => $e->getBindings(),
        ]);

        // Return JSON error response for database error
        return ResponseHelper::fail('An error occurred. Please try again later.', 500, [
            'error' => $e->getMessage(),
        ]);
    } catch (ValidationException $e) {
        // Log validation error details
        Log::error('Validation error: ' . $e->getMessage(), [
            'errors' => $e->errors(),
        ]);

        // Return validation error response
        return ResponseHelper::fail('Validation failed.', 422, [
            'errors' => $e->errors(),
        ]);
    } catch (\Exception $e) {
        // Log any other unexpected exceptions
        Log::error('Unexpected error: ' . $e->getMessage(), [
            'exception' => $e,
        ]);

        // Return generic error response for unexpected exceptions
        return ResponseHelper::fail('An unexpected error occurred. Please try again later.', 500, [
            'error' => $e->getMessage(),
        ]);
    }
}




    
}
