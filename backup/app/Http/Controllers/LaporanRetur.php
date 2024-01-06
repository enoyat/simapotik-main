<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_detailpembelian;
use App\Models\M_dokter;
use App\Models\M_golongan;
use App\Models\M_pembelian;
use App\Models\M_penjualan;
use App\Models\M_detailpenjualan;
use App\Models\M_returdetailpembelian;
use App\Models\M_returdetailpenjualan;
use App\Models\M_returpembelian;
use Illuminate\Http\Request;

class LaporanRetur extends Controller
{
    public function getnamabulan($bulan)
    {
        switch ($bulan) {
            case ("01"):
                return "Januari";
                break;
            case ("02"):
                return "Februari";
                break;
            case ("03"):
                return "Maret";
                break;
            case ("04"):
                return "April";
                break;
            case ("05"):
                return "Mei";
                break;
            case ("06"):
                return "Juni";
                break;
            case ("07"):
                return "Juli";
                break;
            case ("08"):
                return "Agustus";
                break;
            case ("09"):
                return "September";
                break;
            case ("10"):
                return "Oktober";
                break;
            case ("11"):
                return "Nopember";
                break;
            case ("12"):
                return "Desember";
                break;
        }
    }
    public function rptreturpembelian()
    {
        $golongan = M_golongan::get();
        return view('laporantransaksi.returpembelian.rptreturpembelian')->with(['golongan' => $golongan]);;
    }
    public function laporanreturpembelian(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        if ($request->kriteria == "golongan") {
            if ($request->idgolongan == "all") {
                $datapembelian = M_returdetailpembelian::select('returdetailpembelian.*', 
                'detailpembelian.harga','detailpembelian.diskonpersen','barang.namabarang','golongan.namagolongan','supplier.namasupplier')
                    ->join('returpembelian', 'returdetailpembelian.idretur', '=', 'returpembelian.id')
                    ->join('detailpembelian', 'detailpembelian.id', '=', 'returdetailpembelian.iddetailpembelian')
                    ->join('barang', 'barang.kdbarang', '=', 'returdetailpembelian.kdbarang')
                    ->join('pembelian', 'pembelian.id', '=', 'detailpembelian.idpembelian')
                    ->join('supplier', 'supplier.idsupplier', '=', 'pembelian.idsupplier')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->whereBetween('returpembelian.tgltrans', [$tglmulai, $tglakhir])
                    ->orderBy('namagolongan', 'asc')
                    ->get();
                   
            } else {
                $datapembelian = M_returdetailpembelian::select('returdetailpembelian.*', 
                'detailpembelian.harga','detailpembelian.diskonpersen','barang.namabarang','golongan.namagolongan','supplier.namasupplier')
                    ->join('returpembelian', 'returdetailpembelian.idretur', '=', 'returpembelian.id')
                    ->join('detailpembelian', 'detailpembelian.id', '=', 'returdetailpembelian.iddetailpembelian')
                    ->join('barang', 'barang.kdbarang', '=', 'returdetailpembelian.kdbarang')
                    ->join('pembelian', 'pembelian.id', '=', 'detailpembelian.idpembelian')
                    ->join('supplier', 'supplier.idsupplier', '=', 'pembelian.idsupplier')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->whereBetween('returpembelian.tgltrans', [$tglmulai, $tglakhir])
                    ->where('barang.idgolongan', $request->idgolongan)
                    ->orderBy('namagolongan', 'asc')
                    ->get();
               

            }
            return view('laporantransaksi.returpembelian.laporanreturpembelianpergolongan')->with(['datapembelian' => $datapembelian, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
        }
    }

    public function rptreturpenjualan()
    {
        $golongan = M_golongan::get();
        return view('laporantransaksi.returpenjualan.rptreturpenjualan')->with(['golongan' => $golongan]);
    }
    public function laporanreturpenjualan(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        if ($request->kriteria == "golongan") {
            if ($request->idgolongan == "all") {
                $datapenjualan = M_returdetailpenjualan::select('returdetailpenjualan.*', 
                'detailpenjualan.harga','detailpenjualan.diskonpersen','barang.namabarang','golongan.namagolongan','customer.namacustomer')
                    ->join('returpenjualan', 'returdetailpenjualan.idretur', '=', 'returpenjualan.id')
                    ->join('detailpenjualan', 'detailpenjualan.id', '=', 'returdetailpenjualan.iddetailpenjualan')
                    ->join('barang', 'barang.kdbarang', '=', 'returdetailpenjualan.kdbarang')
                    ->join('penjualan', 'penjualan.id', '=', 'detailpenjualan.idpenjualan')
                    ->join('customer', 'customer.idcustomer', '=', 'penjualan.idcustomer')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->whereBetween('returpenjualan.tgltrans', [$tglmulai, $tglakhir])
                    ->orderBy('namagolongan', 'asc')
                    ->get();
                  
            } else {
                $datapenjualan = M_returdetailpenjualan::select('returdetailpenjualan.*', 
                'detailpenjualan.harga','detailpenjualan.diskonpersen','barang.namabarang','golongan.namagolongan','customer.namacustomer')
                    ->join('returpenjualan', 'returdetailpenjualan.idretur', '=', 'returpenjualan.id')
                    ->join('detailpenjualan', 'detailpenjualan.id', '=', 'returdetailpenjualan.iddetailpenjualan')
                    ->join('barang', 'barang.kdbarang', '=', 'returdetailpenjualan.kdbarang')
                    ->join('penjualan', 'penjualan.id', '=', 'detailpenjualan.idpenjualan')
                    ->join('customer', 'customer.idcustomer', '=', 'penjualan.idcustomer')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->whereBetween('returpenjualan.tgltrans', [$tglmulai, $tglakhir])
                    ->where('barang.idgolongan', $request->idgolongan)
                    ->orderBy('namagolongan', 'asc')
                    ->get();
              
               

            }
            return view('laporantransaksi.returpenjualan.laporanreturpenjualanpergolongan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
        } 
        if ($request->kriteria == "kasir") {
            $datapenjualan = M_returdetailpenjualan::select('returdetailpenjualan.*', 
            'detailpenjualan.harga','detailpenjualan.diskonpersen','barang.namabarang','golongan.namagolongan','customer.namacustomer')
                ->join('returpenjualan', 'returdetailpenjualan.idretur', '=', 'returpenjualan.id')
                ->join('detailpenjualan', 'detailpenjualan.id', '=', 'returdetailpenjualan.iddetailpenjualan')
                ->join('barang', 'barang.kdbarang', '=', 'returdetailpenjualan.kdbarang')
                ->join('penjualan', 'penjualan.id', '=', 'detailpenjualan.idpenjualan')
                ->join('customer', 'customer.idcustomer', '=', 'penjualan.idcustomer')
                ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                ->whereBetween('returpenjualan.tgltrans', [$tglmulai, $tglakhir])
                ->where('returpenjualan.email', $request->email)
                ->orderBy('namagolongan', 'asc')
                ->get();
                return view('laporantransaksi.returpenjualan.laporanreturpenjualanpergolongan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir,'email'=>$request->email]);

        }
        
    }
}