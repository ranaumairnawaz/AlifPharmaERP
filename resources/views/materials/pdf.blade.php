<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Material Entry Slip - {{ $entry->slip_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 40px;
        }

        .header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: 900;
            color: #0d9488;
            letter-spacing: -1px;
            text-transform: uppercase;
        }

        .slip-title {
            font-size: 32px;
            font-weight: 900;
            letter-spacing: -2px;
            margin: 10px 0;
            color: #0f172a;
        }

        .meta-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .meta-col {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
        }

        .meta-label {
            font-size: 8px;
            font-weight: 900;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .meta-value {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background: #f8fafc;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 12px 15px;
            font-size: 11px;
            border-bottom: 1px solid #f1f5f9;
        }

        .qty {
            font-weight: 700;
        }

        .total-row {
            background: #f8fafc;
            border-top: 2px solid #e2e8f0;
        }

        .grand-total {
            font-size: 16px;
            font-weight: 900;
            color: #4f46e5;
        }

        .footer {
            margin-top: 50px;
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
            border-t: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        .notes {
            background: #fffbeb;
            border: 1px solid #fef3c7;
            padding: 15px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .notes-label {
            font-size: 8px;
            font-weight: 900;
            color: #92400e;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .notes-text {
            font-size: 10px;
            color: #92400e;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">Alif Pharma</div>
        <div class="slip-title">Material Purchase Slip</div>
    </div>

    <div class="meta-grid">
        <div class="meta-col">
            <div class="meta-label">Entry Number</div>
            <div class="meta-value">{{ $entry->slip_number }}</div>
        </div>
        <div class="meta-col" style="margin-left: 20px;">
            <div class="meta-label">Origin / Source</div>
            <div class="meta-value">{{ $entry->source }}</div>
        </div>
        <div class="meta-col" style="margin-left: 20px;">
            <div class="meta-label">Transaction Date</div>
            <div class="meta-value">{{ $entry->transaction_date->format('M d, Y') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Internal Lot #</th>
                <th>Expiry Date</th>
                <th style="text-align: right;">Quantity</th>
                <th style="text-align: right;">Rate</th>
                <th style="text-align: right;">Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entry->stockMovements as $movement)
                <tr>
                    <td style="color: #94a3b8; font-weight: 700;">
                        {{ str_pad($movement->product->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td style="font-weight: 700;">{{ $movement->product->name }}</td>
                    <td style="font-weight: 700; color: #4f46e5;">{{ $movement->lot_number ?? '--' }}</td>
                    <td style="font-weight: 700; color: #b91c1c;">{{ $movement->expiry_date ? $movement->expiry_date->format('M Y') : '--' }}</td>
                    <td style="text-align: right;" class="qty">{{ number_format($movement->quantity, 2) }}
                        {{ $movement->product->unit->short_name ?? 'Unit' }}
                    </td>
                    <td style="text-align: right;">{{ number_format($movement->price_per_unit, 2) }}</td>
                    <td style="text-align: right; font-weight: 900;">Rs.
                        {{ number_format($movement->quantity * $movement->price_per_unit, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5"
                    style="text-align: right; font-weight: 900; font-size: 10px; color: #64748b; text-transform: uppercase;">
                    Aggregate Valuation</td>
                <td style="text-align: right;" class="grand-total">Rs. {{ number_format($entry->total_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    @if($entry->notes)
        <div class="notes">
            <div class="notes-label">Manifest Notes</div>
            <div class="notes-text">"{{ $entry->notes }}"</div>
        </div>
    @endif

    <div class="footer">
        Alif Pharma Internal Procurement System. Generated on {{ date('M d, Y H:i:s') }}.<br>
        This document serves as proof of material inward and financial exposure registry.
    </div>
</body>

</html>