
<table width="900" border="0" cellpadding="0" cellspacing="0" style="font-size: 11px">
    <tr>
    <td align="center" colspan="3"><h2>LAPORAN pembelian</h2></strong></p>		</td>
    </tr>
      <tr>
        <td width="100">PERIODE</td>
        <td width="11">:</td>
        <td width="589">{{ date_format(date_create($tglmulai),"d-m-Y") }} - {{ date_format(date_create($tglakhir),"d-m-Y") }}</td>
      </tr>
    </table>

        <table width="900" height="21" border="1"  cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 11px">
        <tr bgcolor="#CCCCCC">
        <th width="20" height="30">No.</th>
        <th width="20" ><p>notrans</p></th>
        <th width="40" ><p>Tanggal</p></th>
        <th width="50" ><p>Supplier</p></th>
        <th width="100" ><p>Golongan</p></th>
        <th width="40" ><p>Kode</p></th>
        <th width="100" ><p>Nama Produk</p></th>

        <th width="40"><p>Harga</p></p></th>
        <th width="30"><p>qty</p></p></th>
        <th width="40"><p>Disk %</p></th>
        <th width="40"><p>Disk Amount</p></th>
        <th width="40"><p>Jumlah</p></th>
        </tr>

    <?php

    $total=0;
    $totaldiskon=0;
    $i=1;
    $stategolongan="";
    foreach ($datapembelian as $data) {
        $rungolongan=$data->namagolongan;
                    if ($stategolongan!=$rungolongan) {
                        echo "<tr height=20px><td colspan=12></td></tr>";
                    }

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
        echo "<td align=center>".$data->id."</td>";
        echo "<td align=center>".date_format(date_create($data->tgltrans),"d-m-Y")."</td>";
        echo "<td>".$data->namasupplier."</td>";
        echo "<td align=left>".$data->namagolongan."</td>";
        echo "<td align=left>".$data->kdbarang."</td>";
        echo "<td align=left>".$data->namabarang."</td>";

        echo "<td align=right>".number_format($data->harga)."</td>";
        echo "<td align=center>".$data->qty."</td>";
        echo "<td align=right>".number_format($data->diskpersen)."</td>";
        echo "<td align=right>".number_format($data->diskon)."</td>";
        echo "<td align=right>".number_format($data->jumlah)."</td>";
        echo "</tr>";
        $i++;
        $totaldiskon=$totaldiskon+$data->diskon;
        $total=$total+$data->jumlah;
        $stategolongan=$rungolongan;
        //... loop

    }
    ?>
    <tr>
        <td colspan="10" align="right">Total</td>
        <td align="right"><?php echo number_format($totaldiskon); ?></td>
        <td align="right"><?php echo number_format($total); ?></td>
    </tr>
</table>
