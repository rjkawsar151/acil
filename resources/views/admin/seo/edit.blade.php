@extends('layouts.admin')

@section('page_title', 'Edit Page SEO: ' . ucfirst(str_replace(['_', '-'], ' ', $seo->page_name)))
@section('page_subtitle', 'Configure metadata for search engine crawlers and social share cards')

@section('content')

    <div class="max-w-4xl">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.seo.index') }}" class="text-xs font-bold text-slate-500 hover:text-brand-blue flex items-center gap-1.5 transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to SEO Pages</span>
            </a>
        </div>

        <form action="{{ route('admin.seo.update', $seo->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm space-y-6 text-xs">
                
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-navy text-sm">Target Page Route</div>
                        <div class="font-mono text-slate-400 text-xs">/{{ $seo->page_name === 'home' ? '' : $seo->page_name }}</div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-brand-blue font-bold text-xs uppercase">
                        {{ $seo->page_name }}
                    </span>
                </div>

                <div>
                    <label class="block font-bold text-navy mb-1.5">Meta Title Tag (Recommended: 50-60 chars)</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $seo->meta_title) }}" placeholder="e.g. SINODA Industrial Chemicals | Adonis Chemical Limited" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                </div>

                <div>
                    <label class="block font-bold text-navy mb-1.5">Meta Description (Recommended: 150-160 chars)</label>
                    <textarea name="meta_description" rows="3" placeholder="Brief summary displayed in Google search result snippets..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">{{ old('meta_description', $seo->meta_description) }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-navy mb-1.5">Meta Keywords (Comma separated)</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $seo->meta_keywords) }}" placeholder="e.g. industrial chemical, SINODA, textile dye, water treatment Bangladesh, Genda Savar" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                </div>

                <div>
                    <label class="block font-bold text-navy mb-1.5">Canonical URL Override</label>
                    <input type="url" name="canonical_url" value="{{ old('canonical_url', $seo->canonical_url) }}" placeholder="https://adonischemical.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">
                </div>

                <!-- OG Image -->
                <div>
                    <label class="block font-bold text-navy mb-1.5">OpenGraph Social Share Image (1200x630px recommended)</label>
                    <div class="flex items-center gap-4">
                        @if($seo->og_image)
                            <img src="{{ asset('storage/' . $seo->og_image) }}" alt="OG Preview" class="w-24 h-14 rounded-xl object-cover border border-slate-200">
                        @endif
                        <input type="file" name="og_image" accept="image/*" class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-brand-blue file:text-white cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-navy mb-1.5">Schema.org JSON-LD Structured Data Script</label>
                    <textarea name="schema_markup" rows="6" placeholder='{ "@@context": "https://schema.org", "@@type": "Organization", ... }' class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">{{ old('schema_markup', $seo->schema_markup) }}</textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.seo.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="btn-scientific-primary text-xs !py-2.5 !px-6">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Save SEO Configuration</span>
                    </button>
                </div>

            </div>
        </form>
    </div>

@endsection
