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

class LaporanTransaksi extends Controller
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
    public function rptpembelian()
    {
        $golongan = M_golongan::get();
        return view('laporantransaksi.rptpembelian')->with(['golongan' => $golongan]);
    }
    public function laporanpembelian(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        if ($request->kriteria == "nofaktur") {
            $datapembelian = M_pembelian::with('get_detailpembelian', 'get_supplier')
                ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                ->get()
                ->sortBy(function ($query) {
                    return $query->get_supplier->namasupplier;
                });
            return view('laporantransaksi.laporanpembelian')->with(['datapembelian' => $datapembelian, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
        } elseif ($request->kriteria == "namasupplier") {
            $datapembelian = M_pembelian::with('get_detailpembelian', 'get_supplier')
                ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                ->get()
                ->sortBy(function ($query) {
                    return $query->nofaktur;
                });
            return view('laporantransaksi.laporanpembelian')->with(['datapembelian' => $datapembelian, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
        } elseif ($request->kriteria == "golongan") {
            if ($request->idgolongan == "all") {
                $datapembelian = M_detailpembelian::select('*', 'detailpembelian.diskon', 'golongan.namagolongan')
                    ->join('pembelian', 'detailpembelian.idpembelian', '=', 'pembelian.id')
                    ->join('supplier', 'pembelian.idsupplier', '=', 'supplier.idsupplier')
                    ->join('barang', 'barang.kdbarang', '=', 'detailpembelian.kdbarang')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->whereBetween('pembelian.tgltrans', [$tglmulai, $tglakhir])
                    ->orderBy('namagolongan', 'asc')
                    ->get();
            } else {
                $datapembelian = M_detailpembelian::select('*', 'detailpembelian.diskon', 'golongan.namagolongan')
                    ->join('pembelian', 'detailpembelian.idpembelian', '=', 'pembelian.id')
                    ->join('supplier', 'pembelian.idsupplier', '=', 'supplier.idsupplier')
                    ->join('barang', 'barang.kdbarang', '=', 'detailpembelian.kdbarang')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->whereBetween('pembelian.tgltrans', [$tglmulai, $tglakhir])
                    ->where('barang.idgolongan', $request->idgolongan)
                    ->orderBy('tgltrans', 'asc')
                    ->get();
            }
            return view('laporantransaksi.laporanpembelianpergolongan')->with(['datapembelian' => $datapembelian, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
        }
    }

    public function rptpenjualan()
    {
        $golongan = M_golongan::get();
        $dokter = M_dokter::get();
        return view('laporantransaksi.rptpenjualan')->with(['golongan' => $golongan, 'dokter' => $dokter]);
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
                    ->where('penjualan.idcustomer', "!=", "GBG")
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
                        ->where('penjualan.idcustomer', "!=", "GBG")
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
                        ->where('penjualan.idcustomer', "!=", "GBG")
                        ->orderBy('tgltrans', 'asc')
                        ->get();
                }
                return view('laporantransaksi.laporanpenjualanpergolongan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Kredit']);
            } elseif ($request->kriteria == "barang") {
                $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                    ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                    ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                    ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                    ->where('jenispenjualan', 'N')
                    ->where('tipepenjualan', 'K')
                    ->where('penjualan.idcustomer', "!=", "GBG")
                    ->where('barang.kdbarang', $request->kdbarang)
                    ->orderBy('tgltrans', 'asc')
                    ->get();
                return view('laporantransaksi.laporanpenjualanpergolongan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            } else if ($request->kriteria == "kasir") {

                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('email', $request->email)
                    ->where('jenispenjualan', 'N')
                    ->where('tipepenjualan', 'K')
                    ->where('penjualan.idcustomer', "!=", "GBG")
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
                    ->where('penjualan.idcustomer', "!=", "GBG")
                    ->where('penjualan.idcustomer', "!=", "C0012")
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
                        ->where('penjualan.idcustomer', "!=", "GBG")
                        ->where('penjualan.idcustomer', "!=", "C0012")
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
                        ->where('penjualan.idcustomer', "!=", "GBG")
                        ->where('penjualan.idcustomer', "!=", "C0012")
                        ->where('barang.idgolongan', $request->idgolongan)
                        ->orderBy('tgltrans', 'asc')
                        ->get();
                }
                return view('laporantransaksi.laporanpenjualanpergolongan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            } elseif ($request->kriteria == "barang") {
                $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                    ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                    ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                    ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                    ->where('jenispenjualan', 'N')
                    ->where('tipepenjualan', 'T')
                    ->where('penjualan.idcustomer', "!=", "GBG")
                    ->where('penjualan.idcustomer', "!=", "C0012")
                    ->where('barang.kdbarang', $request->kdbarang)
                    ->orderBy('tgltrans', 'asc')
                    ->get();
                return view('laporantransaksi.laporanpenjualanpergolongan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            } else if ($request->kriteria == "kasir") {

                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('email', $request->email)
                    ->where('jenispenjualan', 'N')
                    ->where('tipepenjualan', 'T')
                    ->where('penjualan.idcustomer', "!=", "GBG")
                    ->where('penjualan.idcustomer', "!=", "C0012")
                    ->get()
                    ->sortBy(function ($query) {
                        return $query->get_customer->namacustomer;
                    });

                return view('laporantransaksi.laporanpenjualan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            }
        }
    }
    public function rptpenjualanresep()
    {
        $golongan = M_golongan::get();
        $dokter = M_dokter::get();
        return view('laporantransaksi.rptpenjualanresep')->with(['golongan' => $golongan, 'dokter' => $dokter]);
    }
    public function laporanpenjualanresep(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        $kasir = $request->email;
        $tipepenjualan = $request->tipepenjualan;
        // dd($kasir);
        if ($tipepenjualan == "K") {
            if ($request->kriteria == "nofaktur") {
                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer', 'get_detailresep')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('jenispenjualan', 'R')
                    ->get()
                    ->sortBy(function ($query) {
                        return $query->get_customer->namacustomer;
                    });
                return view('laporantransaksi.laporanpenjualanresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
            } elseif ($request->kriteria == "golongan") {
                if ($request->idgolongan == "all") {
                    $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                        ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                        ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                        ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                        ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                        ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'R')
                        ->where('tipepenjualan', 'K')
                        ->orderBy('namagolongan', 'asc')
                        ->get();
                } else {
                    $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                        ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                        ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                        ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                        ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                        ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                        ->where('barang.idgolongan', $request->idgolongan)
                        ->where('jenispenjualan', 'R')
                        ->where('tipepenjualan', 'K')
                        ->orderBy('tgltrans', 'asc')
                        ->get();
                }
                return view('laporantransaksi.laporanpenjualanpergolonganresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Kredit']);
            } else if ($request->kriteria == "kasir") {

                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer', 'get_detailresep')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('email', $request->email)
                    ->where('jenispenjualan', 'R')

                    ->get()
                    ->sortBy(function ($query) {
                        return $query->get_customer->namacustomer;
                    });

                return view('laporantransaksi.laporanpenjualanresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Kredit']);
            } else if ($request->kriteria == "dokter") {

                if ($request->iddokter == "all") {
                    $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer', 'get_detailresep')
                        ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'R')
                        ->where('tipepenjualan', 'K')
                        ->get()
                        ->sortBy(function ($query) {
                            return $query->namadokter;
                        });

                    return view('laporantransaksi.laporanpenjualanresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Kredit']);
                } else {

                    $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer')
                        ->with(['get_detailresep' => function ($query) use ($request) {
                            $query->where('iddokter', $request->iddokter);
                        }])
                        ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'R')
                        ->where('tipepenjualan', 'K')
                        ->get()
                        ->sortBy(function ($query) {
                            return $query->namadokter;
                        });

                    return view('laporantransaksi.laporanpenjualanresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Kredit']);
                }
            }
            
        } else {
            if ($request->kriteria == "nofaktur") {
                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer', 'get_detailresep')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('jenispenjualan', 'R')
                    ->where('tipepenjualan', 'T')
                    ->get()
                    ->sortBy(function ($query) {
                        return $query->get_customer->namacustomer;
                    });
                return view('laporantransaksi.laporanpenjualanresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            } elseif ($request->kriteria == "golongan") {
                if ($request->idgolongan == "all") {
                    $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                        ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                        ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                        ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                        ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                        ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'R')
                        ->where('tipepenjualan', 'T')
                        ->orderBy('namagolongan', 'asc')
                        ->get();
                } else {
                    $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                        ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                        ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                        ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                        ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                        ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                        ->where('barang.idgolongan', $request->idgolongan)
                        ->where('jenispenjualan', 'R')
                        ->where('tipepenjualan', 'T')
                        ->orderBy('tgltrans', 'asc')
                        ->get();
                }
                return view('laporantransaksi.laporanpenjualanpergolonganresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            } else if ($request->kriteria == "kasir") {

                $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer', 'get_detailresep')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('email', $request->email)
                    ->where('jenispenjualan', 'R')
                    ->where('tipepenjualan', 'T')
                    ->get()
                    ->sortBy(function ($query) {
                        return $query->get_customer->namacustomer;
                    });

                return view('laporantransaksi.laporanpenjualanresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
            } else if ($request->kriteria == "dokter") {

                if ($request->iddokter == "all") {
                    $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer', 'get_detailresep')
                        ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'R')
                        ->where('tipepenjualan', 'T')
                        ->get()
                        ->sortBy(function ($query) {
                            return $query->namadokter;
                        });

                    return view('laporantransaksi.laporanpenjualanresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
                } else {
                    // $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                    // ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                    // ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                    // ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                    // ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    // ->join('detailresep', 'detailresep.idpenjualan', '=', 'penjualan.id')
                    // ->where('jenispenjualan', 'R')
                    // ->where('tipepenjualan', 'T')                   
                    // ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])     
                    // ->where('detailresep.iddokter', $request->iddokter)           
                    // ->orderBy('tgltrans', 'asc')
                    // ->get();
                    $datapenjualan = M_penjualan::with('get_detailpenjualan', 'get_customer', 'get_detailresep')
                    ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
                    ->where('jenispenjualan', 'R')
                    ->where('tipepenjualan', 'T')
                    ->whereHas('get_detailresep', function ($query) use ($request) {
                        $query->where('iddokter', $request->iddokter);
                    })
                    ->get()
                    ->sortBy(function ($query) {
                        return $query->namadokter;
                    });

                    
                   
                    return view('laporantransaksi.laporanpenjualanresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
                }
            }
            else if ($request->kriteria == "barang") {

                $datapenjualan = M_detailpenjualan::select('*', 'detailpenjualan.diskon', 'golongan.namagolongan')
                        ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                        ->join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                        ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                        ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                        ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
                        ->where('jenispenjualan', 'R')
                        ->where('tipepenjualan', 'T')
                        ->where('barang.kdbarang', $request->kdbarang)
                        ->orderBy('tgltrans', 'asc')
                        ->get();
                   
                    return view('laporantransaksi.laporanpenjualanpergolonganresep')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir, 'tipepenjualan' => 'Tunai/Lunas']);
                
            }
        }
    }
    public function rptlabarugi()
    {
        return view('laporantransaksi.rptlabarugi');
    }
    public function laporanlabarugi(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        $datapenjualan = M_penjualan::select('*', 'detailpenjualan.diskon as diskpenjualan')
            ->join('customer', 'customer.idcustomer', '=', 'penjualan.idcustomer')
            ->join('detailpenjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
            ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
            ->join('golongan', 'golongan.idgolongan', '=', 'barang.idgolongan')
            ->whereBetween('penjualan.tgltrans', [$tglmulai, $tglakhir])
            ->where('tipepenjualan', 'T')
            ->orderBy('namagolongan', 'asc')
            ->get();

        return view('laporantransaksi.laporanlabarugi')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }
    public function rptstok()
    {
        $barang = M_barang::with('jmlstok')->limit(30)->get();
        return view('laporantransaksi.rptstok')->with(['barang' => $barang]);
    }
    public function laporanstok(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        // $datastok = M_barang::select('*','stok.idlokasi','stok.stok')
        //     ->join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')
        //     ->orderBy('barang.namabarang', 'asc')
        //     ->get();
        $datastok = M_barang::with('jmlstok')->orderby('namabarang')->get();

        return view('laporantransaksi.laporanstok')->with(['datastok' => $datastok, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }
    public function fetch(Request $request)
    {

        $barang = M_barang::with('jmlstok')->where('namabarang', 'like', '%' . $request->namabarang . '%')->get();
        return view('laporantransaksi.fetch', ['barang' => $barang]);
        //
    }
    public function rptpersediaan()
    {
        $golongan = M_golongan::get();
        return view('laporantransaksi.rptpersediaan')->with(['golongan' => $golongan]);
    }
    public function laporanpersediaan(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        if ($request->kriteria == "golongan") {
            if ($request->idgolongan == "all") {
                $datastok = M_barang::select('*', 'golongan.namagolongan')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->orderBy('namagolongan', 'asc')
                    ->get();
            } else {
                $datastok = M_barang::select('*', 'golongan.namagolongan')
                    ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                    ->where('barang.idgolongan', $request->idgolongan)
                    ->orderBy('namabarang', 'asc')
                    ->get();
            }
            return view('laporantransaksi.laporanpersediaanpergolongan')->with(['datastok' => $datastok, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
        }
    }
    public function rptrekappenjualan()
    {

        $golongan = M_golongan::get();
        return view('laporantransaksi.rptrekappenjualan', compact('golongan'));
    }
    public function laporanrekappenjualan(Request $request)
    {
        $golongan = M_golongan::get();
        $datapenjualan = array();
        foreach ($golongan as $key => $value) {
            $hv = M_detailpenjualan::select(DB::raw("SUM(jumlah) as jumlah"), 'barang.idgolongan', 'namagolongan')
                ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                ->whereBetween('penjualan.tgltrans', [$request->tglmulai, $request->tglakhir])
                ->where('barang.idgolongan', $value->idgolongan)
                ->where('penjualan.jenispenjualan',"N")
                ->groupby('barang.idgolongan', 'namagolongan')
                ->get();
                $resep = M_detailpenjualan::select(DB::raw("SUM(jumlah) as jumlah"), 'barang.idgolongan', 'namagolongan')
                ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
                ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
                ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                ->whereBetween('penjualan.tgltrans', [$request->tglmulai, $request->tglakhir])
                ->where('barang.idgolongan', $value->idgolongan)
                ->where('penjualan.jenispenjualan',"R")
                ->groupby('barang.idgolongan', 'namagolongan')
                ->get();
                $retur = M_returdetailpenjualan::select(DB::raw("SUM(jumlah) as jumlah"), 'barang.idgolongan', 'namagolongan')
                ->join('detailpenjualan', 'detailpenjualan.id', '=', 'returdetailpenjualan.iddetailpenjualan')
                ->join('returpenjualan', 'returdetailpenjualan.idretur', '=', 'returpenjualan.id')
                ->join('barang', 'barang.kdbarang', '=', 'returdetailpenjualan.kdbarang')
                ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
                ->whereBetween('returpenjualan.tgltrans', [$request->tglmulai, $request->tglakhir])
                ->where('barang.idgolongan', $value->idgolongan)
                ->groupby('barang.idgolongan', 'namagolongan')
                ->get();
            
            $datapenjualan[]=[
                'idgolongan'=>$value->idgolongan,
                'namagolongan'=>$value->namagolongan,
                'jumlah'=>$hv[0]->jumlah,
                'jumlahresep'=>$resep[0]->jumlah,  
                'jumlahretur'=>$retur[0]->jumlah,              
            ];
            // $transkrip[] = Transkrip::where([
            //     ['idgolongan', $request->nim],
            //     ['kdkmk', $value->kdkmk],
            //     ['kdpst', $session_get_kdpst],
            // ])->first();
        }
        
        // $datapenjualan = M_detailpenjualan::select(DB::raw("SUM(jumlah) as jumlah"), 'barang.idgolongan', 'namagolongan')
        //     ->join('penjualan', 'detailpenjualan.idpenjualan', '=', 'penjualan.id')
        //     ->join('barang', 'barang.kdbarang', '=', 'detailpenjualan.kdbarang')
        //     ->join('golongan', 'barang.idgolongan', '=', 'golongan.idgolongan')
        //     ->whereBetween('penjualan.tgltrans', [$request->tglmulai, $request->tglakhir])
        //     ->groupby('barang.idgolongan', 'namagolongan')
        //     ->orderBy('namagolongan', 'asc')
        //     ->get();
        //  dd($datapenjualan);
        return view('laporantransaksi.laporanrekappenjualan')->with(['datapenjualan' => $datapenjualan, 'tglmulai' => $request->tglmulai, 'tglakhir' => $request->tglakhir]);

    }

}
