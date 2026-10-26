@extends('layouts.app')

@section('content')
    <div class="space-y-8 pb-10 px-4">
        <!-- Header Strategy Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-teal-500"></span>
                    <h2 class="text-[10px] font-bold text-teal-600 dark:text-teal-400 uppercase tracking-widest font-sans">
                        Strategic Command Hub</h2>
                </div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight leading-none">Executive
                    Intelligence</h1>
            </div>
            <div class="flex items-center gap-3">
                <div
                    class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm flex items-center gap-3">
                    <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">System
                        Live: {{ now()->format('H:i T') }}</span>
                </div>
            </div>
        </div>

        <!-- Tier 1: Primary KPI Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Asset Valuation -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm group transition-all hover:border-teal-500/20 relative overflow-hidden">
                <div
                    class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity text-teal-600">
                    <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Total Inventory Value</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tighter mb-1">
                    Rs.{{ number_format($totalValuation, 0) }}</h3>
                <span class="text-[10px] font-bold text-teal-600 dark:text-teal-400 uppercase tracking-tight">Active Stock
                    Valuation</span>
            </div>

            <!-- Profit Potential -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm group transition-all hover:border-indigo-500/20 relative overflow-hidden">
                <div
                    class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity text-indigo-600">
                    <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M21 16.5c0 .38-.21.71-.53.88l-7.97 4.19c-.32.17-.69.17-1 0l-7.97-4.19c-.32-.17-.53-.5-.53-.88V7.5c0-.38.21-.71.53-.88l7.97-4.19c.32-.17.69-.17 1 0l7.97 4.19c.32.17.53.5.53.88v9z" />
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Projected Revenue</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tighter mb-1">
                    Rs.{{ number_format($potentialRevenue, 0) }}</h3>
                <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-tight">Estimated
                    Market Return</span>
            </div>

            <!-- Financial Exposure: Receivables -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm group transition-all hover:border-rose-500/20 relative overflow-hidden">
                <div
                    class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity text-rose-600">
                    <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L1 21h22L12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z" />
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Pending Receivables</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tighter mb-1">
                    Rs.{{ number_format($totalOutstanding, 0) }}</h3>
                <span class="text-[10px] font-bold text-rose-500 dark:text-rose-400 uppercase tracking-tight">Total
                    Uncollected Invoices</span>
            </div>

            <!-- Financial Exposure: Payables -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm group transition-all hover:border-indigo-500/20 relative overflow-hidden">
                <div
                    class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity text-indigo-600">
                    <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Pending Payables</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tighter mb-1">
                    Rs.{{ number_format($totalPayables, 0) }}</h3>
                <span class="text-[10px] font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-tight">Total
                    Unpaid Procurement</span>
            </div>

            <!-- Operational Loss -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm group transition-all hover:border-amber-500/20 relative overflow-hidden">
                <div
                    class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity text-amber-600">
                    <svg class="h-24 w-24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z" />
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Institutional Wastage</p>
                <h3 class="text-2xl font-black text-slate-800 dark:text-white tracking-tighter mb-1">
                    Rs.{{ number_format($totalLoss, 0) }}</h3>
                <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-tight">Value Lost
                    to Damages</span>
            </div>
        </div>

        <!-- Tier 2: Analytical Flux -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch w-full">
            <!-- Revenue Trend Chart -->
            <div
                class="col-span-2 lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-8 flex flex-col w-full">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-base font-black text-slate-800 dark:text-white tracking-tight leading-none mb-1">
                            Fiscal Performance Matrix</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">6-Month Strategic
                            Movement Trends</p>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="h-2 w-2 rounded-full bg-teal-500 animate-pulse"></div>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest italic">Live Projection
                            Mode</span>
                    </div>
                </div>
                <div class="flex-1 relative min-h-[300px] w-full">
                    <canvas id="revenueTrendChart"></canvas>
                </div>
            </div>

            <!-- Tier 2 Right Column: Top Performers & Health -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Top Performing Groups Card (Group-Wise) -->
                <div
                    class="bg-slate-900 dark:bg-slate-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden group h-full flex flex-col">
                    <div class="relative z-10">
                        <h3 class="text-[10px] font-black text-teal-400 uppercase tracking-[0.3em] mb-8">Group Performance
                            Matrix</h3>
                        <div class="space-y-6">
                            @forelse($topGroups as $tg)
                                <div class="flex items-center justify-between group/item">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center text-teal-500 border border-white/5 group-hover/item:border-teal-500/50 transition-all">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p
                                                class="text-xs font-black text-white truncate max-w-[150px] uppercase tracking-tight">
                                                {{ $tg->name }}</p>
                                            <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1">
                                                Strategic Asset Group</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-black text-teal-400 tabular-nums">
                                            {{ number_format($tg->total_out) }}</p>
                                        <p class="text-[8px] font-bold text-slate-500 uppercase tracking-tight mt-1">Flow (30D)
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-500 text-[10px] italic text-center py-10 uppercase tracking-widest">No
                                    Group Intelligence Found.</p>
                            @endforelse
                        </div>
                    </div>
                    <!-- Decoration -->
                    <div
                        class="absolute right-0 bottom-0 p-8 opacity-5 group-hover:scale-110 transition-transform duration-1000">
                        <svg class="h-32 w-32 text-teal-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 1L9 9l-8 1 6 6-2 8 7-4 7 4-2-8 6-6-8-1-3-8z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tier 3: Operational Stream -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start w-full">
            <!-- Stock Velocity Stream -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col w-full">
                <div
                    class="px-8 py-6 bg-slate-50/30 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black text-slate-800 dark:text-white tracking-[0.2em] uppercase">Movement
                            Pulse</h3>
                        <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase">Live Inventory Transaction Log</p>
                    </div>
                    <a href="{{ route('stock.index') }}"
                        class="h-8 w-8 rounded-full bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center hover:scale-110 active:scale-95 transition-all text-teal-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="py-6 px-8">ID</th>
                                <th class="py-6 px-8">Product</th>
                                <th class="py-6 px-8">Movement Type</th>
                                <th class="py-6 px-8">Qty</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($recentMovements as $m)
                                <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                                    <td class="py-6 px-8">{{ $m->id }}</td>
                                    <td class="py-6 px-8">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-10 w-10 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:bg-teal-600 group-hover:text-white transition-all">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-black text-slate-900 dark:text-white">
                                                    {{ $m->product->name }}</p>
                                                <p
                                                    class="text-[10px] font-bold text-slate-400 uppercase mt-0.5 tracking-tighter">
                                                    {{ $m->transaction_date->format('M d, H:i') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6 px-8">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $m->type === 'in' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                            {{ $m->type === 'in' ? 'Inbound' : 'Outbound' }}
                                        </span>
                                    </td>
                                    <td class="py-6 px-8 text-right">
                                        <p
                                            class="text-sm font-black {{ $m->type === 'in' ? 'text-emerald-600' : 'text-rose-600' }} tabular-nums">
                                            {{ $m->type === 'in' ? '+' : '-' }}{{ number_format($m->quantity) }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Risk Monitor: Expiry Intelligence -->
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col w-full">
                <div class="px-8 py-6 bg-slate-50/30 dark:bg-slate-800/20 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black text-slate-800 dark:text-white tracking-[0.2em] uppercase">Expiry Monitor
                        </h3>
                        <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase">Pre-emptive Quality Control (6M Window)
                        </p>
                    </div>
                    <a href="{{ route('batches.expiring') }}"
                        class="h-8 w-8 rounded-full bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center hover:scale-110 active:scale-95 transition-all text-amber-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
                <div class="p-4 space-y-3 flex-1 overflow-y-auto max-h-[500px]">
                    @forelse($expiringBatches as $eb)
                        <div
                            class="flex items-center justify-between p-5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:border-amber-500/30 transition-all group shadow-sm">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-10 w-10 border border-amber-100 dark:border-amber-900/50 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-amber-600 flex items-center justify-center">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-900 dark:text-white leading-tight mb-1">
                                        {{ $eb->product->name }}</p>
                                    <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest">BATCH
                                        #{{ $eb->batch_number }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-black text-slate-900 dark:text-white mb-0.5">
                                    {{ $eb->expiry_date->format('d M, Y') }}</p>
                                <p
                                    class="text-[9px] font-black {{ $eb->expiry_date->diffInDays(now()) < 30 ? 'text-rose-600 animate-pulse' : 'text-slate-400' }} uppercase tracking-widest">
                                    {{ $eb->expiry_date->diffInDays(now()) }} Days Residual
                                </p>
                            </div>
                        </div>
                    @empty
                        @if($expiringMaterials->isEmpty())
                        <div class="py-20 text-center text-slate-400 italic text-[10px]">No institutional risk detected in
                            current window.</div>
                        @endif
                    @endforelse

                    @foreach($expiringMaterials as $em)
                        <div
                            class="flex items-center justify-between p-5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:border-indigo-500/30 transition-all group shadow-sm">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-10 w-10 border border-indigo-100 dark:border-indigo-900/50 rounded-xl bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 flex items-center justify-center">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-900 dark:text-white leading-tight mb-1">
                                        {{ $em->product->name }}</p>
                                    <p class="text-[9px] font-black text-indigo-600 uppercase tracking-widest">MATERIAL LOT
                                        #{{ $em->lot_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-black text-slate-900 dark:text-white mb-0.5">
                                    {{ $em->expiry_date->format('d M, Y') }}</p>
                                <p
                                    class="text-[9px] font-black {{ $em->expiry_date->diffInDays(now()) < 30 ? 'text-rose-600 animate-pulse' : 'text-slate-400' }} uppercase tracking-widest">
                                    {{ $em->expiry_date->diffInDays(now()) }} Days Residual
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#94a3b8' : '#64748b';
            const gridColor = isDark ? '#1e293b' : '#f1f5f9';

            // Fiscal Performance Matrix Chart
            new Chart(document.getElementById('revenueTrendChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($fiscalTrendData->pluck('month')) !!},
                    datasets: [
                        {
                            label: 'Gross Revenue',
                            data: {!! json_encode($fiscalTrendData->pluck('revenue')) !!},
                            borderColor: '#14b8a6',
                            backgroundColor: 'rgba(20, 184, 166, 0.05)',
                            borderWidth: 4,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: '#14b8a6',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 4,
                        },
                        {
                            label: 'Total Expenditure',
                            data: {!! json_encode($fiscalTrendData->pluck('expenditure')) !!},
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.05)',
                            borderWidth: 4,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: '#6366f1',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                color: textColor,
                                font: { weight: '800', size: 9 },
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: isDark ? '#0f172a' : '#fff',
                            titleColor: isDark ? '#fff' : '#0f172a',
                            bodyColor: isDark ? '#fff' : '#0f172a',
                            borderColor: isDark ? '#1e293b' : '#f1f5f9',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 12,
                            titleFont: { weight: '800', size: 10 },
                            bodyFont: { weight: '800', size: 12 },
                            displayColors: true,
                            callbacks: {
                                label: function (context) {
                                    return context.dataset.label + ': Rs. ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor, drawBorder: false },
                            ticks: {
                                color: textColor,
                                font: { weight: '800', size: 9 },
                                callback: function (value) { 
                                    if (value >= 1000) return 'Rs ' + (value / 1000) + 'k';
                                    return 'Rs ' + value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: textColor, font: { weight: '800', size: 9 } }
                        }
                    }
                }
            });
        });
    </script>
@endsection