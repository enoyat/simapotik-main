<?php

namespace App\Http\Controllers;

use App\Models\M_akun;
use App\Models\M_jurnalpembayaran;
use App\Models\M_jurnalpenyesuaian;
use App\Models\M_jurnaltagihan;
use App\Models\M_jurnalumum;
use App\Models\M_lapjurnal;
use App\Models\M_lapjurnalpenyesuaian;
use App\Models\M_laporankeuangan;
use App\Models\M_msjurnal;
use App\Models\M_neracasaldo;
use App\Models\M_neracasaldopenyesuaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Laporan extends Controller
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
    public function rptneracasaldo()
    {
        return view('laporan.rptneracasaldo');
    }
    public function neracasaldo(Request $request)
    {
        $bulan = $request->bulan;
        $namabulan = Laporan::getnamabulan($bulan);
        $tahun = $request->tahun;
        $kdperiode = $bulan . $tahun;
        $msakuns = M_akun::where(['f_neraca' => '1', 'kdpst' => Session::get('globalkdpst')])->get();
        foreach ($msakuns as $key) {
            $typeakun = $key->typeakun;
            $kdakun = $key->kdakun;
            $debet = M_lapjurnal::where('kdakun', $kdakun)
                ->whereMonth('tgltrans', $bulan)
                ->where('kdpst', Session::get('globalkdpst'))
                ->whereYear('tgltrans', $tahun)
                ->sum('debet');
            $kredit = M_lapjurnal::where('kdakun', $kdakun)
                ->whereMonth('tgltrans', $bulan)
                ->whereYear('tgltrans', $tahun)
                ->where('kdpst', Session::get('globalkdpst'))
                ->sum('kredit');

            if ($typeakun == 'D') {
                $saldo = $debet - $kredit;

            } else if ($typeakun == 'K') {
                $saldo = $kredit - $debet;

            }
            $cek = M_neracasaldo::where(['kdperiode' => $kdperiode, 'kdakun' => $kdakun, 'kdpst' => Session::get('globalkdpst')])->get();
            if (count($cek) < 1) {
                $neraca = new M_neracasaldo;
                $neraca->kdperiode = $kdperiode;
                $neraca->kdpst = Session::get('globalkdpst');
                $neraca->kdakun = $kdakun;
                if ($typeakun == 'D') {
                    $neraca->debet = $saldo;
                    // $neraca->kredit=0;

                } else if ($typeakun == 'K') {
                    $neraca->kredit = $saldo;
                    // $neraca->debet=0;

                }
                $neraca->save();
            } else {
                if ($typeakun == 'D') {
                    M_neracasaldo::where(['kdperiode' => $kdperiode, 'kdakun' => $kdakun, 'kdpst' => Session::get('globalkdpst')])->update(['debet' => $saldo]);

                } else if ($typeakun == 'K') {
                    M_neracasaldo::where(['kdperiode' => $kdperiode, 'kdakun' => $kdakun, 'kdpst' => Session::get('globalkdpst')])->update(['kredit' => $saldo]);

                }

            }
            # code...
        }

        $dataneracas = M_neracasaldo::where(['kdperiode' => $kdperiode, 'kdpst' => Session::get('globalkdpst')])->get();
        return view('laporan.neracasaldo')->with(['dataneracas' => $dataneracas, 'bulan' => $bulan, 'tahun' => $tahun, 'namabulan' => $namabulan]);
    }

    public function rptneracasaldopenyesuaian()
    {
        return view('laporan.rptneracasaldopenyesuaian');
    }
    public function neracasaldopenyesuaian(Request $request)
    {
        $bulan = $request->bulan;
        $namabulan = Laporan::getnamabulan($bulan);
        $tahun = $request->tahun;
        $kdperiode = $bulan . $tahun;
        M_neracasaldopenyesuaian::where(['kdperiode' => $kdperiode, 'kdpst' => Session::get('globalkdpst')])->delete();
        DB::insert("insert into neracasaldopenyesuaian (kdpst,kdperiode,kdakun,debet,kredit) select kdpst,kdperiode,kdakun,debet,kredit from neracasaldo where kdperiode='$kdperiode'");

        $datajurnals = M_lapjurnalpenyesuaian::where(['kdperiode' => $kdperiode, 'kdpst' => Session::get('globalkdpst')])->get();
        foreach ($datajurnals as $key) {
            $kdakun = $key->kdakun;
            $debet = $key->debet;
            $kredit = $key->kredit;
            $dataneraca = M_neracasaldopenyesuaian::where(['kdperiode' => $kdperiode, 'kdakun' => $kdakun, 'kdpst' => Session::get('globalkdpst')])->get();
            if (count($dataneraca) > 0) {
                foreach ($dataneraca as $neraca) {
                    $debetbaru = $neraca->debet;
                    $kreditbaru = $neraca->kredit;
                    $typeakun = $neraca->get_akun->typeakun;

                    if ($typeakun == 'D') {
                        $saldobaru = ($debet + $debetbaru) - $kredit;
                        M_neracasaldopenyesuaian::where(['kdperiode' => $kdperiode, 'kdakun' => $kdakun, 'kdpst' => Session::get('globalkdpst')])->update(['debet' => $saldobaru]);

                    } else if ($typeakun == 'K') {
                        $saldobaru = ($kredit + $kreditbaru) - $debet;
                        M_neracasaldopenyesuaian::where(['kdperiode' => $kdperiode, 'kdakun' => $kdakun, 'kdpst' => Session::get('globalkdpst')])->update(['kredit' => $saldobaru]);

                    }
                    # code...
                }
                # code...
            }

            # code...
        }
        $dataneracas = M_neracasaldopenyesuaian::where(['kdperiode' => $kdperiode, 'kdpst' => Session::get('globalkdpst')])->get();
        return view('laporan.neracasaldopenyesuaian')->with(['dataneracas' => $dataneracas, 'bulan' => $bulan, 'tahun' => $tahun, 'namabulan' => $namabulan]);
    }
    public function rptlaporanlabarugi()
    {
        return view('laporan.rptlaporanlabarugi');
    }
    public function laporanlabarugi(Request $request)
    {
        $bulan = $request->bulan;
        $namabulan = Laporan::getnamabulan($bulan);
        $tahun = $request->tahun;
        $kdperiode = $bulan . $tahun;
        $kdakuns = M_akun::where('kdpst', Session::get('globalkdpst'))
            ->where(\DB::raw('substr(kdakun, 1, 1)'), '=', '6')
            ->get();
        foreach ($kdakuns as $key) {
            $kdakun = $key->kdakun;
            # code...
        }
        
        $dataneracas = M_neracasaldo::join('akun', 'neracasaldo.kdakun', '=', 'akun.kdakun')
            ->where(['kdperiode' => $kdperiode, 'f_lr' => '1'])
            ->where(['neracasaldo.kdpst' => Session::get('globalkdpst')])
            ->get(['neracasaldo.*', 'akun.*']);
       
        return view('laporan.laporanlabarugi')->with(['dataneracas' => $dataneracas, 'bulan' => $bulan, 'tahun' => $tahun, 'namabulan' => $namabulan, 'kdakun' => $kdakun, 'kdperiode' => $kdperiode]);
    }
    public function rptlaporankeuangan()
    {
        return view('laporan.rptlaporankeuangan');
    }
    public function laporankeuangan(Request $request)
    {
        $bulan = $request->bulan;
        $namabulan = Laporan::getnamabulan($bulan);
        $tahun = $request->tahun;
        $kdperiode = $bulan . $tahun;
        M_laporankeuangan::where(['kdperiode' => $kdperiode, 'kdpst' => Session::get('globalkdpst')])->delete();
        DB::insert("insert into laporankeuangan (kdpst,kdperiode,kdakun,debet,kredit) select neracasaldopenyesuaian.kdpst,neracasaldopenyesuaian.kdperiode,neracasaldopenyesuaian.kdakun, neracasaldopenyesuaian.debet,neracasaldopenyesuaian.kredit from neracasaldopenyesuaian join akun on neracasaldopenyesuaian.kdakun=akun.kdakun where akun.f_lk='1' and neracasaldopenyesuaian.kdperiode='$kdperiode'");
        DB::insert("insert into laporankeuangan (kdpst,kdperiode,kdakun,debet,kredit) select labarugi.kdpst,labarugi.kdperiode,labarugi.kdakun, labarugi.debet,labarugi.kredit from labarugi join akun on labarugi.kdakun=akun.kdakun where akun.f_lk='1' and labarugi.kdperiode='$kdperiode'");

        $dataneracas = M_laporankeuangan::join('akun', 'laporankeuangan.kdakun', '=', 'akun.kdakun')
            ->where(['kdperiode' => $kdperiode, 'f_lk' => '1'])
            ->where(['laporankeuangan.kdpst' => Session::get('globalkdpst')])
            ->get(['laporankeuangan.*', 'akun.*']);

        return view('laporan.laporankeuangan')->with(['dataneracas' => $dataneracas, 'bulan' => $bulan, 'tahun' => $tahun, 'namabulan' => $namabulan]);
    }
    public function rptjurnaltransaksi()
    {
        return view('laporan.rptjurnaltransaksi');
    }
    public function jurnaltransaksi(Request $request)
    {
        $bulan = $request->bulan;
        $namabulan = Laporan::getnamabulan($bulan);
        $tahun = $request->tahun;
        $datajurnals = M_lapjurnal::whereMonth('tgltrans', $bulan)
            ->whereYear('tgltrans', $tahun)
            ->get();
        return view('laporan.jurnaltransaksi')->with(['datajurnals' => $datajurnals, 'bulan' => $bulan, 'tahun' => $tahun, 'namabulan' => $namabulan]);
    }
    public function rptjurnalpenyesuaian()
    {
        return view('laporan.rptjurnalpenyesuaian');
    }
    public function jurnalpenyesuaian(Request $request)
    {
        $bulan = $request->bulan;
        $namabulan = Laporan::getnamabulan($bulan);
        $tahun = $request->tahun;
        $datajurnals = M_lapjurnalpenyesuaian::whereMonth('tgltrans', $bulan)
            ->where('lapjurnalpenyesuaian.kdpst', Session::get('globalkdpst'))
            ->whereYear('tgltrans', $tahun)
            ->get();
        return view('laporan.jurnalpenyesuaian')->with(['datajurnals' => $datajurnals, 'bulan' => $bulan, 'tahun' => $tahun, 'namabulan' => $namabulan]);
    }
    public function rptbukubesar()
    {
        $msakuns = M_akun::where(['f_bb' => '1', 'kdpst' => Session::get('globalkdpst')])->get();
        $msjurnals = M_msjurnal::pluck('namajurnal', 'kdjurnal');
        return view('laporan.rptbukubesar', compact('msjurnals', 'msakuns'));
    }
    public function bukubesar(Request $request)
    {
        $bulan = $request->bulan;
        $namabulan = Laporan::getnamabulan($bulan);
        $tahun = $request->tahun;
        $kdakun = $request->kdakun;
        $datakun = M_akun::find($kdakun);
        $namaakun = $datakun->namaakun;
        $typeakun = $datakun->typeakun;

        $datajurnals = M_lapjurnal::where('kdakun', $kdakun)
            ->whereMonth('tgltrans', $bulan)
            ->whereYear('tgltrans', $tahun)
            ->get();
        return view('laporan.bukubesar')->with(['datajurnals' => $datajurnals, 'bulan' => $bulan, 'tahun' => $tahun, 'namabulan' => $namabulan, 'kdakun' => $kdakun, 'namaakun' => $namaakun, 'typeakun' => $typeakun]);
    }
    public function rptbukubesarall()
    {
        $msakuns = M_akun::where(['f_bb' => '1', 'kdpst' => Session::get('globalkdpst')])->get();
        $msjurnals = M_msjurnal::pluck('namajurnal', 'kdjurnal');
        return view('laporan.rptbukubesarall', compact('msjurnals', 'msakuns'));
    }
    public function bukubesarall(Request $request)
    {
        $bulan = $request->bulan;
        $namabulan = Laporan::getnamabulan($bulan);
        $tahun = $request->tahun;
        $msakuns = M_akun::where(['f_bb' => '1', 'kdpst' => Session::get('globalkdpst')])->get();
        return view('laporan.bukubesarall')->with(['msakuns' => $msakuns, 'bulan' => $bulan, 'tahun' => $tahun, 'namabulan' => $namabulan]);
    }
    public function rpttagihanmahasiswa()
    {
        return view('laporan.rpttagihanmahasiswa');
    }
    public function tagihanmahasiswa(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        $jurnaltagihan = M_jurnaltagihan::join('mahasiswa', 'jurnaltagihan.nim', '=', 'mahasiswa.nim')
            ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
            ->where('jurnaltagihan.kdpst', Session::get('globalkdpst'))
            ->get(['jurnaltagihan.*', 'mahasiswa.*']);

        return view('laporan.tagihanmahasiswa')->with(['jurnaltagihan' => $jurnaltagihan, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }
    public function rpttagihanpmahasiswa()
    {
        return view('laporan.rpttagihanpmahasiswa');
    }
    public function tagihanpmahasiswa(Request $request)
    {
        $nim = $request->nim;
        $jurnaltagihan = M_jurnaltagihan::join('mahasiswa', 'jurnaltagihan.nim', '=', 'mahasiswa.nim')
            ->where('jurnaltagihan.nim', $nim)
            ->where('jurnaltagihan.kdpst', Session::get('globalkdpst'))
            ->get(['jurnaltagihan.*', 'mahasiswa.*']);

        return view('laporan.tagihanpmahasiswa')->with(['jurnaltagihan' => $jurnaltagihan, 'nim' => $nim]);
    }
    public function rptpembayaranmahasiswa()
    {
        return view('laporan.rptpembayaranmahasiswa');
    }
    public function pembayaranmahasiswa(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        $jurnalpembayaran = M_jurnalpembayaran::join('mahasiswa', 'jurnalpembayaran.nim', '=', 'mahasiswa.nim')
            ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
            ->where('jurnalpembayaran.kdpst', Session::get('globalkdpst'))
            ->get(['jurnalpembayaran.*', 'mahasiswa.*']);

        return view('laporan.pembayaranmahasiswa')->with(['jurnalpembayaran' => $jurnalpembayaran, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }
    public function rptpembayaranpmahasiswa()
    {
        return view('laporan.rptpembayaranpmahasiswa');
    }
    public function pembayaranpmahasiswa(Request $request)
    {
        $nim = $request->nim;
        $jurnalpembayaran = M_jurnalpembayaran::join('mahasiswa', 'jurnalpembayaran.nim', '=', 'mahasiswa.nim')
            ->where('jurnalpembayaran.nim', $nim)
            ->where('jurnalpembayaran.kdpst', Session::get('globalkdpst'))
            ->get(['jurnalpembayaran.*', 'mahasiswa.*']);

        return view('laporan.pembayaranpmahasiswa')->with(['jurnalpembayaran' => $jurnalpembayaran, 'nim' => $nim]);
    }
    public function rpttransaksikeuangan()
    {
        return view('laporan.rpttransaksikeuangan');
    }
    public function laptransaksikeuangan(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        $jurnalumum = M_jurnalumum::join('mstransaksi', 'jurnalumum.kdtransaksi', '=', 'mstransaksi.kdtransaksi')
            ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
            ->where('jurnalumum.kdpst', Session::get('globalkdpst'))
            ->get(['jurnalumum.*', 'mstransaksi.*']);

        return view('laporan.laptransaksikeuangan')->with(['jurnalumum' => $jurnalumum, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }
    public function rpttransaksipenyesuaian()
    {
        return view('laporan.rpttransaksipenyesuaian');
    }
    public function laptransaksipenyesuaian(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        $jurnalpenyesuaian = M_jurnalpenyesuaian::join('mstransaksi', 'jurnalpenyesuaian.kdtransaksi', '=', 'mstransaksi.kdtransaksi')
            ->whereBetween('tgltrans', [$tglmulai, $tglakhir])
            ->where('jurnalpenyesuaian.kdpst', Session::get('globalkdpst'))
            ->get(['jurnalpenyesuaian.*', 'mstransaksi.*']);

        return view('laporan.laptransaksipenyesuaian')->with(['jurnalpenyesuaian' => $jurnalpenyesuaian, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }
}
