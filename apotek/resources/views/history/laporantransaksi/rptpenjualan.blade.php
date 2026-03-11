@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Laporan Penjualan </h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <div class="container">

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
                            <form action="{{ route('laporantransaksi.laporanpenjualan') }}" method="POST" target="_blank">
                                @csrf
                                <div class="form-group">
                                    <label for="">Periode Laporan Mulai</label>
                                    <input type="date" name="tglmulai" id="inputTglmulai" value=""
                                        required="required" title=""> s/d <input type="date" name="tglakhir"
                                        id="inputTglmulai" value="" required="required" title="">

                                </div>
                                <div class="form-group">
                                    <label for="">Tipe Penjualan</label>
                                    <Select name="tipepenjualan" id="tipepenjualan" class="form-control">
                                        <option>-- Tipe Penjualan --</option>
                                        <option value="T">Tunai</option>
                                        <option value="K">Kredit/belum bayar</option>
                                        


                                    </Select>

                                </div>
                                <div class="form-group">
                                    <label for="">Kriteria</label>
                                    <Select name="kriteria" id="kriteria" class="form-control">
                                        <option>-- kriteria --</option>
                                        <option value="nofaktur">Urut No Transaksi Penjualan</option>
                                        <option value="kasir">Kasir</option> 
                                        <option value="golongan">Golongan</option>
                                        <option value="barang">Item Barang</option>
                                        


                                    </Select>

                                </div>
                                <div class="form-group" id="golongan">
                                    <label for="">Golongan </label>
                                    <Select name="idgolongan" id="idgolongan" class="form-control">
                                        <option value="all">Semua</option>
                                        @foreach ($golongan as $itemgolongan)
                                            <option value="{{ $itemgolongan->idgolongan }}">
                                                {{ $itemgolongan->namagolongan }}</option>
                                        @endforeach
                                    </Select>

                                </div>
                                <div class="form-group" id="kasir">
                                    <label for="">Kasir </label>
                                    <select name="email" id="email" class="form-control"></select>

                                </div>
                                <div class="form-group" id="barang">
                                    <label for="">Item Barang </label>
                                    <select name="kdbarang" id="kdbarang" class="form-control"></select>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"
                                        onclick="return confirm('Cetak Laporan Ini ?')">Cetak</button>

                                </div>


                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#email").select2({
            placeholder: 'Pilih email user',
            ajax: {
                url: "{{ route('sesionuser.getuser') }}",
                type: "GET",
                dataType: 'JSON',
                delay: 250,
                data: function(params) {
                    return {
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
        $(document).ready(function() {
            $("#golongan").hide();
            $("#kasir").hide();
            $("#barang").hide();
        });
        $("#kriteria").change(function() {
            var pilihan = $("#kriteria").val();
            if (pilihan == "golongan") {
                $("#golongan").show();
                $("#kasir").hide();
                $("#barang").hide();
            }
            else if (pilihan == "kasir") {
                $("#kasir").show();
                $("#golongan").hide();
                $("#barang").hide();
            }
            else if (pilihan == "barang") {
                $("#kasir").hide();
                $("#golongan").hide();
                $("#barang").show();

            }
            else {
                $("#golongan").hide();
                $("#kasir").hide();
                $("#barang").hide();
            }
        });
        $("#kdbarang").select2({
    placeholder: 'Pilih barang',
    ajax: {
        url: "{{ route('barang.getbarang') }}",
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
    </script>
@endsection
