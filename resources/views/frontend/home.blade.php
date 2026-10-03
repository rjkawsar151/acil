@extends('layouts.app')

@section('title', 'Adonis Chemical Industries Ltd | Chemical & Cosmetic Manufacturer in Bangladesh | SINODA')

@section('content')

    <!-- ========================================================================= -->
    <!-- 1. CORPORATE HERO CAROUSEL (AUTOMATIC 4-SECOND INTERVAL)                  -->
    <!-- ========================================================================= -->
    <section class="relative bg-slate-900 text-white overflow-hidden" id="hero-carousel-section">
        
        <!-- Carousel Slides Container -->
        <div class="relative min-h-[500px] lg:min-h-[560px] flex items-center" id="hero-carousel">
            @forelse($heroSlides as $index => $slide)
                <div class="hero-slide {{ $index === 0 ? 'active opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }} absolute inset-0 w-full h-full flex items-center transition-all duration-700 ease-in-out">
                    <!-- Background Image (Fitted top & bottom, aligned to right side) -->
                    <div class="absolute inset-0 bg-cover bg-right bg-no-repeat" style="background-image: url('{{ $slide->image_url }}'); background-position: right center; background-size: cover;">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#07172A] via-[#07172A]/90 to-[#07172A]/30 lg:from-[#07172A] lg:via-[#07172A]/80 lg:to-transparent"></div>
                    </div>
                    
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full py-16">
                        <div class="max-w-2xl space-y-5">
                            @if($slide->badge_text || $slide->badge_subtext)
                                <div class="flex flex-wrap items-center gap-2">
                                    @if($slide->badge_text)
                                        @php
                                            $badgeBg = match($slide->badge_color) {
                                                'cyan' => 'bg-cyan-600',
                                                'emerald' => 'bg-emerald-600',
                                                'amber' => 'bg-amber-600',
                                                'purple' => 'bg-purple-600',
                                                'red' => 'bg-rose-600',
                                                default => 'bg-blue-600',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded {{ $badgeBg }} text-white text-xs font-bold uppercase tracking-wider">
                                            @if($slide->badge_icon)<i class="{{ $slide->badge_icon }}"></i>@endif
                                            {{ $slide->badge_text }}
                                        </span>
                                    @endif
                                    @if($slide->badge_subtext)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-800 text-slate-300 text-xs font-semibold border border-slate-700">
                                            {{ $slide->badge_subtext }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <h1 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
                                {{ $slide->title }}
                            </h1>

                            @if($slide->subtitle)
                                <p class="text-base sm:text-lg text-slate-300 font-normal leading-relaxed">
                                    {{ $slide->subtitle }}
                                </p>
                            @endif

                            @if($slide->button_text || $slide->secondary_button_text || $slide->tertiary_button_text)
                                <div class="pt-2 flex flex-wrap items-center gap-3.5">
                                    @if($slide->button_text && $slide->button_url)
                                        @php
                                            $btn1Class = match($slide->button_style) {
                                                'cyan' => 'btn-corporate-primary !bg-cyan-600 hover:!bg-cyan-700',
                                                'emerald' => 'btn-corporate-primary !bg-emerald-600 hover:!bg-emerald-700',
                                                'red' => 'btn-corporate-red',
                                                'dark' => 'px-5 py-3 rounded-lg bg-slate-800 hover:bg-slate-700 text-white font-semibold text-sm border border-slate-700 transition',
                                                default => 'btn-corporate-primary',
                                            };
                                        @endphp
                                        <a href="{{ $slide->button_url }}" class="{{ $btn1Class }} !py-3 !px-6">
                                            @if($slide->button_icon)<i class="{{ $slide->button_icon }}"></i>@endif
                                            <span>{{ $slide->button_text }}</span>
                                        </a>
                                    @endif

                                    @if($slide->secondary_button_text && $slide->secondary_button_url)
                                        @php
                                            $btn2Class = match($slide->secondary_button_style) {
                                                'primary' => 'btn-corporate-primary',
                                                'cyan' => 'btn-corporate-primary !bg-cyan-600 hover:!bg-cyan-700',
                                                'dark' => 'px-5 py-3 rounded-lg bg-slate-800 hover:bg-slate-700 text-white font-semibold text-sm border border-slate-700 transition',
                                                default => 'btn-corporate-red',
                                            };
                                        @endphp
                                        <a href="{{ $slide->secondary_button_url }}" class="{{ $btn2Class }} !py-3 !px-6">
                                            @if($slide->secondary_button_icon)<i class="{{ $slide->secondary_button_icon }}"></i>@endif
                                            <span>{{ $slide->secondary_button_text }}</span>
                                        </a>
                                    @endif

                                    @if($slide->tertiary_button_text && $slide->tertiary_button_url)
                                        <a href="{{ $slide->tertiary_button_url }}" class="px-5 py-3 rounded-lg bg-slate-800 hover:bg-slate-700 text-white font-semibold text-sm border border-slate-700 transition">
                                            <span>{{ $slide->tertiary_button_text }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="hero-slide active absolute inset-0 w-full h-full flex items-center transition-all duration-700 ease-in-out opacity-100 z-10">
                    <div class="absolute inset-0 bg-cover bg-right bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1600&q=80'); background-position: right center; background-size: cover;">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#07172A] via-[#07172A]/90 to-[#07172A]/30 lg:from-[#07172A] lg:via-[#07172A]/80 lg:to-transparent"></div>
                    </div>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full py-16">
                        <div class="max-w-2xl space-y-5">
                            <h1 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
                                Adonis Chemical Industries Ltd
                            </h1>
                            <p class="text-base sm:text-lg text-slate-300 font-normal leading-relaxed">
                                Leading manufacturer of premium personal care, cosmetics, and industrial chemical formulations in Savar, Bangladesh.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if($heroSlides->count() > 1)
            <!-- Carousel Navigation Chevrons -->
            <button id="carousel-prev" class="absolute left-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-slate-900/70 hover:bg-blue-600 text-white border border-slate-700 flex items-center justify-center transition cursor-pointer" aria-label="Previous Slide">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button id="carousel-next" class="absolute right-4 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-slate-900/70 hover:bg-blue-600 text-white border border-slate-700 flex items-center justify-center transition cursor-pointer" aria-label="Next Slide">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <!-- Carousel Dot Indicators -->
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-30 flex items-center gap-2" id="carousel-dots">
                @foreach($heroSlides as $idx => $slide)
                    <button class="carousel-dot {{ $idx === 0 ? 'w-8 bg-blue-600' : 'w-2 bg-slate-600 hover:bg-slate-400' }} h-2 rounded-full transition-all duration-300" data-slide="{{ $idx }}" aria-label="Slide {{ $idx + 1 }}"></button>
                @endforeach
            </div>
        @endif

    </section>


    <!-- ========================================================================= -->
    <!-- 2. CORPORATE KEY METRICS STRIP                                             -->
    <!-- ========================================================================= -->
    <section class="bg-white py-12 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center sm:text-left">
                
                <div class="p-5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1">Monthly Production</div>
                    <div class="font-heading font-black text-3xl sm:text-4xl text-navy">50,000<span class="text-blue-600">+</span> L</div>
                    <p class="text-xs text-slate-500 mt-1">Industrial blending output at Savar plant</p>
                </div>

                <div class="p-5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1">Active Formulations</div>
                    <div class="font-heading font-black text-3xl sm:text-4xl text-navy">150<span class="text-blue-600">+</span></div>
                    <p class="text-xs text-slate-500 mt-1">Cosmetics, hair care & chemical lines</p>
                </div>

                <div class="p-5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1">Salon & Retail Network</div>
                    <div class="font-heading font-black text-3xl sm:text-4xl text-navy">450<span class="text-blue-600">+</span></div>
                    <p class="text-xs text-slate-500 mt-1">Professional partner salons in Bangladesh</p>
                </div>

                <div class="p-5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1">Quality Validation</div>
                    <div class="font-heading font-black text-3xl sm:text-4xl text-navy">100<span class="text-blue-600">%</span></div>
                    <p class="text-xs text-slate-500 mt-1">Batch tested with in-house analytical lab</p>
                </div>

            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 3. COMPANY PROFILE & ABOUT ADONIS CHEMICAL INDUSTRIES LTD                 -->
    <!-- ========================================================================= -->
    <section class="py-16 lg:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left: Plant Photography -->
                <div class="lg:col-span-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80" alt="Adonis Chemical Facility" class="h-64 sm:h-72 w-full object-cover">
                            <div class="p-3 bg-slate-50 text-xs font-semibold text-slate-700 border-t border-slate-200">
                                Savar Blending & Production Unit
                            </div>
                        </div>
                        <div class="rounded-xl overflow-hidden border border-slate-200 shadow-sm mt-6">
                            <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=800&q=80" alt="Quality Assurance Lab" class="h-64 sm:h-72 w-full object-cover">
                            <div class="p-3 bg-slate-50 text-xs font-semibold text-slate-700 border-t border-slate-200">
                                Analytical Formulation Laboratory
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Corporate Text -->
                <div class="lg:col-span-6 space-y-5">
                    <span class="badge-corporate">
                        <i class="fa-solid fa-building"></i> Company Profile
                    </span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl lg:text-4xl text-navy leading-snug">
                        Leading Chemical & Cosmetic Manufacturing in Savar, Dhaka
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        Adonis Chemical Industries Ltd is an established industrial chemical and cosmetics manufacturer in Bangladesh, operating under the renowned Adonis Group. Our modern production plant at Genda, Karnapara, Savar is equipped with state-of-the-art closed stainless-steel mixing vessels, automated packaging lines, and dedicated quality control laboratories.
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Through our flagship brand <strong>SINODA</strong>, we serve top-tier professional grooming salons, retail cosmetics distributors, and institutional clients across Bangladesh with high-performance hair care, skin care, and specialized chemical formulations.
                    </p>

                    <!-- Core Strengths -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        <div class="flex items-start gap-2.5 text-xs text-slate-700">
                            <i class="fa-solid fa-circle-check text-blue-600 mt-0.5"></i>
                            <span><strong>316L Stainless Steel</strong> closed mixing reactors</span>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs text-slate-700">
                            <i class="fa-solid fa-circle-check text-blue-600 mt-0.5"></i>
                            <span><strong>Multi-Stage RO</strong> deionized water treatment</span>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs text-slate-700">
                            <i class="fa-solid fa-circle-check text-blue-600 mt-0.5"></i>
                            <span><strong>Dermatologically Assayed</strong> safe ingredients</span>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs text-slate-700">
                            <i class="fa-solid fa-circle-check text-blue-600 mt-0.5"></i>
                            <span><strong>Prompt Delivery</strong> across Bangladesh</span>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center gap-4">
                        <a href="{{ route('about') }}" class="btn-corporate-primary">
                            <span>Read Full Profile</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ route('manufacturing') }}" class="btn-corporate-outline">
                            <span>Savar Facility Details</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 4. PRODUCT CATEGORIES SHOWCASE                                            -->
    <!-- ========================================================================= -->
    <section class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="badge-corporate mb-2">Our Product Portfolio</span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-navy">
                        Comprehensive Chemical & Cosmetic Categories
                    </h2>
                    <p class="text-sm text-slate-600 mt-1 max-w-xl">
                        Manufactured according to stringent quality standards for salons, personal consumers, and industrial applications.
                    </p>
                </div>
                <a href="{{ route('products.index') }}" class="btn-corporate-outline text-xs self-start md:self-auto">
                    <span>View All Products</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <div class="corporate-card p-6 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xl mb-4">
                                <i class="fa-solid fa-{{ $category->icon ?: 'flask' }}"></i>
                            </div>
                            <h3 class="font-heading font-bold text-lg text-navy mb-2">
                                <a href="{{ route('categories.show', $category->slug) }}" class="hover:text-blue-700 transition">
                                    {{ $category->name }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-4">
                                {{ $category->description ?? 'Formulated with certified active ingredients and dermatological safety parameters.' }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="font-bold text-blue-700">{{ $category->active_products_count }} Products</span>
                            <a href="{{ route('categories.show', $category->slug) }}" class="text-slate-600 hover:text-blue-700 font-semibold flex items-center gap-1">
                                <span>Browse</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>





    <!-- ========================================================================= -->
    <!-- 7. SINODA FLAGSHIP BRAND FEATURE                                          -->
    <!-- ========================================================================= -->
    <section class="py-16 bg-[#07172A] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <div class="lg:col-span-8 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-900/60 border border-blue-700 text-xs font-bold uppercase tracking-wider text-blue-300">
                        <i class="fa-solid fa-star text-amber-400"></i> Flagship Cosmetic Brand
                    </div>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl lg:text-4xl text-white">
                        SINODA — Professional Salon Care & Daily Grooming
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-3xl">
                        Formulated and manufactured exclusively by Adonis Chemical Industries Ltd, SINODA is the trusted cosmetic and grooming brand for more than 450 premium salons across Dhaka, Chittagong, and major divisions in Bangladesh.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="{{ route('sinoda') }}" class="btn-corporate-primary !bg-blue-600 hover:!bg-blue-500">
                            <span>Explore SINODA Brand Range</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="{{ route('catalogue') }}" class="btn-corporate-outline !bg-transparent !text-white !border-slate-600 hover:!bg-slate-800">
                            <i class="fa-solid fa-file-pdf text-red-400"></i>
                            <span>View Product Catalogue</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-4 bg-slate-800/80 rounded-xl p-6 border border-slate-700">
                    <h4 class="font-bold text-white text-sm mb-3 border-b border-slate-700 pb-2">SINODA Core Lines</h4>
                    <ul class="space-y-2.5 text-xs text-slate-300">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-400"></i> Keratin Infused Hair Shampoos & Masks</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-400"></i> High-Hold Matte & Pomade Hair Waxes</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-400"></i> Natural Aloe Vera & Tea Tree Skin Gels</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-400"></i> Salon Professional Straightening Creams</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-400"></i> Beard & Mustache Conditioning Oils</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>





    <!-- ========================================================================= -->
    <!-- 9. LATEST NEWS & UPDATES                                                  -->
    <!-- ========================================================================= -->
    <section class="py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="badge-corporate mb-2">Company Updates</span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-navy">
                        Latest News & Industrial Announcements
                    </h2>
                </div>
                <a href="{{ route('news.index') }}" class="btn-corporate-outline text-xs self-start md:self-auto">
                    <span>View All Articles</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($latestBlogs as $blog)
                    <article class="corporate-card overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="h-44 bg-slate-100 overflow-hidden">
                                <img src="{{ $blog->featured_image ? (str_starts_with($blog->featured_image, 'http') ? $blog->featured_image : asset('storage/' . $blog->featured_image)) : 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-5">
                                <div class="text-[11px] font-bold text-blue-700 uppercase tracking-wide mb-1.5">
                                    {{ $blog->category->name ?? 'General' }} • {{ $blog->published_at ? $blog->published_at->format('M d, Y') : date('M d, Y') }}
                                </div>
                                <h3 class="font-heading font-bold text-base text-navy hover:text-blue-700 transition line-clamp-2">
                                    <a href="{{ route('news.show', $blog->slug) }}">{{ $blog->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                    {{ $blog->excerpt }}
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="{{ route('news.show', $blog->slug) }}" class="text-xs font-bold text-blue-700 hover:underline flex items-center gap-1">
                                <span>Read Article</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 10. DIRECT FACTORY INQUIRY & CONTACT SECTION                              -->
    <!-- ========================================================================= -->
    <section class="py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Left: Factory & Corporate Office Details -->
                <div class="lg:col-span-5 space-y-6">
                    <div>
                        <span class="badge-corporate mb-2">Direct Touchpoints</span>
                        <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-navy">
                            Get In Touch With Our Team
                        </h2>
                        <p class="text-sm text-slate-600 mt-1">
                            Contact our factory in Savar or corporate headquarters in Uttara for commercial inquiries, dealership, and custom formulations.
                        </p>
                    </div>

                    <div class="space-y-4 text-xs text-slate-700">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <strong class="text-navy font-bold text-sm block mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-industry text-blue-600"></i> Savar Manufacturing Plant
                            </strong>
                            <p class="text-slate-600 leading-relaxed">
                                {{ \App\Models\Setting::get('factory_location', 'Genda, Karnapara, Savar, Dhaka-1340, Bangladesh') }}
                            </p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <strong class="text-navy font-bold text-sm block mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-building text-blue-600"></i> Corporate Headquarters
                            </strong>
                            <p class="text-slate-600 leading-relaxed">
                                {{ \App\Models\Setting::get('corporate_office', 'Adonis Tower, Plot 14, Sector 7, Uttara, Dhaka-1230, Bangladesh') }}
                            </p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-phone text-blue-600"></i>
                                <span>Telephone: <strong>{{ \App\Models\Setting::get('primary_phone', '+880 2 7748891-4') }}</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-envelope text-blue-600"></i>
                                <span>Email: <strong>{{ \App\Models\Setting::get('contact_email', 'info@adonischemical.com') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Clean Corporate Inquiry Form -->
                <div class="lg:col-span-7">
                    <div class="bg-slate-50 p-6 sm:p-8 rounded-2xl border border-slate-200">
                        <h3 class="font-heading font-bold text-lg text-navy mb-4">
                            Send a Product or Commercial Inquiry
                        </h3>
                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4 text-xs">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-navy mb-1">Your Full Name *</label>
                                    <input type="text" name="name" required placeholder="e.g. Md. Rafiqul Islam" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-xs focus:ring-1 focus:ring-blue-600 outline-none bg-white">
                                </div>
                                <div>
                                    <label class="block font-bold text-navy mb-1">Company / Salon Name</label>
                                    <input type="text" name="company" placeholder="e.g. Modern Beauty Care" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-xs focus:ring-1 focus:ring-blue-600 outline-none bg-white">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-navy mb-1">Email Address *</label>
                                    <input type="email" name="email" required placeholder="name@company.com" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-xs focus:ring-1 focus:ring-blue-600 outline-none bg-white">
                                </div>
                                <div>
                                    <label class="block font-bold text-navy mb-1">Phone Number *</label>
                                    <input type="text" name="phone" required placeholder="+880 171X-XXXXXX" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-xs focus:ring-1 focus:ring-blue-600 outline-none bg-white">
                                </div>
                            </div>

                            <div>
                                <label class="block font-bold text-navy mb-1">Product Line of Interest</label>
                                <select name="subject" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-xs focus:ring-1 focus:ring-blue-600 outline-none bg-white">
                                    <option value="SINODA Cosmetics & Salon Care">SINODA Cosmetics & Salon Care</option>
                                    <option value="Hair Care & Keratin Formulations">Hair Care & Keratin Formulations</option>
                                    <option value="Skin Care & Aloe Vera Gels">Skin Care & Aloe Vera Gels</option>
                                    <option value="Industrial Chemical Blending">Industrial Chemical Blending</option>
                                    <option value="Distributorship / Salon Partnership">Distributorship / Salon Partnership</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-bold text-navy mb-1">Message / Requirements *</label>
                                <textarea name="message" rows="4" required placeholder="Specify your desired products, volumes, and requirements..." class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-xs focus:ring-1 focus:ring-blue-600 outline-none bg-white"></textarea>
                            </div>

                            <button type="submit" class="btn-corporate-primary w-full !py-3">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Submit Inquiry to Adonis Chemical</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <!-- Hero Automatic 4-Second Interval Carousel Script -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const prevBtn = document.getElementById('carousel-prev');
        const nextBtn = document.getElementById('carousel-next');
        const carouselSection = document.getElementById('hero-carousel-section');

        if (!slides.length) return;

        let currentIndex = 0;
        let slideInterval = null;
        const intervalDuration = 4000; // Exactly 4-second interval

        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.classList.add('active', 'opacity-100', 'z-10');
                    slide.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                } else {
                    slide.classList.remove('active', 'opacity-100', 'z-10');
                    slide.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                }
            });

            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.add('w-8', 'bg-blue-600');
                    dot.classList.remove('w-2', 'bg-slate-600');
                } else {
                    dot.classList.remove('w-8', 'bg-blue-600');
                    dot.classList.add('w-2', 'bg-slate-600');
                }
            });

            currentIndex = index;
        }

        function nextSlide() {
            let nextIndex = (currentIndex + 1) % slides.length;
            showSlide(nextIndex);
        }

        function prevSlide() {
            let prevIndex = (currentIndex - 1 + slides.length) % slides.length;
            showSlide(prevIndex);
        }

        function startAutoPlay() {
            stopAutoPlay();
            slideInterval = setInterval(nextSlide, intervalDuration);
        }

        function stopAutoPlay() {
            if (slideInterval) clearInterval(slideInterval);
        }

        // Button Listeners
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                startAutoPlay();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                startAutoPlay();
            });
        }

        // Dot Listeners
        dots.forEach((dot) => {
            dot.addEventListener('click', (e) => {
                const targetSlide = parseInt(e.target.getAttribute('data-slide'));
                showSlide(targetSlide);
                startAutoPlay();
            });
        });

        // Pause on hover
        if (carouselSection) {
            carouselSection.addEventListener('mouseenter', stopAutoPlay);
            carouselSection.addEventListener('mouseleave', startAutoPlay);

            // Touch swipe gesture for mobile
            let startX = 0;
            carouselSection.addEventListener('touchstart', (e) => {
                startX = e.changedTouches[0].screenX;
            }, { passive: true });

            carouselSection.addEventListener('touchend', (e) => {
                const endX = e.changedTouches[0].screenX;
                const diff = endX - startX;
                if (Math.abs(diff) > 40) {
                    if (diff < 0) nextSlide();
                    else prevSlide();
                    startAutoPlay();
                }
            }, { passive: true });
        }

        // Start automatic 4s rotation
        startAutoPlay();
    });
    </script>
@endpush
