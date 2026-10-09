<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NCS3MBDJ');</script>
    <!-- End Google Tag Manager -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($seo->meta_title ?? \App\Models\Setting::get('site_name', 'Adonis Chemical Limited') . ' | Science Behind Better Products'))</title>
    
    <meta name="description" content="@yield('meta_description', ($seo->meta_description ?? 'Adonis Chemical Limited is a premier chemical and personal care manufacturer in Genda, Savar, Dhaka. Home of SINODA brand and concern of Adonis Group.'))">
    <meta name="keywords" content="@yield('meta_keywords', ($seo->meta_keywords ?? 'Adonis Chemical Limited, SINODA, chemical manufacturing Bangladesh, Savar chemical plant, salon products'))">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- OpenGraph / Social -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', ($seo->meta_title ?? 'Adonis Chemical Limited'))">
    <meta property="og:description" content="@yield('meta_description', ($seo->meta_description ?? 'Science Behind Better Products.'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ !empty($seo->og_image) ? (str_starts_with($seo->og_image, 'http') ? $seo->og_image : asset('storage/' . $seo->og_image)) : 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1200&q=80' }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#071B33',
                            dark: '#040E1B',
                            light: '#0e2b4f',
                        },
                        brand: {
                            blue: '#0B5ED7',
                            scientific: '#168CFF',
                            cyan: '#00B7D9',
                            light: '#EAF5FF',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- PDF.js CDN for interactive catalogue slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>

    <!-- Custom Scientific Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <!-- Structured JSON-LD Organization Data -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "Adonis Chemical Limited",
        "alternateName": "SINODA",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('assets/images/logo.png') }}",
        "description": "Chemical and personal care manufacturing company based in Genda, Savar, Dhaka, Bangladesh. A concern of Adonis Group.",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "Genda, Savar",
            "addressLocality": "Dhaka",
            "postalCode": "1340",
            "addressCountry": "BD"
        },
        "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "{{ \App\Models\Setting::get('contact_phone', '+880 1810-000000') }}",
            "contactType": "customer service"
        }
    }
    </script>

    @stack('styles')
</head>
<body class="bg-white text-slate-800 antialiased selection:bg-brand-cyan selection:text-navy">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NCS3MBDJ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="toast-alert fixed bottom-6 right-6 z-50 bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 border border-emerald-400 transition-all duration-300">
            <i class="fa-solid fa-circle-check text-xl"></i>
            <div>
                <p class="font-bold text-sm">Success</p>
                <p class="text-sm opacity-95">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 opacity-70 hover:opacity-100"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-alert fixed bottom-6 right-6 z-50 bg-rose-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 border border-rose-400 transition-all duration-300">
            <i class="fa-solid fa-circle-exclamation text-xl"></i>
            <div>
                <p class="font-bold text-sm">Notice</p>
                <p class="text-sm opacity-95">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 opacity-70 hover:opacity-100"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    @if($errors->any())
        <div class="toast-alert fixed bottom-6 right-6 z-50 bg-rose-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 border border-rose-400 transition-all duration-300">
            <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            <div>
                <p class="font-bold text-sm">Please check the form:</p>
                <ul class="text-xs list-disc list-inside opacity-95">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 opacity-70 hover:opacity-100"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Top Corporate Notification & Contact Bar -->
    <div class="bg-[#07172A] text-slate-300 text-xs py-2 px-4 border-b border-slate-800 hidden md:block">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-5">
                <span class="flex items-center gap-1.5 text-slate-300">
                    <i class="fa-solid fa-industry text-blue-400"></i>
                    <span>{{ \App\Models\Setting::get('topbar_plant_text', 'Plant: Genda, Karnapara, Savar, Dhaka') }}</span>
                </span>
                <span class="text-slate-600">|</span>
                <span class="flex items-center gap-1.5 text-slate-300">
                    <i class="fa-solid fa-building text-cyan-400"></i>
                    <span>{{ \App\Models\Setting::get('topbar_concern_text', 'A Concern of Adonis Group') }}</span>
                </span>
            </div>
            <div class="flex items-center gap-5">
                @php
                    $topPhone = \App\Models\Setting::get('primary_phone', '+880 2 7748891-4');
                    $topEmail = \App\Models\Setting::get('contact_email', \App\Models\Setting::get('primary_email', 'info@adonischemical.com'));
                    $topSocialLinks = \App\Models\SocialLink::active()->get();
                @endphp
                <a href="tel:{{ $topPhone }}" class="flex items-center gap-1.5 hover:text-white transition">
                    <i class="fa-solid fa-phone text-blue-400"></i>
                    <span>{{ $topPhone }}</span>
                </a>
                <a href="mailto:{{ $topEmail }}" class="flex items-center gap-1.5 hover:text-white transition">
                    <i class="fa-solid fa-envelope text-blue-400"></i>
                    <span>{{ $topEmail }}</span>
                </a>
                @if($topSocialLinks->count() > 0)
                    <div class="flex items-center gap-2.5 pl-3 border-l border-slate-700">
                        @foreach($topSocialLinks as $soc)
                            <a href="{{ $soc->url }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-400 transition" title="{{ $soc->platform }}">
                                <i class="{{ $soc->icon ?: 'fa-brands fa-' . strtolower($soc->platform) }}"></i>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center gap-2.5 pl-3 border-l border-slate-700">
                        <a href="https://facebook.com" target="_blank" class="hover:text-blue-400 transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://linkedin.com" target="_blank" class="hover:text-blue-400 transition"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Clean Corporate Navigation Header -->
    <header id="main-site-header" class="sticky top-0 left-0 right-0 z-40 bg-white border-b border-slate-200 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                @php
                    $siteLogoUrl = \App\Models\Setting::getUrl('site_logo', 'assets/images/adonis_logo.png');
                    $sinodaLogoUrl = \App\Models\Setting::getUrl('sinoda_logo', 'assets/images/sinoda_logo.svg');
                    $headerNavItems = \App\Models\NavigationItem::where('location', 'header')
                        ->whereNull('parent_id')
                        ->where('is_active', true)
                        ->with('activeChildren')
                        ->orderBy('sort_order', 'asc')
                        ->get();
                @endphp

                <!-- Brand Logos (Adonis Chemical & SINODA) -->
                <div class="flex items-center gap-3 sm:gap-4 py-1">
                    <a href="{{ route('home') }}" class="flex items-center" title="{{ \App\Models\Setting::get('site_name', 'Adonis Chemical Industries Ltd') }}">
                        <img src="{{ $siteLogoUrl }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/adonis_logo.png') }}';" alt="{{ \App\Models\Setting::get('site_name', 'Adonis Chemical Industries Ltd') }}" class="h-10 sm:h-12 w-auto object-contain" style="max-height: 52px;">
                    </a>
                    @if($sinodaLogoUrl)
                        <div class="h-7 sm:h-8 w-px bg-slate-200"></div>
                        <a href="{{ route('sinoda') }}" class="flex items-center" title="SINODA Personal Care & Salon Brand">
                            <img src="{{ $sinodaLogoUrl }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/sinoda_logo.svg') }}';" alt="SINODA" class="h-6 sm:h-7 w-auto object-contain" style="max-height: 32px;">
                        </a>
                    @endif
                </div>

                <!-- Desktop Navigation Menu (Dynamic from Database & Admin Panel) -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-sm font-semibold">
                    @forelse($headerNavItems as $nav)
                        @php
                            $hasChildren = $nav->activeChildren && $nav->activeChildren->count() > 0;
                            $navPath = trim($nav->url, '/');
                            $isItemActive = ($nav->url === '/' && Request::is('/')) || ($navPath !== '' && (Request::is($navPath) || Request::is($navPath . '/*')));
                            $isSinoda = str_contains(strtolower($nav->title), 'sinoda');
                            $isCatalogue = str_contains(strtolower($nav->title), 'catalogue') || str_contains(strtolower($nav->url), 'catalogue');
                        @endphp

                        @if($hasChildren)
                            <div class="relative group">
                                <button class="px-3 py-2 rounded-lg inline-flex items-center gap-1 transition {{ $isItemActive ? 'text-blue-700 font-bold' : 'text-slate-700 hover:text-blue-700' }}">
                                    <span>{{ $nav->title }}</span>
                                    <i class="fa-solid fa-chevron-down text-[10px] opacity-70 group-hover:rotate-180 transition duration-200"></i>
                                </button>
                                <div class="absolute left-0 top-full pt-1.5 w-60 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-200 z-50">
                                    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-2 text-slate-700">
                                        @foreach($nav->activeChildren as $child)
                                            <a href="{{ $child->url }}" target="{{ $child->target }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg hover:bg-slate-50 hover:text-blue-700 text-xs font-semibold transition">
                                                <span>{{ $child->title }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ $nav->url }}" target="{{ $nav->target }}" class="px-3 py-2 rounded-lg transition {{ $isItemActive ? 'text-blue-700 font-bold' : 'text-slate-700 hover:text-blue-700' }} @if($isSinoda) font-bold text-blue-700 @endif @if($isCatalogue) flex items-center gap-1 @endif">
                                @if($isSinoda)
                                    <span class="w-2 h-2 rounded-full bg-blue-600 inline-block mr-1"></span>
                                @elseif($isCatalogue)
                                    <i class="fa-solid fa-file-pdf text-red-600 text-xs mr-1"></i>
                                @endif
                                {{ $nav->title }}
                            </a>
                        @endif
                    @empty
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg {{ Request::is('/') ? 'text-blue-700 font-bold' : 'text-slate-700 hover:text-blue-700' }}">Home</a>
                        <a href="{{ route('about') }}" class="px-3 py-2 rounded-lg text-slate-700 hover:text-blue-700">About Us</a>
                        <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-lg text-slate-700 hover:text-blue-700">Products</a>
                        <a href="{{ route('sinoda') }}" class="px-3 py-2 rounded-lg font-bold text-blue-700">SINODA</a>
                        <a href="{{ route('catalogue') }}" class="px-3 py-2 rounded-lg text-slate-700 hover:text-blue-700 flex items-center gap-1"><i class="fa-solid fa-file-pdf text-red-600 text-xs mr-1"></i> Catalogue</a>
                        <a href="{{ route('manufacturing') }}" class="px-3 py-2 rounded-lg text-slate-700 hover:text-blue-700">Manufacturing</a>
                        <a href="{{ route('quality') }}" class="px-3 py-2 rounded-lg text-slate-700 hover:text-blue-700">Quality Assurance</a>
                        <a href="{{ route('careers.index') }}" class="px-3 py-2 rounded-lg {{ Request::is('careers*') ? 'text-blue-700 font-bold' : 'text-slate-700 hover:text-blue-700' }}">Career</a>
                        <a href="{{ route('news.index') }}" class="px-3 py-2 rounded-lg text-slate-700 hover:text-blue-700">News</a>
                        <a href="{{ route('contact') }}" class="px-3 py-2 rounded-lg text-slate-700 hover:text-blue-700">Contact</a>
                    @endforelse
                </nav>

                <!-- Action CTA & Search -->
                <div class="hidden lg:flex items-center gap-3">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <input type="text" name="q" placeholder="Search products..." class="w-36 focus:w-48 transition-all text-xs py-2 pl-8 pr-3 rounded-lg bg-slate-100 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-600 border border-slate-200">
                        <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </form>

                    <a href="{{ route('inquiry.index') }}" class="btn-corporate-primary text-xs !py-2.5 !px-4">
                        <i class="fa-solid fa-envelope"></i> Inquire Now
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center gap-2 lg:hidden">
                    <a href="{{ route('inquiry.index') }}" class="w-9 h-9 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm shadow-sm" aria-label="Product Inquiry">
                        <i class="fa-solid fa-envelope"></i>
                    </a>
                    <button id="mobile-menu-btn" class="p-2 rounded-lg text-2xl text-slate-700 hover:text-blue-600" aria-label="Toggle mobile menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-navy/80 backdrop-blur-sm z-50 hidden transition-opacity"></div>

    <!-- Mobile Slide-out Drawer -->
    <div id="mobile-menu-drawer" class="fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] bg-navy-dark text-white z-50 shadow-2xl p-6 transform translate-x-full transition-transform duration-300 overflow-y-auto flex flex-col justify-between border-l border-slate-800">
        <div>
            <div class="flex items-center justify-between pb-6 border-b border-slate-800">
                <div class="flex items-center gap-2 bg-white rounded-xl px-2.5 py-1 shadow-sm">
                    <img src="{{ $siteLogoUrl }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/adonis_logo.png') }}';" alt="Adonis Chemical" class="h-7 w-auto object-contain">
                    @if($sinodaLogoUrl)
                        <div class="h-5 w-px bg-slate-300"></div>
                        <img src="{{ $sinodaLogoUrl }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/sinoda_logo.svg') }}';" alt="SINODA" class="h-5 w-auto object-contain">
                    @endif
                </div>
                <button id="mobile-menu-close" class="p-2 text-slate-400 hover:text-white text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Mobile Search -->
            <form action="{{ route('search') }}" method="GET" class="mt-6 relative">
                <input type="text" name="q" placeholder="Search formulations..." class="w-full text-xs py-2.5 pl-9 pr-3 rounded-xl bg-slate-800/80 text-white placeholder-slate-400 border border-slate-700 focus:outline-none focus:border-brand-cyan">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            </form>

            <nav class="mt-6 flex flex-col gap-1 text-sm font-semibold">
                @forelse($headerNavItems as $nav)
                    @php
                        $hasChildren = $nav->activeChildren && $nav->activeChildren->count() > 0;
                        $navPath = trim($nav->url, '/');
                        $isItemActive = ($nav->url === '/' && Request::is('/')) || ($navPath !== '' && (Request::is($navPath) || Request::is($navPath . '/*')));
                        $isSinoda = str_contains(strtolower($nav->title), 'sinoda');
                        $isCatalogue = str_contains(strtolower($nav->title), 'catalogue') || str_contains(strtolower($nav->url), 'catalogue');
                    @endphp

                    <a href="{{ $nav->url }}" target="{{ $nav->target }}" class="px-4 py-3 rounded-xl {{ $isItemActive ? 'bg-brand-blue/30 text-white font-bold' : 'hover:bg-slate-800 text-slate-200 hover:text-brand-cyan' }} transition flex items-center justify-between">
                        <span>{{ $nav->title }}</span>
                        @if($isSinoda)
                            <span class="w-2 h-2 rounded-full bg-brand-cyan"></span>
                        @elseif($isCatalogue)
                            <i class="fa-solid fa-file-pdf text-red-400"></i>
                        @endif
                    </a>

                    @if($hasChildren)
                        <div class="pl-4 space-y-1">
                            @foreach($nav->activeChildren as $child)
                                <a href="{{ $child->url }}" target="{{ $child->target }}" class="px-4 py-2 rounded-lg text-xs text-slate-300 hover:bg-slate-800 hover:text-brand-cyan block transition">
                                    — {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                @empty
                    <a href="{{ route('home') }}" class="px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-200">Home</a>
                    <a href="{{ route('about') }}" class="px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-200">About Enterprise</a>
                    <a href="{{ route('products.index') }}" class="px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-200">Products Catalog</a>
                    <a href="{{ route('catalogue') }}" class="px-4 py-3 rounded-xl bg-slate-800/60 text-brand-scientific font-bold transition flex items-center justify-between">
                        <span>Products Catalogue (PDF)</span>
                        <i class="fa-solid fa-file-pdf text-red-400"></i>
                    </a>
                    <a href="{{ route('sinoda') }}" class="px-4 py-3 rounded-xl bg-brand-blue/20 text-brand-cyan border border-brand-cyan/30 font-bold transition flex items-center justify-between">
                        <span>SINODA Brand</span>
                        <span class="w-2 h-2 rounded-full bg-brand-cyan"></span>
                    </a>
                    <a href="{{ route('manufacturing') }}" class="px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-200">Manufacturing Facility</a>
                    <a href="{{ route('quality') }}" class="px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-200">Quality Assurance</a>
                    <a href="{{ route('careers.index') }}" class="px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-200">Career & Jobs</a>
                    <a href="{{ route('news.index') }}" class="px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-200">News & Articles</a>
                    <a href="{{ route('contact') }}" class="px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-200">Contact Us</a>
                @endforelse
            </nav>
        </div>

        <div class="pt-6 border-t border-slate-800 text-xs text-slate-400">
            <p class="font-bold text-white mb-1">Genda, Savar, Dhaka</p>
            <p class="mb-3">A Concern of Adonis Group</p>
            <a href="{{ route('inquiry.index') }}" class="w-full btn-scientific-primary text-xs !py-3 inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> Submit Inquiry
            </a>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="min-h-screen {{ Request::is('/') ? '' : 'pt-20' }}">
        @yield('content')
    </main>

    <!-- Global Product Inquiry Modal -->
    <div id="product-inquiry-modal" class="fixed inset-0 z-50 bg-navy/80 backdrop-blur-md hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full shadow-2xl border border-slate-100 overflow-hidden relative animate-float-none">
            
            <div class="bg-gradient-to-r from-navy via-brand-blue to-navy-dark p-6 text-white relative">
                <button onclick="closeInquiryModal()" class="absolute right-5 top-5 text-slate-300 hover:text-white text-xl">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <span class="badge-scientific-dark text-[10px] mb-2">Adonis Chemical Commercial Desk</span>
                <h3 id="inquiry-modal-product-title" class="font-heading font-extrabold text-xl text-white">Request Product Information & Quotes</h3>
                <p class="text-xs text-slate-300 mt-1">Connect directly with our Savar technical & sales team.</p>
            </div>

            <form action="{{ route('inquiry.submit') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="">
                <input type="hidden" name="product_name" value="">
                <!-- Honeypot check for bots -->
                <input type="text" name="inquiry_bot_check" style="display:none !important;" tabindex="-1" autocomplete="off">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Your Name *</label>
                        <input type="text" name="name" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-cyan focus:outline-none" placeholder="e.g. Tanvir Ahmed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Company / Salon Name</label>
                        <input type="text" name="company" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-cyan focus:outline-none" placeholder="e.g. Prestige Salon & Spa">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Phone Number *</label>
                        <input type="tel" name="phone" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-cyan focus:outline-none" placeholder="+880 1700-000000">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email Address *</label>
                        <input type="email" name="email" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-cyan focus:outline-none" placeholder="name@domain.com">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Estimated Quantity / Requirement</label>
                    <input type="text" name="quantity_requirement" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-cyan focus:outline-none" placeholder="e.g. 100 units / Salon Bulk 50L / Distribution Inquiry">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Requirement Details *</label>
                    <textarea name="message" rows="3" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-cyan focus:outline-none" placeholder="Please specify target volume, destination city, or custom specification questions..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeInquiryModal()" class="px-5 py-2.5 rounded-full text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="btn-scientific-primary text-xs !py-2.5 !px-6">
                        <i class="fa-solid fa-paper-plane"></i> Submit Inquiry
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Master Footer -->
    <footer class="bg-navy-dark text-slate-300 pt-16 pb-8 border-t border-slate-800 relative overflow-hidden">
        <!-- Subtle scientific background glow -->
        <div class="absolute -top-40 right-0 w-96 h-96 bg-brand-blue/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 left-0 w-96 h-96 bg-brand-cyan/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
                
                <!-- Col 1: Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-blue to-brand-cyan p-0.5">
                            <div class="w-full h-full bg-navy rounded-[10px] flex items-center justify-center text-white font-bold text-lg">
                                <i class="fa-solid fa-atom text-brand-cyan"></i>
                            </div>
                        </div>
                        <div>
                            <span class="font-heading font-extrabold text-xl text-white tracking-tight">ADONIS <span class="text-brand-scientific">CHEMICAL</span></span>
                            <span class="text-[10px] tracking-widest uppercase font-semibold text-brand-cyan block">A Concern of Adonis Group</span>
                        </div>
                    </a>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                        {{ \App\Models\Setting::get('footer_about', 'Adonis Chemical Limited is a leading chemical and personal care manufacturing enterprise committed to scientific formulation, state-of-the-art laboratory standards, and top-tier product quality for salons and consumers under the SINODA brand.') }}
                    </p>
                    <div class="pt-2 flex items-center gap-3">
                        @if($topSocialLinks->count() > 0)
                            @foreach($topSocialLinks as $soc)
                                <a href="{{ $soc->url }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-blue text-slate-300 hover:text-white flex items-center justify-center transition" title="{{ $soc->platform }}">
                                    <i class="{{ $soc->icon ?: 'fa-brands fa-' . strtolower($soc->platform) }} text-sm"></i>
                                </a>
                            @endforeach
                        @else
                            <a href="https://facebook.com" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-blue text-slate-300 hover:text-white flex items-center justify-center transition">
                                <i class="fa-brands fa-facebook-f text-sm"></i>
                            </a>
                            <a href="https://linkedin.com" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-scientific text-slate-300 hover:text-white flex items-center justify-center transition">
                                <i class="fa-brands fa-linkedin-in text-sm"></i>
                            </a>
                            <a href="https://instagram.com" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-pink-600 text-slate-300 hover:text-white flex items-center justify-center transition">
                                <i class="fa-brands fa-instagram text-sm"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Col 2: Company -->
                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-4 border-l-2 border-brand-cyan pl-2.5">Company</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-brand-cyan transition">About Adonis Chemical</a></li>
                        <li><a href="{{ route('adonis-group') }}" class="hover:text-brand-cyan transition">Adonis Group Ecosystem</a></li>
                        <li><a href="{{ route('careers.index') }}" class="hover:text-brand-cyan transition font-semibold text-brand-cyan flex items-center gap-1.5"><i class="fa-solid fa-briefcase text-xs"></i> Careers & Openings</a></li>
                        <li><a href="{{ route('manufacturing') }}" class="hover:text-brand-cyan transition">Savar Manufacturing Plant</a></li>
                        <li><a href="{{ route('quality') }}" class="hover:text-brand-cyan transition">Quality Assurance Lab</a></li>
                        <li><a href="{{ route('rd') }}" class="hover:text-brand-cyan transition">Research & Development</a></li>
                        <li><a href="{{ route('sustainability') }}" class="hover:text-brand-cyan transition">Sustainability Practices</a></li>
                    </ul>
                </div>

                <!-- Col 3: Products & Brand -->
                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-4 border-l-2 border-brand-scientific pl-2.5">Products</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('catalogue') }}" class="text-blue-400 font-semibold hover:underline flex items-center gap-1.5"><i class="fa-solid fa-file-pdf text-red-500 text-xs"></i> Products Catalogue</a></li>
                        <li><a href="{{ route('inquiry.index') }}" class="text-cyan-400 font-semibold hover:underline">Commercial Inquiry & Quotes</a></li>
                        <li><a href="{{ route('sinoda') }}" class="text-brand-cyan font-semibold hover:underline">SINODA Brand Portfolio</a></li>
                        <li><a href="{{ route('categories.show', 'hair-care') }}" class="hover:text-brand-cyan transition">Hair Care & Shampoos</a></li>
                        <li><a href="{{ route('categories.show', 'skin-care') }}" class="hover:text-brand-cyan transition">Skin & Aloe Vera Gels</a></li>
                        <li><a href="{{ route('categories.show', 'salon-professional') }}" class="hover:text-brand-cyan transition">Salon Styling & Waxes</a></li>
                        <li><a href="{{ route('categories.show', 'body-care') }}" class="hover:text-brand-cyan transition">Body & Hand Care</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact Info -->
                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-4 border-l-2 border-brand-blue pl-2.5">Facility & Contact</h4>
                    <ul class="space-y-3 text-xs text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-industry text-brand-cyan mt-1"></i>
                            <div>
                                <strong class="text-white block">Plant Location:</strong>
                                {{ \App\Models\Setting::get('factory_location', 'Genda, Savar, Dhaka-1340, Bangladesh') }}
                            </div>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-phone text-brand-scientific mt-1"></i>
                            <div>
                                <strong class="text-white block">Contact Line:</strong>
                                {{ \App\Models\Setting::get('contact_phone', '+880 1810-000000') }}
                            </div>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-envelope text-brand-cyan mt-1"></i>
                            <div>
                                <strong class="text-white block">Email:</strong>
                                {{ \App\Models\Setting::get('contact_email', 'info@adonischemical.com') }}
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>{{ \App\Models\Setting::get('copyright_text', '© ' . date('Y') . ' Adonis Chemical Industries Ltd. A Concern of Adonis Group. All Rights Reserved.') }}</p>
                <div class="text-slate-500">
                    <span>Manufacturing in Savar, Dhaka, Bangladesh</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Main JavaScript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
