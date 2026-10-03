<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CompanyStatistic;
use App\Models\ManufacturingSection;
use App\Models\Page;
use App\Models\QualitySection;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', 'about')->first();
        $stats = CompanyStatistic::active()->get();
        $seo = SeoSetting::getForPage('about');

        return view('frontend.pages.about', compact('page', 'stats', 'seo'));
    }

    public function manufacturing()
    {
        $page = Page::where('slug', 'manufacturing')->first();
        $steps = ManufacturingSection::active()->get();
        $seo = SeoSetting::getForPage('manufacturing');

        return view('frontend.pages.manufacturing', compact('page', 'steps', 'seo'));
    }

    public function quality()
    {
        $page = Page::where('slug', 'quality')->first();
        $steps = QualitySection::active()->get();
        $seo = SeoSetting::getForPage('quality');

        return view('frontend.pages.quality', compact('page', 'steps', 'seo'));
    }

    public function rd()
    {
        $page = Page::where('slug', 'rd')->first();
        $seo = SeoSetting::getForPage('rd') ?? SeoSetting::getForPage('about');

        return view('frontend.pages.rd', compact('page', 'seo'));
    }

    public function sustainability()
    {
        $page = Page::where('slug', 'sustainability')->first();
        $seo = SeoSetting::getForPage('sustainability');

        return view('frontend.pages.sustainability', compact('page', 'seo'));
    }

    public function adonisGroup()
    {
        $page = Page::where('slug', 'adonis-group')->first();
        $seo = SeoSetting::getForPage('about');

        return view('frontend.pages.adonis-group', compact('page', 'seo'));
    }

    public function applications()
    {
        $applications = Application::active()->get();
        $seo = SeoSetting::getForPage('home');

        return view('frontend.pages.applications', compact('applications', 'seo'));
    }

    public function catalogue()
    {
        $seo = SeoSetting::getForPage('catalogue') ?? SeoSetting::getForPage('home');
        return view('frontend.catalogue', compact('seo'));
    }

    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->published()->firstOrFail();
        return view('frontend.pages.show', compact('page'));
    }
}
