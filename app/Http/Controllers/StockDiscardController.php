<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\StockDiscard;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockDiscardController extends Controller
{
    public function index()
    {
        $discards = StockDiscard::with(['product', 'batch', 'user'])->latest()->get();
        return view('discards.index', compact('discards'));
    }

    public function create()
    {
        $products = Product::with('unit')->get();
        return view('discards.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'batch_id' => 'nullable|exists:product_batches,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:damaged_packaging,rejected_finished_good',
            'reason' => 'required|string|max:500',
        ]);

        return DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            // Validation: check if enough stock
            if ($product->current_stock < $request->quantity) {
                return back()->withErrors(['quantity' => "Insufficient stock to discard. Current: {$product->current_stock}"])->withInput();
            }

            $discard = StockDiscard::create([
                'product_id' => $product->id,
                'batch_id' => $request->batch_id,
                'quantity' => $request->quantity,
                'type' => $request->type,
                'reason' => $request->reason,
                'user_id' => Auth::id(),
            ]);

            // Deduct from master stock
            $product->decrement('current_stock', $request->quantity);

            // If batch is selected, deduct from batch as well
            if ($request->batch_id) {
                $batch = ProductBatch::findOrFail($request->batch_id);
                $batch->decrement('current_quantity', $request->quantity);
            }

            // Record Movement
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => $request->quantity,
                'transaction_date' => now(),
                'notes' => "Stock Discard ({$request->type}): {$request->reason}",
            ]);

            return redirect()->route('discards.index')->with('success', 'Stock discard logged and deducted from inventory.');
        });
    }
}
