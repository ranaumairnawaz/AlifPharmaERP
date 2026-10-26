@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Metric Standards (UOM)</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Define measurement units and decimal precision for inventory assets.</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
    
    <!-- Creation Form -->
    <div class="xl:col-span-4 bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 lg:p-8 transition-all">
        <h2 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6">Register UOM</h2>
        
        <form action="{{ route('units.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Full Name</label>
                    <input type="text" name="name" required placeholder="e.g. Kilograms, Box" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Symbol</label>
                    <input type="text" name="short_name" required placeholder="Kg" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">UOM Metadata</label>
                <textarea name="description" rows="3" placeholder="Define usage context..." class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm text-slate-600 dark:text-slate-300 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none"></textarea>
            </div>

            <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800 transition-colors">
                <input id="is_decimal" name="is_decimal" type="checkbox" value="1" class="h-4 w-4 text-teal-600 border-slate-300 dark:border-slate-700 rounded focus:ring-teal-500 transition-all cursor-pointer">
                <label for="is_decimal" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest cursor-pointer hover:text-teal-600 transition-colors">Apply Decimal Support</label>
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-3 text-sm font-bold text-white shadow-sm hover:bg-teal-500 transition-all active:scale-[0.98]">
                Initialize Metric
            </button>
        </form>
    </div>

    <!-- Listings -->
    <div class="xl:col-span-8 bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col overflow-hidden h-full transition-all">
        <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Available Metrics</h3>
        </div>
        
        <div class="flex-1 overflow-x-auto min-h-[400px]">
            <table id="units-table" class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50/30 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Imperial Mapping</th>
                        <th class="px-6 py-4">Logic Type</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($units as $unit)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                                    {{ $unit->name }}
                                    <span class="text-[9px] font-mono font-bold text-teal-600 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/30 px-1.5 py-0.5 rounded shadow-sm border border-teal-100/10">({{ $unit->short_name }})</span>
                                </div>
                                @if($unit->description)
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 max-w-xs truncate">{{ $unit->description }}</div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($unit->is_decimal)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 uppercase tracking-tighter shadow-sm border border-indigo-100 dark:border-indigo-900/50">Fractional</span>
                                    @else
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-500 uppercase tracking-tighter shadow-sm border border-slate-200 dark:border-slate-700 opacity-60">Discrete Item</span>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @canEdit('units')
                                    <a href="{{ route('units.edit', $unit) }}" class="p-1.5 rounded-md text-slate-300 hover:text-teal-600 hover:bg-teal-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    @endcanEdit
                                    @canDelete('units')
                                    <form id="delete-unit-{{ $unit->id }}" action="{{ route('units.destroy', $unit) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('delete-unit-{{ $unit->id }}', 'Archive Metric System?', 'Deleting this UOM will affect all linked product inventory scaling.')"
                                                class="p-1.5 rounded-md text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition-all shadow-sm">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v2M4 7h16" /></svg>
                                        </button>
                                    </form>
                                    @endcanDelete
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#units-table').DataTable({
            order: [[0, 'asc']]
        });
    });
</script>
@endsection
