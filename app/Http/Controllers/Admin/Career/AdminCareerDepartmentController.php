<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Models\CareerDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCareerDepartmentController extends Controller
{
    /**
     * Display departments listing.
     */
    public function index()
    {
        $departments = CareerDepartment::withCount('jobs')->orderBy('sort_order')->get();
        return view('admin.careers.departments.index', compact('departments'));
    }

    /**
     * Store a newly created department.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:career_departments,name',
            'slug' => 'nullable|string|max:150|unique:career_departments,slug',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        CareerDepartment::create($validated);

        return back()->with('success', 'Department created successfully.');
    }

    /**
     * Update department.
     */
    public function update(Request $request, CareerDepartment $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:career_departments,name,' . $department->id,
            'slug' => 'required|string|max:150|unique:career_departments,slug,' . $department->id,
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $department->update($validated);

        return back()->with('success', 'Department updated successfully.');
    }

    /**
     * Remove department.
     */
    public function destroy(CareerDepartment $department)
    {
        if ($department->jobs()->count() > 0) {
            return back()->with('error', 'Cannot delete department with active job postings. Reassign jobs first.');
        }

        $department->delete();
        return back()->with('success', 'Department deleted successfully.');
    }
}
