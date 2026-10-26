@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 flex flex-col gap-8">
        <!-- Header Command Hub -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <a href="{{ route('damages.index') }}"
                    class="group inline-flex items-center gap-2 text-[10px] font-black text-slate-400 hover:text-rose-600 transition-all uppercase tracking-widest mb-4">
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7V3" />
                    </svg>
                    Damage Ledger Hub
                </a>
                <div class="flex items-center gap-2 mb-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                    <h2
                        class="text-[10px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-widest leading-none font-sans">
                        Loss Control Engine</h2>
                </div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tighter leading-none mb-1">Draft
                    Damage Audit</h1>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 italic">Initiate official recovery report
                    for production deficiency.</p>
            </div>

            <div
                class="hidden lg:flex items-center gap-4 bg-white dark:bg-slate-900 px-6 py-4 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div
                    class="h-10 w-10 rounded-2xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 flex items-center justify-center border border-rose-100 dark:border-rose-800 shadow-inner">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-rose-500 uppercase tracking-[0.2em] mb-0.5">Audit Insight</span>
                    <p
                        class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase leading-tight max-w-[220px]">
                        Proper damage filing credits packing material costs back to your inventory cycle.</p>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div
                class="bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-800 p-6 rounded-3xl animate-in fade-in duration-300">
                <h3 class="text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest mb-3 italic">
                    Validation Exception Ledger</h3>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-[11px] font-bold text-rose-700 dark:text-rose-500 flex items-center gap-2">
                            <span class="h-1 w-1 rounded-full bg-rose-400"></span>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('damages.store') }}" method="POST" class="space-y-8 pb-20" id="damage-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                {{-- Master Identification Block --}}
                <div
                    class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-8 space-y-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="h-8 w-8 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 flex items-center justify-center font-bold text-xs border border-slate-100 dark:border-slate-700">
                            01</div>
                        <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] italic">Product
                            Identification</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label
                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Pharmaceutical
                                Asset</label>
                            <div class="relative group">
                                <input type="text" list="product-search-list" id="product-search-input"
                                    class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-800 dark:text-white bg-slate-50 dark:bg-slate-800 shadow-inner focus:ring-2 focus:ring-teal-500/10 focus:border-teal-500 transition-all outline-none placeholder:text-slate-300"
                                    placeholder="Search inventory by brand or moniker..."
                                    value="{{ old('product_id') ? ($finishedGoods->where('id', old('product_id'))->first() ? '[' . ($finishedGoods->where('id', old('product_id'))->first()->brand->name ?? '---') . '] ' . $finishedGoods->where('id', old('product_id'))->first()->name : '') : '' }}"
                                    onchange="syncProductId(this)">
                                <input type="hidden" name="product_id" id="product-id-hidden"
                                    value="{{ old('product_id') }}" required>

                                <datalist id="product-search-list">
                                    @foreach($finishedGoods as $product)
                                        <option value="[{{ $product->brand->name ?? 'ALIF' }}] {{ $product->name }}"
                                            data-id="{{ $product->id }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Active
                                Batch Identifier</label>
                            <div class="relative">
                                <select name="batch_id" id="batch-selector" required
                                    class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-800 dark:text-white bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-teal-500/10 focus:border-teal-500 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="">Select Origin Batch...</option>
                                    @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" data-product="{{ $batch->product_id }}">
                                            BATCH #{{ $batch->batch_number }} ({{ number_format($batch->current_quantity) }}
                                            Units Avail)
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none text-slate-300">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Deficient
                                    Qty</label>
                                <div class="relative">
                                    <input type="number" name="quantity" required step="any" placeholder="0.00"
                                        class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-black text-rose-600 dark:text-rose-400 bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none placeholder:text-slate-300">
                                    <span
                                        class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none text-[8px] font-black text-slate-300 uppercase tracking-widest">Units</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Reason
                                    Code</label>
                                <input type="text" name="reason" placeholder="e.g. Broken seal"
                                    class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-800 dark:text-white bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-teal-500/10 focus:border-teal-500 transition-all outline-none placeholder:text-slate-300">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Material Recovery Hub Card --}}
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-8 space-y-8"
                    x-data="returnMatrix()">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="h-8 w-8 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 flex items-center justify-center font-bold text-xs border border-slate-100 dark:border-slate-700">
                                02</div>
                            <h3
                                class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] italic leading-none">
                                Material Credit Recovery</h3>
                        </div>
                        <button type="button" @click="addRow()"
                            class="h-10 px-4 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 text-[9px] font-black uppercase tracking-widest border border-teal-100 dark:border-teal-800 hover:bg-teal-100 transition-all active:scale-95 flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Append Item
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(row, index) in rows" :key="index">
                            <div
                                class="flex items-center gap-4 animate-in slide-in-from-right duration-300 bg-slate-50/50 dark:bg-slate-800/20 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <div class="flex-1 min-w-0">
                                    <input type="text" list="material-search-list"
                                        :placeholder="'Search Packaging Items...'"
                                        class="block w-full bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded-xl py-3 px-4 text-xs font-bold text-slate-800 dark:text-white shadow-sm focus:ring-2 focus:ring-teal-500/10 transition-all outline-none"
                                        x-model="row.search_value" @change="syncMaterialId($el, index)">
                                    <input type="hidden" :name="`returns[${index}][product_id]`" x-model="row.product_id">
                                </div>
                                <div class="w-24">
                                    <input type="number" :name="`returns[${index}][quantity]`" required step="any"
                                        placeholder="Qty"
                                        class="block w-full bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded-xl py-3 px-4 text-center text-xs font-black text-emerald-600 shadow-inner focus:ring-2 focus:ring-emerald-500/10 transition-all outline-none">
                                </div>
                                <button type="button" @click="removeRow(index)"
                                    class="h-10 w-10 flex items-center justify-center rounded-xl bg-white dark:bg-slate-900 text-rose-200 hover:text-rose-600 border border-slate-100 dark:border-slate-800 shadow-sm transition-all hover:shadow-md active:scale-90">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <div x-show="rows.length === 0"
                            class="py-16 text-center text-[10px] font-bold text-slate-300 uppercase tracking-widest italic border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-3xl">
                            No materials targeted for recovery credit.
                        </div>

                        <datalist id="material-search-list">
                            @foreach($packagingMaterials as $mat)
                                <option value="{{ $mat->name }}" data-id="{{ $mat->id }}">
                            @endforeach
                        </datalist>
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-10 border-t border-slate-100 dark:border-slate-800">
                <a href="{{ route('damages.index') }}"
                    class="text-[10px] font-bold text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest italic flex items-center gap-2">
                    <span>&larr;</span> Discard Operational Log
                </a>

                <button type="submit"
                    class="w-full rounded-2xl sm:w-auto px-12 py-5 px-3 bg-rose-600 hover:bg-rose-500 text-white text-xs font-black rounded-[2rem] transition-all shadow-2xl shadow-rose-900/20 active:scale-[0.98] uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                    File Official Damage Audit
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <script>
        function syncProductId(input) {
            const val = input.value;
            const hiddenInput = document.getElementById('product-id-hidden');
            const listOptions = document.getElementById('product-search-list').options;
            let found = false;
            for (let i = 0; i < listOptions.length; i++) {
                if (listOptions[i].value === val) {
                    hiddenInput.value = listOptions[i].getAttribute('data-id');
                    found = true;
                    break;
                }
            }
            if (!found) hiddenInput.value = '';
            filterBatches(hiddenInput.value);
        }
        function syncMaterialId(input, index) {
            const val = input.value;
            const listOptions = document.getElementById('material-search-list').options;
            const alpineData = document.querySelector('[x-data="returnMatrix()"]').__x.$data;
            let found = false;
            for (let i = 0; i < listOptions.length; i++) {
                if (listOptions[i].value === val) {
                    alpineData.rows[index].product_id = listOptions[i].getAttribute('data-id');
                    found = true;
                    break;
                }
            }
            if (!found) alpineData.rows[index].product_id = '';
        }
        const batchSelect = document.getElementById('batch-selector');
        const batchOptions = [...batchSelect.options];
        function filterBatches(productId) {
            const filteredOptions = batchOptions.filter(opt => opt.value === "" || opt.getAttribute('data-product') === productId);
            batchSelect.innerHTML = '';
            filteredOptions.forEach(opt => batchSelect.appendChild(opt));
            const oldBatch = "{{ old('batch_id') }}";
            if (oldBatch) batchSelect.value = oldBatch;
        }
        document.addEventListener('alpine:init', () => {
            Alpine.data('returnMatrix', () => ({
                rows: [],
                addRow() { this.rows.push({ product_id: '', search_value: '' }); },
                removeRow(index) { this.rows.splice(index, 1); }
            }));
        });
        window.onload = () => {
            const initialProductId = document.getElementById('product-id-hidden').value;
            if (initialProductId) filterBatches(initialProductId);
        };
    </script>
@endsection