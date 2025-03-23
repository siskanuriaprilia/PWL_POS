@extends('layout.app')

@section('content')

<!-- Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="align-middle">CRUD User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">CRUD User</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="content pb-5"> <!-- Tambahkan padding-bottom -->
    <div class="container-fluid">
        
        <!-- Tombol Tambah User -->
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-right mb-3">
                    <a class="btn btn-success" href="{{ route('m_user.create') }}">
                        <i class="fas fa-user-plus"></i> Input User
                    </a>
                </div>
            </div>
        </div>

        <!-- Pesan Sukses -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <!-- Tabel Data User -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Daftar User</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="bg-brown text-white">
                        <tr>
                            <th width="50px" class="text-center">ID</th>
                            <th class="text-center">Level</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Password</th>
                            <th width="200px" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($useri as $m_user)
                            <tr>
                                <td class="text-center">{{ $m_user->user_id }}</td>
                                <td class="text-center">{{ $m_user->level_id }}</td>
                                <td>{{ $m_user->username }}</td>
                                <td>{{ $m_user->nama }}</td>
                                <td>{{ $m_user->password }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <!-- Tombol Show -->
                                        <a class="btn btn-info btn-sm" href="{{ route('m_user.show', $m_user->user_id) }}">
                                            <i class="fas fa-eye"></i> Show
                                        </a>
                                        
                                        <!-- Tombol Edit -->
                                        <a class="btn btn-primary btn-sm" href="{{ route('m_user.edit', $m_user->user_id) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <!-- Tombol Delete dengan Modal Konfirmasi -->
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $m_user->user_id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>

                                        <!-- Modal Konfirmasi Delete -->
                                        <div class="modal fade" id="deleteModal{{ $m_user->user_id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus user <strong>{{ $m_user->username }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('m_user.destroy', $m_user->user_id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $useri->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('css')
<style>
    .margin-tb {
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .table {
        margin-top: 20px;
    }
    .btn-group .btn {
        margin-right: 5px;
    }
    .alert-success {
        margin-top: 20px;
    }
    .action-btn {
        min-width: 75px;
        padding: 5px 10px;
        margin-right: 5px; /* Ensure consistent spacing */
        height: 38px; /* Set a fixed height for all buttons */
        line-height: 1.5; /* Center text vertically */
    }
    .btn-info, .btn-primary, .btn-danger {
        width: 75px; /* Ensure all buttons have the same width */
    }
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .content-header h1 {
        margin-bottom: 0;
        line-height: 1.5;
    }
    .content-header .align-middle {
        padding-top: 7px; /* Adjust this value as needed */
    }
    .content {
        padding-bottom: 20px; /* Add padding to the bottom */
    }
</style>
@endsection