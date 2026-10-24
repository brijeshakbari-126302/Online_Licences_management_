@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Reports & License Analytics</h1>
        <p class="page-subtitle">Executive financial audit, shelfware waste tracking, department allocation, and data exports.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('reports.export', 'licenses') }}" class="btn btn-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Export Licenses CSV
        </a>
        <a href="{{ route('reports.export', 'assignments') }}" class="btn btn-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Export All Data
        </a>
    </div>
</div>

<!-- Financial & Efficiency KPIs -->
<div class="kpi-grid">
    <!-- Total Annual Spend -->
    <div class="kpi-card accent-primary">
        <div class="kpi-top">
            <span class="kpi-label">Annual Software Investment</span>
            <div class="kpi-icon-wrapper primary">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            </div>
        </div>
        <div class="kpi-value">${{ number_format($annualSpend, 2) }}</div>
        <div class="kpi-meta">
            <span>Committed across {{ $totalLicenses }} active subscriptions</span>
        </div>
    </div>

    <!-- Seat Utilization Rate -->
    <div class="kpi-card accent-success">
        <div class="kpi-top">
            <span class="kpi-label">Global Utilization Rate</span>
            <div class="kpi-icon-wrapper success">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"></path></svg>
            </div>
        </div>
        <div class="kpi-value">{{ $utilizationRate }}%</div>
        <div class="kpi-meta">
            <span>{{ $assignedSeats }} deployed of {{ $totalSeats }} total licensed seats</span>
        </div>
    </div>

    <!-- Shelfware (Unused Spend) -->
    <div class="kpi-card accent-warning">
        <div class="kpi-top">
            <span class="kpi-label">Idle Capacity (Shelfware)</span>
            <div class="kpi-icon-wrapper warning">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
        </div>
        <div class="kpi-value">${{ number_format($wastedSpend, 2) }}</div>
        <div class="kpi-meta">
            <span>Est. annual cost of {{ $unassignedSeats }} unassigned seats</span>
        </div>
    </div>

    <!-- Expirations Requiring Attention -->
    <div class="kpi-card accent-danger">
        <div class="kpi-top">
            <span class="kpi-label">Renewal Attention</span>
            <div class="kpi-icon-wrapper danger">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path></svg>
            </div>
        </div>
        <div class="kpi-value">{{ $expiredCount + $expiring30Days }}</div>
        <div class="kpi-meta">
            <span>{{ $expiredCount }} expired &bull; {{ $expiring30Days }} renew in 30 days</span>
        </div>
    </div>
</div>

<!-- Reports Grid -->
<div class="dashboard-grid-2">
    <!-- Spend by Vendor -->
    <div class="panel-card">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>Vendor Spend & Asset Distribution</span>
            </div>
            <a href="{{ route('vendors.index') }}" class="btn btn-secondary btn-sm">Manage Vendors</a>
        </div>
        <div class="panel-body" style="padding: 0;">
            <div class="table-responsive" style="border: none; border-radius: 0;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Software Vendor</th>
                            <th>Licenses</th>
                            <th>Total Seats</th>
                            <th style="text-align: right;">Est. Annual Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendorBreakdown as $vb)
                            <tr>
                                <td>
                                    <div class="table-cell-main">{{ $vb['name'] }}</div>
                                </td>
                                <td>{{ $vb['license_count'] }} apps</td>
                                <td>{{ $vb['total_seats'] }}</td>
                                <td style="text-align: right;">
                                    <span style="font-weight: 700; color: var(--text-main);">${{ number_format($vb['annual_spend'], 2) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-dim); padding: 2rem;">No vendor data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Category Distribution & Shelfware Analysis -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Category Breakdown -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    <span>Spend by Software Category</span>
                </div>
            </div>
            <div class="panel-body">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach ($categoryBreakdown as $cat)
                        @php
                            $pct = $totalSeats > 0 ? round(($cat->seats / $totalSeats) * 100) : 0;
                        @endphp
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem; font-size: 0.86rem;">
                                <span style="font-weight: 600; color: var(--text-main);">{{ $cat->category ?? 'General' }}</span>
                                <span style="color: var(--text-muted); font-size: 0.8rem;">{{ $cat->count }} apps &bull; {{ $cat->seats }} seats ({{ $pct }}%)</span>
                            </div>
                            <div class="seat-meter-bar">
                                <div class="seat-meter-fill normal" style="width: {{ min(100, $pct) }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Export Center Card -->
        <div class="panel-card">
            <div class="panel-header">
                <div class="panel-title">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Instant CSV Data Exports</span>
                </div>
            </div>
            <div class="panel-body" style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('reports.export', 'licenses') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    Download Software Licenses Catalog (.CSV)
                </a>
                <a href="{{ route('reports.export', 'assignments') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                    Download Seat Allocations Audit (.CSV)
                </a>
                <a href="{{ route('reports.export', 'vendors') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                    Download Software Vendors Directory (.CSV)
                </a>
                <a href="{{ route('reports.export', 'employees') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                    Download Corporate Staff Directory (.CSV)
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Department Seat Allocation Section -->
<div class="panel-card" style="margin-top: 1.5rem;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <span>Departmental Software Utilization</span>
        </div>
    </div>
    <div class="panel-body" style="padding: 0;">
        <div class="table-responsive" style="border: none; border-radius: 0;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Active Staff Count</th>
                        <th>Allocated License Seats</th>
                        <th>Avg. Licenses Per Staff</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departmentBreakdown as $dept)
                        @php
                            $avg = $dept['staff_count'] > 0 ? round($dept['seats_count'] / $dept['staff_count'], 1) : 0;
                        @endphp
                        <tr>
                            <td>
                                <div class="table-cell-main">{{ $dept['department'] }}</div>
                            </td>
                            <td>{{ $dept['staff_count'] }} employees</td>
                            <td>
                                <span class="badge badge-primary">{{ $dept['seats_count'] }} seats</span>
                            </td>
                            <td>{{ $avg }} apps / employee</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-dim); padding: 2rem;">No department allocation data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
