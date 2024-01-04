<div id="databarang">
    <table class="table  table-responsive" id='mydata' style="font-size: 11px">
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>
                    Kode  sss
                </th>
                <th>
                    Nama barang
                </th>
                <th>
                    Harga
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
                <td>@if ($jenisharga=="hargahv")
                    {{ $key->hargahv }}
                    @elseif ($jenisharga=="hargagrosir")
                    {{ $key->hargagrosir }}
                    @elseif ($jenisharga=="hargaresep")
                    {{ $key->hargaresep }}
                    @endif
                </td>
                </td>
                <td><?php echo $key->stok; ?>
                </td>


                <td>
                    <button id="kode" class="itembarang bg-primary">Pilih
                    </button>
                </td>
            </tr>
            <?php $i++;}?>
        </tbody>
    </table>
</div>

<script>
$(".itembarang").click(function() {
    var currentRow = $(this).closest("tr");
    var kode = currentRow.find("td:eq(1)").html();
    var namabarang = currentRow.find("td:eq(2)").html();
    var harga = currentRow.find("td:eq(3)").html();
    $("#kdbarang").val(kode);
    $("#namabarang").val(namabarang);
    $("#qty").val("1");
    $("#harga").val(harga);
    var subtotal = 1 * harga;
    var jumlah = 1 * harga;
    $("#subtotal").val(subtotal);
    $("#diskon").val("0");
    $("#jumlah").val(jumlah);

    $('#myModal').modal('hide');
    $("#qty").focus();

});
</script>
