<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use App\Models\M_detailorder;
use App\Models\M_detailpembelian;
use App\Models\M_jurnalumum;
use App\Models\M_lapjurnal;
use App\Models\M_mstransaksi;
use App\Models\M_order;
use App\Models\M_pembelian;
use App\Models\M_stoklokasi;
use App\Models\M_supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;
use Redirect;
use Response;

class OrderController extends Controller
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
            $temp = OrderController::kekata($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = OrderController::kekata($x / 10) . " puluh" . OrderController::kekata($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . OrderController::kekata($x - 100);
        } else if ($x < 1000) {
            $temp = OrderController::kekata($x / 100) . " ratus" . OrderController::kekata($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . OrderController::kekata($x - 1000);
        } else if ($x < 1000000) {
            $temp = OrderController::kekata($x / 1000) . " ribu" . OrderController::kekata($x % 1000);
        } else if ($x < 1000000000) {
            $temp = OrderController::kekata($x / 1000000) . " juta" . OrderController::kekata($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = OrderController::kekata($x / 1000000000) . " milyar" . OrderController::kekata(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = OrderController::kekata($x / 1000000000000) . " trilyun" . OrderController::kekata(fmod($x, 1000000000000));
        }
        return $temp;
    }

    public static function terbilang($x, $style = 4)
    {
        if ($x < 0) {
            $hasil = "minus " . trim(OrderController::kekata($x));
        } else {
            $hasil = trim(OrderController::kekata($x));
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
        $kdtransaksi = "TR0001" . Session::get('globalkdpst');
        $supplier = M_supplier::where('kdpst', Session::get('globalkdpst'))->get();
        $lokasi = M_stoklokasi::where('f_default', '0')->get();
        $mstransaksis = M_mstransaksi::orderby('namatransaksi')->get();
        return view('order.index')->with(['mstransaksis' => $mstransaksis,  'kdtransaksi' => $kdtransaksi, 'lokasi' => $lokasi, 'supplier' => $supplier]);
    }
    public function caribarang()
    {

        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
        where('stok.idlokasi', "TOKO")->
        where('barang.namabarang', 'like', '%aa%')->
        orderby('namabarang')->get();

        return view('order.formbarang', ['barang' => $barang]);
        //
    }
    public function fetch(Request $request)
    {

        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
        where('stok.idlokasi', "TOKO")->
        where('barang.namabarang', 'like', '%'.$request->namabarang.'%')->
        orderby('namabarang')->get();

        return view('order.fetch', ['barang' => $barang]);
        //
    }
    public function baru()
    {
        Session::forget('cart');
        Session::forget('id');
        return redirect()->route('order');
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
        return view('order.cartview')->with(['data' => $data]);
    }
    public function carthapus(Request $request)
    {
        $cart = Session::get('cart');
        unset($cart[$request->idx]);
        $cart = array_values($cart);
        Session::put('cart', $cart);
        return view('order.cartview');
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
            'idsupplier' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $cart = Session::get('cart');
            $order = new M_order;
            $order->tgltrans = $request->tgltrans;
            $order->idsupplier = $request->idsupplier;
            $order->total = $request->total;
            $order->kdpst = Session::get('globalkdpst');
            $order->save();
            $lastid = $order->id;
            $cart = Session::get('cart');

            foreach ($cart as $key => $value) {
                M_detailorder::create([
                    'idorder' => $lastid,
                    'kdbarang' => $value['kdbarang'],
                    'qty' => $value['qty'],
                    'harga' => $value['harga'],
                    'jumlah' => $value['jumlah'],
                ]);
            }

            Session::forget('cart');
            Session::put('id', $lastid);
            return Redirect()->route('order.invoice');

        }
    }
    public function invoice()
    {
        $data = M_order::find(Session::get('id'));
        $dataorder = M_detailorder::with('get_barang', 'get_order')->where('idorder', Session::get('id'))->get();
        return view('order.invoice')->with(['order' => $data, 'dataorder' => $dataorder]);
    }
    public function createPDF()
    {
        // retreive all records from db
        $dataorder = M_order::find(Session::get('id'));
        $data = M_jurnalumum::where('notrans', Session::get('notrans'))->get();

        // share data to view
        view()->share('jurnalumum', $data);
        $pdf = PDF::loadView('order.invoicepdf', $data, $dataorder);
        return $pdf->stream('invoice.pdf');
        // download PDF file with download method
        //$pdf->download('invoice.pdf');

    }
    public function batal()
    {
        return view('order.batal');
    }
    public function carijurnal(Request $request)
    {
        $datajurnal = M_jurnalumum::where('notrans', $request->id)->get();
        return $datajurnal->toJson(JSON_PRETTY_PRINT);
    }
    public function detail($id)
    {
        $datajurnal = M_jurnalumum::where('notrans', $id)->get();
        return view('order.create')->with(['datajurnal' => $datajurnal]);
    }
    public function destroy($id)
    {
        $jurnalumum = M_jurnalumum::find($id);
        $jurnalumum->delete();
        M_lapjurnal::where('notrans', $id)->delete();
        return redirect()->route('order.batal')
            ->with('success', 'Transaksi deleted successfully');
        //
    }
    public function trorder()
    {
        $order = M_order::with('get_supplier')
            ->orderBy('id', 'DESC')->get();
           
        return view('order.trorder')->with(['order' => $order]);
    }
    public function trdetail($id)
    {
        $data = M_detailorder::where('idorder', $id)
            ->with('get_barang')->get();
        return view("order.detail")->with('data', $data);
    }
    public function hapusorder(Request $request)
    {
        $order = M_Order::find($request->id);
        $order->delete();
        M_detailorder::where('idorder', $request->id)->delete();
        return redirect()->route('order.trorder')
            ->with('success', 'Transaksi Hapus Sukses');
    }
    public function inbond($id)
    {
        $lokasi = M_stoklokasi::where('f_default', '0')->get();
        $kdtransaksi = "TR0001" . Session::get('globalkdpst');
        $data = M_order::find($id);
        $dataorder = M_detailorder::with('get_barang', 'get_order')->where('idorder', $id)->get();
        return view('order.inbond')->with(['order' => $data, 'dataorder' => $dataorder, 'lokasi' => $lokasi, 'kdtransaksi' => $kdtransaksi]);
    }
    public function approve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idlokasi' => 'required',
            'nofaktur' => 'required',
            'total' => 'required',
            'nobatch' => 'required',
            'tglkadaluarsa' => 'required',
            'idorder' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            DB::beginTransaction();
            try {
                $pembelian = new M_pembelian;
                $pembelian->tgltrans = $request->tgltrans;
                $pembelian->nofaktur = $request->nofaktur;
                $pembelian->idsupplier = $request->idsupplier;
                $pembelian->idlokasi = $request->idlokasi;
                $pembelian->total = $request->totalpembelian;
                $pembelian->ppn = $request->ppn;

                $pembelian->kdpst = Session::get('globalkdpst');
                $pembelian->email = Session::get('email');
                $pembelian->idorder=$request->idorder;
                $pembelian->save();
                $lastid = $pembelian->id;

                $jml = count($request->harga);
                for ($i = 0; $i < $jml; $i++) {
                    M_detailpembelian::create([
                        'idpembelian' => $lastid,
                        'kdbarang' => $request->kdbarang[$i],
                        'nobatch' => $request->nobatch[$i],
                        'tglkadaluarsa' => $request->tglkadaluarsa[$i],
                        'qty' => $request->qty[$i],
                        'harga' => $request->harga[$i],
                        'diskonpersen' => $request->diskonpersen[$i],
                        'diskon' => $request->diskon[$i],
                        'jumlah' => $request->jumlah[$i],
                        'idlokasi' => $request->idlokasi,
                    ]);
                }
                $order = M_order::find($request->idorder);
                $order->f_aktif = '1';
                $order->save();

                $lastidjurnal = OrderController::gennotrans();
                $jurnalumum = new M_jurnalumum;
                $jurnalumum->notrans = $lastidjurnal;
                $jurnalumum->kdpst = Session::get('globalkdpst');
                $jurnalumum->tgltrans = $request->tgltrans;
                $jurnalumum->jumlah = $request->total;
                $jurnalumum->keterangan = "Pembelian " . $request->supplier;
                $jurnalumum->kdtransaksi = $request->kdtransaksi;
                $datatransaksi = M_mstransaksi::find($request->kdtransaksi);
                $jurnalumum->debet = $datatransaksi->kdakun_d;
                $jurnalumum->kredit = $datatransaksi->kdakun_k;
                $jurnalumum->f_post = '0';
                $jurnalumum->userid = Session::get('email');
                $jurnalumum->save();

                $transaksipembelian = M_pembelian::find($lastid);
                $transaksipembelian->f_status = '1';
                $transaksipembelian->notrans = $lastidjurnal;
                $transaksipembelian->save();

                Session::forget('cart');
                Session::put('id', $lastid);
                DB::commit();
                return Redirect()->route('order.invoicepembelian');
            } catch (\Exception $e) {
                Alert::error('Error', $e->getMessage());
                DB::rollback();
                return redirect()->back()->with('error', $e->getMessage());
            }

        }
    }
    public function invoicepembelian()
    {
        $data = M_pembelian::find(Session::get('id'));

        $dataorder = M_detailpembelian::with('get_barang', 'get_pembelian')->where('idpembelian', Session::get('id'))->get();
        return view('order.invoicepembelian')->with(['order' => $data, 'dataorder' => $dataorder]);
    }
    public function rincianorder()
    {
        $data = M_detailpembelian::with('get_barang', 'get_pembelian')->get();

        return view("order.rincianorder")->with('data', $data);
    }
}
