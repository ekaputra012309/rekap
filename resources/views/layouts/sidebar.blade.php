<!-- Sidebar (Offcanvas for mobile) -->
<div id="sidebar" class="bg-light d-md-block border-end">
    <div class="p-3">
        <h5 class="text-dark d-flex justify-content-between align-items-center">
            Admin Panel
            <button class="btn btn-sm d-md-none" id="closeSidebar">
                <i class="fas fa-times"></i>
            </button>
        </h5>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-users me-2"></i>Users</a></li>
            <li class="nav-item">
                <a class="nav-link text-dark" data-bs-toggle="collapse" href="#masterSubmenu" role="button"
                    aria-expanded="false" aria-controls="masterSubmenu">
                    <i class="fas fa-server me-2"></i>Master <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse ps-3" id="masterSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('poliklinik.index') ? 'active' : '' }}"
                                href="{{ route('poliklinik.index') }}">Poliklinik</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dokter.index') ? 'active' : '' }}"
                                href="{{ route('dokter.index') }}">Dokter</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" data-bs-toggle="collapse" href="#settingsSubmenu" role="button"
                    aria-expanded="false" aria-controls="settingsSubmenu">
                    <i class="fas fa-cogs me-2"></i>Settings <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse ps-3" id="settingsSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link " href="#">General</a></li>
                        <li class="nav-item"><a class="nav-link " href="#">Security</a></li>
                        <li class="nav-item"><a class="nav-link " href="#">Notifications</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link" style="color: inherit; text-decoration: none;"><i
                            class="fas fa-sign-out-alt me-2"></i>Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>
