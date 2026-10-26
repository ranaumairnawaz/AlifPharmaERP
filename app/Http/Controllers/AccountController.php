<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\SalaryPayment;
use App\Models\MaterialEntry;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountController extends Controller
{
    /**
     * Unified Accounts Ledger – merges Income, Expenses, and Salary payments.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::tomorrow()->toDateString());
        $filter = $request->input('filter', 'all'); // all, income, expense

        // 1. Income entries
        $incomes = Income::whereBetween('income_date', [$startDate, $endDate])->get()
            ->map(fn($i) => (object) [
                'date' => $i->income_date,
                'title' => $i->title,
                'category' => $i->categoryLabel(),
                'type' => 'income',
                'amount' => (float) $i->amount,
                'status' => $i->status,
                'ref_type' => $i->ref_type,
                'ref_id' => $i->ref_id,
                'id' => $i->id,
                'delete_route' => 'accounts.income.destroy',
            ]);

        // 2. Manual expenses
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->get()
            ->map(fn($e) => (object) [
                'date' => $e->expense_date,
                'title' => $e->description ?? $e->category,
                'category' => $e->categoryLabel(),
                'type' => 'expense',
                'amount' => (float) $e->amount,
                'status' => $e->status,
                'ref_type' => $e->ref_type,
                'ref_id' => $e->ref_id,
                'id' => $e->id,
                'delete_route' => 'accounts.expense.destroy',
            ]);

        // 3. Paid salary payments as expense entries (read-only)
        $salaries = SalaryPayment::where('status', 'paid')
            ->whereBetween('paid_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->with('employee')
            ->get()
            ->map(fn($s) => (object) [
                'date' => Carbon::parse($s->paid_at)->toDateString(),
                'title' => 'Salary — ' . ($s->employee->name ?? 'Staff'),
                'category' => 'Salary Payment',
                'type' => 'expense',
                'amount' => (float) $s->net_salary,
                'status' => 'paid',
                'ref_type' => 'SalaryPayment',
                'ref_id' => $s->id,
                'id' => null, // read-only
                'delete_route' => null,
            ]);

        // Merge all
        $all = collect()->merge($incomes)->merge($expenses)->merge($salaries)
            ->sortByDesc('date');

        if ($filter === 'income')
            $ledger = $all->filter(fn($r) => $r->type === 'income');
        elseif ($filter === 'expense')
            $ledger = $all->filter(fn($r) => $r->type === 'expense');
        else
            $ledger = $all;

        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount') + $salaries->sum('amount');
        $netPL = $totalIncome - $totalExpense;

        // Outstanding receivables = unpaid invoice balances
        $receivables = Invoice::where('type', 'net')
            ->where('payment_status', '!=', 'paid')
            ->get()
            ->sum(fn($i) => $i->remainingBalance());

        // Outstanding payables = unpaid material purchase balances
        $payables = MaterialEntry::where('payment_status', '!=', 'paid')
            ->get()
            ->sum(fn($m) => $m->remainingBalance());

        // Asset valuation = current inventory at cost
        $assetValue = Product::where('material_type', 'finished_good')
            ->get()
            ->sum(fn($p) => $p->current_stock * ($p->cost_price ?? 0));

        $rawAssetValue = Product::whereIn('material_type', ['raw_material', 'packaging'])
            ->get()
            ->sum(fn($p) => $p->current_stock * ($p->cost_price ?? 0));

        return view('accounts.index', compact(
            'ledger',
            'totalIncome',
            'totalExpense',
            'netPL',
            'receivables',
            'payables',
            'assetValue',
            'rawAssetValue',
            'startDate',
            'endDate',
            'filter'
        ));
    }

    public function createIncome()
    {
        return view('accounts.create_income');
    }

    public function storeIncome(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:invoice_payment,advance_payment,loan_received,other',
            'amount' => 'required|numeric|min:0.01',
            'income_date' => 'required|date',
            'status' => 'required|in:received,pending',
            'description' => 'nullable|string',
        ]);

        Income::create($request->only([
            'title',
            'category',
            'amount',
            'income_date',
            'status',
            'description'
        ]));

        return redirect()->route('accounts.index')->with('success', 'Income entry recorded successfully.');
    }

    public function createExpense()
    {
        return view('accounts.create_expense');
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:500',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'status' => 'required|in:paid,pending',
            'payment_method' => 'required|in:cash,bank,credit,other',
        ]);

        Expense::create(array_merge($request->only([
            'description',
            'category',
            'amount',
            'expense_date',
            'status',
            'payment_method'
        ])));

        return redirect()->route('accounts.index')->with('success', 'Expense entry recorded successfully.');
    }

    public function destroyIncome(Income $income)
    {
        $income->delete();
        return redirect()->route('accounts.index')->with('success', 'Income entry deleted.');
    }

    public function destroyExpense(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('accounts.index')->with('success', 'Expense entry deleted.');
    }
}
