@extends('layouts.app')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-10">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight text-center sm:text-left">Edit Brand</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 text-center sm:text-left">Modify brand identities and manufacturer associations.</p>
    </div>
    <div class="mt-4 sm:mt-0 flex justify-center">
        <a href="{{ route('brands.index') }}" class="inline-flex items-center rounded-lg bg-white dark:bg-slate-800 px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Directory
        </a>
    </div>
</div>

<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 lg:p-8 transition-all">
        <form action="{{ route('brands.update', $brand) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Brand Name</label>
                <input type="text" name="name" value="{{ $brand->name }}" required class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Manufacturer Group</label>
                <select name="group_id" required class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none transition-all">
                    @foreach(App\Models\Group::orderBy('name')->get() as $group)
                        <option value="{{ $group->id }}" {{ $brand->group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-400 uppercase tracking-tight mb-2 px-1">Additional Notes</label>
                <textarea name="description" rows="4" class="block w-full rounded-lg border-slate-200 dark:border-slate-700 py-3 px-4 text-sm text-slate-600 dark:text-slate-300 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 shadow-inner dark:shadow-none transition-all">{{ $brand->description }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-8 py-3 text-sm font-bold text-white shadow-sm hover:bg-teal-500 transition-all active:scale-[0.98]">
                    Save Brand Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
