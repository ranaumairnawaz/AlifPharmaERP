@php
    $primaryColor = $branding['pdf_override'] ? $branding['color'] : '#0d9488';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $branding['name'] }} - Official Report</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .header {
            border-bottom: 2px solid
                {{ $primaryColor }}
            ;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .brand {
            font-size: 24px;
            font-weight: 900;
            color:
                {{ $primaryColor }}
            ;
            letter-spacing: -1px;
            text-transform: uppercase;
        }

        .report-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #64748b;
            margin-top: 5px;
        }

        .meta-info {
            float: right;
            text-align: right;
            font-size: 9px;
            color: #94a3b8;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .section-title {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color:
                {{ $primaryColor }}
            ;
            margin-bottom: 10px;
            border-left: 3px solid
                {{ $primaryColor }}
            ;
            padding-left: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .font-mono {
            font-family: 'Courier', monospace;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 8px;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }

        .pagenum:before {
            content: counter(page);
        }

        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-in {
            background-color: #f0fdf4;
            color: #166534;
        }

        .badge-out {
            background-color: #fef2f2;
            color: #991b1b;
        }

        .financial-summary {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header clearfix">
        <div class="meta-info">
            Generated on: {{ date('F d, Y | H:i') }}<br>
            System Reference: #{{ strtoupper(substr($branding['name'], 0, 2)) }}-{{ date('Ymd-His') }}<br>
            Authorized Access Only
        </div>
        <div class="brand">{{ $branding['name'] }}</div>
        <div class="report-title">@yield('title', 'Corporate Inventory Record')</div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <div class="footer">
        {{ $branding['name'] }} Official Record &bull; Confidential Corporate Document &bull; Page <span
            class="pagenum"></span>
    </div>
</body>

</html>