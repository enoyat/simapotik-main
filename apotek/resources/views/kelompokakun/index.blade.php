@extends('official/dashboard')

@section('content')
<div class="container">
<legend>Kelompok Akun Laporan</legend>
<div class="row">
	@if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
        
     @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada kesalahan data, silahkan dicek kembali<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="form-group">
					<label >Kelompok Akun</label>
					 <select name="kdkelakun" id="kdkelakun" class="form-control">
                                    <option value="">== Pilih Kelompok Akun Laporan ==</option>
                                    @foreach ($mkelakuns as $kdkelakun => $nmkelakun )
                                        <option value="{{ $kdkelakun }}">{{ $nmkelakun }}</option>
                                    @endforeach
                     </select>

					
				</div>	
			<div class="form-group">	
				<label >Pilihan Akun*</label><br>
					<div name="kdakun" id="kdakun" cols="50"></dov> 
						
					</ul>
			</div>
	</div>
</div>
</div>
<script type="text/javascript">


            $('#kdkelakun').change(function(){ 
            	$('#kdakun').html('');
                var id=$(this).val();
                $.ajax({
                    url : "{{ route('DataCombo.comboakun') }}",
                    data : {id: id},
                    dataType : 'json',
                    success: function(data){
                         var html = '';
                         html="<a class='btn btn-xs btn-info' href='/kelompokakun/tambah/"+id+"'>Tambah Akun</a>";
                        html += '<ul>'; 
                        var i;
                        for(i=0; i<data.length; i++){
                            html += "<li>"+data[i].kdakun+"-"+data[i].namaakun+" <a href='/kelompokakun/hapus/"+data[i].kdtrkelakun+"'>Hapus</a></li>";
                        }
                        $('#kdakun').html(html+'</ul>');
                    }
                });
                return false;
            });
 
</script>
@endsection