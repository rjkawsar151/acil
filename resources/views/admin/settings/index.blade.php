@extends('layouts.admin')

@section('page_title', 'General System Settings')
@section('page_subtitle', 'Corporate configuration, factory contact channels, brand identifiers, and analytics')

@section('content')

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ tab: 'general' }">
        @csrf

        <!-- Navigation Tabs -->
        <div class="flex items-center gap-2 border-b border-slate-200 pb-3 overflow-x-auto">
            <button type="button" @click="tab = 'general'" :class="tab === 'general' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-building"></i>
                <span>Corporate Identity</span>
            </button>
            <button type="button" @click="tab = 'contact'" :class="tab === 'contact' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-address-book"></i>
                <span>Contact & Factory Addresses</span>
            </button>
            <button type="button" @click="tab = 'logos'" :class="tab === 'logos' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-image"></i>
                <span>Brand Logos & Badges</span>
            </button>
            <button type="button" @click="tab = 'catalogue'" :class="tab === 'catalogue' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Product Catalogue PDF</span>
            </button>
            <button type="button" @click="tab = 'scripts'" :class="tab === 'scripts' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-code"></i>
                <span>Analytics & Custom Code</span>
            </button>
        </div>

        <!-- TAB 1: General Identity & Top Bar -->
        <div x-show="tab === 'general'" class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
                <h3 class="font-bold text-navy text-base mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-building text-brand-blue"></i>
                    <span>Company & Top Header Bar Information</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                    <div>
                        <label class="block font-bold text-navy mb-1.5">Official Company Name</label>
                        <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name', 'Adonis Chemical Limited') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Parent Conglomerate / Group</label>
                        <input type="text" name="parent_company" value="{{ \App\Models\Setting::get('parent_company', 'A Concern of Adonis Group') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Top Bar Plant Info (e.g. Plant: Genda, Savar, Dhaka)</label>
                        <input type="text" name="topbar_plant_text" value="{{ \App\Models\Setting::get('topbar_plant_text', 'Plant: Genda, Karnapara, Savar, Dhaka') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Top Bar Concern Text (e.g. A Concern of Adonis Group)</label>
                        <input type="text" name="topbar_concern_text" value="{{ \App\Models\Setting::get('topbar_concern_text', 'A Concern of Adonis Group') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Flagship Chemical Brand</label>
                        <input type="text" name="brand_name" value="{{ \App\Models\Setting::get('brand_name', 'SINODA') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Company Tagline</label>
                        <input type="text" name="site_tagline" value="{{ \App\Models\Setting::get('site_tagline', 'Advanced Chemical Solutions & Industrial Innovation') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-bold text-navy mb-1.5">Working Hours / Operational Schedule</label>
                        <input type="text" name="working_hours" value="{{ \App\Models\Setting::get('working_hours', 'Saturday – Thursday: 9:00 AM – 6:00 PM (Friday Closed)') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: Contact & Locations -->
        <div x-show="tab === 'contact'" class="space-y-6" style="display: none;">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
                <h3 class="font-bold text-navy text-base mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-brand-blue"></i>
                    <span>Contact Touchpoints & Factory Addresses</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                    <div>
                        <label class="block font-bold text-navy mb-1.5">General Inquiries Email (Top Header & Contact)</label>
                        <input type="email" name="contact_email" value="{{ \App\Models\Setting::get('contact_email', \App\Models\Setting::get('primary_email', 'info@adonischemical.com')) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Commercial & Sales Email</label>
                        <input type="email" name="sales_email" value="{{ \App\Models\Setting::get('sales_email', 'sales@adonischemical.com') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Telephone / PABX (Top Header & Contact)</label>
                        <input type="text" name="primary_phone" value="{{ \App\Models\Setting::get('primary_phone', '+880 2 7748891-4') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Emergency Hotline / Mobile</label>
                        <input type="text" name="hotline_phone" value="{{ \App\Models\Setting::get('hotline_phone', '+880 1713 000000') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-bold text-navy mb-1.5">Factory & Chemical Plant Address</label>
                        <textarea name="factory_location" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">{{ \App\Models\Setting::get('factory_location', 'Genda, Karnapara, Savar, Dhaka-1340, Bangladesh') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-bold text-navy mb-1.5">Corporate Headquarters Address</label>
                        <textarea name="corporate_office" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">{{ \App\Models\Setting::get('corporate_office', 'Adonis Tower, Plot 14, Sector 7, Uttara, Dhaka-1230, Bangladesh') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-bold text-navy mb-1.5">Google Maps Embed URL / Iframe Code</label>
                        <textarea name="google_maps_embed" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">{{ \App\Models\Setting::get('google_maps_embed') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: Logos & Homepage Section Images -->
        <div x-show="tab === 'logos'" class="space-y-6" style="display: none;">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
                <h3 class="font-bold text-navy text-base mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-image text-brand-blue"></i>
                    <span>Brand Logos & Homepage Facility Images</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs mb-8">
                    <!-- ACIL Logo -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 text-center">
                        <div class="font-bold text-navy mb-3">Adonis Chemical Logo</div>
                        <div class="h-24 bg-white rounded-xl border border-slate-200 flex items-center justify-center p-3 mb-4">
                            <img src="{{ \App\Models\Setting::getUrl('site_logo', 'assets/images/adonis_logo.png') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/adonis_logo.png') }}';" alt="Adonis Chemical Logo" class="max-h-16 max-w-full object-contain">
                        </div>
                        <input type="file" name="site_logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-brand-blue file:text-white cursor-pointer">
                    </div>

                    <!-- SINODA Logo -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 text-center">
                        <div class="font-bold text-navy mb-3">SINODA Brand Logo</div>
                        <div class="h-24 bg-white rounded-xl border border-slate-200 flex items-center justify-center p-3 mb-4">
                            <img src="{{ \App\Models\Setting::getUrl('sinoda_logo', 'assets/images/sinoda_logo.svg') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/sinoda_logo.svg') }}';" alt="SINODA Logo" class="max-h-16 max-w-full object-contain">
                        </div>
                        <input type="file" name="sinoda_logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-brand-blue file:text-white cursor-pointer">
                    </div>

                    <!-- Adonis Group Logo -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 text-center">
                        <div class="font-bold text-navy mb-3">Adonis Group Conglomerate Logo</div>
                        <div class="h-24 bg-white rounded-xl border border-slate-200 flex items-center justify-center p-3 mb-4">
                            <img src="{{ \App\Models\Setting::getUrl('adonis_group_logo', 'assets/images/adonis_group_logo.png') }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/adonis_group_logo.png') }}';" alt="Adonis Group Logo" class="max-h-16 max-w-full object-contain">
                        </div>
                        <input type="file" name="adonis_group_logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-brand-blue file:text-white cursor-pointer">
                    </div>
                </div>

                <!-- Homepage Facility Images -->
                <h4 class="font-bold text-navy text-sm mb-4 border-t border-slate-100 pt-6 flex items-center gap-2">
                    <i class="fa-solid fa-industry text-brand-blue"></i>
                    <span>Homepage About Section Facility Photos</span>
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <div class="font-bold text-navy mb-2">Facility Photo 1 (Savar Production Unit)</div>
                        <div class="h-40 bg-white rounded-xl border border-slate-200 overflow-hidden mb-3">
                            <img src="{{ \App\Models\Setting::getUrl('about_image_1', 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80') }}" alt="Facility Photo 1" class="w-full h-full object-cover">
                        </div>
                        <label class="block font-semibold text-slate-600 mb-1">Caption / Label</label>
                        <input type="text" name="about_caption_1" value="{{ \App\Models\Setting::get('about_caption_1', 'Savar Blending & Production Unit') }}" class="w-full px-3 py-2 mb-3 rounded-lg border border-slate-200 text-xs">
                        <input type="file" name="about_image_1" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-brand-blue file:text-white cursor-pointer">
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <div class="font-bold text-navy mb-2">Facility Photo 2 (Formulation & QC Lab)</div>
                        <div class="h-40 bg-white rounded-xl border border-slate-200 overflow-hidden mb-3">
                            <img src="{{ \App\Models\Setting::getUrl('about_image_2', 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=800&q=80') }}" alt="Facility Photo 2" class="w-full h-full object-cover">
                        </div>
                        <label class="block font-semibold text-slate-600 mb-1">Caption / Label</label>
                        <input type="text" name="about_caption_2" value="{{ \App\Models\Setting::get('about_caption_2', 'Analytical Formulation Laboratory') }}" class="w-full px-3 py-2 mb-3 rounded-lg border border-slate-200 text-xs">
                        <input type="file" name="about_image_2" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-brand-blue file:text-white cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: Product Catalogue PDF -->
        <div x-show="tab === 'catalogue'" class="space-y-6" style="display: none;">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-slate-100 gap-4">
                    <div>
                        <h3 class="font-bold text-navy text-base flex items-center gap-2">
                            <i class="fa-solid fa-file-pdf text-red-500"></i>
                            <span>Products Catalogue Flipbook & PDF Document</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Upload and manage the digital product catalogue displayed in the interactive slide viewer on the homepage.</p>
                    </div>
                    <div>
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold {{ \App\Models\Setting::get('catalogue_active', '1') == '1' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                            <span class="w-2 h-2 rounded-full {{ \App\Models\Setting::get('catalogue_active', '1') == '1' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            {{ \App\Models\Setting::get('catalogue_active', '1') == '1' ? 'Homepage Catalogue Active' : 'Catalogue Hidden' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs mb-8">
                    <!-- PDF Upload Card -->
                    <div class="md:col-span-1 p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-white border border-slate-200/80 text-center flex flex-col justify-between">
                        <div>
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center text-red-600 text-2xl shadow-inner">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div class="font-bold text-navy text-sm mb-1">Catalogue PDF File</div>
                            <p class="text-slate-500 text-[11px] mb-4">Upload a high-resolution PDF document (all pages will be rendered as interactive slides).</p>
                            
                            @if(\App\Models\Setting::get('catalogue_pdf'))
                                <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-3 text-left mb-4">
                                    <div class="flex items-center gap-2 text-brand-blue font-bold text-[11px] mb-1">
                                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                        <span>Current Active PDF</span>
                                    </div>
                                    <div class="text-[10px] text-slate-600 truncate font-mono mb-2">
                                        {{ basename(\App\Models\Setting::get('catalogue_pdf')) }}
                                    </div>
                                    <a href="{{ asset('storage/' . \App\Models\Setting::get('catalogue_pdf')) }}" target="_blank" class="inline-flex items-center gap-1.5 text-[11px] font-bold text-brand-blue hover:text-navy underline">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                        <span>Preview PDF File</span>
                                    </a>
                                </div>
                            @else
                                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-left mb-4 text-amber-800 text-[11px]">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i> No PDF uploaded yet.
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="block font-bold text-navy text-left mb-1.5">Replace / Upload New PDF</label>
                            <input type="file" name="catalogue_pdf" accept="application/pdf" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer">
                            <span class="text-[10px] text-slate-400 block text-left mt-1">Recommended: standard A4 or Letter PDF format.</span>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="md:col-span-2 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-navy mb-1.5">Catalogue Section Status</label>
                                <select name="catalogue_active" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none bg-white">
                                    <option value="1" {{ \App\Models\Setting::get('catalogue_active', '1') == '1' ? 'selected' : '' }}>Visible (Show Catalogue on Homepage)</option>
                                    <option value="0" {{ \App\Models\Setting::get('catalogue_active', '1') == '0' ? 'selected' : '' }}>Hidden (Temporarily Hide Section)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-bold text-navy mb-1.5">Section Badge Label</label>
                                <input type="text" name="catalogue_badge" value="{{ \App\Models\Setting::get('catalogue_badge', '2026 Interactive Flipbook Edition') }}" placeholder="e.g. 2026 Interactive Flipbook Edition" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-navy mb-1.5">Catalogue Section Title</label>
                            <input type="text" name="catalogue_title" value="{{ \App\Models\Setting::get('catalogue_title', 'SINODA Technical Product Catalogue 2026') }}" placeholder="e.g. SINODA Technical Product Catalogue 2026" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                        </div>

                        <div>
                            <label class="block font-bold text-navy mb-1.5">Section Subtitle / Description</label>
                            <textarea name="catalogue_subtitle" rows="3" placeholder="Description of the catalogue contents..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">{{ \App\Models\Setting::get('catalogue_subtitle', 'Browse our complete 2026 industrial chemical formulations, molecular specifications, ISO/GMP compliance certificates, and commercial application guides right in your browser or download the full document.') }}</textarea>
                        </div>

                        <!-- Feature highlights notice -->
                        <div class="p-4 rounded-2xl bg-brand-light/50 border border-brand-cyan/20 flex items-start gap-3 text-slate-600">
                            <i class="fa-solid fa-circle-info text-brand-blue text-sm mt-0.5"></i>
                            <div class="text-[11px] leading-relaxed">
                                <strong class="text-navy font-semibold">Interactive Viewer Features:</strong>
                                Homepage visitors can seamlessly turn pages with the floating Previous/Next buttons, page dot navigation, zoom controls, full-screen mode, and swipe gestures (touch swipe on mobile / mouse-drag swipe on desktop).
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: Scripts & Analytics -->
        <div x-show="tab === 'scripts'" class="space-y-6" style="display: none;">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
                <h3 class="font-bold text-navy text-base mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-brand-blue"></i>
                    <span>Tracking, Analytics & Custom Code Injections</span>
                </h3>

                <div class="space-y-6 text-xs">
                    <div>
                        <label class="block font-bold text-navy mb-1.5">Google Analytics Measurement ID</label>
                        <input type="text" name="google_analytics_id" value="{{ \App\Models\Setting::get('google_analytics_id') }}" placeholder="G-XXXXXXXXXX" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Custom Header Scripts (Inside &lt;head&gt;)</label>
                        <textarea name="custom_header_scripts" rows="4" placeholder="<!-- Meta tags, font links, verification scripts -->" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">{{ \App\Models\Setting::get('custom_header_scripts') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Custom Footer Scripts (Before &lt;/body&gt;)</label>
                        <textarea name="custom_footer_scripts" rows="4" placeholder="<!-- Live chat scripts, pixel trackers, custom analytics -->" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none font-mono">{{ \App\Models\Setting::get('custom_footer_scripts') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex items-center justify-end">
            <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-8">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Save All Website Settings</span>
            </button>
        </div>

    </form>

@endsection
