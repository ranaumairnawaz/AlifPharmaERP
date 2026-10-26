<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StockAuditController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');
        $query = Product::with(['brand', 'category', 'unit']);
        
        if ($type !== 'all') {
            $query->where('material_type', $type);
        }
        
        $products = $query->get();

        // Segment data by material type
        $rawMaterials = $products->where('material_type', 'raw_material');
        $packagingMaterials = $products->where('material_type', 'packaging');
        $finishedGoods = $products->where('material_type', 'finished_good');

        // Calculate Apportioned Valuations
        $summary = [
            'raw' => [
                'count' => $rawMaterials->count(),
                'total_stock' => $rawMaterials->sum('current_stock'),
                'valuation' => $rawMaterials->sum(fn($p) => $p->current_stock * $p->cost_price),
            ],
            'packaging' => [
                'count' => $packagingMaterials->count(),
                'total_stock' => $packagingMaterials->sum('current_stock'),
                'valuation' => $packagingMaterials->sum(fn($p) => $p->current_stock * $p->cost_price),
            ],
            'finished' => [
                'count' => $finishedGoods->count(),
                'total_stock' => $finishedGoods->sum('current_stock'),
                'valuation' => $finishedGoods->sum(fn($p) => $p->current_stock * $p->cost_price),
            ],
            'total_valuation' => $products->sum(fn($p) => $p->current_stock * $p->cost_price)
        ];

        return view('reports.audit', compact('rawMaterials', 'packagingMaterials', 'finishedGoods', 'summary', 'type'));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'all');
        $query = Product::with(['brand', 'category', 'unit']);
        
        if ($type !== 'all') {
            $query->where('material_type', $type);
        }
        
        $products = $query->get();

        $rawMaterials = $products->where('material_type', 'raw_material');
        $packagingMaterials = $products->where('material_type', 'packaging');
        $finishedGoods = $products->where('material_type', 'finished_good');

        $summary = [
            'raw' => [
                'valuation' => $rawMaterials->sum(fn($p) => $p->current_stock * $p->cost_price),
                'count' => $rawMaterials->count(),
            ],
            'packaging' => [
                'valuation' => $packagingMaterials->sum(fn($p) => $p->current_stock * $p->cost_price),
                'count' => $packagingMaterials->count(),
            ],
            'finished' => [
                'valuation' => $finishedGoods->sum(fn($p) => $p->current_stock * $p->cost_price),
                'count' => $finishedGoods->count(),
            ],
            'total_valuation' => $products->sum(fn($p) => $p->current_stock * $p->cost_price)
        ];

        $pdf = Pdf::loadView('reports.audit_pdf', compact('rawMaterials', 'packagingMaterials', 'finishedGoods', 'summary', 'type'))
                  ->setPaper('a4', 'landscape');
        
        return $pdf->stream("warehouse_audit_" . date('Y-m-d') . ".pdf");
    }
}
