<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteReport;
use App\Models\Quote;
use App\Models\Category;
use Illuminate\Http\Request;

class ReportManagementController extends Controller
{
    public function index(Request $request)
    {
        // Get the descriptive options
        $options = QuoteReport::getReportOptions();
        $categories = Category::orderBy('name')->get();

        // Build the query
        $query = QuoteReport::select('quotereports.*', 'quotes.quote as quote_text', 'quotes.category_id')
            ->join('quotes', 'quotereports.quote_id', '=', 'quotes.id');

        // Apply filters
        if ($request->filled('ip_address')) {
            $query->where('additional_details', 'like', '%' . $request->ip_address . '%');
        }

        if ($request->filled('device_id')) {
            $query->where('additional_details', 'like', '%' . $request->device_id . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('quotes.category_id', $request->category_id);
        }

        if ($request->filled('report_option_id')) {
            $query->where('quotereports.report_option_id', $request->report_option_id);
        }

        // Fetch filtered reports
        $allReports = $query->orderBy('quotereports.timestamp', 'desc')->get();

        // Group by report_option_id
        $groupedReports = $allReports->groupBy('report_option_id');

        return view('admin.reports.index', compact('groupedReports', 'options', 'categories'));
    }

    public function destroy($id)
    {
        $report = QuoteReport::findOrFail($id);
        $report->delete();
        return redirect()->route('admin.reports.index')->with('success', 'Report dismissed.');
    }

    public function deleteQuote($id)
    {
        $report = QuoteReport::findOrFail($id);
        $quote = Quote::find($report->quote_id);

        if ($quote) {
            $quote->delete();
            // All reports for this quote should ideally be cleaned up too
            QuoteReport::where('quote_id', $report->quote_id)->delete();
            return redirect()->route('admin.reports.index')->with('success', 'Offending quote and all its reports deleted.');
        }

        return redirect()->route('admin.reports.index')->with('error', 'Quote already deleted.');
    }
}
