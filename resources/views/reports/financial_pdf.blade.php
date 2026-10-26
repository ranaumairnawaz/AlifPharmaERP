@extends('layouts.print')

@section('title', 'Corporate Financial Performance Statement')

@section('content')
<style>
    .summary-card {
        width: 100%;
        margin-bottom: 30px;
    }
    .summary-item {
        width: 20%;
        display: inline-block;
        vertical-align: top;
        padding: 8px;
        background-color: #f8fafc;
        border-radius: 8px;
        margin-right: 1%;
    }
    .summary-item.highlight {
        background-color: #f0fdfa;
        border: 1px solid #ccfbf1;
    }
    .label { font-size: 8px; font-weight: bold; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
    .value { font-size: 16px; font-weight: 900; color: #1e293b; }
</style>

<div style="margin-bottom: 20px;">
    <span class="badge badge-in" style="font-size: 10px; padding: 5px 10px;">
        Analytical Mode: {{ strtoupper($type) }} | timeframe: {{ strtoupper($timeframe) }} 
        @if($startsAt && $endsAt) ({{ $startsAt->format('Y-m-d') }} to {{ $endsAt->format('Y-m-d') }}) @endif
    </span>
</div>

<div class="summary-card clearfix">
    @if($type === 'sales')
        <div class="summary-item highlight">
            <div class="label">Gross Revenue</div>
            <div class="value">Rs. {{ number_format($summary['revenue'], 2) }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Invoice Count</div>
            <div class="value">{{ $summary['count'] }} Docs</div>
        </div>
        <div class="summary-item">
            <div class="label">AVG Ticket</div>
            <div class="value">Rs. {{ number_format($summary['avg'], 2) }}</div>
        </div>
    @elseif($type === 'profit')
        <div class="summary-item highlight">
            <div class="label">Net Profit</div>
            <div class="value" style="color: #0d9488;">Rs. {{ number_format($summary['profit'], 2) }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Revenue</div>
            <div class="value">Rs. {{ number_format($summary['revenue'], 2) }}</div>
        </div>
        <div class="summary-item">
            <div class="label">COGS Layer</div>
            <div class="value" style="color: #991b1b;">Rs. {{ number_format($summary['cogs'], 2) }}</div>
        </div>
    @elseif($type === 'turnover')
        <div class="summary-item highlight">
            <div class="label">Turnover Ratio</div>
            <div class="value">{{ number_format($summary['ratio'], 2) }}x</div>
        </div>
        <div class="summary-item">
            <div class="label">COGS (Annualized)</div>
            <div class="value">Rs. {{ number_format($summary['cogs'], 2) }}</div>
        </div>
        <div class="summary-item">
            <div class="label">AVG Stock Value</div>
            <div class="value">Rs. {{ number_format($summary['avg_stock'], 2) }}</div>
        </div>
    @elseif($type === 'salaries')
        <div class="summary-item highlight" style="background-color: #fef2f2;">
            <div class="label">Total Payroll</div>
            <div class="value" style="color: #991b1b;">Rs. {{ number_format($summary['payroll'], 2) }}</div>
        </div>
        <div class="summary-item">
            <div class="label">Active Staff</div>
            <div class="value">{{ $summary['staff'] }} Pers.</div>
        </div>
        <div class="summary-item">
            <div class="label">AVG Salary</div>
            <div class="value">Rs. {{ number_format($summary['avg'], 2) }}</div>
        </div>
    @endif
</div>

<div class="section-title">
    @if($type === 'sales') Sales Transaction Log @elseif($type === 'profit') profitability Analysis @elseif($type === 'turnover') Global Inventory Velocity @else Salary Overhead Journal @endif
</div>
<table>
    <thead>
        @if($type === 'sales')
            <tr>
                <th>Date</th>
                <th>Invoice #</th>
                <th>Distributor</th>
                <th>Type</th>
                <th class="text-right">Grand Total</th>
            </tr>
        @elseif($type === 'profit')
            <tr>
                <th>Product</th>
                <th>Sold Qty</th>
                <th class="text-right">Revenue</th>
                <th class="text-right">Total Cost</th>
                <th class="text-right">Net Profit</th>
            </tr>
        @elseif($type === 'turnover')
            <tr>
                <th>Asset Identity</th>
                <th class="text-right">Sold (Qty)</th>
                <th class="text-right">COGS</th>
                <th class="text-right">Stock Value</th>
                <th class="text-right">Velocity</th>
            </tr>
        @elseif($type === 'salaries')
            <tr>
                <th>Employee</th>
                <th>Identity #</th>
                <th>Designation</th>
                <th class="text-right">Total Paid</th>
            </tr>
        @endif
    </thead>
    <tbody>
        @forelse($results as $r)
        <tr>
            @if($type === 'sales')
                <td class="font-mono" style="font-size: 8px;">{{ $r->created_at->format('Y-m-d') }}</td>
                <td class="font-bold">{{ $r->invoice_number }}</td>
                <td>{{ $r->slip->distributor->name ?? 'N/A' }}</td>
                <td><span class="badge badge-in">{{ strtoupper($r->type) }}</span></td>
                <td class="text-right font-bold text-teal-700">Rs. {{ number_format($r->grand_total, 2) }}</td>
            @elseif($type === 'profit')
                <td><div class="font-bold">{{ $r->product_name }}</div></td>
                <td>{{ number_format($r->total_sold, 1) }}</td>
                <td class="text-right">Rs. {{ number_format($r->revenue, 2) }}</td>
                <td class="text-right text-rose-700">Rs. {{ number_format($r->total_cost, 2) }}</td>
                <td class="text-right font-bold text-teal-700">Rs. {{ number_format($r->profit, 2) }}</td>
            @elseif($type === 'turnover')
                <td><div class="font-bold">{{ $r->product_name }}</div></td>
                <td class="text-right">{{ number_format($r->sold_qty, 1) }}</td>
                <td class="text-right">Rs. {{ number_format($r->cogs, 2) }}</td>
                <td class="text-right">Rs. {{ number_format($r->stock_value, 2) }}</td>
                <td class="text-right font-black text-indigo-700">{{ $r->stock_value > 0 ? number_format($r->cogs / $r->stock_value, 2) : '---' }}x</td>
            @elseif($type === 'salaries')
                <td><div class="font-bold">{{ $r->employee_name }}</div></td>
                <td>{{ $r->employee_id }}</td>
                <td>{{ $r->designation }}</td>
                <td class="text-right font-bold text-rose-700">Rs. {{ number_format($r->total_paid, 2) }}</td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center italic" style="padding: 40px;">No records identified for this analytical scope.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top: 50px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
    <div style="float: left; width: 50%;">
        <div style="font-size: 8px; color: #94a3b8; text-transform: uppercase; margin-bottom: 30px;">Prepared By</div>
        <div style="border-bottom: 1px solid #f1f5f9; width: 150px;"></div>
        <div style="font-size: 8px; color: #64748b; margin-top: 5px;">Alif Pharma Systems Admin</div>
    </div>
    <div style="float: right; width: 50%; text-align: right;">
        <div style="font-size: 8px; color: #94a3b8; text-transform: uppercase; margin-bottom: 30px;">Authorized Official</div>
        <div style="border-bottom: 1px solid #f1f5f9; width: 150px; margin-left: auto;"></div>
        <div style="font-size: 8px; color: #64748b; margin-top: 5px;">Finance Controller</div>
    </div>
</div>
@endsection
