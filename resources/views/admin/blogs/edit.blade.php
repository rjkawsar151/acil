@extends('layouts.admin')

@section('page_title', 'Edit Article')
@section('page_subtitle', "Editing: {$blog->title}")

@section('content')

    <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="max-w-4xl space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-6">
                <div class="sm:col-span-8">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Article Title *</label>
                    <input type="text" name="title" value="{{ old('title', $blog->title) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>

                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Category</label>
                    <select name="category_id" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $blog->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Author Name *</label>
                    <input type="text" name="author" value="{{ old('author', $blog->author) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Custom URL Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug', $blog->slug) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Article Excerpt</label>
                <textarea name="excerpt" rows="2" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Article Body (HTML supported) *</label>
                <textarea name="content" rows="12" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue font-mono text-xs">{{ old('content', $blog->content) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Change Featured Image</label>
                    <input type="file" name="featured_image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Publishing Status *</label>
                    <select name="status" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="published" {{ $blog->status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $blog->status === 'draft' ? 'selected' : '' }}>Save as Draft</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.blogs.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Update Article</span>
            </button>
        </div>

    </form>

@endsection
