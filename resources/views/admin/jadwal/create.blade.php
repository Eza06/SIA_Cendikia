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
                    <h5 class="card-header mb-2">Tambah Jadwal</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.jadwal.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="mapel_id" class="mb-2">Mata Pelajaran</label>
                                <select class="form-control" name="mapel_id" id="mapel_id" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach ($mapel as $m)
                                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                                    @endforeach
                                </select>
                                @error('mapel_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="guru_id" class="mb-2">Nama Guru</label>
                                <select name="guru_id" id="guru_id" class="form-control" required>
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($guru as $g)
                                        @php
                                            $mapelIds = $g->mapels->pluck('id')->implode(',');
                                        @endphp
                                        <option value="{{ $g->id }}" data-mapel-ids="{{ $mapelIds }}"
                                            data-jenjang="{{ $g->jenjang }}">
                                            {{ $g->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guru_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="form-group mb-3">
                                <label for="education_level" class="mb-2">Jenjang Pendidikan</label>
                                <select class="form-control" name="jenjang" id="education_level" required>
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
                                <select name="kelas" id="kelas" class="form-control" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <!-- Otomatis terisi berdasarkan jenjang -->
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
                                <label for="tanggal" class="mb-2">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                                @error('tanggal')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="hari" class="mb-2">Hari</label>
                                <input type="text" class="form-control" id="hari" name="hari" readonly>
                            </div>



                            <div class="form-group mb-3">
                                <label for="jam_mulai" class="mb-2">Jam Mulai</label>
                                <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" required>
                                @error('jam_mulai')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="jam_selesai" class="mb-2">Jam Selesai</label>
                                <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" required>
                                @error('jam_selesai')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="ruangan" class="mb-2">Ruangan</label>
                                <input type="text" class="form-control" name="ruangan" id="ruangan"
                                    placeholder="Masukkan Ruangan" required>
                                @error('ruangan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const mapelSelect = document.getElementById('mapel_id');
            const guruSelect = document.getElementById('guru_id');
            const allGuruOptions = Array.from(guruSelect.options).slice(1); // semua kecuali placeholder

            mapelSelect.addEventListener('change', function() {
                const selectedMapelId = this.value;
                guruSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';

                allGuruOptions.forEach(option => {
                    const mapelIds = option.dataset.mapelIds?.split(',') || [];
                    if (mapelIds.includes(selectedMapelId)) {
                        guruSelect.appendChild(option);
                    }
                });
            });
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenjangSelect = document.getElementById('education_level');
            const kelasSelect = document.getElementById('kelas');

            const kelasByJenjang = {
                SD: ['1', '2', '3', '4', '5', '6'],
                SMP: ['7', '8', '9'],
                SMA: ['10', '11', '12']
            };

            jenjangSelect.addEventListener('change', function() {
                const jenjang = this.value;
                const kelasOptions = kelasByJenjang[jenjang] || [];

                // Hapus semua opsi lama
                kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';

                // Tambahkan opsi baru
                kelasOptions.forEach(kelas => {
                    const option = document.createElement('option');
                    option.value = kelas;
                    option.text = kelas;
                    kelasSelect.appendChild(option);
                });
            });
        });
    </script>
