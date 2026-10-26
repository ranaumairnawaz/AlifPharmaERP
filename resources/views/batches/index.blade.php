@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight underline decoration-indigo-500/20 italic">Production Batch Monitor</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-sans tracking-wide">Detailed tracking for all finished goods batches, initial stock, and expiry dates.</p>
    </div>
    
    <div class="mt-4 sm:ml-16 sm:mt-0 flex items-center gap-3">
        <a href="{{ route('batches.create') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-black text-white shadow-lg hover:bg-indigo-500 transition-all active:scale-95 uppercase tracking-widest">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Production Entry
        </a>
    </div>
</div>

<div class="bg-white dark:bg-slate-900 shadow-xl shadow-slate-200/50 dark:shadow-none rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto font-sans">
        <table class="w-full text-left text-sm border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 border-b border-slate-200 uppercase text-[9px] tracking-[0.3em] font-black">
                    <th class="py-5 px-10" style="width: 15%">Batch #</th>
                    <th class="py-5 px-4" style="width: 30%">Finished Good / Brand</th>
                    <th class="py-5 px-4 text-center" style="width: 10%">Produced</th>
                    <th class="py-5 px-4 text-center" style="width: 10%">Remaining</th>
                    <th class="py-5 px-4 text-center" style="width: 10%">Quarantined</th>
                    <th class="py-5 px-4" style="width: 15%">Expiry Date</th>
                    <th class="py-5 pr-10 text-right" style="width: 10%">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800" x-data="{ rejectionModal: false, selectedBatch: null, batchNumber: '' }">
                @forelse($batches as $batch)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="py-5 px-10">
                            <div class="font-black text-indigo-600 tracking-tighter text-base italic underline underline-offset-4 decoration-indigo-500/10">
                                #{{ $batch->batch_number }}
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-slate-900 dark:text-slate-100 uppercase tracking-tight">{{ $batch->product->name }}</div>
                            <div class="text-[10px] font-black text-slate-400 uppercase flex items-center mt-0.5">
                                <span class="text-indigo-500 mr-1.5 font-bold tracking-widest">{{ $batch->product->brand->name ?? 'ALIF PHARMA' }}</span>
                                @if($batch->current_quantity > 0)
                                    <button @click="rejectionModal = true; selectedBatch = {{ $batch->id }}; batchNumber = '{{ $batch->batch_number }}'" 
                                        class="ml-3 text-[9px] text-rose-500 hover:text-rose-700 font-black uppercase tracking-widest flex items-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                        Record Rejection
                                    </button>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center font-bold text-slate-500">
                            {{ number_format($batch->initial_quantity) }}
                        </td>
                        <td class="py-4 px-4 text-center">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black {{ $batch->current_quantity > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200' }} shadow-sm">
                                {{ number_format($batch->current_quantity) }} Left
                            </div>
                            <div class="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-wider">
                                {{ number_format($batch->initial_quantity - $batch->current_quantity) }}/{{ number_format($batch->initial_quantity) }} used
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            @if($batch->rejected_quantity > 0)
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-rose-50 text-rose-700 border border-rose-100 shadow-sm">
                                    {{ number_format($batch->rejected_quantity) }}
                                </div>
                            @else
                                <span class="text-xs text-slate-300 font-bold tracking-widest italic">NONE</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            <div class="text-xs font-black {{ $batch->expiry_date->isPast() ? 'text-rose-600' : ($batch->expiry_date->diffInMonths(now()) < 6 ? 'text-amber-600' : 'text-slate-700') }}">
                                {{ $batch->expiry_date->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="py-4 pr-8 text-right">
                            @if($batch->expiry_date->isPast())
                                <span class="bg-rose-100 text-rose-800 text-[9px] font-black px-2 py-1 rounded-lg tracking-widest uppercase shadow-sm border border-rose-200">Expired</span>
                            @elseif($batch->current_quantity <= 0)
                                <span class="bg-slate-100 text-slate-800 text-[9px] font-black px-2 py-1 rounded-lg tracking-widest uppercase shadow-sm border border-slate-200">Exhausted</span>
                            @else
                                <span class="bg-emerald-100 text-emerald-800 text-[9px] font-black px-2 py-1 rounded-lg tracking-widest uppercase shadow-sm border border-emerald-200">Active Stock</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="h-12 w-12 text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                <p class="text-slate-400 italic text-sm">No production batches have been recorded yet.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Rejection Modal --}}
    <div x-show="rejectionModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="rejectionModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" @click="rejectionModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="rejectionModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 dark:border-slate-800">
                <form :action="'{{ url('batches') }}/' + selectedBatch + '/reject'" method="POST">
                    @csrf
                    <div class="px-8 pt-8 pb-6 sm:px-10">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tighter">Record Rejection</h3>
                                <p class="text-[10px] font-bold text-rose-500 uppercase tracking-widest mt-1 italic">Quarantine Internal Ledger #<span x-text="batchNumber"></span></p>
                            </div>
                            <div class="h-12 w-12 rounded-2xl bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center">
                                <svg class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Quantity to Reject</label>
                                <input type="number" name="rejected_quantity" required placeholder="0" min="1" step="any"
                                    class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-900 dark:text-white bg-slate-50 dark:bg-slate-800 focus:ring-4 focus:ring-rose-500/5 focus:border-rose-500 transition-all outline-none">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Reason / Deficiency Code</label>
                                <textarea name="reason" placeholder="e.g. Visual defects, weight variation, seal integrity" rows="3"
                                    class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-900 dark:text-white bg-slate-50 dark:bg-slate-800 focus:ring-4 focus:ring-rose-500/5 focus:border-rose-500 transition-all outline-none resize-none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-6 bg-slate-50 dark:bg-slate-800/50 flex flex-col sm:flex-row-reverse gap-3">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-rose-600 px-8 py-4 text-xs font-black text-white shadow-xl shadow-rose-600/30 hover:bg-rose-500 transition-all active:scale-95 uppercase tracking-widest">
                            Confirm Rejection
                        </button>
                        <button type="button" @click="rejectionModal = false" class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 px-8 py-4 text-xs font-black text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all active:scale-95 uppercase tracking-widest">
                            Dismiss
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
