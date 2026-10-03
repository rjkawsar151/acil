@extends('layouts.app')

@section('title', 'Quality Assurance & Laboratory Controls | Adonis Chemical Limited')
@section('meta_description', 'Discover our stringent laboratory testing, microbiological screening, and stability chambers at Adonis Chemical Limited.')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">Quality Control Division</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">Quality at Every Stage</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Our multi-parameter testing protocols guarantee that every batch meets rigorous purity, viscosity, stability, and consumer safety standards.
                </p>
            </div>
        </div>
    </section>

    <!-- Quality Standards Grid -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($steps as $step)
                    <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between card-hover-effect">
                        
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <span class="w-12 h-12 rounded-2xl bg-brand-light text-brand-blue font-heading font-black text-lg flex items-center justify-center">
                                    0{{ $step->step_number }}
                                </span>
                                <span class="badge-scientific text-[10px]">Assurance Level</span>
                            </div>

                            <h3 class="font-heading font-bold text-xl text-navy mb-2">{{ $step->title }}</h3>
                            <p class="text-xs text-slate-400 font-semibold mb-3">{{ $step->subtitle }}</p>
                            <p class="text-xs text-slate-600 leading-relaxed mb-6">{{ $step->description }}</p>
                        </div>

                        @if(!empty($step->standards) && is_array($step->standards))
                            <div class="pt-4 border-t border-slate-100">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Standards Applied:</span>
                                <ul class="space-y-1 text-xs text-slate-700">
                                    @foreach($step->standards as $std)
                                        <li class="flex items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i>
                                            <span>{{ $std }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

            <!-- Laboratory Guarantee Statement -->
            <div class="mt-16 bg-navy-dark text-white rounded-3xl p-8 lg:p-12 border border-slate-700 shadow-2xl">
                <div class="max-w-3xl space-y-4">
                    <span class="badge-scientific-dark">Savar Lab Commitment</span>
                    <h3 class="font-heading font-bold text-2xl text-white">Zero Tolerance for Contamination or Instability</h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        We mandate a 48-hour incubation quarantine for every batch of SINODA personal care formulation before release. Products failing any of our physicochemical or microbiological specifications are discarded without compromise.
                    </p>
                </div>
            </div>

        </div>
    </section>

@endsection
