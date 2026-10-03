<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('sort_order', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150|unique:categories,slug',
            'description' => 'nullable|string',
            'badge_text' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|max:150|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'badge_text' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with associated products. Please reassign products first.');
        }

        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json(['success' => true, 'is_active' => $category->is_active]);
    }
}
