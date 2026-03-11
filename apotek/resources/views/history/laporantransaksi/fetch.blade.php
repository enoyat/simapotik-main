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
                stok
            </th>
            <th>stok total</th>

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

            </td>
            <td> <?php 
        $jmlstok=0;
            foreach ($key->jmlstok as $key => $value) {
                echo " ".$value->idlokasi . " : " .$value->stok;
                $jmlstok=$jmlstok+$value->stok;
            }
            ?>
            </td>
            <td><?php echo $jmlstok; ?>


        </tr>
        <?php $i++;}?>
    </tbody>
</table>

</div>
<br>
<br>
<script>
$(document).ready(function() {
    $('#mydata').DataTable({
        "scrollX": true,
        "lengthChange": false,
    });
});
</script>