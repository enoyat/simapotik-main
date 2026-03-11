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
                        <a href="{{ route('laporantransaksi.rptstok') }}">
                            <div id="viewData" class="btn btn-info">Refresh</div></a>

                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari Produk" />
                    </div>
                    <div style="display: inline;  float:right; width:300px">
                        <form action="{{ route('laporantransaksi.laporanstok') }}" method="POST" target="_blank">
                            @csrf
                                        <button type="submit" class="btn btn-primary"
                                            onclick="return confirm('Cetak Laporan Ini ?')">Cetak Stok</button>
                        </form>
                    </div>

                </div>

            </div>
            <br>
            <div class="row">
                <div class="col-12">

                    <div id="databarang">
                        @include('laporantransaksi.fetch')

                    </div>

                </div>
            </div>
    </section>
</div>
<script>
function getdatastok(namabarang) {
    $.ajax({

        url: "{{ route('laporantransaksi.fetch') }}",
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