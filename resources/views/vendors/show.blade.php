@extends('layouts.app')

@section('title', $vendor->name . ' - Software Vendor')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <a href="{{ route('vendors.index') }}" class="btn btn-secondary btn-icon" title="Back to vendors">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
            <h1>{{ $vendor->name }}</h1>
        </div>
        <p class="page-subtitle">Software Publisher Profile & Associated Enterprise Licenses</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('licenses.create', ['vendor_id' => $vendor->id]) }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add License for Vendor
        </a>
        <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            Edit Vendor
        </a>
    </div>
</div>

<!-- Vendor Hero Card -->
<div class="detail-hero-card">
    <div class="detail-hero-header">
        <div>
            <div style="font-size: 1.5rem; font-weight: 800; color: #ffffff; margin-bottom: 0.35rem;">{{ $vendor->name }}</div>
            <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                @if ($vendor->website)
                    <a href="{{ $vendor->website }}" target="_blank" rel="noopener noreferrer" style="color: var(--primary-light); font-size: 0.9rem; font-weight: 500;">
                        {{ $vendor->website }} &nearr;
                    </a>
                @endif
                @if ($vendor->support_url)
                    <span style="color: var(--text-dim);">&bull;</span>
                    <a href="{{ $vendor->support_url }}" target="_blank" rel="noopener noreferrer" style="color: #38bdf8; font-size: 0.9rem; font-weight: 500;">
                        Support Desk Portal &nearr;
                    </a>
                @endif
            </div>
        </div>

        <div>
            <span class="badge badge-primary" style="font-size: 0.9rem; padding: 0.4rem 0.9rem;">
                {{ $vendor->licenses->count() }} Licensed Products
            </span>
        </div>
    </div>

    <div class="detail-meta-grid">
        <div class="meta-item">
            <span class="meta-item-label">Account Representative</span>
            <span class="meta-item-value">{{ $vendor->contact_name ?? 'Direct Corporate Account' }}</span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Contact Email</span>
            <span class="meta-item-value">
                @if ($vendor->contact_email)
                    <a href="mailto:{{ $vendor->contact_email }}" style="color: var(--primary-light);">{{ $vendor->contact_email }}</a>
                @else
                    <span style="color: var(--text-dim);">-</span>
                @endif
            </span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Contact Phone</span>
            <span class="meta-item-value">{{ $vendor->contact_phone ?? 'Unspecified' }}</span>
        </div>

        <div class="meta-item">
            <span class="meta-item-label">Total Seats Contracted</span>
            <span class="meta-item-value" style="color: #ffffff;">{{ $vendor->licenses->sum('total_seats') }} seats</span>
        </div>
    </div>
</div>

<!-- Vendor Notes -->
@if ($vendor->notes)
    <div class="panel-card" style="margin-bottom: 2rem;">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                <span>Vendor Partnership Agreement Notes</span>
            </div>
        </div>
        <div class="panel-body">
            <p style="color: var(--text-muted); font-size: 0.92rem; line-height: 1.6; white-space: pre-line;">{{ $vendor->notes }}</p>
        </div>
    </div>
@endif

<!-- Associated Licenses Table -->
<div class="panel-card">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3M4 12v-2h16v2M4 17v-2h16v2M4 20h16"></path><circle cx="8" cy="8.5" r="1.5"></circle></svg>
            <span>Software Applications Provided by {{ $vendor->name }}</span>
        </div>
        <a href="{{ route('licenses.create', ['vendor_id' => $vendor->id]) }}" class="btn btn-primary btn-sm">
            + New License
        </a>
    </div>
    <div class="panel-body" style="padding: 0;">
        @if ($vendor->licenses->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3M4 12v-2h16v2M4 17v-2h16v2M4 20h16"></path></svg>
                </div>
                <div class="empty-state-title">No software licenses linked to this vendor</div>
                <div class="empty-state-desc">Register subscriptions or software product keys purchased through {{ $vendor->name }}.</div>
                <a href="{{ route('licenses.create', ['vendor_id' => $vendor->id]) }}" class="btn btn-primary btn-sm">Add License for Vendor</a>
            </div>
        @else
            <div class="table-responsive" style="border: none; border-radius: 0;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Software Product</th>
                            <th>License Key / ID</th>
                            <th>Seat Utilization</th>
                            <th>Billing Rate</th>
                            <th>Expiration</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendor->licenses as $lic)
                            @php
                                $assigned = $lic->activeAssignments->count();
                                $pct = $lic->total_seats > 0 ? round(($assigned / $lic->total_seats) * 100) : 0;
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('licenses.show', $lic) }}" class="table-cell-main">
                                        {{ $lic->software_name }}
                                    </a>
                                    <div class="table-cell-sub">{{ $lic->license_type }} &bull; {{ $lic->category ?? 'General' }}</div>
                                </td>
                                <td>
                                    @if ($lic->license_key)
                                        <code class="license-key-tag">{{ Str::limit($lic->license_key, 16) }}</code>
                                    @else
                                        <span style="color: var(--text-dim); font-size: 0.8rem;">Auto-provisioned</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="seat-meter">
                                        <div class="seat-meter-info">
                                            <span><strong>{{ $assigned }}</strong> / {{ $lic->total_seats }}</span>
                                            <span>{{ $pct }}%</span>
                                        </div>
                                        <div class="seat-meter-bar">
                                            <div class="seat-meter-fill {{ $pct >= 90 ? 'warning' : 'normal' }}" style="width: {{ min(100, $pct) }}%;"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-cell-main">${{ number_format($lic->cost_per_seat, 2) }}</div>
                                    <div class="table-cell-sub">{{ ucfirst($lic->billing_cycle) }}</div>
                                </td>
                                <td>
                                    @if ($lic->expiration_date)
                                        <div style="font-weight: 500; color: {{ $lic->isExpired() ? '#f87171' : ($lic->isExpiringSoon() ? '#fbbf24' : 'var(--text-muted)') }};">
                                            {{ $lic->expiration_date->format('M d, Y') }}
                                        </div>
                                    @else
                                        <span style="color: var(--text-dim); font-size: 0.8rem;">Perpetual</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($lic->status === 'active')
                                        <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                                    @elseif ($lic->status === 'expiring_soon')
                                        <span class="badge badge-expiring"><span class="badge-dot"></span> Expiring</span>
                                    @elseif ($lic->status === 'expired')
                                        <span class="badge badge-expired"><span class="badge-dot"></span> Expired</span>
                                    @else
                                        <span class="badge badge-neutral"><span class="badge-dot"></span> {{ ucfirst($lic->status) }}</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('licenses.show', $lic) }}" class="btn btn-secondary btn-sm">View Details</a>
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
