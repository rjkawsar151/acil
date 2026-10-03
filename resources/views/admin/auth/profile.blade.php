@extends('layouts.admin')

@section('page_title', 'Staff Profile & Security')
@section('page_subtitle', 'Manage your administrator details and password')

@section('content')

    <div class="max-w-4xl space-y-8">
        
        <!-- Profile Details Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm">
            <h3 class="font-heading font-bold text-lg text-navy mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-user-gear text-brand-blue"></i>
                <span>Personal Information</span>
            </h3>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-6">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-2xl object-cover border-2 border-brand-light shadow-md">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Change Avatar</label>
                        <input type="file" name="avatar" accept="image/*" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-light file:text-brand-blue hover:file:bg-brand-blue hover:file:text-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Assigned Role</label>
                        <input type="text" value="{{ $user->role->name ?? 'Administrator' }}" disabled class="w-full px-4 py-3 text-sm rounded-xl bg-slate-50 border border-slate-200 text-slate-500 cursor-not-allowed">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-scientific-primary text-xs !py-3 !px-6">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Save Profile Changes</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Change Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm">
            <h3 class="font-heading font-bold text-lg text-navy mb-6 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-lock text-brand-scientific"></i>
                <span>Update Password</span>
            </h3>

            <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Current Password *</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue max-w-md">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">New Password *</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Confirm New Password *</label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-blue">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-scientific-outline-dark text-xs !py-3 !px-6">
                        <i class="fa-solid fa-key"></i>
                        <span>Update Password</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

@endsection
