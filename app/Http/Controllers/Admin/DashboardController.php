<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Category;
use App\Models\QuoteReport;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_quotes' => Quote::count(),
            'total_categories' => Category::count(),
            'total_reports' => QuoteReport::has('quote')->count(),
            'recent_quotes' => Quote::with('category')->orderBy('id', 'desc')->limit(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
