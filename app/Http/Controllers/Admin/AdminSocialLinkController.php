<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class AdminSocialLinkController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::orderBy('sort_order', 'asc')->get();
        return view('admin.social_links.index', compact('socialLinks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:50',
            'icon' => 'required|string|max:50',
            'url' => 'required|url|max:250',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        SocialLink::create($validated);

        return back()->with('success', 'Social media link added.');
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:50',
            'icon' => 'required|string|max:50',
            'url' => 'required|url|max:250',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $socialLink->update($validated);

        return back()->with('success', 'Social media link updated.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();
        return back()->with('success', 'Social link deleted.');
    }
}
