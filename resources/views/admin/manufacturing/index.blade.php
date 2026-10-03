@extends('layouts.admin')

@section('page_title', 'Manufacturing Steps CMS')
@section('page_subtitle', 'Manage 7-step Savar plant manufacturing process')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">
            Total Steps: <strong>{{ $steps->count() }}</strong>
        </p>
        <a href="{{ route('admin.manufacturing.create') }}" class="btn-scientific-primary text-xs !py-2.5 !px-5">
            <i class="fa-solid fa-plus"></i>
            <span>Add Step</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-4 px-6 text-center">Step #</th>
                    <th class="py-4 px-4">Title & Subtitle</th>
                    <th class="py-4 px-4">Description</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @foreach($steps as $step)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 text-center font-bold text-base text-brand-blue">{{ $step->step_number }}</td>
                        <td class="py-4 px-4">
                            <h4 class="font-bold text-sm text-navy">{{ $step->title }}</h4>
                            <p class="text-[11px] text-brand-scientific">{{ $step->subtitle }}</p>
                        </td>
                        <td class="py-4 px-4">
                            <p class="text-xs text-slate-500 line-clamp-2 max-w-md">{{ $step->description }}</p>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $step->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $step->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-1">
                            <a href="{{ route('admin.manufacturing.edit', $step->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.manufacturing.destroy', $step->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Delete this step?')">
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
