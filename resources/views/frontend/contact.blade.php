@extends('layouts.app')

@section('title', 'Contact Adonis Chemical Limited | Genda, Savar Plant & Head Office')
@section('meta_description', 'Get in touch with Adonis Chemical Limited for product inquiries, salon dealership, and custom chemical manufacturing in Savar, Dhaka, Bangladesh.')

@section('content')

    <!-- Header Banner -->
    <section class="bg-navy-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-hexagon-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <span class="badge-scientific-dark">Commercial & Plant Inquiries</span>
                <h1 class="font-heading font-black text-3xl sm:text-5xl text-white tracking-tight">Contact Adonis Chemical</h1>
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
                    Connect with our corporate office in Dhaka or manufacturing plant in Genda, Savar for commercial partnerships, salon orders, and distribution inquiries.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Contact Section -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Contact Information Cards -->
                <div class="lg:col-span-5 space-y-6">
                    
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
                        <h3 class="font-heading font-bold text-xl text-navy border-b border-slate-100 pb-4">
                            Direct Contact Channels
                        </h3>

                        <!-- Savar Plant -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-brand-light text-brand-blue flex items-center justify-center text-xl flex-shrink-0">
                                <i class="fa-solid fa-industry"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Manufacturing Plant</span>
                                <h4 class="font-heading font-bold text-sm text-navy">Genda, Savar Plant</h4>
                                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $settings['factory_location'] }}</p>
                            </div>
                        </div>

                        <!-- Corporate Office -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-brand-light text-brand-scientific flex items-center justify-center text-xl flex-shrink-0">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Corporate Office</span>
                                <h4 class="font-heading font-bold text-sm text-navy">Adonis Tower</h4>
                                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $settings['corporate_office'] }}</p>
                            </div>
                        </div>

                        <!-- Phone Lines -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-brand-light text-brand-cyan flex items-center justify-center text-xl flex-shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Telephone & Hotline</span>
                                <p class="text-xs text-slate-700 font-bold mt-0.5">{{ $settings['contact_phone'] }}</p>
                                <p class="text-xs text-slate-500">{{ $settings['hotline_phone'] }} (Hotline)</p>
                            </div>
                        </div>

                        <!-- Email Contacts -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-brand-light text-emerald-600 flex items-center justify-center text-xl flex-shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block">Email Inquiries</span>
                                <p class="text-xs text-slate-700 font-bold mt-0.5">{{ $settings['contact_email'] }}</p>
                                <p class="text-xs text-slate-500">{{ $settings['sales_email'] }} (Sales & Bulk)</p>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-150 text-xs text-slate-600 flex items-center gap-3">
                            <i class="fa-regular fa-clock text-brand-blue text-base"></i>
                            <span>{{ $settings['working_hours'] }}</span>
                        </div>

                    </div>

                    <!-- Map Box -->
                    <div class="rounded-3xl overflow-hidden shadow-sm border border-slate-200 h-64">
                        <iframe src="{{ $settings['google_maps_embed'] }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>

                </div>

                <!-- Contact Message Form -->
                <div class="lg:col-span-7">
                    <div class="bg-white rounded-3xl p-8 lg:p-10 border border-slate-200 shadow-sm space-y-6">
                        
                        <div>
                            <span class="badge-scientific text-[10px] mb-2">Message Desk</span>
                            <h3 class="font-heading font-black text-2xl text-navy">Send Us a Direct Message</h3>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                                Our commercial team responds to all verified business inquiries within 24 hours.
                            </p>
                        </div>

                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <!-- Honeypot field for bot spam blocking -->
                            <input type="text" name="website_url_hp" style="display:none !important;" tabindex="-1" autocomplete="off">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Your Full Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan" placeholder="e.g. Ashraf Hossain">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Company / Salon Name</label>
                                    <input type="text" name="company" value="{{ old('company') }}" class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan" placeholder="e.g. Adonis Beauty Salon">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan" placeholder="+880 1700-000000">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan" placeholder="name@domain.com">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Subject / Department</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan" placeholder="e.g. SINODA Salon Dealership / Savar Plant Visit / Bulk Order">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Message / Inquiry Details *</label>
                                <textarea name="message" rows="5" required class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-cyan" placeholder="Please provide detailed specifications, questions, or supply volume requirements...">{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="w-full btn-scientific-primary !py-4 text-sm font-bold shadow-xl shadow-blue-600/30">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Send Message to Adonis Chemical</span>
                            </button>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
