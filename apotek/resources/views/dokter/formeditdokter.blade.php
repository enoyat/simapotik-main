@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>dokter</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                    @foreach ($datadokter as $key)
                        @php
                            $iddokter = $key->iddokter;
                            $namadokter = $key->namadokter;
                        @endphp
                    @endforeach
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Whoops!</strong> Ada kesalahan data, silahkan dicek
                                            kembali<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form action="{{ route('dokter.update') }}" method="POST" role="form"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Kode</label>
                                            <input type="text" class="form-control" id="iddokter" name="iddokter"
                                                placeholder="kode dokter" value="<?php echo $iddokter; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama dokter</label>
                                            <input type="text" class="form-control" id="namadokter" name="namadokter"
                                                placeholder="Nama dokter" value="<?php echo $namadokter; ?>" required="">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('dokter.index') }}">
                                            <div class="btn btn-primary">Kembali</div>
                                        </a>

                                    </form>
                                    <br>

                                </div>

                            </div>
                        </div>
                    </div>

        </section>
    </div>
@endsection
