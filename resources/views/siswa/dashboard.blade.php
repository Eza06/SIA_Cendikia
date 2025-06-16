@extends('layouts.template.master')

@section('title', 'Siswa')
@section('content')

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
                                        <h3 class="card-title mb-2">{{ $jadwal->count() }}</h3>
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
                                        <h3 class="card-title mb-2">{{ $mapelCount }}</h3>
                                        <small class="text-success fw-semibold"><strong></strong></small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3>Jadwal Bimbel</h3>
                    <div class="row">
                        @forelse ($jadwal as $item)
                            <div class="col-md-6 col-lg-4 mb-4"> 
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bx bx-calendar bx-sm text-primary"></i>
                                            <h5 class="mb-0">Jadwal {{ $item->mapel->name ?? '-' }} - Kelas
                                                {{ $item->kelasbelajar->nama_kelas ?? '-' }}</h5>
                                        </div>
                                        <span class="badge {{ $item->status == 'AKTIF' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>                                        
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2"><i class="bx bx-id-card me-2 text-info"></i>
                                            <strong>Nama Guru : </strong>
                                             {{ $item->guru->user->name }}</p>
                                            <hr>
                                        <p class="mb-2"><i class="bx bx-phone-call me-2 text-info"></i>
                                            <strong>Kontak Guru : </strong>
                                                {{ $item->guru->no_telpon }}</p>
                                            <hr>
                                        <p class="mb-2"><i class="bx bx-time-five me-2 text-info"></i><strong>Hari /
                                                Tanggal : </strong> {{ $item->hari }},
                                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</p>
                                            <hr>
                                        <p class="mb-2"><i class="bx bx-time me-2 text-info"></i><strong>Jam : </strong>
                                            {{ $item->jam_mulai }} - {{ $item->jam_selesai }}</p>
                                            <hr>
                                        <p class="mb-2"><i
                                                class="bx bx-bar-chart-alt me-2 text-warning"></i><strong>Jenjang : </strong>
                                            {{ $item->jenjang }}</p>
                                            <hr>
                                        <p class="mb-2"><i
                                                class="bx bx-group me-2 text-primary"></i><strong>Kelas : </strong>
                                            {{ $item->kelas }}</p>
                                            <hr>
                                        <p class="mb-2"><i
                                                class="bx bx-building-house me-2 text-secondary"></i><strong>Ruangan : </strong>
                                            {{ $item->ruangan }}</p>
                                            <hr>
                                        <p class="mb-2"><i
                                                class="bx bx-book-content me-2 text-success"></i><strong>Materi : </strong>
                                            {{ $item->materi ?? 'Materi Belum Terkonfirmasi'}}</p>
                                            <hr>
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
            </div>
        @endsection
