@extends('template.master-dashboard-administrator')
@section('contents')
@php
use app\Http\Controllers\Penjualan;
@endphp

<style>
#area-print {
    width: 800px;
    margin: auto;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 13px;
}

.header-table {
    width: 100%;
    border-bottom: 3px double #000;
    margin-bottom: 10px;
}

.header-table td {
    vertical-align: top;
}

.logo {
    height: 70px;
}

.toko-info h2 {
    margin: 0;
    font-size: 22px;
}

.toko-info p {
    margin: 0;
    font-size: 12px;
}

.invoice-title {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0;
}

.table-info {
    margin-top: 10px;
}

.table-produk {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.table-produk th,
.table-produk td {
    border: 1px solid #000;
    padding: 5px;
}

.table-produk th {
    text-align: center;
}

.total {
    font-weight: bold;
}

.ttd {
    margin-top: 30px;
    text-align: center;
    font-size: 11px;
}

@media print {

    .main-header,
    .main-sidebar,
    .content-header,
    .btn {
        display: none !important;
    }

    #area-print {
        width: 100%;
        margin: 0;
    }

}
</style>


<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoice Penjualan</h1>
                </div>
            </div>
        </div>
    </section>


    <section class="content">

        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="container">

                        <div id="area-print">

                            <table class="header-table">
                                <tr>

                                 
                                    <td class="toko-info text-center">
                                        <img src="{{ url('assets/img/logoapotik.png') }}" class="logo">
                                        <p>{{ $toko->alamat }}</p>
                                        <p>Telp: {{ $toko->telpon }}</p>
                                    </td>

                                </tr>
                            </table>


                            <div class="invoice-title">
                                INVOICE
                            </div>


                            <table class="table-info">

                                <tr>
                                    <td width="150">Invoice</td>
                                    <td width="10">:</td>
                                    <td>{{ $datapenjualan->id }}</td>
                                </tr>

                                <tr>
                                    <td>Customer</td>
                                    <td>:</td>
                                    <td>{{ $datapenjualan->get_customer->namacustomer }}</td>
                                </tr>

                                <tr>
                                    <td>Tanggal Transaksi</td>
                                    <td>:</td>
                                    <td>
                                        {{ date_format(date_create($datapenjualan->tgltrans),"d-m-Y") }}
                                        , Jam {{ $datapenjualan->jam }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>Jenis Transaksi</td>
                                    <td>:</td>
                                    <td>{{ $datapenjualan->tipepenjualan }}</td>
                                </tr>

                            </table>



                            <table class="table-produk">

                                <thead>

                                    <tr>
                                        <th width="10%">Kode</th>
                                        <th width="40%">Nama Produk</th>
                                        <th width="15%">Harga</th>
                                        <th width="10%">Qty</th>
                                        <th width="15%">Total</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($penjualan as $data)

                                    <tr>
                                        <td>{{ $data->kdbarang }}</td>

                                        <td>{{ $data->get_barang->namabarang }}</td>

                                        <td align="right">
                                            {{ number_format($data->harga) }}
                                        </td>

                                        <td align="right">
                                            {{ $data->qty }}
                                        </td>

                                        <td align="right">
                                            {{ number_format($data->jumlah) }}
                                        </td>
                                    </tr>

                                    @endforeach


                                    <tr>

                                        <td></td>

                                        <td colspan="3">
                                            Terbilang :
                                            <strong>

                                                @php
                                                $terbilang = Penjualan::terbilang($datapenjualan->total,$style=3);
                                                @endphp

                                                {{ $terbilang }} Rupiah

                                            </strong>
                                        </td>

                                        <td align="right" class="total">
                                            {{ number_format($datapenjualan->total,0) }}
                                        </td>

                                    </tr>

                                </tbody>

                            </table>



                            <div class="ttd">

                                {{ Carbon\Carbon::now() }} <br>
                                Bagian Keuangan

                                <br><br><br>

                                ( .................... )

                            </div>


                        </div>


                        <button class="btn btn-primary" onclick="window.print()">
                            Cetak Bukti
                        </button>

                        <a class="btn btn-primary" href="{{ route('penjualan.retur') }}">
                            Selesai
                        </a>


                    </div>
                </div>
            </div>
        </div>

    </section>

</div>

@endsection