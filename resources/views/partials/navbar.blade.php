<header class="d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
    <div class="d-flex align-items-center">
        <h5 class="mb-0 fw-bold text-dark d-none d-md-block">
            @yield('title', 'SIMAS')
        </h5>
    </div>

    <div class="d-flex align-items-center">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle border-0"
                id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="text-end me-3 d-none d-md-block">
                    <h6 class="mb-0 fw-bold text-primary">Halo, {{ Auth::user()->name }}!</h6>
                    <small class="text-muted text-uppercase fw-bold"
                        style="font-size: 0.7rem;">{{ Auth::user()->role }}</small>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                    style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-user"></i>
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-3" aria-labelledby="dropdownUser">
                <li>
                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                        <i class="fa-solid fa-user-pen me-2 text-primary"></i> Profil Saya
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider m-0">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Sign out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
