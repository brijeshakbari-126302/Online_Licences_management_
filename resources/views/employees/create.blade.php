@extends('layouts.app')

@section('title', 'Register Employee')

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1>Register Employee Member</h1>
        <p class="page-subtitle">Add a corporate staff member to the system directory for software seat provisioning.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
            &larr; Back to Directory
        </a>
    </div>
</div>

<div class="panel-card" style="max-width: 800px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="11" x2="19" y2="17"></line><line x1="22" y1="14" x2="16" y2="14"></line></svg>
            <span>Staff Member Information</span>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{ route('employees.store') }}" method="POST" novalidate id="employee-form">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Employee ID <span class="required">*</span></label>
                    <input type="text" name="employee_id" class="form-input @error('employee_id') is-invalid @enderror" placeholder="e.g. EMP-1025" value="{{ old('employee_id') }}" style="font-family: var(--font-mono);" required>
                    @error('employee_id') <div class="form-error">{{ $message }}</div> @enderror
                    <div class="form-hint">Unique corporate badge or payroll identifier.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" placeholder="e.g. Marcus Miller" value="{{ old('name') }}" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Corporate Email Address <span class="required">*</span></label>
                    <input type="email" name="email" class="form-input @error('email') is-invalid @enderror" placeholder="m.miller@company.com" value="{{ old('email') }}" required>
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Direct Phone / Mobile</label>
                    <input type="text" name="phone" class="form-input @error('phone') is-invalid @enderror" placeholder="+1 (555) 123-4567" value="{{ old('phone') }}">
                    @error('phone') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Department <span class="required">*</span></label>
                    <select name="department" class="form-select @error('department') is-invalid @enderror" required>
                        <option value="">Select department...</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept }}" {{ old('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                    @error('department') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Job Title / Designation <span class="required">*</span></label>
                    <input type="text" name="job_title" class="form-input @error('job_title') is-invalid @enderror" placeholder="e.g. Senior Backend Engineer" value="{{ old('job_title') }}" required>
                    @error('job_title') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Employment Status <span class="required">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ old('status') === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                    @error('status') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Employee</button>
            </div>
        </form>
    </div>
</div>
@endsection
