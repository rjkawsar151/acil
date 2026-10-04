@extends('layouts.admin')

@section('title', 'Career Job Posts | Admin CMS')
@section('page_title', 'Career & Recruitment Positions')
@section('page_subtitle', 'Manage published job openings, candidate requirements, and dynamic custom questions')

@section('content')

    <!-- Metrics Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
        
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-brand-blue flex items-center justify-center text-lg">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold text-slate-400">Total Positions</p>
                <p class="text-lg font-extrabold text-navy">{{ $stats['total'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold text-slate-400">Published</p>
                <p class="text-lg font-extrabold text-emerald-600">{{ $stats['published'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-file-pen"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold text-slate-400">Drafts</p>
                <p class="text-lg font-extrabold text-amber-600">{{ $stats['draft'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold text-slate-400">Closed</p>
                <p class="text-lg font-extrabold text-rose-600">{{ $stats['closed'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center gap-3 col-span-2 sm:col-span-1">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-bold text-slate-400">Applications</p>
                <p class="text-lg font-extrabold text-indigo-600">{{ $stats['total_applications'] }}</p>
            </div>
        </div>

    </div>

    <!-- Filter & Action Header -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 mb-6 shadow-sm">
        <form action="{{ route('admin.careers.jobs.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <div class="flex flex-wrap items-center gap-3 flex-1">
                <!-- Search Input -->
                <div class="relative min-w-[220px]">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search positions..." class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </div>

                <!-- Status Filter -->
                <select name="status" class="px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none bg-white text-slate-700">
                    <option value="all">All Statuses</option>
                    <option value="published" {{ $status === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="closed" {{ $status === 'closed' ? 'selected' : '' }}>Closed</option>
                    <option value="archived" {{ $status === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>

                <!-- Department Filter -->
                <select name="department_id" class="px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue focus:ring-1 focus:ring-brand-blue outline-none bg-white text-slate-700">
                    <option value="all">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $departmentId == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>

                @if($search || ($status && $status !== 'all') || ($departmentId && $departmentId !== 'all'))
                    <a href="{{ route('admin.careers.jobs.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition" title="Clear Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.careers.departments.index') }}" class="px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-folder-tree text-brand-blue"></i>
                    <span>Departments</span>
                </a>

                <a href="{{ route('admin.careers.jobs.create') }}" class="btn-scientific-primary text-xs !py-2.5 !px-4">
                    <i class="fa-solid fa-plus"></i>
                    <span>Post New Vacancy</span>
                </a>
            </div>

        </form>
    </div>

    <!-- Jobs Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Position & Department</th>
                        <th class="py-4 px-4">Location & Type</th>
                        <th class="py-4 px-4 text-center">Vacancies</th>
                        <th class="py-4 px-4 text-center">Applications</th>
                        <th class="py-4 px-4">Deadline</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-slate-50/80 transition">
                            
                            <!-- Position & Dept -->
                            <td class="py-4 px-6">
                                <div>
                                    <h4 class="font-bold text-sm text-navy leading-snug hover:text-brand-blue transition">
                                        <a href="{{ route('admin.careers.jobs.edit', $job->id) }}">
                                            {{ $job->title }}
                                        </a>
                                    </h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 font-semibold text-[10px]">
                                            {{ $job->effective_department_name }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-mono">/careers/{{ $job->slug }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Location & Type -->
                            <td class="py-4 px-4">
                                <p class="font-semibold text-slate-800">{{ $job->location }}</p>
                                <p class="text-[11px] text-slate-400">{{ $job->employment_type_label }} • {{ $job->workplace_type_label }}</p>
                            </td>

                            <!-- Vacancies -->
                            <td class="py-4 px-4 text-center">
                                <span class="font-extrabold text-navy text-xs">{{ $job->vacancies }}</span>
                            </td>

                            <!-- Applications Received -->
                            <td class="py-4 px-4 text-center">
                                <a href="{{ route('admin.careers.applications.index', ['job_id' => $job->id]) }}" class="inline-flex flex-col items-center group">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition">
                                        {{ $job->applications_count }}
                                    </span>
                                    @if($job->pending_applications_count > 0)
                                        <span class="text-[10px] text-amber-600 font-bold mt-0.5">
                                            {{ $job->pending_applications_count }} pending
                                        </span>
                                    @endif
                                </a>
                            </td>

                            <!-- Deadline -->
                            <td class="py-4 px-4">
                                @if($job->application_deadline)
                                    <p class="font-medium text-slate-700">{{ $job->application_deadline->format('d M Y') }}</p>
                                    @if($job->is_deadline_passed)
                                        <span class="text-[10px] font-bold text-rose-500 block">Expired</span>
                                    @endif
                                @else
                                    <span class="text-slate-400">Open Ended</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('admin.careers.jobs.toggle-status', $job->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-extrabold border transition cursor-pointer {{ $job->status_badge_class }}" title="Click to toggle Status">
                                        {{ ucfirst($job->status) }}
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right whitespace-nowrap space-x-1">
                                
                                <a href="{{ route('careers.show', $job->slug) }}" target="_blank" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block" title="View Public Page">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.careers.applications.index', ['job_id' => $job->id]) }}" class="p-2 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition inline-block" title="View Applications ({{ $job->applications_count }})">
                                    <i class="fa-solid fa-users"></i>
                                </a>

                                <a href="{{ route('admin.careers.jobs.edit', $job->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block" title="Edit Job">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('admin.careers.jobs.duplicate', $job->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition" title="Duplicate as Draft">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admin.careers.jobs.destroy', $job->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Move this job vacancy to trash? Candidate applications will be retained.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl mb-3">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <p class="font-bold text-slate-600 text-sm">No job positions found.</p>
                                <p class="text-xs text-slate-400 mt-1">Create your first recruitment post to start receiving candidate applications.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $jobs->links() }}
        </div>
    </div>

@endsection
