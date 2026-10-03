@extends('layouts.app')

@section('title', 'Product Inquiry & Quotation Request | Adonis Chemical Industries Ltd')
@section('meta_description', 'Submit commercial product inquiries, salon bulk orders, formulation quotes, or contract manufacturing requests directly to Adonis Chemical Industries Ltd.')

@section('content')

    <!-- 1. Header Banner -->
    <section class="bg-navy-dark text-white py-16 sm:py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="badge-scientific-dark text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-file-signature text-cyan-400"></i> Commercial & Plant Desk
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-slate-800 text-slate-300 text-xs font-semibold border border-slate-700">
                        <i class="fa-solid fa-shield-halved text-emerald-400"></i> ISO & GMP Certified Plant
                    </span>
                </div>

                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight leading-tight">
                    Product Inquiry & Quote Request
                </h1>
                
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl">
                    Connect directly with our chemical formulation specialists and commercial sales team at our Savar facility for volume quotes, salon distribution, technical datasheets, or custom batch manufacturing.
                </p>
            </div>
        </div>
    </section>

    <!-- 2. Main Inquiry Section -->
    <section class="py-14 sm:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Left: Comprehensive Inquiry Form (8 cols) -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-8">
                        
                        <!-- Pre-selected Product Banner (If passed via URL) -->
                        @if($selectedProduct)
                            <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-900 border border-slate-200 flex-shrink-0">
                                        <img src="{{ $selectedProduct->primary_image_url }}" alt="{{ $selectedProduct->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded bg-blue-600 text-white inline-block mb-1">
                                            Inquiring About
                                        </span>
                                        <h3 class="font-heading font-bold text-navy text-base truncate">{{ $selectedProduct->name }}</h3>
                                        <p class="text-xs text-slate-500 font-mono">Code: {{ $selectedProduct->code }} &bull; {{ $selectedProduct->category->name ?? 'SINODA' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('inquiry.index') }}" class="text-xs text-slate-500 hover:text-navy font-bold underline whitespace-nowrap self-end sm:self-center">
                                    Change / General Inquiry
                                </a>
                            </div>
                        @endif

                        <form action="{{ route('inquiry.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Honeypot check for bots -->
                            <input type="text" name="inquiry_bot_check" style="display:none !important;" tabindex="-1" autocomplete="off">
                            <input type="hidden" name="product_id" id="hidden_product_id" value="{{ $selectedProduct ? $selectedProduct->id : '' }}">

                            <!-- Section 1: Customer Identification -->
                            <div class="space-y-4">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2 flex items-center gap-2">
                                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">1</span>
                                    <span>Contact & Organization Profile</span>
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Your Full Name *</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Engr. Tanvir Ahmed" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-slate-50/50 focus:bg-white transition">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Company / Salon / Enterprise Name</label>
                                        <input type="text" name="company" value="{{ old('company') }}" placeholder="e.g. Prestige Salon Care Ltd" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-slate-50/50 focus:bg-white transition">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Phone / WhatsApp Number *</label>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+880 1700-000000" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-slate-50/50 focus:bg-white transition">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Official Email Address *</label>
                                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@company.com" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-slate-50/50 focus:bg-white transition">
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Product & Commercial Scope -->
                            <div class="space-y-4 pt-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2 flex items-center gap-2">
                                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">2</span>
                                    <span>Product Selection & Volume Requirement</span>
                                </h3>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Product of Interest</label>
                                        <select name="product_selector" id="product_selector" onchange="updateProductSelection(this)" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-slate-50/50 focus:bg-white transition">
                                            <option value="" data-id="" {{ !$selectedProduct ? 'selected' : '' }}>— Select Product or General Inquiry —</option>
                                            <option value="General Chemical Inquiry" data-id="" {{ old('product_name') == 'General Chemical Inquiry' ? 'selected' : '' }}>General Chemical Formulation Inquiry</option>
                                            <option value="SINODA Dealership / Salon Line" data-id="" {{ old('product_name') == 'SINODA Dealership / Salon Line' ? 'selected' : '' }}>SINODA Brand Dealership & Salon Supply</option>
                                            <option value="Contract Manufacturing / Private Label" data-id="" {{ old('product_name') == 'Contract Manufacturing / Private Label' ? 'selected' : '' }}>Contract Manufacturing / Private Label</option>

                                            @foreach($categories as $cat)
                                                @if($cat->activeProducts->count() > 0)
                                                    <optgroup label="{{ $cat->name }}">
                                                        @foreach($cat->activeProducts as $prod)
                                                            <option value="{{ $prod->name }}" data-id="{{ $prod->id }}" {{ ($selectedProduct && $selectedProduct->id == $prod->id) ? 'selected' : '' }}>
                                                                {{ $prod->name }} ({{ $prod->code }})
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endif
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="product_name" id="hidden_product_name" value="{{ $selectedProduct ? $selectedProduct->name : old('product_name', '') }}">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Estimated Quantity / Volume</label>
                                        <input type="text" name="quantity_requirement" value="{{ old('quantity_requirement') }}" placeholder="e.g. 500 Liters, 100 cartons, 5 Tons" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-slate-50/50 focus:bg-white transition">
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Detailed Message & Technical Needs -->
                            <div class="space-y-4 pt-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2 flex items-center gap-2">
                                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold">3</span>
                                    <span>Detailed Specifications & Requirements</span>
                                </h3>

                                <div>
                                    <label class="block text-xs font-bold text-navy uppercase tracking-wider mb-2">Message / Requirement Details *</label>
                                    <textarea name="message" rows="5" required placeholder="Please provide specific details regarding your target packaging, delivery location (city), required pH/viscosity parameters (if custom formulation), or commercial questions..." class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-slate-50/50 focus:bg-white transition">{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-100">
                                <p class="text-xs text-slate-400 flex items-center gap-1.5">
                                    <i class="fa-solid fa-lock text-emerald-500"></i>
                                    <span>Your commercial inquiries are kept strictly confidential.</span>
                                </p>
                                <button type="submit" class="btn-corporate-primary !py-3.5 !px-8 w-full sm:w-auto inline-flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    <span>Submit Inquiry to Factory Desk</span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Right: Information & Factory Desk Sidebar (4 cols) -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Savar Facility Desk Card -->
                    <div class="bg-navy text-white rounded-3xl p-6 sm:p-8 relative overflow-hidden shadow-lg">
                        <div class="absolute -right-10 -bottom-10 w-36 h-36 bg-blue-600/20 rounded-full blur-2xl pointer-events-none"></div>

                        <span class="badge-scientific-dark text-[10px] mb-3">Direct Factory Dispatch</span>
                        <h3 class="font-heading font-extrabold text-xl text-white mb-2">Commercial Desk</h3>
                        <p class="text-xs text-slate-300 leading-relaxed mb-6">
                            For urgent bulk orders or distributor partnerships, reach out directly through our priority lines:
                        </p>

                        <div class="space-y-4 border-t border-slate-800 pt-5 text-xs">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-phone text-cyan-400 mt-1"></i>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400">Direct Factory Hotline</p>
                                    <a href="tel:{{ $settings['contact_phone'] }}" class="font-bold text-white hover:text-cyan-400 transition">{{ $settings['contact_phone'] }}</a>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-envelope text-blue-400 mt-1"></i>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400">Commercial Email</p>
                                    <a href="mailto:{{ $settings['sales_email'] }}" class="font-bold text-white hover:text-cyan-400 transition">{{ $settings['sales_email'] }}</a>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-industry text-emerald-400 mt-1"></i>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400">Manufacturing Plant</p>
                                    <p class="text-slate-300 leading-relaxed">{{ $settings['factory_location'] }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-clock text-amber-400 mt-1"></i>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400">Working Hours</p>
                                    <p class="text-slate-300">{{ $settings['working_hours'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Procurement & SLA Process Card -->
                    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm space-y-4">
                        <h4 class="font-heading font-bold text-sm text-navy uppercase tracking-wider border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i class="fa-solid fa-list-check text-blue-600"></i>
                            <span>Inquiry & Fulfillment SLA</span>
                        </h4>

                        <div class="space-y-4 text-xs">
                            <div class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center flex-shrink-0 text-[11px]">1</span>
                                <div>
                                    <p class="font-bold text-navy">Formulation Review</p>
                                    <p class="text-slate-500 text-[11px]">Technical team analyzes requirements and safety compliance.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center flex-shrink-0 text-[11px]">2</span>
                                <div>
                                    <p class="font-bold text-navy">Lab Sample & Quote</p>
                                    <p class="text-slate-500 text-[11px]">Commercial quotation and batch specs provided within 24–48 hours.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center flex-shrink-0 text-[11px]">3</span>
                                <div>
                                    <p class="font-bold text-navy">Savar Batch Manufacturing</p>
                                    <p class="text-slate-500 text-[11px]">High-shear 316L vessel production under strict ISO/GMP standards.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('catalogue') }}" class="w-full btn-corporate-red !py-2.5 !px-4 text-xs inline-flex items-center justify-center gap-2">
                                <i class="fa-solid fa-file-pdf"></i>
                                <span>Download Product Catalogue (PDF)</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
function updateProductSelection(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const productId = selectedOption.getAttribute('data-id') || '';
    const productName = selectedOption.value || '';
    
    document.getElementById('hidden_product_id').value = productId;
    document.getElementById('hidden_product_name').value = productName;
}
</script>
@endpush
