<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('quotes');

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('id', 'desc')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        try {
            // Sanitize input to prevent XSS
            $name = strip_tags($request->name);
            Category::create(['name' => $name]);
            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->with([
                'error' => 'Failed to create category. A database error occurred.',
                'error_code' => $e->getCode()
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        try {
            // Sanitize input to prevent XSS
            $name = strip_tags($request->name);
            $category->update(['name' => $name]);
            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->with([
                'error' => 'Failed to update category. Database constraint violation.',
                'error_code' => $e->getCode()
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        try {
            // Check if category has quotes
            if ($category->quotes()->count() > 0) {
                return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category that contains quotes. Please move or delete the quotes first.');
            }

            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with([
                'error' => 'Could not delete category.',
                'error_code' => 'ERR_DEL_CAT'
            ]);
        }
    }
}
