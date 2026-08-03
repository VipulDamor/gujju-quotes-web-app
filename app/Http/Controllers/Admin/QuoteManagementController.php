<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Category;
use Illuminate\Http\Request;

class QuoteManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Quote::with('category');

        if ($request->has('search')) {
            $query->where('quote', 'LIKE', '%' . $request->search . '%');
        }

        $quotes = $query->orderBy('id', 'desc')->paginate(15);
        return view('admin.quotes.index', compact('quotes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.quotes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quote' => 'required|string|max:1000',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Sanitize input: Strip any tags to prevent XSS
        $data = $request->all();
        $data['quote'] = strip_tags($request->quote);

        Quote::create($data);
        return redirect()->route('admin.quotes.index')->with('success', 'Quote added successfully!');
    }

    public function edit(Quote $quote)
    {
        $categories = Category::all();
        return view('admin.quotes.edit', compact('quote', 'categories'));
    }

    public function update(Request $request, Quote $quote)
    {
        $request->validate([
            'quote' => 'required|string|max:1000',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Sanitize input: Strip any tags to prevent XSS
        $data = $request->all();
        $data['quote'] = strip_tags($request->quote);

        $quote->update($data);
        return redirect()->route('admin.quotes.index')->with('success', 'Quote updated successfully!');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('admin.quotes.index')->with('success', 'Quote deleted successfully!');
    }
}
