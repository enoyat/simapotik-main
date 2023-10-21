@extends('official.dashboard')
  
@section('content')
   
<div class="container mt-12">
   
    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 50rem;">
            <div class="card-header">
            Data Informasi VA
            </div>
            <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
                  <div class="alert alert-success">
                    <p>{{ $success }} </p>
                    </div>      
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach($tagihan as $row)
                <div class="form-group">
                    <label for="name">No.Tagihan</label>                    
                    <input type="text" name="notagihan" class="form-control" id="name" value="{{ $row->notagihan }}" aria-describedby="name" >                
                </div>
                <div class="form-group">
                    <label for="email">no. VA</label>                    
                    <input type="text" name="nova" class="form-control" id="nova" value="{{ $row->nova }}" aria-describedby="email" >                
                </div>
                <div class="form-group">
                    <label for="email">Keterangan</label>                    
                    <input type="text" name="keterangan" class="form-control" id="email" value="{{ $row->keterangan }}" aria-describedby="email" >                
                </div>                <div class="form-group">
                    <label for="email">Jumlah</label>                    
                    <input type="text" name="jumlah" class="form-control" id="email" value="{{ $row->jumlah }}" aria-describedby="email" >                
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection