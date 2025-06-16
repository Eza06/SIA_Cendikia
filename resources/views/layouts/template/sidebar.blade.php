@php
    $active = 'menu-item active';
    $nonActive = 'menu-item';
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo mb-3" style="height: 100px;">
        <div class="d-flex flex-column">
            <div class="d-flex align-items-center justify-content-center">
                <a class="app-brand-link" href="{{ route('welcome') }}">
                <img src="{{ asset('/storage/image/cendikia.png') }}" alt="" width="50px"
                    height="50px">
            </a>
            </div>
            <div class="mt-2">
                <span class="demo menu-text fw-bolder ms-2 fs-3">Cendikia</span>
            </div>
        </div>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    @if (Auth::user()->role == 'ADMIN')
        <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="{{ Route::is('admin.dashboard') ? $active : $nonActive }}">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

            <!-- Master Data Header -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Master Data</span>
            </li>

            <!-- Data Siswa -->
            <li class="{{ Route::is('admin.siswa.*') ? $active : $nonActive }}">
                <a href="{{ route('admin.siswa.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Data Siswa">Data Siswa</div>
                </a>
            </li>

            <!-- Data Guru -->
            <li class="{{ Route::is('admin.guru.*') ? $active : $nonActive }}">
                <a href="{{ route('admin.guru.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Data Guru">Data Guru</div>
                </a>
            </li>

              <!-- Data Kelas Belajar -->
              <li class="{{ Route::is('admin.kelasbelajar.*') ? $active : $nonActive }}">
                <a href="{{ route('admin.kelasbelajar.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-building-house"></i>
                    <div data-i18n="Data Guru">Data Kelas</div>
                </a>
            </li>

            <!-- Data Tahun Ajaran -->
            <li class="{{ Route::is('admin.angkatan.*') ? $active : $nonActive }}">
                <a href="{{ route('admin.angkatan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-open"></i>

                    <div data-i18n="Data Guru">Tahun Ajaran</div>
                </a>
            </li>

            <!-- Mata Pelajaran -->
            <li class="{{ Route::is('admin.mapel.*') ? $active : $nonActive }}">
                <a href="{{ route('admin.mapel.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Mata Pelajaran">Mata Pelajaran</div>
                </a>
            </li>

            <li class="{{ Route::is('admin.raport.*') ? $active : $nonActive }}">
                <a href="{{ route('admin.raport.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-notepad"></i>
                    <div data-i18n="Mata Pelajaran">Raport</div>
                </a>
            </li>

            <!-- Jadwal -->
            <li class="{{ Route::is('admin.jadwal.*') ? $active : $nonActive }}">
                <a href="{{route('admin.jadwal.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Jadwal">Jadwal</div>
                </a>
            </li>


            <!-- Components Header (Optional) -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Laporan & Pengaturan</span>
            </li>

            <!-- Contoh Laporan Absensi -->
            <li class="{{ Route::is('admin.settings') ? $active : $nonActive }}">
                <a href="{{ route('admin.settings') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Pengaturan">Pengaturan</div>
                </a>
            </li>
            



            <!-- Tambahkan menu lain sesuai kebutuhan -->

        </ul>
    @endif

    @if (Auth::user()->role == 'GURU')
        <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="{{ Route::is('guru.dashboard') ? $active : $nonActive }}">
                <a href="{{ route('guru.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>


            <!-- Components Header (Optional) -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pengaturan</span>
            </li>

            <!-- Contoh Laporan Absensi -->
            <li class="{{ Route::is('guru.settings') ? $active : $nonActive }}">
                <a href="{{route('guru.settings')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Pengaturan">Pengaturan</div>
                </a>
            </li>



            <!-- Tambahkan menu lain sesuai kebutuhan -->

        </ul>
    @endif
    @if (Auth::user()->role == 'MURID')
        <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="{{ Route::is('siswa.dashboard') ? $active : $nonActive }}">
                <a href="{{ route('siswa.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

            <!-- Components Header (Optional) -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pengaturan</span>
            </li>

            <!-- Contoh Laporan Absensi -->
            <li class="{{ Route::is('siswa.settings') ? $active : $nonActive }}">
                <a href="{{route('siswa.settings')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Pengaturan">Pengaturan</div>
                </a>
            </li>



            <!-- Tambahkan menu lain sesuai kebutuhan -->

        </ul>
    @endif

</aside>
