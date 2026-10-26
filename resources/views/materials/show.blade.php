@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <a href="{{ route('materials.index') }}"
                    class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-all uppercase tracking-[0.2em] mb-4 group">
                    <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7V3" />
                    </svg>
                    Logistics Hub
                </a>
                <h2
                    class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em] mb-1 italic underline decoration-teal-500/30">
                    Manifest Audit</h2>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter">Slip #{{ $entry->slip_number }}</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('materials.pdf', $entry) }}" target="_blank"
                    class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-8 py-4 text-xs font-black text-white shadow-xl shadow-slate-900/30 hover:bg-slate-800 transition-all active:scale-[0.98] uppercase tracking-widest group">
                    Download PDF Slip
                    <svg class="ml-4 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </a>
            </div>
        </div>

<div class="flex flex-col lg:flex-row gap-8 mb-12">
            <!-- 2/3 COLUMN: OVERVIEW & ITEMS -->
            <div class="w-full lg:w-2/3 space-y-6">
                <!-- Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-xl shadow-slate-200/40">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Origin / Source</p>
                        <p class="text-lg font-black text-slate-900 tracking-tight">{{ $entry->source }}</p>
                        <p class="text-[8px] font-bold text-slate-400 mt-2 uppercase italic">Verified Logistics Partner</p>
                    </div>
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-xl shadow-slate-200/40 border-t-4 border-t-teal-500 text-center md:text-left">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Execution Date</p>
                        <p class="text-lg font-black text-slate-900 tracking-tight">{{ $entry->transaction_date->format('F d, Y') }}</p>
                        <p class="text-[8px] font-bold text-teal-500 mt-2 uppercase italic tracking-widest">Temporal Log Registered</p>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
                    <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center text-left">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 flex items-center justify-center border border-teal-100 dark:border-teal-800">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-bold text-slate-800 dark:text-white uppercase tracking-tight leading-none mb-1">Asset Manifest</p>
                                <p class="text-[9px] text-slate-400 uppercase font-bold tracking-widest leading-none">Procurement details</p>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse font-sans">
                            <thead>
                                <tr class="bg-slate-50/20">
                                    <th class="px-8 py-5 text-[9px] font-black text-slate-400 uppercase border-b border-slate-100">ID</th>
                                    <th class="px-4 py-5 text-[9px] font-black text-slate-400 uppercase border-b border-slate-100">Product Designation</th>
                                    <th class="px-4 py-5 text-[9px] font-black text-slate-400 uppercase border-b border-slate-100 text-right">Expiry</th>
                                    <th class="px-4 py-5 text-[9px] font-black text-slate-400 uppercase border-b border-slate-100 text-right">Qty</th>
                                    <th class="px-4 py-5 text-[9px] font-black text-slate-400 uppercase border-b border-slate-100 text-right">Rate</th>
                                    <th class="px-8 py-5 text-[9px] font-black text-slate-400 uppercase border-b border-slate-100 text-right">Net Value</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($entry->stockMovements as $movement)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-5"><span class="text-[10px] font-black text-slate-300 tracking-widest uppercase">P-{{ str_pad($movement->product->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td class="px-4 py-5">
                                            <p class="text-xs font-black text-slate-800 tracking-tight mb-1">{{ $movement->product->name }}</p>
                                            @if($movement->lot_number)
                                                <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-500 text-[8px] font-bold uppercase tracking-widest italic border border-indigo-100">LOT# {{ $movement->lot_number }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-5 text-right">
                                            @if($movement->expiry_date)
                                                <span class="text-xs font-bold {{ $movement->expiry_date->isPast() ? 'text-rose-600' : 'text-slate-500' }} tracking-tighter">{{ $movement->expiry_date->format('M Y') }}</span>
                                            @else
                                                <span class="text-[10px] font-bold text-slate-300 italic">--</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-5 text-right">
                                            <span class="text-xs font-black text-slate-700 tracking-tighter">{{ number_format($movement->quantity, 2) }}</span>
                                            <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest ml-1">{{ $movement->product->unit->short_name ?? 'Units' }}</span>
                                        </td>
                                        <td class="px-4 py-5 text-right"><span class="text-xs font-bold text-slate-500">Rs. {{ number_format($movement->price_per_unit, 2) }}</span></td>
                                        <td class="px-8 py-5 text-right"><span class="text-xs font-black text-slate-900 tracking-tighter">Rs. {{ number_format($movement->quantity * $movement->price_per_unit, 2) }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Notes Section -->
                @if($entry->notes)
                    <div class="bg-amber-50/30 rounded-[2rem] p-8 border border-amber-100 text-center md:text-left">
                        <h3 class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-4 flex items-center justify-center md:justify-start gap-2">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Internal Observational Notes
                        </h3>
                        <p class="text-xs font-medium text-amber-800 leading-relaxed italic">"{{ $entry->notes }}"</p>
                    </div>
                @endif
            </div>

            <!-- 1/3 COLUMN: PAYMENTS & FINANCIALS -->
            <div class="w-full lg:w-1/3 space-y-6">
                <!-- Expense Analysis Block -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm text-center">
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 dark:border-slate-800 pb-4 text-left">
                        Expense Analysis
                    </h4>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-400 font-bold uppercase tracking-widest">Aggregate Valuation</span>
                            <span class="font-bold text-slate-800 dark:text-white leading-none">Rs.{{ number_format($entry->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-emerald-500 font-bold uppercase tracking-widest">Cash Paid Out</span>
                            <span class="font-bold text-emerald-600 leading-none">Rs.{{ number_format($entry->paid_amount, 2) }}</span>
                        </div>
                        <div class="h-px bg-slate-100 dark:bg-slate-800 my-2"></div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Balance Payable</span>
                            <span class="text-2xl font-black {{ $entry->remainingBalance() > 0 ? 'text-rose-500' : 'text-emerald-500' }} tracking-tighter tabular-nums leading-none">Rs.{{ number_format($entry->remainingBalance(), 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Settlement Hub -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm overflow-hidden" x-data="{ status: '{{ $entry->payment_status ?? "pending" }}' }">
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                        Record Settlement
                    </h4>

                    <form action="{{ route('materials.update-status', $entry) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <div class="grid grid-cols-3 gap-1 p-1 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                                <button type="button" @click="status = 'pending'"
                                    :class="status === 'pending' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm' : 'text-slate-400'"
                                    class="py-2 rounded-lg text-[9px] font-bold uppercase tracking-widest transition-all">Pending</button>
                                <button type="button" @click="status = 'partial'"
                                    :class="status === 'partial' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm' : 'text-slate-400'"
                                    class="py-2 rounded-lg text-[9px] font-bold uppercase tracking-widest transition-all">Partial</button>
                                <button type="button" @click="status = 'paid'"
                                    :class="status === 'paid' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm' : 'text-slate-400'"
                                    class="py-2 rounded-lg text-[9px] font-bold uppercase tracking-widest transition-all">Paid</button>
                            </div>
                            <input type="hidden" name="payment_status" :value="status">
                        </div>

                        <div x-show="status === 'partial'" x-transition.opacity>
                            <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Paid Settlement (Rs.)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 font-bold text-xs">Rs.</div>
                                <input type="number" step="0.01" name="paid_amount" value="{{ $entry->paid_amount }}"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 pl-10 pr-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition-all outline-none"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div x-show="status !== 'pending'" x-transition.opacity>
                            <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Payment Method</label>
                            <select name="payment_method" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition-all outline-none">
                                <option value="cash">Cash</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="cheque">Cheque</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full py-4 bg-slate-900 dark:bg-emerald-600 hover:bg-slate-800 dark:hover:bg-emerald-500 text-white text-[10px] font-black rounded-xl transition-all shadow-lg active:scale-[0.98] uppercase tracking-widest">
                            Apply Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection