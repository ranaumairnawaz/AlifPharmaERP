@extends('layouts.print')

@section('title', 'Product Portfolio & Catalogue Statement')

@section('content')
<style>
    .status-badge {
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 8px;
        font-weight: 900;
        text-transform: uppercase;
        display: inline-block;
    }
    .status-critical { background-color: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }
    .status-normal { background-color: #ecfdf5; color: #065f46; border: 1px solid #d1fae5; }
    .status-near { background-color: #fffbeb; color: #92400e; border: 1px solid #fef3c7; }
    
    .sku-pill {
        color: #64748b;
        font-family: monospace;
        font-size: 7px;
        letter-spacing: 0.5px;
    }
    
    .price-col { font-weight: 900; color: #1e293b; }
    .type-label { font-size: 7px; color: #94a3b8; font-weight: 900; text-transform: uppercase; }
</style>

<div style="font-size: 9px; font-weight: bold; margin-bottom: 25px; color: #64748b;">
    Portfolio Overview: <span style="color: #0d9488; font-size: 14px; font-weight: 900; margin-left: 10px;">{{ $products->count() }} Active Entries Identified</span>
</div>

<table style="width: 100%; border-collapse: collapse; font-size: 9px;">
    <thead>
        <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
            <th style="padding: 10px 5px; text-align: left; width: 30%;">Product Specification</th>
            <th style="padding: 10px 5px; text-align: left; width: 15%;">Classification</th>
            <th style="padding: 10px 5px; text-align: left; width: 10%;">Expiry</th>
            <th style="padding: 10px 5px; text-align: right; width: 15%;">Unit Value (Rs)</th>
            <th style="padding: 10px 5px; text-align: right; width: 15%;">Inventory Status</th>
            <th style="padding: 10px 5px; text-align: right; width: 15%;">Valuation (Global)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 10px 5px;">
                    <div style="font-weight: 900; color: #0f172a; font-size: 10px;">{{ $product->name }}</div>
                    <div class="sku-pill">CODE: #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }} | {{ $product->brand->name ?? 'Generic Portfolio' }}</div>
                </td>
                <td style="padding: 10px 5px;">
                    <div style="font-weight: 700; color: #6366f1;">{{ $product->category->name ?? 'Unlinked' }}</div>
                    <div class="type-label">{{ str_replace('_', ' ', $product->material_type) }}</div>
                </td>
                <td style="padding: 10px 5px;">
                    @if($product->expiry_date)
                        @php
                            $daysRemaining = now()->diffInDays($product->expiry_date, false);
                            $expiryStyle = $daysRemaining < 0 ? 'color: #ef4444;' : ($daysRemaining <= 30 ? 'color: #f59e0b;' : '');
                        @endphp
                        <div style="font-weight: 700; font-family: monospace; {{ $expiryStyle }}">
                            {{ $product->expiry_date->format('M Y') }}
                        </div>
                    @else
                        <div style="color: #cbd5e1; font-style: italic;">N/A</div>
                    @endif
                </td>
                <td style="padding: 10px 5px; text-align: right;">
                    <div class="price-col">Rs. {{ number_format($product->sale_price, 2) }}</div>
                    <div style="font-size: 7px; color: #94a3b8;">Cost: Rs. {{ number_format($product->cost_price, 2) }}</div>
                </td>
                <td style="padding: 10px 5px; text-align: right;">
                    @php
                        $isLow = $product->current_stock <= $product->reorder_point;
                        $statusClass = $isLow ? 'status-critical' : 'status-normal';
                    @endphp
                    <div class="status-badge {{ $statusClass }}">
                        {{ number_format($product->current_stock, $product->unit->is_decimal ? 1 : 0) }} {{ $product->unit->short_name }}
                    </div>
                </td>
                <td style="padding: 10px 5px; text-align: right;">
                    <div style="font-weight: 900; color: #0d9488;">Rs. {{ number_format($product->current_stock * $product->cost_price, 2) }}</div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="padding: 50px; text-align: center; color: #94a3b8; font-style: italic;">
                    No pharmaceutical inventory entries match the selected filters.
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="background-color: #f1f5f9; font-weight: 900;">
            <td colspan="5" style="padding: 12px 5px; text-align: right; text-transform: uppercase; font-size: 8px; letter-spacing: 1px;">Global Portfolio Net Valuation:</td>
            <td style="padding: 12px 5px; text-align: right; font-size: 11px; color: #0d9488;">
                Rs. {{ number_format($products->sum(fn($p) => $p->current_stock * $p->cost_price), 2) }}
            </td>
        </tr>
    </tfoot>
</table>

<div style="margin-top: 40px; border-top: 1px dashed #cbd5e1; padding-top: 20px;">
    <div style="font-size: 7px; color: #94a3b8; line-height: 1.6;">
        <strong>Data Integrity Notice:</strong> This statement reflects the authorized inventory ledger of Alif Pharma. Valuation is calculated using weighted cost pricing. Unauthorized reproduction or dissemination is strictly prohibited for external stakeholders.
    </div>
</div>
@endsection
