@extends('layouts.template.master')

@section('title', 'Admin')
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
                                            Kamu mendapatkan Notifikasi
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
                                                <i class="menu-icon tf-icons bx bx-book-reader fs-1"></i>
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Total Siswa</span>
                                        <h3 class="card-title mb-2">{{ $jumlahSiswa }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <i class="menu-icon tf-icons bx bx-user-voice fs-1"></i>
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Total Guru</span>
                                        <h3 class="card-title mb-2">{{ $jumlahGuru }}</h3>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4 col-xl-6 order-0 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('sneat') }}/assets/img/icons/unicons/chart.png" alt="Rate Kehadiran" class="rounded" />
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Rate Kehadiran Siswa</span>
                                <h3 class="card-title mb-2">{{ $rateHadir }}%</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-6 order-0 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="menu-icon tf-icons bx bx-book-open fs-1"></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Mata Pelajaran</span>
                                <h3 class="card-title mb-2">{{ $mapelAll }}</h3>
                            </div>
                        </div>
                    </div>
                    <!--- Status Tagihan -->
                </div>
                  
            </div>
        </div>
        @endsection