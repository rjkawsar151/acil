<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManufacturingSection;
use Illuminate\Http\Request;

class AdminManufacturingController extends Controller
{
    public function index()
    {
        $steps = ManufacturingSection::orderBy('step_number', 'asc')->get();
        return view('admin.manufacturing.index', compact('steps'));
    }

    public function create()
    {
        return view('admin.manufacturing.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'step_number' => 'required|integer|min:1',
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:200',
            'description' => 'required|string',
            'details_text' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (!empty($request->details_text)) {
            $validated['details'] = array_filter(array_map('trim', explode("\n", $request->details_text)));
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('manufacturing', 'public');
        }

        ManufacturingSection::create($validated);

        return redirect()->route('admin.manufacturing.index')->with('success', 'Manufacturing step created.');
    }

    public function edit(ManufacturingSection $manufacturing)
    {
        return view('admin.manufacturing.edit', ['step' => $manufacturing]);
    }

    public function update(Request $request, ManufacturingSection $manufacturing)
    {
        $validated = $request->validate([
            'step_number' => 'required|integer|min:1',
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:200',
            'description' => 'required|string',
            'details_text' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (!empty($request->details_text)) {
            $validated['details'] = array_filter(array_map('trim', explode("\n", $request->details_text)));
        } else {
            $validated['details'] = [];
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('manufacturing', 'public');
        }

        $manufacturing->update($validated);

        return redirect()->route('admin.manufacturing.index')->with('success', 'Manufacturing step updated.');
    }

    public function destroy(ManufacturingSection $manufacturing)
    {
        $manufacturing->delete();
        return back()->with('success', 'Manufacturing step deleted.');
    }
}
