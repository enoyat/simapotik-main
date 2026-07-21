@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>STOK OPNAME</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="container">

                            <br>
                            <br>
                            <label>Lokasi : </label>
                            <select name="idlokasi" id="idlokasi" class="form-control col-3">
                                <option value="">== Pilih Lokasi ==</option>
                                @foreach ($lokasi as $row)
                                    <option value="{{ $row->idlokasi }}">{{ $row->namalokasi }}</option>
                                @endforeach
                            </select>

                            <label>Etalase : </label>
                            <select name="kdkategori" id="kdkategori" class="form-control col-3">
                                <option value="">== Pilih Etalase ==</option>
                                @foreach ($kategori as $row)
                                    <option value="{{ $row->kdkategori }}">{{ $row->namakategori }}</option>
                                @endforeach
                            </select>

                            @csrf
                            <br>
                            <div id="loading" class="text-center p-5" style="display:none;">
                                <div class="spinner-border text-primary" role="status" style="width:4rem;height:4rem;">
                                </div>

                                <h5 class="mt-3">
                                    Sedang memproses data stok opname...
                                </h5>

                                <small>Mohon tunggu beberapa saat.</small>
                            </div>

                            <div id="datastok"></div>
                            <div id="datastok"></div>

                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        function getdatastok(idlokasi, idjenis, kdkategori) {

            $.ajax({
                url: "{{ route('stokopname.fetch') }}",
                method: "GET",
                data: {
                    kdkategori: kdkategori,
                    idjenis: idjenis,
                    idlokasi: idlokasi
                },

                beforeSend: function() {
                    $('#loading').show();
                    $('#datastok').hide();
                },

                success: function(data) {
                    $('#datastok').html(data);
                },

                complete: function() {
                    $('#loading').hide();
                    $('#datastok').show();
                },

                error: function() {
                    $('#loading').hide();
                    $('#datastok').show();
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        }
        $('#idlokasi, #kdkategori').change(function() {

            var idlokasi = $('#idlokasi').val();
            var idjenis = $('#idjenis').val();
            var kdkategori = $('#kdkategori').val();

            if (idlokasi != '' && kdkategori != '') {
                getdatastok(idlokasi, idjenis, kdkategori);
            }
        });
    </script>
@endsection
