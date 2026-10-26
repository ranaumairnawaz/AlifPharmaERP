<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\InventorySlip;
use App\Models\InventorySlipItem;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InventorySlipController extends Controller
{
    public function index()
    {
        $slips = InventorySlip::with('distributor')->latest()->get();
        return view('slips.index', compact('slips'));
    }

    public function show(InventorySlip $slip)
    {
        $slip->load(['distributor', 'items.product.brand', 'items.product.unit', 'invoices']);
        return view('slips.show', compact('slip'));
    }

    public function create()
    {
        $distributors = Distributor::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('material_type', 'finished_good')->with(['brand', 'unit'])->orderBy('name')->get();
        
        return view('slips.create', compact('distributors', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'transaction_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Pre-validation: Check all items for sufficient stock
        $errors = [];
        foreach ($request->items as $index => $itemData) {
            $product = Product::find($itemData['product_id']);
            if (!$product) continue;

            $requestedTotal = (int)$itemData['quantity'];

            if ($requestedTotal > $product->current_stock) {
                $errors[] = "Item #".($index + 1).": Insufficient stock for '{$product->name}'. Requested {$requestedTotal} units, but only {$product->current_stock} available.";
            }
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        return DB::transaction(function () use ($request) {
            $slip = InventorySlip::create([
                'slip_number' => InventorySlip::nextSlipNumber(),
                'distributor_id' => $request->distributor_id,
                'transaction_date' => $request->transaction_date,
                'notes' => $request->notes,
                'status' => 'completed',
            ]);

            foreach ($request->items as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                $quantity = (int)$itemData['quantity'];
                
                InventorySlipItem::create([
                    'inventory_slip_id' => $slip->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'number_of_cartons' => (int)($itemData['number_of_cartons'] ?? 0),
                ]);

                // Register Stock Movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $quantity,
                    'transaction_date' => $request->transaction_date,
                    'notes' => "Logistics Slip: {$slip->slip_number}",
                ]);

                // Update Product Stock
                $product->decrement('current_stock', $quantity);
            }

            return redirect()->route('slips.index')->with('success', "Inventory Slip {$slip->slip_number} created successfully.");
        });
    }

    public function generatePDF(InventorySlip $slip)
    {
        $slip->load(['distributor', 'items.product.brand', 'items.product.unit']);
        
        $pdf = Pdf::loadView('slips.pdf', compact('slip'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream("Inventory_Slip_{$slip->slip_number}.pdf");
    }

    public function edit(InventorySlip $slip)
    {
        if ($slip->is_net_invoiced || $slip->is_warranty_invoiced) {
            return back()->with('error', 'This slip has been partially or fully invoiced and is locked for modification.');
        }

        $slip->load('items.product');
        $distributors = Distributor::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('material_type', 'finished_good')->with(['brand', 'unit'])->orderBy('name')->get();

        return view('slips.edit', compact('slip', 'distributors', 'products'));
    }

    public function update(Request $request, InventorySlip $slip)
    {
        if ($slip->is_net_invoiced || $slip->is_warranty_invoiced) {
            return back()->with('error', 'This slip is locked due to active invoicing.');
        }

        $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'transaction_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($request, $slip) {
                // Restore previous stock
                foreach ($slip->items as $item) {
                    $item->product->increment('current_stock', $item->quantity);
                }

                // Update slip meta
                $slip->update($request->only('distributor_id', 'transaction_date', 'notes'));

                // Delete old items
                $slip->items()->delete();

                // Create new items and deduct stock
                foreach ($request->items as $itemData) {
                    $product = Product::findOrFail($itemData['product_id']);
                    $quantity = (int)$itemData['quantity'];
                    
                    if ($product->current_stock < $quantity) {
                        throw new \Exception("Insufficient stock for product: {$product->name}. Requested {$quantity}, but only {$product->current_stock} available.");
                    }

                    $slip->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'number_of_cartons' => (int)($itemData['number_of_cartons'] ?? 0),
                    ]);

                    $product->decrement('current_stock', $quantity);
                }

                return redirect()->route('slips.index')->with('success', "Slip {$slip->slip_number} updated and inventory synchronized.");
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(InventorySlip $slip)
    {
        if ($slip->is_net_invoiced || $slip->is_warranty_invoiced) {
            return back()->with('error', 'Invoiced records cannot be deleted.');
        }

        return DB::transaction(function () use ($slip) {
            foreach ($slip->items as $item) {
                $item->product->increment('current_stock', $item->quantity);
            }
            $slip->delete();
            return redirect()->route('slips.index')->with('success', 'Slip archived and inventory restored.');
        });
    }
}
