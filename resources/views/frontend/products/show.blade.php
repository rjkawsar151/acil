@extends('layouts.app')

@section('title', $product->meta_title ?: "{$product->name} | SINODA by Adonis Chemical Limited")
@section('meta_description', $product->meta_description ?: $product->short_description)

@section('content')

    <!-- Breadcrumb & Header -->
    <section class="bg-slate-100 py-6 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-slate-500 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-brand-blue">Home</a>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                <a href="{{ route('products.index') }}" class="hover:text-brand-blue">Products</a>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-brand-blue">{{ $product->category->name }}</a>
                <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                <span class="text-navy font-bold truncate max-w-xs">{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    <!-- Product Detail Main View -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12" x-data="{ activeImage: '{{ $product->featured_image_url }}' }">
                
                <!-- Left Column: Gallery -->
                <div class="lg:col-span-5 space-y-4">
                    <!-- Main Large Image View -->
                    <div class="rounded-3xl border border-slate-200 overflow-hidden bg-slate-50 aspect-square shadow-sm flex items-center justify-center relative">
                        <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-cover transition-all duration-300">
                        
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-navy/90 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-widest">
                            {{ $product->brand ?? 'SINODA' }}
                        </span>

                        @if($product->sku)
                            <span class="absolute bottom-4 left-4 px-2.5 py-1 rounded-lg bg-white/90 backdrop-blur-sm text-xs font-mono font-bold text-navy shadow">
                                SKU: {{ $product->sku }}
                            </span>
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    @if($product->images->count() > 0)
                        <div class="grid grid-cols-4 gap-3">
                            <button @click="activeImage = '{{ $product->featured_image_url }}'" :class="activeImage === '{{ $product->featured_image_url }}' ? 'border-brand-blue ring-2 ring-brand-blue/30' : 'border-slate-200'" class="rounded-2xl border-2 overflow-hidden aspect-square bg-slate-50 transition">
                                <img src="{{ $product->featured_image_url }}" alt="Thumbnail" class="w-full h-full object-cover">
                            </button>
                            @foreach($product->images as $img)
                                <button @click="activeImage = '{{ $img->image_url }}'" :class="activeImage === '{{ $img->image_url }}' ? 'border-brand-blue ring-2 ring-brand-blue/30' : 'border-slate-200'" class="rounded-2xl border-2 overflow-hidden aspect-square bg-slate-50 transition">
                                    <img src="{{ $img->image_url }}" alt="Gallery thumbnail" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Chemical Quality Verification Box -->
                    <div class="p-5 rounded-3xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="flex items-center gap-2.5 text-xs font-bold text-navy">
                            <i class="fa-solid fa-flask-vial text-brand-scientific text-base"></i>
                            <span>Savar Laboratory Verification</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600">
                            <div class="bg-white p-2.5 rounded-xl border border-slate-150">
                                <span class="text-slate-400 block text-[10px]">pH Balance:</span>
                                <strong>{{ $product->ph_level ?: '5.5 ± 0.2' }}</strong>
                            </div>
                            <div class="bg-white p-2.5 rounded-xl border border-slate-150">
                                <span class="text-slate-400 block text-[10px]">Appearance:</span>
                                <strong class="truncate block">{{ $product->color_appearance ?: 'Standard Matrix' }}</strong>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Product Details & Inquiry -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <a href="{{ route('categories.show', $product->category->slug) }}" class="text-xs font-bold text-brand-blue hover:underline">
                                {{ $product->category->name }}
                            </a>
                            <span class="text-slate-300">•</span>
                            <span class="text-xs font-bold text-slate-500">Brand: {{ $product->brand ?? 'SINODA' }}</span>
                        </div>

                        <h1 class="font-heading font-black text-2xl sm:text-3xl lg:text-4xl text-navy leading-tight">
                            {{ $product->name }}
                        </h1>
                    </div>

                    <!-- Short Description -->
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        {{ $product->short_description }}
                    </p>

                    <!-- Sizes & Specs Grid -->
                    <div class="flex flex-wrap items-center gap-4 py-3 border-y border-slate-100">
                        @if($product->available_sizes)
                            <div class="flex items-center gap-2 text-xs">
                                <span class="font-bold text-navy">Available Sizes:</span>
                                <span class="px-3 py-1 rounded-full bg-brand-light text-brand-blue font-bold">{{ $product->available_sizes }}</span>
                            </div>
                        @endif

                        <div class="flex items-center gap-2 text-xs">
                            <span class="font-bold text-navy">Manufacturing Plant:</span>
                            <span class="text-slate-600">Genda, Savar, Dhaka</span>
                        </div>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <button onclick="openInquiryModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="btn-scientific-primary text-xs !py-3.5 !px-8 shadow-lg shadow-blue-600/30">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Request Product Quote & Specs</span>
                        </button>

                        @if($product->brochure)
                            <a href="{{ $product->brochure_url }}" download class="btn-scientific-outline-dark text-xs !py-3.5 !px-6">
                                <i class="fa-solid fa-file-pdf text-rose-500"></i>
                                <span>Download PDF Brochure</span>
                            </a>
                        @endif
                    </div>

                    <!-- Tabs for Full Specs, Benefits, Ingredients -->
                    <div class="pt-6" x-data="{ tab: 'description' }">
                        <div class="flex items-center gap-2 border-b border-slate-200">
                            <button @click="tab = 'description'" :class="tab === 'description' ? 'border-brand-blue text-brand-blue font-bold' : 'border-transparent text-slate-500'" class="pb-3 px-3 text-xs sm:text-sm border-b-2 transition">
                                Description
                            </button>
                            <button @click="tab = 'benefits'" :class="tab === 'benefits' ? 'border-brand-blue text-brand-blue font-bold' : 'border-transparent text-slate-500'" class="pb-3 px-3 text-xs sm:text-sm border-b-2 transition">
                                Key Benefits
                            </button>
                            <button @click="tab = 'usage'" :class="tab === 'usage' ? 'border-brand-blue text-brand-blue font-bold' : 'border-transparent text-slate-500'" class="pb-3 px-3 text-xs sm:text-sm border-b-2 transition">
                                Usage & Application
                            </button>
                            <button @click="tab = 'ingredients'" :class="tab === 'ingredients' ? 'border-brand-blue text-brand-blue font-bold' : 'border-transparent text-slate-500'" class="pb-3 px-3 text-xs sm:text-sm border-b-2 transition">
                                Formulation
                            </button>
                        </div>

                        <div class="py-6 text-sm text-slate-600 leading-relaxed">
                            
                            <!-- Description Tab -->
                            <div x-show="tab === 'description'" class="space-y-3">
                                <p>{{ $product->description ?: $product->short_description }}</p>
                                @if($product->packaging_information)
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 mt-4 text-xs">
                                        <strong class="text-navy block mb-1">Packaging Specification:</strong>
                                        {{ $product->packaging_information }}
                                    </div>
                                @endif
                            </div>

                            <!-- Benefits Tab -->
                            <div x-show="tab === 'benefits'" style="display: none;" class="space-y-2">
                                @if($product->benefits)
                                    <div class="whitespace-pre-line text-xs sm:text-sm bg-slate-50 p-5 rounded-2xl border border-slate-200 font-sans">
                                        {{ $product->benefits }}
                                    </div>
                                @else
                                    <p class="text-xs text-slate-400">Standard salon-grade performance benchmarks met.</p>
                                @endif
                            </div>

                            <!-- Usage Tab -->
                            <div x-show="tab === 'usage'" style="display: none;">
                                @if($product->usage_information)
                                    <p class="bg-slate-50 p-5 rounded-2xl border border-slate-200 text-xs sm:text-sm">
                                        {{ $product->usage_information }}
                                    </p>
                                @else
                                    <p class="text-xs text-slate-400">Refer to product outer packaging for application details.</p>
                                @endif
                            </div>

                            <!-- Ingredients Tab -->
                            <div x-show="tab === 'ingredients'" style="display: none;">
                                @if($product->ingredients_information)
                                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-2 font-mono">
                                        <strong class="text-navy block font-sans">INCI Ingredients:</strong>
                                        <p>{{ $product->ingredients_information }}</p>
                                    </div>
                                @else
                                    <p class="text-xs text-slate-400">Chemical formulation details available upon commercial inquiry.</p>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <section class="py-16 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="font-heading font-bold text-2xl text-navy mb-8">Related Formulations in {{ $product->category->name }}</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $rel)
                        <div class="bg-white rounded-3xl border border-slate-200 p-5 flex flex-col justify-between hover:shadow-xl transition duration-300 group card-hover-effect">
                            <div>
                                <div class="relative h-48 rounded-2xl overflow-hidden bg-slate-100 mb-3">
                                    <img src="{{ $rel->featured_image_url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                </div>
                                <h4 class="font-heading font-bold text-sm text-navy group-hover:text-brand-blue transition line-clamp-2">
                                    <a href="{{ route('products.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h4>
                            </div>
                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('products.show', $rel->slug) }}" class="text-xs font-bold text-brand-blue">View Specs</a>
                                <button onclick="openInquiryModal({{ $rel->id }}, '{{ addslashes($rel->name) }}')" class="text-xs font-bold text-slate-500 hover:text-navy">Inquire</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
