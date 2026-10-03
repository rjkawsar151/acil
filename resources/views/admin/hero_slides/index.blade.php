@extends('layouts.admin')

@section('page_title', 'Hero Carousel Slides')
@section('page_subtitle', 'Manage slides, images, badges, headings, and CTA buttons on the homepage hero carousel')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">
                Active Slides in Carousel: <strong class="text-navy">{{ $slides->where('is_active', true)->count() }} / {{ $slides->count() }}</strong>
            </p>
            <p class="text-xs text-slate-400 mt-0.5">Slides automatically rotate every 4 seconds on the homepage.</p>
        </div>
        <a href="{{ route('admin.hero-slides.create') }}" class="btn-scientific-primary text-xs !py-2.5 !px-5 inline-flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            <span>Add New Slide</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-4 px-4 text-center w-16">Order</th>
                    <th class="py-4 px-4 w-28">Preview</th>
                    <th class="py-4 px-4">Slide Content & Badges</th>
                    <th class="py-4 px-4">CTA Buttons</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($slides as $slide)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-4 text-center font-bold text-sm text-brand-blue">
                            {{ $slide->sort_order }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="w-24 h-14 rounded-xl overflow-hidden bg-slate-900 border border-slate-200 shadow-sm relative group">
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="space-y-1.5 max-w-md">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    @if($slide->badge_text)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider 
                                            @if($slide->badge_color === 'cyan') bg-cyan-100 text-cyan-800
                                            @elseif($slide->badge_color === 'emerald') bg-emerald-100 text-emerald-800
                                            @elseif($slide->badge_color === 'amber') bg-amber-100 text-amber-800
                                            @elseif($slide->badge_color === 'purple') bg-purple-100 text-purple-800
                                            @elseif($slide->badge_color === 'red') bg-rose-100 text-rose-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            @if($slide->badge_icon)<i class="{{ $slide->badge_icon }}"></i>@endif
                                            {{ $slide->badge_text }}
                                        </span>
                                    @endif
                                    @if($slide->badge_subtext)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-medium border border-slate-200">
                                            {{ $slide->badge_subtext }}
                                        </span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-sm text-navy leading-snug">{{ $slide->title }}</h4>
                                @if($slide->subtitle)
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">{{ $slide->subtitle }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="space-y-1 text-[11px]">
                                @if($slide->button_text)
                                    <div class="flex items-center gap-1.5 text-slate-700">
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                        <span class="font-semibold">{{ $slide->button_text }}</span>
                                        <span class="text-slate-400 font-mono text-[10px]">({{ $slide->button_url }})</span>
                                    </div>
                                @endif
                                @if($slide->secondary_button_text)
                                    <div class="flex items-center gap-1.5 text-slate-700">
                                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                        <span class="font-semibold">{{ $slide->secondary_button_text }}</span>
                                        <span class="text-slate-400 font-mono text-[10px]">({{ $slide->secondary_button_url }})</span>
                                    </div>
                                @endif
                                @if($slide->tertiary_button_text)
                                    <div class="flex items-center gap-1.5 text-slate-700">
                                        <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                        <span class="font-semibold">{{ $slide->tertiary_button_text }}</span>
                                    </div>
                                @endif
                                @if(!$slide->button_text && !$slide->secondary_button_text && !$slide->tertiary_button_text)
                                    <span class="text-slate-400">—</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <button type="button" onclick="toggleSlideStatus({{ $slide->id }}, this)" class="px-2.5 py-1 rounded-full text-[10px] font-bold cursor-pointer transition {{ $slide->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                {{ $slide->is_active ? 'Active' : 'Hidden' }}
                            </button>
                        </td>
                        <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                            <a href="{{ route('admin.hero-slides.edit', $slide->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block" title="Edit Slide">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.hero-slides.destroy', $slide->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this hero slide?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition" title="Delete Slide">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-images text-3xl text-slate-300 mb-2 block"></i>
                            <p class="text-sm font-semibold">No slides configured yet.</p>
                            <a href="{{ route('admin.hero-slides.create') }}" class="mt-3 inline-block text-brand-blue font-bold hover:underline text-xs">Create your first slide &rarr;</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
<script>
function toggleSlideStatus(slideId, btn) {
    fetch(`/admin/hero-slides/${slideId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (data.is_active) {
                btn.className = 'px-2.5 py-1 rounded-full text-[10px] font-bold cursor-pointer transition bg-emerald-100 text-emerald-700 hover:bg-emerald-200';
                btn.textContent = 'Active';
            } else {
                btn.className = 'px-2.5 py-1 rounded-full text-[10px] font-bold cursor-pointer transition bg-slate-100 text-slate-600 hover:bg-slate-200';
                btn.textContent = 'Hidden';
            }
        }
    })
    .catch(err => console.error(err));
}
</script>
@endpush
