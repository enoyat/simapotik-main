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

            </div>
        </div>
    </div>
</div>
@endsection