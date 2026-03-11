@extends('template.master-dashboard-administrator')
@section('contents')
    @php
        use app\Http\Controllers\Pembelian;
    @endphp
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Daftar Retur</h1>

                    </div>
                </div>
            </div>
        </section>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">RETUR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <table border="1" id="tabelku" style="font-size: 11px">
                            <thead>
                                <tr>
                                    <th width="20px" class="text-center">No</th>
                                    <th width="50px">No.retur</th>
                                    <th width="100px">No Pembelian</th>
                                    <th width="100px">No Ref Faktur</th>
                                    <th width="60px">Tanggal Transaksi</th>
                                    <th width="200px">supplier</th>
                                    <th width="200px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($retur as $row)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->idpembelian }}</td>
                                        <td>{{ $row->get_pembelian->nofaktur }}</td>
                                        <td>{{ $row->tgltrans }}</td>
                                        <td>{{ $row->get_pembelian->get_supplier->namasupplier }}</td>
                                        <td>
                                            <div style="display: inline;  width:35px">
                                                <button class="btn btn-sm btn-info  btn-action"
                                                    data-url="{{ route('hspembelian.trreturdetail', $row->idhsdetailpembelian) }}"
                                                    id="btnAction1">detail</button>
                                            </div>


                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
