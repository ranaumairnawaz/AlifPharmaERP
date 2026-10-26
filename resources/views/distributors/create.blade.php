@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
        <a href="{{ route('distributors.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-all uppercase tracking-[0.2em] mb-4 group font-sans">
            <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3" /></svg>
            Distribution Index
        </a>
        <h2 class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em] mb-1 italic underline decoration-teal-500/30">Partner Hub</h2>
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Onboard New Distributor</h1>
    </div>

    <form action="{{ route('distributors.store') }}" method="POST" class="space-y-10">
        @csrf

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden group transition-all hover:border-teal-500/20">
            <div class="p-8 sm:p-10 space-y-8">
                <div class="grid grid-cols-1 gap-8 font-sans">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-teal-600">Company / Business Name</label>
                            <input type="text" name="company_name" required placeholder="e.g. MA Distributor" 
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-indigo-600">Contact Executive Name</label>
                            <input type="text" name="contact_name" placeholder="e.g. Naseer Ahmed" 
                                class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all outline-none">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Designated Delivery Area</label>
                            <input type="text" name="area" placeholder="e.g. Okara" 
                                class="block w-full rounded-2xl border-slate-200 py-3.5 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Contact Phone</label>
                            <input type="text" name="phone" placeholder="+92 XXX XXXXXXX" 
                                class="block w-full rounded-2xl border-slate-200 py-3.5 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1">Street Address / Warehouse Loc.</label>
                        <input type="text" name="street_address" placeholder="e.g. 12B Logistics Hub" 
                            class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 px-1 text-emerald-600">City</label>
                        <input type="text" name="city" placeholder="e.g. Okara" 
                            class="block w-full rounded-2xl border-slate-200 py-4 px-6 text-sm font-bold text-slate-900 bg-white shadow-inner focus:ring-4 focus:ring-teal-500/5 focus:border-teal-500 transition-all outline-none italic">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-6 border-t border-slate-100 font-sans">
            <a href="{{ route('distributors.index') }}" class="text-[10px] font-black text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest group italic">
                <span class="inline-block transition-transform group-hover:-translate-x-1">&larr;</span> Terminate Process
            </a>
            
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-teal-600 px-10 py-5 text-sm font-black text-white shadow-2xl shadow-teal-600/30 hover:bg-teal-500 transition-all active:scale-[0.98] uppercase tracking-[0.2em] group/btn">
                Confirm Registration
                <svg class="ml-4 h-4 w-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </button>
        </div>
    </form>
</div>
@endsection
