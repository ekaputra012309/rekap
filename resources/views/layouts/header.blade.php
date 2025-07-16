<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <!-- Sidebar toggle on mobile -->
        <button class="btn btn-outline-secondary d-md-none" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Right side navbar (user + dark mode toggle) -->
        <div class="ms-auto d-flex align-items-center gap-2">

            <!-- User Dropdown -->
            <div class="dropdown">
                <!-- Using a link instead of a button -->
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ auth()->user()->name }} <i class="fas fa-user"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                class="fas fa-user-circle me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('company.edit') }}"><i
                                class="fas fa-cogs me-2"></i>Settings</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item"><i
                                    class="fas fa-sign-out-alt me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
