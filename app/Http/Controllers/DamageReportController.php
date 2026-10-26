<?php

namespace App\Http\Controllers;

use App\Models\DamageReport;
use App\Models\DamageReturnItem;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DamageReportController extends Controller
{
    public function index()
    {
        $reports = DamageReport::with(['product', 'batch', 'items.product'])->latest()->paginate(15);
        return view('damages.index', compact('reports'));
    }

    public function create()
    {
        // Only show finished goods for the Damaged Product selection
        $finishedGoods = Product::where('material_type', 'finished_good')->get();
        
        // Packaging materials for the Return selection
        $packagingMaterials = Product::where('material_type', 'packaging')->get();
        
        // Batches for the selected products
        $batches = ProductBatch::with('product')->where('current_quantity', '>', 0)->get();

        return view('damages.create', compact('finishedGoods', 'packagingMaterials', 'batches'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'product_id' => 'required|exists:products,id',
            'batch_id' => 'required|exists:product_batches,id',
            'quantity' => 'required|numeric|min:0.001',
            'reason' => 'nullable|string',
            'returns' => 'nullable|array',
            'returns.*.product_id' => 'required|exists:products,id',
            'returns.*.quantity' => 'required|numeric|min:0.001',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $batch = ProductBatch::findOrFail($request->batch_id);
                
                if ($request->quantity > $batch->current_quantity) {
                    throw new \Exception('Insufficient quantity in batch #' . $batch->batch_number . '. Available: ' . $batch->current_quantity);
                }

                // 1. Create the Damage Report
                $report = DamageReport::create([
                    'product_id' => $request->product_id,
                    'batch_id' => $request->batch_id,
                    'quantity' => $request->quantity,
                    'reason' => $request->reason,
                    'user_id' => auth()->id(),
                ]);

                // 2. Reduce Batch Stock
                $batch->decrement('current_quantity', $request->quantity);
                $batch->increment('discarded_quantity', $request->quantity);

                // 3. Log Stock Movement for the Damaged Product
                StockMovement::create([
                    'product_id' => $request->product_id,
                    'type' => 'out',
                    'quantity' => $request->quantity,
                    'notes' => 'Damaged/Discarded from Batch: ' . $batch->batch_number,
                    'transaction_date' => now(),
                ]);

                // 4. Update the Master Product Stock (Sync with batch current quantity usually)
                Product::where('id', $request->product_id)->decrement('current_stock', $request->quantity);

                // 5. Process Packaging Material Returns
                if ($request->has('returns')) {
                    foreach ($request->returns as $returnData) {
                        $material = Product::findOrFail($returnData['product_id']);
                        
                        // Increment Material Stock
                        $material->increment('current_stock', $returnData['quantity']);

                        // Create Detail Record
                        DamageReturnItem::create([
                            'damage_report_id' => $report->id,
                            'product_id' => $material->id,
                            'quantity_returned' => $returnData['quantity'],
                            'unit_cost' => $material->cost_price,
                        ]);

                        // Log Stock Movement for the Returned Material
                        StockMovement::create([
                            'product_id' => $material->id,
                            'type' => 'in',
                            'quantity' => $returnData['quantity'],
                            'notes' => 'Returned from Damaged Finished Good: ' . $report->product->name,
                            'transaction_date' => now(),
                        ]);
                    }
                }
            });

            return redirect()->route('damages.index')->with('success', 'Production Damage Report successfully filed and material costs reconciled.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
