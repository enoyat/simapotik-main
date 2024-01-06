<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_mstransaksi;
use App\Models\M_jurnalumum;
use App\Models\M_lapjurnal;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Redirect;

use Response;
use Validator;
use Hash;
use Session;
use Carbon;
use PDF;
class Trkeuangan extends Controller
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
        $mstransaksis=M_mstransaksi::where(['kdktgtransaksi'=>'TRKEU','kdpst'=>Session::get('globalkdpst'),'aktif'=>'1'])->orderby('namatransaksi')->get();
        return view('trkeuangan.index')->with(['mstransaksis'=>$mstransaksis]);
    }
    function gennotrans() {
        $kode =DB::table('jurnalumum')->max('notrans');
                if(empty($kode)) {
                $noUrut = 1;
        }
        else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = "JUM";
        $newID = $char . sprintf("%017s", $noUrut);
        return $newID;
    }
    public function store(Request $request) {
        $validator = \Validator::make($request->all(), [
            'tgltrans' => 'required',
            'kdtransaksi' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required'
          ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        else {
            $lastid= Trkeuangan::gennotrans();
            $jurnalumum = new M_jurnalumum;
            $jurnalumum->notrans = $lastid;
            $jurnalumum->kdpst=Session::get('globalkdpst');
            $jurnalumum->tgltrans = $request->tgltrans;
            $jurnalumum->jumlah = $request->jumlah;
            $jurnalumum->keterangan = $request->keterangan;
            $jurnalumum->kdtransaksi = $request->kdtransaksi;
            $datatransaksi=M_mstransaksi::find($request->kdtransaksi);
            $jurnalumum->debet = $datatransaksi->kdakun_d;
            $jurnalumum->kredit = $datatransaksi->kdakun_k;
            $jurnalumum->f_post = '0';
            $jurnalumum->userid = Session::get('email');
            $jurnalumum->save();

            Session::put('notrans',$lastid);
            return Redirect()->route('trkeuangan.invoice');
        }
    }
    public function invoice() {
        $data = M_jurnalumum::where('notrans',Session::get('notrans'))->get();
        return view('trkeuangan.invoice')->with(['jurnalumum'=>$data]);
    }
    public function createPDF() {
      // retreive all records from db
      $data = M_jurnalumum::where('notrans',Session::get('notrans'))->get();

      // share data to view
      view()->share('jurnalumum',$data);
      $pdf = PDF::loadView('trkeuangan.invoicepdf', $data);
      return $pdf->stream('invoice.pdf');
      // download PDF file with download method
      //$pdf->download('invoice.pdf');

    }
    public function batal() {
        return view('trkeuangan.batal');
    }
    public function carijurnal(Request $request){
        $datajurnal = M_jurnalumum::where('notrans',$request->id)->get();
        return $datajurnal->toJson(JSON_PRETTY_PRINT);
    }
    public function detail($id){
        $datajurnal = M_jurnalumum::where('notrans',$id)->get();
        return view('trkeuangan.create')->with(['datajurnal'=>$datajurnal]);
    }
    public function destroy($id)
    {
        $jurnalumum=M_jurnalumum::find($id);
        $jurnalumum->delete();
        M_lapjurnal::where('notrans',$id)->delete();
        return redirect()->route('trkeuangan.batal')
                        ->with('success','Transaksi deleted successfully');
        //
    }
}
