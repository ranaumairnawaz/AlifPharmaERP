@extends('layouts.app')

@section('content')
<div class="px-6 py-8">
    <div class="mb-8">
        <a href="{{ route('roles.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 transition-colors mb-4 group">
            <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Security Records
        </a>
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white uppercase tracking-tight">Modify Role Matrix</h2>
        <p class="mt-1 text-slate-500 dark:text-slate-400 tracking-tight">Granular control over system-wide operational permissions.</p>
    </div>

    <form action="{{ route('roles.update', $role) }}" method="POST" id="role-form">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <!-- Left Side: Role Profile -->
            <div class="xl:col-span-1 space-y-6">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2 border-b dark:border-slate-800 pb-3 uppercase italic">
                        <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Role Profile
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Managed Name</label>
                            <input type="text" name="name" value="{{ $role->name }}" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-bold outline-none ring-teal-500/10 focus:ring-4 focus:border-teal-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Activity Scope</label>
                            <textarea name="description" rows="4" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-sm font-medium outline-none ring-teal-500/10 focus:ring-4 focus:border-teal-500 transition-all resize-none">{{ $role->description }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl shadow-slate-900/20">
                    <h4 class="font-black mb-2 flex items-center gap-2 text-emerald-400 uppercase text-xs">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4"/></svg>
                        System Lock
                    </h4>
                    <p class="text-[10px] text-slate-400 leading-relaxed font-bold uppercase tracking-tight">Access policies synchronized via database-level atomic transactions. Changes are permanent.</p>
                </div>
                
                <button type="submit" class="w-full py-5 bg-teal-600 hover:bg-teal-700 text-white font-black rounded-2xl shadow-xl shadow-teal-900/20 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                    Apply Systematic Changes
                </button>
            </div>

            <!-- Right Side: Clean Matrix -->
            <div class="xl:col-span-3">
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="px-8 py-5 bg-slate-50 dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Master Permission Control Registry</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800">
                                    <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest w-1/4">Core Module</th>
                                    <th class="px-6 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Read Access</th>
                                    <th class="px-6 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Edit Policy</th>
                                    <th class="px-6 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Admin Control</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                @foreach($permissions as $module => $actions)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-950/50 transition-colors">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-2 w-2 rounded-full bg-teal-500"></div>
                                            <span class="font-black text-sm text-slate-800 dark:text-slate-100 uppercase tracking-tight">{{ Str::title($module) }}</span>
                                        </div>
                                    </td>
                                    @foreach(['read', 'edit', 'delete'] as $action)
                                    @php $perm = $actions->where('action', $action)->first(); @endphp
                                    <td class="px-6 py-4 text-center">
                                        @if($perm)
                                        <div class="flex justify-center items-center">
                                            <label class="matrix-toggle">
                                                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" 
                                                    {{ in_array($perm->id, $rolePermissions) ? 'checked' : '' }}>
                                                <span class="matrix-slider"></span>
                                            </label>
                                        </div>
                                        @endif
                                    </td>
                                    @endforeach
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

<style>
/* 100% Reliable Custom Matrix Toggles */
.matrix-toggle {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 24px;
}

.matrix-toggle input { 
    opacity: 0;
    width: 0;
    height: 0;
}

.matrix-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #e2e8f0;
    transition: .4s;
    border-radius: 24px;
}

.matrix-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

input:checked + .matrix-slider {
    background-color: #10b981; /* emerald-500 */
}

input:checked + .matrix-slider:before {
    transform: translateX(24px);
}

.dark .matrix-slider {
    background-color: #1e293b;
}

/* Tighten the UI gaps as requested */
.divide-y > :not([hidden]) ~ :not([hidden]) {
    border-top-width: 1px;
}
</style>
@endsection
