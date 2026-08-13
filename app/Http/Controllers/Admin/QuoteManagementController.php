<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function bulkCreate()
    {
        $categories = Category::all();
        return view('admin.quotes.bulk-create', compact('categories'));
    }

    public function bulkPreview(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'quotes_text' => 'required_without:quotes_file',
            'quotes_file' => 'required_without:quotes_text|file|mimes:csv,txt|max:2048', // Max 2MB
        ]);

        $quotes = [];
        $errors = [];
        $lineNum = 0;

        // Handle File Upload
        if ($request->hasFile('quotes_file')) {
            $file = $request->file('quotes_file');
            $handle = fopen($file->getRealPath(), 'r');

            while (($row = fgetcsv($handle)) !== false) {
                $lineNum++;
                $text = $row[0] ?? '';
                $trimmed = trim($text);

                if (empty($trimmed)) {
                    $errors[] = "Line {$lineNum}: Row is empty.";
                    continue;
                }

                if (strlen($trimmed) > 1000) {
                    $errors[] = "Line {$lineNum}: Quote is too long (Max 1000 chars).";
                    continue;
                }

                $quotes[] = [
                    'line' => $lineNum,
                    'text' => strip_tags($trimmed)
                ];
            }
            fclose($handle);
        } else {
            // Handle Text Area
            $separator = $request->input('separator', '\n');
            $lines = ($separator === '\n') ? explode("\n", $request->quotes_text) : explode($separator, $request->quotes_text);

            foreach ($lines as $line) {
                $lineNum++;
                $trimmed = trim($line);

                if (empty($trimmed)) continue; // Silently skip empty lines in text area

                if (strlen($trimmed) > 1000) {
                    $errors[] = "Quote #{$lineNum}: Too long (Max 1000 chars).";
                    continue;
                }

                $quotes[] = [
                    'line' => $lineNum,
                    'text' => strip_tags($trimmed)
                ];
            }
        }

        if (!empty($errors)) {
            return back()->withInput()->with('bulk_errors', $errors);
        }

        if (empty($quotes)) {
            return back()->with('error', 'No valid quotes found in your input.');
        }

        // Store in session for preview (storing only text for DB)
        session([
            'bulk_quotes' => array_column($quotes, 'text'),
            'bulk_category_id' => $request->category_id
        ]);

        return view('admin.quotes.bulk-preview', [
            'quotes' => $quotes,
            'category' => Category::find($request->category_id)
        ]);
    }

    public function bulkRemove(Request $request)
    {
        $index = $request->input('index');
        $quotes = session('bulk_quotes', []);

        if (isset($quotes[$index])) {
            unset($quotes[$index]);
            // Re-index the array to prevent issues
            $quotes = array_values($quotes);
            session(['bulk_quotes' => $quotes]);
            return response()->json(['status' => 'success', 'count' => count($quotes)]);
        }

        return response()->json(['status' => 'error'], 400);
    }

    public function bulkStore(Request $request)
    {
        $quotes = session('bulk_quotes');
        $categoryId = session('bulk_category_id');

        if (!$quotes || !$categoryId) {
            return redirect()->route('admin.quotes.bulk.create')->with('error', 'Session expired. Please upload again.');
        }

        // If user removed some quotes in the preview, we should handle that
        // For simplicity, let's assume they want to publish the current session list
        // If we want them to remove specific ones, we'd need more logic here.
        // I will add a 'remove' logic in preview via JS or another request.
        // For now, let's just insert what's in the session.

        try {
            DB::beginTransaction();
            foreach ($quotes as $quoteText) {
                Quote::create([
                    'quote' => $quoteText,
                    'category_id' => $categoryId
                ]);
            }
            DB::commit();

            session()->forget(['bulk_quotes', 'bulk_category_id']);
            return redirect()->route('admin.quotes.index')->with('success', count($quotes) . ' quotes published successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save quotes: ' . $e->getMessage());
        }
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

        try {
            // Sanitize input: Strip any tags to prevent XSS
            $data = $request->all();
            $data['quote'] = strip_tags($request->quote);

            Quote::create($data);
            return redirect()->route('admin.quotes.index')->with('success', 'Quote added successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->with([
                'error' => 'Database error: Could not save quote.',
                'error_code' => $e->getCode()
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Operation failed: ' . $e->getMessage());
        }
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

        try {
            // Sanitize input: Strip any tags to prevent XSS
            $data = $request->all();
            $data['quote'] = strip_tags($request->quote);

            $quote->update($data);
            return redirect()->route('admin.quotes.index')->with('success', 'Quote updated successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->with([
                'error' => 'Update failed due to database error.',
                'error_code' => $e->getCode()
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Quote $quote)
    {
        try {
            $quote->delete();
            return redirect()->route('admin.quotes.index')->with('success', 'Quote deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.quotes.index')->with([
                'error' => 'Delete failed.',
                'error_code' => 'ERR_DEL_QUOTE'
            ]);
        }
    }
}
