<table class="table table-hover" style="font-size: 11px">
    <thead>
        <tr class="main-hading">
            <th>Pasien</th>
            <th>Dokter</th>
            <th>No Resep</th>

        </tr>
    </thead>


    @foreach ($data as $item)
        <tr>
            <td class="image" data-title="No">{{ $item->namapasien }}</td>
            <td class="product-des" data-title="No">{{ $item->get_dokter->namadokter }}</td>
            <td class="product-des" data-title="No">{{ $item->noresep }}</td>

        </tr>

    @endforeach
</tbody>
</table>
