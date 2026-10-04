<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Models\CareerApplicationStatusLog;
use App\Models\CareerJob;
use Illuminate\Http\Request;

class AdminCareerApplicationController extends Controller
{
    /**
     * Display a listing of candidate applications.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $jobId = $request->query('job_id');
        $status = $request->query('status');
        $dateFilter = $request->query('date_filter');

        $query = CareerApplication::with(['job.department', 'answers']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        if ($jobId && $jobId !== 'all') {
            $query->where('career_job_id', $jobId);
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($dateFilter) {
            match ($dateFilter) {
                'today' => $query->whereDate('applied_at', now()->toDateString()),
                'this_week' => $query->whereBetween('applied_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'this_month' => $query->whereBetween('applied_at', [now()->startOfMonth(), now()->endOfMonth()]),
                default => null,
            };
        }

        $applications = $query->latest('applied_at')->paginate(20)->withQueryString();
        $jobs = CareerJob::orderBy('title')->get();

        // Metrics Summary
        $stats = [
            'total' => CareerApplication::count(),
            'pending' => CareerApplication::where('status', 'pending')->count(),
            'under_review' => CareerApplication::where('status', 'under_review')->count(),
            'shortlisted' => CareerApplication::where('status', 'shortlisted')->count(),
            'interview_scheduled' => CareerApplication::where('status', 'interview_scheduled')->count(),
            'selected' => CareerApplication::where('status', 'selected')->count(),
            'rejected' => CareerApplication::where('status', 'rejected')->count(),
            'hired' => CareerApplication::where('status', 'hired')->count(),
        ];

        return view('admin.careers.applications.index', compact(
            'applications',
            'jobs',
            'search',
            'jobId',
            'status',
            'dateFilter',
            'stats'
        ));
    }

    /**
     * Display candidate application details.
     */
    public function show(CareerApplication $application)
    {
        $application->load([
            'job.department',
            'answers.question',
            'statusLogs.causer',
            'emailLogs.sender',
        ]);

        return view('admin.careers.applications.show', compact('application'));
    }

    /**
     * Update application status with audit log.
     */
    public function updateStatus(Request $request, CareerApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,shortlisted,interview_scheduled,interviewed,selected,rejected,withdrawn,hired',
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $application->status;
        $newStatus = $validated['status'];

        if ($oldStatus !== $newStatus) {
            $application->status = $newStatus;
            $application->save();

            CareerApplicationStatusLog::create([
                'career_application_id' => $application->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => auth()->id(),
                'notes' => $validated['notes'] ?? 'Status updated from admin panel.',
                'created_at' => now(),
            ]);

            return back()->with('success', "Status updated to " . $application->status_label . ".");
        }

        return back()->with('info', "Status remained unchanged.");
    }

    /**
     * Update internal HR notes for candidate.
     */
    public function updateNotes(Request $request, CareerApplication $application)
    {
        $validated = $request->validate([
            'internal_notes' => 'nullable|string|max:2000',
        ]);

        $application->update($validated);

        return back()->with('success', 'Internal HR notes saved.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CareerApplication $application)
    {
        $ref = $application->reference;
        $application->delete();

        return redirect()->route('admin.careers.applications.index')
            ->with('success', "Application {$ref} moved to trash.");
    }
}
