<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('sneat') }}/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard | @yield('title')</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat') }}/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/css/demo.css" />
    <link rel="stylesheet" href="{{ asset('sneat') }}/assets/vendor/css/pages/page-auth.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

    <!-- SweetAlert & jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Login Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ asset('/storage/image/cendikia.png') }}" alt="Logo Cendikia" width="80"
                                class="mb-2">
                            <h3 class="fw-bold mb-0">Bimbel Cendikia</h3>
                        </div>

                        <h4 class="mb-5 text-center">Selamat Datang Guru 👋</h4>

                        <form id="formAuthentication" class="mb-3" action="{{ route('login.guru.process') }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email atau Username</label>
                                <input type="text" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Masukkan email/username" />
                                @error('email')
                                    <span class="invalid-feedback"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    {{-- Tautan Lupa Password ditambahkan di sini --}}
                                    <a href="{{ route('password.request') }}">
                                        <small>Lupa Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="************" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Login Card -->
            </div>
        </div>
    </div>

    <!-- SweetAlert: Force Login Notification -->
    @if (session('show_force_login_guru'))
        <script>
            Swal.fire({
                title: 'Akun sedang aktif di perangkat lain!',
                html: `<b>{{ session('force_login_name_guru') }}</b><br>{{ session('force_login_email_guru') }}<br><br>
                        Ingin melanjutkan login dan mengeluarkan sesi sebelumnya?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Login Saja',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('force.login.proceed.guru') }}";

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = "{{ csrf_token() }}";

                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        </script>
    @endif

    <!-- Core JS -->
    <script src="{{ asset('sneat') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('sneat') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ asset('sneat') }}/assets/vendor/js/menu.js"></script>
    <script src="{{ asset('sneat') }}/assets/js/main.js"></script>

    <!-- JAVASCRIPT TAMBAHAN UNTUK LIHAT PASSWORD -->
    <script>
        $(document).ready(function() {
            // Ketika ikon mata di dalam .input-group-text di klik
            $('.input-group-text').on('click', function() {
                // Cari input password yang terdekat
                var passwordInput = $(this).prev('input[type="password"], input[type="text"]');
                // Cari ikon di dalam span yang di klik
                var icon = $(this).find('i');

                // Cek tipe input saat ini
                if (passwordInput.attr('type') === 'password') {
                    // Jika tipenya password, ubah ke text
                    passwordInput.attr('type', 'text');
                    // Ganti ikon mata dari 'hide' ke 'show'
                    icon.removeClass('bx-hide').addClass('bx-show');
                } else {
                    // Jika tipenya text, ubah kembali ke password
                    passwordInput.attr('type', 'password');
                    // Ganti ikon mata dari 'show' ke 'hide'
                    icon.removeClass('bx-show').addClass('bx-hide');
                }
            });
        });
    </script>

</body>

</html>
