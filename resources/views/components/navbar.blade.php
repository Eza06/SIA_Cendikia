<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center shadow-sm"
    id="layout-navbar" style="background: linear-gradient(90deg, #0d6efd, #0a58ca);">

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4 text-white" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            <!-- Optional Search Bar -->
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- User Dropdown -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <img src="{{ asset('storage/image/user.png') }}" 
                         alt="User Avatar" 
                         class="rounded-circle shadow-sm"
                         style="width: 45px; height: 45px; object-fit: cover;"/>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded-3">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{ asset('storage/image/user.png') }}" 
                                         alt="User Avatar" 
                                         class="rounded-circle border border-2 border-primary shadow-sm"
                                         style="width: 35px; height: 35px; object-fit: cover;"/>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block text-dark">{{ Auth::user()->name }}</span>
                                    <small class="text-muted">{{ Auth::user()->role }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li><div class="dropdown-divider"></div></li>

                    @if (Auth::user()->role == 'ADMIN')
                        <li>
                            <a class="dropdown-item text-danger fw-semibold" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bx bx-power-off me-2 text-danger"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @elseif (Auth::user()->role == 'GURU')
                        <li>
                            <a class="dropdown-item text-danger fw-semibold" href="{{ route('logout.guru') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form-guru').submit();">
                                <i class="bx bx-power-off me-2 text-danger"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                            <form id="logout-form-guru" action="{{ route('logout.guru') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @elseif (Auth::user()->role == 'MURID')
                        <li>
                            <a class="dropdown-item text-danger fw-semibold" href="{{ route('logout.siswa') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form-siswa').submit();">
                                <i class="bx bx-power-off me-2 text-danger"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                            <form id="logout-form-siswa" action="{{ route('logout.siswa') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endif
                </ul>
            </li>
            <!--/ User Dropdown -->
        </ul>
    </div>
</nav>
