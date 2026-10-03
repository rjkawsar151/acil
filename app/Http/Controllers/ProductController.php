<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $search = $request->query('q');
        $sort = $request->query('sort', 'popular');

        $categories = Category::active()->withCount('activeProducts')->get();
        $query = Product::active()->with(['category', 'images']);

        $selectedCategory = null;
        if ($categorySlug) {
            $selectedCategory = Category::where('slug', $categorySlug)->first();
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        if ($search) {
            $query->search($search);
        }

        if ($sort === 'name_asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->orderBy('name', 'desc');
        } elseif ($sort === 'featured') {
            $query->orderBy('is_featured', 'desc')->orderBy('sort_order', 'asc');
        } else {
            $query->orderBy('sort_order', 'asc')->orderBy('is_featured', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        $seo = SeoSetting::getForPage('products');

        return view('frontend.products.index', compact('products', 'categories', 'selectedCategory', 'search', 'sort', 'seo'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'images'])->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::active()->where('category_id', $category->id)->with('images')->paginate(12);
        $categories = Category::active()->withCount('activeProducts')->get();

        return view('frontend.products.category', compact('category', 'products', 'categories'));
    }
}
