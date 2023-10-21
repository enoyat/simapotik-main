<table class="table shopping-summery table-responsive-md">
    <thead>
        <tr class="main-hading">
        <th>tglmutasi</th>
        <th>lokasi awal</th>
        <th>lokasi dest</th>
            <th>Kode</th>
            <th>Produk</th>
            <th class="text-center">qty</th>
            <td style="display: none">Idx</th>
            <th class="text-center"><i class="ti-trash remove-icon"></i></th>
        </tr>
    </thead>
    <tbody>

 
        @if (Session::has('cart'))
            <?php $i = 0;
            $total = 0; ?>
            @foreach (Session::get('cart') as $item)
                <tr>
                <td class="image" data-title="No">{{ $item['tglmutasi'] }}</td>
                <td class="image" data-title="No">{{ $item['idlokasi'] }}</td>
                <td class="image" data-title="No">{{ $item['idlokasidest'] }}</td>
                    <td class="image" data-title="No">{{ $item['kdbarang'] }}</td>
                    <td class="product-des" data-title="Description">
                        {{ $item['namabarang'] }}
                    </td>
                    <td class="qty" data-title="Qty" style="text-align: right">
                        {{ $item['qty'] }}
                    </td>
                    <td style="display: none">
                        {{ $i; }}
                    </td>
                    <td class="action" data-title="Remove">
                        <div class="btn btnhapus"><i class="bi bi-trash3"></i></div>

                    </td>
                </tr>
                <?php
                $total = $total + $item['jumlah'];
                $i++; ?>
            @endforeach
        @endif
    </tbody>
</table>
<div class="row">
    <div class="col-12">
        <!-- Total Amount -->
        <div class="total-amount">
            <div class="row">
                <div class="col-lg-8 col-md-5 col-12">
                    <div class="left">

                    </div>
                </div>
                <div class="col-lg-4 col-md-7 col-12">
                        <div class="right">
                            <ul>
                                <button type="submit" class="button5">Simpan</button>
                            </ul>


                        </div>
                </div>
            </div>
        </div>
        <!--/ End Total Amount -->
    </div>
</div>
<script>
    $(".btnhapus").click(function() {
        var currentRow = $(this).closest("tr");
        var idx = currentRow.find("td:eq(6)").html();
        $.ajax({
            url: "{{ route('mutasi.carthapus') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "idx": idx,
            },
            success: function(response) {
                $("#cart").load("{{ route('mutasi.cartview') }}");
            },
        });
    });
</script>
