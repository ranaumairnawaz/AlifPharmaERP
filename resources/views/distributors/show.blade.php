@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 font-sans">
    <!-- Header -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <a href="{{ route('distributors.index') }}"
                class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-indigo-600 transition-all uppercase tracking-[0.2em] mb-4 group">
                <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7V3" />
                </svg>
                Partner Ecosystem
            </a>
            <h2 class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-1 italic">Distributor
                Intelligence</h2>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter">
                {{ $distributor->company_name ?? $distributor->name }}
            </h1>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('distributors.pdf', $distributor) }}" target="_blank"
                class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-8 py-4 text-xs font-black text-white shadow-xl shadow-indigo-600/30 hover:bg-indigo-500 transition-all active:scale-[0.98] uppercase tracking-widest group">
                Export Branded Profile
                <svg class="ml-4 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </a>
            @canEdit('distributors')
            <a href="{{ route('distributors.edit', $distributor) }}"
                class="inline-flex items-center justify-center rounded-2xl bg-white border border-slate-200 px-8 py-4 text-xs font-black text-slate-700 shadow-sm hover:bg-slate-50 transition-all active:scale-[0.98] uppercase tracking-widest group">
                Edit Entity
            </a>
            @endcanEdit
        </div>
    </div>

    <!-- Financial Core Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div
            class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl shadow-slate-200/20 col-span-1 md:col-span-2 flex flex-col justify-between relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 p-8 text-indigo-50 transition-transform duration-500 group-hover:scale-110">
                <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 20 20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 relative z-10">Lifetime
                    Value (LTV)</p>
                <h3 class="text-4xl font-black text-indigo-600 tracking-tighter italic relative z-10">Rs.
                    {{ number_format($stats['total_invoiced'], 2) }}
                </h3>
            </div>
            <p class="text-[9px] font-bold text-slate-400 mt-4 uppercase tracking-[0.2em] relative z-10">Total Invoiced
                (Net Sales)</p>
        </div>

        <div
            class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl shadow-slate-200/20 flex flex-col justify-between">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 text-rose-500">Capital
                    Exposure</p>
                <h3 class="text-2xl font-black text-rose-600 tracking-tighter">Rs.
                    {{ number_format($stats['total_pending'], 2) }}
                </h3>
            </div>
            <p class="text-[8px] font-bold text-rose-400 mt-4 uppercase tracking-[0.2em]">Pending Receivables</p>
        </div>

        <div
            class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl shadow-slate-200/20 flex flex-col justify-between">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 text-emerald-500">Cleared
                    Assets</p>
                <h3 class="text-2xl font-black text-emerald-600 tracking-tighter">Rs.
                    {{ number_format($stats['total_paid'], 2) }}
                </h3>
            </div>
            <p class="text-[8px] font-bold text-emerald-400 mt-4 uppercase tracking-[0.2em]">Liquidated Capital</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Contact Identity -->
        <div
            class="bg-white rounded-[2.5rem] p-8 border border-slate-200 shadow-xl shadow-slate-200/20 lg:col-span-1 h-max">
            <h3
                class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 border-b border-slate-100 pb-4">
                Corporate Identity</h3>

            <div class="space-y-6">
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Primary Contact
                        Person</p>
                    <p class="text-sm font-black text-slate-900 tracking-tight">
                        {{ $distributor->contact_name ?? 'Not Specified' }}
                    </p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Geographic
                        Designation</p>
                    <p class="text-sm font-black text-slate-900 tracking-tight">{{ $distributor->area }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Direct Communication
                    </p>
                    <p class="text-sm font-black text-slate-600 font-mono">{{ $distributor->phone ?? 'Not Specified' }}
                    </p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Registered Logistics
                        Node</p>
                    <p class="text-xs font-bold text-slate-600 leading-relaxed">
                        {{ $distributor->street_address }}<br>{{ $distributor->city }}
                    </p>
                </div>
                <div class="pt-6 border-t border-slate-100">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Logistics Frequency
                    </p>
                    <p class="text-sm font-black text-slate-900 tracking-tight">{{ $stats['total_dcs'] }} Delivery
                        Challans</p>
                </div>
            </div>
        </div>

        <!-- Ledger View -->
        <div
            class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/20 col-span-2 lg:col-span-2 overflow-hidden flex flex-col h-full">
            <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Transaction Ledger</h3>
                <span
                    class="inline-flex items-center px-2 py-1 rounded-md text-[8px] font-black bg-indigo-100 text-indigo-700 uppercase tracking-widest">{{ $invoices->count() }}
                    Invoices</span>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-slate-100">
                            <th class="px-4 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest">Inv # /
                                DC #</th>
                            <th
                                class="px-4 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest hidden sm:table-cell">
                                Type / Date</th>
                            <th
                                class="px-4 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest text-right">
                                Valuation</th>
                            <th
                                class="px-4 py-4 text-[9px] font-black text-slate-400 uppercase tracking-widest text-right">
                                Status</th>
                            <th
                                class="px-4 py-4 text-center text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                A</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($invoices->sortByDesc('created_at') as $invoice)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-black text-slate-900">{{ $invoice->invoice_number }}</span>
                                        <a href="{{ route('slips.show', $invoice->inventory_slip_id) }}"
                                            class="text-[9px] font-bold text-indigo-500 hover:text-indigo-600 hover:underline uppercase tracking-widest mt-0.5 truncate max-w-[100px]">DC:
                                            #{{ $invoice->slip->slip_number }}</a>
                                    </div>
                                </td>
                                <td class="px-4 py-4 hidden sm:table-cell">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] font-black {{ $invoice->type === 'net' ? 'text-teal-600' : 'text-amber-600' }} uppercase tracking-widest mb-1">{{ $invoice->type }}</span>
                                        <span
                                            class="text-[9px] text-slate-400 uppercase font-bold">{{ $invoice->created_at->format('d M, Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-xs font-black text-slate-900 tracking-tighter">Rs.
                                        {{ number_format($invoice->grand_total, 2) }}</span>
                                    @if($invoice->type === 'net' && $invoice->payment_status !== 'paid')
                                        <p class="text-[8px] font-bold text-rose-500 uppercase tracking-widest mt-1">Due:
                                            {{ number_format($invoice->remainingBalance(), 0) }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right">
                                    @if($invoice->type === 'net')
                                        @if($invoice->payment_status === 'paid')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[8px] font-black bg-emerald-100 text-emerald-800 uppercase tracking-widest">Paid</span>
                                        @elseif($invoice->payment_status === 'partial')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[8px] font-black bg-amber-100 text-amber-800 uppercase tracking-widest">Partial</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[8px] font-black bg-rose-100 text-rose-800 uppercase tracking-widest">Pending</span>
                                        @endif
                                    @else
                                        <span class="text-[8px] font-bold text-slate-300 uppercase italic">N/A</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('invoices.show', $invoice) }}"
                                        class="inline-flex p-1.5 bg-slate-100 hover:bg-indigo-100 text-slate-400 hover:text-indigo-600 rounded-md transition-colors"
                                        title="View Invoice">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-12 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">
                                    No transaction history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection