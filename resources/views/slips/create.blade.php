@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6 font-sans">
            <div>
                <a href="{{ route('slips.index') }}"
                    class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-all uppercase tracking-[0.2em] mb-4 group">
                    <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7V3" />
                    </svg>
                    Logistics Ledger
                </a>
                <h2 class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em] mb-1 italic">Drafting Order
                    #{{ \App\Models\InventorySlip::nextSlipNumber() }}</h2>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Generate Distribution Slip</h1>
            </div>

            <div class="flex items-center gap-4 bg-teal-50 px-4 py-3 rounded-2xl border border-teal-100">
                <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-[11px] font-bold text-teal-800 uppercase tracking-widest leading-tight italic">Consolidated
                    quantity entry for unit-based logistics.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-8 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl">
                <div class="flex items-center mb-2">
                    <svg class="h-5 w-5 text-rose-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xs font-black text-rose-800 uppercase tracking-widest">Inventory Conflict Detected</h3>
                </div>
                <ul class="list-disc list-inside text-xs text-rose-700 font-medium space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('slips.store') }}" method="POST" id="slip-form">
            @csrf

            <!-- Horizontal Top Header -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/20 p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="md:col-span-1">
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Distribution
                            Partner</label>
                        <select name="distributor_id" required
                            class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                            <option value="">Select Distributor...</option>
                            @foreach($distributors as $distributor)
                                <option value="{{ $distributor->id }}" {{ old('distributor_id') == $distributor->id ? 'selected' : '' }}>
                                    {{ $distributor->name }} ({{ $distributor->area }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Dispatch
                            Date</label>
                        <input type="date" name="transaction_date" required
                            value="{{ old('transaction_date', date('Y-m-d')) }}"
                            class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Operational
                            Remarks / Truck Details</label>
                        <input type="text" name="notes" placeholder="e.g. Loading truck LHR-908, high priority"
                            value="{{ old('notes') }}"
                            class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none placeholder:text-slate-300">
                    </div>
                </div>
            </div>

            <!-- Full Space Manifest Table -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-200 py-4 px-8 flex items-center justify-between">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Inventory Load Manifest
                        (Full Width)</h3>
                    <button type="button" onclick="addRow()"
                        class="inline-flex items-center text-[10px] font-black text-teal-600 hover:text-teal-700 transition-all uppercase tracking-widest group">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Append Manifest Row
                    </button>
                </div>

                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]" id="manifest-table">
                        <thead>
                            <tr
                                class="bg-slate-100/50 border-b border-slate-200 text-slate-400 uppercase text-[9px] tracking-[0.2em] font-black">
                                <th class="py-4 px-8" style="width: 40%">Branded Product / SKU</th>
                                <th class="py-4 px-4 text-center" style="width: 15%">Available</th>
                                <th class="py-4 px-4 text-center" style="width: 15%">Cartons</th>
                                <th class="py-4 px-4 text-center" style="width: 20%">Issue Quantity</th>
                                <th class="py-4 pr-8 text-right" style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody id="items-container" class="divide-y divide-slate-100">
                            <!-- Dynamic Rows Inject here -->
                        </tbody>
                    </table>
                </div>

                <div
                    class="p-8 bg-slate-50/30 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic flex items-center">
                        <span class="h-2 w-2 rounded-full bg-teal-500 mr-2 animate-pulse"></span>
                        Verification Status: Ready for loading. Total Rows: <span id="row-count"
                            class="text-slate-900 ml-1">0</span>
                    </div>

                    <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-teal-600 px-10 py-5 text-sm font-black text-white shadow-2xl shadow-teal-600/30 hover:bg-teal-500 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn">
                        Confirm & Publish Slip
                        <svg class="ml-4 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Searchable Datalist -->
    <datalist id="product-search-list">
        @foreach($products as $product)
            <option value="{{ $product->id }}" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-stock="{{ $product->current_stock }}"
                data-unit="{{ $product->unit->name ?? 'PCS' }}">
        @endforeach
    </datalist>

    <script>
        let rowIndex = 0;

        function addRow() {
            const index = rowIndex++;
            const rowHtml = `
                <tr class="manifest-row hover:bg-teal-50/20 transition-all group animate-fadeIn" id="row-${index}">
                    <td class="py-4 px-8">
                        <div class="relative">
                            <input type="text" list="product-search-list" 
                                class="product-search block w-full rounded-xl border-slate-200 py-3 px-4 text-xs font-bold text-slate-800 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none placeholder:text-slate-200"
                                placeholder="Type ID..." onchange="handleProductSelect(this, ${index})">
                            <input type="hidden" name="items[${index}][product_id]" class="product-id">
                            <p class="mt-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest product-name-display">
                                --- Pending Selection ---
                            </p>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <div class="stock-display flex flex-col items-center">
                            <span class="stock-val text-xs font-black text-slate-300">--</span>
                            <span class="unit-label text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">---</span>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <input type="number" name="items[${index}][number_of_cartons]" placeholder="0" min="0" 
                            class="block w-24 mx-auto text-center rounded-xl border-slate-200 py-3 text-sm font-black text-slate-600 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                    </td>
                    <td class="py-4 px-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <input type="number" name="items[${index}][quantity]" placeholder="0" min="1" required
                                class="qty-input block w-32 text-center rounded-xl border-slate-200 py-3 text-sm font-black text-teal-600 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none"
                                oninput="validateRow(${index})">
                            <span class="unit-indicator text-[10px] font-black text-slate-400 uppercase tracking-widest">---</span>
                        </div>
                    </td>
                    <td class="py-4 pr-8 text-right">
                        <button type="button" onclick="removeRow(${index})" class="p-2 rounded-xl text-slate-200 hover:text-rose-500 hover:bg-rose-50 transition-all group-hover:scale-110">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </td>
                </tr>
            `;
            document.getElementById('items-container').insertAdjacentHTML('beforeend', rowHtml);
            updateRowCount();
        }

        function handleProductSelect(input, index) {
            const val = input.value;
            const row = document.getElementById(`row-${index}`);
            const idInput = row.querySelector('.product-id');
            const stockVal = row.querySelector('.stock-val');
            const unitLabel = row.querySelector('.unit-label');
            const unitIndicator = row.querySelector('.unit-indicator');
            const nameDisplay = row.querySelector('.product-name-display');

            const listOptions = document.getElementById('product-search-list').options;
            let found = false;

            for (let i = 0; i < listOptions.length; i++) {
                if (listOptions[i].value === val) {
                    const id = listOptions[i].getAttribute('data-id');
                    const stock = listOptions[i].getAttribute('data-stock');
                    const unit = listOptions[i].getAttribute('data-unit');
                    const name = listOptions[i].getAttribute('data-name');

                    idInput.value = id;
                    stockVal.textContent = stock;
                    stockVal.classList.remove('text-slate-300');
                    stockVal.classList.add('text-slate-900');
                    stockVal.setAttribute('data-max', stock);

                    unitLabel.textContent = unit;
                    unitIndicator.textContent = unit;
                    nameDisplay.textContent = name;
                    nameDisplay.classList.remove('text-slate-400');
                    nameDisplay.classList.add('text-teal-600', 'font-black');
                    found = true;
                    break;
                }
            }

            if (!found) {
                idInput.value = '';
                stockVal.textContent = '--';
                unitLabel.textContent = '---';
                unitIndicator.textContent = '---';
                nameDisplay.textContent = '--- Pending Selection ---';
                nameDisplay.classList.remove('text-teal-600', 'font-black');
                nameDisplay.classList.add('text-slate-400');
            }

            validateRow(index);
        }

        function validateRow(index) {
            const row = document.getElementById(`row-${index}`);
            const qtyInput = row.querySelector('.qty-input');
            const qty = parseInt(qtyInput.value) || 0;
            const stockVal = row.querySelector('.stock-val');
            const maxStock = parseInt(stockVal.getAttribute('data-max')) || 0;

            if (qty > maxStock && maxStock > 0) {
                row.classList.add('bg-rose-50/50');
                qtyInput.classList.add('text-rose-600', 'border-rose-300');
            } else {
                row.classList.remove('bg-rose-50/50');
                qtyInput.classList.remove('text-rose-600', 'border-rose-300');
            }
        }

        function removeRow(index) {
            document.getElementById(`row-${index}`).remove();
            updateRowCount();
        }

        function updateRowCount() {
            document.getElementById('row-count').textContent = document.querySelectorAll('.manifest-row').length;
        }

        window.onload = function () {
            addRow();
        };

        document.getElementById('slip-form').onsubmit = function (e) {
            const rows = document.querySelectorAll('.manifest-row');
            let hasError = false;
            let hasQty = false;

            rows.forEach(row => {
                const qtyInput = row.querySelector('.qty-input');
                const qty = parseInt(qtyInput.value) || 0;
                const stockVal = row.querySelector('.stock-val');
                const maxStock = parseInt(stockVal.getAttribute('data-max')) || 0;

                if (qty > 0) hasQty = true;
                if (qty > maxStock) hasError = true;
            });

            if (hasError) {
                alert('Insufficient stock for some items. Please adjust quantities.');
                e.preventDefault();
                return false;
            }

            if (!hasQty) {
                alert('Please specify quantity for at least one item.');
                e.preventDefault();
                return false;
            }
        };
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
@endsection