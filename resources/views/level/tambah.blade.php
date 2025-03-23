@extends('adminlte::page')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <!-- Form untuk m_level -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Form untuk tabel m_level</h3>
        </div>
        <form action="{{ url('/level/store') }}" method="POST">
          @csrf

          <div class="card-body">
            <!-- Pesan Error -->
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div class="form-group">
              <label for="levelName">Nama Level</label>
              <input type="text" name="level_nama" class="form-control @error('level_nama') is-invalid @enderror" 
                id="levelName" placeholder="Masukkan nama level" value="{{ old('level_nama') }}">
              @error('level_nama')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="levelCode">Kode Level</label>
              <input type="text" name="level_kode" class="form-control @error('level_kode') is-invalid @enderror" 
                id="levelCode" placeholder="Masukkan kode level" value="{{ old('level_kode') }}">
              @error('level_kode')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-info">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop

@section('css')
{{-- Tambahkan stylesheet tambahan di sini jika diperlukan --}}
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop