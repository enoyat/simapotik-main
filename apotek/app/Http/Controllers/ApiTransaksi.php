<?php

namespace App\Http\Controllers;

use App\Models\M_detailbayar;
use App\Models\M_detailpenjualan;
use App\Models\M_detailresep;
use App\Models\M_jurnalumum;
use App\Models\M_mstransaksi;
use App\Models\M_pendingdetailpenjualan;
use App\Models\M_pendingpenjualan;
use App\Models\M_penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTransaksi extends Controller
{
    public function getinvoice(Request $request){
        $iteminvoice = M_penjualan::where('id',$request->id)->get();
        return $data = [
            'status' => 'success',
            'data' => $iteminvoice,
        ];
    }
    public function detailinvoice(Request $request){
        $iteminvoice = M_detailpenjualan::join('barang','detailpenjualan.kdbarang','barang.kdbarang')->where('idpenjualan',$request->id)->
        select('detailpenjualan.*','barang.namabarang','barang.idgolongan')->get();
        return $data = [
            'status' => 'success',
            'data' => $iteminvoice,
        ];
    }
   
}

 
