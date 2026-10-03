<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $status = $request->query('status');

        $query = Blog::with('category');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $blogs = $query->latest('published_at')->paginate(15)->withQueryString();
        $categories = BlogCategory::all();

        return view('admin.blogs.index', compact('blogs', 'categories', 'search', 'categoryId', 'status'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', true)->get();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:blog_categories,id',
            'title' => 'required|string|max:250',
            'slug' => 'nullable|string|max:250|unique:blogs,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'author' => 'required|string|max:100',
            'published_at' => 'nullable|date',
            'status' => 'required|in:published,draft',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (empty($validated['published_at']) && $validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog article published successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('status', true)->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:blog_categories,id',
            'title' => 'required|string|max:250',
            'slug' => 'required|string|max:250|unique:blogs,slug,' . $blog->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'author' => 'required|string|max:100',
            'published_at' => 'nullable|date',
            'status' => 'required|in:published,draft',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog article updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return back()->with('success', 'Blog post deleted.');
    }
}
