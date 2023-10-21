<h1>Laporan Stok</h1>
<table>
    <tr>
        <td width="100px">Tanggal</td>
        <td width="10px">:</td>
        <td>{{ date('d-m-Y') }}</td>
    <tr>
        <td width="100px">Lokasi</td>
        <td width="10px">:</td>
        <td>{{ $datastok->get_lokasi->namalokasi }}</td>
    </tr>

    <tr>
        <td>Kategori</td>
        <td>:</td>
        <td>{{ $datastok->get_barang->get_kategori->namakategori}}</td>


</table>


<table border=1 cellpadding=2 id='mydata'>
    <thead>
        <tr>
            <th>
                No
            </th>
            <th>
                Kode
            </th>
            <th>
                Nama Produk
            </th>
            <th>
                Stok
            </th>
            <th>
                Fisik
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
            <td><?php echo $key->kdbarang; ?></td>
            <td><?php echo $key->namabarang; ?></td>
            <td style="text-align: center"><?php echo $key->stok; ?></td>
            <td style="text-align: center" width="15%"></td>

        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
