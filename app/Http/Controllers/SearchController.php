<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->query('q', ''));

        $products = collect();
        $blogs = collect();
        $pages = collect();

        if (strlen($query) >= 2) {
            $products = Product::active()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('sku', 'like', "%{$query}%")
                      ->orWhere('short_description', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('ingredients_information', 'like', "%{$query}%");
                })
                ->with('category')
                ->take(8)
                ->get();

            $blogs = Blog::published()
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('excerpt', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->with('category')
                ->take(6)
                ->get();

            $pages = Page::published()
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->take(4)
                ->get();
        }

        $totalResults = $products->count() + $blogs->count() + $pages->count();

        return view('frontend.search', compact('query', 'products', 'blogs', 'pages', 'totalResults'));
    }
}
