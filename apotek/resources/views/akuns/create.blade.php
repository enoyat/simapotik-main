@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>MASTER AKUN</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container">

        <div class="row mt-5 mb-5">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <h2>Create Akun</h2>
                </div>
                <div class="float-right">
                    <a class="btn btn-secondary" href="{{ route('akuns.index') }}"> Back</a>
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

        <form action="{{ route('akuns.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Kd Akun:</strong>
                        <input type="text" name="kdakun" value="" class="form-control" placeholder="Title">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Akun:</strong>
                        <input type="text" name="namaakun" value="" class="form-control" placeholder="Title">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Kelompok Akun:</strong>
                        <select name="kdmsakun" id="kdmsakun" class="form-control">
                            <option value="">== Kelompok Akun ==</option>
                            @foreach ($msakuns as $msakun)
                            <option value="{{ $msakun->kdmsakun }}">{{ $msakun->kdmsakun }} - {{ $msakun->namamsakun }}
                            </option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Kategori Akun:</strong>
                        <select name="kdktgakun" id="kdktgakun" class="form-control">
                            <option value="">== Kategori Akun ==</option>
                            @foreach ($ktgakuns as $ktgakun)
                            <option value="{{ $ktgakun->kdktgakun }}">{{ $ktgakun->kdktgakun }} -
                                {{ $ktgakun->namaktgakun }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Saldo Akun</strong>
                        <select name="typeakun" id="typeakun" class="form-control">
                            <option value="">== Saldo Akun ==</option>
                            <option value="D">Debet</option>
                            <option value="K">Kredit</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Posisi Neraca</strong>
                        <select name='posisi' id="posisi" class="form-control">
                            <option value="">== Posisi ==</option>
                            <option value="L">Kiri</option>
                            <option value="R">Kanan</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tampil Laba Rugi</strong>
                        <select name='f_lr' id="f_lr" class="form-control">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tampil Buku Besar</strong>
                        <select name='f_bb' id="f_bb" class="form-control">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tampil Neraca</strong>
                        <select name='f_neraca' id="f_neraca" class="form-control">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tampil laporan Keuangan</strong>
                        <select name='f_lk' id="f_lk" class="form-control">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Store</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection