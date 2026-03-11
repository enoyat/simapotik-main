<div style="display: inline;  float:left; width:300px">

    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Produk" />
</div>
<br>
<br>
<div id="databarang">

</div>
<script>
function getdatastok(namabarang) {
    $.ajax({

        url: "{{ route('pembelian.fetch') }}",
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
    // getdatastok(namabarang);
    
    $.ajax({

        url: "{{ route('pembelian.fetch') }}",
        method: "GET",
        data: {
            namabarang: namabarang
        },
        success: function(data) {
            $('#databarang').html(data);
        }
    });
});
</script>