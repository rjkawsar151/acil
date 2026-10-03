@extends('layouts.admin')

@section('page_title', 'Homepage Sections CMS')
@section('page_subtitle', 'Enable, disable, reorder and customize homepage sections')

@section('content')

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-4 px-6">Section Key</th>
                    <th class="py-4 px-4">Heading Title</th>
                    <th class="py-4 px-4">Button Label</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-4 text-center">Order</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @foreach($sections as $sec)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6">
                            <span class="font-mono font-bold text-navy">{{ $sec->section_key }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <h4 class="font-bold text-sm text-navy">{{ $sec->title }}</h4>
                            <p class="text-[11px] text-slate-400 line-clamp-1 max-w-sm">{{ $sec->subtitle }}</p>
                        </td>
                        <td class="py-4 px-4 font-medium">{{ $sec->button_text ?: '—' }}</td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $sec->is_enabled ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $sec->is_enabled ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center font-bold">{{ $sec->sort_order }}</td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.homepage.edit', $sec->id) }}" class="btn-scientific-outline-dark text-xs !py-1.5 !px-3 inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Edit Section</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
