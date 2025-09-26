@extends('layouts.template.master')

@section('title', 'Siswa')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil', html: '{!! session('success') !!}', timer: 2500, showConfirmButton: false });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Gagal', html: '{!! session('error') !!}' });
        </script>
    @endif

    <div class="layout-page">
        <x-navbar></x-navbar>
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">

                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                      <h4 class="fw-bold py-3 mb-4">Data Siswa</h4>
                    </div>
                    <div class="d-flex align-items-center flex-wrap text-nowrap gap-2">
                      <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary"><i class='bx bx-add-to-queue me-1'></i> Tambah Murid</a>
                      <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importSiswaModal"><i class='bx bx-import me-1'></i> Import</button>
                      <a href="{{ route('admin.siswa.export', request()->query()) }}" class="btn btn-success"><i class='bx bx-export me-1'></i> Export</a>
                      <button type="submit" form="deleteAllForm" class="btn btn-danger"><i class='bx bx-trash me-1'></i> Hapus Pilihan</button>
                      <form action="{{ route('admin.siswa.deleteSelected') }}" method="POST" id="deleteAllForm" class="d-none"> @csrf @method('DELETE') </form>
                    </div>
                </div>

                <!-- Card untuk Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Filter Data</h5>
                        <form action="{{ route('admin.siswa.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Jenjang</label>
                                <select name="jenjang" class="form-select">
                                    <option value="">-- Semua Jenjang --</option>
                                    <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="form-select">
                                    <option value="">-- Semua Kelas --</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('kelas') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
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
                    </div>
                </div>

                <!-- Card untuk Tabel Data -->
                <div class="card">
                    <div class="card-body">
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
                                            <td><input type="checkbox" class="checkbox-item" name="ids[]" value="{{ $siswa->id }}"></td>
                                            <td><strong>{{ strtoupper($siswa->kode_siswa) }}</strong></td>
                                            <td><strong>{{ strtoupper(optional($siswa->user)->name ?? '[USER DIHAPUS]') }}</strong></td>
                                            <td><strong>{{ $siswa->asal_sekolah ?? '-' }}</strong></td>
                                            <td>{{ strtoupper($siswa->education_level) }}</td>
                                            <td>{{ strtoupper($siswa->kelas) }}</td>
                                            <td class="d-flex">
                                                <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $siswa->id }}"><i class="bx bx-detail"></i></button>
                                                <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm me-2"><i class="bx bx-edit-alt"></i></a>
                                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST"> @csrf @method('DELETE') <button class="btn btn-danger btn-sm show_confirm" type="submit"><i class="bx bx-trash"></i></button></form>
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

    <!-- Modal untuk Impor Siswa -->
    <div class="modal fade" id="importSiswaModal" tabindex="-1" aria-labelledby="importSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importSiswaModalLabel">Import Data Siswa dari Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" id="importSiswaForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_siswa" class="form-label">1. Pilih File Excel</label>
                            <input class="form-control" type="file" id="file_siswa" name="file_siswa" required accept=".xlsx, .xls">
                        </div>

                        <div id="import-results" class="mt-3" style="display: none;"></div>

                        <div class="alert alert-info mt-3" role="alert">
                             <h6 class="alert-heading fw-bold"><i class='bx bx-info-circle me-1'></i> Ketentuan Import</h6>
                             <p class="mb-2">Untuk menghindari error, pastikan file Excel Anda memenuhi ketentuan berikut:</p>
                             <ul>
                                 <li>Cara termudah adalah dengan <strong><a href="{{ route('admin.siswa.template') }}" class="fw-bold alert-link">mengunduh template</a></strong> yang sudah disediakan.</li>
                                 <li>Semua kolom wajib diisi.</li>
                                 <li>Kolom <strong>email</strong> harus unik.</li>
                                 <li>Untuk <strong>jenjang</strong>, isi dengan: <code>SD</code>, <code>SMP</code>, atau <code>SMA</code>.</li>
                                 <li>Untuk <strong>jenis_kelamin</strong>, isi dengan: <code>LAKI-LAKI</code> atau <code>PEREMPUAN</code>.</li>
                             </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-warning" id="check-import-btn">2. Cek Data</button>
                        <button type="submit" class="btn btn-primary" id="import-btn" disabled>3. Import Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Skrip untuk SweetAlert konfirmasi hapus per baris
        $('.show_confirm').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest("form");
            Swal.fire({
                title: 'Apakah Anda yakin?', text: "Data siswa ini akan dihapus permanen!", icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });

        // Skrip untuk fungsionalitas checkbox "Pilih Semua"
        $('#checkAll').on('click', function() {
            $('.checkbox-item').prop('checked', this.checked);
        });

        // Skrip untuk form "Hapus Pilihan" (bulk delete)
        $('#deleteAllForm').on('submit', function(e) {
            e.preventDefault();
            let selected = $('.checkbox-item:checked');
            if (selected.length === 0) {
                Swal.fire('Oops!', 'Pilih minimal satu siswa untuk dihapus.', 'warning');
                return;
            }
            $(this).find('input[name="ids[]"]').remove();
            selected.each(function() {
                $('<input>').attr({ type: 'hidden', name: 'ids[]', value: $(this).val() }).appendTo('#deleteAllForm');
            });
            Swal.fire({
                title: 'Apakah Anda yakin?', text: `Anda akan menghapus ${selected.length} data siswa permanen!`, icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus semua!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) { this.submit(); }
            });
        });

        // =======================================================
        // == [LOGIKA BARU] Untuk fitur Cek Sebelum Import ==
        // =======================================================
        const checkBtn = $('#check-import-btn');
        const importBtn = $('#import-btn');
        const importForm = $('#importSiswaForm');
        const fileInput = $('#file_siswa');
        const resultsDiv = $('#import-results');
        const originalCheckBtnText = '2. Cek Data';

        // Reset state saat file baru dipilih atau modal ditutup
        fileInput.on('change', function() {
            importBtn.prop('disabled', true);
            checkBtn.prop('disabled', false).html(originalCheckBtnText);
            resultsDiv.hide().empty();
        });
        $('#importSiswaModal').on('hidden.bs.modal', function () {
            importForm[0].reset();
            fileInput.trigger('change');
        });

        checkBtn.on('click', function(e) {
            e.preventDefault();

            if (!fileInput.val()) {
                Swal.fire('Oops!', 'Silakan pilih file Excel terlebih dahulu.', 'warning');
                return;
            }

            let formData = new FormData(importForm[0]);

            checkBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Mengecek...');
            resultsDiv.hide().empty();

            $.ajax({
                url: "{{ route('admin.siswa.checkImport') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    checkBtn.prop('disabled', true).html('<i class="bx bx-check-circle"></i> Valid');
                    importBtn.prop('disabled', false); // Aktifkan tombol import
                    resultsDiv.show().html('<div class="alert alert-success">' + response.message + '</div>');
                },
                error: function(xhr) {
                    checkBtn.prop('disabled', false).html(originalCheckBtnText);
                    importBtn.prop('disabled', true);

                    let errorHtml = '<div class="alert alert-danger"><h5><i class="bx bx-x-circle"></i> Ditemukan Error:</h5><ul class="mb-0">';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(index, error) {
                            errorHtml += '<li>' + error + '</li>';
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorHtml += '<li>' + xhr.responseJSON.message + '</li>';
                    } else {
                        errorHtml += '<li>Terjadi kesalahan yang tidak diketahui. Cek format file Anda.</li>';
                    }
                    errorHtml += '</ul></div>';
                    resultsDiv.show().html(errorHtml);
                }
            });
        });
    });
</script>
@endpush

