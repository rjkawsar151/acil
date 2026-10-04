@extends('layouts.app')

@section('title', 'Careers & Job Openings | ' . \App\Models\Setting::get('site_name', 'Adonis Chemical Industries Ltd.'))
@section('meta_description', 'Explore career opportunities and job openings at Adonis Chemical Industries Ltd. in Savar, Dhaka. Join a leading manufacturing and scientific formulation team.')

@section('content')

    <!-- Hero Banner Section -->
    <section class="relative bg-gradient-to-br from-[#040E1B] via-[#071B33] to-[#0B3B7B] text-white py-20 lg:py-28 overflow-hidden">
        <!-- Ambient Scientific Glow Effects -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-brand-cyan/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 right-10 w-[500px] h-[500px] bg-brand-blue/25 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff0a_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-cyan/15 border border-brand-cyan/30 text-brand-cyan text-xs font-bold tracking-wider uppercase mb-6 backdrop-blur-sm">
                    <i class="fa-solid fa-briefcase text-xs"></i>
                    <span>Adonis Talent Acquisition</span>
                </div>
                
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight mb-6">
                    Shape the Future of <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-cyan to-blue-400">Chemical Innovation</span>
                </h1>
                
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mb-8">
                    Join our dedicated team of formulation chemists, engineers, manufacturing specialists, and business innovators at our state-of-the-art Savar plant and corporate office.
                </p>

                <!-- Search / Filter Quick Anchor -->
                <div class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-300">
                    <span class="flex items-center gap-1.5 bg-slate-800/80 px-3.5 py-2 rounded-xl border border-slate-700/80 backdrop-blur-sm">
                        <i class="fa-solid fa-circle-check text-emerald-400"></i>
                        <span><strong>{{ $totalOpenings }}</strong> Active {{ Str::plural('Opening', $totalOpenings) }}</span>
                    </span>
                    <span class="flex items-center gap-1.5 bg-slate-800/80 px-3.5 py-2 rounded-xl border border-slate-700/80 backdrop-blur-sm">
                        <i class="fa-solid fa-location-dot text-brand-cyan"></i>
                        <span>Genda, Savar, Dhaka & Head Office</span>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter & Search Toolbar -->
    <section class="bg-slate-50 border-b border-slate-200 py-4 sm:py-6 sticky top-16 md:top-20 z-20 shadow-sm backdrop-blur-md bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('careers.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                
                <!-- Search Input -->
                <div class="md:col-span-4 relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search position or keywords..." class="w-full pl-10 pr-4 py-2.5 text-base sm:text-sm rounded-xl border border-slate-300 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition bg-white">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </div>

                <!-- Department Filter -->
                <div class="md:col-span-3">
                    <select name="department" class="w-full px-3.5 py-2.5 text-base sm:text-sm rounded-xl border border-slate-300 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition bg-white text-slate-700">
                        <option value="all">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->slug }}" {{ $departmentSlug === $dept->slug ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Employment Type Filter -->
                <div class="md:col-span-3">
                    <select name="type" class="w-full px-3.5 py-2.5 text-base sm:text-sm rounded-xl border border-slate-300 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 outline-none transition bg-white text-slate-700">
                        <option value="all">All Employment Types</option>
                        <option value="full_time" {{ $employmentType === 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ $employmentType === 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contractual" {{ $employmentType === 'contractual' ? 'selected' : '' }}>Contractual</option>
                        <option value="internship" {{ $employmentType === 'internship' ? 'selected' : '' }}>Internship</option>
                    </select>
                </div>

                <!-- Submit / Reset Buttons -->
                <div class="md:col-span-2 flex items-center gap-2">
                    <button type="submit" class="flex-1 btn-corporate-primary !py-2.5 text-xs font-bold justify-center">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    @if($search || ($departmentSlug && $departmentSlug !== 'all') || ($employmentType && $employmentType !== 'all'))
                        <a href="{{ route('careers.index') }}" class="p-2.5 rounded-xl border border-slate-300 hover:bg-slate-100 text-slate-600 transition flex items-center justify-center" title="Clear Filters">
                            <i class="fa-solid fa-rotate-left text-xs"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </section>

    <!-- Job Listings Section -->
    <section class="py-16 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-[#071B33]">Current Open Opportunities</h2>
                    <p class="text-sm text-slate-500 mt-1">Showing {{ $jobs->total() }} available recruitment {{ Str::plural('position', $jobs->total()) }}</p>
                </div>
            </div>

            <!-- Job Cards Grid -->
            @if($jobs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jobs as $job)
                        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                            
                            <div>
                                <!-- 16:9 Cover Image -->
                                <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-100">
                                    <img src="{{ $job->cover_image_url }}" alt="{{ $job->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/20"></div>
                                    
                                    <!-- Badges Floating on Image -->
                                    <div class="absolute top-3 left-3 right-3 flex items-center justify-between gap-2">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold tracking-wide uppercase bg-blue-600/90 text-white backdrop-blur-sm shadow-sm">
                                            {{ $job->effective_department_name }}
                                        </span>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 text-slate-800 backdrop-blur-sm shadow-sm">
                                            {{ $job->employment_type_label }}
                                        </span>
                                    </div>

                                    <!-- Floating Workplace Badge at Bottom of Image -->
                                    <div class="absolute bottom-3 left-3 flex items-center gap-1.5 text-white text-[11px] font-medium drop-shadow">
                                        <i class="fa-solid fa-building text-cyan-300 text-xs"></i>
                                        <span>{{ $job->workplace_type_label }}</span>
                                    </div>
                                </div>

                                <!-- Card Body Content -->
                                <div class="p-6">
                                    <!-- Job Title -->
                                    <h3 class="text-base sm:text-lg font-bold text-[#071B33] group-hover:text-blue-600 transition leading-snug mb-2 line-clamp-2 min-h-[3rem]">
                                        <a href="{{ route('careers.show', $job->slug) }}">
                                            {{ $job->title }}
                                        </a>
                                    </h3>

                                    <!-- Short Description -->
                                    @if($job->short_description)
                                        <p class="text-xs text-slate-600 line-clamp-2 mb-4 leading-relaxed">
                                            {{ $job->short_description }}
                                        </p>
                                    @endif

                                    <!-- Details Grid -->
                                    <div class="space-y-2 py-3 border-y border-slate-100 text-xs text-slate-600 mb-2">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-location-dot w-4 text-center text-blue-500"></i>
                                            <span class="truncate">{{ $job->location }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-money-bill-wave w-4 text-center text-emerald-500"></i>
                                            <span class="font-medium text-slate-700">{{ $job->formatted_salary }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-users w-4 text-center text-indigo-500"></i>
                                            <span>{{ $job->vacancies }} {{ Str::plural('Vacancy', $job->vacancies) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Action / Deadline -->
                            <div class="px-6 pb-6 pt-0">
                                <div class="flex items-center justify-between text-[11px] text-slate-500 mb-3 font-medium">
                                    <span>
                                        <i class="fa-regular fa-clock mr-1 text-slate-400"></i>
                                        Deadline: <strong class="text-slate-700">{{ $job->application_deadline ? $job->application_deadline->format('d M Y') : 'Open Until Filled' }}</strong>
                                    </span>
                                </div>

                                <a href="{{ route('careers.show', $job->slug) }}" class="w-full btn-scientific-primary text-xs !py-2.5 justify-center group-hover:shadow-md transition">
                                    <span>View Details & Apply</span>
                                    <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $jobs->links() }}
                </div>
            @else
                <!-- Clean Empty State -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-xl mx-auto shadow-sm">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto text-2xl mb-4">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#071B33] mb-2">No Matching Job Openings Found</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-6">
                        There are currently no job positions matching your selected filters. Please check back regularly or clear your filters to view other openings.
                    </p>
                    <a href="{{ route('careers.index') }}" class="btn-corporate-primary text-xs !py-2.5 !px-6 inline-flex">
                        <i class="fa-solid fa-rotate-left"></i> View All Openings
                    </a>
                </div>
            @endif

        </div>
    </section>

    <!-- Why Work with Adonis Chemical Section -->
    <section class="py-20 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="badge-scientific text-xs mb-3">Workplace Excellence</span>
                <h2 class="text-3xl font-extrabold text-[#071B33]">Why Build Your Career at Adonis?</h2>
                <p class="text-sm text-slate-500 mt-2">
                    We foster an environment of continuous learning, scientific rigor, safety, and mutual professional growth.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-brand-blue/40 transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-flask-vial"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#071B33] mb-2">Modern R&D & Plant</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Work with high-grade European testing equipment, automated filling lines, and advanced formulation laboratories in Savar.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-brand-blue/40 transition">
                    <div class="w-12 h-12 rounded-xl bg-cyan-600 text-white flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#071B33] mb-2">Career Progression</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Clear pathways for promotion, technical skill development, leadership mentoring, and specialized industry certifications.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-brand-blue/40 transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-shield-heart"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#071B33] mb-2">Safety & Welfare</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Strict occupational health and safety standards, medical insurance support, festival bonuses, and employee well-being initiatives.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-brand-blue/40 transition">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-users-rays"></i>
                    </div>
                    <h3 class="text-base font-bold text-[#071B33] mb-2">Adonis Group Ecosystem</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Be part of an established corporate conglomerate with diverse ventures in manufacturing, textiles, and international trade.
                    </p>
                </div>

            </div>

        </div>
    </section>

@endsection
