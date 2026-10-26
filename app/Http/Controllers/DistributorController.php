<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        $distributors = Distributor::latest()->get();
        return view('distributors.index', compact('distributors'));
    }

    public function create()
    {
        return view('distributors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'area' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        Distributor::create($request->all() + ['name' => $request->company_name]);

        return redirect()->route('distributors.index')->with('success', 'Distribution partner onboarded successfully.');
    }

    public function update(Request $request, Distributor $distributor)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'area' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $distributor->update($request->all() + ['name' => $request->company_name]);

        return redirect()->route('distributors.index')->with('success', 'Distributor profile updated.');
    }

    public function show(Distributor $distributor)
    {
        $distributor->load(['inventorySlips.invoices', 'inventorySlips.items.product']);

        // Flatten invoices into a collection
        $invoices = $distributor->inventorySlips->flatMap->invoices->where('type', '!=', 'warranty');

        $stats = [
            'total_dcs' => $distributor->inventorySlips->count(),
            'total_invoiced' => $invoices->where('type', 'net')->sum('grand_total'),
            'total_paid' => $invoices->where('type', 'net')->sum('paid_amount'),
        ];
        $stats['total_pending'] = $stats['total_invoiced'] - $stats['total_paid'];

        return view('distributors.show', compact('distributor', 'stats', 'invoices'));
    }

    public function edit(Distributor $distributor)
    {
        return view('distributors.edit', compact('distributor'));
    }


    public function pdf(Distributor $distributor)
    {
        $distributor->load(['inventorySlips.invoices', 'inventorySlips.items.product']);
        $invoices = $distributor->inventorySlips->flatMap->invoices->where('type', '!=', 'warranty');
        
        $stats = [
            'total_dcs' => $distributor->inventorySlips->count(),
            'total_invoiced' => $invoices->where('type', 'net')->sum('grand_total'),
            'total_paid' => $invoices->where('type', 'net')->sum('paid_amount'),
        ];
        $stats['total_pending'] = $stats['total_invoiced'] - $stats['total_paid'];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('distributors.pdf', compact('distributor', 'stats', 'invoices'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream("Distributor_Profile_{$distributor->id}.pdf");
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();
        return redirect()->route('distributors.index')->with('success', 'Distributor removed successfully.');
    }
}
