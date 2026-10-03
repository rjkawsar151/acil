@extends('layouts.admin')

@section('page_title', 'Dynamic Pages')
@section('page_subtitle', 'Manage corporate information pages and custom content')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">
            Total Pages: <strong>{{ $pages->total() }}</strong>
        </p>
        <a href="{{ route('admin.pages.create') }}" class="btn-scientific-primary text-xs !py-2.5 !px-5">
            <i class="fa-solid fa-plus"></i>
            <span>Add Custom Page</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-4 px-6">Page Title</th>
                    <th class="py-4 px-4">Slug</th>
                    <th class="py-4 px-4">Template</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @foreach($pages as $page)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6">
                            <h4 class="font-bold text-sm text-navy">{{ $page->title }}</h4>
                            <p class="text-[11px] text-slate-400 line-clamp-1 max-w-sm">{{ $page->subtitle }}</p>
                        </td>
                        <td class="py-4 px-4 font-mono text-slate-500">/{{ $page->slug }}</td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold text-[10px]">
                                {{ $page->template }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $page->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($page->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-1">
                            <a href="{{ url('/' . $page->slug) }}" target="_blank" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Delete this page?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-100">
            {{ $pages->links() }}
        </div>
    </div>

@endsection
