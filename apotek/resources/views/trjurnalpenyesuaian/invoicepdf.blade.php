<?php
use App\Http\Controllers\Trkeuangan;
?>
<div class="container">
    <div id="area-print">
        <table >
                <thead>
                  <tr>
                    <th><img src="{{public_path('/img/logountag.jpg')}} " width="50px" />
                    </th>
                    <th style="text-align: left; font-size: 10px">
                      Yayasan Pembina Pendidikan 17 Agustus 1945 Semarang<br>
      FAKULTAS EKONOMI DAN BISNIS <br>
       UNIVERSITAS 17 AGUSTUS 1945 SEMARANG<br>
Jl. Pawiyatan Luhur Brendan Duwur, Semarang, Telp. (0274) 76421189, www.untagsmg.ac.id

                    </th>
                  </tr>                 
                </thead>

        </table>
        <br>
        <center>
            <h3><b>BUKTI TRANSAKSI</b></h3>
            <h5><b>NO: {{ Session::get('notrans') }}</b></h3><br/>
        </center>
        <table width="100%" border=1 cellpadding="5" cellspacing="0" style="text-align: left; font-size: 10px">
                <tr >
                    <th >No.Bukti</th>
                    <th >Tgl. Transaksi</th>
                    <th >Keterangan</th>
                    <th >jumlah</th>
                </tr>
                @foreach($jurnalumum ?? '' as $data)
                <tr >
                    <td width="5%">{{ $data->notrans }}</td>
                    <td width="10%">{{ $data->tgltrans }}</td>
                    <td width="65%">{{ $data->keterangan }}</td>
                    <td width="20%" style="text-align: right;">{{ number_format($data->jumlah) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td ></td>
                   <td colspan="3"> Terbilang:
                      
                      <b>
                      @php 
                        $terbilang =Trkeuangan::terbilang($data->jumlah,$style=3); 
                      @endphp
                      {{ $terbilang }} Rupiah
                    </b>
                    </td>
                    
                </tr>
            </table>
            <br>
           <table width="100%" border=0 cellpadding="5" cellspacing="0" style="text-align: left; font-size: 10px">
                <tr style="text-align: center;">
                   <td>
                    Semarang, {{ Carbon\Carbon::now() }}<br>
                    Bagian Keuangan:<br>
                   <br>
                   <br>
                  <br>
                    <label>....................</label>
                   </td>                   
                </tr>
        </table>

    </div>
