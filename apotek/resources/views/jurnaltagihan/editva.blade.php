@extends('official.dashboard')
  
@section('content')
   
<div class="container mt-5">
   
    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-header">
            Edit Tagihan VA
            </div>
            <div class="card-body">
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
            <form method="post" action="{{ route('jurnaltagihan.update', $tagihan->notagihan) }}" id="myForm">
            @csrf
            @method('PUT')
                <div class="form-group">
                    <label for="name">No.Tagihan</label>                    
                    <input type="text" name="name" class="form-control" id="name" value="{{ $tagihan->notagihan }}" aria-describedby="name" >                
                </div>
                <div class="form-group">
                    <label for="email">no. VA</label>                    
                    <input type="text" name="email" class="form-control" id="email" value="{{ $tagihan->nova }}" aria-describedby="email" >                
                </div>
                <div class="form-group">
                    <label for="email">Keterangan</label>                    
                    <input type="text" name="email" class="form-control" id="email" value="{{ $tagihan->keterangan }}" aria-describedby="email" >                
                </div>                <div class="form-group">
                    <label for="email">Jumlah</label>                    
                    <input type="text" name="email" class="form-control" id="email" value="{{ $tagihan->jumlah }}" aria-describedby="email" >                
                </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection