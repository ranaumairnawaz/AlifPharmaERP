<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\StockMovement;
use App\Models\Invoice;
use App\Models\DamageReport;
use App\Models\MaterialEntry;
use App\Models\SalaryPayment;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            if (auth()->user()->hasModuleAction('products', 'read')) {
                return redirect()->route('products.finished');
            } elseif (auth()->user()->hasModuleAction('invoices', 'read')) {
                return redirect()->route('invoices.index');
            }
        }
        // 1. Core KPIs
        $totalProducts = Product::count();

        // Total Valuation (Cost x Stock)
        $totalValuation = Product::selectRaw('SUM(current_stock * cost_price) as total')->value('total') ?? 0;

        // Potential Revenue (Sale x Stock)
        $potentialRevenue = Product::selectRaw('SUM(current_stock * sale_price) as total')->value('total') ?? 0;

        // Low Stock Count
        $lowStockCount = Product::whereColumn('current_stock', '<=', 'reorder_point')->count();

        // 2. Monthly Velocity (In vs Out)
        $startOfMonth = Carbon::now()->startOfMonth();
        $monthlyIn = StockMovement::where('type', 'in')
            ->where('transaction_date', '>=', $startOfMonth)
            ->sum('quantity');

        $monthlyOut = StockMovement::where('type', 'out')
            ->where('transaction_date', '>=', $startOfMonth)
            ->sum('quantity');

        // 3. Expiry Alerts (Expiring in 30 days)
        $expiringCount = Product::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', Carbon::now()->addDays(30))
            ->where('expiry_date', '>=', Carbon::now())
            ->count();

        $expiredCount = Product::whereNotNull('expiry_date')
            ->where('expiry_date', '<', Carbon::now())
            ->count();

        // 4. Category Distribution (Chart Data)
        $categoryData = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(*) as count'))
            ->groupBy('categories.name')
            ->get();

        // 5. Recent Movements
        $recentMovements = StockMovement::with('product')
            ->orderBy('transaction_date', 'desc')
            ->limit(8)
            ->get();

        $expiringBatches = ProductBatch::with('product.brand')
            ->where('status', 'active')
            ->where('current_quantity', '>', 0)
            ->whereBetween('expiry_date', [now(), now()->addMonths(6)])
            ->orderBy('expiry_date')
            ->get();

        $expiringMaterials = StockMovement::with('product.brand')
            ->where('type', 'in')
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [now(), now()->addMonths(6)])
            ->orderBy('expiry_date')
            ->get();

        // 6. AD-HOC Analytics: Financial Exposure
        $totalOutstanding = Invoice::where('payment_status', '!=', 'paid')
            ->selectRaw('SUM(grand_total - paid_amount) as total')
            ->value('total') ?? 0;

        // 7. AD-HOC Analytics: Operational Loss
        $totalLoss = DamageReport::join('products', 'damage_reports.product_id', '=', 'products.id')
            ->selectRaw('SUM(damage_reports.quantity * products.cost_price) as total')
            ->value('total') ?? 0;

        // 8. Top Performing Groups (Last 30 Days)
        $topGroups = StockMovement::join('products', 'stock_movements.product_id', '=', 'products.id')
            ->join('groups', 'products.group_id', '=', 'groups.id')
            ->where('stock_movements.type', 'out')
            ->where('stock_movements.transaction_date', '>=', Carbon::now()->subDays(30))
            ->select('groups.name', DB::raw('SUM(stock_movements.quantity) as total_out'))
            ->groupBy('groups.name')
            ->orderBy('total_out', 'desc')
            ->limit(5)
            ->get();

        // 9. NEW: Outstanding Payables (Material Debt)
        $totalPayables = MaterialEntry::where('payment_status', '!=', 'paid')
            ->get()
            ->sum(fn($m) => $m->remainingBalance());

        // 10. Fiscal Trend Analysis (Last 6 Months)
        $fiscalTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $fiscalTrend[$monthKey] = [
                'month' => $date->format('M'),
                'revenue' => 0,
                'expenditure' => 0
            ];
        }

        // Aggregate Revenue (Invoices + Income)
        $invoiceRevenue = Invoice::select(
            DB::raw('strftime("%Y-%m", created_at) as month_key'),
            DB::raw('SUM(grand_total) as amount')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month_key')
            ->get();

        $manualIncome = Income::select(
            DB::raw('strftime("%Y-%m", income_date) as month_key'),
            DB::raw('SUM(amount) as amount')
        )
            ->where('income_date', '>=', Carbon::now()->subMonths(5)->startOfMonth()->toDateString())
            ->groupBy('month_key')
            ->get();

        // Aggregate Expenditure (Material Entries + manual Expenses + Salary Payments)
        $materialExpenditure = MaterialEntry::select(
            DB::raw('strftime("%Y-%m", transaction_date) as month_key'),
            DB::raw('SUM(total_amount) as amount')
        )
            ->where('transaction_date', '>=', Carbon::now()->subMonths(5)->startOfMonth()->toDateString())
            ->groupBy('month_key')
            ->get();

        $manualExpenses = Expense::select(
            DB::raw('strftime("%Y-%m", expense_date) as month_key'),
            DB::raw('SUM(amount) as amount')
        )
            ->where('expense_date', '>=', Carbon::now()->subMonths(5)->startOfMonth()->toDateString())
            ->groupBy('month_key')
            ->get();

        $salaryExpenditure = SalaryPayment::select(
            DB::raw('strftime("%Y-%m", paid_at) as month_key'),
            DB::raw('SUM(net_salary) as amount')
        )
            ->where('paid_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->where('status', 'paid')
            ->groupBy('month_key')
            ->get();

        // Merge into Fiscal Trend
        foreach ($invoiceRevenue as $r) { if (isset($fiscalTrend[$r->month_key])) $fiscalTrend[$r->month_key]['revenue'] += $r->amount; }
        foreach ($manualIncome as $r) { if (isset($fiscalTrend[$r->month_key])) $fiscalTrend[$r->month_key]['revenue'] += $r->amount; }
        foreach ($materialExpenditure as $r) { if (isset($fiscalTrend[$r->month_key])) $fiscalTrend[$r->month_key]['expenditure'] += $r->amount; }
        foreach ($manualExpenses as $r) { if (isset($fiscalTrend[$r->month_key])) $fiscalTrend[$r->month_key]['expenditure'] += $r->amount; }
        foreach ($salaryExpenditure as $r) { if (isset($fiscalTrend[$r->month_key])) $fiscalTrend[$r->month_key]['expenditure'] += $r->amount; }

        $fiscalTrendData = collect(array_values($fiscalTrend));

        return view('dashboard.index', compact(
            'totalProducts',
            'totalValuation',
            'potentialRevenue',
            'lowStockCount',
            'monthlyIn',
            'monthlyOut',
            'expiringCount',
            'expiredCount',
            'categoryData',
            'recentMovements',
            'expiringBatches',
            'expiringMaterials',
            'totalOutstanding',
            'totalPayables',
            'totalLoss',
            'topGroups',
            'fiscalTrendData'
        ));
    }
}
