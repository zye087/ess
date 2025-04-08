<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                
                <!-- Account Alerts (Mobile Only) -->
                <div class="sidenav-menu-heading d-sm-none">Account</div>
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="bell"></i></div>
                    Alerts
                    <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                </a>
                <a class="nav-link d-sm-none" href="#!">
                    <div class="nav-link-icon"><i data-feather="mail"></i></div>
                    Messages
                    <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                </a>

                <!-- Main Menu -->
                <div class="sidenav-menu-heading">Menu</div>

                <!-- Dashboard -->
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dashboard
                </a>

                <!-- Users Management -->
                <div class="sidenav-menu-heading">Users Management</div>
                <a class="nav-link {{ request()->routeIs('admin.parents') ? 'active' : '' }}" href="{{ route('admin.parents') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Parents
                </a>
                <a class="nav-link {{ request()->routeIs('admin.guardians') ? 'active' : '' }}" href="{{route('admin.guardians')}}">
                    <div class="nav-link-icon"><i data-feather="shield"></i></div>
                    Guardians
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    <div class="nav-link-icon"><i data-feather="user-check"></i></div>
                    Users
                </a>

                <!-- Children & Pickups -->
                <div class="sidenav-menu-heading">Children & Pickups</div>
                <a class="nav-link {{ request()->routeIs('admin.children') ? 'active' : '' }}" href="{{route('admin.children')}}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Children
                </a>
                <a class="nav-link {{ request()->routeIs('admin.pickups') ? 'active' : '' }}" href="{{route('admin.pickups')}}">
                    <div class="nav-link-icon"><i data-feather="truck"></i></div>
                    Pickups
                </a>

                <!-- Reports & Logs -->
                <div class="sidenav-menu-heading">QR Code Scanner</div>
                <a class="nav-link {{ request()->routeIs('admin.scanner') ? 'active' : '' }}" href="{{route('admin.scanner')}}">
                    <div class="nav-link-icon"><i data-feather="bar-chart-2"></i></div>
                    Scan
                </a>

                <!-- Settings -->
                <div class="sidenav-menu-heading">Settings</div>
                <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                    <div class="nav-link-icon"><i data-feather="settings"></i></div>
                    System Settings
                </a>

                <!-- Logout -->
                <a class="nav-link text-danger" href="{{ route('admin.logout') }}">
                    <div class="nav-link-icon"><i data-feather="log-out"></i></div>
                    Logout
                </a>
            </div>
        </div>

        <!-- Sidenav Footer -->
        {{-- <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ ucfirst(auth()->user()->username) }}</div>
            </div>
        </div> --}}
    </nav>
</div>
