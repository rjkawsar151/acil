@extends('layouts.admin')

@section('page_title', 'Search Engine Optimization (SEO)')
@section('page_subtitle', 'Manage meta tags, OpenGraph social sharing previews, and Schema.org structured data per page')

@section('content')

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-navy text-sm">Indexed Pages & Canonical Routes</h3>
                <p class="text-xs text-slate-400">Search engine meta titles, descriptions, keywords and social graphs</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Page Name</th>
                        <th class="py-4 px-4">Meta Title</th>
                        <th class="py-4 px-4">Meta Description</th>
                        <th class="py-4 px-4 text-center">OG Image</th>
                        <th class="py-4 px-4 text-center">Schema Data</th>
                        <th class="py-4 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($seoSettings as $seo)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-bold text-navy whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-file-code text-brand-blue"></i>
                                    <span class="capitalize">{{ str_replace(['_', '-'], ' ', $seo->page_name) }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 font-mono">/{{ $seo->page_name === 'home' ? '' : $seo->page_name }}</span>
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-800 max-w-xs truncate">
                                {{ $seo->meta_title ?: 'Default Title' }}
                            </td>
                            <td class="py-4 px-4 text-slate-500 max-w-sm">
                                <p class="line-clamp-2 text-[11px]">{{ $seo->meta_description ?: 'No meta description set.' }}</p>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($seo->og_image)
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block" title="OG Image Active"></span>
                                @else
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-300 inline-block" title="No Custom OG Image"></span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($seo->schema_markup)
                                    <span class="px-2 py-0.5 rounded bg-blue-50 text-brand-blue font-mono font-bold text-[10px]">JSON-LD</span>
                                @else
                                    <span class="text-slate-400 text-[10px]">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <a href="{{ route('admin.seo.edit', $seo->id) }}" class="btn-scientific-primary text-xs !py-1.5 !px-3">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit Meta</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No SEO routes registered.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
