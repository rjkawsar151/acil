<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Models\CareerDepartment;
use App\Models\CareerJob;
use App\Models\CareerJobQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminCareerJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $departmentId = $request->query('department_id');

        $query = CareerJob::with('department')
            ->withCount([
                'applications',
                'applications as pending_applications_count' => fn($q) => $q->where('status', 'pending'),
                'applications as shortlisted_applications_count' => fn($q) => $q->where('status', 'shortlisted'),
            ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('department_name', 'like', "%{$search}%");
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($departmentId && $departmentId !== 'all') {
            $query->where('department_id', $departmentId);
        }

        $jobs = $query->latest('id')->paginate(15)->withQueryString();
        $departments = CareerDepartment::orderBy('name')->get();

        // Metrics
        $stats = [
            'total' => CareerJob::count(),
            'published' => CareerJob::where('status', 'published')->count(),
            'draft' => CareerJob::where('status', 'draft')->count(),
            'closed' => CareerJob::where('status', 'closed')->count(),
            'total_applications' => CareerApplication::count(),
        ];

        return view('admin.careers.jobs.index', compact('jobs', 'departments', 'search', 'status', 'departmentId', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = CareerDepartment::orderBy('name')->get();
        return view('admin.careers.jobs.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:250',
            'slug' => 'nullable|string|max:250|unique:career_jobs,slug',
            'department_id' => 'nullable|exists:career_departments,id',
            'department_name' => 'nullable|string|max:150',
            'location' => 'required|string|max:250',
            'workplace_type' => 'required|in:on_site,remote,hybrid',
            'employment_type' => 'required|in:full_time,part_time,contractual,internship',
            'vacancies' => 'required|integer|min:1|max:100',
            'salary_type' => 'required|in:fixed,range,negotiable,hidden',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'show_salary' => 'nullable|boolean',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'education_requirements' => 'nullable|string',
            'experience_requirements' => 'nullable|string',
            'additional_requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'status' => 'required|in:draft,published,closed,archived',
            'allow_applications' => 'nullable|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'cover_image_url' => 'nullable|url|max:500',
            // Dynamic custom questions
            'questions' => 'nullable|array',
            'questions.*.question' => 'required_with:questions|string|max:500',
            'questions.*.type' => 'required_with:questions|in:text,textarea,number,email,phone,date,yes_no,radio,select,checkbox,multi_checkbox',
            'questions.*.options' => 'nullable|string',
            'questions.*.is_required' => 'nullable|boolean',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['show_salary'] = $request->boolean('show_salary', true);
        $validated['allow_applications'] = $request->boolean('allow_applications', true);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('careers/covers', 'public');
            $validated['cover_image'] = $path;
            
            $source = storage_path('app/public/' . $path);
            $target = public_path('storage/' . $path);
            $targetDir = dirname($target);
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
            if (file_exists($source) && !is_link($target)) {
                @copy($source, $target);
            }
        } elseif ($request->filled('cover_image_url')) {
            $validated['cover_image'] = $request->input('cover_image_url');
        }
        unset($validated['cover_image_url']);

        if (empty($validated['slug'])) {
            $validated['slug'] = CareerJob::generateUniqueSlug($validated['title']);
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if (!empty($validated['department_id'])) {
            $dept = CareerDepartment::find($validated['department_id']);
            if ($dept) {
                $validated['department_name'] = $dept->name;
            }
        }

        DB::beginTransaction();
        try {
            $job = CareerJob::create($validated);

            // Process Custom Questions
            if ($request->has('questions') && is_array($request->questions)) {
                $sort = 1;
                foreach ($request->questions as $qData) {
                    if (empty($qData['question'])) {
                        continue;
                    }

                    $options = null;
                    if (!empty($qData['options'])) {
                        $options = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $qData['options'])))));
                    }

                    CareerJobQuestion::create([
                        'career_job_id' => $job->id,
                        'question' => trim($qData['question']),
                        'type' => $qData['type'] ?? 'text',
                        'options' => $options,
                        'is_required' => isset($qData['is_required']) && $qData['is_required'] == '1',
                        'sort_order' => $sort++,
                        'is_active' => true,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.careers.jobs.index')
                ->with('success', "Job position \"{$job->title}\" created successfully.");

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create job position: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CareerJob $job)
    {
        $job->load(['department', 'questions']);
        $departments = CareerDepartment::orderBy('name')->get();

        return view('admin.careers.jobs.edit', compact('job', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CareerJob $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:250',
            'slug' => 'required|string|max:250|unique:career_jobs,slug,' . $job->id,
            'department_id' => 'nullable|exists:career_departments,id',
            'department_name' => 'nullable|string|max:150',
            'location' => 'required|string|max:250',
            'workplace_type' => 'required|in:on_site,remote,hybrid',
            'employment_type' => 'required|in:full_time,part_time,contractual,internship',
            'vacancies' => 'required|integer|min:1|max:100',
            'salary_type' => 'required|in:fixed,range,negotiable,hidden',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'show_salary' => 'nullable|boolean',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'education_requirements' => 'nullable|string',
            'experience_requirements' => 'nullable|string',
            'additional_requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'status' => 'required|in:draft,published,closed,archived',
            'allow_applications' => 'nullable|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'cover_image_url' => 'nullable|url|max:500',
            // Dynamic custom questions
            'questions' => 'nullable|array',
            'questions.*.id' => 'nullable|integer',
            'questions.*.question' => 'required_with:questions|string|max:500',
            'questions.*.type' => 'required_with:questions|in:text,textarea,number,email,phone,date,yes_no,radio,select,checkbox,multi_checkbox',
            'questions.*.options' => 'nullable|string',
            'questions.*.is_required' => 'nullable|boolean',
        ]);

        $validated['updated_by'] = auth()->id();
        $validated['show_salary'] = $request->boolean('show_salary', true);
        $validated['allow_applications'] = $request->boolean('allow_applications', true);

        if ($request->hasFile('cover_image')) {
            if ($job->cover_image && !str_starts_with($job->cover_image, 'http')) {
                Storage::disk('public')->delete($job->cover_image);
            }
            $path = $request->file('cover_image')->store('careers/covers', 'public');
            $validated['cover_image'] = $path;
            
            $source = storage_path('app/public/' . $path);
            $target = public_path('storage/' . $path);
            $targetDir = dirname($target);
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
            if (file_exists($source) && !is_link($target)) {
                @copy($source, $target);
            }
        } elseif ($request->filled('cover_image_url')) {
            $validated['cover_image'] = $request->input('cover_image_url');
        }
        unset($validated['cover_image_url']);

        if ($validated['status'] === 'published' && empty($job->published_at)) {
            $validated['published_at'] = now();
        }

        if (!empty($validated['department_id'])) {
            $dept = CareerDepartment::find($validated['department_id']);
            if ($dept) {
                $validated['department_name'] = $dept->name;
            }
        }

        DB::beginTransaction();
        try {
            $job->update($validated);

            // Sync Custom Questions
            $submittedQuestionIds = [];
            if ($request->has('questions') && is_array($request->questions)) {
                $sort = 1;
                foreach ($request->questions as $qData) {
                    if (empty($qData['question'])) {
                        continue;
                    }

                    $options = null;
                    if (!empty($qData['options'])) {
                        $options = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $qData['options'])))));
                    }

                    $questionId = $qData['id'] ?? null;
                    $isReq = isset($qData['is_required']) && ($qData['is_required'] == '1' || $qData['is_required'] === true);

                    if ($questionId) {
                        $existingQ = CareerJobQuestion::where('career_job_id', $job->id)->where('id', $questionId)->first();
                        if ($existingQ) {
                            $existingQ->update([
                                'question' => trim($qData['question']),
                                'type' => $qData['type'] ?? 'text',
                                'options' => $options,
                                'is_required' => $isReq,
                                'sort_order' => $sort++,
                            ]);
                            $submittedQuestionIds[] = $existingQ->id;
                            continue;
                        }
                    }

                    // Create new question
                    $newQ = CareerJobQuestion::create([
                        'career_job_id' => $job->id,
                        'question' => trim($qData['question']),
                        'type' => $qData['type'] ?? 'text',
                        'options' => $options,
                        'is_required' => $isReq,
                        'sort_order' => $sort++,
                        'is_active' => true,
                    ]);
                    $submittedQuestionIds[] = $newQ->id;
                }
            }

            // Remove questions that were deleted in the UI
            CareerJobQuestion::where('career_job_id', $job->id)
                ->whereNotIn('id', $submittedQuestionIds)
                ->delete();

            DB::commit();

            return redirect()->route('admin.careers.jobs.index')
                ->with('success', "Job position \"{$job->title}\" updated successfully.");

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update job position: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Duplicate a job post.
     */
    public function duplicate(CareerJob $job)
    {
        DB::beginTransaction();
        try {
            $newJob = $job->replicate(['created_at', 'updated_at', 'deleted_at']);
            $newJob->title = $job->title . ' (Copy)';
            $newJob->slug = CareerJob::generateUniqueSlug($newJob->title);
            $newJob->status = 'draft';
            $newJob->published_at = null;
            $newJob->created_by = auth()->id();
            $newJob->save();

            // Clone questions
            foreach ($job->questions as $q) {
                $newQ = $q->replicate(['created_at', 'updated_at']);
                $newQ->career_job_id = $newJob->id;
                $newQ->save();
            }

            DB::commit();

            return redirect()->route('admin.careers.jobs.edit', $newJob->id)
                ->with('success', "Job position duplicated as Draft. You can now edit and publish it.");

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to duplicate job: ' . $e->getMessage());
        }
    }

    /**
     * Toggle Job Status (published / draft).
     */
    public function toggleStatus(CareerJob $job)
    {
        $newStatus = $job->status === 'published' ? 'draft' : 'published';
        $job->status = $newStatus;
        if ($newStatus === 'published' && empty($job->published_at)) {
            $job->published_at = now();
        }
        $job->save();

        return back()->with('success', "Job status changed to " . ucfirst($newStatus) . ".");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CareerJob $job)
    {
        $title = $job->title;
        if ($job->cover_image && !str_starts_with($job->cover_image, 'http')) {
            Storage::disk('public')->delete($job->cover_image);
        }
        $job->delete();

        return redirect()->route('admin.careers.jobs.index')
            ->with('success', "Job position \"{$title}\" has been moved to trash.");
    }
}
