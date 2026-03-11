<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_detailmutasi;
use App\Models\M_detailpembelian;
use App\Models\M_detailpenjualan;
use App\Models\M_dokter;
use App\Models\M_golongan;
use App\Models\M_pembelian;
use App\Models\M_penjualan;
use App\Models\M_returdetailpembelian;
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
            ->where('barang.kdbarang', $request->kdbarang)
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlout FROM detailpenjualan WHERE detailpenjualan.kdbarang = barang.kdbarang ) as jmlpenjualan'))
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlreturout FROM returdetailpenjualan WHERE returdetailpenjualan.kdbarang = barang.kdbarang ) as jmlreturpenjualan'))
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlin FROM detailpembelian  WHERE detailpembelian.kdbarang = barang.kdbarang ) as jmlpembelian'))
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlreturin FROM returdetailpembelian  WHERE returdetailpembelian.kdbarang = barang.kdbarang ) as jmlreturpembelian'))
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlmutasi FROM detailmutasi  WHERE detailmutasi.kdbarang = barang.kdbarang ) as jmladjustmutasi'))
            ->get();
        return view('kartustok.laporankartustok')->with(['datastok' => $datastok, 'tglawal' => $tglawal, 'tglakhir' => $tglakhir]);
    }
    public function detail(Request $request)
    {

        $kdtransaksi = $request->kdtransaksi;
        if ($kdtransaksi == "pembelian") {
            $datastok = M_detailpembelian::query()
                ->select('*', 'pembelian.tgltrans')
                ->join('pembelian', 'detailpembelian.idpembelian', '=', 'pembelian.id')
                ->join('barang', 'detailpembelian.kdbarang', '=', 'barang.kdbarang')
                ->where('barang.kdbarang', $request->kdbarang)
                ->orderby('pembelian.tgltrans', 'asc')
                ->get();
        } elseif ($kdtransaksi == "returpembelian") {
            $datastok = M_returdetailpembelian::query()
                ->select('*',)
                ->join('barang', 'returdetailpembelian.kdbarang', '=', 'barang.kdbarang')
                ->join('returpembelian', 'returdetailpembelian.idretur', '=', 'returpembelian.id')
                ->where('returdetailpembelian.kdbarang', $request->kdbarang)
                ->get();
        } elseif ($kdtransaksi == "penjualan") {
            $datastok = M_detailpenjualan::query()
                ->select('*', 'penjualan.tgltrans')
                ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                ->join('barang', 'detailpenjualan.kdbarang', '=', 'barang.kdbarang')
                ->where('barang.kdbarang', $request->kdbarang)
                ->orderby('penjualan.tgltrans', 'asc')
                ->get();
        } elseif ($kdtransaksi == "returpenjualan") {
            $datastok = M_returdetailpenjualan::query()
                ->select('*',)
                ->join('barang', 'returdetailpenjualan.kdbarang', '=', 'barang.kdbarang')
                ->join('returpenjualan', 'returdetailpenjualan.idretur', '=', 'returpenjualan.id')
                ->where('returdetailpenjualan.kdbarang', $request->kdbarang)
                ->get();
        } elseif ($kdtransaksi == "adjustmutasi") {
            $datastok = M_detailmutasi::query()
                ->select('*',)
                ->join('barang', 'detailmutasi.kdbarang', '=', 'barang.kdbarang')
                ->where('detailmutasi.kdbarang', $request->kdbarang)
                ->get();
        }
        return view('kartustok.detail')->with(['datastok' => $datastok, 'kdtransaksi' => $kdtransaksi]);
    }
}
