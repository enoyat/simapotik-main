@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>jenis Obat</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
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
                                                <strong>Whoops!</strong> Ada kesalahan data, silahkan dicek kembali<br><br>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form action="{{ route('jenis.store') }}" method="POST" role="form"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Kode</label>
                                                <input type="text" class="form-control" id="idjenis" name="idjenis"
                                                    placeholder="kode jenis (otomatis)" value="{{ old('idjenis') }}"
                                                    readonly >
                                            </div>
                                            <div class="form-group">
                                                <label>Nama jenis</label>
                                                <input type="text" class="form-control" id="namajenis"
                                                    name="namajenis" placeholder="Nama jenis"
                                                    value="{{ old('namajenis') }}" required="">
                                            </div>

                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <a href="{{ route('jenis.index') }}">
                                                <div class="btn btn-primary">Kembali</div>
                                            </a>

                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
