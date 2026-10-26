@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="mb-12">
            <a href="{{ route('slips.index') }}"
                class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-all uppercase tracking-[0.2em] mb-4 group font-sans">
                <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3" />
                </svg>
                Logistics Stream
            </a>
            <h2
                class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em] mb-1 italic underline decoration-teal-500/30 font-sans">
                Modify Distribution Manifest</h2>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Edit Slip #{{ $slip->slip_number }}</h1>
        </div>

        <form action="{{ route('slips.update', $slip) }}" method="POST" id="slip-form">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Left Sidebar: Meta -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl p-8 space-y-6">
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Recipient
                                / Distributor</label>
                            <select name="distributor_id" required
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none appearance-none cursor-pointer">
                                @foreach($distributors as $d)
                                    <option value="{{ $d->id }}" {{ $slip->distributor_id == $d->id ? 'selected' : '' }}>
                                        {{ $d->company_name ?? $d->name }} ({{ $d->area }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Dispatch
                                Date</label>
                            <input type="date" name="transaction_date"
                                value="{{ $slip->transaction_date->format('Y-m-d') }}" required
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Logistics
                                Notes</label>
                            <textarea name="notes" rows="3" placeholder="Route info, driver details, etc."
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">{{ $slip->notes }}</textarea>
                        </div>
                    </div>

                    <div
                        class="bg-indigo-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-indigo-900/20 relative overflow-hidden group">
                        <div class="relative z-10">
                            <h4 class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-4">Stock
                                Integrity Warning</h4>
                            <p class="text-xs font-medium leading-relaxed opacity-80">Updating this slip will automatically
                                recalculate master stock levels. Ensure quantities match physical load before confirming.
                            </p>
                        </div>
                        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                            <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L1 21h22L12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Right Main: Items -->
                <div class="lg:col-span-8">
                    <div
                        class="bg-white rounded-[2.5rem] border border-slate-200 shadow-2xl shadow-slate-200/40 overflow-hidden">
                        <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="text-sm font-black text-slate-800 tracking-tight leading-none uppercase">Load
                                Manifest Composition</h3>
                            <button type="button" onclick="addItem()"
                                class="inline-flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-teal-100 transition-all active:scale-95 border border-teal-200/50">
                                <svg class="h-3.5 w-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Line Item
                            </button>
                        </div>

                        <div class="p-8">
                            <table class="w-full text-left">
                                <thead>
                                    <tr
                                        class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 italic">
                                        <th class="pb-4 px-4 w-5/12">Product Designation</th>
                                        <th class="pb-4 px-4 w-2/12 text-center">Cartons</th>
                                        <th class="pb-4 px-4 w-4/12">Issue Quantity</th>
                                        <th class="pb-4 px-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="items-container" class="divide-y divide-slate-50 italic">
                                    @foreach($slip->items as $index => $item)
                                        <tr class="group" data-row="{{ $index }}">
                                            <td class="py-6 px-4">
                                                <select name="items[{{ $index }}][product_id]" required
                                                    onchange="updateRowUnit(this)"
                                                    class="block w-full rounded-xl border-slate-100 py-3 px-4 text-sm font-bold text-slate-900 bg-slate-50/50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none appearance-none cursor-pointer">
                                                    <option value="">Select Product...</option>
                                                    @foreach($products as $p)
                                                        <option value="{{ $p->id }}" data-unit="{{ $p->unit->name ?? 'PCS' }}" {{ $item->product_id == $p->id ? 'selected' : '' }}>{{ $p->id }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="py-6 px-4">
                                                <input type="number" name="items[{{ $index }}][number_of_cartons]"
                                                    value="{{ $item->number_of_cartons }}" placeholder="0" min="0"
                                                    class="block w-full text-center rounded-xl border-slate-100 py-3 px-4 text-sm font-black text-slate-600 bg-slate-50/50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none shadow-inner">
                                            </td>
                                            <td class="py-6 px-4">
                                                <div class="relative">
                                                    <input type="number" name="items[{{ $index }}][quantity]"
                                                        value="{{ $item->quantity }}" required placeholder="0" min="0.01"
                                                        step="0.01"
                                                        class="block w-full rounded-xl border-slate-100 py-3 px-4 text-sm font-black text-slate-900 bg-slate-50/50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none pr-16 shadow-inner">
                                                    <div
                                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[9px] font-black text-slate-400 uppercase tracking-tighter unit-label">
                                                        {{ $item->product->unit->name ?? 'PCS' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-6 px-4 text-right">
                                                <button type="button" onclick="removeItem(this)"
                                                    class="p-2 text-slate-300 hover:text-rose-500 transition-all opacity-0 group-hover:opacity-100">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-12 flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-2xl bg-teal-600 px-10 py-5 text-sm font-black text-white shadow-2xl shadow-teal-600/30 hover:bg-teal-500 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn">
                                    Recalculate & Sync Load
                                    <svg class="ml-4 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let itemCount = {{ $slip->items->count() }};

        function addItem() {
            const container = document.getElementById('items-container');
            const row = document.createElement('tr');
            row.className = 'group';
            row.innerHTML = `
                                <td class="py-6 px-4">
                                    <select name="items[${itemCount}][product_id]" required onchange="updateRowUnit(this)" class="block w-full rounded-xl border-slate-100 py-3 px-4 text-sm font-bold text-slate-900 bg-slate-50/50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none appearance-none cursor-pointer">
                                        <option value="">Select Product...</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}" data-unit="{{ $p->unit->name ?? 'PCS' }}">{{ $p->id }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-6 px-4">
                                    <input type="number" name="items[${itemCount}][number_of_cartons]" placeholder="0" min="0"
                                        class="block w-full text-center rounded-xl border-slate-100 py-3 px-4 text-sm font-black text-slate-600 bg-slate-50/50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none shadow-inner">
                                </td>
                                <td class="py-6 px-4">
                                    <div class="relative">
                                        <input type="number" name="items[${itemCount}][quantity]" required placeholder="0" min="0.01" step="0.01"
                                            class="block w-full rounded-xl border-slate-100 py-3 px-4 text-sm font-black text-slate-900 bg-slate-50/50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none pr-16 shadow-inner">
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-[9px] font-black text-slate-400 uppercase tracking-tighter unit-label">PCS</div>
                                    </div>
                                </td>
                                <td class="py-6 px-4 text-right">
                                    <button type="button" onclick="removeItem(this)" class="p-2 text-slate-300 hover:text-rose-500 transition-all opacity-0 group-hover:opacity-100">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            `;
            container.appendChild(row);
            itemCount++;
        }

        function removeItem(btn) {
            if (document.querySelectorAll('#items-container tr').length > 1) {
                btn.closest('tr').remove();
            } else {
                alert('A slip must have at least one product.');
            }
        }

        function updateRowUnit(select) {
            const unit = select.options[select.selectedIndex].dataset.unit || 'PCS';
            select.closest('tr').querySelector('.unit-label').textContent = unit;
        }
    </script>
@endsection