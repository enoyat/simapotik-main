<?php ini_set('memory_limit', '2048M'); ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 11px">
    <tr>
        <td align="center" colspan="3">
            <h2>KARTU STOK</h2></strong></p>
        </td>
    </tr>
    <tr>
        <td width="100">TANGGAL </td>
        <td width="11">:</td>
        <td width="589">{{ date('d-m-Y') }}</td>
    </tr>
    <tr>
        <td width="100">Kode Barang </td>
        <td width="11">:</td>
        <td width="589">{{ $kdbarang }}</td>
    </tr>
</table>

<table width="100%" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid"
    style="font-size: 12px">
    <tr bgcolor="#CCCCCC">
        <th width="10" height="30">No.</th>
        <th>
            <p>Tanggal</p>
        </th>
        <th width="20">
            <p>No Transaksi</p>
        </th>
        <th>
            <p>Jenis Transaksi</p>
        </th>
        <th>
            <p>Lokasi Asal</p>
        </th>
        <th>
            <p>Gudang Tujuan</p>
        </th>
        <th>
            <p>Masuk</p>
        </th>
        <th>
            <p>Keluar</p>
        </th>
        <th>
            <p>Saldo</p>
        </th>

        <th>
            <p>email</p>
        </th>
        <th>
            <p>jam</p>
        </th>

    </tr>

    <?php
    
    $i = 1;
    $total = 0;
    
    foreach ($datastok as $data) {
        # code...
    
        //... batas halaman
        if ($i % 30 == 1) {
            if ($i > 1) {
                echo "<div class=\"pagebreak\"> </div>";
            }
        }
        //....... body detail
        echo '<tr >';
        echo "<td height='20' align=center>$i</td>";
        echo '<td align=center>' . $data->tgltrans . '</td>';
        echo '<td align=center>' . $data->id . '</td>';
        echo '<td>' . $data->jenis_transaksi . '</td>';
        echo '<td>' . $data->lokasi_asal . '</td>';
        echo '<td>' . $data->gudang_tujuan . '</td>';
        echo '<td>' . $data->masuk . '</td>';
        echo '<td>' . $data->keluar . '</td>';
        echo '<td>' . $data->saldo . '</td>';
        echo '<td>' . $data->email . '</td>';
        echo '<td>' . $data->jam . '</td>';
        $i++;
    }
    ?>



</table>
<button type="button" class="btn btn-sm btn-primary" id="cetak" onclick="printDiv('area-print')">Cetak
    Bukti</button>
