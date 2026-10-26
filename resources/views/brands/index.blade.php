@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Brand Directory</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage brands categorized under manufacturer groups.</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
    
    <!-- Creation Form -->
    <div class="xl:col-span-4 bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 lg:p-8 transition-all">
        <h2 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6">Register New Brand</h2>
        
        <form action="{{ route('brands.store') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Brand Name</label>
                <input type="text" name="name" required placeholder="e.g. Panadol, Nexium" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Manufacturer Group</label>
                <select name="group_id" required class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none">
                    <option value="">Select Group</option>
                    @foreach(App\Models\Group::orderBy('name')->get() as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Description</label>
                <textarea name="description" rows="3" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm text-slate-600 dark:text-slate-300 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none"></textarea>
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-3 text-sm font-bold text-white shadow-sm hover:bg-teal-500 transition-all active:scale-[0.98]">
                Initialize Brand Entry
            </button>
        </form>
    </div>

    <!-- Listings -->
    <div class="xl:col-span-8 bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col overflow-hidden h-full transition-all">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Registered Brands</h3>
        </div>
        
        <div class="flex-1 overflow-x-auto min-h-[400px]">
            <table id="brands-table" class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50/30 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Brand</th>
                        <th class="px-6 py-4">Group</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($brands as $brand)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 dark:text-slate-100">{{ $brand->name }}</div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-slate-700 dark:text-slate-300">
                                    {{ $brand->group->name ?? 'No Group' }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @canEdit('brands')
                                    <a href="{{ route('brands.edit', $brand) }}" class="p-1.5 rounded-md text-slate-300 hover:text-teal-600 hover:bg-teal-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    @endcanEdit
                                    @canDelete('brands')
                                    <form id="delete-brand-{{ $brand->id }}" action="{{ route('brands.destroy', $brand) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('delete-brand-{{ $brand->id }}', 'Delete Brand Account?', 'This brand may be linked to specific product formulations.')"
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
        $('#brands-table').DataTable({
            order: [[0, 'asc']]
        });
    });
</script>
@endsection
