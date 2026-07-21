<div class="container">
    <form id="add-stokopname-form">
        @csrf
        <div class="form-group row">
            <label for="kdbarang" class="col-sm-3 col-form-label">Kode Barang</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="kdbarang" name="kdbarang" value="{{ $barang->kdbarang }}"
                    readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="namabarang" class="col-sm-3 col-form-label">Nama Barang</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="namabarang" name="namabarang"
                    value="{{ $barang->get_barang->namabarang }}" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="kdbarang" class="col-sm-3 col-form-label">Lokasi</label>
            <div class="col-sm-8">
                {{ $barang->get_lokasi->namalokasi }}
                <input type="hidden" class="form-control" id="idlokasi" name="idlokasi"
                    value="{{ $barang->idlokasi }}" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="stok" class="col-sm-3 col-form-label">Stok Sistem</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="stok" name="stok" value="{{ $barang->stok }}"
                    readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="qtybeli" class="col-sm-3 col-form-label">Stok Fisik</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="stokfisik" name="stokfisik" value="">
            </div>
        </div>
        <div class="form-group row">
            <label for="selisih" class="col-sm-3 col-form-label">Selisih</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="selisih" name="selisih" value="" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="selisih" class="col-sm-3 col-form-label">Keterangan</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-3 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $("#stokfisik").focus();
        $('#stokfisik').keyup(function() {
            var idlokasi = $('#idlokasi').val();
            var stok = $('#stok').val();
            var stokfisik = $('#stokfisik').val();
            var selisih = stokfisik - stok;
            $('#selisih').val(selisih);
        });
    });
    $('form').submit(function() {
        $('#btnSubmit')
            .prop('disabled', true)
            .text('Menyimpan...');
    });
    $("#add-stokopname-form").submit(function(event) {
        event.preventDefault();
        var kdkategori = $('#kdkategori').val();
        var idjenis = $('#idjenis').val();
        var idlokasi = $('#idlokasi').val();
        $.ajax({
            url: "/stokopname/store",
            type: "POST",
            data: {
                'kdbarang': $('#kdbarang').val(),
                'idlokasi': $('#idlokasi').val(),
                'namabarang': $('#namabarang').val(),
                'stok': $('#stok').val(),
                'stokfisik': $('#stokfisik').val(),
                'selisih': $('#selisih').val(),
                'keterangan': $('#keterangan').val(),
                '_token': $('input[name=_token]').val()

            },
            success: function(response) {
                alert(response.message);
                $('#myModal').modal('hide');
                $('.modal-backdrop').hide();
                getdatastok(idlokasi, idjenis, kdkategori);


            },

        });
    });
</script>
