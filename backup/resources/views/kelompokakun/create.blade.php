@extends('official/dashboard')

@section('content')
<div class="container">

    <div class="row mt-5 mb-5">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Create Akun Laporan</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-secondary" href="{{ route('kelompokakuns.index') }}"> Back</a>
            </div>
        </div>
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

    <form action="{{ route('kelompokakuns.store') }}" method="POST">
        @csrf
        @method('POST')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kelompok Laporan:</strong>
                    <input type="text" name="kdkelakun" value="{{ $kdkelakun }}" class="form-control" readonly="">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Akun :</strong>
                     <select name="kdakun" id="kdakun" class="form-control">
                                    <option value="">== Akun Debet ==</option>
                                    @foreach ($msakuns as $msakun)
                                        <option value="{{ $msakun->kdakun }}">{{ $msakun->namaakun }}</option>
                                    @endforeach
                     </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>

    </form>
</div>
@endsection
