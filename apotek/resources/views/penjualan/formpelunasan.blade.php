 <form action="{{ route('penjualan.ubahtipepenjualan') }}" method="POST">
     @csrf
     @method('POST')
     <input type="hidden" name="id" value="{{ $data->id }}">
     Jumlah Tagihan : {{ number_format($data->total) }} <br>
     <label for="">Mode Pembayaran</label>
     <select nama="modebayar" id="modebayar" class="form-control" name="modebayar" required>
         <option value="">-- Pilih Mode Pembayaran --</option>
         <option value="Cash">Cash</option>
         <option value="Transfer">Transfer</option>
         <option value="QRIS">QRIS</option>
         <option value="Debit Card (EDC)">Debit Card (EDC)</option>
     </select>
     <br>
     <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
         onclick="return confirm('Ubah Tipe penjualan ini?');">Ubah Penjualan
         (Lunas)
     </button>
 </form>
