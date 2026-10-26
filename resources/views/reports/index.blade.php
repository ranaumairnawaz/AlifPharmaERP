@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Intelligence & Analytics Hub</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Sales, Profitability, Payroll, Procurement, P&L Statement, and Asset Valuation.</p>
    </div>
</div>

<!-- Report Filtering -->
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 mb-8 overflow-hidden relative group">
    <div class="absolute inset-0 bg-gradient-to-r from-teal-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
    <form action="{{ route('reports.index') }}" method="GET" class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
        <div class="lg:col-span-2">
            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Analytics Mode</label>
            <select name="type" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-3 text-xs font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                <optgroup label="── Sales & Revenue ──">
                    <option value="sales"       {{ $type == 'sales' ? 'selected' : '' }}>Sales Summary</option>
                    <option value="receivables" {{ $type == 'receivables' ? 'selected' : '' }}>Receivables (Aging Debt)</option>
                    <option value="profit"      {{ $type == 'profit' ? 'selected' : '' }}>Profitability Analysis</option>
                    <option value="turnover"    {{ $type == 'turnover' ? 'selected' : '' }}>Inventory Turnover</option>
                </optgroup>
                <optgroup label="── Finance & Accounts ──">
                    <option value="pl_statement" {{ $type == 'pl_statement' ? 'selected' : '' }}>P&L Statement (Full)</option>
                    <option value="expenses"     {{ $type == 'expenses' ? 'selected' : '' }}>Expense Breakdown</option>
                    <option value="assets"       {{ $type == 'assets' ? 'selected' : '' }}>Asset Valuation</option>
                </optgroup>
                <optgroup label="── Operations ──">
                    <option value="payroll"     {{ $type == 'payroll' ? 'selected' : '' }}>Payroll Summary</option>
                    <option value="procurement" {{ $type == 'procurement' ? 'selected' : '' }}>Material Procurement</option>
                </optgroup>
            </select>
        </div>

        <div>
            <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Temporal Scope</label>
            <select name="timeframe" id="timeframe_select" onchange="toggleCustomDates()" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-3 text-xs font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                <option value="daily"   {{ $timeframe == 'daily' ? 'selected' : '' }}>Daily (Today)</option>
                <option value="weekly"  {{ $timeframe == 'weekly' ? 'selected' : '' }}>Weekly (This Week)</option>
                <option value="monthly" {{ $timeframe == 'monthly' ? 'selected' : '' }}>Monthly (This Month)</option>
                <option value="yearly"  {{ $timeframe == 'yearly' ? 'selected' : '' }}>Yearly (This Year)</option>
                <option value="custom"  {{ $timeframe == 'custom' ? 'selected' : '' }}>Custom Range</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-3 text-xs font-bold text-white shadow-sm hover:bg-teal-500 transition-all uppercase tracking-widest">
                Generate
            </button>
            <a href="{{ route('reports.financial.pdf', request()->all()) }}" target="_blank" class="p-2.5 rounded-lg border border-teal-200 bg-teal-50 text-teal-600 hover:bg-teal-100 transition-colors shadow-sm" title="Export PDF">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </a>
        </div>

        <!-- Custom Dates -->
        <div id="custom_dates" class="col-span-full grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100" style="{{ $timeframe == 'custom' ? '' : 'display:none;' }}">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500">
            </div>
        </div>
    </form>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 text-center">
    @if($type === 'sales')
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Total Booked Sales</dt>
            <dd class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter">Rs.{{ number_format($summary['revenue'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-emerald-500/20 shadow-sm p-6 flex flex-col items-center bg-emerald-50/10">
            <dt class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] mb-1">Cash Collected</dt>
            <dd class="text-2xl font-black text-emerald-600 tracking-tighter">Rs.{{ number_format($summary['collected'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-rose-500/20 shadow-sm p-6 flex flex-col items-center bg-rose-50/10">
            <dt class="text-[10px] font-bold text-rose-500 uppercase tracking-[0.2em] mb-1">Outstanding</dt>
            <dd class="text-2xl font-black text-rose-600 tracking-tighter">Rs.{{ number_format($summary['outstanding'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Collection Rate</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">{{ $summary['revenue'] > 0 ? number_format(($summary['collected'] / $summary['revenue']) * 100, 1) : 0 }}%</dd>
        </div>

    @elseif($type === 'receivables')
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-rose-500/20 shadow-sm p-6 flex flex-col items-center col-span-2 bg-rose-50/10">
            <dt class="text-xs font-bold text-rose-500 uppercase tracking-[0.2em] mb-1">Total Aging Debt</dt>
            <dd class="text-4xl font-black text-rose-600 tracking-tighter">Rs.{{ number_format($summary['outstanding'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Pending Invoices</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">{{ $summary['count'] }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Avg Debt / Invoice</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">Rs.{{ number_format($summary['avg_debt'], 2) }}</dd>
        </div>

    @elseif($type === 'turnover')
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Total COGS</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">Rs.{{ number_format($summary['cogs'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Inventory Value</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">Rs.{{ number_format($summary['avg_stock'], 2) }}</dd>
        </div>
        <div class="col-span-2 bg-white dark:bg-slate-900/50 rounded-xl border border-teal-200 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-teal-500 uppercase tracking-[0.2em] mb-1">Turnover Ratio</dt>
            <dd class="text-4xl font-black text-teal-600 tracking-tighter">{{ number_format($summary['ratio'], 2) }}x</dd>
        </div>

    @elseif($type === 'payroll')
        <div class="col-span-2 bg-white dark:bg-slate-900/50 rounded-xl border border-indigo-200 shadow-sm p-8 flex flex-col items-center bg-indigo-50/10">
            <dt class="text-xs font-black text-indigo-400 uppercase tracking-[0.3em] mb-2">Total Salary Disbursed</dt>
            <dd class="text-4xl font-black text-indigo-600 tracking-tighter">Rs.{{ number_format($summary['payroll'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Payments Made</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">{{ $summary['staff'] }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Avg Salary</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">Rs.{{ number_format($summary['avg'], 2) }}</dd>
        </div>

    @elseif($type === 'expenses')
        <div class="col-span-2 bg-white dark:bg-slate-900/50 rounded-xl border border-rose-200 shadow-sm p-6 flex flex-col items-center bg-rose-50/10">
            <dt class="text-[10px] font-bold text-rose-400 uppercase tracking-[0.2em] mb-1">Total Expenses</dt>
            <dd class="text-3xl font-black text-rose-600 tracking-tighter">Rs.{{ number_format($summary['total'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Transactions</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">{{ $summary['count'] }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Categories</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">{{ count($summary['by_category']) }}</dd>
        </div>

    @elseif($type === 'procurement')
        <div class="col-span-2 bg-white dark:bg-slate-900/50 rounded-xl border border-teal-200 shadow-sm p-6 flex flex-col items-center bg-teal-50/10">
            <dt class="text-[10px] font-bold text-teal-500 uppercase tracking-[0.2em] mb-1">Total Procurement Spend</dt>
            <dd class="text-3xl font-black text-teal-600 tracking-tighter">Rs.{{ number_format($summary['total_spend'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Entry Slips</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">{{ $summary['entry_count'] }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Total Units Received</dt>
            <dd class="text-2xl font-black text-slate-900 tracking-tighter">{{ number_format($summary['total_units'], 0) }}</dd>
        </div>

    @elseif($type === 'pl_statement')
        {{-- Full P&L — no table rows, show full statement as cards --}}
        <div class="col-span-full grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Income Column --}}
            <div class="bg-emerald-50/30 dark:bg-emerald-900/10 rounded-xl border border-emerald-200 dark:border-emerald-900/40 p-6 space-y-4">
                <h3 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest border-b border-emerald-200 pb-3">Income</h3>
                <div class="flex justify-between text-sm"><span class="text-slate-600 font-bold">Invoice Revenue</span><span class="font-black text-emerald-700">Rs.{{ number_format($summary['invoice_revenue'], 2) }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-slate-600 font-bold">Other Income</span><span class="font-black text-emerald-700">Rs.{{ number_format($summary['manual_income'], 2) }}</span></div>
                <div class="flex justify-between text-sm pt-2 border-t border-emerald-200"><span class="text-emerald-700 font-black uppercase text-xs tracking-wider">Total Income</span><span class="font-black text-xl text-emerald-700">Rs.{{ number_format($summary['total_income'], 2) }}</span></div>
            </div>
            {{-- Expense Column --}}
            <div class="bg-rose-50/30 dark:bg-rose-900/10 rounded-xl border border-rose-200 dark:border-rose-900/40 p-6 space-y-4">
                <h3 class="text-[10px] font-black text-rose-600 uppercase tracking-widest border-b border-rose-200 pb-3">Expenses</h3>
                <div class="flex justify-between text-sm"><span class="text-slate-600 font-bold">Material Purchases</span><span class="font-black text-rose-700">Rs.{{ number_format($summary['material_cost'], 2) }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-slate-600 font-bold">Salaries Paid</span><span class="font-black text-rose-700">Rs.{{ number_format($summary['salary_cost'], 2) }}</span></div>
                <div class="flex justify-between text-sm"><span class="text-slate-600 font-bold">Other Expenses</span><span class="font-black text-rose-700">Rs.{{ number_format($summary['other_expenses'], 2) }}</span></div>
                <div class="flex justify-between text-sm pt-2 border-t border-rose-200"><span class="text-rose-700 font-black uppercase text-xs tracking-wider">Total Expenses</span><span class="font-black text-xl text-rose-700">Rs.{{ number_format($summary['total_expenses'], 2) }}</span></div>
            </div>
            {{-- Net P&L Column --}}
            <div class="{{ $summary['net_pl'] >= 0 ? 'bg-emerald-50/50 border-emerald-300' : 'bg-rose-50/50 border-rose-300' }} dark:bg-slate-800 rounded-xl border p-6 flex flex-col items-center justify-center text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Net Profit / Loss</p>
                <p class="text-4xl font-black {{ $summary['net_pl'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }} tracking-tighter">
                    {{ $summary['net_pl'] >= 0 ? '+' : '' }}Rs.{{ number_format($summary['net_pl'], 2) }}
                </p>
                <p class="mt-3 text-xs font-bold {{ $summary['net_pl'] >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                    {{ $summary['net_pl'] >= 0 ? '✓ Profitable Period' : '⚠ Operating at Loss' }}
                </p>
            </div>
        </div>

    @elseif($type === 'assets')
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-indigo-200 shadow-sm p-6 flex flex-col items-center bg-indigo-50/10">
            <dt class="text-[10px] font-bold text-indigo-500 uppercase tracking-[0.2em] mb-1">Finished Goods</dt>
            <dd class="text-xl font-black text-indigo-600 tracking-tighter">Rs.{{ number_format($summary['fg_value'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-teal-200 shadow-sm p-6 flex flex-col items-center bg-teal-50/10">
            <dt class="text-[10px] font-bold text-teal-500 uppercase tracking-[0.2em] mb-1">Raw Materials</dt>
            <dd class="text-xl font-black text-teal-600 tracking-tighter">Rs.{{ number_format($summary['rm_value'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-amber-200 shadow-sm p-6 flex flex-col items-center bg-amber-50/10">
            <dt class="text-[10px] font-bold text-amber-500 uppercase tracking-[0.2em] mb-1">Packaging Materials</dt>
            <dd class="text-xl font-black text-amber-600 tracking-tighter">Rs.{{ number_format($summary['pm_value'], 2) }}</dd>
        </div>
        <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-300 shadow-sm p-6 flex flex-col items-center">
            <dt class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-1">Total Asset Value</dt>
            <dd class="text-xl font-black text-slate-900 dark:text-white tracking-tighter">Rs.{{ number_format($summary['total_value'], 2) }}</dd>
        </div>
    @endif
</div>

<!-- Data Table (hidden for pl_statement) -->
@if($type !== 'pl_statement' && count($results) > 0)
<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Detail Records ({{ strtoupper($type) }})</p>
    </div>
    <div class="overflow-x-auto">
        <table id="reports-table" class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50/50 text-slate-400 border-b border-slate-200 dark:border-slate-800">
                <tr>
                    <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Date</th>
                    @if($type === 'sales')
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Invoice #</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Distributor</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-right">Revenue</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-center">Status</th>
                    @elseif($type === 'receivables')
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Invoice #</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Distributor</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-right">Total</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-right">Unpaid</th>
                    @elseif($type === 'profit')
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Product</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-center">Units Sold</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-right">Profit</th>
                    @elseif($type === 'payroll')
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Employee</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Designation</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-right">Net Salary</th>
                    @elseif($type === 'turnover')
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Product</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-center">Turnover</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-right">Stock Value</th>
                    @elseif($type === 'expenses')
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Description</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Category</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-right">Amount</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-center">Status</th>
                    @elseif($type === 'procurement')
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Slip #</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Source</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-right">Amount</th>
                    @elseif($type === 'assets')
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Product</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em]">Type</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-center">Stock</th>
                        <th class="py-4 px-6 font-bold uppercase text-[9px] tracking-[0.2em] text-right">Value (@ Cost)</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($results as $item)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="py-3 px-6 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                        @if(in_array($type, ['profit','turnover','assets']))N/A
                        @elseif($type === 'payroll') {{ \Carbon\Carbon::parse($item->paid_at)->format('M d, Y') }}
                        @elseif($type === 'expenses') {{ \Carbon\Carbon::parse($item->expense_date)->format('M d, Y') }}
                        @elseif($type === 'procurement') {{ \Carbon\Carbon::parse($item->transaction_date)->format('M d, Y') }}
                        @else {{ $item->created_at->format('M d, Y') }}
                        @endif
                    </td>
                    @if($type === 'sales')
                        <td class="py-3 px-6 font-mono font-bold text-teal-600">{{ $item->invoice_number }}</td>
                        <td class="py-3 px-6 text-slate-500 font-bold uppercase text-[10px]">{{ $item->slip->distributor->name ?? 'N/A' }}</td>
                        <td class="py-3 px-6 text-right font-black">Rs.{{ number_format($item->grand_total, 2) }}</td>
                        <td class="py-3 px-6 text-center">
                            <span class="{{ $item->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($item->payment_status === 'partial' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }} text-[8px] font-black px-2 py-0.5 rounded uppercase">
                                {{ $item->payment_status }}
                            </span>
                        </td>
                    @elseif($type === 'receivables')
                        <td class="py-3 px-6 font-mono font-bold text-rose-600">{{ $item->invoice_number }}</td>
                        <td class="py-3 px-6 text-slate-500 font-bold uppercase text-[10px]">{{ $item->slip->distributor->name ?? 'N/A' }}</td>
                        <td class="py-3 px-6 text-right text-slate-400 font-bold text-xs">Rs.{{ number_format($item->grand_total, 2) }}</td>
                        <td class="py-3 px-6 text-right font-black text-rose-600">Rs.{{ number_format($item->remainingBalance(), 2) }}</td>
                    @elseif($type === 'profit')
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">{{ $item->product_name }}</td>
                        <td class="py-3 px-6 text-center font-bold text-indigo-500">{{ number_format($item->total_sold, 1) }}</td>
                        <td class="py-3 px-6 text-right font-black text-teal-600">Rs.{{ number_format($item->profit, 2) }}</td>
                    @elseif($type === 'payroll')
                        <td class="py-3 px-6 font-bold">{{ $item->employee->name ?? 'Unknown' }}</td>
                        <td class="py-3 px-6 italic text-slate-500 uppercase text-[10px]">{{ $item->designation }}</td>
                        <td class="py-3 px-6 text-right font-black text-indigo-600">Rs.{{ number_format($item->net_salary, 2) }}</td>
                    @elseif($type === 'turnover')
                        <td class="py-3 px-6 font-bold">{{ $item->product_name }}</td>
                        <td class="py-3 px-6 text-center font-black text-emerald-600">{{ $item->stock_value > 0 ? number_format($item->cogs / $item->stock_value, 2) : '0' }}x</td>
                        <td class="py-3 px-6 text-right font-black text-rose-500">Rs.{{ number_format($item->stock_value, 2) }}</td>
                    @elseif($type === 'expenses')
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300 max-w-xs truncate">{{ $item->description }}</td>
                        <td class="py-3 px-6"><span class="bg-rose-50 text-rose-700 text-[9px] font-black px-2 py-0.5 rounded uppercase tracking-wide">{{ $item->category }}</span></td>
                        <td class="py-3 px-6 text-right font-black text-rose-600">Rs.{{ number_format($item->amount, 2) }}</td>
                        <td class="py-3 px-6 text-center"><span class="{{ $item->status === 'paid' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }} text-[9px] font-black px-2 py-0.5 rounded uppercase">{{ $item->status }}</span></td>
                    @elseif($type === 'procurement')
                        <td class="py-3 px-6 font-mono font-bold text-teal-600">{{ $item->slip_number }}</td>
                        <td class="py-3 px-6 font-bold text-slate-700">{{ $item->source }}</td>
                        <td class="py-3 px-6 text-right font-black text-teal-700">Rs.{{ number_format($item->total_amount, 2) }}</td>
                    @elseif($type === 'assets')
                        <td class="py-3 px-6 font-bold text-slate-700 dark:text-slate-300">{{ $item->name }}</td>
                        <td class="py-3 px-6"><span class="text-[9px] font-black uppercase px-2 py-0.5 rounded {{ $item->material_type === 'finished_good' ? 'bg-indigo-50 text-indigo-700' : ($item->material_type === 'raw_material' ? 'bg-teal-50 text-teal-700' : 'bg-amber-50 text-amber-700') }}">{{ str_replace('_', ' ', $item->material_type) }}</span></td>
                        <td class="py-3 px-6 text-center font-mono font-bold text-slate-600">{{ number_format($item->current_stock, 2) }}</td>
                        <td class="py-3 px-6 text-right font-black text-indigo-600">Rs.{{ number_format($item->stock_value, 2) }}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<script>
$(document).ready(function() {
    $('#reports-table').DataTable({ order: [[0, 'desc']] });
});
function toggleCustomDates() {
    var val = document.getElementById('timeframe_select').value;
    document.getElementById('custom_dates').style.display = (val === 'custom') ? 'grid' : 'none';
}
</script>
@endsection
