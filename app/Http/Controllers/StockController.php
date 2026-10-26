<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('product')->latest('transaction_date')->get();
        return view('stock.index', compact('movements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.001',
            'lot_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($validated) {
            $movement = StockMovement::create([
                ...$validated,
                'transaction_date' => now()
            ]);

            $product = Product::findOrFail($validated['product_id']);

            if ($validated['type'] === 'in') {
                $product->current_stock += $validated['quantity'];
            } else {
                $product->current_stock -= $validated['quantity'];
            }

            $product->save();
        });

        return back()->with('success', 'Stock movement recorded successfully.');
    }

    /**
     * API: Search Raw & Packaging materials by name or ID.
     */
    public function searchMaterials(Request $request)
    {
        $q = trim($request->get('q', ''));
        if (strlen($q) < 1) {
            return response()->json([]);
        }

        $products = Product::whereIn('material_type', ['raw_material', 'packaging'])
            ->where(function ($query) use ($q) {
                $query->where('id', $q)
                    ->orWhere('name', 'LIKE', '%' . $q . '%');
            })
            ->orderBy('id')
            ->limit(10)
            ->get(['id', 'name', 'current_stock']);

        return response()->json($products->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'label' => '#' . $p->id . ' — ' . $p->name,
            'current_stock' => (float) $p->current_stock,
        ]));
    }

    /**
     * API: Get lot numbers for a product with per-lot remaining stock.
     * Calculates: sum of 'in' movements - sum of 'out' movements for each lot_number.
     */
    public function getProductLots(Request $request, $productId)
    {
        // Get all distinct lots that ever had 'in' movements for this product
        $lots = StockMovement::where('product_id', $productId)
            ->where('type', 'in')
            ->whereNotNull('lot_number')
            ->where('lot_number', '!=', '')
            ->distinct()
            ->pluck('lot_number');

        if ($lots->isEmpty()) {
            return response()->json([]);
        }

        $result = [];
        foreach ($lots as $lot) {
            $inQty = StockMovement::where('product_id', $productId)
                ->where('lot_number', $lot)
                ->where('type', 'in')
                ->sum('quantity');

            $outQty = StockMovement::where('product_id', $productId)
                ->where('lot_number', $lot)
                ->where('type', 'out')
                ->sum('quantity');

            $remaining = round((float) $inQty - (float) $outQty, 3);

            $result[] = [
                'lot_number' => $lot,
                'remaining' => $remaining,
                'label' => $lot . ' (Stock: ' . number_format($remaining, 3) . ')',
            ];
        }

        // Sort by lot number descending (most recent first)
        usort($result, fn($a, $b) => strcmp($b['lot_number'], $a['lot_number']));

        return response()->json($result);
    }
}
