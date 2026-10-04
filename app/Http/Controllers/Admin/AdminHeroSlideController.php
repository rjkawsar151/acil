<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order', 'asc')->get();
        return view('admin.hero_slides.index', compact('slides'));
    }

    public function create()
    {
        $nextOrder = (HeroSlide::max('sort_order') ?? 0) + 1;
        return view('admin.hero_slides.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'badge_text' => 'nullable|string|max:100',
            'badge_icon' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:30',
            'badge_subtext' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'button_icon' => 'nullable|string|max:50',
            'button_style' => 'nullable|string|max:30',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:255',
            'secondary_button_icon' => 'nullable|string|max:50',
            'secondary_button_style' => 'nullable|string|max:30',
            'tertiary_button_text' => 'nullable|string|max:100',
            'tertiary_button_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_url' => 'nullable|url|max:500',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hero_slides', 'public');
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
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        unset($validated['image_url']);

        HeroSlide::create($validated);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide created successfully.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero_slides.edit', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'badge_text' => 'nullable|string|max:100',
            'badge_icon' => 'nullable|string|max:50',
            'badge_color' => 'nullable|string|max:30',
            'badge_subtext' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'button_icon' => 'nullable|string|max:50',
            'button_style' => 'nullable|string|max:30',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:255',
            'secondary_button_icon' => 'nullable|string|max:50',
            'secondary_button_style' => 'nullable|string|max:30',
            'tertiary_button_text' => 'nullable|string|max:100',
            'tertiary_button_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_url' => 'nullable|url|max:500',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            // Delete old file if local
            if ($heroSlide->image && !str_starts_with($heroSlide->image, 'http')) {
                Storage::disk('public')->delete($heroSlide->image);
            }
            $path = $request->file('image')->store('hero_slides', 'public');
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
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        unset($validated['image_url']);

        $heroSlide->update($validated);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image && !str_starts_with($heroSlide->image, 'http')) {
            Storage::disk('public')->delete($heroSlide->image);
        }

        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide deleted successfully.');
    }

    public function toggle(HeroSlide $heroSlide)
    {
        $heroSlide->is_active = !$heroSlide->is_active;
        $heroSlide->save();

        return response()->json([
            'success' => true,
            'is_active' => $heroSlide->is_active
        ]);
    }
}
