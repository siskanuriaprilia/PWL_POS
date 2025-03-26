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

            <a href="{{ url('/level/tambah') }}" class="btn btn-primary mb-3">Tambah Level</a>

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
                            <a href="{{ url('/level/ubah/'.$level->level_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ url('/level/hapus/'.$level->level_id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection