@extends('layouts.template.master')

@section('title', 'Kelas Belajar')
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
        <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4">
                    Kelas
                </h4>
                <div class="card">
                    <div class="card-header d-xl-block">
                        <div class="d-xl-flex align-items-center mb-4 d-block">

                            <a href="#" class="btn btn-primary d-flex align-items-center me-2 tambahMapelBtn"
                                data-id="" data-name="" data-bs-toggle="modal" data-bs-target="#tambahMapelModal">
                                <i class='bx bx-add-to-queue me-1'></i> Tambah Kelas</a>
                            <!-- Edit Mapel Modal -->
                            <div class="modal fade" id="tambahMapelModal" tabindex="-1"
                                aria-labelledby="tambahMapelModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                        <form action="{{ route('admin.kelasbelajar.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="tambahMapelModalLabel">Tambah Kelas Belajar</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label for="edit_mapel_name">Nama Kelas</label>
                                                            <input type="text" name="nama_kelas" id="edit_mapel_name" class="form-control" required>
                                                            <div class="text-danger" id="editError"></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>no</th>
                                            <th>Nama</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelasBelajar as $index => $kelas)
                                            <tr>
                                                <td>
                                                    <strong>{{ $index + 1 }}</strong>
                                                </td>
                                                <td><strong>{{ $kelas->nama_kelas }}</strong></td>
                                                <td class="d-flex">
                                                    <a href="#" class="btn btn-warning me-2 editMapelBtn"
                                                        data-id="{{ $kelas->id }}" data-name="{{ $kelas->nama_kelas }}"
                                                        data-bs-toggle="modal" data-bs-target="#editMapelModal">
                                                        <i class="bx bx-edit-alt"></i>
                                                    </a>
                                                    <!-- Edit Mapel Modal -->
                                                    <div class="modal fade" id="editMapelModal" tabindex="-1"
                                                        aria-labelledby="editMapelModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form action="{{ route('admin.kelasbelajar.update', $kelas->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editMapelModalLabel">
                                                                            Edit Nama Kelas</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group mb-3">
                                                                            <label for="edit_mapel_name">Nama Kelas</label>
                                                                            <input type="text" name="nama_kelas"
                                                                                id="edit_mapel_name" class="form-control"
                                                                                required>
                                                                            <div class="text-danger" id="editError"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <form action="{{ route('admin.kelasbelajar.destroy', $kelas->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger show_confirm" type="submit"><i
                                                                class="bx bx-trash"></i></button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.show_confirm');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data Kelas akan dihapus!",
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