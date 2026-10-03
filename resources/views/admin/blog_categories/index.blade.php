@extends('layouts.admin')

@section('page_title', 'Blog & News Categories')
@section('page_subtitle', 'Organize chemical research articles, corporate announcements, and updates')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Add Category Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm sticky top-6">
                <h3 class="font-bold text-navy text-sm mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-folder-plus text-brand-blue"></i>
                    <span>Create Category</span>
                </h3>

                <form action="{{ route('admin.blog-categories.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-navy mb-1">Category Name *</label>
                        <input type="text" name="name" required placeholder="e.g. Chemical Innovation" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1">Slug (Optional)</label>
                        <input type="text" name="slug" placeholder="e.g. chemical-innovation" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1">Description</label>
                        <textarea name="description" rows="3" placeholder="Category summary or topic coverage..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none"></textarea>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" id="status" name="status" value="1" checked class="rounded border-slate-300 text-brand-blue focus:ring-brand-blue">
                        <label for="status" class="font-bold text-slate-700">Active / Published</label>
                    </div>

                    <button type="submit" class="btn-scientific-primary w-full text-xs !py-2.5 justify-center mt-4">
                        <i class="fa-solid fa-check"></i>
                        <span>Save Blog Category</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-navy text-sm">Existing Categories ({{ $categories->count() }})</h3>
                    <a href="{{ route('admin.blogs.index') }}" class="text-xs text-brand-blue hover:underline font-bold">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Back to News Articles
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                <th class="py-3 px-6">Name</th>
                                <th class="py-3 px-4">Slug</th>
                                <th class="py-3 px-4 text-center">Articles</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($categories as $cat)
                                <tr class="hover:bg-slate-50/80 transition" x-data="{ editing: false }">
                                    <td class="py-4 px-6 font-bold text-navy">
                                        <template x-if="!editing">
                                            <div>
                                                <div>{{ $cat->name }}</div>
                                                @if($cat->description)
                                                    <p class="text-[11px] text-slate-400 font-normal mt-0.5 line-clamp-1">{{ $cat->description }}</p>
                                                @endif
                                            </div>
                                        </template>
                                        <template x-if="editing">
                                            <form :id="'edit-cat-form-{{ $cat->id }}'" action="{{ route('admin.blog-categories.update', $cat->id) }}" method="POST" class="space-y-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" value="{{ $cat->name }}" class="w-full px-2 py-1 rounded border border-slate-200 text-xs font-bold text-navy">
                                                <input type="text" name="slug" value="{{ $cat->slug }}" class="w-full px-2 py-1 rounded border border-slate-200 text-xs font-mono">
                                                <textarea name="description" class="w-full px-2 py-1 rounded border border-slate-200 text-xs">{{ $cat->description }}</textarea>
                                                <label class="flex items-center gap-1.5 text-slate-600 font-normal">
                                                    <input type="checkbox" name="status" value="1" {{ $cat->status ? 'checked' : '' }}> Active
                                                </label>
                                            </form>
                                        </template>
                                    </td>
                                    <td class="py-4 px-4 font-mono text-slate-400 text-[11px]">{{ $cat->slug }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-2 py-0.5 rounded-full bg-slate-100 font-bold text-navy text-[11px]">{{ $cat->blogs_count }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $cat->status ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                            {{ $cat->status ? 'Active' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right whitespace-nowrap space-x-1">
                                        <template x-if="!editing">
                                            <div class="inline-block">
                                                <button type="button" @click="editing = true" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <form action="{{ route('admin.blog-categories.destroy', $cat->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Delete category?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </template>
                                        <template x-if="editing">
                                            <div class="inline-block space-x-1">
                                                <button type="submit" :form="'edit-cat-form-{{ $cat->id }}'" class="px-3 py-1 bg-emerald-600 text-white rounded font-bold text-[11px] hover:bg-emerald-700">
                                                    Save
                                                </button>
                                                <button type="button" @click="editing = false" class="px-3 py-1 bg-slate-200 text-slate-700 rounded font-bold text-[11px] hover:bg-slate-300">
                                                    Cancel
                                                </button>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">No blog categories found. Create one on the left.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
