@extends('layouts.app')

@section('title', 'Assign License Seat')

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1>Assign License Seat</h1>
        <p class="page-subtitle">Allocate an available software license seat to an active company employee.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('assignments.index') }}" class="btn btn-secondary">
            &larr; Back to Assignments
        </a>
    </div>
</div>

<div class="panel-card" style="max-width: 800px; margin: 0 auto;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
            <span>Assignment Allocation</span>
        </div>
    </div>
    <div class="panel-body">
        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf

            <!-- Software License Selection -->
            <div class="form-group">
                <label class="form-label">Software License <span class="required">*</span></label>
                <select name="license_id" class="form-select @error('license_id') is-invalid @enderror" required>
                    <option value="">Select a software license...</option>
                    @foreach ($licenses as $lic)
                        @php
                            $available = $lic->available_seats_count;
                            $isSelected = old('license_id', $preselectedLicenseId) == $lic->id;
                        @endphp
                        <option value="{{ $lic->id }}" {{ $isSelected ? 'selected' : '' }} {{ $available <= 0 && !$isSelected ? 'disabled' : '' }}>
                            {{ $lic->software_name }} ({{ $lic->vendor->name }}) &mdash; {{ $available }} available of {{ $lic->total_seats }} seats {{ $available <= 0 ? '[FULL]' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('license_id') <div class="form-error">{{ $message }}</div> @enderror
                <div class="form-hint">Only licenses with available remaining capacity can be allocated.</div>
            </div>

            <!-- Employee Selection -->
            <div class="form-group">
                <label class="form-label">Employee Recipient <span class="required">*</span></label>
                <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                    <option value="">Select an employee...</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}" {{ old('employee_id', $preselectedEmployeeId) == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }} ({{ $emp->employee_id }}) &mdash; {{ $emp->department }} &bull; {{ $emp->job_title }}
                        </option>
                    @endforeach
                </select>
                @error('employee_id') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-grid-2">
                <!-- Assigned Date -->
                <div class="form-group">
                    <label class="form-label">Date Assigned <span class="required">*</span></label>
                    <input type="date" name="assigned_date" class="form-input @error('assigned_date') is-invalid @enderror" value="{{ old('assigned_date', date('Y-m-d')) }}" required>
                    @error('assigned_date') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <!-- Hardware Device / Station Info -->
                <div class="form-group">
                    <label class="form-label">Hardware Device / Workstation Info</label>
                    <input type="text" name="device_info" class="form-input @error('device_info') is-invalid @enderror" placeholder="e.g. MacBook Pro 16 (Asset IT-104)" value="{{ old('device_info') }}">
                    @error('device_info') <div class="form-error">{{ $message }}</div> @enderror
                    <div class="form-hint">Hardware device ID, laptop serial, or cloud VM name.</div>
                </div>
            </div>

            <!-- Assignment Notes -->
            <div class="form-group">
                <label class="form-label">Allocation Notes & Justification</label>
                <textarea name="notes" rows="3" class="form-textarea @error('notes') is-invalid @enderror" placeholder="Project name, manager approval, or temporary assignment details...">{{ old('notes') }}</textarea>
                @error('notes') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Allocate Seat</button>
            </div>
        </form>
    </div>
</div>
@endsection
