@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="col-sm-6">
                    <h1>Mutasi Stok</h1>
                    <a href="{{ route('mutasi.baru') }}" class="btn btn-primary">Baru</a>
                </div>
            </div>
        </section>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">DAFTAR PRODUK</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('mutasi.store') }}" method="POST">
            @csrf
            <section class="content">

                <div class="container-fluid">

                    <div class="shopping-cart section">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">

                                    <div class="col-lg-4 col-md-3 mb-3">
                                        <label for="" class="form-label">Tanggal Mutasi</label>
                                        <input type="date" class="form-control" name="tgltrans" id="tgltrans"
                                            aria-describedby="helpId" placeholder="" value="{{ date('Y-m-d') }}" required>

                                    </div>
                                    <div class="col-lg-4 col-md-3 mb-3">
                                        <label for="" class="form-label">Lokasi Asal</label>
                                        <select name="idlokasi" id="idlokasi" class="form-text text-muted" required>
                                            <option value="">Pilih Lokasi</option>
                                            @foreach ($lokasi as $item)
                                                <option value="{{ $item->idlokasi }}">{{ $item->namalokasi }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-lg-4 col-md-3 mb-3">
                                        <label for="" class="form-label">Lokasi Tujuan</label>
                                        <select name="idlokasidest" id="idlokasidest" class="form-text text-muted" required>
                                            <option value="">Pilih Lokasi</option>
                                            @foreach ($lokasi as $item)
                                                <option value="{{ $item->idlokasi }}">{{ $item->namalokasi }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-12 mb-3" style="font-size: 12px">

                                        <div data-url="{{ route('mutasi.listproduk') }}"
                                            class="btn btn-sm btn-info  btn-action">Cari Produk</div>
                                        <input type="text" id="kdbarang" name="kdbarang" value="" size=20
                                            placeholder="Kode" readonly>
                                        <input type="text" name="namabarang" value="" size=30 id="namabarang"
                                            placeholder="Nama Produk" style="text-align: left">
                                        Stok Max: <input type="number" name="qtymax" value="" id="qtymax" min=1
                                            max=999 placeholder="qty" readonly>
                                        Mutasi: <input type="number" name="qty" value="" id="qty" min=1
                                            max=999 placeholder="qty">
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
    <!-- Button trigger modal -->
    <script>
        $(document).ready(function() {
            $("#cart").load("{{ route('mutasi.cartview') }}");
            $("#dataku").DataTable();
        });

        $('#tambah').click(function() {
            var qty = $("#qty").val();
            var harga = $("#harga").val();
            var diskon = $("#diskon").val();
            var jumlah = qty * harga - diskon;
            $("#jumlah").val(jumlah);
            $.ajax({
                url: "{{ route('mutasi.cart') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "tglmutasi": $("#tgltrans").val(),
                    "idlokasi": $("#idlokasi").val(),
                    "idlokasidest": $("#idlokasidest").val(),
                    "kdbarang": $("#kdbarang").val(),
                    "namabarang": $("#namabarang").val(),
                    "qty": $("#qty").val(),
                    "qtymax": $("#qtymax").val(),

                },
                dataType: "text",
                success: function(response) {
                    if (response == "sukses") {
                        $("#cart").load("{{ route('mutasi.cartview') }}");
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
            $("#qtymax").val("");
        }
        $('.btn-action').click(function() {
            var url = $(this).data("url");
            var idlokasi = $("#idlokasi").val();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "idlokasi": idlokasi,
                },
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
    </script>


    <!-- Modal -->
@endsection
