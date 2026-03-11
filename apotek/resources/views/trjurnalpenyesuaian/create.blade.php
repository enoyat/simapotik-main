    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @foreach ($datajurnal as $data) 
    <form action="{{ route('trjurnalpenyesuaian.destroy',$data->notrans) }}" method="GET">
        @csrf
  
  <table class="table table-hover">
    <tr>
      <td colspan="2" style="background: blue; color: white" >FORM BATAL TRANSAKSI KEUANGAN</td>
    </tr>

    <tr>
    <td colspan="2"> 
      
          <b>No. Transaksi:</b> {{ $data->notrans }}<br>
          <b>Tgl. Transaksi:</b> {{ $data->tgltrans }}<br>
          <b>Keterangan:</b> {{ $data->keterangan }}<br>
          <b>Jumlah:</b> {{ number_format($data->jumlah) }}<br>

          <br>
      <button type="submit" class="btn btn-primary" onclick="return confirm('Hapus Transaksi Ini ?')">Batalkan</button>
    </td>
  </tr>
  </table>
</form>
      @endforeach
</div>
