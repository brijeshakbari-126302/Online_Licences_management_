<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request): View
    {
        $query = Employee::withCount(['activeAssignments']);

        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('employee_id', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('job_title', 'like', $term);
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->input('department'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $employees = $query->orderBy('name')->paginate(10)->withQueryString();
        $departments = Employee::select('department')->distinct()->pluck('department');

        return view('employees.index', [
            'employees' => $employees,
            'departments' => $departments,
            'selectedDepartment' => $request->input('department'),
            'selectedStatus' => $request->input('status'),
            'searchTerm' => $request->input('search'),
        ]);
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create(): View
    {
        $departments = ['Engineering', 'Product & Design', 'DevOps & IT', 'Marketing', 'Sales', 'Finance', 'Human Resources', 'Legal & Compliance'];

        return view('employees.create', [
            'departments' => $departments,
        ]);
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'string', 'max:50', 'unique:employees,employee_id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:employees,email'],
            'department' => ['required', 'string', 'max:100'],
            'job_title' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'string', 'in:active,inactive,on_leave'],
        ]);

        $employee = Employee::create($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', "Employee '{$employee->name}' registered successfully.");
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee): View
    {
        $employee->load(['assignments.license.vendor']);

        return view('employees.show', [
            'employee' => $employee,
        ]);
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee): View
    {
        $departments = ['Engineering', 'Product & Design', 'DevOps & IT', 'Marketing', 'Sales', 'Finance', 'Human Resources', 'Legal & Compliance'];

        return view('employees.edit', [
            'employee' => $employee,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'string', 'max:50', Rule::unique('employees')->ignore($employee->id)],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('employees')->ignore($employee->id)],
            'department' => ['required', 'string', 'max:100'],
            'job_title' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'string', 'in:active,inactive,on_leave'],
        ]);

        $employee->update($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', "Employee '{$employee->name}' updated successfully.");
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        $name = $employee->name;
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', "Employee '{$name}' deleted successfully.");
    }
}
