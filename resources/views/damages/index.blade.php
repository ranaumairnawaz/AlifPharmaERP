@extends('layouts.app')

@section('content')
    <div class="space-y-8 pb-10">
        <!-- Header Command Bar -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                    <h2 class="text-[10px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-widest font-sans">
                        Loss Control Center</h2>
                </div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight leading-none">Damage Ledger</h1>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">Audit of production damage and
                    packing material recovery credit.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('damages.create') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-rose-600 px-8 py-4 text-[10px] font-black text-white shadow-xl shadow-rose-600/20 hover:bg-rose-500 transition-all active:scale-[0.98] uppercase tracking-[0.2em]">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    File Damage Report
                </a>
            </div>
        </div>

        <!-- Data Hub Container -->
        <div
            class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr
                            class="bg-slate-50/50 dark:bg-slate-800/30 text-slate-400 border-b border-slate-100 dark:border-slate-800 uppercase text-[9px] tracking-widest font-black">
                            <th class="py-5 px-8">Production Item</th>
                            <th class="py-5 px-4 text-center">Qty Loss</th>
                            <th class="py-5 px-6">Recovery Details</th>
                            <th class="py-5 px-4">Audit Date</th>
                            <th class="py-5 px-8 text-right">Filed By</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($reports as $report)
                            <tr class="hover:bg-slate-50/30 dark:hover:bg-slate-800/20 transition-colors group">
                                <td class="py-6 px-8">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-bold text-slate-900 dark:text-white text-sm mb-1 group-hover:text-rose-600 transition-colors">{{ $report->product->name }}</span>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-[9px] font-black text-slate-400 bg-slate-50 dark:bg-slate-800 px-2 py-0.5 rounded uppercase">Batch:
                                                #{{ $report->batch->batch_number ?? '---' }}</span>
                                            <span
                                                class="text-[9px] font-bold text-rose-500 italic opacity-80">{{ Str::limit($report->reason, 30) ?: 'Production Damage' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-6 px-4 text-center">
                                    <span
                                        class="inline-flex items-center justify-center min-w-[3rem] px-3 py-1.5 rounded-xl bg-rose-50 dark:bg-rose-900/20 text-rose-600 font-bold text-sm border border-rose-100 dark:border-rose-800">
                                        {{ number_format($report->quantity) }}
                                    </span>
                                </td>
                                <td class="py-6 px-6">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($report->items as $item)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-lg text-[8px] font-black bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 uppercase tracking-widest">
                                                +{{ number_format($item->quantity_returned) }} {{ $item->product->name }}
                                            </span>
                                        @empty
                                            <span
                                                class="text-[9px] text-slate-400 font-bold uppercase tracking-widest italic opacity-50">No
                                                recovery data</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="py-6 px-4">
                                    <div
                                        class="text-[10px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">
                                        {{ $report->created_at->format('M d, Y') }}</div>
                                    <div class="text-[9px] text-slate-400 mt-1 uppercase italic tracking-tighter opacity-60">
                                        {{ $report->created_at->format('H:i') }} PST</div>
                                </td>
                                <td class="py-6 px-8 text-right">
                                    <div
                                        class="inline-flex items-center gap-2 text-[9px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] bg-slate-50 dark:bg-slate-800 px-4 py-1.5 rounded-full border border-slate-100 dark:border-slate-800 shadow-sm">
                                        <svg class="h-3 w-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ $report->user->name ?? 'SYSTEM' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-32 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="h-16 w-16 rounded-3xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                                            <svg class="h-8 w-8 text-slate-200 dark:text-slate-700" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-400 italic text-sm tracking-tight font-medium">Clear inventory
                                            cycles: zero damage reports filed in this range.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($reports->hasPages())
                <div class="px-8 py-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50/20">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection