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
                <div class="col-5">
                <div style="display: inline;  float:left; width:300px">
                        <a href="{{ route('barang.index') }}">
                            <div id="viewData" class="btn btn-info">Daftar Produk</div>
                        </a>
                        <a href="{{ route('barang.create') }}">
                            <div id="viewData" class="btn btn-info">Tambah Produk</div>
                        </a>
                    </div>
                    <div style="display: inline;  float:right; width:300px">
                        
                        <input type="text" name="search" id="search" class="form-control"
                            placeholder="Cari Produk" />
                    </div>
                </div>

            </div>
            <br>
            <div class="row">
                <div class="col-12">

                    <div id="databarang">
                        @include('barang.fetch')

                    </div>

                </div>
            </div>
    </section>
</div>
<script>
function getdatastok(namabarang) {
    $.ajax({

        url: "{{ route('barang.fetch') }}",
        method: "GET",
        data: {
            namabarang: namabarang
        },
        success: function(data) {
            $('#databarang').html(data);
        }
    });
};
$('#search').change(function() {
    var namabarang = $('#search').val();
    getdatastok(namabarang);
});
</script>
@endsection