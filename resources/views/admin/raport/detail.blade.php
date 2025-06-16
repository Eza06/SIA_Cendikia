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
                    <div class="card-header">Detail Raport</div>
                    <div class="card-body">
                        <form action="#" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nama_rapor" class="form-label">Nama Raport</label>
                                <input type="text" name="nama_rapor" id="nama_rapor" class="form-control"
                                    value="{{ old('nama_rapor', $rapor->nama_rapor) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="angkatan_id" class="form-label">Tahun Ajaran</label>
                                <select name="angkatan_id" id="angkatan_id" class="form-control" disabled>
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    @foreach ($angkatans as $angkatan)
                                        <option value="{{ $angkatan->id }}"
                                            {{ $rapor->angkatan_id == $angkatan->id ? 'selected' : '' }}>
                                            {{ $angkatan->tahun_angkatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select name="semester" id="semester" class="form-control" disabled>
                                    <option value="Ganjil" {{ $rapor->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil
                                    </option>
                                    <option value="Genap" {{ $rapor->semester == 'Genap' ? 'selected' : '' }}>Genap
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="kelas_belajar_id" class="form-label">Kelas</label>
                                <select name="kelas_belajar_id" id="kelas_belajar_id" class="form-control" disabled>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelasBelajar as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ $rapor->kelas_belajar_id == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            
                            @if (count($siswas) > 0)
                                <h5 class="mt-4">Nilai Siswa</h5>
                                <div class="row mt-3">
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
                                                                        value="{{ $nilaiRaport[$siswa->id][$mapel->id]->nilai ?? '' }}"
                                                                        min="0" max="100" readonly>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <a href="{{ route('admin.raport.cetak.siswa', ['rapor' => $rapor->id, 'siswa' => $siswa->id]) }}"
                                                    class="btn btn-info btn-sm mt-2" target="_blank">
                                                    <i class="bx bx-printer"></i> Cetak Raport
                                                 </a>
                                                 
                                                                                                                         
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif


                            <a href="{{ route('admin.raport.index') }}" class="btn btn-secondary">Kembali</a>
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
