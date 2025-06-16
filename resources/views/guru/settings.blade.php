@extends('layouts.template.master')

@section('title', 'Settings')

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

            <!-- Judul -->
            <h4 class="fw-bold py-3 mb-4">Pengaturan</h4>

            <!-- Informasi Guru -->
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center">
                    <div class="d-flex flex-column w-100">
                        <div><strong>KODE GURU:</strong> {{ Auth::user()->guru->kode_guru ?? '-' }}</div>
                        <hr>
                        <div><strong>NAMA:</strong> {{ strtoupper($user->name) }}</div>
                        <hr>
                        <div><strong>EMAIL:</strong> {{ $user->email }}</div>
                        <hr>
                        <div><strong>TANGGAL BERGABUNG:</strong> {{ $user->created_at->format('d F Y') }}</div>
                        <hr>
                    </div>
                </div>
            </div>

            <!-- Form Ubah Data -->
            <h4 class="fw-bold py-3">Ubah Informasi Guru</h4>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('guru.settings.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label">No. Telpon</label>
                            <input type="text" name="no_telpon" class="form-control" value="{{ old('no_telpon', $user->guru->no_telpon ?? '') }}">
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control">{{ old('alamat', $user->guru->alamat ?? '') }}</textarea>
                        </div>
                    
                        <button type="submit" class="btn btn-primary show_confirm">Simpan Perubahan</button>
                    </form>
                    
                </div>
            </div>

        </div>
        <!-- /Content -->
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.show_confirm');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data Akan Di update!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, ubah!',
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