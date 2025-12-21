@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-default mt-1" onclick="location.href='{{ url('stok') }}'"></i> Kembali ke Stok
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Kode Barang</th>
                        <td>{{ $barang->barang_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td>{{ $barang->barang_nama }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $barang->kategori->kategori_nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Stok Saat Ini</th>
                        <td><strong class="h4">{{ $barang->stok }}</strong> unit</td>
                    </tr>
                    <tr>
                        <th>Harga Beli</th>
                        <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Harga Jual</th>
                        <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Perubahan</th>
                        <th>Stok Sebelum</th>
                        <th>Stok Sesudah</th>
                        <th>Keterangan</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $history)
                    <tr>
                        <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($history->tipe_perubahan == 'masuk')
                                <span class="badge badge-success">Masuk</span>
                            @elseif($history->tipe_perubahan == 'keluar')
                                <span class="badge badge-danger">Keluar</span>
                            @elseif($history->tipe_perubahan == 'koreksi_tambah')
                                <span class="badge badge-warning">Koreksi +</span>
                            @else
                                <span class="badge badge-warning">Koreksi -</span>
                            @endif
                        </td>
                        <td class="{{ $history->perubahan >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $history->perubahan >= 0 ? '+' : '' }}{{ $history->perubahan }}
                        </td>
                        <td>{{ $history->stok_sebelum }}</td>
                        <td>{{ $history->stok_sesudah }}</td>
                        <td>{{ $history->keterangan }}</td>
                        <td>{{ $history->user->nama ?? 'System' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada history stok</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $histories->links() }}
        </div>
    </div>
</div>
@endsection