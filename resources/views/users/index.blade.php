@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 font-sans">
        <div>
            <h2 class="text-[10px] font-bold text-teal-600 uppercase tracking-[0.2em] mb-1 italic underline">System Governance</h2>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter transition-all">Personnel Security Ledger</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed max-w-2xl">Manage system access levels, onboard new team members, and monitor administrative authority across your pharmaceutical operations.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center rounded-xl bg-teal-600 px-6 py-3.5 text-xs font-black text-white shadow-xl shadow-teal-600/20 hover:bg-teal-500 transition-all active:scale-[0.98] uppercase tracking-[0.15em] group">
                <svg class="mr-3 h-4 w-4 transition-transform group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Onboard New Staff
            </a>
        </div>
    </div>

    <!-- Live Access Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 group transition-all hover:border-teal-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center group-hover:scale-110 transition-transform font-bold">
                    {{ $users->where('role', 'admin')->count() }}
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">System Administrators</p>
            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tighter italic opacity-70">"Master Authority"</h3>
        </div>

        <div class="bg-white dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 group transition-all hover:border-teal-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition-transform font-bold">
                    {{ $users->where('role', 'manager')->count() }}
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Stock Managers</p>
            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tighter italic opacity-70">"Operational Oversight"</h3>
        </div>

        <div class="bg-white dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 group transition-all hover:border-teal-500/30">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center group-hover:scale-110 transition-transform font-bold">
                    {{ $users->where('role', 'staff')->count() }}
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Generic Staff</p>
            <h3 class="text-xl font-black text-slate-900 dark:text-white tracking-tighter italic opacity-70">"Transactional Layer"</h3>
        </div>
    </div>

    <!-- Security Ledger -->
    <div class="bg-white dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
            <svg class="h-3.5 w-3.5 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            <h3 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em]">Personnel Security Ledger</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table id="users-table" class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="py-4 px-6">Identity Portal</th>
                        <th class="py-4 px-6">System Credential (Email)</th>
                        <th class="py-4 px-6">Access Authority</th>
                        <th class="py-4 px-6 text-right">Operation Control</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 flex-shrink-0 flex items-center justify-center rounded-xl font-black text-xs {{ $user->role === 'admin' ? 'bg-teal-600 text-white shadow-lg shadow-teal-600/20' : 'bg-slate-100 text-slate-400' }}">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-900 dark:text-slate-100 flex items-center gap-2 uppercase tracking-wide text-xs">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="text-[9px] bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 px-1.5 py-0.5 rounded-full lowercase tracking-normal">Session Active</span>
                                            @endif
                                        </div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-0.5 font-bold italic">User ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium italic text-xs lowercase">
                                {{ $user->email }}
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $badgeClass = match($user->role) {
                                        'admin' => 'bg-teal-50 text-teal-700 ring-teal-600/20 border-teal-200',
                                        'manager' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20 border-indigo-200',
                                        default => 'bg-slate-50 text-slate-700 ring-slate-600/20 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[10px] font-black uppercase tracking-widest {{ $badgeClass }} border border-inset ring-1 ring-inset shadow-sm transition-transform group-hover:scale-105">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex justify-end gap-3 opacity-20 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('users.edit', $user) }}" class="p-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-teal-600 dark:hover:text-teal-400 hover:border-teal-200 dark:hover:border-teal-900 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-all shadow-sm active:scale-95">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form id="revoke-access-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('revoke-access-{{ $user->id }}', 'Revoke System Access?', 'This identity will be immediately locked out of all corporate modules.', 'Yes, revoke access!')"
                                                class="p-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 hover:border-rose-200 dark:hover:border-rose-900 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all shadow-sm active:scale-95">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" /></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            dom: '<"dt-layout-row"<"dt-layout-cell"B><"dt-layout-cell"f>>rt<"dt-layout-row"<"dt-layout-cell"il><"dt-layout-cell"p>>',
            buttons: [
                {
                    extend: 'excel',
                    text: '<svg class="h-3 w-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Excel',
                    className: 'dt-button buttons-excel'
                }
            ],
            language: {
                search: "",
                searchPlaceholder: "Identify Staff...",
            },
            autoWidth: false,
            pageLength: 10
        });
    });
</script>
@endsection
