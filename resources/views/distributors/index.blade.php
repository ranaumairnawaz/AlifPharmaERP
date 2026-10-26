@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Distribution Partners</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage your distributors and their shipping
            designations.</p>
    </div>

    <div class="mt-4 sm:ml-16 sm:mt-0 flex items-center gap-3">
        @canEdit('distributors')
        <a href="{{ route('distributors.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 transition-all active:scale-95">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Distributor
        </a>
        @endcanEdit
    </div>
</div>

<div
    class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 border-b border-slate-200">
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest text-teal-600">Company /
                        Business Identity</th>
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest text-indigo-600">Contact
                        Executive</th>
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest">Region / City</th>
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest text-center">Status</th>
                    <th class="py-4 px-6 font-bold uppercase text-[10px] tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($distributors as $distributor)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group italic">
                    <td class="py-4 px-6">
                        <div
                            class="font-black text-slate-900 dark:text-slate-100 uppercase tracking-tight text-base italic underline underline-offset-4 decoration-teal-500/10">
                            {{ $distributor->company_name ?? $distributor->name }}
                        </div>
                        <div
                            class="text-[9px] text-slate-400 mt-1 font-bold tracking-widest uppercase truncate max-w-xs">
                            {{ $distributor->street_address }}
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-slate-800 dark:text-slate-200 uppercase tracking-tight text-xs">
                            {{ $distributor->contact_name ?? '---' }}
                        </div>
                        <div class="text-[10px] text-indigo-500 font-black mt-0.5">
                            {{ $distributor->phone ?? 'NO PHONE' }}
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black bg-indigo-50 text-indigo-700 uppercase tracking-widest border border-indigo-100 italic">
                            {{ $distributor->city ?? '---' }} / {{ $distributor->area }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        @if($distributor->is_active)
                            <span
                                class="bg-emerald-50 text-emerald-700 text-[10px] font-black px-2 py-0.5 rounded-md uppercase tracking-widest">Active</span>
                        @else
                            <span
                                class="bg-slate-100 text-slate-500 text-[10px] font-black px-2 py-0.5 rounded-md uppercase tracking-widest">Disabled</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex justify-end gap-2">
                            @canRead('distributors')
                            <a href="{{ route('distributors.show', $distributor) }}"
                                class="p-1.5 rounded-md text-slate-300 hover:text-indigo-600 hover:bg-indigo-50 transition-all font-bold">
                                View
                            </a>
                            @endcanRead

                            @canEdit('distributors')
                            <a href="{{ route('distributors.edit', $distributor) }}"
                                class="p-1.5 rounded-md text-slate-300 hover:text-teal-600 hover:bg-teal-50 transition-all font-bold">
                                Edit
                            </a>
                            @endcanEdit

                            @canDelete('distributors')
                            <form action="{{ route('distributors.destroy', $distributor) }}" method="POST"
                                onsubmit="return confirm('Remove distributor?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="p-1.5 rounded-md text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition-all font-bold uppercase text-[10px]">
                                    Delete
                                </button>
                            </form>
                            @endcanDelete
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-slate-400 italic">No distributors registered yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection