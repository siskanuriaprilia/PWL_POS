@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Barang</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-info btn-sm">Import Data Barang</button>
                <a href="{{ url('/barang/export_excel') }}" class="btn btn-primary btn-sm">Export Excel</a>
                <a href="{{ url('/barang/export_pdf') }}" class="btn btn-warning btn-sm">Export PDF</a>
                <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-success btn-sm">Tambah Data Barang</button>
                @if(Auth::check() && (Auth::user()->level_id == 1 || Auth::user()->level_id == 2))
                <a href="{{ url('/stok') }}" class="btn btn-secondary btn-sm">Manajemen Stok</a>
                @endif
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filter data -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row text-sm mb-0">
                            <label for="filter_date" class="col-md-1 col-form-label">Filter:</label>
                            <div class="col-md-3">
                                <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                                    <option value="">- Semua Kategori -</option>
                                    @foreach($kategori as $l)
                                        <option value="{{ $l->kategori_id }}">{{ $l->kategori_nama }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Kategori Barang</small>
                            </div>
                            <div class="col-md-3">
                                <select name="filter_stok" class="form-control form-control-sm filter_stok">
                                    <option value="">- Semua Status Stok -</option>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="menipis">Menipis (< 5)</option>
                                    <option value="habis">Habis</option>
                                </select>
                                <small class="form-text text-muted">Status Stok</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <table class="table table-bordered table-striped table-hover table-sm" id="table-barang">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="8%">Kode</th>
                        <th width="20%">Nama Barang</th>
                        <th class="text-right" width="12%">Harga Beli</th>
                        <th class="text-right" width="12%">Harga Jual</th>
                        <th class="text-center" width="8%">Stok</th>
                        <th class="text-center" width="12%">Status</th>
                        <th class="text-center" width="15%">Kategori</th>
                        <th class="text-center" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('css')
<style>
    .status-stok {
        font-size: 0.8rem;
        padding: 3px 8px;
        border-radius: 10px;
        font-weight: 500;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }
    .status-tersedia {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .status-menipis {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    .status-habis {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .table-actions {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    .table-actions .btn {
        padding: 2px 8px;
        font-size: 0.8rem;
    }
</style>
@endpush

@push('js')
<script>
    function modalAction(url = ''){
        $('#myModal').load(url,function(){
            $('#myModal').modal('show');
        });
    }

    var tableBarang;
    $(document).ready(function(){
        tableBarang = $('#table-barang').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 8,
            lengthMenu: [[8, , 50, -1], [10, 25, 50, "Semua"]],
            ajax: {
                url: "{{ url('barang/list') }}",
                type: "POST",
                data: function (d) {
                    d.filter_kategori = $('.filter_kategori').val();
                    d.filter_stok = $('.filter_stok').val();
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {
                    data: "DT_RowIndex", 
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    width: "5%"
                },
                {
                    data: "barang_kode", 
                    className: "text-center",
                    orderable: true,
                    searchable: true,
                    width: "8%"
                },
                {
                    data: "barang_nama", 
                    orderable: true,
                    searchable: true,
                    width: "20%"
                },
                {
                    data: "harga_beli", 
                    className: "text-right",
                    orderable: true,
                    searchable: false,
                    width: "12%",
                    render: function(data, type, row){
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                {
                    data: "harga_jual", 
                    className: "text-right",
                    orderable: true,
                    searchable: false,
                    width: "12%",
                    render: function(data, type, row){
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                {
                    data: "stok", 
                    className: "text-center",
                    orderable: true,
                    searchable: false,
                    width: "8%",
                    render: function(data, type, row){
                        return data;
                    }
                },
                {
                    data: "stok", 
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    width: "12%",
                    render: function(data, type, row){
                        if (data == 0) {
                            return '<span class="status-stok status-habis">Habis</span>';
                        } else if (data < 5) {
                            return '<span class="status-stok status-menipis">Menipis</span>';
                        } else {
                            return '<span class="status-stok status-tersedia">Tersedia</span>';
                        }
                    }
                },
                {
                    data: "kategori.kategori_nama", 
                    className: "text-center",
                    orderable: true,
                    searchable: false,
                    width: "15%",
                    render: function(data, type, row) {
                        return data || '-';
                    }
                },
              {
                data: "barang_id", 
                className: "text-center",
                orderable: false,
                searchable: false,
                width: "20%",
                render: function(data, type, row) {
                    return `
                        <div class="table-actions">
                            <button onclick="modalAction('{{ url('/barang') }}/${data}/show_ajax')" 
                                    class="btn btn-info btn-sm">
                                Detail
                            </button>
                            <button onclick="modalAction('{{ url('/barang') }}/${data}/edit_ajax')" 
                                    class="btn btn-warning btn-sm">
                                Edit
                            </button>
                            <button onclick="confirmDelete(${data})" 
                                    class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </div>
                    `;
                }
            }
                        ],
            order: [[1, 'asc']],
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                emptyTable: "Tidak ada data barang",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ barang",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 barang",
                lengthMenu: "Tampilkan _MENU_ barang",
                loadingRecords: "Memuat...",
                zeroRecords: "Tidak ada data yang cocok",
                search: "Search:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Previous",
                    previous: "Next"
                }
            }
        });

        $('#table-barang_filter input').unbind().bind().on('keyup', function(e){
            if(e.keyCode == 13){ // enter key
                tableBarang.search(this.value).draw();
            }
        });

        $('.filter_kategori, .filter_stok').change(function(){
            tableBarang.draw();
        });
    });

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
                // Tampilkan modal konfirmasi AJAX
                modalAction('{{ url("/barang") }}/' + barangId + '/confirm_ajax');
            }
        });
    }
</script>
@endpush