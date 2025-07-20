<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-2">Reset Password Anda</h1>
        <p class="text-gray-500 text-center mb-6">Masukkan email Anda untuk menerima kode verifikasi.</p>

        <!-- Session Status Messages -->
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form untuk mengirim kode -->
        <form action="{{ route('password.send.code') }}" method="POST" class="space-y-4 mb-6">
            @csrf
            <div>
                <label for="email_send" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input type="email" name="email" id="email_send" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="contoh@email.com">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Kirim Kode Verifikasi
                </button>
            </div>
        </form>

        <hr class="my-6">

        <h2 class="text-xl font-bold text-gray-800 text-center mb-4">Sudah Punya Kode?</h2>
        <p class="text-gray-500 text-center mb-6">Masukkan kode verifikasi dan password baru Anda di bawah ini.</p>

        <!-- Form untuk reset password dengan kode -->
        <form action="{{ route('password.handle') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email_reset" class="block text-sm font-medium text-gray-700">Email Admin</label>
                <div class="mt-1">
                    <input type="text" name="identifier" id="email_reset" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Masukkan email atau kode unik Anda">
                </div>
                 @error('identifier')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kode" class="block text-sm font-medium text-gray-700">Kode Verifikasi</label>
                <div class="mt-1">
                    <input type="text" name="kode" id="kode" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="XXXXXX">
                </div>
                 @error('kode')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <div class="mt-1">
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                 @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <div class="mt-1">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Reset Password
                </button>
            </div>
        </form>
         <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                Kembali ke Login
            </a>
        </div>
    </div>

</body>
</html>
