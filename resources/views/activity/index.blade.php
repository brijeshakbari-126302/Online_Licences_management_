@extends('layouts.app')

@section('title', 'Activity & Audit Log')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-title-group">
        <h1>Audit Trail & System Activity</h1>
        <p class="page-subtitle">Chronological ledger of software license assignments, revocations, and publisher agreements.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('reports.export', 'assignments') }}" class="btn btn-secondary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Export Audit Log (.CSV)
        </a>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="toolbar-card">
    <form action="{{ route('activity.index') }}" method="GET" class="filter-form">
        <span style="font-size: 0.86rem; font-weight: 600; color: var(--text-muted); margin-right: 0.5rem;">Filter Action:</span>
        <select name="filter" class="form-select" style="width: auto; min-width: 200px;" onchange="this.form.submit()">
            <option value="all" {{ $currentFilter === 'all' ? 'selected' : '' }}>All Audit Events ({{ $totalActivitiesCount }})</option>
            <option value="assignments" {{ $currentFilter === 'assignments' ? 'selected' : '' }}>Seat Allocations Only</option>
            <option value="revocations" {{ $currentFilter === 'revocations' ? 'selected' : '' }}>Seat Revocations Only</option>
            <option value="licenses" {{ $currentFilter === 'licenses' ? 'selected' : '' }}>New Licenses Registered</option>
            <option value="vendors" {{ $currentFilter === 'vendors' ? 'selected' : '' }}>Vendor Onboarding</option>
        </select>

        @if ($currentFilter !== 'all')
            <a href="{{ route('activity.index') }}" class="btn btn-secondary btn-sm" style="color: var(--text-dim);">Reset Filter</a>
        @endif
    </form>
</div>

<!-- Activity Log Stream -->
<div class="panel-card">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>Activity History Ledger</span>
        </div>
        <span style="font-size: 0.8rem; color: var(--text-dim);">Real-time tracking enabled</span>
    </div>
    <div class="panel-body" style="padding: 0;">
        <div class="table-responsive" style="border: none; border-radius: 0;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Event Type</th>
                        <th>Activity Summary</th>
                        <th>Details & Scope</th>
                        <th>Timestamp</th>
                        <th style="text-align: right;">Record Link</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $act)
                        <tr>
                            <td>
                                <span class="badge {{ $act['badge_class'] }}">
                                    <span class="badge-dot"></span>
                                    {{ $act['badge'] }}
                                </span>
                            </td>
                            <td>
                                <div class="table-cell-main">{{ $act['title'] }}</div>
                            </td>
                            <td>
                                <div style="font-size: 0.84rem; color: var(--text-muted); max-width: 480px; line-height: 1.4;">
                                    {{ $act['description'] }}
                                </div>
                            </td>
                            <td>
                                @if ($act['timestamp'] instanceof \Carbon\Carbon)
                                    <div style="font-weight: 500; color: var(--text-main);">{{ $act['timestamp']->format('M d, Y') }}</div>
                                    <div class="table-cell-sub">{{ $act['timestamp']->diffForHumans() }}</div>
                                @else
                                    <div style="font-weight: 500; color: var(--text-main);">{{ \Carbon\Carbon::parse($act['timestamp'])->format('M d, Y') }}</div>
                                    <div class="table-cell-sub">{{ \Carbon\Carbon::parse($act['timestamp'])->diffForHumans() }}</div>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ $act['link'] }}" class="btn btn-secondary btn-sm">
                                    {{ $act['link_text'] }} &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    </div>
                                    <div class="empty-state-title">No audit activities matching filter</div>
                                    <div class="empty-state-desc">Try selecting another event filter from the dropdown above.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
    {{ $activities->links() }}
</div>
@endsection
