@extends('layouts.app')

@section('content')
<div class="max-w-[1600px] mx-auto pb-20 px-4 sm:px-6 lg:px-8">
    <div class="mb-12 flex flex-col lg:flex-row lg:items-end justify-between gap-8">
        <div class="max-w-3xl">
            <h2 class="text-[10px] font-bold text-teal-600 uppercase tracking-[0.25em] mb-2 px-1">Inventory Governance</h2>
            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter leading-none mb-4">Stock Valuation & Audit Hub</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed italic">Real-time segmented auditing for Raw Materials, Packaging, and Finished Goods. All valuations are calculated based on current weighted cost pricing.</p>
        </div>
    </div>
    <div class="mb-12 flex flex-col lg:flex-row lg:items-center justify-between gap-8 bg-white dark:bg-slate-900/50 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
        <div class="flex items-center gap-6">
            <div class="px-6 py-2 border-r border-slate-100 dark:border-slate-800">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Global Assets Value</p>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter">Rs. {{ number_format($summary['total_valuation'], 2) }}</h3>
            </div>
            
            <form action="{{ route('reports.audit') }}" method="GET" class="flex items-center gap-3" id="filter-form">
                <div class="relative">
                    <select name="type" onchange="document.getElementById('filter-form').submit()" class="h-11 pl-4 pr-10 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs font-bold text-slate-700 dark:text-slate-200 focus:ring-teal-500 focus:border-teal-500 appearance-none min-w-[200px] shadow-sm transition-all">
                        <option value="all" {{ $type === 'all' ? 'selected' : '' }}>Full Global Audit</option>
                        <option value="finished_good" {{ $type === 'finished_good' ? 'selected' : '' }}>Finished Goods Only</option>
                        <option value="raw_material" {{ $type === 'raw_material' ? 'selected' : '' }}>Raw Materials Only</option>
                        <option value="packaging" {{ $type === 'packaging' ? 'selected' : '' }}>Packaging Assets Only</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('reports.audit.pdf', ['type' => $type]) }}" target="_blank" class="h-11 px-6 flex items-center justify-center rounded-xl bg-slate-900 text-white font-bold text-xs shadow-xl shadow-slate-900/20 hover:bg-slate-800 transition-all active:scale-95 group">
                <svg class="h-4 w-4 mr-2 transition-transform group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                Export Branded Audit (PDF)
            </a>
            <button onclick="window.print()" class="h-11 w-11 flex items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all active:scale-95">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            </button>
        </div>
    </div>

    <!-- Segmented Valuation Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12 items-start">
        @if($type === 'all' || $type === 'raw_material')
        <!-- Raw Materials -->
        <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 group hover:border-teal-500/30 transition-all shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-[0.03] dark:opacity-[0.07] group-hover:opacity-[0.05] dark:group-hover:opacity-[0.1] transition-opacity">
                <svg class="h-24 w-24 text-teal-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3L4 9v10l8 2 8-2V9l-8-6zm0 2.5L17.5 9.5 12 12.5 6.5 9.5 12 5.5zM6 11.5l5 2.5v6.5l-5-1.5v-7.5zm12 0v7.5l-5 1.5v-6.5l5-2.5z"/></svg>
            </div>
            <div class="flex items-center gap-3 mb-6 font-sans">
                <div class="h-10 w-10 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center font-black">RM</div>
                <h3 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Raw Materials</h3>
            </div>
            <div class="space-y-1 font-sans">
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">Rs. {{ number_format($summary['raw']['valuation'], 2) }}</p>
                <div class="flex items-center gap-2 text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tight">
                    <span>{{ $summary['raw']['count'] }} SKUs Identified</span>
                </div>
            </div>
        </div>
        @endif

        @if($type === 'all' || $type === 'packaging')
        <!-- Packaging -->
        <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 group hover:border-indigo-500/30 transition-all shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-[0.03] dark:opacity-[0.07] group-hover:opacity-[0.05] dark:group-hover:opacity-[0.1] transition-opacity">
                <svg class="h-24 w-24 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M21 16.5c0 .38-.21.71-.53.88l-7.97 4.44c-.31.17-.66.26-1 .26s-.69-.09-1-.26L2.53 17.38c-.32-.17-.53-.5-.53-.88V7.5c0-.38.21-.71.53-.88l7.97-4.44c.31-.17.66-.26 1-.26s.69.09 1 .26l7.97 4.44c.32.17.53.5.53.88v9z"/></svg>
            </div>
            <div class="flex items-center gap-3 mb-6 font-sans">
                <div class="h-10 w-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-black">PK</div>
                <h3 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Packaging</h3>
            </div>
            <div class="space-y-1 font-sans">
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">Rs. {{ number_format($summary['packaging']['valuation'], 2) }}</p>
                <div class="flex items-center gap-2 text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tight">
                    <span>{{ $summary['packaging']['count'] }} SKUs Identified</span>
                </div>
            </div>
        </div>
        @endif

        @if($type === 'all' || $type === 'finished_good')
        <!-- Finished Goods -->
        <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 group hover:border-emerald-500/30 transition-all shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-[0.03] dark:opacity-[0.07] group-hover:opacity-[0.05] dark:group-hover:opacity-[0.1] transition-opacity">
                <svg class="h-24 w-24 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 7l11 5 11-5-11-5zM2 9.5l10 4.5 10-4.5V17l-10 5-10-5V9.5z"/></svg>
            </div>
            <div class="flex items-center gap-3 mb-6 font-sans">
                <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black">FG</div>
                <h3 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Finished Goods</h3>
            </div>
            <div class="space-y-1 font-sans">
                <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">Rs. {{ number_format($summary['finished']['valuation'], 2) }}</p>
                <div class="flex items-center gap-2 text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tight">
                    <span>{{ $summary['finished']['count'] }} SKUs Identified</span>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Segmented DataTables Grid -->
    <div class="grid grid-cols-1 gap-8">

        @if($type === 'all' || $type === 'finished_good')
        <!-- Finished Goods Table -->
        <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none overflow-hidden font-sans flex flex-col h-full border-t-4 border-t-emerald-500 group transition-all hover:border-emerald-400">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/50 flex items-center justify-between">
                <h3 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] italic">Finished Goods Ledger</h3>
                <span class="px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-[8px] font-black uppercase tracking-widest border border-emerald-100 dark:border-emerald-900/50">Live Audit</span>
            </div>
            <div class="p-2 overflow-x-auto flex-1">
                <table id="finished-table" class="w-full text-left text-[11px] whitespace-nowrap compact-table">
                    <thead>
                        <tr class="bg-slate-50/50 text-[9px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="py-3 px-4">Designation</th>
                            <th class="py-3 px-4 text-center">Capacity Gauge</th>
                            <th class="py-3 px-4 text-right">Valuation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($finishedGoods as $p)
                            @php 
                                $percent = $p->reorder_point > 0 ? min(100, ($p->current_stock / ($p->reorder_point * 3)) * 100) : 100;
                                $isCritical = $p->current_stock <= $p->reorder_point;
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/80 transition-all {{ $isCritical ? 'bg-rose-50/20 dark:bg-rose-900/10' : '' }}">
                                <td class="py-4 px-4">
                                    <div class="font-black text-slate-900 dark:text-slate-100 tracking-tight flex items-center gap-2">
                                        {{ $p->name }}
                                        @if($isCritical)
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse shadow-[0_0_8px_rgba(244,63,94,0.6)]"></span>
                                        @endif
                                    </div>
                                    <div class="text-[8px] text-slate-400 dark:text-slate-500 uppercase font-black tracking-tighter">{{ $p->category->name ?? 'Mixed' }}</div>
                                </td>
                                <td class="py-4 px-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between text-[8px] font-black uppercase tracking-widest">
                                            <span class="{{ $isCritical ? 'text-rose-500' : 'text-slate-400 dark:text-slate-500' }}">{{ number_format($p->current_stock, 1) }} {{ $p->unit->short_name }}</span>
                                            <span class="text-slate-300 dark:text-slate-600 italic">Target: {{ $p->reorder_point * 3 }}</span>
                                        </div>
                                        <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden flex shadow-inner">
                                            <div class="h-full transition-all duration-700 ease-out {{ $isCritical ? 'bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.4)]' : 'bg-emerald-500' }}" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right align-middle">
                                    <div class="font-mono font-black text-emerald-600 dark:text-emerald-400 text-xs">Rs.{{ number_format($p->current_stock * $p->cost_price, 0) }}</div>
                                    <div class="text-[8px] text-slate-400 dark:text-slate-500 font-bold italic tracking-tighter">@Rs.{{ number_format($p->cost_price, 0) }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @endif

        @if($type === 'all' || $type === 'raw_material')
        <!-- Raw Materials Table -->
        <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none overflow-hidden font-sans flex flex-col h-full border-t-4 border-t-teal-500 group transition-all hover:border-teal-400">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/50 flex items-center justify-between">
                <h3 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] italic">Raw Materials Ledger</h3>
                <span class="px-2 py-0.5 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 text-[8px] font-black uppercase tracking-widest border border-teal-100 dark:border-teal-900/50">Live Audit</span>
            </div>
            <div class="p-2 overflow-x-auto flex-1">
                <table id="raw-table" class="w-full text-left text-[11px] whitespace-nowrap compact-table">
                    <thead>
                        <tr class="bg-slate-50/50 text-[9px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="py-3 px-4">Item Identity</th>
                            <th class="py-3 px-4 text-center">Capacity Gauge</th>
                            <th class="py-3 px-4 text-right">Valuation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($rawMaterials as $p)
                            @php 
                                $percent = $p->reorder_point > 0 ? min(100, ($p->current_stock / ($p->reorder_point * 3)) * 100) : 100;
                                $isCritical = $p->current_stock <= $p->reorder_point;
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/80 transition-all {{ $isCritical ? 'bg-rose-50/20 dark:bg-rose-900/10' : '' }}">
                                <td class="py-4 px-4">
                                    <div class="font-black text-slate-900 dark:text-slate-100 tracking-tight flex items-center gap-2">
                                        {{ $p->name }}
                                        @if($isCritical)
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse shadow-[0_0_8px_rgba(244,63,94,0.6)]"></span>
                                        @endif
                                    </div>
                                    <div class="text-[8px] text-slate-400 dark:text-slate-500 uppercase font-black tracking-tighter">{{ $p->category->name ?? 'Mixed' }}</div>
                                </td>
                                <td class="py-4 px-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between text-[8px] font-black uppercase tracking-widest">
                                            <span class="{{ $isCritical ? 'text-rose-500' : 'text-slate-400 dark:text-slate-500' }}">{{ number_format($p->current_stock, 1) }} {{ $p->unit->short_name }}</span>
                                            <span class="text-slate-300 dark:text-slate-600 italic">Target: {{ $p->reorder_point * 3 }}</span>
                                        </div>
                                        <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden flex shadow-inner">
                                            <div class="h-full transition-all duration-700 ease-out {{ $isCritical ? 'bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.4)]' : 'bg-teal-500' }}" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right align-middle">
                                    <div class="font-mono font-black text-teal-600 dark:text-teal-400 text-xs">Rs.{{ number_format($p->current_stock * $p->cost_price, 0) }}</div>
                                    <div class="text-[8px] text-slate-400 dark:text-slate-500 font-bold italic tracking-tighter">@Rs.{{ number_format($p->cost_price, 0) }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @endif

        @if($type === 'all' || $type === 'packaging')
        <!-- Packaging Table -->
        <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none overflow-hidden font-sans flex flex-col h-full border-t-4 border-t-indigo-500 group transition-all hover:border-indigo-400">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/50 flex items-center justify-between">
                <h3 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] italic">Packaging Ledger</h3>
                <span class="px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[8px] font-black uppercase tracking-widest border border-indigo-100 dark:border-indigo-900/50">Live Audit</span>
            </div>
            <div class="p-2 overflow-x-auto flex-1">
                <table id="packaging-table" class="w-full text-left text-[11px] whitespace-nowrap compact-table">
                    <thead>
                        <tr class="bg-slate-50/50 text-[9px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="py-3 px-4">Specification</th>
                            <th class="py-3 px-4 text-center">Capacity Gauge</th>
                            <th class="py-3 px-4 text-right">Valuation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($packagingMaterials as $p)
                            @php 
                                $percent = $p->reorder_point > 0 ? min(100, ($p->current_stock / ($p->reorder_point * 3)) * 100) : 100;
                                $isCritical = $p->current_stock <= $p->reorder_point;
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/80 transition-all {{ $isCritical ? 'bg-rose-50/20 dark:bg-rose-900/10' : '' }}">
                                <td class="py-4 px-4">
                                    <div class="font-black text-slate-900 dark:text-slate-100 tracking-tight flex items-center gap-2">
                                        {{ $p->name }}
                                        @if($isCritical)
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse shadow-[0_0_8px_rgba(244,63,94,0.6)]"></span>
                                        @endif
                                    </div>
                                    <div class="text-[8px] text-slate-400 dark:text-slate-500 uppercase font-black tracking-tighter">{{ $p->category->name ?? 'Mixed' }}</div>
                                </td>
                                <td class="py-4 px-4 align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between text-[8px] font-black uppercase tracking-widest">
                                            <span class="{{ $isCritical ? 'text-rose-500' : 'text-slate-400 dark:text-slate-500' }}">{{ number_format($p->current_stock, 1) }} {{ $p->unit->short_name }}</span>
                                            <span class="text-slate-300 dark:text-slate-600 italic">Target: {{ $p->reorder_point * 3 }}</span>
                                        </div>
                                        <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden flex shadow-inner">
                                            <div class="h-full transition-all duration-700 ease-out {{ $isCritical ? 'bg-rose-500 shadow-[0_0_10px_rgba(244,63,94,0.4)]' : 'bg-indigo-500' }}" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right align-middle">
                                    <div class="font-mono font-black text-indigo-600 dark:text-indigo-400 text-xs">Rs.{{ number_format($p->current_stock * $p->cost_price, 0) }}</div>
                                    <div class="text-[8px] text-slate-400 dark:text-slate-500 font-bold italic tracking-tighter">@Rs.{{ number_format($p->cost_price, 0) }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @endif

    </div>
</div>

<script>
    $(document).ready(function() {
        const tableOptions = {
            order: [[0, 'asc']]
        };

        $('#raw-table').DataTable(tableOptions);
        $('#packaging-table').DataTable(tableOptions);
        $('#finished-table').DataTable(tableOptions);
    });
</script>
@endsection
