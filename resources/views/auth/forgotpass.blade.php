<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Bimbel Cendikia</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Boxicons for icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .form-password-toggle .input-group-text {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">

        <!-- Header -->
        <div class="text-center">
            <img src="{{ asset('/storage/image/cendikia.png') }}" alt="Logo Cendikia" width="70" class="mx-auto mb-2">
            <h2 class="text-2xl font-bold text-gray-900">Lupa Password?</h2>
            <p class="text-gray-600 mt-1">Jangan khawatir, kami bantu Anda.</p>
        </div>

        <!-- Session Status & Error Messages -->
        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                <p>{{ session('status') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Form 1: Kirim Kode Verifikasi -->
        <form action="{{ route('password.send.code') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email_send" class="block text-sm font-medium text-gray-700">Email Terdaftar</label>
                <div class="mt-1">
                    <input type="email" name="email" id="email_send" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Masukkan email Anda">
                </div>
                @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                    Kirim Kode Verifikasi
                </button>
            </div>
        </form>

        <div class="border-t border-gray-200"></div>

        <!-- Form 2: Reset Password dengan Kode -->
        <div class="text-center">
             <h3 class="text-xl font-bold text-gray-900">Sudah Punya Kode?</h3>
             <p class="text-gray-600 mt-1">Masukkan kode dan password baru Anda.</p>
        </div>

        <form action="{{ route('password.handle') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email_reset" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input type="email" name="identifier" id="email_reset" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Email yang Anda gunakan untuk meminta kode">
                </div>
                @error('identifier')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kode" class="block text-sm font-medium text-gray-700">Kode Verifikasi</label>
                <div class="mt-1">
                    <input type="text" name="kode" id="kode" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="XXXXXX">
                </div>
                @error('kode')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Baru -->
            <div class="form-password-toggle">
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <div class="relative mt-1">
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <i class="bx bx-hide text-gray-400 input-group-text"></i>
                    </span>
                </div>
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password Baru -->
            <div class="form-password-toggle">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <div class="relative mt-1">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                     <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <i class="bx bx-hide text-gray-400 input-group-text"></i>
                    </span>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                    Reset Password
                </button>
            </div>
        </form>

        <!-- Navigasi Kembali ke Login -->
        <div class="text-center text-sm">
            <p class="text-gray-600">Ingat password Anda? Kembali ke login</p>
            <div class="flex justify-center space-x-4 mt-2">
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Admin</a>
                <a href="{{ route('login.guru') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Guru</a>
                {{-- Tautan ke login.murid telah dihapus untuk memperbaiki error --}}
            </div>
        </div>
    </div>

    <script>
        // Script untuk toggle lihat/sembunyikan password
        $(document).ready(function() {
            $('.input-group-text').on('click', function() {
                var passwordInput = $(this).closest('.relative').find('input');
                var icon = $(this);
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('bx-hide').addClass('bx-show');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('bx-show').addClass('bx-hide');
                }
            });
        });
    </script>

</body>
</html>
