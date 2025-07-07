@extends('layouts.template.master')

@section('content')
    <!-- Layout wrapper -->
    <!-- Sidebar -->

    <!-- Layout container -->
    <div class="layout-page">
        <!-- Navbar -->
        <x-navbar></x-navbar>
        <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <!-- Bordered Table -->
                <div class="card">
                    <h5 class="card-header">Tambah Murid</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.siswa.store') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="name" class="mb-2">Nama</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan Nama" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="" class="mb-2">Jenis Kelamin</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input type="radio" class="form-check-input" name="jenis_kelamin" id="laki" value="laki-laki" required>
                                            <label class="form-check-label" for="laki">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="jenis_kelamin" id="perempuan" value="perempuan">
                                            <label class="form-check-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                    @error('jenis_kelamin')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="no_telpon" class="mb-2">Asal Sekolah</label>
                                    <input type="text" class="form-control" name="asal_sekolah" id="asal_sekolah">
                                    @error('asal_sekolah')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group mb-3">
                                        <label for="education_level" class="mb-2">Jenjang Pendidikan</label>
                                        <select class="form-control" name="education_level" id="education_level" required>
                                            <option value="">-- Pilih Jenjang --</option>
                                            <option value="SD">SD</option>
                                            <option value="SMP">SMP</option>
                                            <option value="SMA">SMA</option>
                                        </select>
                                        @error('education_level')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="kelas" class="mb-2">Kelas</label>
                                        <select class="form-control" name="kelas" id="kelas" required>
                                            <option value="">-- Pilih Kelas --</option>
                                            <!-- Akan terisi otomatis berdasarkan jenjang -->
                                        </select>
                                        @error('kelas')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="kelas" class="mb-2">Kelas Belajar</label>
                                        <select class="form-control" name="kelas_belajar_id" id="kelas_belajar_id" required>
                                            <option value="">-- Pilih Kelas Belajar --</option>
                                            @foreach ($kelasBelajar as $kelas)
                                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                        @error('kelas_belajar_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                <div class="form-group mb-3">
                                    <label for="no_telpon" class="mb-2">Nomor Telepon Siswa/Wali Siswa</label>
                                    <input type="text" class="form-control" name="no_telpon" id="no_telpon" placeholder="08xxxxxxxxxx" required>
                                    @error('no_telpon')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="alamat" class="mb-2">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamat" placeholder="Masukkan Alamat" rows="3"></textarea>
                                    @error('alamat')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email" class="mb-2">Email Murid</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="email@domain.com" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="mb-2">Password Akun</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="mb-2">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                                </div>

                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-primary">Simpan Murid</button>
                                </div>
                            </form>

                    </div>
                </div>
            </div>
            <!--/ Bordered Table -->
        </div>
    </div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jenjangSelect = document.getElementById('education_level');
        const kelasSelect = document.getElementById('kelas');
        const kelasBelajarSelect = document.getElementById('kelas_belajar_id');

        const kelasByJenjang = {
            SD: ['1', '2', '3', '4', '5', '6'],
            SMP: ['7', '8', '9'],
            SMA: ['10', '11', '12']
        };

        // Simpan semua opsi awal kelas belajar
        const allKelasBelajarOptions = Array.from(kelasBelajarSelect.querySelectorAll('option'));

        let currentJenjang = '';

        jenjangSelect.addEventListener('change', function () {
            currentJenjang = this.value;
            const kelasOptions = kelasByJenjang[currentJenjang] || [];

            // Reset kelas & kelas belajar
            kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
            kelasBelajarSelect.innerHTML = '<option value="">-- Pilih Kelas Belajar --</option>';

            // Tambah kelas sesuai jenjang
            kelasOptions.forEach(kelas => {
                const option = document.createElement('option');
                option.value = kelas;
                option.textContent = kelas;
                kelasSelect.appendChild(option);
            });
        });

        kelasSelect.addEventListener('change', function () {
            const selectedKelas = this.value;
            kelasBelajarSelect.innerHTML = '<option value="">-- Pilih Kelas Belajar --</option>';

            allKelasBelajarOptions.forEach(option => {
                if (!option.value) return;

                const nama = option.textContent.trim(); // contoh: "6-1" atau "10 IPA"
                const regex = new RegExp('^' + selectedKelas + '([\\s\\-]|$)');

                if (regex.test(nama) && kelasByJenjang[currentJenjang].includes(selectedKelas)) {
                    kelasBelajarSelect.appendChild(option.cloneNode(true));
                }
            });
        });
    });
</script>
@endpush
