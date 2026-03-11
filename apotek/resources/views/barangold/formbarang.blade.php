@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Produk</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-5">
                            <div class="col-md-12 col-lg-6">
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
                                        <form action="{{ route('barang.store') }}" method="POST" role="form"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Kode Produk</label>
                                                <input type="text" class="form-control" id="kdbarang" name="kdbarang"
                                                    placeholder="kode produk" value="{{ old('kdbarang') }}" required="" >
                                                    <small>Minimal 5 Karakter</small>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Produk</label>
                                                <input type="text" class="form-control" id="namabarang" name="namabarang"
                                                    placeholder="Nama produk" value="{{ old('namabarang') }}"
                                                    required="">
                                            </div>
                                            <div class="form-group">
                                                <label>deskripsi</label>
                                                <textarea name="deskripsi" required="" class="form-control" rows="10">{{ old('deskripsi') }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Harga Beli</label>
                                                <input type="text" class="form-control" id="hargabeli" name="hargabeli"
                                                    placeholder="Harga Beli" value="{{ old('hargabeli') }}" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Harga Jual</label>
                                                <input type="text" class="form-control" id="hargajual" name="hargajual"
                                                    placeholder="Harga jual" value="{{ old('hargajual') }}" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Berat (gram)</label>
                                                <input type="text" class="form-control" id="berat" name="berat"
                                                    placeholder="berat" value="{{ old('berat') }}" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Kategori</label>
                                                <select name="kdkategori" id="kdkategori" class="form-control"
                                                    required="required">
                                                    <option value=""></option>
                                                    @foreach ($kategori as $key)
                                                        <option value="<?php echo $key->kdkategori; ?>"><?php echo $key->namakategori; ?></option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Foto Utama</label>
                                                <input type="file" name="filefoto"><br>
                                                <small>Max Ukuran 1MB</small>
                                            </div>


                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <a href="{{ route('barang.index') }}">
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
    </div>
    </section>

@endsection
