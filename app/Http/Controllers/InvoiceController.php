<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InventorySlip;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $pendingSlips = InventorySlip::where('is_net_invoiced', false)
            ->with('distributor')
            ->latest()
            ->get();

        $invoices = Invoice::with(['slip.distributor', 'creator', 'projectManager'])->latest()->get();

        return view('invoices.index', compact('pendingSlips', 'invoices'));
    }

    public function create(Request $request)
    {
        $slipId = $request->query('slip');
        $slip = InventorySlip::with([
            'distributor',
            'items.product.brand',
            'items.product.unit',
            'items.product.batches' => function ($q) {
                $q->where('current_quantity', '>', 0)->where('status', 'active');
            }
        ])->findOrFail($slipId);

        if ($slip->is_net_invoiced) {
            return redirect()->route('invoices.index')->with('error', 'This DC has already been fully invoiced.');
        }

        $projectManagers = \App\Models\ProjectManager::where('status', 'active')->get();

        return view('invoices.create', compact('slip', 'projectManagers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_slip_id' => 'required|exists:inventory_slips,id',
            'project_manager_id' => 'required|exists:project_managers,id',
            'due_date' => 'nullable|date',
            'adjustment_amount' => 'nullable|numeric',
            'items' => 'required|array',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.product_batch_id' => 'required|exists:product_batches,id',
            'items.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $slip = InventorySlip::findOrFail($request->inventory_slip_id);

        if ($slip->is_net_invoiced) {
            return back()->with('error', 'This DC has already been invoiced.');
        }

        return DB::transaction(function () use ($request, $slip) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($slip->items as $item) {
                $product = $item->product;
                $inputItem = $request->items[$product->id];
                $unitPrice = (float) $inputItem['unit_price'];
                $discountPercent = (float) ($inputItem['discount_percentage'] ?? 0);

                $grossAmount = $unitPrice * $item->quantity;
                $discountValue = $grossAmount * ($discountPercent / 100);
                $netAmount = $grossAmount - $discountValue;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'product_batch_id' => $inputItem['product_batch_id'],
                    'quantity' => $item->quantity,
                    'unit_price' => $unitPrice,
                    'gross_amount' => $grossAmount,
                    'discount_percentage' => $discountPercent,
                    'discount_value' => $discountValue,
                    'total_price' => $netAmount,
                ];

                $batch = \App\Models\ProductBatch::find($inputItem['product_batch_id']);
                if ($batch) {
                    $batch->decrement('current_quantity', $item->quantity);
                }

                $subtotal += $netAmount;
            }

            $adjustment = (float) ($request->adjustment_amount ?? 0);
            $grandTotal = $subtotal + $adjustment;

            $invoice = Invoice::create([
                'invoice_number' => Invoice::nextInvoiceNumber(),
                'inventory_slip_id' => $slip->id,
                'project_manager_id' => $request->project_manager_id,
                'type' => 'net', // Always Net initially
                'due_date' => $request->due_date,
                'subtotal_mrp' => 0, // Not used in Net
                'discount_percentage' => 0, // Now handled per item
                'discount_amount' => collect($itemsData)->sum('discount_value'),
                'adjustment_amount' => $adjustment,
                'grand_total' => $grandTotal,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);

            foreach ($itemsData as $item) {
                $invoice->items()->create($item);
            }

            $slip->update(['is_net_invoiced' => true]);

            return redirect()->route('invoices.index')->with('success', "Net Invoice #{$invoice->invoice_number} generated successfully.");
        });
    }

    private function generateSingleInvoice($request, $slip, $type)
    {
        // This is now legacy/unused but kept for internal reference or kept as private if needed.
        // We will implement special warranty generation logic elsewhere.
        return null;
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['slip.distributor', 'items.product.unit', 'creator', 'projectManager']);
        return view('invoices.show', compact('invoice'));
    }

    public function pdf(Invoice $invoice)
    {
        $invoice->load(['slip.distributor', 'items.product.unit', 'creator', 'projectManager']);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("Invoice_{$invoice->invoice_number}.pdf");
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,partial,paid',
            'paid_amount' => 'nullable|numeric|min:0',
        ]);

        $previousStatus = $invoice->payment_status;
        $previousPaidAmount = $invoice->paid_amount ?? 0;

        $newPaidAmount = $request->paid_amount ?? 0;
        if ($request->payment_status === 'paid') {
            $newPaidAmount = $invoice->grand_total;
        } elseif ($request->payment_status === 'pending') {
            $newPaidAmount = 0;
        }

        $invoice->update([
            'payment_status' => $request->payment_status,
            'paid_amount' => $newPaidAmount,
        ]);

        // Calculate money actually received right now
        $delta = $newPaidAmount - $previousPaidAmount;

        if ($delta > 0) {
            $distributor = $invoice->slip->distributor->name ?? 'Unknown';

            $isFinalPayment = ($request->payment_status === 'paid' && $previousStatus === 'partial');
            $titlePrefix = $isFinalPayment ? "Final payment" : ($request->payment_status === 'partial' ? "Partial payment" : "Payment received");
            $descPrefix = $isFinalPayment ? "Final remaining payment of Rs.{$delta} logged for Invoice {$invoice->invoice_number}."
                : ($request->payment_status === 'partial' ? "Partial payment of Rs.{$delta} on Invoice {$invoice->invoice_number}." : "Invoice {$invoice->invoice_number} marked as paid.");

            Income::create([
                'title' => "{$titlePrefix} — {$invoice->invoice_number} ({$distributor})",
                'category' => 'invoice_payment',
                'amount' => $delta,
                'ref_type' => 'Invoice',
                'ref_id' => $invoice->id,
                'description' => "Auto-logged: {$descPrefix}",
                'income_date' => now()->toDateString(),
                'status' => 'received',
            ]);
        }

        return back()->with('success', 'Payment status updated successfully.');
    }

    public function generateWarranty(Request $request, Invoice $invoice)
    {
        $request->validate([
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($invoice->type !== 'net') {
            return back()->with('error', 'Warranty can only be generated from a Net invoice.');
        }

        $slip = $invoice->slip;
        if ($slip->is_warranty_invoiced) {
            return back()->with('error', 'Warranty invoice already generated for this DC.');
        }

        return DB::transaction(function () use ($request, $invoice, $slip) {
            $discountPercent = (float) $request->discount_percentage;
            $subtotalMRP = 0;
            $itemsData = [];

            foreach ($invoice->items as $item) {
                $product = $item->product;
                $basePrice = $product->mrp > 0 ? $product->mrp : $product->sale_price;
                $unitPrice = $basePrice * (1 - ($discountPercent / 100));
                $rowTotal = $unitPrice * $item->quantity;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'product_batch_id' => $item->product_batch_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $rowTotal,
                ];

                $subtotalMRP += ($basePrice * $item->quantity);
            }

            $discountAmount = $subtotalMRP * ($discountPercent / 100);
            $grandTotal = $subtotalMRP - $discountAmount;

            $warrantyInvoice = Invoice::create([
                'invoice_number' => Invoice::nextInvoiceNumber(),
                'inventory_slip_id' => $slip->id,
                'project_manager_id' => $invoice->project_manager_id,
                'type' => 'warranty',
                'due_date' => $invoice->due_date,
                'subtotal_mrp' => $subtotalMRP,
                'discount_percentage' => $discountPercent,
                'discount_amount' => $discountAmount,
                'adjustment_amount' => 0,
                'grand_total' => $grandTotal,
                'notes' => "Auto-generated Warranty Slip for Net Invoice #{$invoice->invoice_number}",
                'created_by' => auth()->id(),
            ]);

            foreach ($itemsData as $item) {
                $warrantyInvoice->items()->create($item);
            }

            $slip->update(['is_warranty_invoiced' => true]);

            return redirect()->route('invoices.index')->with('success', "Warranty Invoice #{$warrantyInvoice->invoice_number} generated successfully.");
        });
    }
}
