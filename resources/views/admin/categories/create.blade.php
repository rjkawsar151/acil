@extends('layouts.admin')

@section('page_title', 'Add Category')
@section('page_subtitle', 'Create a new product grouping')

@section('content')

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl space-y-6">
        @csrf

        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Category Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. Hair Care Formulations">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Custom Slug (Optional)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="auto-generated-if-blank">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Text</label>
                    <input type="text" name="badge_text" value="{{ old('badge_text', 'Salon & Consumer') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Display Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Category Image</label>
                <input type="file" name="image" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="Describe the formulations within this category...">{{ old('description') }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded text-brand-blue focus:ring-0">
                    <span class="text-xs font-bold text-navy">Active & Visible in Catalog</span>
                </label>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save Category</span>
            </button>
        </div>

    </form>

@endsection
