
<table width="900" border="0" cellpadding="0" cellspacing="0" style="font-size: 11px">
    <tr>
    <td align="center" colspan="3"><h2>LAPORAN LABA/RUGI</h2></strong></p>		</td>
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
        <th width="50" ><p>Customer</p></th>
        <th width="40" ><p>Golongan</p></th>

        <th width="40" ><p>Kode</p></th>
        <th width="100" ><p>Nama Produk</p></th>
        <th width="30"><p>qty</p></p></th>
        <th width="40"><p>Harga Pokok</p></p></th>

        <th width="30"><p>Pembelian</p></p></th>
        <th width="40"><p>Harga Jual</p></p></th>
        <th width="40"><p>Disk %</p></th>
        <th width="40"><p>Diskon Rp</p></th>
        <th width="40"><p>Penjualan</p></p></th>
        </tr>

    <?php

    $totalpenjualan=0;
    $totalpembelian=0;
    $totaldiskon=0;
    $labarugi=0;
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
        echo "<td align=left>".$data->namagolongan."</td>";
        echo "<td align=center>".$data->kdbarang."</td>";
        echo "<td align=left>".$data->namabarang."</td>";
        echo "<td align=center>".$data->qty."</td>";
        echo "<td align=right>".number_format($data->hargabeli)."</td>";
        $pembelian=$data->hargabeli*$data->qty;
        echo "<td align=right>".number_format($pembelian)."</td>";
        echo "<td align=right>".number_format($data->hargahv)."</td>";
        echo "<td align=right>".number_format($data->diskonpersen)."</td>";
        echo "<td align=right>".number_format($data->diskpenjualan)."</td>";
        echo "<td align=right>".number_format($data->jumlah)."</td>";
        echo "</tr>";

        $i++;
        $totalpembelian=$totalpembelian+$pembelian;
        $totaldiskon=$totaldiskon+$data->diskon;
        $totalpenjualan=$totalpenjualan+$data->jumlah;
        $labarugi=$totalpenjualan-$totalpembelian;


        //... loop
    }
    ?>
    <tr>
        <td colspan="9" align="right">Total </td>
        <td align="right"><?php echo number_format($totalpembelian); ?></td>
        <td align="right" colspan="2"></td>        

        <td align="right" ><?php echo number_format($totaldiskon); ?></td>
        <td align="right"><?php echo number_format($totalpenjualan); ?></td>

    </tr>
        <tr>
        <td colspan="13" align="right">Laba/Rugi</td>
        <td colspan="2" align="right"><?php echo number_format($labarugi); ?></td>

    </tr>

</table>
