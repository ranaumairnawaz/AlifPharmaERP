@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Stock Movements</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Record physical asset adjustments for receiving or dispatching inventory.</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
    
    <!-- Deduction Form -->
    <div class="xl:col-span-4 bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 lg:p-8 transition-all">
        <h2 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6">Production Dispatch / Deduction</h2>
        
        <form action="{{ route('stock.store') }}" method="POST" class="space-y-6" x-data="productSelector()" @submit="onSubmit">
            @csrf
            <input type="hidden" name="type" value="out"> <!-- Forced Outbound for Dispatch -->

            <div class="relative">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Raw/Packaging Material Search</label>
                
                <!-- Hidden Real ID -->
                <input type="hidden" name="product_id" :value="selectedProduct ? selectedProduct.id : ''" required>
                
                <div class="relative">
                    <input type="text" 
                           x-model="searchQuery" 
                           @input.debounce.300ms="search" 
                           @click.away="showDropdown = false"
                           @focus="if(results.length > 0) showDropdown = true"
                           placeholder="Search Materials by Name or ID..." 
                           class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 pl-10 pr-4 text-sm font-bold text-slate-900 dark:text-slate-200 placeholder:text-slate-300 dark:placeholder:text-slate-700 focus:ring-teal-500 focus:border-teal-500 bg-slate-50/50 dark:bg-slate-800 shadow-inner dark:shadow-none transition-all">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 transition-colors">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <!-- Dropdown -->
                    <div x-show="showDropdown && results.length > 0" 
                         style="display: none;" 
                         class="absolute z-50 mt-2 w-full bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-2xl overflow-hidden transition-all duration-200">
                        <template x-for="product in results" :key="product.id">
                            <div @click="selectProduct(product)" class="px-4 py-3 hover:bg-teal-50 dark:hover:bg-teal-900/30 cursor-pointer border-b border-slate-100 dark:border-slate-700 last:border-0 transition-colors">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-bold text-slate-900 dark:text-slate-200" x-text="product.name"></span>
                                    <span class="text-[10px] bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded text-slate-500 dark:text-slate-400 font-mono font-bold" x-text="'#' + product.id"></span>
                                </div>
                                <div class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 font-bold" x-text="'Current Stock: ' + product.current_stock"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Selected Indicator -->
                <template x-if="selectedProduct">
                    <div class="mt-2 flex items-center gap-2 bg-teal-50 dark:bg-teal-900/20 border border-teal-100 dark:border-teal-900/50 px-3 py-2 rounded-lg transition-all animate-in fade-in slide-in-from-top-1 whitespace-nowrap overflow-hidden">
                        <div class="h-2 w-2 rounded-full bg-teal-500 shadow-[0_0_8px_rgba(20,184,166,0.5)]"></div>
                        <span class="text-xs font-bold text-teal-700 dark:text-teal-400 truncate" x-text="'Selected: ' + selectedProduct.name"></span>
                        <button type="button" @click="clearSelection" class="ml-auto text-teal-400 hover:text-teal-600 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">
                        Lot Number
                        <span class="ml-1 text-[9px] text-slate-400 normal-case font-medium" x-text="lots.length ? '— ' + lots.length + ' lot(s) available' : ''"></span>
                    </label>

                    <!-- Dynamic Lot Dropdown -->
                    <template x-if="lots.length > 0">
                        <select name="lot_number" x-model="selectedLotNumber" @change="onLotChange" required class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none transition-all">
                            <option value="">— Select Lot (Required) —</option>
                            <template x-for="lot in lots" :key="lot.lot_number">
                                <option :value="lot.lot_number" x-text="lot.label"></option>
                            </template>
                        </select>
                    </template>

                    <!-- Fallback: No lots found — free text entry -->
                    <template x-if="lots.length === 0">
                        <div>
                            <input type="text" name="lot_number" x-model="selectedLotNumber" placeholder="No lots recorded — enter manually" required class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none transition-all">
                            <p class="mt-1 text-[9px] text-amber-500 font-bold uppercase tracking-wide" x-show="selectedProduct && !lotsLoading">⚠ No lot-tracked intake found for this material.</p>
                        </div>
                    </template>

                    <p x-show="lotsLoading" class="mt-1 text-[9px] text-slate-400 font-bold uppercase tracking-wide animate-pulse">Loading lots...</p>
                </div>

                <div x-show="selectedLotNumber !== ''">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Usage Amount</label>
                    <input type="number" name="quantity" step="0.001" min="0.001" :max="getMaxQuantity()" x-model="quantity" required placeholder="0.000" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none transition-all">
                    <p x-show="quantity > getMaxQuantity()" class="mt-1 text-[10px] text-rose-500 font-bold uppercase tracking-wider">
                        ⚠ Exceeds remaining stock of <span x-text="getMaxQuantity()"></span> in this lot/product!
                    </p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Purpose / Notes</label>
                <textarea name="notes" rows="2" placeholder="e.g., Used for Batch #1024..." class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm text-slate-700 dark:text-slate-300 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none transition-all"></textarea>
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-3 text-sm font-bold text-white shadow-sm hover:bg-teal-500 transition-all active:scale-[0.98] uppercase tracking-widest leading-none">
                Dispatch to Production
            </button>
        </form>
    </div>

    <!-- Movement History -->
    <div class="xl:col-span-8 bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col overflow-hidden h-full">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Global Activity Matrix</h3>
        </div>
        
        <div class="p-2 flex-1 overflow-visible">
            <table id="movements-table" class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-6 py-4">Timeline</th>
                        <th class="px-6 py-4">Transaction Details</th>
                        <th class="px-6 py-4 text-right">Magnitude</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($movements as $mov)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                    {{ $mov->transaction_date->format('M d, Y') }}
                                </div>
                                <div class="text-[9px] text-slate-400 font-mono mt-0.5 opacity-60">
                                    {{ $mov->transaction_date->format('H:i a') }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg flex items-center justify-center {{ $mov->type === 'in' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500' : 'bg-rose-50 dark:bg-rose-900/20 text-rose-500' }}">
                                        @if($mov->type === 'in')
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                        @else
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 dark:text-slate-100 text-xs">
                                             {{ $mov->product->name ?? 'Corrupt Data' }}
                                             <span class="text-[9px] font-mono font-bold text-slate-400 dark:text-slate-500 px-1 bg-slate-100 dark:bg-slate-800 rounded ml-1 tracking-tighter">#{{ $mov->product_id }}</span>
                                        </div>
                                        @if($mov->lot_number)
                                            <div class="text-[9px] font-bold text-indigo-500 mt-1 uppercase tracking-widest"><span class="text-slate-400 font-normal">LOT:</span> {{ $mov->lot_number }}</div>
                                        @endif
                                        @if($mov->notes)
                                            <div class="text-[10px] text-slate-400 italic mt-0.5 truncate max-w-xs">{{ $mov->notes }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-bold font-mono tracking-tighter {{ $mov->type === 'in' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                    {{ $mov->type === 'in' ? '+' : '-' }}{{ number_format($mov->quantity, 2) }}
                                </span>
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
        $('#movements-table').DataTable({
            order: [[0, 'desc']]
        });
    });

    function productSelector() {
        return {
            searchQuery: '',
            results: [],
            showDropdown: false,
            selectedProduct: null,
            lots: [],
            lotsLoading: false,
            selectedLotNumber: '',
            selectedLot: null,
            quantity: '',

            async search() {
                if (this.searchQuery.length < 1) {
                    this.results = [];
                    this.showDropdown = false;
                    return;
                }
                // Call dedicated materials-only endpoint
                const res = await fetch(`/api/materials/search?q=${encodeURIComponent(this.searchQuery)}`);
                if (res.ok) {
                    this.results = await res.json();
                    this.showDropdown = this.results.length > 0;
                }
            },

            async selectProduct(product) {
                this.selectedProduct = product;
                this.searchQuery    = '#' + product.id + ' — ' + product.name;
                this.showDropdown   = false;
                this.results        = [];
                this.selectedLotNumber = '';
                this.selectedLot = null;
                this.quantity = '';

                // Fetch per-lot remaining stock for this product
                this.lots        = [];
                this.lotsLoading = true;
                try {
                    const res = await fetch(`/api/materials/${product.id}/lots`);
                    if (res.ok) {
                        this.lots = await res.json();
                    }
                } finally {
                    this.lotsLoading = false;
                }
            },

            clearSelection() {
                this.selectedProduct = null;
                this.searchQuery     = '';
                this.results         = [];
                this.showDropdown    = false;
                this.lots            = [];
                this.lotsLoading     = false;
                this.selectedLotNumber = '';
                this.selectedLot = null;
                this.quantity = '';
            },

            onLotChange() {
                const found = this.lots.find(l => l.lot_number === this.selectedLotNumber);
                this.selectedLot = found || null;
            },

            getMaxQuantity() {
                if (this.selectedLot) {
                    return this.selectedLot.remaining;
                }
                if (this.selectedProduct) {
                    return this.selectedProduct.current_stock;
                }
                return 0;
            },

            onSubmit(e) {
                const maxVal = this.getMaxQuantity();
                const qty = parseFloat(this.quantity) || 0;
                if (qty > maxVal) {
                    e.preventDefault();
                    alert(`Error: Quantity cannot exceed the remaining stock in this lot/product (${maxVal}).`);
                    return false;
                }
            }
        }
    }
</script>
@endsection
