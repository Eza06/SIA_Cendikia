<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #hiddenLogin {
            display: none;
        }
    </style>
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container text-center">
        <img src="{{ asset('storage/image/cendikia.png') }}" alt="Logo Cendikia" width="150" class="mb-3">
        <h2 class="mb-4">BIMBEL <strong>CENDIKIA</strong></h2>

        <h4 class="mb-3">Selamat Datang di Bimbingan Belajar Cendikia</h4>
        <h5 class="mb-4">Silakan login untuk melanjutkan</h5>

        <a href="{{ route('login.siswa') }}" class="btn btn-primary mb-3">Login Siswa</a>

        <div id="loginAdmin" style="display: none;">
            <div class="d-grid gap-2 col-9 mx-auto">
                <a href="{{ route('login') }}" class="btn btn-danger">Login Admin</a>
            </div>
        </div>
        
        <div id="loginGuru" style="display: none;">
            <div class="d-grid gap-2 col-6 mx-auto">
                <a href="{{ route('login.guru') }}" class="btn btn-warning">Login Guru</a>
            </div>
        </div>
    </div>

    <!-- JavaScript obfuscated -->
    <script>
        (function () {
            function showLogin(role) {
                if (role === 'ADMIN') {
                    document.getElementById('loginAdmin').style.display = 'block';
                } else if (role === 'GURU') {
                    document.getElementById('loginGuru').style.display = 'block';
                }
            }
        
            document.addEventListener('keydown', function (e) {
                if (e.ctrlKey && e.altKey && e.key.toLowerCase() === 'l') {
                    let p = prompt(String.fromCharCode(77, 97, 115, 117, 107, 107, 97, 110, 32, 80, 73, 78)); // Masukkan PIN
                    if (p === atob('Y2VuZGlraWFhZG1pbg==')) {
                        showLogin('ADMIN');
                    } else if (p === atob('Y2VuZGlraWFndXJ1')) {
                        showLogin('GURU');
                    } else {
                        alert("PIN salah!");
                    }
                }
            });
        })();
        </script>
</body>
</html>
