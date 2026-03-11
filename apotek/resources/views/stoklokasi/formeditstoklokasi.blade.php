@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>stoklokasi Obat</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                    @foreach ($datastoklokasi as $key)
                        @php
                            $idlokasi = $key->idlokasi;
                            $namalokasi = $key->namalokasi;
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
                                    <form action="{{ route('stoklokasi.update') }}" method="POST" role="form"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Kode</label>
                                            <input type="text" class="form-control" id="idlokasi" name="idlokasi"
                                                placeholder="kode stoklokasi" value="<?php echo $idlokasi; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama stoklokasi</label>
                                            <input type="text" class="form-control" id="namalokasi" name="namalokasi"
                                                placeholder="Nama stoklokasi" value="<?php echo $namalokasi; ?>" required="">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('stoklokasi.index') }}">
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
