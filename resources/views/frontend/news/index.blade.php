@extends('layouts.app')

@section('title', 'News & Chemical Formulation Insights | Adonis Chemical Limited')
@section('meta_description', 'Read latest corporate news, scientific insights, and product development updates from Adonis Chemical Limited.')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">Corporate & Scientific Journal</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">News & Formulation Insights</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Breakthroughs in cosmetic chemistry, Savar manufacturing facility updates, and SINODA product releases.
                </p>
            </div>
        </div>
    </section>

    <!-- News List Section -->
    <section class="py-16 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Main Articles Feed -->
                <div class="lg:col-span-8 space-y-8">
                    @if($blogs->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($blogs as $blog)
                                <article class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden flex flex-col justify-between shadow-sm hover:shadow-xl transition duration-300 group card-hover-effect">
                                    <div>
                                        <div class="relative h-52 overflow-hidden bg-slate-100">
                                            <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                            <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-navy/85 backdrop-blur-md text-[10px] font-bold text-white">
                                                {{ $blog->category->name ?? 'Article' }}
                                            </span>
                                        </div>

                                        <div class="p-6">
                                            <div class="text-[11px] text-slate-400 font-semibold mb-2">
                                                <i class="fa-regular fa-calendar-days text-brand-scientific mr-1"></i>
                                                {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Recent' }}
                                            </div>

                                            <h2 class="font-heading font-bold text-base text-navy group-hover:text-brand-blue transition line-clamp-2 leading-snug">
                                                <a href="{{ route('news.show', $blog->slug) }}">{{ $blog->title }}</a>
                                            </h2>

                                            <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                                {{ $blog->excerpt }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="px-6 pb-6 pt-2">
                                        <a href="{{ route('news.show', $blog->slug) }}" class="text-xs font-bold text-brand-blue hover:text-navy flex items-center gap-1.5 transition">
                                            <span>Read Article</span>
                                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $blogs->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
                            <p class="text-sm text-slate-500">No blog articles match your search.</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-8">
                    
                    <!-- Search Widget -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                        <h4 class="font-heading font-bold text-sm text-navy mb-3">Search News</h4>
                        <form action="{{ route('news.index') }}" method="GET" class="relative">
                            <input type="text" name="q" value="{{ $search }}" placeholder="Search topics..." class="w-full text-xs py-3 pl-9 pr-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        </form>
                    </div>

                    <!-- Category List -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                        <h4 class="font-heading font-bold text-sm text-navy mb-4 border-l-2 border-brand-blue pl-2.5">Categories</h4>
                        <ul class="space-y-2 text-xs">
                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ route('news.category', $cat->slug) }}" class="flex items-center justify-between py-1.5 px-2.5 rounded-xl hover:bg-slate-50 text-slate-700 hover:text-brand-blue font-medium transition">
                                        <span>{{ $cat->name }}</span>
                                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 font-bold">{{ $cat->blogs_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Recent Articles Widget -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                        <h4 class="font-heading font-bold text-sm text-navy mb-4 border-l-2 border-brand-cyan pl-2.5">Recent Highlights</h4>
                        <div class="space-y-4">
                            @foreach($recentBlogs as $rb)
                                <div class="flex items-center gap-3 group">
                                    <img src="{{ $rb->featured_image_url }}" alt="{{ $rb->title }}" class="w-14 h-14 rounded-xl object-cover flex-shrink-0">
                                    <div class="min-w-0">
                                        <h5 class="font-heading font-bold text-xs text-navy group-hover:text-brand-blue line-clamp-2 transition leading-tight">
                                            <a href="{{ route('news.show', $rb->slug) }}">{{ $rb->title }}</a>
                                        </h5>
                                        <p class="text-[10px] text-slate-400 mt-1">{{ $rb->published_at ? $rb->published_at->format('M d, Y') : '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection
