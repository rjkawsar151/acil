@extends('layouts.app')

@section('title', 'Products Catalog | SINODA by Adonis Chemical Limited')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <span class="badge-scientific-dark mb-3">Formulation Catalog</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">Chemical & Personal Care Products</h1>
                <p class="text-sm sm:text-base text-slate-300 mt-3 leading-relaxed">
                    Explore our portfolio of salon-grade haircare, skincare, body hygiene, and styling waxes manufactured under rigorous quality controls at our Savar facility.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Catalog Section -->
    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filters & Search Toolbar -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 mb-10">
                <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    
                    <!-- Search Input -->
                    <div class="md:col-span-5 relative">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Search products, ingredients, SKU..." class="w-full text-sm py-3 pl-10 pr-4 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>

                    <!-- Category Filter -->
                    <div class="md:col-span-4">
                        <select name="category" onchange="this.form.submit()" class="w-full text-sm py-3 px-4 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan bg-white">
                            <option value="">All Categories ({{ $categories->sum('active_products_count') }})</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->active_products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div class="md:col-span-3 flex items-center gap-2">
                        <select name="sort" onchange="this.form.submit()" class="w-full text-sm py-3 px-4 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan bg-white">
                            <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Sort by: Featured</option>
                            <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                        </select>
                        
                        @if($search || request('category'))
                            <a href="{{ route('products.index') }}" class="p-3 text-slate-400 hover:text-rose-500 transition" title="Clear Filters">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </div>

                </form>

                <!-- Category Quick Pills -->
                <div class="flex flex-wrap items-center gap-2 mt-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('products.index') }}" class="text-xs px-3.5 py-1.5 rounded-full font-semibold transition {{ !request('category') ? 'bg-navy text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        All
                    </a>
                    @foreach($categories as $c)
                        <a href="{{ route('products.index', ['category' => $c->slug]) }}" class="text-xs px-3.5 py-1.5 rounded-full font-semibold transition {{ request('category') == $c->slug ? 'bg-navy text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $c->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl p-5 flex flex-col justify-between transition duration-300 group card-hover-effect">
                            
                            <div>
                                <div class="relative h-56 rounded-2xl overflow-hidden bg-slate-100 mb-4">
                                    <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    
                                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-navy/90 text-white text-[10px] font-bold uppercase tracking-wider">
                                        {{ $product->category->name ?? 'SINODA' }}
                                    </span>

                                    @if($product->is_featured)
                                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-brand-cyan text-navy text-[10px] font-black uppercase tracking-wider">
                                            Featured
                                        </span>
                                    @endif

                                    @if($product->sku)
                                        <span class="absolute bottom-3 left-3 px-2 py-0.5 rounded bg-white/90 backdrop-blur-sm text-[9px] font-mono font-bold text-slate-700">
                                            {{ $product->sku }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="font-heading font-bold text-base text-navy group-hover:text-brand-blue transition line-clamp-2 leading-snug">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>

                                <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                    {{ $product->short_description }}
                                </p>

                                @if($product->available_sizes)
                                    <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-600">
                                        <i class="fa-solid fa-box text-brand-scientific"></i>
                                        <span>Sizes: <strong>{{ $product->available_sizes }}</strong></span>
                                    </div>
                                @endif
                            </div>

                            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-bold text-brand-blue hover:text-navy transition flex items-center gap-1">
                                    <span>Full Specs</span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>

                                <button onclick="openInquiryModal({{ $product->id }}, '{{ addslashes($product->name) }}')" class="px-3 py-1.5 rounded-full bg-brand-light hover:bg-brand-blue text-brand-blue hover:text-white text-[11px] font-bold transition flex items-center gap-1">
                                    <i class="fa-solid fa-envelope"></i> Inquire
                                </button>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-3xl p-12 text-center max-w-md mx-auto border border-slate-200">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-flask"></i>
                    </div>
                    <h3 class="font-heading font-bold text-lg text-navy">No Formulations Found</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-6">No products match your current search or category filter. Try clearing the filter.</p>
                    <a href="{{ route('products.index') }}" class="btn-scientific-primary text-xs !py-2.5 !px-6">
                        Reset Filters
                    </a>
                </div>
            @endif

        </div>
    </section>

@endsection
