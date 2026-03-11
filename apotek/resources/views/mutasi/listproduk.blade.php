<table class="table table-hover" style="font-size: 11px" id="listproduk">
    <thead>
        <tr class="main-hading">
            <th>Kode</th>
            <th>Produk</th>
            <th class="text-center">stok</th>
            <th>Aksi</th>

        </tr>
    </thead>


    <?php $i = 0;
    $total = 0; ?>
    @foreach ($barang as $item)
        <tr>
            <td class="image" data-title="No">{{ $item->kdbarang }}</td>
            <td>{{ $item->namabarang }}</td>
            <td class="qty" data-title="Qty" style="text-align: right">{{ $item->stok }}</td>
            <td>
                <div id="kode" class="btn btn-primary btn-sm itembarang">Pilih
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
</table>
<script>
            $(".itembarang").click(function() {
            var currentRow = $(this).closest("tr");
            var kode = currentRow.find("td:eq(0)").html();
            var namabarang = currentRow.find("td:eq(1)").html();
            var qty = currentRow.find("td:eq(2)").html();
            
            $("#kdbarang").val(kode);
            $("#namabarang").val(namabarang);
            $("#qtymax").val(qty);
            $('#myModal').modal('hide');
            $("#qty").focus();

        });
    $(document).ready(function() {
        $('#listproduk').DataTable();
    });

</script>
