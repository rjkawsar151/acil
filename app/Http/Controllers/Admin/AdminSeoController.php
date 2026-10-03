<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class AdminSeoController extends Controller
{
    public function index()
    {
        $seoSettings = SeoSetting::all();
        return view('admin.seo.index', compact('seoSettings'));
    }

    public function edit(SeoSetting $seo)
    {
        return view('admin.seo.edit', compact('seo'));
    }

    public function update(Request $request, SeoSetting $seo)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|url|max:250',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'schema_markup' => 'nullable|string',
        ]);

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $seo->update($validated);

        return redirect()->route('admin.seo.index')->with('success', "SEO settings for '{$seo->page_name}' updated.");
    }
}
