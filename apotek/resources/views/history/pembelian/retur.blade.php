@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1>Cari History Data Pembelian</h1>
                        <hr>

                    </div>
                </div>
            </div>
        </section>

        <div id="myModal" class="modal fade " tabindex="-1" role="dialog">
            <div class="modal-dialog" style="max-width: 50%;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pembelian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
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
                            <tr>
                                <td>Periode Stok Opname</td>
                                <td>
                                    <Select name="kodeopname" id="kodeopname">
                                        <option value="">-- Pilih Periode Stok Opname --</option>
                                        @foreach ($periode as $item)
                                            <option value="{{ $item->kodeopname }}">{{ $item->kodeopname }}
                                                ({{ $item->periode }})
                                            </option>
                                        @endforeach
                                    </Select>


                                </td>

                            </tr>
                            <tr>
                                <td>Filter Pencarian </td>
                                <td>
                                    <Select name="kriteria" id="kriteria">
                                        <option value="nofaktur">No Faktur</option>
                                        <option value="namasupplier">Supplier</option>
                                        <option value="nobatch">No Batch</option>
                                        <option value="namaproduk">Nama Produk</option>
                                        <option value="noinvoice">No invoice</option>

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
        function getdatastok(keyword) {
            var kriteria = $("#kriteria").val();
            $.ajax({

                url: "{{ route('hspembelian.fetchretur') }}",
                method: "GET",
                data: {
                    kodeopname: $('#kodeopname').val(),
                    kriteria: kriteria,
                    keyword: keyword
                },
                success: function(data) {
                    $('#databarang').html(data);
                }
            });
        };
        var input = document.getElementById("search");

        // Execute a function when the user presses a key on the keyboard
        input.addEventListener("keypress", function(event) {
            // If the user presses the "Enter" key on the keyboard
            if (event.key === "Enter") {
                var keyword = $('#search').val();
                getdatastok(keyword);
                event.preventDefault();
            }
        });
    </script>
@endsection
