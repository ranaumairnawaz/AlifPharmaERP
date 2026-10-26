@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-10 text-center uppercase tracking-widest">
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-colors mb-4 group">
            <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3"/></svg>
            Staff Governance Hub
        </a>
        <h2 class="text-[10px] font-bold text-teal-600 mb-1">Access Authority Update</h2>
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Modify Professional Role</h1>
    </div>

    <!-- Identity Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden relative group">
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-teal-500 via-indigo-500 to-teal-500 transition-transform group-hover:scale-x-110"></div>
        
        <div class="p-8 sm:p-12">
            <div class="flex flex-col items-center mb-10">
                <div class="h-20 w-20 rounded-2xl bg-slate-50 flex items-center justify-center text-2xl font-black text-slate-300 ring-4 ring-slate-50 shadow-inner mb-4 transition-transform group-hover:rotate-3">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h3 class="text-lg font-bold text-slate-900 uppercase tracking-wide">{{ $user->name }}</h3>
                <p class="text-xs font-semibold text-slate-400 italic lowercase">{{ $user->email }}</p>
                
                <div class="mt-4 inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-slate-100 text-slate-500 ring-1 ring-slate-200">
                    Current: {{ $user->role }}
                </div>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 text-center">Select New Authority Level</label>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($roles as $role)
                        <label class="relative flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white p-6 cursor-pointer hover:border-teal-300 hover:bg-teal-50/50 transition-all group/role ring-teal-500 focus-within:ring-2 has-checked:border-teal-600 has-checked:bg-teal-50">
                            <input type="radio" name="role" value="{{ $role->slug }}" class="sr-only" {{ $user->role === $role->slug ? 'checked' : '' }}>
                            <div class="h-8 w-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center mb-3 group-hover/role:scale-110 transition-transform">
                                @if($role->slug === 'admin')
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                @elseif($role->slug === 'manager')
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                @else
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                @endif
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">{{ $role->name }}</span>
                            <span class="text-[8px] text-slate-400 font-bold mt-1 text-center leading-tight">Authority Level</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-col gap-4">
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-slate-900 px-6 py-4 text-xs font-black text-white shadow-xl shadow-slate-900/10 hover:bg-slate-800 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn">
                        Commit Authorization Change
                        <svg class="ml-3 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                    <a href="{{ route('users.index') }}" class="w-full inline-flex items-center justify-center rounded-xl bg-white border border-slate-200 px-6 py-4 text-[10px] font-black text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-all uppercase tracking-[0.15em]">
                        Cancel Operation
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Security Warning -->
    <div class="mt-8 flex items-start gap-4 p-6 bg-rose-50 rounded-2xl border border-rose-100 italic transition-all hover:bg-rose-100/50">
        <svg class="h-5 w-5 text-rose-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <div>
            <h4 class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-1 italic underline">Operational Protocol Alert</h4>
            <p class="text-[10px] text-rose-500/80 font-bold leading-relaxed">
                Modifying authority levels affects real-time system accessibility. Promoting users to 'Admin' grants destructive capabilities over master data. Ensure the identity is verified.
            </p>
        </div>
    </div>
</div>

<style>
    /* Styling for the radio buttons using 'has-checked' logic or custom selectors */
    label:has(input[type="radio"]:checked) {
        border-color: currentColor;
    }
</style>
@endsection
