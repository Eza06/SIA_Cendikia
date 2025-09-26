@extends('layouts.template.master')

@section('title', 'Edit Siswa')
@section('content')

    <div class="layout-page">
        <x-navbar></x-navbar>
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data Siswa /</span> Edit Data</h4>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Formulir Edit Data Siswa</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6 class="alert-heading mb-1">Terdapat Kesalahan Validasi:</h6>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                {{-- Kolom Kiri - Informasi Pribadi & Akun --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $siswa->user->name) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $siswa->user->email) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak diubah">
                                    </div>
                                     <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="" disabled>-- Pilih --</option>
                                            <option value="LAKI-LAKI" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'LAKI-LAKI' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="PEREMPUAN" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'PEREMPUAN' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_telpon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="no_telpon" name="no_telpon" value="{{ old('no_telpon', $siswa->no_telpon) }}" required>
                                    </div>
                                </div>

                                {{-- Kolom Kanan - Informasi Akademik & Personal --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="asal_sekolah" class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="education_level" class="form-label">Jenjang Pendidikan <span class="text-danger">*</span></label>
                                        <select class="form-select" id="education_level" name="education_level" required>
                                            <option value="" disabled>-- Pilih Jenjang --</option>
                                            <option value="SD" {{ old('education_level', $siswa->education_level) == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('education_level', $siswa->education_level) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ old('education_level', $siswa->education_level) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="kelas-container">
                                        <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kelas" name="kelas" required>
                                            <option value="" disabled>-- Pilih Kelas --</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelas_belajar_id" class="form-label">Kelas Belajar <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kelas_belajar_id" name="kelas_belajar_id" required>
                                            <option value="" disabled>-- Pilih Kelas Belajar --</option>
                                            @foreach($kelasBelajar as $kelas)
                                                <option value="{{ $kelas->id }}" {{ old('kelas_belajar_id', $siswa->kelas_belajar_id) == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Update Data Siswa</button>
                                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        const jenjangDropdown = $('#education_level');
        const kelasDropdown = $('#kelas');
        const kelasContainer = $('#kelas-container');

        function updateKelasDropdown() {
            const jenjang = jenjangDropdown.val();
            // [PENTING] Ambil nilai kelas yang tersimpan di database
            const currentKelas = "{{ old('kelas', $siswa->kelas) }}";

            kelasDropdown.empty().append('<option value="" disabled>-- Pilih Kelas --</option>');

            if (jenjang) {
                kelasContainer.show();
                kelasDropdown.prop('disabled', false);

                let start, end;
                if (jenjang === 'SD') { [start, end] = [1, 6]; }
                else if (jenjang === 'SMP') { [start, end] = [7, 9]; }
                else if (jenjang === 'SMA') { [start, end] = [10, 12]; }

                if (start && end) {
                    for (let i = start; i <= end; i++) {
                        // Cek apakah 'i' sama dengan kelas yang tersimpan, jika ya, beri 'selected'
                        const isSelected = i == currentKelas ? 'selected' : '';
                        kelasDropdown.append(`<option value="${i}" ${isSelected}>${i}</option>`);
                    }
                }
            } else {
                kelasContainer.hide();
                kelasDropdown.prop('disabled', true);
            }
        }

        // Jalankan fungsi saat pilihan jenjang berubah
        jenjangDropdown.on('change', updateKelasDropdown);

        // [SANGAT PENTING] Jalankan fungsi ini saat halaman pertama kali dimuat
        // Ini akan mengisi dropdown kelas berdasarkan jenjang yang sudah ada
        updateKelasDropdown();
    });
</script>
@endpush
