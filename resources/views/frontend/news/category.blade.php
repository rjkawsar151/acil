@extends('layouts.app')

@section('title', "{$category->name} | News | Adonis Chemical Limited")

@section('content')

    <section class="bg-navy-dark text-white py-16 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                <a href="{{ route('home') }}" class="hover:text-brand-cyan">Home</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <a href="{{ route('news.index') }}" class="hover:text-brand-cyan">News</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-white font-bold">{{ $category->name }}</span>
            </nav>
            <h1 class="font-heading font-black text-3xl sm:text-5xl text-white">{{ $category->name }}</h1>
            <p class="text-sm text-slate-300 mt-2">{{ $category->description }}</p>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($blogs as $blog)
                    <article class="bg-white rounded-3xl border border-slate-200 overflow-hidden flex flex-col justify-between shadow-sm hover:shadow-xl transition duration-300 group card-hover-effect">
                        <div>
                            <div class="relative h-48 overflow-hidden bg-slate-100">
                                <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="p-6">
                                <span class="text-[11px] text-slate-400 font-semibold block mb-2">{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '' }}</span>
                                <h3 class="font-heading font-bold text-base text-navy group-hover:text-brand-blue transition line-clamp-2">
                                    <a href="{{ route('news.show', $blog->slug) }}">{{ $blog->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-500 mt-2 line-clamp-2">{{ $blog->excerpt }}</p>
                            </div>
                        </div>
                        <div class="px-6 pb-6">
                            <a href="{{ route('news.show', $blog->slug) }}" class="text-xs font-bold text-brand-blue flex items-center gap-1">Read Article <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $blogs->links() }}
            </div>
        </div>
    </section>

@endsection
