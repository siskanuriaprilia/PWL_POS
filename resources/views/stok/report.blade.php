@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-default mt-1" onclick="location.href='{{ url('stok') }}'"></i> Kembali
            </button>
        </div>
</div>
        <!-- Barang Stok Terbanyak -->
        <div class="card card-success mb-4">
            <div class="card-header">
                <h3 class="card-title">5 Barang dengan Stok Terbanyak</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Nilai Beli</th>
                                <th>Nilai Jual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokTerbanyak as $index => $barang)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $barang->barang_kode }}</td>
                                <td>{{ $barang->barang_nama }}</td>
                                <td>{{ $barang->kategori->kategori_nama }}</td>
                                <td><span class="badge badge-success">{{ $barang->stok }}</span></td>
                                <td>Rp {{ number_format($barang->stok * $barang->harga_beli, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($barang->stok * $barang->harga_jual, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endsection

@push('css')
<style>
    .info-box {
        color: white;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }
    .info-box-icon {
        float: left;
        height: 70px;
        width: 70px;
        text-align: center;
        font-size: 30px;
        line-height: 70px;
        background: rgba(0,0,0,0.2);
        border-radius: 5px;
    }
    .info-box-content {
        padding: 10px 10px 10px 80px;
    }
    .info-box-text {
        font-size: 14px;
        text-transform: uppercase;
    }
    .info-box-number {
        font-size: 20px;
        font-weight: bold;
    }
</style>
@endpush