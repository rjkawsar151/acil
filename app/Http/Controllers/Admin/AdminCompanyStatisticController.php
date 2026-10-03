<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyStatistic;
use Illuminate\Http\Request;

class AdminCompanyStatisticController extends Controller
{
    public function index()
    {
        $statistics = CompanyStatistic::orderBy('sort_order', 'asc')->get();
        return view('admin.statistics.index', compact('statistics'));
    }

    public function create()
    {
        return view('admin.statistics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'value' => 'required|string|max:50',
            'suffix' => 'nullable|string|max:20',
            'prefix' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        CompanyStatistic::create($validated);

        return redirect()->route('admin.statistics.index')->with('success', 'Statistic added successfully.');
    }

    public function edit(CompanyStatistic $statistic)
    {
        return view('admin.statistics.edit', compact('statistic'));
    }

    public function update(Request $request, CompanyStatistic $statistic)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'value' => 'required|string|max:50',
            'suffix' => 'nullable|string|max:20',
            'prefix' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $statistic->update($validated);

        return redirect()->route('admin.statistics.index')->with('success', 'Statistic updated successfully.');
    }

    public function destroy(CompanyStatistic $statistic)
    {
        $statistic->delete();
        return back()->with('success', 'Statistic deleted.');
    }
}
