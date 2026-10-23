<aside class="sidebar" id="appSidebar">
    <!-- Sidebar Header / Brand -->
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <div class="brand-logo-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <span>License<span style="color: var(--primary-light);">Hub</span></span>
            <span class="brand-badge">PRO</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="sidebar-content">
        <!-- Main Section -->
        <div>
            <div class="nav-section-title">Overview</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard', 'home') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </span>
                        <span>Executive Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Management Section -->
        <div>
            <div class="nav-section-title">License Management</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('licenses.index') }}" class="nav-link {{ request()->routeIs('licenses.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 7V4h16v3M4 12v-2h16v2M4 17v-2h16v2M4 20h16"></path>
                                <circle cx="8" cy="8.5" r="1.5"></circle>
                            </svg>
                        </span>
                        <span>Software Licenses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('assignments.index') }}" class="nav-link {{ request()->routeIs('assignments.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <polyline points="16 11 18 13 22 9"></polyline>
                            </svg>
                        </span>
                        <span>Seat Assignments</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Directory Section -->
        <div>
            <div class="nav-section-title">Directory & Vendors</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('vendors.index') }}" class="nav-link {{ request()->routeIs('vendors.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </span>
                        <span>Software Vendors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <span>Employee Staff</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar Footer / Live Status -->
    <div class="sidebar-footer">
        <div class="system-status-card">
            <div class="status-dot-pulse"></div>
            <div>
                <div style="font-size: 0.78rem; font-weight: 700; color: var(--text-main);">License Monitor Live</div>
                <div style="font-size: 0.7rem; color: var(--text-dim);">Enterprise Edition v2.4</div>
            </div>
        </div>
    </div>
</aside>
