<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Partner Profile - {{ $distributor->name }}</title>
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
            border-bottom: 2px solid #4f46e5;
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
            color: #4f46e5;
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

        .stats-grid {
            width: 100%;
            margin-bottom: 20px;
        }

        .stat-box {
            width: 32%;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            text-align: center;
            vertical-align: top;
        }

        .stat-label {
            font-size: 8px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
        }

        .stat-val {
            font-size: 14px;
            font-weight: bold;
            color: #4f46e5;
            margin-top: 5px;
        }

        .stat-val-danger {
            color: #e11d48;
        }

        .stat-val-success {
            color: #059669;
        }

        table.manifest {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }

        table.manifest th {
            background: #4f46e5;
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

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <h1 class="company-name" style="margin-top: 10px; color: #1e293b;">Distributor Profile</h1>
        </div>
        <div class="company-info">
            <h1 class="company-name">Alif Pharma</h1>
            <p class="company-tagline">Excellence in Pharmaceutical Manufacturing</p>
            <p style="margin-top: 5px;">Report Date: {{ now()->format('M d, Y') }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <table class="details-grid">
        <tr>
            <td class="details-box">
                <div class="details-header">Partner Identity</div>
                <div class="details-content">
                    <strong
                        style="font-size: 12px; color: #0f172a;">{{ $distributor->company_name ?? $distributor->name }}</strong><br>
                    <strong>Contact:</strong> {{ $distributor->contact_name ?? 'N/A' }}<br>
                    <strong>Phone:</strong> {{ $distributor->phone ?? 'N/A' }}
                </div>
            </td>
            <td style="width: 4%;"></td>
            <td class="details-box">
                <div class="details-header">Logistics Zone</div>
                <div class="details-content">
                    <strong style="font-size: 10px;">{{ $distributor->area }}</strong><br>
                    {{ $distributor->street_address ?? 'No Street Addr' }}<br>
                    {{ $distributor->city ?? 'No City' }}
                </div>
            </td>
        </tr>
    </table>

    <table class="stats-grid" style="border-collapse: collapse;">
        <tr>
            <td class="stat-box" style="margin: 0; padding: 10px;">
                <div class="stat-label">Lifetime Valuation</div>
                <div class="stat-val">Rs. {{ number_format($stats['total_invoiced'], 2) }}</div>
            </td>
            <td style="width: 2%;"></td>
            <td class="stat-box" style="margin: 0; padding: 10px;">
                <div class="stat-label">Capital Exposure</div>
                <div class="stat-val stat-val-danger">Rs. {{ number_format($stats['total_pending'], 2) }}</div>
            </td>
            <td style="width: 2%;"></td>
            <td class="stat-box" style="margin: 0; padding: 10px;">
                <div class="stat-label">Cleared Assets</div>
                <div class="stat-val stat-val-success">Rs. {{ number_format($stats['total_paid'], 2) }}</div>
            </td>
        </tr>
    </table>

    <h3 style="font-size: 10px; font-weight: bold; text-transform: uppercase; color: #64748b; margin-bottom: 5px;">
        Transaction Ledger (Top 50)</h3>
    <table class="manifest">
        <thead>
            <tr>
                <th style="width: 15%;">Date</th>
                <th style="width: 20%;">Invoice # / DC #</th>
                <th style="width: 25%; text-align: right;">Valuation</th>
                <th style="width: 25%; text-align: right;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices->sortByDesc('created_at')->take(50) as $invoice)
                <tr>
                    <td>{{ $invoice->created_at->format('d-M-Y') }}</td>
                    <td>
                        <strong>{{ $invoice->invoice_number }}</strong><br>
                        <span style="font-size: 7px; color: #64748b;">DC: {{ $invoice->slip->slip_number }}</span>
                    </td>
                    <td style="text-align: right; font-weight: bold;">Rs. {{ number_format($invoice->grand_total, 2) }}</td>
                    <td style="text-align: right;">
                        @if($invoice->type === 'net')
                                @if($invoice->payment_status === 'paid')
                                    <span style="color: #059669; font-weight: bold;">PAID</span>
                                @elseif($invoice->payment_status === 'partial')
                                        <span style="color: #d97706; font-weight: bold;">PARTIAL</span><br>
                                        <span style="font-size: 7px; color: #64748b;">Rs.
                                            {{ number_format($invoice->paid_amount, 2) }}</span>
                                    </td>
                                @else
                                <span style="color: #e11d48; font-weight: bold;">PENDING</span>
                            @endif
                        @else
                        --
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated by Internal Intelligence Hub | Authorized for Alif Pharma Administrative Use Only
    </div>
</body>

</html>