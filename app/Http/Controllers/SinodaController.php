<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class SinodaController extends Controller
{
    public function index()
    {
        $categories = Category::active()->withCount('activeProducts')->get();
        $sinodaProducts = Product::active()->where('brand', 'SINODA')->with(['category', 'images'])->orderBy('sort_order', 'asc')->get();
        $featuredProducts = $sinodaProducts->where('is_featured', true)->take(6);
        $seo = SeoSetting::getForPage('sinoda');

        return view('frontend.sinoda.index', compact('categories', 'sinodaProducts', 'featuredProducts', 'seo'));
    }
}
