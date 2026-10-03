@extends('layouts.app')

@section('title', 'SINODA Brand | Professional Care Developed with Purpose | Adonis Chemical Limited')
@section('meta_description', 'Discover the full SINODA brand portfolio by Adonis Chemical Limited. Salon professional haircare, skincare, depilatory waxes, and personal grooming.')

@section('content')

    <!-- SINODA Hero Showcase -->
    <section class="bg-navy-dark text-white py-24 relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute -top-20 -right-20 w-[30rem] h-[30rem] bg-brand-cyan/20 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-[30rem] h-[30rem] bg-brand-blue/30 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-6">
            <span class="badge-scientific-dark">Signature Brand of Adonis Chemical Limited</span>
            <h1 class="font-heading font-black text-5xl sm:text-6xl lg:text-7xl text-white tracking-tight">
                SINODA
            </h1>
            <p class="text-brand-cyan font-bold text-xl sm:text-2xl max-w-2xl mx-auto">
                Professional Care. Developed with Purpose.
            </p>
            <p class="text-sm sm:text-base text-slate-300 max-w-3xl mx-auto leading-relaxed">
                SINODA represents our dedication to dermatological safety, high cosmetic active concentrations, and salon-grade performance. Every formulation is engineered and manufactured at our Savar plant in Dhaka, Bangladesh.
            </p>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <a href="#sinoda-products" class="btn-scientific-primary !py-3.5 !px-8 text-sm">
                    <i class="fa-solid fa-sparkles"></i>
                    <span>Explore Formulations</span>
                </a>
                <button onclick="openInquiryModal('', 'SINODA Brand Commercial Dealership')" class="btn-scientific-outline text-sm !py-3.5 !px-8">
                    <i class="fa-solid fa-handshake"></i>
                    <span>Salon & Dealership Inquiry</span>
                </button>
            </div>
        </div>
    </section>

    <!-- SINODA Brand Pillars -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center sm:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-brand-light text-brand-blue flex items-center justify-center text-xl mb-4 mx-auto sm:mx-0">
                        <i class="fa-solid fa-droplet"></i>
                    </div>
                    <h3 class="font-heading font-bold text-base text-navy mb-1">Isodermic pH Balanced</h3>
                    <p class="text-xs text-slate-500">Formulated between pH 5.2 and 5.8 to match the natural cutaneous acid mantle.</p>
                </div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center sm:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-brand-light text-brand-cyan flex items-center justify-center text-xl mb-4 mx-auto sm:mx-0">
                        <i class="fa-solid fa-dna"></i>
                    </div>
                    <h3 class="font-heading font-bold text-base text-navy mb-1">Micro-Keratin Peptides</h3>
                    <p class="text-xs text-slate-500">Hydrolyzed proteins for deep cortex penetration and cuticle restoration.</p>
                </div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center sm:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-brand-light text-emerald-600 flex items-center justify-center text-xl mb-4 mx-auto sm:mx-0">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h3 class="font-heading font-bold text-base text-navy mb-1">Pure Botanical Hydrosols</h3>
                    <p class="text-xs text-slate-500">Steam-distilled rose water and 99% concentrated organic Aloe Vera extracts.</p>
                </div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center sm:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-brand-light text-purple-600 flex items-center justify-center text-xl mb-4 mx-auto sm:mx-0">
                        <i class="fa-solid fa-scissors"></i>
                    </div>
                    <h3 class="font-heading font-bold text-base text-navy mb-1">Salon High Elasticity</h3>
                    <p class="text-xs text-slate-500">Low-temperature melting depilatory waxes and 24-hour ultra-matte styling waxes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- All SINODA Products Portfolio -->
    <section id="sinoda-products" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="badge-scientific mb-2">Portfolio Directory</span>
                    <h2 class="font-heading font-black text-3xl sm:text-4xl text-navy">All SINODA Formulations</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Direct from Adonis Chemical Limited manufacturing plant.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($sinodaProducts as $product)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl p-5 flex flex-col justify-between transition duration-300 group card-hover-effect">
                        <div>
                            <div class="relative h-52 rounded-2xl overflow-hidden bg-slate-100 mb-4">
                                <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-navy/90 text-white text-[10px] font-bold uppercase tracking-wider">
                                    {{ $product->category->name ?? 'SINODA' }}
                                </span>
                            </div>

                            <h3 class="font-heading font-bold text-sm sm:text-base text-navy group-hover:text-brand-blue transition line-clamp-2">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>

                            <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                {{ $product->short_description }}
                            </p>

                            @if($product->available_sizes)
                                <p class="text-[11px] text-slate-600 font-medium mt-3">
                                    <i class="fa-solid fa-box text-brand-scientific mr-1"></i> {{ $product->available_sizes }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-bold text-brand-blue hover:text-navy transition">
                                View Specs
                            </a>
                            <button onclick="openInquiryModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="px-3 py-1.5 rounded-full bg-brand-light text-brand-blue text-[11px] font-bold hover:bg-brand-blue hover:text-white transition">
                                Inquire
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

@endsection
