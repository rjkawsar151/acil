@extends('layouts.admin')

@section('page_title', 'Administrative Overview')
@section('page_subtitle', 'Real-time metrics, product inquiries, and system activity')

@section('content')

    <!-- Metrics Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Total Products -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Formulations</p>
                <h3 class="font-heading font-black text-3xl text-navy mt-1">{{ $stats['total_products'] }}</h3>
                <p class="text-[11px] text-emerald-600 font-semibold mt-1">
                    <i class="fa-solid fa-circle-check"></i> {{ $stats['active_products'] }} Active in Catalog
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-brand-blue flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-flask"></i>
            </div>
        </div>

        <!-- Product Inquiries -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Product Inquiries</p>
                <h3 class="font-heading font-black text-3xl text-navy mt-1">{{ $stats['total_inquiries'] }}</h3>
                <p class="text-[11px] text-cyan-600 font-semibold mt-1">
                    <i class="fa-solid fa-bell"></i> {{ $stats['unread_inquiries'] }} Pending Review
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-brand-cyan flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-cart-flatbed"></i>
            </div>
        </div>

        <!-- Contact Messages -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Contact Messages</p>
                <h3 class="font-heading font-black text-3xl text-navy mt-1">{{ $stats['total_messages'] }}</h3>
                <p class="text-[11px] text-rose-600 font-semibold mt-1">
                    <i class="fa-solid fa-envelope"></i> {{ $stats['unread_messages'] }} Unread
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-message"></i>
            </div>
        </div>

        <!-- Blog Articles -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Articles & Journal</p>
                <h3 class="font-heading font-black text-3xl text-navy mt-1">{{ $stats['published_blogs'] }}</h3>
                <p class="text-[11px] text-slate-500 font-semibold mt-1">
                    {{ $stats['draft_blogs'] }} Drafts in Editorial
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl shadow-sm">
                <i class="fa-solid fa-newspaper"></i>
            </div>
        </div>

    </div>

    <!-- Charts & Distribution Row -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
        
        <!-- Left: Category Distribution -->
        <div class="lg:col-span-6 bg-white rounded-3xl p-6 lg:p-8 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="font-heading font-bold text-base text-navy flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-brand-blue"></i>
                    <span>Category Formulation Distribution</span>
                </h3>
                <span class="text-xs font-bold text-slate-400">{{ $stats['total_categories'] }} Categories</span>
            </div>

            <div class="space-y-4 pt-2">
                @php
                    $maxCount = max(array_values($categoryDistribution) ?: [1]);
                @endphp
                @foreach($categoryDistribution as $catName => $count)
                    @php
                        $pct = $maxCount > 0 ? round(($count / $maxCount) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span>{{ $catName }}</span>
                            <span class="text-brand-blue font-extrabold">{{ $count }} Products</span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-brand-blue to-brand-cyan rounded-full transition-all duration-1000" style="width: {{ $pct }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Fast Actions & Plant Info -->
        <div class="lg:col-span-6 bg-white rounded-3xl p-6 lg:p-8 border border-slate-200/80 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="font-heading font-bold text-base text-navy flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-amber-500"></i>
                    <span>Quick Management Actions</span>
                </h3>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.products.create') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-brand-blue hover:text-white transition group border border-slate-150">
                    <i class="fa-solid fa-plus-circle text-brand-blue group-hover:text-white text-lg mb-2"></i>
                    <p class="font-bold text-xs text-navy group-hover:text-white">Add New Product</p>
                    <p class="text-[10px] text-slate-400 group-hover:text-blue-100 mt-0.5">Upload specs & gallery</p>
                </a>

                <a href="{{ route('admin.blogs.create') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-brand-blue hover:text-white transition group border border-slate-150">
                    <i class="fa-solid fa-pen-nib text-brand-scientific group-hover:text-white text-lg mb-2"></i>
                    <p class="font-bold text-xs text-navy group-hover:text-white">Publish Article</p>
                    <p class="text-[10px] text-slate-400 group-hover:text-blue-100 mt-0.5">News & lab insights</p>
                </a>

                <a href="{{ route('admin.inquiries.index') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-brand-blue hover:text-white transition group border border-slate-150">
                    <i class="fa-solid fa-inbox text-cyan-600 group-hover:text-white text-lg mb-2"></i>
                    <p class="font-bold text-xs text-navy group-hover:text-white">Manage Inquiries</p>
                    <p class="text-[10px] text-slate-400 group-hover:text-blue-100 mt-0.5">{{ $stats['unread_inquiries'] }} pending reply</p>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-brand-blue hover:text-white transition group border border-slate-150">
                    <i class="fa-solid fa-sliders text-slate-600 group-hover:text-white text-lg mb-2"></i>
                    <p class="font-bold text-xs text-navy group-hover:text-white">Site Settings</p>
                    <p class="text-[10px] text-slate-400 group-hover:text-blue-100 mt-0.5">Phones, logos & factory</p>
                </a>
            </div>

            <!-- Plant Info Mini Banner -->
            <div class="p-4 rounded-2xl bg-navy text-white text-xs space-y-1">
                <div class="flex items-center gap-2 text-brand-cyan font-bold">
                    <i class="fa-solid fa-industry"></i>
                    <span>Savar Manufacturing Facility</span>
                </div>
                <p class="text-slate-300 text-[11px]">Location: Genda, Savar, Dhaka-1340, Bangladesh. Concern of Adonis Group.</p>
            </div>
        </div>

    </div>

    <!-- Recent Inquiries & Messages Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Recent Inquiries -->
        <div class="lg:col-span-6 bg-white rounded-3xl p-6 lg:p-8 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="font-heading font-bold text-base text-navy flex items-center gap-2">
                    <i class="fa-solid fa-cart-flatbed text-brand-cyan"></i>
                    <span>Recent Product Inquiries</span>
                </h3>
                <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-bold text-brand-blue hover:underline">View All</a>
            </div>

            @if($recentInquiries->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($recentInquiries as $inq)
                        <div class="py-3 flex items-center justify-between">
                            <div class="min-w-0 pr-3">
                                <p class="text-xs font-bold text-navy truncate">{{ $inq->name }} <span class="text-slate-400 font-normal">({{ $inq->company ?: 'Individual' }})</span></p>
                                <p class="text-[11px] text-brand-blue truncate">{{ $inq->product_name ?: ($inq->product->name ?? 'General Inquiry') }}</p>
                                <p class="text-[10px] text-slate-400">{{ $inq->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $inq->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ ucfirst($inq->status) }}
                                </span>
                                <a href="{{ route('admin.inquiries.show', $inq->id) }}" class="p-1.5 rounded-lg bg-slate-100 hover:bg-brand-blue hover:text-white text-slate-600 transition text-xs">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 py-4 text-center">No recent product inquiries received yet.</p>
            @endif
        </div>

        <!-- Recent Contact Messages -->
        <div class="lg:col-span-6 bg-white rounded-3xl p-6 lg:p-8 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="font-heading font-bold text-base text-navy flex items-center gap-2">
                    <i class="fa-solid fa-envelope text-rose-500"></i>
                    <span>Recent Contact Messages</span>
                </h3>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-bold text-brand-blue hover:underline">View All</a>
            </div>

            @if($recentMessages->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($recentMessages as $msg)
                        <div class="py-3 flex items-center justify-between">
                            <div class="min-w-0 pr-3">
                                <p class="text-xs font-bold text-navy truncate">{{ $msg->name }}</p>
                                <p class="text-[11px] text-slate-600 truncate">{{ $msg->subject ?: 'Website Inquiry' }}</p>
                                <p class="text-[10px] text-slate-400">{{ $msg->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $msg->status === 'new' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($msg->status) }}
                                </span>
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="p-1.5 rounded-lg bg-slate-100 hover:bg-brand-blue hover:text-white text-slate-600 transition text-xs">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 py-4 text-center">No recent messages received yet.</p>
            @endif
        </div>

    </div>

@endsection
