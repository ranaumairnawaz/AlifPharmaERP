<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Expense;
use App\Models\Income;
use App\Models\SalaryPayment;
use App\Models\MaterialEntry;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    private function getDateRange(Request $request): array
    {
        $timeframe = $request->get('timeframe', 'monthly');
        $startDate = $request->get('start_date');
        $endDate   = $request->get('end_date');

        $startsAt = match ($timeframe) {
            'daily'   => Carbon::today(),
            'weekly'  => Carbon::now()->startOfWeek(),
            'monthly' => Carbon::now()->startOfMonth(),
            'yearly'  => Carbon::now()->startOfYear(),
            'custom'  => $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth(),
            default   => Carbon::now()->startOfMonth(),
        };

        $endsAt = match ($timeframe) {
            'daily'  => Carbon::today()->endOfDay(),
            'custom' => $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay(),
            default  => Carbon::now()->endOfDay(),
        };

        return [$startsAt, $endsAt, $timeframe];
    }

    private function getReportData(Request $request): array
    {
        [$startsAt, $endsAt, $timeframe] = $this->getDateRange($request);
        $type = $request->get('type', 'sales');

        $summary = [];
        $results = collect();

        // ─── 1. Sales & Revenue ─────────────────────────────────────────────
        if ($type === 'sales') {
            $invoices = Invoice::with(['slip.distributor'])
                ->where('type', 'net')
                ->whereBetween('created_at', [$startsAt, $endsAt])
                ->latest()->get();

            $revenue   = $invoices->sum('grand_total');
            $collected = $invoices->sum('paid_amount');
            $count     = $invoices->count();

            $summary = [
                'revenue'     => $revenue,
                'collected'   => $collected,
                'outstanding' => $revenue - $collected,
                'count'       => $count,
                'avg'         => $count > 0 ? $revenue / $count : 0,
            ];
            $results = $invoices;
        }

        // ─── 2. Outstanding Receivables ──────────────────────────────────────
        elseif ($type === 'receivables') {
            $invoices = Invoice::with(['slip.distributor'])
                ->where('type', 'net')
                ->where('payment_status', '!=', 'paid')
                ->whereBetween('created_at', [$startsAt, $endsAt])
                ->latest()->get();

            $totalOutstanding = $invoices->sum(fn($i) => $i->remainingBalance());
            $count = $invoices->count();

            $summary = [
                'outstanding' => $totalOutstanding,
                'count'       => $count,
                'avg_debt'    => $count > 0 ? $totalOutstanding / $count : 0,
            ];
            $results = $invoices;
        }

        // ─── 3. Product Profitability ────────────────────────────────────────
        elseif ($type === 'profit') {
            $items = InvoiceItem::whereHas('invoice', fn($q) =>
                    $q->where('type', 'net')->whereBetween('created_at', [$startsAt, $endsAt])
                )
                ->select('product_id',
                    DB::raw('SUM(quantity) as total_sold'),
                    DB::raw('SUM(total_price) as revenue')
                )
                ->groupBy('product_id')
                ->with('product')
                ->get();

            $totalRevenue = 0;
            $totalCost    = 0;

            foreach ($items as $item) {
                $cost               = $item->total_sold * ($item->product->cost_price ?? 0);
                $item->product_name = $item->product->name;
                $item->total_cost   = $cost;
                $item->profit       = $item->revenue - $cost;
                $totalRevenue += $item->revenue;
                $totalCost    += $cost;
            }

            $summary = [
                'revenue' => $totalRevenue,
                'cogs'    => $totalCost,
                'profit'  => $totalRevenue - $totalCost,
            ];
            $results = $items;
        }

        // ─── 4. Inventory Turnover ───────────────────────────────────────────
        elseif ($type === 'turnover') {
            $items = InvoiceItem::whereHas('invoice', fn($q) =>
                    $q->where('type', 'net')->whereBetween('created_at', [$startsAt, $endsAt])
                )
                ->select('product_id', DB::raw('SUM(quantity) as sold_qty'))
                ->groupBy('product_id')
                ->with('product')
                ->get();

            $totalCOGS = 0;
            foreach ($items as $item) {
                $cogs              = $item->sold_qty * ($item->product->cost_price ?? 0);
                $item->product_name = $item->product->name;
                $item->cogs        = $cogs;
                $item->stock_value = $item->product->current_stock * ($item->product->cost_price ?? 0);
                $totalCOGS        += $cogs;
            }

            $avgStockValue = Product::all()->sum(fn($p) => $p->current_stock * ($p->cost_price ?? 0));

            $summary = [
                'cogs'      => $totalCOGS,
                'avg_stock' => $avgStockValue,
                'ratio'     => $avgStockValue > 0 ? $totalCOGS / $avgStockValue : 0,
            ];
            $results = $items;
        }

        // ─── 5. Payroll (FIXED column names) ────────────────────────────────
        elseif ($type === 'payroll') {
            $payments = SalaryPayment::with('employee')
                ->where('status', 'paid')
                ->whereBetween('paid_at', [$startsAt, $endsAt])
                ->get();

            $total      = $payments->sum('net_salary'); // FIXED: was 'amount'
            $staffCount = $payments->count();

            foreach ($payments as $p) {
                $p->employee_name = $p->employee->name ?? 'Unknown';
                $p->designation   = $p->employee->designation ?? 'Staff';
                $p->total_paid    = $p->net_salary; // FIXED: was 'amount'
            }

            $summary = [
                'payroll'    => $total,
                'staff'      => $staffCount,
                'avg'        => $staffCount > 0 ? $total / $staffCount : 0,
            ];
            $results = $payments;
        }

        // ─── 6. Expense Breakdown ────────────────────────────────────────────
        elseif ($type === 'expenses') {
            $expenses = Expense::whereBetween('expense_date', [$startsAt->toDateString(), $endsAt->toDateString()])
                ->get();

            $byCategory = $expenses->groupBy('category')->map(fn($g) => $g->sum('amount'));
            $total      = $expenses->sum('amount');

            $summary = [
                'total'       => $total,
                'by_category' => $byCategory,
                'count'       => $expenses->count(),
            ];
            $results = $expenses;
        }

        // ─── 7. Material Procurement ─────────────────────────────────────────
        elseif ($type === 'procurement') {
            $entries = MaterialEntry::with('stockMovements.product')
                ->whereBetween('transaction_date', [$startsAt->toDateString(), $endsAt->toDateString()])
                ->latest('transaction_date')
                ->get();

            $totalSpend  = $entries->sum('total_amount');
            $totalUnits  = $entries->flatMap->stockMovements->sum('quantity');

            $summary = [
                'total_spend'  => $totalSpend,
                'total_units'  => $totalUnits,
                'entry_count'  => $entries->count(),
            ];
            $results = $entries;
        }

        // ─── 8. P&L Statement (Full) ─────────────────────────────────────────
        elseif ($type === 'pl_statement') {
            // INCOME SIDE
            $invoiceRevenue = Invoice::where('type', 'net')
                ->whereBetween('created_at', [$startsAt, $endsAt])
                ->sum('grand_total');

            $manualIncome = Income::whereBetween('income_date', [$startsAt->toDateString(), $endsAt->toDateString()])
                ->where('status', 'received')
                ->sum('amount');

            $totalIncome = $invoiceRevenue + $manualIncome;

            // EXPENSE SIDE
            $materialCost = Expense::where('category', 'Material Procurement')
                ->whereBetween('expense_date', [$startsAt->toDateString(), $endsAt->toDateString()])
                ->sum('amount');

            $salaryCost = SalaryPayment::where('status', 'paid')
                ->whereBetween('paid_at', [$startsAt, $endsAt])
                ->sum('net_salary');

            $otherExpenses = Expense::where('category', '!=', 'Material Procurement')
                ->whereBetween('expense_date', [$startsAt->toDateString(), $endsAt->toDateString()])
                ->sum('amount');

            $totalExpenses = $materialCost + $salaryCost + $otherExpenses;
            $netPL         = $totalIncome - $totalExpenses;

            $summary = [
                // Income
                'invoice_revenue' => $invoiceRevenue,
                'manual_income'   => $manualIncome,
                'total_income'    => $totalIncome,
                // Expenses
                'material_cost'   => $materialCost,
                'salary_cost'     => $salaryCost,
                'other_expenses'  => $otherExpenses,
                'total_expenses'  => $totalExpenses,
                // Bottom line
                'net_pl'          => $netPL,
            ];
            $results = collect(); // No table rows for P&L statement
        }

        // ─── 9. Asset Valuation ──────────────────────────────────────────────
        elseif ($type === 'assets') {
            $products = Product::with('unit')
                ->where('current_stock', '>', 0)
                ->get()
                ->map(function ($p) {
                    $p->stock_value = $p->current_stock * ($p->cost_price ?? 0);
                    return $p;
                })
                ->sortByDesc('stock_value');

            $fgValue  = $products->where('material_type', 'finished_good')->sum('stock_value');
            $rmValue  = $products->where('material_type', 'raw_material')->sum('stock_value');
            $pmValue  = $products->where('material_type', 'packaging')->sum('stock_value');

            $summary = [
                'total_value' => $fgValue + $rmValue + $pmValue,
                'fg_value'    => $fgValue,
                'rm_value'    => $rmValue,
                'pm_value'    => $pmValue,
                'sku_count'   => $products->count(),
            ];
            $results = $products;
        }

        return [
            'results'  => $results,
            'summary'  => $summary,
            'timeframe'=> $timeframe,
            'type'     => $type,
            'startsAt' => $startsAt,
            'endsAt'   => $endsAt,
        ];
    }

    public function index(Request $request)
    {
        $data = $this->getReportData($request);
        return view('reports.index', $data);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);
        $pdf  = Pdf::loadView('reports.financial_pdf', $data);
        return $pdf->stream('financial_statement_' . date('Y-m-d') . '.pdf');
    }
}
