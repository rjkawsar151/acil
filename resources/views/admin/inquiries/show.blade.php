@extends('layouts.admin')

@section('page_title', 'Product Inquiry Details')
@section('page_subtitle', 'Review commercial and technical requirements for quotation')

@section('content')

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-bold text-slate-500 hover:text-brand-blue flex items-center gap-1.5 transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Inquiries</span>
        </a>

        <div class="flex items-center gap-2">
            <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Regarding your inquiry for ' . ($inquiry->product ? $inquiry->product->name : $inquiry->product_name) . ' - Adonis Chemical') }}" class="btn-scientific-primary text-xs !py-2 !px-4">
                <i class="fa-solid fa-paper-plane"></i>
                <span>Send Quotation / Reply</span>
            </a>
            <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Delete inquiry?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Product & Inquiry Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Requested Product Box -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Chemical Product of Interest</h3>
                
                @if($inquiry->product)
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <img src="{{ $inquiry->product->primary_image_url }}" alt="{{ $inquiry->product->name }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200">
                        <div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-brand-blue/10 text-brand-blue uppercase">{{ $inquiry->product->category->name ?? 'SINODA' }}</span>
                            <h4 class="font-bold text-navy text-base mt-1">{{ $inquiry->product->name }}</h4>
                            <p class="text-xs text-slate-500 font-mono">Code: {{ $inquiry->product->code }}</p>
                            <a href="{{ route('products.show', $inquiry->product->slug) }}" target="_blank" class="text-xs text-brand-blue hover:underline font-bold inline-flex items-center gap-1 mt-2">
                                <span>View Public Spec Sheet</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <h4 class="font-bold text-navy text-base">{{ $inquiry->product_name ?: 'General Chemical Inquiry' }}</h4>
                        <p class="text-xs text-slate-400">Custom formulation or uncataloged chemical request</p>
                    </div>
                @endif
            </div>

            <!-- Inquiry Requirements -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                    <div>
                        <h3 class="font-bold text-navy text-base">Inquiry Specifications</h3>
                        <p class="text-xs text-slate-400">Submitted {{ $inquiry->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-bold block text-right">Required Volume</span>
                        <span class="text-sm font-black text-navy">{{ $inquiry->quantity ?: 'Custom / Not Specified' }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Client Requirements & Message</label>
                    <div class="p-6 rounded-2xl bg-slate-50/70 border border-slate-100 text-slate-800 text-sm leading-relaxed whitespace-pre-line">
                        {{ $inquiry->message ?: 'No additional message provided.' }}
                    </div>
                </div>

                @if($inquiry->admin_notes)
                    <div class="mt-6 p-4 rounded-2xl bg-amber-50 border border-amber-200/60 text-xs">
                        <div class="font-bold text-amber-900 mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-clipboard-list text-amber-600"></i>
                            <span>Admin Handling Notes</span>
                        </div>
                        <p class="text-amber-800 whitespace-pre-line">{{ $inquiry->admin_notes }}</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- Right: Client Profile & Workflow Actions -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Client Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="font-bold text-navy text-sm mb-4">Contact Information</h3>
                
                <div class="space-y-4 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Contact Person</span>
                        <div class="font-bold text-navy text-sm mt-0.5">{{ $inquiry->name }}</div>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Company / Industry</span>
                        <div class="font-semibold text-slate-700 mt-0.5">{{ $inquiry->company ?: 'Not provided' }}</div>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Email</span>
                        <a href="mailto:{{ $inquiry->email }}" class="font-bold text-brand-blue hover:underline block mt-0.5">{{ $inquiry->email }}</a>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Phone / WhatsApp</span>
                        <div class="font-semibold text-slate-700 mt-0.5">{{ $inquiry->phone ?: 'Not provided' }}</div>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Submission IP</span>
                        <div class="font-mono text-slate-500 mt-0.5 text-[11px]">{{ $inquiry->ip_address ?: 'Unknown' }}</div>
                    </div>
                </div>
            </div>

            <!-- Status Manager -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="font-bold text-navy text-sm mb-4">Commercial Pipeline Status</h3>

                <form action="{{ route('admin.inquiries.status', $inquiry->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Pipeline Stage</label>
                        <select name="status" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                            <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>Pending Initial Review</option>
                            <option value="in_review" {{ $inquiry->status === 'in_review' ? 'selected' : '' }}>In Review / Lab Formulation</option>
                            <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>Contacted / Quotation Sent</option>
                            <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>Deal Closed / Complete</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Quote / Discussion Notes</label>
                        <textarea name="admin_notes" rows="4" placeholder="Quoted price, MOQ discussed, lab sample dispatch date, delivery terms..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">{{ $inquiry->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="btn-scientific-primary w-full text-xs !py-2.5 justify-center">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Update Pipeline Status</span>
                    </button>
                </form>
            </div>

        </div>

    </div>

@endsection
