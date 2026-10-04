@extends('layouts.admin')

@section('title', 'Career Departments | Admin CMS')
@section('page_title', 'Recruitment Departments')
@section('page_subtitle', 'Manage functional corporate departments for classifying job posts')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Add Department Form (4 cols) -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm space-y-4 sticky top-24">
                <h3 class="text-sm font-extrabold uppercase tracking-wider text-navy pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-plus text-brand-blue"></i>
                    <span>Add New Department</span>
                </h3>

                <form action="{{ route('admin.careers.departments.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Department Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" required placeholder="e.g. Research & Development" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Description (Optional)
                        </label>
                        <textarea name="description" rows="3" placeholder="Brief notes about department focus..." class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Sort Order
                        </label>
                        <input type="number" name="sort_order" value="0" class="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-brand-blue rounded border-slate-300">
                            <span>Active / Available for Selection</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full btn-scientific-primary text-xs !py-3 justify-center">
                        <i class="fa-solid fa-plus"></i>
                        <span>Save Department</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Department Table (8 cols) -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-navy">Existing Departments ({{ $departments->count() }})</h3>
                    <a href="{{ route('admin.careers.jobs.index') }}" class="text-xs font-bold text-brand-blue hover:underline">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Back to Jobs
                    </a>
                </div>

                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-4 px-6">Department Name</th>
                            <th class="py-4 px-4 text-center">Active Jobs</th>
                            <th class="py-4 px-4 text-center">Status</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($departments as $dept)
                            <tr class="hover:bg-slate-50/80 transition">
                                
                                <td class="py-4 px-6">
                                    <p class="font-bold text-sm text-navy leading-snug">{{ $dept->name }}</p>
                                    @if($dept->description)
                                        <p class="text-[11px] text-slate-400 line-clamp-1">{{ $dept->description }}</p>
                                    @endif
                                    <span class="text-[10px] text-slate-400 font-mono">Slug: {{ $dept->slug }}</span>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('admin.careers.jobs.index', ['department_id' => $dept->id]) }}" class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition">
                                        {{ $dept->jobs_count }} {{ Str::plural('Job', $dept->jobs_count) }}
                                    </a>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $dept->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $dept->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <form action="{{ route('admin.careers.departments.destroy', $dept->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this department?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">No departments configured yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
