<?php

namespace App\Services\Career;

use App\Mail\CareerApplicationConfirmationMail;
use App\Mail\CareerInterviewInvitationMail;
use App\Models\CareerApplication;
use App\Models\CareerApplicationStatusLog;
use App\Models\CareerEmailLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CareerEmailService
{
    /**
     * Replace dynamic placeholders with candidate and job specific details.
     */
    public function replacePlaceholders(string $template, CareerApplication $application, array $extraData = []): string
    {
        $job = $application->job;
        $companyName = Setting::get('site_name', 'Adonis Chemical Industries Ltd.');

        $placeholders = [
            '{{ applicant_name }}' => $application->name,
            '{{ applicant_email }}' => $application->email,
            '{{ applicant_phone }}' => $application->phone,
            '{{ application_reference }}' => $application->reference,
            '{{ position_name }}' => $job ? $job->title : 'Applied Position',
            '{{ department }}' => $job ? $job->effective_department_name : 'N/A',
            '{{ job_location }}' => $job ? $job->location : 'Savar, Dhaka',
            '{{ interview_date }}' => $extraData['interview_date'] ?? 'To be scheduled',
            '{{ interview_time }}' => $extraData['interview_time'] ?? '',
            '{{ interview_location }}' => $extraData['interview_location'] ?? 'Plant: Genda, Karnapara, Savar, Dhaka',
            '{{ company_name }}' => $companyName,
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $template);
    }

    /**
     * Send application confirmation email.
     */
    public function sendConfirmationEmail(CareerApplication $application): bool
    {
        try {
            $mailable = new CareerApplicationConfirmationMail($application);
            Mail::to($application->email)->send($mailable);

            CareerEmailLog::create([
                'career_application_id' => $application->id,
                'career_job_id' => $application->career_job_id,
                'email_type' => 'application_confirmation',
                'recipient_email' => $application->email,
                'cc' => null,
                'bcc' => null,
                'subject' => "Application Received — " . ($application->job->title ?? 'Position') . " [Ref: {$application->reference}]",
                'body' => "Application confirmation notice sent to candidate.",
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::error('Career confirmation email failed: ' . $e->getMessage(), [
                'application_id' => $application->id,
                'email' => $application->email,
            ]);

            CareerEmailLog::create([
                'career_application_id' => $application->id,
                'career_job_id' => $application->career_job_id,
                'email_type' => 'application_confirmation',
                'recipient_email' => $application->email,
                'cc' => null,
                'bcc' => null,
                'subject' => "Application Received — " . ($application->job->title ?? 'Position'),
                'body' => "Application confirmation notice (failed)",
                'status' => 'failed',
                'failure_reason' => $e->getMessage(),
                'sent_at' => null,
            ]);

            return false;
        }
    }

    /**
     * Send personalized interview email to an individual candidate.
     */
    public function sendInterviewEmail(
        CareerApplication $application,
        string $subjectTemplate,
        string $bodyTemplate,
        array $extraData = [],
        array $ccEmails = [],
        array $bccEmails = [],
        ?int $sentById = null,
        bool $updateStatusToInterviewScheduled = true
    ): bool {
        $personalizedSubject = $this->replacePlaceholders($subjectTemplate, $application, $extraData);
        $personalizedBody = $this->replacePlaceholders($bodyTemplate, $application, $extraData);

        try {
            $mailable = new CareerInterviewInvitationMail(
                $application,
                $personalizedSubject,
                $personalizedBody,
                $extraData['interview_date'] ?? null,
                $extraData['interview_time'] ?? null,
                $extraData['interview_location'] ?? null
            );

            if (!empty($ccEmails)) {
                $mailable->cc($ccEmails);
            }

            if (!empty($bccEmails)) {
                $mailable->bcc($bccEmails);
            }

            Mail::to($application->email)->send($mailable);

            // Log email
            CareerEmailLog::create([
                'career_application_id' => $application->id,
                'career_job_id' => $application->career_job_id,
                'email_type' => 'interview_invitation',
                'recipient_email' => $application->email,
                'cc' => !empty($ccEmails) ? array_values($ccEmails) : null,
                'bcc' => !empty($bccEmails) ? array_values($bccEmails) : null,
                'subject' => $personalizedSubject,
                'body' => $personalizedBody,
                'status' => 'sent',
                'sent_by' => $sentById,
                'sent_at' => now(),
            ]);

            // If configured, update status to interview_scheduled
            if ($updateStatusToInterviewScheduled && $application->status !== 'interview_scheduled') {
                $oldStatus = $application->status;
                $application->status = 'interview_scheduled';
                $application->save();

                CareerApplicationStatusLog::create([
                    'career_application_id' => $application->id,
                    'old_status' => $oldStatus,
                    'new_status' => 'interview_scheduled',
                    'changed_by' => $sentById,
                    'notes' => 'Interview email invitation sent.',
                    'created_at' => now(),
                ]);
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('Career interview email failed: ' . $e->getMessage(), [
                'application_id' => $application->id,
                'email' => $application->email,
            ]);

            CareerEmailLog::create([
                'career_application_id' => $application->id,
                'career_job_id' => $application->career_job_id,
                'email_type' => 'interview_invitation',
                'recipient_email' => $application->email,
                'cc' => !empty($ccEmails) ? array_values($ccEmails) : null,
                'bcc' => !empty($bccEmails) ? array_values($bccEmails) : null,
                'subject' => $personalizedSubject,
                'body' => $personalizedBody,
                'status' => 'failed',
                'failure_reason' => $e->getMessage(),
                'sent_by' => $sentById,
                'sent_at' => null,
            ]);

            return false;
        }
    }
}
