<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the actual column names from the categories table
        $columns = Schema::getColumnListing('categories');
        return view('categories.create', compact('columns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get the actual column names from the categories table
        $columns = Schema::getColumnListing('categories');
        
        // Check if 'name' column exists
        if (in_array('name', $columns)) {
            $request->validate([
                'name' => 'required|string|unique:categories',
            ]);

            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);
        } else {
            // If 'name' doesn't exist, use 'category_name' or another column that exists
            $request->validate([
                'category_name' => 'required|string|unique:categories',
            ]);

            Category::create([
                'category_name' => $request->category_name,
                'slug' => Str::slug($request->category_name),
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Get the actual column names from the categories table
        $columns = Schema::getColumnListing('categories');
        
        // Check if 'name' column exists
        if (in_array('name', $columns)) {
            $request->validate([
                'name' => 'required|string|unique:categories,name,' . $id,
            ]);

            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);
        } else {
            // If 'name' doesn't exist, use 'category_name' or another column that exists
            $request->validate([
                'category_name' => 'required|string|unique:categories,category_name,' . $id,
            ]);

            $category = Category::findOrFail($id);
            $category->update([
                'category_name' => $request->category_name,
                'slug' => Str::slug($request->category_name),
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('warning', 'Category deleted successfully');
    }
}


