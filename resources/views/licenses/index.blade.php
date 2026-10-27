@extends('layouts.app')

@section('title', 'Software Catalog')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Software License Catalog</h1>
        <p class="page-subtitle">Browse, discover, and manage licensed tools, seat capacities, and activation keys.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('licenses.create') }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Software License
        </a>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="toolbar-card">
    <form action="{{ route('licenses.index') }}" method="GET" class="filter-form">
        <div class="search-input-wrap">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" name="search" class="form-input" placeholder="Search software, key, or vendor..." value="{{ $searchTerm }}">
        </div>

        <select name="status" class="form-select" style="width: auto; min-width: 140px;">
            <option value="">All Statuses</option>
            <option value="active" {{ $selectedStatus === 'active' ? 'selected' : '' }}>Active</option>
            <option value="expiring_soon" {{ $selectedStatus === 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
            <option value="expired" {{ $selectedStatus === 'expired' ? 'selected' : '' }}>Expired</option>
            <option value="suspended" {{ $selectedStatus === 'suspended' ? 'selected' : '' }}>Suspended</option>
        </select>

        <select name="vendor_id" class="form-select" style="width: auto; min-width: 160px;">
            <option value="">All Vendors</option>
            @foreach ($vendors as $vendor)
                <option value="{{ $vendor->id }}" {{ $selectedVendor == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
            @endforeach
        </select>

        <select name="category" class="form-select" style="width: auto; min-width: 140px;">
            <option value="">All Categories</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}" {{ $selectedCategory === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-secondary">Filter</button>

        @if ($searchTerm || $selectedStatus || $selectedVendor || $selectedCategory)
            <a href="{{ route('licenses.index') }}" class="btn btn-secondary btn-sm" style="color: var(--text-dim);">Clear</a>
        @endif
    </form>
</div>

<!-- License Table -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Software Application</th>
                <th>Vendor</th>
                <th>License Key / ID</th>
                <th>Seat Capacity</th>
                <th>Cost & Billing</th>
                <th>Expiration</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($licenses as $license)
                @php
                    $assignedCount = $license->activeAssignments->count();
                    $utilization = $license->total_seats > 0 ? round(($assignedCount / $license->total_seats) * 100) : 0;
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('licenses.show', $license) }}" class="table-cell-main">
                            {{ $license->software_name }}
                        </a>
                        <div class="table-cell-sub">
                            <span class="badge badge-primary" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">{{ $license->category ?? 'General' }}</span>
                            <span style="margin-left: 0.35rem;">{{ $license->license_type }}</span>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('vendors.show', $license->vendor) }}" style="color: var(--text-muted); font-weight: 500;">
                            {{ $license->vendor->name }}
                        </a>
                    </td>
                    <td>
                        @if ($license->license_key)
                            <code class="license-key-tag">{{ Str::limit($license->license_key, 18) }}</code>
                        @else
                            <span style="color: var(--text-dim); font-size: 0.8rem;">Auto-provisioned</span>
                        @endif
                    </td>
                    <td>
                        <div class="seat-meter">
                            <div class="seat-meter-info">
                                <span><strong>{{ $assignedCount }}</strong> of {{ $license->total_seats }}</span>
                                <span>{{ $utilization }}%</span>
                            </div>
                            <div class="seat-meter-bar">
                                <div class="seat-meter-fill {{ $utilization >= 90 ? 'warning' : 'normal' }}" style="width: {{ min(100, $utilization) }}%;"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="table-cell-main">${{ number_format($license->cost_per_seat, 2) }} <span style="font-size: 0.75rem; color: var(--text-dim); font-weight: 400;">/ seat</span></div>
                        <div class="table-cell-sub">{{ ucfirst($license->billing_cycle) }}</div>
                    </td>
                    <td>
                        @if ($license->expiration_date)
                            <div style="font-weight: 500; color: {{ $license->isExpired() ? '#dc2626' : ($license->isExpiringSoon() ? '#d97706' : 'var(--text-muted)') }};">
                                {{ $license->expiration_date->format('M d, Y') }}
                            </div>
                            <div class="table-cell-sub">
                                @if ($license->isExpired())
                                    Expired {{ $license->expiration_date->diffForHumans() }}
                                @else
                                    {{ $license->expiration_date->diffInDays(now()) }} days left
                                @endif
                            </div>
                        @else
                            <span style="color: var(--text-dim); font-size: 0.82rem;">Perpetual / Lifetime</span>
                        @endif
                    </td>
                    <td>
                        @if ($license->status === 'active')
                            <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                        @elseif ($license->status === 'expiring_soon')
                            <span class="badge badge-expiring"><span class="badge-dot"></span> Expiring</span>
                        @elseif ($license->status === 'expired')
                            <span class="badge badge-expired"><span class="badge-dot"></span> Expired</span>
                        @else
                            <span class="badge badge-neutral"><span class="badge-dot"></span> {{ ucfirst($license->status) }}</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; align-items: center; gap: 0.35rem;">
                            <a href="{{ route('licenses.show', $license) }}" class="btn btn-secondary btn-icon" title="View Details">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="{{ route('licenses.edit', $license) }}" class="btn btn-secondary btn-icon" title="Edit License">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            </div>
                            <div class="empty-state-title">No licenses found</div>
                            <div class="empty-state-desc">Try clearing the search filters or add a new software license to get started.</div>
                            <a href="{{ route('licenses.create') }}" class="btn btn-primary btn-sm">Add Software License</a>
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
