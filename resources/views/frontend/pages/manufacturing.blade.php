@extends('layouts.app')

@section('title', 'Manufacturing Facility & Process | Adonis Chemical Limited | Savar')
@section('meta_description', 'Discover our 7-step chemical and personal care manufacturing process in Genda, Savar, Dhaka. High-shear batching, cleanroom filling, and strict QC.')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">Genda, Savar Plant</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">Manufacturing with Precision</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Our manufacturing facility in Genda, Savar combines high-capacity closed batch reactors, automated volumetric filling, and strict environmental cleanrooms.
                </p>
            </div>
        </div>
    </section>

    <!-- Manufacturing Interactive Process Flow -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="badge-scientific mb-2">7-Step Precision System</span>
                <h2 class="font-heading font-black text-3xl text-navy">End-to-End Production Process</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">Every batch is tracked through an unbroken chain of custody and chemical verification.</p>
            </div>

            <!-- Steps Grid -->
            <div class="space-y-12">
                @foreach($steps as $index => $step)
                    <div class="bg-white rounded-3xl p-8 lg:p-10 border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <div class="lg:col-span-1 flex items-center justify-center">
                            <span class="w-16 h-16 rounded-3xl bg-brand-blue text-white font-heading font-black text-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                0{{ $step->step_number }}
                            </span>
                        </div>

                        <div class="lg:col-span-6 space-y-3">
                            <span class="text-xs font-bold uppercase tracking-widest text-brand-scientific">{{ $step->subtitle }}</span>
                            <h3 class="font-heading font-black text-2xl text-navy">{{ $step->title }}</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $step->description }}</p>

                            @if(!empty($step->details) && is_array($step->details))
                                <div class="pt-2 flex flex-wrap gap-2">
                                    @foreach($step->details as $item)
                                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-semibold flex items-center gap-1.5">
                                            <i class="fa-solid fa-check text-emerald-500 text-[9px]"></i>
                                            {{ $item }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="lg:col-span-5">
                            <img src="{{ $step->image_url }}" alt="{{ $step->title }}" class="w-full h-56 sm:h-64 rounded-2xl object-cover shadow-md">
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('contact') }}" class="btn-scientific-primary !py-3.5 !px-8 text-sm">
                    <i class="fa-solid fa-industry"></i>
                    <span>Inquire About Facility Tours & Bulk Orders</span>
                </a>
            </div>

        </div>
    </section>

@endsection
