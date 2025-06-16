@extends('layouts.template.master')

@section('title', 'Guru')
@section('content')
    <div class="layout-page">
        <!-- Navbar -->
        <x-navbar></x-navbar>
        <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4">
                    Absensi
                </h4>
                <div class="card">
                    <div class="card-body">
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <h4 class="mb-4">Absensi Kelas {{ $jadwal->kelasbelajar->nama_kelas ?? 'Tidak Ditemukan' }}
                                {{ $jadwal->mapel->name }}</h4>
                            <h4 class="mb-4">Materi Pelajaran {{ $jadwal->materi }}</h4>
                            <div class="mb-4">
                                <strong>Hari / Tanggal:</strong> {{ $jadwal->hari }},
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}<br>
                                <strong>Jam:</strong> {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </div>

                            <form action="{{ route('guru.absen.update', $jadwal->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Status Absen</th>
                                            <th>Keterangan (Opsional)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($siswas->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">
                                                    Tidak ada murid yang terdaftar di kelas ini!
                                                </td>
                                            </tr>
                                        @else
                                            @php $no = 1; @endphp
                                            @foreach ($siswas as $siswa)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $siswa->user->name }}</td>
                                                    <td>
                                                        @php
                                                            $selectedStatus =
                                                                old("absen.{$siswa->id}.status") ??
                                                                ($absens[$siswa->id]->status ?? '');
                                                        @endphp
                                                        <select name="absen[{{ $siswa->id }}][status]"
                                                            class="form-select" required>
                                                            <option value="HADIR"
                                                                {{ $selectedStatus == 'HADIR' ? 'selected' : '' }}>Hadir
                                                            </option>
                                                            <option value="IZIN"
                                                                {{ $selectedStatus == 'IZIN' ? 'selected' : '' }}>Izin
                                                            </option>
                                                            <option value="TANPA KETERANGAN"
                                                                {{ $selectedStatus == 'TANPA KETERANGAN' ? 'selected' : '' }}>
                                                                Tanpa Keterangan</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="absen[{{ $siswa->id }}][keterangan]"
                                                            class="form-control" placeholder="Opsional">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                @if ($siswas->isNotEmpty())
                                    <button type="submit" class="btn btn-primary mt-3">Simpan Absen</button>
                                @endif
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!--/ Bordered Table -->
        </div>
    </div>
@endsection
