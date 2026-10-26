<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SalaryPayment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SalaryController extends Controller
{
    public function index()
    {
        $payments = SalaryPayment::with('employee')->latest()->paginate(15);
        return view('salaries.index', compact('payments'));
    }

    public function process(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $employees = Employee::where('status', 'active')->get();
        
        // Calculate days in selected month for accurate deduction
        $daysInMonth = \Carbon\Carbon::parse($month)->daysInMonth;

        return view('salaries.process', compact('employees', 'month', 'daysInMonth'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|string',
            'payments' => 'required|array',
            'payments.*.employee_id' => 'required|exists:employees,id',
            'payments.*.off_days' => 'required|integer|min:0',
            'payments.*.adjustment' => 'required|numeric',
            'payments.*.note' => 'nullable|string',
        ]);

        $month = $request->month;
        $daysInMonth = \Carbon\Carbon::parse($month)->daysInMonth;

        foreach ($request->payments as $pData) {
            $employee = Employee::find($pData['employee_id']);
            
            // Logic: (Base / Days) * OffDays
            $deduction = ($employee->base_salary / $daysInMonth) * $pData['off_days'];
            $net = $employee->base_salary - $deduction + $pData['adjustment'];

            SalaryPayment::updateOrCreate(
                ['employee_id' => $employee->id, 'payment_month' => $month],
                [
                    'base_salary' => $employee->base_salary,
                    'off_days' => $pData['off_days'],
                    'off_days_deduction' => $deduction,
                    'manual_adjustment' => $pData['adjustment'],
                    'adjustment_note' => $pData['note'],
                    'net_salary' => $net,
                    'status' => 'paid',
                    'paid_at' => now(),
                ]
            );
        }

        return redirect()->route('salaries.index')->with('success', 'Payroll for ' . $month . ' finalized and disbursed.');
    }

    public function slip(SalaryPayment $payment)
    {
        $payment->load('employee');
        $pdf = Pdf::loadView('salaries.slip_pdf', compact('payment'));
        
        return $pdf->download('Salary-Slip-' . $payment->employee->employee_id . '-' . $payment->payment_month . '.pdf');
    }
}
