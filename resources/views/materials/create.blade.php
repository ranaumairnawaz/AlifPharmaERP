@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <a href="{{ route('materials.index') }}"
                    class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-all uppercase tracking-[0.2em] mb-4 group font-sans">
                    <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7V3" />
                    </svg>
                    Material Logistics
                </a>
                <h2
                    class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em] mb-1 italic underline decoration-teal-500/30">
                    Inward Procurement</h2>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter">Deploy Material Entry Slip</h1>
            </div>
        </div>

        <form action="{{ route('materials.store') }}" method="POST" id="material-entry-form" class="space-y-10">
            @csrf

            <!-- Source & Meta -->
            <div
                class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden group transition-all hover:border-teal-500/20">
                <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-4 font-sans">
                        <div
                            class="h-10 w-10 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-teal-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">
                                Procurement Context</h3>
                            <p class="text-sm font-black text-slate-800 tracking-tight">Vendor & Source Details</p>
                        </div>
                    </div>
                </div>

                <div class="p-8 sm:p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 font-sans">
                        <div class="group/input relative">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Source
                                / Vendor Name</label>
                            <input type="text" name="source" required placeholder="e.g. Allied Chemical Supplies"
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                        </div>

                        <div class="group/input relative">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Transaction
                                Date</label>
                            <input type="date" name="transaction_date" required value="{{ date('Y-m-d') }}"
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                        </div>

                        <div class="group/input relative lg:col-span-1">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Procurement
                                Notes</label>
                            <input type="text" name="notes" placeholder="Optional internal comments..."
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Material Selection Table -->
            <div
                class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden font-sans">
                <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="h-10 w-10 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-indigo-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div>
                            <h3
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1 text-xs">
                                Asset Listing</h3>
                            <p class="text-sm font-black text-slate-800 tracking-tight">Multi-Product Material Manifest</p>
                        </div>
                    </div>
                    <button type="button" onclick="addRow()"
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-[10px] font-black text-white hover:bg-indigo-500 transition-all uppercase tracking-widest shadow-lg shadow-indigo-600/20">
                        <svg class="mr-2 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Manifest Line
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="materials-table">
                        <thead>
                            <tr class="bg-slate-50/30">
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    Product Identifier (ID Only)</th>
                                <th
                                    class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    Inward Qty</th>
                                <th
                                    class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    Rate / Unit</th>
                                <th
                                    class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    Lot / Int. Batch #</th>
                                <th
                                    class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    Expiry Date</th>
                                <th
                                    class="px-4 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    Total Valuation</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody id="rows-container">
                            <tr class="manifest-row group transition-all hover:bg-slate-50/50">
                                <td class="px-8 py-4 border-b border-slate-50">
                                    <select name="items[0][product_id]" required
                                        class="product-selector block w-full rounded-xl border-slate-200 py-3 px-4 text-xs font-bold text-slate-800 bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none">
                                        <option value="">Select ID...</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-name="{{ $product->name }}"
                                                data-unit="{{ $product->unit->short_name ?? 'Units' }}">
                                                {{ $product->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p
                                        class="mt-1.5 text-[8px] font-black text-slate-300 uppercase tracking-widest product-display-name">
                                        --- Pending ID Selection ---</p>
                                </td>
                                <td class="px-4 py-4 border-b border-slate-50">
                                    <div class="relative">
                                        <input type="number" name="items[0][quantity]" step="0.001" min="0.001" required
                                            class="qty-input block w-full rounded-xl border-slate-200 py-3 px-4 text-xs font-black text-slate-800 bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none text-right pr-12">
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-[8px] font-black text-slate-300 uppercase tracking-tighter unit-display">Units</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 border-b border-slate-50">
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-[8px] font-black text-slate-300 uppercase tracking-tighter">Rs.</span>
                                        <input type="number" name="items[0][price_per_unit]" step="0.01" min="0" required
                                            class="price-input block w-full rounded-xl border-slate-200 py-3 px-4 pl-10 text-xs font-black text-indigo-700 bg-indigo-50/20 focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none text-right">
                                    </div>
                                </td>
                                <td class="px-4 py-4 border-b border-slate-50">
                                    <input type="text" name="items[0][lot_number]" placeholder="Internal Ref..."
                                        class="block w-full rounded-xl border-slate-200 py-3 px-4 text-xs font-bold text-slate-600 bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none">
                                </td>
                                <td class="px-4 py-4 border-b border-slate-50">
                                    <input type="date" name="items[0][expiry_date]"
                                        class="block w-full rounded-xl border-slate-200 py-3 px-4 text-xs font-bold text-slate-600 bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none">
                                </td>
                                <td class="px-4 py-4 border-b border-slate-50">
                                    <p class="text-[10px] font-black text-slate-800 tracking-tight row-total text-right">Rs.
                                        0.00</p>
                                </td>
                                <td class="px-8 py-4 border-b border-slate-50 text-right">
                                    <button type="button" onclick="removeRow(this)"
                                        class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Total Valuation Summary -->
                <div class="px-8 py-6 bg-slate-50/50 flex justify-end items-center gap-10">
                    <div class="text-right">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Aggregate Payload
                            Valuation</p>
                        <h2 id="grand-total-display"
                            class="text-3xl font-black text-indigo-600 tracking-tighter italic shadow-indigo-600/5 shadow-sm">
                            Rs. 0.00</h2>
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-10 border-t border-slate-100 font-sans">
                <a href="{{ route('materials.index') }}"
                    class="text-[10px] font-black text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest group italic">
                    <span class="inline-block transition-transform group-hover:-translate-x-1">&larr;</span> Discard
                    Manifest & Return
                </a>

                <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-teal-600 px-10 py-5 text-sm font-black text-white shadow-2xl shadow-teal-600/30 hover:bg-teal-500 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn">
                    Commit Manifest & Update Accounts
                    <svg class="ml-4 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <script>
        let rowCount = 1;

        function addRow() {
            const container = document.getElementById('rows-container');
            const newRow = container.querySelector('.manifest-row').cloneNode(true);

            // Update names and reset values
            newRow.querySelectorAll('input, select').forEach(input => {
                const name = input.name;
                input.name = name.replace(/\[\d+\]/, `[${rowCount}]`);
                input.value = '';
            });

            // Reset option texts in the cloned select
            newRow.querySelectorAll('.product-selector option').forEach(opt => {
                if (opt.value) {
                    opt.text = opt.value;
                }
            });

            newRow.querySelector('.product-display-name').innerText = '--- Pending ID Selection ---';
            newRow.querySelector('.unit-display').innerText = 'Units';
            newRow.querySelector('.row-total').innerText = 'Rs. 0.00';

            container.appendChild(newRow);
            rowCount++;
            attachListeners(newRow);
        }

        function removeRow(button) {
            const rows = document.querySelectorAll('.manifest-row');
            if (rows.length > 1) {
                button.closest('.manifest-row').remove();
                calculateGrandTotal();
            } else {
                alert('Manifest must contain at least one asset line.');
            }
        }

        function calculateRowTotal(row) {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const total = qty * price;
            row.querySelector('.row-total').innerText = 'Rs. ' + total.toLocaleString(undefined, { minimumFractionDigits: 2 });
            return total;
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.manifest-row').forEach(row => {
                grandTotal += calculateRowTotal(row);
            });
            document.getElementById('grand-total-display').innerText = 'Rs. ' + grandTotal.toLocaleString(undefined, { minimumFractionDigits: 2 });
        }

        function updateSelectOptionTexts(select) {
            Array.from(select.options).forEach(opt => {
                if (opt.value) {
                    opt.text = opt.value;
                }
            });
            const option = select.options[select.selectedIndex];
            if (select.value && option) {
                const name = option.getAttribute('data-name');
                if (name) {
                    option.text = select.value + ' - ' + name;
                }
            }
        }

        function attachListeners(row) {
            const select = row.querySelector('.product-selector');
            const qty = row.querySelector('.qty-input');
            const price = row.querySelector('.price-input');

            select.addEventListener('change', function () {
                const option = this.options[this.selectedIndex];
                const name = option.getAttribute('data-name') || '--- Pending ID Selection ---';
                const unit = option.getAttribute('data-unit') || 'Units';
                row.querySelector('.product-display-name').innerText = name;
                row.querySelector('.unit-display').innerText = unit;

                updateSelectOptionTexts(this);
            });

            qty.addEventListener('input', calculateGrandTotal);
            price.addEventListener('input', calculateGrandTotal);
        }

        // Initialize listeners for the first row
        document.querySelectorAll('.manifest-row').forEach(row => {
            attachListeners(row);
        });
    </script>
@endsection