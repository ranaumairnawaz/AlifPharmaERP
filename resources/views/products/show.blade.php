@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    <!-- Breadcrumbs & Actions -->
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
        <div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-colors uppercase tracking-[0.2em] mb-2 group">
                <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3"/></svg>
                Master Inventory
            </a>
            <h2 class="text-[10px] font-bold text-teal-600 uppercase tracking-[0.2em] mb-1">Asset Intelligence Hub</h2>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $product->name }}</h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('products.pdf', $product) }}" target="_blank" class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-teal-500/20 hover:bg-teal-500 transition-all active:scale-[0.98]">
                <svg class="mr-2 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Branded Audit Export (PDF)
            </a>
            <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center justify-center rounded-lg bg-white border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-600 shadow-sm hover:bg-slate-50 transition-all active:scale-[0.98]">
                Modify Asset
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Archive whole product profile?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-rose-50 border border-rose-200 px-4 py-2.5 text-xs font-bold text-rose-600 shadow-sm hover:bg-rose-100 transition-all active:scale-[0.98]">
                    Archive Profile
                </button>
            </form>
        </div>
    </div>

    <!-- Live Analytics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Stock Level -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 group transition-all hover:border-teal-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                @php $isLow = $product->current_stock <= $product->reorder_point; @endphp
                <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full {{ $isLow ? 'bg-rose-50 text-rose-500 animate-pulse' : 'bg-emerald-50 text-emerald-500' }}">
                    {{ $isLow ? 'Critical Level' : 'Stable Supply' }}
                </span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Available Reserve</p>
            <h3 class="text-2xl font-black text-slate-900 tracking-tighter">
                {{ number_format($product->current_stock, $product->unit->is_decimal ? 2 : 0) }} 
                <span class="text-xs font-bold text-slate-400 uppercase ml-1">{{ $product->unit->short_name }}</span>
            </h3>
        </div>

        <!-- Valuation -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 group transition-all hover:border-teal-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Current Appraisal</p>
            <h3 class="text-2xl font-black text-slate-900 tracking-tighter">Rs.{{ number_format($valuation, 2) }}</h3>
        </div>

        <!-- Total In -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 group transition-all hover:border-teal-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Cumulative Inbound</p>
            <h3 class="text-2xl font-black text-slate-900 tracking-tighter">{{ number_format($totalIn, 1) }}</h3>
        </div>

        <!-- Total Out -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 group transition-all hover:border-teal-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Cumulative Outbound</p>
            <h3 class="text-2xl font-black text-slate-900 tracking-tighter">{{ number_format($totalOut, 1) }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Technical Specifications -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center gap-2">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Technical Data Sheet</h3>
                </div>
                <div class="p-6 space-y-5">
                    <div class="flex justify-between items-start pt-2 border-t border-slate-50 first:pt-0 first:border-0 font-sans">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Brand Library</span>
                        <div class="text-right">
                           <div class="text-xs font-bold text-slate-900">{{ $product->brand->name ?? 'Generic' }}</div>
                           <div class="text-[9px] text-slate-400 uppercase tracking-tight">{{ $product->brand->country_of_origin ?? 'International' }}</div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center pt-5 border-t border-slate-50">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Taxonomy Hub</span>
                        <span class="bg-indigo-50 text-indigo-700 text-[9px] font-bold px-2 py-0.5 rounded-md uppercase border border-indigo-100">
                            {{ $product->category->name ?? 'Mixed' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center pt-5 border-t border-slate-50">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Metric Standard</span>
                        <span class="text-xs font-bold text-slate-800">{{ $product->unit->name }} ({{ $product->unit->short_name }})</span>
                    </div>

                    <div class="flex justify-between items-center pt-5 border-t border-slate-50">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Import Ceiling</span>
                        <span class="text-xs font-bold text-rose-500 font-mono tracking-tighter">Rs.{{ number_format($product->cost_price, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center pt-5 border-t border-slate-50">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Retail Target</span>
                        <span class="text-xs font-bold text-emerald-600 font-mono tracking-tighter">Rs.{{ number_format($product->sale_price, 2) }}</span>
                    </div>

                    <div class="flex justify-between items-center pt-5 border-t border-slate-50 border-dashed">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Reorder Matrix</span>
                        <span class="text-xs font-bold text-slate-900 px-2 py-1 bg-slate-100 rounded-lg">{{ $product->reorder_point }}</span>
                    </div>

                    <div class="flex justify-between items-center pt-5 border-t border-slate-50">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Architectural Expiry</span>
                        <span class="text-xs font-bold {{ $product->expiry_date ? 'text-slate-800' : 'text-slate-300 italic uppercase' }}">
                            {{ $product->expiry_date ? $product->expiry_date->format('M d, Y') : 'No Expiry Set' }}
                        </span>
                    </div>

                    @if($product->expiry_date)
                    <div class="flex justify-between items-center pt-5 border-t border-slate-50">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Safety Window</span>
                        @php $days = now()->diffInDays($product->expiry_date, false); @endphp
                        <span class="text-xs font-black {{ $days < 0 ? 'text-rose-600' : ($days <= 30 ? 'text-amber-500' : 'text-emerald-500') }}">
                            {{ $days < 0 ? 'EXPIRED' : $days . ' Days Remaining' }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-teal-900 rounded-2xl p-6 text-white shadow-lg shadow-teal-900/20 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-125 transition-transform">
                   <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                </div>
                <h4 class="text-[10px] font-bold text-teal-400 uppercase tracking-widest mb-3">System Synopsis</h4>
                <p class="text-sm font-medium text-teal-50/80 leading-relaxed italic">
                    "{{ $product->description ?? 'No specific detailed annotation provided for this pharmaceutical asset.' }}"
                </p>
            </div>
        </div>

        <!-- Master Transaction Ledger -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm flex flex-col overflow-hidden h-full min-h-[600px]">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-2 w-2 rounded-full bg-teal-500 shadow-[0_0_8px_rgba(20,184,166,0.5)]"></div>
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Individual Asset Ledger</h3>
                </div>
            </div>

            <div class="flex-1 overflow-x-auto p-2">
                <table id="asset-ledger" class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <th class="px-6 py-4">Temporal Mark</th>
                            <th class="px-6 py-4">Transaction Vector</th>
                            <th class="px-6 py-4 text-center">Magnitude</th>
                            <th class="px-6 py-4">Narrative</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($product->stockMovements as $m)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 flex flex-col">
                                    <span class="font-bold text-slate-900 text-xs">{{ $m->transaction_date->format('M d, Y') }}</span>
                                    <span class="text-[9px] text-slate-400 uppercase tracking-tight">{{ $m->transaction_date->format('H:i a') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-6 w-6 rounded flex items-center justify-center {{ $m->type === 'in' ? 'bg-emerald-50 text-emerald-500' : 'bg-rose-50 text-rose-500' }}">
                                            @if($m->type === 'in')
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                            @else
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                            @endif
                                        </div>
                                        <span class="text-[10px] font-bold uppercase tracking-widest {{ $m->type === 'in' ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $m->type === 'in' ? 'Stock Receive' : 'Stock Dispatch' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-mono font-bold text-xs tracking-tighter {{ $m->type === 'in' ? 'text-emerald-700' : 'text-rose-700' }}">
                                        {{ $m->type === 'in' ? '+' : '-' }}{{ number_format($m->quantity, 1) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-[10px] text-slate-500 italic truncate max-w-xs">{{ $m->notes ?? 'Administrative Adjustment' }}</p>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#asset-ledger').DataTable({
            order: [[0, 'desc']]
        });
    });
</script>
@endsection
