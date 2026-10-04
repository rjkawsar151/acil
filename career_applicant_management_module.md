# Career & Applicant Management Module — Detailed Specification

## 1. Overview

This module adds a complete **Career / Recruitment Management System** to the website and admin panel.

The public website will have a **Career** section where visitors can:

- View active job openings.
- Open a detailed job page.
- Review job information such as:
  - Position name
  - Location
  - Salary
  - Employment type
  - Responsibilities
  - Education requirements
  - Experience requirements
  - Other requirements
  - Application deadline
- Complete an application form.
- Answer custom questions configured by the admin.
- Upload a CV/resume.
- Submit the application.
- Receive an application success message.
- Receive an automatic confirmation email.

The admin panel will have a new **Career** menu with:

1. Job Posts
2. Applications
3. Custom Questions
4. Email / Interview actions
5. Bulk operations
6. Applicant status management
7. CV preview

---

# 2. Main Objectives

The system should allow the company to manage the complete recruitment process from the existing website and admin dashboard.

Primary goals:

- Publish and manage job vacancies.
- Allow candidates to apply online.
- Allow different jobs to have different custom questions.
- Store CV files securely.
- Review candidates from the admin panel.
- Preview CVs without manually downloading them when possible.
- Change applicant status individually or in bulk.
- Send interview emails to shortlisted candidates.
- Support CC and BCC in bulk emails.
- Maintain a clear applicant history and audit trail.

---

# 3. Public Website — Career Section

## 3.1 Navigation

Add a new navigation item:

**Career**

Recommended placement:

`Home | About Us | Products | Career | Contact`

The Career section should visually follow the current website style:

- White / blue corporate design
- Clean spacing
- Rounded cards
- Responsive layout
- Same typography system as the existing website
- Mobile friendly

---

# 4. Career Listing Page

Suggested route:

```text
/careers
```

Page heading example:

```text
Careers
Build Your Career With Us
```

Optional introductory copy:

> Explore current opportunities and join a growing team focused on quality, innovation and professional development.

---

## 4.1 Job Card Design

Each active job should appear as a card or row.

Display:

- Position name
- Department
- Location
- Employment type
- Salary / salary range
- Vacancy count
- Application deadline
- Short description
- View Details / Apply button

Example:

```text
Digital Marketing Executive

Department: Marketing
Location: Savar, Dhaka
Employment Type: Full Time
Salary: BDT 25,000 – 35,000
Deadline: 30 October 2026

[View Details]
```

---

## 4.2 Career Listing Filters — Optional but Recommended

Allow candidates to filter jobs by:

- Department
- Location
- Employment type

Optional keyword search:

```text
Search jobs...
```

---

# 5. Job Details Page

Suggested route:

```text
/careers/{slug}
```

Example:

```text
/careers/digital-marketing-executive
```

---

## 5.1 Job Header

Display:

- Position name
- Department
- Location
- Employment type
- Salary
- Number of vacancies
- Application deadline
- Apply Now button

Example:

```text
Digital Marketing Executive

Marketing Department
Savar, Dhaka
Full Time
Salary: BDT 25,000 – 35,000
Vacancy: 2
Application Deadline: 30 October 2026

[Apply Now]
```

---

# 6. Job Details Information

The admin should be able to manage all sections individually.

Recommended fields:

## Basic Information

- Position name
- Job slug
- Department
- Location
- Employment type
- Workplace type
  - On-site
  - Remote
  - Hybrid
- Number of vacancies
- Salary type
  - Fixed
  - Range
  - Negotiable
  - Hide salary
- Minimum salary
- Maximum salary
- Currency
- Application deadline

## Job Description

- Short summary
- Full description

## Responsibilities

Rich text field.

Example:

```text
- Manage company social media accounts.
- Prepare campaign plans.
- Coordinate with graphic designers and video editors.
- Monitor advertising performance.
```

## Education Requirements

Rich text field.

Example:

```text
Bachelor's degree in Marketing, Business Administration,
Computer Science or a related field.
```

## Experience Requirements

Example:

```text
Minimum 2 years of relevant experience.
```

## Additional Requirements

Optional.

Example:

```text
- Good communication skills.
- Strong understanding of digital marketing.
- Ability to work under deadlines.
```

## Benefits

Optional.

Example:

```text
- Festival bonus
- Performance bonus
- Training opportunities
```

---

# 7. Application Form

The application form should appear below the job details or inside a clearly separated application section.

Recommended title:

```text
Apply for This Position
```

---

## 7.1 Standard Applicant Fields

Required fields:

### Full Name

```text
Full Name *
```

Type:

```text
text
```

Validation:

- Required
- Minimum 2 characters
- Maximum 150 characters

---

### Email Address

```text
Email Address *
```

Type:

```text
email
```

Validation:

- Required
- Valid email format
- Maximum 255 characters

---

### Phone Number

```text
Phone Number *
```

Type:

```text
tel
```

Validation:

- Required
- Maximum 30 characters
- Server-side sanitization

---

# 8. Custom Questions

Admin can create custom questions for each job post.

If no custom question is configured, no custom question should appear.

If questions are configured, they should appear automatically in the application form.

---

## 8.1 Supported Question Types

Recommended question types:

- Short text
- Long text / textarea
- Number
- Email
- Phone
- Date
- Yes / No
- Radio button
- Dropdown
- Checkbox
- Multiple choice / multiple checkbox

---

## 8.2 Custom Question Configuration

Each custom question should support:

- Question text
- Question type
- Required / optional
- Options
- Sort order
- Active / inactive

Example:

```text
Question:
Do you have experience managing Meta Ads?

Type:
Yes / No

Required:
Yes
```

Another example:

```text
Question:
Which tools have you used?

Type:
Multiple Checkbox

Options:
- Meta Ads Manager
- Google Ads
- Canva
- CapCut
- Adobe Premiere Pro

Required:
No
```

---

# 9. CV Upload

Field:

```text
Upload CV / Resume *
```

Supported file formats:

- PDF
- DOC
- DOCX
- JPG
- JPEG
- PNG

Maximum file size:

```text
5 MB
```

---

## 9.1 Validation

Server-side validation must be mandatory.

Suggested Laravel validation:

```php
'cv' => [
    'required',
    'file',
    'max:5120',
    'mimes:pdf,doc,docx,jpg,jpeg,png',
],
```

Do not rely only on the browser file extension.

Validate:

- MIME type
- File size
- File extension
- Upload success

---

## 9.2 CV Storage

Recommended storage structure:

```text
storage/app/private/careers/{job_id}/{year}/{month}/
```

Example:

```text
storage/app/private/careers/15/2026/10/
```

Recommended generated filename:

```text
application-{application_id}-{random_string}.pdf
```

Do not use the candidate's original filename as the physical server filename.

Store the original filename separately in the database.

---

# 10. Application Submit Button

Button:

```text
Apply Now
```

On submit:

1. Validate form.
2. Validate custom questions.
3. Validate CV.
4. Save applicant data.
5. Save custom answers.
6. Save CV.
7. Create applicant status history.
8. Send candidate confirmation email.
9. Show success message.

---

# 11. Success Message

After a successful application, show a clear success screen/message.

Example:

```text
Application Submitted Successfully

Thank you for applying for the position of
Digital Marketing Executive.

We have received your application successfully.
Our recruitment team will review your application and contact you
if you are shortlisted.
```

Optional:

```text
Application Reference: APP-2026-000123
```

Button:

```text
Back to Careers
```

---

# 12. Duplicate Application Handling

Recommended behavior:

Prevent the same email address from applying repeatedly to the same job within a configurable period.

Recommended default:

```text
Same email + same job = only one active application
```

Possible response:

```text
You have already applied for this position.
```

This behavior may be configurable if repeat applications are required later.

---

# 13. Candidate Confirmation Email

After successful submission, automatically send an email.

Suggested subject:

```text
Application Received — {Position Name}
```

Example body:

```text
Dear {Applicant Name},

Thank you for applying for the position of {Position Name}.

We have successfully received your application.

Application Details:
Position: {Position Name}
Location: {Job Location}
Application Date: {Application Date}
Reference No: {Application Reference}

Our recruitment team will review your application.
If you are shortlisted, we will contact you with the next steps.

Regards,
HR Team
Adonis Chemical Industries Ltd.
```

---

# 14. Admin Panel — Career Module

Add a new sidebar menu:

```text
Career
```

Sub-menu:

```text
Career
├── Job Posts
├── Applications
└── Custom Questions
```

Optional future submenu:

```text
├── Email Templates
├── Departments
└── Settings
```

---

# 15. Admin — Job Post List

Suggested admin route:

```text
/admin/careers/jobs
```

Display jobs as rows in a table.

Recommended columns:

| Column | Description |
|---|---|
| ID | Job ID |
| Position | Position name |
| Department | Department |
| Location | Job location |
| Vacancy | Number of vacancies |
| Applications | Total received |
| Deadline | Application deadline |
| Status | Draft / Published / Closed |
| Created At | Creation date |
| Actions | Manage actions |

Actions:

```text
View
Edit
Applications
Duplicate
Publish / Unpublish
Close Job
Delete
```

---

# 16. Create / Edit Job

Suggested routes:

```text
/admin/careers/jobs/create
/admin/careers/jobs/{id}/edit
```

Recommended sections:

## General

- Position name
- Slug
- Department
- Location
- Workplace type
- Employment type
- Number of vacancies

## Compensation

- Salary visibility
- Salary type
- Minimum salary
- Maximum salary
- Currency

## Requirements

- Responsibilities
- Education requirements
- Experience requirements
- Additional requirements

## Description

- Short description
- Full description

## Application

- Application deadline
- Custom questions
- Allow applications toggle

## Publishing

- Draft
- Published
- Closed

---

# 17. Job Statuses

Recommended job statuses:

```text
draft
published
closed
archived
```

### Draft

Not visible publicly.

### Published

Visible publicly and accepting applications.

### Closed

Visible optionally, but application form disabled.

### Archived

Hidden from the normal management list unless archive filter is enabled.

---

# 18. Custom Question Builder in Admin

Inside job create/edit screen, include:

```text
Application Questions
```

Admin can click:

```text
+ Add Question
```

For each question:

- Question
- Type
- Required
- Options
- Sort order
- Delete

Example UI:

```text
Question: Years of relevant experience?
Type: Number
Required: Yes

[Delete]
```

Support drag-and-drop reordering if convenient.

---

# 19. Admin — Applications Page

Suggested route:

```text
/admin/careers/applications
```

Display applications as rows.

Recommended columns:

| Column | Description |
|---|---|
| Checkbox | Bulk selection |
| Reference | Application ID |
| Applicant | Name |
| Email | Candidate email |
| Phone | Candidate phone |
| Position | Applied job |
| Location | Job location |
| Applied Date | Submission date |
| Status | Current applicant status |
| CV | Preview button |
| Actions | View / Edit status / Email |

---

# 20. Application Statuses

Recommended default statuses:

```text
pending
under_review
shortlisted
interview_scheduled
interviewed
selected
rejected
withdrawn
hired
```

Admin should be able to update a status directly from:

- Application list
- Application details page
- Bulk operation

Suggested badges:

```text
Pending
Under Review
Shortlisted
Interview Scheduled
Interviewed
Selected
Rejected
Hired
```

Do not depend only on badge color; always show the status label.

---

# 21. Application Detail Page

Suggested route:

```text
/admin/careers/applications/{id}
```

Display:

## Candidate Details

- Applicant name
- Email
- Phone
- Applied position
- Application date
- Current status
- Application reference

## Job Information

- Position
- Department
- Location
- Salary
- Deadline

## Custom Question Answers

Example:

```text
Do you have Meta Ads experience?
Yes

Years of experience?
3 Years
```

## CV

Buttons:

```text
Preview CV
Download CV
```

## Status Management

```text
Change Status
```

## Internal Notes

Recommended field:

```text
HR Notes
```

Internal notes should never be visible to the applicant.

---

# 22. Instant CV Preview

The applications table should contain:

```text
Preview CV
```

Clicking the button opens a modal / popup.

---

## 22.1 PDF

Display PDF directly in the popup using:

```text
iframe
```

or a PDF viewer.

---

## 22.2 Images

For:

- JPG
- JPEG
- PNG

Display the image inside the modal.

---

## 22.3 DOC / DOCX

Browsers do not reliably render DOC/DOCX directly.

Recommended implementation:

### Option A — Server-side conversion

Convert DOC/DOCX into PDF for preview while keeping the original file.

Best experience.

### Option B — Download fallback

If conversion is unavailable:

```text
Preview unavailable for this file type.

[Download CV]
```

The original DOC/DOCX should remain available.

---

# 23. Secure CV Access

CV files should not be publicly accessible through a predictable URL.

Recommended:

```text
/private/career-cv/{application}
```

Access must require admin authentication and permission.

Controller should:

1. Check admin authentication.
2. Check career/application permission.
3. Locate the stored CV.
4. Return inline response for preview.
5. Return attachment response for download when requested.

---

# 24. Application Filters

Admin should be able to filter by:

- Job position
- Department
- Applicant status
- Application date
- Location

Search fields:

- Applicant name
- Email
- Phone
- Application reference

Example:

```text
Search applicant...

Position: All Jobs
Status: Shortlisted
Date: This Month

[Filter]
```

---

# 25. Sorting

Allow sorting by:

- Newest
- Oldest
- Applicant name
- Position
- Status

Recommended default:

```text
Newest First
```

---

# 26. Pagination

Applications table should be paginated.

Recommended:

```text
25 / 50 / 100 per page
```

---

# 27. Bulk Operations

Each application row should include a checkbox.

Header should have:

```text
Select All
```

After one or more rows are selected, show:

```text
Bulk Actions
```

Supported actions:

- Change status
- Mark Pending
- Mark Under Review
- Shortlist
- Reject
- Mark Interview Scheduled
- Mark Selected
- Mark Hired
- Send Email
- Delete

---

# 28. Bulk Status Change

Example:

```text
12 applicants selected.

Change Status To:
Shortlisted

[Apply]
```

Before applying:

```text
Are you sure you want to change the status of 12 applications
to Shortlisted?
```

After completion:

```text
12 applications updated successfully.
```

---

# 29. Bulk Delete

Bulk delete must require confirmation.

Example:

```text
You are about to delete 8 applications.

This action may remove applicant data and uploaded CVs.

[Cancel] [Delete Applications]
```

Recommended:

Use soft delete instead of immediate permanent deletion.

---

# 30. Bulk Email to Shortlisted Candidates

Admin can select shortlisted candidates and click:

```text
Send Interview Email
```

Recommended workflow:

```text
Applications
→ Filter: Shortlisted
→ Select candidates
→ Send Interview Email
```

---

# 31. Interview Email Form

Fields:

## To

Automatically populated from selected candidates.

Admin should not have to manually enter candidate emails.

---

## CC

Optional.

Supports:

- Single email
- Multiple emails

Example:

```text
hr@example.com, manager@example.com
```

---

## BCC

Optional.

Supports:

- Single email
- Multiple emails

---

## Subject

Example:

```text
Interview Invitation — {Position Name}
```

---

## Interview Location

Example:

```text
Adonis Chemical Industries Ltd.
Genda, Karnapara, Savar, Dhaka
```

---

## Interview Date

Date picker.

---

## Interview Time

Time picker.

---

## Email Body

Rich text editor or textarea.

The body should support dynamic placeholders.

Example:

```text
Dear {{ applicant_name }},

Congratulations.

You have been shortlisted for an interview for the position of
{{ position_name }}.

Interview Details:

Date: {{ interview_date }}
Time: {{ interview_time }}
Location: {{ interview_location }}

Please bring a copy of your updated CV and any relevant documents.

Kindly confirm your availability by replying to this email.

Regards,
HR Team
Adonis Chemical Industries Ltd.
```

---

# 32. Applicant Name Personalization

Even when sending bulk emails, each applicant must receive an individual personalized email.

For example:

Candidate 1 receives:

```text
Dear Rahim Ahmed,
```

Candidate 2 receives:

```text
Dear Nusrat Jahan,
```

Do NOT send one email where every candidate is visible in the `To` field.

Each message should be dispatched separately.

---

# 33. Email Placeholder System

Recommended placeholders:

```text
{{ applicant_name }}
{{ applicant_email }}
{{ applicant_phone }}
{{ application_reference }}
{{ position_name }}
{{ department }}
{{ job_location }}
{{ interview_date }}
{{ interview_time }}
{{ interview_location }}
{{ company_name }}
```

Optional future placeholders:

```text
{{ hr_name }}
{{ hr_phone }}
{{ interview_link }}
```

---

# 34. Email CC / BCC Behavior

For each personalized candidate email:

```text
To: candidate@example.com
CC: configured CC addresses
BCC: configured BCC addresses
```

This preserves candidate privacy.

---

# 35. Interview Email Result

After bulk sending, show:

```text
Interview emails queued successfully.

Successful: 18
Failed: 1
```

If a queued email fails, store the failure reason for admin review.

---

# 36. Queue Email Sending

Do not send large batches directly in the web request.

Use Laravel queues.

Example:

```php
SendCandidateInterviewEmail::dispatch($application->id, $emailData);
```

Recommended queue drivers:

- Redis
- Database queue

This prevents request timeout during bulk email sending.

---

# 37. Candidate Confirmation Email Queue

Candidate confirmation email should also be queued.

Flow:

```text
Application Submitted
        ↓
Application Saved
        ↓
Confirmation Email Queued
        ↓
Success Page Returned
```

The application should remain successful even if the mail provider is temporarily unavailable.

---

# 38. Recommended Database Design

## `career_jobs`

Suggested columns:

```text
id
title
slug
department_id nullable
department_name nullable
location
workplace_type
employment_type
vacancies
salary_type
salary_min nullable
salary_max nullable
currency
show_salary
short_description
description
responsibilities
education_requirements
experience_requirements nullable
additional_requirements nullable
benefits nullable
application_deadline nullable
status
allow_applications
published_at nullable
created_by nullable
updated_by nullable
created_at
updated_at
deleted_at nullable
```

---

# 39. `career_job_questions`

Suggested columns:

```text
id
career_job_id
question
type
options json nullable
is_required boolean
sort_order integer
is_active boolean
created_at
updated_at
```

Question type values:

```text
text
textarea
number
email
phone
date
yes_no
radio
select
checkbox
multi_checkbox
```

---

# 40. `career_applications`

Suggested columns:

```text
id
reference
career_job_id
name
email
phone
cv_original_name
cv_storage_path
cv_mime_type
cv_size
status
internal_notes nullable
applied_at
created_at
updated_at
deleted_at nullable
```

Recommended indexes:

```text
career_job_id
email
phone
status
applied_at
reference
```

---

# 41. `career_application_answers`

Suggested columns:

```text
id
career_application_id
career_job_question_id
question_snapshot
question_type_snapshot
answer_text nullable
answer_json nullable
created_at
updated_at
```

The question text should be stored as a snapshot.

Reason:

If the admin later edits or deletes a question, the historical application should still show the original question the applicant answered.

---

# 42. `career_application_status_logs`

Suggested columns:

```text
id
career_application_id
old_status nullable
new_status
changed_by nullable
notes nullable
created_at
```

This table provides a complete status history.

---

# 43. `career_email_logs`

Recommended table:

```text
id
career_application_id nullable
career_job_id nullable
email_type
recipient_email
cc json nullable
bcc json nullable
subject
body
status
provider_message_id nullable
failure_reason nullable
sent_by nullable
sent_at nullable
created_at
updated_at
```

Possible email types:

```text
application_confirmation
interview_invitation
rejection
custom
```

---

# 44. Optional `career_departments`

If departments will be reused, create:

```text
id
name
slug
is_active
created_at
updated_at
```

Examples:

```text
Human Resources
Marketing
Sales
Production
Finance
IT
Administration
```

---

# 45. Eloquent Model Relationships

## CareerJob

```text
CareerJob
hasMany CareerJobQuestion
hasMany CareerApplication
belongsTo Department
```

## CareerApplication

```text
CareerApplication
belongsTo CareerJob
hasMany CareerApplicationAnswer
hasMany CareerApplicationStatusLog
hasMany CareerEmailLog
```

## CareerJobQuestion

```text
CareerJobQuestion
belongsTo CareerJob
hasMany CareerApplicationAnswer
```

---

# 46. Suggested Laravel Models

```text
CareerJob
CareerJobQuestion
CareerApplication
CareerApplicationAnswer
CareerApplicationStatusLog
CareerEmailLog
CareerDepartment
```

---

# 47. Public Routes

Example:

```php
Route::get('/careers', [CareerController::class, 'index'])
    ->name('careers.index');

Route::get('/careers/{careerJob:slug}', [CareerController::class, 'show'])
    ->name('careers.show');

Route::post('/careers/{careerJob:slug}/apply', [CareerApplicationController::class, 'store'])
    ->name('careers.apply');
```

---

# 48. Admin Routes

Recommended:

```php
Route::prefix('admin/careers')
    ->middleware(['auth'])
    ->group(function () {

        Route::resource('jobs', CareerJobController::class);

        Route::get('applications', [CareerApplicationAdminController::class, 'index'])
            ->name('career.applications.index');

        Route::get('applications/{application}', [CareerApplicationAdminController::class, 'show'])
            ->name('career.applications.show');

        Route::patch('applications/{application}/status', [CareerApplicationAdminController::class, 'updateStatus'])
            ->name('career.applications.status');

        Route::post('applications/bulk-status', [CareerBulkApplicationController::class, 'status'])
            ->name('career.applications.bulk-status');

        Route::delete('applications/bulk-delete', [CareerBulkApplicationController::class, 'destroy'])
            ->name('career.applications.bulk-delete');

        Route::post('applications/bulk-email', [CareerBulkEmailController::class, 'send'])
            ->name('career.applications.bulk-email');

        Route::get('applications/{application}/cv/preview', [CareerCvController::class, 'preview'])
            ->name('career.applications.cv.preview');

        Route::get('applications/{application}/cv/download', [CareerCvController::class, 'download'])
            ->name('career.applications.cv.download');
    });
```

---

# 49. Recommended Controller Responsibilities

## CareerController

```text
index()
show()
```

Responsibilities:

- List active jobs.
- Apply filters.
- Show published job details.
- Hide drafts and archived jobs.

---

## CareerApplicationController

```text
store()
```

Responsibilities:

- Validate candidate data.
- Validate job availability.
- Validate application deadline.
- Validate custom questions.
- Validate CV.
- Save application.
- Save answers.
- Store CV.
- Generate reference number.
- Queue confirmation email.

---

## CareerJobController

Admin CRUD:

```text
index()
create()
store()
show()
edit()
update()
destroy()
```

---

## CareerApplicationAdminController

Responsibilities:

```text
index()
show()
updateStatus()
```

---

## CareerBulkApplicationController

Responsibilities:

```text
status()
destroy()
```

---

## CareerBulkEmailController

Responsibilities:

```text
send()
```

---

## CareerCvController

Responsibilities:

```text
preview()
download()
```

---

# 50. Form Request Classes

Recommended:

```text
StoreCareerJobRequest
UpdateCareerJobRequest
StoreCareerApplicationRequest
BulkApplicationStatusRequest
BulkApplicationDeleteRequest
BulkCareerEmailRequest
```

Using dedicated request classes keeps controllers clean.

---

# 51. Validation Rules — Candidate Application

Example:

```php
[
    'name' => ['required', 'string', 'min:2', 'max:150'],

    'email' => ['required', 'email', 'max:255'],

    'phone' => ['required', 'string', 'max:30'],

    'cv' => [
        'required',
        'file',
        'max:5120',
        'mimes:pdf,doc,docx,jpg,jpeg,png',
    ],

    'answers' => ['nullable', 'array'],
]
```

Custom question validation must be dynamically generated according to the job's active questions.

---

# 52. Application Availability Validation

Before accepting an application, verify:

```text
Job status = published
allow_applications = true
deadline has not passed
```

If unavailable:

```text
Applications for this position are currently closed.
```

---

# 53. Reference Number

Generate a human-friendly reference.

Example:

```text
APP-2026-000001
APP-2026-000002
APP-2026-000003
```

Do not use the reference as the only database primary key.

---

# 54. Permissions

If the admin panel uses roles and permissions, recommended permissions:

```text
career.view
career.jobs.view
career.jobs.create
career.jobs.edit
career.jobs.delete

career.applications.view
career.applications.update_status
career.applications.delete

career.cv.preview
career.cv.download

career.email.send
career.email.bulk_send
```

Example roles:

```text
Super Admin
HR Admin
HR Executive
Viewer
```

---

# 55. Security Requirements

## File Security

- Store CV files outside public web root.
- Never trust client-provided MIME type only.
- Generate random physical filenames.
- Prevent PHP/executable uploads.
- Use authorized controller routes for preview/download.

## Input Security

Use Laravel validation and escaping.

For rich-text fields:

- Sanitize HTML.
- Whitelist safe tags.
- Remove scripts.
- Remove dangerous event attributes.

## CSRF

All application/admin POST requests must use Laravel CSRF protection.

## Rate Limiting

Recommended public application limit:

```text
5 application attempts per IP per 10 minutes
```

Tune later if needed.

---

# 56. Spam Protection

Recommended:

- Laravel rate limiter
- Honeypot field

Optional:

- Cloudflare Turnstile
- Google reCAPTCHA

A honeypot can reduce automated spam without adding visible friction.

---

# 57. Transaction Handling

Application submission should use a database transaction.

Example flow:

```text
Begin transaction
    Create application
    Save answers
    Save CV metadata
    Create status history
Commit
Queue confirmation email
```

If a critical database step fails:

```text
Rollback transaction
Delete partially uploaded file if needed
Return validation/server error
```

---

# 58. Job Closing Logic

A job should automatically stop accepting applications when:

```text
application_deadline < current date/time
```

It may remain visible as:

```text
Applications Closed
```

Optional scheduled command:

```text
php artisan careers:close-expired-jobs
```

Run through Laravel Scheduler.

---

# 59. Admin Dashboard Statistics

Recommended Career dashboard cards:

```text
Active Jobs
Total Applications
Pending
Shortlisted
Interviews Scheduled
Selected
Rejected
```

Optional chart:

```text
Applications Received — Last 30 Days
```

---

# 60. Job-Level Statistics

On a job details/admin page show:

```text
Total Applications: 124
Pending: 45
Under Review: 22
Shortlisted: 18
Interview Scheduled: 10
Selected: 4
Rejected: 25
```

---

# 61. Application Status History

Inside application details show:

```text
Status History

04 Oct 2026 10:20 AM
Pending → Under Review
Changed by: HR Admin

05 Oct 2026 03:10 PM
Under Review → Shortlisted
Changed by: HR Manager
```

This improves accountability.

---

# 62. Internal Notes

Admin should be able to add internal notes.

Example:

```text
Strong portfolio.
Good Meta Ads experience.
Consider for second interview.
```

Notes are never included in candidate emails.

---

# 63. Rejection Email — Optional

When status changes to rejected, optionally allow:

```text
Send rejection email
```

Do not automatically send without confirmation unless configured.

Example:

```text
Dear {{ applicant_name }},

Thank you for your interest in the position of {{ position_name }}.

After reviewing your application, we will not be proceeding with your
application at this stage.

We appreciate the time you invested and wish you success in your career.

Regards,
HR Team
```

---

# 64. Interview Confirmation Tracking — Future Enhancement

Future version can include a link:

```text
Confirm Attendance
```

Candidate could select:

```text
I will attend
Unable to attend
Request another time
```

This is not required for V1 but the architecture should allow it later.

---

# 65. Admin UI Layout

Suggested Career sidebar:

```text
CAREER

Jobs
Applications
```

Applications table toolbar:

```text
[Search Applicant]

[All Jobs ▼]
[All Status ▼]
[Date Range ▼]

[Bulk Actions ▼]

                           [Export] [Refresh]
```

Table:

```text
☐ | Applicant | Position | Phone | Applied | Status | CV | Actions
```

---

# 66. CV Preview Modal

Suggested modal:

```text
------------------------------------------------
Applicant CV

Rahim Ahmed
Digital Marketing Executive

[PDF / Image Preview Area]

[Download CV]                    [Close]
------------------------------------------------
```

Modal should be:

- Large
- Scrollable
- Responsive
- Keyboard accessible

---

# 67. Mobile Admin Behavior

On mobile:

- Hide low-priority table columns.
- Use responsive cards or horizontal scrolling.
- Keep applicant name, position, status and actions visible.
- CV preview modal should use almost full screen.

---

# 68. Public Responsive Design

The public Career section must support:

- Desktop
- Tablet
- Mobile

On mobile:

```text
Job Information
↓
Requirements
↓
Application Form
```

Form fields should become one column.

---

# 69. Accessibility

Recommended:

- Form labels connected to inputs.
- Validation messages connected using ARIA attributes.
- Keyboard accessible modal.
- Visible focus states.
- Proper heading hierarchy.
- Do not communicate status by color alone.

---

# 70. Empty States

## No Active Jobs

Show:

```text
There are currently no open positions.

Please check again later for future opportunities.
```

## No Applications

Admin:

```text
No applications found.
```

## No Shortlisted Candidates

```text
No shortlisted applicants match the current filters.
```

---

# 71. Error Handling

Application errors should display user-friendly messages.

Examples:

```text
The CV must not be larger than 5 MB.
```

```text
Only PDF, DOC, DOCX, JPG, JPEG and PNG files are allowed.
```

```text
Please answer all required questions.
```

```text
This job is no longer accepting applications.
```

---

# 72. Audit Logging

Recommended admin audit events:

```text
Job created
Job edited
Job published
Job closed
Job deleted

Application status changed
Application deleted
CV downloaded
Bulk status changed
Bulk email sent
```

This may integrate with the existing activity log system if available.

---

# 73. Notification Strategy

## Applicant

Send email for:

- Application received
- Interview invitation
- Optional rejection
- Optional selection

## Admin

Optional:

Send admin notification when a new application arrives.

Example:

```text
New application received:
Digital Marketing Executive
Rahim Ahmed
```

Can be enabled later to avoid excessive email volume.

---

# 74. Email Templates

For maintainability, email content should preferably be stored as templates.

Recommended template keys:

```text
career_application_confirmation
career_interview_invitation
career_rejection
career_selected
```

Templates can use placeholders.

---

# 75. Bulk Email Privacy

Important:

Never place all shortlisted candidate emails into one shared `To` or `CC` list.

Each candidate receives a separate email.

CC/BCC configured by HR can be attached to each outgoing message.

Correct:

```text
Email #1
To: applicant1@example.com
CC: hr@example.com
BCC: director@example.com

Email #2
To: applicant2@example.com
CC: hr@example.com
BCC: director@example.com
```

---

# 76. Recommended Admin Bulk Email Flow

```text
1. Open Applications.
2. Filter by status = Shortlisted.
3. Select candidates.
4. Click "Send Interview Email".
5. Email modal opens.
6. Enter:
   - Subject
   - CC
   - BCC
   - Interview Date
   - Interview Time
   - Interview Location
   - Email body
7. Preview email.
8. Click Send.
9. Confirmation modal appears.
10. Emails are queued.
11. Success/failure result appears.
```

---

# 77. Email Preview

Before sending bulk email, allow preview using one selected candidate.

Example:

```text
Preview as: Rahim Ahmed
```

Rendered preview:

```text
Dear Rahim Ahmed,

Congratulations.

You have been shortlisted...
```

This reduces mistakes.

---

# 78. Database Constraints

Recommended:

```text
career_jobs.slug UNIQUE
career_applications.reference UNIQUE
```

Foreign keys should use appropriate cascade behavior.

Recommended:

### Job → Questions

```text
ON DELETE CASCADE
```

if the job is permanently deleted.

### Job → Applications

Prefer soft-delete/business rules instead of accidental cascading permanent deletion.

Applicant records should not disappear because someone mistakenly deletes a job.

---

# 79. Soft Deletes

Recommended models using soft deletes:

```text
CareerJob
CareerApplication
```

Optional:

```text
CareerJobQuestion
```

This enables recovery from accidental deletion.

---

# 80. Application Retention / Privacy

Candidate data contains personal information.

Recommended:

- Restrict access to authorized staff.
- Define retention policy.
- Delete expired recruitment data when no longer required.
- Protect downloadable CV URLs.
- Avoid storing CV files in public storage.

Optional future setting:

```text
Delete rejected application data after X months.
```

---

# 81. Performance Considerations

Applications list should use:

- Pagination
- Indexed filters
- Eager loading where necessary
- No N+1 relationship queries

Example:

```php
CareerApplication::query()
    ->with('job')
    ->latest('applied_at')
    ->paginate(25);
```

---

# 82. Email Sending Performance

Bulk emails should use jobs/queues.

Recommended job:

```text
SendCareerEmailJob
```

Each candidate should be queued individually.

Benefits:

- Personalized content
- Isolated failures
- Retry support
- Better logging
- No admin request timeout

---

# 83. Recommended Events

Optional Laravel events:

```text
CareerApplicationSubmitted
CareerApplicationStatusChanged
CareerInterviewScheduled
```

Listeners can handle:

- Emails
- Activity log
- Notifications
- Analytics

This keeps controllers decoupled.

---

# 84. Suggested Service Classes

Recommended:

```text
CareerApplicationService
CareerQuestionValidationService
CareerCvService
CareerBulkActionService
CareerEmailService
```

Example responsibility:

### CareerCvService

```text
validate
store
preview
download
delete
convertToPdfForPreview
```

---

# 85. Recommended Enums

If the project uses PHP enums:

```php
enum CareerApplicationStatus: string
{
    case Pending = 'pending';
    case UnderReview = 'under_review';
    case Shortlisted = 'shortlisted';
    case InterviewScheduled = 'interview_scheduled';
    case Interviewed = 'interviewed';
    case Selected = 'selected';
    case Rejected = 'rejected';
    case Withdrawn = 'withdrawn';
    case Hired = 'hired';
}
```

Job status:

```php
enum CareerJobStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Closed = 'closed';
    case Archived = 'archived';
}
```

---

# 86. Suggested Folder Structure

Example Laravel structure:

```text
app/
├── Enums/
│   ├── CareerApplicationStatus.php
│   └── CareerJobStatus.php
│
├── Http/
│   ├── Controllers/
│   │   ├── CareerController.php
│   │   ├── CareerApplicationController.php
│   │   └── Admin/
│   │       └── Career/
│   │           ├── CareerJobController.php
│   │           ├── CareerApplicationController.php
│   │           ├── CareerBulkApplicationController.php
│   │           ├── CareerBulkEmailController.php
│   │           └── CareerCvController.php
│   │
│   └── Requests/
│       └── Career/
│           ├── StoreCareerJobRequest.php
│           ├── UpdateCareerJobRequest.php
│           ├── StoreCareerApplicationRequest.php
│           ├── BulkApplicationStatusRequest.php
│           └── BulkCareerEmailRequest.php
│
├── Jobs/
│   ├── SendCareerConfirmationEmail.php
│   └── SendCareerInterviewEmail.php
│
├── Models/
│   ├── CareerJob.php
│   ├── CareerJobQuestion.php
│   ├── CareerApplication.php
│   ├── CareerApplicationAnswer.php
│   ├── CareerApplicationStatusLog.php
│   └── CareerEmailLog.php
│
├── Services/
│   └── Career/
│       ├── CareerApplicationService.php
│       ├── CareerCvService.php
│       ├── CareerEmailService.php
│       └── CareerQuestionValidationService.php
```

---

# 87. Frontend Blade Structure

Possible structure:

```text
resources/views/
├── careers/
│   ├── index.blade.php
│   ├── show.blade.php
│   ├── partials/
│   │   ├── job-card.blade.php
│   │   ├── application-form.blade.php
│   │   └── custom-question.blade.php
│   └── success.blade.php
│
└── admin/
    └── careers/
        ├── jobs/
        ├── applications/
        └── partials/
```

Adjust this structure to match the project's current module architecture.

---

# 88. Frontend Design Direction

To match the current website shown in the reference screenshot:

## Public Career Pages

Use:

- Deep navy headings
- Corporate blue buttons
- Light gray/blue backgrounds
- Thin borders
- Rounded cards
- Clean white content areas
- Strong heading hierarchy
- Minimal decorative effects

### Job Listing Card

Example layout:

```text
--------------------------------------------------
Digital Marketing Executive

Marketing       Full Time
Savar, Dhaka    BDT 25,000–35,000

We are looking for...

Deadline: 30 Oct 2026

                           [View Details]
--------------------------------------------------
```

---

# 89. Job Details Page Design

Desktop suggestion:

```text
--------------------------------------------------------------
LEFT CONTENT AREA                         RIGHT STICKY CARD

Position Title                            Job Summary
Job Description                           Location
Responsibilities                          Salary
Education                                 Type
Experience                                Deadline

Application Form                          [Apply Now]
--------------------------------------------------------------
```

On mobile:

```text
Job Summary
Job Details
Requirements
Application Form
```

---

# 90. Application Form Design

Use cards / sections:

```text
Your Information
----------------
Full Name
Email
Phone

Additional Questions
--------------------
Dynamic questions

CV / Resume
-----------
Upload CV
PDF, DOC, DOCX, JPG or PNG — Max 5 MB

[Apply Now]
```

Show uploaded filename before submission.

---

# 91. Upload UX

Display:

```text
Drag & drop your CV here
or
[Browse File]

PDF, DOC, DOCX, JPG, JPEG, PNG
Maximum 5 MB
```

After selecting:

```text
rahim-ahmed-cv.pdf
2.1 MB
[Remove]
```

---

# 92. Application Success UX

After submission:

```text
✓ Application Submitted Successfully

Thank you, Rahim Ahmed.

Your application for Digital Marketing Executive
has been received.

Reference:
APP-2026-000123

A confirmation email has been sent to:
rahim@example.com

[View Other Openings]
```

Do not expose sensitive internal IDs.

---

# 93. Recommended MVP Scope

## Public

- Career navigation menu
- Job listing
- Job detail
- Application form
- Dynamic custom questions
- CV upload
- Success screen
- Candidate confirmation email

## Admin

- Career sidebar
- Job CRUD
- Custom question builder
- Application listing
- Application details
- Search/filter
- CV preview
- CV download
- Status management
- Bulk status update
- Bulk delete
- Bulk interview email
- CC/BCC
- Email personalization
- Email queue/log

---

# 94. Phase 2 Enhancements

Possible later additions:

- Interview attendance confirmation
- Candidate portal
- Saved jobs
- Application withdrawal
- Interview calendar integration
- Interview panel assignment
- Applicant scoring
- Applicant rating
- HR notes timeline
- Candidate tags
- Job approval workflow
- Email template editor
- Export applicants to Excel/CSV
- Talent pool
- Automated rejection rules
- Offer letter generation

---

# 95. Acceptance Criteria

## Career Listing

- [ ] Active published jobs appear publicly.
- [ ] Draft jobs do not appear.
- [ ] Closed jobs cannot accept applications.
- [ ] Job cards display required information.

## Job Details

- [ ] Position name is visible.
- [ ] Location is visible.
- [ ] Salary configuration works.
- [ ] Responsibilities display correctly.
- [ ] Education requirements display correctly.
- [ ] Application deadline displays correctly.

## Application

- [ ] Name is required.
- [ ] Email is required and validated.
- [ ] Phone is required.
- [ ] Custom questions load for the current job.
- [ ] Required custom questions are validated.
- [ ] CV is required.
- [ ] PDF uploads work.
- [ ] DOC uploads work.
- [ ] DOCX uploads work.
- [ ] JPG/JPEG uploads work.
- [ ] PNG uploads work.
- [ ] Files above 5 MB are rejected.
- [ ] Application is stored successfully.
- [ ] Success message displays.
- [ ] Confirmation email is queued/sent.

## Admin Jobs

- [ ] Admin can create a job.
- [ ] Admin can edit a job.
- [ ] Admin can publish/unpublish.
- [ ] Admin can close a job.
- [ ] Admin can create custom questions.
- [ ] Admin can reorder custom questions.

## Admin Applications

- [ ] Applications display in rows.
- [ ] Admin can filter by job.
- [ ] Admin can filter by status.
- [ ] Admin can search by applicant.
- [ ] Admin can open application details.
- [ ] Admin can preview PDF CV in a popup.
- [ ] Admin can preview image CV in a popup.
- [ ] DOC/DOCX has supported preview or fallback download.
- [ ] Admin can change applicant status.
- [ ] Status history is stored.

## Bulk Operations

- [ ] Admin can select multiple applicants.
- [ ] Admin can bulk change status.
- [ ] Admin can bulk shortlist.
- [ ] Admin can bulk reject.
- [ ] Admin can bulk mark pending.
- [ ] Admin can bulk delete with confirmation.

## Interview Email

- [ ] Admin can select shortlisted candidates.
- [ ] Admin can enter interview date.
- [ ] Admin can enter interview time.
- [ ] Admin can enter interview location.
- [ ] Admin can add CC.
- [ ] Admin can add BCC.
- [ ] Applicant name is personalized.
- [ ] Position name is personalized.
- [ ] Each candidate receives a separate email.
- [ ] Bulk emails use queue processing.
- [ ] Email activity is logged.

---

# 96. Suggested Development Order

Recommended implementation order:

```text
1. Database migrations
2. Models + enums
3. Job admin CRUD
4. Custom question builder
5. Public career listing
6. Public job details
7. Application submission
8. CV storage/security
9. Confirmation email
10. Admin application list
11. Application details
12. CV preview/download
13. Status management
14. Bulk actions
15. Interview bulk email
16. Email logging
17. Permissions
18. Testing
19. UI polish
```

---

# 97. Suggested Testing Checklist

## Unit Tests

- Job status enum
- Application status enum
- Dynamic question validation
- CV file service
- Reference generation

## Feature Tests

- Guest can view published jobs.
- Guest cannot view draft job.
- Candidate can submit valid application.
- Invalid CV type fails.
- CV above 5 MB fails.
- Required custom question fails when empty.
- Application confirmation is queued.
- Admin can view applications.
- Unauthorized user cannot access CV.
- Admin can update status.
- Status history is created.
- Bulk status update works.
- Bulk email queues one message per candidate.

---

# 98. Recommended Final Status Workflow

Suggested primary recruitment workflow:

```text
Pending
   ↓
Under Review
   ↓
Shortlisted
   ↓
Interview Scheduled
   ↓
Interviewed
   ↓
Selected
   ↓
Hired
```

Alternative ending:

```text
Pending / Under Review / Shortlisted / Interviewed
                          ↓
                       Rejected
```

This workflow should not be technically locked unless the business later requests strict transitions.

---

# 99. Definition of Done

The Career module is complete when:

1. Admin can create and publish job posts.
2. Admin can add custom questions to each job.
3. Visitors can view open jobs.
4. Candidates can submit the complete application form.
5. CV uploads support PDF, DOC, DOCX, JPG, JPEG and PNG up to 5 MB.
6. The application is securely stored.
7. Candidate receives an application confirmation email.
8. Admin can view all applicants in rows.
9. Admin can search and filter applicants.
10. Admin can instantly preview supported CV files.
11. Admin can update applicant statuses.
12. Admin can perform bulk status operations.
13. Admin can delete applications in bulk.
14. Admin can select shortlisted candidates and send interview emails.
15. Interview emails support CC and BCC.
16. Interview email begins with the individual applicant's name.
17. Interview date, time and location are included.
18. Bulk emails are sent as separate personalized messages.
19. Email actions are logged.
20. All important admin actions are protected by authorization.

---

# 100. Recommended Module Name

Backend/module naming:

```text
Career
```

Main entities:

```text
CareerJob
CareerJobQuestion
CareerApplication
CareerApplicationAnswer
CareerApplicationStatusLog
CareerEmailLog
```

Admin menu:

```text
Career
├── Job Posts
└── Applications
```

This naming is simple, clear, and suitable for future recruitment functionality.
