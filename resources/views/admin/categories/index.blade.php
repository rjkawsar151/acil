@extends('layouts.admin')

@section('page_title', 'Product Categories')
@section('page_subtitle', 'Manage product groupings and catalog taxonomy')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">
            Total Categories: <strong>{{ $categories->count() }}</strong>
        </p>
        <a href="{{ route('admin.categories.create') }}" class="btn-scientific-primary text-xs !py-2.5 !px-5">
            <i class="fa-solid fa-plus"></i>
            <span>Add Category</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-4 px-6">Category</th>
                    <th class="py-4 px-4">Slug</th>
                    <th class="py-4 px-4 text-center">Products</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-4 text-center">Order</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @foreach($categories as $cat)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" class="w-10 h-10 rounded-xl object-cover border border-slate-200">
                                <div>
                                    <h4 class="font-bold text-sm text-navy">{{ $cat->name }}</h4>
                                    <p class="text-[11px] text-slate-400 line-clamp-1 max-w-xs">{{ $cat->description }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 font-mono text-slate-500">{{ $cat->slug }}</td>
                        <td class="py-4 px-4 text-center font-bold text-navy">{{ $cat->products_count }}</td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $cat->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $cat->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center font-bold">{{ $cat->sort_order }}</td>
                        <td class="py-4 px-6 text-right space-x-1">
                            <a href="{{ route('categories.show', $cat->slug) }}" target="_blank" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Delete this category?')">
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
