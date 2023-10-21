@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>LAPORAN STOK OPNAME</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="container" style="text-align: center">

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
                        <form action="{{ route('stokopname.cetakstokopname') }}" method="POST" target="_blank">
                            @csrf

                            <table class="table table-responsive">
                                <tr>
                                    <td colspan="2" style="background: blue; color: white">LAPORAN STOK OPNAME</td>
                                </tr>
                                <tr>
                                    <td>Lokasi  </td>
                                    <td>
                                        <select name="idlokasi" id="idlokasi" class="form-control">
                                            <option value="">== Pilih lokasi ==</option>
                                            @foreach ($lokasi as $row)
                                            <option value="{{ $row->idlokasi }}">{{ $row->namalokasi }}</option>
                                            @endforeach
                                        </select>

                                    </td>

                                </tr>
                                <tr>
                                    <td>Mulai </td>
                                    <td>
                                        <input type="date" name="tglmulai" id="inputTglmulai" value="" required="required"
                                            title="">
                                    </td>

                                </tr>
                                <tr>
                                    <td>Akhir </td>
                                    <td> <input type="date" name="tglakhir" id="inputTglmulai" value="" required="required"
                                            title=""></td>

                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="submit" class="btn btn-primary"
                                            onclick="return confirm('Cetak Laporan Ini ?')">Cetak</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection
