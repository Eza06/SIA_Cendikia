@extends('layouts.template.master')

@section('title', 'Tambah Siswa')
@section('content')

    <div class="layout-page">
        <x-navbar></x-navbar>
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data Siswa /</span> Tambah Baru</h4>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Formulir Pendaftaran Siswa Baru</h5>
                    </div>
                    <div class="card-body">
                        {{-- Menampilkan error validasi jika ada --}}
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

                        <form action="{{ route('admin.siswa.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                {{-- Kolom Kiri - Informasi Pribadi & Akun --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap siswa" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                     <div class="mb-3">
                                        <label for="no_telpon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="no_telpon" name="no_telpon" value="{{ old('no_telpon') }}" placeholder="08xxxxxxxxxx" required>
                                    </div>
                                </div>

                                {{-- Kolom Kanan - Informasi Akademik & Personal --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="asal_sekolah" class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah') }}" placeholder="Contoh: SMPN 1 Jakarta" required>
                                    </div>
                                     <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                            <option value="LAKI-LAKI" {{ old('jenis_kelamin') == 'LAKI-LAKI' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="PEREMPUAN" {{ old('jenis_kelamin') == 'PEREMPUAN' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="education_level" class="form-label">Jenjang Pendidikan <span class="text-danger">*</span></label>
                                        <select class="form-select" id="education_level" name="education_level" required>
                                            <option value="" disabled selected>-- Pilih Jenjang --</option>
                                            <option value="SD" {{ old('education_level') == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('education_level') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ old('education_level') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="kelas-container" style="display: none;">
                                        <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kelas" name="kelas" required disabled>
                                            <option value="" disabled selected>-- Pilih Kelas --</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelas_belajar_id" class="form-label">Kelas Belajar <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kelas_belajar_id" name="kelas_belajar_id" required>
                                            <option value="" disabled selected>-- Pilih Kelas Belajar --</option>
                                            @foreach($kelasBelajar as $kelas)
                                                <option value="{{ $kelas->id }}" {{ old('kelas_belajar_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap siswa" required>{{ old('alamat') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan Data Siswa</button>
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
            const oldKelas = "{{ old('kelas') }}";

            kelasDropdown.empty().append('<option value="" disabled selected>-- Pilih Kelas --</option>');

            if (jenjang) {
                kelasContainer.show();
                kelasDropdown.prop('disabled', false);

                let start, end;
                if (jenjang === 'SD') { [start, end] = [1, 6]; }
                else if (jenjang === 'SMP') { [start, end] = [7, 9]; }
                else if (jenjang === 'SMA') { [start, end] = [10, 12]; }

                if (start && end) {
                    for (let i = start; i <= end; i++) {
                        const isSelected = i == oldKelas ? 'selected' : '';
                        kelasDropdown.append(`<option value="${i}" ${isSelected}>${i}</option>`);
                    }
                }
            } else {
                kelasContainer.hide();
                kelasDropdown.prop('disabled', true);
            }
        }

        jenjangDropdown.on('change', updateKelasDropdown);

        if (jenjangDropdown.val()) {
            updateKelasDropdown();
        }
    });
</script>
@endpush

