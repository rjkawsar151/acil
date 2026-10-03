@extends('layouts.app')

@section('title', 'Industries & Applications | Adonis Chemical Limited | SINODA')
@section('meta_description', 'Explore the diverse industry applications of Adonis Chemical Limited formulations across salons, spas, clinics, and commercial institutions.')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">Market Domains</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">Industries & Applications</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Custom-tailored chemical formulations and bulk product supply for salon professionals, beauty clinics, retail brands, and commercial institutions.
                </p>
            </div>
        </div>
    </section>

    <!-- Applications Grid -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($applications as $app)
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between card-hover-effect">
                        <div>
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-brand-light text-brand-blue flex items-center justify-center text-2xl shadow-sm">
                                    <i class="fa-solid fa-{{ $app->icon ?: 'sparkles' }}"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-brand-scientific">{{ $app->subtitle }}</span>
                                    <h3 class="font-heading font-bold text-xl text-navy">{{ $app->title }}</h3>
                                </div>
                            </div>

                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">{{ $app->description }}</p>

                            @if(!empty($app->features) && is_array($app->features))
                                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-150 mb-6">
                                    <span class="text-xs font-bold text-navy block mb-2">Key Application Advantages:</span>
                                    <ul class="space-y-1.5 text-xs text-slate-700">
                                        @foreach($app->features as $feat)
                                            <li class="flex items-center gap-2">
                                                <i class="fa-solid fa-check text-emerald-500 text-[10px]"></i>
                                                <span>{{ $feat }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <button onclick="openInquiryModal('', '{{ addslashes($app->title) }} Supply Inquiry')" class="btn-scientific-primary text-xs !py-2.5 !px-5">
                                <i class="fa-solid fa-envelope"></i>
                                <span>Request Commercial Supply</span>
                            </button>
                            <a href="{{ route('products.index') }}" class="text-xs font-bold text-slate-500 hover:text-brand-blue">
                                Browse Catalog
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
