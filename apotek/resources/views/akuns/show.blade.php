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

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kd Akun:</strong>
                    {{ $akuns->kdakun}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nama Akun:</strong>
                    {{ $akuns->namaakun }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kelompok Akun:</strong>
                    {{ $akuns->get_msakun->namamsakun }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kategori Akun:</strong>
                    {{ $akuns->get_ktgakun->namaktgakun }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Type Saldo Akun:</strong>
                    {{ $akuns->typeakun }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection