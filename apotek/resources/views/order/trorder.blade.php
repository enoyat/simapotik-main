@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Order Pembelian</h1>

                </div>
            </div>
        </div>
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <table class="table table-bordered table-responsive" id="tabelku" style="font-size: 11px">
                        <thead>
                            <tr>
                                <th width="20px" class="text-center">No</th>
                                <th>No Order</th>
                                <th>Tanggal Transaksi</th>
                                <th>Supplier</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($order as $row)
                            <tr>
                                <td class="text-center">{{ ++$i }}</td>
                                <td>{{ $row->id }}</td>

                                <td>{{ $row->tgltrans }}</td>
                                <td>{{ $row->get_supplier->namasupplier }}</td>
                                <td>{{ $row->total }}</td>
                                <td><?php if ($row->f_aktif=='1') {
                                    echo '<p style="color:blue">Sudah Proses</p>';
                                } else {
                                    echo '<p style="color:Red">Belum Proses</p>';
                                }
                                ?></td>
                                <td>
                                    <div style="display: inline;  float:left; width:35px">

                                        <button class="btn btn-sm btn-info  btn-action"
                                            data-url="{{ URL::to('/order/trdetail/' . $row->id) }}"
                                            id="btnAction1" title="Detail"><i class="fa fa-search-plus" aria-hidden="true"></i></button>
                                    </div>
                                    @if($row->f_aktif=='0')
                                    <div style="display: inline;  float:left; width:35px">
                                        <a href="{{ route('order.inbond',$row->id) }}" class="btn btn-sm btn-success"
                                            title="Approve Order"><i class="fa fa-inbox"></i></i></a>
                                    </div>

                                    <div style="display: inline;  float:right; width:35px">
                                    <form action="{{ route('order.hapusorder',$row->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus Order ini?');"><i
                                                class="fa fa-trash" aria-hidden="true" title="Hapus Order"></i></button>
                                    </form>
                                    @endif
                                    </div>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
      


                </div>
            </div>
    </section>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#tabelku').DataTable();
    });

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
@endsection
