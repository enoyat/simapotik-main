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
                            <td>Filter Pencarian </td>
                            <td>
                                <Select name="kriteria" id="kriteria">
                                    <option value="nofaktur">No Penjualan</option>
                                    <option value="namacustomer">Customer</option>
                                    <option value="resep">Resep</option>
                                    <option value="namabarang">Nama Barang</option>
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


var input = document.getElementById("search");

// Execute a function when the user presses a key on the keyboard
input.addEventListener("keypress", function(event) {
    // If the user presses the "Enter" key on the keyboard
    if (event.key === "Enter") {
        var keyword = $('#search').val();
        var kriteria = $("#kriteria").val();
        $.ajax({

            url: "{{ route('penjualan.fetchretur') }}",
            method: "GET",
            data: {
                kriteria: kriteria,
                keyword: keyword
            },
            success: function(data) {
                $('#databarang').html(data);
            }
        });
        event.preventDefault();
    }
});
</script>
@endsection