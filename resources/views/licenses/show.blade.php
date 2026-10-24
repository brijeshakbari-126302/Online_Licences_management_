@extends('layouts.app')

@section('title', $license->software_name . ' - Software License')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <a href="{{ route('licenses.index') }}" class="btn btn-secondary btn-icon" title="Back to licenses">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
            <h1>{{ $license->software_name }}</h1>
        </div>
        <p class="page-subtitle">Provided by <a href="{{ route('vendors.show', $license->vendor) }}" style="color: var(--primary); font-weight: 600;">{{ $license->vendor->name }}</a> &bull; {{ $license->license_type }}</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('assignments.create', ['license_id' => $license->id]) }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
            Assign Seat to Staff
        </a>
        <a href="{{ route('licenses.edit', $license) }}" class="btn btn-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            Edit License
        </a>
    </div>
</div>

<!-- Hero Information Card -->
<div class="detail-hero-card">
    <div class="detail-hero-header">
        <div>
            <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.5rem;">
                <span class="badge badge-primary">{{ $license->category ?? 'Software Asset' }}</span>
                @if ($license->status === 'active')
                    <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                @elseif ($license->status === 'expiring_soon')
                    <span class="badge badge-expiring"><span class="badge-dot"></span> Expiring Soon</span>
                @elseif ($license->status === 'expired')
                    <span class="badge badge-expired"><span class="badge-dot"></span> Expired</span>
                @else
                    <span class="badge badge-neutral"><span class="badge-dot"></span> {{ ucfirst($license->status) }}</span>
                @endif
            </div>
            <div style="font-size: 1.15rem; color: var(--text-muted);">
                Vendor Publisher: <a href="{{ route('vendors.show', $license->vendor) }}" style="color: var(--text-main); font-weight: 600;">{{ $license->vendor->name }}</a>
            </div>
        </div>

        <div style="min-width: 200px;">
            <div class="seat-meter-info" style="margin-bottom: 0.35rem;">
                <span style="font-weight: 600; color: var(--text-main);">Seats In Use: {{ $license->assigned_seats_count }} / {{ $license->total_seats }}</span>
                <span style="font-weight: 700; color: var(--primary);">{{ $license->utilization_percentage }}%</span>
            </div>
            <div class="seat-meter-bar" style="height: 10px;">
                <div class="seat-meter-fill {{ $license->utilization_percentage >= 90 ? 'warning' : 'normal' }}" style="width: {{ $license->utilization_percentage }}%;"></div>
            </div>
            <div style="font-size: 0.78rem; color: var(--text-dim); margin-top: 0.35rem;">{{ $license->available_seats_count }} remaining seats available for assignment</div>
        </div>
    </div>

    <div class="detail-meta-grid">
        <div class="meta-item">
            <span class="meta-item-label">License Key / Serial</span>
            <span class="meta-item-value">
                @if ($license->license_key)
                    <code class="license-key-tag" style="font-size: 0.85rem;">{{ $license->license_key }}</code>
                @else
                    <span style="color: var(--text-dim);">Cloud Single Sign-On</span>
                @endif
            </span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Cost Per Seat</span>
            <span class="meta-item-value">${{ number_format($license->cost_per_seat, 2) }} {{ $license->currency }}</span>
            <span style="font-size: 0.76rem; color: var(--text-dim);">Billed {{ ucfirst($license->billing_cycle) }}</span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Total Agreement Spend</span>
            <span class="meta-item-value" style="color: var(--primary);">${{ number_format($license->total_cost, 2) }} {{ $license->currency }}</span>
            <span style="font-size: 0.76rem; color: var(--text-dim);">For {{ $license->total_seats }} total seats</span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Purchase Date</span>
            <span class="meta-item-value">{{ $license->purchase_date ? $license->purchase_date->format('M d, Y') : '-' }}</span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Expiration / Renewal</span>
            <span class="meta-item-value" style="color: {{ $license->isExpired() ? '#dc2626' : ($license->isExpiringSoon() ? '#d97706' : 'var(--text-main)') }};">
                {{ $license->expiration_date ? $license->expiration_date->format('M d, Y') : 'Never (Perpetual)' }}
            </span>
            @if ($license->expiration_date)
                <span style="font-size: 0.76rem; color: var(--text-dim);">
                    @if ($license->isExpired())
                        Expired {{ $license->expiration_date->diffForHumans() }}
                    @else
                        {{ $license->expiration_date->diffInDays(now()) }} days remaining
                    @endif
                </span>
            @endif
        </div>
    </div>
</div>

<!-- License Notes -->
@if ($license->notes)
    <div class="panel-card" style="margin-bottom: 2rem;">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                <span>Contract Provisions & Notes</span>
            </div>
        </div>
        <div class="panel-body">
            <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.6; white-space: pre-line;">{{ $license->notes }}</p>
        </div>
    </div>
@endif

<!-- Allocated Employee Seats Table -->
<div class="panel-card">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <span>Allocated Seat Members ({{ $license->assignments->count() }})</span>
        </div>
        <a href="{{ route('assignments.create', ['license_id' => $license->id]) }}" class="btn btn-primary btn-sm">
            + Assign Seat
        </a>
    </div>
    <div class="panel-body" style="padding: 0;">
        @if ($license->assignments->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                </div>
                <div class="empty-state-title">No employees assigned yet</div>
                <div class="empty-state-desc">You have {{ $license->total_seats }} seats available to distribute to team members.</div>
                <a href="{{ route('assignments.create', ['license_id' => $license->id]) }}" class="btn btn-primary btn-sm">Assign First Seat</a>
            </div>
        @else
            <div class="table-responsive" style="border: none; border-radius: 0;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Staff Member</th>
                            <th>Department</th>
                            <th>Device / Station</th>
                            <th>Assigned Date</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($license->assignments as $assignment)
                            <tr>
                                <td>
                                    <a href="{{ route('employees.show', $assignment->employee) }}" class="table-cell-main">
                                        {{ $assignment->employee->name }}
                                    </a>
                                    <div class="table-cell-sub">{{ $assignment->employee->email }} &bull; {{ $assignment->employee->employee_id }}</div>
                                </td>
                                <td>{{ $assignment->employee->department }}</td>
                                <td>
                                    @if ($assignment->device_info)
                                        <span style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--text-muted);">{{ $assignment->device_info }}</span>
                                    @else
                                        <span style="color: var(--text-dim); font-size: 0.8rem;">Unspecified</span>
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
