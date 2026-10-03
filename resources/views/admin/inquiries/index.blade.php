@extends('layouts.admin')

@section('page_title', 'Product Quote & Sample Inquiries')
@section('page_subtitle', 'B2B procurement requests, chemical formulation quotes, and bulk order inquiries')

@section('content')

    <!-- Top Filter Bar -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
            <a href="{{ route('admin.inquiries.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ !$status ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                All ({{ $inquiries->total() }})
            </a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $status === 'pending' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <span>Pending</span>
                @if($unreadCount > 0)
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-rose-500 text-white font-bold">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'in_review']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $status === 'in_review' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                In Review
            </a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'contacted']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $status === 'contacted' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Contacted
            </a>
            <a href="{{ route('admin.inquiries.index', ['status' => 'closed']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $status === 'closed' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Closed
            </a>
        </div>

        <!-- Search & Filter by Product -->
        <form action="{{ route('admin.inquiries.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif

            <select name="product_id" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none max-w-[180px]">
                <option value="">All Products</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ $productId == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>

            <div class="relative flex-1 md:w-56">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search client / product..." class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none w-full">
            </div>
        </form>
    </div>

    <!-- Inquiries Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Client / Company</th>
                        <th class="py-4 px-4">Chemical Product</th>
                        <th class="py-4 px-4 text-center">Req. Volume</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-4 text-right">Inquiry Date</th>
                        <th class="py-4 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($inquiries as $inq)
                        <tr class="hover:bg-slate-50/80 transition {{ !$inq->is_read ? 'bg-blue-50/30 font-semibold' : '' }}">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs uppercase {{ !$inq->is_read ? 'bg-cyan-accent text-navy shadow-sm' : 'bg-slate-100 text-slate-600' }}">
                                        {{ substr($inq->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-navy flex items-center gap-1.5">
                                            <span>{{ $inq->name }}</span>
                                            @if(!$inq->is_read)
                                                <span class="w-2 h-2 rounded-full bg-brand-blue animate-pulse"></span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-400">
                                            {{ $inq->company ?: $inq->email }} &bull; {{ $inq->phone ?: 'No phone' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                @if($inq->product)
                                    <a href="{{ route('admin.products.edit', $inq->product->id) }}" class="font-bold text-brand-blue hover:underline block">
                                        {{ $inq->product->name }}
                                    </a>
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $inq->product->code }}</span>
                                @else
                                    <span class="font-bold text-slate-800">{{ $inq->product_name ?: 'General Chemical Inquiry' }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center font-bold text-slate-700">
                                {{ $inq->quantity ?: 'N/A' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($inq->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Pending</span>
                                @elseif($inq->status === 'in_review')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-cyan-100 text-cyan-800">In Review</span>
                                @elseif($inq->status === 'contacted')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Contacted</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Closed</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right whitespace-nowrap text-slate-400 text-[11px]">
                                {{ $inq->created_at->format('M d, Y') }}<br>
                                <span class="text-[10px]">{{ $inq->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap space-x-1">
                                <a href="{{ route('admin.inquiries.show', $inq->id) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-brand-blue hover:text-white transition font-bold text-slate-700 text-xs inline-flex items-center gap-1">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>Details</span>
                                </a>
                                <form action="{{ route('admin.inquiries.destroy', $inq->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Delete this inquiry?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-file-invoice-dollar text-3xl mb-2 text-slate-300 block"></i>
                                No product inquiries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>

@endsection
