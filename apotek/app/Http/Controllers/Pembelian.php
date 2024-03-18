<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_detailpembelian;
use App\Models\M_inreturpembelian;
use App\Models\M_jurnalumum;
use App\Models\M_lapjurnal;
use App\Models\M_mstransaksi;
use App\Models\M_pembelian;
use App\Models\M_returdetailpembelian;
use App\Models\M_returpembelian;
use App\Models\M_stok;
use App\Models\M_stoklokasi;
use App\Models\M_supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;
use Response;

class Pembelian extends Controller
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
        $supplier = M_supplier::where('kdpst', Session::get('globalkdpst'))->get();
        $lokasi = M_stoklokasi::where('f_default', '0')->get();

        $kdtransaksi = "TR0001" . Session::get('globalkdpst');
        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
            where('stok.idlokasi', "TOKO")->
            where('kdpst', Session::get('globalkdpst'))->
            where('stok.stok', '>=', 0)->get();

        $mstransaksis = M_mstransaksi::where(['kdktgtransaksi' => 'TRKEU', 'kdpst' => Session::get('globalkdpst')])->orderby('namatransaksi')->get();
        return view('pembelian.index')->with(['mstransaksis' => $mstransaksis, 'barang' => $barang, 'kdtransaksi' => $kdtransaksi, 'supplier' => $supplier, 'lokasi' => $lokasi]);
    }
    public function baru()
    {
        Session::forget('cart');
        Session::forget('id');
        return redirect()->route('pembelian');
    }

    public function cart(Request $request)
    {
        if ($request->qty == 0) {
            return 'Qty tidak boleh 0';
        }
        $cart = Session::get('cart');
        $cart[] = array(
            'kdbarang' => $request->kdbarang,
            'namabarang' => $request->namabarang,
            'nobatch' => $request->nobatch,
            'tglkadaluarsa' => $request->tglkadaluarsa,
            'qty' => $request->qty,
            'harga' => $request->harga,
            'diskonpersen' => $request->diskonpersen,
            'diskon' => $request->diskon,
            'jumlah' => $request->jumlah,
        );
        //dd($cart);
        Session::put('cart', $cart);
        return "sukses";
    }
    public function cartview()
    {
        $data = Session::get('cart');
        return view('pembelian.cartview')->with(['data' => $data]);
    }
    public function carthapus(Request $request)
    {
        $cart = Session::get('cart');
        unset($cart[$request->idx]);
        $cart = array_values($cart);
        Session::put('cart', $cart);
        return view('pembelian.cartview');
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
        DB::beginTransaction();
        try {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'tgltrans' => 'required',
                'idsupplier' => 'required',
                'total' => 'required',
                'ppn'=> 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            } else {
                $cart = Session::get('cart');
                $lastid = pembelian::gennotrans();
                if (empty($request->modebayar)) {
                    $modebayar = "TUNAI";
                } else {
                    $modebayar = "NONTUNAI";
                }

                $pembelian = new M_pembelian;
                $pembelian->nofaktur = $request->nofaktur;
                $pembelian->idsupplier = $request->idsupplier;
                $pembelian->idlokasi = $request->idlokasi;
                $pembelian->tgltrans = $request->tgltrans;
                $pembelian->total = $request->grandtotal;
                $pembelian->email = Session::get('email');
                $pembelian->tipepembelian = $request->tipepembelian;
                $pembelian->ppn = $request->ppn;
                $pembelian->save();
                $lastid = $pembelian->id;
                $cart = Session::get('cart');

                foreach ($cart as $key => $value) {
                    M_detailpembelian::create([
                        'idpembelian' => $lastid,
                        'kdbarang' => $value['kdbarang'],
                        'nobatch' => $value['nobatch'],
                        'tglkadaluarsa' => $value['tglkadaluarsa'],
                        'qty' => $value['qty'],
                        'harga' => $value['harga'],
                        'diskonpersen' => $value['diskonpersen'],
                        'diskon' => $value['diskon'],
                        'jumlah' => $value['jumlah'],
                        'idlokasi' => $request->idlokasi,
                    ]);
                }

                Session::forget('cart');
                Session::put('id', $lastid);
                DB::commit();
                return Redirect()->route('pembelian.invoice');

            }
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Error', $e->getMessage());
            return Redirect()->back()->withInput();
        }
    }
    public function invoice()
    {
        $datapembelian = M_pembelian::find(Session::get('id'));
        $data = M_detailpembelian::with('get_barang', 'get_pembelian')->where('idpembelian', Session::get('id'))->get();
        return view('pembelian.invoice')->with(['pembelian' => $data, 'datapembelian' => $datapembelian]);
    }

    public function batal()
    {
        return view('pembelian.batal');
    }
    public function carijurnal(Request $request)
    {
        $datajurnal = M_jurnalumum::where('notrans', $request->id)->get();
        return $datajurnal->toJson(JSON_PRETTY_PRINT);
    }
    public function detail($id)
    {
        $datajurnal = M_jurnalumum::where('notrans', $id)->get();
        return view('pembelian.create')->with(['datajurnal' => $datajurnal]);
    }
    public function destroy($id)
    {
        $jurnalumum = M_jurnalumum::find($id);
        $jurnalumum->delete();
        M_lapjurnal::where('notrans', $id)->delete();
        return redirect()->route('pembelian.retur')
            ->with('success', 'Transaksi deleted successfully');

        //
    }
    public function trpembelian()
    {
        $pembelian = M_pembelian::where('kdpst', Session::get('globalkdpst'))->orderBy('id', 'DESC')->where('f_statustransaksi', '0')->limit(50)->get();
        return view('pembelian.trpembelian')->with(['pembelian' => $pembelian]);
    }
    public function trdetail($id)
    {
        $data = M_detailpembelian::where('idpembelian', $id)
            ->with('get_barang')->get();
        return view("pembelian.detail")->with('data', $data);
    }
    public function trreturdetail($id)
    {
        $data = M_returdetailpembelian::where('idretur', $id)
            ->with('get_barang')->get();

        return view("pembelian.returdetail")->with('data', $data);
    }
    public function hapuspembelian(Request $request)
    {
        //cek retur
        $cek = M_returpembelian::where('idpembelian', $request->id)->where('f_statustransaksi', '0')->get();
        if ($cek->count()==0) {
            $pembelian = M_pembelian::find($request->id);
            $notrans = $pembelian->notrans;
            $pembelian->f_statustransaksi = "1";
            $pembelian->emailhapus = Session::get('email');
            $pembelian->save();

            M_detailpembelian::where('idpembelian', $request->id)->delete();
            M_jurnalumum::where('notrans', $notrans)->delete();
            M_lapjurnal::where('notrans', $notrans)->delete();
            Alert::success('pembelian sukses dihapus');
            return redirect()->route('pembelian.retur')
                ->with('success', 'Transaksi Hapus Sukses');
        } else {
            Alert::success('gagal dihapus, karena masih ada transaksi retur yang aktif');
            return redirect()->back();
        }
    }
    public function caribarang(Request $request)
    {

        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
            where('stok.idlokasi', "TOKO")->
            where('barang.namabarang', 'like', '%aa%')->
            where('stok.stok', '>=', 0)->
            orderby('namabarang')->get();

        return view('pembelian.formbarang', ['barang' => $barang, 'jenisharga' => $request->jenisharga]);
        //
    }
    public function fetch(Request $request)
    {

        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
            where('stok.idlokasi', "TOKO")->
            where('barang.namabarang', 'like', '%' . $request->namabarang . '%')->
            where('stok.stok', '>=', 0)->
            orderby('namabarang')->get();
       
        return view('pembelian.fetch', ['barang' => $barang]);
        //
    }
    public function retur()
    {
        return view('pembelian.retur');
    }

    public function fetchretur(Request $request)
    {
        if ($request->kriteria == "nofaktur") {
            $pembelian = M_pembelian::join('supplier', 'pembelian.idsupplier', '=', 'supplier.idsupplier')
                ->where('pembelian.nofaktur', $request->keyword)->orderBy('id', 'DESC')
                ->where('f_statustransaksi', '0')
                ->get();
        } else if ($request->kriteria == "nobatch") {
            $pembelian = M_pembelian::join('supplier', 'pembelian.idsupplier', '=', 'supplier.idsupplier')
                ->join('detailpembelian', 'pembelian.id', '=', 'detailpembelian.idpembelian')
                ->where('detailpembelian.nobatch', $request->keyword)->orderBy('pembelian.id', 'DESC')
                ->where('f_statustransaksi', '0')
                ->select('pembelian.*', 'supplier.namasupplier')
                ->get();
        } 
        else if ($request->kriteria == "namaproduk") {
            $pembelian = M_pembelian::join('supplier', 'pembelian.idsupplier', '=', 'supplier.idsupplier')
                ->join('detailpembelian', 'pembelian.id', '=', 'detailpembelian.idpembelian')
                ->join('barang', 'detailpembelian.kdbarang', '=', 'barang.kdbarang')
                ->where('barang.namabarang', 'like', '%' . $request->keyword . '%')->orderBy('id', 'DESC')
                ->where('f_statustransaksi', '0')
                ->select('pembelian.*', 'supplier.namasupplier')
                ->get();
        } 
        else if ($request->kriteria == "noinvoice") {
            $pembelian = M_pembelian::join('supplier', 'pembelian.idsupplier', '=', 'supplier.idsupplier')
                ->join('detailpembelian', 'pembelian.id', '=', 'detailpembelian.idpembelian')
                ->join('barang', 'detailpembelian.kdbarang', '=', 'barang.kdbarang')
                ->where('pembelian.id', 'like', '%' . $request->keyword . '%')->orderBy('id', 'DESC')
                ->where('f_statustransaksi', '0')
                ->select('pembelian.*', 'supplier.namasupplier')
                ->get();
               
        } 
        else {
            $pembelian = M_pembelian::join('supplier', 'pembelian.idsupplier', '=', 'supplier.idsupplier')
                ->where('supplier.namasupplier', 'like', '%' . $request->keyword . '%')->orderBy('id', 'DESC')
                ->where('f_statustransaksi', '0')
                ->get();

        }
        return view('pembelian.fetchretur', ['pembelian' => $pembelian]);
        //
    }
    public function listretur($id)
    {
        $data = M_returpembelian::with('get_pembelian')->where('idpembelian', $id)->where('f_statustransaksi', '0')->get();
        return view('pembelian.listretur')->with(['retur' => $data, 'idpembelian' => $id]);
    }
    public function inbond($id)
    {
        $lokasi = M_stoklokasi::where('f_default', '0')->get();
        $kdtransaksi = "TR0001" . Session::get('globalkdpst');
        $data = M_pembelian::find($id);
        $dataorder = M_detailpembelian::with('get_barang', 'get_pembelian')->where('idpembelian', $id)->get();
        return view('pembelian.inbond')->with(['pembelian' => $data, 'datapembelian' => $dataorder, 'lokasi' => $lokasi, 'kdtransaksi' => $kdtransaksi]);
    }
    public function inretur($id)
    {
        $lokasi = M_stoklokasi::where('f_default', '0')->get();
        $kdtransaksi = "TR0001" . Session::get('globalkdpst');
        $data = M_returdetailpembelian::where('idretur',$id)->first();
        $dataorder = M_returdetailpembelian::with('get_barang')->where('idretur', $id)->get();
        return view('pembelian.inretur')->with(['pembelian' => $data, 'datapembelian' => $dataorder, 'lokasi' => $lokasi, 'kdtransaksi' => $kdtransaksi]);
    }
    public function approveretur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idpembelian' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            DB::beginTransaction();
            try {
                $retur = new M_returpembelian;
                $retur->tgltrans = $request->tgltrans;
                $retur->email = Session::get('email');
                $retur->idpembelian = $request->idpembelian;
                $retur->save();
                $lastid = $retur->id;

                $jml = count($request->checkretur);

                for ($i = 0; $i < $jml; $i++) {
                    M_returdetailpembelian::create([
                        'idretur' => $lastid,
                        'iddetailpembelian' => $request->id[$request->checkretur[$i]],
                        'kdbarang' => $request->kdbarang[$request->checkretur[$i]],
                        'nobatch' => $request->nobatch[$request->checkretur[$i]],
                        'tglkadaluarsa' => $request->tglkadaluarsa[$request->checkretur[$i]],
                        'qty' => $request->qty[$request->checkretur[$i]],
                        'idlokasi' => $request->idlokasi[$request->checkretur[$i]],
                    ]);
                }
                Alert::success("retur sukses");
                Session::put('id', $lastid);
                DB::commit();
                return Redirect()->route('pembelian.invoiceretur');
            } catch (\Exception $e) {
                Alert::error('Error', $e->getMessage());
                DB::rollback();
                return redirect()->back()->with('error', $e->getMessage());
            }

        }
    }
    public function approveinretur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idretur'=> 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            DB::beginTransaction();
            try {
                $jml = count($request->checkretur);

                for ($i = 0; $i < $jml; $i++) {
                    M_inreturpembelian::create([
                        'idretur' => $request->idretur,
                        'iddetailpembelian' => $request->id[$request->checkretur[$i]],
                        'kdbarang' => $request->kdbarang[$request->checkretur[$i]],
                        'qty' => $request->qty[$request->checkretur[$i]],
                        'idlokasi' => $request->idlokasi[$request->checkretur[$i]],
                    ]);
                }
                Alert::success("In Retur sukses");
                DB::commit();
                return Redirect()->route('pembelian.retur');
            } catch (\Exception $e) {
                Alert::error('Error', $e->getMessage());
                DB::rollback();
                return redirect()->back()->with('error', $e->getMessage());
            }

        }
    }
    public function formretur(Request $request)
    {

        $barang = M_stok::with('get_barang', 'get_lokasi')->where('kdbarang', $request['kdbarang'])->get();
        return view('pembelian.formretur', ['barang' => $barang, 'idrecord' => $request['idrecord']]);
    }
    public function forminretur(Request $request)
    {

        $barang = M_returdetailpembelian::where('kdbarang', $request['kdbarang'])->first();
        return view('pembelian.forminretur', ['barang' => $barang, 'idrecord' => $request['idrecord']]);
    }
    public function invoiceretur()
    {
        $retur = M_returpembelian::find(Session::get('id'));
        $detailretur = M_returdetailpembelian::with('get_barang', 'get_retur')->where('idretur', Session::get('id'))->get();
        return view('pembelian.invoiceretur')->with(['retur' => $retur, 'detailretur' => $detailretur]);
    }
    public function hapusreturpembelian(Request $request)
    {
        try 
        {
        M_returpembelian::find($request->id)->delete();
        M_returdetailpembelian::where('idretur', $request->id)->delete();
        Alert::success('retur sukses dihapus');
        return redirect()->route('pembelian.retur')
            ->with('success', 'Transaksi Hapus Sukses');
        }
        catch (\Exception $e) {
            Alert::error('Error', 'Udah ada transaksi, tidak bisa dihapus ');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
