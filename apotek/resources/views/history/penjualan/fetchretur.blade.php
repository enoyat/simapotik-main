<div id="myModal" class="modal fade " tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 50%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


@if ($penjualan->count() > 0)
    <table border="1" id="tabelku" style="font-size: 11px">
        <thead>
            <tr>
                <th width="20px" class="text-center">No</th>
                <th width="50px">No.penjualan</th>
                <th width="60px">Tanggal Transaksi</th>
                <th width="60px">Jam</th>
                <th width="200px">customer</th>
                <th width="60px">Penjualan (T=Tunai, K=Kredit)</th>
                <th width="100px">Nominal</th>
                <th width="120px">Kasir</th>
                <th width="200px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($penjualan as $row)
                <tr>
                    <td class="text-center">{{ ++$i }}</td>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->tgltrans }}</td>
                    <td>{{ $row->jam }}</td>
                    <td>{{ $row->get_customer->namacustomer }} -

                        @if ($row->jenispenjualan == 'R')
                            {{ $row->namapasien }}
                            {{ $row->namadokter }}
                        @endif
                    </td>
                    <td class="text-center">{{ $row->tipepenjualan }}</td>

                    <td style="text-align:right">{{ number_format($row->total) }}</td>
                    <td>{{ $row->email }}</td>

                    <td>
                        <div style="display: inline;  width:35px">
                            <button class="btn btn-sm btn-info  btn-action"
                                data-url="{{ URL::to('/hspenjualan/trdetail/' . $row->idhspenjualan) }}"
                                id="btnAction1">detail</button>
                        </div>

                        @if ($row->jenispenjualan == 'R')
                            <div style="display: inline;  width:50px">
                                <a class="btn btn-sm btn-info  btn-action"
                                    data-url="{{ URL::to('/hspenjualan/trdetailresep/' . $row->idhspenjualan) }}"
                                    id="btnAction2">Detail
                                    Pasien</a>
                            </div>
                        @endif
                        <div style="display: inline;  width:35px">
                            <a class="btn btn-sm btn-warning "
                                href="{{ URL::to('/hspenjualan/listretur/' . $row->idhspenjualan) }}"
                                id="btnAction1">retur</a>
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
    $('#tabelku').DataTable({
        "scrollCollapse": true,
        "paging": true,
        "searching": true,
        "info": false,
        "order": [
            [1, "desc"]
        ]
    });
</script>
