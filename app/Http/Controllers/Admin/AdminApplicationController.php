<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::orderBy('sort_order', 'asc')->get();
        return view('admin.applications.index', compact('applications'));
    }

    public function create()
    {
        return view('admin.applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:applications,slug',
            'subtitle' => 'nullable|string|max:200',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'features_text' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_active'] = $request->boolean('is_active');

        if (!empty($request->features_text)) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", $request->features_text)));
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('applications', 'public');
        }

        Application::create($validated);

        return redirect()->route('admin.applications.index')->with('success', 'Industry application added.');
    }

    public function edit(Application $application)
    {
        return view('admin.applications.edit', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'required|string|max:200|unique:applications,slug,' . $application->id,
            'subtitle' => 'nullable|string|max:200',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'features_text' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (!empty($request->features_text)) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", $request->features_text)));
        } else {
            $validated['features'] = [];
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('applications', 'public');
        }

        $application->update($validated);

        return redirect()->route('admin.applications.index')->with('success', 'Industry application updated.');
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return back()->with('success', 'Application deleted.');
    }
}
