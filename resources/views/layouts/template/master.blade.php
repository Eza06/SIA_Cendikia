<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('sneat/assets/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard @yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>

    <!-- Ekstra -->
    <script src="sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <main>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('layouts.template.sidebar')
                @yield('content')
                @stack('scripts')
            </div>
        </div>
    </main>

    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#myTable');
    </script>

    <!-- Core JS -->
    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('sneat/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Ekstra -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Idle Timer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/idle-timer/2.0.1/idle-timer.min.js"></script>
    <script>
        const idleTimeout = 15 * 60 * 1000; 
        const logoutTimeout = 30 * 60 * 1000;
        let idleWarned = false;
        let logoutTimer = null;

        $(document).ready(function () {
            $(document).idle({
                onIdle: function () {
                    if (!idleWarned) {
                        idleWarned = true;

                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak ada aktivitas',
                            text: 'Anda akan logout otomatis jika tidak aktif dalam 15 menit.',
                            timer: 10000,
                            showConfirmButton: false
                        });

                        logoutTimer = setTimeout(function () {
                            Swal.fire({
                                icon: 'info',
                                title: 'Sesi Berakhir',
                                text: 'Anda telah logout otomatis.',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            setTimeout(function () {
                                document.getElementById('logout-form').submit();
                            }, 3000);
                        }, 15 * 60 * 1000);
                    }
                },
                onActive: function () {
                    if (idleWarned) {
                        idleWarned = false;
                        clearTimeout(logoutTimer);
                    }
                },
                idle: idleTimeout
            });
        });
    </script>

    <!-- Hidden Logout Form -->
    @auth
        <form id="logout-form" action="{{ route(auth()->user()->role == 'ADMIN' ? 'logout' : (auth()->user()->role == 'GURU' ? 'logout.guru' : 'logout.siswa')) }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

    @stack('script')
</body>
</html>
