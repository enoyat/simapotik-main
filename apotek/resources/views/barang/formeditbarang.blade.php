@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit barang</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
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
                        <form action="{{ route('barang.update',$barang->kdbarang) }}" method="POST" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label>Kode</label>
                                                <input type="text" class="form-control" id="kdbarang" name="kdbarang"
                                                    placeholder="kode barang" value="{{ $barang->kdbarang }}" required="">
                                                <small>Minimal 5 Karakter</small>
                                            </div>
                                            <div class="form-group">
                                                <label>Barcode</label>
                                                <input type="text" class="form-control" id="barcode" name="barcode"
                                                    placeholder="barcode" value="{{ $barang->barcode }}" required="">

                                            </div>
                                            <div class="form-group">
                                                <label>Nama Produk</label>
                                                <input type="text" class="form-control" id="namabarang" name="namabarang"
                                                    placeholder="Nama barang" value="{{ $barang->namabarang }}" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis </label>
                                                <select name="idjenis" id="idjenis" class="form-control">
                                                    <option value="" disabled> == Jenis ==</option>
                                                    @foreach ($jenis as $key => $value)
                                                        <option value="{{ $value->idjenis }}"
                                                            @if ($value->idjenis == $barang->idjenis) selected @endif>
                                                            {{ $value->namajenis }}

                                                           </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="form-group">
                                                <label>Golongan</label>
                                                <select name="idgolongan" id="idgolongan" class="form-control">
                                                    <option value="" disabled> == Golongan ==</option>
                                                    @foreach ($golongan as $key => $value)
                                                        <option value="{{ $value->idgolongan }}"
                                                            @if ($value->idgolongan == $barang->idgolongan) selected @endif>
                                                            {{ $value->namagolongan }}

                                                           </option>
                                                    @endforeach
                                                </select>


                                            </div>
                                            <div class="form-group">
                                                <label>Satuan</label>
                                                <input type="text" class="form-control" id="satuan"
                                                    name="satuan" placeholder="satuan"
                                                    value="{{ $barang->satuan }}">

                                            </div>
                                            <div class="form-group">
                                                <label>Stok Minimum</label>
                                                <input type="text" class="form-control" id="minstok" name="minstok"
                                                    placeholder="min stok" value="{{ $barang->minstok }}" required="">

                                            </div>
                                            <div class="form-group">
                                                <label for="">Supplier</label>
                                                <select name="idsupplier" id="idsupplier" class="form-control"
                                                    required="required">

                                                    <option value="" disabled> == Supplier ==</option>
                                                    @foreach ($supplier as $key => $value)
                                                        <option value="{{ $value->idsupplier }}"
                                                            @if ($value->idsupplier == $barang->idsupplier) selected @endif>
                                                            {{ $value->namasupplier }}

                                                           </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">BHP</label>
                                                <select name="bhp" id="bhp" class="form-control"
                                                    required="required">
                                                    <option value="" disabled> == BHP ==</option>
                                                    <option value="BHP"
                                                            @if ($barang->bhp == "BHP") selected @endif>
                                                           BHP</option>
                                                           <option value="NON BHP"
                                                            @if ($barang->bhp == "NON BHP") selected @endif>
                                                           NON BHP</option>



                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Etalase Kategori</label>
                                                <select name="kdkategori" id="kdkategori" class="form-control"
                                                    required="required">
                                                    <option value="" disabled> == Supplier ==</option>
                                                    @foreach ($kategori as $key => $value)
                                                        <option value="{{ $value->kdkategori }}"
                                                            @if ($value->kdkategori == $barang->kdkategori) selected @endif>
                                                            {{ $value->namakategori }}

                                                           </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="form-group">

                                                <label for="">Aktif</label>
                                                <select name="f_status" id="f_status" class="form-control"
                                                    required="required">
                                                    <option value="" disabled> == Aktif ==</option>
                                                    <option value="AKTIF"

                                                    @if ($barang->f_status == "AKTIF") selected @endif>
                                                    AKTIF</option>
                                                    <option value="NON AKTIF"
                                                     @if ($barang->f_status == "NON AKTIF") selected @endif>
                                                    NON AKTIF</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="panel panel-info">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label>HNA</label>
                                                <input type="text" class="form-control" id="hna" name="hna"
                                                    placeholder="HNA" value="{{ $barang->hna }}" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Diskon</label>
                                                <input type="text" class="form-control" id="diskon" name="diskon"
                                                    placeholder="diskon %" value="{{ $barang->diskon }}" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>PPN</label>
                                                <input type="text" class="form-control" id="ppn" name="ppn"
                                                    placeholder="PPN %" value="{{ $barang->ppn }}" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Harga Beli</label>
                                                <input type="text" class="form-control" id="hargabeli"
                                                    name="hargabeli" placeholder="hargabeli"
                                                    value="{{ $barang->hargabeli }}" required="">
                                                <div
                                                    style="border-block-color: red; color: red; border: 1px solid; padding: 5px">
                                                    <p>HNA+PPN : <input type="text" id="hna_ppn" name="hna_ppn"
                                                            value="{{ $barang->hna_ppn }}" readonly
                                                            style="text-align: right">

                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Harga Resep</label>
                                                <div
                                                    style="border-block-color: red; color: red; border: 1px solid; padding: 5px">
                                                    <p>MARGIN (%):
                                                        <input type="text" id="marginresep" name="marginresep"
                                                            value="{{ $barang->marginresep }}" placeholder="%"
                                                            size="4">
                                                    </p>
                                                </div>
                                                <input type="text" class="form-control" id="hargaresep"
                                                    name="hargaresep" placeholder="hargaresep"
                                                    value="{{ $barang->hargaresep }}" required="">



                                            </div>
                                            <div class="form-group">
                                                <label>Harga Grosir</label>
                                                <input type="text" class="form-control" id="hargagrosir"
                                                    name="hargagrosir" placeholder="hargagrosir"
                                                    value="{{ $barang->hargagrosir }}" required="">

                                            </div>
                                            <div class="form-group">
                                                <label>Harga HV</label>
                                                <div
                                                    style="border-block-color: red; color: red; border: 1px solid; padding: 5px">
                                                    <p>MARGIN (%):
                                                        <input type="text" id="marginhv" name="marginhv"
                                                            value="{{ $barang->marginhv }}" placeholder="%"
                                                            size="4">
                                                    </p>
                                                </div>
                                                <input type="text" class="form-control" id="hargahv" name="hargahv"
                                                    placeholder="hargahv" value="{{ $barang->hargahv }}" required="">

                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div style="float: right;">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('barang.index') }}">
                                    <div class="btn btn-primary">Kembali</div>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <br>
    </div>

    @push('custom-scripts-body')
        <script>
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function() {
                function hitung() {
                    var hna = parseFloat($("#hna").val());
                    var ppn = parseFloat($("#ppn").val());
                    var diskon = parseFloat($("#diskon").val());
                    var hargadiskon= (hna * diskon) / 100;
                    var hargaafterdiskon=hna-hargadiskon;
                    var hargappn=(hargaafterdiskon * ppn / 100)
                   
                    var hargabeli = hargaafterdiskon + hargappn;
                    $("#hargabeli").val(hargabeli.toFixed(2));

                    $("#hna_ppn").val(hargabeli.toFixed(2));
                    $("#margin").val(margin);
                };

                $("#hna").keyup(function() {
                    hitung();
                });
                $("#ppn").keyup(function() {
                    hitung();
                });
                $("#diskon").keyup(function() {
                    hitung();
                });
                $("#marginresep").keyup(function() {
                    var hna_ppn = parseFloat($("#hna_ppn").val());
                    var marginresep = parseFloat($("#marginresep").val());
                    var hargaresep = hna_ppn + (hna_ppn * marginresep / 100);
                    $("#hargaresep").val(hargaresep);
                });
                $("#marginhv").keyup(function() {
                    var hna_ppn = parseFloat($("#hna_ppn").val());
                    var marginhv = parseFloat($("#marginhv").val());
                    var hargahv = hna_ppn + (hna_ppn * marginhv / 100);
                    $("#hargahv").val(hargahv);
                });

                // getPti
                $("#idjenis").select2({
                    placeholder: 'Pilih Jenis barang',
                    ajax: {
                        url: "{{ route('barang.getjenis') }}",
                        type: "GET",
                        dataType: 'JSON',
                        delay: 250,
                        data: function(params) {
                            return {
                                _token: CSRF_TOKEN,
                                search: params.term,
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                });
                $("#idgolongan").select2({
                    placeholder: 'Pilih Golongan barang',
                    ajax: {
                        url: "{{ route('barang.getgolongan') }}",
                        type: "GET",
                        dataType: 'JSON',
                        delay: 250,
                        data: function(params) {
                            return {
                                _token: CSRF_TOKEN,
                                search: params.term,
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                });

            });
        </script>
    @endpush
@endsection
