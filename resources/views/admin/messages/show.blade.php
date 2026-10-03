@extends('layouts.admin')

@section('page_title', 'Message Details')
@section('page_subtitle', 'View sender message and update status')

@section('content')

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.messages.index') }}" class="text-xs font-bold text-slate-500 hover:text-brand-blue flex items-center gap-1.5 transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Messages</span>
        </a>

        <div class="flex items-center gap-2">
            <a href="mailto:{{ $message->email }}?subject={{ urlencode('Re: ' . $message->subject) }}" class="btn-scientific-primary text-xs !py-2 !px-4">
                <i class="fa-solid fa-reply"></i>
                <span>Reply via Email</span>
            </a>
            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Delete message?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Message Body -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
                
                <div class="flex items-start justify-between border-b border-slate-100 pb-6 mb-6">
                    <div>
                        <h2 class="text-xl font-black text-navy">{{ $message->subject }}</h2>
                        <div class="text-xs text-slate-400 mt-1">
                            Received on {{ $message->created_at->format('F d, Y \a\t h:i A') }} ({{ $message->created_at->diffForHumans() }})
                        </div>
                    </div>
                    <div>
                        @if($message->status === 'new')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-cyan-100 text-cyan-800">New Message</span>
                        @elseif($message->status === 'replied')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Replied</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">Archived</span>
                        @endif
                    </div>
                </div>

                <div class="text-slate-800 text-sm leading-relaxed whitespace-pre-line bg-slate-50/50 p-6 rounded-2xl border border-slate-100 font-sans">
                    {{ $message->message }}
                </div>

                @if($message->admin_notes)
                    <div class="mt-6 p-4 rounded-2xl bg-amber-50/70 border border-amber-200/60 text-xs">
                        <div class="font-bold text-amber-900 mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-note-sticky text-amber-600"></i>
                            <span>Internal Admin Notes</span>
                        </div>
                        <p class="text-amber-800 whitespace-pre-line">{{ $message->admin_notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Sender Details & Status Update Form -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Sender Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="font-bold text-navy text-sm mb-4">Sender Information</h3>
                
                <div class="space-y-4 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Full Name</span>
                        <div class="font-bold text-navy text-sm mt-0.5">{{ $message->name }}</div>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Email Address</span>
                        <a href="mailto:{{ $message->email }}" class="font-bold text-brand-blue hover:underline block mt-0.5">{{ $message->email }}</a>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Phone / Mobile</span>
                        <div class="font-semibold text-slate-700 mt-0.5">{{ $message->phone ?: 'Not provided' }}</div>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">Company / Organization</span>
                        <div class="font-semibold text-slate-700 mt-0.5">{{ $message->company ?: 'Not provided' }}</div>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold tracking-wider">IP Address</span>
                        <div class="font-mono text-slate-500 mt-0.5 text-[11px]">{{ $message->ip_address ?: 'Unknown' }}</div>
                    </div>
                </div>
            </div>

            <!-- Update Status Card -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="font-bold text-navy text-sm mb-4">Manage Status & Notes</h3>

                <form action="{{ route('admin.messages.status', $message->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Status</label>
                        <select name="status" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                            <option value="new" {{ $message->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="replied" {{ $message->status === 'replied' ? 'selected' : '' }}>Replied</option>
                            <option value="archived" {{ $message->status === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Internal Notes</label>
                        <textarea name="admin_notes" rows="3" placeholder="Add follow-up notes, phone call logs, or assignments..." class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">{{ $message->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="btn-scientific-primary w-full text-xs !py-2.5 justify-center">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Update Message</span>
                    </button>
                </form>
            </div>

        </div>

    </div>

@endsection
