@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2
                    class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em] mb-1 italic underline decoration-teal-500/30">
                    Strategic Procurement</h2>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter">Material Logistics Hub</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('materials.create') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-teal-600 px-8 py-4 text-xs font-black text-white shadow-xl shadow-teal-600/30 hover:bg-teal-500 transition-all active:scale-[0.98] uppercase tracking-widest group">
                    Register New Manifest
                    <svg class="ml-4 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            </div>
        </div>
        <!-- Data Table -->
        <div
            class="bg-white rounded-[2.5rem] border border-slate-200 shadow-2xl shadow-slate-200/50 overflow-hidden font-sans">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Manifest #</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Origin / Source</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Timestamp</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Assets Included</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Payment Status</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                                Total Valuation</th>
                            <th
                                class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($entries as $entry)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6">
                                    <span
                                        class="text-xs font-black text-slate-900 tracking-tighter group-hover:text-teal-600 transition-colors">{{ $entry->slip_number }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-8 w-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-xs font-bold text-slate-700 tracking-tight">{{ $entry->source }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-xs font-medium text-slate-500 italic">
                                    {{ $entry->transaction_date->format('M d, Y') }}
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="px-3 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-widest border border-indigo-100">
                                        {{ $entry->stockMovements->count() }} Products
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $statusConfig = [
                                            'paid' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'Paid'],
                                            'partial' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => 'Partial'],
                                            'pending' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'label' => 'Pending'],
                                        ];
                                        $conf = $statusConfig[$entry->payment_status ?? 'pending'];
                                    @endphp
                                    <span class="px-3 py-1 rounded-lg {{ $conf['bg'] }} {{ $conf['text'] }} {{ $conf['border'] }} text-[9px] font-black uppercase tracking-widest border">
                                        {{ $conf['label'] }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-black text-slate-900 tracking-tighter">Rs.
                                        {{ number_format($entry->total_amount, 2) }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div
                                        class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                        <a href="{{ route('materials.show', $entry) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-600 transition-colors"
                                            title="Detailed Audit">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('materials.pdf', $entry) }}" target="_blank"
                                            class="p-2 text-slate-400 hover:text-rose-600 transition-colors"
                                            title="Export Manifest PDF">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection