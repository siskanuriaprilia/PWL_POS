@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('supplier/create') }}">Tambah</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        
                   
                        <!-- Dropdown filter berdasarkan kode supplier -->
                        <div class="col-3">
                            <select class="form-control" id="supplier_kode">
                                <option value="">- Semua Kode -</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_kode }}">{{ $supplier->supplier_kode }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kode Supplier</small>
                        </div>
                    </div>
                </div>
            </div>
            

            <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
   $(document).ready(function() {
    var dataSupplier = $('#table_supplier').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ url('supplier/list') }}",
            "type": "POST",
            "data": function(d) {
                d.supplier_nama = $('#supplier_nama').val(); // Filter berdasarkan nama
                d.supplier_kode = $('#supplier_kode').val(); // Filter berdasarkan kode
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "supplier_kode", orderable: true, searchable: true },
            { data: "supplier_nama", orderable: true, searchable: true },
            { data: "supplier_alamat", orderable: false, searchable: false },
            { data: "supplier_telp", orderable: false, searchable: false },
            { data: "aksi", orderable: false, searchable: false }
        ]
    });

    // Event saat user mengetik di input pencarian
    $('#supplier_nama').on('keyup', function() {
        dataSupplier.ajax.reload();
    });

    // Event saat user mengubah pilihan pada dropdown filter kode supplier
    $('#supplier_kode').on('change', function() {
        dataSupplier.ajax.reload();
    });
});

</script>
@endpush