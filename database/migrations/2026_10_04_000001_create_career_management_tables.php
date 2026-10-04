<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Career Departments
        Schema::create('career_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 2. Career Jobs
        Schema::create('career_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('department_id')->nullable()->constrained('career_departments')->nullOnDelete();
            $table->string('department_name')->nullable();
            $table->string('location')->default('Genda, Savar, Dhaka');
            $table->enum('workplace_type', ['on_site', 'remote', 'hybrid'])->default('on_site');
            $table->enum('employment_type', ['full_time', 'part_time', 'contractual', 'internship'])->default('full_time');
            $table->unsignedInteger('vacancies')->default(1);
            $table->enum('salary_type', ['fixed', 'range', 'negotiable', 'hidden'])->default('negotiable');
            $table->decimal('salary_min', 12, 2)->nullable();
            $table->decimal('salary_max', 12, 2)->nullable();
            $table->string('currency', 10)->default('BDT');
            $table->boolean('show_salary')->default(true);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('responsibilities')->nullable();
            $table->longText('education_requirements')->nullable();
            $table->longText('experience_requirements')->nullable();
            $table->longText('additional_requirements')->nullable();
            $table->longText('benefits')->nullable();
            $table->date('application_deadline')->nullable();
            $table->enum('status', ['draft', 'published', 'closed', 'archived'])->default('draft');
            $table->boolean('allow_applications')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'allow_applications']);
            $table->index('application_deadline');
        });

        // 3. Career Job Questions
        Schema::create('career_job_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_job_id')->constrained('career_jobs')->cascadeOnDelete();
            $table->string('question');
            $table->enum('type', [
                'text',
                'textarea',
                'number',
                'email',
                'phone',
                'date',
                'yes_no',
                'radio',
                'select',
                'checkbox',
                'multi_checkbox'
            ])->default('text');
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['career_job_id', 'sort_order']);
        });

        // 4. Career Applications
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 50)->unique();
            $table->foreignId('career_job_id')->constrained('career_jobs')->cascadeOnDelete();
            $table->string('name', 150);
            $table->string('email', 255);
            $table->string('phone', 50);
            $table->string('cv_original_name');
            $table->string('cv_storage_path');
            $table->string('cv_mime_type', 100);
            $table->unsignedBigInteger('cv_size');
            $table->enum('status', [
                'pending',
                'under_review',
                'shortlisted',
                'interview_scheduled',
                'interviewed',
                'selected',
                'rejected',
                'withdrawn',
                'hired'
            ])->default('pending');
            $table->text('internal_notes')->nullable();
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();

            $table->index('career_job_id');
            $table->index('email');
            $table->index('phone');
            $table->index('status');
            $table->index('applied_at');
        });

        // 5. Career Application Answers
        Schema::create('career_application_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->constrained('career_applications')->cascadeOnDelete();
            $table->foreignId('career_job_question_id')->nullable()->constrained('career_job_questions')->nullOnDelete();
            $table->string('question_snapshot');
            $table->string('question_type_snapshot', 50)->default('text');
            $table->text('answer_text')->nullable();
            $table->json('answer_json')->nullable();
            $table->timestamps();

            $table->index('career_application_id');
        });

        // 6. Career Application Status Logs
        Schema::create('career_application_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->constrained('career_applications')->cascadeOnDelete();
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('career_application_id');
        });

        // 7. Career Email Logs
        Schema::create('career_email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->nullable()->constrained('career_applications')->nullOnDelete();
            $table->foreignId('career_job_id')->nullable()->constrained('career_jobs')->nullOnDelete();
            $table->string('email_type', 50); // application_confirmation, interview_invitation, rejection, selected, custom
            $table->string('recipient_email');
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->string('subject');
            $table->longText('body');
            $table->enum('status', ['pending', 'queued', 'sent', 'failed'])->default('sent');
            $table->string('provider_message_id')->nullable();
            $table->text('failure_reason')->nullable();
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['career_application_id', 'email_type']);
            $table->index('recipient_email');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_email_logs');
        Schema::dropIfExists('career_application_status_logs');
        Schema::dropIfExists('career_application_answers');
        Schema::dropIfExists('career_applications');
        Schema::dropIfExists('career_job_questions');
        Schema::dropIfExists('career_jobs');
        Schema::dropIfExists('career_departments');
    }
};
