@extends('layout.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="align-middle">Show User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('m_user.index') }}">CRUD User</a></li>
                    <li class="breadcrumb-item active">Show User</li>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th width="150px">User ID</th>
                            <td>{{ $useri->user_id }}</td>
                        </tr>
                        <tr>
                            <th>Level ID</th>
                            <td>{{ $useri->level_id }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $useri->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $useri->nama }}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>{{ $useri->password }}</td>
                        </tr>
                    </tbody>
                </table>
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