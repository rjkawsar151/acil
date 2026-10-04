@extends('layouts.app')

@section('title', 'Application Submitted | ' . \App\Models\Setting::get('site_name', 'Adonis Chemical Industries Ltd.'))

@section('content')

    <section class="min-h-[80vh] flex items-center justify-center py-16 bg-[#F8FAFC]">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 w-full">
            
            <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-xl text-center relative overflow-hidden">
                
                <!-- Decorative Scientific Background Blob -->
                <div class="absolute -top-20 -right-20 w-48 h-48 bg-emerald-50 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-blue-50 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Animated Success Badge -->
                <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto text-3xl mb-6 shadow-lg shadow-emerald-500/20">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 mb-3">
                    Application Successfully Received
                </span>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#071B33] mb-3">
                    Thank You, {{ $application->name }}!
                </h1>

                <p class="text-sm text-slate-600 leading-relaxed max-w-md mx-auto mb-8">
                    Your application for the position of <strong class="text-[#071B33]">{{ $application->job->title ?? 'the open position' }}</strong> has been recorded in our talent recruitment database.
                </p>

                <!-- Reference Card -->
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 max-w-md mx-auto mb-8 text-left">
                    <div class="flex items-center justify-between gap-4 pb-3 border-b border-slate-200">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block">Application Reference No</span>
                            <span class="text-base font-extrabold text-navy font-mono">{{ $application->reference }}</span>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ $application->reference }}'); alert('Reference number copied!');" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-brand-blue hover:border-brand-blue transition text-xs font-semibold flex items-center gap-1.5 shadow-sm" title="Copy Reference">
                            <i class="fa-regular fa-copy"></i>
                            <span>Copy</span>
                        </button>
                    </div>

                    <div class="pt-3 space-y-1.5 text-xs text-slate-600">
                        <p><strong>Applicant:</strong> {{ $application->name }}</p>
                        <p><strong>Confirmation Sent To:</strong> {{ $application->email }}</p>
                        <p><strong>Submission Date:</strong> {{ $application->applied_at ? $application->applied_at->format('d M Y, h:i A') : date('d M Y') }}</p>
                    </div>
                </div>

                <!-- What Happens Next Timeline -->
                <div class="text-left max-w-md mx-auto mb-8 bg-blue-50/50 rounded-2xl p-5 border border-blue-100">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-blue-900 mb-3 flex items-center gap-1.5">
                        <i class="fa-solid fa-list-ol text-blue-600"></i>
                        <span>What Happens Next?</span>
                    </h4>
                    <ol class="space-y-2 text-xs text-slate-600 list-decimal list-inside leading-relaxed">
                        <li>Our Human Resources department will screen your qualifications and CV.</li>
                        <li>Shortlisted candidates will receive an interview invitation by email or phone.</li>
                        <li>You may be invited for a technical assessment and interview at our Savar plant or head office.</li>
                    </ol>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('careers.index') }}" class="w-full sm:w-auto btn-scientific-primary text-xs !py-3 !px-6">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>View Other Open Positions</span>
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3 rounded-full text-xs font-bold text-slate-600 hover:bg-slate-100 transition border border-slate-200">
                        <span>Return to Homepage</span>
                    </a>
                </div>

            </div>

        </div>
    </section>

@endsection
