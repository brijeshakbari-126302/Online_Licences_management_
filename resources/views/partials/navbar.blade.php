<header class="topbar">
    <div class="topbar-left">
        <!-- Breadcrumb / Location -->
        <nav class="page-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('dashboard') }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </a>
            <span class="breadcrumb-separator">/</span>
            @if (request()->routeIs('dashboard', 'home'))
                <span class="current">Dashboard</span>
            @elseif (request()->routeIs('reports.*'))
                <span class="current">Reports & Analytics</span>
            @elseif (request()->routeIs('renewals.*'))
                <span class="current">Renewals & Expirations</span>
            @elseif (request()->routeIs('activity.*'))
                <span class="current">Audit Activity Log</span>
            @elseif (request()->routeIs('settings.*'))
                <span class="current">System Settings</span>
            @elseif (request()->routeIs('licenses.*'))
                <a href="{{ route('licenses.index') }}">Software Catalog</a>
                @if (request()->routeIs('licenses.create'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Add New</span>
                @elseif (request()->routeIs('licenses.edit'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Edit</span>
                @elseif (request()->routeIs('licenses.show'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Details</span>
                @endif
            @elseif (request()->routeIs('assignments.*'))
                <a href="{{ route('assignments.index') }}">Seat Activations</a>
                @if (request()->routeIs('assignments.create'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Assign Seat</span>
                @elseif (request()->routeIs('assignments.edit'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Edit</span>
                @elseif (request()->routeIs('assignments.show'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Details</span>
                @endif
            @elseif (request()->routeIs('vendors.*'))
                <a href="{{ route('vendors.index') }}">Publishers</a>
                @if (request()->routeIs('vendors.create'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Add New</span>
                @elseif (request()->routeIs('vendors.edit'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Edit</span>
                @elseif (request()->routeIs('vendors.show'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Details</span>
                @endif
            @elseif (request()->routeIs('employees.*'))
                <a href="{{ route('employees.index') }}">Employees</a>
                @if (request()->routeIs('employees.create'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Register</span>
                @elseif (request()->routeIs('employees.edit'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Edit</span>
                @elseif (request()->routeIs('employees.show'))
                    <span class="breadcrumb-separator">/</span>
                    <span class="current">Profile</span>
                @endif
            @endif
        </nav>
    </div>

    <div class="topbar-right">
        <!-- Quick Action Buttons -->
        <a href="{{ route('assignments.create') }}" class="btn btn-secondary btn-sm" title="Activate a seat for a device">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <line x1="19" y1="8" x2="19" y2="14"></line>
                <line x1="22" y1="11" x2="16" y2="11"></line>
            </svg>
            <span>Activate Seat</span>
        </a>

        <a href="{{ route('licenses.create') }}" class="quick-action-btn" title="Publish new software license">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>New Software</span>
        </a>

        <!-- User Profile Pill & Logout Button -->
        <div style="display: flex; align-items: center; gap: 0.65rem;">
            <div class="avatar-pill">
                <div class="avatar-circle">
                    @auth
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    @else
                        AD
                    @endauth
                </div>
                <div class="avatar-meta">
                    <span class="avatar-name">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <span class="avatar-role">{{ Auth::user()->email ?? 'admin@licensehub.pro' }}</span>
                </div>
            </div>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn" title="Sign out of your session">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </div>
</header>
