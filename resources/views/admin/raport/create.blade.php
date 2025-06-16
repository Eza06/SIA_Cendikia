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
                    <h5 class="card-header mb-2">Buat Raport</h5>
                    <div class="card-body">
                        <form action="{{ route('admin.raport.store') }}" method="POST">

                            @csrf
                            <div class="form-group mb-3">
                                <label for="nama_rapor" class="mb-2">Nama Raport</label>
                                <input type="text" class="form-control" name="nama_rapor" id="nama_rapor"
                                    placeholder="cth Raport TO semester 2 tahun ajaran 2024/2025" required>
                                @error('nama_rapor')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="angkatan_id" class="mb-2">Tahun Ajaran</label>
                                <select class="form-control" name="angkatan_id" id="angkatan_id" required>
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    @foreach ($angkatan as $m)
                                        <option value="{{ $m->id }}">{{ $m->tahun_angkatan }}</option>
                                    @endforeach
                                </select>
                                @error('angkatan_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="semester" class="mb-2">Semester</label>
                                <select class="form-control" name="semester" id="semester" required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                                @error('kelas_belajar_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="kelas_belajar" class="mb-2">Kelas Belajar</label>
                                <select name="kelas_belajar_id" id="kelas_belajar_id" class="form-control"
                                    onchange="getKelasBelajar()">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelasBelajar as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ request('kelas_belajar_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            @if (count($siswas) > 0)
                                <h5 class="mt-4">Input Nilai</h5>
                                <div class="row mt-4">
                                    @foreach ($siswas as $siswa)
                                        <div class="col-md-6">
                                            <div class="card mb-3 p-3">
                                                <div><strong>NAMA : </strong>
                                                    {{ strtoupper($siswa->user->name) }}</div>
                                                <hr>
                                                <div><strong>KODE SISWA : </strong>
                                                    {{ strtoupper($siswa->kode_siswa) }}
                                                </div>
                                                <hr>
                                                <div><strong>JENJANG PENDIDIKAN : </strong>
                                                    {{ strtoupper($siswa->education_level) }}</div>
                                                <hr>
                                                <div><strong>KELAS : </strong>
                                                    {{ strtoupper($siswa->kelas) }}
                                                </div>
                                                <hr>

                                                <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                                <table class="table table-bordered mt-2">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Mapel</th>
                                                            <th>Nilai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($mapels as $index => $mapel)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $mapel->name }}</td>
                                                                <td>
                                                                    <input type="number" class="form-control"
                                                                        name="nilai[{{ $siswa->id }}][{{ $mapel->id }}]"
                                                                        placeholder="0-100" min="0" max="100"
                                                                        required>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-danger text-center mt-4">
                                    Tidak ada data murid untuk kelas yang dipilih.
                                </div>
                            @endif


                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Simpan Raport</button>
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
        function getKelasBelajar() {
            const selected = document.getElementById('kelas_belajar_id').value;
            const url = new URL(window.location.href);
            url.searchParams.set('kelas_belajar_id', selected);
            window.location.href = url.toString();
        }
    </script>
@endpush
