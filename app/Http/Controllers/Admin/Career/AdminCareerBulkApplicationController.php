<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Models\CareerApplicationStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCareerBulkApplicationController extends Controller
{
    /**
     * Handle bulk status changes for selected applications.
     */
    public function status(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:career_applications,id',
            'status' => 'required|in:pending,under_review,shortlisted,interview_scheduled,interviewed,selected,rejected,withdrawn,hired',
            'notes' => 'nullable|string|max:500',
        ]);

        $ids = $validated['ids'];
        $newStatus = $validated['status'];
        $notes = $validated['notes'] ?? "Bulk status changed to {$newStatus}.";
        $adminId = auth()->id();
        $updatedCount = 0;

        DB::beginTransaction();
        try {
            $applications = CareerApplication::whereIn('id', $ids)->get();

            foreach ($applications as $application) {
                if ($application->status !== $newStatus) {
                    $oldStatus = $application->status;
                    $application->status = $newStatus;
                    $application->save();

                    CareerApplicationStatusLog::create([
                        'career_application_id' => $application->id,
                        'old_status' => $oldStatus,
                        'new_status' => $newStatus,
                        'changed_by' => $adminId,
                        'notes' => $notes,
                        'created_at' => now(),
                    ]);

                    $updatedCount++;
                }
            }

            DB::commit();

            $statusLabel = ucwords(str_replace('_', ' ', $newStatus));
            return back()->with('success', "{$updatedCount} applications updated to \"{$statusLabel}\".");

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Bulk status update failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle bulk deletion of selected applications.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|integer|exists:career_applications,id',
        ]);

        $ids = $validated['ids'];
        $deletedCount = CareerApplication::whereIn('id', $ids)->delete();

        return back()->with('success', "{$deletedCount} applications moved to trash.");
    }
}
