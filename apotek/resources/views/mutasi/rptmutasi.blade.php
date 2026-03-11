@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>LAPORAN MUTASI STOK</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <div class="container">

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
                            <form action="{{ route('mutasi.laporanmutasi') }}" method="POST" target="_blank">
                                @csrf
                                <div class="form-group">
                                    <label for="">Periode Laporan Mulai</label>
                                    <input type="date" name="tglmulai" id="inputTglmulai" value=""
                                        required="required" title=""> s/d <input type="date" name="tglakhir"
                                        id="inputTglmulai" value="" required="required" title="">

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"
                                    onclick="return confirm('Cetak Laporan Ini ?')">Cetak</button>

                                </div>


                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $("#golongan").hide();
        });
        $("#kriteria").change(function() {
            var pilihan = $("#kriteria").val();
            if(pilihan=="golongan") {
                $("#golongan").show();
            }
            else {
                $("#golongan").hide();
            };
        });
    </script>
@endsection
