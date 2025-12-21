@empty($barang)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/barang') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/barang/' . $barang->barang_id.'/delete_ajax') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                    Apakah Anda ingin menghapus data seperti di bawah ini?
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr><th class="text-right col-3">Kode Barang :</th><td class="col-9">{{ $barang->barang_kode }}</td></tr>
                    <tr><th class="text-right col-3">Nama Barang :</th><td class="col-9">{{ $barang->barang_nama }}</td></tr>
                    <tr><th class="text-right col-3">Harga Beli :</th><td class="col-9">{{ number_format($barang->harga_beli, 0, ',', '.') }}</td></tr>
                    <tr><th class="text-right col-3">Harga Jual :</th><td class="col-9">{{ number_format($barang->harga_jual, 0, ',', '.') }}</td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Ya, Hapus</button>
            </div>
        </div>
    </div>
    </form>
    <script>
       $(document).ready(function() {
    $("#form-delete").validate({
        rules: {},
        submitHandler: function(form) {
            var submitBtn = $(form).find('button[type="submit"]');
            var originalText = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menghapus...');
            
            $.ajax({
                url: form.action,
                type: 'DELETE',
                data: $(form).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.status){
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Data berhasil dihapus',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            tableBarang.ajax.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan'
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
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
            return false;
        }
    });
});