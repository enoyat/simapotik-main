@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>MASTER JURNAL TRANSAKSI</h1>
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

                    <table class="table table-bordered table-hover table-responsive" id="tabelku" style="font-size: 12px">
                        <thead>
                            <tr>
                                <th width="20px" class="text-center">No</th>
                                <th>Kode Transaksi</th>
                                <th>Nama Transaksi</th>
                                <th>Akun Debet</th>
                                <th>Akun Kredit</th>
                                <th>Sub Transaksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mstransaksis as $mstransaksi)
                            <tr>
                                <td class="text-center">{{ ++$i }}</td>
                                <td>{{ $mstransaksi->kdtransaksi }}</td>

                                <td>{{ $mstransaksi->namatransaksi }}</td>
                                <td>{{ $mstransaksi->kdakun_d }} - {{ $mstransaksi->get_akundebet->namaakun }}</td>
                                <td>{{ $mstransaksi->kdakun_k }} - {{ $mstransaksi->get_akunkredit->namaakun }}</td>

                                <td>
                                    <table class="table table-condensed table-hover">

                                        @foreach ($mstransaksi->get_subtransaksi as $subtransaksi )
                                        <tr>
                                            <td><a
                                                    href="{{ route('subtransaksis.edit',$subtransaksi->kdsubtransaksi ) }}">{{ $subtransaksi->namasubtransaksi }}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#tabelku').DataTable();
    });
    </script>
</div>
@endsection
