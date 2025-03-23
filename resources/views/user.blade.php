@extends('layout.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Daftar User</h3>
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
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Kode Level</th>
                        <th>Nama Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->level->level_kode }}</td>
                        <td>{{ $user->level->level_nama }}</td>
                        <td>
                            <a href="{{ url('/user/ubah/'.$user->user_id) }}" class="btn btn-warning btn-sm d-inline-flex align-items-center">
                                <i class="fas fa-edit"></i>&nbsp; Edit
                            </a>
                            <a href="{{ url('/user/hapus/'.$user->user_id) }}" class="btn btn-danger btn-sm d-inline-flex align-items-center" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i>&nbsp; Delete
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tombol Tambah User di bagian bawah kanan -->
        <div class="card-footer text-end">
            <a href="{{ url('/user/tambah') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>
    </div>
</div>
@endsection
