@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-20">
    <!-- Premium Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h2 class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-[0.3em] mb-2 px-1">Financial Reconciliation Hub</h2>
            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter">Payroll Audit Ledger</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium italic mt-1 font-sans">Historical disbursement records and automated salary settlements for {{ $branding['name'] }}.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('salaries.process') }}" 
                class="h-12 px-8 flex items-center bg-indigo-600 hover:bg-indigo-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                Generate Monthly Payroll
            </a>
        </div>
    </div>

    <!-- Disbursement Ledger Table -->
    <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
        <table class="w-full text-left border-collapse border-spacing-0">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Payment Cycle</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Personnel</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Base Salary</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Deductions/Adj</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Settled Amount</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Instruments</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($payments as $payment)
                    <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <span class="text-sm font-black text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse($payment->payment_month)->format('M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div>
                                <h4 class="text-sm font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ $payment->employee->name }}</h4>
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-widest uppercase mt-1">{{ $payment->employee->employee_id }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-slate-500">Rs. {{ number_format($payment->base_salary, 0) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                @if($payment->off_days > 0)
                                    <span class="text-[9px] font-black text-rose-500 uppercase tracking-tight">- Rs. {{ number_format($payment->off_days_deduction, 0) }} ({{ $payment->off_days }} days)</span>
                                @endif
                                @if($payment->manual_adjustment != 0)
                                    <span class="text-[9px] font-black uppercase tracking-tight {{ $payment->manual_adjustment > 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                                        {{ $payment->manual_adjustment > 0 ? '+' : '-' }} Rs. {{ number_format(abs($payment->manual_adjustment), 0) }} 
                                        @if($payment->adjustment_note) <span class="text-slate-400 italic">({{ $payment->adjustment_note }})</span> @endif
                                    </span>
                                @endif
                                @if($payment->off_days == 0 && $payment->manual_adjustment == 0)
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Full Disbursement</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-black text-indigo-600 dark:text-indigo-400">Rs. {{ number_format($payment->net_salary, 0) }}</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('salaries.slip', $payment) }}" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all text-[9px] font-black uppercase tracking-widest border border-slate-100 dark:border-slate-800 hover:border-indigo-100 dark:hover:border-indigo-900/50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                Download Slip
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="h-20 w-20 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-200">
                                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <p class="text-sm font-black text-slate-300 uppercase tracking-widest">No financial disbursement records identified.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($payments->hasPages())
            <div class="px-8 py-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 font-sans">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
