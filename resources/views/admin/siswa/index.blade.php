@extends('layouts.template.master')

@section('title', 'Siswa')
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
                    Siswa
                </h4>
                <div class="card">
                    <div class="card-header d-xl-block">
                        <div class="d-xl-flex align-items-center mb-4 d-block">
                            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary d-flex align-items-center"><i
                                    class='bx bx-add-to-queue me-1'></i> Tambah Murid</a>
                            <form action="{{ route('admin.siswa.deleteSelected') }}" method="POST" id="deleteAllForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ms-3 me-3">Delete Selected</button>
                            </form>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="col-md-10">
                                    <form action="{{ route('admin.siswa.index') }}" method="GET"
                                        class="row align-items-end mb-4">
                                        <div class="col-md-3">
                                            <label class="form-label">Jenjang</label>
                                            <select name="jenjang" class="form-select">
                                                <option value="">-- Semua Jenjang --</option>
                                                <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD
                                                </option>
                                                <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>
                                                    SMP</option>
                                                <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>
                                                    SMA</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label">Kelas</label>
                                            <select name="kelas" class="form-select">
                                                <option value="">-- Semua Kelas --</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ request('kelas') == $i ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Kelas Belajar</label>
                                            <select name="kelas_belajar_id" class="form-select">
                                                <option value="">-- Semua Kelas Belajar --</option>
                                                @foreach ($kelasBelajar as $kelas)
                                                    <option value="{{ $kelas->id }}"
                                                        {{ request('kelas_belajar_id') == $kelas->id ? 'selected' : '' }}>
                                                        {{ $kelas->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 d-flex gap-2">
                                            <div>
                                                <button type="submit" class="btn btn-primary mt-3">Filter</button>
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.siswa.index') }}"
                                                    class="btn btn-secondary mt-3">Reset</a>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
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
                                                </td>
                                                <td>
                                                    <strong>{{ strtoupper($siswa->kode_siswa) }}</strong>
                                                </td>
                                                <td><strong>{{ strtoupper($siswa->user->name) }}</strong></td>
                                                <td><strong>{{ $siswa->asal_sekolah ?? '-' }}</strong></td>
                                                <td>{{ strtoupper($siswa->education_level) }}</td>
                                                <td>{{ strtoupper($siswa->kelas) }}</td>
                                                <td class="d-flex">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalDetail{{ $siswa->id }}">
                                                        <i class="bx bx-detail"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modalDetail{{ $siswa->id }}"
                                                        tabindex="-1" aria-labelledby="modalLabel{{ $siswa->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5"
                                                                        id="modalLabel{{ $siswa->id }}">Detail Siswa
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div><strong>KODE SISWA : </strong>
                                                                        {{ strtoupper($siswa->kode_siswa) }}</div>
                                                                    <hr>
                                                                    <div><strong>NAMA : </strong>
                                                                        {{ strtoupper($siswa->user->name) }}
                                                                    </div>
                                                                    <hr>
                                                                    <div><strong>JENIS KELAMIN : </strong>
                                                                        {{ strtoupper($siswa->jenis_kelamin) }}</div>
                                                                    <hr>
                                                                    <div><strong>ASAL SEKOLAH : </strong>
                                                                        {{ strtoupper($siswa->asal_sekolah) }}</div>
                                                                    <hr>
                                                                    <div><strong>JENJANG PENDIDIKAN : </strong>
                                                                        {{ strtoupper($siswa->education_level) }}</div>
                                                                    <hr>
                                                                    <div><strong>KELAS : </strong>
                                                                        {{ strtoupper($siswa->kelas) }}
                                                                    </div>
                                                                    <hr>
                                                                    <div><strong>EMAIL : </strong>
                                                                        {{ $siswa->user->email }}</div>
                                                                    <hr>
                                                                    <div><strong>NOMOR TELEPON : </strong>
                                                                        {{ strtoupper($siswa->no_telpon) }}</div>
                                                                    <hr>
                                                                    <div class="text-wrap"
                                                                        style="white-space: normal; word-break: break-word;">
                                                                        <strong>ALAMAT:</strong> {{ $siswa->alamat }}
                                                                        <hr>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                                                        class="btn btn-warning me-2"><i class="bx bx-edit-alt"></i></a>
                                                    <form action="{{ route('admin.siswa.destroy', $siswa->id) }}"
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButtons = document.querySelectorAll('.show_confirm');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
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
            });
        </script>
        <script>
            $(document).ready(function() {
                const table = $('#myTable').DataTable({
                    responsive: true,
                    paging: true,
                    searching: true,
                    ordering: true,
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#checkAll').on('click', function() {
                    $('.checkbox-item').prop('checked', this.checked);
                });

                $('#deleteAllForm').on('submit', function(e) {
                    e.preventDefault();

                    let selected = $('.checkbox-item:checked');

                    if (selected.length === 0) {
                        Swal.fire('Oops!', 'Pilih minimal satu siswa.', 'warning');
                        return;
                    }

                    // Kumpulkan ID yang dipilih
                    let ids = [];
                    selected.each(function() {
                        ids.push($(this).val());
                    });

                    // Hapus input sebelumnya
                    $(this).find('input[name="ids[]"]').remove();

                    // Tambahkan input hidden satu-satu
                    ids.forEach(function(id) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'ids[]',
                            value: id
                        }).appendTo('#deleteAllForm');
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
            });
        </script>
    @endpush
