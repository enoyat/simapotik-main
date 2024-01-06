<table width="700" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" colspan="3">
            <h2>NERACA SALDO</h2></strong></p>
        </td>
    </tr>
    <tr>
        <td width="100">PERIODE</td>
        <td width="11">:</td>
        <td width="589"><?php echo $namabulan." ".$tahun ; ?></td>
    </tr>
</table>

<table width="700" height="21" border="1" cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 11px">
    <tr bgcolor="#CCCCCC">
        <th width="39" height="30">No.</th>
        <th width="80">
            <p>kdakun</p>
        </th>
        <th width="200">
            <p>Nama Akun</p>
        </th>
        <th width="82">
            <p>Debit</p>
            </p>
        </th>
        <th width="73">
            <p>Kredit</p>
        </th>
    </tr>

    <?php	

$totdebet=0;
$totkredit=0;
$i=1;
foreach ($dataneracas as $data) {
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
	echo "<td align=center>".$data->kdakun."</td>";
	echo "<td>".$data->get_akun->namaakun."</td>";
	echo "<td align=right>";
	if (!empty($data->debet)){
		echo number_format($data->debet);
	}
	echo "</td>";
	echo "<td align=right>";
	if (!empty($data->kredit)){
		echo number_format($data->kredit);
	}
	echo "</tr>";
	$i++;
	$totdebet=$totdebet+$data->debet;
	$totkredit=$totkredit+$data->kredit;
	
	//... loop
}
?>
    <tr>
        <th colspan="3">
            <p>Total</p>
        </th>
        <th width="48"><?php echo number_format($totdebet); ?></th>
        <th width="48"><?php echo number_format($totkredit); ?></th>
    </tr>
</table>