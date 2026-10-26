<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Delivery Challan - {{ $slip->slip_number }}</title>
    <style>
        @font-face {
            font-family: 'Outfit';
            src: url('{{ public_path('fonts/outfit-400.ttf') }}') format('truetype');
            font-weight: normal;
        }

        @font-face {
            font-family: 'Outfit';
            src: url('{{ public_path('fonts/outfit-700.ttf') }}') format('truetype');
            font-weight: bold;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            font-size: 10pt;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            margin-bottom: 40px;
        }

        /* Split Header */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #0f766e;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .distributor-info {
            width: 60%;
            vertical-align: top;
        }

        .company-branding {
            width: 40%;
            text-align: right;
            vertical-align: top;
        }

        .branding-title {
            font-size: 18pt;
            font-weight: bold;
            color: #0f766e;
            letter-spacing: -0.5px;
        }

        .branding-sub {
            font-size: 8pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: -5px;
        }

        .doc-title {
            font-size: 24pt;
            font-weight: bold;
            color: #0f766e;
            margin-bottom: 5px;
            letter-spacing: -1px;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 12px;
        }

        .label {
            font-size: 8pt;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .value {
            font-size: 10pt;
            font-weight: bold;
            color: #334155;
        }

        /* Main Manifest Table (Boxed Layout) */
        .manifest-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
        }

        .manifest-table th {
            background-color: #0f766e;
            color: white;
            text-transform: uppercase;
            font-size: 8pt;
            font-weight: bold;
            letter-spacing: 1px;
            padding: 12px 15px;
            text-align: left;
        }

        .manifest-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .manifest-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .total-row {
            background-color: #f1f5f9;
            font-weight: bold;
        }

        .copy-label {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 9pt;
            font-weight: bold;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
        }

        .signature-box {
            width: 200px;
            border-top: 1px solid #1e293b;
            text-align: center;
            padding-top: 5px;
            font-size: 8pt;
            color: #64748b;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    @php
        $copies = ['Warehouse / Office Copy', 'Distributor / Truck Copy', 'Accounts Copy'];
    @endphp

    @foreach($copies as $copy)
        <div class="container @if(!$loop->last) page-break @endif">
            <div class="copy-label">{{ $copy }}</div>

            <table class="header-table">
                <tr>
                    <td class="distributor-info">
                        <div class="doc-title">DELIVERY CHALLAN</div>
                        <div class="label">Date of Dispatch</div>
                        <div class="value">{{ $slip->transaction_date->format('l, d F Y') }}</div>
                    </td>
                    <td class="company-branding">
                        <div style="margin-bottom: 10px;">
                            <img src="{{ public_path('alif-logo.png') }}" style="height: 40px; width: auto;" alt="Logo">
                        </div>
                        <div class="branding-title italic">ALIF PHARMA</div>
                        <div class="branding-sub">Precision Logistics Unit</div>
                    </td>
                </tr>
            </table>

            <!-- Meta Grid -->
            <table width="100%" style="margin-bottom: 30px;">
                <tr>
                    <td width="50%" style="padding-right: 15px;">
                        <div class="meta-box">
                            <div class="label">Invoice Destination</div>
                            <div class="value" style="font-size: 14pt; margin-top: 5px;">
                                {{ $slip->distributor->company_name ?? $slip->distributor->name }}
                            </div>
                            <div style="color: #64748b; font-size: 9pt; margin-top: 5px;">
                                {{ $slip->distributor->street_address }}<br>
                                {{ $slip->distributor->city }} {{ $slip->distributor->area }}
                            </div>
                        </div>
                    </td>
                    <td width="50%" style="padding-left: 15px;">
                        <div class="meta-box">
                            <div class="grid" style="width: 100%;">
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <div class="label">Challan No.</div>
                                            <div class="value">{{ $slip->slip_number }}</div>
                                        </td>
                                        <td style="text-align: right;">
                                            <div class="label">Tracking Vector</div>
                                            <div class="value">LOG-{{ date('Ymd') }}-{{ $slip->id }}</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div style="margin-top: 15px; font-size: 8pt; color: #64748b; font-style: italic;">
                            Notes: {{ $slip->notes ?? 'Standard logistic protocols applying to this shipment.' }}
                        </div>
                    </td>
                </tr>
            </table>

            <table class="manifest-table">
                <thead>
                    <tr>
                        <th width="10%">Sr. #</th>
                        <th width="50%">Branded Product / Item Specification</th>
                        <th width="20%" style="text-align: center;">Cartons</th>
                        <th width="20%" style="text-align: right;">Quantity Loaded</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($slip->items as $index => $item)
                        <tr>
                            <td style="text-align: center; color: #94a3b8; font-weight: bold;">{{ $index + 1 }}</td>
                            <td style="font-weight: bold; text-transform: uppercase;">{{ $item->product->name }}</td>
                            <td style="text-align: center; font-weight: bold; color: #0f766e;">
                                {{ number_format($item->number_of_cartons) ?: '--' }}
                            </td>
                            <td style="text-align: right; font-weight: bold; background-color: #f8fafc;">
                                {{ number_format($item->quantity) }}
                                <span style="font-size: 8pt; color: #94a3b8;">{{ $item->product->unit->name ?? 'PCS' }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="footer">
                <tr>
                    <td>
                        <div class="signature-box" style="margin-right: auto;">
                            Warehouse Manager Signature
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <div class="signature-box" style="margin-left: auto;">
                            Receiver's Acknowledged Signature
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endforeach

</body>

</html>