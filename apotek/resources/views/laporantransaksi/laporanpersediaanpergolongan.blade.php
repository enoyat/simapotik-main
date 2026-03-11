<?php ini_set("memory_limit","2048M"); ?>

<table width="700" border="0" cellpadding="0" cellspacing="0" style="font-size: 11px">
    <tr>
    <td align="center" colspan="3"><h2>LAPORAN STOK PERSEDIAAN</h2></strong></p>		</td>
    </tr>
      <tr>
        <td width="100">TANGGAL </td>
        <td width="11">:</td>
        <td width="589">{{ date("d-m-Y") }}</td>
      </tr>
    </table>

        <table width="700" height="21" border="1"  cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 10px">
        <tr bgcolor="#CCCCCC">
        <th width="20" height="30">No.</th>
        <th width="10" ><p>Kode</p></th>
        <th width="100" ><p>Nama Produk</p></th>
        <th width="100" ><p>Golongan</p></th>
        <th width="30" ><p>HNA</p></th>
        <th width="120" ><p>Lokasi</p></th>
        <th width="50" ><p>Stok</p></th>
        <th width="50" ><p>Nominal</p></th>
        </tr>

    <?php


    $i=1;
    $total=0;
    foreach ($datastok as $data) {
        # code...

        //... batas halaman
        if(($i%30)==1){
            if($i > 1){
                echo "<div class=\"pagebreak\"> </div>";
            }
        }
        //....... body detail
        echo "<tr >";
        echo "<td height='20' align=center>$i</td>";
        echo "<td align=center>".$data->kdbarang."</td>";
        echo "<td>".$data->namabarang."</td>";
        echo "<td>".$data->namagolongan."</td>";
        echo "<td align=right>".number_format($data->hna)."</td>";

        echo "<td align=center>";
            $jmlstok=0;
            foreach ($data->jmlstok as $key => $value) {
                echo " ".$value->idlokasi . " : " .$value->stok;
                $jmlstok=$jmlstok+$value->stok;
            }
        echo "</td>";
        echo "<td  align=center>".$jmlstok."</td>";
        echo "<td align=right>".number_format($data->hna*$jmlstok)."</td>";   

        echo "</tr>";
        $total=$total+($data->hna*$jmlstok);

        $i++;



        //... loop
    }
    ?>
    <tr>
        <td colspan="7" align="right">Total</td>
        <td align="right">{{ number_format($total) }}</td>
    </tr>


</table>
