@extends('layouts.app')

@section('title', 'Edit Assignment Record')

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1>Edit License Assignment</h1>
        <p class="page-subtitle">Update seat status, record hardware changes, or revoke the assigned license.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-secondary">
            &larr; View Details
        </a>
    </div>
</div>

<div class="panel-card" style="max-width: 800px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <span>Update Assignment Details</span>
        </div>
        <div>
            @if ($assignment->status === 'active')
                <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
            @else
                <span class="badge badge-neutral"><span class="badge-dot"></span> Revoked</span>
            @endif
        </div>
    </div>
    <div class="panel-body">
        <form action="{{ route('assignments.update', $assignment) }}" method="POST" novalidate id="assignment-edit-form">
            @csrf
            @method('PUT')

            <!-- Software License Selection -->
            <div class="form-group">
                <label class="form-label">Software License <span class="required">*</span></label>
                <select name="license_id" class="form-select @error('license_id') is-invalid @enderror" required>
                    @foreach ($licenses as $lic)
                        <option value="{{ $lic->id }}" {{ old('license_id', $assignment->license_id) == $lic->id ? 'selected' : '' }}>
                            {{ $lic->software_name }} ({{ $lic->vendor->name }})
                        </option>
                    @endforeach
                </select>
                @error('license_id') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <!-- Employee Selection -->
            <div class="form-group">
                <label class="form-label">Employee Staff Member <span class="required">*</span></label>
                <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id', $assignment->employee_id) == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }} ({{ $emp->employee_id }}) &mdash; {{ $emp->department }}
                        </option>
                    @endforeach
                </select>
                @error('employee_id') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-grid-3">
                <!-- Assigned Date -->
                <div class="form-group">
                    <label class="form-label">Date Assigned <span class="required">*</span></label>
                    <input type="date" name="assigned_date" class="form-input @error('assigned_date') is-invalid @enderror" value="{{ old('assigned_date', $assignment->assigned_date ? $assignment->assigned_date->format('Y-m-d') : '') }}" required>
                    @error('assigned_date') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <!-- Assignment Status -->
                <div class="form-group">
                    <label class="form-label">Seat Status <span class="required">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required onchange="toggleRevokedDate(this.value)">
                        <option value="active" {{ old('status', $assignment->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="revoked" {{ old('status', $assignment->status) === 'revoked' ? 'selected' : '' }}>Revoked / Returned</option>
                    </select>
                    @error('status') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <!-- Revoked Date -->
                <div class="form-group" id="revoked-date-group">
                    <label class="form-label">Date Revoked</label>
                    <input type="date" name="revoked_date" class="form-input @error('revoked_date') is-invalid @enderror" value="{{ old('revoked_date', $assignment->revoked_date ? $assignment->revoked_date->format('Y-m-d') : '') }}">
                    @error('revoked_date') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Hardware Device Info -->
            <div class="form-group">
                <label class="form-label">Hardware Device / Workstation Info</label>
                <input type="text" name="device_info" class="form-input @error('device_info') is-invalid @enderror" value="{{ old('device_info', $assignment->device_info) }}">
                @error('device_info') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label class="form-label">Allocation & Revocation Notes</label>
                <textarea name="notes" rows="3" class="form-textarea @error('notes') is-invalid @enderror">{{ old('notes', $assignment->notes) }}</textarea>
                @error('notes') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to permanently delete this assignment record?')) { document.getElementById('delete-assignment-form').submit(); }">
                        Delete Record
                    </button>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Assignment</button>
                </div>
            </div>
        </form>

        <form id="delete-assignment-form" action="{{ route('assignments.destroy', $assignment) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
