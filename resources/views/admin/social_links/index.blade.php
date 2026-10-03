@extends('layouts.admin')

@section('page_title', 'Social Media Links')
@section('page_subtitle', 'Manage corporate social profiles, icons, and external community links')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Add Social Link Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm sticky top-6">
                <h3 class="font-bold text-navy text-sm mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-share-nodes text-brand-blue"></i>
                    <span>Add Social Channel</span>
                </h3>

                <form action="{{ route('admin.social-links.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    <div>
                        <label class="block font-bold text-navy mb-1">Platform Name *</label>
                        <input type="text" name="platform" required placeholder="e.g. LinkedIn, YouTube, Facebook" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1">FontAwesome Icon Class *</label>
                        <input type="text" name="icon" required placeholder="e.g. fa-brands fa-linkedin-in" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">
                        <span class="text-[10px] text-slate-400 mt-1 block">e.g. fa-brands fa-facebook-f, fa-brands fa-twitter, fa-brands fa-youtube</span>
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1">Profile URL *</label>
                        <input type="url" name="url" required placeholder="https://..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1">Sort Order</label>
                        <input type="number" name="sort_order" value="0" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked class="rounded border-slate-300 text-brand-blue focus:ring-brand-blue">
                        <label for="is_active" class="font-bold text-slate-700">Display on Public Website</label>
                    </div>

                    <button type="submit" class="btn-scientific-primary w-full text-xs !py-2.5 justify-center mt-4">
                        <i class="fa-solid fa-plus"></i>
                        <span>Save Social Link</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Social Links List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-navy text-sm">Active Social Links</h3>
                        <p class="text-xs text-slate-400">Displayed in top bar, footer, and contact touchpoints</p>
                    </div>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($socialLinks as $link)
                        <div class="p-4 flex items-center justify-between hover:bg-slate-50/50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-brand-blue text-base">
                                    <i class="{{ $link->icon }}"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-navy text-xs flex items-center gap-2">
                                        <span>{{ $link->platform }}</span>
                                        @if(!$link->is_active)
                                            <span class="px-1.5 py-0.2 rounded bg-slate-100 text-slate-500 text-[10px]">Inactive</span>
                                        @endif
                                    </div>
                                    <a href="{{ $link->url }}" target="_blank" class="font-mono text-[11px] text-slate-400 hover:text-brand-blue truncate block max-w-sm">
                                        {{ $link->url }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-50 border border-slate-200 text-slate-600 font-mono text-[10px]">
                                    Order: {{ $link->sort_order }}
                                </span>
                                <a href="{{ $link->url }}" target="_blank" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                                <form action="{{ route('admin.social-links.destroy', $link->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Delete social link?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">No social media links added yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

@endsection
