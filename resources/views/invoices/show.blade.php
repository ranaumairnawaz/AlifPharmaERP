@extends('layouts.app')

@section('content')
    <div class="px-6 py-8 max-w-7xl mx-auto">
        <!-- Breadcrumbs & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('invoices.index') }}"
                        class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-colors uppercase tracking-widest">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Registry Hub
                    </a>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white uppercase tracking-tight leading-none mb-1">
                    Financial Breakdown</h2>
                <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400">Detailed audit and settlement status
                    for invoice #{{ $invoice->invoice_number }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('invoices.pdf', $invoice) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-900 border border-rose-200 dark:border-rose-900/30 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 text-[10px] font-bold rounded-xl transition-all shadow-sm active:scale-95 uppercase tracking-widest">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Generate PDF
                </a>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- 2/3 COLUMN: PRODUCTS & DETAILS -->
            <div class="w-full lg:w-2/3 space-y-6">
                <!-- Product Manifest Table -->
                <div
                    class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden text-center">
                    <div
                        class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center text-left">
                        <div class="flex items-center gap-3">
                            <div
                                class="h-10 w-10 rounded-xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 flex items-center justify-center border border-teal-100 dark:border-teal-800">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-800 dark:text-white uppercase tracking-tight">
                                    Product Manifest</h3>
                                <p class="text-[9px] text-slate-400 uppercase font-bold tracking-widest">Billing cycle
                                    summary</p>
                            </div>
                        </div>
                        <span
                            class="px-3 py-1 rounded-lg text-[9px] font-bold {{ $invoice->type === 'net' ? 'bg-teal-100 text-teal-700' : 'bg-amber-100 text-amber-700' }} uppercase tracking-widest border {{ $invoice->type === 'net' ? 'border-teal-200' : 'border-amber-200' }}">
                            {{ $invoice->type }} Type
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr
                                    class="text-[9px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50">
                                    <th class="px-8 py-4">Item Description</th>
                                    <th class="px-6 py-4 text-center">Qty</th>
                                    <th class="px-6 py-4 text-right">Unit Price</th>
                                    <th class="px-8 py-4 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                @foreach($invoice->items as $item)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                        <td class="px-8 py-4 text-left">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-bold text-slate-800 dark:text-white leading-none mb-1">{{ $item->product->name }}</span>
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ $item->product->category->name ?? 'Misc' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs border border-slate-200 dark:border-slate-700">
                                                {{ number_format($item->quantity) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-right font-medium text-slate-500 dark:text-slate-400 text-xs tabular-nums">
                                            Rs.{{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td class="px-8 py-4 text-right font-bold text-slate-900 dark:text-white tabular-nums">
                                            Rs.{{ number_format($item->total_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Additional Detail Sections -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Logistic Remark -->
                    <div
                        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Logistic Notes</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 italic font-medium leading-relaxed">
                            {{ $invoice->notes ?? 'No internal modifications recorded for this cycle.' }}
                        </p>
                    </div>

                    <!-- Partner Branding Section -->
                    <div
                        class="bg-indigo-50/30 dark:bg-indigo-900/10 rounded-3xl border border-indigo-100 dark:border-indigo-900/30 p-8 flex flex-col justify-between">
                        <div>
                            <h4 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-4">Partner
                                Identity</h4>
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="h-12 w-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold text-xl shadow-lg shadow-indigo-600/20">
                                    {{ substr($invoice->slip->distributor->name, 0, 1) }}
                                </div>
                                <div>
                                    <p
                                        class="text-base font-bold text-slate-900 dark:text-white leading-none mb-1.5 tracking-tight">
                                        {{ $invoice->slip->distributor->name }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Official
                                        Partner</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between pt-4 border-t border-indigo-100 dark:border-indigo-900/50">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">PM:
                                {{ $invoice->projectManager->name ?? 'None' }}</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">DC:
                                #{{ $invoice->slip->slip_number }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1/3 COLUMN: REVENUE HUB -->
            <div class="w-full lg:w-1/3 space-y-6">
                <!-- Revenue Analysis Block -->
                <div
                    class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm text-center">
                    <h4
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 dark:border-slate-800 pb-4 text-left">
                        Revenue Analysis
                    </h4>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-400 font-bold uppercase tracking-widest">Booked Total</span>
                            <span
                                class="font-bold text-slate-800 dark:text-white leading-none">Rs.{{ number_format($invoice->grand_total, 2) }}</span>
                        </div>

                        @if($invoice->isNet())
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-emerald-500 font-bold uppercase tracking-widest">Cash Recovered</span>
                                <span
                                    class="font-bold text-emerald-600 leading-none">Rs.{{ number_format($invoice->paid_amount, 2) }}</span>
                            </div>
                            <div class="h-px bg-slate-100 dark:bg-slate-800 my-2"></div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Balance Due</span>
                                <span
                                    class="text-2xl font-black {{ $invoice->remainingBalance() > 0 ? 'text-rose-500' : 'text-emerald-500' }} tracking-tighter tabular-nums leading-none">Rs.{{ number_format($invoice->remainingBalance(), 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Settlement Hub -->
                @if($invoice->isNet())
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm overflow-hidden"
                        x-data="{ status: '{{ $invoice->payment_status }}' }">
                        <h4
                            class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                            Record Settlement</h4>

                        <form action="{{ route('invoices.update-status', $invoice) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <div>
                                <div
                                    class="grid grid-cols-3 gap-1 p-1 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
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
                                <label
                                    class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Received
                                    Settlement (Rs.)</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 font-bold text-xs">
                                        Rs.</div>
                                    <input type="number" step="0.01" name="paid_amount" value="{{ $invoice->paid_amount }}"
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 pl-10 pr-4 text-sm font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition-all outline-none"
                                        placeholder="0.00">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-slate-900 dark:bg-emerald-600 hover:bg-slate-800 dark:hover:bg-emerald-500 text-white text-[10px] font-black rounded-xl transition-all shadow-lg active:scale-[0.98] uppercase tracking-widest">
                                Apply Update
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Metadata Shell -->
                <div
                    class="bg-slate-50 dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 space-y-4">
                    <div class="flex justify-between items-center text-[9px] font-bold uppercase tracking-widest">
                        <span class="text-slate-400">Created At</span>
                        <span class="text-slate-800 dark:text-white">{{ $invoice->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($invoice->due_date)
                        <div class="flex justify-between items-center text-[9px] font-bold uppercase tracking-widest">
                            <span class="text-rose-500 font-black">Soft Deadline</span>
                            <span
                                class="text-rose-500 font-black px-2 py-0.5 bg-rose-50 dark:bg-rose-900/20 rounded-lg">{{ $invoice->due_date->format('d M, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection