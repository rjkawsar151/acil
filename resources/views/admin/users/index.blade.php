@extends('layouts.admin')

@section('page_title', 'Administrators & User Access')
@section('page_subtitle', 'Manage administrative accounts, assigned RBAC roles, and portal credentials')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">
            Total Portal Users: <strong>{{ $users->total() }}</strong>
        </p>
        <a href="{{ route('admin.users.create') }}" class="btn-scientific-primary text-xs !py-2.5 !px-5">
            <i class="fa-solid fa-user-plus"></i>
            <span>Add Admin User</span>
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="py-4 px-6">User / Staff</th>
                        <th class="py-4 px-4">Role & Permissions</th>
                        <th class="py-4 px-4">Contact Phone</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-4 text-right">Created At</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($users as $usr)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-brand-blue/10 text-brand-blue flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($usr->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm text-navy flex items-center gap-2">
                                            <span>{{ $usr->name }}</span>
                                            @if($usr->id === auth()->id())
                                                <span class="px-1.5 py-0.2 rounded bg-cyan-100 text-cyan-800 text-[9px] font-bold">You</span>
                                            @endif
                                        </h4>
                                        <p class="text-[11px] text-slate-400">{{ $usr->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                @if($usr->role)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-navy text-white">
                                        {{ $usr->role->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400">No Role</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-slate-600 font-medium">
                                {{ $usr->phone ?: 'None' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $usr->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $usr->is_active ? 'Active' : 'Suspended' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right text-slate-400 text-[11px]">
                                {{ $usr->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap space-x-1">
                                <a href="{{ route('admin.users.edit', $usr->id) }}" class="p-2 rounded-lg text-slate-400 hover:text-brand-blue hover:bg-slate-100 transition inline-block">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if($usr->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $usr->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, 'Delete user {{ $usr->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

@endsection
