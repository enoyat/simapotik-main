<div class="container">
    <table class="table" style="font-size: 12px">
        @foreach ($barang as $key)
            <tr>
                <td>{{ $key->idlokasi }} </td>
                <td>{{ $key->get_lokasi->namalokasi }} </td>
                <td>{{ $key->stok }} </td>
                <td><button id="kode" class="itembarang bg-primary">Pilih
                    </button></td>


            </tr>
            @php
                $kdbarang = $key->kdbarang;
                $namabarang = $key->get_barang->namabarang;
                $namalokasi = $key->get_lokasi->namalokasi;
                $stok = $key->stok;
            @endphp
        @endforeach

    </table>




    <div class="form-group row">
        <label for="kdbarang" class="col-sm-3 col-form-label">Kode Barang</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="kdbarang" name="kdbarang" value="{{ $kdbarang }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="namabarang" class="col-sm-3 col-form-label">Nama Barang</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="namabarang" name="namabarang" value="{{ $namabarang }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="kdbarang" class="col-sm-3 col-form-label">Lokasi</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="idlokasi" name="idlokasi" value="" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="stok" class="col-sm-3 col-form-label">Stok Sistem</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="stok" name="stok" value="{{ $stok }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="qtybeli" class="col-sm-3 col-form-label">Retur</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="qtyretur" name="qtyretur" value="">
            <input type="hidden" class="form-control" id="idrecord" name="idrecord" value="{{ $idrecord }}">
        </div>

    </div>
    <div class="form-group row">

        <div class="col-sm-12" style="text-align: right">
            <button id="btnsimpan" class="btn btn-primary">Masukkan</button>
        </div>
    </div>

</div>
<script>
    $('#qtyretur').keyup(function() {
        var stok = parseInt($('#stok').val());
        var qty = parseInt($(this).val());
        if (qty > stok) {
            alert("qty melebihi stok");
            $("#qtyretur").val("");
            $("#qtyretur").focus();

        }

    });
    $('#btnsimpan').click(function() {
        var idrecord = $('#idrecord').val();
        var qty = $('#qtyretur').val();
        var idlokasi = $('#idlokasi').val();
        if (qty == 0) {
            alert("qty masih kosong");
        } else {
            $("#qty" + idrecord).val(qty);
            $("#idlokasi" + idrecord).val(idlokasi);
            document.getElementById('checkretur' + idrecord).checked = true;
            $('#myModal').modal('hide');
            $('.modal-backdrop').hide();
        }

    });
    $(".itembarang").click(function() {
        var currentRow = $(this).closest("tr");
        var idlokasi = currentRow.find("td:eq(0)").html();
        var namalokasi = currentRow.find("td:eq(1)").html();
        var stok = currentRow.find("td:eq(2)").html();

        $("#idlokasi").val(idlokasi);
        $("#namalokasi").val(namalokasi);
        $("#stok").val(stok);
        $("#qtyretur").focus();

    });
</script>
