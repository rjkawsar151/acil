<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class AdminHomepageController extends Controller
{
    public function index()
    {
        $sections = HomepageSection::orderBy('sort_order', 'asc')->get();
        return view('admin.homepage.index', compact('sections'));
    }

    public function edit(HomepageSection $homepage)
    {
        return view('admin.homepage.edit', ['section' => $homepage]);
    }

    public function update(Request $request, HomepageSection $homepage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:250',
            'subtitle' => 'nullable|string|max:250',
            'badge_text' => 'nullable|string|max:100',
            'content' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:250',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:250',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'is_enabled' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_enabled'] = $request->boolean('is_enabled');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('homepage', 'public');
            $validated['image'] = $path;
            
            $source = storage_path('app/public/' . $path);
            $target = public_path('storage/' . $path);
            $targetDir = dirname($target);
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
            if (file_exists($source) && !is_link($target)) {
                @copy($source, $target);
            }
        }

        $homepage->update($validated);

        return redirect()->route('admin.homepage.index')->with('success', "Homepage section '{$homepage->section_key}' updated successfully.");
    }

    public function toggle(HomepageSection $homepage)
    {
        $homepage->is_enabled = !$homepage->is_enabled;
        $homepage->save();

        return response()->json(['success' => true, 'is_enabled' => $homepage->is_enabled]);
    }
}
