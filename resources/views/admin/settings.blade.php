@extends('layouts.template.master')

@section('title', 'Settings')
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
                <h4 class="fw-bold py-3 mb-4">Pengaturan</h4>

                {{-- Tabel Admin --}}
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admin as $index => $admins)
                                        <tr>
                                            <td><strong>{{ $index + 1 }}</strong></td>
                                            <td><strong>{{ $admins->name }}</strong></td>
                                            <td><strong>{{ $admins->created_at ? $admins->created_at->format('d F Y') : '-' }}</strong></td>
                                            <td class="d-flex">
                                                {{-- Tombol Edit (bisa dikembangkan jika diperlukan) --}}
                                                <a href="#" class="btn btn-warning me-2"><i class="bx bx-edit-alt"></i></a>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('admin.settings.destroy', $admins->id) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger show_confirm">
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

                {{-- Tambah Admin --}}
                <h4 class="fw-bold py-3 mt-4">Tambah Admin</h4>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.settings.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Admin</button>
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
            const deleteButtons = document.querySelectorAll('.show_confirm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin ingin menghapus admin ini?',
                        text: "Tindakan ini tidak bisa dibatalkan.",
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
