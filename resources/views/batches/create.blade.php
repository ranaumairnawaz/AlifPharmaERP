@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="mb-12">
            <a href="{{ route('batches.index') }}"
                class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-indigo-600 transition-all uppercase tracking-[0.2em] mb-4 group font-sans">
                <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3" />
                </svg>
                Batch Monitoring Ledger
            </a>
            <h2
                class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-1 italic underline decoration-indigo-500/30">
                Finished Goods Production</h2>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Enter Production Batch</h1>
        </div>

        @if($errors->any())
            <div class="mb-8 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl">
                <h3 class="text-xs font-black text-rose-800 uppercase tracking-widest mb-1">Batch Validation Conflict</h3>
                <ul class="list-disc list-inside text-xs text-rose-700 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('batches.store') }}" method="POST" class="space-y-10">
            @csrf

            <div
                class="bg-white rounded-[2rem] border border-slate-200 shadow-2xl shadow-slate-200/40 overflow-hidden group transition-all hover:border-indigo-500/20">
                <div class="p-8 sm:p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="md:col-span-2">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Institutional
                                Portfolio - Product Identification</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                                <div class="md:col-span-1">
                                    <input type="number" name="product_id" id="product-id-input" required
                                        value="{{ old('product_id') }}"
                                        placeholder="Enter Product ID (e.g. 5)"
                                        class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 shadow-inner focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none placeholder:text-slate-200">
                                </div>
                                <div class="md:col-span-2">
                                    <div class="py-4 px-6 rounded-2xl bg-slate-100 border border-slate-200 flex items-center min-h-[56px]">
                                        <p id="product-name-display" class="text-sm font-bold text-slate-400">
                                            --- Enter Product ID to display name ---
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            const productsData = @json($products->mapWithKeys(function($p) {
                                return [$p->id => ($p->brand ? '[' . $p->brand->name . '] ' : '') . $p->name];
                            }));

                            const productIdInput = document.getElementById('product-id-input');
                            const productNameDisplay = document.getElementById('product-name-display');

                            function updateProductName() {
                                const id = productIdInput.value.trim();
                                if (id === '') {
                                    productNameDisplay.innerText = '--- Enter Product ID to display name ---';
                                    productNameDisplay.className = 'text-sm font-bold text-slate-400';
                                } else if (productsData[id]) {
                                    productNameDisplay.innerText = productsData[id];
                                    productNameDisplay.className = 'text-sm font-black text-indigo-600';
                                } else {
                                    productNameDisplay.innerText = 'Product not found (Invalid ID)';
                                    productNameDisplay.className = 'text-sm font-bold text-rose-500';
                                }
                            }

                            productIdInput.addEventListener('input', updateProductName);
                            // Trigger on page load in case of old input
                            updateProductName();
                        </script>

                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Production
                                Batch #</label>
                            <input type="text" name="batch_number" required value="{{ old('batch_number') }}"
                                placeholder="e.g. BATCH-2024-001"
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 shadow-inner focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none placeholder:text-slate-200 placeholder:italic">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Total
                                Quantity Produced</label>
                            <input type="number" name="quantity" required value="{{ old('quantity') }}" placeholder="0"
                                min="1"
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 shadow-inner focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none text-indigo-600 font-black">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Manufacturing
                                Date</label>
                            <input type="date" name="mfg_date" value="{{ old('mfg_date', date('Y-m-d')) }}"
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 shadow-inner focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none uppercase text-xs">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 font-bold text-rose-500 italic">Critical
                                Expiry Date</label>
                            <input type="date" name="expiry_date" required value="{{ old('expiry_date') }}"
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 shadow-inner focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none uppercase text-xs border-r-4 border-rose-500/20">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-6 border-t border-slate-100">
                <a href="{{ route('batches.index') }}"
                    class="text-[10px] font-black text-slate-300 hover:text-slate-500 transition-all uppercase tracking-widest group italic">
                    <span class="inline-block transition-transform group-hover:-translate-x-1">&larr;</span> Cancel
                    Operation
                </a>

                <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-10 py-5 text-sm font-black text-white shadow-2xl shadow-indigo-600/30 hover:bg-indigo-500 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn">
                    Confirm Production Batch
                    <svg class="ml-4 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
@endsection