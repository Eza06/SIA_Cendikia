@extends('layouts.template.master')

@section('content')
<div class="layout-page">
    <x-navbar></x-navbar>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <h5 class="card-header">Tambah Guru</h5>
                <div class="card-body">
                    <form action="{{ route('admin.guru.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name">Nama Guru</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Jenis Kelamin</label>
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input type="radio" name="jenis_kelamin" id="laki" class="form-check-input" value="laki-laki" required>
                                    <label class="form-check-label" for="laki">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="jenis_kelamin" id="perempuan" class="form-check-input" value="perempuan">
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                            @error('jenis_kelamin') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>


                        <div class="form-group mb-3">
                            <label class="mb-2">Mata Pelajaran</label>
                            <div>
                                @foreach($mapel as $mapels)
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="mapel_id[]" 
                                            value="{{ $mapels->id }}" 
                                            id="mapel{{ $mapels->id }}"
                                            {{ (is_array(old('mapel_id')) && in_array($mapels->id, old('mapel_id'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mapel{{ $mapels->id }}">
                                            {{ $mapels->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('mapel_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        
                        

                        {{-- <div class="form-group mb-3">
                            <label for="education_level">Jenjang Pendidikan</label>
                            <select class="form-control" name="jenjang" id="education_level" required>
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                            </select>
                            @error('jenjang') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">ء
                            <label for="kelas">Kelas</label>
                            <select class="form-control" name="kelas" id="kelas" required>
                                <option value="">-- Pilih Kelas --</option>
                            </select>
                            @error('kelas') <div class="text-danger">{{ $message }}</div> @enderror
                        </div> --}}

                        <div class="form-group mb-3">
                            <label for="no_telpon">Nomor Telepon</label>
                            <input type="text" class="form-control" name="no_telpon" id="no_telpon">
                            @error('no_telpon') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
                            @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email Guru</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password Akun</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Simpan Guru</button>
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

    const kelasByJenjang = {
        SD: ['1', '2', '3', '4', '5', '6'],
        SMP: ['7', '8', '9'],
        SMA: ['10', '11', '12']
    };

    jenjangSelect.addEventListener('change', function () {
        const jenjang = this.value;
        const kelasOptions = kelasByJenjang[jenjang] || [];
        kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
        kelasOptions.forEach(kelas => {
            const option = document.createElement('option');
            option.value = kelas;
            option.text = kelas;
            kelasSelect.appendChild(option);
        });
    });
});
</script>
@endpush
