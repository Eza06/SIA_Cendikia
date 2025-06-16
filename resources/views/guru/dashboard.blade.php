@extends('layouts.template.master')

@section('title', 'Guru')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>:
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif
    <div class="layout-page">

        <!-- Navbar -->
        <x-navbar></x-navbar>
        <!-- / Navbar -->
        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="col-lg-8 mb-4 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Selamat Datang
                                            {{ $user->name }}
                                            🎉</h5>
                                        <p class="mb-4">
                                            Semoga Harimu Menyenangkan!!
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="{{ asset('sneat') }}/assets/img/illustrations/man-with-laptop-light.png"
                                            height="140" alt="View Badge User"
                                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4 col-md-4 order-1">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <img src="{{ asset('sneat') }}/assets/img/icons/unicons/chart-success.png"
                                                    alt="chart success" class="rounded" />
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Total Jadwal</span>
                                        <h3 class="card-title mb-2">{{$totalJadwal}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <img src="{{ asset('sneat') }}/assets/img/icons/unicons/wallet-info.png"
                                                    alt="chart success" class="rounded" />
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Total Mata Pelajaran</span>
                                        <h3 class="card-title mb-2">{{$totalMapel}}</h3>
                                        <small class="text-success fw-semibold"><strong></strong></small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    @forelse ($jadwals as $jadwal)
                        <div class="col-md-6 col-xl-6 mb-4"> {{-- 2 kolom per baris di layar besar --}}
                            <div class="card mt-3 shadow-sm border-0">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bx bx-calendar bx-sm text-primary"></i>
                                        <h5 class="mb-0">Jadwal Mengajar : {{ $jadwal->mapel->name }}</h5>
                                    </div>
                                    @if ($jadwal->status == 'AKTIF')
                                        <span class="badge bg-success">AKTIF</span>
                                    @else
                                        <span class="badge bg-danger">NonAktif</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div><i class="bx bx-time-five me-2 text-info"></i><strong>Hari / Tanggal : </strong>
                                        {{ $jadwal->hari }},
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}</div>
                                    <hr>
                                    <div><i class="bx bx-time me-2 text-info"></i><strong>Jam : </strong>
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</div>
                                    <hr>
                                    <div><i class="bx bx-bar-chart-alt me-2 text-warning"></i><strong>Jenjang : </strong>
                                        {{ $jadwal->jenjang }}</div>
                                    <hr>
                                    <div><i class="bx bx-group me-2 text-primary"></i><strong>Kelas : </strong>
                                        {{ $jadwal->kelas }}</div>
                                    <hr>
                                    <div><i class="bx bx-building-house me-2 text-secondary"></i><strong>Ruangan : </strong>
                                        {{ $jadwal->ruangan }}</div>
                                    <hr>
                                    <div class="mb-2">
                                        <i class="bx bx-book-content me-2 text-success"></i><strong>Materi:</strong>
                                        <form action="{{ route('guru.jadwal.materi.update', $jadwal->id) }}" method="POST" class="d-inline-flex align-items-center ms-2" style="gap: 8px;">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="materi" value="{{ old('materi', $jadwal->materi) }}" class="form-control form-control-sm" style="width: 300px;" placeholder="Isi materi...">
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                    <hr>
                                    
                                    
                                    
                                    <div class="mt-3 text-end">
                                        @if ($jadwal->status == 'AKTIF')
                                            <a href="{{ route('guru.absen.edit', $jadwal->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bx bx-check-circle me-1"></i> Masuk Halaman Absen
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="bx bx-lock me-1"></i> Jadwal Tidak Aktif
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h5 class="text-muted"><i class="bx bx-calendar-x me-2"></i>Tidak ada jadwal mengajar</h5>
                        </div>
                    @endforelse
                </div>
                
            </div>
        @endsection
            