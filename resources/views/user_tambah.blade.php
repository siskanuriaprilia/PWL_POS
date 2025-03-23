@extends('adminlte::page')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <!-- Form untuk m_user -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Form untuk tabel m_user</h3>
        </div>
        <form id="quickForm" method="POST" action="{{ url('/user/tambah_simpan') }}">
          @csrf
          <div class="card-body">
            <!-- Pesan error -->
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
              <label for="username">Username</label>
              <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                id="username" placeholder="Masukkan username" value="{{ old('username') }}">
              @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                id="nama" placeholder="Masukkan nama" value="{{ old('nama') }}">
              @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                id="password" placeholder="Masukkan password">
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="level">Level</label>
              <select name="level_id" class="form-control @error('level_id') is-invalid @enderror" id="level">
                <option value="">Pilih Level</option>
                <option value="1" {{ old('level_id') == 1 ? 'selected' : '' }}>Administrator</option>
                <option value="2" {{ old('level_id') == 2 ? 'selected' : '' }}>Manager</option>
                <option value="3" {{ old('level_id') == 3 ? 'selected' : '' }}>Staff</option>
              </select>
              @error('level_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-check">
              <input type="checkbox" name="terms" class="form-check-input" id="termsCheck">
              <label class="form-check-label" for="termsCheck">
                I agree to the <a href="#" class="text-primary font-weight-bold">terms of service</a>.
              </label>
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
@stop

@section('css')
{{-- Add here extra stylesheets --}}
@stop

@section('js')
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop