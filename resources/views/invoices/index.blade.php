@extends('layouts.app')

@section('content')
<div class="px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white uppercase tracking-tight">Accounts & Invoicing Hub</h2>
            <p class="mt-1 text-slate-500 dark:text-slate-400">Transform validated Delivery Challans (DC) into professional financial documents.</p>
        </div>
    </div>

    <!-- Ready to Invoice -->
    <div class="mb-12">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
            <div class="h-2 w-2 rounded-full bg-orange-500 animate-pulse"></div>
            Pending Invoicing (Ready DCs)
        </h3>
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">DC Number</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Distributor</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingSlips as $slip)
                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-700 dark:text-slate-300">#{{ $slip->slip_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-800 dark:text-white">{{ $slip->distributor->name }}</span>
                                <span class="text-xs text-slate-400">{{ $slip->distributor->company_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $slip->transaction_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-400 uppercase tracking-widest shadow-sm">
                                Ready
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @canEdit('invoices')
                            <a href="{{ route('invoices.create', ['slip' => $slip->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-[10px] font-black rounded-lg transition-all shadow-lg shadow-teal-900/20 active:scale-95 uppercase tracking-widest">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                Generate Billing
                            </a>
                            @else
                            <span class="text-xs text-slate-400 italic">Read-Only</span>
                            @endcanEdit
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 opacity-40">
                                <svg class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">No DCs Pending Invoicing</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Invoice Registry -->
    <div>
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Professional Invoice Registry
        </h3>
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
            <table class="w-full border-collapse datatable-luxury">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Invoice Unit</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Financial Type</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Distributor</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Grand Total</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Payment Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 dark:text-white">{{ $invoice->invoice_number }}</span>
                                <span class="text-[10px] text-slate-400 uppercase font-bold">Ref: #{{ $invoice->slip->slip_number }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col items-start gap-1">
                                @if($invoice->type === 'net')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400 uppercase tracking-tight">Net Invoice</span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 uppercase tracking-tight">Warranty Invoice</span>
                                @endif
                                
                                @if($invoice->due_date)
                                <span class="text-[9px] text-rose-500 font-black px-1 uppercase tracking-tighter italic shadow-sm bg-rose-50 dark:bg-rose-900/20 rounded">Due: {{ $invoice->due_date->format('d M, Y') }}</span>
                                @endif

                                @if($invoice->type === 'warranty')
                                <span class="text-[10px] text-amber-600 font-bold px-1">{{ number_format($invoice->discount_percentage, 0) }}% Reduc.</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-800 dark:text-white">{{ $invoice->slip->distributor->name }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">PM: {{ $invoice->projectManager->name ?? 'None' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 dark:text-white">Rs. {{ number_format($invoice->grand_total, 2) }}</span>
                                @if($invoice->adjustment_amount != 0)
                                <span class="text-[10px] font-bold {{ $invoice->adjustment_amount > 0 ? 'text-rose-500' : 'text-teal-500' }}">
                                    Adj: {{ $invoice->adjustment_amount > 0 ? '+' : '' }}{{ number_format($invoice->adjustment_amount, 2) }}
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($invoice->isNet())
                                <div class="flex flex-col items-center">
                                    @if($invoice->payment_status === 'paid')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-400 uppercase tracking-widest">Paid</span>
                                    @elseif($invoice->payment_status === 'partial')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-400 uppercase tracking-widest">Partial</span>
                                        <span class="text-[9px] font-bold text-rose-500 mt-1 uppercase tracking-tighter">Due: {{ number_format($invoice->remainingBalance(), 0) }}</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-400 uppercase tracking-widest">Pending</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-[10px] font-bold text-slate-400 uppercase italic">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('invoices.show', $invoice) }}" class="p-2 bg-slate-100 hover:bg-teal-100 text-slate-500 hover:text-teal-600 dark:bg-slate-800 dark:hover:bg-teal-900/30 dark:text-slate-400 dark:hover:text-teal-400 rounded-lg transition-colors" title="View Financial Breakdown">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('invoices.pdf', $invoice) }}" target="_blank" class="p-2 bg-slate-100 hover:bg-rose-100 text-slate-500 hover:text-rose-600 dark:bg-slate-800 dark:hover:bg-rose-900/30 dark:text-slate-400 dark:hover:text-rose-400 rounded-lg transition-colors" title="Download Professional PDF">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </a>
                                @if($invoice->type === 'net' && !$invoice->slip->is_warranty_invoiced)
                                <button onclick="openWarrantyModal({{ $invoice->id }}, '{{ $invoice->invoice_number }}')" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg transition-colors" title="Generate Warranty Slip">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Warranty Modal -->
<div id="warranty-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl w-full max-w-md overflow-hidden animate-in zoom-in duration-300">
        <div class="px-8 py-6 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-xs font-black text-amber-600 uppercase tracking-widest mb-1">Invoicing Action Required</h3>
            <p class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Deploy Warranty Slip for <span id="modal-invoice-num" class="text-indigo-600">--</span></p>
        </div>
        <form id="warranty-form" method="POST" action="">
            @csrf
            <div class="p-8">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 leading-relaxed italic border-l-2 border-amber-300 pl-4">
                    Warranty slips are calculated based on MRP with a fixed percentage reduction. This does not affect established financial ledger balances.
                </p>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Discount Percentage (%)</label>
                        <div class="relative">
                            <input type="number" name="discount_percentage" required min="0" max="100" step="0.1" value="10" 
                                class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-black text-slate-900 dark:text-white bg-white dark:bg-slate-800 shadow-inner focus:ring-4 focus:ring-amber-500/10 transition-all outline-none text-center">
                            <span class="absolute right-6 top-4 text-xs font-black text-slate-300">%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 bg-slate-50 dark:bg-slate-950 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-4">
                <button type="button" onclick="closeWarrantyModal()" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Discard</button>
                <button type="submit" class="inline-flex bg-emerald-100 dark:bg-emerald-900/30 items-center justify-center rounded-xl px-8 py-4 text-[10px] font-black text-white shadow-xl shadow-amber-500/20 hover:bg-amber-400 transition-all active:scale-95 uppercase tracking-[0.2em]">
                    Generate Slip
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openWarrantyModal(invoiceId, invoiceNum) {
        document.getElementById('modal-invoice-num').textContent = invoiceNum;
        document.getElementById('warranty-form').action = `/invoices/${invoiceId}/warranty`;
        document.getElementById('warranty-modal').classList.remove('hidden');
    }
    
    function closeWarrantyModal() {
        document.getElementById('warranty-modal').classList.add('hidden');
    }
</script>
@endsection
