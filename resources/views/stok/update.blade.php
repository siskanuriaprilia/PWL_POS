<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Stok: {{ $barang->barang_nama }}</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="form-update-stok">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" class="form-control" value="{{ $barang->barang_kode }}" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" class="form-control" value="{{ $barang->barang_nama }}" readonly>
                </div>
                <div class="form-group">
                    <label>Stok Saat Ini</label>
                    <input type="text" class="form-control font-weight-bold" value="{{ number_format($barang->stok) }}" readonly>
                </div>
                <div class="form-group">
                    <label>Tipe Perubahan</label>
                    <select name="tipe_perubahan" class="form-control" required>
                        <option value="masuk">Stok Masuk (+)</option>
                        <option value="keluar">Stok Keluar (-)</option>
                        <option value="koreksi_tambah">Koreksi Tambah (+)</option>
                        <option value="koreksi_kurang">Koreksi Kurang (-)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" min="1" required>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Penambahan stok dari supplier"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update Stok</button>
            </div>
        </form>
    </div>
</div>

<script>
$('#form-update-stok').submit(function(e){
    e.preventDefault();
    
    $.ajax({
        url: "{{ url('/stok/' . $barang->barang_id . '/update') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(response){
            if(response.status){
                alert(response.message);
                $('#myModal').modal('hide');
                $('#table-stok').DataTable().ajax.reload();
            } else {
                alert(response.message);
            }
        },
        error: function(){
            alert('Terjadi kesalahan!');
        }
    });
});
</script>