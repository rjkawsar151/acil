<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Services\Career\CareerEmailService;
use Illuminate\Http\Request;

class AdminCareerBulkEmailController extends Controller
{
    /**
     * Send bulk personalized interview invitations / notifications.
     */
    public function send(Request $request, CareerEmailService $emailService)
    {
        $validated = $request->validate([
            'application_ids' => 'required|array|min:1',
            'application_ids.*' => 'required|integer|exists:career_applications,id',
            'subject' => 'required|string|max:250',
            'body' => 'required|string',
            'interview_date' => 'nullable|string|max:100',
            'interview_time' => 'nullable|string|max:100',
            'interview_location' => 'nullable|string|max:250',
            'cc' => 'nullable|string|max:500',
            'bcc' => 'nullable|string|max:500',
            'update_status' => 'nullable|boolean',
        ]);

        $ccEmails = [];
        if (!empty($validated['cc'])) {
            $rawCc = preg_split('/[,\s]+/', $validated['cc']);
            foreach ($rawCc as $email) {
                $email = trim($email);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $ccEmails[] = $email;
                }
            }
        }

        $bccEmails = [];
        if (!empty($validated['bcc'])) {
            $rawBcc = preg_split('/[,\s]+/', $validated['bcc']);
            foreach ($rawBcc as $email) {
                $email = trim($email);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $bccEmails[] = $email;
                }
            }
        }

        $extraData = [
            'interview_date' => $validated['interview_date'] ?? null,
            'interview_time' => $validated['interview_time'] ?? null,
            'interview_location' => $validated['interview_location'] ?? null,
        ];

        $updateStatus = $request->boolean('update_status', true);
        $applications = CareerApplication::with('job.department')
            ->whereIn('id', $validated['application_ids'])
            ->get();

        $successCount = 0;
        $failCount = 0;
        $adminId = auth()->id();

        foreach ($applications as $application) {
            $sent = $emailService->sendInterviewEmail(
                $application,
                $validated['subject'],
                $validated['body'],
                $extraData,
                $ccEmails,
                $bccEmails,
                $adminId,
                $updateStatus
            );

            if ($sent) {
                $successCount++;
            } else {
                $failCount++;
            }
        }

        if ($failCount === 0) {
            return back()->with('success', "{$successCount} personalized interview emails dispatched successfully.");
        } else {
            return back()->with('warning', "{$successCount} emails sent successfully, but {$failCount} failed. Please review the email logs.");
        }
    }
}
