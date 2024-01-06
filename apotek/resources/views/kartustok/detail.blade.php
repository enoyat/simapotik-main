<?php ini_set("memory_limit","2048M"); ?>
{{ date("d-m-Y") }} detail {{ $kdtransaksi }} <br><br>

<table width="700" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 10px">
    <tr bgcolor="#CCCCCC">
        <th width="20" height="30">No.</th>
        <th width="10">
            <p>Kode</p>
        </th>
        <th width="100">
            <p>Tanggal</p>
        </th>
        <th width="100">
            <p>NoInv</p>
        </th>
        <th width="100">
            <p>Nama Produk</p>
        </th>


        <th width="30">
            <p>qty</p>
        </th>
        <th width="50">
            <p>Teller</p>
        </th>
           

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
       
        echo "<td align=center>".$data->tgltrans."</td>";
        echo "<td align=center>".$data->id."</td>";

        echo "<td>".$data->namabarang."</td>";
       
       
        echo "<td align=center>".$data->qty."</td>";
        echo "<td align=center>".$data->email."</td>";

       

        echo "</tr>";
        $total=$total+$data->qty;

        $i++;



        //... loop
    }
    ?>
    <tr>
        <td colspan="5" align="right">Total</td>
        <td align="right">{{ number_format($total) }}</td>
        <td></td>

    </tr>


</table>