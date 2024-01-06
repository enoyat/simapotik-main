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
                    <h2> Show Ayat Jurnal Transaksi</h2>
                </div>
                <div class="float-right">
                    <a class="btn btn-secondary" href="{{ route('mstransaksis.index') }}"> Back</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kd Transaksi:</strong>
                    {{ $mstransaksis->kdtransaksi}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nama Transaksi:</strong>
                    {{ $mstransaksis->namatransaksi }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Akun Debet:</strong>
                    {{ $mstransaksis->kdakun_d }} - {{ $mstransaksis->get_akundebet->namaakun }}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Akun Kredit:</strong>
                    {{ $mstransaksis->kdakun_k }} - {{ $mstransaksis->get_akunkredit->namaakun }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection