@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                    <div class="col-sm-6">
                        <h1>Stok Awal Produk</h1>
                        <a href="{{ route('stokawal.baru') }}" class="btn btn-primary">Baru</a>
                    </div>
            </div>
        </section>

        <form action="{{ route('stokawal.store') }}" method="POST">
            <input type="hidden" name="kdtransaksi" id="kdtransaksi" value="{{ $kdtransaksi }}">
            @csrf
            <section class="content">
                <div class="container-fluid">

                    <div class="shopping-cart section">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">

                                    <div class="col-lg-4 col-md-3 mb-3">
                                        <label for="" class="form-label">Tanggal Input</label>
                                        <input type="date" class="form-control" name="tgltrans" id="tgltrans"
                                            aria-describedby="helpId" placeholder="" value="{{ date('Y-m-d') }}" required>
                                        <small id="helpId" class="form-text text-muted">Tanggal transaksi
                                            pembelian</small>
                                    </div>
                                    <div class="col-12 mb-3" style="font-size: 12px">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#exampleModal">
                                            Cari Produk
                                        </button>
                                        <input type="text" id="kdbarang" name="kdbarang" value="" size=10 placeholder="Kode" readonly>
                                        <input type="text" name="namabarang" value="" id="namabarang" placeholder="Nama Produk"
                                            class="bg-dark">
                                        <input type="number" name="qty" value="" id="qty" min=1 max=999 placeholder="qty">
                                        <input type="text" name="harga" value="" id="harga"  placeholder="Harga"
                                            style="text-align: right" size="13" require>
                                            <input style="display:none" type="text" name="subtotal" value="" id="subtotal" readonly placeholder="SubTotal"
                                            class="bg-dark" style="text-align: right" size="13">
                                        <input style="display:none" type="text" name="diskon" value="" size="13" id="diskon" style="text-align: right" placeholder="diskon" >
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Daftar Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-bordered table-responsive-md" id="dataku" style="font-size: 10px">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $item)
                                    <tr>
                                        <td>{{ $item->kdbarang }}</td>
                                        <td>{{ $item->namabarang }}</td>
                                        <td>{{ $item->hargabeli }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>
                                            <div id="kode" class="btn btn-primary btn-sm itembarang">Pilih
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <script>
        $(document).ready(function() {
            $("#cart").load("{{ route('stokawal.cartview') }}");
            $("#kdbarang").val("");
            $("#kdbarang").focus();
        });
        $(".itembarang").click(function() {
            var currentRow = $(this).closest("tr");
            var kode = currentRow.find("td:eq(0)").html();
            var namabarang = currentRow.find("td:eq(1)").html();
            var harga = currentRow.find("td:eq(2)").html();
            $("#kdbarang").val(kode);
            $("#namabarang").val(namabarang);
            $("#qty").val("1");
            $("#harga").val(harga);
            var subtotal=1*harga;
            var jumlah = 1 * harga;
            $("#subtotal").val(subtotal);
            $("#diskon").val("0");
            $("#jumlah").val(jumlah);

            $('#exampleModal').modal('hide');
            $("#kdbarang").focus();

        });
        $("#qty").change(function() {
            var qty = $("#qty").val();
            var harga = $("#harga").val();
            var diskon= $("#diskon").val();
            var subtotal=qty*harga;
            var jumlah = qty * harga-diskon;
            $("#subtotal").val(subtotal);
            $("#jumlah").val(jumlah);
        });
        $("#harga").change(function() {
            var qty = $("#qty").val();
            var harga = $("#harga").val();
            var diskon= $("#diskon").val();
            var subtotal=qty*harga;
            var jumlah = qty * harga-diskon;
            $("#subtotal").val(subtotal);
            $("#jumlah").val(jumlah);
        });
        $("#diskon").keyup(function() {
            var qty = $("#qty").val();
            var harga = $("#harga").val();
            var diskon= $("#diskon").val();
            var subtotal=qty*harga;
            var jumlah = qty * harga-diskon;
            $("#subtotal").val(subtotal);
            $("#jumlah").val(jumlah);
        });

        $('#tambah').click(function() {
            var qty = $("#qty").val();
            var harga = $("#harga").val();
            var diskon= $("#diskon").val();
            var jumlah = qty * harga-diskon;
            $("#jumlah").val(jumlah);
            $.ajax({
                url: "{{ route('stokawal.cart') }}",
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
                    if(response=="sukses"){
                        $("#cart").load("{{ route('stokawal.cartview') }}");
                        kosong();
                        $("#kdbarang").focus();
                    }else{
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
    </script>
    <script>
        $(document).ready(function() {
            $('#dataku').DataTable();
        });
    </script>

    <!-- Modal -->
@endsection
