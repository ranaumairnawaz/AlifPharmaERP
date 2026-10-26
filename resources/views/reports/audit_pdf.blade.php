@extends('layouts.print')

@section('title', 'Warehouse Inventory Audit Statement')

@section('content')
<style>
    .segment-header {
        background-color: #f8fafc;
        padding: 8px 15px;
        border-radius: 6px;
        margin-bottom: 5px;
        font-weight: 900;
        font-size: 10px;
        border-left: 4px solid #0d9488;
    }
    .grid-container {
        width: 100%;
        margin-bottom: 20px;
    }
    .grid-column {
        width: 32%;
        display: inline-block;
        vertical-align: top;
        margin-right: 1%;
    }
    .val-box {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px;
        background-color: #ffffff;
    }
    .val-label { font-size: 8px; text-transform: uppercase; color: #64748b; font-weight: bold; }
    .val-value { font-size: 14px; font-weight: 900; color: #1e293b; margin: 2px 0; }
    .val-meta { font-size: 8px; color: #94a3b8; }
</style>

<!-- Top Summary Grid -->
<div class="grid-container clearfix">
    @if($type === 'all' || $type === 'raw_material')
    <div class="grid-column">
        <div class="val-box" style="border-top: 3px solid #0d9488;">
            <div class="val-label">Raw Materials</div>
            <div class="val-value">Rs. {{ number_format($summary['raw']['valuation'], 2) }}</div>
            <div class="val-meta">{{ $summary['raw']['count'] }} Assets Identified</div>
        </div>
    </div>
    @endif
    
    @if($type === 'all' || $type === 'packaging')
    <div class="grid-column">
        <div class="val-box" style="border-top: 3px solid #6366f1;">
            <div class="val-label">Packaging Materials</div>
            <div class="val-value">Rs. {{ number_format($summary['packaging']['valuation'], 2) }}</div>
            <div class="val-meta">{{ $summary['packaging']['count'] }} Assets Identified</div>
        </div>
    </div>
    @endif
    
    @if($type === 'all' || $type === 'finished_good')
    <div class="grid-column" style="margin-right: 0;">
        <div class="val-box" style="border-top: 3px solid #10b981;">
            <div class="val-label">Finished Goods</div>
            <div class="val-value">Rs. {{ number_format($summary['finished']['valuation'], 2) }}</div>
            <div class="val-meta">{{ $summary['finished']['count'] }} Assets Identified</div>
        </div>
    </div>
    @endif
</div>

<div style="font-size: 9px; font-weight: bold; margin-bottom: 20px; color: #64748b; text-align: right;">
    Audit Focus Valuation Sum: <span style="color: #0d9488; font-size: 14px; font-weight: 900; margin-left: 10px;">Rs. {{ number_format($summary['total_valuation'], 2) }}</span>
</div>

@if($type === 'all' || $type === 'finished_good')
<!-- Finished Goods Section -->
<div class="segment-header" style="border-left-color: #10b981;">3. Finished Goods Ledger (FG)</div>
<table style="font-size: 9px;">
    <thead>
        <tr>
            <th width="40%">Product Designation</th>
            <th>Category</th>
            <th class="text-center">Stock</th>
            <th class="text-right">Unit Cost</th>
            <th class="text-right">Total Value</th>
        </tr>
    </thead>
    <tbody>
        @foreach($finishedGoods as $p)
        <tr>
            <td>
                <div class="font-bold">{{ $p->name }}</div>
                <div style="font-size: 7px; color: #94a3b8;">{{ $p->brand->name ?? 'Generic' }}</div>
            </td>
            <td>{{ $p->category->name ?? 'Unlinked' }}</td>
            <td class="text-center">{{ number_format($p->current_stock, 1) }} <small>{{ $p->unit->short_name }}</small></td>
            <td class="text-right text-xs">Rs.{{ number_format($p->cost_price, 2) }}</td>
            <td class="text-right font-bold" style="color: #10b981;">Rs.{{ number_format($p->current_stock * $p->cost_price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@if($type === 'all')
<div style="page-break-before: always;"></div>
@endif

@if($type === 'all' || $type === 'raw_material')
<!-- Raw Materials Section -->
<div class="segment-header">1. Raw Materials Ledger (RM)</div>
<table style="font-size: 9px;">
    <thead>
        <tr>
            <th width="40%">Item Name</th>
            <th>Category</th>
            <th class="text-center">Stock</th>
            <th class="text-right">Unit Cost</th>
            <th class="text-right">Total Value</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rawMaterials as $p)
        <tr>
            <td>
                <div class="font-bold">{{ $p->name }}</div>
                <div style="font-size: 7px; color: #94a3b8;">{{ $p->brand->name ?? 'Generic' }}</div>
            </td>
            <td>{{ $p->category->name ?? 'Unlinked' }}</td>
            <td class="text-center">{{ number_format($p->current_stock, 1) }} <small>{{ $p->unit->short_name }}</small></td>
            <td class="text-right text-xs">Rs.{{ number_format($p->cost_price, 2) }}</td>
            <td class="text-right font-bold text-teal-600">Rs.{{ number_format($p->current_stock * $p->cost_price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@if($type === 'all')
<div style="page-break-before: always;"></div>
@endif

@if($type === 'all' || $type === 'packaging')
<!-- Packaging Section -->
<div class="segment-header" style="border-left-color: #6366f1;">2. Packaging Materials Ledger (PM)</div>
<table style="font-size: 9px;">
    <thead>
        <tr>
            <th width="40%">Item Name</th>
            <th>Category</th>
            <th class="text-center">Stock</th>
            <th class="text-right">Unit Cost</th>
            <th class="text-right">Total Value</th>
        </tr>
    </thead>
    <tbody>
        @foreach($packagingMaterials as $p)
        <tr>
            <td>
                <div class="font-bold">{{ $p->name }}</div>
                <div style="font-size: 7px; color: #94a3b8;">{{ $p->brand->name ?? 'Generic' }}</div>
            </td>
            <td>{{ $p->category->name ?? 'Unlinked' }}</td>
            <td class="text-center">{{ number_format($p->current_stock, 1) }} <small>{{ $p->unit->short_name }}</small></td>
            <td class="text-right text-xs">Rs.{{ number_format($p->cost_price, 2) }}</td>
            <td class="text-right font-bold" style="color: #6366f1;">Rs.{{ number_format($p->current_stock * $p->cost_price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div style="margin-top: 40px; border-top: 2px solid #f1f5f9; padding-top: 20px;">
    <div style="font-size: 8px; color: #94a3b8;">
        <strong>Audit Disclaimer:</strong> This document represents the official inventory state of Alif Pharma as of the generation timestamp. Discrepancies should be reported to the Inventory Controller immediately.
    </div>
</div>
@endsection
