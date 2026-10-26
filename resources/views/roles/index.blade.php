@extends('layouts.app')

@section('content')
<div class="px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Security & Access Control</h2>
            <p class="mt-1 text-slate-500 dark:text-slate-400">Manage granular permissions (Read, Edit, Delete) for your corporate team.</p>
        </div>
        <a href="{{ route('roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-teal-900/20 active:scale-95">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Define New Role
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roles as $role)
        <div class="group relative bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 transition-all hover:shadow-2xl hover:shadow-teal-900/10 hover:-translate-y-1">
            <div class="flex items-start justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400 transition-colors group-hover:bg-teal-600 group-hover:text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('roles.edit', $role) }}" class="p-2 text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    @if($role->slug !== 'admin')
                    <form id="delete-role-{{ $role->id }}" action="{{ route('roles.destroy', $role) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                                onclick="confirmDelete('delete-role-{{ $role->id }}', 'Purge Security Role?', 'Archiving this role will immediately revoke access for all associated staff members.')"
                                class="p-2 text-slate-400 hover:text-rose-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v2M4 7h16" /></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">{{ $role->name }}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-6">{{ $role->description ?: 'No operational description provided.' }}</p>

            <div class="flex items-center gap-4 text-xs font-bold text-slate-400 uppercase tracking-widest border-t border-slate-100 dark:border-slate-800 pt-4 mt-auto">
                <div class="flex items-center gap-1.5">
                    <span class="text-teal-600 dark:text-teal-400">{{ $role->permissions_count }}</span>
                    <span>Rules</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="text-teal-600 dark:text-teal-400">{{ $role->users_count }}</span>
                    <span>Staff</span>
                </div>
            </div>

            @if($role->slug === 'admin')
            <div class="absolute top-4 right-4 h-2 w-2 rounded-full bg-orange-500 ring-4 ring-orange-500/20" title="System Protected"></div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
