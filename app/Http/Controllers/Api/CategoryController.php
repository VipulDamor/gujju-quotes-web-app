<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;  // Import Log for error handling

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = Category::all();

        // Return success response with categories
         return ResponseHelper::success([
            'categories' => $categories
        ], 'Categories fetched successfully');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data (optional but recommended)
        $request->validate([
            'name' => 'required|string|max:255',  // Example validation rule
        ]);

        // Create a new category
        $category = Category::create($request->all());

        // Return success response with the created category
        return ResponseHelper::success($category, 'Category created successfully', 201);
    }

    public function show($id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);

        // Return success response with the found category
        return ResponseHelper::success($category, 'Category fetched successfully');
    }

    public function update(Request $request, $id)
    {
        // Find the existing category by ID
        $category = Category::findOrFail($id);

        // Validate the incoming request data (optional but recommended)
        $request->validate([
            'name' => 'required|string|max:255',  // Example validation rule
        ]);

        // Update the category with the new data
        $category->update($request->all());

        // Return success response with the updated category
        return ResponseHelper::success($category, 'Category updated successfully');
    }

    public function destroy($id)
    {
        // Find and delete the category by ID
        Category::destroy($id);

        // Return success response indicating the category was deleted
        return ResponseHelper::success(null, 'Category deleted successfully', 204);
    }
}
