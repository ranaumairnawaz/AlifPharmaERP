@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('groups.index') }}"
                class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-teal-600 transition-colors uppercase tracking-[0.2em] mb-2 group">
                <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7V3" />
                </svg>
                group Matrix
            </a>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit group: {{ $group->name }}</h1>
        </div>

        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 group relative overflow-hidden transition-all hover:border-teal-100">
            <form action="{{ route('groups.update', $group) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label
                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Manufacturer
                            Name</label>
                        <input type="text" name="name" required value="{{ old('name', $group->name) }}"
                            class="block w-full rounded-lg border-slate-200 py-3 px-4 text-sm font-bold text-slate-900 bg-slate-50/50 focus:ring-teal-500 focus:border-teal-500 shadow-inner overflow-hidden">
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Corporate
                            Website</label>
                        <input type="url" name="website" value="{{ old('website', $group->website) }}"
                            class="block w-full rounded-lg border-slate-200 py-3 px-4 text-sm text-slate-600 bg-slate-50/50 focus:ring-teal-500 focus:border-teal-500 shadow-inner">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Contact
                                Person</label>
                            <input type="text" name="contact_person"
                                value="{{ old('contact_person', $group->contact_person) }}"
                                class="block w-full rounded-lg border-slate-200 py-3 px-4 text-xs font-bold text-slate-900 bg-slate-50/50 focus:ring-teal-500 focus:border-teal-500 shadow-inner">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Direct
                                Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $group->phone) }}"
                                class="block w-full rounded-lg border-slate-200 py-3 px-4 text-xs font-bold text-slate-900 bg-slate-50/50 focus:ring-teal-500 focus:border-teal-500 shadow-inner">
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Country
                            of Origin</label>
                        <input type="text" name="country_of_origin"
                            value="{{ old('country_of_origin', $group->country_of_origin) }}"
                            class="block w-full rounded-lg border-slate-200 py-3 px-4 text-sm text-slate-600 bg-slate-50/50 focus:ring-teal-500 focus:border-teal-500 shadow-inner">
                    </div>

                    <div class="md:col-span-2">
                        <label
                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Manufacturer
                            Profile Notes</label>
                        <textarea name="description" rows="4"
                            class="block w-full rounded-lg border-slate-200 py-3 px-4 text-sm text-slate-600 bg-slate-50/50 focus:ring-teal-500 focus:border-teal-500 shadow-inner">{{ old('description', $group->description) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                    <a href="{{ route('groups.index') }}"
                        class="text-[10px] font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors">Discard</a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-8 py-3 text-xs font-bold text-white shadow-lg shadow-teal-500/20 hover:bg-teal-500 transition-all active:scale-[0.98]">
                        Sync group Record &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection