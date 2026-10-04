@extends('layouts.admin')

@section('title', 'Edit Job: ' . $job->title . ' | Admin CMS')
@section('page_title', 'Edit Career Vacancy')
@section('page_subtitle', 'Update job details, salary structure, requirements, and custom screening questions')

@section('content')

    <form action="{{ route('admin.careers.jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data" id="job-form" class="space-y-8 max-w-5xl">
        @csrf
        @method('PUT')

        <!-- 1. Basic Information Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-6">
            <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-brand-blue"></i>
                <span>1. General Position Details</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                
                <!-- Position Title -->
                <div class="sm:col-span-2 lg:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Position Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="job-title" value="{{ old('title', $job->title) }}" required placeholder="e.g. Senior Formulation Chemist" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">
                    @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        URL Slug <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="slug" id="job-slug" value="{{ old('slug', $job->slug) }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition font-mono text-xs">
                    @error('slug') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Department -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Department
                    </label>
                    <select name="department_id" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none bg-white text-slate-700">
                        <option value="">-- Select or Free Type Below --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $job->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Department Name Fallback -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Custom Department Title
                    </label>
                    <input type="text" name="department_name" value="{{ old('department_name', $job->department_name) }}" placeholder="e.g. Research & Development" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Job Location <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="location" value="{{ old('location', $job->location) }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">
                </div>

                <!-- Workplace Type -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Workplace Type <span class="text-rose-500">*</span>
                    </label>
                    <select name="workplace_type" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none bg-white text-slate-700">
                        <option value="on_site" {{ old('workplace_type', $job->workplace_type) === 'on_site' ? 'selected' : '' }}>On-site (Plant / Office)</option>
                        <option value="remote" {{ old('workplace_type', $job->workplace_type) === 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="hybrid" {{ old('workplace_type', $job->workplace_type) === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>

                <!-- Employment Type -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Employment Type <span class="text-rose-500">*</span>
                    </label>
                    <select name="employment_type" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none bg-white text-slate-700">
                        <option value="full_time" {{ old('employment_type', $job->employment_type) === 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ old('employment_type', $job->employment_type) === 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contractual" {{ old('employment_type', $job->employment_type) === 'contractual' ? 'selected' : '' }}>Contractual</option>
                        <option value="internship" {{ old('employment_type', $job->employment_type) === 'internship' ? 'selected' : '' }}>Internship</option>
                    </select>
                </div>

                <!-- Vacancies -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Number of Vacancies <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="vacancies" min="1" max="100" value="{{ old('vacancies', $job->vacancies) }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">
                </div>

            </div>
        </div>

        <!-- Cover Image Card (16:9) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy flex items-center gap-2">
                    <i class="fa-solid fa-image text-brand-blue"></i>
                    <span>Cover Image (16:9 Aspect Ratio)</span>
                </h3>
                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-brand-blue border border-blue-100">
                    Recommended 1200 × 675 px (16:9)
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                <!-- Preview Frame -->
                <div class="md:col-span-5">
                    <div class="aspect-[16/9] w-full rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden relative group flex items-center justify-center shadow-inner" id="cover-preview-container">
                        <img id="cover-preview-img" src="{{ $job->cover_image_url }}" alt="{{ $job->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-semibold pointer-events-none">
                            <i class="fa-solid fa-camera mr-1.5"></i> 16:9 Aspect Ratio Preview
                        </div>
                    </div>
                </div>

                <!-- Input Options -->
                <div class="md:col-span-7 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Upload New Image File (JPEG, PNG, WEBP &le; 4MB)
                        </label>
                        <input type="file" name="cover_image" id="cover-image-input" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-brand-blue hover:file:bg-blue-100 file:cursor-pointer border border-slate-200 rounded-xl p-1">
                        @error('cover_image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="h-px bg-slate-200 flex-1"></div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase">OR Image URL</span>
                        <div class="h-px bg-slate-200 flex-1"></div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Direct Image URL (Optional)
                        </label>
                        <input type="url" name="cover_image_url" id="cover-url-input" value="{{ old('cover_image_url', str_starts_with($job->cover_image ?? '', 'http') ? $job->cover_image : '') }}" placeholder="https://images.unsplash.com/... or /uploads/..." class="w-full px-4 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">
                        <p class="text-[11px] text-slate-400 mt-1">If empty, fallback cover image remains active.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Compensation & Salary -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-6">
            <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-money-bill-wave text-emerald-600"></i>
                <span>2. Compensation & Salary</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- Salary Type -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Salary Structure <span class="text-rose-500">*</span>
                    </label>
                    <select name="salary_type" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none bg-white text-slate-700">
                        <option value="negotiable" {{ old('salary_type', $job->salary_type) === 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                        <option value="fixed" {{ old('salary_type', $job->salary_type) === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        <option value="range" {{ old('salary_type', $job->salary_type) === 'range' ? 'selected' : '' }}>Salary Range</option>
                        <option value="hidden" {{ old('salary_type', $job->salary_type) === 'hidden' ? 'selected' : '' }}>Hide Salary</option>
                    </select>
                </div>

                <!-- Minimum Salary -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Minimum / Fixed Amount
                    </label>
                    <input type="number" step="500" name="salary_min" value="{{ old('salary_min', $job->salary_min ? (int)$job->salary_min : '') }}" placeholder="e.g. 35000" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">
                </div>

                <!-- Maximum Salary -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Maximum Amount (Range)
                    </label>
                    <input type="number" step="500" name="salary_max" value="{{ old('salary_max', $job->salary_max ? (int)$job->salary_max : '') }}" placeholder="e.g. 50000" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">
                </div>

                <!-- Currency -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Currency
                    </label>
                    <input type="text" name="currency" value="{{ old('currency', $job->currency) }}" placeholder="BDT" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition uppercase">
                </div>

                <!-- Show Salary Toggle -->
                <div class="sm:col-span-2 lg:col-span-4 pt-2">
                    <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="show_salary" value="1" {{ old('show_salary', $job->show_salary) ? 'checked' : '' }} class="w-4 h-4 text-brand-blue rounded border-slate-300 focus:ring-brand-blue">
                        <span>Display salary figure publicly on career cards</span>
                    </label>
                </div>

            </div>
        </div>

        <!-- 3. Job Description & Requirements -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-6">
            <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-file-lines text-indigo-600"></i>
                <span>3. Job Content & Qualifications</span>
            </h3>

            <div class="space-y-5">
                
                <!-- Short Description -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Short Summary / Tagline <span class="text-slate-400 font-normal">(Visible on listing cards)</span>
                    </label>
                    <textarea name="short_description" rows="2" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">{{ old('short_description', $job->short_description) }}</textarea>
                </div>

                <!-- Full Description -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Full Job Description & Role Context
                    </label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">{{ old('description', $job->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <!-- Responsibilities -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Key Responsibilities (One per line or paragraph)
                        </label>
                        <textarea name="responsibilities" rows="5" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">{{ old('responsibilities', $job->responsibilities) }}</textarea>
                    </div>

                    <!-- Education -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Education & Academic Requirements
                        </label>
                        <textarea name="education_requirements" rows="5" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">{{ old('education_requirements', $job->education_requirements) }}</textarea>
                    </div>

                    <!-- Experience -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Experience Requirements
                        </label>
                        <textarea name="experience_requirements" rows="4" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">{{ old('experience_requirements', $job->experience_requirements) }}</textarea>
                    </div>

                    <!-- Additional Requirements -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Additional Skills & Certifications
                        </label>
                        <textarea name="additional_requirements" rows="4" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">{{ old('additional_requirements', $job->additional_requirements) }}</textarea>
                    </div>

                </div>

                <!-- Benefits -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Employee Benefits & Perks
                    </label>
                    <textarea name="benefits" rows="3" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition">{{ old('benefits', $job->benefits) }}</textarea>
                </div>

            </div>
        </div>

        <!-- 4. Dynamic Custom Question Builder -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-6" id="question-builder-section">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-question text-purple-600"></i>
                        <span>4. Application Custom Questions</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Configure tailored screening questions candidates must answer during application</p>
                </div>
                
                <button type="button" id="add-question-btn" class="px-4 py-2 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 font-bold text-xs transition inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-plus"></i>
                    <span>Add Question</span>
                </button>
            </div>

            <!-- Dynamic Question List Container -->
            <div id="questions-container" class="space-y-4">
                <!-- Prepopulated with existing questions -->
            </div>

            <div id="empty-questions-notice" class="py-6 text-center text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-xs hidden">
                No custom questions configured. Candidates will only submit their standard profile and CV.
            </div>
        </div>

        <!-- 5. Publishing & Deadlines -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-6">
            <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-sliders text-cyan-600"></i>
                <span>5. Publishing & Availability</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                
                <!-- Status -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Job Status <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none bg-white text-slate-700">
                        <option value="published" {{ old('status', $job->status) === 'published' ? 'selected' : '' }}>Published (Active & Visible)</option>
                        <option value="draft" {{ old('status', $job->status) === 'draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                        <option value="closed" {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}>Closed (Applications Disabled)</option>
                        <option value="archived" {{ old('status', $job->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <!-- Application Deadline -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Application Deadline
                    </label>
                    <input type="date" name="application_deadline" value="{{ old('application_deadline', $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none transition bg-white">
                </div>

                <!-- Allow Applications Toggle -->
                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-2.5 text-xs font-bold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="allow_applications" value="1" {{ old('allow_applications', $job->allow_applications) ? 'checked' : '' }} class="w-4 h-4 text-brand-blue rounded border-slate-300 focus:ring-brand-blue">
                        <span>Accepting Online Applications</span>
                    </label>
                </div>

            </div>
        </div>

        <!-- Submit Bar -->
        <div class="flex items-center justify-between gap-4 pt-4">
            <a href="{{ route('careers.show', $job->slug) }}" target="_blank" class="text-xs font-bold text-brand-blue hover:underline flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Preview Public Page</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.careers.jobs.index') }}" class="px-6 py-3 rounded-full text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                    Cancel
                </a>
                <button type="submit" class="btn-scientific-primary text-xs !py-3.5 !px-8 shadow-lg shadow-blue-500/30">
                    <i class="fa-solid fa-check mr-1"></i>
                    <span>Update Job Vacancy</span>
                </button>
            </div>
        </div>

    </form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('add-question-btn');
        const container = document.getElementById('questions-container');
        const emptyNotice = document.getElementById('empty-questions-notice');

        let questionIndex = 0;

        function updateEmptyState() {
            if (container.children.length === 0) {
                emptyNotice.classList.remove('hidden');
            } else {
                emptyNotice.classList.add('hidden');
            }
        }

        function createQuestionCard(data = {}) {
            const index = questionIndex++;
            const card = document.createElement('div');
            card.className = 'p-5 rounded-2xl bg-slate-50 border border-slate-200 relative space-y-4 question-card';
            card.dataset.index = index;

            const qId = data.id || '';
            const qText = data.question || '';
            const qType = data.type || 'text';
            const qOpts = Array.isArray(data.options) ? data.options.join('\n') : (data.options || '');
            const qReq = data.is_required ? 'checked' : '';

            card.innerHTML = `
                ${qId ? `<input type="hidden" name="questions[${index}][id]" value="${qId}">` : ''}

                <div class="flex items-center justify-between gap-2 border-b border-slate-200/80 pb-2.5">
                    <span class="text-xs font-bold text-purple-700 flex items-center gap-1.5">
                        <i class="fa-solid fa-grip-vertical text-slate-400"></i>
                        <span>Question</span>
                    </span>
                    <button type="button" class="remove-q-btn text-rose-500 hover:text-rose-700 p-1 text-xs font-bold flex items-center gap-1">
                        <i class="fa-solid fa-trash"></i> Remove
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="sm:col-span-8">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">
                            Question Title / Prompt *
                        </label>
                        <input type="text" name="questions[${index}][question]" value="${qText}" required placeholder="e.g. Do you have experience managing laboratory tests?" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:border-brand-blue outline-none bg-white">
                    </div>

                    <div class="sm:col-span-4">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">
                            Response Type *
                        </label>
                        <select name="questions[${index}][type]" class="q-type-select w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:border-brand-blue outline-none bg-white text-slate-700">
                            <option value="text" ${qType === 'text' ? 'selected' : ''}>Short Text</option>
                            <option value="textarea" ${qType === 'textarea' ? 'selected' : ''}>Paragraph / Long Text</option>
                            <option value="number" ${qType === 'number' ? 'selected' : ''}>Number</option>
                            <option value="email" ${qType === 'email' ? 'selected' : ''}>Email</option>
                            <option value="phone" ${qType === 'phone' ? 'selected' : ''}>Phone</option>
                            <option value="date" ${qType === 'date' ? 'selected' : ''}>Date</option>
                            <option value="yes_no" ${qType === 'yes_no' ? 'selected' : ''}>Yes / No</option>
                            <option value="select" ${qType === 'select' ? 'selected' : ''}>Dropdown Menu</option>
                            <option value="radio" ${qType === 'radio' ? 'selected' : ''}>Single Choice (Radio)</option>
                            <option value="multi_checkbox" ${qType === 'multi_checkbox' ? 'selected' : ''}>Multiple Choice (Checkboxes)</option>
                            <option value="checkbox" ${qType === 'checkbox' ? 'selected' : ''}>Single Checkbox</option>
                        </select>
                    </div>

                    <!-- Dynamic Options Box for Select / Radio / Multi Checkbox -->
                    <div class="sm:col-span-12 options-box ${['select', 'radio', 'multi_checkbox'].includes(qType) ? '' : 'hidden'}">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">
                            Options (One choice per line)
                        </label>
                        <textarea name="questions[${index}][options]" rows="3" placeholder="Option 1&#10;Option 2&#10;Option 3" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-300 focus:border-brand-blue outline-none bg-white">${qOpts}</textarea>
                    </div>

                    <div class="sm:col-span-12 pt-1 flex items-center justify-between">
                        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                            <input type="checkbox" name="questions[${index}][is_required]" value="1" ${qReq} class="w-4 h-4 text-brand-blue rounded border-slate-300 focus:ring-brand-blue">
                            <span>Mandatory Question (Applicant must answer)</span>
                        </label>
                    </div>
                </div>
            `;

            // Event Listeners
            const removeBtn = card.querySelector('.remove-q-btn');
            removeBtn.addEventListener('click', function() {
                card.remove();
                updateEmptyState();
            });

            const typeSelect = card.querySelector('.q-type-select');
            const optionsBox = card.querySelector('.options-box');
            typeSelect.addEventListener('change', function() {
                if (['select', 'radio', 'multi_checkbox'].includes(this.value)) {
                    optionsBox.classList.remove('hidden');
                } else {
                    optionsBox.classList.add('hidden');
                }
            });

            container.appendChild(card);
            updateEmptyState();
        }

        if (addBtn) {
            addBtn.addEventListener('click', function() {
                createQuestionCard();
            });
        }

        // Preload Existing Questions
        const existingQuestions = @json($job->questions);
        if (existingQuestions && existingQuestions.length > 0) {
            existingQuestions.forEach(q => {
                createQuestionCard(q);
            });
        }

        updateEmptyState();

        // Cover Image Preview
        const coverInput = document.getElementById('cover-image-input');
        const coverUrlInput = document.getElementById('cover-url-input');
        const coverImg = document.getElementById('cover-preview-img');

        if (coverInput && coverImg) {
            coverInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        coverImg.src = evt.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (coverUrlInput && coverImg) {
            coverUrlInput.addEventListener('input', function() {
                if (this.value.trim().length > 5) {
                    coverImg.src = this.value.trim();
                }
            });
        }
    });
</script>
@endpush
