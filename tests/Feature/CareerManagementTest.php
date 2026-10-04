<?php

namespace Tests\Feature;

use App\Mail\CareerApplicationConfirmationMail;
use App\Mail\CareerInterviewInvitationMail;
use App\Models\CareerApplication;
use App\Models\CareerDepartment;
use App\Models\CareerJob;
use App\Models\CareerJobQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CareerManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected CareerJob $testJob;

    protected function setUp(): void
    {
        parent::setUp();

        $role = \App\Models\Role::firstOrCreate(
            ['slug' => 'super-admin'],
            ['name' => 'Super Administrator', 'description' => 'Full access']
        );

        $this->adminUser = User::factory()->create([
            'email' => 'admin@adonischemical.com',
            'is_active' => true,
            'role_id' => $role->id,
        ]);

        $dept = CareerDepartment::firstOrCreate(
            ['slug' => 'research-development'],
            ['name' => 'Research & Development', 'is_active' => true]
        );

        $this->testJob = CareerJob::firstOrCreate(
            ['slug' => 'senior-formulation-chemist'],
            [
                'title' => 'Senior Formulation Chemist (Personal Care & Cosmetics)',
                'department_id' => $dept->id,
                'department_name' => 'Research & Development',
                'location' => 'Genda, Savar, Dhaka',
                'workplace_type' => 'on_site',
                'employment_type' => 'full_time',
                'vacancies' => 2,
                'salary_type' => 'range',
                'salary_min' => 45000,
                'salary_max' => 65000,
                'status' => 'published',
                'allow_applications' => true,
                'application_deadline' => now()->addDays(30),
            ]
        );
    }

    /**
     * Test public career listing page.
     */
    public function test_public_career_listing_is_accessible()
    {
        $response = $this->get(route('careers.index'));
        $response->assertStatus(200);
        $response->assertSee('Shape the Future of');
        $response->assertSee('Senior Formulation Chemist');
    }

    /**
     * Test public job details page.
     */
    public function test_public_job_details_is_accessible()
    {
        $response = $this->get(route('careers.show', $this->testJob->slug));
        $response->assertStatus(200);
        $response->assertSee($this->testJob->title);
        $response->assertSee('Apply for This Position');
    }

    /**
     * Test candidate application submission.
     */
    public function test_candidate_can_submit_application_with_cv()
    {
        Mail::fake();

        $fakeCv = UploadedFile::fake()->create('john_doe_resume.pdf', 500, 'application/pdf');

        $payload = [
            'name' => 'John Doe',
            'email' => 'john.test.applicant@example.com',
            'phone' => '+880 1700-112233',
            'cv' => $fakeCv,
            'answers' => [],
        ];

        $response = $this->post(route('careers.apply', $this->testJob->slug), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('career_applications', [
            'career_job_id' => $this->testJob->id,
            'email' => 'john.test.applicant@example.com',
            'name' => 'John Doe',
            'status' => 'pending',
        ]);

        Mail::assertSent(CareerApplicationConfirmationMail::class, function ($mail) {
            return $mail->hasTo('john.test.applicant@example.com');
        });
    }

    /**
     * Test admin can view career jobs.
     */
    public function test_admin_can_view_career_jobs_index()
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.careers.jobs.index'));
        $response->assertStatus(200);
        $response->assertSee('Career &amp; Recruitment Positions', false);
        $response->assertSee('Post New Vacancy');
    }

    /**
     * Test admin can view applications list.
     */
    public function test_admin_can_view_applications_index()
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.careers.applications.index'));
        $response->assertStatus(200);
        $response->assertSee('Career Applications &amp; Candidate Pipeline', false);
    }

    /**
     * Test admin can update application status.
     */
    public function test_admin_can_update_application_status()
    {
        $app = CareerApplication::create([
            'career_job_id' => $this->testJob->id,
            'name' => 'Alice Test',
            'email' => 'alice.test@example.com',
            'phone' => '+880 1711-223344',
            'cv_storage_path' => 'private/careers/test/sample.pdf',
            'cv_original_name' => 'sample.pdf',
            'cv_size' => 102400,
            'cv_mime_type' => 'application/pdf',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)->patch(
            route('admin.careers.applications.status', $app->id),
            [
                'status' => 'shortlisted',
                'notes' => 'Candidate shortlisted for interview.',
            ]
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('career_applications', [
            'id' => $app->id,
            'status' => 'shortlisted',
        ]);
        $this->assertDatabaseHas('career_application_status_logs', [
            'career_application_id' => $app->id,
            'new_status' => 'shortlisted',
        ]);
    }

    /**
     * Test admin can dispatch personalized interview emails in bulk.
     */
    public function test_admin_can_send_personalized_interview_email()
    {
        Mail::fake();

        $app = CareerApplication::create([
            'career_job_id' => $this->testJob->id,
            'name' => 'Bob Test',
            'email' => 'bob.test@example.com',
            'phone' => '+880 1711-556677',
            'cv_storage_path' => 'private/careers/test/sample.pdf',
            'cv_original_name' => 'sample.pdf',
            'cv_size' => 102400,
            'cv_mime_type' => 'application/pdf',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)->post(
            route('admin.careers.applications.bulk-email'),
            [
                'application_ids' => [$app->id],
                'subject' => 'Interview Invitation — {{ position_name }}',
                'body' => 'Dear {{ applicant_name }}, you are invited for an interview on {{ interview_date }}.',
                'interview_date' => '2026-10-15',
                'interview_time' => '11:00 AM',
                'interview_location' => 'Savar Plant',
                'cc' => 'hr@adonischemical.com',
                'update_status' => true,
            ]
        );

        $response->assertRedirect();
        Mail::assertSent(CareerInterviewInvitationMail::class, function ($mail) use ($app) {
            return $mail->hasTo($app->email) && $mail->hasCc('hr@adonischemical.com');
        });
    }

    /**
     * Test admin can create a new job post with custom questions.
     */
    public function test_admin_can_create_job_with_custom_questions()
    {
        Storage::fake('public');
        $fakeCover = UploadedFile::fake()->create('process_engineer_cover.jpg', 500, 'image/jpeg');

        $payload = [
            'title' => 'Senior Process Engineer',
            'department_id' => $this->testJob->department_id,
            'location' => 'Savar, Dhaka',
            'workplace_type' => 'on_site',
            'employment_type' => 'full_time',
            'experience_level' => 'mid_senior',
            'vacancies' => 1,
            'salary_type' => 'range',
            'salary_min' => 60000,
            'salary_max' => 90000,
            'status' => 'published',
            'allow_applications' => 1,
            'cover_image' => $fakeCover,
            'description' => '<p>Job description for process engineer</p>',
            'questions' => [
                [
                    'question' => 'How many years of industrial chemical manufacturing experience do you have?',
                    'type' => 'number',
                    'is_required' => 1,
                    'sort_order' => 0,
                ],
                [
                    'question' => 'Are you willing to work in shift rotations?',
                    'type' => 'radio',
                    'options' => "Yes\nNo",
                    'is_required' => 1,
                    'sort_order' => 1,
                ]
            ]
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.careers.jobs.store'), $payload);

        $response->assertRedirect(route('admin.careers.jobs.index'));
        $this->assertDatabaseHas('career_jobs', [
            'title' => 'Senior Process Engineer',
            'status' => 'published',
        ]);

        $createdJob = CareerJob::where('title', 'Senior Process Engineer')->first();
        $this->assertNotNull($createdJob);
        $this->assertNotNull($createdJob->cover_image);
        $this->assertCount(2, $createdJob->questions);
    }

    /**
     * Test admin can toggle job status.
     */
    public function test_admin_can_toggle_job_status()
    {
        $response = $this->actingAs($this->adminUser)->post(
            route('admin.careers.jobs.toggle-status', $this->testJob->id)
        );

        $response->assertRedirect();
        $this->assertEquals('draft', $this->testJob->fresh()->status);
    }

    /**
     * Test admin can duplicate job as draft.
     */
    public function test_admin_can_duplicate_job_as_draft()
    {
        $response = $this->actingAs($this->adminUser)->post(
            route('admin.careers.jobs.duplicate', $this->testJob->id)
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('career_jobs', [
            'title' => $this->testJob->title . ' (Copy)',
            'status' => 'draft',
        ]);
    }

    /**
     * Test admin can view application detail page and update HR private notes.
     */
    public function test_admin_can_view_application_detail_and_update_notes()
    {
        $app = CareerApplication::create([
            'career_job_id' => $this->testJob->id,
            'name' => 'Charlie Review',
            'email' => 'charlie@example.com',
            'phone' => '+880 1711-998877',
            'cv_storage_path' => 'private/careers/test/sample.pdf',
            'cv_original_name' => 'sample.pdf',
            'cv_size' => 102400,
            'cv_mime_type' => 'application/pdf',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)->get(
            route('admin.careers.applications.show', $app->id)
        );
        $response->assertStatus(200);
        $response->assertSee('Charlie Review');

        // Update HR notes
        $notesResponse = $this->actingAs($this->adminUser)->put(
            route('admin.careers.applications.notes', $app->id),
            ['internal_notes' => 'Highly recommended by Technical Director.']
        );
        $notesResponse->assertRedirect();
        $this->assertEquals('Highly recommended by Technical Director.', $app->fresh()->internal_notes);
    }

    /**
     * Test admin can bulk update status and bulk delete applications.
     */
    public function test_admin_can_bulk_manage_applications()
    {
        $app1 = CareerApplication::create([
            'career_job_id' => $this->testJob->id,
            'name' => 'Bulk One',
            'email' => 'bulk1@example.com',
            'phone' => '+880 1711-000001',
            'cv_storage_path' => 'private/careers/test/bulk1.pdf',
            'cv_original_name' => 'bulk1.pdf',
            'cv_size' => 102400,
            'cv_mime_type' => 'application/pdf',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $app2 = CareerApplication::create([
            'career_job_id' => $this->testJob->id,
            'name' => 'Bulk Two',
            'email' => 'bulk2@example.com',
            'phone' => '+880 1711-000002',
            'cv_storage_path' => 'private/careers/test/bulk2.pdf',
            'cv_original_name' => 'bulk2.pdf',
            'cv_size' => 102400,
            'cv_mime_type' => 'application/pdf',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        // Bulk status update
        $statusResponse = $this->actingAs($this->adminUser)->post(
            route('admin.careers.applications.bulk-status'),
            [
                'ids' => [$app1->id, $app2->id],
                'status' => 'under_review',
            ]
        );
        $statusResponse->assertRedirect();
        $this->assertEquals('under_review', $app1->fresh()->status);
        $this->assertEquals('under_review', $app2->fresh()->status);

        // Bulk delete
        $deleteResponse = $this->actingAs($this->adminUser)->delete(
            route('admin.careers.applications.bulk-delete'),
            [
                'ids' => [$app1->id, $app2->id],
            ]
        );
        $deleteResponse->assertRedirect();
        $this->assertSoftDeleted('career_applications', ['id' => $app1->id]);
        $this->assertSoftDeleted('career_applications', ['id' => $app2->id]);
    }

    /**
     * Test admin can access secure CV preview and download.
     */
    public function test_admin_can_access_secure_cv_preview_and_download()
    {
        Storage::disk('local')->put('private/careers/test/test_doc.pdf', '%PDF-1.4 Mock CV Content');

        $app = CareerApplication::create([
            'career_job_id' => $this->testJob->id,
            'name' => 'Secure CV User',
            'email' => 'securecv@example.com',
            'phone' => '+880 1711-334455',
            'cv_storage_path' => 'private/careers/test/test_doc.pdf',
            'cv_original_name' => 'test_doc.pdf',
            'cv_size' => 1024,
            'cv_mime_type' => 'application/pdf',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        // Preview (inline)
        $previewResponse = $this->actingAs($this->adminUser)->get(
            route('admin.careers.applications.cv.preview', $app->id)
        );
        $previewResponse->assertStatus(200);
        $previewResponse->assertHeader('Content-Type', 'application/pdf');

        // Download (attachment)
        $downloadResponse = $this->actingAs($this->adminUser)->get(
            route('admin.careers.applications.cv.download', $app->id)
        );
        $downloadResponse->assertStatus(200);
    }

    /**
     * Test admin can manage career departments.
     */
    public function test_admin_can_manage_departments()
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.careers.departments.index'));
        $response->assertStatus(200);
        $response->assertSee('Career Departments');

        // Create department
        $createResponse = $this->actingAs($this->adminUser)->post(
            route('admin.careers.departments.store'),
            [
                'name' => 'Quality Assurance & Regulatory',
                'description' => 'Oversees all chemical testing and compliance',
                'is_active' => 1,
            ]
        );
        $createResponse->assertRedirect();
        $this->assertDatabaseHas('career_departments', [
            'name' => 'Quality Assurance & Regulatory',
            'slug' => 'quality-assurance-regulatory',
        ]);
    }
}
