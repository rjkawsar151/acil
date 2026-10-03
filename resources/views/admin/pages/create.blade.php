@extends('layouts.admin')

@section('page_title', 'Create Page')
@section('page_subtitle', 'Add a custom corporate page to the CMS')

@section('content')

    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl space-y-6">
        @csrf

        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Page Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. Terms & Commercial Policies">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Custom Slug (Optional)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. commercial-terms">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Template *</label>
                    <select name="template" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="default">Default Content Template</option>
                        <option value="about">About Page Template</option>
                        <option value="sinoda">SINODA Brand Template</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Short Excerpt</label>
                <textarea name="excerpt" rows="2" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('excerpt') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Page Content (HTML supported) *</label>
                <textarea name="content" rows="10" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue font-mono text-xs" placeholder="<p>Enter page content here...</p>">{{ old('content') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Banner Image</label>
                    <input type="file" name="banner_image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.pages.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save Page</span>
            </button>
        </div>

    </form>

@endsection
