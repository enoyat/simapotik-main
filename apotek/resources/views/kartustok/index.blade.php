@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1>History Kartu Stok</h1>
                        <hr>

                    </div>
                </div>
            </div>
        </section>


        <section class="content">
            <div class="container-fluid">
                <div class="row">

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

                    <div class="col-6">
                        <label>Filter Pencarian</label>
                        <select name="kdbarang" id="kdbarang" class="form-control col-6"></select>
                        {{-- <label>Periode Pencarian</label> --}}
                        {{-- <input type="date" name="tglmulai" id="inputTglmulai" value="" required="required"
                            title=""> s/d <input type="date" name="tglakhir" id="inputTglmulai" value=""
                            required="required" title=""> --}}

                        <button type="button" class="btn btn-primary" id="btn-cari">Cari</button>

                    </div>



                </div>
                <div id="loading" style="display:none">
                    <center>
                        <img src="{{ asset('assets/img/loading.gif') }}" alt="Loading...." width="100px" height="100px">
                    </center>
                </div>
                <script type="text/javascript">
                    function printDiv(divName) {
                        var printContents = document.getElementById(divName).innerHTML;
                        var originalContents = document.body.innerHTML;
                        document.body.innerHTML = printContents;
                        window.print();
                        document.body.innerHTML = originalContents;
                    }
                </script>
                <div class="container">


                    <div id="area-print">
                        <div id="databarang">


                        </div>
                    </div>

                </div>

        </section>
    </div>
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $("#kdbarang").select2({
            placeholder: 'Pilih barang',
            ajax: {
                url: "{{ route('barang.getbarang') }}",
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
        $('#btn-cari').click(function() {
            var kdbarang = $('#kdbarang').val();
            if (kdbarang != '') {
                $.ajax({
                    url: "{{ route('kartustok.laporankartustok') }}",
                    type: "GET",
                    dataType: 'html',
                    data: {
                        kdbarang: kdbarang,
                        tglmulai: $('#inputTglmulai').val(),
                        tglakhir: $('#inputTglakhir').val(),
                        _token: CSRF_TOKEN
                    },
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(response) {
                        $('#loading').hide();
                        $('#databarang').html(response);
                    },
                    error: function(xhr) {
                        $('#loading').hide();
                        alert('error');
                    }
                });
            } else {
                alert('Pilih barang terlebih dahulu');
            }
        });
    </script>
@endsection
