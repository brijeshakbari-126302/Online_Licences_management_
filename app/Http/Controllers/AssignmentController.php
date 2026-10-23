<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\License;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Display a listing of license assignments.
     */
    public function index(Request $request): View
    {
        $query = Assignment::with(['license.vendor', 'employee']);

        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->whereHas('employee', function ($eq) use ($term) {
                    $eq->where('name', 'like', $term)
                        ->orWhere('employee_id', 'like', $term)
                        ->orWhere('email', 'like', $term);
                })->orWhereHas('license', function ($lq) use ($term) {
                    $lq->where('software_name', 'like', $term)
                        ->orWhere('license_key', 'like', $term);
                })->orWhere('device_info', 'like', $term);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('license_id')) {
            $query->where('license_id', $request->input('license_id'));
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->input('employee_id'));
        }

        $assignments = $query->latest('assigned_date')->paginate(10)->withQueryString();
        $licenses = License::orderBy('software_name')->get();
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        return view('assignments.index', [
            'assignments' => $assignments,
            'licenses' => $licenses,
            'employees' => $employees,
            'selectedStatus' => $request->input('status'),
            'selectedLicense' => $request->input('license_id'),
            'selectedEmployee' => $request->input('employee_id'),
            'searchTerm' => $request->input('search'),
        ]);
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create(Request $request): View
    {
        $licenses = License::with(['vendor', 'activeAssignments'])->orderBy('software_name')->get();
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        return view('assignments.create', [
            'licenses' => $licenses,
            'employees' => $employees,
            'preselectedLicenseId' => $request->input('license_id'),
            'preselectedEmployeeId' => $request->input('employee_id'),
        ]);
    }

    /**
     * Store a newly created assignment in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'license_id' => ['required', 'exists:licenses,id'],
            'employee_id' => ['required', 'exists:employees,id'],
            'assigned_date' => ['required', 'date'],
            'device_info' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $license = License::findOrFail($validated['license_id']);

        // Check if employee already has an active assignment for this license
        $existing = Assignment::where('license_id', $license->id)
            ->where('employee_id', $validated['employee_id'])
            ->where('status', 'active')
            ->first();

        if ($existing) {
            return back()->withInput()->withErrors([
                'employee_id' => 'This employee already has an active seat assigned for this license.',
            ]);
        }

        // Check available seats
        if ($license->available_seats_count <= 0) {
            return back()->withInput()->withErrors([
                'license_id' => "License '{$license->software_name}' has no available seats remaining ({$license->assigned_seats_count}/{$license->total_seats} used).",
            ]);
        }

        $assignment = Assignment::create([
            ...$validated,
            'status' => 'active',
            'revoked_date' => null,
        ]);

        return redirect()->route('assignments.show', $assignment)
            ->with('success', 'License successfully assigned to employee.');
    }

    /**
     * Display the specified assignment.
     */
    public function show(Assignment $assignment): View
    {
        $assignment->load(['license.vendor', 'employee']);

        return view('assignments.show', [
            'assignment' => $assignment,
        ]);
    }

    /**
     * Show the form for editing the specified assignment.
     */
    public function edit(Assignment $assignment): View
    {
        $licenses = License::with('vendor')->orderBy('software_name')->get();
        $employees = Employee::orderBy('name')->get();

        return view('assignments.edit', [
            'assignment' => $assignment,
            'licenses' => $licenses,
            'employees' => $employees,
        ]);
    }

    /**
     * Update the specified assignment in storage.
     */
    public function update(Request $request, Assignment $assignment): RedirectResponse
    {
        $validated = $request->validate([
            'license_id' => ['required', 'exists:licenses,id'],
            'employee_id' => ['required', 'exists:employees,id'],
            'assigned_date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:active,revoked'],
            'revoked_date' => ['nullable', 'date', 'after_or_equal:assigned_date'],
            'device_info' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($validated['status'] === 'revoked' && empty($validated['revoked_date'])) {
            $validated['revoked_date'] = Carbon::now()->toDateString();
        } elseif ($validated['status'] === 'active') {
            $validated['revoked_date'] = null;
        }

        $assignment->update($validated);

        return redirect()->route('assignments.show', $assignment)
            ->with('success', 'Assignment record updated successfully.');
    }

    /**
     * Remove the specified assignment from storage.
     */
    public function destroy(Assignment $assignment): RedirectResponse
    {
        $assignment->delete();

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment record deleted successfully.');
    }
}
