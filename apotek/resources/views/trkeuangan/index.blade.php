@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">


                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('trkeuangan.store') }}" method="POST">
                        @csrf

                        <table class="table table-hover " >
                            <tr>
                                <td colspan="2" style="background: blue; color: white">FORM TRANSAKSI KEUANGAN</td>
                            </tr>

                            <tr>
                                <div align="center"> <br />
                                    <table width="90%" class="table-responsive">
                                        <tr>
                                            <td>Tgl. Transaksi</td>
                                            <td><input type="date" name="tgltrans" value="" placeholder=""
                                                    required="required"></td>
                                        </tr>
                                        <tr>
                                            <td>Transaksi</td>
                                            <td>

                                                <select name="kdtransaksi" id="kdtransaksi" required="required">
                                                    <option value="" selected>-- Transaksi Keuangan --</option>}

                                                    @foreach ($mstransaksis as $mstransaksi)
                                                    @php

                                                    $ID = $mstransaksi->kdtransaksi;
                                                    $nama = $mstransaksi->namatransaksi;
                                                    $a = $ID;
                                                    @endphp
                                                    <option value='{{ $a }}'>{{ $nama }}</option>";
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah</td>
                                            <td>
                                                <input type="text" name="jumlah" id="jumlah" />
                                                <input type="text" name="tampiljumlah" id="tampiljumlah"
                                                    readonly="readonly" style="font-size:18px; text-align:right"
                                                    required="required" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td><input type="text" name="keterangan" id="keterangan" required="required"
                                                    size="50" /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <hr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><input type="submit" value="Simpan" class="customBtn"
                                                    onclick="return confirm('Simpan Transaksi Ini ?')" />
                                                <input type="reset" value="Reset" class="customBtn" />
                                            </td>
                                        </tr>
                                    </table>
                                    <br />
                                </div>

                                </td>
                            </tr>
                        </table>

                    </form>


                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
    $('#jumlah').change(function() {
        var data = $("#jumlah").val();
        $('#tampiljumlah').val(accounting.formatMoney(data, "Rp ", 0, ".", ","));
    });
    </script>
</div>
@endsection
