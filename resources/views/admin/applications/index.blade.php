@extends('layouts.admin')

@section('page_title', 'Industries & Applications')
@section('page_subtitle', 'Manage commercial industry solutions and salon sectors')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">
            Total Domains: <strong>{{ $applications->count() }}</strong>
        </p>
        <a href="{{ route('admin.applications.create') }}" class="btn-scientific-primary text-xs !py-2.5 !px-5">
            <i class="fa-solid fa-plus"></i>
            <span>Add Industry</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-4 px-6">Domain</th>
                    <th class="py-4 px-4">Subtitle</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-4 text-center">Order</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @foreach($applications as $app)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 font-bold text-navy text-sm">{{ $app->title }}</td>
                        <td class="py-4 px-4 text-slate-500">{{ $app->subtitle }}</td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $app->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $app->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center font-bold">{{ $app->sort_order }}</td>
                        <td class="py-4 px-6 text-right space-x-1">
                            <a href="{{ route('admin.applications.edit', $app->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.applications.destroy', $app->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Delete this industry application?')">
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
    </div>

@endsection
