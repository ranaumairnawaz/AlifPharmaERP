<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $invoice->invoice_number }}</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.4;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #0d9488;
            padding-bottom: 15px;
        }

        .logo {
            height: 60px;
            float: left;
        }

        .company-info {
            text-align: right;
            float: right;
        }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #0d9488;
            text-transform: uppercase;
            margin: 0;
        }

        .company-tagline {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .details-grid {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .details-box {
            width: 48%;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            vertical-align: top;
        }

        .details-header {
            background: #f8fafc;
            padding: 5px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
            color: #64748b;
        }

        .details-content {
            padding: 8px 12px;
        }

        table.manifest {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }

        table.manifest th {
            background: #0d9488;
            color: white;
            padding: 6px 8px;
            font-size: 8px;
            text-transform: uppercase;
            font-weight: bold;
            text-align: left;
        }

        table.manifest td {
            padding: 8px 8px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }

        table.manifest tr:nth-child(even) {
            background: #f8fafc;
        }

        .totals-table {
            float: right;
            width: 250px;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 4px 10px;
            border-bottom: 1px solid #f1f5f9;
        }

        .totals-label {
            text-align: right;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            font-size: 8px;
        }

        .totals-value {
            text-align: right;
            font-weight: bold;
            font-size: 10px;
        }

        .grand-total-row {
            background: #0d9488;
            color: white;
        }

        .grand-total-row td {
            border: none;
            padding: 8px 10px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-net {
            background: #ccfbf1;
            color: #0f766e;
        }

        .badge-warranty {
            background: #fef3c7;
            color: #92400e;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('alif-logo.png') }}" style="height: 50px;" alt="Logo">
        </div>
        <div class="company-info">
            <h1 class="company-name">Alif Pharma</h1>
            <p class="company-tagline">Excellence in Pharmaceutical Manufacturing</p>
            <p style="margin-top: 5px;">Hashim Park, Sheikhupura Road, Lahore, Pakistan<br>
                Invoice Date: {{ $invoice->created_at->format('M d, Y') }}
            </p>
        </div>
        <div class="clear"></div>
    </div>

    <table class="details-grid">
        <tr>
            <td class="details-box">
                <div class="details-header">Billed To</div>
                <div class="details-content">
                    <strong
                        style="font-size: 12px; color: #0f172a;">{{ $invoice->slip->distributor->company_name ?? $invoice->slip->distributor->name }}</strong><br>
                    {{ $invoice->slip->distributor->street_address }}<br>
                    {{ $invoice->slip->distributor->city }}, {{ $invoice->slip->distributor->area }}
                </div>
            </td>
            <td style="width: 4%;"></td>
            <td class="details-box">
                <div class="details-header">Document Identity</div>
                <div class="details-content">
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td style="font-weight: bold;">Invoice No:</td>
                            <td style="text-align: right;">{{ $invoice->invoice_number }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">DC Ref:</td>
                            <td style="text-align: right;">#{{ $invoice->slip->slip_number }}</td>
                        </tr>
                        @if($invoice->due_date)
                            <tr>
                                <td style="font-weight: bold;">Due Date:</td>
                                <td style="text-align: right; color: #e11d48;">{{ $invoice->due_date->format('M d, Y') }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td style="font-weight: bold;">Type:</td>
                            <td style="text-align: right;">
                                <span
                                    class="badge {{ $invoice->type === 'net' ? 'badge-net' : 'badge-warranty' }}">{{ strtoupper($invoice->type) }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <table class="manifest">
        <thead>
            <tr>
                <th style="width: 3%;">#</th>
                <th style="width: 32%;">Item Specification</th>
                <th style="width: 12%;">Batch No</th>
                <th style="width: 8%; text-align: center;">Qty</th>
                <th style="width: 10%; text-align: right;">Rate (Rs.)</th>
                <th style="width: 10%; text-align: right;">Gross (Rs.)</th>
                <th style="width: 10%; text-align: right;">Disc</th>
                <th style="width: 15%; text-align: right;">Net Amt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product->name }}</strong><br>
                        <span style="font-size: 7px; color: #64748b;">{{ $item->product->unit->short_name }}</span>
                    </td>
                    <td style="font-weight: 700; color: #4f46e5;">{{ $item->productBatch->batch_number ?? '--' }}</td>
                    <td style="text-align: center;">{{ number_format($item->quantity, 0) }}</td>
                    <td style="text-align: right;">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right;">
                        {{ number_format($item->gross_amount ?? ($item->unit_price * $item->quantity), 2) }}</td>
                    <td style="text-align: right;">
                        @if($item->discount_percentage > 0)
                            {{ number_format($item->discount_percentage, 1) }}%<br>
                            <span style="font-size: 7px; color: #94a3b8;">-{{ number_format($item->discount_value, 0) }}</span>
                        @else
                            --
                        @endif
                    </td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals-section">
        <div style="float: left; width: 350px; padding: 10px; border: 1px solid #f1f5f9; border-radius: 8px;">
            <div class="details-header" style="margin: -10px -10px 5px -10px;">Audit / Logistics Remarks</div>
            <p style="font-style: italic; color: #64748b;">{{ $invoice->notes ?: 'Standard corporate terms apply.' }}
            </p>
        </div>

        <table class="totals-table">
            <tr>
                <td class="totals-label">Manifest Subtotal:</td>
                <td class="totals-value">Rs. {{ number_format($invoice->items->sum('total_price'), 2) }}</td>
            </tr>
            @if($invoice->adjustment_amount != 0)
                <tr>
                    <td class="totals-label">Manual Adjustment:</td>
                    <td class="totals-value"
                        style="{{ $invoice->adjustment_amount > 0 ? 'color: #e11d48;' : 'color: #059669;' }}">
                        {{ $invoice->adjustment_amount > 0 ? '+' : '' }} Rs.
                        {{ number_format($invoice->adjustment_amount, 2) }}
                    </td>
                </tr>
            @endif
            <tr class="grand-total-row">
                <td class="totals-label" style="color: white;">Payable Amount:</td>
                <td class="totals-value" style="font-size: 13px;">Rs. {{ number_format($invoice->grand_total, 2) }}</td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>

    <div class="footer">
        Generated by {{ $invoice->creator->name }} | Authorized for Alif Pharma Administrative Use
    </div>
</body>

</html>