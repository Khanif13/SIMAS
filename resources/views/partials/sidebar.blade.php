<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4 mt-3">
            <h3 class="text-white fw-bold mb-0">
                <i class="fa-solid fa-folder-open me-2 text-warning"></i>SIMAS
            </h3>
            <small class="text-white-50">Sistem Informasi Manajemen</small><br>
            <small class="text-white-50">Arsip Surat</small>
        </div>

        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                    <i class="fa-solid fa-chart-pie me-2 w-20px"></i> Dashboard
                </a>
            </li>

            @if (Auth::check() && in_array(Auth::user()->role, ['superadmin', 'admin']))
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('incoming-letters*') ? 'active' : '' }}"
                        href="{{ url('/incoming-letters') }}">
                        <i class="fa-solid fa-inbox me-2 w-20px"></i> Surat Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('outgoing-letters*') ? 'active' : '' }}"
                        href="{{ url('/outgoing-letters') }}">
                        <i class="fa-solid fa-paper-plane me-2 w-20px"></i> Surat Keluar
                    </a>
                </li>
            @endif

            @if (Auth::check() && Auth::user()->role === 'superadmin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ url('/users') }}">
                        <i class="fa-solid fa-users-gear me-2 w-20px"></i> Kelola Pengguna
                    </a>
                </li>
            @endif

            @if (Auth::check() && Auth::user()->role === 'member')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dispositions*') ? 'active' : '' }}"
                        href="{{ route('dispositions.index') }}">
                        <i class="fa-solid fa-share-nodes me-2 w-20px"></i> Disposisi Saya
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
