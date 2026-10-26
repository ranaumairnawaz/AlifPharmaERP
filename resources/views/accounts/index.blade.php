@extends('layouts.app')

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Finance & Accounts Ledger</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Unified view of all income, expenses, and
                financial position.</p>
        </div>
        @canEdit('accounts')
        <div class="flex items-center gap-3">
            <a href="{{ route('accounts.income.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-black text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-500 transition-all uppercase tracking-widest">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Log Income
            </a>
            <a href="{{ route('accounts.expense.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-black text-white shadow-lg shadow-rose-600/20 hover:bg-rose-500 transition-all uppercase tracking-widest">
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                </svg>
                Log Expense
            </a>
        </div>
        @endcanEdit
    </div>

    {{-- Distributor Accounts Summary --}}
    @php
        $distributors = \App\Models\Distributor::where('is_active', true)->orWhereHas('inventorySlips.invoices')->get()->map(function($distributor) {
            $invoices = \App\Models\Invoice::whereHas('slip', function($q) use ($distributor) {
                $q->where('distributor_id', $distributor->id);
            })->get();

            $lifetime = $invoices->sum('grand_total');
            $cleared = $invoices->sum('paid_amount');
            $remaining = $lifetime - $cleared;

            return (object) [
                'name' => $distributor->name,
                'company_name' => $distributor->company_name,
                'lifetime' => $lifetime,
                'cleared' => $cleared,
                'remaining' => $remaining
            ];
        });
    @endphp

    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden font-sans">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex justify-between items-center">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Distributor Ledger Summary</h3>
            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Financial Overview</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Distributor Name</th>
                        <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Company</th>
                        <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Lifetime Amount</th>
                        <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Cleared Amount</th>
                        <th class="px-6 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Remaining Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($distributors as $dist)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-3 font-bold text-slate-900 dark:text-slate-100">
                            {{ $dist->name }}
                        </td>
                        <td class="px-6 py-3 text-xs text-slate-500 dark:text-slate-400">
                            {{ $dist->company_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-3 text-right font-semibold text-slate-800 dark:text-slate-200">
                            Rs.{{ number_format($dist->lifetime, 2) }}
                        </td>
                        <td class="px-6 py-3 text-right font-semibold text-emerald-600">
                            Rs.{{ number_format($dist->cleared, 2) }}
                        </td>
                        <td class="px-6 py-3 text-right font-black {{ $dist->remaining > 0 ? 'text-amber-600' : 'text-slate-500' }}">
                            Rs.{{ number_format($dist->remaining, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-xs text-slate-400 font-bold uppercase">
                            No distributors found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Net P&L --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border {{ $netPL >= 0 ? 'border-emerald-100 dark:border-emerald-900/40' : 'border-rose-100 dark:border-rose-900/40' }} shadow-sm p-6">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Net P&L (Period)</p>
            <p class="text-2xl font-black tracking-tighter {{ $netPL >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                {{ $netPL >= 0 ? '+' : '' }}Rs.{{ number_format($netPL, 0) }}
            </p>
            <p class="text-[10px] text-slate-400 mt-1 font-bold">{{ \Carbon\Carbon::parse($startDate)->format('d M') }}
                → {{ \Carbon\Carbon::parse($endDate)->format('d M, Y') }}</p>
        </div>

        {{-- Total Income --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-emerald-100 dark:border-emerald-900/40 shadow-sm p-6">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Income</p>
            <p class="text-2xl font-black text-emerald-600 tracking-tighter">Rs.{{ number_format($totalIncome, 0) }}</p>
            <p class="text-[10px] text-slate-400 mt-1 font-bold">Received this period</p>
        </div>

        {{-- Total Expenses --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-rose-100 dark:border-rose-900/40 shadow-sm p-6">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Expenses</p>
            <p class="text-2xl font-black text-rose-600 tracking-tighter">Rs.{{ number_format($totalExpense, 0) }}</p>
            <p class="text-[10px] text-slate-400 mt-1 font-bold">All outflows this period</p>
        </div>

        {{-- Outstanding Receivables --}}
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-amber-100 dark:border-amber-900/40 shadow-sm p-6">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Receivables</p>
            <p class="text-2xl font-black text-amber-600 tracking-tighter">Rs.{{ number_format($receivables, 0) }}</p>
            <p class="text-[10px] text-slate-400 mt-1 font-bold">Unpaid invoice balances</p>
        </div>
    </div>

    {{-- Assets / Liabilities --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-indigo-100 dark:border-indigo-900/40 shadow-sm p-6">
            <p
                class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 border-b border-indigo-50 dark:border-indigo-900/20 pb-2">
                Assets — Current Valuation</p>
            <div class="grid grid-cols-3 gap-2">
                <div>
                    <p class="text-[10px] text-slate-500 font-bold mb-1 leading-tight">Finished<br>Goods</p>
                    <p class="text-lg font-black text-indigo-600 tracking-tighter">
                        Rs.{{ number_format($assetValue, 0) }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-slate-500 font-bold mb-1 leading-tight">Raw<br>Materials</p>
                    <p class="text-lg font-black text-teal-600 tracking-tighter">
                        Rs.{{ number_format($rawAssetValue, 0) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-slate-500 font-bold mb-1 leading-tight">Accounts<br>Receivable</p>
                    <p class="text-lg font-black text-amber-600 tracking-tighter">
                        Rs.{{ number_format($receivables, 0) }}</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-indigo-50 dark:border-indigo-900/20 flex justify-between items-end">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Liquid Assets</p>
                <p class="text-xl font-black text-slate-900 dark:text-white tracking-tighter">
                    Rs.{{ number_format($assetValue + $rawAssetValue + $receivables, 0) }}</p>
            </div>
        </div>
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-rose-100 dark:border-rose-900/40 shadow-sm p-6 flex flex-col justify-between">
            <div>
                <p
                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 border-b border-rose-50 dark:border-rose-900/20 pb-2">
                    Liabilities & Corporate Value</p>
                <div class="flex justify-between items-end mb-4">
                    <div>
                        <p class="text-[10px] text-slate-500 font-bold mb-1 leading-tight">Accounts Payable<br><span
                                class="text-rose-400 font-medium">(Vendor Debt)</span></p>
                        <p class="text-lg font-black text-rose-600 tracking-tighter">
                            Rs.{{ number_format($payables, 0) }}</p>
                    </div>
                    <div class="text-right">
                        @php $netPosition = ($assetValue + $rawAssetValue + $receivables) - $payables; @endphp
                        <p class="text-[10px] text-slate-500 font-bold mb-1 leading-tight"><br>Net Position</p>
                        <p
                            class="text-lg font-black {{ $netPosition >= 0 ? 'text-emerald-600' : 'text-rose-600' }} tracking-tighter">
                            Rs.{{ number_format($netPosition, 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ledger Table --}}
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        {{-- Filters --}}
        <div
            class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Transaction Ledger</h3>
            <form method="GET" action="{{ route('accounts.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="rounded-lg border-slate-200 dark:border-slate-700 text-xs font-bold py-2 px-3 bg-white dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500">
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="rounded-lg border-slate-200 dark:border-slate-700 text-xs font-bold py-2 px-3 bg-white dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500">
                <select name="filter"
                    class="rounded-lg border-slate-200 dark:border-slate-700 text-xs font-bold py-2 px-3 bg-white dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500">
                    <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>All Transactions</option>
                    <option value="income" {{ $filter === 'income' ? 'selected' : '' }}>Income Only</option>
                    <option value="expense" {{ $filter === 'expense' ? 'selected' : '' }}>Expenses Only</option>
                </select>
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-teal-600 px-4 py-2 text-xs font-black text-white hover:bg-teal-500 transition-all uppercase tracking-widest">Apply</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table id="ledger-table" class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            Description</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category
                        </th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Type</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Amount</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                            Status</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($ledger as $row)
                    <tr
                        class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group {{ $row->type === 'income' ? 'border-l-2 border-emerald-400' : 'border-l-2 border-rose-400' }}">
                        <td class="px-6 py-3.5">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                {{ \Carbon\Carbon::parse($row->date)->format('d M, Y') }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 max-w-xs">
                            <p class="text-xs font-bold text-slate-900 dark:text-slate-100 truncate">{{ $row->title }}
                            </p>
                        </td>
                        <td class="px-6 py-3.5">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider
                                {{ $row->type === 'income' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400' : 'bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400' }}">
                                {{ $row->category }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5">
                            <span
                                class="text-[10px] font-black uppercase tracking-widest {{ $row->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $row->type }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <span
                                class="text-sm font-black font-mono tracking-tighter {{ $row->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $row->type === 'income' ? '+' : '-' }}Rs.{{ number_format($row->amount, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-center">
                            <span
                                class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest
                                {{ in_array($row->status, ['received', 'paid']) ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ $row->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            @if($row->delete_route && $row->id)
                            @canDelete('accounts')
                                <form id="delete-form-{{ $row->type }}-{{ $row->id }}"
                                    action="{{ route($row->delete_route, $row->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                        onclick="confirmDelete(this.closest('form').id, 'Delete Entry?', 'This cannot be undone.')"
                                        class="p-1.5 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endcanDelete
                            @else
                            <span class="text-[9px] text-slate-300 font-bold uppercase tracking-wider">Read-Only</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-400 font-bold">
                            No transactions found for the selected period.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#ledger-table').DataTable({ order: [[0, 'desc']], pageLength: 25 });
    });
</script>
@endsection