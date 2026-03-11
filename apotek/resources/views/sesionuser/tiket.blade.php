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
                    <h1>TIKET SESSION </h1>
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
                                <h3><b>TIKET SESSION</b></h3>
                            </center>
                            <table>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>{{ date_format(date_create($order->tgltrans),"d-m-Y") }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $order->email }}</td>
                                </tr>
                                <tr>
                                    <td>Token</td>
                                    <td>:</td>
                                    <td>{{ $order->token }}</td>
                                </tr>
                            </table>


                        </div>
<br>
<br>
                        <button type="button" class="btn btn-primary" id="cetak" onclick="printDiv('area-print')">Cetak
                            Tiket</button>
                            <a class="btn btn-primary" href="{{ route('sesionuser') }}">Selesai</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>
<br>
<br>
@endsection
