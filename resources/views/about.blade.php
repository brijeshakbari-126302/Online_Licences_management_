@extends('layouts.public')

@section('title', 'About Us - Software License Catalog & Activation Portal')

@section('content')
<!-- Hero Section -->
<section class="pub-hero" style="padding-bottom: 2.5rem;">
    <div class="pub-hero-badge">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        Our Mission & Architecture
    </div>

    <h1>
        Empowering Organizations with Total Visibility Over <br>
        <span class="gradient-text">Software Investments</span>
    </h1>

    <p class="pub-hero-subtitle">
        LicenseHub was created to provide a unified software catalog and activation portal for organizations: discovering licensed tools, activating seats on workstations, and eliminating shelfware.
    </p>
</section>

<!-- Content Pillars Section -->
<section style="max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem 5rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">
        <div class="panel-card" style="padding: 2rem;">
            <div class="pub-feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">Total Asset Transparency</h3>
            <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6;">
                Know exactly which software applications are purchased, how many seats exist, who holds them, and when contracts expire. Eliminate shadow IT.
            </p>
        </div>

        <div class="panel-card" style="padding: 2rem;">
            <div class="pub-feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">Shelfware Cost Reduction</h3>
            <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6;">
                On average, 25-35% of purchased enterprise licenses go unused. We quantify this idle capacity as dollar waste, giving finance and IT the leverage to right-size tiers.
            </p>
        </div>

        <div class="panel-card" style="padding: 2rem;">
            <div class="pub-feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">Guaranteed Audit Compliance</h3>
            <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.6;">
                Software publisher audits can result in severe financial penalties. LicenseHub keeps full seat activation logs and device tokens ready for instant verification.
            </p>
        </div>
    </div>

    <!-- Architecture & Platform Details -->
    <div class="panel-card" style="padding: 3rem 2.5rem; margin-bottom: 3rem;">
        <h2 style="font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-bottom: 1rem;">Platform Architecture & Reliability</h2>
        <p style="font-size: 1rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 1.5rem;">
            LicenseHub is engineered using robust, test-driven Laravel design patterns and PHP 8.3 type safety. The database schema strictly enforces relational integrity across software publishers, license keys, corporate departments, and employee workstations.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
            <div style="background: var(--bg-surface-hover); padding: 1.25rem; border-radius: var(--radius-md);">
                <div style="font-weight: 700; color: var(--primary); font-size: 1.1rem; margin-bottom: 0.25rem;">PHP 8.3 + Laravel 12</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">Strict type-hinting, modern Blade components, and high throughput.</div>
            </div>
            <div style="background: var(--bg-surface-hover); padding: 1.25rem; border-radius: var(--radius-md);">
                <div style="font-weight: 700; color: var(--success); font-size: 1.1rem; margin-bottom: 0.25rem;">Relational Integrity</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">Cascading constraints prevent phantom assignments or orphan seats.</div>
            </div>
            <div style="background: var(--bg-surface-hover); padding: 1.25rem; border-radius: var(--radius-md);">
                <div style="font-weight: 700; color: var(--text-main); font-size: 1.1rem; margin-bottom: 0.25rem;">Modern Light Aesthetic</div>
                <div style="font-size: 0.85rem; color: var(--text-muted);">Ergonomic, accessible color palette built for daily IT management.</div>
            </div>
        </div>
    </div>

    <!-- Call to action -->
    <div style="text-align: center; margin-top: 2rem;">
        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.75rem;">Explore the Live Management Dashboard</h3>
        <p style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 1.5rem;">Experience real-time license tracking, seat allocations, and renewal workflows right in your browser.</p>
        <div style="display: flex; justify-content: center; gap: 1rem;">
            <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">Open Dashboard</a>
            <a href="{{ route('contact') }}" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">Contact Support</a>
        </div>
    </div>
</section>
@endsection
