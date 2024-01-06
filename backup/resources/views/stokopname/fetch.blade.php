<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADJUSTMENT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
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
                Stok
            </th>

            <th>Aksi</th>


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
            <td><?php echo $key->stok; ?></td>
            <td>
                <div style="display: inline;  float:left; width:35px">

                    <button class="btn btn-sm btn-info  btn-action"
                        data-url="{{ route('stokopname.create',$key->id) }}"
                        id="btnAction1">Adjust</button>
                </div>
            </td>

        </tr>
        <?php $i++; } ?>
    </tbody>
</table>

<script>

    $('.btn-action').click(function() {
            var url = $(this).data("url");

            $.ajax({
                url: url,
                dataType: 'html',
                success: function(res) {

                    // get the ajax response data
                    var data = res;

                    // update modal content here
                    // you may want to format data or
                    // update other modal elements here too
                    $('.modal-body').html(data);

                    // show modal
                    $('#myModal').modal('show');

                },
                error: function(request, status, error) {
                    console.log("ajax call went wrong:" + request.responseText);
                }
            });
        });
        $(function() {
        $('#mydata').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false
        })
    });
</script>
