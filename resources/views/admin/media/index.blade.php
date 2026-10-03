@extends('layouts.admin')

@section('page_title', 'Media & Asset Library')
@section('page_subtitle', 'Upload and organize product photography, chemical certificates, brochures, and lab imagery')

@section('content')

    <!-- Upload Zone -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm mb-8" x-data="{ uploading: false }">
        <h3 class="font-bold text-navy text-sm mb-3 flex items-center gap-2">
            <i class="fa-solid fa-cloud-arrow-up text-brand-blue"></i>
            <span>Upload New Media Files</span>
        </h3>

        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-1">
                    <label class="block font-bold text-navy text-xs mb-1.5">Asset Category</label>
                    <select name="category" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none bg-slate-50/50">
                        <option value="general">General Asset</option>
                        <option value="products">Product Imagery</option>
                        <option value="lab">Lab & QC Equipment</option>
                        <option value="plant">Factory & Manufacturing</option>
                        <option value="documents">TDS / Safety Sheets / PDF</option>
                        <option value="banners">Hero & Section Banners</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block font-bold text-navy text-xs mb-1.5">Select Files (JPG, PNG, WEBP, GIF, SVG, PDF &bull; Max 10MB per file)</label>
                    <div class="flex items-center gap-3">
                        <input type="file" name="files[]" multiple required class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-blue file:text-white hover:file:bg-navy cursor-pointer">
                        <button type="submit" class="btn-scientific-primary text-xs !py-2.5 !px-6 whitespace-nowrap">
                            <i class="fa-solid fa-upload"></i>
                            <span>Upload Files</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Filter & Search Controls -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
            <a href="{{ route('admin.media.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ !$category ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                All Files
            </a>
            @foreach($categories as $cat)
                @if($cat)
                    <a href="{{ route('admin.media.index', ['category' => $cat]) }}" class="px-4 py-2 rounded-xl text-xs font-bold capitalize transition whitespace-nowrap {{ $category === $cat ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                        {{ $cat }}
                    </a>
                @endif
            @endforeach
        </div>

        <form action="{{ route('admin.media.index') }}" method="GET" class="w-full md:w-auto">
            @if($category)
                <input type="hidden" name="category" value="{{ $category }}">
            @endif
            <div class="relative w-full md:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search files by name..." class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none w-full">
            </div>
        </form>
    </div>

    <!-- Media Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($media as $item)
            <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm group hover:shadow-md transition flex flex-col justify-between" x-data="{ copied: false }">
                
                <!-- Preview -->
                <div class="relative h-36 bg-slate-100 flex items-center justify-center overflow-hidden border-b border-slate-100">
                    @if(Str::startsWith($item->file_type, 'image/'))
                        <img src="{{ $item->url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @elseif($item->file_type === 'application/pdf')
                        <div class="text-center p-4">
                            <i class="fa-solid fa-file-pdf text-4xl text-rose-500"></i>
                            <span class="block text-[10px] font-bold text-slate-500 mt-1 uppercase">PDF Doc</span>
                        </div>
                    @else
                        <div class="text-center p-4">
                            <i class="fa-solid fa-file-lines text-4xl text-brand-blue"></i>
                            <span class="block text-[10px] font-bold text-slate-500 mt-1 uppercase">Document</span>
                        </div>
                    @endif

                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-navy/80 backdrop-blur-sm text-white text-[9px] font-bold uppercase">
                        {{ $item->category }}
                    </span>
                </div>

                <!-- Info & Actions -->
                <div class="p-3">
                    <p class="font-bold text-navy text-xs truncate" title="{{ $item->file_name }}">{{ $item->name }}</p>
                    <div class="flex items-center justify-between text-[10px] text-slate-400 mt-1">
                        <span>{{ number_format($item->file_size / 1024, 1) }} KB</span>
                        <span class="uppercase">{{ pathinfo($item->file_name, PATHINFO_EXTENSION) }}</span>
                    </div>

                    <div class="flex items-center gap-1.5 mt-3 pt-2 border-t border-slate-100">
                        <button type="button" @click="navigator.clipboard.writeText('{{ $item->url }}'); copied = true; setTimeout(() => copied = false, 2000)" class="flex-1 py-1 px-2 rounded-lg bg-slate-100 hover:bg-brand-blue hover:text-white transition font-bold text-[10px] text-slate-600 flex items-center justify-center gap-1">
                            <i :class="copied ? 'fa-solid fa-check text-emerald-500' : 'fa-solid fa-copy'"></i>
                            <span x-text="copied ? 'Copied!' : 'Copy URL'"></span>
                        </button>
                        
                        <a href="{{ $item->url }}" target="_blank" class="p-1 px-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-[10px]">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>

                        <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Delete file?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 px-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 text-[10px]">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-3xl border border-slate-200/80">
                <i class="fa-solid fa-photo-film text-4xl mb-2 text-slate-300 block"></i>
                No media assets found in this category.
            </div>
        @endforelse
    </div>

    @if($media->hasPages())
        <div class="mt-8 bg-white p-4 rounded-2xl border border-slate-200/80">
            {{ $media->links() }}
        </div>
    @endif

@endsection
