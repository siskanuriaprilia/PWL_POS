@extends('layout.app')

@section('subtitle', 'Kategori')
@section('header_title', 'Kategori')
@section('header_subtitle', 'Create')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                {{-- Alert untuk Validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- Card Form --}}
                <div class="card card-primary shadow">
                    <div class="card-header">
                        <h3 class="card-title m-0">Buat Kategori Baru</h3>
                    </div>
                    <form method="POST" action="/kategori">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kodeKategori">Kode Kategori</label>
                                <input type="text" class="form-control" id="kodeKategori" name="kodeKategori" 
                                       placeholder="Masukkan kode kategori" value="{{ old('kodeKategori') }}">
                            </div>

                            <div class="form-group">
                                <label for="namaKategori">Nama Kategori</label>
                                <input type="text" class="form-control" id="namaKategori" name="namaKategori" 
                                       placeholder="Masukkan nama kategori" value="{{ old('namaKategori') }}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
