@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Retur customer</h1>
                        <HR>
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
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Ada kesalahan data, silahkan dicek kembali<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <script type="text/javascript">
                            function printDiv(divName) {
                                var printContents = document.getElementById(divName).innerHTML;
                                var originalContents = document.body.innerHTML;
                                document.body.innerHTML = printContents;
                                window.print();
                                document.body.innerHTML = originalContents;
                            }
                        </script>
                        <div class="container">


                            <div id="area-print">
                                <table>
                                    <thead>
                                        <tr>
                                            <th><img src="{{ asset('assets/img/logoapotik.png') }}" width="100px"
                                                    style="padding: 10px;">
                                            </th>
                                            <th style="text-align: left; font-size: 10px">
                                                Apotik Sehati Pati <br>


                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                                <br>
                                <center>
                                    <h3><b>DATA RETUR</b></h3>
                                </center>
                                <form action="{{ route('penjualan.approveretur') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="kdtransaksi" value="{{ $kdtransaksi }}">
                                    <table>
                                        <tr>
                                            <td>No. penjualan</td>
                                            <td>:</td>
                                            <td>{{ $penjualan->id }}
                                                <input type="hidden" value="{{ $penjualan->id }}" name="idpenjualan"
                                                    id="idpenjualan">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Customer</td>
                                            <td>:</td>
                                            <td><input type="hidden" value="{{ $penjualan->idcustomer }}" name="idcustomer"
                                                    id="idcustomer">
                                                {{ $penjualan->get_customer->namacustomer }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal penjualan</td>
                                            <td>:</td>
                                            <td>{{ date_format(date_create($penjualan->tgltrans), 'd-m-Y') }} - Jam
                                                {{ $penjualan->jam }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Retur</td>
                                            <td>:</td>
                                            <td> <input type="date" class="form-control" name="tgltrans" id="tgltrans"
                                                    aria-describedby="helpId" placeholder="" value="{{ date('Y-m-d') }}"
                                                    required></td>
                                        </tr>


                                    </table>

                                    <table class="table table-bpenjualaned mb-5" style="text-align: left; font-size: 10px">
                                        <thead>

                                            <tr class="table-danger">
                                                <th scope="col">Kode</th>
                                                <th scope="col">No Batch</th>
                                                <th scope="col">Tgl.Ed</th>
                                                <th scope="col">Nama Produk</th>
                                                <th scope="col">Qty Terjual</th>
                                                <th scope="col">Qty retur</th>
                                                <th scope="col">Retur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <form>
                                                <?php $i = 0;
                                                $total = 0; ?>
                                                @foreach ($datapenjualan as $data)
                                                    <tr>
                                                        <td width="3%">{{ $data->kdbarang }}
                                                            <input type="hidden" name="id[]" id="id{{ $i }}"
                                                                value="{{ $data->id }}" readonly
                                                                style="text-align: left; width: 50px">
                                                            <input type="hidden" name="kdbarang[]"
                                                                id="kdbarang{{ $i }}"
                                                                value="{{ $data->kdbarang }}" readonly
                                                                style="text-align: left; width: 50px">
                                                        </td>
                                                        <td width="5%">{{ $data->nobatch }}
                                                            <input type="hidden" name="nobatch[]"
                                                                id="nobatch{{ $i }}"
                                                                value="{{ $data->nobatch }}" readonly
                                                                style="text-align: left; width: 50px">

                                                        </td>

                                                        <td width="5%">{{ $data->tglkadaluarsa }}
                                                            <input type="hidden" name="tglkadaluarsa[]"
                                                                id="tglkadaluarsa{{ $i }}"
                                                                value="{{ $data->tglkadaluarsa }}" readonly
                                                                style="text-align: left; width: 50px">

                                                        </td>
                                                        <td width="40%">{{ $data->get_barang->namabarang }}</td>
                                                        <td width="5%" style="text-align: right;">
                                                            <input class="innilai" type="number" name="qtyjual[]"
                                                                id="qtyjual{{ $i }}"
                                                                value="{{ $data->qty }}"
                                                                style="text-align: right; width: 50px" readonly>

                                                        </td>
                                                        <td width="5%" style="text-align: right;">
                                                            <input class="innilai" type="number" name="qty[]"
                                                                id="qty{{ $i }}" value=""
                                                                style="text-align: right; width: 50px">
                                                            <div id="kode" style="display:none"><?php echo $i; ?>
                                                        </td>


                                                        <td width="10%" style="text-align: left;">

                                                            <input type="checkbox" name="checkretur[]"
                                                                value="{{ $i }}"
                                                                id="checkretur{{ $i }}">
                                                        </td>

                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
                                                <tr>
                                                    <td colspan="8" style="text-align: right">

                                                        <input type="submit" value="Simpan" class="btn btn-primary">
                                                    </td>
                                                </tr>
                                            </form>
                                        </tbody>
                                    </table>

                                </form>
                            </div>

                            <a class="btn btn-primary" href="{{ route('penjualan.retur') }}">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
    <br>
    <br>
    <script>
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
        $('.innilai').keyup(function() {
            var counter = $(this).closest('tr').find('#kode').text();
           // alert(counter);
            var qtyjual = $("#qtyjual" + counter).val();
            var qty = $("#qty" + counter).val();
            if (parseInt(qty) > parseInt(qtyjual)) {
                alert("Qty retur melebihi penjualan");
                $("#qty" + counter).val(qtyjual);
            }


        })
    </script>
@endsection
