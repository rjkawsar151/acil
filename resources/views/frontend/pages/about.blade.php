@extends('layouts.app')

@section('title', 'About Adonis Chemical Limited | Concern of Adonis Group | Savar, Dhaka')
@section('meta_description', 'Learn about Adonis Chemical Limited, our modern chemical manufacturing plant in Genda, Savar, our SINODA brand, and our relationship with Adonis Group.')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">Corporate Profile</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">About Adonis Chemical Limited</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    A premier chemical, cosmetic formulation, and personal care manufacturing enterprise under Adonis Group, based in Genda, Savar, Dhaka, Bangladesh.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-6 space-y-6">
                    <span class="badge-scientific">Our Foundation & Vision</span>
                    <h2 class="font-heading font-black text-3xl sm:text-4xl text-navy">
                        Where Science Meets Everyday Care
                    </h2>

                    <div class="prose prose-slate max-w-none text-sm leading-relaxed space-y-4 text-slate-600">
                        {!! $page->content ?? '<p>Adonis Chemical Limited is a growing chemical and personal care product company committed to combining scientific formulation, controlled manufacturing and consistent product quality. Through our SINODA brand, we develop products designed for professional salon, grooming, beauty and everyday personal care applications.</p>' !!}
                    </div>

                    <div class="pt-4 flex flex-wrap gap-4">
                        <a href="{{ route('manufacturing') }}" class="btn-scientific-primary text-xs !py-3 !px-6">
                            <i class="fa-solid fa-industry"></i>
                            <span>Savar Manufacturing Plant</span>
                        </a>
                        <a href="{{ route('sinoda') }}" class="btn-scientific-outline-dark text-xs !py-3 !px-6">
                            <i class="fa-solid fa-sparkles"></i>
                            <span>Discover SINODA Brand</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80" alt="Plant Operations" class="rounded-3xl object-cover h-64 sm:h-80 w-full shadow-lg">
                        <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=800&q=80" alt="Laboratory Formulation" class="rounded-3xl object-cover h-64 sm:h-80 w-full shadow-lg mt-8">
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Company Stats Counter -->
    <section class="py-16 bg-slate-50 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($stats as $st)
                    <div class="text-center sm:text-left">
                        <div class="font-heading font-black text-3xl sm:text-4xl text-navy">
                            <span>{{ $st->prefix }}</span>
                            <span class="counter-value" data-target="{{ (int)preg_replace('/[^0-9]/', '', $st->value) }}">{{ $st->value }}</span>
                            <span class="text-brand-scientific">{{ $st->suffix }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-700 uppercase tracking-wider mt-1">{{ $st->title }}</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $st->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Adonis Group Connection -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-navy-dark text-white p-8 lg:p-14 shadow-2xl relative overflow-hidden">
                <div class="max-w-3xl space-y-4 relative z-10">
                    <span class="badge-scientific-dark">Group Synergy</span>
                    <h3 class="font-heading font-black text-3xl sm:text-4xl text-white">An Integral Concern of Adonis Group</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Operating under Adonis Group enables Adonis Chemical Limited to leverage institutional supply chains, nationwide freight logistics, advanced capital investment, and world-class management rigor to supply thousands of clients across Bangladesh.
                    </p>
                    <div class="pt-4">
                        <a href="{{ route('adonis-group') }}" class="btn-scientific-primary text-xs !py-3 !px-6">
                            <span>Learn More About Adonis Group</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
