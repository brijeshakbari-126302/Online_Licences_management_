<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LicenseHub Pro') - Enterprise Software License Management</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body class="pub-page-wrapper">
    <!-- Public Header Navigation -->
    <header class="pub-header">
        <div class="pub-header-container">
            <a href="{{ route('home') }}" class="brand-link">
                <div class="brand-logo-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <span>License<span style="color: var(--primary);">Hub</span></span>
                <span class="brand-badge">PRO</span>
            </a>

            <nav>
                <ul class="pub-nav-links">
                    <li><a href="{{ route('home') }}" class="pub-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('dashboard') }}" class="pub-nav-link">Live Dashboard</a></li>
                    <li><a href="{{ route('about') }}" class="pub-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ route('contact') }}" class="pub-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact & Support</a></li>
                </ul>
            </nav>

            <div class="pub-header-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Log In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Get Started</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main style="flex: 1;">
        <!-- Flash Messages -->
        <div style="max-width: 1200px; margin: 1.5rem auto 0; padding: 0 1.5rem;">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Public Footer -->
    <footer class="pub-footer">
        <div class="pub-footer-container">
            <div class="pub-footer-grid">
                <div class="pub-footer-brand">
                    <div class="brand-link" style="margin-bottom: 0.5rem;">
                        <div class="brand-logo-icon" style="width: 32px; height: 32px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <span>License<span style="color: var(--primary);">Hub</span></span>
                    </div>
                    <p>The centralized, enterprise-grade software license & asset management system built for IT compliance, seat optimization, and contract governance.</p>
                </div>

                <div class="pub-footer-col">
                    <h4>Platform</h4>
                    <ul class="pub-footer-links">
                        <li><a href="{{ route('dashboard') }}">Executive Dashboard</a></li>
                        <li><a href="{{ route('licenses.index') }}">Software Licenses</a></li>
                        <li><a href="{{ route('assignments.index') }}">Seat Allocations</a></li>
                        <li><a href="{{ route('renewals.index') }}">Renewal Hub</a></li>
                        <li><a href="{{ route('reports.index') }}">Analytics & Reports</a></li>
                    </ul>
                </div>

                <div class="pub-footer-col">
                    <h4>Company</h4>
                    <ul class="pub-footer-links">
                        <li><a href="{{ route('about') }}">About LicenseHub</a></li>
                        <li><a href="{{ route('contact') }}">Contact & Inquiries</a></li>
                        <li><a href="{{ route('activity.index') }}">Audit Trail</a></li>
                        <li><a href="{{ route('settings.index') }}">System Settings</a></li>
                    </ul>
                </div>

                <div class="pub-footer-col">
                    <h4>Security & Trust</h4>
                    <div style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6;">
                        <p>Enterprise encryption, ISO-compliant audit logs, and zero unauthorized seat provisioning.</p>
                        <div style="margin-top: 1rem; display: flex; align-items: center; gap: 0.5rem; color: var(--success); font-weight: 600; font-size: 0.8rem;">
                            <span style="width: 8px; height: 8px; background: var(--success); border-radius: 50%; display: inline-block;"></span>
                            All Systems Operational
                        </div>
                    </div>
                </div>
            </div>

            <div class="pub-footer-bottom">
                <div>&copy; {{ date('Y') }} LicenseHub Pro. All software assets and trademarks belong to their respective publishers.</div>
                <div>Designed & Built with Laravel {{ app()->version() }} &bull; PHP {{ PHP_VERSION }}</div>
            </div>
        </div>
    </footer>

    <!-- jQuery & Form Validation -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('js/form-validation.js') }}"></script>
    @stack('scripts')
</body>
</html>
