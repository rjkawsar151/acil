<?php

namespace App\Http\Controllers;

use App\Models\CareerApplication;
use App\Models\CareerDepartment;
use App\Models\CareerJob;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Public Career Listing Page.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $departmentSlug = $request->query('department');
        $employmentType = $request->query('type');
        $workplaceType = $request->query('workplace');

        $query = CareerJob::with('department')
            ->published()
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now()->toDateString());
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($departmentSlug && $departmentSlug !== 'all') {
            $query->where(function ($q) use ($departmentSlug) {
                $q->whereHas('department', function ($dq) use ($departmentSlug) {
                    $dq->where('slug', $departmentSlug);
                })->orWhere('department_name', 'like', "%{$departmentSlug}%");
            });
        }

        if ($employmentType && $employmentType !== 'all') {
            $query->where('employment_type', $employmentType);
        }

        if ($workplaceType && $workplaceType !== 'all') {
            $query->where('workplace_type', $workplaceType);
        }

        $jobs = $query->latest('published_at')->paginate(12)->withQueryString();
        $departments = CareerDepartment::active()->get();
        $totalOpenings = CareerJob::published()
            ->where(function ($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now()->toDateString());
            })->count();

        return view('frontend.careers.index', compact(
            'jobs',
            'departments',
            'search',
            'departmentSlug',
            'employmentType',
            'workplaceType',
            'totalOpenings'
        ));
    }

    /**
     * Public Job Details Page with Application Form.
     */
    public function show(string $slug)
    {
        $job = CareerJob::with(['department', 'activeQuestions'])
            ->where('slug', $slug)
            ->firstOrFail();

        // If draft or archived, only allow if admin preview
        if ($job->status === 'draft' || $job->status === 'archived') {
            if (!auth()->check() || !auth()->user()->isAdmin()) {
                abort(404);
            }
        }

        $relatedJobs = CareerJob::published()
            ->where('id', '!=', $job->id)
            ->where(function ($q) use ($job) {
                if ($job->department_id) {
                    $q->where('department_id', $job->department_id);
                }
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.careers.show', compact('job', 'relatedJobs'));
    }

    /**
     * Application Submission Success Screen.
     */
    public function success(string $reference)
    {
        $application = CareerApplication::with('job.department')
            ->where('reference', $reference)
            ->firstOrFail();

        return view('frontend.careers.success', compact('application'));
    }
}
