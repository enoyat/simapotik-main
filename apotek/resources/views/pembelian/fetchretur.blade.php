@if ($pembelian->count()>0)
<table  border="1" id="tabelku" style="font-size: 11px">
    <thead>
        <tr>
            <th width="20px" class="text-center">No</th>
            <th width="50px">No.Pembelian</th>
            <th width="100px">No Faktur</th>
            <th width="60px">Tanggal Transaksi</th>
            <th width="200px">supplier</th>
            <th width="40px">Lokasi</th>
            <th width="100px">Nominal</th>
            <th >Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        @foreach ($pembelian as $row)
            <tr>
                <td class="text-center">{{ ++$i }}</td>
                <td>{{ $row->id }}</td>
                <td>{{ $row->nofaktur }}</td>
                <td>{{ $row->tgltrans }}</td>
                <td>{{ $row->get_supplier->namasupplier }}</td>
                <td>{{ $row->idlokasi }}</td>
                <td style="text-align:right">{{ number_format($row->total) }}</td>

                <td>
                    <div style="display: inline;  width:35px">
                        <button class="btn btn-sm btn-info  btn-action"
                            data-url="{{ URL::to('/pembelian/trdetail/' . $row->id) }}" id="btnAction1">detail</button>
                    </div>
                    <div style="display: inline;  width:35px">
                        <a class="btn btn-sm btn-warning  "
                            href="{{ URL::to('/pembelian/listretur/' . $row->id) }}" id="btnAction1">retur</a>
                    </div>
                    <div style="display: inline;  float: right;width:35px">
                    <form action="{{ route('pembelian.hapuspembelian',$row->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                            onclick="return confirm('Hapus pembelian ini?');"><i
                                class="fa fa-trash" aria-hidden="true" ></i></button>
                    </form>
                    </div>

                </td>


            </tr>
        @endforeach
    </tbody>
</table>
@else
    Data tidak ditemukan
@endif
<script type="text/javascript">

    $('.btn-action').click(function() {
        var url = $(this).data("url");

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(res) {

                // get the ajax response data
                var data = res;

                // update modal content here
                // you may want to format data or
                // update other modal elements here too
                $('.modal-body').html(data);

                // show modal
                $('#myModal').modal('show');

            },
            error: function(request, status, error) {
                console.log("ajax call went wrong:" + request.responseText);
            }
        });
    });
</script>
