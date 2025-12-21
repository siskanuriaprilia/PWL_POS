@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title ?? 'Detail Barang' }}</h3>
            <div class="card-tools">
                <a href="{{ url('barang') }}" class="btn btn-sm btn-default">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            @if(empty($barang))
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <tr>
                                <th width="40%">ID Barang</th>
                                <td>{{ $barang->barang_id }}</td>
                            </tr>
                            <tr>
                                <th>Kode Barang</th>
                                <td>
                                    <span class="badge badge-primary">{{ $barang->barang_kode }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Barang</th>
                                <td>{{ $barang->barang_nama }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>
                                    @if($barang->kategori)
                                        <span class="badge badge-secondary">{{ $barang->kategori->kategori_nama }}</span>
                                    @else
                                        <span class="text-danger">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td class="text-center">
                                    @if($barang->stok == 0)
                                        <span class="badge badge-danger">Habis (0)</span>
                                    @elseif($barang->stok < 5)
                                        <span class="badge badge-warning">Menipis ({{ $barang->stok }})</span>
                                    @else
                                        <span class="badge badge-success">Tersedia ({{ $barang->stok }})</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <tr>
                                <th width="40%">Harga Beli</th>
                                <td class="text-right">Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td class="text-right text-success">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Margin</th>
                                <td class="text-right">
                                    <span class="text-success font-weight-bold">
                                        Rp {{ number_format($barang->harga_jual - $barang->harga_beli, 0, ',', '.') }}
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        ({{ number_format((($barang->harga_jual - $barang->harga_beli) / $barang->harga_beli) * 100, 2) }}%)
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <th>Nilai Total Beli</th>
                                <td class="text-right text-warning">Rp {{ number_format($barang->stok * $barang->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Nilai Total Jual</th>
                                <td class="text-right text-success">Rp {{ number_format($barang->stok * $barang->harga_jual, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-calendar-alt mr-2"></i>Informasi Waktu
                                </h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="50%">Dibuat</th>
                                        <td>{{ $barang->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Diupdate</th>
                                        <td>{{ $barang->updated_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-line mr-2"></i>Statistik
                                </h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="50%">Potensi Profit</th>
                                        <td class="text-success font-weight-bold">
                                            Rp {{ number_format($barang->stok * ($barang->harga_jual - $barang->harga_beli), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Stok per Harga</th>
                                        <td>
                                            <small class="text-muted">
                                                Beli: Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}/unit<br>
                                                Jual: Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}/unit
                                            </small>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="mt-4">
                    <div class="btn-group">
                        <button onclick="modalAction('{{ url('/barang') }}/{{ $barang->barang_id }}/edit_ajax')" 
                                class="btn btn-warning">
                            <i class="fas fa-edit mr-1"></i> Edit Barang
                        </button>
                        <button onclick="confirmDelete({{ $barang->barang_id }})" 
                                class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Hapus Barang
                        </button>
                        <a href="{{ url('/stok') }}?barang_id={{ $barang->barang_id }}" 
                           class="btn btn-primary">
                            <i class="fas fa-boxes mr-1"></i> Kelola Stok
                        </a>
                        <a href="{{ url('/barang') }}" 
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('css')
<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .table td {
        vertical-align: middle;
    }
    .card-header {
        font-weight: 600;
    }
    .btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .btn-group .btn {
        flex: 1;
        min-width: 150px;
    }
</style>
@endpush

@push('js')
<script>
    function modalAction(url = ''){
        $('#myModal').load(url, function(){
            $('#myModal').modal('show');
        });
    }

    function confirmDelete(barangId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data barang akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                modalAction('{{ url("/barang") }}/' + barangId + '/confirm_ajax');
            }
        });
    }
</script>
@endpush