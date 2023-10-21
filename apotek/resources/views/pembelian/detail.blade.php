<table class="table table-hover" style="font-size: 11px">
    <thead>
        <tr class="main-hading">
            <th>Kode</th>
            <th>Produk</th>
            <th>No.Batch</th>
            <th>Tgl.Ed</th>
            <th class="text-center">Harga </th>
            <th class="text-center">qty</th>
            <th class="text-center">Diskon %</th>
            <th class="text-center">Diskon Rp</th>
            <th class="text-center">Total</th>

        </tr>
    </thead>


    <?php $i = 0;
    $total = 0; ?>
    @foreach ($data as $item)
        <tr>
            <td class="image" data-title="No">{{ $item->kdbarang }}</td>
            <td class="product-des" data-title="Description">
                {{ $item->get_barang->namabarang }}
            </td>
            <td class="product-des" data-title="Description">
                {{ $item->nobatch }}
            </td>
            <td class="product-des" data-title="Description">
                {{ $item->tglkadaluarsa }}
            </td>
            <td class="price" data-title="Price" style="text-align: right">
                <span>{{ number_format($item->harga, 0) }}</span>
            </td>
            <td class="qty" data-title="Qty" style="text-align: right">
                {{ $item->qty }}
            </td>
            <td class="total-amount" data-title="Diskon %" style="text-align: right">
                <span>{{ number_format($item->diskonpersen, 0) }}</span>
            </td>
            <td class="total-amount" data-title="Diskon" style="text-align: right">
                <span>{{ number_format($item->diskon, 0) }}</span>
            </td>

            <td class="total-amount" data-title="Total" style="text-align: right">
                <span>{{ number_format($item->jumlah, 0) }}</span>
            </td>

        </tr>
        <?php
        $total = $total + $item->jumlah;
        $i++; ?>
    @endforeach
</tbody>
</table>
