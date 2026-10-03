@extends('layouts.admin')

@section('page_title', 'Navigation & Menus')
@section('page_subtitle', 'Configure top header navigation bar, nested dropdowns, and footer link columns')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Add Link Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm sticky top-6">
                <h3 class="font-bold text-navy text-sm mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-link text-brand-blue"></i>
                    <span>Add Navigation Item</span>
                </h3>

                <form action="{{ route('admin.navigation.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    <div>
                        <label class="block font-bold text-navy mb-1">Menu Label / Title *</label>
                        <input type="text" name="title" required placeholder="e.g. Products, About Us" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1">Target URL / Route *</label>
                        <input type="text" name="url" required placeholder="e.g. /products or https://..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-navy mb-1">Location *</label>
                            <select name="location" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                                <option value="header">Header Navbar</option>
                                <option value="footer">Footer Column</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-navy mb-1">Parent Item (Submenu)</label>
                            <select name="parent_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                                <option value="">-- None (Top Level) --</option>
                                @foreach($headerItems as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }} (Header)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-navy mb-1">Open In</label>
                            <select name="target" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                                <option value="_self">Same Tab (_self)</option>
                                <option value="_blank">New Tab (_blank)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-navy mb-1">Sort Order</label>
                            <input type="number" name="sort_order" value="0" min="0" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked class="rounded border-slate-300 text-brand-blue focus:ring-brand-blue">
                        <label for="is_active" class="font-bold text-slate-700">Show on Live Site</label>
                    </div>

                    <button type="submit" class="btn-scientific-primary w-full text-xs !py-2.5 justify-center mt-4">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Menu Item</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Menus Structure List -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Header Navigation -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-navy text-sm">Main Header Navigation</h3>
                        <p class="text-xs text-slate-400">Items displayed in the main top header & mobile drawer</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-brand-blue">
                        {{ $headerItems->count() }} Top-Level Items
                    </span>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($headerItems as $item)
                        <div class="p-4 hover:bg-slate-50/50 transition">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-500 shrink-0">
                                        {{ $item->sort_order }}
                                    </span>
                                    <div class="min-w-0">
                                        <div class="font-bold text-navy text-xs flex items-center gap-2">
                                            <span>{{ $item->title }}</span>
                                            @if(!$item->is_active)
                                                <span class="px-1.5 py-0.2 rounded bg-amber-50 text-amber-700 font-bold border border-amber-200 text-[10px]">Hidden</span>
                                            @else
                                                <span class="px-1.5 py-0.2 rounded bg-emerald-50 text-emerald-700 font-bold border border-emerald-200 text-[10px]">Live</span>
                                            @endif
                                            @if($item->target === '_blank')
                                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                                            @endif
                                        </div>
                                        <span class="font-mono text-[11px] text-slate-400 block truncate">{{ $item->url }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button" onclick="document.getElementById('edit-nav-{{ $item->id }}').classList.toggle('hidden')" class="px-2.5 py-1.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-semibold transition flex items-center gap-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </button>

                                    <form action="{{ route('admin.navigation.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete \'{{ addslashes($item->title) }}\'? This will remove it from the header.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                                            <i class="fa-solid fa-trash-can"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Edit Form Dropdown -->
                            <div id="edit-nav-{{ $item->id }}" class="hidden mt-3 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                <form action="{{ route('admin.navigation.update', $item->id) }}" method="POST" class="space-y-3 text-xs">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="location" value="{{ $item->location }}">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block font-bold text-navy mb-1">Title</label>
                                            <input type="text" name="title" value="{{ $item->title }}" required class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs">
                                        </div>
                                        <div>
                                            <label class="block font-bold text-navy mb-1">URL</label>
                                            <input type="text" name="url" value="{{ $item->url }}" required class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-mono">
                                        </div>
                                        <div>
                                            <label class="block font-bold text-navy mb-1">Sort Order</label>
                                            <input type="number" name="sort_order" value="{{ $item->sort_order }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs">
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between pt-1">
                                        <label class="flex items-center gap-2 cursor-pointer font-bold text-slate-700">
                                            <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }} class="rounded text-brand-blue">
                                            <span>Active on Live Site</span>
                                        </label>
                                        <div class="flex items-center gap-2">
                                            <button type="button" onclick="document.getElementById('edit-nav-{{ $item->id }}').classList.add('hidden')" class="px-3 py-1 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 font-semibold">Cancel</button>
                                            <button type="submit" class="px-3 py-1 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-semibold">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Children / Dropdown Items -->
                            @if($item->children && $item->children->count() > 0)
                                <div class="mt-3 ml-10 pl-4 border-l-2 border-brand-blue/30 space-y-2">
                                    @foreach($item->children as $child)
                                        <div class="flex items-center justify-between py-1.5 px-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-turn-up rotate-90 text-slate-400 text-[10px]"></i>
                                                <span class="font-semibold text-navy">{{ $child->title }}</span>
                                                <span class="font-mono text-[10px] text-slate-400">({{ $child->url }})</span>
                                            </div>
                                            <form action="{{ route('admin.navigation.destroy', $child->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete sub-link \'{{ addslashes($child->title) }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 rounded-lg text-rose-600 hover:bg-rose-50 text-[11px] font-bold flex items-center gap-1 transition">
                                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">No header links configured.</div>
                    @endforelse
                </div>
            </div>

            <!-- Footer Links -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-navy text-sm">Footer Navigation Links</h3>
                        <p class="text-xs text-slate-400">Quick links displayed in the footer columns</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-brand-blue">
                        {{ $footerItems->count() }} Links
                    </span>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($footerItems as $item)
                        <div class="p-4 flex items-center justify-between hover:bg-slate-50/50 transition gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-500 shrink-0">
                                    {{ $item->sort_order }}
                                </span>
                                <div class="min-w-0">
                                    <div class="font-bold text-navy text-xs">{{ $item->title }}</div>
                                    <span class="font-mono text-[11px] text-slate-400 block truncate">{{ $item->url }}</span>
                                </div>
                            </div>
                            <form action="{{ route('admin.navigation.destroy', $item->id) }}" method="POST" class="inline-block shrink-0" onsubmit="return confirm('Delete footer link \'{{ addslashes($item->title) }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">No footer links configured.</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

@endsection
