@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pembatalan Transaksi Keuangan </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">


                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Ada kesalahan data, silahkan dicek kembali<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nomor Transaksi</strong>
                                <input type="text" name="notrans" id="notrans" class="form-control" value=""
                                    required="required" pattern="" title="">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="btncari">Cari</button>
                                <a class="btn btn-info" href="{{ route('trkeuangan.batal') }}"> Refresh</a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div id="datajurnal"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div id="formbatal"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <script type="text/javascript">
            $('#btncari').click(function() {
                $('#datajurnal').html('');
                var id = $("#notrans").val();
                $.ajax({
                    url: "{{ route('trkeuangan.carijurnal') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        html += '<ul class="list-group">';
                        var i;
                        if (data.length < 1) {

                            html += "<li class='list-group-item'> data tidak ditemukan </li>";
                            $('#datajurnal').html(html + '</ul>');

                        } else {
                            for (i = 0; i < data.length; i++) {
                                notrans = data[i].notrans;
                                html += "<li class='list-group-item'> <b>No.Transaksi: </b>" + data[
                                        i].notrans + " | <b>Keterangan:</b> " + data[i].keterangan +
                                    "</li>";
                            }
                            $('#datajurnal').html(html + '</ul>');
                            $.get("/trkeuangan/detail/" + notrans, function(data) {
                                $("#formbatal").html(data);
                            });
                        }
                    }
                });
                return false;
            });
            </script>
        </div>
    </section>
</div>
@endsection