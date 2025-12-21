@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manajemen Stok Barang</h3>
        <div class="card-tools">
            <a href="{{ url('/stok/history-all') }}" class="btn btn-info">
                <i class="fas fa-history"></i> History Semua Stok
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-3">
                <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="filter_status" class="form-control form-control-sm filter_status">
                    <option value="">Semua Status</option>
                    <option value="habis">Stok Habis</option>
                    <option value="menipis">Stok Menipis (< 5)</option>
                    <option value="tersedia">Stok Tersedia</option>
                </select>
            </div>
        </div>

        <table class="table table-bordered table-hover" id="table-stok">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1"></div>
@endsection

@push('js')
<script>
$(document).ready(function(){
    var tableStok = $('#table-stok').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('stok/list') }}",
            data: function (d) {
                d.filter_kategori = $('.filter_kategori').val();
                d.filter_status = $('.filter_status').val();
            }
        },
        columns: [
            { data: "DT_RowIndex", orderable: false },
            { data: "barang_kode" },
            { data: "barang_nama" },
            { data: "kategori.kategori_nama" },
            { 
                data: "harga_beli",
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            { 
                data: "harga_jual",
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            { 
                data: "stok",
                className: "text-center font-weight-bold"
            },
            { 
                data: "status_stok",
                className: "text-center"
            },
            { 
                data: "aksi",
                className: "text-center",
                orderable: false
            }
        ]
    });

    $('.filter_kategori, .filter_status').change(function(){
        tableStok.draw();
    });
});

function modalAction(url){
    $('#myModal').load(url, function(){
        $('#myModal').modal('show');
    });
}
</script>
@endpush