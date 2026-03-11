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

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                @php
                                    foreach ($databarang as $key) {
                                        $kdbarang = $key->kdbarang;
                                        $namabarang = $key->namabarang;
                                        $deskripsi = $key->deskripsi;
                                        $hargabeli = $key->hargabeli;
                                        $hargajual = $key->hargajual;
                                        $berat = $key->berat;
                                        $fotolama = $key->foto;
                                        $kdkategori = $key->kdkategori;
                                        $namakategori = $key->get_kategori->namakategori;
                                    }
                                @endphp

                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
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
                                                <form action="{{ route('barang.update') }}" method="POST" role="form"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Kode produk</label>
                                                        <input type="text" class="form-control" id="kdbarang"
                                                            name="kdbarang" placeholder="kode produk"
                                                            value="<?php echo $kdbarang; ?>" required="" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama produk</label>
                                                        <input type="text" class="form-control" id="namabarang"
                                                            name="namabarang" placeholder="Nama barang"
                                                            value="<?php echo $namabarang; ?>" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>deskripsi</label>
                                                        <textarea name="deskripsi" required="" class="form-control" rows="10"><?php echo $deskripsi; ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Harga Beli</label>
                                                        <input type="text" class="form-control" id="hargabeli"
                                                            name="hargabeli" placeholder="Harga" value="<?php echo $hargabeli; ?>"
                                                            required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Harga Jual</label>
                                                        <input type="text" class="form-control" id="hargajual"
                                                            name="hargajual" placeholder="Harga" value="<?php echo $hargajual; ?>"
                                                            required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Berat (gram)</label>
                                                        <input type="text" class="form-control" id="berat"
                                                            name="berat" placeholder="Berat" value="<?php echo $berat; ?>"
                                                            required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Kategori</label>
                                                        <select name="kdkategori" id="kdkategori" class="form-control"
                                                            required="required">
                                                            <option value="<?php echo $kdkategori; ?>"><?php echo $namakategori; ?></option>

                                                            @foreach ($kategori as $ktg)
                                                                <option value="<?php echo $ktg->kdkategori; ?>"><?php echo $ktg->namakategori; ?>
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Foto Utama</label>
                                                        <input type="file" name="filefoto">
                                                        <input type="hidden" name="fotolama" value="<?php echo $fotolama; ?>"
                                                            placeholder="">
                                                        <img src="{{ asset('assets/inventory/' . $fotolama) }}"
                                                            class="img-responsive">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <a href="{{ route('barang.index') }}">
                                                        <div class="btn btn-primary">Kembali</div>
                                                    </a>

                                                </form>
                                                <br>
                                                <div class="form-group">
                                                    <label>Foto Gallery Produk</label><br>
                                                    @foreach ($key->get_foto as $key2)
                                                        <div class="img-thumbnail img-fluid"
                                                            style="width: 75px; text-align: center">
                                                            <img src="{{ asset('assets/inventory/' . $key2->foto) }}"
                                                                class="img-fluid">
                                                            <a
                                                                href="{{ route('barang.hapusgallery', $key2->kdfoto) }}">Hapus</a>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <form action="{{ route('barang.uploadgallery') }}" method="POST"
                                                    role="form" enctype="multipart/form-data">
                                                    @csrf
                                                    <br>
                                                    <input type="hidden" class="form-control" id="kdbarang"
                                                        name="kdbarang" placeholder="kode produk"
                                                        value="<?php echo $kdbarang; ?>" required="">
                                                    <div class="form-group">
                                                        <label>Upload Foto Gallery</label>
                                                        <input type="file" name="filefoto">
                                                        <button type="submit" class="btn btn-primary">Upload</button>
                                                    </div>


                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
