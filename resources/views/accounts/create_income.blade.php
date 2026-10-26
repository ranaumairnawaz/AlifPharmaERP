@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto py-10 px-4">
        <div class="mb-8">
            <a href="{{ route('accounts.index') }}"
                class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-emerald-600 transition-all uppercase tracking-[0.2em] mb-4 group">
                <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Accounts Ledger
            </a>
            <h2 class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-1">Finance Module</h2>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">Log New Income Entry</h1>
        </div>

        <form action="{{ route('accounts.income.store') }}" method="POST"
            class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Title /
                        Description *</label>
                    <input type="text" name="title" required value="{{ old('title') }}"
                        placeholder="e.g. Payment received from ABC Distributor"
                        class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
                    @error('title')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Category
                        *</label>
                    <select name="category" required
                        class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
                        <option value="invoice_payment" {{ old('category') === 'invoice_payment' ? 'selected' : '' }}>Invoice
                            Payment</option>
                        <option value="advance_payment" {{ old('category') === 'advance_payment' ? 'selected' : '' }}>Advance
                            Payment</option>
                        <option value="loan_received" {{ old('category') === 'loan_received' ? 'selected' : '' }}>Loan
                            Received</option>
                        <option value="other" {{ old('category', 'other') === 'other' ? 'selected' : '' }}>Other Income
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Amount (Rs.)
                        *</label>
                    <input type="number" name="amount" step="0.01" min="0.01" required value="{{ old('amount') }}"
                        placeholder="0.00"
                        class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-black text-emerald-700 dark:text-emerald-400 bg-emerald-50/30 dark:bg-emerald-900/10 focus:ring-emerald-500 focus:border-emerald-500 transition-all font-mono">
                    @error('amount')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Income Date
                        *</label>
                    <input type="date" name="income_date" required value="{{ old('income_date', date('Y-m-d')) }}"
                        class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status
                        *</label>
                    <select name="status" required
                        class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
                        <option value="received" {{ old('status', 'received') === 'received' ? 'selected' : '' }}>Received
                        </option>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Notes
                        (Optional)</label>
                    <textarea name="description" rows="2" placeholder="Additional notes..."
                        class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm text-slate-700 dark:text-slate-300 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
                <a href="{{ route('accounts.index') }}"
                    class="text-xs font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest">← Cancel</a>
                <button type="submit"
                    class="inline-flex items-center rounded-xl bg-emerald-600 px-6 py-3 text-xs font-black text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-500 transition-all uppercase tracking-widest">
                    Record Income Entry →
                </button>
            </div>
        </form>
    </div>
@endsection