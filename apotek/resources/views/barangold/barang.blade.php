@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Produk</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="container">
                            <a href="{{ route('barang.index') }}">
                                <div id="viewData" class="btn btn-info">Daftar Produk</div>
                            </a>
                            <a href="{{ route('barang.create') }}">
                                <div id="viewData" class="btn btn-info">Tambah Produk</div>
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
                                            Nama Produk
                                        </th>
                                        <th>
                                            Harga Pokok Pembelian (HPP)
                                        </th>

                                        <th>
                                            Harga Jual
                                        </th>
                                        <th>
                                            Berat (gr)
                                        </th>
                                        <th>
                                            Gambar
                                        </th>
                                        <th>
                                            stok
                                        </th>
                                        <th>
                                            Aksi
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                            foreach ($barang as $key) {

                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $key->kdbarang; ?></td>
                                        <td><?php echo $key->namabarang; ?></td>
                                        <td><?php echo $key->hargabeli; ?></td>
                                        <td><?php echo $key->hargajual; ?></td>
                                        <td><?php echo $key->berat; ?></td>

                                        <td><img src="{{ asset('assets/inventory/' . $key->foto) }}" height="50px">
                                        </td>
                                        <td><?php echo $key->stok; ?></td>

                                        <td>

                                            <a class="btn btn-xs btn-danger" data-toggle="modal"
                                                data-target="#modal_hapus<?php echo $key->kdbarang; ?>">Hapus</a>

                                            <a href="{{ route('barang.edit', $key->kdbarang) }}">
                                                <div id='soalBtn' class='btn btn-warning btn-xs' title="Edit">edit</div>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                            <br>
                            <br>
                        </div>
                        <?php
                    foreach($barang as $i):
                        $kdbarang=$i->kdbarang;
                        $namabarang=$i->namabarang;
                    ?>

                        <!-- ============ MODAL HAPUS  =============== -->
                        <div class="modal fade" id="modal_hapus<?php echo $kdbarang; ?>" tabindex="-1" role="dialog"
                            aria-labelledby="largeModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">x</button>
                                        <h3 class="modal-title" id="myModalLabel">Hapus Produk</h3>
                                    </div>
                                    <form class="form-horizontal" method="post" action="{{ route('barang.destroy') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Anda yakin mau menghapus <b><?php echo $namabarang; ?></b></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="kdbarang" value="<?php echo $kdbarang; ?>">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                                            <button class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>



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
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
