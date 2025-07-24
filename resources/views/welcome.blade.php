<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bimbel Cendikia - Bimbingan Belajar Terbaik</title>
    <meta name="description"
        content="Bimbel Cendikia menyediakan program bimbingan belajar untuk tingkat SD, SMP, dan SMA dengan pengajar berpengalaman dan kurikulum terupdate.">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-bg {
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.8)), url('https://placehold.co/1920x1080/e2e8f0/a0aec0?text=Suasana+Belajar');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow-md fixed w-full z-20">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <img id="logoCendikia" src="{{ asset('storage/image/cendikia.png') }}" alt="Logo Cendikia"
                    class="h-10 w-10 mr-3 cursor-pointer">
                <span class="text-2xl font-bold text-gray-800">Bimbel Cendikia</span>
            </div>
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="#keunggulan" class="text-gray-600 hover:text-blue-600">Keunggulan</a>
                <a href="#program" class="text-gray-600 hover:text-blue-600">Program</a>
                <a href="#testimoni" class="text-gray-600 hover:text-blue-600">Testimoni</a>
                <a href="#kontak" class="text-gray-600 hover:text-blue-600">Kontak</a>
                <a href="{{ route('login.siswa') }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 transition duration-300">Login
                    Siswa</a>
            </nav>
            <button class="md:hidden" id="mobile-menu-button">
                <i class='bx bx-menu text-3xl'></i>
            </button>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white py-4">
            <a href="#keunggulan" class="block text-center py-2 text-gray-600 hover:bg-gray-100">Keunggulan</a>
            <a href="#program" class="block text-center py-2 text-gray-600 hover:bg-gray-100">Program</a>
            <a href="#testimoni" class="block text-center py-2 text-gray-600 hover:bg-gray-100">Testimoni</a>
            <a href="#kontak" class="block text-center py-2 text-gray-600 hover:bg-gray-100">Kontak</a>
            <div class="px-6 mt-4">
                <a href="{{ route('login.siswa') }}"
                    class="block text-center bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 transition duration-300">Login
                    Siswa</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-bg pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight mb-4">
                    Raih Potensi Akademik Terbaikmu
                </h1>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    Bersama pengajar berpengalaman dan metode belajar yang menyenangkan, kami siap membantu Anda
                    mencapai prestasi gemilang di setiap jenjang pendidikan.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login.siswa') }}"
                        class="bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-700 transition duration-300 shadow-lg">
                        Login Siswa
                    </a>
                    <a href="#program"
                        class="bg-white text-blue-600 px-8 py-3 rounded-full text-lg font-semibold hover:bg-gray-100 transition duration-300 border border-gray-300 shadow-lg">
                        Lihat Program Kami
                    </a>
                </div>
            </div>
        </section>

        <!-- Keunggulan Section -->
        <section id="keunggulan" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold">Kenapa Memilih Cendikia?</h2>
                    <p class="text-gray-600 mt-2">Keunggulan yang kami tawarkan untuk mendukung kesuksesan Anda.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div
                        class="text-center p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <i class='bx bxs-user-voice text-5xl text-blue-600 mb-4'></i>
                        <h3 class="text-xl font-semibold mb-2">Pengajar Berpengalaman</h3>
                        <p class="text-gray-600">Tim pengajar kami adalah para ahli di bidangnya yang sabar dan
                            suportif.</p>
                    </div>
                    <div
                        class="text-center p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <i class='bx bxs-book-content text-5xl text-blue-600 mb-4'></i>
                        <h3 class="text-xl font-semibold mb-2">Kurikulum Terupdate</h3>
                        <p class="text-gray-600">Materi pembelajaran selalu disesuaikan dengan kurikulum nasional
                            terbaru.</p>
                    </div>
                    <div
                        class="text-center p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <i class='bx bxs-group text-5xl text-blue-600 mb-4'></i>
                        <h3 class="text-xl font-semibold mb-2">Kelas Interaktif</h3>
                        <p class="text-gray-600">Suasana belajar dua arah yang aktif dan menyenangkan di kelas kecil.
                        </p>
                    </div>
                    <div
                        class="text-center p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <i class='bx bxs-bar-chart-alt-2 text-5xl text-blue-600 mb-4'></i>
                        <h3 class="text-xl font-semibold mb-2">Monitoring Progres</h3>
                        <p class="text-gray-600">Laporan perkembangan belajar rutin untuk memantau kemajuan siswa.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Program Section -->
        <section id="program" class="py-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold">Program Bimbingan Kami</h2>
                    <p class="text-gray-600 mt-2">Dirancang khusus untuk setiap jenjang pendidikan.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/3b82f6/ffffff?text=SD" alt="Program SD"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-2">Sekolah Dasar (SD)</h3>
                            <p class="text-gray-600 mb-4">Membangun fondasi akademik yang kuat dengan metode belajar
                                yang seru dan mudah dipahami.</p>
                            <a href="#" class="font-semibold text-blue-600 hover:underline">Pelajari Lebih Lanjut
                                &rarr;</a>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/10b981/ffffff?text=SMP" alt="Program SMP"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-2">Sekolah Menengah Pertama (SMP)</h3>
                            <p class="text-gray-600 mb-4">Persiapan matang menghadapi ujian dan pemantapan konsep untuk
                                jenjang selanjutnya.</p>
                            <a href="#" class="font-semibold text-blue-600 hover:underline">Pelajari Lebih
                                Lanjut &rarr;</a>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="https://placehold.co/600x400/f97316/ffffff?text=SMA" alt="Program SMA"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-2">Sekolah Menengah Atas (SMA)</h3>
                            <p class="text-gray-600 mb-4">Strategi jitu taklukkan soal-soal sulit dan sukses masuk
                                perguruan tinggi impian.</p>
                            <a href="#" class="font-semibold text-blue-600 hover:underline">Pelajari Lebih
                                Lanjut &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimoni Section -->
        <section id="testimoni" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold">Kata Mereka Tentang Cendikia</h2>
                    <p class="text-gray-600 mt-2">Kami bangga menjadi bagian dari perjalanan sukses mereka.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-8 rounded-lg shadow-sm">
                        <p class="text-gray-600 italic mb-4">"Belajar di Cendikia asyik banget! Kakak-kakak pengajarnya
                            baik dan sabar, jadi aku lebih ngerti pelajaran di sekolah. Nilai matematikaku jadi naik!"
                        </p>
                        <div class="flex items-center">
                            <img src="https://placehold.co/100x100/c7d2fe/4338ca?text=S" alt="Siswa"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <p class="font-bold">Sandria A.</p>
                                <p class="text-sm text-gray-500">Siswa Kelas 8</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-8 rounded-lg shadow-sm">
                        <p class="text-gray-600 italic mb-4">"Metode pembelajarannya mudah diikuti. Try out rutin
                            sangat membantu saya dalam persiapan ujian akhir sekolah. Terima kasih Bimbel Cendikia!"</p>
                        <div class="flex items-center">
                            <img src="https://placehold.co/100x100/bbf7d0/166534?text=D" alt="Siswa"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <p class="font-bold">Deanti A.</p>
                                <p class="text-sm text-gray-500">Siswa Kelas 11</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-8 rounded-lg shadow-sm">
                        <p class="text-gray-600 italic mb-4">"Sebagai orang tua, saya melihat perubahan positif pada
                            anak saya. Dia jadi lebih percaya diri dan semangat belajar. Laporannya juga sangat detail."
                        </p>
                        <div class="flex items-center">
                            <img src="https://placehold.co/100x100/fed7aa/9a3412?text=I" alt="Orang Tua"
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <p class="font-bold">Ibu Rina</p>
                                <p class="text-sm text-gray-500">Orang Tua Siswa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kontak Section -->
        <section id="kontak" class="py-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold">Hubungi Kami</h2>
                    <p class="text-gray-600 mt-2">Kami siap menjawab pertanyaan Anda dan membantu proses pendaftaran.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-semibold mb-4">Informasi Kontak</h3>
                            <div class="flex items-start mb-4">
                                <i class='bx bxs-map text-xl text-blue-600 mr-3 mt-1'></i>
                                <div>
                                    <p class="font-medium">Alamat</p>
                                    <p class="text-gray-600">Jl. Pinang Raya No.37, Ragajaya, Bojonggede, Bogor, Jawa
                                        Barat 16920</p>
                                </div>
                            </div>
                            <a href="https://wa.me/6289637757810" target="_blank"
                                class="flex items-center mb-4 text-gray-800 hover:text-blue-600">
                                <i class='bx bxl-whatsapp text-xl text-green-500 mr-3'></i>
                                <div>
                                    <p class="font-medium">WhatsApp</p>
                                    <p class="text-gray-600">+62 896-3775-7810</p>
                                </div>
                            </a>

                            <a href="https://www.instagram.com/bimbel.cendikia?igsh=MWpoOHl0YjdzeDV1cg=="
                                target="_blank" class="flex items-center mb-3 text-gray-800 hover:text-blue-600">
                                <i class='bx bxl-instagram text-xl text-pink-500 mr-3'></i>
                                <div>
                                    <p class="font-medium">Instagram</p>
                                    <p class="text-gray-600">@bimbel.cendikia</p>
                                </div>
                            </a>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-4">Lokasi Kami</h3>
                            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.633356199458!2d106.78013831477028!3d-6.440789995339358!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c3b1f4ffffff%3A0x8a7c1b2c3d4e5f6!2sJl.%20Pinang%20Raya%20No.37%2C%20Ragajaya%2C%20Kec.%20Bojong%20Gede%2C%20Kabupaten%20Bogor%2C%20Jawa%20Barat%2016920!5e0!3m2!1sen!2sid!4v1678886400001!5m2!1sen!2sid"
                                    width="100%" height="100%" style="border:0;" allowfullscreen=""
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-8">
            <div class="text-center">
                <h3 class="text-2xl font-bold">Bimbel Cendikia</h3>
                <p class="mt-2">Membentuk Generasi Cerdas dan Berprestasi</p>
                <div class="flex justify-center space-x-6 mt-4">
                    <a href="#" class="hover:text-blue-400"><i class='bx bxl-facebook-square text-2xl'></i></a>
                    <a href="#" class="hover:text-blue-400"><i class='bx bxl-instagram-alt text-2xl'></i></a>
                    <a href="#" class="hover:text-blue-400"><i class='bx bxl-twitter text-2xl'></i></a>
                </div>
            </div>
            <hr class="my-6 border-gray-700">
            <div class="text-center">
                <p class="text-gray-400">&copy; 2025 Bimbel Cendikia. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Hidden Login Buttons -->
    <div id="hiddenLogins" class="fixed bottom-4 right-4 space-y-2" style="display: none;">
        <a href="{{ route('login') }}"
            class="block bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition duration-300 shadow-lg">Login
            Admin</a>
        <a href="{{ route('login.guru') }}"
            class="block bg-yellow-500 text-white px-4 py-2 rounded-full hover:bg-yellow-600 transition duration-300 shadow-lg">Login
            Guru</a>
    </div>

    <script>
        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Secret Login Logic
        (function() {
            const hiddenLogins = document.getElementById('hiddenLogins');

            function showLoginButtons() {
                hiddenLogins.style.display = 'block';
                setTimeout(() => {
                    hiddenLogins.style.display = 'none';
                }, 10000); // Sembunyikan lagi setelah 10 detik
            }

            function promptPIN() {
                // Obfuscated "Masukkan PIN"
                let p = prompt(String.fromCharCode(77, 97, 115, 117, 107, 107, 97, 110, 32, 80, 73, 78));
                // Obfuscated "cendikiaadmin"
                if (p === atob('Y2VuZGlraWFhZG1pbg==')) {
                    window.location.href = "{{ route('login') }}";
                    // Obfuscated "cendikiaguru"
                } else if (p === atob('Y2VuZGlraWFndXJ1')) {
                    window.location.href = "{{ route('login.guru') }}";
                } else if (p) { // Hanya tampilkan alert jika user memasukkan sesuatu
                    alert("PIN salah!");
                }
            }

            // CTRL + ALT + L for desktop
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.altKey && e.key.toLowerCase() === 'l') {
                    e.preventDefault();
                    promptPIN();
                }
            });

            // Tap logo 3x for mobile
            let tapCount = 0;
            let tapTimer;
            const logo = document.getElementById('logoCendikia');
            logo.addEventListener('click', function() {
                tapCount++;
                clearTimeout(tapTimer);
                if (tapCount >= 3) {
                    promptPIN();
                    tapCount = 0;
                } else {
                    tapTimer = setTimeout(() => {
                        tapCount = 0;
                    }, 1000); // Reset count if no tap within 1 second
                }
            });
        })();
    </script>
</body>

</html>
