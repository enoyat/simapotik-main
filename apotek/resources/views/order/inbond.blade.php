@extends('template.master-dashboard-administrator')
@section('contents')
@php
use app\Http\Controllers\OrderController;
@endphp
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>FORM ORDER MASUK </h1>
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
                                <h3><b>DATA ORDER</b></h3>
                            </center>
                            <form action="{{ route('order.approve') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kdtransaksi" value="{{ $kdtransaksi }}">
                                <table>
                                    <tr>
                                        <td>No. Order</td>
                                        <td>:</td>
                                        <td>{{ $order->id }}
                                            <input type="hidden" value="{{ $order->id }}" name="idorder" id="idorder">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Suplier</td>
                                        <td>:</td>
                                        <td><input type="hidden" value="{{ $order->idsupplier }}" name="idsupplier"
                                                id="idsupplier">
                                            {{ $order->get_supplier->namasupplier }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Order</td>
                                        <td>:</td>
                                        <td>{{ date_format(date_create($order->tgltrans), 'd-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Approve</td>
                                        <td>:</td>
                                        <td> <input type="date" class="form-control" name="tgltrans" id="tgltrans"
                                                aria-describedby="helpId" placeholder="" value="{{ date('Y-m-d') }}"
                                                required></td>
                                    </tr>
                                    <tr>
                                        <td>No. Faktur </td>
                                        <td>:</td>
                                        <td>
                                            <input type="text" name="nofaktur" id="nofaktur" value="" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gudang </td>
                                        <td>:</td>
                                        <td>
                                            <select name="idlokasi" id="idlokasi" required>
                                                <option value="">Pilih Gudang</option>
                                                @foreach ($lokasi as $item)
                                                <option value="{{ $item->idlokasi }}">{{ $item->namalokasi }}
                                                </option>
                                                @endforeach
                                            </select>

                                        </td>
                                    </tr>
                                </table>

                                <table class="table table-bordered mb-5" style="text-align: left; font-size: 10px">
                                    <thead>

                                        <tr class="table-danger">
                                            <th scope="col">Kode</th>
                                            <th scope="col">No Batch</th>
                                            <th scope="col">Tgl.Ed</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Qty Order</th>
                                            <th scope="col">Qty Datang</th>
                                            <th scope="col">Diskon (%)</th>
                                            <th scope="col">Diskon (Rp)</th>
                                            <th scope="col">Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form>
                                            <?php $i = 0;
                                                $total = 0; ?>
                                            @foreach ($dataorder as $data)
                                            <tr>
                                                <td width="3%">
                                                    <input type="text" name="kdbarang[]" id="kdbarang{{ $i }}"
                                                        value="{{ $data->kdbarang }}" readonly
                                                        style="text-align: left; width: 50px">
                                                </td>
                                                <td width="5%">
                                                    <input type="text" name="nobatch[]" id="nobatch{{ $i }}"
                                                        value="{{ $data->nobatch }}"
                                                        style="text-align: left; width: 100px" require>
                                                </td>
                                                <td width="5%">
                                                    <input type="date" name="tglkadaluarsa[]" id="tglkadaluarsa{{ $i }}"
                                                        value="{{ $data->tglkadaluarsa }}" require>
                                                </td>
                                                <td width="40%">{{ $data->get_barang->namabarang }}</td>
                                                <td width="10%" style="text-align: right;">
                                                    <input class="innilai" type="text" name="harga[]" id="harga{{ $i }}"
                                                        value="{{ $data->harga }}"
                                                        style="text-align: right; width: 100px">
                                                </td>
                                                <td width="5%" style="text-align: right;">
                                                    <input class="innilai" type="text" name="qtyorder[]"
                                                        id="qtyorder{{ $i }}" value="1"
                                                        style="text-align: right; width: 50px" readonly>

                                                </td>
                                                <td width="5%" style="text-align: right;">
                                                    <input class="innilai" type="number" name="qty[]" id="qty{{ $i }}"
                                                        value="{{ number_format($data->qty) }}"
                                                        style="text-align: right; width: 50px">

                                                </td>
                                                <td style="text-align: right;">
                                                    <input class="indiskonpersen" type="text" name="diskonpersen[]"
                                                        id="diskonpersen{{ $i }}" value="0" max="100"
                                                        style="text-align: right; width: 50px">

                                                </td>
                                                <td width="5%" style="text-align: right;">
                                                    <input class="indiskon" type="text" name="diskon[]"
                                                        id="diskon{{ $i }}" value="0"
                                                        style="text-align: right; width: 60px">

                                                </td>
                                                <td width="10%" style="text-align: right;">
                                                    <input type="text" name="jumlah[]" id="jumlah{{ $i }}"
                                                        value="{{ $data->jumlah }}"
                                                        style="text-align: right; width: 100px" readonly>

                                                    <div id="kode" style="display:none"><?php echo $i; ?>
                                                    </div>
                                                </td>

                                            </tr>
                                            <?php $i++; ?>
                                            @endforeach



                                            <tr>
                                                <td scope="row"></td>
                                                <td colspan="4">


                                                </td>
                                                <td colspan="6" style="text-align: right">Total:

                                                    <input type="text" name="total" id="total"
                                                        value="{{ $order->total }}"
                                                        style="text-align: right; width: 100px" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="9" style="text-align: right">PPN (%):

                                                    <input type="text" name="ppn" id="ppn" value="11"
                                                        style="text-align: right; width: 100px" class="inppn">
                                                </td>
                                                <td style="text-align: right">

                                                    <input type="text" name="ppnnominal" id="ppnnominal" value=""
                                                        style="text-align: right; width: 100px" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="10" style="text-align: right">Total Pembelian:

                                                    <input type="text" name="totalpembelian" id="totalpembelian"
                                                        value="" style="text-align: right; width: 100px" readonly>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="10" style="text-align: right">
                                                    <input type="submit" value="Simpan" class="btn btn-primary">
                                                </td>
                                            </tr>
                                        </form>
                                    </tbody>
                                </table>

                            </form>
                        </div>

                        <a class="btn btn-primary" href="{{ route('order.trorder') }}">Selesai</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>
<br>
<br>
<script>
$(function() {
    var keyStop = {
        8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
        13: "input:text, input:password", // stop enter = submit 

        end: null
    };
    $(document).bind("keydown", function(event) {
        var selector = keyStop[event.which];

        if (selector !== undefined && $(event.target).is(selector)) {
            event.preventDefault(); //stop event
        }
        return true;
    });
});

function total() {
    var x = {{ count($dataorder) }};
    var total = 0;
    for (i = 0; i < x; i++) {
        var jumlah = parseInt($("#jumlah" + i).val());
        total = total + jumlah;
    }
    var ppn = $("#ppn").val();
    var ppnnominal = total * ppn / 100;
    $("#ppnnominal").val(Math.ceil(ppnnominal));
    $("#totalpembelian").val(Math.ceil(total + ppnnominal));
    $("#total").val(Math.ceil(total));

}

function hitung(counter, asal) {

    var qtyorder = $("#qtyorder" + counter).val();
    var qty = $("#qty" + counter).val();
    if (parseInt(qty) > parseInt(qtyorder)) {
        alert("Qty Datang Tidak Boleh Lebih Dari Qty Order");
        $("#qty" + counter).val(qtyorder);
        qty = qtyorder;
    } else {
        var harga = $("#harga" + counter).val();
        var qty = $("#qty" + counter).val();

        if (asal == 'diskonpersen') {
            var diskonpersen = $("#diskonpersen" + counter).val();
            var diskon = parseFloat(harga) * parseInt(qty) * parseFloat(diskonpersen) / 100;
            $("#diskon" + counter).val(diskon);

        } else if (asal == 'diskonrupiah') {
            var diskonpersen = $("#diskonpersen" + counter).val();
            var diskonamount = $("#diskon" + counter).val();
            var diskon = parseFloat(diskonamount);            
        }
       
        jumlah = parseFloat(harga) * parseInt(qty) - parseFloat(diskon);
        $("#jumlah" + counter).val(jumlah);
        total();
    }

}
$('.inppn').change(function() {
    total();
});
$('.indiskon').change(function() {
    var counter = $(this).closest('tr').find('#kode').text();
    var harga = $("#harga" + counter).val();
    var qty = $("#qty" + counter).val();
    var diskonamount = $("#diskon" + counter).val();

    hitung(counter, 'diskonrupiah');
});
$('.innilai').change(function() {
    var counter = $(this).closest('tr').find('#kode').text();
    hitung(counter, 'diskonpersen');
});
$('.indiskonpersen').change(function() {
    var counter = $(this).closest('tr').find('#kode').text();
    hitung(counter, 'diskonpersen');
});

</script>
@endsection