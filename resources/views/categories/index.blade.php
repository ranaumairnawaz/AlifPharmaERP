@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Category Taxonomy</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Classify pharmaceutical products for faster sorting and reporting.</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
    
    <!-- Creation Form -->
    @canEdit('categories')
    <div class="xl:col-span-4 bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 lg:p-8 transition-all">
        <h2 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6">Create Classification</h2>
        
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Category Title</label>
                <input type="text" name="name" required placeholder="e.g. Antibiotics, Vaccines" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Scope Description</label>
                <textarea name="description" rows="4" placeholder="Briefly specify category use cases..." class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-2.5 px-4 text-sm text-slate-600 dark:text-slate-300 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none"></textarea>
            </div>

            <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-3 text-sm font-bold text-white shadow-sm hover:bg-teal-500 transition-all active:scale-[0.98]">
                Deploy Category
            </button>
        </form>
    </div>
    @else
    <div class="xl:col-span-4 bg-slate-50 dark:bg-slate-900/30 rounded-xl border border-dashed border-slate-200 dark:border-slate-800 p-8 text-center">
        <svg class="mx-auto h-12 w-12 text-slate-300 dark:text-slate-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Master Data Locked</p>
        <p class="text-[10px] text-slate-500 mt-2">You lack the tactical clearance to initialize new classifications.</p>
    </div>
    @endcanEdit

    <!-- Listings -->
    <div class="xl:col-span-8 bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col overflow-hidden h-full transition-all">
        <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Defined Classifications</h3>
        </div>
        
        <div class="flex-1 overflow-x-auto min-h-[400px]">
            <table id="categories-table" class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50/30 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-4">Taxonomy</th>
                        <th class="px-4 py-4">Status Vector</th>
                        <th class="px-4 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group">
                            <td class="px-4 py-4">
                                <div class="font-bold text-slate-900 dark:text-slate-100">{{ $category->name }}</div>
                                @if($category->description)
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 max-w-xs truncate">{{ $category->description }}</div>
                                @endif
                            </td>
                            
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex h-2 w-2 rounded-full {{ $category->is_active ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-slate-300 dark:bg-slate-700' }}"></span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest font-mono text-slate-600 dark:text-slate-400">{{ $category->is_active ? 'In Pool' : 'Dormant' }}</span>
                                </div>
                            </td>
                            
                            <td class="px-4 py-4 text-right">
                                <div class="flex justify-end gap-2 outline-none">
                                    @canEdit('categories')
                                    <a href="{{ route('categories.edit', $category) }}" class="p-1.5 rounded-md text-slate-300 hover:text-teal-600 hover:bg-teal-50 transition-all" title="Revision Mode">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                    @endcanEdit
                                    @canDelete('categories')
                                    <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('delete-category-{{ $category->id }}', 'Purge Classification?', 'Removing this category will immediately declassify all associated products. This action is terminal.')"
                                                class="p-1.5 rounded-md text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition-all">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v2M4 7h16" /></svg>
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
        $('#categories-table').DataTable({
            order: [[0, 'asc']],
            pageLength: 25,
            dom: '<"flex flex-col md:flex-row justify-between items-center gap-4 mb-4"f>rt<"flex flex-col md:flex-row justify-between items-center gap-4 mt-6"ip>'
        });
    });
</script>
@endsection
