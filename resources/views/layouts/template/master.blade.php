<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('sneat/assets/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard | @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Helpers -->
    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('layouts.template.sidebar')

            <!-- Main Content -->
            @yield('content')
            <!-- / Main Content -->

        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Hidden Logout Form -->
    @auth
        <form id="logout-form" action="{{ route(auth()->user()->role == 'ADMIN' ? 'logout' : (auth()->user()->role == 'GURU' ? 'logout.guru' : 'logout.siswa')) }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

    <!-- Core JS -->
    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('sneat/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>

    <!-- Global Scripts (Idle Timer & DataTable Initialization) -->
    <script src="https://cdn.jsdelivr.net/npm/idle-timer@2.0.1/idle-timer.min.js"></script>
    <script>
        $(document).ready(function () {

            // Inisialisasi DataTable secara terpusat, aman, dan "kebal"
            if ($('#myTable').length && !$.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable();
            }

            // Konfigurasi Idle Timer
            const idleTimeout = 15 * 60 * 1000;
            const logoutDelay = 15 * 60 * 1000;
            let idleWarned = false;
            let logoutTimer = null;

            const idle = new Idle({
                onIdle: function () {
                    if (!idleWarned) {
                        idleWarned = true;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Ada Aktivitas',
                            text: 'Sesi Anda akan berakhir dalam 15 menit.',
                            timer: 10000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });

                        logoutTimer = setTimeout(function () {
                            if(document.getElementById('logout-form')) {
                                document.getElementById('logout-form').submit();
                            }
                        }, logoutDelay);
                    }
                },
                onActive: function () {
                    if (idleWarned) {
                        Swal.close();
                        idleWarned = false;
                        clearTimeout(logoutTimer);
                    }
                },
                idle: idleTimeout
            });
        });
    </script>

    <!-- Script khusus dari halaman anak akan dimuat di sini -->
    @stack('script')

</body>
</html>


