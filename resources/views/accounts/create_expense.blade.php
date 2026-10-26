@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="mb-8">
        <a href="{{ route('accounts.index') }}" class="inline-flex items-center text-[10px] font-bold text-slate-400 hover:text-rose-600 transition-all uppercase tracking-[0.2em] mb-4 group">
            <svg class="mr-2 h-3.5 w-3.5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Accounts Ledger
        </a>
        <h2 class="text-[10px] font-black text-rose-600 uppercase tracking-[0.3em] mb-1">Finance Module</h2>
        <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">Log New Expense Entry</h1>
    </div>

    <form action="{{ route('accounts.expense.store') }}" method="POST"
          class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-8 space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Description *</label>
                <input type="text" name="description" required value="{{ old('description') }}"
                    placeholder="e.g. Electricity bill for March 2026"
                    class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
                @error('description')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Category *</label>
                <select name="category" required class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
                    <option value="Utilities" {{ old('category') === 'Utilities' ? 'selected' : '' }}>Utilities (Electricity, Gas, Water)</option>
                    <option value="Transport" {{ old('category') === 'Transport' ? 'selected' : '' }}>Transport & Logistics</option>
                    <option value="Maintenance" {{ old('category') === 'Maintenance' ? 'selected' : '' }}>Maintenance & Repairs</option>
                    <option value="Marketing" {{ old('category') === 'Marketing' ? 'selected' : '' }}>Marketing & Advertising</option>
                    <option value="Administrative" {{ old('category') === 'Administrative' ? 'selected' : '' }}>Administrative / Office</option>
                    <option value="Other" {{ old('category', 'Other') === 'Other' ? 'selected' : '' }}>Other Expense</option>
                </select>
                @error('category')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Amount (Rs.) *</label>
                <input type="number" name="amount" step="0.01" min="0.01" required value="{{ old('amount') }}"
                    placeholder="0.00"
                    class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-black text-rose-700 dark:text-rose-400 bg-rose-50/30 dark:bg-rose-900/10 focus:ring-rose-500 focus:border-rose-500 transition-all font-mono">
                @error('amount')<p class="mt-1 text-xs text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Expense Date *</label>
                <input type="date" name="expense_date" required value="{{ old('expense_date', date('Y-m-d')) }}"
                    class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-900 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Payment Method *</label>
                <select name="payment_method" required class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
                    <option value="cash" {{ old('payment_method', 'cash') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="bank" {{ old('payment_method') === 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="credit" {{ old('payment_method') === 'credit' ? 'selected' : '' }}>Credit / On Account</option>
                    <option value="other" {{ old('payment_method') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status *</label>
                <select name="status" required class="block w-full rounded-xl border-slate-200 dark:border-slate-700 py-3 px-4 text-sm font-bold text-slate-800 dark:text-slate-200 bg-slate-50/50 dark:bg-slate-800 focus:ring-teal-500 focus:border-teal-500 transition-all">
                    <option value="paid" {{ old('status', 'paid') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
            <a href="{{ route('accounts.index') }}" class="text-xs font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest">← Cancel</a>
            <button type="submit" class="inline-flex items-center rounded-xl bg-rose-600 px-6 py-3 text-xs font-black text-white shadow-lg shadow-rose-600/20 hover:bg-rose-500 transition-all uppercase tracking-widest">
                Record Expense Entry →
            </button>
        </div>
    </form>
</div>
@endsection
