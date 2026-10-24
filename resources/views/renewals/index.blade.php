@extends('layouts.app')

@section('title', 'Renewals & Expirations')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Renewals & Contract Expirations</h1>
        <p class="page-subtitle">Track overdue subscriptions, upcoming contract renewals, and execute one-click license extensions.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('licenses.create') }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Software License
        </a>
    </div>
</div>

<!-- Renewal Alert KPIs -->
<div class="kpi-grid">
    <div class="kpi-card accent-danger">
        <div class="kpi-top">
            <span class="kpi-label">Expired Licenses (Overdue)</span>
            <div class="kpi-icon-wrapper danger">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            </div>
        </div>
        <div class="kpi-value">{{ $totalExpired }}</div>
        <div class="kpi-meta">
            <span>Requires immediate vendor contract renewal</span>
        </div>
    </div>

    <div class="kpi-card accent-warning">
        <div class="kpi-top">
            <span class="kpi-label">Expiring in Next 30 Days</span>
            <div class="kpi-icon-wrapper warning">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            </div>
        </div>
        <div class="kpi-value">{{ $expiringNext30 }}</div>
        <div class="kpi-meta">
            <span>Critical upcoming expiration window</span>
        </div>
    </div>

    <div class="kpi-card accent-primary">
        <div class="kpi-top">
            <span class="kpi-label">60-Day Renewal Budget Need</span>
            <div class="kpi-icon-wrapper primary">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            </div>
        </div>
        <div class="kpi-value">${{ number_format($renewalCostEstimate, 2) }}</div>
        <div class="kpi-meta">
            <span>Projected software renewal commitment</span>
        </div>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="toolbar-card">
    <form action="{{ route('renewals.index') }}" method="GET" class="filter-form">
        <div class="search-input-wrap">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" class="form-input" placeholder="Search application or publisher..." value="{{ $searchTerm }}">
        </div>

        <select name="timeframe" class="form-select" style="width: auto; min-width: 170px;">
            <option value="all_expiring" {{ $timeframe === 'all_expiring' ? 'selected' : '' }}>All Expiring & Expired</option>
            <option value="expired" {{ $timeframe === 'expired' ? 'selected' : '' }}>Expired Only</option>
            <option value="30_days" {{ $timeframe === '30_days' ? 'selected' : '' }}>Expiring in 30 Days</option>
            <option value="60_days" {{ $timeframe === '60_days' ? 'selected' : '' }}>Expiring in 60 Days</option>
            <option value="90_days" {{ $timeframe === '90_days' ? 'selected' : '' }}>Expiring in 90 Days</option>
        </select>

        <select name="vendor_id" class="form-select" style="width: auto; min-width: 160px;">
            <option value="">All Vendors</option>
            @foreach ($vendors as $v)
                <option value="{{ $v->id }}" {{ $selectedVendor == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-secondary">Filter</button>

        @if ($searchTerm || $selectedVendor || $timeframe !== 'all_expiring')
            <a href="{{ route('renewals.index') }}" class="btn btn-secondary btn-sm" style="color: var(--text-dim);">Reset</a>
        @endif
    </form>
</div>

<!-- Renewals Table -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Software Application</th>
                <th>Vendor Publisher</th>
                <th>Seats Assigned</th>
                <th>Expiration Date</th>
                <th>Status</th>
                <th>Est. Renewal Cost</th>
                <th style="text-align: right;">Quick Renew Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($licenses as $license)
                @php
                    $isExpired = $license->isExpired();
                    $isExpiringSoon = $license->isExpiringSoon();
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('licenses.show', $license) }}" class="table-cell-main">
                            {{ $license->software_name }}
                        </a>
                        <div class="table-cell-sub">{{ $license->category ?? 'Software Asset' }} &bull; {{ $license->license_type }}</div>
                    </td>
                    <td>
                        <a href="{{ route('vendors.show', $license->vendor) }}" style="color: var(--text-muted); font-weight: 500;">
                            {{ $license->vendor->name }}
                        </a>
                    </td>
                    <td>
                        {{ $license->activeAssignments->count() }} / {{ $license->total_seats }}
                        <div class="table-cell-sub">{{ $license->available_seats_count }} seats free</div>
                    </td>
                    <td>
                        @if ($license->expiration_date)
                            <div style="font-weight: 600; color: {{ $isExpired ? '#dc2626' : ($isExpiringSoon ? '#d97706' : 'var(--text-main)') }};">
                                {{ $license->expiration_date->format('M d, Y') }}
                            </div>
                            <div class="table-cell-sub">
                                @if ($isExpired)
                                    Expired {{ $license->expiration_date->diffForHumans() }}
                                @else
                                    In {{ $license->expiration_date->diffInDays(now()) }} days
                                @endif
                            </div>
                        @else
                            <span style="color: var(--text-dim);">No date (Perpetual)</span>
                        @endif
                    </td>
                    <td>
                        @if ($isExpired)
                            <span class="badge badge-expired"><span class="badge-dot"></span> Expired</span>
                        @elseif ($isExpiringSoon)
                            <span class="badge badge-expiring"><span class="badge-dot"></span> Expiring Soon</span>
                        @else
                            <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                        @endif
                    </td>
                    <td>
                        <div class="table-cell-main">${{ number_format($license->total_cost, 2) }}</div>
                        <div class="table-cell-sub">${{ number_format($license->cost_per_seat, 2) }}/seat</div>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            <!-- One-click 1 Year Extension Form -->
                            <form action="{{ route('renewals.extend', $license) }}" method="POST" onsubmit="return confirm('Renew and extend {{ addslashes($license->software_name) }} by 1 year?');">
                                @csrf
                                <input type="hidden" name="extension_type" value="1_year">
                                <button type="submit" class="btn btn-primary btn-sm" title="Extend expiration by 1 year">
                                    +1 Year
                                </button>
                            </form>

                            <!-- One-click 1 Month Extension Form -->
                            <form action="{{ route('renewals.extend', $license) }}" method="POST" onsubmit="return confirm('Extend {{ addslashes($license->software_name) }} by 1 month?');">
                                @csrf
                                <input type="hidden" name="extension_type" value="1_month">
                                <button type="submit" class="btn btn-secondary btn-sm" title="Extend expiration by 1 month">
                                    +1 Month
                                </button>
                            </form>

                            <a href="{{ route('licenses.edit', $license) }}" class="btn btn-secondary btn-icon" title="Edit Full Details">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="empty-state-title">No upcoming renewals found</div>
                            <div class="empty-state-desc">All enterprise software licenses are active and in compliance with valid expiration windows.</div>
                            <a href="{{ route('licenses.index') }}" class="btn btn-secondary btn-sm">Browse All Licenses</a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
    {{ $licenses->links() }}
</div>
@endsection
