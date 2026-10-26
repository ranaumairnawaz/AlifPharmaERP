@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-all uppercase tracking-[0.2em] mb-4 group font-sans">
                <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3" /></svg>
                Master Inventory Catalog
            </a>
            <h2 class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-1 italic underline decoration-indigo-500/30 font-sans">Command Center Velocity</h2>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter">Bulk Stock Adjustment</h1>
        </div>
        <div class="bg-indigo-50 rounded-2xl p-4 border border-indigo-100 max-w-sm">
            <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1 italic">Warning: Direct Manipulation</p>
            <p class="text-[11px] text-indigo-700/70 font-medium leading-relaxed">Changes made here will bypass standard inbound/outbound forms but will still be logged as "Batch Adjustments" in the ledger for audit compliance.</p>
        </div>
    </div>

    <form action="{{ route('products.batch.update') }}" method="POST">
        @csrf
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400 border-b border-slate-100 font-sans text-xs">
                            <th class="py-5 px-8 font-black uppercase tracking-widest">Asset Designation</th>
                            <th class="py-5 px-8 font-black uppercase tracking-widest">Classification</th>
                            <th class="py-5 px-8 font-black uppercase tracking-widest text-center w-48">Actual Balance</th>
                            <th class="py-5 px-8 font-black uppercase tracking-widest">Metric</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-sans">
                        @foreach($products as $product)
                        <tr class="hover:bg-indigo-50/20 transition-colors group">
                            <td class="py-5 px-8">
                                <div class="font-bold text-slate-800">{{ $product->name }}</div>
                                <div class="text-[9px] text-slate-400 uppercase tracking-tighter mt-0.5">Asset ID: #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="py-5 px-8">
                                <span class="bg-slate-100 text-slate-500 text-[9px] font-black px-2 py-0.5 rounded-md uppercase border border-slate-200">
                                    {{ $product->material_type }}
                                </span>
                            </td>
                            <td class="py-5 px-8">
                                <div class="relative max-w-[140px] mx-auto">
                                    <input type="number" 
                                           name="stocks[{{ $product->id }}]" 
                                           step="{{ $product->unit->is_decimal ? '0.001' : '1' }}" 
                                           value="{{ $product->current_stock }}"
                                           class="block w-full rounded-xl border-slate-200 py-2.5 px-4 text-sm font-black text-center text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-400 transition-all outline-none">
                                    @if($product->current_stock <= $product->reorder_point)
                                        <div class="absolute -top-1.5 -right-1.5 h-3 w-3 bg-rose-500 rounded-full border-2 border-white shadow-sm" title="Low Stock Trigger"></div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-5 px-8">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $product->unit->short_name }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer Action -->
            <div class="p-8 bg-slate-50/50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6 font-sans">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Executing mass-synchronization will broadcast audit logs across the shared ledger.
                </div>
                
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-10 py-5 text-sm font-black text-white shadow-2xl shadow-indigo-600/30 hover:bg-indigo-500 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn">
                    Synchronize Physical Balances
                    <svg class="ml-4 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
