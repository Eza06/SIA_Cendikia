@extends('layouts.template.master')

@section('title', 'Tahun Ajaran')
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
                <h4 class="fw-bold py-3 mb-4">Tahun Ajaran</h4>
                <div class="card">
                    <div class="card-header d-xl-block">
                        <div class="d-xl-flex align-items-center mb-4 d-block">
                            <a href="#" class="btn btn-primary d-flex align-items-center me-2"
                                data-bs-toggle="modal" data-bs-target="#tambahAngkatanModal">
                                <i class='bx bx-add-to-queue me-1'></i> Tambah Tahun Ajaran
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
                                    @foreach ($tahunAngkatan as $index => $angkatan)
                                        <tr>
                                            <td><strong>{{ $index + 1 }}</strong></td>
                                            <td><strong>{{ $angkatan->tahun_angkatan }}</strong></td>
                                            <td class="d-flex">
                                                <button type="button" class="btn btn-warning me-2 editBtn"
                                                    data-id="{{ $angkatan->id }}"
                                                    data-nama="{{ $angkatan->tahun_angkatan }}">
                                                    <i class="bx bx-edit-alt"></i>
                                                </button>

                                                <form action="{{ route('admin.angkatan.destroy', $angkatan->id) }}"
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

                {{-- Modal Tambah --}}
                <div class="modal fade" id="tambahAngkatanModal" tabindex="-1"
                    aria-labelledby="tambahAngkatanModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.angkatan.store') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Tahun Ajaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="tahun_angkatan">Tahun Ajaran</label>
                                    <input type="text" name="tahun_angkatan" class="form-control" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Modal Edit --}}
                <div class="modal fade" id="editAngkatanModal" tabindex="-1"
                    aria-labelledby="editAngkatanModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="formEditAngkatan" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Tahun Ajaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="edit_tahun_angkatan">Tahun Ajaran</label>
                                    <input type="text" name="tahun_angkatan" id="edit_tahun_angkatan"
                                        class="form-control" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
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
        // Edit button handler
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                document.getElementById('edit_tahun_angkatan').value = nama;
                const form = document.getElementById('formEditAngkatan');
                form.action = `/admin/angkatan/${id}`;
                new bootstrap.Modal(document.getElementById('editAngkatanModal')).show();
            });
        });

        // SweetAlert for delete
        document.querySelectorAll('.show_confirm').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data Tahun Ajaran akan dihapus!",
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
