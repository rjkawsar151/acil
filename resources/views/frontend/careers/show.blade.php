@extends('layouts.app')

@section('title', $job->title . ' | Careers at ' . \App\Models\Setting::get('site_name', 'Adonis Chemical Industries Ltd.'))
@section('meta_description', Str::limit(strip_tags($job->short_description ?: $job->description), 160))

@section('content')

    <!-- Header Breadcrumb & Job Banner -->
    <section class="bg-gradient-to-r from-[#071B33] to-[#0D305C] text-white py-10 sm:py-12 lg:py-16 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumbs with smooth mobile horizontal scroll -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-5 sm:mb-6 overflow-x-auto whitespace-nowrap pb-1 scrollbar-none">
                <a href="{{ route('home') }}" class="hover:text-brand-cyan transition flex items-center gap-1.5 flex-shrink-0">
                    <i class="fa-solid fa-house text-[11px]"></i>
                    <span>Home</span>
                </a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 flex-shrink-0"></i>
                <a href="{{ route('careers.index') }}" class="hover:text-brand-cyan transition flex-shrink-0">Careers</a>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 flex-shrink-0"></i>
                <span class="text-slate-200 font-medium truncate max-w-[200px] sm:max-w-md">{{ $job->title }}</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="flex flex-wrap items-center gap-2 sm:gap-2.5 mb-3">
                        <span class="px-3 py-1 rounded-full text-[11px] sm:text-xs font-bold uppercase tracking-wider bg-brand-cyan/20 text-brand-cyan border border-brand-cyan/30">
                            {{ $job->effective_department_name }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full text-[11px] sm:text-xs font-semibold bg-white/10 text-slate-200">
                            {{ $job->employment_type_label }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full text-[11px] sm:text-xs font-semibold bg-white/10 text-slate-200">
                            {{ $job->workplace_type_label }}
                        </span>
                        @if(!$job->is_accepting_applications)
                            <span class="px-2.5 py-1 rounded-full text-[11px] sm:text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/40">
                                Applications Closed
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight mb-3 sm:mb-4 break-words">
                        {{ $job->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-y-2 gap-x-4 sm:gap-x-6 text-xs sm:text-sm text-slate-300">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-location-dot text-brand-cyan text-xs"></i>
                            <span>{{ $job->location }}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-money-bill-wave text-emerald-400 text-xs"></i>
                            <span>{{ $job->formatted_salary }}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-day text-blue-400 text-xs"></i>
                            <span>Deadline: {{ $job->application_deadline ? $job->application_deadline->format('d M Y') : 'Open Until Filled' }}</span>
                        </span>
                    </div>
                </div>

                @if($job->is_accepting_applications)
                    <div class="pt-2 sm:pt-0">
                        <a href="#application-form-section" class="w-full sm:w-auto inline-flex items-center justify-center btn-scientific-primary text-sm !py-3.5 !px-8 shadow-lg shadow-blue-500/30">
                            <i class="fa-solid fa-paper-plane mr-2"></i>
                            <span>Apply for this Position</span>
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </section>

    <!-- Main Content Area & Reordered Responsive Grid -->
    <section class="py-10 sm:py-16 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-10">
                
                <!-- 1. Position Snapshot / Job Overview Card (Top of page on mobile, right sticky sidebar on desktop) -->
                <div class="order-1 lg:order-2 lg:col-span-4 space-y-6">
                    
                    <!-- Job Summary Card -->
                    <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-slate-200/90 shadow-sm lg:sticky lg:top-24 space-y-5 sm:space-y-6 overflow-hidden">
                        
                        <!-- 16:9 Cover Image -->
                        <div class="-mx-5 -mt-5 sm:-mx-6 sm:-mt-6 mb-4 relative aspect-[16/9] w-[calc(100%+2.5rem)] sm:w-[calc(100%+3rem)] overflow-hidden bg-slate-100">
                            <img src="{{ $job->cover_image_url }}" alt="{{ $job->title }}" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/10"></div>
                            <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-[11px] font-semibold drop-shadow">
                                <span class="bg-blue-600/90 px-2.5 py-0.5 rounded-full backdrop-blur-sm uppercase tracking-wide text-[10px]">{{ $job->effective_department_name }}</span>
                                <span class="bg-white/90 text-slate-800 px-2.5 py-0.5 rounded-full backdrop-blur-sm text-[10px]">{{ $job->employment_type_label }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h3 class="text-base sm:text-lg font-bold text-[#071B33] flex items-center gap-2">
                                <i class="fa-solid fa-id-card-clip text-blue-600"></i>
                                <span>Position Snapshot</span>
                            </h3>
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Job Overview</span>
                        </div>

                        <!-- Snapshot attributes grid (1 col on phone, 2 cols on tablet, 1 col on desktop sidebar) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3.5 sm:gap-4 text-xs">
                            
                            <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/80 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm flex-shrink-0">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-semibold text-[11px]">Department</span>
                                    <span class="text-slate-800 font-bold leading-tight">{{ $job->effective_department_name }}</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/80 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm flex-shrink-0">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-semibold text-[11px]">Employment Type</span>
                                    <span class="text-slate-800 font-bold leading-tight">{{ $job->employment_type_label }} ({{ $job->workplace_type_label }})</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/80 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-sm flex-shrink-0">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-semibold text-[11px]">Vacancies</span>
                                    <span class="text-slate-800 font-bold leading-tight">{{ $job->vacancies }} {{ Str::plural('Post', $job->vacancies) }}</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/80 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center text-sm flex-shrink-0">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-semibold text-[11px]">Offered Salary</span>
                                    <span class="text-slate-800 font-bold leading-tight">{{ $job->formatted_salary }}</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/80 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm flex-shrink-0">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-semibold text-[11px]">Application Deadline</span>
                                    <span class="text-slate-800 font-bold leading-tight">{{ $job->application_deadline ? $job->application_deadline->format('d M Y') : 'Open Until Filled' }}</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/80 border border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-sm flex-shrink-0">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-semibold text-[11px]">Location</span>
                                    <span class="text-slate-800 font-bold leading-tight">{{ $job->location }}</span>
                                </div>
                            </div>

                        </div>

                        @if($job->is_accepting_applications)
                            <div class="pt-2">
                                <a href="#application-form-section" class="w-full btn-corporate-primary text-xs sm:text-sm !py-3 justify-center shadow-sm">
                                    <i class="fa-solid fa-file-signature mr-1.5"></i>
                                    <span>Apply for this Role</span>
                                </a>
                            </div>
                        @endif

                        <!-- Share Job -->
                        <div class="pt-4 border-t border-slate-100">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-2.5">Share This Opportunity</span>
                            <div class="flex items-center gap-2 sm:gap-2.5">
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-[#0A66C2] text-slate-600 hover:text-white flex items-center justify-center text-sm transition" title="Share on LinkedIn">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-[#1877F2] text-slate-600 hover:text-white flex items-center justify-center text-sm transition" title="Share on Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($job->title . ' at Adonis Chemical: ' . url()->current()) }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-[#25D366] text-slate-600 hover:text-white flex items-center justify-center text-sm transition" title="Share on WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <button type="button" onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Job link copied to clipboard!');" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-brand-blue text-slate-600 hover:text-white flex items-center justify-center text-sm transition" title="Copy Link">
                                    <i class="fa-solid fa-link"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Related Jobs (Desktop Sidebar) -->
                    @if($relatedJobs->count() > 0)
                        <div class="hidden lg:block bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                            <h4 class="text-sm font-bold text-[#071B33] flex items-center gap-2">
                                <i class="fa-solid fa-briefcase text-blue-600"></i>
                                <span>Other Open Roles</span>
                            </h4>
                            <div class="space-y-3">
                                @foreach($relatedJobs as $rel)
                                    <a href="{{ route('careers.show', $rel->slug) }}" class="block p-3 rounded-xl hover:bg-blue-50/50 border border-slate-100 hover:border-blue-200 transition group">
                                        <p class="text-xs font-bold text-[#071B33] group-hover:text-blue-600 transition leading-snug">{{ $rel->title }}</p>
                                        <p class="text-[11px] text-slate-500 mt-1">{{ $rel->location }} • {{ $rel->employment_type_label }}</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                <!-- 2. Main Details Content & Application Form (Order 2 on mobile, left 8 cols on desktop) -->
                <div class="order-2 lg:order-1 lg:col-span-8 space-y-8 sm:space-y-10">
                    
                    <!-- Job Summary / Description -->
                    <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 border border-slate-200/90 shadow-sm space-y-6">
                        
                        @if($job->short_description)
                            <div class="p-4 sm:p-5 rounded-2xl bg-blue-50/70 border border-blue-100 text-slate-700 text-xs sm:text-sm leading-relaxed font-medium">
                                {{ $job->short_description }}
                            </div>
                        @endif

                        @if($job->description)
                            <div>
                                <h3 class="text-base sm:text-lg font-extrabold text-[#071B33] mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-info text-blue-600"></i>
                                    <span>Job Overview</span>
                                </h3>
                                <div class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line prose prose-slate max-w-none">
                                    {!! nl2br(e($job->description)) !!}
                                </div>
                            </div>
                        @endif

                        @if($job->responsibilities)
                            <div class="pt-4 border-t border-slate-100">
                                <h3 class="text-base sm:text-lg font-extrabold text-[#071B33] mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-list-check text-blue-600"></i>
                                    <span>Key Responsibilities & Duties</span>
                                </h3>
                                <div class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line prose prose-slate max-w-none">
                                    {!! nl2br(e($job->responsibilities)) !!}
                                </div>
                            </div>
                        @endif

                        @if($job->education_requirements)
                            <div class="pt-4 border-t border-slate-100">
                                <h3 class="text-base sm:text-lg font-extrabold text-[#071B33] mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-graduation-cap text-blue-600"></i>
                                    <span>Education & Academic Background</span>
                                </h3>
                                <div class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line prose prose-slate max-w-none">
                                    {!! nl2br(e($job->education_requirements)) !!}
                                </div>
                            </div>
                        @endif

                        @if($job->experience_requirements)
                            <div class="pt-4 border-t border-slate-100">
                                <h3 class="text-base sm:text-lg font-extrabold text-[#071B33] mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-briefcase text-blue-600"></i>
                                    <span>Experience Requirements</span>
                                </h3>
                                <div class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line prose prose-slate max-w-none">
                                    {!! nl2br(e($job->experience_requirements)) !!}
                                </div>
                            </div>
                        @endif

                        @if($job->additional_requirements)
                            <div class="pt-4 border-t border-slate-100">
                                <h3 class="text-base sm:text-lg font-extrabold text-[#071B33] mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-award text-blue-600"></i>
                                    <span>Additional Skills & Attributes</span>
                                </h3>
                                <div class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line prose prose-slate max-w-none">
                                    {!! nl2br(e($job->additional_requirements)) !!}
                                </div>
                            </div>
                        @endif

                        @if($job->benefits)
                            <div class="pt-4 border-t border-slate-100">
                                <h3 class="text-base sm:text-lg font-extrabold text-[#071B33] mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-gift text-blue-600"></i>
                                    <span>Compensation & Employee Benefits</span>
                                </h3>
                                <div class="text-xs sm:text-sm text-slate-600 leading-relaxed whitespace-pre-line prose prose-slate max-w-none">
                                    {!! nl2br(e($job->benefits)) !!}
                                </div>
                            </div>
                        @endif

                    </div>

                    <!-- Application Form Section -->
                    <div id="application-form-section" class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 md:p-10 border border-slate-200/90 shadow-sm relative overflow-hidden scroll-mt-24">
                        
                        <!-- Top Accent Banner -->
                        <div class="border-b border-slate-100 pb-5 sm:pb-6 mb-6 sm:mb-8">
                            <span class="badge-scientific text-xs mb-2">Online Application</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-[#071B33]">Apply for This Position</h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                Complete the application details below and attach your CV. Fields marked with an asterisk (<span class="text-rose-500 font-bold">*</span>) are mandatory.
                            </p>
                        </div>

                        @if($job->is_accepting_applications)
                            <form action="{{ route('careers.apply', $job->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-6 sm:space-y-8" id="career-application-form">
                                @csrf
                                
                                <!-- Honeypot Bot Trap -->
                                <input type="text" name="career_bot_check" value="" style="display:none !important;" tabindex="-1" autocomplete="off">

                                <!-- 1. Candidate Information -->
                                <div>
                                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-slate-400 mb-4 pb-2 border-b border-slate-100">
                                        1. Personal & Contact Details
                                    </h3>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                        
                                        <!-- Full Name -->
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                                Full Name <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Rahim Ahmed" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition @error('name') border-rose-400 @enderror">
                                            @error('name')
                                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Email Address -->
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                                Email Address <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@domain.com" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition @error('email') border-rose-400 @enderror">
                                            @error('email')
                                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Phone Number -->
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                                Contact Phone Number <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+880 1700-000000" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition @error('phone') border-rose-400 @enderror">
                                            @error('phone')
                                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <!-- 2. Custom Role-Specific Questions (If Configured) -->
                                @if($job->activeQuestions->count() > 0)
                                    <div>
                                        <h3 class="text-xs font-extrabold uppercase tracking-widest text-slate-400 mb-4 pb-2 border-b border-slate-100">
                                            2. Candidate Questionnaire
                                        </h3>

                                        <div class="space-y-4 sm:space-y-5">
                                            @foreach($job->activeQuestions as $question)
                                                @php
                                                    $fieldId = "answers_{$question->id}";
                                                    $fieldName = "answers[{$question->id}]";
                                                    $oldVal = old("answers.{$question->id}");
                                                @endphp

                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1.5 leading-snug">
                                                        {{ $loop->iteration }}. {{ $question->question }}
                                                        @if($question->is_required)
                                                            <span class="text-rose-500">*</span>
                                                        @else
                                                            <span class="text-slate-400 font-normal text-[11px]">(Optional)</span>
                                                        @endif
                                                    </label>

                                                    @if($question->type === 'textarea')
                                                        <textarea name="{{ $fieldName }}" rows="3" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition" placeholder="Write your response..." {{ $question->is_required ? 'required' : '' }}>{{ $oldVal }}</textarea>

                                                    @elseif($question->type === 'number')
                                                        <input type="number" name="{{ $fieldName }}" value="{{ $oldVal }}" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition" placeholder="Enter number..." {{ $question->is_required ? 'required' : '' }}>

                                                    @elseif($question->type === 'email')
                                                        <input type="email" name="{{ $fieldName }}" value="{{ $oldVal }}" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition" placeholder="name@example.com" {{ $question->is_required ? 'required' : '' }}>

                                                    @elseif($question->type === 'phone')
                                                        <input type="tel" name="{{ $fieldName }}" value="{{ $oldVal }}" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition" placeholder="+880..." {{ $question->is_required ? 'required' : '' }}>

                                                    @elseif($question->type === 'date')
                                                        <input type="date" name="{{ $fieldName }}" value="{{ $oldVal }}" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition bg-white" {{ $question->is_required ? 'required' : '' }}>

                                                    @elseif($question->type === 'yes_no')
                                                        <div class="grid grid-cols-2 gap-3 mt-1">
                                                            <label class="flex items-center justify-center gap-2 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-sm text-slate-700 cursor-pointer transition">
                                                                <input type="radio" name="{{ $fieldName }}" value="Yes" class="w-4 h-4 text-brand-blue border-slate-300 focus:ring-brand-blue" {{ $oldVal === 'Yes' ? 'checked' : '' }} {{ $question->is_required ? 'required' : '' }}>
                                                                <span class="font-semibold">Yes</span>
                                                            </label>
                                                            <label class="flex items-center justify-center gap-2 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-sm text-slate-700 cursor-pointer transition">
                                                                <input type="radio" name="{{ $fieldName }}" value="No" class="w-4 h-4 text-brand-blue border-slate-300 focus:ring-brand-blue" {{ $oldVal === 'No' ? 'checked' : '' }} {{ $question->is_required ? 'required' : '' }}>
                                                                <span class="font-semibold">No</span>
                                                            </label>
                                                        </div>

                                                    @elseif($question->type === 'select' && !empty($question->options))
                                                        <select name="{{ $fieldName }}" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition bg-white text-slate-700" {{ $question->is_required ? 'required' : '' }}>
                                                            <option value="">-- Please Select --</option>
                                                            @foreach($question->options as $opt)
                                                                <option value="{{ $opt }}" {{ $oldVal === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                            @endforeach
                                                        </select>

                                                    @elseif($question->type === 'radio' && !empty($question->options))
                                                        <div class="space-y-2 mt-1">
                                                            @foreach($question->options as $opt)
                                                                <label class="flex items-center gap-3 p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 text-sm text-slate-700 cursor-pointer transition">
                                                                    <input type="radio" name="{{ $fieldName }}" value="{{ $opt }}" class="w-4 h-4 text-brand-blue border-slate-300 focus:ring-brand-blue" {{ $oldVal === $opt ? 'checked' : '' }} {{ $question->is_required ? 'required' : '' }}>
                                                                    <span>{{ $opt }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>

                                                    @elseif($question->type === 'multi_checkbox' && !empty($question->options))
                                                        <div class="space-y-2 mt-1">
                                                            @foreach($question->options as $opt)
                                                                <label class="flex items-center gap-3 p-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 text-sm text-slate-700 cursor-pointer transition">
                                                                    <input type="checkbox" name="{{ $fieldName }}[]" value="{{ $opt }}" class="w-4 h-4 text-brand-blue rounded border-slate-300 focus:ring-brand-blue" {{ is_array($oldVal) && in_array($opt, $oldVal) ? 'checked' : '' }}>
                                                                    <span>{{ $opt }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>

                                                    @elseif($question->type === 'checkbox')
                                                        <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-sm text-slate-700 cursor-pointer mt-1">
                                                            <input type="checkbox" name="{{ $fieldName }}" value="1" class="w-4 h-4 text-brand-blue rounded border-slate-300 focus:ring-brand-blue" {{ $oldVal ? 'checked' : '' }} {{ $question->is_required ? 'required' : '' }}>
                                                            <span class="font-medium">I confirm and agree</span>
                                                        </label>

                                                    @else
                                                        <!-- Default Short text -->
                                                        <input type="text" name="{{ $fieldName }}" value="{{ $oldVal }}" class="w-full px-4 py-3 text-base sm:text-sm rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition" placeholder="Your answer..." {{ $question->is_required ? 'required' : '' }}>
                                                    @endif

                                                    @error("answers.{$question->id}")
                                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- 3. CV / Resume Upload Box -->
                                <div>
                                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-slate-400 mb-4 pb-2 border-b border-slate-100">
                                        {{ $job->activeQuestions->count() > 0 ? '3.' : '2.' }} Upload CV / Resume <span class="text-rose-500">*</span>
                                    </h3>

                                    <div class="relative border-2 border-dashed border-slate-300 hover:border-brand-blue rounded-2xl p-5 sm:p-6 text-center transition bg-slate-50/70 group cursor-pointer" id="cv-drop-zone">
                                        <input type="file" name="cv" id="cv-file-input" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        
                                        <div id="cv-upload-prompt" class="space-y-2 pointer-events-none">
                                            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto text-xl group-hover:scale-110 transition">
                                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                            </div>
                                            <p class="text-sm font-bold text-slate-700">
                                                <span class="text-brand-blue underline">Click to upload</span> or drag & drop your CV
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                Accepted Formats: PDF, DOC, DOCX, JPG, PNG (Max file size: 5 MB)
                                            </p>
                                        </div>

                                        <!-- Selected File Preview Pill -->
                                        <div id="cv-selected-info" class="hidden items-center justify-between p-3 rounded-xl bg-blue-50 border border-blue-200 text-left">
                                            <div class="flex items-center gap-3 overflow-hidden">
                                                <i class="fa-solid fa-file-lines text-blue-600 text-xl flex-shrink-0"></i>
                                                <div class="truncate">
                                                    <p class="text-xs font-bold text-navy truncate" id="cv-filename"></p>
                                                    <p class="text-[11px] text-slate-500" id="cv-filesize"></p>
                                                </div>
                                            </div>
                                            <button type="button" id="cv-remove-btn" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-100 transition z-20 text-xs font-bold flex items-center gap-1 flex-shrink-0">
                                                <i class="fa-solid fa-xmark"></i>
                                                <span>Remove</span>
                                            </button>
                                        </div>

                                    </div>
                                    @error('cv')
                                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Privacy Consent & Submission Button -->
                                <div class="pt-4 border-t border-slate-100 space-y-4">
                                    <p class="text-xs text-slate-500 leading-relaxed">
                                        By clicking <strong>Submit Application</strong>, you confirm that the information provided is true and accurate. Your personal information will only be used for recruitment and candidate evaluation purposes by Adonis Chemical Industries Ltd.
                                    </p>

                                    <button type="submit" id="submit-btn" class="w-full btn-scientific-primary text-sm sm:text-base !py-3.5 sm:!py-4 justify-center shadow-lg shadow-blue-500/25 cursor-pointer">
                                        <i class="fa-solid fa-paper-plane mr-2"></i>
                                        <span>Submit Application</span>
                                    </button>
                                </div>

                            </form>
                        @else
                            <div class="py-8 text-center text-slate-500">
                                <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto text-xl mb-3">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <h4 class="text-base font-bold text-[#071B33]">Applications Are Closed</h4>
                                <p class="text-xs mt-1">This position is no longer accepting new candidate applications.</p>
                                <a href="{{ route('careers.index') }}" class="btn-corporate-primary text-xs !py-2 !px-5 mt-4 inline-flex">
                                    Browse Other Openings
                                </a>
                            </div>
                        @endif

                    </div>

                    <!-- Related Jobs (Mobile bottom only) -->
                    @if($relatedJobs->count() > 0)
                        <div class="block lg:hidden bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-sm space-y-4">
                            <h4 class="text-sm font-bold text-[#071B33] flex items-center gap-2">
                                <i class="fa-solid fa-briefcase text-blue-600"></i>
                                <span>Other Open Positions</span>
                            </h4>
                            <div class="space-y-3">
                                @foreach($relatedJobs as $rel)
                                    <a href="{{ route('careers.show', $rel->slug) }}" class="block p-3 rounded-xl hover:bg-blue-50/50 border border-slate-100 hover:border-blue-200 transition group">
                                        <p class="text-xs font-bold text-[#071B33] group-hover:text-blue-600 transition leading-snug">{{ $rel->title }}</p>
                                        <p class="text-[11px] text-slate-500 mt-1">{{ $rel->location }} • {{ $rel->employment_type_label }}</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('cv-file-input');
        const dropZone = document.getElementById('cv-drop-zone');
        const uploadPrompt = document.getElementById('cv-upload-prompt');
        const selectedInfo = document.getElementById('cv-selected-info');
        const filenameLabel = document.getElementById('cv-filename');
        const filesizeLabel = document.getElementById('cv-filesize');
        const removeBtn = document.getElementById('cv-remove-btn');

        function handleFile(file) {
            if (!file) return;
            filenameLabel.textContent = file.name;
            
            let sizeStr = '';
            if (file.size >= 1048576) {
                sizeStr = (file.size / 1048576).toFixed(2) + ' MB';
            } else {
                sizeStr = (file.size / 1024).toFixed(1) + ' KB';
            }
            filesizeLabel.textContent = sizeStr;

            uploadPrompt.classList.add('hidden');
            selectedInfo.classList.remove('hidden');
            selectedInfo.classList.add('flex');
        }

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    handleFile(this.files[0]);
                }
            });

            if (dropZone) {
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropZone.classList.add('border-brand-blue', 'bg-blue-50/50');
                    });
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropZone.classList.remove('border-brand-blue', 'bg-blue-50/50');
                    });
                });
            }

            if (removeBtn) {
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    e.preventDefault();
                    fileInput.value = '';
                    selectedInfo.classList.remove('flex');
                    selectedInfo.classList.add('hidden');
                    uploadPrompt.classList.remove('hidden');
                });
            }
        }
    });
</script>
@endpush
