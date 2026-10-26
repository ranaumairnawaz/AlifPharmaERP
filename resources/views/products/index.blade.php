@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
            {{ $pageTitle ?? 'Product Catalog' }}
        </h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage your pharmaceutical inventory and asset
            valuation.</p>
    </div>

    <div class="mt-4 sm:ml-16 sm:mt-0 flex items-center gap-3">
        @canRead('products')
        <a href="{{ route('products.catalogue.pdf', request()->query()) }}" target="_blank"
            class="inline-flex items-center justify-center rounded-lg bg-slate-900 border border-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-xl shadow-slate-900/20 hover:bg-slate-800 transition-all active:scale-95 group">
            <svg class="mr-2 h-4 w-4 transition-transform group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            Branded Catalogue (PDF)
        </a>
        @endcanRead

        @canEdit('products')
        <a href="{{ route('products.batch') }}"
            class="inline-flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <svg class="mr-2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            Batch Adjustment
        </a>
        <a href="{{ route('products.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600 transition-all">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Product
        </a>
        @endcanEdit
    </div>
</div>

{{-- KPI Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 font-sans">
    @php
        $kinds = [
            'finished_good' => [
                'title' => 'Finished Goods Hub',
                'border' => 'border-indigo-100 dark:border-indigo-900/40',
                'bg' => 'bg-indigo-50/20 dark:bg-indigo-950/10',
                'text' => 'text-indigo-600 dark:text-indigo-400',
            ],
            'raw_material' => [
                'title' => 'Raw Materials Warehouse',
                'border' => 'border-teal-100 dark:border-teal-900/40',
                'bg' => 'bg-teal-50/20 dark:bg-teal-950/10',
                'text' => 'text-teal-600 dark:text-teal-400',
            ],
            'packaging' => [
                'title' => 'Packaging Library',
                'border' => 'border-amber-100 dark:border-amber-900/40',
                'bg' => 'bg-amber-50/20 dark:bg-amber-950/10',
                'text' => 'text-amber-600 dark:text-amber-400',
            ],
        ];
    @endphp

    @foreach($kinds as $type => $meta)
        @php
            $kindProducts = \App\Models\Product::where('material_type', $type)->get();
            $totalCount = $kindProducts->count();
            $totalStock = $kindProducts->sum('current_stock');
            $totalCost = $kindProducts->sum(function($p) {
                return $p->current_stock * $p->cost_price;
            });
            $lowStockCount = $kindProducts->filter(function($p) {
                return $p->current_stock <= $p->reorder_point;
            })->count();
        @endphp
        <div class="bg-white dark:bg-slate-900 rounded-2xl border {{ $meta['border'] }} {{ $meta['bg'] }} shadow-sm p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-black uppercase tracking-widest {{ $meta['text'] }} mb-3 border-b border-slate-100 dark:border-slate-800 pb-2">
                    {{ $meta['title'] }}
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase">Total Products</p>
                        <p class="text-lg font-black text-slate-800 dark:text-slate-200 tracking-tight">{{ number_format($totalCount) }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase">Total Stock</p>
                        <p class="text-lg font-black text-slate-800 dark:text-slate-200 tracking-tight">{{ number_format($totalStock) }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase">Total Cost Value</p>
                        <p class="text-md font-black text-slate-800 dark:text-slate-200 tracking-tight">Rs.{{ number_format($totalCost, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-[10px] font-semibold">
                <span class="text-slate-400">Low Stock Alert:</span>
                <span class="{{ $lowStockCount > 0 ? 'text-rose-500 font-bold' : 'text-emerald-500 font-bold' }}">
                    {{ $lowStockCount }} {{ $lowStockCount == 1 ? 'item' : 'items' }}
                </span>
            </div>
        </div>
    @endforeach
</div>

<!-- Filter Bar (Keep for advanced filtering) -->
<div
    class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 mb-8 overflow-hidden relative group transition-all hover:border-teal-100 dark:hover:border-teal-900/50">
    <form action="{{ route('products.index') }}" method="GET"
        class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
        <div>
            <label
                class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Manufacturer
                Group</label>
            <select name="group_id"
                class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-3 text-xs font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                <option value="">All Groups</option>
                @foreach(App\Models\Group::orderBy('name')->get() as $group)
                    <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label
                class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Specific
                Brand</label>
            <select name="brand_id"
                class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-3 text-xs font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                <option value="">All Brands</option>
                @foreach(App\Models\Brand::orderBy('name')->get() as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label
                class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Category
                Library</label>
            <select name="category_id"
                class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-3 text-xs font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                <option value="">All Categories</option>
                @foreach(App\Models\Category::orderBy('name')->get() as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="flex-1 inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-3 text-[10px] font-bold text-white shadow-sm hover:bg-teal-500 transition-all uppercase tracking-widest leading-none">
                Apply Filters
            </button>
            @if(request()->anyFilled(['brand_id', 'group_id', 'category_id', 'material_type']))
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-3 text-[10px] font-bold text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all uppercase tracking-widest leading-none shadow-sm">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<div
    class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table id="inventory-table" class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 border-b border-slate-200">
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest">Product Information</th>
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest">Ownership & Category</th>
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest">Expiry</th>
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest text-right">Pricing</th>
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest text-right">Inventory Status
                    </th>
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($products as $product)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group">
                    <td class="py-4 px-6 flex items-center gap-4">
                        <div
                            class="h-10 w-10 flex-shrink-0 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 font-bold group-hover:bg-teal-50 dark:group-hover:bg-teal-900/30 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors uppercase">
                            {{ strtoupper(substr($product->name, 0, 1)) }}
                        </div>
                        <div>
                            <a href="{{ route('products.show', $product) }}"
                                class="font-bold text-slate-900 dark:text-slate-100 hover:text-teal-600 transition-colors">
                                {{ $product->name }}
                            </a>
                            <div class="text-[10px] font-mono text-slate-400 mt-0.5 uppercase tracking-tighter">SKU:
                                #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex flex-col gap-1">
                            <span
                                class="bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 text-[10px] font-black px-2 py-0.5 rounded-md w-fit uppercase tracking-wider shadow-sm">
                                {{ $product->group->name ?? 'Direct' }}
                            </span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1 font-bold">
                                @if($product->brand)
                                    <svg class="h-3 w-3 text-slate-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                    {{ $product->brand->name }}
                                @else
                                    Generic Formulation
                                @endif
                            </span>
                            <div class="text-[9px] text-slate-400 uppercase font-bold tracking-tighter">
                                {{ $product->category->name ?? 'Misc' }}
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        @if($product->expiry_date)
                            @php
                                $daysRemaining = now()->diffInDays($product->expiry_date, false);
                                $isNearExpiry = $daysRemaining <= 30;
                                $expiryClass = $daysRemaining < 0
                                    ? 'bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 ring-rose-200 dark:ring-rose-900/50'
                                    : ($isNearExpiry ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 ring-amber-200 dark:ring-amber-900/50' : 'bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 ring-slate-200 dark:ring-slate-700');
                            @endphp
                            <div
                                class="inline-flex items-center gap-1.5 rounded-md px-2 py-1 text-[10px] font-bold {{ $expiryClass }} ring-1 ring-inset shadow-sm">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $product->expiry_date->format('M Y') }}
                            </div>
                        @else
                            <span
                                class="text-[10px] text-slate-300 dark:text-slate-700 font-bold uppercase italic whitespace-nowrap">No
                                Expiry</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="font-bold text-slate-900 dark:text-slate-100">
                            Rs.{{ number_format($product->sale_price, 2) }}</div>
                        <div class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 uppercase font-semibold">Cost:
                            Rs.{{ number_format($product->cost_price, 2) }}</div>
                    </td>
                    <td class="py-4 px-6 text-right">
                        @php
                            $isLow = $product->current_stock <= $product->reorder_point;
                            $statusClass = $isLow
                                ? 'bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 ring-rose-200 dark:ring-rose-900/50'
                                : 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 ring-emerald-200 dark:ring-emerald-900/50';
                        @endphp
                        <div
                            class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1 text-xs font-bold {{ $statusClass }} ring-1 ring-inset shadow-sm">
                            <span>{{ number_format($product->current_stock, $product->unit->is_decimal ? 2 : 0) }}</span>
                            <span
                                class="opacity-60 text-[10px] uppercase font-bold">{{ $product->unit->short_name }}</span>
                        </div>
                        @if($isLow)
                            <div
                                class="mt-1 flex items-center justify-end text-[9px] font-bold text-rose-500 uppercase tracking-widest gap-1.5 animate-pulse">
                                <div class="h-1 w-1 bg-rose-500 rounded-full"></div>
                                Critical Stock
                            </div>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex justify-end gap-2">
                            @canRead('products')
                            <a href="{{ route('products.show', $product) }}"
                                class="p-1.5 rounded-md text-slate-300 hover:text-teal-600 hover:bg-teal-50 transition-all"
                                title="View Portfolio">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            @endcanRead

                            @canEdit('products')
                            <a href="{{ route('products.edit', $product) }}"
                                class="p-1.5 rounded-md text-slate-300 hover:text-teal-600 hover:bg-teal-50 transition-all"
                                title="Edit Metadata">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            @endcanEdit

                            @canDelete('products')
                            <form id="delete-product-{{ $product->id }}"
                                action="{{ route('products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="confirmDelete('delete-product-{{ $product->id }}', 'Archive Product Account?', 'Disabling this product will block its usage in new DC slips and invoices.')"
                                    class="p-1.5 rounded-md text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition-all shadow-sm">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v2M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                            @endcanDelete
                        </div>
                    </td>
                </tr>
                @empty
                <!-- Handled by simple-datatables -->
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#inventory-table').DataTable({
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [5] } // Actions column
            ]
        });
    });
</script>
@endsection