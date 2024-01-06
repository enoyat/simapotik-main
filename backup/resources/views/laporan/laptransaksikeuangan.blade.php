<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" colspan="3">
            <h2>TRANSAKSI KEUANGAN </h2></strong></p>
        </td>
    </tr>
    <tr>
        <td width="100">PERIODE</td>
        <td width="11">:</td>
        <td width="589"><?php echo $tglmulai . " - " . $tglakhir; ?></td>
    </tr>
</table>

<table width="700" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 11px">
    <tr bgcolor="#CCCCCC">
        <th width="39" height="30">No.</th>
        <th width="80">
            <p>No.Transaksi</p>
        </th>
        <th width="80">
            <p>Tanggal</p>
        </th>
        <th width="200">
            <p>Keterangan</p>
        </th>
        <th width="82">
            <p>Debet</p>
            </p>
        </th>
        <th width="73">
            <p>Kredit</p>
        </th>
        <th width="73">
            <p>Jumlah</p>
        </th>

    </tr>

    <?php

$totdebet = 0;
$totkredit = 0;
$i = 1;
foreach ($jurnalumum as $data) {
    # code...

    //... batas halaman
    if (($i % 30) == 1) {
        if ($i > 1) {
            echo "<div class=\"pagebreak\"> </div>";
        }
    }
    //....... body detail
    echo "<tr >";
    echo "<td height='20' align=center>$i</td>";
    echo "<td align=center>" . $data->notrans . "</td>";
    echo "<td align=center>" . $data->tgltrans . "</td>";
    echo "<td>" . $data->keterangan . "</td>";
    echo "<td align=right>" . $data->debet . "</td>";
    echo "<td align=right>" . $data->kredit . "</td>";
    echo "<td align=right>" . number_format($data->jumlah) . "</td>";

    echo "</tr>";
    $i++;
    $totdebet = $totdebet + $data->debet;
    $totkredit = $totkredit + $data->kredit;

    //... loop
}
?>

</table>