<?php ini_set('memory_limit', '2048M'); ?>
<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=Report ' . $title . '.xls');
?>
<style>
    .str {
        mso-number-format: \@;
    }
</style>
<table width="700" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid"
    style="font-size: 12px">
    <tr bgcolor="#CCCCCC">
        <th>No.</th>
        <th>
            <p>Kode</p>
        </th>
        <th>
            <p>Nama Produk</p>
        </th>
        <th>
            <p>Satuan</p>
        </th>
        <th>Harga HV</th>
        <th>Harga Resep</th>
        <th>Harga Grosir</th>




    </tr>

    <?php
    
    $i = 1;
    foreach ($barang as $data) {
        # code...
    
        //... batas halaman
        if ($i % 30 == 1) {
            if ($i > 1) {
                echo "<div class=\"pagebreak\"> </div>";
            }
        }
        //....... body detail
        echo '<tr >';
        echo "<td align=center>$i</td>";
        echo '<td align=center class="str">' . $data->kdbarang . '</td>';
        echo '<td>' . $data->namabarang . '</td>';
        echo '<td>' . $data->satuan . '</td>';
        echo '<td align=right>' . $data->hargahv . '</td>';
        echo '<td align=right>' . $data->hargaresep . '</td>';
        echo '<td align=right>' . $data->hargagrosir . '</td>';
        echo '</tr>';
    
        $i++;
    
        //... loop
    }
    ?>


</table>
