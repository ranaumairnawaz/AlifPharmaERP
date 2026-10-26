@extends('layouts.print')

@section('title', 'Institutional Salary Disbursement Slip')

@section('content')
<style>
    .slip-container {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .slip-header {
        background-color: #f8fafc;
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .label {
        font-size: 8px;
        font-weight: 900;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 4px;
    }
    .value {
        font-size: 11px;
        font-weight: bold;
        color: #1e293b;
    }
    .grid { display: block; width: 100%; border-collapse: collapse; }
    .col { float: left; width: 25%; }
    .clearfix::after { content: ""; clear: both; display: table; }
    
    .financial-table { width: 100%; margin-top: 20px; }
    .financial-table th { background-color: #f1f5f9; color: #475569; font-size: 9px; padding: 12px 15px; border-bottom: 2px solid #e2e8f0; }
    .financial-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 10px; }
    
    .total-row { background-color: #f8fafc; font-weight: 900; }
    .net-amount { font-size: 16px; color: {{ $branding['pdf_override'] ? $branding['color'] : '#0d9488' }}; }
    
    .signature-box {
        margin-top: 50px;
        border-top: 1px dashed #cbd5e1;
        padding-top: 20px;
    }
</style>

<div class="slip-container">
    <!-- Personnel Metadata -->
    <div class="slip-header">
        <div class="clearfix">
            <div class="col">
                <span class="label">Personnel Name</span>
                <span class="value">{{ $payment->employee->name }}</span>
            </div>
            <div class="col">
                <span class="label">Institutional ID</span>
                <span class="value">{{ $payment->employee->employee_id }}</span>
            </div>
            <div class="col" style="width: 30%;">
                <span class="label">Designation</span>
                <span class="value">{{ $payment->employee->designation ?? 'Corporate Staff' }}</span>
            </div>
            <div class="col" style="width: 20%; text-align: right;">
                <span class="label">Payment Cycle</span>
                <span class="value" style="color: #6366f1;">{{ \Carbon\Carbon::parse($payment->payment_month)->format('M Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Settlement Matrix -->
    <table class="financial-table">
        <thead>
            <tr>
                <th style="text-align: left;">Financial Specification</th>
                <th style="text-align: right;">Institutional Standard (Rs.)</th>
                <th style="text-align: right;">Disbursement (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="font-weight: 900;">Retainer Base Salary</div>
                    <div style="font-size: 8px; color: #94a3b8; text-transform: uppercase;">Standard monthly contractual compensation</div>
                </td>
                <td style="text-align: right; font-weight: bold; color: #64748b;">{{ number_format($payment->base_salary, 2) }}</td>
                <td style="text-align: right; font-weight: 900; color: #1e293b;">{{ number_format($payment->base_salary, 2) }}</td>
            </tr>
            
            @if($payment->off_days > 0)
            <tr>
                <td>
                    <div style="font-weight: 900; color: #ef4444;">Attendance Deduction ({{ $payment->off_days }} Off-Days)</div>
                    <div style="font-size: 8px; color: #94a3b8; text-transform: uppercase;">Prorated subtraction for unauthorized dormancy</div>
                </td>
                <td style="text-align: right; font-weight: bold; color: #64748b;">-</td>
                <td style="text-align: right; font-weight: 900; color: #ef4444;">- {{ number_format($payment->off_days_deduction, 2) }}</td>
            </tr>
            @endif

            @if($payment->manual_adjustment != 0)
            <tr>
                <td>
                    <div style="font-weight: 900; color: {{ $payment->manual_adjustment > 0 ? '#10b981' : '#ef4444' }};">
                        Manual Institutional Adjustment
                    </div>
                    <div style="font-size: 8px; color: #94a3b8; text-transform: uppercase;">{{ $payment->adjustment_note ?? 'Authorized manual override' }}</div>
                </td>
                <td style="text-align: right; font-weight: bold; color: #64748b;">-</td>
                <td style="text-align: right; font-weight: 900; color: {{ $payment->manual_adjustment > 0 ? '#10b981' : '#ef4444' }};">
                    {{ $payment->manual_adjustment > 0 ? '+' : '-' }} {{ number_format(abs($payment->manual_adjustment), 2) }}
                </td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2" style="text-align: right; padding: 20px; font-size: 9px; text-transform: uppercase; letter-spacing: 1px;">Net Institutional Disbursement:</td>
                <td style="text-align: right; padding: 20px;">
                    <span class="net-amount">Rs. {{ number_format($payment->net_salary, 2) }}</span>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="signature-box clearfix">
    <div style="float: left; width: 45%;">
        <div style="height: 40px;"></div>
        <div style="border-top: 1px solid #e2e8f0; width: 100%; margin-bottom: 5px;"></div>
        <div style="font-[10px]; font-bold; text-transform: uppercase; color: #94a3b8; text-align: center;">Personnel Acceptance</div>
    </div>
    <div style="float: right; width: 45%;">
        <div style="height: 40px;"></div>
        <div style="border-top: 1px solid #e2e8f0; width: 100%; margin-bottom: 5px;"></div>
        <div style="font-[10px]; font-bold; text-transform: uppercase; color: #94a3b8; text-align: center;">Authorized Accounts Manager</div>
    </div>
</div>

<div style="margin-top: 40px; font-[8px]; color: #94a3b8; line-height: 1.6; font-style: italic;">
    <strong>Financial Integrity Notice:</strong> This is a computer-generated salary disbursement instrument from the {{ $branding['name'] }} intelligence system. Discrepancies must be reported to the Accounts Department within 48 hours of disbursement. Reference ID: #SLIP-{{ $payment->id }}-{{ date('Ymd') }}.
</div>
@endsection
