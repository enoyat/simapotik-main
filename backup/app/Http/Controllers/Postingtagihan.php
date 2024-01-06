<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_mstagihan;
use App\Models\M_mahasiswa;
use App\Models\M_jurnaltagihan;
use App\Models\M_jurnalpembayaran;
use App\Models\M_lapjurnal;

use App\Models\M_mstransaksi;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Response;
use Validator;
use Hash;
use Session;
use Carbon;

class Postingtagihan extends Controller
{
    public function index() {
        Session::forget('nim');
        Session::forget('namahasiswa');

        return view('postingtagihan.index');
    }
    public function create() {
        return view('postingtagihan.create');
    }
    function gennotrans() {
        $kode =DB::table('jurnaltagihan')->max('notagihan');    
                if(empty($kode)) {
                $noUrut = 1;
        }
        else {
            $noUrut = substr($kode, 3);
            $noUrut++;            
        }
        $char = "JTG";
        $newID = $char . sprintf("%017s", $noUrut);
        return $newID;
    }
    public function store(Request $request) {
        $validator = \Validator::make($request->all(), [ 
            'nim' => 'required',
            'kdtransaksi' => 'required',
            'jumlah' => 'required',
            'kdtagihan' => ['required',
                         Rule::unique('jurnaltagihan')
                                    ->where('kdtagihan', $request->kdtagihan)
                                    ->where('nim', $request->nim)
                            ]
          ]);

        if ($validator->fails()) {
            return '{"status":"0"}';
            //return response()->json($validator->errors(), 400);                       
        }
        else {
            $lastid= Postingtagihan::gennotrans();
            $jurnaltagihan = new M_jurnaltagihan;
            $jurnaltagihan->notagihan = $lastid;
            $jurnaltagihan->kdpst=Session::get('kdpst');
            $jurnaltagihan->kdtagihan = $request->kdtagihan;
            $jurnaltagihan->tgltrans = Carbon\Carbon::now();
            $jurnaltagihan->nim = $request->nim;
            $jurnaltagihan->jumlah = $request->jumlah;
            $jurnaltagihan->keterangan = $request->keterangan;
            $jurnaltagihan->kdtransaksi = $request->kdtransaksi;  
            $jurnaltagihan->kdtransaksilawan = $request->kdtransaksilawan;                        
            $datatransaksi=M_mstransaksi::find($request->kdtransaksi);
            $jurnaltagihan->debet = $datatransaksi->kdakun_d;
            $jurnaltagihan->kredit = $datatransaksi->kdakun_k;
            $jurnaltagihan->modebayar = $request->modebayar;
            $jurnaltagihan->userid = Session::get('email');
            $jurnaltagihan->save();   
            return '{"status":"1"}';
        }
    }
    public function formintrmahasiswa() {
        $mstagihans=M_mstagihan::get();
        return view('postingtagihan.formintrmahasiswa')->with(['mstagihans'=>$mstagihans]);
    }
    public function tabelbayar() {
        $jurnaltagihans=M_jurnaltagihan::where(['nim'=>Session::get('nim'), 'f_aktif'=>'0'])->get();
        return view('postingtagihan.tabelbayar')->with(['success'=>'List Tagihan','jurnaltagihans'=>$jurnaltagihans]);
    }
    public function ambilnominal(Request $request){
        $nominal = M_mstagihan::where('kdtagihan',$request->id)->get();
        return $nominal->toJson(JSON_PRETTY_PRINT);
    }
    public function posting(Request $request) {
            $datatagihan=M_jurnaltagihan::where('nim',Session::get('nim'))->update(['f_aktif'=>'1']);
            return redirect()->route('postingtagihan.index')
                   ->with('success', 'data tagihan sukses diaktifkan');      
    }

    public function batal() {
        return view('postingtagihan.batal');
    }
    public function carijurnal(Request $request){
        $datajurnal = M_jurnaltagihan::where('notagihan',$request->id)->get();                    
        return $datajurnal->toJson(JSON_PRETTY_PRINT);
    }
    public function detail($id){
        $datajurnal = M_jurnaltagihan::where('notagihan',$id)->get();                    
        return view('postingtagihan.detail')->with(['datajurnal'=>$datajurnal]);
    }
    public function prosesbatal(Request $request){
        $cekbayar=M_jurnalpembayaran::where('notagihan',$request->notagihan)->get();
        if(count($cekbayar)>0){            
            return redirect()->route('postingtagihan.batal')
                       ->with('success', 'data tagihan ini sudah ada pembayaran, silahkan batalkan pembayaran terlebih dahulu');
        }           
        else {
            M_jurnaltagihan::where('notagihan',$request->notagihan)->delete();
            M_lapjurnal::where('notrans',$request->notagihan)->delete();

            return redirect()->route('postingtagihan.batal')
                       ->with('success', 'Pembatatalan tagihan sukses');            
        }
    }
}
