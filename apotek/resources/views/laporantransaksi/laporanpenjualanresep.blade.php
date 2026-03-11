<table width="900" border="0" cellpadding="0" cellspacing="0" style="font-size: 11px">
    <tr>
        <td align="center" colspan="3">
            <h2>Laporan Penjualan Resep {{ $tipepenjualan }}</h2></strong></p>
        </td>
    </tr>
    <tr>
        <td width="100">PERIODE</td>
        <td width="11">:</td>
        <td width="589">{{ date_format(date_create($tglmulai), 'd-m-Y') }} -
            {{ date_format(date_create($tglakhir), 'd-m-Y') }}
        </td>
    </tr>
</table>
<table width="900" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 10px">
    <tr bgcolor="#CCCCCC">
        <th width="20" height="30">No.</th>
        <th width="20">
            <p>notrans</p>
        </th>
        <th width="40">
            <p>Tanggal</p>
        </th>
        <th width="50">
            <p>customer</p>
        </th>
        <th width="30">
            <p>Type Penjualan</p>
        </th>
        <th width="30">
            <p>Mode Pembayaran</p>
        </th>
        <th width="30">
            <p>Kasir</p>
        </th>
        <th width="50">
            <p>Item penjualan</p>
        </th>

    </tr>

    <?php

    $total = 0;
    $i = 1;
    foreach ($datapenjualan as $data) {
        # code...
        //... batas halaman
        if (($i % 30) == 1) {
            if ($i > 1) {
                echo '<div class=\"pagebreak\"> </div>';
            };
        };
    ?>

        <tr>
            <td align=center valign=top>{{ $i }}</td>
            <td align=center valign=top>{{ $data->id }}</td>

            <td align=center valign=top>{{ date_format(date_create($data->tgltrans), 'd-m-Y') }} - Jam {{ $data->jam }}</td>
            <td valign=top>{{ $data->get_customer->namacustomer }}</td>
            <td valign=top align=center>{{ $data->tipepenjualan }}</td>
        <td valign=top align=center>{{ $data->modebayar }}</td>

            <td valign=top align=center>{{ $data->email }}</td>

            <td style="text-align: center">
                <table border="0" cellspacing="0" style="font-size: 10px" width="100%">
                    <tr>
                        <td width="15%"><u>Jenis Pasien</u></td>
                        <td width="30%"><u>Poly</u></td>
                        <td width="15%"><u>Dokter</u></td>
                        <td><u>Admin Resep</u></td>
                        <td><u>Admin Racik</u></td>
                    </tr>
                    @foreach ($data->get_detailresep as $detailresep)

                    <tr>
                        <td align=left> {{ $detailresep->get_jenispasien->namajenispasien }}</td>
                        <td align=left>{{ $detailresep->get_poly->namapoly }}</td>
                        <td align=left>{{ $detailresep->get_dokter->namadokter }}</td>
                        <td align=right>{{ number_format($detailresep->adminresep) }}</td>
                        <td align=right>{{ number_format($detailresep->adminracik) }}</td>

                    </tr>
                    @endforeach
                </table>
                <br>
                <table border="0" cellspacing="0" style="font-size: 10px" width="100%">
                    <tr>
                        <td width="15%"><u>kode</u></td>
                        <td width="30%"><u>nama produk</u></td>
                        <td width="15%"><u>Golongan</u></td>
                        <td><u>harga</u></td>
                        <td><u>qty</u></td>
                        <td><u>disc %</u></td>
                        <td><u>disc amount</u></td>
                        <td><u>Jumlah</u></td>

                    </tr>
                    @foreach ($data->get_detailpenjualan as $detail)

                    <tr>
                        <td align=left> {{ $detail->kdbarang }}</td>
                        <td align=left>{{ $detail->get_barang->namabarang }}</td>
                        <td align=left>{{ $detail->get_barang->get_golongan->namagolongan }}</td>
                        <td align=right>{{ number_format($detail->harga) }}</td>
                        <td align=center>{{ $detail->qty }}</td>
                        <td align=right>{{ number_format($detail->diskonpersen) }}</td>
                        <td align=right>{{ number_format($detail->diskon) }}</td>
                        <td align=right>{{ number_format($detail->jumlah) }}</td>
                    </tr>

                    <?php $total = $total + $detail->jumlah; ?>
                    @endforeach
                </table>
            </td>
        </tr>
    <?php
        $i++;


        //... loop
    }
    ?>
    <tr>
        <td colspan="6" align="right"></td>
        <td align="right" style="font-size: 13px;">Total penjualan: <b><?php echo number_format($total); ?></b></td>
    </tr>
</table>
