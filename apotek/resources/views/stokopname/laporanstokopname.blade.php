<h1>Laporan Transaksi Stok Opname</h1>
<h2>Tanggal Cetak {{ date('d-m-Y') }}</h2>
<table>
    <tr>
        <td>Tanggal Transaksi</td>
        <td>:</td>
        <td>{{ date_format(date_create($tglmulai), 'd-m-Y') }}</td>
    </tr>
    <tr>
        <td>S/d Tanggal</td>
        <td>:</td>
        <td>{{ date_format(date_create($tglakhir), 'd-m-Y') }}</td>


</table>
<table border=1 cellpadding=2 id='mydata'>
    <thead>
        <tr>
            <th>
                No
            </th>
            <th>
                Lokasi
            </th>

            <th>
                Kode
            </th>
            <th>
                Nama Produk
            </th>


            <th>
                Tanggal Opname
            </th>
            <th>
                Stok Sistem
            </th>
            <th>
                Stok Fisik
            </th>
            <th>
                Selisih
            </th>
            <th>
                Keterangan
            </th>
            <th>
                User
            </th>


        </tr>
    </thead>
    <tbody>
        <?php
                                    $i=1;
                            foreach ($barang as $key) {

                                ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $key->namalokasi; ?></td>

            <td><?php echo $key->kdbarang; ?></td>
            <td><?php echo $key->namabarang; ?></td>

            <td style="text-align: center"><?php echo $key->tanggal; ?></td>
            <td style="text-align: center"><?php echo $key->stoksistem; ?></td>
            <td style="text-align: center"><?php echo $key->stokfisik; ?></td>
            <td style="text-align: center"><?php echo $key->selisih; ?></td>
            <td style="text-align: left"><?php echo $key->keterangan; ?></td>
            <td style="text-align: left"><?php echo $key->email; ?></td>

        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
