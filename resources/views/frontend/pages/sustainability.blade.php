@extends('layouts.app')

@section('title', 'Sustainability Commitment | Adonis Chemical Limited')
@section('meta_description', 'Discover how Adonis Chemical Limited practices responsible manufacturing, clean water usage, and recyclable packaging in Savar, Bangladesh.')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">Environmental Stewardship</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">Responsible Growth</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Building a cleaner manufacturing future through closed-loop water demineralization, recyclable packaging polymers, and verified effluent safety.
                </p>
            </div>
        </div>
    </section>

    <!-- Sustainability Initiatives -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-600 flex items-center justify-center text-xl mb-5">
                        <i class="fa-solid fa-water"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg text-navy mb-2">Closed-Loop Water Management</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Multi-stage reverse osmosis (RO) and cooling loops prevent water wastage during high-volume batch formulation.</p>
                </div>

                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl mb-5">
                        <i class="fa-solid fa-recycle"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg text-navy mb-2">100% Recyclable Polymers</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Transitioning our bottles and jars to high-grade HDPE and PET that integrate smoothly into domestic recycling systems.</p>
                </div>

                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-brand-blue flex items-center justify-center text-xl mb-5">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg text-navy mb-2">Biodegradable Surfactants</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Prioritizing naturally derived coconut and glucose-based cleansers with high environmental degradation rates.</p>
                </div>

            </div>
        </div>
    </section>

@endsection
