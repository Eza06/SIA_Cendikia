@extends('layouts.template.master')

@section('title', 'Mata Pelajaran')
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
            <h4 class="fw-bold py-3 mb-4">Mata Pelajaran</h4>
            <div class="card">
                <div class="card-header d-xl-block">
                    <div class="d-xl-flex align-items-center mb-4 d-block">
                        <a href="#" class="btn btn-primary d-flex align-items-center me-2"
                            data-bs-toggle="modal" data-bs-target="#tambahMapelModal">
                            <i class='bx bx-add-to-queue me-1'></i> Tambah Mapel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mapel as $index => $mapels)
                                    <tr>
                                        <td><strong>{{ $index + 1 }}</strong></td>
                                        <td><strong>{{ $mapels->name }}</strong></td>
                                        <td class="d-flex">
                                            <button type="button" class="btn btn-warning me-2 editBtn"
                                                data-id="{{ $mapels->id }}"
                                                data-nama="{{ $mapels->name }}">
                                                <i class="bx bx-edit-alt"></i>
                                            </button>

                                            <form action="{{ route('admin.mapel.destroy', $mapels->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger show_confirm" type="submit"><i class="bx bx-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Mapel -->
            <div class="modal fade" id="tambahMapelModal" tabindex="-1"
                aria-labelledby="tambahMapelModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('admin.mapel.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Mata Pelajaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <label for="mapel_baru">Nama Mapel</label>
                                <input type="text" name="name" id="mapel_baru" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Mapel -->
            <div class="modal fade" id="editMapelModal" tabindex="-1"
                aria-labelledby="editMapelModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="formEditMapel" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Mata Pelajaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <label for="edit_mapel_input">Nama Mapel</label>
                                <input type="text" name="name" id="edit_mapel_input" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // SweetAlert untuk konfirmasi hapus
        const deleteButtons = document.querySelectorAll('.show_confirm');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data Mata Pelajaran akan dihapus!",
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

        // Isi data ke dalam modal edit
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                document.getElementById('edit_mapel_input').value = nama;
                document.getElementById('formEditMapel').action = `/admin/mapel/${id}`;
                new bootstrap.Modal(document.getElementById('editMapelModal')).show();
            });
        });
    });
</script>
@endpush
