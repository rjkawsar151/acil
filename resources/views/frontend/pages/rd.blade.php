@extends('layouts.app')

@section('title', 'Research & Development (R&D) | Adonis Chemical Limited')
@section('meta_description', 'Learn how our scientific team develops cutting-edge chemical and personal care formulations at Adonis Chemical Limited.')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">Innovation Division</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">Innovation Through Research</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Advancing cosmetic chemistry through biomimetic peptide synthesis, green surfactant engineering, and tropical climate stability.
                </p>
            </div>
        </div>
    </section>

    <!-- R&D Pillars -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-6 space-y-6">
                    <span class="badge-scientific">Formulation Science</span>
                    <h2 class="font-heading font-black text-3xl sm:text-4xl text-navy">Translating Molecular Science into Superior Care</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        At Adonis Chemical Limited, our laboratory researchers continually screen active ingredients, evaluate polymer interactions, and optimize emulsion micelle structures.
                    </p>
                    
                    <div class="space-y-4 text-xs sm:text-sm text-slate-700">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <strong class="text-navy block mb-1">1. Hydrolyzed Biomimetic Keratin:</strong>
                            Cleaving protein chains to low molecular mass (<2,000 Da) so active peptides penetrate directly into the cortex of damaged hair fibers.
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <strong class="text-navy block mb-1">2. Cold Hydro-Steam Extraction:</strong>
                            Distilling pure Damask rose petals and Aloe Barbadensis leaf extracts at low temperatures to prevent heat degradation of natural polyphenols.
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <strong class="text-navy block mb-1">3. Humidity Rheology Optimization:</strong>
                            Synthesizing hair waxes and depilatories with specific polymer crosslinks that resist melting or degradation in 90%+ tropical humidity.
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1000&q=80" alt="R&D Lab" class="rounded-3xl object-cover shadow-2xl w-full h-96">
                </div>
            </div>
        </div>
    </section>

@endsection
