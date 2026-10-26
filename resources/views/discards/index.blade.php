@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight underline decoration-rose-500/20 italic">Stock Waste & Rejected Goods Hub</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-sans tracking-wide">Precise tracking of damaged packaging and rejected production batches.</p>
    </div>
    
    <div class="mt-4 sm:ml-16 sm:mt-0 flex items-center gap-3">
        <a href="{{ route('discards.create') }}" class="inline-flex items-center justify-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-black text-white shadow-lg hover:bg-rose-500 transition-all active:scale-95 uppercase tracking-widest">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Log Production Rejection
        </a>
    </div>
</div>

<div class="bg-white dark:bg-slate-900 shadow-xl shadow-slate-200/50 dark:shadow-none rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto font-sans">
        <table class="w-full text-left text-sm border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 border-b border-slate-200 uppercase text-[9px] tracking-[0.2em] font-black">
                    <th class="py-4 px-8" style="width: 15%">Timestamp</th>
                    <th class="py-4 px-4" style="width: 30%">Product / Batch Reference</th>
                    <th class="py-4 px-4 text-center" style="width: 15%">Quantity</th>
                    <th class="py-4 px-4" style="width: 15%">Type / Vector</th>
                    <th class="py-4 px-4" style="width: 15%">Reason</th>
                    <th class="py-4 pr-8 text-right" style="width: 10%">Log Entry By</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($discards as $discard)
                    <tr class="hover:bg-rose-50/20 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="py-4 px-8">
                            <div class="font-bold text-slate-900 dark:text-slate-100 tracking-tight">{{ $discard->created_at->format('M d, Y') }}</div>
                            <div class="text-[9px] text-slate-400 uppercase font-black tracking-widest">{{ $discard->created_at->format('H:i T') }}</div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-black text-slate-900 dark:text-white uppercase tracking-tight">{{ $discard->product->name }}</div>
                            @if($discard->batch_id)
                                <div class="text-[10px] font-black text-indigo-500 uppercase tracking-widest italic flex items-center mt-0.5">
                                    <span class="mr-1">Batch:</span> #{{ $discard->batch->batch_number }}
                                </div>
                            @else
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic flex items-center mt-0.5">
                                    Raw/Packaging Stock
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-rose-50 text-rose-700 border border-rose-100 shadow-sm">
                                -{{ number_format($discard->quantity) }}
                                <span class="ml-1 text-[9px] font-bold opacity-70">{{ $discard->product->unit->name ?? 'PCS' }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            @if($discard->type === 'damaged_packaging')
                                <span class="bg-amber-100 text-amber-800 text-[9px] font-black px-2 py-1 rounded-lg tracking-widest uppercase">Damaged Packaging</span>
                            @else
                                <span class="bg-rose-100 text-rose-800 text-[9px] font-black px-2 py-1 rounded-lg tracking-widest uppercase">Batch Rejection</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="text-xs text-slate-600 dark:text-slate-400 italic max-w-[200px] truncate group-hover:whitespace-normal group-hover:break-words">
                                {{ $discard->reason }}
                            </div>
                        </td>
                        <td class="py-4 pr-8 text-right font-bold text-slate-900">
                             {{ $discard->user->name ?? 'System' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="h-12 w-12 text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                <p class="text-slate-400 italic text-sm">No inventory discards or rejections reported.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
