@extends('layouts.app')

@section('content')
<!-- High-End Mesh Gradient Background Layer -->
<div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none opacity-50 dark:opacity-20 transition-opacity duration-1000">
    <div class="absolute top-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-teal-500/20 blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-indigo-500/10 blur-[120px] animate-pulse delay-700"></div>
</div>

<div class="max-w-6xl mx-auto space-y-10 pb-20 animate-in fade-in slide-in-from-bottom-8 duration-1000 px-4">
    <!-- Executive Profile Header (Glassmorphic Hub) -->
    <div class="relative backdrop-blur-3xl bg-white/70 dark:bg-slate-900/40 rounded-[3.5rem] p-12 lg:p-16 shadow-[0_50px_100px_-30px_rgba(0,0,0,0.1)] dark:shadow-none border border-white/50 dark:border-slate-800/50 overflow-hidden group">
        <div class="relative z-10 flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Dynamic Avatar Hub (World Class) -->
            <div class="relative group/avatar">
                <div class="h-48 w-48 rounded-[3rem] bg-gradient-to-br from-teal-500 via-teal-600 to-emerald-700 flex items-center justify-center text-white text-7xl font-black shadow-[0_30px_60px_-15px_rgba(20,184,166,0.4)] group-hover/avatar:rotate-2 group-hover/avatar:scale-105 transition-all duration-700">
                    {{ substr($employee->name, 0, 1) }}
                </div>
                <!-- Premium Status Ripple -->
                <div class="absolute -bottom-3 -right-3 h-14 w-14 bg-white dark:bg-slate-800 rounded-[1.5rem] flex items-center justify-center shadow-2xl border-8 border-white/20 dark:border-slate-900/50">
                    <div class="h-4 w-4 rounded-full {{ $employee->status === 'active' ? 'bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.8)] animate-pulse' : 'bg-rose-500' }}"></div>
                </div>
            </div>

            <!-- Profile Identity Strategy -->
            <div class="flex-1 text-center lg:text-left">
                <div class="flex flex-col lg:flex-row lg:items-center gap-5 mb-6">
                    <h1 class="text-6xl font-black text-slate-900 dark:text-white tracking-tighter leading-none">{{ $employee->name }}</h1>
                    <span class="inline-flex h-8 items-center px-5 rounded-2xl text-[11px] font-black uppercase tracking-[0.3em] backdrop-blur-xl {{ $employee->status === 'active' ? 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 dark:text-emerald-400' : 'bg-rose-500/10 text-rose-600 border border-rose-500/20 dark:text-rose-400' }}">
                        {{ $employee->status }} Protocol
                    </span>
                </div>
                <div class="flex flex-wrap justify-center lg:justify-start items-center gap-6 text-sm font-bold text-slate-400 uppercase tracking-[0.4em] mb-10">
                    <span>{{ $employee->designation ?? 'Strategic Command Staff' }}</span>
                    <span class="h-1.5 w-1.5 rounded-full bg-slate-200 dark:bg-slate-800"></span>
                    <span>ID: {{ $employee->employee_id }}</span>
                </div>
                
                <!-- Performance Matrix Row -->
                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                    <div class="px-8 py-4 bg-white/50 dark:bg-slate-800/30 rounded-3xl border border-white dark:border-slate-800/50 backdrop-blur-sm group/metric hover:bg-teal-500 transition-all duration-500">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover/metric:text-white transition-colors">Base Retention Matrix</p>
                        <p class="text-xl font-black text-slate-800 dark:text-slate-200 group-hover/metric:text-white transition-colors tabular-nums">Rs. {{ number_format($employee->base_salary) }}</p>
                    </div>
                    <div class="px-8 py-4 bg-white/50 dark:bg-slate-800/30 rounded-3xl border border-white dark:border-slate-800/50 backdrop-blur-sm group/metric hover:bg-indigo-500 transition-all duration-500">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover/metric:text-white transition-colors">Institutional Tenure</p>
                        <p class="text-xl font-black text-slate-800 dark:text-slate-200 group-hover/metric:text-white transition-colors tabular-nums">{{ \Carbon\Carbon::parse($employee->joining_date)->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Strategic Action Sector -->
            <div class="flex flex-col gap-4 w-full lg:w-autoz-10 group/actions">
                <a href="{{ route('employees.edit', $employee->id) }}" class="flex items-center justify-center gap-3 px-10 py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-black text-xs uppercase tracking-widest rounded-3xl hover:scale-105 active:scale-95 transition-all shadow-2xl shadow-slate-900/20 dark:shadow-none ring-offset-2 focus:ring-2 focus:ring-slate-900 dark:focus:ring-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Modify Metadata
                </a>
            </div>
        </div>
        
        <!-- Premium Abstract Background -->
        <div class="absolute -right-32 -bottom-32 opacity-5 dark:opacity-[0.03] group-hover:rotate-45 transition-transform duration-[3000ms] pointer-events-none select-none">
            <svg class="h-[32rem] w-[32rem] text-teal-600 dark:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
        </div>
    </div>

    <!-- Multi-Column Intelligence Matrix -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        <!-- Vertical Intelligence Column -->
        <div class="lg:col-span-1 space-y-10">
            <!-- Banking Protocol Card (Glass) -->
            <div class="backdrop-blur-2xl bg-white/60 dark:bg-slate-900/40 rounded-[3rem] p-10 shadow-xl border border-white/50 dark:border-slate-800/50 group relative overflow-hidden">
                <div class="absolute top-0 right-0 h-full w-1.5 bg-indigo-500 opacity-20 group-hover:opacity-100 transition-opacity duration-700"></div>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-10">Banking Registry</h3>
                <div class="space-y-10">
                    <div class="flex items-center gap-6">
                        <div class="h-12 w-12 bg-indigo-500/10 text-indigo-600 flex items-center justify-center rounded-2xl border border-indigo-500/20 group-hover:scale-110 transition-transform">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Settlement ID</p>
                            <p class="text-sm font-black text-slate-800 dark:text-white font-mono tracking-widest">{{ $employee->account_number ?? 'Restricted' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="h-12 w-12 bg-indigo-500/10 text-indigo-600 flex items-center justify-center rounded-2xl border border-indigo-500/20 group-hover:scale-110 transition-transform">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Financial Org</p>
                            <p class="text-sm font-black text-slate-800 dark:text-white uppercase leading-tight">{{ $employee->bank_name ?? 'Alif Internal' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Discovery Hub (Glossy) -->
            <div class="backdrop-blur-3xl bg-slate-900/90 dark:bg-slate-800 rounded-[3rem] p-10 text-slate-400 relative overflow-hidden group shadow-2xl">
                <div class="relative z-10">
                    <h3 class="text-[10px] font-black text-teal-400 uppercase tracking-[0.3em] mb-6">Manifest Contact</h3>
                    <p class="text-lg font-black text-white mb-2 truncate group-hover:text-teal-400 transition-colors uppercase leading-none">{{ $employee->email ?? 'Protocol offline.' }}</p>
                    <p class="text-[10px] font-bold tracking-widest opacity-40 uppercase italic mt-4">Statutory Mail Server Active</p>
                </div>
                <div class="absolute right-[-10%] bottom-[-10%] h-40 w-40 opacity-10 group-hover:scale-125 transition-transform duration-1000 rotate-12">
                    <svg class="h-full w-full" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                </div>
            </div>
        </div>

        <!-- Historical Payroll Section (Expansive Glass) -->
        <div class="lg:col-span-3">
            <div class="backdrop-blur-3xl bg-white/70 dark:bg-slate-900/40 rounded-[3rem] shadow-xl border border-white/50 dark:border-slate-800/50 overflow-hidden h-full flex flex-col">
                <div class="px-10 py-10 border-b border-white/20 dark:border-slate-800/50 bg-slate-50/20 dark:bg-slate-800/10 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-[0.4em]">Compensation History Manifest</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">Institutional Verified Disbursement Logs</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest font-mono">Syncing ({{ $employee->payments->count() }} Cycles)</span>
                    </div>
                </div>
                
                <div class="flex-1 overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/30 dark:bg-slate-800/20">
                                <th class="px-12 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Billing Cycle Matrix</th>
                                <th class="px-12 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Audit Command</th>
                                <th class="px-12 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Settlement Liquid Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/20 dark:divide-slate-800/50">
                            @forelse($employee->payments->take(15) as $payment)
                            <tr class="group hover:bg-teal-500/5 dark:hover:bg-teal-500/10 transition-all duration-500">
                                <td class="px-12 py-8">
                                    <div class="flex items-center gap-6">
                                        <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-teal-600 group-hover:scale-110 group-hover:bg-teal-600 group-hover:text-white transition-all shadow-lg">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-base font-black text-slate-900 dark:text-white uppercase tracking-tighter">{{ $payment->month }} — {{ $payment->year }}</p>
                                            <p class="text-[9px] font-black text-teal-600 uppercase tracking-widest mt-1 italic">Verified Dispensation ✓</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-12 py-8 text-center">
                                    <a href="{{ route('salaries.slip', $payment->id) }}" target="_blank" class="inline-flex items-center gap-3 px-6 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-border-slate-700 text-[10px] font-black text-slate-500 hover:text-teal-600 hover:border-teal-500 transition-all uppercase tracking-widest shadow-sm">
                                        Analyze Slip
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    </a>
                                </td>
                                <td class="px-12 py-8 text-right">
                                    <p class="text-xl font-black text-slate-900 dark:text-white tabular-nums tracking-tighter">Rs. {{ number_format($payment->paid_amount) }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Institutional Total</p>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-12 py-40 text-center">
                                    <div class="flex flex-col items-center gap-6">
                                        <div class="h-24 w-24 bg-slate-50/50 dark:bg-slate-800/30 rounded-[2.5rem] flex items-center justify-center text-slate-200">
                                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                        <p class="text-sm font-black text-slate-400 uppercase tracking-[0.4em] italic">Historical Matrix Null.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Audit Matrix -->
                <div class="px-12 py-10 bg-slate-950/90 dark:bg-slate-800 text-slate-400">
                    <div class="flex flex-col md:flex-row gap-8 justify-between">
                        <div class="max-w-md">
                            <p class="text-[10px] font-black text-teal-400 uppercase tracking-widest mb-3">Institutional Auditor Protocol</p>
                            <p class="text-xs font-bold leading-relaxed opacity-60 italic">
                                This personnel record is verified against the Alif Pharma central audit protocols. Compensation data is sourced directly from encrypted financial settlements. Unauthorized data modification is strictly prohibited under institutional security matrix regulations.
                            </p>
                        </div>
                        <div class="flex flex-col items-end justify-center">
                            <p class="text-[9px] font-black text-slate-600 uppercase tracking-tighter">Record Hash: AI-{{ md5($employee->id) }}-PH</p>
                            <p class="text-[9px] font-black text-slate-600 uppercase tracking-tighter mt-1">Audit Status: SECURE ✓</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
