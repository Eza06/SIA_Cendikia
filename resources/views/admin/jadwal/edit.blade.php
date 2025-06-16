@extends('layouts.template.master')

@section('content')
<div class="layout-page">
    <x-navbar></x-navbar>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <h5 class="card-header mb-2">Edit Jadwal</h5>
                <div class="card-body">
                    <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="mapel_id" class="mb-2">Mata Pelajaran</label>
                            <select class="form-control" name="mapel_id" id="mapel_id" required>
                                <option value="">-- Pilih Mapel --</option>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}" {{ old('mapel_id', $jadwal->mapel_id) == $m->id ? 'selected' : '' }}>
                                        {{ $m->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="guru_id" class="mb-2">Nama Guru</label>
                            <select name="guru_id" id="guru_id" class="form-control" required>
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($guru as $g)
                                    <option value="{{ $g->id }}"
                                        data-mapel-id="{{ $g->mapel_id }}"
                                        data-jenjang="{{ $g->jenjang }}"
                                        {{ old('guru_id', $jadwal->guru_id) == $g->id ? 'selected' : '' }}>
                                        {{ $g->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenjang" class="mb-2">Jenjang Pendidikan</label>
                            <input type="text" class="form-control" id="jenjang" name="jenjang"
                                   value="{{ old('jenjang', $jadwal->jenjang) }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelas" class="mb-2">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                @php
                                    $jenjang = old('jenjang', $jadwal->jenjang);
                                    $kelasOptions = match($jenjang) {
                                        'SD' => ['1', '2', '3', '4', '5', '6'],
                                        'SMP' => ['7', '8', '9'],
                                        'SMA' => ['10', '11', '12'],
                                        default => []
                                    };
                                @endphp
                                @foreach ($kelasOptions as $kelas)
                                    <option value="{{ $kelas }}" {{ old('kelas', $jadwal->kelas) == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kelas" class="mb-2">Kelas Belajar</label>
                            <select class="form-control" name="kelas_belajar_id" id="kelas_belajar_id" required>
                                <option value="">-- Pilih Kelas Belajar --</option>
                                @foreach ($kelasBelajar as $kelas)
                                    <option value="{{ $kelas->id }}" {{ old('kelas_belajar_id') == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_belajar_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="tanggal" class="mb-2">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal"
                                   value="{{ old('tanggal', $jadwal->tanggal) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="hari" class="mb-2">Hari</label>
                            <input type="text" class="form-control" id="hari" name="hari"
                                   value="{{ old('hari', $jadwal->hari) }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jam_mulai" class="mb-2">Jam Mulai</label>
                            <input type="time" class="form-control" name="jam_mulai" id="jam_mulai"
                                   value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jam_selesai" class="mb-2">Jam Selesai</label>
                            <input type="time" class="form-control" name="jam_selesai" id="jam_selesai"
                                   value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="materi" class="mb-2">Materi</label>
                            <textarea class="form-control" name="materi" id="materi" rows="3" required>{{ old('materi', $jadwal->materi) }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ruangan" class="mb-2">Ruangan</label>
                            <input type="text" class="form-control" name="ruangan" id="ruangan"
                                   value="{{ old('ruangan', $jadwal->ruangan) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Perbarui Jadwal</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const mapelSelect = document.getElementById('mapel_id');
            const guruSelect = document.getElementById('guru_id');
            const jenjangInput = document.getElementById('jenjang');

            // Simpan semua opsi guru
            const allGuruOptions = Array.from(guruSelect.options).slice(1); // kecuali placeholder

            mapelSelect.addEventListener('change', function() {
                const selectedMapelId = this.value;

                // Reset dropdown guru
                guruSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';
                jenjangInput.value = '';

                // Filter guru yang mapel_id nya sesuai mapel yang dipilih
                allGuruOptions.forEach(option => {
                    if (option.getAttribute('data-mapel-id') === selectedMapelId) {
                        guruSelect.appendChild(option);
                    }
                });
            });

            // Saat guru dipilih, tampilkan jenjangnya
            guruSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (!selectedOption || !selectedOption.getAttribute) {
                    jenjangInput.value = '';
                    return;
                }
                const jenjang = selectedOption.getAttribute('data-jenjang') || '';
                jenjangInput.value = jenjang;
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenjangInput = document.getElementById('jenjang');
            const kelasSelect = document.getElementById('kelas');

            const kelasByJenjang = {
                'SD': ['1', '2', '3', '4', '5', '6'],
                'SMP': ['7', '8', '9'],
                'SMA': ['10', '11', '12']
            };

            // Karena jenjang input readonly, kita buat event manual supaya trigger kelas update:
            // Pas guru dipilih, jenjang akan berubah → trigger isi kelas
            const updateKelasOptions = () => {
                const jenjang = jenjangInput.value;
                kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
                if (kelasByJenjang[jenjang]) {
                    kelasByJenjang[jenjang].forEach(kelas => {
                        const opt = document.createElement('option');
                        opt.value = kelas;
                        opt.textContent = kelas;
                        kelasSelect.appendChild(opt);
                    });
                }
            };

            // Panggil update kelas setiap jenjang berubah (dalam kasus ini, saat guru dipilih)
            // Jadi tambahkan di event guruSelect change
            const guruSelect = document.getElementById('guru_id');
            guruSelect.addEventListener('change', updateKelasOptions);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalInput = document.getElementById('tanggal');
            const hariInput = document.getElementById('hari');

            tanggalInput.addEventListener('change', function() {
                const tanggal = new Date(this.value);
                if (!isNaN(tanggal.getTime())) {
                    const hariIndonesia = tanggal.toLocaleDateString('id-ID', {
                        weekday: 'long'
                    });
                    hariInput.value = hariIndonesia.charAt(0).toUpperCase() + hariIndonesia.slice(1);
                } else {
                    hariInput.value = '';
                }
            });
        });
    </script>
