@extends('layouts.admin')

@section('page_title', 'Add Manufacturing Step')
@section('page_subtitle', 'Define a precision production stage')

@section('content')

    <form action="{{ route('admin.manufacturing.store') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl space-y-6">
        @csrf

        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Step Number *</label>
                    <input type="number" name="step_number" value="{{ old('step_number', 1) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Step Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. Raw Material Selection & Quality Assay">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subtitle / Kicker</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. Certified Global Chemical Sourcing">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Description *</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="Describe the step in detail...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Key Quality Bullet Points (One per line)</label>
                <textarea name="details_text" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="Certificates of Analysis (COA) verification&#10;FTIR Spectroscopy checks"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Step Image</label>
                <input type="file" name="image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded text-brand-blue focus:ring-0">
                    <span class="text-xs font-bold text-navy">Active in Manufacturing Showcase</span>
                </label>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.manufacturing.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save Step</span>
            </button>
        </div>

    </form>

@endsection
