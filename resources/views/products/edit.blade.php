@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <!-- Header Navigation -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-all uppercase tracking-[0.2em] mb-4 group font-sans">
                <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3" /></svg>
                Master Inventory Catalog
            </a>
            <div class="flex items-center gap-3 mb-1 font-sans">
                <h2 class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] italic underline decoration-indigo-500/30">Asset Modification</h2>
                <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-500 text-[8px] font-black uppercase tracking-widest border border-indigo-100">Live Record</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter">Edit Asset: {{ $product->name }}</h1>
        </div>

        <div class="flex flex-col items-end font-sans">
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Deployment Timestamp</p>
            <p class="text-xs font-bold text-slate-700 bg-white px-3 py-1.5 rounded-lg border border-slate-100 shadow-sm">{{ $product->created_at->format('M d, Y | H:i') }}</p>
        </div>
    </div>

    <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-10">
        @csrf
        @method('PUT')

        <!-- Section 1: Core Identity -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden group transition-all hover:border-teal-500/20">
            <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4 font-sans text-xs">
                    <div class="h-10 w-10 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-teal-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Phase Alpha</h3>
                        <p class="text-sm font-black text-slate-800 tracking-tight">Core Identity & Meta-Data</p>
                    </div>
                </div>
            </div>
            
            <div class="p-8 sm:p-10 space-y-8 font-sans">
                <div class="grid grid-cols-1 gap-8">
                    <div class="group/input relative">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Product Designation</label>
                        <input type="text" name="name" required value="{{ old('name', $product->name) }}" 
                            class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                    </div>
                    
                    <div class="group/input relative">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Asset Narrative & Description</label>
                        <textarea name="description" rows="3" 
                            class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-medium text-slate-600 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Strategic Classification -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden group transition-all hover:border-indigo-500/20">
            <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4 font-sans text-xs">
                    <div class="h-10 w-10 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-indigo-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Phase Beta</h3>
                        <p class="text-sm font-black text-slate-800 tracking-tight">Strategic Classification & Taxonomy</p>
                    </div>
                </div>
            </div>

            <div class="p-8 sm:p-10 font-sans text-xs">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-xs">Material Classification</label>
                        <select name="material_type" id="material_type" required class="block w-full rounded-2xl border-slate-200 py-3.5 px-5 text-xs font-bold text-slate-800 bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-inner outline-none text-xs">
                            <option value="finished_good" {{ old('material_type', $product->material_type) === 'finished_good' ? 'selected' : '' }}>Finished Goods (FG)</option>
                            <option value="raw_material" {{ old('material_type', $product->material_type) === 'raw_material' ? 'selected' : '' }}>Raw Materials (RM)</option>
                            <option value="packaging" {{ old('material_type', $product->material_type) === 'packaging' ? 'selected' : '' }}>Packaging Materials (PM)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-xs">Metric Unit (UOM)</label>
                        <select name="unit_id" required class="block w-full rounded-2xl border-slate-200 py-3.5 px-5 text-xs font-bold text-slate-800 bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-inner outline-none text-xs">
                            <option value="">Select Metric...</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>{{ $unit->name }} ({{ $unit->short_name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="finished_good_fields" class="contents">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-xs">Manufacturer Group</label>
                            <select name="group_id" id="group_id" class="block w-full rounded-2xl border-slate-200 py-3.5 px-5 text-xs font-bold text-slate-800 bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-inner outline-none">
                                <option value="">Select Group</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group_id', $product->group_id) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-xs">Brand Mapping</label>
                            <select name="brand_id" id="brand_id" class="block w-full rounded-2xl border-slate-200 py-3.5 px-5 text-xs font-bold text-slate-800 bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-inner outline-none">
                                <option value="">Generic (None)</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" data-group="{{ $brand->group_id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-xs">Category Taxonomy</label>
                            <select name="category_id" class="block w-full rounded-2xl border-slate-200 py-3.5 px-5 text-xs font-bold text-slate-800 bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all shadow-inner outline-none">
                                <option value="">Unlinked</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <script>
                        const materialTypeSelect = document.getElementById('material_type');
                        const finishedGoodFields = document.getElementById('finished_good_fields');
                        const pricingFields = document.getElementById('pricing_fields');
                        const groupIdSelect = document.getElementById('group_id');
                        const brandSelect = document.getElementById('brand_id');

                        function toggleMaterialFields() {
                            if (materialTypeSelect.value === 'finished_good') {
                                finishedGoodFields.classList.remove('hidden');
                                finishedGoodFields.classList.add('contents');
                                if (pricingFields) pricingFields.style.display = 'grid';
                            } else {
                                finishedGoodFields.classList.add('hidden');
                                finishedGoodFields.classList.remove('contents');
                                if (pricingFields) pricingFields.style.display = 'none';
                            }
                        }

                        materialTypeSelect.addEventListener('change', toggleMaterialFields);
                        window.addEventListener('load', toggleMaterialFields);

                        groupIdSelect.addEventListener('change', function() {
                            const groupId = this.value;
                            const brandOptions = brandSelect.querySelectorAll('option');
                            
                            brandOptions.forEach(option => {
                                if (!option.value) return; 
                                if (!groupId || option.getAttribute('data-group') == groupId) {
                                    option.style.display = 'block';
                                } else {
                                    option.style.display = 'none';
                                }
                            });
                            
                            const selectedOption = brandOptions[brandSelect.selectedIndex];
                            if (selectedOption.style.display === 'none') {
                                brandSelect.value = '';
                            }
                        });
                    </script>
                </div>
            </div>
        </div>

        <!-- Section 3: Financial Engineering -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden group transition-all hover:border-emerald-500/20">
            <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4 font-sans text-xs">
                    <div class="h-10 w-10 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-emerald-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1 text-xs">Phase Gamma</h3>
                        <p class="text-sm font-black text-slate-800 tracking-tight">Financial Engineering & Benchmarks</p>
                    </div>
                </div>
            </div>

            <div class="p-8 sm:p-10 flex flex-col lg:flex-row gap-10 font-sans text-xs">
                <div id="pricing_fields" class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="group/p">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-xs">Baseline Cost Ceiling</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-rose-300 font-bold text-xs uppercase italic tracking-tighter">Rs.</div>
                            <input type="number" name="cost_price" step="0.01" min="0" value="{{ old('cost_price', $product->cost_price) }}" 
                                class="block w-full pl-12 rounded-2xl border-slate-200 py-4 px-6 text-sm font-black bg-rose-50/30 text-rose-700 font-mono shadow-inner focus:ring-4 focus:ring-rose-500/5 focus:border-rose-400 transition-all outline-none">
                        </div>
                    </div>

                    <div class="group/p text-xs">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-xs">Market Valuation Point</label>
                        <div class="relative text-xs">
                            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-emerald-300 font-bold text-xs uppercase italic tracking-tighter">Rs.</div>
                            <input type="number" name="sale_price" step="0.01" min="0" value="{{ old('sale_price', $product->sale_price) }}" 
                                class="block w-full pl-12 rounded-2xl border-slate-200 py-4 px-6 text-sm font-black bg-emerald-50/30 text-emerald-700 font-mono shadow-inner focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-400 transition-all outline-none">
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-72 bg-slate-50 rounded-3xl p-6 border border-slate-100 font-sans text-xs">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 text-center text-xs">Safety Reorder Point</label>
                    <div class="relative text-center text-xs">
                        <input type="number" name="reorder_point" step="0.001" min="0" value="{{ old('reorder_point', $product->reorder_point) }}" 
                            class="block w-full rounded-2xl border-slate-200 py-3.5 px-4 text-sm font-black font-mono text-center text-slate-700 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-400 outline-none text-xs">
                        <p class="mt-4 text-[9px] text-slate-400 font-bold text-center leading-relaxed italic text-xs">Minimum stock threshold trigger for procurement automated alerts.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Logistics & Compliance -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden group transition-all hover:border-amber-500/20">
            <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4 font-sans text-xs">
                    <div class="h-10 w-10 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-amber-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1 text-xs">Phase Delta</h3>
                        <p class="text-sm font-black text-slate-800 tracking-tight">Logistics & Compliance</p>
                    </div>
                </div>
            </div>

            <div class="p-8 sm:p-10 font-sans text-xs">
                <div class="max-w-xs mx-auto">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-xs text-center">Architectural Expiry Threshold</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', $product->expiry_date ? $product->expiry_date->format('Y-m-d') : '') }}" 
                        class="block w-full rounded-2xl border-slate-200 py-3.5 px-5 text-sm font-bold text-slate-800 bg-white focus:ring-4 focus:ring-amber-500/5 focus:border-amber-500 transition-all shadow-inner outline-none text-center">
                    <p class="mt-4 text-[9px] text-slate-400 font-bold text-center leading-relaxed italic text-xs">Critical for batch safety and regulation audits. Leave blank if the item has no defined shelf-life.</p>
                </div>
            </div>
        </div>

        <!-- Submission Control -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-10 border-t border-slate-100 font-sans text-xs">
            <a href="{{ route('products.index') }}" class="text-[10px] font-black text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest group italic text-xs">
                <span class="inline-block transition-transform group-hover:-translate-x-1">&larr;</span> Discard Changes & Return
            </a>
            
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-teal-600 px-10 py-5 text-sm font-black text-white shadow-2xl shadow-teal-600/30 hover:bg-teal-500 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn text-xs">
                Update Asset Record & Sync Catalog
                <svg class="ml-4 h-4 w-4 transition-transform group-hover/btn:translate-x-1 text-xs" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </button>
        </div>
    </form>
</div>
@endsection
