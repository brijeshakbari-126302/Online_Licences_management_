@extends('layouts.app')

@section('title', 'Edit Staff Member: ' . $employee->name)

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1>Edit Employee Record</h1>
        <p class="page-subtitle">Update department placement, role designation, or employment status.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('employees.show', $employee) }}" class="btn btn-secondary">
            &larr; View Profile
        </a>
    </div>
</div>

<div class="panel-card" style="max-width: 800px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <span>Update {{ $employee->name }}</span>
        </div>
        <div>
            @if ($employee->status === 'active')
                <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
            @elseif ($employee->status === 'on_leave')
                <span class="badge badge-expiring"><span class="badge-dot"></span> On Leave</span>
            @else
                <span class="badge badge-neutral"><span class="badge-dot"></span> Inactive</span>
            @endif
        </div>
    </div>
    <div class="panel-body">
        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Employee ID <span class="required">*</span></label>
                    <input type="text" name="employee_id" class="form-input @error('employee_id') is-invalid @enderror" value="{{ old('employee_id', $employee->employee_id) }}" style="font-family: var(--font-mono);" required>
                    @error('employee_id') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name', $employee->name) }}" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Corporate Email Address <span class="required">*</span></label>
                    <input type="email" name="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email', $employee->email) }}" required>
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Direct Phone / Mobile</label>
                    <input type="text" name="phone" class="form-input @error('phone') is-invalid @enderror" value="{{ old('phone', $employee->phone) }}">
                    @error('phone') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Department <span class="required">*</span></label>
                    <select name="department" class="form-select @error('department') is-invalid @enderror" required>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept }}" {{ old('department', $employee->department) === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                    @error('department') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Job Title / Designation <span class="required">*</span></label>
                    <input type="text" name="job_title" class="form-input @error('job_title') is-invalid @enderror" value="{{ old('job_title', $employee->job_title) }}" required>
                    @error('job_title') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Employment Status <span class="required">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $employee->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $employee->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ old('status', $employee->status) === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                    @error('status') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this employee record? Any assigned software seats will be unlinked.')) { document.getElementById('delete-employee-form').submit(); }">
                        Delete Employee
                    </button>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('employees.show', $employee) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Record</button>
                </div>
            </div>
        </form>

        <form id="delete-employee-form" action="{{ route('employees.destroy', $employee) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
