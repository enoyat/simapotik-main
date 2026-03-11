@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Golongan Obat</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <a href="{{ route('golongan.index') }}">
                            <div id="viewData" class="btn btn-info">Daftar golongan</div>
                        </a>
                        <a href="{{ route('golongan.create') }}">
                            <div id="viewData" class="btn btn-info">Tambah golongan</div>
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
                                        Kode
                                    </th>
                                    <th>
                                        Nama golongan
                                    </th>
                                    <th>
                                        Aksi
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($golongan as $key)
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $key->idgolongan; ?></td>
                                        <td><?php echo $key->namagolongan; ?></td>
                                        <td>
                                            <a href="{{ route('golongan.edit', $key->idgolongan) }}">
                                                <div id='soalBtn' class='btn btn-warning btn-xs' title="Edit">Edit</div>
                                            </a>
                                            <a class="btn btn-xs btn-danger" data-toggle="modal"
                                                data-target="#modal_hapus<?php echo $key->idgolongan; ?>">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                    </div>

                    @foreach ($golongan as $i)
                        @php
                            $idgolongan = $i->idgolongan;
                            $namgolongan = $i->namgolongan;
                        @endphp
                        <!-- ============ MODAL HAPUS  =============== -->
                        <div class="modal fade" id="modal_hapus<?php echo $idgolongan; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="largeModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">x</button>
                                        <h3 class="modal-title" id="myModalLabel">Hapus golongan</h3>
                                    </div>
                                    <form class="form-horizontal" method="post" action="{{ route('golongan.destroy') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Anda yakin mau menghapus <b><?php echo $namgolongan; ?></b></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="idgolongan" value="<?php echo $idgolongan; ?>">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                                            <button class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
