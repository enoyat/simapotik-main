<table class="table table-hover" style="font-size: 11px">
    <thead>
        <tr class="main-hading">
            <th>Kode</th>
            <th>Produk</th>
            <th>No.Batch</th>
            <th>Tgl.Ed</th>
            <th>Lokasi</th>
            <th class="text-center">qty</th>

        </tr>
    </thead>

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

            <td class="product-des" data-title="Description">
                {{ $item->idlokasi }}
            </td>
            <td class="qty" data-title="Qty" style="text-align: right">
                {{ $item->qty }}
            </td>
        </tr>
    @endforeach
</tbody>
</table>
