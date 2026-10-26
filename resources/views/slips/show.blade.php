@extends('layouts.app')

@section('content')
    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div
                    class="h-16 w-16 bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl flex items-center justify-center border border-slate-100 dark:border-slate-800">
                    <svg class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">{{ $slip->slip_number }}
                    </h1>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Logistics Dispatch
                            Registry</span>
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                        <span
                            class="text-[10px] font-black text-teal-600 uppercase tracking-widest">{{ $slip->transaction_date->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('slips.pdf', $slip->id) }}" target="_blank"
                    class="flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 font-bold text-xs uppercase tracking-widest rounded-2xl border border-slate-200 dark:border-slate-800 hover:shadow-lg transition-all active:scale-95 group">
                    <svg class="h-4 w-4 text-teal-600 group-hover:scale-110 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Chalan
                </a>
                @if(!$slip->is_net_invoiced || !$slip->is_warranty_invoiced)
                    <a href="{{ route('slips.edit', $slip->id) }}"
                        class="flex items-center gap-2 px-6 py-3 bg-teal-600 text-white font-bold text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-teal-500/20 hover:bg-teal-700 hover:shadow-teal-500/40 transition-all active:scale-95">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Slip
                    </a>
                @endif
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Partner Card -->
            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:shadow-xl transition-all duration-500">
                <div class="relative z-10">
                    <h3
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <svg class="h-3 w-3 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        Distributor Info
                    </h3>
                    <div class="space-y-1">
                        <p
                            class="text-xl font-black text-slate-900 dark:text-white leading-tight group-hover:text-teal-600 transition-colors">
                            {{ $slip->distributor->name }}</p>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500">Primary Logistics Partner</p>
                    </div>
                    <div class="mt-8 grid grid-cols-2 gap-4 pt-6 border-t border-slate-50 dark:border-slate-800">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-tight">Status</p>
                            <span
                                class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                {{ $slip->status }}
                            </span>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-tight">Items</p>
                            <p class="text-base font-black text-slate-700 dark:text-slate-300">{{ $slip->items->count() }}
                                SKUs</p>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:opacity-[0.05] group-hover:scale-110 transition-all duration-700">
                    <svg class="h-48 w-48" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                    </svg>
                </div>
            </div>

            <!-- Invoicing Card -->
            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 shadow-sm border border-slate-100 dark:border-slate-800 flex flex-col justify-between hover:shadow-xl transition-all duration-500">
                <div>
                    <h3
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <svg class="h-3 w-3 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                            <path fill-rule="evenodd"
                                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Ledger Links
                    </h3>
                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Net Sales
                                Status</span>
                            <span
                                class="text-[10px] font-black {{ $slip->is_net_invoiced ? 'text-emerald-600' : 'text-rose-500' }} uppercase tracking-widest">
                                {{ $slip->is_net_invoiced ? 'Invoiced ✓' : 'Pending Action' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($slip->invoices->count() > 0)
                    <div class="mt-4">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Attached Documents</p>
                        @foreach($slip->invoices as $invoice)
                            <a href="{{ route('invoices.show', $invoice->id) }}"
                                class="inline-flex items-center gap-2 text-xs font-black text-teal-600 hover:text-teal-700 transition-colors uppercase tracking-widest border-b-2 border-teal-50 dark:border-teal-900/30 hover:border-teal-500 pb-0.5">
                                {{ $invoice->invoice_number }}
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Meta Summary Card -->
            <div class="bg-slate-900 dark:bg-slate-800 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden group">
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Dispatch Volume
                        </h3>
                        <p class="text-4xl font-black text-white tracking-widest">
                            {{ number_format($slip->items->sum('quantity')) }}</p>
                        <p class="text-[10px] font-bold text-teal-400 uppercase tracking-[0.3em] mt-1">Total Unit Dispersal
                        </p>
                    </div>
                    <div class="pt-6 border-t border-white/10 mt-6 md:mt-0">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Protocol Check</p>
                        <p class="text-xs font-bold text-white uppercase italic tracking-tighter mt-1 opacity-80">Manifest
                            Verified & Secured</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div
            class="bg-white dark:bg-slate-900 rounded-[3rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="px-10 py-6 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Inventory Manifest</h3>
                <span
                    class="px-3 py-1 rounded-full bg-slate-50 dark:bg-slate-800 text-[9px] font-black text-slate-500 uppercase tracking-widest">Real-time
                    Stock Impact</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                            <th class="px-10 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest">Product /
                                Brand</th>
                            <th
                                class="px-10 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest text-center">
                                Batch Mapping</th>
                            <th
                                class="px-10 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest text-right">
                                Quantity</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @foreach($slip->items as $item)
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-all duration-300">
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-5">
                                        <div
                                            class="h-10 w-10 bg-slate-50 dark:bg-slate-800 flex items-center justify-center rounded-xl text-slate-400 group-hover:bg-teal-50 group-hover:text-teal-600 transition-all border border-slate-100 dark:border-slate-700 group-hover:border-teal-500">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-black text-slate-900 dark:text-white group-hover:text-teal-600 transition-colors">
                                                {{ $item->product->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                                                {{ $item->product->brand->name ?? 'Standard' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-6 text-center">
                                    <span
                                        class="text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest italic">—
                                        Standard Lot —</span>
                                </td>
                                <td class="px-10 py-6 text-right font-mono">
                                    <span
                                        class="text-base font-black text-slate-900 dark:text-white tabular-nums">{{ number_format($item->quantity) }}</span>
                                    <span
                                        class="text-[9px] font-black text-slate-400 uppercase ml-1">{{ $item->product->unit->name }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($slip->notes)
                <div class="px-10 py-8 bg-slate-50/30 dark:bg-slate-800/30 border-t border-slate-50 dark:border-slate-800">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Auditor Ledger Notes
                    </p>
                    <p
                        class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed italic border-l-4 border-teal-500 pl-6 py-1 bg-white/50 dark:bg-slate-900/50 rounded-r-2xl">
                        {{ $slip->notes }}
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection