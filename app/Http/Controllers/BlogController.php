<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $search = $request->query('q');

        $categories = BlogCategory::active()->withCount('blogs')->get();
        $query = Blog::published()->with('category');

        $selectedCategory = null;
        if ($categorySlug) {
            $selectedCategory = BlogCategory::where('slug', $categorySlug)->first();
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->paginate(9)->withQueryString();
        $recentBlogs = Blog::published()->take(4)->get();
        $seo = SeoSetting::getForPage('news');

        return view('frontend.news.index', compact('blogs', 'categories', 'selectedCategory', 'recentBlogs', 'search', 'seo'));
    }

    public function show(string $slug)
    {
        $blog = Blog::published()->with('category')->where('slug', $slug)->firstOrFail();
        $relatedBlogs = Blog::published()
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->take(3)
            ->get();

        $categories = BlogCategory::active()->withCount('blogs')->get();

        return view('frontend.news.show', compact('blog', 'relatedBlogs', 'categories'));
    }

    public function category(string $slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();
        $blogs = Blog::published()->where('category_id', $category->id)->paginate(9);
        $categories = BlogCategory::active()->withCount('blogs')->get();
        $recentBlogs = Blog::published()->take(4)->get();

        return view('frontend.news.category', compact('category', 'blogs', 'categories', 'recentBlogs'));
    }
}
