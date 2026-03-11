@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                    @foreach ($datacustomer as $key)
                        @php
                            $idcustomer = $key->idcustomer;
                            $namacustomer = $key->namacustomer;
                            $kategori = $key->kategori;
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
                                    <form action="{{ route('customer.update') }}" method="POST" role="form"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Kode</label>
                                            <input type="text" class="form-control" id="idcustomer" name="idcustomer"
                                                placeholder="kode customer" value="<?php echo $idcustomer; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama customer</label>
                                            <input type="text" class="form-control" id="namacustomer" name="namacustomer"
                                                placeholder="Nama customer" value="<?php echo $namacustomer; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                                <label>Kategori customer</label>
                                                <select class="form-control" name="kategori" id="kategori">
                                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                                    <option value="umum">umum</option>
                                                    <option value="khusus">khusus</option>
                                                </select>
                                            </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('customer.index') }}">
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
