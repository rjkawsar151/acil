@extends('layouts.app')

@section('title', 'Adonis Group | Parent Conglomerate of Adonis Chemical Limited')
@section('meta_description', 'Discover Adonis Group, a prominent business group in Bangladesh and the parent organization of Adonis Chemical Limited.')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">Parent Enterprise</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">Adonis Group</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    A dynamic multi-sector conglomerate in Bangladesh dedicated to industrial excellence, reliable consumer goods, and national economic progress.
                </p>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-7 space-y-6">
                    <span class="badge-scientific">Corporate Foundation</span>
                    <h2 class="font-heading font-black text-3xl text-navy">Powering Growth Across Industries</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Adonis Group has established itself as a respected industrial name in Bangladesh. Through continuous investment in modern manufacturing infrastructure, supply chain logistics, and customer-first management, the group creates long-term value across all business sectors.
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        As the chemical and personal care arm of the conglomerate, <strong>Adonis Chemical Limited</strong> benefits from the group’s national distribution network, strategic procurement channels, and seasoned executive governance.
                    </p>

                    <div class="pt-4 flex items-center gap-4">
                        <a href="{{ route('about') }}" class="btn-scientific-primary text-xs !py-3 !px-6">
                            <span>About Adonis Chemical</span>
                        </a>
                        <a href="{{ route('contact') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">
                            <span>Corporate Contact</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-8 shadow-md space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-brand-blue text-white flex items-center justify-center text-xl">
                            <i class="fa-solid fa-sitemap"></i>
                        </div>
                        <h3 class="font-heading font-bold text-xl text-navy">Adonis Group Ecosystem</h3>
                        <ul class="space-y-3 text-xs text-slate-600">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-brand-scientific"></i> Chemical & Personal Care (Adonis Chemical / SINODA)</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-brand-scientific"></i> Consumer Goods & Distribution</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-brand-scientific"></i> Industrial Supply Chains</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-brand-scientific"></i> Nationwide Logistics Fleet</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
