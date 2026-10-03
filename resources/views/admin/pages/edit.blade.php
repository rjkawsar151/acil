@extends('layouts.admin')

@section('page_title', 'Edit Page')
@section('page_subtitle', "Editing: {$page->title}")

@section('content')

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Page Title *</label>
                    <input type="text" name="title" value="{{ old('title', $page->title) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $page->subtitle) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Template *</label>
                    <select name="template" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="default" {{ $page->template === 'default' ? 'selected' : '' }}>Default Content Template</option>
                        <option value="about" {{ $page->template === 'about' ? 'selected' : '' }}>About Page Template</option>
                        <option value="sinoda" {{ $page->template === 'sinoda' ? 'selected' : '' }}>SINODA Brand Template</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Short Excerpt</label>
                <textarea name="excerpt" rows="2" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('excerpt', $page->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Page Content (HTML supported) *</label>
                <textarea name="content" rows="12" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue font-mono text-xs">{{ old('content', $page->content) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Change Banner Image</label>
                    <input type="file" name="banner_image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="published" {{ $page->status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $page->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.pages.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Update Page</span>
            </button>
        </div>

    </form>

@endsection
