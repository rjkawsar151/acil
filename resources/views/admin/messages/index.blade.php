@extends('layouts.admin')

@section('page_title', 'Contact Messages & Inquiries')
@section('page_subtitle', 'Direct corporate communications and partner requests received via public contact form')

@section('content')

    <!-- Top Filter & Search Bar -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !$status ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                All ({{ $messages->total() }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'new']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $status === 'new' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <span>New / Unread</span>
                @if($unreadCount > 0)
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-rose-500 text-white font-bold">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'replied' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Replied
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'archived']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'archived' ? 'bg-brand-blue text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Archived
            </a>
        </div>

        <form action="{{ route('admin.messages.index') }}" method="GET" class="w-full sm:w-auto">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search messages..." class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none w-full sm:w-64">
            </div>
        </form>
    </div>

    <!-- Messages Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">Sender</th>
                        <th class="py-4 px-4">Subject & Excerpt</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-4 text-right">Received Date</th>
                        <th class="py-4 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/80 transition {{ !$msg->is_read ? 'bg-cyan-50/30 font-semibold' : '' }}">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs uppercase {{ !$msg->is_read ? 'bg-brand-blue text-white shadow-sm' : 'bg-slate-100 text-slate-600' }}">
                                        {{ substr($msg->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-navy flex items-center gap-1.5">
                                            <span>{{ $msg->name }}</span>
                                            @if(!$msg->is_read)
                                                <span class="w-2 h-2 rounded-full bg-cyan-accent animate-pulse"></span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-400">
                                            {{ $msg->email }}
                                            @if($msg->company) &bull; <span class="text-slate-600">{{ $msg->company }}</span> @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-navy text-xs">{{ $msg->subject }}</div>
                                <p class="text-[11px] text-slate-500 line-clamp-1 max-w-md font-normal mt-0.5">
                                    {{ $msg->message }}
                                </p>
                            </td>
                            <td class="py-4 px-4 text-center">
                                @if($msg->status === 'new')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-cyan-100 text-cyan-800">New</span>
                                @elseif($msg->status === 'replied')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Replied</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Archived</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right whitespace-nowrap text-slate-400 text-[11px]">
                                {{ $msg->created_at->format('M d, Y') }}<br>
                                <span class="text-[10px]">{{ $msg->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap space-x-1">
                                <a href="{{ route('admin.messages.show', $msg->id) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-brand-blue hover:text-white transition font-bold text-slate-700 text-xs inline-flex items-center gap-1">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>View</span>
                                </a>
                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Delete this message permanently?')">
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
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-envelope-open text-3xl mb-2 text-slate-300 block"></i>
                                No messages matching your filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

@endsection
