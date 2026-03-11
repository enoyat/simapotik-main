<?php
namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use App\Models\MTrstokopname;
use App\Models\M_barang;
use App\Models\M_hsdetailmutasi;
use App\Models\M_hsdetailpembelian;
use App\Models\M_hsdetailpenjualan;
use App\Models\M_hsreturdetailpembelian;
use App\Models\M_hsreturdetailpenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HsStokController extends Controller
{
    public function index()
    {
        $periode = MTrstokopname::get();
        return view('history.kartustok.index', ['periode' => $periode]);
    }
    public function laporankartustok(Request $request)
    {
        $tglawal  = $request->tglawal;
        $tglakhir = $request->tglakhir;
        DB::statement("SET SQL_MODE=''");

        $datastok = M_barang::query()
            ->select('*', 'golongan.namagolongan')
            ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
            ->where('barang.kdbarang', $request->kdbarang)
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlout FROM hsdetailpenjualan WHERE hsdetailpenjualan.kdbarang = barang.kdbarang and hsdetailpenjualan.kodeopname=' . $request->kodeopname . ' ) as jmlpenjualan'))
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlreturout FROM hsreturdetailpenjualan WHERE hsreturdetailpenjualan.kdbarang = barang.kdbarang and kodeopname=' . $request->kodeopname . ') as jmlreturpenjualan'))
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlin FROM hsdetailpembelian  WHERE hsdetailpembelian.kdbarang = barang.kdbarang and kodeopname=' . $request->kodeopname . ') as jmlpembelian'))
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlreturin FROM hsreturdetailpembelian  WHERE hsreturdetailpembelian.kdbarang = barang.kdbarang and kodeopname=' . $request->kodeopname . ') as jmlreturpembelian'))
            ->addSelect(DB::raw('(SELECT sum(qty) as jmlmutasi FROM hsdetailmutasi  WHERE hsdetailmutasi.kdbarang = barang.kdbarang and kodeopname=' . $request->kodeopname . ' ) as jmladjustmutasi'))
            ->get();
        return view('history.kartustok.laporankartustok')->with(['datastok' => $datastok, 'tglawal' => $tglawal, 'tglakhir' => $tglakhir]);
    }
    public function detail(Request $request)
    {

        $kdtransaksi = $request->kdtransaksi;
        if ($kdtransaksi == "pembelian") {
            $datastok = M_hsdetailpembelian::query()
                ->select('*', 'hspembelian.tgltrans')
                ->join('hspembelian', 'hsdetailpembelian.idhspembelian', '=', 'hspembelian.idhspembelian')
                ->join('barang', 'hsdetailpembelian.kdbarang', '=', 'barang.kdbarang')
                ->where('barang.kdbarang', $request->kdbarang)
                ->orderby('hspembelian.tgltrans', 'asc')
                ->get();
        } elseif ($kdtransaksi == "returpembelian") {
            $datastok = M_hsreturdetailpembelian::query()
                ->select('*', 'hsreturpembelian.tgltrans')
                ->join('hsreturpembelian', 'hsreturdetailpembelian.idretur', '=', 'hsreturpembelian.idhsretur')
                ->join('barang', 'hsreturdetailpembelian.kdbarang', '=', 'barang.kdbarang')
                ->join('returpembelian', 'hsreturdetailpembelian.idretur', '=', 'returpembelian.id')
                ->where('hsreturdetailpembelian.kdbarang', $request->kdbarang)
                ->get();
        } elseif ($kdtransaksi == "penjualan") {

            $datastok = M_hsdetailpenjualan::query()
                ->select('*', 'hspenjualan.tgltrans')
                ->join('hspenjualan', 'hsdetailpenjualan.idhspenjualan', '=', 'hspenjualan.idhspenjualan')
                ->join('barang', 'hsdetailpenjualan.kdbarang', '=', 'barang.kdbarang')
                ->where('barang.kdbarang', $request->kdbarang)
                ->orderby('hspenjualan.tgltrans', 'asc')
                ->get();
        } elseif ($kdtransaksi == "returpenjualan") {

            $datastok = M_hsreturdetailpenjualan::query()
                ->select('*', )
                ->join('barang', 'hsreturdetailpenjualan.kdbarang', '=', 'barang.kdbarang')
                ->join('hsreturpenjualan', 'hsreturdetailpenjualan.idhsreturpenjualan', '=', 'hsreturpenjualan.idhsreturpenjualan')
                ->where('hsreturdetailpenjualan.kdbarang', $request->kdbarang)
                ->get();
        } elseif ($kdtransaksi == "adjustmutasi") {
            $datastok = M_hsdetailmutasi::query()
                ->select('*', )
                ->join('barang', 'hsdetailmutasi.kdbarang', '=', 'barang.kdbarang')
                ->where('hsdetailmutasi.kdbarang', $request->kdbarang)
                ->get();
        }
        return view('history.kartustok.detail')->with(['datastok' => $datastok, 'kdtransaksi' => $kdtransaksi]);
    }
}
