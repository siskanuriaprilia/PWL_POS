@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('/stok/report') }}" class="btn btn-success btn-sm mr-2"></i> Laporan Stok
            </a>
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="kategori_id" name="kategori_id">
                            <option value="">- Semua Kategori -</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Kategori Barang</small>
                    </div>
                    <div class="col-3">
                        <select class="form-control" id="status_stok" name="status_stok">
                            <option value="">- Semua Status -</option>
                            <option value="tersedia">Tersedia</option>
                            <option value="menipis">Menipis</option>
                            <option value="habis">Habis</option>
                        </select>
                        <small class="form-text text-muted">Status Stok</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabel -->
        <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Nilai Beli</th>
                    <th>Nilai Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal Update Stok -->
<div class="modal fade" id="modalStok" tabindex="-1" aria-labelledby="modalStokLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalStokLabel">Update Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formStok" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="barang_id_stok" name="barang_id">
                    <div class="form-group">
                        <label for="barang_nama_stok">Nama Barang</label>
                        <input type="text" class="form-control" id="barang_nama_stok" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tipe_perubahan">Tipe Perubahan</label>
                        <select class="form-control" id="tipe_perubahan" name="tipe_perubahan" required>
                            <option value="masuk">Stok Masuk (+)</option>
                            <option value="keluar">Stok Keluar (-)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Adjust Stok -->
<div class="modal fade" id="modalAdjust" tabindex="-1" aria-labelledby="modalAdjustLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAdjustLabel">Koreksi Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAdjust" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="barang_id_adjust" name="barang_id">
                    <div class="form-group">
                        <label for="barang_nama_adjust">Nama Barang</label>
                        <input type="text" class="form-control" id="barang_nama_adjust" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stok_sekarang">Stok Sekarang</label>
                        <input type="text" class="form-control" id="stok_sekarang" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stok_baru">Stok Baru</label>
                        <input type="number" class="form-control" id="stok_baru" name="stok_baru" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan Koreksi</label>
                        <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
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
        font-size: 24px;
        font-weight: bold;
    }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    var dataTable = $('#table_stok').DataTable({
        serverSide: true,
        pageLength: 3, // Jumlah baris default per halaman
        lengthMenu: [[3, 6, 12, 24, 50], [3, 6, 12, 24, 50, "Semua"]], // Opsi dropdown untuk memilih jumlah baris
        ajax: {
            url: "{{ url('stok/list') }}",
            data: function(d) {
                d.kategori_id = $('#kategori_id').val();
                d.status_stok = $('#status_stok').val();
            }
        },
        columns: [
            { 
                data: "DT_RowIndex", 
                className: "text-center", 
                orderable: false, 
                searchable: false 
            },
            { 
                data: "barang_kode", 
                className: "font-weight-bold",
                orderable: true, 
                searchable: true 
            },
            { 
                data: "barang_nama", 
                className: "",
                orderable: true, 
                searchable: true 
            },
            { 
                data: "kategori.kategori_nama", 
                className: "",
                orderable: true, 
                searchable: false 
            },
            { 
                data: "stok", 
                className: "text-center font-weight-bold",
                orderable: true, 
                searchable: false 
            },
            { 
                data: "status_stok", 
                className: "text-center",
                orderable: false, 
                searchable: false 
            },
            { 
                data: "harga_beli", 
                className: "text-right",
                orderable: true, 
                searchable: false,
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            { 
                data: "harga_jual", 
                className: "text-right font-weight-bold",
                orderable: true, 
                searchable: false,
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            { 
                data: "total_nilai_beli", 
                className: "text-right",
                orderable: true, 
                searchable: false 
            },
            { 
                data: "total_nilai_jual", 
                className: "text-right",
                orderable: true, 
                searchable: false 
            },
            { 
                data: "aksi", 
                className: "text-center",
                orderable: false, 
                searchable: false 
            }
        ],
        drawCallback: function(settings) {
            var api = this.api();
            var totalBarang = api.rows({ search: 'applied' }).count();
            var totalStok = 0;
            var stokMenipis = 0;
            var stokHabis = 0;
            
            api.rows({ search: 'applied' }).data().each(function(row) {
                totalStok += parseInt(row.stok);
                if (row.stok == 0) {
                    stokHabis++;
                } else if (row.stok < 5) {
                    stokMenipis++;
                }
            });
            
            $('#total-barang').text(totalBarang);
            $('#total-stok').text(totalStok);
            $('#stok-menipis').text(stokMenipis);
            $('#stok-habis').text(stokHabis);
        }
    });

    $('#kategori_id, #status_stok').on('change', function() {
        dataTable.ajax.reload();
    });

    // Toggle supplier field
    $('#tipe_perubahan').on('change', function() {
        if ($(this).val() === 'masuk') {
            $('#supplier-group').show();
        } else {
            $('#supplier-group').hide();
        }
    });

    // Show stok modal
    window.showStokModal = function(barangId, barangNama) {
        $('#barang_id_stok').val(barangId);
        $('#barang_nama_stok').val(barangNama);
        $('#tipe_perubahan').val('masuk');
        $('#jumlah').val('');
        $('#keterangan').val('');
        $('#supplier').val('');
        $('#supplier-group').show();
        $('#modalStok').modal('show');
    };

    // Show adjust modal
    window.showAdjustModal = function(barangId, barangNama, stokSekarang) {
        $('#barang_id_adjust').val(barangId);
        $('#barang_nama_adjust').val(barangNama);
        $('#stok_sekarang').val(stokSekarang);
        $('#stok_baru').val(stokSekarang);
        $('#alasan').val('');
        $('#modalAdjust').modal('show');
    };

    // Handle stok form submission
    $('#formStok').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var url = $('#tipe_perubahan').val() === 'masuk' ? '{{ url("stok/add") }}' : '{{ url("stok/reduce") }}';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#formStok button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            },
            success: function(response) {
                if (response.status) {
                    $('#modalStok').modal('hide');
                    dataTable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server'
                });
            },
            complete: function() {
                $('#formStok button[type="submit"]').prop('disabled', false).html('Simpan');
            }
        });
    });

    // Handle adjust form submission
    $('#formAdjust').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ url("stok/adjust") }}',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                $('#formAdjust button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            },
            success: function(response) {
                if (response.status) {
                    $('#modalAdjust').modal('hide');
                    dataTable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server'
                });
            },
            complete: function() {
                $('#formAdjust button[type="submit"]').prop('disabled', false).html('Simpan');
            }
        });
    });
});
</script>
@endpush