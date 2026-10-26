@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="mb-12">
        <a href="{{ route('discards.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-rose-600 transition-all uppercase tracking-[0.2em] mb-4 group font-sans">
            <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3" /></svg>
            Discard Monitoring Ledger
        </a>
        <h2 class="text-[10px] font-black text-rose-600 uppercase tracking-[0.3em] mb-1 italic underline decoration-rose-500/30">Non-Conforming Stock</h2>
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Log Inventory Discard</h1>
    </div>

    @if($errors->any())
        <div class="mb-8 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl">
            <h3 class="text-xs font-black text-rose-800 uppercase tracking-widest mb-1">Inventory Conflict</h3>
            <ul class="list-disc list-inside text-xs text-rose-700 font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('discards.store') }}" method="POST" class="space-y-10">
        @csrf

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-2xl shadow-slate-200/40 overflow-hidden group transition-all hover:border-rose-500/20">
            <div class="p-8 sm:p-10 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Select Product for Discard</label>
                        <select name="product_id" id="product_id" required class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 focus:ring-4 focus:ring-rose-500/5 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer" onchange="loadBatches(this.value)">
                            <option value="">Search Master Catalog...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-type="{{ $product->material_type }}">
                                    [{{ strtoupper($product->material_type) }}] {{ $product->name }} ({{ $product->unit->name ?? '---' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="batch-container" class="md:col-span-2 hidden">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Select Specific Batch (For Finished Goods)</label>
                        <select name="batch_id" id="batch_id" class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                            <option value="">Select Production Batch...</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Discard Reason / Type</label>
                        <select name="type" id="type" required class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 focus:ring-4 focus:ring-rose-500/5 focus:border-rose-500 transition-all outline-none">
                            <option value="damaged_packaging">Damaged Raw/Packaging</option>
                            <option value="rejected_finished_good">Finished Good Rejection</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Quantity to Remove</label>
                        <input type="number" name="quantity" required placeholder="0" min="1"
                            class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 shadow-inner focus:ring-4 focus:ring-rose-500/5 focus:border-rose-500 transition-all outline-none text-rose-600 font-black">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Root Cause / Justification</label>
                        <textarea name="reason" required rows="3" placeholder="Explain why this stock is being discarded..."
                            class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 shadow-inner focus:ring-4 focus:ring-rose-500/5 focus:border-rose-500 transition-all outline-none placeholder:text-slate-200 placeholder:italic"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-6 border-t border-slate-100">
            <a href="{{ route('discards.index') }}" class="text-[10px] font-black text-slate-300 hover:text-slate-500 transition-all uppercase tracking-widest group italic">
                <span class="inline-block transition-transform group-hover:-translate-x-1">&larr;</span> Cancel Operation
            </a>
            
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-rose-600 px-10 py-5 text-sm font-black text-white shadow-2xl shadow-rose-600/30 hover:bg-rose-500 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn">
                Confirm Discard Operation
                <svg class="ml-4 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </button>
        </div>
    </form>
</div>

<script>
    async function loadBatches(productId) {
        const batchContainer = document.getElementById('batch-container');
        const batchSelect = document.getElementById('batch_id');
        const typeSelect = document.getElementById('type');
        
        // Reset
        batchSelect.innerHTML = '<option value="">Select Production Batch...</option>';
        batchContainer.classList.add('hidden');

        if (!productId) return;

        // Check product type from data attribute
        const selectedOption = document.getElementById('product_id').options[document.getElementById('product_id').selectedIndex];
        const productType = selectedOption.getAttribute('data-type');

        if (productType === 'finished_good') {
            batchContainer.classList.remove('hidden');
            typeSelect.value = 'rejected_finished_good';
            
            try {
                const response = await fetch(`/api/products/${productId}/batches`);
                const batches = await response.json();
                
                batches.forEach(batch => {
                    const opt = document.createElement('option');
                    opt.value = batch.id;
                    opt.textContent = `#${batch.batch_number} (Exp: ${batch.expiry_date} | Stock: ${batch.current_quantity})`;
                    batchSelect.appendChild(opt);
                });
            } catch (error) {
                console.error("Failed to load batches", error);
            }
        } else {
            typeSelect.value = 'damaged_packaging';
        }
    }
</script>
@endsection
