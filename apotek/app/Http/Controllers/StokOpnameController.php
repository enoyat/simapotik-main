<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\M_barang;
use App\Models\M_fotobarang;
use App\Models\M_jenis;
use App\Models\M_kategori;
use App\Models\M_stok;
use App\Models\M_stoklokasi;
use App\Models\M_stokopname;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class StokOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lokasi = M_stoklokasi::get();
        $jenis = M_jenis::get();
        $kategori = M_kategori::where('kdpst', Session::get('globalkdpst'))->get();
        return view('stokopname.index', ['kategori' => $kategori, 'lokasi' => $lokasi, 'jenis' => $jenis]);
        //
    }
    public function cetakstok(Request $request)
    {
        // $barang=M_barang::with('get_kategori')
        // ->select('barang.*', 'qbeli.qtybeli', 'qjual.qtyjual')
        // ->leftJoin(DB::raw("(SELECT kdbarang, sum(qty) as qtybeli from detailpembelian group by kdbarang) AS qbeli"), 'qbeli.kdbarang', '=', 'barang.kdbarang')
        // ->leftJoin(DB::raw("(SELECT kdbarang, sum(qty) as qtyjual from detailpenjualan group by kdbarang) AS qjual"), 'qjual.kdbarang', '=', 'barang.kdbarang')
        //   ->where('barang.kdpst', Session::get('globalkdpst'))
        //   ->where('barang.idlokasi', $request->kdkategori)
        //   ->where('barang.kdkategori', $request->kdkategori)
        // ->get();
        $datastok = M_stok::with('get_barang', 'get_lokasi')->where('idlokasi', $request->idlokasi)->first();
        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->where('stok.idlokasi', $request->idlokasi)->where('barang.kdkategori', $request->kdkategori)->get();

        if ($barang->count() < 1) {
            Alert::error('Data Tidak Ditemukan', 'Gagal');
            return redirect()->back();
        } else {
            return view('stokopname.laporan', ['barang' => $barang, 'datastok' => $datastok]);
        }
        //
    }

    public function stok(Request $request)
    {
        $lokasi = M_stoklokasi::get();
        $jenis = M_jenis::get();
        $kategori = M_kategori::where('kdpst', Session::get('globalkdpst'))->get();
        return view('stokopname.stok', ['kategori' => $kategori, 'lokasi' => $lokasi, 'jenis' => $jenis]);
        //
    }
    public function fetch(Request $request)
    {
        // $barang = M_barang::with('get_kategori')
        //     ->select('barang.*', 'qbeli.qtybeli', 'qjual.qtyjual')
        //     ->leftJoin(DB::raw("(SELECT kdbarang, sum(qty) as qtybeli from detailpembelian group by kdbarang) AS qbeli"), 'qbeli.kdbarang', '=', 'barang.kdbarang')
        //     ->leftJoin(DB::raw("(SELECT kdbarang, sum(qty) as qtyjual from detailpenjualan group by kdbarang) AS qjual"), 'qjual.kdbarang', '=', 'barang.kdbarang')
        //     ->where('barang.kdpst', Session::get('globalkdpst'))
        //     ->where('barang.kdkategori', $request->kdkategori)
        //     ->get();
        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->where('stok.idlokasi', $request->idlokasi)->where('barang.kdkategori', $request->kdkategori)->get();

        return view('stokopname.fetch', ['barang' => $barang]);
        //
    }

    public function detail($kdbarang)
    {
        $kategori = M_kategori::where('kdpst', Session::get('globalkdpst'))->get();
        $product = M_barang::where('kdbarang', $kdbarang)->with('get_foto')->where('kdpst', Session::get('globalkdpst'))->get();
        return view('detailbarang', ['barang' => $product, 'kategori' => $kategori]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($id)
    {
        $barang = M_stok::with('get_barang', 'get_lokasi')->find($id);
        return view('stokopname.create', ['barang' => $barang]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $request->validate([
            'stokfisik' => 'required|numeric',
            'keterangan' => 'required',
            'selisih' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $stokopname = new M_stokopname();

            $stokopname->tanggal = Carbon::now();
            $stokopname->kdbarang = $request->kdbarang;
            $stokopname->idlokasi = $request->idlokasi;
            $stokopname->stoksistem = $request->stok;
            $stokopname->stokfisik = $request->stokfisik;
            $stokopname->selisih = $request->selisih;
            $stokopname->keterangan = $request->keterangan;
            $stokopname->kdpst = Session::get('globalkdpst');
            $stokopname->email = auth()->user()->email;

            $stokopname->save();

            DB::commit();

            return [
                'status' => true,
                'message' => 'Data Berhasil Disimpan'
            ];
        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = M_kategori::where('kdpst', Session::get('globalkdpst'))->get();
        $product = M_barang::where('kdbarang', $id)->where('kdpst', Session::get('globalkdpst'))->get();
        // dd($product);
        return view('barang.formeditbarang', ['databarang' => $product, 'kategori' => $kategori]);
        //
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->kdbarang;
            $mfoto = M_barang::find($id);
            $destinationPath = 'assets/inventory/';
            File::delete($destinationPath . $mfoto->foto);
            M_barang::where('kdbarang', '=', $id)->delete();
            M_fotobarang::where('kdbarang', '=', $id)->delete();

            return redirect()->back(); //
        } catch (QueryException $ex) {
            Alert::error('Gagal', 'Barang tidak bisa dihapus karena masih digunakan');
            return redirect()->back();
            //dd($ex->getMessage());
        }
    }
    public function rptstokopname()
    {
        $lokasi = M_stoklokasi::get();
        return view('stokopname.rptstokopname', ['lokasi' => $lokasi]);
        //
    }

    public function cetakstokopname(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        $barang = M_barang::with('get_kategori')
            ->select('barang.*', 'stokopname.tanggal', 'stoklokasi.namalokasi', 'stokopname.stoksistem', 'stokopname.stokfisik', 'stokopname.selisih', 'stokopname.keterangan')
            ->join('stokopname', 'stokopname.kdbarang', '=', 'barang.kdbarang')
            ->join('stoklokasi', 'stoklokasi.idlokasi', '=', 'stokopname.idlokasi')
            ->where('barang.kdpst', Session::get('globalkdpst'))
            ->where('stokopname.idlokasi', $request->idlokasi)
            ->whereBetween('tanggal', [$tglmulai, $tglakhir])
            ->get();
        return view('stokopname.laporanstokopname', ['barang' => $barang, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
        //
    }
    public function expstokopname()
    {
        $lokasi = M_stoklokasi::get();
        return view('stokopname.expstokopname', ['lokasi' => $lokasi]);
        //
    }
    public function exportstokopname(Request $request)
    {
        $lokasi = M_stoklokasi::get();
        $datastok = M_barang::with('jmlstok')->orderby('namabarang')->get();
        return view('stokopname.exportstokopname', ['datastok' => $datastok, 'lokasi' => $lokasi, 'title' => 'Laporan Stok Opname']);
        //
    }
}
