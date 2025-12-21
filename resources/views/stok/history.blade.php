<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">History Stok: {{ $barang->barang_nama }} ({{ $barang->barang_kode }})</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <strong>Stok Saat Ini:</strong> {{ number_format($barang->stok) }}
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Tipe</th>
                            <th>Perubahan</th>
                            <th>Stok Sebelum</th>
                            <th>Stok Sesudah</th>
                            <th>User</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $key => $history)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $history->created_at->format('d-m-Y H:i') }}</td>
                            <td>{!! $history->tipe_badge !!}</td>
                            <td class="{{ $history->perubahan >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $history->perubahan >= 0 ? '+' : '' }}{{ number_format($history->perubahan) }}
                            </td>
                            <td>{{ number_format($history->stok_sebelum) }}</td>
                            <td>{{ number_format($history->stok_sesudah) }}</td>
                            <td>{{ $history->user->nama ?? '-' }}</td>
                            <td>{{ $history->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>