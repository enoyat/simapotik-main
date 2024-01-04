<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_detailpembelian;
use App\Models\M_detailpenjualan;
use App\Models\M_dokter;
use App\Models\M_golongan;
use App\Models\M_pembelian;
use App\Models\M_penjualan;
use App\Models\M_returdetailpenjualan;
use DB;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        return view('kartustok.index');
    }
    public function laporankartustok(Request $request)
    {
        $tglawal = $request->tglawal;
        $tglakhir = $request->tglakhir;
        DB::statement("SET SQL_MODE=''");

            $datastok = M_barang::query()
                ->select('*', 'golongan.namagolongan')
                ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                ->where('barang.kdbarang',$request->kdbarang)
                ->addSelect(DB::raw('(SELECT sum(qty) as jmlout FROM detailpenjualan WHERE detailpenjualan.kdbarang = barang.kdbarang ) as jmlpenjualan'))
                ->addSelect(DB::raw('(SELECT sum(qty) as jmlreturout FROM returdetailpenjualan WHERE returdetailpenjualan.kdbarang = barang.kdbarang ) as jmlreturpenjualan'))
                ->addSelect(DB::raw('(SELECT sum(qty) as jmlin FROM detailpembelian  WHERE detailpembelian.kdbarang = barang.kdbarang ) as jmlpembelian'))
                ->addSelect(DB::raw('(SELECT sum(qty) as jmlreturin FROM returdetailpembelian  WHERE returdetailpembelian.kdbarang = barang.kdbarang ) as jmlreturpembelian'))
                ->get();
        return view('kartustok.laporankartustok')->with(['datastok' => $datastok, 'tglawal' => $tglawal, 'tglakhir' => $tglakhir]);
    }
}
