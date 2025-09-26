@extends('layouts.template.master')

@section('title', 'Admin Dashboard')
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
                    <!-- Kartu Ucapan Selamat Datang -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Selamat Datang {{ $user->name ?? 'Admin' }} 🎉</h5>
                                        <p class="mb-4">
                                            Selamat datang di dashboard admin. Berikut adalah ringkasan data terbaru dari sistem.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="{{ asset('sneat/assets/img/illustrations/man-with-laptop-light.png') }}"
                                            height="140" alt="View Badge User" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Kartu Ucapan Selamat Datang -->

                    <!-- Grafik Statistik Utama -->
                    <div class="col-lg-8 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Statistik Umum</h5>
                            </div>
                            <div class="card-body">
                                <div id="statistikUmumChart"></div>
                            </div>
                        </div>
                    </div>
                    <!--/ Grafik Statistik Utama -->

                    <!-- Grafik Pie Chart Kehadiran -->
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                             <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Ringkasan Kehadiran Siswa</h5>
                            </div>
                            <div class="card-body">
                                <div id="kehadiranPieChart"></div>
                            </div>
                        </div>
                    </div>
                    <!--/ Grafik Pie Chart Kehadiran -->
                </div>
            </div>
            <!-- / Content -->
            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
    </div>

@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof ApexCharts !== 'undefined') {

                // --- GRAFIK STATISTIK UMUM (TIDAK BERUBAH) ---
                var optionsBar = {
                    series: [{
                        name: 'Jumlah',
                        data: [{{ $jumlahSiswa }}, {{ $jumlahGuru }}, {{ $mapelAll }}]
                    }],
                    chart: { type: 'bar', height: 350, toolbar: { show: false } },
                    plotOptions: { bar: { horizontal: false, columnWidth: '55%', borderRadius: 7 } },
                    dataLabels: { enabled: false },
                    stroke: { show: true, width: 2, colors: ['transparent'] },
                    xaxis: { categories: ['Total Siswa', 'Total Guru', 'Total Mapel'] },
                    yaxis: { title: { text: 'Jumlah' } },
                    fill: { opacity: 1 },
                    tooltip: { y: { formatter: (val) => val } },
                    colors: ['#696cff', '#03c3ec', '#ffab00']
                };
                var chartBar = new ApexCharts(document.querySelector("#statistikUmumChart"), optionsBar);
                chartBar.render();


                // --- GRAFIK PIE CHART KEHADIRAN (DIPERBARUI) ---
                var optionsPie = {
                    // Diperbarui: Menggunakan 3 variabel persentase dari controller
                    series: [{{ $persentaseHadir ?? 0 }}, {{ $persentaseIzin ?? 0 }}, {{ $persentaseTanpaKeterangan ?? 0 }}],
                    // Diperbarui: Label disesuaikan dengan status Anda
                    labels: ['Hadir', 'Izin', 'Tanpa Keterangan'],
                    chart: {
                        type: 'pie',
                        height: 350
                    },
                    // Diperbarui: Warna disesuaikan untuk 3 kategori
                    colors: ['#28a745', '#03c3ec', '#ff3e1d'],
                    legend: {
                        position: 'bottom'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            // Menampilkan persentase dengan 1 angka di belakang koma
                            return val.toFixed(1) + "%"
                        },
                    },
                };
                var chartPie = new ApexCharts(document.querySelector("#kehadiranPieChart"), optionsPie);
                chartPie.render();

            } else {
                console.error("ApexCharts library failed to load. Check master.blade.php");
            }
        });
    </script>
@endpush

