<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{
    public function index()
    {
        $batches = ProductBatch::with('product.brand')->latest()->get();
        return view('batches.index', compact('batches'));
    }

    public function expiring()
    {
        $batches = ProductBatch::with('product.brand')
            ->where('status', 'active')
            ->where('current_quantity', '>', 0)
            ->whereBetween('expiry_date', [now(), now()->addMonths(6)])
            ->orderBy('expiry_date')
            ->get();

        $materials = StockMovement::with('product.brand')
            ->where('type', 'in')
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [now(), now()->addMonths(6)])
            ->orderBy('expiry_date')
            ->get();

        return view('batches.expiring', compact('batches', 'materials'));
    }

    public function create()
    {
        $products = Product::where('material_type', 'finished_good')->with('brand')->orderBy('name')->get();
        return view('batches.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'batch_number' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'expiry_date' => 'required|date|after:today',
            'mfg_date' => 'nullable|date|before_or_equal:today',
        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            $batch = ProductBatch::create([
                'product_id' => $product->id,
                'batch_number' => $request->batch_number,
                'initial_quantity' => $request->quantity,
                'current_quantity' => $request->quantity,
                'mfg_date' => $request->mfg_date,
                'expiry_date' => $request->expiry_date,
            ]);

            // Track the movement
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $request->quantity,
                'transaction_date' => now(),
                'notes' => "Production Entry: Batch #{$request->batch_number}",
            ]);

        // Increment the product's master stock
        $product->increment('current_stock', $request->quantity);

        return redirect()->route('batches.index')->with('success', "Batch #{$batch->batch_number} for {$product->name} added successfully.");
    });
}

public function reject(Request $request, ProductBatch $batch)
{
    $request->validate([
        'rejected_quantity' => 'required|numeric|min:1|max:' . $batch->current_quantity,
        'reason' => 'nullable|string|max:255'
    ]);

    DB::transaction(function () use ($request, $batch) {
        $batch->decrement('current_quantity', $request->rejected_quantity);
        $batch->increment('rejected_quantity', $request->rejected_quantity);
        
        // Track the movement as 'out' from available stock
        StockMovement::create([
            'product_id' => $batch->product_id,
            'type' => 'out',
            'quantity' => $request->rejected_quantity,
            'notes' => "Quarantined/Rejected from Batch #{$batch->batch_number}. Reason: " . ($request->reason ?? 'Quality Control Rejection'),
            'transaction_date' => now(),
        ]);

        // Sync master stock
        $batch->product->decrement('current_stock', $request->rejected_quantity);
    });

    return redirect()->route('batches.index')->with('success', "{$request->rejected_quantity} units placed in quarantine from Batch #{$batch->batch_number}.");
}
}
