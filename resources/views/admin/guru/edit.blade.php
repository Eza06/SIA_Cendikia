@extends('layouts.template.master')

@section('content')
<div class="layout-page">
    <x-navbar></x-navbar>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <h5 class="card-header">Edit Data Guru</h5>
                <div class="card-body">
                    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $guru->user->name) }}" required>
                            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Jenis Kelamin</label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input type="radio" class="form-check-input" name="jenis_kelamin" id="laki" value="laki-laki" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'laki-laki' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="laki">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="jenis_kelamin" id="perempuan" value="perempuan" {{ old('jenis_kelamin', $guru->jenis_kelamin) === 'perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                            @error('jenis_kelamin')<div class="text-danger">{{ $message }}</div>@enderror
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
                                            {{ 
                                                (is_array(old('mapel_id')) && in_array($mapels->id, old('mapel_id'))) 
                                                || (!old('mapel_id') && $guru->mapels->contains($mapels->id))
                                                ? 'checked' : '' 
                                            }}>
                                        <label class="form-check-label" for="mapel{{ $mapels->id }}">
                                            {{ $mapels->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('mapel_id')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        

                        <div class="form-group mb-3">
                            <label for="no_telpon">Nomor Telepon</label>
                            <input type="text" class="form-control" name="no_telpon" id="no_telpon" value="{{ old('no_telpon', $guru->no_telpon) }}">
                            @error('no_telpon')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3">{{ old('alamat', $guru->alamat) }}</textarea>
                            @error('alamat')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" 
                                value="{{ old('email', $guru->user->email ?? '') }}" placeholder="email@domain.com" required>
                            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" name="password" id="password">
                            @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Update Data Guru</button>
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
        const currentKelas = "{{ old('kelas', $guru->kelas) }}";

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
        populateKelas(); // initial load
    });
</script>
@endpush
