@extends('template.master-dashboard-administrator')
@section('contents')
    @php
        use app\Http\Controllers\Penjualan;
    @endphp
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Invoice Penjualan </h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container">
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
                                <table width="500px">
                                    <thead>

                                        <tr>

                                            <th colspan="2" style="text-align: left; font-size: 12px">
                                                <h3><b>INVOICE KHUSUS</b></h3>

                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                                <br>

                                <table width="500px">
                                    <tr>
                                        <td>Invoice</td>
                                        <td>:</td>
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
                                        <td>{{ date_format(date_create($datapenjualan->tgltrans), 'd-m-Y') }}, Jam
                                            {{ $datapenjualan->jam }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Transaksi</td>
                                        <td>:</td>
                                        <td>{{ $datapenjualan->tipepenjualan }}</td>
                                    </tr>
                                </table>

                                <table border="1" style="text-align: left; font-size: 12px" width="100%">
                                    <thead>

                                        <tr class="table-danger">
                                            <th scope="col">Kode</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Harga HV</th>
                                            <th scope="col">Harga Beli</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penjualan as $data)
                                            <tr>
                                                <td width="5%">{{ $data->kdbarang }}</td>
                                                <td width="30%">{{ $data->get_barang->namabarang }}</td>
                                                <td width="10%" style="text-align: right;">
                                                    {{ number_format($data->get_barang->hargahv) }}
                                                </td>
                                                <td width="10%" style="text-align: right;">
                                                    {{ number_format($data->harga) }}
                                                </td>
                                                <td width="5%" style="text-align: right;">{{ $data->qty }}</td>
                                                <td width="10%" style="text-align: right;">
                                                    {{ number_format($data->jumlah) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td scope="row"></td>
                                            <td colspan="3"> Terbilang:

                                                <label>
                                                    @php
                                                        $terbilang = Penjualan::terbilang(
                                                            $datapenjualan->total,
                                                            $style = 3,
                                                        );
                                                    @endphp
                                                    {{ $terbilang }} Rupiah
                                                </label>
                                            </td>
                                            <td colspan="3" style="text-align: right">Total:
                                                {{ number_format($datapenjualan->total, 0) }}</td>



                                        </tr>
                                    </tbody>
                                </table>
                                <table style="text-align: left; font-size: 10px">
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

                            <button type="button" class="btn btn-primary" id="cetak"
                                onclick="printDiv('area-print')">Cetak
                                Bukti</button>
                            <a class="btn btn-primary" href="{{ route('penjualan.retur') }}">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
    <br>
    <br>
@endsection
