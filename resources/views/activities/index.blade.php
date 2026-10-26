@extends('layouts.app')

@section('content')
<div class="px-6 py-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white uppercase tracking-tight italic">System Auditing Ledger</h2>
        <p class="mt-1 text-slate-500 dark:text-slate-400 font-medium tracking-tight">Real-time chronicle of atomic system changes and user interactions.</p>
    </div>

    <!-- Live Event Feed -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/20 overflow-hidden">
        <div class="px-8 py-5 bg-slate-50 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Operational Event Stream</h3>
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest italic">Immutable Logs Active</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 text-slate-400 uppercase text-[10px] font-black tracking-[0.1em]">
                        <th class="px-8 py-6 text-left w-1/4">User / Performer</th>
                        <th class="px-6 py-6 text-left w-1/4">Module & Type</th>
                        <th class="px-6 py-6 text-left w-1/3">Activity Manifest</th>
                        <th class="px-8 py-6 text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @foreach($activities as $activity)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-950 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-2xl bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center text-teal-600 font-black text-xs border border-teal-100 dark:border-teal-900/30 group-hover:scale-110 transition-transform">
                                    {{ substr($activity->user_name ?? $activity->user->name ?? 'SYS', 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-800 dark:text-slate-200 text-sm italic">{{ $activity->user_name ?? $activity->user->name ?? 'System' }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $activity->ip_address ?? '127.0.0.1' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <span class="font-black text-xs text-slate-900 dark:text-slate-100 uppercase tracking-tight">{{ $activity->module_name }}</span>
                                <span class="text-[10px] font-bold {{ match($activity->action_type) {
                                    'create' => 'text-emerald-500',
                                    'update' => 'text-amber-500',
                                    'delete' => 'text-rose-500',
                                    default => 'text-slate-400'
                                } }} uppercase tracking-widest italic">{{ $activity->action_type }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6 font-bold text-slate-600 dark:text-slate-400 text-xs leading-relaxed uppercase tracking-tight">
                            {{ $activity->description }}
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-slate-800 dark:text-slate-200 tracking-tighter">{{ $activity->created_at->format('M d, Y') }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $activity->created_at->format('H:i:s') }}</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
