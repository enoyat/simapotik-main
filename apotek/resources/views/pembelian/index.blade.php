@extends('template.master-dashboard-administrator')
@section('contents')
<style>
.btn:hover {
    background-color: red;
    color: white;
}
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12">
                    <h1>Pembelian</h1>
                    <hr>
                    <a href="{{ route('pembelian.baru') }}" class="btn btn-primary">Baru</a>
                </div>
            </div>
        </div>
    </section>

    <form action="{{ route('pembelian.store') }}" method="POST">
        <input type="hidden" name="kdtransaksi" id="kdtransaksi" value="{{ $kdtransaksi }}">
        @csrf
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3">
                            <label for="" class="form-label">Supplier</label>
                            <select class="form-control" name="idsupplier" id="idsupplier" required>

                            </select>
                            <label for="" class="form-label">Tanggal pembelian</label>
                            <input type="date" class="form-control" name="tgltrans" id="tgltrans"
                                aria-describedby="helpId" placeholder="" value="{{ date('Y-m-d') }}" required>
                                <label for="" class="form-label ">Jenis pembelian</label>
                            <select class="form-control" name="tipepembelian" id="tipepembelian" required>
                                <option value="T" selected>Tunai</option>
                                <option value="K">Kredit</option>
                            </select>
                    </div>
                    <div class="col-3">
                            <label for="" class="form-label">No. Faktur</label>
                            <input type="text" name="nofaktur" id="nofaktur" value="" class="form-control" required>

                            <label for="" class="form-label">Gudang</label>
                            <select name="idlokasi" id="idlokasi" class="form-control" required>
                                <option value="">Pilih Gudang</option>
                                @foreach ($lokasi as $item)
                                <option value="{{ $item->idlokasi }}">{{ $item->namalokasi }}
                                </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="shopping-cart section">
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mb-3" style="font-size: 12px">
                            <table width="80%">
                                <tr>
                                    <td>Cari</td>
                                    </td>
                                    <td>Kode / Nama Produk</td>
                                    <td>NoBatch</td>
                                    <td> Tgl.Ed</td>
                                    <td>Harga</td>
                                    <td>Qty</td>
                                    <td>Disc % </td>
                                    <td> Disc Rp</td>
                                    <td>Total</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a class="btn btn-sm btn-info" data-url="{{ route('pembelian.fetch') }}"
                                            id="btncari" title="Detail"><i class="fa fa-search-plus"
                                                aria-hidden="true"></i></a>
                                    </td>
                                    <td>
                                        <input type="text" id="kdbarang" name="kdbarang" value="" size=10
                                            placeholder="Kode" readonly>


                                    </td>
                                    <td>
                                        <input type="text" name="nobatch" id="nobatch" value="" require>
                                    </td>
                                    <td><input type="date" name="tglkadaluarsa" id="tglkadaluarsa" value="" require>
                                    </td>


                                    <td>
                                        <input type="text" name="harga" value="" id="harga" class="innilai"
                                            placeholder="Harga" style="text-align: right" size="13">
                                    </td>
                                    <td>
                                        <input type="number" name="qty" value="" id="qty" min=1 max=999
                                            placeholder="qty" class="innilai">
                                    </td>
                                    <td>
                                        <input class="innilai" type="number" name="diskonpersen" id="diskonpersen"
                                            value="0" max="100" style="text-align: right; width: 50px">

                                    </td>

                                    <td>
                                        <input type="text" name="diskon" value="" size="13" id="diskon"
                                            style="text-align: right" placeholder="diskon">
                                    </td>
                                    <td>
                                        <input type="text" name="jumlah" value="" id="jumlah" readonly
                                            placeholder="Jumlah" class="bg-dark" style="text-align: right">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" id="tambah">+</button>
                                    </td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2"> <input type="hidden" name="namabarang" value="" id="namabarang"
                                            placeholder="Nama Produk" readonly size=20>
                                        <div id="dispnamabarang"></div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <!-- Shopping Summery -->
                        
                        <div id="cart" class="col-12 mb-3">

                        </div>
                    </div>
                        <!--/ End Shopping Summery -->
                    </div>
                </div>

            </div>
        </section>
    </form>
</div>


<!-- Button trigger modal -->


<div id="myModal" class="modal fade " tabindex="-1" role="dialog">
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
    $("#cart").load("{{ route('pembelian.cartview') }}");
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
    $.ajax({
        url: "{{ route('pembelian.cart') }}",
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            "kdbarang": $("#kdbarang").val(),
            "namabarang": $("#namabarang").val(),
            "nobatch": $("#nobatch").val(),
            "tglkadaluarsa": $("#tglkadaluarsa").val(),
            "qty": $("#qty").val(),
            "harga": $("#harga").val(),
            "diskonpersen": $("#diskonpersen").val(),
            "diskon": $("#diskon").val(),
            "jumlah": $("#jumlah").val(),
        },
        dataType: "text",
        success: function(response) {
            if (response == "sukses") {
                $("#cart").load("{{ route('pembelian.cartview') }}");
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
    $("#nobatch").val("");
    $("#tglkadaluarsa").val("");
    $("#qty").val("");
    $("#harga").val("");
    $("#subtotal").val("");
    $("#diskonpersen").val("0");
    $("#diskon").val("0");
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