@extends('layouts.app')

@section('content')
@php
    $initialPrices = $slip->items->mapWithKeys(function($item) {
        return [$item->product_id => [
            'sale' => (float)$item->product->sale_price,
            'mrp' => (float)$item->product->mrp,
            'cost' => (float)($item->product->purchase_price ?? $item->product->cost_price ?? 0),
            'qty' => (float)$item->quantity,
            'unit_price' => (float)($item->product->purchase_price ?? $item->product->cost_price ?? 0),
            'discount' => 0,
            'batches' => $item->product->batches->map(fn($b) => ['id' => $b->id, 'number' => $b->batch_number, 'qty' => $b->current_quantity])
        ]];
    });
@endphp

<div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8" x-data="invoiceManifest()">
    <script>
        function invoiceManifest() {
            return {
                items: @json($initialPrices),
                adjustment: 0,
                pms: @json($projectManagers),
                newPmName: '',
                pmLoading: false,
                
                addPm() {
                    if (!this.newPmName.trim()) return;
                    this.pmLoading = true;
                    fetch('{{ url('project-managers') }}', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ name: this.newPmName })
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            this.pms.push(res.pm);
                            this.newPmName = '';
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }
                    })
                    .catch(e => toastr.error('Communication error with registry hub.'))
                    .finally(() => this.pmLoading = false);
                },

                getRowGross(id) {
                    return this.items[id].unit_price * this.items[id].qty;
                },
                
                getRowNet(id) {
                    let gross = this.getRowGross(id);
                    let disc = this.items[id].discount / 100;
                    return gross * (1 - disc);
                },
                
                getManifestTotal() {
                    let total = 0;
                    Object.keys(this.items).forEach(id => {
                        total += this.getRowNet(id);
                    });
                    return total + parseFloat(this.adjustment || 0);
                }
            }
        }
    </script>
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6 font-sans">
        <div>
            <a href="{{ route('invoices.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-all uppercase tracking-[0.2em] mb-4 group">
                <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3" /></svg>
                Invoicing Hub
            </a>
            <h2 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-1 italic">Financial Draft #{{ \App\Models\Invoice::nextInvoiceNumber() }}</h2>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Generate Net Sale Invoice</h1>
        </div>
        
        <div class="flex items-center gap-4 bg-emerald-50 px-4 py-3 rounded-2xl border border-emerald-100 italic">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            <p class="text-[11px] font-bold text-emerald-800 uppercase tracking-widest leading-tight">Batch allocation and per-item discounting enabled for DC #{{ $slip->slip_number }}.</p>
        </div>
    </div>

    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf
        <input type="hidden" name="inventory_slip_id" value="{{ $slip->id }}">

        <!-- Top Header Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/20 p-8 mb-8 font-sans">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                <div class="flex items-center gap-6">
                    <div class="h-16 w-16 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-300 font-black text-2xl uppercase italic border border-slate-100">
                        {{ substr($slip->distributor->name, 0, 1) }}
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 text-xs">Billing Target</label>
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">{{ $slip->distributor->company_name ?? $slip->distributor->name }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $slip->distributor->city }} / {{ $slip->distributor->area }}</p>
                    </div>
                </div>

                <div class="col-span-1">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1 text-xs">Financial Due Date</label>
                    <input type="date" name="due_date" required class="w-full py-4 px-6 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black text-slate-900 outline-none focus:ring-4 focus:ring-emerald-500/5 transition-all">
                </div>

                <div class="col-span-1">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1 text-xs">Global Adjustment (Rs.)</label>
                    <input type="number" name="adjustment_amount" step="0.01" x-model="adjustment" placeholder="0.00" class="w-full py-4 px-6 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black text-slate-900 outline-none focus:ring-4 focus:ring-emerald-500/5 transition-all">
                </div>
            </div>
        </div>

        <!-- Manifest Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden mb-8 font-sans">
            <div class="bg-slate-50 border-b border-slate-200 py-4 px-8 flex items-center justify-between">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Multi-Batch Financial Manifest</h3>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest italic">Live Accounting Calculation</span>
            </div>

            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead>
                        <tr class="bg-slate-100/30 border-b border-slate-100 text-slate-400 uppercase text-[9px] tracking-[0.2em] font-black">
                            <th class="py-5 px-8">Product Spec</th>
                            <th class="py-5 px-4 text-center">Qty</th>
                            <th class="py-5 px-4">Batch Allocation</th>
                            <th class="py-5 px-4 text-center">Rate</th>
                            <th class="py-5 px-4 text-center">Gross</th>
                            <th class="py-5 px-4 text-center">Discount %</th>
                            <th class="py-5 px-8 text-right">Net Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($slip->items as $item)
                        <tr class="hover:bg-slate-50/50 transition-all font-sans">
                            <td class="py-6 px-8">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $item->product->name }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">{{ $item->product->brand->name ?? 'Direct' }}</span>
                                </div>
                            </td>
                            <td class="py-6 px-4 text-center">
                                <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-[10px] font-black text-slate-600 uppercase tracking-tighter">
                                    {{ number_format($item->quantity, 0) }} {{ $item->product->unit->short_name }}
                                </span>
                            </td>
                            <td class="py-6 px-4">
                                <select name="items[{{ $item->product_id }}][product_batch_id]" required 
                                    class="w-full rounded-xl border-slate-200 py-2.5 px-4 text-[10px] font-black text-slate-800 bg-white shadow-sm focus:ring-4 focus:ring-emerald-500/5 transition-all outline-none">
                                    <option value="">Select Batch...</option>
                                    @foreach($item->product->batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->batch_number }} (Rem: {{ $batch->current_quantity }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-6 px-4">
                                <input type="number" name="items[{{ $item->product_id }}][unit_price]" step="0.01" x-model="items[{{ $item->product_id }}].unit_price"
                                    class="w-32 mx-auto py-2.5 px-4 border border-slate-200 rounded-xl text-center text-xs font-black text-slate-900 outline-none focus:border-emerald-500 transition-all">
                            </td>
                            <td class="py-6 px-4 text-center">
                                <span class="text-xs font-bold text-slate-400 italic">Rs. <span x-text="getRowGross({{ $item->product_id }}).toLocaleString(undefined, {minimumFractionDigits: 2})"></span></span>
                            </td>
                            <td class="py-6 px-4">
                                <div class="relative w-24 mx-auto">
                                    <input type="number" name="items[{{ $item->product_id }}][discount_percentage]" step="0.1" x-model="items[{{ $item->product_id }}].discount"
                                        class="w-full py-2.5 px-4 pr-8 border border-slate-200 rounded-xl text-center text-xs font-black text-emerald-600 outline-none focus:border-emerald-500 transition-all">
                                    <span class="absolute right-3 top-2.5 text-[10px] font-black text-slate-300">%</span>
                                </div>
                            </td>
                            <td class="py-6 px-8 text-right">
                                <span class="text-sm font-black text-slate-900 tracking-tighter shadow-sm">
                                    Rs. <span x-text="getRowNet({{ $item->product_id }}).toLocaleString(undefined, {minimumFractionDigits: 2})"></span>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-900">
                            <td colspan="5" class="py-8 px-8 text-right">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.4em]">Integrated Financial Total</span>
                            </td>
                            <td colspan="2" class="py-8 px-8 text-right">
                                <div class="flex flex-col items-end">
                                    <span class="text-3xl font-black text-white tracking-tighter">
                                        PKR <span x-text="getManifestTotal().toLocaleString(undefined, {minimumFractionDigits: 2})"></span>
                                    </span>
                                    <span class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest mt-1 italic italic">Allocated to accounts upon commitment</span>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12 font-sans">
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-xl shadow-slate-200/20">
                <div class="mb-6 px-1 flex justify-between items-center">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Project Accountability</label>
                    <span class="text-[9px] font-bold text-teal-600 uppercase tracking-widest cursor-pointer hover:underline" @click="$refs.pmRegistry.classList.toggle('hidden')">Personnel Registry</span>
                </div>
                <select name="project_manager_id" required class="w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 outline-none focus:ring-4 focus:ring-emerald-500/5 transition-all">
                    <option value="">Select Project Manager</option>
                    <template x-for="pm in pms" :key="pm.id">
                        <option :value="pm.id" x-text="pm.name"></option>
                    </template>
                </select>

                <div x-ref="pmRegistry" class="hidden mt-4 p-5 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl animate-in fade-in duration-300">
                    <div class="flex gap-2">
                        <input type="text" x-model="newPmName" placeholder="Name" class="flex-1 py-3 px-4 bg-white border border-slate-200 rounded-xl text-xs font-bold outline-none">
                        <button type="button" @click="addPm()" class="px-5 py-3 bg-slate-900 text-white text-[9px] font-black rounded-xl uppercase tracking-widest active:scale-95 transition-transform">Add</button>
                    </div>
                </div>

                <div class="mt-8">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Ledger Notes</label>
                    <textarea name="notes" rows="3" placeholder="Logistical details..." class="w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-slate-50 outline-none focus:border-emerald-500 transition-all resize-none"></textarea>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="bg-emerald-600 rounded-3xl p-10 shadow-2xl shadow-emerald-600/30 flex flex-col items-center justify-center text-center group">
                    <div class="h-14 w-14 rounded-2xl bg-white/10 flex items-center justify-center text-white mb-6 backdrop-blur-md">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <h4 class="text-sm font-black text-white uppercase tracking-[0.2em] mb-2 italic underline decoration-white/20">Manifest Execution</h4>
                    <p class="text-[10px] font-bold text-emerald-100 uppercase leading-relaxed tracking-widest mb-10">Committing this manifest will update financial ledgers and distributor standing.</p>
                    
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-2xl bg-white px-10 py-5 text-xs font-black text-emerald-600 shadow-xl hover:bg-slate-50 transition-all active:scale-[0.98] uppercase tracking-[0.3em]">
                        Finalize Finance Flow
                    </button>
                </div>
                
                <a href="{{ route('invoices.index') }}" class="text-center text-[9px] font-black text-slate-400 hover:text-slate-600 transition-all uppercase tracking-[0.3em] font-sans">
                    Abort Draft Manifest & Return to Hub
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
