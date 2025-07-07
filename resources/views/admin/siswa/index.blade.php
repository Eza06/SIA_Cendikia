@extends('layouts.template.master')

@section('title', 'Siswa')
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
                <h4 class="fw-bold py-3 mb-4">Siswa</h4>

                <div class="card">
                    <div class="card-header d-flex justify-content-between flex-wrap gap-3">
                        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class='bx bx-add-to-queue me-1'></i> Tambah Murid
                        </a>
                        <form action="{{ route('admin.siswa.deleteSelected') }}" method="POST" id="deleteAllForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Selected</button>
                        </form>
                    </div>

                    <div class="card-body">
                        {{-- Filter Form --}}
                        <form action="{{ route('admin.siswa.index') }}" method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Jenjang</label>
                                <select name="jenjang" class="form-select">
                                    <option value="">-- Semua Jenjang --</option>
                                    <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="form-select">
                                    <option value="">-- Semua Kelas --</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('kelas') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Kelas Belajar</label>
                                <select name="kelas_belajar_id" class="form-select">
                                    <option value="">-- Semua Kelas Belajar --</option>
                                    @foreach ($kelasBelajar as $kelas)
                                        <option value="{{ $kelas->id }}" {{ request('kelas_belajar_id') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary w-100">Reset</a>
                            </div>
                        </form>

                        {{-- Tabel Siswa --}}
                        <div class="table-responsive">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAll"></th>
                                        <th>Kode Siswa</th>
                                        <th>Nama</th>
                                        <th>Asal Sekolah</th>
                                        <th>Jenjang</th>
                                        <th>Kelas</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($murid as $siswa)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="checkbox-item" name="ids[]" value="{{ $siswa->id }}">
                                            </td>
                                            <td><strong>{{ strtoupper($siswa->kode_siswa) }}</strong></td>
                                            <td><strong>{{ strtoupper($siswa->user->name) }}</strong></td>
                                            <td><strong>{{ $siswa->asal_sekolah ?? '-' }}</strong></td>
                                            <td>{{ strtoupper($siswa->education_level) }}</td>
                                            <td>{{ strtoupper($siswa->kelas) }}</td>
                                            <td class="d-flex">
                                                {{-- Detail --}}
                                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $siswa->id }}">
                                                    <i class="bx bx-detail"></i>
                                                </button>

                                                {{-- Modal Detail --}}
                                                <div class="modal fade" id="modalDetail{{ $siswa->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Detail Siswa</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div><strong>Kode Siswa:</strong> {{ strtoupper($siswa->kode_siswa) }}</div><hr>
                                                                <div><strong>Nama:</strong> {{ strtoupper($siswa->user->name) }}</div><hr>
                                                                <div><strong>Jenis Kelamin:</strong> {{ strtoupper($siswa->jenis_kelamin) }}</div><hr>
                                                                <div><strong>Asal Sekolah:</strong> {{ strtoupper($siswa->asal_sekolah) }}</div><hr>
                                                                <div><strong>Jenjang:</strong> {{ strtoupper($siswa->education_level) }}</div><hr>
                                                                <div><strong>Kelas:</strong> {{ strtoupper($siswa->kelas) }}</div><hr>
                                                                <div><strong>Email:</strong> {{ $siswa->user->email }}</div><hr>
                                                                <div><strong>No. Telepon:</strong> {{ $siswa->no_telpon }}</div><hr>
                                                                <div><strong>Alamat:</strong> {{ $siswa->alamat }}</div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Edit --}}
                                                <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning me-2">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>

                                                {{-- Hapus --}}
                                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST">
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
                    text: "Data siswa akan dihapus!",
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

        $('#checkAll').on('click', function () {
            $('.checkbox-item').prop('checked', this.checked);
        });

        $('#deleteAllForm').on('submit', function (e) {
            e.preventDefault();
            let selected = $('.checkbox-item:checked');
            if (selected.length === 0) {
                Swal.fire('Oops!', 'Pilih minimal satu siswa.', 'warning');
                return;
            }

            let ids = [];
            selected.each(function () {
                ids.push($(this).val());
            });

            $(this).find('input[name="ids[]"]').remove();
            ids.forEach(function (id) {
                $('<input>').attr({ type: 'hidden', name: 'ids[]', value: id }).appendTo('#deleteAllForm');
            });

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Semua siswa yang dipilih akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        $('#myTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
        });
    });
</script>
@endpush
