@auth

<button class="mobile-toggle" onclick="toggleMobileMenu()">
    <i class="fa-solid fa-bars"></i>
</button>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileMenu()"></div>

<div class="sidebar" id="sidebar">

    <!-- HEADER -->
    <div class="sidebar-header">
        <div class="logo-container">
            <span class="logo-text">
                <i class="fa-solid fa-school"></i> Sistem Akademik
            </span>
        </div>
    </div>

    <!-- MENU -->
    <nav class="nav-menu">

        <div class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('jurusan.index') }}"
               class="nav-link {{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="nav-text">Jurusan</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('mahasiswa.index') }}"
               class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i>
                <span class="nav-text">Mahasiswa</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('matakuliah.index') }}"
               class="nav-link {{ request()->routeIs('matakuliah.*') ? 'active' : '' }}">
                <i class="fa-solid fa-book"></i>
                <span class="nav-text">Matakuliah</span>
            </a>
        </div>
    </nav>

    <!-- FOOTER -->
    <div class="sidebar-footer">

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="nav-text">Logout</span>
            </button>
        </form>

    </div>

</div>

@endauth