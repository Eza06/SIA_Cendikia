<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Siswa - Bimbel Cendikia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">

        <!-- Header -->
        <div class="text-center">
            <img src="{{ asset('/storage/image/cendikia.png') }}" alt="Logo Cendikia" width="70" class="mx-auto mb-2">
            <h2 class="text-2xl font-bold text-gray-900">Reset Password Siswa</h2>
            <p class="text-gray-600 mt-1">Masukkan email Anda yang terdaftar.</p>
        </div>

        <!-- Session & Error Messages -->
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Form untuk memasukkan email -->
        <form action="{{ route('password.email.siswa') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Siswa</label>
                <div class="mt-1">
                    <input type="email" name="email" id="email" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="contoh@email.com">
                </div>
                @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                    Lanjutkan
                </button>
            </div>
        </form>

        <!-- Navigasi Kembali ke Login -->
        <div class="text-center text-sm">
            <a href="{{ route('login.siswa') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                Kembali ke Login
            </a>
        </div>
    </div>

</body>
</html>
