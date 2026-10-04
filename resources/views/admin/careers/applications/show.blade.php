@extends('layouts.admin')

@section('title', 'Application: ' . $application->name . ' | Admin CMS')
@section('page_title', 'Candidate Profile & Application Details')
@section('page_subtitle', 'Reference: ' . $application->reference . ' — Applied for ' . ($application->job->title ?? 'Position'))

@section('content')

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.careers.applications.index') }}" class="p-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 transition text-xs font-bold flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Pipeline</span>
            </a>
            <span class="px-3 py-1 rounded-full text-xs font-extrabold border {{ $application->status_badge_class }}">
                {{ $application->status_label }}
            </span>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.careers.applications.cv.download', $application->id) }}" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-download text-brand-blue"></i>
                <span>Download CV ({{ $application->formatted_cv_size }})</span>
            </a>

            <button type="button" onclick="openSingleEmailModal({{ $application->id }}, '{{ addslashes($application->name) }}', '{{ addslashes($application->email) }}', '{{ addslashes($application->job->title ?? 'Position') }}')" class="btn-scientific-primary text-xs !py-2.5 !px-4">
                <i class="fa-solid fa-envelope"></i>
                <span>Send Interview Email</span>
            </button>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Content Area (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- 1. Candidate Information Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-6">
                <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-blue to-brand-cyan text-white flex items-center justify-center font-extrabold text-xl shadow-md">
                        {{ strtoupper(substr($application->name, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-navy leading-snug">{{ $application->name }}</h3>
                        <p class="text-xs text-slate-400 font-mono mt-0.5">Reference ID: {{ $application->reference }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 font-semibold block mb-0.5">Email Address</span>
                        <a href="mailto:{{ $application->email }}" class="font-bold text-brand-blue hover:underline text-sm">{{ $application->email }}</a>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 font-semibold block mb-0.5">Contact Phone</span>
                        <a href="tel:{{ $application->phone }}" class="font-bold text-slate-800 text-sm">{{ $application->phone }}</a>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 font-semibold block mb-0.5">Application Date</span>
                        <span class="font-bold text-slate-800">{{ $application->applied_at ? $application->applied_at->format('d M Y, h:i A') : '—' }}</span>
                    </div>
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 font-semibold block mb-0.5">CV Original Filename</span>
                        <span class="font-bold text-slate-800 truncate block" title="{{ $application->cv_original_name }}">{{ $application->cv_original_name }}</span>
                    </div>
                </div>
            </div>

            <!-- 2. Custom Questionnaire Answers Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-5">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-question text-purple-600"></i>
                    <span>Candidate Questionnaire Responses</span>
                </h3>

                @if($application->answers->count() > 0)
                    <div class="space-y-4">
                        @foreach($application->answers as $ans)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                                <p class="text-xs font-bold text-slate-700">
                                    {{ $loop->iteration }}. {{ $ans->question_snapshot }}
                                </p>
                                <p class="text-sm text-navy font-semibold whitespace-pre-line pl-3 border-l-2 border-brand-blue">
                                    {{ $ans->formatted_answer }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 py-4 text-center italic">
                        No additional custom screening questions were assigned to this position.
                    </p>
                @endif
            </div>

            <!-- 3. Embedded CV Preview Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy flex items-center gap-2">
                        <i class="fa-solid fa-file-pdf text-red-500"></i>
                        <span>Uploaded CV Document</span>
                    </h3>
                    <a href="{{ route('admin.careers.applications.cv.download', $application->id) }}" class="text-xs font-bold text-brand-blue hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-download"></i>
                        <span>Download ({{ $application->formatted_cv_size }})</span>
                    </a>
                </div>

                @if($application->is_previewable)
                    <div class="w-full h-[600px] rounded-2xl border border-slate-200 bg-slate-100 overflow-hidden">
                        <iframe src="{{ route('admin.careers.applications.cv.preview', $application->id) }}" class="w-full h-full" frameborder="0"></iframe>
                    </div>
                @else
                    <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                        <i class="fa-solid fa-file-word text-blue-500 text-3xl mb-3"></i>
                        <h4 class="font-bold text-slate-800 text-sm">Direct Browser Preview Unavailable</h4>
                        <p class="text-xs text-slate-500 mt-1 mb-4">This CV file is in {{ strtoupper(pathinfo($application->cv_original_name, PATHINFO_EXTENSION)) }} format. Please download to view.</p>
                        <a href="{{ route('admin.careers.applications.cv.download', $application->id) }}" class="btn-corporate-primary text-xs !py-2.5 !px-5 inline-flex">
                            <i class="fa-solid fa-download mr-1"></i> Download {{ $application->cv_original_name }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- 4. Status History Audit Trail -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-timeline text-cyan-600"></i>
                    <span>Application Status Audit Trail</span>
                </h3>

                <div class="space-y-4">
                    @forelse($application->statusLogs as $log)
                        <div class="flex items-start gap-3 text-xs">
                            <div class="w-2 h-2 rounded-full bg-brand-blue mt-1.5 flex-shrink-0"></div>
                            <div class="flex-1 bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span class="font-bold text-slate-800">
                                        {{ $log->old_status_label }} → <strong class="text-brand-blue">{{ $log->new_status_label }}</strong>
                                    </span>
                                    <span class="text-[10px] text-slate-400">{{ $log->created_at ? $log->created_at->format('d M Y, h:i A') : '' }}</span>
                                </div>
                                <p class="text-slate-600">{{ $log->notes }}</p>
                                <p class="text-[10px] text-slate-400 mt-1 font-semibold">Updated by: {{ $log->causer->name ?? 'System / Candidate' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">No status changes recorded yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- 5. Email Logs for this Candidate -->
            @if($application->emailLogs->count() > 0)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-4">
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-envelope-circle-check text-indigo-600"></i>
                        <span>Dispatched Email Activity</span>
                    </h3>

                    <div class="space-y-3">
                        @foreach($application->emailLogs as $elog)
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="font-bold text-navy">{{ $elog->subject }}</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $elog->status === 'sent' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ ucfirst($elog->status) }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500">To: {{ $elog->recipient_email }} | Sent: {{ $elog->sent_at ? $elog->sent_at->format('d M Y, h:i A') : '—' }}</p>
                                @if(!empty($elog->cc))
                                    <p class="text-[10px] text-slate-400">CC: {{ implode(', ', $elog->cc) }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Right Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Update Status Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-brand-blue"></i>
                    <span>Update Applicant Status</span>
                </h3>

                <form action="{{ route('admin.careers.applications.status', $application->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Current Status
                        </label>
                        <select name="status" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none bg-white font-bold text-slate-800">
                            <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="under_review" {{ $application->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                            <option value="interview_scheduled" {{ $application->status === 'interview_scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                            <option value="interviewed" {{ $application->status === 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                            <option value="selected" {{ $application->status === 'selected' ? 'selected' : '' }}>Selected</option>
                            <option value="hired" {{ $application->status === 'hired' ? 'selected' : '' }}>Hired</option>
                            <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="withdrawn" {{ $application->status === 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Status Transition Remarks / Notes
                        </label>
                        <textarea name="notes" rows="2" placeholder="e.g. Cleared preliminary screening, qualified for technical interview." class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full btn-scientific-primary text-xs !py-2.5 justify-center">
                        <i class="fa-solid fa-check"></i>
                        <span>Apply Status Change</span>
                    </button>
                </form>
            </div>

            <!-- Applied Job Summary Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-2 border-b border-slate-100">
                    Applied Position
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <a href="{{ route('admin.careers.jobs.edit', $application->job->id ?? 0) }}" class="font-bold text-sm text-navy hover:text-brand-blue transition block">
                            {{ $application->job->title ?? 'N/A' }}
                        </a>
                        <p class="text-slate-400 text-[11px] mt-0.5">{{ $application->job->effective_department_name ?? 'General' }}</p>
                    </div>

                    <div class="pt-2 border-t border-slate-100 space-y-2 text-slate-600">
                        <p><strong>Location:</strong> {{ $application->job->location ?? 'Savar, Dhaka' }}</p>
                        <p><strong>Employment:</strong> {{ $application->job->employment_type_label ?? 'Full Time' }}</p>
                        <p><strong>Salary:</strong> {{ $application->job->formatted_salary ?? 'Negotiable' }}</p>
                        <p><strong>Deadline:</strong> {{ $application->job->application_deadline ? $application->job->application_deadline->format('d M Y') : 'Open Ended' }}</p>
                    </div>
                </div>

                <a href="{{ route('admin.careers.jobs.edit', $application->job->id ?? 0) }}" class="w-full px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition block text-center">
                    Edit Position Details
                </a>
            </div>

            <!-- Private HR Internal Notes Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-lock text-amber-500"></i>
                    <span>Private HR Notes</span>
                </h3>
                <p class="text-[11px] text-slate-400">These notes are confidential and never visible to the applicant.</p>

                <form action="{{ route('admin.careers.applications.notes', $application->id) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <textarea name="internal_notes" rows="4" placeholder="Enter confidential candidate remarks, salary expectations, or interview panel feedback..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">{{ old('internal_notes', $application->internal_notes) }}</textarea>

                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-navy text-white text-xs font-bold transition">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Save HR Notes
                    </button>
                </form>
            </div>

        </div>

    </div>

    <!-- Interview Email Modal Component -->
    <div id="email-modal" class="fixed inset-0 z-50 bg-navy/80 backdrop-blur-md hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] shadow-2xl border border-slate-100 flex flex-col overflow-hidden">
            
            <div class="bg-gradient-to-r from-navy via-brand-blue to-navy-dark px-6 py-4 text-white flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-brand-cyan">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-extrabold text-sm text-white">Send Interview Invitation</h3>
                        <p class="text-xs text-brand-cyan">Recipient: {{ $application->name }} ({{ $application->email }})</p>
                    </div>
                </div>
                <button type="button" onclick="closeEmailModal()" class="p-2 text-slate-300 hover:text-white text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.careers.applications.bulk-email') }}" method="POST" class="flex-1 overflow-y-auto p-6 space-y-4">
                @csrf
                <input type="hidden" name="application_ids[]" value="{{ $application->id }}">

                <!-- CC & BCC -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">CC Address</label>
                        <input type="text" name="cc" placeholder="hr@adonischemical.com" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">BCC Address</label>
                        <input type="text" name="bcc" placeholder="recruitment@adonischemical.com" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">
                    </div>
                </div>

                <!-- Subject -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Subject *</label>
                    <input type="text" name="subject" required value="Interview Invitation — {{ $application->job->title ?? 'Position' }} [Adonis Chemical]" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">
                </div>

                <!-- Interview Schedule Summary -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 rounded-2xl bg-blue-50/60 border border-blue-100">
                    <div>
                        <label class="block text-[10px] font-bold text-blue-950 uppercase tracking-wider mb-1">Date</label>
                        <input type="date" name="interview_date" class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-white outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-blue-950 uppercase tracking-wider mb-1">Time</label>
                        <input type="text" name="interview_time" placeholder="e.g. 11:30 AM" class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-white outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-blue-950 uppercase tracking-wider mb-1">Location</label>
                        <input type="text" name="interview_location" value="Plant: Genda, Karnapara, Savar, Dhaka" class="w-full px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 bg-white outline-none">
                    </div>
                </div>

                <!-- Message Body -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Body *</label>
                    <textarea name="body" rows="6" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none leading-relaxed">Dear {{ $application->name }},

Congratulations. We have reviewed your application for the position of {{ $application->job->title ?? 'Applied Position' }} and are pleased to invite you for an in-person interview and technical evaluation.

Interview Schedule:
• Date: @{{ interview_date }}
• Time: @{{ interview_time }}
• Location: @{{ interview_location }}
• Reference No: {{ $application->reference }}

Please bring a printed copy of your updated CV, academic credentials, and national ID. Kindly confirm your availability by replying to this email.

Best regards,
HR Recruitment Committee
Adonis Chemical Industries Ltd.</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeEmailModal()" class="px-5 py-2.5 rounded-full text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="btn-scientific-primary text-xs !py-2.5 !px-6">
                        <i class="fa-solid fa-paper-plane mr-1"></i>
                        <span>Send Email</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openSingleEmailModal() {
        const modal = document.getElementById('email-modal');
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
