<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Invoice;
use App\Models\InventorySlip;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        if (!$q || strlen($q) < 2)
            return response()->json([]);

        $results = [];

        // 1. Search Products (Catalog)
        $products = Product::where('id', $q)
            ->orWhere('name', 'LIKE', '%' . $q . '%')
            ->take(5)
            ->get(['id', 'name', 'sale_price']);

        if ($products->count() > 0) {
            $results['Pharmaceutical Catalog'] = $products->map(function ($p) {
                return [
                    'title' => $p->name,
                    'meta' => 'Rs.' . number_format($p->sale_price, 0),
                    'url' => route('products.show', $p->id),
                    'icon' => 'package'
                ];
            });
        }

        // 2. Search Invoices (Finance)
        $invoices = Invoice::where('invoice_number', 'LIKE', '%' . $q . '%')
            ->take(5)
            ->get(['id', 'invoice_number', 'grand_total', 'type']);

        if ($invoices->count() > 0) {
            $results['Financial Records'] = $invoices->map(function ($i) {
                return [
                    'title' => $i->invoice_number,
                    'meta' => strtoupper($i->type) . ' • Rs.' . number_format($i->grand_total, 0),
                    'url' => route('invoices.show', $i->id),
                    'icon' => 'file-text'
                ];
            });
        }

        // 3. Search Delivery Chalans (Logistics)
        $slips = InventorySlip::where('slip_number', 'LIKE', '%' . $q . '%')
            ->take(5)
            ->get(['id', 'slip_number', 'transaction_date']);

        if ($slips->count() > 0) {
            $results['Logistics (DC)'] = $slips->map(function ($s) {
                return [
                    'title' => $s->slip_number,
                    'meta' => \Carbon\Carbon::parse($s->transaction_date)->format('d M, Y'),
                    'url' => route('slips.show', $s->id),
                    'icon' => 'truck'
                ];
            });
        }

        // 4. Search Employees (HR)
        $employees = Employee::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('employee_id', 'LIKE', '%' . $q . '%')
            ->take(5)
            ->get(['id', 'name', 'employee_id', 'designation']);

        if ($employees->count() > 0) {
            $results['Personnel & HR'] = $employees->map(function ($e) {
                return [
                    'title' => $e->name,
                    'meta' => $e->employee_id . ' • ' . $e->designation,
                    'url' => route('employees.show', $e->id),
                    'icon' => 'users'
                ];
            });
        }

        // 5. Search App Features (Navigation)
        $features = $this->getFeatureLinks($q);
        if (count($features) > 0) {
            $results['Navigation & Tools'] = $features;
        }

        return response()->json($results);
    }

    private function getFeatureLinks($q)
    {
        $links = [
            ['title' => 'Executive Dashboard', 'url' => route('dashboard.index'), 'icon' => 'layout', 'tags' => 'home stats analytics overview'],
            ['title' => 'Finished Goods Hub', 'url' => route('products.finished'), 'icon' => 'package', 'tags' => 'inventory stock medical medicine items'],
            ['title' => 'Raw Materials Registry', 'url' => route('products.raw'), 'icon' => 'droplet', 'tags' => 'ingredients chemistry bulk'],
            ['title' => 'Packaging Materials Hub', 'url' => route('products.packaging'), 'icon' => 'box', 'tags' => 'boxes foils labels'],
            ['title' => 'Invoice Registry', 'url' => route('invoices.index'), 'icon' => 'file-text', 'tags' => 'billing payments finance sales receipts'],
            ['title' => 'Damage & Loss Hub', 'url' => route('damages.index'), 'icon' => 'alert-triangle', 'tags' => 'rejected broken expired losses'],
            ['title' => 'Production Batches', 'url' => route('batches.index'), 'icon' => 'layers', 'tags' => 'manufacturing lots series'],
            ['title' => 'Financial Reports', 'url' => route('reports.index'), 'icon' => 'bar-chart', 'tags' => 'ledger revenue profit receivables'],
            ['title' => 'System Settings', 'url' => route('settings.index'), 'icon' => 'settings', 'tags' => 'config branding setup labels'],
            ['title' => 'Staff Directory', 'url' => route('employees.index'), 'icon' => 'users', 'tags' => 'employees hr workers hiring payroll'],
            ['title' => 'Activity Audit Ledger', 'url' => route('activities.index'), 'icon' => 'clock', 'tags' => 'logs monitoring security tracking'],
            ['title' => 'Access Matrix (Roles)', 'url' => route('roles.index'), 'icon' => 'shield', 'tags' => 'permissions security rbac users'],
        ];

        return array_values(array_filter($links, function ($link) use ($q) {
            return Str::contains(strtolower($link['title']), strtolower($q)) ||
                Str::contains(strtolower($link['tags']), strtolower($q));
        }));
    }
}
