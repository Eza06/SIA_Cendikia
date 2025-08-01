<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - Bimbel Cendikia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .form-password-toggle .input-group-text { cursor: pointer; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">

        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900">Atur Password Baru</h2>
            <p class="text-gray-600 mt-1">Email: <strong>{{ $email }}</strong></p>
        </div>

        <form action="{{ route('password.update.siswa') }}" method="POST" class="space-y-4">
            @csrf
            {{-- Kirim email secara tersembunyi untuk proses update --}}
            <input type="hidden" name="email" value="{{ $email }}">

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
                    Simpan Password Baru
                </button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('.input-group-text').on('click', function() {
                var passwordInput = $(this).closest('.relative').find('input');
                var icon = $(this).closest('.input-group-text').find('i');
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
