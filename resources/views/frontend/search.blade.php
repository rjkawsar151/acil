@extends('layouts.app')

@section('title', "Search Results for '{$query}' | Adonis Chemical Limited")

@section('content')

    <section class="bg-navy-dark text-white py-16 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <span class="badge-scientific-dark mb-2">Universal Search</span>
            <h1 class="font-heading font-black text-3xl sm:text-4xl text-white">
                Results for "<span class="text-brand-cyan">{{ $query }}</span>"
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-2">Found {{ $totalResults }} matching results across products, news, and pages.</p>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Products Search Results -->
            @if($products->count() > 0)
                <div>
                    <h3 class="font-heading font-bold text-xl text-navy mb-6 border-l-4 border-brand-blue pl-3">
                        Products & Formulations ({{ $products->count() }})
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($products as $prod)
                            <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between">
                                <div>
                                    <img src="{{ $prod->featured_image_url }}" alt="{{ $prod->name }}" class="w-full h-44 rounded-2xl object-cover mb-3">
                                    <h4 class="font-heading font-bold text-sm text-navy line-clamp-2">
                                        <a href="{{ route('products.show', $prod->slug) }}">{{ $prod->name }}</a>
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $prod->short_description }}</p>
                                </div>
                                <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                    <a href="{{ route('products.show', $prod->slug) }}" class="text-xs font-bold text-brand-blue">View Product</a>
                                    <button onclick="openInquiryModal({{ $prod->id }}, '{{ addslashes($prod->name) }}')" class="text-xs font-bold text-slate-500 hover:text-navy">Inquire</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- News Search Results -->
            @if($blogs->count() > 0)
                <div>
                    <h3 class="font-heading font-bold text-xl text-navy mb-6 border-l-4 border-brand-scientific pl-3">
                        News & Articles ({{ $blogs->count() }})
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        @foreach($blogs as $blog)
                            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                                <h4 class="font-heading font-bold text-sm text-navy mb-2 line-clamp-2">
                                    <a href="{{ route('news.show', $blog->slug) }}">{{ $blog->title }}</a>
                                </h4>
                                <p class="text-xs text-slate-500 line-clamp-2">{{ $blog->excerpt }}</p>
                                <a href="{{ route('news.show', $blog->slug) }}" class="text-xs font-bold text-brand-blue mt-4 inline-block">Read Article →</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Dynamic Pages -->
            @if($pages->count() > 0)
                <div>
                    <h3 class="font-heading font-bold text-xl text-navy mb-6 border-l-4 border-brand-cyan pl-3">
                        Pages & Information ({{ $pages->count() }})
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($pages as $pg)
                            <a href="{{ route('pages.show', $pg->slug) }}" class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-brand-blue transition block">
                                <h4 class="font-bold text-sm text-navy mb-1">{{ $pg->title }}</h4>
                                <p class="text-xs text-slate-500">{{ $pg->excerpt ?: 'View page details...' }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($totalResults == 0)
                <div class="bg-white rounded-3xl p-12 text-center max-w-md mx-auto border border-slate-200">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg text-navy">No Matches Found</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-6">No records matched "{{ $query }}". Try searching for keywords like "shampoo", "wax", "keratin", or "Savar".</p>
                    <a href="{{ route('products.index') }}" class="btn-scientific-primary text-xs !py-2.5 !px-6">Browse Products</a>
                </div>
            @endif

        </div>
    </section>

@endsection
