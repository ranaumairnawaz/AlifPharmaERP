@extends('layouts.app')

@section('content')
<!-- Glassmorphic Mesh Background Layer -->
<div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none opacity-40 dark:opacity-20 transition-opacity duration-1000">
    <div class="absolute top-[-20%] right-[-10%] w-[60%] h-[60%] rounded-full bg-teal-500/10 blur-[150px] animate-pulse"></div>
    <div class="absolute bottom-[-10%] left-[-20%] w-[50%] h-[50%] rounded-full bg-indigo-500/10 blur-[120px] animate-pulse delay-1000"></div>
</div>

<div class="max-w-4xl mx-auto pb-20 animate-in fade-in slide-in-from-bottom-8 duration-1000 px-6">
    <!-- Executive Header Strategy (Glass Hub) -->
    <div class="flex flex-col items-center text-center mb-16 relative">
        <div class="h-16 w-16 bg-white/50 dark:bg-slate-900/40 backdrop-blur-2xl rounded-3xl flex items-center justify-center mb-8 border border-white/50 dark:border-slate-800 shadow-xl shadow-slate-200/20">
            <svg class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        </div>
        <h2 class="text-[10px] font-black text-teal-600 dark:text-teal-400 uppercase tracking-[0.6em] mb-4">Strategic Onboarding Protocol</h2>
        <h1 class="text-6xl font-black text-slate-900 dark:text-white tracking-tighter leading-none mb-6">Forge Personnel Entry</h1>
        <p class="max-w-md text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-relaxed opacity-70">
            Equip the Alif Pharma operational matrix with high-performance staff assets. Precision data integrity is non-negotiable.
        </p>
    </div>

    <!-- Glossy Personnel Manifest Form -->
    <div class="backdrop-blur-3xl bg-white/70 dark:bg-slate-900/40 rounded-[3.5rem] border border-white/50 dark:border-slate-800/50 shadow-[0_50px_100px_-30px_rgba(0,0,0,0.1)] p-12 md:p-16 lg:p-20 relative overflow-hidden group">
        <!-- Abstract Decoration Vector -->
        <div class="absolute -right-32 -bottom-32 opacity-[0.03] group-hover:rotate-45 transition-transform duration-[4000ms] select-none pointer-events-none text-teal-600">
            <svg class="h-[32rem] w-[32rem]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
        </div>

        <form action="{{ route('employees.store') }}" method="POST" class="space-y-16 relative z-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
                <!-- Identity Section Hub Header -->
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-4">
                            <div class="h-2 w-2 rounded-full bg-teal-500 shadow-[0_0_15px_rgba(20,184,166,0.8)]"></div>
                            <h3 class="text-[11px] font-black text-slate-900 dark:text-white uppercase tracking-[0.4em]">Primary Identity Data</h3>
                        </div>
                        <span class="text-[9px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest">Protocol Check: 10%</span>
                    </div>
                    <div class="h-[1px] w-full bg-gradient-to-r from-teal-500/20 via-slate-100 dark:via-slate-800 to-transparent"></div>
                </div>

                <!-- Input Name Matrix -->
                <div class="space-y-4 group/field">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-2 group-focus-within/field:text-teal-600 transition-colors">Personnel Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Salman Alif"
                        class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 py-5 px-8 text-sm font-bold text-slate-800 dark:text-white bg-white/40 dark:bg-white/5 backdrop-blur-md focus:ring-[12px] focus:ring-teal-500/5 focus:border-teal-500/50 transition-all shadow-sm placeholder:text-slate-300 dark:placeholder:text-slate-700">
                </div>

                <!-- Input Email Matrix -->
                <div class="space-y-4 group/field">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-2 group-focus-within/field:text-teal-600 transition-colors">Digital Discovery Mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="it.admin@alifpharma.com"
                        class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 py-5 px-8 text-sm font-bold text-slate-800 dark:text-white bg-white/40 dark:bg-white/5 backdrop-blur-md focus:ring-[12px] focus:ring-teal-500/5 focus:border-teal-500/50 transition-all shadow-sm placeholder:text-slate-300 dark:placeholder:text-slate-700">
                </div>

                <!-- Metrics Section Hub Header -->
                <div class="md:col-span-2 pt-8">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-4">
                            <div class="h-2 w-2 rounded-full bg-indigo-500 shadow-[0_0_15px_rgba(99,102,241,0.8)]"></div>
                            <h3 class="text-[11px] font-black text-slate-900 dark:text-white uppercase tracking-[0.4em]">Operational Allocation</h3>
                        </div>
                        <span class="text-[9px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest">Protocol Check: 35%</span>
                    </div>
                    <div class="h-[1px] w-full bg-gradient-to-r from-indigo-500/20 via-slate-100 dark:via-slate-800 to-transparent"></div>
                </div>

                <!-- Input Designation Matrix -->
                <div class="space-y-4 group/field">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-2 group-focus-within/field:text-indigo-600 transition-colors">Staff Designation Role</label>
                    <input type="text" name="designation" value="{{ old('designation') }}" placeholder="e.g. Accounts Chief"
                        class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 py-5 px-8 text-sm font-bold text-slate-800 dark:text-white bg-white/40 dark:bg-white/5 backdrop-blur-md focus:ring-[12px] focus:ring-indigo-500/5 focus:border-indigo-500/50 transition-all shadow-sm placeholder:text-slate-300 dark:placeholder:text-slate-700">
                </div>

                <!-- Input Salary Matrix -->
                <div class="space-y-4 group/field">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-2 group-focus-within/field:text-indigo-600 transition-colors">Base Retention Compensation</label>
                    <div class="relative group/input">
                        <input type="number" name="base_salary" value="{{ old('base_salary', 0) }}" min="0" required
                            class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 py-5 px-8 text-sm font-black text-indigo-600 dark:text-indigo-400 bg-white/40 dark:bg-white/5 backdrop-blur-md focus:ring-[12px] focus:ring-indigo-500/5 focus:border-indigo-500/50 transition-all shadow-sm tabular-nums">
                        <div class="absolute inset-y-0 right-0 pr-8 flex items-center pointer-events-none">
                            <span class="text-[10px] font-black text-slate-300 dark:text-slate-600 tracking-widest uppercase">PKR Currency</span>
                        </div>
                    </div>
                </div>

                <!-- Banking Infrastructure Header -->
                <div class="md:col-span-2 pt-8">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-4">
                            <div class="h-2 w-2 rounded-full bg-slate-400 shadow-[0_0_15px_rgba(203,213,225,0.8)]"></div>
                            <h3 class="text-[11px] font-black text-slate-900 dark:text-white uppercase tracking-[0.4em]">Financial Settlement Matrix</h3>
                        </div>
                        <span class="text-[9px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest">Protocol Check: 70%</span>
                    </div>
                    <div class="h-[1px] w-full bg-gradient-to-r from-slate-400/20 via-slate-100 dark:via-slate-800 to-transparent"></div>
                </div>

                <!-- Input Bank Name Matrix -->
                <div class="space-y-4 group/field">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-2 group-focus-within/field:text-teal-600 transition-colors">Institutional Bank Entity</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="e.g. Meezan Central Hub"
                        class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 py-5 px-8 text-sm font-bold text-slate-800 dark:text-white bg-white/40 dark:bg-white/5 backdrop-blur-md focus:ring-[12px] focus:ring-teal-500/5 focus:border-teal-500/50 transition-all shadow-sm placeholder:text-slate-300 dark:placeholder:text-slate-700">
                </div>

                <!-- Input Account Matrix -->
                <div class="space-y-4 group/field">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-2 group-focus-within/field:text-teal-600 transition-colors">Settlement Account Identity</label>
                    <input type="text" name="account_number" value="{{ old('account_number') }}" placeholder="0000-0000-0000"
                        class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 py-5 px-8 text-sm font-black text-slate-800 dark:text-white bg-white/40 dark:bg-white/5 backdrop-blur-md focus:ring-[12px] focus:ring-teal-500/5 focus:border-teal-500/50 transition-all shadow-sm font-mono tracking-widest">
                </div>

                <!-- Operational Lifecycle Header -->
                <div class="md:col-span-2 pt-8">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-4">
                            <div class="h-2 w-2 rounded-full bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.8)]"></div>
                            <h3 class="text-[11px] font-black text-slate-900 dark:text-white uppercase tracking-[0.4em]">Lifecycle Protocol Matrix</h3>
                        </div>
                        <span class="text-[9px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest">Protocol Integrity: 100%</span>
                    </div>
                    <div class="h-[1px] w-full bg-gradient-to-r from-emerald-500/20 via-slate-100 dark:via-slate-800 to-transparent"></div>
                </div>

                <!-- Input Start Date Matrix -->
                <div class="space-y-4 group/field">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-2 group-focus-within/field:text-emerald-600 transition-colors">Tenure Commencement Date</label>
                    <input type="date" name="joining_date" value="{{ old('joining_date', date('Y-m-d')) }}" required
                        class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 py-5 px-8 text-sm font-bold text-slate-800 dark:text-white bg-white/40 dark:bg-white/5 backdrop-blur-md focus:ring-[12px] focus:ring-emerald-500/5 focus:border-emerald-500/50 transition-all shadow-sm">
                </div>

                <!-- Input Status Matrix -->
                <div class="space-y-4 group/field">
                    <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-2 group-focus-within/field:text-emerald-600 transition-colors">Operational Status Protocol</label>
                    <div class="relative">
                        <select name="status" required
                            class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 py-5 px-8 text-sm font-black text-slate-800 dark:text-white bg-white/40 dark:bg-white/5 backdrop-blur-md focus:ring-[12px] focus:ring-emerald-500/5 focus:border-emerald-500/50 transition-all shadow-sm appearance-none cursor-pointer">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Institutional Active (Deployed)</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Probation / Pending Matrix (Archived)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-8 flex items-center pointer-events-none text-emerald-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Command Action Manifest -->
            <div class="pt-16 flex flex-col sm:flex-row gap-6">
                <button type="submit" class="group/btn flex-1 h-20 rounded-[2.5rem] bg-teal-600 text-white font-black text-xs uppercase tracking-[0.5em] shadow-2xl shadow-teal-500/30 hover:bg-teal-500 hover:scale-[1.02] active:scale-[0.98] transition-all border border-white/20">
                    <span class="group-hover/btn:tracking-[0.6em] transition-all block">Authorize Human Asset Entry</span>
                </button>
                <a href="{{ route('employees.index') }}" class="px-14 h-20 rounded-[2.5rem] bg-white/30 dark:bg-slate-800 border-2 border-white dark:border-slate-700 text-slate-400 hover:bg-white/50 hover:text-slate-600 transition-all flex items-center justify-center font-black text-xs uppercase tracking-widest text-center backdrop-blur-3xl">
                    Abort Protocol
                </a>
            </div>
        </form>
    </div>
</div>
@endsection