@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-10 text-center uppercase tracking-widest">
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-colors mb-4 group font-sans">
            <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3"/></svg>
            Personnel Security Ledger
        </a>
        <h2 class="text-[10px] font-bold text-teal-600 mb-1">New Identity Onboarding</h2>
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Register Personnel</h1>
    </div>

    <!-- Registration Hub -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden relative group">
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-teal-500 via-emerald-500 to-teal-500 transition-transform group-hover:scale-x-110"></div>
        
        <div class="p-8 sm:p-12">
            <form action="{{ route('users.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Basic Identification -->
                <div class="space-y-6">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-4">A. Primary Identification</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 font-sans">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1 text-xs">Full Legal Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Uzair Khan"
                                class="block w-full rounded-xl border-slate-200 py-3 px-4 text-sm font-bold text-slate-800 bg-slate-50/50 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none">
                            @error('name') <p class="mt-1 text-[10px] text-rose-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1 text-xs">System Email/ID</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="staff@alifpharma.com"
                                class="block w-full rounded-xl border-slate-200 py-3 px-4 text-sm font-bold text-slate-800 bg-slate-50/50 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none">
                            @error('email') <p class="mt-1 text-[10px] text-rose-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Access & Credentials -->
                <div class="space-y-6">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-4">B. System Authorization</h3>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 px-1 text-center">Initial Authority Level</label>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($roles as $role)
                            <label class="relative flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white p-6 cursor-pointer hover:border-teal-300 hover:bg-teal-50/50 transition-all group/role has-checked:border-teal-600 has-checked:bg-teal-50 font-sans">
                                <input type="radio" name="role" value="{{ $role->slug }}" class="sr-only" {{ old('role', 'staff') === $role->slug ? 'checked' : '' }}>
                                <div class="h-8 w-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center mb-2 group-hover/role:scale-110 transition-transform">
                                    @if($role->slug === 'admin')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                    @elseif($role->slug === 'manager')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    @endif
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">{{ $role->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 font-sans">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1 text-xs">Security Key (Password)</label>
                            <input type="password" name="password" required placeholder="Minimum 8 characters"
                                class="block w-full rounded-xl border-slate-200 py-3 px-4 text-sm font-bold text-slate-800 bg-slate-50/50 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none">
                            @error('password') <p class="mt-1 text-[10px] text-rose-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1 text-xs">Verify Security Key</label>
                            <input type="password" name="password_confirmation" required placeholder="Retype password"
                                class="block w-full rounded-xl border-slate-200 py-3 px-4 text-sm font-bold text-slate-800 bg-slate-50/50 focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none">
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t border-slate-100 flex flex-col gap-4">
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-slate-900 px-6 py-4 text-xs font-black text-white shadow-xl shadow-slate-900/10 hover:bg-slate-800 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn">
                        Finalize Identity Creation
                        <svg class="ml-3 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
