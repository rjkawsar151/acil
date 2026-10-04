<?php

namespace Database\Seeders;

use App\Models\CareerApplication;
use App\Models\CareerApplicationAnswer;
use App\Models\CareerApplicationStatusLog;
use App\Models\CareerDepartment;
use App\Models\CareerEmailLog;
use App\Models\CareerJob;
use App\Models\CareerJobQuestion;
use App\Models\NavigationItem;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CareerModuleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        // 1. Navigation Item
        if (!NavigationItem::where('url', '/careers')->exists()) {
            NavigationItem::create([
                'title' => 'Career',
                'url' => '/careers',
                'target' => '_self',
                'location' => 'header',
                'parent_id' => null,
                'sort_order' => 8,
                'is_active' => true,
            ]);
        }

        // 2. Permissions
        $careerPermissions = [
            ['name' => 'View Career Jobs', 'slug' => 'career.jobs.view', 'group' => 'Career'],
            ['name' => 'Manage Career Jobs', 'slug' => 'career.jobs.manage', 'group' => 'Career'],
            ['name' => 'View Applications', 'slug' => 'career.applications.view', 'group' => 'Career'],
            ['name' => 'Manage Applications', 'slug' => 'career.applications.manage', 'group' => 'Career'],
            ['name' => 'Send Candidate Emails', 'slug' => 'career.email.send', 'group' => 'Career'],
        ];

        $superAdminRole = Role::where('slug', 'super-admin')->first();
        $adminRole = Role::where('slug', 'admin')->first();

        foreach ($careerPermissions as $cp) {
            $perm = Permission::firstOrCreate(['slug' => $cp['slug']], $cp);
            if ($superAdminRole && !$superAdminRole->permissions()->where('permissions.id', $perm->id)->exists()) {
                $superAdminRole->permissions()->attach($perm->id);
            }
            if ($adminRole && !$adminRole->permissions()->where('permissions.id', $perm->id)->exists()) {
                $adminRole->permissions()->attach($perm->id);
            }
        }

        // 3. Departments
        $departments = [
            [
                'name' => 'Research & Development',
                'slug' => 'research-development',
                'description' => 'Chemical formulation, laboratory testing, and innovative cosmetic personal care research.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Quality Assurance & QC',
                'slug' => 'quality-assurance-qc',
                'description' => 'Raw material verification, in-process testing, HPLC analytics, and finished product quality certification.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Production & Manufacturing',
                'slug' => 'production-manufacturing',
                'description' => 'Plant operations, automated batch blending, packaging, and facility maintenance at Savar.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Sales & Corporate Marketing',
                'slug' => 'sales-corporate-marketing',
                'description' => 'SINODA brand promotion, nationwide distribution, salon partnership desk, and digital campaigns.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Human Resources & Administration',
                'slug' => 'human-resources-administration',
                'description' => 'Talent acquisition, plant safety protocols, employee welfare, and administrative operations.',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        $createdDepts = [];
        foreach ($departments as $d) {
            $createdDepts[$d['slug']] = CareerDepartment::firstOrCreate(['slug' => $d['slug']], $d);
        }

        // 4. Sample Job Posts
        // Job 1: Senior Formulation Chemist
        if (!CareerJob::where('slug', 'senior-formulation-chemist')->exists()) {
            $job1 = CareerJob::create([
                'title' => 'Senior Formulation Chemist (Personal Care & Cosmetics)',
                'slug' => 'senior-formulation-chemist',
                'department_id' => $createdDepts['research-development']->id,
                'department_name' => 'Research & Development',
                'location' => 'Genda, Karnapara, Savar, Dhaka',
                'workplace_type' => 'on_site',
                'employment_type' => 'full_time',
                'vacancies' => 2,
                'salary_type' => 'range',
                'salary_min' => 45000,
                'salary_max' => 65000,
                'currency' => 'BDT',
                'cover_image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1200&h=675&q=80',
                'show_salary' => true,
                'short_description' => 'Lead product formulation, active ingredient stability assessments, and laboratory batch optimizations for SINODA hair care, skin care, and salon products.',
                'description' => "Adonis Chemical Industries Ltd. is looking for an accomplished Senior Formulation Chemist to join our advanced laboratory team at our Savar manufacturing plant. In this role, you will be responsible for new formulation development, raw material compatibility tests, and scaling pilot batches to commercial production under strict BSTI and ISO quality benchmarks.",
                'responsibilities' => "- Formulate personal care formulations including hair waxes, sulfate-free shampoos, soothing gels, and skin care lotions.\n- Supervise stability chamber tests, accelerated aging studies, and viscosity measurements.\n- Analyze active compounds using HPLC, spectrophotometers, and precision titrators.\n- Collaborate with the manufacturing unit during scale-up and commercial pilot batches.\n- Maintain batch records, formulation master logs, and safety data sheets (MSDS).",
                'education_requirements' => "M.Sc or B.Sc in Applied Chemistry, Chemical Technology, Biochemistry, or Pharmacy from an accredited university.",
                'experience_requirements' => "Minimum 4–6 years of formulation experience in cosmetic, personal care, or chemical manufacturing industries.",
                'additional_requirements' => "- Thorough understanding of surfactants, emulsifiers, preservatives, and botanical extracts.\n- High proficiency in GMP documentation and lab safety protocols.\n- Strong problem-solving aptitude and cross-functional team communication.",
                'benefits' => "- Two Festival Bonuses annually\n- Subsidized lunch and transport facilities at Savar Plant\n- Annual performance incentive\n- Comprehensive group life and medical insurance",
                'application_deadline' => now()->addDays(35)->toDateString(),
                'status' => 'published',
                'allow_applications' => true,
                'published_at' => now(),
                'created_by' => $adminId,
            ]);

            // Questions for Job 1
            $q1_1 = CareerJobQuestion::create([
                'career_job_id' => $job1->id,
                'question' => 'How many years of personal care / cosmetic formulation experience do you have?',
                'type' => 'number',
                'options' => null,
                'is_required' => true,
                'sort_order' => 1,
                'is_active' => true,
            ]);

            $q1_2 = CareerJobQuestion::create([
                'career_job_id' => $job1->id,
                'question' => 'Do you have hands-on experience with HPLC, Viscometers, and pH instrumentation?',
                'type' => 'yes_no',
                'options' => null,
                'is_required' => true,
                'sort_order' => 2,
                'is_active' => true,
            ]);

            $q1_3 = CareerJobQuestion::create([
                'career_job_id' => $job1->id,
                'question' => 'Which cosmetic product formulation categories have you worked on directly?',
                'type' => 'multi_checkbox',
                'options' => [
                    'Hair Care (Shampoos, Conditioners, Serums)',
                    'Styling Products (Hair Wax, Pomades, Gels)',
                    'Skin & Body Care (Aloe Vera Gels, Lotions, Creams)',
                    'Sanitizers & Disinfectants',
                ],
                'is_required' => false,
                'sort_order' => 3,
                'is_active' => true,
            ]);

            $q1_4 = CareerJobQuestion::create([
                'career_job_id' => $job1->id,
                'question' => 'What is your expected joining notice period or earliest start date?',
                'type' => 'text',
                'options' => null,
                'is_required' => true,
                'sort_order' => 4,
                'is_active' => true,
            ]);
        }

        // Job 2: Quality Control Officer
        if (!CareerJob::where('slug', 'quality-control-officer')->exists()) {
            $job2 = CareerJob::create([
                'title' => 'Quality Control Officer (Chemical & Raw Materials)',
                'slug' => 'quality-control-officer',
                'department_id' => $createdDepts['quality-assurance-qc']->id,
                'department_name' => 'Quality Assurance & QC',
                'location' => 'Genda, Karnapara, Savar, Dhaka',
                'workplace_type' => 'on_site',
                'employment_type' => 'full_time',
                'vacancies' => 3,
                'salary_type' => 'fixed',
                'salary_min' => 32000,
                'salary_max' => null,
                'currency' => 'BDT',
                'cover_image' => 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?auto=format&fit=crop&w=1200&h=675&q=80',
                'show_salary' => true,
                'short_description' => 'Conduct inbound raw material verification, in-process analytical checks, and finished packaging inspection for quality assurance.',
                'description' => "The Quality Control Officer will ensure that all incoming raw chemicals, in-process mixtures, and finished formulations comply with Adonis standard operating procedures and regulatory requirements. Position is based at our Savar Quality Assurance Laboratory.",
                'responsibilities' => "- Sample and test raw chemicals (surfactants, solvents, polymers) upon arrival at Savar plant.\n- Perform physical-chemical tests (pH, viscosity, specific gravity, refractive index).\n- Issue Certificate of Analysis (COA) for released production lots.\n- Maintain calibrated state of all laboratory analytical balances and equipment.",
                'education_requirements' => "B.Sc in Chemistry, Applied Chemistry, or Diploma in Chemical Engineering.",
                'experience_requirements' => "Minimum 2–3 years in QC lab operations within chemical or pharmaceutical manufacturing.",
                'additional_requirements' => "- Detail-oriented with accurate record keeping.\n- Ability to work rotational day/evening shifts at Savar.",
                'benefits' => "- Festival bonuses\n- Subsidized meals at plant canteen\n- Overtime allowance",
                'application_deadline' => now()->addDays(28)->toDateString(),
                'status' => 'published',
                'allow_applications' => true,
                'published_at' => now(),
                'created_by' => $adminId,
            ]);

            // Questions for Job 2
            CareerJobQuestion::create([
                'career_job_id' => $job2->id,
                'question' => 'Highest Academic Qualification in Chemistry or Science?',
                'type' => 'select',
                'options' => ['B.Sc in Chemistry / Applied Chemistry', 'M.Sc in Chemistry', 'Diploma in Chemical Engineering', 'B.Pharm', 'Other'],
                'is_required' => true,
                'sort_order' => 1,
                'is_active' => true,
            ]);

            CareerJobQuestion::create([
                'career_job_id' => $job2->id,
                'question' => 'Are you willing to work on-site in Savar, Dhaka?',
                'type' => 'yes_no',
                'options' => null,
                'is_required' => true,
                'sort_order' => 2,
                'is_active' => true,
            ]);
        }

        // Job 3: Digital Marketing & Brand Executive
        if (!CareerJob::where('slug', 'digital-marketing-brand-executive')->exists()) {
            $job3 = CareerJob::create([
                'title' => 'Digital Marketing & Brand Executive (SINODA Brand)',
                'slug' => 'digital-marketing-brand-executive',
                'department_id' => $createdDepts['sales-corporate-marketing']->id,
                'department_name' => 'Sales & Corporate Marketing',
                'location' => 'Corporate Office, Dhaka & Savar',
                'workplace_type' => 'hybrid',
                'employment_type' => 'full_time',
                'vacancies' => 1,
                'salary_type' => 'range',
                'salary_min' => 28000,
                'salary_max' => 38000,
                'currency' => 'BDT',
                'cover_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&h=675&q=80',
                'show_salary' => true,
                'short_description' => 'Drive online presence, salon influencer partnerships, Meta advertising campaigns, and creative brand storytelling for SINODA products.',
                'description' => "We are seeking an energetic Digital Marketing & Brand Executive to spearhead digital customer engagement for the SINODA salon & personal care brand. You will coordinate social media channels, create engaging visual assets, and run high-converting ad campaigns.",
                'responsibilities' => "- Manage company social media pages (Facebook, Instagram, LinkedIn, YouTube).\n- Plan and optimize Meta Ads campaigns targeted at salon owners and retail consumers.\n- Coordinate photography and video production for new formulation product launches.\n- Track ROI, website inquiries, and commercial engagement metrics.",
                'education_requirements' => "Bachelor's degree in Marketing, Media, Business Administration, or related discipline.",
                'experience_requirements' => "Minimum 2 years of demonstrable digital marketing and campaign management experience.",
                'additional_requirements' => "- Proficiency with Meta Ads Manager, Canva, Photoshop, or video editing tools.\n- Strong copywriting skills in Bengali and English.",
                'benefits' => "- Two festival bonuses\n- Hybrid work flexibility\n- Mobile and internet allowance",
                'application_deadline' => now()->addDays(20)->toDateString(),
                'status' => 'published',
                'allow_applications' => true,
                'published_at' => now(),
                'created_by' => $adminId,
            ]);

            CareerJobQuestion::create([
                'career_job_id' => $job3->id,
                'question' => 'Portfolio or Campaign Links (Behance, Google Drive, or Social Links)',
                'type' => 'text',
                'options' => null,
                'is_required' => false,
                'sort_order' => 1,
                'is_active' => true,
            ]);

            CareerJobQuestion::create([
                'career_job_id' => $job3->id,
                'question' => 'Which digital marketing platforms have you actively run ad campaigns on?',
                'type' => 'multi_checkbox',
                'options' => ['Meta Ads (Facebook / Instagram)', 'Google Ads & Search', 'TikTok Ads', 'YouTube Video Campaigns', 'Email Marketing'],
                'is_required' => true,
                'sort_order' => 2,
                'is_active' => true,
            ]);
        }

        // Job 4: Industrial Plant Maintenance Engineer
        if (!CareerJob::where('slug', 'industrial-plant-maintenance-engineer')->exists()) {
            CareerJob::create([
                'title' => 'Industrial Plant Maintenance Engineer',
                'slug' => 'industrial-plant-maintenance-engineer',
                'department_id' => $createdDepts['production-manufacturing']->id,
                'department_name' => 'Production & Manufacturing',
                'location' => 'Genda, Karnapara, Savar, Dhaka',
                'workplace_type' => 'on_site',
                'employment_type' => 'full_time',
                'vacancies' => 1,
                'salary_type' => 'negotiable',
                'salary_min' => null,
                'salary_max' => null,
                'currency' => 'BDT',
                'cover_image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&h=675&q=80',
                'show_salary' => false,
                'short_description' => 'Oversee preventive maintenance, boiler and pump operations, mixing vessels, and automated filling equipment at the Savar manufacturing facility.',
                'description' => "Responsible for the mechanical, electrical, and pneumatic upkeep of chemical processing tanks, high-shear homogenizers, liquid tube fillers, and boiler utility systems at Savar Plant.",
                'responsibilities' => "- Implement daily preventive maintenance schedules across filling and formulation machinery.\n- Troubleshoot mechanical breakdowns and minimize factory downtime.\n- Maintain inventory of critical spare parts and manage technical technicians.",
                'education_requirements' => "B.Sc or Diploma in Mechanical or Electrical Engineering.",
                'experience_requirements' => "Minimum 3–5 years in industrial chemical or FMCG plant maintenance.",
                'additional_requirements' => "- Sound knowledge of 3-phase electrical panels, PLC controllers, and steam boilers.",
                'benefits' => "- Festival bonuses\n- Plant housing / transportation support\n- Performance incentive",
                'application_deadline' => now()->addDays(40)->toDateString(),
                'status' => 'published',
                'allow_applications' => true,
                'published_at' => now(),
                'created_by' => $adminId,
            ]);
        }

        // 5. Create Sample Dummy CV files in storage/app/private/careers/
        $samplePdfDir = storage_path('app/private/careers/1/2026/10');
        if (!File::exists($samplePdfDir)) {
            File::makeDirectory($samplePdfDir, 0755, true);
        }

        // Minimal valid 1-page PDF file content for preview demonstration
        $dummyPdfContent = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 595 842]/Parent 2 0 R/Resources<<>>/Contents 4 0 R>>endobj\n4 0 obj<</Length 55>>stream\nBT /F1 18 Tf 50 750 Td (Candidate Curriculum Vitae - Sample PDF Preview) Tj ET\nendstream\nendobj\nxref\n0 5\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000216 00000 n \ntrailer<</Size 5/Root 1 0 R>>\nstartxref\n320\n%%EOF\n";

        $samplePdfPath1 = $samplePdfDir . '/sample-chemist-cv.pdf';
        $samplePdfPath2 = $samplePdfDir . '/sample-qc-cv.pdf';
        $samplePdfPath3 = $samplePdfDir . '/sample-marketing-cv.pdf';

        File::put($samplePdfPath1, $dummyPdfContent);
        File::put($samplePdfPath2, $dummyPdfContent);
        File::put($samplePdfPath3, $dummyPdfContent);

        // 6. Seed Sample Candidate Applications
        $targetJob1 = CareerJob::where('slug', 'senior-formulation-chemist')->first();
        $targetJob2 = CareerJob::where('slug', 'quality-control-officer')->first();
        $targetJob3 = CareerJob::where('slug', 'digital-marketing-brand-executive')->first();

        if ($targetJob1 && !CareerApplication::where('email', 'tanvir.chemist@example.com')->exists()) {
            
            // Applicant 1
            $app1 = CareerApplication::create([
                'career_job_id' => $targetJob1->id,
                'reference' => 'APP-2026-000101',
                'name' => 'Tanvir Hasan',
                'email' => 'tanvir.chemist@example.com',
                'phone' => '+880 1711-234567',
                'cv_original_name' => 'Tanvir_Hasan_Formulation_Chemist_CV.pdf',
                'cv_storage_path' => 'careers/1/2026/10/sample-chemist-cv.pdf',
                'cv_mime_type' => 'application/pdf',
                'cv_size' => 102400,
                'status' => 'shortlisted',
                'internal_notes' => 'Strong background in personal care formulation at Square Toiletries. High potential candidate for second technical interview.',
                'applied_at' => now()->subDays(3),
            ]);

            CareerApplicationStatusLog::create([
                'career_application_id' => $app1->id,
                'old_status' => null,
                'new_status' => 'pending',
                'notes' => 'Application submitted online.',
                'created_at' => now()->subDays(3),
            ]);

            CareerApplicationStatusLog::create([
                'career_application_id' => $app1->id,
                'old_status' => 'pending',
                'new_status' => 'shortlisted',
                'changed_by' => $adminId,
                'notes' => 'Shortlisted by R&D Director based on surfactant expertise.',
                'created_at' => now()->subDays(1),
            ]);

            // Applicant 2
            $app2 = CareerApplication::create([
                'career_job_id' => $targetJob1->id,
                'reference' => 'APP-2026-000102',
                'name' => 'Dr. Nusrat Jahan',
                'email' => 'nusrat.jahan@example.com',
                'phone' => '+880 1819-876543',
                'cv_original_name' => 'Nusrat_Jahan_Resume_2026.pdf',
                'cv_storage_path' => 'careers/1/2026/10/sample-chemist-cv.pdf',
                'cv_mime_type' => 'application/pdf',
                'cv_size' => 204800,
                'status' => 'under_review',
                'internal_notes' => 'Ph.D in Applied Chemistry from DU. Extensive research papers on natural emulsifiers.',
                'applied_at' => now()->subDays(2),
            ]);

            CareerApplicationStatusLog::create([
                'career_application_id' => $app2->id,
                'old_status' => null,
                'new_status' => 'pending',
                'notes' => 'Application submitted online.',
                'created_at' => now()->subDays(2),
            ]);

            CareerApplicationStatusLog::create([
                'career_application_id' => $app2->id,
                'old_status' => 'pending',
                'new_status' => 'under_review',
                'changed_by' => $adminId,
                'notes' => 'Under technical panel review.',
                'created_at' => now()->subDay(),
            ]);

            // Applicant 3
            $app3 = CareerApplication::create([
                'career_job_id' => $targetJob1->id,
                'reference' => 'APP-2026-000103',
                'name' => 'Mahmudul Karim',
                'email' => 'mahmud.karim@example.com',
                'phone' => '+880 1912-345678',
                'cv_original_name' => 'Mahmudul_Karim_CV.pdf',
                'cv_storage_path' => 'careers/1/2026/10/sample-chemist-cv.pdf',
                'cv_mime_type' => 'application/pdf',
                'cv_size' => 153600,
                'status' => 'pending',
                'internal_notes' => null,
                'applied_at' => now()->subHours(8),
            ]);

            CareerApplicationStatusLog::create([
                'career_application_id' => $app3->id,
                'old_status' => null,
                'new_status' => 'pending',
                'notes' => 'Application submitted online.',
                'created_at' => now()->subHours(8),
            ]);
        }

        if ($targetJob2 && !CareerApplication::where('email', 'sumon.qc@example.com')->exists()) {
            // Applicant 4 (QC - Interview Scheduled)
            $app4 = CareerApplication::create([
                'career_job_id' => $targetJob2->id,
                'reference' => 'APP-2026-000104',
                'name' => 'Sumon Roy',
                'email' => 'sumon.qc@example.com',
                'phone' => '+880 1622-998877',
                'cv_original_name' => 'Sumon_Roy_QC_Officer.pdf',
                'cv_storage_path' => 'careers/1/2026/10/sample-qc-cv.pdf',
                'cv_mime_type' => 'application/pdf',
                'cv_size' => 184320,
                'status' => 'interview_scheduled',
                'internal_notes' => 'Interview invitation dispatched for 10 Oct 2026, 11:30 AM at Savar Plant QA room.',
                'applied_at' => now()->subDays(5),
            ]);

            CareerApplicationStatusLog::create([
                'career_application_id' => $app4->id,
                'old_status' => 'shortlisted',
                'new_status' => 'interview_scheduled',
                'changed_by' => $adminId,
                'notes' => 'Interview scheduled for 10 Oct 2026.',
                'created_at' => now()->subDays(1),
            ]);

            CareerEmailLog::create([
                'career_application_id' => $app4->id,
                'career_job_id' => $targetJob2->id,
                'email_type' => 'interview_invitation',
                'recipient_email' => 'sumon.qc@example.com',
                'cc' => ['hr@adonischemical.com'],
                'bcc' => null,
                'subject' => 'Interview Invitation — Quality Control Officer [Adonis Chemical]',
                'body' => "Dear Sumon Roy,\n\nCongratulations. You have been shortlisted for an interview on 10 Oct 2026 at Savar Plant QA Lab.\n\nRegards,\nHR Team",
                'status' => 'sent',
                'sent_by' => $adminId,
                'sent_at' => now()->subDays(1),
            ]);
        }

        if ($targetJob3 && !CareerApplication::where('email', 'sadia.marketing@example.com')->exists()) {
            // Applicant 5 (Marketing - Selected)
            $app5 = CareerApplication::create([
                'career_job_id' => $targetJob3->id,
                'reference' => 'APP-2026-000105',
                'name' => 'Sadia Islam',
                'email' => 'sadia.marketing@example.com',
                'phone' => '+880 1788-554433',
                'cv_original_name' => 'Sadia_Islam_Digital_Marketer_CV.pdf',
                'cv_storage_path' => 'careers/1/2026/10/sample-marketing-cv.pdf',
                'cv_mime_type' => 'application/pdf',
                'cv_size' => 256000,
                'status' => 'selected',
                'internal_notes' => 'Cleared practical design and Meta Ads task with 95% score. Selected for appointment.',
                'applied_at' => now()->subDays(7),
            ]);

            CareerApplicationStatusLog::create([
                'career_application_id' => $app5->id,
                'old_status' => 'interviewed',
                'new_status' => 'selected',
                'changed_by' => $adminId,
                'notes' => 'Selected by Management Committee.',
                'created_at' => now()->subDays(1),
            ]);
        }
    }
}
