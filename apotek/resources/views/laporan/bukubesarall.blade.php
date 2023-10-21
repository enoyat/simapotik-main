
<table width="700" border="0" cellpadding="0" cellspacing="0" >
	<tr>
		<td align="center" ><div style="font-size: 24px;"><b>BUKU BESAR</b></div></td>
	</tr>
  	<tr>
		<td align="center">PERIODE <?php echo $namabulan." ".$tahun ; ?></td>
	</tr>
</table>


	@php 
		$totdebet=0;
		$totkredit=0;
		
		$no = 1; 

	@endphp
		@foreach ($msakuns as $i) 
			@php
				$totdebet=0;
				$totkredit=0;
		
				$kdakun=$i->kdakun;
				$typeakun=$i->typeakun;
				$listjurnal =App\Models\M_lapjurnal::whereMonth('tgltrans', $bulan)
                                ->whereYear('tgltrans',$tahun)
                                ->where('kdakun',$kdakun)
                                ->get();
				@endphp
				</table>
				<br><br>
				<legend>Akun: {{  $i->kdakun }} - {{  $i->namaakun }}	</legend>			
				<table width="700" height="21" border="1"  cellspacing="0" bordercolor="#000000" class="grid" style="font-size: 11px">
				<tr bgcolor="#CCCCCC">
				<th width="39" height="30">No.</th>
				<th width="80" ><p>Tanggal</p></th>
				<th width="200" ><p>Keterangan</p></th>
				<th width="82"><p>Debet</p></p></th>
				<th width="73"><p>Kredit</p></th>
				</tr>

				<?php $idx=0; ?>
				@foreach ($listjurnal as $j) 
						@php
						if(($idx%30)==1){
							if($idx > 1){
								echo "<div class=\"pagebreak\"> </div>";
							}
						}	
						@endphp					
						<tr >
						<td align=center>{{ $idx }}</td>
						<td align=center>{{ $j->tgltrans }}</td>
						<td>{{ $j->keterangan }}</td>
						<td align=right>{{ number_format($j->debet) }}</td>
						<td align=right>{{ number_format($j->kredit) }}</td>
						</tr>
						@php
							$idx++;
							$totdebet=$totdebet+$j->debet;
							$totkredit=$totkredit+$j->kredit;
						@endphp
				@endforeach
			    <tr>	
			        <th colspan="3"><p>Total</p></th>
			        <th width="48">{{ number_format($totdebet) }}</th>
			        <th width="48">{{ number_format($totkredit) }}</th>
			    </tr>
			    <tr>	
			        <th colspan="3"><p>Saldo</p></th>
			        <th width="48"></th>
			        <th width="48">
			        	<?php
			        	if ($typeakun=='D'){
			        		$saldo=$totdebet-$totkredit;
			        	} 
			        	else if ($typeakun=='K'){
			        		$saldo=$totkredit-$totdebet;
			        	} 
			        	?>
			        	{{ number_format($saldo) }}
			        </th>
			    </tr>				
			@php $no++; @endphp
			@endforeach

	</tbody>
</table>