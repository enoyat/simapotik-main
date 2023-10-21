@extends('official/dashboard')

@section('content')
<div class="container">

	<legend>Informasi Pembayaran Mahasiswa</h4></legend>	
	<br>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a href="{{ route('officialpeserta') }}"><div class="btn btn-primary">Kembali</div></a>	

		</div>

	</div>
				<br>		
	<div class="row">	
		<div class="col-md-12 col-lg-12">
			<table class="table table-bordered table-hover" id="example" style="font-size: 12px;">
				<thead>
					<tr class="active">					
						<th width="1%">No</th>					
						<th>No. Pembayaran</th>					
						<th>No. Pendaftaran </th>
						<th>No. Tagihan </th>
						<th>Nama</th>
						<th>Tanggal </th>					
						<th>Keterangan</th>
						<th>Jumlah</th>

					</tr>
				</thead>
				<tbody>
				<?php $no = 1; ?>
				@foreach ($pembayaran as $row)
					<tr>
						<td>{{ $no++ }}</td>					
						<td>{{  $row->nobayar }}</td>
						<td>{{  $row->tagihan }}</td>						
						<td>{{  $row->kdregister }}</td>
						<td>{{ $row->get_registrasi->namalengkap }} </td>
						<td>{{  $row->tgltrans }}</td>
						<td>{{  $row->keterangan }}</td>
						<td align="right">{{  number_format($row->jumlah,0) }}</td>
					</tr>
				@endforeach		
				</tbody>
			</table>			
		</div>	
	</div>
</div>
@endsection
