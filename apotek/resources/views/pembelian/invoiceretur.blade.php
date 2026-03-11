@extends('template.master-dashboard-administrator')
@section('contents')
@php
use app\Http\Controllers\Pembelian;
@endphp
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Faktur Retur </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

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
                                        <th style="text-align: left; font-size: 12px">
                                            Apotek Sehati <br>


                                        </th>
                                    </tr>
                                </thead>

                            </table>
                            <br>
                            <center>
                                <h3><b>FAKTUR RETUR</b></h3>
                            </center>
                            <table>
                                <tr>
                                    <td>No.Faktur</td>
                                    <td>:</td>
                                    <td>{{ $retur->id }}</td>
                                </tr>
                                <tr>
                                    <td>Referensi Faktur</td>
                                    <td>:</td>
                                    <td>{{ $retur->get_pembelian->nofaktur }}</td>
                                </tr>
                                <tr>
                                    <td>Supplier</td>
                                    <td>:</td>
                                    <td>{{ $retur->get_pembelian->get_supplier->namasupplier }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Transaksi</td>
                                    <td>:</td>
                                    <td>{{ date_format(date_create($retur->tgltrans),"d-m-Y") }}</td>
                                </tr>
                            </table>

                            <table class="table table-bordered mb-5" style="text-align: left; font-size: 10px">
                                <thead>

                                    <tr class="table-danger">
                                        <th scope="col">Kode</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">No Batch</th>
                                        <th scope="col">Tgl. Ed</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Jumlah</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detailretur  as $data)
                                    <tr>
                                        <td width="5%">{{ $data->kdbarang }}</td>
                                        <td width="30%">{{ $data->get_barang->namabarang }}</td>
                                        <td width="10%">{{ $data->nobatch }}</td>
                                        <td width="10%">{{ $data->tglkadaluarsa }}</td>

                                        <td width="10%">{{ $data->get_detailpembelian->harga }}</td>
                                        <td width="5%" style="text-align: center;">{{ $data->qty }}</td>
                                        <td width="5%" style="text-align: center;">{{ number_format($data->qty*$data->get_detailpembelian->harga) }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table mb-5" style="text-align: left; font-size: 10px">
                                <tbody>
                                    <tr style="text-align: center;">
                                        <td>
                                            {{ Carbon\Carbon::now() }}<br>
                                            Bagian Keuangan:<br>
                                            <br>
                                            <br>
                                            <br>
                                            <label>....................</label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <button type="button" class="btn btn-primary" id="cetak" onclick="printDiv('area-print')">Cetak
                            Bukti</button>
                            <a class="btn btn-primary" href="{{ route('pembelian.retur') }}">Selesai</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>
<br>
<br>
@endsection
