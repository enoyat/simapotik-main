<table width="700" border="0" cellpadding="0" cellspacing="0" style="font-size: 12px">
    <tr>
        <td align="center" colspan="3">
            <h2>Laporan Rekap Penjualan </h2></strong></p>
        </td>
    </tr>
    <tr>
        <td width="100">PERIODE</td>
        <td width="11">:</td>
        <td width="589">{{ date_format(date_create($tglmulai), 'd-m-Y') }} -
            {{ date_format(date_create($tglakhir), 'd-m-Y') }}
        </td>
    </tr>
</table>
<table width="700" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 12px">
    <tr bgcolor="#CCCCCC">
        <th width="20" height="30">No.</th>
        <th width="20" >
            <p>Kode</p>
        </th>
        <th width="40">
            <p>Golongan</p>
        </th>
        <th width="50">
            <p>HV</p>
        </th>
        <th width="50">
            <p>Resep</p>
        </th>
        <th width="50">
            <p>Retur</p>
        </th>
        <th width="50">
            <p>Jumlah</p>
        </th>


    </tr>

    <?php

    $total=0;
    $totalhv=0;
    $totalresep=0;
    $totalretur=0;
    $i=1;
    foreach ($datapenjualan as $data) {
        # code...
        //... batas halaman
        if(($i%30)==1){
            if($i > 1){
                echo '<div class=\"pagebreak\"> </div>';
            };
        };
        ?>

    <tr>
        <td align=center valign=top>{{ $i }}</td>
        <td align=center valign=top>{{ $data["idgolongan"] }}</td>
        <td valign=top>{{ $data["namagolongan"] }}</td>
        <td valign=top align=right>{{ number_format($data["jumlah"]) }}</td>
        <td valign=top align=right>{{ number_format($data["jumlahresep"]) }}</td>
        <td valign=top align=right>{{ number_format($data["jumlahretur"]) }}</td>
        <td valign=top align=right>{{ number_format(($data["jumlah"]+$data["jumlahresep"])-$data["jumlahretur"]) }}</td>

    </tr>
    <?php
        $totalhv=$totalhv+$data["jumlah"];
        $totalresep=$totalresep+$data["jumlahresep"];
        $totalretur=$totalretur+$data["jumlahretur"];
        $total=$total+(($data["jumlah"]+$data["jumlahresep"])-$data["jumlahretur"]);

        $i++;


        //... loop
        }
        ?>
    <tr>
        <td colspan="3" align="right"></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalhv); ?></b></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalresep); ?></b></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($totalretur); ?></b></td>
        <td align="right" style="font-size: 13px;"><b><?php echo number_format($total); ?></b></td>

    </tr>
</table>
