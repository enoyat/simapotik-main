<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_customer;
use App\Models\M_detailpenjualan;
use App\Models\M_detailresep;
use App\Models\M_jurnalumum;
use App\Models\M_lapjurnal;
use App\Models\M_mstransaksi;
use App\Models\M_penjualan;
use App\Models\M_returdetailpenjualan;
use App\Models\M_returpenjualan;
use App\Models\M_stok;
use App\Models\M_stoklokasi;
use App\Models\M_toko;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;
use Response;

class Penjualan extends Controller
{
    public $total;

    public static function kekata($x)
    {
        $x = abs($x);
        $angka = array(
            "",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan",
            "sepuluh",
            "sebelas"
        );
        $temp = "";
        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = penjualan::kekata($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = penjualan::kekata($x / 10) . " puluh" . penjualan::kekata($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . penjualan::kekata($x - 100);
        } else if ($x < 1000) {
            $temp = penjualan::kekata($x / 100) . " ratus" . penjualan::kekata($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . penjualan::kekata($x - 1000);
        } else if ($x < 1000000) {
            $temp = penjualan::kekata($x / 1000) . " ribu" . penjualan::kekata($x % 1000);
        } else if ($x < 1000000000) {
            $temp = penjualan::kekata($x / 1000000) . " juta" . penjualan::kekata($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = penjualan::kekata($x / 1000000000) . " milyar" . penjualan::kekata(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = penjualan::kekata($x / 1000000000000) . " trilyun" . penjualan::kekata(fmod($x, 1000000000000));
        }
        return $temp;
    }

    public static function terbilang($x, $style = 4)
    {
        if ($x < 0) {
            $hasil = "minus " . trim(penjualan::kekata($x));
        } else {
            $hasil = trim(penjualan::kekata($x));
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
        $kdtransaksi = "TR0002";
        $customer = M_customer::get();
        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->where('stok.idlokasi', "TOKO")->where('stok.stok', '>', 0)->get();

        $mstransaksis = M_mstransaksi::orderby('namatransaksi')->get();
        return view('penjualan.index')->with(['mstransaksis' => $mstransaksis, 'barang' => $barang, 'kdtransaksi' => $kdtransaksi, 'customer' => $customer]);
    }
    public function baru()
    {
        Session::forget('cart');
        Session::forget('id');
        return redirect()->route('penjualan');
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
        return view('penjualan.cartview')->with(['data' => $data]);
    }
    public function carthapus(Request $request)
    {
        $cart = Session::get('cart');
        unset($cart[$request->idx]);
        $cart = array_values($cart);
        Session::put('cart', $cart);
        return view('penjualan.cartview');
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
                'idcustomer' => 'required',
                'total' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            } else {
                $cart = Session::get('cart');
                $lastid = Penjualan::gennotrans();
                if (empty($request->modebayar)) {
                    $modebayar = "TUNAI";
                } else {
                    $modebayar = "NONTUNAI";
                }

                $penjualan = new M_penjualan;
                $penjualan->tgltrans = Carbon::now();
                $penjualan->jam = date("h:i");
                $penjualan->idcustomer = $request->idcustomer;
                $penjualan->total = $request->total;
                $penjualan->email = Session::get('email');
                $penjualan->tipepenjualan = $request->tipepenjualan;
                $penjualan->modebayar = $modebayar;

                $penjualan->save();
                $lastid = $penjualan->id;
                $cart = Session::get('cart');

                foreach ($cart as $key => $value) {
                    M_detailpenjualan::create([
                        'idpenjualan' => $lastid,
                        'kdbarang' => $value['kdbarang'],
                        'qty' => $value['qty'],
                        'harga' => $value['harga'],
                        'diskonpersen' => $value['diskonpersen'],
                        'diskon' => $value['diskon'],
                        'jumlah' => $value['jumlah'],
                        'idlokasi' => 'TOKO',
                    ]);
                }


                Session::forget('cart');
                Session::put('id', $lastid);
                DB::commit();
                return Redirect()->route('penjualan.invoice');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Error', $e->getMessage());
            return Redirect()->back()->withInput();
        }
    }
    public function invoice(Request $request)
    {
        $toko = M_toko::first();
        $datapenjualan = M_penjualan::find($request->id);
        $kategori = $datapenjualan->get_customer->kategori;
        $data = M_detailpenjualan::with('get_barang', 'get_penjualan')->where('idpenjualan', $request->id)->get();
        if ($kategori == "khusus") {
            return view('penjualan.invoicekhusus')->with(['penjualan' => $data, 'datapenjualan' => $datapenjualan]);
        } else {
            return view('penjualan.invoice')->with(['penjualan' => $data, 'datapenjualan' => $datapenjualan, 'toko'=>$toko]);
        }
    }

    public function batal()
    {
        return view('penjualan.batal');
    }
    public function carijurnal(Request $request)
    {
        $datajurnal = M_jurnalumum::where('notrans', $request->id)->get();
        return $datajurnal->toJson(JSON_PRETTY_PRINT);
    }
    public function detail($id)
    {
        $datajurnal = M_jurnalumum::where('notrans', $id)->get();
        return view('penjualan.create')->with(['datajurnal' => $datajurnal]);
    }
    public function destroy($id)
    {
        $jurnalumum = M_jurnalumum::find($id);
        $jurnalumum->delete();
        M_lapjurnal::where('notrans', $id)->delete();
        return redirect()->route('penjualan.batal')
            ->with('success', 'Transaksi deleted successfully');
        //
    }
    public function trpenjualan()
    {
        $penjualan = M_penjualan::orderBy('id', 'DESC')->where('f_statustransaksi', '0')->get();
        return view('penjualan.trpenjualan')->with(['penjualan' => $penjualan]);
    }
    public function trdetail($id)
    {
        $data = M_detailpenjualan::where('idpenjualan', $id)
            ->with('get_barang')->get();
        return view("penjualan.detail")->with('data', $data);
    }
    public function trdetailresep($id)
    {
        $data = M_detailresep::with('get_jenispasien', 'get_poly', 'get_dokter')->where('idpenjualan', $id)->get();
        return view("penjualan.detailresep")->with('data', $data);
    }
    public function hapuspenjualan(Request $request)
    {
        $cek = M_returpenjualan::where('idpenjualan', $request->id)->where('f_statustransaksi', '0')->get();
        if ($cek->count() == 0) {
            $penjualan = M_penjualan::find($request->id);
            $notrans = $penjualan->notrans;
            $penjualan->f_statustransaksi = "1";
            $penjualan->emailhapus = Session::get('email');
            $penjualan->save();
            M_detailpenjualan::where('idpenjualan', $request->id)->delete();
            M_jurnalumum::where('notrans', $notrans)->delete();
            M_lapjurnal::where('notrans', $notrans)->delete();
            return redirect()->route('penjualan.retur')
                ->with('success', 'Transaksi Hapus Sukses');
        } else {
            Alert::success('gagal dihapus, karena masih ada transaksi retur yang aktif');
            return redirect()->back();
        }
    }
    public function caribarang(Request $request)
    {

        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->where('stok.idlokasi', "TOKO")->where('stok.stok', '>', 0)->orderby('namabarang')->get();

        return view('penjualan.formbarang', ['barang' => $barang, 'jenisharga' => $request->jenisharga]);
        //
    }
    public function fetch(Request $request)
    {

        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->where('stok.idlokasi', "TOKO")->where('barang.namabarang', 'like', '%' . $request->namabarang . '%')->where('stok.stok', '>', 0)->orderby('namabarang')->get();

        return view('penjualan.fetch', ['barang' => $barang]);
        //
    }
    public function trreturdetail($id)
    {
        $data = M_returdetailpenjualan::where('idretur', $id)
            ->with('get_barang')->get();

        return view("penjualan.returdetail")->with('data', $data);
    }
    public function retur()
    {
        return view('penjualan.retur');
    }

    public function fetchretur(Request $request)
    {
        if ($request->kriteria == "nofaktur") {
            $penjualan = M_penjualan::join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                ->where('penjualan.id', $request->keyword)->orderBy('id', 'DESC')
                ->where('f_statustransaksi', '0')
                ->get();
        } else if ($request->kriteria == "namabarang") {
            $penjualan = M_penjualan::join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                ->join('detailpenjualan', 'penjualan.id', '=', 'detailpenjualan.idpenjualan')
                ->join('barang', 'detailpenjualan.kdbarang', '=', 'barang.kdbarang')
                ->leftjoin('detailresep', 'detailresep.idpenjualan', '=', 'penjualan.id')
                ->leftjoin('dokter', 'detailresep.iddokter', '=', 'dokter.iddokter')
                ->where('barang.namabarang', 'like', '%' . $request->keyword . '%')->orderBy('penjualan.id', 'DESC')
                ->whereBetween('penjualan.tgltrans', [$request->tglmulai, $request->tglakhir])
                ->where('f_statustransaksi', '0')
                ->select('penjualan.*', 'customer.namacustomer', 'detailresep.namapasien', 'dokter.namadokter')
                ->get();
        } else if ($request->kriteria == "resep") {
            $penjualan = M_penjualan::join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                ->join('detailpenjualan', 'penjualan.id', '=', 'detailpenjualan.idpenjualan')
                ->join('barang', 'detailpenjualan.kdbarang', '=', 'barang.kdbarang')
                ->join('detailresep', 'detailresep.idpenjualan', '=', 'penjualan.id')
                ->where('detailresep.noresep', 'like', '%' . $request->keyword . '%')->orderBy('penjualan.id', 'DESC')
                ->whereBetween('penjualan.tgltrans', [$request->tglmulai, $request->tglakhir])
                ->where('f_statustransaksi', '0')
                ->select('penjualan.*', 'customer.namacustomer')
                ->get();
        } else if ($request->kriteria == "namadokter") {

            $penjualan = M_penjualan::join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                ->join('detailpenjualan', 'penjualan.id', '=', 'detailpenjualan.idpenjualan')
                ->join('barang', 'detailpenjualan.kdbarang', '=', 'barang.kdbarang')
                ->join('detailresep', 'detailresep.idpenjualan', '=', 'penjualan.id')
                ->join('dokter', 'detailresep.iddokter', '=', 'dokter.iddokter')
                ->where('dokter.namadokter', 'like', '%' . $request->keyword . '%')->orderBy('penjualan.id', 'DESC')
                ->whereBetween('penjualan.tgltrans', [$request->tglmulai, $request->tglakhir])
                ->where('f_statustransaksi', '0')
                ->select('penjualan.*', 'dokter.*', 'customer.namacustomer')
                ->get();
        } else if ($request->kriteria == "pasien") {
            $penjualan = M_penjualan::join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                ->join('detailpenjualan', 'penjualan.id', '=', 'detailpenjualan.idpenjualan')
                ->join('barang', 'detailpenjualan.kdbarang', '=', 'barang.kdbarang')
                ->join('detailresep', 'detailresep.idpenjualan', '=', 'penjualan.id')
                ->where('detailresep.namapasien', 'like', '%' . $request->keyword . '%')->orderBy('penjualan.id', 'DESC')
                ->whereBetween('penjualan.tgltrans', [$request->tglmulai, $request->tglakhir])
                ->where('f_statustransaksi', '0')
                ->select('penjualan.*', 'customer.namacustomer')
                ->get();
        } else {
            $penjualan = M_penjualan::join('customer', 'penjualan.idcustomer', '=', 'customer.idcustomer')
                ->where('customer.namacustomer', 'like', '%' . $request->keyword . '%')->orderBy('id', 'DESC')
                ->whereBetween('penjualan.tgltrans', [$request->tglmulai, $request->tglakhir])
                ->where('f_statustransaksi', '0')
                ->get();
        }

        return view('penjualan.fetchretur', ['penjualan' => $penjualan]);
        //
    }
    public function listretur($id)
    {
        $data = M_returpenjualan::with('get_penjualan')->where('idpenjualan', $id)->where('f_statustransaksi', '0')->get();
        return view('penjualan.listretur')->with(['retur' => $data, 'idpenjualan' => $id]);
    }
    public function inbond($id)
    {
        $lokasi = M_stoklokasi::where('f_default', '0')->get();
        $kdtransaksi = "TR0001";
        $data = M_penjualan::find($id);
        $dataorder = M_detailpenjualan::with('get_barang', 'get_penjualan')->where('idpenjualan', $id)->get();
        return view('penjualan.inbond')->with(['penjualan' => $data, 'datapenjualan' => $dataorder, 'lokasi' => $lokasi, 'kdtransaksi' => $kdtransaksi]);
    }
    public function approveretur(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idpenjualan' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            DB::beginTransaction();
            try {
                $retur = new M_returpenjualan;
                $retur->tgltrans = $request->tgltrans;
                $retur->email = Session::get('email');
                $retur->idpenjualan = $request->idpenjualan;
                $retur->save();
                $lastid = $retur->id;

                $jml = count($request->checkretur);

                for ($i = 0; $i < $jml; $i++) {
                    M_returdetailpenjualan::create([
                        'idretur' => $lastid,
                        'iddetailpenjualan' => $request->id[$request->checkretur[$i]],
                        'kdbarang' => $request->kdbarang[$request->checkretur[$i]],
                        'qty' => $request->qty[$request->checkretur[$i]],
                        'idlokasi' => 'TOKO',
                    ]);
                }
                Alert::success("retur sukses");
                Session::put('id', $lastid);
                DB::commit();
                return Redirect()->route('penjualan.invoiceretur');
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
        return view('penjualan.formretur', ['barang' => $barang, 'idrecord' => $request['idrecord']]);
    }
    public function invoiceretur()
    {
        $retur = M_returpenjualan::find(Session::get('id'));
        $detailretur = M_returdetailpenjualan::with('get_barang', 'get_detailpenjualan')->where('idretur', Session::get('id'))->get();
        return view('penjualan.invoiceretur')->with(['retur' => $retur, 'detailretur' => $detailretur]);
    }
    public function hapusreturpenjualan(Request $request)
    {
        $retur = M_returpenjualan::find($request->id);
        $retur->f_statustransaksi = "1";
        $retur->emailhapus = Session::get('email');
        $retur->save();
        M_returdetailpenjualan::where('idretur', $request->id)->delete();
        Alert::success('retur sukses dihapus');
        return redirect()->route('penjualan.retur')
            ->with('success', 'Transaksi Sukses');
    }
    public function ubahtipepenjualan(Request $request)
    {
        M_penjualan::where('id', $request->id)->update([
            'tipepenjualan' => "T",
            'tgltrans' => Carbon::now(),
            'jam' => date("h:i"),
            'email' => Session::get('email')


        ]);

        Alert::success('Tipe Penjualan Berhasil Diubah');
        return redirect()->route('penjualan.retur')
            ->with('success', 'Transaksi Sukses');
    }
}
