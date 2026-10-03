<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QualitySection;
use Illuminate\Http\Request;

class AdminQualityController extends Controller
{
    public function index()
    {
        $steps = QualitySection::orderBy('step_number', 'asc')->get();
        return view('admin.quality.index', compact('steps'));
    }

    public function create()
    {
        return view('admin.quality.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'step_number' => 'required|integer|min:1',
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:200',
            'description' => 'required|string',
            'standards_text' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (!empty($request->standards_text)) {
            $validated['standards'] = array_filter(array_map('trim', explode("\n", $request->standards_text)));
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('quality', 'public');
        }

        QualitySection::create($validated);

        return redirect()->route('admin.quality.index')->with('success', 'Quality assurance step created.');
    }

    public function edit(QualitySection $quality)
    {
        return view('admin.quality.edit', ['step' => $quality]);
    }

    public function update(Request $request, QualitySection $quality)
    {
        $validated = $request->validate([
            'step_number' => 'required|integer|min:1',
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:200',
            'description' => 'required|string',
            'standards_text' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (!empty($request->standards_text)) {
            $validated['standards'] = array_filter(array_map('trim', explode("\n", $request->standards_text)));
        } else {
            $validated['standards'] = [];
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('quality', 'public');
        }

        $quality->update($validated);

        return redirect()->route('admin.quality.index')->with('success', 'Quality assurance step updated.');
    }

    public function destroy(QualitySection $quality)
    {
        $quality->delete();
        return back()->with('success', 'Quality assurance step deleted.');
    }
}
