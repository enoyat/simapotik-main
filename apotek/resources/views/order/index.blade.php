@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="col-sm-6">
                <h1>Order Pembelian</h1>
                <a href="{{ route('order.baru') }}" class="btn btn-primary">Buat Order Baru</a>
            </div>
        </div>
    </section>

    <form action="{{ route('order.store') }}" method="POST">
        <input type="hidden" name="kdtransaksi" id="kdtransaksi" value="{{ $kdtransaksi }}">
        @csrf
        <section class="content">
            <div class="container-fluid">

                <div class="shopping-cart section">

                    <div class="container">

                        <div class="row">
                            <div class="col-12">
                                <div class="col-lg-4 col-md-3 mb-3">
                                    <label for="" class="form-label">Supllier</label>
                                    <select class="form-control" name="idsupplier" id="idsupplier" required>
                                    </select>
                                    <small id="helpId" class="form-text text-muted">Supplier</small>
                                </div>
                                <div class="col-lg-4 col-md-3 mb-3">
                                    <label for="" class="form-label">Tanggal Order</label>
                                    <input type="date" class="form-control" name="tgltrans" id="tgltrans"
                                        aria-describedby="helpId" placeholder="" value="{{ date('Y-m-d') }}" required>
                                    <small id="helpId" class="form-text text-muted">Tanggal transaksi
                                        pembelian</small>
                                </div>
                                <div class="col-12 mb-3" style="font-size: 12px">
                                    <a class="btn btn-sm btn-info" data-url="{{ route('order.caribarang') }}"
                                        id="btncari" title="Detail"><i class="fa fa-search-plus"
                                            aria-hidden="true"></i></a>
                                    <input type="text" id="kdbarang" name="kdbarang" value="" size=10 placeholder="Kode"
                                        readonly>
                                    <input type="text" name="namabarang" value="" id="namabarang"
                                        placeholder="Nama Produk" class="bg-dark">
                                    <input type="number" name="qty" value="" id="qty" min=1 max=999 placeholder="qty">
                                    <input type="text" name="harga" value="" id="harga" placeholder="Harga"
                                        style="text-align: right" size="13">
                                    <input style="display:none" type="text" name="subtotal" value="" id="subtotal"
                                        readonly placeholder="SubTotal" class="bg-dark" style="text-align: right"
                                        size="13">
                                    <input style="display:none" type="text" name="diskon" value="" size="15" id="diskon"
                                        style="text-align: right" placeholder="diskon">
                                    <input type="text" name="jumlah" value="" id="jumlah" readonly placeholder="Jumlah"
                                        class="bg-dark" style="text-align: right">
                                    <button type="button" class="btn btn-primary" id="tambah">+</button>
                                </div>
                                <!-- Shopping Summery -->
                                <div id="cart">

                                </div>
                                <!--/ End Shopping Summery -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- Button trigger modal -->
    </form>


</div>
<div id="myModal" class="modal fade modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function() {
    $("#cart").load("{{ route('order.cartview') }}");
    $("#kdbarang").val("");
    $("#kdbarang").focus();
});
$('#btncari').click(function() {
    var url = $(this).data("url");

    $.ajax({
        url: url,
        dataType: 'html',
        success: function(res) {

            // get the ajax response data
            var data = res;

            // update modal content here
            // you may want to format data or
            // update other modal elements here too
            $('.modal-body').html(data);

            // show modal
            $('#myModal').modal('show');

        },
        error: function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
});


$("#qty").change(function() {
    var qty = $("#qty").val();
    var harga = $("#harga").val();
    var diskon = $("#diskon").val();
    var subtotal = qty * harga;
    var jumlah = qty * harga - diskon;
    $("#subtotal").val(subtotal);
    $("#jumlah").val(jumlah);
});
$("#harga").change(function() {
    var qty = $("#qty").val();
    var harga = $("#harga").val();
    var diskon = $("#diskon").val();
    var subtotal = qty * harga;
    var jumlah = qty * harga - diskon;
    $("#subtotal").val(subtotal);
    $("#jumlah").val(jumlah);
});
$("#diskon").keyup(function() {
    var qty = $("#qty").val();
    var harga = $("#harga").val();
    var diskon = $("#diskon").val();
    var subtotal = qty * harga;
    var jumlah = qty * harga - diskon;
    $("#subtotal").val(subtotal);
    $("#jumlah").val(jumlah);
});

$('#tambah').click(function() {
    var qty = $("#qty").val();
    var harga = $("#harga").val();
    var diskon = $("#diskon").val();
    var jumlah = qty * harga - diskon;
    $("#jumlah").val(jumlah);
    $.ajax({
        url: "{{ route('order.cart') }}",
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            "kdbarang": $("#kdbarang").val(),
            "namabarang": $("#namabarang").val(),
            "qty": $("#qty").val(),
            "harga": $("#harga").val(),
            "diskon": $("#diskon").val(),
            "jumlah": $("#jumlah").val(),
        },
        dataType: "text",
        success: function(response) {
            if (response == "sukses") {
                $("#cart").load("{{ route('order.cartview') }}");
                kosong();
                $("#kdbarang").focus();
            } else {
                alert(response);
            }
        }
    });

});

function kosong() {
    $("#kdbarang").val("");
    $("#namabarang").val("");
    $("#qty").val("");
    $("#harga").val("");
    $("#subtotal").val("");
    $("#diskon").val("");
    $("#jumlah").val("");
}
$("#idsupplier").select2({
    placeholder: 'Pilih Supplier',
    ajax: {
        url: "{{ route('supplier.getsupplier') }}",
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
<script>
$(document).ready(function() {
    $('#dataku').DataTable();
});
</script>

<!-- Modal -->
@endsection