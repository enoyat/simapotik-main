@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>MASTER AYAT JURNAL TRANSAKSI</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container">

        <div class="row mt-5 mb-5">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <h2>Edit Ayat Jurnal Transaksi</h2>
                </div>
                <div class="float-right">
                    <a class="btn btn-secondary" href="{{ route('mstransaksis.index') }}"> Back</a>
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

        <form action="{{ route('mstransaksis.update',$mstransaksis->kdtransaksi) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Kd Transaksi:</strong>
                        <input type="text" name="kdtransaksi" value="{{ $mstransaksis->kdtransaksi }}"
                            class="form-control" placeholder="Title" readonly="">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Transaksi:</strong>
                        <input type="text" name="namatransaksi" value="{{ $mstransaksis->namatransaksi }}"
                            class="form-control" placeholder="Title">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Akun Debet:</strong>
                        <select name="kdakun_d" id="kdakun_d" class="form-control">
                            <option value="{{ $mstransaksis->kdakun_d }}">{{ $mstransaksis->get_akundebet->namaakun }}
                            </option>
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
                            <option value="{{ $mstransaksis->kdakun_k }}">{{ $mstransaksis->get_akunkredit->namaakun }}
                            </option>
                            <option value="">== Akun Kredit ==</option>
                            @foreach ($msakuns as $msakun)
                            <option value="{{ $msakun->kdakun }}">{{ $msakun->namaakun }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Kategori Transaksi:</strong>
                        <select name="kdktgtransaksi" id="kdktgtransaksi" class="form-control">
                            <option value="{{ $mstransaksis->kdktgtransaksi }}">
                                {{ $mstransaksis->get_ktgtransaksi->namaktgtransaksi }} </option>
                            <option value="">== Kategori Transaksi ==</option>
                            @foreach ($ktgtransaksis as $ktgtransaksi)
                            <option value="{{ $ktgtransaksi->kdktgtransaksi }}">{{ $ktgtransaksi->namaktgtransaksi }}
                            </option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection