<h1>Laporan Mutasi Stok</h1>
<h2>Tanggal Cetak {{ date('d-m-Y') }}</h2>
<table>
    <tr>
        <td>Tanggal Transaksi</td>
        <td>:</td>
        <td>{{ date_format(date_create($tglmulai),"d-m-Y") }}</td>
    </tr>
    <tr>
        <td>S/d Tanggal</td>
        <td>:</td>
        <td>{{ date_format(date_create($tglakhir),"d-m-Y") }}</td>


</table>
<table width="900" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 10px">
    <thead>
        <tr>
            <th>
                No
            </th>
            <th>
                Lokasi Asal
            </th>

            <th>
                Lokasi Tujuan
            </th>
            <th>
                Kode
            </th>
            <th>
                Nama Produk
            </th>
            <th>
                Qty
            </th>
            <th>
                Tanggal Mutasi
            </th>
            <th>
               Email
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
                                    $i=1;
                            foreach ($mutasi as $key) {

                                ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $key->idlokasi; ?></td>

            <td><?php echo $key->idlokasidest; ?></td>
            <td><?php echo $key->kdbarang; ?></td>

            <td style="text-align: left"><?php echo $key->get_barang->namabarang; ?></td>
            <td style="text-align: center"><?php echo $key->qty; ?></td>
            <td style="text-align: center"><?php echo $key->tglmutasi; ?></td>
            <td style="text-align: center"><?php echo $key->email; ?></td>

        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
