@extends('layouts.app')

@section('title', 'Seat Assignment Details')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <a href="{{ route('assignments.index') }}" class="btn btn-secondary btn-icon" title="Back to seat assignments">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
            <h1>Assignment Record</h1>
        </div>
        <p class="page-subtitle">{{ $assignment->license->software_name }} allocated to {{ $assignment->employee->name }}</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('assignments.edit', $assignment) }}" class="btn btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            Edit / Revoke Seat
        </a>
    </div>
</div>

<!-- Hero Card -->
<div class="detail-hero-card">
    <div class="detail-hero-header">
        <div>
            <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.35rem;">
                @if ($assignment->status === 'active')
                    <span class="badge badge-active"><span class="badge-dot"></span> Active Allocation</span>
                @else
                    <span class="badge badge-neutral"><span class="badge-dot"></span> Revoked License</span>
                @endif
                <span class="badge badge-primary">{{ $assignment->license->license_type }}</span>
            </div>
            <div style="font-size: 1.35rem; font-weight: 800; color: var(--text-main);">
                <a href="{{ route('licenses.show', $assignment->license) }}" style="color: var(--text-main);">{{ $assignment->license->software_name }}</a>
                &rarr;
                <a href="{{ route('employees.show', $assignment->employee) }}" style="color: var(--primary);">{{ $assignment->employee->name }}</a>
            </div>
        </div>

        <div>
            @if ($assignment->license->license_key)
                <div style="font-size: 0.74rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase; margin-bottom: 0.25rem;">Software Key</div>
                <code class="license-key-tag" style="font-size: 0.9rem;">{{ $assignment->license->license_key }}</code>
            @endif
        </div>
    </div>

    <div class="detail-meta-grid">
        <div class="meta-item">
            <span class="meta-item-label">Assigned Date</span>
            <span class="meta-item-value">{{ $assignment->assigned_date ? $assignment->assigned_date->format('M d, Y') : '-' }}</span>
            <span style="font-size: 0.76rem; color: var(--text-dim);">{{ $assignment->assigned_date ? $assignment->assigned_date->diffForHumans() : '' }}</span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Revoked Date</span>
            <span class="meta-item-value" style="color: {{ $assignment->revoked_date ? '#dc2626' : 'var(--text-dim)' }};">
                {{ $assignment->revoked_date ? $assignment->revoked_date->format('M d, Y') : 'Active (Not Revoked)' }}
            </span>
            @if ($assignment->revoked_date)
                <span style="font-size: 0.76rem; color: var(--text-dim);">Returned {{ $assignment->revoked_date->diffForHumans() }}</span>
            @endif
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Hardware Device / Workstation</span>
            <span class="meta-item-value">
                @if ($assignment->device_info)
                    <code class="license-key-tag">{{ $assignment->device_info }}</code>
                @else
                    <span style="color: var(--text-dim);">Unspecified workstation</span>
                @endif
            </span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Publisher Vendor</span>
            <span class="meta-item-value">
                <a href="{{ route('vendors.show', $assignment->license->vendor) }}" style="color: var(--text-muted);">
                    {{ $assignment->license->vendor->name }}
                </a>
            </span>
        </div>
    </div>
</div>

<!-- Linked Details Grid -->
<div class="form-grid-2" style="margin-bottom: 2rem;">
    <!-- License Snapshot -->
    <div class="panel-card">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3M4 12v-2h16v2M4 17v-2h16v2M4 20h16"></path><circle cx="8" cy="8.5" r="1.5"></circle></svg>
                <span>License Summary</span>
            </div>
            <a href="{{ route('licenses.show', $assignment->license) }}" class="btn btn-secondary btn-sm">View Full License</a>
        </div>
        <div class="panel-body">
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-dim); font-size: 0.88rem;">Application Name</span>
                    <strong style="color: var(--text-main);">{{ $assignment->license->software_name }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-dim); font-size: 0.88rem;">License Type</span>
                    <span>{{ $assignment->license->license_type }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-dim); font-size: 0.88rem;">Seat Utilization</span>
                    <span>{{ $assignment->license->assigned_seats_count }} / {{ $assignment->license->total_seats }} used</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-dim); font-size: 0.88rem;">License Expiration</span>
                    <span style="color: {{ $assignment->license->isExpired() ? '#f87171' : 'var(--text-main)' }};">
                        {{ $assignment->license->expiration_date ? $assignment->license->expiration_date->format('M d, Y') : 'Perpetual' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Snapshot -->
    <div class="panel-card">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                <span>Assigned Staff Profile</span>
            </div>
            <a href="{{ route('employees.show', $assignment->employee) }}" class="btn btn-secondary btn-sm">View Employee</a>
        </div>
        <div class="panel-body">
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-dim); font-size: 0.88rem;">Staff Name</span>
                    <strong style="color: var(--text-main);">{{ $assignment->employee->name }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-dim); font-size: 0.88rem;">Badge ID</span>
                    <code class="license-key-tag">{{ $assignment->employee->employee_id }}</code>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-dim); font-size: 0.88rem;">Department</span>
                    <span>{{ $assignment->employee->department }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-dim); font-size: 0.88rem;">Email</span>
                    <a href="mailto:{{ $assignment->employee->email }}" style="color: var(--primary-light);">{{ $assignment->employee->email }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Allocation Notes -->
@if ($assignment->notes)
    <div class="panel-card">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                <span>Allocation Notes</span>
            </div>
        </div>
        <div class="panel-body">
            <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.6; white-space: pre-line;">{{ $assignment->notes }}</p>
        </div>
    </div>
@endif
@endsection
