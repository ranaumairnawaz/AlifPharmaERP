@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
        <div>
            <h2 class="text-[10px] font-bold text-teal-600 uppercase tracking-[0.25em] mb-2 px-1 underline italic">Personal Identity</h2>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">Identity Management Hub</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium italic mt-1 leading-relaxed">Manage your digital presence and security credentials within the Alif Pharma system.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-8 p-4 bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-900/50 rounded-2xl">
            <ul class="list-disc list-inside text-xs font-bold text-rose-600 dark:text-rose-400 space-y-1 uppercase tracking-tight">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Personal Information -->
            <div class="lg:col-span-12">
                <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none overflow-hidden">
                    <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-xl bg-teal-600 text-white flex items-center justify-center shadow-lg shadow-teal-500/20">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <h3 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Profile Specification</h3>
                    </div>
                    
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 px-1">Full Legal Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-700 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all shadow-inner dark:shadow-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 px-1">Corporate Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-700 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all shadow-inner dark:shadow-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Credentials -->
            <div class="lg:col-span-12">
                <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none overflow-hidden">
                    <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center gap-3">
                        <div class="h-8 w-8 rounded-xl bg-orange-600 text-white flex items-center justify-center shadow-lg shadow-orange-500/20">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <h3 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Security Protocol Overlay</h3>
                    </div>
                    
                    <div class="p-8 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-2">
                             <div>
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 px-1">New Security Password</label>
                                <input type="password" name="new_password" autocomplete="new-password" placeholder="Leave blank to maintain current"
                                    class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-700 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-orange-500 focus:border-orange-500 transition-all shadow-inner dark:shadow-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 px-1">Confirm Security Handshake</label>
                                <input type="password" name="new_password_confirmation" autocomplete="new-password" placeholder="Re-type new password"
                                    class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-700 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-orange-500 focus:border-orange-500 transition-all shadow-inner dark:shadow-none">
                            </div>
                        </div>

                        <div class="pt-8 border-t border-slate-50 dark:border-slate-800">
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] mb-4 text-center italic">IDENTITY VERIFICATION REQUIRED FOR SENSITIVE CHANGES</label>
                            <div class="max-w-md mx-auto relative group">
                                <input type="password" name="current_password" placeholder="Current Password"
                                    class="block w-full rounded-2xl border-rose-200 dark:border-rose-900/50 py-4 px-6 text-sm font-bold text-slate-900 dark:text-white bg-rose-50/30 dark:bg-rose-900/10 focus:ring-rose-500 focus:border-rose-500 transition-all text-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center pt-4">
            <button type="submit" class="w-full md:w-auto px-16 h-14 rounded-2xl bg-teal-600 text-white font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-teal-500/30 hover:bg-teal-500 transition-all active:scale-[0.98] outline-none">
                Synchronize Identity & Security
            </button>
        </div>
    </form>
</div>
@endsection
