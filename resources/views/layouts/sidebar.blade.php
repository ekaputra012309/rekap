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
            <li class="nav-item">
                <a class="nav-link text-dark" data-bs-toggle="collapse" href="#masterSubmenu" role="button"
                    aria-expanded="false" aria-controls="masterSubmenu">
                    <i class="fas fa-server me-2"></i>Master <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse ps-3" id="masterSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('income.index') ? 'active' : '' }}"
                                href="{{ route('income.index') }}">List Pendapatan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('outcome.index') ? 'active' : '' }}"
                                href="{{ route('outcome.index') }}">List Pengeluaran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('saldo.index') ? 'active' : '' }}"
                                href="{{ route('saldo.index') }}">Saldo Awal</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" data-bs-toggle="collapse" href="#transaksisSubmenu" role="button"
                    aria-expanded="false" aria-controls="transaksisSubmenu">
                    <i class="fas fa-book-open me-2"></i>Transaksi <i class="fas fa-chevron-down float-end"></i>
                </a>
                <div class="collapse ps-3" id="transaksisSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('gess.index') ? 'active' : '' }}"
                                href="{{ route('gess.index') }}">GESS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('doom.index') ? 'active' : '' }}"
                                href="{{ route('doom.index') }}">DOOM</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('gib.index') ? 'active' : '' }}"
                                href="{{ route('gib.index') }}">GIB</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('pemasukan.index') ? 'active' : '' }}"
                    href="{{ route('pemasukan.index') }}"><i class="fas fa-download me-2"></i>Pemasukan</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('pengeluaran.index') ? 'active' : '' }}"
                    href="{{ route('pengeluaran.index') }}"><i class="fas fa-upload me-2"></i>Pengeluaran</a></li>
            {{-- <li class="nav-item">
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
            </li> --}}
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
