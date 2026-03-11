<div style="display: inline;  float:right; width:300px">
                        
                        <input type="text" name="search" id="search" class="form-control"
                            placeholder="Cari Produk" />
                    </div>
                    <br>
                    <br>
<div id="databarang">
    @include('order.fetch')
</div>
<script>
function getdatastok(namabarang) {
    $.ajax({

        url: "{{ route('order.fetch') }}",
        method: "GET",
        data: {
            namabarang: namabarang
        },
        success: function(data) {
            $('#databarang').html(data);
        }
    });
};
$('#search').change(function() {
    var namabarang = $('#search').val();
    getdatastok(namabarang);
});
</script>