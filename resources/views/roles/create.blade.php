@extends('layouts.app')

@section('content')
<div class="px-6 py-8">
    <div class="mb-8">
        <a href="{{ route('roles.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 transition-colors mb-4 group">
            <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Security Records
        </a>
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Define New System Role</h2>
        <p class="mt-1 text-slate-500 dark:text-slate-400">Establish unique access levels across manufacturing and logistics modules.</p>
    </div>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Role Profile -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Role Profile
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Role Name</label>
                            <input type="text" name="name" required placeholder="e.g. Accounts Manager" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Operational Description</label>
                            <textarea name="description" rows="4" placeholder="Briefly describe the responsibilities..." class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-teal-600 rounded-2xl p-6 text-white shadow-lg shadow-teal-900/20">
                    <h4 class="font-bold mb-2 flex items-center gap-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Operational Tip
                    </h4>
                    <p class="text-sm text-teal-100 leading-relaxed">Changes to this role will immediately affect all assigned users. Ensure the permission combinations align with corporate auditing requirements.</p>
                </div>
                
                <button type="submit" class="w-full py-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-2xl shadow-xl shadow-teal-900/20 transition-all active:scale-95 flex items-center justify-center gap-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Authorize New Role
                </button>
            </div>

            <!-- Permission Matrix -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Dynamic Permission Matrix</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800">
                                    <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-widest min-w-[200px]">Module Name</th>
                                    <th class="px-6 py-4 text-center text-xs font-black text-slate-400 uppercase tracking-widest min-w-[100px]">Read</th>
                                    <th class="px-6 py-4 text-center text-xs font-black text-slate-400 uppercase tracking-widest min-w-[100px]">Edit</th>
                                    <th class="px-6 py-4 text-center text-xs font-black text-slate-400 uppercase tracking-widest min-w-[100px]">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $module => $actions)
                                <tr class="border-b border-slate-50 dark:border-slate-800 last:border-0 hover:bg-slate-50/50 dark:hover:bg-slate-950/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-2 w-2 rounded-full bg-teal-500"></div>
                                            <span class="font-bold text-slate-700 dark:text-slate-200 uppercase tracking-tight">{{ Str::title($module) }}</span>
                                        </div>
                                    </td>
                                    @php
                                        $read = $actions->where('action', 'read')->first();
                                        $edit = $actions->where('action', 'edit')->first();
                                        $delete = $actions->where('action', 'delete')->first();
                                    @endphp
                                    <td class="px-6 py-4 text-center">
                                        @if($read)
                                        <label class="relative inline-flex items-center justify-center cursor-pointer">
                                            <input type="checkbox" name="permissions[]" value="{{ $read->id }}" class="peer sr-only">
                                            <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:bg-teal-600 transition-colors"></div>
                                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5"></div>
                                        </label>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($edit)
                                        <label class="relative inline-flex items-center justify-center cursor-pointer">
                                            <input type="checkbox" name="permissions[]" value="{{ $edit->id }}" class="peer sr-only">
                                            <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:bg-orange-600 transition-colors"></div>
                                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5"></div>
                                        </label>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($delete)
                                        <label class="relative inline-flex items-center justify-center cursor-pointer">
                                            <input type="checkbox" name="permissions[]" value="{{ $delete->id }}" class="peer sr-only">
                                            <div class="w-11 h-6 bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:bg-rose-600 transition-colors"></div>
                                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5"></div>
                                        </label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
