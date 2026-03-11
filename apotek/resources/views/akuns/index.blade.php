@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>MASTER AKUN</h1>

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

                    <table class="table table-bordered table-responsive" id="tabelku" style="font-size: 11px">
                        <thead>
                            <tr>
                                <th width="20px" class="text-center">No</th>
                                <th>Kode Akun</th>
                                <th>Nama Akun</th>
                                <th>Kelompok Akun</th>
                                <th>Kategori Akun</th>
                                <th>Saldo Akun</th>
                                <th>Posisi Neraca</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($akuns as $akun)
                            <tr>
                                <td class="text-center">{{ ++$i }}</td>
                                <td>{{ $akun->kdakun }}</td>

                                <td>{{ $akun->namaakun }}</td>
                                <td>{{ $akun->get_msakun->namamsakun }}</td>
                                <td>{{ $akun->get_ktgakun->namaktgakun }}</td>
                                <td><?php
                                    if($akun->typeakun=="D") {
                                    echo "Debet";
                                    } else {
                                    echo "Kredit";
                                    };
                                    ?></td>
                                <td><?php
                                    if($akun->posisi=="L") {
                                    echo "Kiri";
                                    } else {
                                    echo "Kanan";
                                    };
                                    ?>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>



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
