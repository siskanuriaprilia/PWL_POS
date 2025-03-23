@extends('layout.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="align-middle">Edit User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('m_user.index') }}">CRUD User</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-right">
                    <a class="btn btn-secondary" href="{{ route('m_user.index') }}"> Kembali</a>
                </div>
            </div>
        </div>
        <div class="mb-4"></div> <!-- Added space below the header -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ops!</strong> Error <br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit User</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('m_user.update', $useri->user_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>User ID:</strong>
                                <input type="text" name="userid" value="{{ $useri->user_id }}" class="form-control" placeholder="Masukkan user id">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Level ID:</strong>
                                <input type="text" name="levelid" value="{{ $useri->level_id }}" class="form-control" placeholder="Masukkan level">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Username:</strong>
                                <input type="text" name="username" value="{{ $useri->username }}" class="form-control" placeholder="Masukkan username">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nama:</strong>
                                <input type="text" name="nama" value="{{ $useri->nama }}" class="form-control" placeholder="Masukkan nama">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Password:</strong>
                                <input type="password" name="password" value="{{ $useri->password }}" class="form-control" placeholder="Masukkan password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary action-btn">Update</button>
                        </div>
                    </div>
                </form>
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