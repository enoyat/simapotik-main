@extends('dashboard')
@section('content')
<legend>Ubah Password</legend>

<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
	<form action="{{ route('ubahpassword') }}" method="POST" role="form"  enctype="multipart/form-data">
			@csrf	
			<div class="form-group">
				<label class="control-label col-md-4">Password Baru</label>				
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<input type="password" name="pbaru" class="form-control" placeholder="Password Baru" id="txtNewPassword" required="">				
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-8 col-sm-offset-4">
			<br>
					<button type="submit" class="btn btn-primary" id="btnsubmit" >Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection