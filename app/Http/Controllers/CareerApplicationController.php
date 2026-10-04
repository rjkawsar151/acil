<?php

namespace App\Http\Controllers;

use App\Models\CareerApplication;
use App\Models\CareerApplicationAnswer;
use App\Models\CareerApplicationStatusLog;
use App\Models\CareerJob;
use App\Services\Career\CareerCvService;
use App\Services\Career\CareerEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CareerApplicationController extends Controller
{
    /**
     * Store candidate application.
     */
    public function store(
        Request $request,
        string $slug,
        CareerCvService $cvService,
        CareerEmailService $emailService
    ) {
        $job = CareerJob::with('activeQuestions')
            ->where('slug', $slug)
            ->firstOrFail();

        // 1. Availability Checks
        if (!$job->is_accepting_applications) {
            return back()->with('error', 'Applications for this position are currently closed.')->withInput();
        }

        // 2. Honeypot check for bots
        if ($request->filled('career_bot_check')) {
            Log::warning('Honeypot bot attempt caught on career application: ' . $request->ip());
            return back()->with('error', 'Invalid submission detected.')->withInput();
        }

        // 3. Base Validation Rules
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'cv' => [
                'required',
                'file',
                'max:5120', // 5 MB max
                'mimes:pdf,doc,docx,jpg,jpeg,png',
            ],
            'answers' => ['nullable', 'array'],
        ];

        // 4. Dynamic Validation Rules for Custom Questions
        foreach ($job->activeQuestions as $question) {
            $fieldKey = "answers.{$question->id}";
            $fieldRules = [];

            if ($question->is_required) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            switch ($question->type) {
                case 'number':
                    $fieldRules[] = 'numeric';
                    break;
                case 'email':
                    $fieldRules[] = 'email';
                    break;
                case 'date':
                    $fieldRules[] = 'date';
                    break;
                case 'multi_checkbox':
                    $fieldRules = $question->is_required ? ['required', 'array', 'min:1'] : ['nullable', 'array'];
                    break;
                case 'checkbox':
                case 'yes_no':
                    // Boolean-like strings
                    break;
                case 'textarea':
                case 'text':
                default:
                    $fieldRules[] = 'string';
                    break;
            }

            $rules[$fieldKey] = $fieldRules;
        }

        $messages = [
            'name.required' => 'Please provide your full legal name.',
            'email.required' => 'A valid email address is required so we can contact you.',
            'email.email' => 'Please enter a valid email format (e.g. name@example.com).',
            'phone.required' => 'A contact phone number is required.',
            'cv.required' => 'Please upload your CV / resume.',
            'cv.mimes' => 'Allowed CV formats are PDF, DOC, DOCX, JPG, JPEG, and PNG.',
            'cv.max' => 'Your CV file size must not exceed 5 MB.',
        ];

        // Custom error messages for dynamic questions
        foreach ($job->activeQuestions as $question) {
            $messages["answers.{$question->id}.required"] = "The question \"{$question->question}\" is required.";
        }

        $validated = $request->validate($rules, $messages);

        // 5. Prevent Duplicate Applications for same email & job within 30 days
        $existing = CareerApplication::where('career_job_id', $job->id)
            ->where('email', strtolower(trim($validated['email'])))
            ->where('created_at', '>=', now()->subDays(30))
            ->first();

        if ($existing) {
            return back()
                ->with('error', "You have already submitted an application for this position (Reference: {$existing->reference}). Our recruitment team is currently reviewing your profile.")
                ->withInput();
        }

        // 6. DB Transaction for Atomic Submission
        DB::beginTransaction();
        try {
            // Upload & Store CV
            $cvData = $cvService->storeCv($request->file('cv'), $job->id);

            // Create Application
            $application = CareerApplication::create([
                'career_job_id' => $job->id,
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'phone' => trim($validated['phone']),
                'cv_original_name' => $cvData['original_name'],
                'cv_storage_path' => $cvData['storage_path'],
                'cv_mime_type' => $cvData['mime_type'],
                'cv_size' => $cvData['size'],
                'status' => 'pending',
                'internal_notes' => null,
                'applied_at' => now(),
            ]);

            // Save Dynamic Answers
            $submittedAnswers = $request->input('answers', []);
            foreach ($job->activeQuestions as $question) {
                $rawAnswer = $submittedAnswers[$question->id] ?? null;
                $answerText = null;
                $answerJson = null;

                if (is_array($rawAnswer)) {
                    $answerJson = array_values(array_filter($rawAnswer));
                    $answerText = implode(', ', $answerJson);
                } else {
                    $answerText = is_null($rawAnswer) ? null : (string) $rawAnswer;
                }

                CareerApplicationAnswer::create([
                    'career_application_id' => $application->id,
                    'career_job_question_id' => $question->id,
                    'question_snapshot' => $question->question,
                    'question_type_snapshot' => $question->type,
                    'answer_text' => $answerText,
                    'answer_json' => $answerJson,
                ]);
            }

            // Create Initial Status Log
            CareerApplicationStatusLog::create([
                'career_application_id' => $application->id,
                'old_status' => null,
                'new_status' => 'pending',
                'changed_by' => null,
                'notes' => 'Application submitted online by candidate.',
                'created_at' => now(),
            ]);

            DB::commit();

            // Send Confirmation Email
            $emailService->sendConfirmationEmail($application);

            return redirect()->route('careers.success', $application->reference)
                ->with('success', 'Your application has been received successfully!');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Career application submission failed: ' . $e->getMessage(), [
                'exception' => $e,
                'job_id' => $job->id,
            ]);

            return back()
                ->with('error', 'An error occurred while submitting your application. Please check your information and try again.')
                ->withInput();
        }
    }
}
