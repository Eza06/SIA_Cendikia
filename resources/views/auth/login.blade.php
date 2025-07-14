<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="/sneat/assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login | Bimbel Cendikia</title>
    <meta name="description" content="" />

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sneat/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/sneat/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="/sneat/assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="/sneat/assets/css/demo.css" />
    <link rel="stylesheet" href="/sneat/assets/vendor/css/pages/page-auth.css" />

    <!-- Vendor -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Login Card -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ asset('/storage/image/cendikia.png') }}" alt="Logo" width="80" class="mb-2">
                            <h3 class="fw-bold mb-0">Bimbel Cendikia</h3>
                            <small class="text-muted">Sistem Informasi Administrator</small>
                        </div>

                        <h4 class="mb-2 text-center">Selamat Datang 👋</h4>
                        <p class="mb-4 text-center">Silakan login untuk mengelola sistem</p>

                        <form id="formAuthentication" action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email atau Username</label>
                                <input type="text" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="password" class="form-label">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"><small>Lupa Password?</small></a>
                                    @endif
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="************">
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary w-100" type="submit">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Login Card -->
            </div>
        </div>
    </div>

    <!-- SweetAlert Force Login (if session exists) -->
    @if (session('pending_login_user_id'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Akun sedang aktif di perangkat lain!',
                    html: `<b>{{ session('pending_login_name') }}</b><br>{{ session('pending_login_email') }}<br><br>
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
                        form.action = "{{ route('force.login.proceed') }}";

                        const token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = '_token';
                        token.value = "{{ csrf_token() }}";

                        form.appendChild(token);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        </script>
    @endif

    <!-- Core JS -->
    <script src="/sneat/assets/vendor/libs/popper/popper.js"></script>
    <script src="/sneat/assets/vendor/js/bootstrap.js"></script>
    <script src="/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/sneat/assets/vendor/js/menu.js"></script>
    <script src="/sneat/assets/js/main.js"></script>
</body>
</html>
