<header class="navbar top-navbar sticky-top flex-md-nowrap p-0 shadow-sm">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fw-bold" style="color: var(--secondary-color);" href="#">
        <span class="d-md-none">SIMAS</span>
    </a>

    <button class="navbar-toggler position-absolute d-md-none collapsed mt-2 ms-2" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-nav w-100 d-flex flex-row justify-content-end px-3 py-2">
        <div class="nav-item text-nowrap d-flex align-items-center">
            <!-- Menampilkan Nama & Role Pengguna -->
            <div class="text-end me-3 d-none d-sm-block">
                <span class="d-block fw-bold mb-0" style="color: var(--secondary-color); line-height: 1;">Halo,
                    {{ Auth::user()->name }}!</span>
                <small class="text-muted text-uppercase"
                    style="font-size: 0.7rem; font-weight: 800;">{{ Auth::user()->role }}</small>
            </div>

            <!-- Tombol Logout Menggunakan Form POST -->
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger px-3 shadow-sm">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Sign out
                </button>
            </form>
        </div>
    </div>
</header>
