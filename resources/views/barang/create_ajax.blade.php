<form action="{{ url('/barang/ajax') }}" method="POST" id="form-tambah-barang">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah Data Barang
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kategori <span class="text-danger">*</span></label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Barang <span class="text-danger">*</span></label>
                    <input type="text" name="barang_kode" id="barang_kode" class="form-control" required>
                    <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="barang_nama" id="barang_nama" class="form-control" required>
                    <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Harga Beli <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="harga_beli" id="harga_beli" class="form-control" required min="0">
                            </div>
                            <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Harga Jual <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="harga_jual" id="harga_jual" class="form-control" required min="0">
                            </div>
                            <small id="error-harga_jual" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Stok Awal <span class="text-danger">*</span></label>
                    <input type="number" name="stok" id="stok" class="form-control" required min="0" value="0">
                    <small id="error-stok" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $("#form-tambah-barang").validate({
        rules: {
            kategori_id: { 
                required: true, 
                number: true 
            },
            barang_kode: { 
                required: true, 
                minlength: 3, 
                maxlength: 20 
            },
            barang_nama: { 
                required: true, 
                minlength: 3, 
                maxlength: 100 
            },
            harga_beli: { 
                required: true, 
                number: true, 
                min: 0 
            },
            harga_jual: { 
                required: true, 
                number: true, 
                min: 0 
            },
            stok: { 
                required: true, 
                number: true, 
                min: 0 
            }
        },
        messages: {
            kategori_id: {
                required: "Kategori harus dipilih",
                number: "Kategori tidak valid"
            },
            barang_kode: {
                required: "Kode barang harus diisi",
                minlength: "Kode barang minimal 3 karakter",
                maxlength: "Kode barang maksimal 20 karakter"
            },
            barang_nama: {
                required: "Nama barang harus diisi",
                minlength: "Nama barang minimal 3 karakter",
                maxlength: "Nama barang maksimal 100 karakter"
            },
            harga_beli: {
                required: "Harga beli harus diisi",
                number: "Harga beli harus angka",
                min: "Harga beli tidak boleh negatif"
            },
            harga_jual: {
                required: "Harga jual harus diisi",
                number: "Harga jual harus angka",
                min: "Harga jual tidak boleh negatif"
            },
            stok: {
                required: "Stok harus diisi",
                number: "Stok harus angka",
                min: "Stok tidak boleh negatif"
            }
        },
        submitHandler: function(form) {
            var submitBtn = $(form).find('button[type="submit"]');
            var originalText = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
            
            $.ajax({
                url: form.action,
                type: 'POST',
                data: $(form).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log("Response:", response);
                    var isSuccess = response.status === true || response.status === 'true' || response.status === 1;
                    
                    if(isSuccess) {
                        $('#modal-master').closest('.modal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Data berhasil disimpan',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ url('/barang') }}";
                        });
                    } else {
                        $('.error-text').text('');
                        if (response.msgField) {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                                $('#' + prefix).addClass('is-invalid');
                            });
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan'
                        });
                    }
                },
                error: function(xhr) {
                    console.log("Error:", xhr.responseText);
                    var errorMessage = 'Terjadi kesalahan pada server';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
            return false;
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    
    // Auto generate kode barang jika kosong
    $('#barang_nama').on('blur', function() {
        if ($('#barang_kode').val() === '') {
            var nama = $(this).val();
            if (nama.length >= 3) {
                var kode = nama.substring(0, 3).toUpperCase() + Math.floor(Math.random() * 1000);
                $('#barang_kode').val(kode);
            }
        }
    });
    
    // Auto calculate harga jual jika harga beli diisi
    $('#harga_beli').on('blur', function() {
        var hargaBeli = parseInt($(this).val()) || 0;
        if (hargaBeli > 0 && $('#harga_jual').val() === '') {
            var hargaJual = Math.ceil(hargaBeli * 1.2);
            $('#harga_jual').val(hargaJual);
        }
    });
});
</script>