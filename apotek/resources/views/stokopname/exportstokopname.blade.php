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

        <?php $datalokasi = []; ?>
        @foreach ($lokasi as $lok)
            <?php $datalokasi[] = $lok->idlokasi; ?>
            <th>
                <p>{{ $lok->idlokasi }}-{{ $lok->namalokasi }}</p>
            </th>
        @endforeach

    </tr>

    <?php
    
    $i = 1;
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
        echo "<td align=center>$i</td>";
        echo '<td align=center class="str">' . $data->kdbarang . '</td>';
        echo '<td>' . $data->namabarang . '</td>';
        echo '<td>' . $data->satuan . '</td>';
    
        $jmlstok = 0;
    
        foreach ($datalokasi as $lok) {
            echo '<td align=center>';
            echo '0';
            echo '</td>';
        }
    
        echo '</tr>';
    
        $i++;
    
        //... loop
    }
    ?>


</table>
