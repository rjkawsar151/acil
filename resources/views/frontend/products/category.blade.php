@extends('layouts.app')

@section('title', "{$category->name} | SINODA by Adonis Chemical Limited")
@section('meta_description', $category->description)

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <nav class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                    <a href="{{ route('home') }}" class="hover:text-brand-cyan">Home</a>
                    <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    <a href="{{ route('products.index') }}" class="hover:text-brand-cyan">Products</a>
                    <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    <span class="text-white font-bold">{{ $category->name }}</span>
                </nav>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">{{ $category->name }}</h1>
                <p class="text-sm sm:text-base text-slate-300 mt-3 leading-relaxed">
                    {{ $category->description }}
                </p>
            </div>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-8">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                    Showing <strong>{{ $products->total() }}</strong> Formulations in {{ $category->name }}
                </p>
                <a href="{{ route('products.index') }}" class="text-xs font-bold text-brand-blue hover:underline">
                    View All Categories
                </a>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl p-5 flex flex-col justify-between transition duration-300 group card-hover-effect">
                            <div>
                                <div class="relative h-56 rounded-2xl overflow-hidden bg-slate-100 mb-4">
                                    <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @if($product->sku)
                                        <span class="absolute bottom-3 left-3 px-2 py-0.5 rounded bg-white/90 backdrop-blur-sm text-[9px] font-mono font-bold text-slate-700">
                                            {{ $product->sku }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="font-heading font-bold text-base text-navy group-hover:text-brand-blue transition line-clamp-2 leading-snug">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>

                                <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                    {{ $product->short_description }}
                                </p>
                            </div>

                            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-bold text-brand-blue hover:text-navy transition">
                                    Details & Specs
                                </a>
                                <button onclick="openInquiryModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="px-3 py-1.5 rounded-full bg-brand-light text-brand-blue text-[11px] font-bold">
                                    Inquire
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-3xl p-12 text-center max-w-md mx-auto border border-slate-200">
                    <p class="text-sm text-slate-500">No active products found in this category currently.</p>
                </div>
            @endif

        </div>
    </section>

@endsection
