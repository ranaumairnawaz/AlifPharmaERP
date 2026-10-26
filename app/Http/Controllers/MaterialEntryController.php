<?php

namespace App\Http\Controllers;

use App\Models\MaterialEntry;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MaterialEntryController extends Controller
{
    public function index()
    {
        $entries = MaterialEntry::with('stockMovements.product')->latest()->get();
        return view('materials.index', compact('entries'));
    }

    public function create()
    {
        $products = Product::whereIn('material_type', ['raw_material', 'packaging'])->orderBy('name')->get();
        return view('materials.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.price_per_unit' => 'required|numeric|min:0',
            'items.*.lot_number' => 'nullable|string|max:255',
            'items.*.expiry_date' => 'nullable|date',
        ]);

        return DB::transaction(function () use ($request) {
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += $item['quantity'] * $item['price_per_unit'];
            }

            $entry = MaterialEntry::create([
                'slip_number' => MaterialEntry::nextSlipNumber(),
                'source' => $request->source,
                'transaction_date' => $request->transaction_date,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);
                
                $movement = StockMovement::create([
                    'product_id' => $product->id,
                    'material_entry_id' => $entry->id,
                    'type' => 'in',
                    'quantity' => $itemData['quantity'],
                    'price_per_unit' => $itemData['price_per_unit'],
                    'lot_number' => $itemData['lot_number'],
                    'expiry_date' => $itemData['expiry_date'] ?? null,
                    'transaction_date' => $request->transaction_date,
                    'notes' => "Received from source: {$entry->source}. Internal Ref/Lot: " . ($itemData['lot_number'] ?? 'N/A'),
                ]);

                $product->current_stock += $itemData['quantity'];
                $product->save();
            }

            return redirect()->route('materials.index')->with('success', 'Material entry recorded successfully. Awaiting payment settlement.');
        });
    }

    public function show(MaterialEntry $entry)
    {
        $entry->load('stockMovements.product.unit');
        return view('materials.show', compact('entry'));
    }

    public function pdf(MaterialEntry $entry)
    {
        $entry->load('stockMovements.product.unit');
        $pdf = Pdf::loadView('materials.pdf', compact('entry'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream("MaterialEntry_{$entry->slip_number}.pdf");
    }

    public function updateStatus(Request $request, MaterialEntry $entry)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,partial,paid',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:100',
        ]);

        $previousStatus = $entry->payment_status;
        $previousPaidAmount = $entry->paid_amount ?? 0;

        $newPaidAmount = $request->paid_amount ?? 0;
        if ($request->payment_status === 'paid') {
            $newPaidAmount = $entry->total_amount;
        } elseif ($request->payment_status === 'pending') {
            $newPaidAmount = 0;
        }

        $entry->update([
            'payment_status' => $request->payment_status,
            'paid_amount' => $newPaidAmount,
        ]);

        // Calculate money actually paid right now
        $delta = $newPaidAmount - $previousPaidAmount;

        if ($delta > 0) {
            $source = $entry->source ?? 'Vendor';
            $isFinalPayment = ($request->payment_status === 'paid' && $previousStatus === 'partial');
            
            $descPrefix = $isFinalPayment 
                ? "Final remaining payment of Rs.{$delta} logged for Material Slip {$entry->slip_number}."
                : ($request->payment_status === 'partial' ? "Partial payment of Rs.{$delta} on Material Slip {$entry->slip_number}." : "Material Slip {$entry->slip_number} paid in full.");

            Expense::create([
                'amount' => $delta,
                'category' => 'Material Procurement',
                'ref_type' => 'MaterialEntry',
                'ref_id' => $entry->id,
                'description' => "Auto-logged: {$descPrefix} (Source: {$source})",
                'expense_date' => now()->toDateString(),
                'status' => 'paid',
                'payment_method' => $request->payment_method ?? 'cash',
            ]);
        }

        return back()->with('success', 'Payment status and accounts updated successfully.');
    }
}
