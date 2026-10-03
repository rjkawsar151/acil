@extends('layouts.admin')

@section('page_title', 'Edit User: ' . $user->name)
@section('page_subtitle', 'Update administrator profile, system permissions, and password')

@section('content')

    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-slate-500 hover:text-brand-blue flex items-center gap-1.5 transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Users</span>
            </a>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm space-y-6 text-xs">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-navy mb-1.5">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Email Address (Login ID) *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">New Password (Leave blank to keep current)</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-navy mb-1.5">Contact Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-bold text-navy mb-1.5">System Role *</label>
                        <select name="role_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue outline-none">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id === $role->id ? 'selected' : '' }}>
                                    {{ $role->name }} &bull; {{ $role->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-brand-blue focus:ring-brand-blue">
                    <label for="is_active" class="font-bold text-slate-700">Account Active (Permit Login)</label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="btn-scientific-primary text-xs !py-2.5 !px-6">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Update User</span>
                    </button>
                </div>

            </div>
        </form>
    </div>

@endsection
