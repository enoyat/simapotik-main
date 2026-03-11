@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1>Penjualan Resep</h1>
                    <hr>
                    <a href="{{ route('penjualanresep.baru') }}" class="btn btn-primary">Baru</a>
                </div>
            </div>
        </div>
    </section>

    <form action="{{ route('penjualanresep.store') }}" method="POST">
        <input type="hidden" name="kdtransaksi" id="kdtransaksi" value="{{ $kdtransaksi }}">
        @csrf
        <section class="content">
            <div class="container-fluid">

                <div class="shopping-cart section">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-3">
                                    <label for="" class="form-label">Pasien</label>
                                        <Input type="hidden" name="idcustomer" value="P0001" class="form-control">
                                        <input type="text" class="form-control" name="namapasien" id="namapasien"
                                        aria-describedby="helpId" placeholder="" value="" >

                                    <label for="" class="form-label">No Resep (otomatis)</label>
                                    <input type="text" class="form-control" name="noresep" id="noresep"
                                        aria-describedby="helpId" placeholder="" value="" readonly>

                                    <label for="" class="form-label">Jenis Penjualan</label>
                                    <select class="form-control" name="tipepenjualan" id="tipepenjualan" required>

                                        <option value="T" selected>Tunai</option>
                                        <option value="K">Kredit</option>
                                    </select>
                                    <label for="" class="form-label">Dokter</label>
                                    <select class="form-control" name="iddokter" id="iddokter" required>
                                        <option value="">== Dokter ==</option>
                                        @foreach ($dokters as $dokter)
                                            <option value="{{ $dokter->iddokter }}">{{ $dokter->namadokter }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="idjenispasien" id="idjenispasien" required value="1">
                                    <input type="hidden" name="idpoly" id="idpoly" required value="1">

                            </div>
                            
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-12 mb-3" style="font-size: 12px">
                                <table>
                                    <tr>
                                        <td>Jenis Harga</td>
                                        <td>Cari</td>
                                        </td>
                                        <td>Kode</td>
                                        <td>Nama Produk</td>
                                        <td>Harga</td>
                                        <td>Qty</td>
                                        <td>Disc %</td>
                                        <td>Disc Rp</td>
                                        <td>Total</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="jenisharga" id="jenisharga">
                                                <option value="hargaresep">Harga Resep</option>
                                            </select>
                                        </td>

                                        <td>
                                            <a class="btn btn-sm btn-info"
                                                data-url="{{ route('penjualan.caribarang') }}" id="btncari"
                                                title="Detail"><i class="fa fa-search-plus" aria-hidden="true"></i></a>
                                        </td>
                                        <td>
                                            <input type="text" id="kdbarang" name="kdbarang" value="" size=10
                                                placeholder="Kode" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="namabarang" value="" id="namabarang"
                                                placeholder="Nama Produk" class="bg-dark">
                                        </td>
                                        <td>
                                            <input type="text" name="harga" value="" id="harga" readonly
                                                placeholder="Harga" class="bg-dark" style="text-align: right" size="13">
                                        </td>
                                        <td>
                                            <input type="number" name="qty" value="" id="qty" min=1 max=999
                                                placeholder="qty" class="innilai">
                                        </td>
                                        <td>
                                            <input class="innilai" type="number" name="diskonpersen" id="diskonpersen"
                                                value="0" max="100" style="text-align: right; width: 50px"
                                                class="innilai">
                                        </td>
                                        <td>
                                            <input type="text" name="diskon" value="" size="13" id="diskon"
                                                style="text-align: right" placeholder="diskon" >
                                        </td>
                                        <td>
                                            <input type="text" name="jumlah" value="" id="jumlah" readonly
                                                placeholder="Jumlah" class="bg-dark" style="text-align: right">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" id="tambah">+</button>
                                        </td>

                                    </tr>
                                </table>
                            </div>
                            <!-- Shopping Summery -->
                            </div>
                        <div class="row">
                            <div id="cart" class="col-12 mb-3" >

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
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
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

</div>
<!-- Button trigger modal -->
<script>
    $(function() {
    var keyStop = {
        8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
        13: "input:text, input:password", // stop enter = submit 

        end: null
    };
    $(document).bind("keydown", function(event) {
        var selector = keyStop[event.which];

        if (selector !== undefined && $(event.target).is(selector)) {
            event.preventDefault(); //stop event
        }
        return true;
    });
});
$('#btncari').click(function() {
    var url = $(this).data("url");

    $.ajax({
        url: url,
        dataType: 'html',
        data: {
            _token: CSRF_TOKEN,
            jenisharga: $('#jenisharga').val()
        },
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
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function() {
    $("#cart").load("{{ route('penjualanresep.cartview') }}");
    $("#kdbarang").val("");
    $("#kdbarang").focus();
});

function hitung() {
    var harga = $("#harga").val();
    var qty = $("#qty").val();
    var diskonpersen = $("#diskonpersen").val();
    var diskonamount = $("#diskon").val();
    var diskon = parseInt(harga) * parseInt(qty) * parseInt(diskonpersen) / 100;
    $("#diskon").val(diskon);
    diskonamount = diskon;

    var diskon = parseInt(diskonamount);
    jumlah = parseInt(harga) * parseInt(qty) - parseInt(diskon);
    //  alert(jumlah);
    $("#jumlah").val(Math.ceil(jumlah));
    total();


}
$('#diskon').change(function() {
    var harga = $("#harga").val();
    var qty = $("#qty").val();
    var diskonamount = $("#diskon").val();
    var diskpersen = (parseInt(diskonamount) / (parseInt(harga) * parseInt(qty)) * 100);
    $("#diskonpersen").val(diskpersen);
    hitung();
});
$('.innilai').keyup(function() {
    hitung();
});

$('#tambah').click(function() {
    var qty = $("#qty").val();
    var harga = $("#harga").val();
    var diskon = $("#diskon").val();
    var jumlah = qty * harga - diskon;
    $("#jumlah").val(jumlah);
    $.ajax({
        url: "{{ route('penjualanresep.cart') }}",
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            "kdbarang": $("#kdbarang").val(),
            "namabarang": $("#namabarang").val(),
            "qty": $("#qty").val(),
            "harga": $("#harga").val(),
            "diskonpersen": $("#diskonpersen").val(),
            "diskon": $("#diskon").val(),
            "jumlah": $("#jumlah").val(),
        },
        dataType: "text",
        success: function(response) {
            if (response == "sukses") {
                $("#cart").load("{{ route('penjualanresep.cartview') }}");
                kosong();
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
$("#idcustomer").select2({
    placeholder: 'Pilih Customer',
    ajax: {
        url: "{{ route('customer.getcustomer') }}",
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
