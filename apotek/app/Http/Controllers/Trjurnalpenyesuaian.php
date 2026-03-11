<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_mstransaksi;
use App\Models\M_jurnalumum;
use App\Models\M_lapjurnal;
use App\Models\M_lapjurnalpenyesuaian;
use App\Models\M_jurnalpenyesuaian;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Redirect;

use Response;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\PDF;
class Trjurnalpenyesuaian extends Controller
{
    public static function kekata($x) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x <12) {
            $temp = " ". $angka[$x];
        } else if ($x <20) {
            $temp = Trkeuangan::kekata($x - 10). " belas";
        } else if ($x <100) {
            $temp = Trkeuangan::kekata($x/10)." puluh". Trkeuangan::kekata($x % 10);
        } else if ($x <200) {
            $temp = " seratus" . Trkeuangan::kekata($x - 100);
        } else if ($x <1000) {
            $temp = Trkeuangan::kekata($x/100) . " ratus" . Trkeuangan::kekata($x % 100);
        } else if ($x <2000) {
            $temp = " seribu" . Trkeuangan::kekata($x - 1000);
        } else if ($x <1000000) {
            $temp = Trkeuangan::kekata($x/1000) . " ribu" . Trkeuangan::kekata($x % 1000);
        } else if ($x <1000000000) {
            $temp = Trkeuangan::kekata($x/1000000) . " juta" . Trkeuangan::kekata($x % 1000000);
        } else if ($x <1000000000000) {
            $temp = Trkeuangan::kekata($x/1000000000) . " milyar" . Trkeuangan::kekata(fmod($x,1000000000));
        } else if ($x <1000000000000000) {
            $temp = Trkeuangan::kekata($x/1000000000000) . " trilyun" . Trkeuangan::kekata(fmod($x,1000000000000));
        }
            return $temp;
    }


    public static function terbilang($x, $style=4) {
        if($x<0) {
            $hasil = "minus ". trim(Trkeuangan::kekata($x));
        } else {
            $hasil = trim(Trkeuangan::kekata($x));
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

    public function index() {
        $mstransaksis=M_mstransaksi::where(['kdktgtransaksi'=>'TRSES','kdpst'=>Session::get('globalkdpst')])->orderby('namatransaksi')->get();
        return view('trjurnalpenyesuaian.index')->with(['mstransaksis'=>$mstransaksis]);
    }
    function gennotrans() {
        $kode =DB::table('jurnalpenyesuaian')->max('notrans');
                if(empty($kode)) {
                $noUrut = 1;
        }
        else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = "JUP";
        $newID = $char . sprintf("%017s", $noUrut);
        return $newID;
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'bulan' => 'required',
            'tahun' => 'required',
            'kdtransaksi' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required'
          ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        else {
            $kdperiode=$request->bulan.$request->tahun;
            $lastid= Trjurnalpenyesuaian::gennotrans();
            $jurnalpenyesuaian = new M_jurnalpenyesuaian;
            $jurnalpenyesuaian->notrans = $lastid;
            $jurnalpenyesuaian->kdpst=Session::get('globalkdpst');
            $jurnalpenyesuaian->kdperiode = $kdperiode;
            $jurnalpenyesuaian->tgltrans =Carbon::now();
            $jurnalpenyesuaian->jumlah = $request->jumlah;
            $jurnalpenyesuaian->keterangan = $request->keterangan;
            $jurnalpenyesuaian->kdtransaksi = $request->kdtransaksi;
            $datatransaksi=M_mstransaksi::find($request->kdtransaksi);
            $jurnalpenyesuaian->debet = $datatransaksi->kdakun_d;
            $jurnalpenyesuaian->kredit = $datatransaksi->kdakun_k;
            $jurnalpenyesuaian->f_post = '0';
            $jurnalpenyesuaian->userid = Session::get('email');

            $jurnalpenyesuaian->save();

            Session::put('notrans',$lastid);
            return Redirect()->route('trjurnalpenyesuaian.invoice');
        }
    }
    public function invoice() {
        $data = M_jurnalpenyesuaian::where('notrans',Session::get('notrans'))->get();
        return view('trjurnalpenyesuaian.invoice')->with(['jurnalumum'=>$data]);
    }
    public function createPDF() {
      // retreive all records from db
      $data = M_jurnalpenyesuaian::where('notrans',Session::get('notrans'))->get();

      // share data to view
      view()->share('jurnalpenyesuaian',$data);
      $pdf = PDF::loadView('jurnalpenyesuaian.invoicepdf', $data);
      return $pdf->stream('invoice.pdf');
      // download PDF file with download method
      //$pdf->download('invoice.pdf');

    }
    public function batal() {
        return view('trjurnalpenyesuaian.batal');
    }
    public function carijurnal(Request $request){
        $datajurnal = M_jurnalpenyesuaian::where('notrans',$request->id)->get();
        return $datajurnal->toJson(JSON_PRETTY_PRINT);
    }
    public function detail($id){
        $datajurnal = M_jurnalpenyesuaian::where('notrans',$id)->get();
        return view('trjurnalpenyesuaian.create')->with(['datajurnal'=>$datajurnal]);
    }
    public function destroy($id)
    {
        $jurnalpenyesuaian=M_jurnalpenyesuaian::find($id);
        $jurnalpenyesuaian->delete();
        M_lapjurnalpenyesuaian::where('notrans',$id)->delete();
        return redirect()->route('trjurnalpenyesuaian.batal')
                        ->with('success','Transaksi deleted successfully');
        //
    }
}
