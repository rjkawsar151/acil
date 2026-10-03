@extends('layouts.app')

@section('title', $blog->meta_title ?: "{$blog->title} | Adonis Chemical Limited")
@section('meta_description', $blog->meta_description ?: $blog->excerpt)

@section('content')

    <!-- Breadcrumbs -->
    <section class="bg-slate-100 py-6 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-brand-blue">Home</a>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <a href="{{ route('news.index') }}" class="hover:text-brand-blue">News</a>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <span class="text-navy font-bold truncate max-w-xs">{{ $blog->title }}</span>
            </nav>
        </div>
    </section>

    <!-- Article Header & Body -->
    <article class="py-12 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="space-y-4">
                <div class="flex items-center gap-3 text-xs">
                    @if($blog->category)
                        <span class="badge-scientific">{{ $blog->category->name }}</span>
                    @endif
                    <span class="text-slate-400">•</span>
                    <span class="text-slate-500 font-medium">
                        <i class="fa-regular fa-calendar-days text-brand-scientific mr-1"></i>
                        {{ $blog->published_at ? $blog->published_at->format('F d, Y') : 'Recent' }}
                    </span>
                    <span class="text-slate-400">•</span>
                    <span class="text-slate-500 font-medium">
                        <i class="fa-solid fa-user-pen text-brand-cyan mr-1"></i>
                        {{ $blog->author }}
                    </span>
                </div>

                <h1 class="font-heading font-black text-3xl sm:text-4xl lg:text-5xl text-navy leading-tight">
                    {{ $blog->title }}
                </h1>

                @if($blog->excerpt)
                    <p class="text-base sm:text-lg text-slate-600 font-medium leading-relaxed border-l-4 border-brand-cyan pl-4 py-1">
                        {{ $blog->excerpt }}
                    </p>
                @endif
            </div>

            <!-- Featured Image -->
            <div class="rounded-3xl overflow-hidden shadow-xl border border-slate-200">
                <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-80 sm:h-96 object-cover">
            </div>

            <!-- Article Body Content -->
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4 text-sm sm:text-base pt-4">
                {!! $blog->content !!}
            </div>

            <!-- Share & Author Box -->
            <div class="pt-8 mt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-navy uppercase tracking-wider">Share Article:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-brand-blue hover:text-white text-slate-600 flex items-center justify-center text-xs transition">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-brand-scientific hover:text-white text-slate-600 flex items-center justify-center text-xs transition">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-600 flex items-center justify-center text-xs transition">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                </div>

                <a href="{{ route('news.index') }}" class="btn-scientific-outline-dark text-xs !py-2.5 !px-5">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to News</span>
                </a>
            </div>

        </div>
    </article>

    <!-- Related Articles -->
    @if($relatedBlogs->count() > 0)
        <section class="py-16 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="font-heading font-bold text-2xl text-navy mb-8">Related Chemical Insights</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedBlogs as $rel)
                        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                            <h4 class="font-heading font-bold text-sm text-navy mb-2 line-clamp-2">
                                <a href="{{ route('news.show', $rel->slug) }}" class="hover:text-brand-blue">{{ $rel->title }}</a>
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-2">{{ $rel->excerpt }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
