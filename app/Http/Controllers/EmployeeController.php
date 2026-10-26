<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function show(Employee $employee)
    {
        $employee->load('payments');
        return view('employees.show', compact('employee'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:employees,email',
            'designation' => 'nullable|string|max:255',
            'base_salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'account_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Auto-generate Employee ID
        $lastEmployee = Employee::orderBy('id', 'desc')->first();
        $nextId = $lastEmployee ? ($lastEmployee->id + 1) : 1;
        $data['employee_id'] = 'AP-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        Employee::create($data);

        return redirect()->route('employees.index')->with('success', 'Employee ' . $data['employee_id'] . ' onboarded successfully.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:employees,email,' . $employee->id,
            'designation' => 'nullable|string|max:255',
            'base_salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'account_number' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Employee record synchronized.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee record archived.');
    }
}
