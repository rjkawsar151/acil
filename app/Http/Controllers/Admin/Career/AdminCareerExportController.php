<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Services\Career\CareerExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminCareerExportController extends Controller
{
    protected CareerExportService $exportService;

    public function __construct(CareerExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Download candidate CV documents bundled in a ZIP archive.
     */
    public function downloadCvZip(Request $request)
    {
        $scope = $request->input('scope', 'all');
        $forcedStatus = in_array($scope, ['pending', 'under_review', 'shortlisted', 'interview_scheduled', 'selected', 'hired', 'rejected']) 
            ? $scope 
            : null;

        $applications = $this->exportService->resolveApplications($request, $forcedStatus);

        if ($applications->isEmpty()) {
            return back()->with('warning', 'No candidate applications found for the selected export criteria.');
        }

        $scopeLabel = $this->resolveScopeLabel($request, $scope, $applications->count());

        try {
            $zipResult = $this->exportService->buildCvZip($applications, $scopeLabel);

            if ($zipResult['count'] === 0) {
                if (File::exists($zipResult['zip_path'])) {
                    File::delete($zipResult['zip_path']);
                }
                return back()->with('warning', 'None of the selected candidates have an uploaded CV document on server storage.');
            }

            return response()->download(
                $zipResult['zip_path'],
                $zipResult['filename'],
                [
                    'Content-Type' => 'application/zip',
                    'Content-Length' => filesize($zipResult['zip_path']),
                ]
            )->deleteFileAfterSend(true);

        } catch (\Throwable $e) {
            return back()->with('error', 'CV ZIP export failed: ' . $e->getMessage());
        }
    }

    /**
     * Download formatted A4-friendly XLS spreadsheet of applicants.
     */
    public function downloadXls(Request $request)
    {
        $scope = $request->input('scope', 'all');
        $forcedStatus = in_array($scope, ['pending', 'under_review', 'shortlisted', 'interview_scheduled', 'selected', 'hired', 'rejected']) 
            ? $scope 
            : null;

        $applications = $this->exportService->resolveApplications($request, $forcedStatus);

        if ($applications->isEmpty()) {
            return back()->with('warning', 'No candidate records found matching the export filter.');
        }

        $scopeLabel = $this->resolveScopeLabel($request, $scope, $applications->count());
        $htmlContent = $this->exportService->generateA4XlsHtml($applications, $scopeLabel);

        $cleanScope = Str::slug($scope, '_');
        $timestamp = date('Ymd_His');
        $filename = "ACIL_Candidates_Registry_{$cleanScope}_{$timestamp}.xls";

        return response($htmlContent, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Helper to humanize export scope label for report headers.
     */
    protected function resolveScopeLabel(Request $request, string $scope, int $count): string
    {
        if ($request->filled('ids')) {
            return "Selected {$count} Candidates";
        }

        if ($scope === 'all') {
            $parts = ['All Applications'];
            if ($request->filled('job_id') && $request->input('job_id') !== 'all') {
                $job = \App\Models\CareerJob::find($request->input('job_id'));
                if ($job) {
                    $parts[] = "Position: {$job->title}";
                }
            }
            if ($request->filled('search')) {
                $parts[] = "Search: \"{$request->input('search')}\"";
            }
            if ($request->filled('date_filter')) {
                $parts[] = "Date: " . ucfirst(str_replace('_', ' ', $request->input('date_filter')));
            }
            return implode(' — ', $parts);
        }

        return ucwords(str_replace('_', ' ', $scope)) . " Candidates";
    }
}
