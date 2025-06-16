@extends('layouts.template.master')

@section('title', 'Settingsx')
@section('content')
    <div class="layout-page">
        <!-- Navbar -->
        <x-navbar></x-navbar>
        <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4">
                    Pengaturan
                </h4>
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>no</th>
                                            <th>Nama</th>
                                            <th>Tanggal Bergabung</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admin as $index => $admins)
                                            <tr>
                                                <td>
                                                    <strong>{{$index + 1}}</strong>
                                                </td>
                                                <td><strong>{{ $admins->name }}</strong></td>
                                                <td><strong>  {{ $admins->created_at ? $admins->created_at->format('d F Y') : '-' }}
                                                </div></strong></td>
                                                <td class="d-flex">
                                                    <a href="#"
                                                        class="btn btn-warning me-2"><i class="bx bx-edit-alt"></i></a>
                                                    <form action="#"
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
                <h4 class="fw-bold py-3 mt-4 ">
                    Tambah Admin
                </h4>
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
                
                
                <!--/ Bordered Table -->
            </div>
            
       
        </div>
    @endsection
