@extends('layouts.admin')

@section('page_title', 'Add Metric Counter')
@section('page_subtitle', 'Define an animated counter for homepage')

@section('content')

    <form action="{{ route('admin.statistics.store') }}" method="POST" class="max-w-2xl space-y-6">
        @csrf

        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
            
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Metric Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. Years of Excellence">
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Prefix</label>
                    <input type="text" name="prefix" value="{{ old('prefix') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. $">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Number Value *</label>
                    <input type="text" name="value" value="{{ old('value') }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. 15">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Suffix</label>
                    <input type="text" name="suffix" value="{{ old('suffix', '+') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. + / L+">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">FontAwesome Icon Name</label>
                    <input type="text" name="icon" value="{{ old('icon', 'chart-simple') }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="e.g. award, flask, industry">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Short Description</label>
                <textarea name="description" rows="2" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue" placeholder="Supporting text below number...">{{ old('description') }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded text-brand-blue focus:ring-0">
                    <span class="text-xs font-bold text-navy">Active on Homepage</span>
                </label>
            </div>

        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.statistics.index') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">Cancel</a>
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save Metric</span>
            </button>
        </div>

    </form>

@endsection
