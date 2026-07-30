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
use App\Models\M_stoklokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index()
    {
        $lokasi = M_stoklokasi::get();
        return view('kartustok.index', compact('lokasi'));
    }
    public function laporankartustok(Request $request)
    {

        $request->validate([
            'kdbarang' => 'required',
            'idlokasi' => 'required'
        ]);

        $sql = "SELECT
    kartu.*,
    l.namalokasi,
    SUM(masuk - keluar) OVER (
        PARTITION BY kartu.kdbarang, kartu.idlokasi
        ORDER BY kartu.tgltrans, kartu.jam, kartu.id
        ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
    ) AS saldo
FROM
(
    /* PEMBELIAN */
    SELECT
        pb.tgltrans,
        pb.id,
        'Pembelian' AS jenis_transaksi,
        s.namasupplier AS lokasi_asal,
        g.namalokasi AS gudang_tujuan,
        d.qty AS masuk,
        0 AS keluar,
        d.kdbarang,
        d.idlokasi,
        pb.email,
        TIME(pb.created_at) AS jam
    FROM detailpembelian d
    JOIN pembelian pb ON pb.id=d.idpembelian
    JOIN supplier s ON s.idsupplier=pb.idsupplier
    JOIN stoklokasi g ON g.idlokasi=d.idlokasi

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
        d.idlokasi,
        pj.email,
        pj.jam
    FROM detailpenjualan d
    JOIN penjualan pj ON pj.id=d.idpenjualan
    JOIN stoklokasi g ON g.idlokasi=d.idlokasi

    UNION ALL

    /* MUTASI KELUAR */
    SELECT
        m.tglmutasi,
        m.id,
        'Mutasi Keluar',
        ga.namalokasi,
        gt.namalokasi,
        0,
        m.qty,
        m.kdbarang,
        m.idlokasi,
        m.email,
        TIME(m.created_at)
    FROM detailmutasi m
    JOIN stoklokasi ga ON ga.idlokasi=m.idlokasi
    JOIN stoklokasi gt ON gt.idlokasi=m.idlokasidest

    UNION ALL

    /* MUTASI MASUK */
    SELECT
        m.tglmutasi,
        m.id,
        'Mutasi Masuk',
        ga.namalokasi,
        gt.namalokasi,
        m.qty,
        0,
        m.kdbarang,
        m.idlokasidest,
        m.email,
        TIME(m.created_at)
    FROM detailmutasi m
    JOIN stoklokasi ga ON ga.idlokasi=m.idlokasi
    JOIN stoklokasi gt ON gt.idlokasi=m.idlokasidest

    UNION ALL

    /* ADJUSTMENT */
    SELECT
        a.tanggal,
        a.id,
        'Adjustment',
        ga.namalokasi,
        a.keterangan,
        CASE WHEN a.selisih>0 THEN a.selisih ELSE 0 END,
        CASE WHEN a.selisih<0 THEN ABS(a.selisih) ELSE 0 END,
        a.kdbarang,
        a.idlokasi,
        a.email,
        TIME(a.created_at)
    FROM stokopname a
    JOIN stoklokasi ga ON ga.idlokasi=a.idlokasi

    UNION ALL

    /* RETUR PEMBELIAN */
    SELECT
        r.tgltrans,
        r.id,
        'Retur Pembelian',
        s.namasupplier,
        g.namalokasi,
        d.qtykembali,
        d.qty,
        d.kdbarang,
        d.idlokasi,
        r.email,
        TIME(r.tgltrans)
    FROM returdetailpembelian d
    JOIN returpembelian r ON r.id=d.idretur
    JOIN detailpembelian dp ON dp.id=d.iddetailpembelian
    JOIN pembelian pb ON pb.id=dp.idpembelian
    JOIN supplier s ON s.idsupplier=pb.idsupplier
    JOIN stoklokasi g ON g.idlokasi=d.idlokasi

    UNION ALL

    /* RETUR PENJUALAN */
    SELECT
        r.tgltrans,
        r.id,
        'Retur Penjualan',
        c.namacustomer,
        g.namalokasi,
        d.qty,
        0,
        d.kdbarang,
        d.idlokasi,
        r.email,
        TIME(r.tgltrans)
    FROM returdetailpenjualan d
    JOIN returpenjualan r ON r.id=d.idretur
    JOIN detailpenjualan dp ON dp.id=d.iddetailpenjualan
    JOIN penjualan pb ON pb.id=dp.idpenjualan
    JOIN customer c ON c.idcustomer=pb.idcustomer
    JOIN stoklokasi g ON g.idlokasi=d.idlokasi

) kartu
JOIN stoklokasi l
    ON l.idlokasi = kartu.idlokasi
WHERE
    kartu.kdbarang = ?
    AND (? = 'all' OR kartu.idlokasi = ?)
ORDER BY
    kartu.idlokasi,
    kartu.tgltrans,
    kartu.jam,
    kartu.id;";
        $datastok = DB::select($sql, [
            $request->kdbarang,
            $request->idlokasi,
            $request->idlokasi,
        ]);

        return view('kartustok.laporankartustok', [
            'datastok' => $datastok,
            'kdbarang' => $request->kdbarang,
            'idlokasi' => $request->idlokasi
        ]);
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
