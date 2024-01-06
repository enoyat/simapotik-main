<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_detailpembelian;
use App\Models\M_dokter;
use App\Models\M_golongan;
use App\Models\M_pembelian;
use App\Models\M_penjualan;
use App\Models\M_detailpenjualan;

use Illuminate\Http\Request;

class LaporanGembong extends Controller
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
    public function rptpenjualan()
    {
        $golongan = M_golongan::get();
        $dokter = M_dokter::get();
        return view('laporantransaksi.rptgembong')->with(['golongan' => $golongan, 'dokter' => $dokter]);
    }
    public function laporanpenjualan(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        $tipepenjualan = $request->tipepenjualan;
        $kasir = $request->email;
        if ($tipepenjualan == "K") {
            // dd($kasir);
            if ($request->kriteria == "nofaktur") {
                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('jenispenjualan', 'N')
                    ->where('tipepenjualan', 'K')
                    ->where('idcustomer', "GBG")
                    ->get()
                    ->sortBy(function ($query) {
                        return $query->get_customer->namacustomer;
                    });
                return view('laporantransaksi.laporanpenjualan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Kredit']);
            } elseif ($request->kriteria == "golongan") {
                if ($request->idgolongan == "all") {
                    $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                        ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                        ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                        ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                        ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                        ->where('tipepenjualan', 'K')
                        ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'N')
                        ->where('penjualan.idcustomer', "GBG")
                        ->orderBy('namagolongan', 'asc')
                        ->get();
                       
                } else {
                    $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                        ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                        ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                        ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                        ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                        ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'N')
                        ->where('tipepenjualan', 'K')
                        ->where('barang.idgolongan', $request->idgolongan)
                        ->where('penjualan.idcustomer', "GBG")
                        ->orderBy('tgltrans', 'asc')
                        ->get();
                }
                return view('laporantransaksi.laporanpenjualanpergolongan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Kredit']);
            } else if ($request->kriteria == "kasir") {

                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('email', $request->email)
                    ->where('jenispenjualan', 'N')
                    ->where('tipepenjualan', 'K')
                    ->where('penjualan.idcustomer', "GBG")
                    ->get()
                    ->sortBy(function ($query) {
                        return $query->get_customer->namacustomer;
                    });

                return view('laporantransaksi.laporanpenjualan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Kredit']);
            }
        } else {
            // dd($kasir);
            if ($request->kriteria == "nofaktur") {
                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('jenispenjualan', 'N')
                    ->where('tipepenjualan', 'T')
                    ->where('penjualan.idcustomer', "GBG")
                    ->get()
                    ->sortBy(function ($query) {
                        return $query->get_customer->namacustomer;
                    });
                return view('laporantransaksi.laporanpenjualan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            } elseif ($request->kriteria == "golongan") {
                if ($request->idgolongan == "all") {
                    $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                        ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                        ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                        ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                        ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                        ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'N')
                        ->where('tipepenjualan', 'T')
                        ->where('penjualan.idcustomer', "GBG")
                        ->orderBy('namagolongan', 'asc')
                        ->get();
                      
                } else {
                    $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                        ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                        ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                        ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                        ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                        ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'N')
                        ->where('tipepenjualan', 'T')
                        ->where('barang.idgolongan', $request->idgolongan)
                        ->where('penjualan.idcustomer', "GBG")
                        ->orderBy('tgltrans', 'asc')
                        ->get();
                }
                return view('laporantransaksi.laporanpenjualanpergolongan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            } else if ($request->kriteria == "kasir") {

                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('email', $request->email)
                    ->where('jenispenjualan', 'N')
                    ->where('tipepenjualan', 'T')
                    ->where('penjualan.idcustomer', "GBG")
                    ->get()
                    ->sortBy(function ($query) {
                        return $query->get_customer->namacustomer;
                    });

                return view('laporantransaksi.laporanpenjualan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            }
        }
    }
}
