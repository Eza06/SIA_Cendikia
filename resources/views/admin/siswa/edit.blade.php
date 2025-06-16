@extends('layouts.template.master')

@section('content')
    <div class="layout-page">
        <x-navbar></x-navbar>
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                    <h5 class="card-header">Edit Murid</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="name" class="mb-2">Nama</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $siswa->user->name) }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="mb-2">Jenis Kelamin</label>
                                <div class="d-flex align-items-center">
                                    <div class="form-check me-3">
                                        <input type="radio" class="form-check-input" name="jenis_kelamin" id="laki" value="laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'laki-laki' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="laki">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="jenis_kelamin" id="perempuan" value="perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'perempuan' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perempuan">Perempuan</label>
                                    </div>
                                </div>
                                @error('jenis_kelamin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="education_level" class="mb-2">Jenjang Pendidikan</label>
                                <select class="form-control" name="education_level" id="education_level" required>
                                    <option value="">-- Pilih Jenjang --</option>
                                    <option value="SD" {{ old('education_level', $siswa->education_level) === 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ old('education_level', $siswa->education_level) === 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ old('education_level', $siswa->education_level) === 'SMA' ? 'selected' : '' }}>SMA</option>
                                </select>
                                @error('education_level')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="kelas" class="mb-2">Kelas</label>
                                <select class="form-control" name="kelas" id="kelas" required>
                                    <option value="">-- Pilih Kelas --</option>
                                </select>
                                @error('kelas')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="kelas_belajar_id" class="mb-2">Kelas Belajar</label>
                                <select class="form-control" name="kelas_belajar_id" id="kelas_belajar_id" required>
                                    <option value="">-- Pilih Kelas Belajar --</option>
                                    @foreach ($kelasBelajar as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ old('kelas_belajar_id', $siswa->kelas_belajar_id) == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_belajar_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="asal_sekolah" class="mb-2">Asal Sekolah</label>
                                <input type="text" class="form-control" name="asal_sekolah" id="asal_sekolah" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}" required>
                                @error('asal_sekolah')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="no_telpon" class="mb-2">Nomor Telepon</label>
                                <input type="text" class="form-control" name="no_telpon" id="no_telpon" value="{{ old('no_telpon', $siswa->no_telpon) }}" required>
                                @error('no_telpon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="alamat" class="mb-2">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="mb-2">Email Murid</label>
                                <input type="email" class="form-control" name="email" id="email" 
                                    value="{{ old('email', $siswa->user->email ?? '') }}" placeholder="email@domain.com" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="password" class="mb-2">Password Akun</label>
                                <input type="password" class="form-control" name="password" id="password" 
                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Update Murid</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenjangSelect = document.getElementById('education_level');
            const kelasSelect = document.getElementById('kelas');
            const currentKelas = "{{ old('kelas', $siswa->kelas) }}";

            const kelasByJenjang = {
                SD: ['1', '2', '3', '4', '5', '6'],
                SMP: ['7', '8', '9'],
                SMA: ['10', '11', '12']
            };

            function populateKelas() {
                const jenjang = jenjangSelect.value;
                const kelasOptions = kelasByJenjang[jenjang] || [];

                kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
                kelasOptions.forEach(kelas => {
                    const option = document.createElement('option');
                    option.value = kelas;
                    option.text = kelas;
                    if (kelas === currentKelas) {
                        option.selected = true;
                    }
                    kelasSelect.appendChild(option);
                });
            }

            jenjangSelect.addEventListener('change', populateKelas);
            populateKelas();
        });
    </script>
@endpush