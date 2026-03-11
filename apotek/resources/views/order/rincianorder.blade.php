@extends('template.master-dashboard-administrator')
@section('contents')
    <div class="content-wrapper">
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Pembelian</h1>

                    </div>
                </div>
            </div>
        </section>


        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-hover" style="font-size: 11px" id="mydata">
                            <thead>
                                <tr class="main-hading">
                                    <td>No. Approve</td>
                                    <td>No. Order/PO</td>
                                    <td>Tgl.Approve</td>
                                    <td>Supplier</td>
                                    <th>No. Batch</th>
                                    <th>Tgl.Ed</th>
                                    <th>Kode</th>                                    
                                    <th>Produk</th>
                                    <td>Golongan</td>
                                    <th class="text-center">Harga Unit</th>
                                    <th class="text-center">qty</th>
                                    <th class="text-center">Total</th>

                                </tr>
                            </thead>


                            <?php $i = 0;
                            $total = 0; ?>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->get_pembelian->id }}</td>
                                    <td>{{ $item->get_pembelian->idorder }}</td>
                                    <td>{{ $item->get_pembelian->tgltrans }}</td>
                                    <td>{{ $item->get_pembelian->get_supplier->namasupplier }}</td>
                                    <td class="image" data-title="No">{{ $item->nobatch }}</td>
                                    <td class="image" data-title="No">{{ $item->tglkadaluarsa }}</td>

                                    <td class="image" data-title="No">{{ $item->kdbarang }}</td>
                                    <td class="product-des" data-title="Description">
                                        {{ $item->get_barang->namabarang }}
                                    </td>
                                    <td>{{ $item->get_barang->get_golongan->namagolongan }}</td>
                                    <td class="price" data-title="Price" style="text-align: right">
                                        <span>{{ number_format($item->harga, 0) }}</span>
                                    </td>
                                    <td class="qty" data-title="Qty" style="text-align: right">
                                        {{ $item->qty }}
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
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#mydata').DataTable();
        });
    </script>

@endsection
