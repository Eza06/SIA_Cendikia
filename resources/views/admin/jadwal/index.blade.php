@extends('layouts.template.master')

@section('title', 'Jadwal')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <x-navbar></x-navbar>
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4"><i class="bx bx-calendar me-2"></i>Jadwal Mengajar</h4>

                <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary mb-4">
                    <i class='bx bx-add-to-queue me-1'></i> Tambah Jadwal
                </a>

                {{-- Filter --}}
                <form method="GET" action="{{ route('admin.jadwal.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="jenjang" class="form-label">Jenjang</label>
                            <select name="jenjang" class="form-select">
                                <option value="">-- Semua --</option>
                                <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" class="form-select">
                                <option value="">-- Semua --</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('kelas') == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="hari" class="form-label">Hari</label>
                            <select name="hari" class="form-select">
                                <option value="">-- Semua --</option>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" {{ request('hari') == $day ? 'selected' : '' }}>
                                        {{ $day }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="guru_id" class="form-label">Guru</label>
                            <select name="guru_id" class="form-select">
                                <option value="">-- Semua --</option>
                                @foreach ($guruList as $g)
                                    <option value="{{ $g->id }}"
                                        {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                                        {{ optional($g->user)->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="mapel_id" class="form-label">Mapel</label>
                            <select name="mapel_id" class="form-select">
                                <option value="">-- Semua --</option>
                                @foreach ($mapelList as $m)
                                    <option value="{{ $m->id }}"
                                        {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">-- Semua --</option>
                                <option value="AKTIF" {{ request('status') == 'AKTIF' ? 'selected' : '' }}>AKTIF</option>
                                <option value="NONAKTIF" {{ request('status') == 'NONAKTIF' ? 'selected' : '' }}>NONAKTIF
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-secondary">
                                <i class="bx bx-search"></i> Filter
                            </button>
                            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                {{-- List Jadwal --}}
                <div class="row">
                    @forelse ($jadwal as $jadwals)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm border rounded-3">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mt-3 mb-3 d-flex align-items-center">
                                        {{-- PERBAIKAN 1 --}}
                                        <i class="bx bx-book me-2"></i> {{ optional($jadwals->mapel)->name ?? '[Mapel Dihapus]' }}
                                    </h5>
                                    {{-- PERBAIKAN 2 --}}
                                    <div><strong>Nama Pengajar:</strong>
                                        {{ optional(optional($jadwals->guru)->user)->name ?? '[Guru Dihapus]' }}</div>
                                    <hr>
                                    <div><strong>Jenjang:</strong> {{ $jadwals->jenjang }}</div>
                                    <hr>
                                    <div><strong>Kelas:</strong> {{ $jadwals->kelas }}</div>
                                    <hr>
                                    <div><strong>Hari / Tanggal:</strong> {{ $jadwals->hari }},
                                        {{ \Carbon\Carbon::parse($jadwals->tanggal)->translatedFormat('d F Y') }}
                                    </div>
                                    <hr>
                                    <div><strong>Jam:</strong>
                                        {{ \Carbon\Carbon::parse($jadwals->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($jadwals->jam_selesai)->format('H:i') }}
                                    </div>
                                    <hr>
                                    <div><strong>Ruangan:</strong> {{ $jadwals->ruangan }}</div>
                                    <hr>
                                    <div><strong>Materi:</strong> {{ $jadwals->materi }}</div>
                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <form action="{{ route('admin.jadwal.toggleStatus', $jadwals->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin mengubah status jadwal ini?')">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="badge border-0 fs-5 {{ $jadwals->status == 'AKTIF' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $jadwals->status }}
                                            </button>
                                        </form>

                                        <div class="d-flex gap-2">
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalDetail{{ $jadwals->id }}">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="{{ route('admin.jadwal.edit', $jadwals->id) }}"
                                                class="btn btn-warning">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <form action="{{ route('admin.jadwal.destroy', $jadwals->id) }}"
                                                method="POST">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger show_confirm" type="submit">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Detail --}}
                        <div class="modal fade" id="modalDetail{{ $jadwals->id }}" tabindex="-1"
                            aria-labelledby="modalLabel{{ $jadwals->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel{{ $jadwals->id }}">Detail Jadwal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{-- PERBAIKAN 3 & 4 --}}
                                                <p><strong>Mapel:</strong> {{ optional($jadwals->mapel)->name ?? '-' }}</p>
                                                <p><strong>Guru:</strong> {{ optional(optional($jadwals->guru)->user)->name ?? '-' }}</p>
                                                <p><strong>Jenjang:</strong> {{ $jadwals->jenjang }}</p>
                                                <p><strong>Kelas:</strong> {{ $jadwals->kelas }}</p>
                                                <p><strong>Kelas Belajar:</strong>
                                                    {{ optional($jadwals->kelasBelajar)->nama_kelas ?? '-' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Hari:</strong> {{ $jadwals->hari }}</p>
                                                <p><strong>Tanggal:</strong>
                                                    {{ \Carbon\Carbon::parse($jadwals->tanggal)->translatedFormat('d F Y') }}
                                                </p>
                                                <p><strong>Jam:</strong>
                                                    {{ \Carbon\Carbon::parse($jadwals->jam_mulai)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($jadwals->jam_selesai)->format('H:i') }}
                                                </p>
                                                <p><strong>Ruangan:</strong> {{ $jadwals->ruangan }}</p>
                                                <p><strong>Materi:</strong> {{ $jadwals->materi }}</p>
                                            </div>
                                        </div>
                                        <p class="mt-3"><strong>Status:</strong><br>
                                            <span
                                                class="badge {{ $jadwals->status == 'AKTIF' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $jadwals->status }}
                                            </span>
                                        </p>

                                        {{-- Tabel Absensi --}}
                                        <hr>
                                        <h6 class="mt-4">Daftar Absensi Murid</h6>
                                        @if ($jadwals->absen->isNotEmpty())
                                            <div class="table-responsive mt-2">
                                                <table class="table table-bordered table-sm">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Siswa</th>
                                                            <th>Status</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($jadwals->absen as $i => $absen)
                                                            <tr>
                                                                <td>{{ $i + 1 }}</td>
                                                                {{-- PERBAIKAN 5 --}}
                                                                <td>{{ optional(optional($absen->siswa)->user)->name ?? '-' }}</td>
                                                                <td>{{ $absen->status }}</td>
                                                                <td>{{ $absen->keterangan ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-muted">Belum ada absensi tercatat.</div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h5 class="text-muted"><i class="bx bx-calendar-x me-2"></i> Tidak ada jadwal mengajar</h5>
                        </div>
                    @endforelse
                </div>
            </div> {{-- container --}}
        </div> {{-- content-wrapper --}}
    </div> {{-- layout-page --}}
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.show_confirm');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data Jadwal akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
