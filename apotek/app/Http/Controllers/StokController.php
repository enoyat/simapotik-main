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

        // $datastok = M_barang::query()
        //     ->select('*', 'golongan.namagolongan')
        //     ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
        //     ->where('barang.kdbarang', $request->kdbarang)
        //     ->addSelect(DB::raw('(SELECT sum(qty) as jmlout FROM detailpenjualan WHERE detailpenjualan.kdbarang = barang.kdbarang ) as jmlpenjualan'))
        //     ->addSelect(DB::raw('(SELECT sum(qty) as jmlreturout FROM returdetailpenjualan WHERE returdetailpenjualan.kdbarang = barang.kdbarang ) as jmlreturpenjualan'))
        //     ->addSelect(DB::raw('(SELECT sum(qty) as jmlin FROM detailpembelian  WHERE detailpembelian.kdbarang = barang.kdbarang ) as jmlpembelian'))
        //     ->addSelect(DB::raw('(SELECT sum(qty) as jmlreturin FROM returdetailpembelian  WHERE returdetailpembelian.kdbarang = barang.kdbarang ) as jmlreturpembelian'))
        //     ->addSelect(DB::raw('(SELECT sum(qty) as jmlmutasi FROM detailmutasi  WHERE detailmutasi.kdbarang = barang.kdbarang ) as jmladjustmutasi'))
        //     ->get();
        $datastok = "SELECT *
FROM
(
    /* PEMBELIAN */
   SELECT
        pb.tgltrans,
        pb.id,
        'Pembelian' jenis_transaksi,
        s.namasupplier lokasi_asal,
        g.namalokasi gudang_tujuan,
        d.qty masuk,
        0 keluar,
        d.kdbarang,
      	d.idlokasi,

        pb.email,
        TIME(pb.tgltrans) jam
    FROM detailpembelian d
    JOIN pembelian pb
        ON pb.id=d.idpembelian
    JOIN supplier s
        ON s.idsupplier=pb.idsupplier
    JOIN stoklokasi g
        ON g.idlokasi=d.idlokasi

UNION ALL

    /* PENJUALAN */

   SELECT
        pj.tgltrans,
        pj.id,
        'Penjualan',
        g.namalokasi,
        pj.modebayar,
        0,
        d.qty,
        d.kdbarang,
        'TOKO',
        pj.email,
        pj.jam

    FROM detailpenjualan d
    JOIN penjualan pj
        ON pj.id=d.idpenjualan
    JOIN stoklokasi g
        ON g.idlokasi=d.idlokasi
UNION ALL

    /* MUTASI KELUAR */
SELECT
        m.tglmutasi,
        m.id,
        'Mutasi Keluar',
        ga.namalokasi gudanga,
        gt.namalokasi gudangt,
        0,
        m.qty,
        m.kdbarang,
        m.idlokasi,

        m.email,
        TIME(m.tglmutasi)

    FROM detailmutasi m
    JOIN stoklokasi ga
        ON ga.idlokasi=m.idlokasi
    JOIN stoklokasi gt
        ON gt.idlokasi=m.idlokasidest

    UNION ALL
    SELECT
        a.tanggal,
        a.id,
        'Adjustment',
        a.keterangan,
        a.stoksistem,
        a.stokfisik,
        a.selisih,
         a.kdbarang,
          a.idlokasi,
        a.email,
        TIME(a.created_at)

    FROM stokopname a
    JOIN stoklokasi g
        ON g.idlokasi=a.idlokasi


) kartu
WHERE kdbarang = ?
AND idlokasi = ?
ORDER BY tanggal,jam,id;";


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
