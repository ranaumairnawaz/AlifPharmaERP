@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-20">
    <!-- Premium Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h2 class="text-[10px] font-black text-teal-600 dark:text-teal-400 uppercase tracking-[0.3em] mb-2 px-1">Human Resource Hub</h2>
            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter">Personnel Portfolio</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium italic mt-1">Manage the pharmaceutical force powering {{ $branding['name'] }}.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('employees.create') }}" 
                class="h-12 px-8 flex items-center bg-teal-600 hover:bg-teal-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-teal-500/20 transition-all active:scale-95">
                Onboard New Personnel
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-2xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center text-teal-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Staff</p>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white leading-none mt-1">{{ App\Models\Employee::count() }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Monthly Payroll</p>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white leading-none mt-1">Rs. {{ number_format(App\Models\Employee::where('status', 'active')->sum('base_salary'), 0) }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-2xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Ratio</p>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white leading-none mt-1">
                        @php $total = App\Models\Employee::count(); @endphp
                        {{ $total > 0 ? round((App\Models\Employee::where('status', 'active')->count() / $total) * 100) : 0 }}%
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Table -->
    <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Staff Identification</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Designation</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Base Salary</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Synchronization</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($employees as $employee)
                    <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 font-black text-xs border border-slate-200 dark:border-slate-700">
                                    {{ substr($employee->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-slate-900 dark:text-white tracking-tight">{{ $employee->name }}</h4>
                                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-widest uppercase mt-0.5">{{ $employee->employee_id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-400 italic font-mono">{{ $employee->designation }}</span>
                        </td>
                        <td class="px-8 py-6 text-sm font-black text-slate-800 dark:text-slate-200">
                            Rs. {{ number_format($employee->base_salary, 0) }}
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $employee->status === 'active' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-500' }}">
                                {{ $employee->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('employees.edit', $employee) }}" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-teal-500 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Archive this personnel?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-rose-500 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="h-20 w-20 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-200">
                                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                </div>
                                <p class="text-sm font-black text-slate-300 uppercase tracking-widest">No pharmaceutical force identified.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($employees->hasPages())
            <div class="px-8 py-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
