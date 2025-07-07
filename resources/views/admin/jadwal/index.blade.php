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
        <!-- Navbar -->
        <x-navbar></x-navbar>
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">

                <h4 class="fw-bold py-3 mb-4"><i class="bx bx-calendar me-2"></i>Jadwal Mengajar</h4>
                <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary mb-4"><i
                        class='bx bx-add-to-queue me-1'></i> Tambah Jadwal</a>

                <div class="row">
                    @forelse ($jadwal as $jadwals)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm border rounded-3">
                                <div class="card-body">
                                    <h5 class="card-title text-primary mt-3 mb-3 d-flex align-items-center">
                                        <i class="bx bx-book me-2"></i>
                                        {{ $jadwals->mapel->name ?? '[Mapel dihapus]' }}
                                    </h5>
                                    <div><strong>Nama Pengajar : </strong>
                                        @if ($jadwals->guru && $jadwals->guru->user)
                                            {{ $jadwals->guru->user->name }}
                                        @else
                                            <span class="text-danger">[Guru dihapus]</span>
                                        @endif
                                    </div>
                                    <hr>
                                    <div><strong>Jenjang : </strong> {{ $jadwals->jenjang }}</div>
                                    <hr>
                                    <div><strong>Kelas : </strong> {{ $jadwals->kelas }}</div>
                                    <hr>
                                    <div><strong>Hari / Tanggal : </strong>
                                        {{ $jadwals->hari }},
                                        {{ \Carbon\Carbon::parse($jadwals->tanggal)->translatedFormat('d F Y') }}
                                    </div>
                                    <hr>
                                    <div><strong>Jam :</strong>
                                        {{ \Carbon\Carbon::parse($jadwals->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($jadwals->jam_selesai)->format('H:i') }}
                                    </div>
                                    <hr>
                                    <div><strong>Ruangan : </strong> {{ $jadwals->ruangan }}</div>
                                    <hr>
                                    <div><strong>Materi : </strong> {{ $jadwals->materi }}</div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        {{-- Status kiri --}}
                                        <form action="{{ route('admin.jadwal.toggleStatus', $jadwals->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin mengubah status jadwal ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="badge border-0 fs-5 {{ $jadwals->status == 'AKTIF' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $jadwals->status }}
                                            </button>
                                        </form>

                                        {{-- Tombol kanan --}}
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.jadwal.edit', $jadwals->id) }}"
                                                class="btn btn-warning me-2"><i class="bx bx-edit-alt"></i></a>
                                            <form action="{{ route('admin.jadwal.destroy', $jadwals->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger show_confirm" type="submit"><i
                                                        class="bx bx-trash"></i></button>
                                            </form>
                                        </div>
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
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.show_confirm');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
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
