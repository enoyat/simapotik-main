<div style="display: inline;  float:left; width:300px">

                        <input type="text" name="searchbarang" id="searchbarang" class="form-control"
                            placeholder="Cari Produk / Barang" value="" autocomplete="off"/>
                    </div>
                    <br>
                    <br>
<div id="databarang">
    @include('penjualan.fetch')
</div>
<script>
function getdatastok(namabarang) {
    $.ajax({

        url: "{{ route('penjualan.fetch') }}",
        method: "GET",
        data: {
            jenisharga: $('#jenisharga').val(),
            namabarang: namabarang
        },
        success: function(data) {
            $('#databarang').html(data);
        }
    });
};
$('#searchbarang').change(function() {
    var namabarang = $('#searchbarang').val();
    getdatastok(namabarang);
});
</script>
