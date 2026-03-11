<script>
    function hitungppn() {
    var ppn = $("#ppn").val();
    var total = $("#total").val();
    totalbaru = parseInt(total) + ((parseInt(total) * parseInt(ppn)) / 100);
    $("#grandtotal").val(totalbaru);
    $("#dgrandtotal").val(totalbaru.toLocaleString('en-GB'));
};
</script>

<table class="table table-sm table-hover  " style="font-size:12px">
    <thead class="thead-dark">
        <tr class="main-hading">
            <th>Kode</th>
            <th>Produk</th>
            <th>No.Batch</th>
            <th>Tgl.Ed</th>
            <th class="text-center">Harga</th>
            <th class="text-center">qty</th>
            <th class="text-center">Diskon %</th>
            <th class="text-center">Diskon Rp</th>
            <th class="text-center">Total</th>
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
            <td class="image" data-title="No">{{ $item['kdbarang'] }}</td>
            <td class="product-des" data-title="Description">
                {{ $item['namabarang'] }}
            </td>
            <td class="product-des" data-title="Description">
                {{ $item['nobatch'] }}
            </td>
            <td class="product-des" data-title="Description">
                {{ $item['tglkadaluarsa'] }}
            </td>
            <td class="price" data-title="Price" style="text-align: right">
                <span>{{ number_format($item['harga'], 0) }}</span>
            </td>
            <td class="qty" data-title="Qty" style="text-align: right">
                {{ $item['qty'] }}
            </td>
            <td class="total-amount" data-title="Diskon" style="text-align: right">
                <span>{{ number_format($item['diskonpersen'], 0) }}</span>
            </td>
            <td class="total-amount" data-title="Diskon" style="text-align: right">
                <span>{{ number_format($item['diskon'], 0) }}</span>
            </td>

            <td class="total-amount" data-title="Total" style="text-align: right">
                <span>{{ number_format($item['jumlah'], 0) }}</span>
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
                            <li><label>Cart Total</label><span>

                                    @if (isset($total) && $total > 0)
                                    {{ number_format($total, 0) }}
                                </span></li>
                            <input type="hidden" id="total" name="total" value="{{ $total }}">
                            <li><label>PPN (%)</label><span>
                                    <input type="text" id="ppn" name="ppn" value="11" style="text-align: right"
                                        class="inadmin">
                                </span></li>

                            <li><label>
                                    <script>
                                    $(function() {
                                        hitungppn();
                                    })
                                    </script>
                                    N E T T O
                                </label><span><input type="text" id="dgrandtotal" value="{{ number_format($total, 0) }}"
                                        style="text-align: right" readonly>
                                </span></li>

                            <input type="hidden" id="grandtotal" name="grandtotal" value="{{ $total }}"
                                style="text-align: right" class="form-control" readonly>


                            Pembayaran: <input type="checkbox" id="modebayar" name="modebayar" value="NONTUNAI"> Non
                            Tunai
                            <br>
                            <br>

                            <button type="submit" class="button5">Simpan</button>
                            @endif

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
    var idx = currentRow.find("td:eq(9)").html();
    $.ajax({
        url: "{{ route('pembelian.carthapus') }}",
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            "idx": idx,
        },
        success: function(response) {
            $("#cart").load("{{ route('pembelian.cartview') }}");
        },
    });
});



$(".inadmin").change(function() {
    hitungppn();
});
</script>