@extends('layouts.print')

@section('title', 'Product Asset Audit Report')

@section('content')
<div class="section-title">I. Core Asset Identity</div>
<table>
    <tr>
        <td width="30%" class="font-bold">Product Name</td>
        <td>{{ $product->name }}</td>
    </tr>
    <tr>
        <td class="font-bold">Classification</td>
        <td>
            @if($product->material_type === 'raw_material') Raw Material (RM)
            @elseif($product->material_type === 'packaging') Packaging Material (PM)
            @else Finished Good (FG) @endif
        </td>
    </tr>
    <tr>
        <td class="font-bold">Brand / Category</td>
        <td>{{ $product->brand->name ?? 'Generic' }} / {{ $product->category->name ?? 'Unlinked' }}</td>
    </tr>
    <tr>
        <td class="font-bold">Metrics</td>
        <td>1 Unit = {{ $product->unit->name }} ({{ $product->unit->short_name }})</td>
    </tr>
    <tr>
        <td class="font-bold">Description</td>
        <td>{{ $product->description ?: 'No additional metadata provided.' }}</td>
    </tr>
</table>

<div class="section-title">II. Inventory Status & Valuation</div>
<div class="financial-summary clearfix">
    <div style="float: left; width: 33%;">
        <div style="font-size: 8px; color: #64748b; text-transform: uppercase;">Current Stock</div>
        <div style="font-size: 18px; font-weight: 900;">{{ number_format($product->current_stock, 2) }} <small style="font-size: 10px;">{{ $product->unit->short_name }}</small></div>
    </div>
    <div style="float: left; width: 33%;">
        <div style="font-size: 8px; color: #64748b; text-transform: uppercase;">Unit Cost</div>
        <div style="font-size: 18px; font-weight: 900;">Rs. {{ number_format($product->cost_price, 2) }}</div>
    </div>
    <div style="float: left; width: 34%;">
        <div style="font-size: 8px; color: #64748b; text-transform: uppercase;">Total Valuation</div>
        <div style="font-size: 18px; font-weight: 900; color: #0d9488;">Rs. {{ number_format($valuation, 2) }}</div>
    </div>
</div>

<div class="section-title">III. Historical Stock Movements</div>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th class="text-right">Quantity</th>
            <th>Reference/Note</th>
            <th class="text-right">Resulting Stock</th>
        </tr>
    </thead>
    <tbody>
        @php $runningStock = $product->current_stock; @endphp
        @forelse($product->stockMovements as $movement)
            <tr>
                <td class="font-mono">{{ $movement->transaction_date->format('Y-m-d H:i') }}</td>
                <td>
                    <span class="badge {{ $movement->type === 'in' ? 'badge-in' : 'badge-out' }}">
                        {{ strtoupper($movement->type) }}
                    </span>
                </td>
                <td class="text-right font-bold">{{ number_format($movement->quantity, 2) }}</td>
                <td>{{ $movement->reference_number ?: '---' }} <br> <small style="color: #94a3b8;">{{ $movement->note }}</small></td>
                <td class="text-right font-mono">{{ number_format($runningStock, 2) }}</td>
            </tr>
            @php 
                if($movement->type === 'in') $runningStock -= $movement->quantity;
                else $runningStock += $movement->quantity;
            @endphp
        @empty
            <tr>
                <td colspan="5" class="text-center italic" style="padding: 40px;">No transaction history found for this asset.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top: 50px; font-size: 9px; color: #64748b; text-align: center;">
    *** End of Official Asset Audit Record ***
</div>
@endsection
