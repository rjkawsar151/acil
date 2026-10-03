<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:pages,slug',
            'subtitle' => 'nullable|string|max:200',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'template' => 'required|string|max:50',
            'status' => 'required|in:published,draft',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('pages', 'public');
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:pages,slug,' . $page->id,
            'subtitle' => 'nullable|string|max:200',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'template' => 'required|string|max:50',
            'status' => 'required|in:published,draft',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('pages', 'public');
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Page deleted.');
    }
}
