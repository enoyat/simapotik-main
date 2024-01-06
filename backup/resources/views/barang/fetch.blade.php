<table class="table  table-hover table-responsive" id='mydata' style="font-size: 11px">
<thead>
    <tr>
        <th>
            No
        </th>
        <th>
            Kode
        </th>
        <th>
            Nama barang
        </th>
        <th>
            HNA
        </th>
        <th>
            Harga Beli
        </th>
        <th>
            Harga Resep
        </th>
        <th>
            Harga Grosir
        </th>
        <th>
            Harga HV
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
$i = 1;
foreach ($barang as $key) {

?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $key->kdbarang; ?></td>
        <td><?php echo $key->namabarang; ?></td>
        <td><?php echo $key->hna; ?></td>
        <td><?php echo $key->hargabeli; ?></td>
        <td><?php echo $key->hargaresep; ?></td>
        <td><?php echo $key->hargagrosir; ?></td>
        <td><?php echo $key->hargahv; ?></td>

        </td>
        <td><?php echo $key->stok; ?>
        </td>


        <td>

            <a class="btn btn-xs btn-danger" data-toggle="modal"
                data-target="#modal_hapus<?php echo $key->kdbarang; ?>">Hapus</a>

            <a href="{{ route('barang.edit', $key->kdbarang) }}">
                <div id='soalBtn' class='btn btn-warning btn-xs' title="Edit">edit</div>
            </a>
        </td>
    </tr>
    <?php $i++;}?>
</tbody>
</table>

<?php
foreach ($barang as $i):
$kdbarang = $i->kdbarang;
$namabarang = $i->namabarang;
?>

<!-- ============ MODAL HAPUS  =============== -->
<div class="modal fade" id="modal_hapus<?php echo $kdbarang; ?>" tabindex="-1" role="dialog"
    aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-hidden="true">x</button>
                <h3 class="modal-title" id="myModalLabel">Hapus barang</h3>
            </div>
            <form class="form-horizontal" method="post"
                action="{{ route('barang.destroy') }}">
                @csrf
                <div class="modal-body">
                    <p>Anda yakin mau menghapus <b><?php echo $namabarang; ?></b></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="kdbarang" value="<?php echo $kdbarang; ?>">
                    <button class="btn" data-dismiss="modal"
                        aria-hidden="true">Tutup</button>
                    <button class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
</div>
<br>
<br>
<script>
        $(document).ready(function() {
        $('#mydata').DataTable(
            {
                "scrollX": true,
                "lengthChange": false,
            }   
        );
    });
</script>