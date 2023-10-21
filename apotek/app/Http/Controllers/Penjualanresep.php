<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_customer;
use App\Models\M_jurnalumum;
use App\Models\M_lapjurnal;
use App\Models\M_mstransaksi;
use App\Models\M_penjualan;
use App\Models\M_detailpenjualan;
use App\Models\M_detailresep;
use App\Models\M_jenispasien;
use App\Models\M_poly;
use App\Models\M_dokter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Redirect;
use Response;
use Illuminate\Support\Carbon;

class Penjualanresep extends Controller
{
    public $total;

    public static function kekata($x)
    {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = penjualanresep::kekata($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = penjualanresep::kekata($x / 10) . " puluh" . penjualanresep::kekata($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . penjualanresep::kekata($x - 100);
        } else if ($x < 1000) {
            $temp = penjualanresep::kekata($x / 100) . " ratus" . penjualanresep::kekata($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . penjualanresep::kekata($x - 1000);
        } else if ($x < 1000000) {
            $temp = penjualanresep::kekata($x / 1000) . " ribu" . penjualanresep::kekata($x % 1000);
        } else if ($x < 1000000000) {
            $temp = penjualanresep::kekata($x / 1000000) . " juta" . penjualanresep::kekata($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = penjualanresep::kekata($x / 1000000000) . " milyar" . penjualanresep::kekata(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = penjualanresep::kekata($x / 1000000000000) . " trilyun" . penjualanresep::kekata(fmod($x, 1000000000000));
        }
        return $temp;
    }

    public static function terbilang($x, $style = 4)
    {
        if ($x < 0) {
            $hasil = "minus " . trim(penjualanresep::kekata($x));
        } else {
            $hasil = trim(penjualanresep::kekata($x));
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
        $kdtransaksi="TR0002";
        $customer = M_customer::get();
        $jenispasiens=M_jenispasien::get();
        $polys=M_poly::get();
        $dokters=M_dokter::get();
        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
        where('stok.idlokasi', "TOKO")->
        where('stok.stok', '>', 0)->get();

        $mstransaksis = M_mstransaksi::where(['kdktgtransaksi' => 'TRKEU', 'kdpst' => Session::get('globalkdpst')])->orderby('namatransaksi')->get();
        return view('penjualanresep.index')->with(['mstransaksis' => $mstransaksis, 'barang' => $barang, 'kdtransaksi' => $kdtransaksi,'customer'=>$customer,'jenispasiens'=>$jenispasiens,'polys'=>$polys,'dokters'=>$dokters]);
    }
    public function baru()
    {
        Session::forget('cart');
        Session::forget('id');
        return redirect()->route('penjualanresep');
    }

    public function cart(Request $request)
    {
        if($request->qty==0){
            return 'Qty tidak boleh 0';
        }
        $cart = Session::get('cart');
        $cart[] = array(
            'kdbarang' => $request->kdbarang,
            'namabarang' => $request->namabarang,
            'qty' => $request->qty,
            'harga' => $request->harga,
            'diskonpersen'=>$request->diskonpersen,
            'diskon' => $request->diskon,
            'jumlah' => $request->jumlah,
        );
        //dd($cart);
        Session::put('cart', $cart);
        return "sukses";
    }
    public function cartview(){
        $data=Session::get('cart');
        return view('penjualanresep.cartview')->with(['data'=>$data]);
    }
    public function carthapus(Request $request)
    {
        $cart = Session::get('cart');
        unset($cart[$request->idx]);
        $cart=array_values($cart);
        Session::put('cart', $cart);
        return view('penjualanresep.cartview');
    }
    public function gennotrans()
    {
        $kode = DB::table('detailresep')->max('noresep');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = "R";
        $newID = $char . sprintf("%017s", $noUrut);
        return $newID;
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
       // dd($request->all());
        $validator = Validator::make($request->all(), [
            'idcustomer' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $cart = Session::get('cart');
            $lastid = Penjualanresep::gennotrans();
            if (empty($request->modebayar)) {
                $modebayar = "TUNAI";
            }
            else {
                $modebayar="NONTUNAI";
            }
            $penjualanresep=new M_penjualan;
            $penjualanresep->tgltrans=Carbon::now();
            $penjualanresep->jam=date("h:i");
            $penjualanresep->idcustomer=$request->idcustomer;
            $penjualanresep->total=$request->total;
            $penjualanresep->email=Session::get('email');
            $penjualanresep->tipepenjualan=$request->tipepenjualan;
            $penjualanresep->modebayar=$modebayar;
            $penjualanresep->jenispenjualan="R";


            $penjualanresep->save();
            $lastid=$penjualanresep->id;
            $cart=Session::get('cart');

            foreach ($cart as $key => $value) {
                M_detailpenjualan::create([
                    'idpenjualan' => $lastid,
                    'kdbarang' => $value['kdbarang'],
                    'qty' => $value['qty'],
                    'harga' => $value['harga'],
                    'diskonpersen' => $value['diskonpersen'],
                    'diskon' => $value['diskon'],
                    'jumlah' => $value['jumlah'],
                    'idlokasi'=>'TOKO'
                ]);
            }
            $detailresep=new M_detailresep;
            $detailresep->idpenjualan=$lastid;
            $detailresep->idjenispasien=$request->idjenispasien;
            $detailresep->namapasien=$request->namapasien;
            $detailresep->idpoly=$request->idpoly;
            $detailresep->iddokter=$request->iddokter;
            $detailresep->noresep=$lastid;
            $detailresep->admresep='0';
            $detailresep->admracik='0';
            $detailresep->save();


            Session::forget('cart');
            Session::put('id', $lastid);
            DB::commit();
            return Redirect()->route('penjualanresep.invoice');

        }
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Error', $e->getMessage());
            return Redirect()->back()->withInput();
        }
    }
    public function invoice()
    {
        $datapenjualan = M_penjualan::find(Session::get('id'));
        $data = M_detailpenjualan::with('get_barang','get_penjualan')->where('idpenjualan', Session::get('id'))->get();
        $dataresep=M_detailresep::with('get_jenispasien','get_poly','get_dokter')->where('idpenjualan', Session::get('id'))->first();
        return view('penjualanresep.invoice')->with(['penjualan' => $data, 'datapenjualan' => $datapenjualan,'dataresep'=>$dataresep]);
    }

    public function batal()
    {
        return view('penjualanresep.batal');
    }
    public function carijurnal(Request $request)
    {
        $datajurnal = M_jurnalumum::where('notrans', $request->id)->get();
        return $datajurnal->toJson(JSON_PRETTY_PRINT);
    }
    public function detail($id)
    {
        $datajurnal = M_jurnalumum::where('notrans', $id)->get();
        return view('penjualanresep.create')->with(['datajurnal' => $datajurnal]);
    }
    public function destroy($id)
    {

        return redirect()->route('penjualanresep.batal')
            ->with('success', 'Transaksi deleted successfully');
        //
    }
    public function trpenjualanresep()
    {
        $penjualanresep = M_penjualan::where('f_statustransaksi','0')->orderBy('id','DESC')->get();
        return view('penjualanresep.trpenjualanresep')->with(['penjualanresep' => $penjualanresep]);
    }
    public function trdetail($id)
    {
        $data = M_detailpenjualan::where('idpenjualanresep', $id)
            ->with('get_barang')->get();
        return view("penjualanresep.detail")->with('data', $data);
    }
    public function hapuspenjualanresep(Request $request)
    {
        $penjualanresep = M_penjualan::find($request->id);
        $penjualanresep->f_statustransaksi="1";
        $penjualanresep->emailhapus=Session::get('email');
        $penjualanresep->save();
        M_detailpenjualan::where('idpenjualanresep', $request->id)->delete();
        return redirect()->route('penjualanresep.trpenjualanresep')
            ->with('success', 'Transaksi Hapus Sukses');
    }
    public function caribarang(Request $request)
    {

        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
        where('stok.idlokasi', "TOKO")->
        where('barang.namabarang', 'like', '%aa%')->
        where('stok.stok', '>', 0)->
        orderby('namabarang')->get();

        return view('penjualanresep.formbarang', ['barang' => $barang, 'jenisharga'=>$request->jenisharga]);
        //
    }
    public function fetch(Request $request)
    {

        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
        where('stok.idlokasi', "TOKO")->
        where('barang.namabarang', 'like', '%'.$request->namabarang.'%')->
        where('stok.stok', '>', 0)->
        orderby('namabarang')->get();

        return view('penjualanresep.fetch', ['barang' => $barang]);
        //
    }
}
