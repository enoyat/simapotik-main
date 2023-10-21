@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>LAPORAN KEUANGAN</h1>
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
                        <form action="{{ route('laporankeuangan') }}" method="POST" target="_blank">
                            @csrf

                            <table class="table table-responsive">
                                <tr>
                                    <td colspan="2" style="background: blue; color: white">LAPORAN KEUANGAN</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Periode Laporan: </td>
                                </tr>
                                <tr>
                                    <td>Bulan </td>
                                    <td>
                                        <select name="bulan" id="bulan" class="form-control">
                                            <option value="<?php echo gmdate("m",time()+60*60*7);?>">
                                                <?php echo gmdate("M",time()+60*60*7);?></option>
                                            <option value="01">Januari</option>
                                            <option value="02">Februari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">Nopember</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Tahun </td>
                                    <td><input type="text" name="tahun" value="<?php echo gmdate("Y",time()+60*60*7);?>"
                                            size=5 maxlength="4" class="form-control"></td>

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