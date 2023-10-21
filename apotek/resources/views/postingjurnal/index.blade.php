@extends('template.master-dashboard-administrator')
@section('contents')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

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
                        <form action="{{ route('postingjurnal.posting') }}" method="POST">
                            @csrf

                            <table class="table table-hover">
                                <tr>
                                    <td colspan="2" style="background: blue; color: white">POSTING JURNAL TRANSAKSI
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Periode Posting </td>
                                </tr>
                                <tr>
                                    <td>Jurnal </td>
                                    <td>
                                        <select name="kdjurnal" id="kdjurnal" class="form-control">
                                            <option value="">== Pilih Jurnal ==</option>
                                            @foreach ($msjurnals as $kdjurnal => $namajurnal )
                                            <option value="{{ $kdjurnal }}">{{ $namajurnal }}</option>
                                            @endforeach
                                        </select>

                                    </td>

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
                                            onclick="return confirm('Posting Jurnal Transaksi Ini ?')">Posting</button>
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
