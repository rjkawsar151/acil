<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('blogs')->get();
        return view('admin.blog_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:blog_categories,slug',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['status'] = $request->boolean('status');

        BlogCategory::create($validated);

        return back()->with('success', 'Blog category created.');
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:blog_categories,slug,' . $blogCategory->id,
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $blogCategory->update($validated);

        return back()->with('success', 'Blog category updated.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        if ($blogCategory->blogs()->count() > 0) {
            return back()->with('error', 'Cannot delete category that contains published blogs.');
        }

        $blogCategory->delete();
        return back()->with('success', 'Blog category deleted.');
    }
}
