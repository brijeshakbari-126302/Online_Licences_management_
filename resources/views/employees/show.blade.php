@extends('layouts.app')

@section('title', $employee->name . ' - Staff Profile')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-icon" title="Back to employee directory">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
            <h1>{{ $employee->name }}</h1>
        </div>
        <p class="page-subtitle">{{ $employee->job_title }} &bull; {{ $employee->department }} Department</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('assignments.create', ['employee_id' => $employee->id]) }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
            Assign Software License
        </a>
        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            Edit Profile
        </a>
    </div>
</div>

<!-- Employee Hero Card -->
<div class="detail-hero-card">
    <div class="detail-hero-header">
        <div style="display: flex; align-items: center; gap: 1.25rem;">
            <div style="width: 58px; height: 58px; border-radius: 50%; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 700; color: #ffffff; box-shadow: 0 4px 15px var(--primary-glow);">
                {{ strtoupper(substr($employee->name, 0, 1)) }}{{ strtoupper(substr(strrchr($employee->name, ' ') ?: '', 1, 1)) }}
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.25rem;">
                    <span style="font-size: 1.4rem; font-weight: 800; color: var(--text-main);">{{ $employee->name }}</span>
                    @if ($employee->status === 'active')
                        <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                    @elseif ($employee->status === 'on_leave')
                        <span class="badge badge-expiring"><span class="badge-dot"></span> On Leave</span>
                    @else
                        <span class="badge badge-neutral"><span class="badge-dot"></span> Inactive</span>
                    @endif
                </div>
                <div style="color: var(--text-muted); font-size: 0.95rem;">{{ $employee->job_title }} &bull; {{ $employee->department }}</div>
            </div>
        </div>

        <div>
            <span class="badge badge-primary" style="font-size: 0.9rem; padding: 0.4rem 0.9rem;">
                {{ $employee->activeAssignments->count() }} Active Software Seats
            </span>
        </div>
    </div>

    <div class="detail-meta-grid">
        <div class="meta-item">
            <span class="meta-item-label">Employee Identifier</span>
            <span class="meta-item-value">
                <code class="license-key-tag" style="font-size: 0.9rem;">{{ $employee->employee_id }}</code>
            </span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Corporate Email</span>
            <span class="meta-item-value">
                <a href="mailto:{{ $employee->email }}" style="color: var(--primary);">{{ $employee->email }}</a>
            </span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Phone Contact</span>
            <span class="meta-item-value">{{ $employee->phone ?? 'Not provided' }}</span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Department</span>
            <span class="meta-item-value">{{ $employee->department }}</span>
        </div>
    </div>
</div>

<!-- Assigned Licenses Table -->
<div class="panel-card">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3M4 12v-2h16v2M4 17v-2h16v2M4 20h16"></path><circle cx="8" cy="8.5" r="1.5"></circle></svg>
            <span>Assigned Software Subscriptions & Licenses</span>
        </div>
        <a href="{{ route('assignments.create', ['employee_id' => $employee->id]) }}" class="btn btn-primary btn-sm">
            + Assign Seat
        </a>
    </div>
    <div class="panel-body" style="padding: 0;">
        @if ($employee->assignments->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3M4 12v-2h16v2M4 17v-2h16v2M4 20h16"></path></svg>
                </div>
                <div class="empty-state-title">No software seats currently assigned</div>
                <div class="empty-state-desc">Assign IDEs, design tools, or corporate apps to {{ $employee->name }}.</div>
                <a href="{{ route('assignments.create', ['employee_id' => $employee->id]) }}" class="btn btn-primary btn-sm">Assign First License</a>
            </div>
        @else
            <div class="table-responsive" style="border: none; border-radius: 0;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Software Product</th>
                            <th>Publisher</th>
                            <th>License Key / Token</th>
                            <th>Assigned Hardware / Device</th>
                            <th>Assigned Date</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employee->assignments as $assignment)
                            <tr>
                                <td>
                                    <a href="{{ route('licenses.show', $assignment->license) }}" class="table-cell-main">
                                        {{ $assignment->license->software_name }}
                                    </a>
                                    <div class="table-cell-sub">{{ $assignment->license->license_type }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('vendors.show', $assignment->license->vendor) }}" style="color: var(--text-muted); font-weight: 500;">
                                        {{ $assignment->license->vendor->name }}
                                    </a>
                                </td>
                                <td>
                                    @if ($assignment->license->license_key)
                                        <code class="license-key-tag">{{ Str::limit($assignment->license->license_key, 16) }}</code>
                                    @else
                                        <span style="color: var(--text-dim); font-size: 0.8rem;">Auto-provisioned</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($assignment->device_info)
                                        <span style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--text-muted);">{{ $assignment->device_info }}</span>
                                    @else
                                        <span style="color: var(--text-dim); font-size: 0.8rem;">General Account</span>
                                    @endif
                                </td>
                                <td>{{ $assignment->assigned_date ? $assignment->assigned_date->format('M d, Y') : '-' }}</td>
                                <td>
                                    @if ($assignment->status === 'active')
                                        <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                                    @else
                                        <span class="badge badge-neutral"><span class="badge-dot"></span> Revoked</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-secondary btn-sm">Manage</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
