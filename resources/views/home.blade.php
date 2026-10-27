@extends('layouts.public')

@section('title', 'Centralized Software License Catalog & Activation Portal')

@section('content')
<!-- Hero Section -->
<section class="pub-hero">
    <div class="pub-hero-badge">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
        Digital Software Catalog & Seat Activation Portal
    </div>

    <h1>
        Discover, Activate & Track Your <br>
        <span class="gradient-text">Software Licenses</span>
    </h1>

    <p class="pub-hero-subtitle">
        A unified software catalog for engineering and design teams. Browse licensed tools, activate seats on your device, and manage activation keys seamlessly.
    </p>

    <div class="pub-hero-actions">
        <a href="{{ route('licenses.index') }}" class="btn btn-primary" style="padding: 0.85rem 1.75rem; font-size: 0.95rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Browse Software Catalog &rarr;
        </a>
        <a href="{{ route('register') }}" class="btn btn-secondary" style="padding: 0.85rem 1.75rem; font-size: 0.95rem;">
            Sign In / Register Free
        </a>
    </div>

    <!-- Live System Overview Card -->
    <div class="pub-hero-preview">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; padding-bottom: 0.85rem; border-bottom: 1px solid var(--border-subtle);">
            <div style="display: flex; align-items: center; gap: 0.6rem;">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444;"></span>
                <span style="width: 10px; height: 10px; border-radius: 50%; background: #f59e0b;"></span>
                <span style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></span>
                <span style="font-size: 0.82rem; color: var(--text-dim); margin-left: 0.5rem; font-family: var(--font-mono);">licensehub-live-metrics.preview</span>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm" style="font-size: 0.78rem;">Launch Full App &nearr;</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem; text-align: left;">
            <div style="background: var(--bg-surface-hover); padding: 1.25rem; border-radius: var(--radius-md);">
                <div style="font-size: 0.76rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase;">Active Subscriptions</div>
                <div style="font-size: 2rem; font-weight: 800; color: var(--primary); margin-top: 0.25rem;">{{ $totalLicenses ?? 0 }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Across {{ $totalVendors ?? 0 }} software publishers</div>
            </div>

            <div style="background: var(--bg-surface-hover); padding: 1.25rem; border-radius: var(--radius-md);">
                <div style="font-size: 0.76rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase;">Seats In Use</div>
                <div style="font-size: 2rem; font-weight: 800; color: var(--success); margin-top: 0.25rem;">{{ $assignedSeats ?? 0 }} / {{ $totalSeats ?? 0 }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">{{ $utilizationRate ?? 0 }}% seat capacity utilized</div>
            </div>

            <div style="background: var(--bg-surface-hover); padding: 1.25rem; border-radius: var(--radius-md);">
                <div style="font-size: 0.76rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase;">Annual Spend</div>
                <div style="font-size: 2rem; font-weight: 800; color: var(--text-main); margin-top: 0.25rem;">${{ number_format($annualSpend ?? 0, 2) }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Audited SaaS & Perpetual agreements</div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Strip -->
<div class="pub-stats-strip">
    <div class="pub-stats-container">
        <div class="pub-stat-item">
            <div class="pub-stat-number">100%</div>
            <div class="pub-stat-label">Audit & Compliance Readiness</div>
        </div>
        <div class="pub-stat-item">
            <div class="pub-stat-number">0</div>
            <div class="pub-stat-label">Missed Renewal Deadlines</div>
        </div>
        <div class="pub-stat-item">
            <div class="pub-stat-number">30%</div>
            <div class="pub-stat-label">Average Shelfware Cost Saved</div>
        </div>
        <div class="pub-stat-item">
            <div class="pub-stat-number">Instant</div>
            <div class="pub-stat-label">CSV Reporting & Exports</div>
        </div>
    </div>
</div>

<!-- Features Grid -->
<section class="pub-features-section">
    <div class="pub-section-header">
        <h2>Engineered for Modern Software Discovery & Governance</h2>
        <p>Everything your teams need to explore licensed software, activate seats, and maintain pristine vendor relationships.</p>
    </div>

    <div class="pub-features-grid">
        <!-- Feature 1 -->
        <div class="pub-feature-card">
            <div class="pub-feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7V4h16v3M4 12v-2h16v2M4 17v-2h16v2M4 20h16"></path><circle cx="8" cy="8.5" r="1.5"></circle></svg>
            </div>
            <h3 class="pub-feature-title">Software Catalog & Discovery</h3>
            <p class="pub-feature-desc">Record license keys, agreement tiers, seat quantities, purchase dates, and billing intervals (monthly/annual) in one centralized repository.</p>
        </div>

        <!-- Feature 2 -->
        <div class="pub-feature-card">
            <div class="pub-feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><polyline points="16 11 18 13 22 9"></polyline></svg>
            </div>
            <h3 class="pub-feature-title">Device Seat Activations</h3>
            <p class="pub-feature-desc">Link software licenses to staff members, log workstation hardware models, track deployment dates, and revoke unused seats with a single click.</p>
        </div>

        <!-- Feature 3 -->
        <div class="pub-feature-card">
            <div class="pub-feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6"></path><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
            </div>
            <h3 class="pub-feature-title">Renewal Tracker & Expiration Center</h3>
            <p class="pub-feature-desc">Proactive warning banners for licenses expiring in 30, 60, or 90 days. Rapid one-click +1 Year / +1 Month extension actions prevent software blackouts.</p>
        </div>

        <!-- Feature 4 -->
        <div class="pub-feature-card">
            <div class="pub-feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
            </div>
            <h3 class="pub-feature-title">Shelfware & Waste Analytics</h3>
            <p class="pub-feature-desc">Calculate wasted budget on idle, unallocated seats. Identify which departments are over-provisioned and make informed renewal sizing decisions.</p>
        </div>

        <!-- Feature 5 -->
        <div class="pub-feature-card">
            <div class="pub-feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            </div>
            <h3 class="pub-feature-title">Vendor & Publisher Directory</h3>
            <p class="pub-feature-desc">Maintain direct account representative emails, phone numbers, and customer support desk portals across all your corporate software suppliers.</p>
        </div>

        <!-- Feature 6 -->
        <div class="pub-feature-card">
            <div class="pub-feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <h3 class="pub-feature-title">Audit Activity Trail</h3>
            <p class="pub-feature-desc">Maintain an unalterable chronological audit log of all license assignments, employee returns, renewals, and newly registered software products.</p>
        </div>
    </div>
</section>

<!-- Final Call to Action -->
<section style="background: var(--bg-surface); border-top: 1px solid var(--border-subtle); padding: 4.5rem 1.5rem; text-align: center;">
    <div style="max-width: 650px; margin: 0 auto;">
        <h2 style="font-size: 2.2rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.75rem;">Explore the Software License Catalog Today</h2>
        <p style="font-size: 1rem; color: var(--text-muted); margin-bottom: 2rem;">Discover available commercial tools, activate seats on your workstation, and track contract renewals with LicenseHub.</p>
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('licenses.index') }}" class="btn btn-primary" style="padding: 0.8rem 1.75rem;">Browse Catalog</a>
            <a href="{{ route('contact') }}" class="btn btn-secondary" style="padding: 0.8rem 1.75rem;">Contact Support</a>
        </div>
    </div>
</section>
@endsection
