@extends('layouts.template.master')

@section('title', 'Guru')
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
                <h4 class="fw-bold py-3 mb-4">
                    Data Guru
                </h4>
            <div class="card">
                    <div class="card-header d-xl-block">
                        <div class="d-xl-flex align-items-center mb-4 d-block">
                            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary d-flex align-items-center"><i
                                    class='bx bx-add-to-queue me-1'></i> Tambah Guru</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Kode Guru</th>
                                        <th>Nama</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($guru as $gurus)
                                        <tr>
                                            <td>
                                                <strong>{{ $gurus->kode_guru }}</strong>
                                            </td>
                                            <td><strong>{{ strtoupper(optional($gurus->user)->name ?? '[User Dihapus]') }}</strong></td>
                                            <td>
                                                <strong>{{ strtoupper($gurus->mapels->pluck('name')->implode(', ')) }}</strong>
                                            </td>
                                            <td class="d-flex">
                                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $gurus->id }}">
                                                    <i class="bx bx-detail"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modalDetail{{ $gurus->id }}" tabindex="-1"
                                                    aria-labelledby="modalLabel{{ $gurus->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="modalLabel{{ $gurus->id }}">Detail Guru</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div><strong>KODE GURU : </strong> {{ $gurus->kode_guru }}
                                                                </div>
                                                                <hr>
                                                                <div><strong>NAMA : </strong> {{ strtoupper(optional($gurus->user)->name ?? '[User Dihapus]') }}
                                                                </div>
                                                                <hr>
                                                                <div><strong>PELAJARAN : </strong>
                                                                    {{ strtoupper($gurus->mapels->pluck('name')->implode(', ')) }}
                                                                </div>
                                                                <hr>
                                                                <div><strong>EMAIL : </strong>
                                                                    {{ optional($gurus->user)->email ?? '-' }}</div>
                                                                <hr>
                                                                <div><strong>TANGGAL BERGABUNG : </strong>
                                                                    {{ $gurus->created_at->format('d F Y') }}</div>
                                                                <hr>
                                                                <div><strong>NO TELEPON : </strong>
                                                                    {{ $gurus->no_telpon }}</div>
                                                                <hr>
                                                                <div class="text-wrap"
                                                                    style="white-space: normal; word-break: break-word;">
                                                                    <strong>ALAMAT : </strong>
                                                                    {{ $gurus->alamat }}</div>
                                                                <hr>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="{{ route('admin.guru.edit', $gurus->id) }}"
                                                    class="btn btn-warning me-2"><i class="bx bx-edit-alt"></i></a>
                                                <form action="{{ route('admin.guru.destroy', $gurus->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger show_confirm" type="submit">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Bordered Table -->
        </div>
    </div>
@endsection

@push('script')
{{-- Skrip untuk konfirmasi hapus (tetap di sini) --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.show_confirm');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data guru akan dihapus!",
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

