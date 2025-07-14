@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1>Cari Data penjualan</h1>
                        <hr>

                    </div>
                </div>
            </div>
        </section>

        <div id="loader"><img id="loading-image" src="{{ asset('assets/img/Ajax-loader.gif') }}" /></div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="container-fluid">

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
                        <table class="table table-responsive">
                            <tr><td>Periode Penjualan</td>
                                <td>
                            <div class="form-group">

                                <input type="date" name="tglmulai" id="tglmulai" value=""
                                    required="required" title=""> s/d <input type="date" name="tglakhir"
                                    id="tglakhir" value="" required="required" title="">

                            </div>
                            </td>
                            <tr>
                                <td>Filter Pencarian </td>
                                <td>
                                    <Select name="kriteria" id="kriteria">
                                        <option value="nofaktur">No Penjualan</option>
                                        <option value="namacustomer">Customer</option>
                                        <option value="resep">Resep</option>
                                        <option value="namabarang">Nama Barang</option>
                                        <option value="namadokter">Nama Dokter</option>
                                        <option value="pasien">Nama Pasien</option>

                                    </Select>



                                </td>

                            </tr>
                            <tr>
                                <td>Kata Kunci</td>
                                <td> <input type="text" name="search" id="search" class="form-control"
                                        placeholder="KeyWord" /></td>

                            </tr>


                        </table>
                    </div>

                </div>
                <div id="databarang">


                </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#loader').hide();
        });

        var input = document.getElementById("search");

        // Execute a function when the user presses a key on the keyboard
        input.addEventListener("keypress", function(event) {
            // If the user presses the "Enter" key on the keyboard
            if (event.key === "Enter") {
                var keyword = $('#search').val();
                var kriteria = $("#kriteria").val();
                var tglmulai = $("#tglmulai").val();
                var tglakhir = $("#tglakhir").val();
                $.ajax({

                    url: "{{ route('penjualan.fetchretur') }}",
                    method: "GET",
                    data: {
                        tglmulai: tglmulai,
                        tglakhir: tglakhir,
                        kriteria: kriteria,
                        keyword: keyword
                    },
                    beforeSend: function() {
                        $('#loader').show();
                    },

                    success: function(data) {
                        $('#databarang').html(data);
                        $('#loader').hide();
                    }
                });
                event.preventDefault();
            }
        });
    </script>
@endsection
