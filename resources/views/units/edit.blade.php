@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('units.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-colors uppercase tracking-[0.2em] mb-2 group">
            <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3"/></svg>
            Metric Catalog
        </a>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit UOM: {{ $unit->name }}</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 group relative overflow-hidden transition-all hover:border-teal-100">
        <form action="{{ route('units.update', $unit) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="grid grid-cols-3 gap-4 md:col-span-2">
                    <div class="col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Metric Title</label>
                        <input type="text" name="name" required value="{{ old('name', $unit->name) }}" class="block w-full rounded-lg border-slate-200 py-3 px-4 text-sm font-bold text-slate-900 bg-slate-50/50 focus:ring-teal-500 focus:border-teal-500 shadow-inner">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Symbol</label>
                        <input type="text" name="short_name" required value="{{ old('short_name', $unit->short_name) }}" class="block w-full rounded-lg border-slate-200 py-3 px-4 text-sm font-bold text-slate-900 bg-slate-50/50 focus:ring-teal-500 focus:border-teal-500 shadow-inner text-center">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Functional Description</label>
                    <textarea name="description" rows="3" class="block w-full rounded-lg border-slate-200 py-3 px-4 text-sm text-slate-600 bg-slate-50/50 focus:ring-teal-500 focus:border-teal-500 shadow-inner">{{ old('description', $unit->description) }}</textarea>
                </div>

                <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <input type="hidden" name="is_decimal" value="0">
                    <input id="is_decimal" name="is_decimal" type="checkbox" value="1" {{ $unit->is_decimal ? 'checked' : '' }} class="h-5 w-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 transition-all cursor-pointer">
                    <label for="is_decimal" class="text-xs font-bold text-indigo-700 uppercase tracking-widest cursor-pointer hover:text-indigo-600 transition-colors">Decimal Scaling Enabled</label>
                </div>

                <div class="flex items-center gap-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <input type="hidden" name="is_active" value="0">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ $unit->is_active ? 'checked' : '' }} class="h-5 w-5 text-teal-600 border-slate-300 rounded focus:ring-teal-500 transition-all cursor-pointer">
                    <label for="is_active" class="text-xs font-bold text-teal-700 uppercase tracking-widest cursor-pointer hover:text-teal-600 transition-colors">Metric Available for Use</label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="{{ route('units.index') }}" class="text-[10px] font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors">Discard</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-8 py-3 text-xs font-bold text-white shadow-lg shadow-teal-500/20 hover:bg-teal-500 transition-all active:scale-[0.98]">
                    Sync Metric &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
