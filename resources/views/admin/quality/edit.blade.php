@extends('layouts.admin')

@section('page_title', 'Edit QA Checkpoint')
@section('page_subtitle', "Editing Stage #{$step->step_number}: {$step->title}")

@section('content')

    <form action="{{ route('admin.quality.update', $step->id) }}" method="POST" enctype="multipart/form-data" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Stage Number *</label>
                    <input type="number" name="step_number" value="{{ old('step_number', $step->step_number) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Stage Title *</label>
                    <input type="text" name="title" value="{{ old('title', $step->title) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $step->subtitle) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Description *</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('description', $step->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Applied Laboratory Standards (One per line)</label>
                <textarea name="standards_text" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ is_array($step->standards) ? implode("\n", $step->standards) : '' }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Change Image</label>
                    <input type="file" name="image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
                </div>
                <div>
                    <img src="{{ $step->image_url }}" alt="{{ $step->title }}" class="w-20 h-20 rounded-xl object-cover border border-slate-200">
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $step->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-blue focus:ring-0">
                    <span class="text-xs font-bold text-navy">Active in Quality Assurance Showcase</span>
                </label>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.quality.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Update Stage</span>
            </button>
        </div>

    </form>

@endsection
