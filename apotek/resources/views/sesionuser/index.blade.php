@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>sesionuser</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <a href="{{ route('sesionuser') }}">
                            <div id="viewData" class="btn btn-info">Daftar sesionuser</div>
                        </a>
                        <a href="{{ route('sesionuser.create') }}">
                            <div id="viewData" class="btn btn-info">Tambah sesionuser</div>
                        </a>

                        <br>
                        <br>

                        <table class="table  table-hover table-responsive" id='mydata'>
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        tanggal
                                    </th>
                                    <th>
                                        email
                                    </th>
                                    <th>
                                        token
                                    </th>
                                    <th>
                                        status
                                    </th>
                                    <th>
                                        Aksi
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($sesionuser as $key)
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $key->tgltrans; ?></td>
                                        <td><?php echo $key->email; ?></td>
                                        <td><?php echo $key->token; ?></td>
                                        <td><?php echo $key->f_status; ?></td>

                                        <td>
                                            <a href="{{ route('sesionuser.edit', $key->id) }}">
                                                <div id='soalBtn' class='btn btn-warning btn-xs' title="Edit">Edit</div>
                                            </a>
                                            <a href="{{ route('sesionuser.show', $key->id) }}">
                                                <div id='soalBtn' class='btn btn-primary btn-xs' title="Edit">Cetak</div>
                                            </a>

                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                    </div>

                </div>
            </div>
        </section>
    </div>
    <script>
        $(function() {
            $('#mydata').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            })
        })
    </script>
@endsection
