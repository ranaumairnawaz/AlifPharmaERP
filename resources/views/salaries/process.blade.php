@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-20">
    <form action="{{ route('salaries.store') }}" method="POST">
        @csrf
        <input type="hidden" name="month" value="{{ $month }}">

        <!-- High-Fidelity Header -->
        <div class="mb-10 flex flex-col md:flex-row md:items-end md:justify-between gap-6 px-1">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="h-2 w-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.6)]"></span>
                    <h2 class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-[0.4em]">Payroll Matrix System</h2>
                </div>
                <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter capitalize">{{ \Carbon\Carbon::parse($month)->format('F Y') }} Settlement Matrix</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium italic mt-1 font-sans">Finalize corporate disbursements for the {{ $branding['name'] }} pharmaceutical force.</p>
            </div>
            
            <!-- Month Selector -->
            <div class="flex items-center gap-4 bg-white dark:bg-slate-900 p-2 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/20 dark:shadow-none">
                <input type="month" value="{{ $month }}" onchange="window.location.href='{{ route('salaries.process') }}?month=' + this.value"
                    class="bg-transparent border-0 text-sm font-black text-slate-700 dark:text-slate-200 focus:ring-0 cursor-pointer">
                <div class="h-8 w-8 rounded-xl bg-indigo-50 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
        </div>

        <!-- Matrix Table -->
        <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden transition-all">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-indigo-600 border-b border-indigo-700/50">
                        <th class="px-8 py-5 text-[10px] font-black text-indigo-100 uppercase tracking-widest w-1/4">Personnel Profile</th>
                        <th class="px-8 py-5 text-[10px] font-black text-indigo-100 uppercase tracking-widest">Retainer / Base</th>
                        <th class="px-8 py-5 text-[10px] font-black text-indigo-100 uppercase tracking-widest w-24">Off-Days</th>
                        <th class="px-8 py-5 text-[10px] font-black text-indigo-100 uppercase tracking-widest w-32">Adjustment (Rs)</th>
                        <th class="px-8 py-5 text-[10px] font-black text-indigo-100 uppercase tracking-widest">Justification / Notes</th>
                        <th class="px-8 py-5 text-[10px] font-black text-indigo-100 uppercase tracking-widest text-right">Settlement Preview</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800" x-data="{ employees: [] }">
                    @forelse($employees as $index => $employee)
                        <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                            <input type="hidden" name="payments[{{ $index }}][employee_id]" value="{{ $employee->id }}">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 font-black text-xs border border-slate-200 dark:border-slate-700">
                                        {{ substr($employee->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black text-slate-900 dark:text-white tracking-tight leading-none">{{ $employee->name }}</h4>
                                        <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-widest uppercase mt-1">{{ $employee->employee_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs font-black text-slate-800 dark:text-slate-200">Rs. {{ number_format($employee->base_salary, 0) }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <input type="number" name="payments[{{ $index }}][off_days]" value="0" min="0" max="{{ $daysInMonth }}"
                                    class="w-full h-10 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-xs font-black text-rose-500 focus:ring-rose-500 shadow-inner text-center">
                            </td>
                            <td class="px-8 py-6">
                                <input type="number" name="payments[{{ $index }}][adjustment]" value="0"
                                    class="w-full h-10 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-xs font-black text-emerald-500 focus:ring-emerald-500 shadow-inner text-center">
                            </td>
                            <td class="px-8 py-6">
                                <input type="text" name="payments[{{ $index }}][note]" placeholder="e.g. Fuel / Bonus"
                                    class="w-full h-10 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-[10px] font-bold text-slate-500 italic focus:ring-indigo-500 shadow-inner px-4">
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex flex-col items-end gap-1">
                                    <span class="text-xs font-black text-indigo-600 dark:text-indigo-400 tracking-tight">Recalculating...</span>
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Pending Sync</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center gap-6">
                                    <div class="h-24 w-24 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-100">
                                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="text-xs font-black text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em]">Zero Deployment Identified</h4>
                                        <p class="text-[10px] text-slate-400 italic">No active personnel found for the selected payment cycle.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($employees->isNotEmpty())
                <div class="p-10 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center border border-amber-100 dark:border-amber-900/50 shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-[10px] font-black text-amber-700/80 dark:text-amber-500/60 uppercase tracking-tight leading-relaxed max-w-sm">
                            Authorizing this matrix will finalize financial disbursements and generate professional salary slips for every personnel listed. This action is irreversible.
                        </p>
                    </div>
                    <button type="submit" class="h-14 px-12 rounded-2xl bg-slate-900 dark:bg-indigo-600 text-white font-black text-xs uppercase tracking-[0.3em] shadow-2xl shadow-indigo-900/20 hover:scale-[1.02] transition-all active:scale-95 border border-slate-700 dark:border-indigo-500/50">
                        Finalize & Disburse Payroll
                    </button>
                </div>
            @endif
        </div>
    </form>
</div>
@endsection
