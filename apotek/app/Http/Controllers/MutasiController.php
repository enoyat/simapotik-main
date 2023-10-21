<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_jurnalumum;
use App\Models\M_lapjurnal;
use App\Models\M_mstransaksi;
use App\Models\M_pembelian;
use App\Models\M_detailpembelian;
use App\Models\M_mutasi;
use App\Models\M_detailmutasi;

use App\Models\M_stoklokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Redirect;
use Response;

class MutasiController extends Controller
{
    public $total;
    public $idlokasi;

    public static function kekata($x)
    {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = pembelian::kekata($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = pembelian::kekata($x / 10) . " puluh" . pembelian::kekata($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . pembelian::kekata($x - 100);
        } else if ($x < 1000) {
            $temp = pembelian::kekata($x / 100) . " ratus" . pembelian::kekata($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . pembelian::kekata($x - 1000);
        } else if ($x < 1000000) {
            $temp = pembelian::kekata($x / 1000) . " ribu" . pembelian::kekata($x % 1000);
        } else if ($x < 1000000000) {
            $temp = pembelian::kekata($x / 1000000) . " juta" . pembelian::kekata($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = pembelian::kekata($x / 1000000000) . " milyar" . pembelian::kekata(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = pembelian::kekata($x / 1000000000000) . " trilyun" . pembelian::kekata(fmod($x, 1000000000000));
        }
        return $temp;
    }

    public static function terbilang($x, $style = 4)
    {
        if ($x < 0) {
            $hasil = "minus " . trim(pembelian::kekata($x));
        } else {
            $hasil = trim(pembelian::kekata($x));
        }
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }
        return $hasil;
    }

    public function index()
    {
        $lokasi = M_stoklokasi::get();
        $barang = M_barang::where('kdpst', Session::get('globalkdpst'))->get();
        return view('mutasi.index')->with(['barang' => $barang, 'lokasi' => $lokasi]);
    }
    public function baru()
    {
        Session::forget('cart');
        Session::forget('id');
        return redirect()->route('mutasi.index');
    }

    public function cart(Request $request)
    {

        if($request->qty==0){
            return 'Qty tidak boleh 0';
        }
        if(intval($request->qty) > intval($request->qtymax)){
            return 'Mutasi Stok melebihi stok tersedia';
        }
        if($request->idlokasi==$request->idlokasidest){
            return 'Lokasi tidak boleh sama';
        }

        $cart = Session::get('cart');
        $cart[] = array(
            'kdbarang' => $request->kdbarang,
            'namabarang' => $request->namabarang,
            'qty' => $request->qty,
            'harga' => $request->harga,
            'diskon' => $request->diskon,
            'jumlah' => $request->jumlah,
            'idlokasi' => $request->idlokasi,
            'idlokasidest' => $request->idlokasidest,
            'tglmutasi' => $request->tglmutasi,
        );
        //dd($cart);
        Session::put('cart', $cart);
        return "sukses";
    }
    public function cartview(){
        $data=Session::get('cart');
        return view('mutasi.cartview')->with(['data'=>$data]);
    }
    public function carthapus(Request $request)
    {
        $cart = Session::get('cart');
        unset($cart[$request->idx]);
        $cart=array_values($cart);
        Session::put('cart', $cart);
        return view('mutasi.cartview');
    }
    public function gennotrans()
    {
        $kode = DB::table('jurnalumum')->max('notrans');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = "JUM";
        $newID = $char . sprintf("%017s", $noUrut);
        return $newID;
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tgltrans' => 'required',
            'idlokasi' => 'required',
            'idlokasidest' => 'required',

        ]);
        $cart = Session::get('cart');
        if (empty($cart)) {
            Alert::error('error', 'data belum dipilih');
            return Redirect()->back();
           
        }
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $cart = Session::get('cart');
            if (empty($cart)) {
                Alert::error('error', 'data belum dipilih');
                return Redirect()->back();
               
            }
            $cart=Session::get('cart');            
            foreach ($cart as $key => $value) {
                M_detailmutasi::create([
                    'tglmutasi' => $value['tglmutasi'],
                    'kdbarang' => $value['kdbarang'],
                    'qty' => $value['qty'],
                    'idlokasi' => $value['idlokasi'],
                    'idlokasidest' => $value['idlokasidest'],
                    'email'=>Session::get('email'),
                ]);
            }

            Session::forget('cart');
            //Session::put('id', $lastid);
            Alert::success('Berhasil', 'Data Berhasil Disimpan');
            return Redirect()->route('mutasi.index');

        }
    }
    public function invoice()
    {
        $datapembelian = M_pembelian::find(Session::get('id'));
        $data = M_detailpembelian::with('get_barang','get_pembelian')->where('idpembelian', Session::get('id'))->get();
        return view('mutasi.invoice')->with(['pembelian' => $data, 'datapembelian' => $datapembelian]);
    }
    public function createPDF()
    {

    }
    public function batal()
    {
        return view('mutasi.batal');
    }
    public function carijurnal(Request $request)
    {
        $datajurnal = M_jurnalumum::where('notrans', $request->id)->get();
        return $datajurnal->toJson(JSON_PRETTY_PRINT);
    }
    public function detail($id)
    {
        $datajurnal = M_jurnalumum::where('notrans', $id)->get();
        return view('mutasi.create')->with(['datajurnal' => $datajurnal]);
    }
    public function destroy($id)
    {
        $jurnalumum = M_jurnalumum::find($id);
        $jurnalumum->delete();
        M_lapjurnal::where('notrans', $id)->delete();
        return redirect()->route('pembelian.batal')
            ->with('success', 'Transaksi deleted successfully');
        //
    }
    public function trpembelian()
    {
        $pembelian = M_pembelian::where('kdpst', Session::get('globalkdpst'))->orderBy('id','DESC')->get();
        return view('mutasi.trpembelian')->with(['pembelian' => $pembelian]);
    }
    public function trdetail($id)
    {
        $data = M_detailpembelian::where('idpembelian', $id)
            ->with('get_barang')->get();
        return view("mutasi.detail")->with('data', $data);
    }
    public function hapuspembelian(Request $request)
    {
        $pembelian = M_pembelian::find($request->id);
        $notrans=$pembelian->notrans;
        $pembelian->delete();
        M_detailpembelian::where('idpembelian', $request->id)->delete();
        M_jurnalumum::where('notrans', $notrans)->delete();
        M_lapjurnal::where('notrans', $notrans)->delete();
        return redirect()->route('mutasi.trpembelian')
            ->with('success', 'Transaksi Hapus Sukses');
    }
    public function listproduk(Request $request)
    {
        $barang=M_barang::join('stok','barang.kdbarang','=','stok.kdbarang')->
        where('stok.idlokasi',$request->idlokasi)->
        where('stok.stok','>',0)->get();

        return view('mutasi.listproduk',['barang' => $barang]);
   //
    }

    public function rptmutasi()
    {
        return view('mutasi.rptmutasi');
    }
    public function laporanmutasi(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
        $mutasi = M_detailmutasi::with('get_barang')->whereBetween('tglmutasi', [$tglmulai, $tglakhir])->get();
        return view('mutasi.laporanmutasi')->with(['mutasi' => $mutasi, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }
}
