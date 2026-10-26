@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight underline decoration-teal-500/20">Logistics History</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-sans tracking-wide">Review all issued AP-series distribution slips and loading status.</p>
    </div>
    
    <div class="mt-4 sm:ml-16 sm:mt-0 flex items-center gap-3">
        @canEdit('slips')
        <a href="{{ route('slips.create') }}" class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-2 text-sm font-black text-white shadow-lg hover:bg-teal-500 transition-all active:scale-95 uppercase tracking-widest">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Distribution Slip
        </a>
        @endcanEdit
    </div>
</div>

<div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto font-sans min-h-[400px]">
        <table id="slips-table" class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-900/50 text-slate-400 border-b border-slate-200 dark:border-slate-800 uppercase text-[9px] tracking-[0.2em] font-black">
                    <th class="py-4 px-4 text-center">Slip ID</th>
                    <th class="py-4 px-4">Partner / Distributor</th>
                    <th class="py-4 px-4">Dispatch Date</th>
                    <th class="py-4 px-4">Load Status</th>
                    <th class="py-4 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($slips as $slip)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group {{ ($slip->is_net_invoiced || $slip->is_warranty_invoiced) ? 'opacity-75' : '' }}">
                        <td class="py-4 px-4 text-center">
                            <div class="font-black text-teal-600 tracking-tighter text-base italic underline underline-offset-4 decoration-teal-500/10">
                                #{{ $slip->slip_number }}
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-black text-slate-900 dark:text-slate-100 uppercase tracking-tight">{{ $slip->distributor->company_name ?? $slip->distributor->name }}</div>
                            <div class="text-[9px] font-black text-indigo-500 uppercase flex items-center mt-0.5">
                                <span class="text-[8pt] text-slate-400 mr-2">Contact: {{ $slip->distributor->contact_name ?? '---' }}</span>
                                <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                {{ $slip->distributor->area }}
                            </div>
                        </td>
                        <td class="py-4 px-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                            {{ $slip->transaction_date->format('d M, Y') }}
                        </td>
                        <td class="py-4 px-4">
                            @if($slip->is_net_invoiced || $slip->is_warranty_invoiced)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 uppercase tracking-widest shadow-sm">
                                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    @if($slip->is_net_invoiced && $slip->is_warranty_invoiced)
                                        INVOICED & LOCKED
                                    @else
                                        PARTIALLY INVOICED
                                    @endif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 uppercase tracking-widest shadow-sm">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>
                                    READY FOR LOAD
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex justify-end gap-3 items-center">
                                @if(!($slip->is_net_invoiced || $slip->is_warranty_invoiced))
                                    @canEdit('slips')
                                    <a href="{{ route('slips.edit', $slip) }}" class="p-1.5 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all" title="Revision Mode">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    @endcanEdit
                                @endif

                                @canRead('slips')
                                <a href="{{ route('slips.pdf', $slip) }}" target="_blank" class="p-1.5 rounded-md text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all" title="PDF Distribution Slip">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                </a>
                                @endcanRead
                                
                                @if(!($slip->is_net_invoiced || $slip->is_warranty_invoiced))
                                    @canDelete('slips')
                                    <form id="archive-slip-{{ $slip->id }}" action="{{ route('slips.destroy', $slip) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('archive-slip-{{ $slip->id }}', 'Purge Logistics Slave?', 'Archiving this DC slip will immediately restore all allocated product batch quantities to the inventory library.')"
                                                class="p-1.5 rounded-md text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v2M4 7h16" /></svg>
                                        </button>
                                    </form>
                                    @endcanDelete
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center italic text-slate-400 text-xs">No distribution slips found in the repository.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#slips-table').DataTable({
            order: [[0, 'desc']],
            pageLength: 25,
            dom: '<"flex flex-col md:flex-row justify-between items-center gap-4 mb-4"f>rt<"flex flex-col md:flex-row justify-between items-center gap-4 mt-6"ip>'
        });
    });
</script>
@endsection
