@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Transaksi</h1>
                    <a class="btn btn-secondary" href="{{ route('mstransaksis.index') }}"> Back</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

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

                    <form action="{{ route('subtransaksis.store') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Master Transaksi:</strong>
                                    <input type="text" name="kdtransaksi" value="{{ $kdtransaksi }}"
                                        class="form-control" readonly="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Nama Transaksi:</strong>
                                    <input type="text" name="namasubtransaksi" value="" class="form-control"
                                        placeholder="Title">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Akun Debet:</strong>
                                    <select name="kdakun_d" id="kdakun_d" class="form-control">
                                        <option value="">== Akun Debet ==</option>
                                        @foreach ($msakuns as $msakun)
                                        <option value="{{ $msakun->kdakun }}">{{ $msakun->namaakun }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Akun Kredit:</strong>
                                    <select name="kdakun_k" id="kdakun_k" class="form-control">
                                        <option value="">== Akun Kredit ==</option>
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
            </div>
        </div>
    </section>
</div>
@endsection