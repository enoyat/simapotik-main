
<table width="700" border="0" cellpadding="0" cellspacing="0" style="font-size: 11px">
    <tr>
    <td align="center" colspan="3"><h2>Laporan Penjualan</h2></strong></p>		</td>
    </tr>
      <tr>
        <td width="100">PERIODE</td>
        <td width="11">:</td>
        <td width="589">{{ date_format(date_create($tglmulai),"d-m-Y") }} - {{ date_format(date_create($tglakhir),"d-m-Y") }}</td>
      </tr>
    </table>

        <table width="700" height="21" border="1"  cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 11px">
        <tr bgcolor="#CCCCCC">
        <th width="20" height="30">No.</th>
        <th width="20" ><p>notrans</p></th>
        <th width="40" ><p>Tanggal</p></th>
        <th width="50" ><p>Customer</p></th>
        <th width="40" ><p>Kode</p></th>
        <th width="100" ><p>Nama Produk</p></th>
        <th width="40"><p>Harga</p></p></th>
        <th width="30"><p>qty</p></p></th>
        <th width="40"><p>Diskon</p></th>
        <th width="40"><p>Jumlah</p></th>
        <th width="40"><p>PPN</p></th>
        <th width="40"><p>Netto Penjualan</p></th>
        </tr>

    <?php

    $total=0;
    $totalpajak=0;
    $i=1;
    foreach ($datapenjualan as $data) {
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
        echo "<td>".$data->namacustomer."</td>";
        echo "<td align=center>".$data->kdbarang."</td>";
        echo "<td align=left>".$data->namabarang."</td>";

        echo "<td align=right>".number_format($data->harga)."</td>";
        echo "<td align=center>".$data->qty."</td>";
        $ppn=($data->jumlah*$data->ppn)/100;
        $jumlah=$data->jumlah-$ppn;
        echo "<td align=right>".number_format($data->diskpenjualan)."</td>";
        echo "<td align=right>".number_format($data->jumlah)."</td>";
        echo "<td align=right>".number_format($ppn)."</td>";
        echo "<td align=right>".number_format($jumlah)."</td>";
        echo "</tr>";
        $i++;

        $total=$total+$jumlah;
        $totalpajak=$totalpajak+$ppn;
        //... loop
    }
    ?>
    <tr>
        <td colspan="9" align="right">Total</td>
        <td align="right"><?php echo number_format($total); ?></td>
        <td align="right"><?php echo number_format($totalpajak); ?></td>
        <td align="right"><?php echo number_format($total); ?></td>
    </tr>
</table>
