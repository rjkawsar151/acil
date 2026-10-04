@extends('layouts.admin')

@section('title', 'Candidate Applications | Admin CMS')
@section('page_title', 'Career Applications & Candidate Pipeline')
@section('page_subtitle', 'Review candidate CVs, update applicant screening statuses, and dispatch bulk personalized interview invitations')

@section('content')

    <!-- Metrics Cards Summary -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 mb-6">
        
        <a href="{{ route('admin.careers.applications.index') }}" class="bg-white rounded-2xl p-3 border {{ empty($status) ? 'border-brand-blue ring-2 ring-blue-500/20 shadow-md' : 'border-slate-200' }} hover:border-brand-blue transition text-center">
            <p class="text-[10px] uppercase font-bold text-slate-400">Total</p>
            <p class="text-base font-extrabold text-navy mt-0.5">{{ $stats['total'] }}</p>
        </a>

        <a href="{{ route('admin.careers.applications.index', ['status' => 'pending']) }}" class="bg-white rounded-2xl p-3 border {{ $status === 'pending' ? 'border-amber-500 ring-2 ring-amber-500/20 shadow-md' : 'border-slate-200' }} hover:border-amber-400 transition text-center">
            <p class="text-[10px] uppercase font-bold text-amber-600">Pending</p>
            <p class="text-base font-extrabold text-amber-600 mt-0.5">{{ $stats['pending'] }}</p>
        </a>

        <a href="{{ route('admin.careers.applications.index', ['status' => 'under_review']) }}" class="bg-white rounded-2xl p-3 border {{ $status === 'under_review' ? 'border-blue-500 ring-2 ring-blue-500/20 shadow-md' : 'border-slate-200' }} hover:border-blue-400 transition text-center">
            <p class="text-[10px] uppercase font-bold text-blue-600">Review</p>
            <p class="text-base font-extrabold text-blue-600 mt-0.5">{{ $stats['under_review'] }}</p>
        </a>

        <a href="{{ route('admin.careers.applications.index', ['status' => 'shortlisted']) }}" class="bg-white rounded-2xl p-3 border {{ $status === 'shortlisted' ? 'border-indigo-500 ring-2 ring-indigo-500/20 shadow-md' : 'border-slate-200' }} hover:border-indigo-400 transition text-center">
            <p class="text-[10px] uppercase font-bold text-indigo-600">Shortlisted</p>
            <p class="text-base font-extrabold text-indigo-600 mt-0.5">{{ $stats['shortlisted'] }}</p>
        </a>

        <a href="{{ route('admin.careers.applications.index', ['status' => 'interview_scheduled']) }}" class="bg-white rounded-2xl p-3 border {{ $status === 'interview_scheduled' ? 'border-purple-500 ring-2 ring-purple-500/20 shadow-md' : 'border-slate-200' }} hover:border-purple-400 transition text-center">
            <p class="text-[10px] uppercase font-bold text-purple-600">Interview</p>
            <p class="text-base font-extrabold text-purple-600 mt-0.5">{{ $stats['interview_scheduled'] }}</p>
        </a>

        <a href="{{ route('admin.careers.applications.index', ['status' => 'selected']) }}" class="bg-white rounded-2xl p-3 border {{ $status === 'selected' ? 'border-emerald-500 ring-2 ring-emerald-500/20 shadow-md' : 'border-slate-200' }} hover:border-emerald-400 transition text-center">
            <p class="text-[10px] uppercase font-bold text-emerald-600">Selected</p>
            <p class="text-base font-extrabold text-emerald-600 mt-0.5">{{ $stats['selected'] }}</p>
        </a>

        <a href="{{ route('admin.careers.applications.index', ['status' => 'hired']) }}" class="bg-white rounded-2xl p-3 border {{ $status === 'hired' ? 'border-green-600 ring-2 ring-green-600/20 shadow-md' : 'border-slate-200' }} hover:border-green-500 transition text-center">
            <p class="text-[10px] uppercase font-bold text-green-700">Hired</p>
            <p class="text-base font-extrabold text-green-700 mt-0.5">{{ $stats['hired'] }}</p>
        </a>

        <a href="{{ route('admin.careers.applications.index', ['status' => 'rejected']) }}" class="bg-white rounded-2xl p-3 border {{ $status === 'rejected' ? 'border-rose-500 ring-2 ring-rose-500/20 shadow-md' : 'border-slate-200' }} hover:border-rose-400 transition text-center">
            <p class="text-[10px] uppercase font-bold text-rose-600">Rejected</p>
            <p class="text-base font-extrabold text-rose-600 mt-0.5">{{ $stats['rejected'] }}</p>
        </a>

    </div>

    <!-- Filter Toolbar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 mb-6 shadow-sm">
        <form action="{{ route('admin.careers.applications.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <div class="flex flex-wrap items-center gap-3 flex-1">
                
                <!-- Search -->
                <div class="relative min-w-[200px] flex-1 sm:flex-initial">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search candidate, email, phone, ref..." class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </div>

                <!-- Position Filter -->
                <select name="job_id" class="px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none bg-white text-slate-700 max-w-xs">
                    <option value="all">All Job Positions</option>
                    @foreach($jobs as $j)
                        <option value="{{ $j->id }}" {{ $jobId == $j->id ? 'selected' : '' }}>{{ $j->title }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="status" class="px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none bg-white text-slate-700">
                    <option value="all">All Statuses</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="under_review" {{ $status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="shortlisted" {{ $status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                    <option value="interview_scheduled" {{ $status === 'interview_scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                    <option value="interviewed" {{ $status === 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                    <option value="selected" {{ $status === 'selected' ? 'selected' : '' }}>Selected</option>
                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="hired" {{ $status === 'hired' ? 'selected' : '' }}>Hired</option>
                    <option value="withdrawn" {{ $status === 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                </select>

                <!-- Date Filter -->
                <select name="date_filter" class="px-3 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none bg-white text-slate-700">
                    <option value="">All Time</option>
                    <option value="today" {{ $dateFilter === 'today' ? 'selected' : '' }}>Applied Today</option>
                    <option value="this_week" {{ $dateFilter === 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="this_month" {{ $dateFilter === 'this_month' ? 'selected' : '' }}>This Month</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>

                @if($search || ($jobId && $jobId !== 'all') || ($status && $status !== 'all') || $dateFilter)
                    <a href="{{ route('admin.careers.applications.index') }}" class="p-2 text-slate-400 hover:text-slate-600 transition" title="Clear Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>

            <!-- Header Quick Summary -->
            <div class="text-xs text-slate-500 font-semibold self-end lg:self-auto">
                Showing <strong>{{ $applications->total() }}</strong> total candidate applications
            </div>

        </form>
    </div>

    <!-- Bulk Operations Action Bar (Shows when checkboxes are selected) -->
    <div id="bulk-actions-bar" class="hidden bg-gradient-to-r from-navy to-brand-blue text-white rounded-2xl p-4 mb-6 shadow-lg items-center justify-between gap-4 transition-all">
        
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full bg-white/20 text-white font-extrabold text-xs">
                <span id="selected-count">0</span> Selected
            </span>
            <span class="text-xs text-slate-200 hidden sm:inline">Bulk candidate recruitment actions:</span>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            
            <!-- Bulk Status Dropdown -->
            <form action="{{ route('admin.careers.applications.bulk-status') }}" method="POST" id="bulk-status-form" class="flex items-center gap-2">
                @csrf
                <div id="bulk-status-hidden-inputs"></div>
                <select name="status" class="px-3 py-2 text-xs rounded-xl bg-white text-slate-800 border-none outline-none font-bold">
                    <option value="under_review">Mark Under Review</option>
                    <option value="shortlisted" selected>Mark Shortlisted</option>
                    <option value="interview_scheduled">Mark Interview Scheduled</option>
                    <option value="selected">Mark Selected</option>
                    <option value="hired">Mark Hired</option>
                    <option value="rejected">Mark Rejected</option>
                    <option value="pending">Mark Pending</option>
                </select>
                <button type="submit" onclick="return confirm('Apply status change to all selected applications?');" class="px-3.5 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs transition">
                    Apply Status
                </button>
            </form>

            <!-- Send Bulk Interview Email Trigger -->
            <button type="button" id="open-bulk-email-modal-btn" class="px-4 py-2 rounded-xl bg-brand-cyan hover:bg-cyan-400 text-navy font-bold text-xs transition flex items-center gap-1.5 shadow-md">
                <i class="fa-solid fa-envelope"></i>
                <span>Send Interview Email</span>
            </button>

            <!-- Bulk Delete Form -->
            <form action="{{ route('admin.careers.applications.bulk-delete') }}" method="POST" id="bulk-delete-form" class="inline-block">
                @csrf
                @method('DELETE')
                <div id="bulk-delete-hidden-inputs"></div>
                <button type="submit" onclick="return confirm('Are you sure you want to delete all selected candidate applications?');" class="p-2 rounded-xl bg-rose-500/30 hover:bg-rose-600 text-white text-xs transition" title="Delete Selected">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>

        </div>

    </div>

    <!-- Candidate Applications Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-4 pl-6 pr-2 w-10">
                            <input type="checkbox" id="select-all-checkbox" class="w-4 h-4 text-brand-blue rounded border-slate-300 focus:ring-brand-blue cursor-pointer">
                        </th>
                        <th class="py-4 px-3">Applicant Profile</th>
                        <th class="py-4 px-4">Position Applied</th>
                        <th class="py-4 px-4">Contact Details</th>
                        <th class="py-4 px-4">Applied Date</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-4 text-center">CV File</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($applications as $app)
                        <tr class="hover:bg-slate-50/80 transition application-row" data-id="{{ $app->id }}" data-name="{{ $app->name }}" data-email="{{ $app->email }}" data-position="{{ $app->job->title ?? 'Position' }}">
                            
                            <!-- Checkbox -->
                            <td class="py-4 pl-6 pr-2">
                                <input type="checkbox" class="app-checkbox w-4 h-4 text-brand-blue rounded border-slate-300 focus:ring-brand-blue cursor-pointer" value="{{ $app->id }}">
                            </td>

                            <!-- Applicant Profile -->
                            <td class="py-4 px-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-blue to-brand-cyan text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($app->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.careers.applications.show', $app->id) }}" class="font-bold text-sm text-navy hover:text-brand-blue transition block leading-snug">
                                            {{ $app->name }}
                                        </a>
                                        <span class="text-[10px] text-slate-400 font-mono">{{ $app->reference }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Position -->
                            <td class="py-4 px-4">
                                <p class="font-bold text-slate-800">{{ $app->job->title ?? 'N/A' }}</p>
                                <p class="text-[11px] text-slate-400">{{ $app->job->effective_department_name ?? 'General' }}</p>
                            </td>

                            <!-- Contact -->
                            <td class="py-4 px-4">
                                <p class="font-medium text-slate-800">{{ $app->email }}</p>
                                <p class="text-[11px] text-slate-500">{{ $app->phone }}</p>
                            </td>

                            <!-- Applied Date -->
                            <td class="py-4 px-4 text-slate-600 whitespace-nowrap">
                                <p class="font-medium">{{ $app->applied_at ? $app->applied_at->format('d M Y') : '—' }}</p>
                                <p class="text-[10px] text-slate-400">{{ $app->applied_at ? $app->applied_at->format('h:i A') : '' }}</p>
                            </td>

                            <!-- Status with inline changer -->
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('admin.careers.applications.status', $app->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="px-2.5 py-1 rounded-full text-[10px] font-bold border transition cursor-pointer outline-none {{ $app->status_badge_class }}">
                                        <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="under_review" {{ $app->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                                        <option value="shortlisted" {{ $app->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                        <option value="interview_scheduled" {{ $app->status === 'interview_scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                                        <option value="interviewed" {{ $app->status === 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                                        <option value="selected" {{ $app->status === 'selected' ? 'selected' : '' }}>Selected</option>
                                        <option value="hired" {{ $app->status === 'hired' ? 'selected' : '' }}>Hired</option>
                                        <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="withdrawn" {{ $app->status === 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                                    </select>
                                </form>
                            </td>

                            <!-- CV Actions -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" onclick="previewCv('{{ route('admin.careers.applications.cv.preview', $app->id) }}', '{{ addslashes($app->name) }}', '{{ addslashes($app->job->title ?? 'Position') }}', '{{ route('admin.careers.applications.cv.download', $app->id) }}', {{ $app->is_previewable ? 'true' : 'false' }})" class="px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white text-[11px] font-bold transition flex items-center gap-1 shadow-sm">
                                        <i class="fa-solid fa-file-pdf"></i>
                                        <span>Preview</span>
                                    </button>
                                    <a href="{{ route('admin.careers.applications.cv.download', $app->id) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" title="Download Original CV">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right whitespace-nowrap space-x-1">
                                
                                <a href="{{ route('admin.careers.applications.show', $app->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block" title="View Full Application Details">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <button type="button" onclick="openSingleEmailModal({{ $app->id }}, '{{ addslashes($app->name) }}', '{{ addslashes($app->email) }}', '{{ addslashes($app->job->title ?? 'Position') }}')" class="p-2 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition inline-block" title="Send Interview / Notification Email">
                                    <i class="fa-solid fa-envelope"></i>
                                </button>

                                <form action="{{ route('admin.careers.applications.destroy', $app->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Move this application to trash?');">
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
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl mb-3">
                                    <i class="fa-solid fa-inbox"></i>
                                </div>
                                <p class="font-bold text-slate-600 text-sm">No candidate applications found.</p>
                                <p class="text-xs text-slate-400 mt-1">Applications submitted by visitors on the public Careers portal will appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $applications->links() }}
        </div>
    </div>

    <!-- 1. Instant CV Preview Modal -->
    <div id="cv-preview-modal" class="fixed inset-0 z-50 bg-navy/80 backdrop-blur-md hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-5xl w-full h-[90vh] shadow-2xl border border-slate-100 flex flex-col overflow-hidden animate-float-none">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-navy via-brand-blue to-navy-dark px-6 py-4 text-white flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-brand-cyan text-lg">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div>
                        <h3 id="cv-modal-applicant-name" class="font-heading font-extrabold text-base text-white leading-snug">Rahim Ahmed</h3>
                        <p id="cv-modal-job-title" class="text-xs text-brand-cyan">Applied: Digital Marketing Executive</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a id="cv-modal-download-btn" href="#" class="px-4 py-2 rounded-xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs transition flex items-center gap-1.5">
                        <i class="fa-solid fa-download"></i>
                        <span>Download Original</span>
                    </a>
                    <button type="button" onclick="closeCvModal()" class="p-2 text-slate-300 hover:text-white text-xl">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Content Frame -->
            <div class="flex-1 bg-slate-100 relative overflow-hidden flex items-center justify-center p-2">
                <iframe id="cv-modal-iframe" src="" class="w-full h-full rounded-xl border border-slate-200 bg-white" frameborder="0"></iframe>
                
                <div id="cv-modal-fallback" class="hidden text-center p-8 max-w-md bg-white rounded-2xl shadow-sm border border-slate-200">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-brand-blue flex items-center justify-center mx-auto text-xl mb-3">
                        <i class="fa-solid fa-file-word"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm">Direct Preview Not Supported for this File Format</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-4">This CV is in DOC/DOCX format. You can download and inspect it directly on your device.</p>
                    <a id="cv-fallback-download-btn" href="#" class="btn-corporate-primary text-xs !py-2.5 !px-5 inline-flex">
                        <i class="fa-solid fa-download"></i> Download CV
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- 2. Bulk & Individual Interview Email Modal -->
    <div id="email-modal" class="fixed inset-0 z-50 bg-navy/80 backdrop-blur-md hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-3xl w-full max-h-[92vh] shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
            
            <div class="bg-gradient-to-r from-navy via-brand-blue to-navy-dark px-6 py-5 text-white flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-brand-cyan text-lg">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-base text-white">Send Personalized Interview Invitation</h3>
                        <p class="text-xs text-slate-300">Emails are dispatched individually to preserve candidate privacy</p>
                    </div>
                </div>
                <button type="button" onclick="closeEmailModal()" class="p-2 text-slate-300 hover:text-white text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.careers.applications.bulk-email') }}" method="POST" class="flex-1 overflow-y-auto p-6 space-y-5" id="email-dispatch-form">
                @csrf
                <div id="email-modal-hidden-inputs"></div>

                <!-- Recipient Preview Chips -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Recipients (<span id="email-modal-recipient-count">0</span> Candidates)
                    </label>
                    <div id="email-modal-recipients-list" class="flex flex-wrap gap-1.5 p-3 rounded-xl bg-slate-50 border border-slate-200 max-h-24 overflow-y-auto text-xs">
                        <!-- Injected badges -->
                    </div>
                </div>

                <!-- CC & BCC Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            CC Address (Optional)
                        </label>
                        <input type="text" name="cc" placeholder="hr@adonischemical.com, manager@domain.com" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            BCC Address (Optional)
                        </label>
                        <input type="text" name="bcc" placeholder="recruitment@adonischemical.com" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">
                    </div>
                </div>

                <!-- Subject -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Email Subject *
                    </label>
                    <input type="text" name="subject" id="email-subject-input" required value="Interview Invitation — @{{ position_name }} [Adonis Chemical]" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">
                </div>

                <!-- Interview Date / Time / Location -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 rounded-2xl bg-blue-50/60 border border-blue-100">
                    <div>
                        <label class="block text-[11px] font-bold text-blue-950 uppercase tracking-wider mb-1">
                            Interview Date
                        </label>
                        <input type="date" name="interview_date" id="email-date-input" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:border-brand-blue outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-blue-950 uppercase tracking-wider mb-1">
                            Interview Time
                        </label>
                        <input type="text" name="interview_time" id="email-time-input" placeholder="e.g. 11:30 AM" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:border-brand-blue outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-blue-950 uppercase tracking-wider mb-1">
                            Interview Location / Link
                        </label>
                        <input type="text" name="interview_location" id="email-location-input" value="Plant: Genda, Karnapara, Savar, Dhaka" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:border-brand-blue outline-none">
                    </div>
                </div>

                <!-- Placeholders Quick Guide -->
                <div class="text-[11px] text-slate-500">
                    <span class="font-bold text-slate-700">Dynamic Placeholders:</span>
                    <span class="font-mono bg-slate-100 px-1 py-0.5 rounded">@{{ applicant_name }}</span>
                    <span class="font-mono bg-slate-100 px-1 py-0.5 rounded">@{{ position_name }}</span>
                    <span class="font-mono bg-slate-100 px-1 py-0.5 rounded">@{{ interview_date }}</span>
                    <span class="font-mono bg-slate-100 px-1 py-0.5 rounded">@{{ interview_time }}</span>
                    <span class="font-mono bg-slate-100 px-1 py-0.5 rounded">@{{ interview_location }}</span>
                    <span class="font-mono bg-slate-100 px-1 py-0.5 rounded">@{{ application_reference }}</span>
                </div>

                <!-- Body -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Email Message Body *
                    </label>
                    <textarea name="body" id="email-body-input" rows="7" required class="w-full px-4 py-3 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none font-sans leading-relaxed">Dear @{{ applicant_name }},

Congratulations. We have reviewed your application for the position of @{{ position_name }} and are pleased to invite you for an in-person interview and technical assessment.

Interview Details:
• Date: @{{ interview_date }}
• Time: @{{ interview_time }}
• Location: @{{ interview_location }}
• Reference No: @{{ application_reference }}

Please bring a printed copy of your updated CV, academic certificates, and national ID card. Kindly reply to this email to confirm your attendance.

Regards,
HR Recruitment Committee
Adonis Chemical Industries Ltd.</textarea>
                </div>

                <!-- Auto update status toggle -->
                <div>
                    <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="update_status" value="1" checked class="w-4 h-4 text-brand-blue rounded border-slate-300 focus:ring-brand-blue">
                        <span>Automatically update applicant status to "Interview Scheduled" upon dispatch</span>
                    </label>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeEmailModal()" class="px-5 py-2.5 rounded-full text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="btn-scientific-primary text-xs !py-2.5 !px-6 shadow-md shadow-blue-500/25">
                        <i class="fa-solid fa-paper-plane mr-1"></i>
                        <span>Dispatch Emails</span>
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all-checkbox');
        const rowCheckboxes = document.querySelectorAll('.app-checkbox');
        const bulkBar = document.getElementById('bulk-actions-bar');
        const selectedCountLabel = document.getElementById('selected-count');
        const bulkStatusHidden = document.getElementById('bulk-status-hidden-inputs');
        const bulkDeleteHidden = document.getElementById('bulk-delete-hidden-inputs');

        function getSelectedApps() {
            const selected = [];
            rowCheckboxes.forEach(cb => {
                if (cb.checked) {
                    const row = cb.closest('tr');
                    selected.push({
                        id: cb.value,
                        name: row.dataset.name,
                        email: row.dataset.email,
                        position: row.dataset.position
                    });
                }
            });
            return selected;
        }

        function updateBulkBar() {
            const selected = getSelectedApps();
            selectedCountLabel.textContent = selected.length;

            if (selected.length > 0) {
                bulkBar.classList.remove('hidden');
                bulkBar.classList.add('flex');

                // Populate hidden inputs
                bulkStatusHidden.innerHTML = selected.map(s => `<input type="hidden" name="ids[]" value="${s.id}">`).join('');
                bulkDeleteHidden.innerHTML = selected.map(s => `<input type="hidden" name="ids[]" value="${s.id}">`).join('');
            } else {
                bulkBar.classList.remove('flex');
                bulkBar.classList.add('hidden');
                bulkStatusHidden.innerHTML = '';
                bulkDeleteHidden.innerHTML = '';
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => cb.checked = this.checked);
                updateBulkBar();
            });
        }

        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                updateBulkBar();
                if (!this.checked && selectAll) {
                    selectAll.checked = false;
                }
            });
        });

        // Email Modal Trigger from Bulk Bar
        const openBulkEmailBtn = document.getElementById('open-bulk-email-modal-btn');
        if (openBulkEmailBtn) {
            openBulkEmailBtn.addEventListener('click', function() {
                const selected = getSelectedApps();
                if (selected.length === 0) {
                    alert('Please select at least one applicant.');
                    return;
                }
                openEmailModalWithApps(selected);
            });
        }
    });

    // CV Preview Function
    function previewCv(previewUrl, applicantName, jobTitle, downloadUrl, isPreviewable) {
        const modal = document.getElementById('cv-preview-modal');
        const nameLabel = document.getElementById('cv-modal-applicant-name');
        const jobLabel = document.getElementById('cv-modal-job-title');
        const downloadBtn = document.getElementById('cv-modal-download-btn');
        const iframe = document.getElementById('cv-modal-iframe');
        const fallback = document.getElementById('cv-modal-fallback');
        const fallbackDownloadBtn = document.getElementById('cv-fallback-download-btn');

        nameLabel.textContent = applicantName;
        jobLabel.textContent = 'Position: ' + jobTitle;
        downloadBtn.href = downloadUrl;
        fallbackDownloadBtn.href = downloadUrl;

        if (isPreviewable) {
            iframe.src = previewUrl;
            iframe.classList.remove('hidden');
            fallback.classList.add('hidden');
        } else {
            iframe.src = 'about:blank';
            iframe.classList.add('hidden');
            fallback.classList.remove('hidden');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCvModal() {
        const modal = document.getElementById('cv-preview-modal');
        const iframe = document.getElementById('cv-modal-iframe');
        iframe.src = 'about:blank';
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    // Email Modal Functions
    function openSingleEmailModal(id, name, email, position) {
        openEmailModalWithApps([{ id: id, name: name, email: email, position: position }]);
    }

    function openEmailModalWithApps(apps) {
        const modal = document.getElementById('email-modal');
        const countLabel = document.getElementById('email-modal-recipient-count');
        const chipsContainer = document.getElementById('email-modal-recipients-list');
        const hiddenInputs = document.getElementById('email-modal-hidden-inputs');

        countLabel.textContent = apps.length;
        chipsContainer.innerHTML = apps.map(a => `
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-100 text-blue-800 text-xs font-medium">
                <i class="fa-solid fa-user text-[10px]"></i>
                <strong>${a.name}</strong> (${a.email})
            </span>
        `).join('');

        hiddenInputs.innerHTML = apps.map(a => `<input type="hidden" name="application_ids[]" value="${a.id}">`).join('');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEmailModal() {
        const modal = document.getElementById('email-modal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endpush
