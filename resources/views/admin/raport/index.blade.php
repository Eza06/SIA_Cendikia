@extends('layouts.template.master')

@section('title', 'Raport')
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

                <h4 class="fw-bold py-3 mb-4"><i class="bx bx-calendar me-2"></i>Raport</h4>
                <a href="{{route('admin.raport.create')}}" class="btn btn-primary mb-4 "><i
                        class='bx bx-add-to-queue me-1'></i>Buat Raport</a>

                        <div class="row">
                            @forelse ($raporTo as $rapor)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card shadow-sm border rounded-3">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">
                                                <i class="bx bx-book me-2"></i> {{ $rapor->nama_rapor }}
                                            </h5>
                        
                                            <div><strong>Semester: </strong> {{ $rapor->semester }}</div>
                                            <hr>
                                            <div><strong>Tahun Ajaran: </strong> {{ $rapor->angkatan->tahun_angkatan ?? '-' }}</div>
                                            <hr>
                                            <div><strong>Kelas: </strong> {{ $rapor->kelasBelajar->nama_kelas ?? '-' }}</div>
                                            <hr>
                        
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                {{-- Tombol lihat detail --}}
                                                <a href="{{route('admin.raport.show', $rapor->id)}}" class="btn btn-warning">
                                                    <i class="bx bx-show"></i> Detail Raport 
                                                </a>
                                                <a href="{{route('admin.raport.edit', $rapor->id)}}" class="btn btn-info">
                                                    <i class="bx bx-edit-alt"></i> Edit Raport 
                                                </a>
                                                {{-- Tombol hapus --}}
                                                <form action="{{route('admin.raport.destroy', $rapor->id)}}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus raport ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger show_confirm" type="submit"><i class="bx bx-trash"></i></button>
                                                </form>
                                            </div>
                        
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <h5 class="text-muted"><i class="bx bx-calendar-x me-2"></i>Tidak ada raport yang tersedia</h5>
                                </div>
                            @endforelse
                        </div>                        
                <!-- Tambah contoh lagi jika perlu -->

            </div>
        </div>
    </div>
    </div>
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
                        text: "Data Raport akan dihapus!",
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
