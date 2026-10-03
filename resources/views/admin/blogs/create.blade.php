@extends('layouts.admin')

@section('page_title', 'Write New Article')
@section('page_subtitle', 'Publish formulation breakthroughs and corporate news')

@section('content')

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl space-y-6">
        @csrf

        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-6">
                <div class="sm:col-span-8">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Article Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. The Chemistry of Keratin in Salon Restorative Formulas">
                </div>

                <div class="sm:col-span-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Category</label>
                    <select name="category_id" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Author Name *</label>
                    <input type="text" name="author" value="{{ old('author', auth()->user()->name) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Custom URL Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="auto-generated-if-blank">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Article Excerpt / Lead Summary</label>
                <textarea name="excerpt" rows="2" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="Brief 1-2 sentence lead paragraph...">{{ old('excerpt') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Article Body (HTML supported) *</label>
                <textarea name="content" rows="12" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue font-mono text-xs" placeholder="<p>Detailed article paragraphs, h2 headers, lists...</p>">{{ old('content') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Featured Image</label>
                    <input type="file" name="featured_image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Publishing Status *</label>
                    <select name="status" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue bg-white">
                        <option value="published">Published</option>
                        <option value="draft">Save as Draft</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.blogs.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Publish Article</span>
            </button>
        </div>

    </form>

@endsection
