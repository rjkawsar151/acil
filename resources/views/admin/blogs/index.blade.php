@extends('layouts.admin')

@section('page_title', 'Blog Articles & News')
@section('page_subtitle', 'Manage formulation insights, corporate news, and scientific articles')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">
                Total Articles: <strong>{{ $blogs->total() }}</strong>
            </span>
            <a href="{{ route('admin.blog-categories.index') }}" class="text-xs font-bold text-brand-blue hover:underline">
                <i class="fa-solid fa-folder-tree mr-1"></i> Manage Categories ({{ $categories->count() }})
            </a>
        </div>

        <a href="{{ route('admin.blogs.create') }}" class="btn-scientific-primary text-xs !py-2.5 !px-5 self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i>
            <span>Write New Article</span>
        </a>
    </div>

    <!-- Articles Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-4 px-6">Article</th>
                    <th class="py-4 px-4">Category</th>
                    <th class="py-4 px-4">Author</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-4">Published Date</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($blogs as $blog)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 flex-shrink-0">
                                <div>
                                    <h4 class="font-bold text-sm text-navy leading-snug">{{ $blog->title }}</h4>
                                    <p class="text-[11px] text-slate-400 line-clamp-1 max-w-sm">{{ $blog->excerpt }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold text-[10px]">
                                {{ $blog->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-600 font-medium">{{ $blog->author }}</td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $blog->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($blog->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-slate-500">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '—' }}</td>
                        <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                            <a href="{{ route('news.show', $blog->slug) }}" target="_blank" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Delete this article?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">No blog articles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-100">
            {{ $blogs->links() }}
        </div>
    </div>

@endsection
