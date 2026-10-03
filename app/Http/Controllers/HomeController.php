<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CompanyStatistic;
use App\Models\HomepageSection;
use App\Models\ManufacturingSection;
use App\Models\Product;
use App\Models\QualitySection;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sections = HomepageSection::enabled()->get()->keyBy('section_key');
        $statistics = CompanyStatistic::active()->get();
        $categories = Category::active()->withCount('activeProducts')->get();
        $featuredProducts = Product::featured()->with('category')->orderBy('sort_order', 'asc')->take(8)->get();
        $applications = Application::active()->take(4)->get();
        $manufacturingSteps = ManufacturingSection::active()->take(6)->get();
        $qualitySteps = QualitySection::active()->take(6)->get();
        $latestBlogs = Blog::published()->with('category')->take(3)->get();
        $seo = SeoSetting::getForPage('home');

        return view('frontend.home', compact(
            'sections',
            'statistics',
            'categories',
            'featuredProducts',
            'applications',
            'manufacturingSteps',
            'qualitySteps',
            'latestBlogs',
            'seo'
        ));
    }
}
