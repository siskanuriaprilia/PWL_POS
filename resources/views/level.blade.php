@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Daftar Level</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Level</th>
                        <th>Nama Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $level)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $level->level_kode }}</td>
                        <td>{{ $level->level_nama }}</td>
                        <td>
                            <a href="{{ url('/level/ubah/'.$level->level_id) }}" class="btn btn-warning btn-sm d-inline-flex align-items-center">
                                <i class="fas fa-edit"></i>&nbsp; Edit
                            </a>
                            <a href="{{ url('/level/hapus/'.$level->level_id) }}" class="btn btn-danger btn-sm d-inline-flex align-items-center" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i>&nbsp; Delete
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
<!-- Tombol Tambah User di bagian bawah kanan -->
<div class="card-footer d-flex justify-content-end">
    <a href="{{ url('/level/tambah') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Level
    </a>
</div>

@endsection
