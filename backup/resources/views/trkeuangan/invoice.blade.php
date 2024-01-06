@extends('template.master-dashboard-administrator')
@section('contents')
@php
use app\Http\Controllers\Trkeuangan;
@endphp
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Transaksi Keuangan </h1>
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
                        <a class="btn btn-primary" href="{{ route('trkeuangan') }}">Selesai</a>

                        <div id="area-print">
                            <table>
                                <thead>
                                    <tr>
                                        <th><img src="{{ asset('assets/img/logoapotik.png') }}" width="100px"
                                                style="padding: 10px;">
                                        </th>
                                        <th style="text-align: left; font-size: 10px">
                                            SIM Apotik<br>
                                           

                                        </th>
                                    </tr>
                                </thead>

                            </table>
                            <br>
                            <center>
                                <h3><b>BUKTI TRANSAKSI</b></h3>
                                <h5><b>NO: {{ Session::get('notrans') }}</b></h3><br />
                            </center>
                            <table class="table table-bordered mb-5" style="text-align: left; font-size: 10px">
                                <thead>

                                    <tr class="table-danger">
                                        <th scope="col">No.Bukti</th>
                                        <th scope="col">Tgl. Transaksi</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jurnalumum ?? '' as $data)
                                    <tr>
                                        <td width="5%">{{ $data->notrans }}</td>
                                        <td width="10%">{{ $data->tgltrans }}</td>
                                        <td width="65%">{{ $data->keterangan }}</td>
                                        <td width="20%" style="text-align: right;">{{ number_format($data->jumlah) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td scope="row"></td>
                                        <td colspan="3"> Terbilang:

                                            <label>
                                                @php
                                                $terbilang =Trkeuangan::terbilang($data->jumlah,$style=3);
                                                @endphp
                                                {{ $terbilang }} Rupiah
                                            </label>
                                        </td>

                                    </tr>
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
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>
@endsection
