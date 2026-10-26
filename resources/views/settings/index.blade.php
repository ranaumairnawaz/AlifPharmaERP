@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
        <div>
            <h2 class="text-[10px] font-bold text-teal-600 dark:text-teal-400 uppercase tracking-[0.25em] mb-2 px-1">Application Hub</h2>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">System Intelligence & Configuration</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium italic mt-1">Configure global application behavior and redundant data protection protocols.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Main Configuration -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none overflow-hidden transition-all">
                <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-xl bg-teal-600 text-white flex items-center justify-center shadow-lg shadow-teal-500/20">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        </div>
                        <h3 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Redundant Security Protocol (Offline Backup)</h3>
                    </div>
                </div>

                <form action="{{ route('settings.update') }}" method="POST" class="p-8 space-y-8" x-data="{ cloudEnabled: {{ $cloud_backup_enabled == '1' ? 'true' : 'false' }} }">
                    @csrf
                    
                    <!-- Local Redundancy -->
                    <div>
                        <div class="flex items-center gap-2 mb-3 px-1">
                            <div class="h-1.5 w-1.5 rounded-full bg-teal-500 shadow-[0_0_8px_rgba(20,184,166,0.6)]"></div>
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest text-xs">Primary Redundancy Path (Local Mirror)</label>
                        </div>
                        <div class="relative group">
                            <input type="text" name="backup_path" value="{{ old('backup_path', $backup_path) }}" placeholder="C:\Users\AlifPharma\Backups" required
                                class="block w-full rounded-2xl border-slate-200 dark:border-slate-700 py-4 px-6 text-sm font-bold text-slate-700 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 shadow-inner group-hover:bg-white dark:group-hover:bg-slate-700">
                            <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none opacity-40">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Cloud Redundancy Hub (Google Drive) -->
                    <div class="pt-8 border-t border-slate-50 dark:border-slate-800">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center border border-indigo-100 dark:border-indigo-900/50 shadow-sm">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-tighter">Google Drive Mirroring Protocol</h3>
                                    <p class="text-[10px] text-indigo-500/80 dark:text-indigo-400/60 font-bold tracking-tight italic text-xs">Secondary Cloud Data Protection</p>
                                </div>
                            </div>
                            <div class="relative inline-block w-12 h-6 transition duration-200 ease-in">
                                <input type="checkbox" name="cloud_backup_enabled" id="cloud_backup_enabled" value="1" x-model="cloudEnabled"
                                    class="absolute w-6 h-6 rounded-full bg-white border-4 border-slate-300 appearance-none cursor-pointer transition-transform duration-200 ease-in checked:translate-x-6 checked:border-indigo-600 outline-none z-10">
                                <label for="cloud_backup_enabled" class="block overflow-hidden h-6 rounded-full bg-slate-200 cursor-pointer"></label>
                            </div>
                        </div>

                        <div x-show="cloudEnabled" x-transition.opacity class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-slate-50/50 dark:bg-slate-800/30 rounded-3xl border border-slate-100 dark:border-slate-800">
                            <div class="md:col-span-2">
                                <label class="block text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1 text-xs">Mirroring Identity (Client ID)</label>
                                <input type="text" name="google_drive_client_id" value="{{ old('google_drive_client_id', $google_drive_client_id) }}" placeholder="123456789-abc.apps.googleusercontent.com"
                                    class="block w-full rounded-xl border-slate-100 dark:border-slate-700 py-3 px-5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1 text-xs">Mirroring Secret Key</label>
                                <input type="password" name="google_drive_client_secret" value="{{ old('google_drive_client_secret', $google_drive_client_secret) }}" placeholder="••••••••••••••••"
                                    class="block w-full rounded-xl border-slate-100 dark:border-slate-700 py-3 px-5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1 text-xs">Persistent Access (Refresh Token)</label>
                                <input type="password" name="google_drive_refresh_token" value="{{ old('google_drive_refresh_token', $google_drive_refresh_token) }}" placeholder="1//0abcde-..."
                                    class="block w-full rounded-xl border-slate-100 dark:border-slate-700 py-3 px-5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1 text-xs">Target Storage Folder ID (Optional)</label>
                                <input type="text" name="google_drive_folder_id" value="{{ old('google_drive_folder_id', $google_drive_folder_id) }}" placeholder="1yXuv..."
                                    class="block w-full rounded-xl border-slate-100 dark:border-slate-700 py-3 px-5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Corporate Identity Hub (Branding) -->
                    <div class="pt-8 border-t border-slate-50 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-2xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center border border-teal-100 dark:border-teal-900/50 shadow-sm">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h14a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-tighter">Corporate Identity Hub</h3>
                                <p class="text-[10px] text-teal-500/80 dark:text-teal-400/60 font-bold tracking-tight italic text-xs">Synchronized Brand Presence across UI & PDFs</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1 text-xs">Global Company Name</label>
                                <input type="text" name="company_name" value="{{ old('company_name', $company_name) }}" placeholder="Alif Pharma"
                                    class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-5 text-sm font-bold text-slate-700 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all shadow-inner dark:shadow-none">
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1 text-xs">Primary Executive Color (Hex)</label>
                                <div class="flex gap-2">
                                    <input type="color" name="brand_color" value="{{ old('brand_color', $brand_color) }}" 
                                        class="h-11 w-16 p-1 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 cursor-pointer">
                                    <input type="text" value="{{ $brand_color }}" readonly class="flex-1 rounded-xl border-slate-200 dark:border-slate-700 py-3 px-5 text-xs font-mono font-bold text-slate-400 bg-slate-50/30 dark:bg-slate-800/30">
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1 text-xs">Corporate Shield / Logo Upload</label>
                                <div class="flex items-center gap-6 p-4 bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                                    <div class="h-16 w-16 rounded-xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 flex items-center justify-center overflow-hidden">
                                        <img src="{{ $company_logo }}" class="max-h-12 max-w-12 object-contain" id="logo-preview">
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="company_logo_file" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-all">
                                        <p class="text-[9px] text-slate-400 mt-2 italic font-medium">Recommended: PNG or SVG with transparent background (Max 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="flex items-center justify-between p-4 bg-amber-50/30 dark:bg-amber-900/10 rounded-2xl border border-amber-100/50 dark:border-amber-900/30">
                                    <div class="flex items-center gap-3">
                                        <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                        <div>
                                            <h4 class="text-[10px] font-black text-amber-800 dark:text-amber-400 uppercase tracking-tight">Global PDF Color Override</h4>
                                            <p class="text-[9px] text-amber-700/60 dark:text-amber-500/50 font-bold italic tracking-tight">Apply brand color to Invoices, DCs & Reports</p>
                                        </div>
                                    </div>
                                    <select name="pdf_override_colors" class="text-[10px] font-black rounded-lg border-amber-200 dark:border-amber-900 bg-white dark:bg-slate-900 text-amber-700 appearance-none px-4 py-1 pr-8">
                                        <option value="false" {{ $pdf_override_colors === 'false' ? 'selected' : '' }}>Legacy Colors (Teal/Emerald)</option>
                                        <option value="true" {{ $pdf_override_colors === 'true' ? 'selected' : '' }}>Corporate Brand Color</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-50">
                        <button type="submit" class="w-full h-14 rounded-2xl bg-teal-600 text-white font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-teal-500/20 hover:bg-teal-500 transition-all active:scale-[0.98] outline-none">
                            Save & Synchronize Infrastructure
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-indigo-900 rounded-3xl p-8 text-white shadow-2xl shadow-indigo-900/20 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:scale-125 transition-transform duration-700">
                    <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                </div>
                <div class="relative z-10">
                    <h4 class="text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-4">Native Desktop Performance Guide</h4>
                    <p class="text-sm font-medium text-indigo-50/80 leading-relaxed max-w-xl">
                        "Your Alif Pharma environment is currently optimized for high-velocity manual mirroring. This configuration ensures that every transaction is recoverable via your secondary redundant path in the Cloud Hub, providing a 100% data integrity guarantee across networks."
                    </p>
                </div>
            </div>
        </div>

        <!-- Sidebar context -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white dark:bg-slate-900/50 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/20 dark:shadow-none overflow-hidden transition-all">
                <div class="p-8">
                    <h3 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-6">Device Information</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-slate-50 dark:border-slate-800 last:border-0">
                            <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Environment</span>
                            <span class="text-[10px] font-black text-slate-700 dark:text-slate-200">Production / Native Electron</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-slate-50 dark:border-slate-800 last:border-0">
                            <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Database Engine</span>
                            <span class="text-[10px] font-black text-slate-700 dark:text-slate-200">SQLite v3 High Performance</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-slate-50 dark:border-slate-800 last:border-0">
                            <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Last backup</span>
                            <span class="text-[10px] font-black text-teal-600 dark:text-teal-400 text-xs">Pending Sync...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
