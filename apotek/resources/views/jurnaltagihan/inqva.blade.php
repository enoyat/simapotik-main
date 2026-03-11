@extends('official/dashboard')

@section('content')
<div class="container">
<legend>Inquery VA</legend>
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
		<form action="{{ route('jurnaltagihan.getinqva') }}" method="post" >
			@csrf
			<div class="form-group">
				<label class="control-label col-md-3">No. VA </label>				
				<div class="col-md-6">
					<input type="text" name="nova" id="inputnova" class="form-control" value="" required="required" title="">
					<br>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-9 col-sm-offset-3">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> Proses</button>

				</div>
			</div>
		</form>
	</div>
</div>
</div>
<br>
@endsection