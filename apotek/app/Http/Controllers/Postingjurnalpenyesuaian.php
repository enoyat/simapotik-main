<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_mstagihan;
use App\Models\M_mahasiswa;
use App\Models\M_jurnaltagihan;
use App\Models\M_jurnalumum;
use App\Models\M_jurnalpembayaran;
use App\Models\M_jurnalpenyesuaian;

use App\Models\M_msjurnal;
use App\Models\M_lapjurnal;
use App\Models\M_lapjurnalpenyesuaian;
use App\Models\M_mstransaksi;

use App\Models\M_subtransaksi;
use Illuminate\Validation\Rule;

use Response;
use Validator;
use Hash;
use Session;
use Carbon;

class Postingjurnalpenyesuaian extends Controller
{
    public function getnamabulan($bulan){
        switch($bulan) {
            case("01"):
                return "Januari";
                break;    
            case("02"):
                return "Februari";
                break;    
            case("03"):
                return "Maret";
                break;    
            case("04"):
                return "April";
                break;    
            case("05"):
                return "Mei";
                break;    
            case("06"):
                return "Juni";
                break;    
            case("07"):
                return "Juli";
                break;    
            case("08"):
                return "Agustus";
                break;    
            case("09"):
                return "September";
                break;    
            case("10"):
                return "Oktober";
                break;    
            case("11"):
                return "Nopember";
                break;    
            case("12"):
                return "Desember";
                break;    

        }
    }
    public function index() {
        $msjurnals=M_msjurnal::pluck('namajurnal', 'kdjurnal');
        return view('postingjurnalpenyesuaian.index',compact('msjurnals'));
    }
    public function create() {
        return view('postingjurnalpenyesuaian.create');
    }

    public function posting(Request $request) {
        $bulan=$request->bulan;
        $namabulan=Postingjurnalpenyesuaian::getnamabulan($bulan);
        $tahun=$request->tahun;
        $kdperiode=$bulan.$tahun;
        $datajurnals=M_jurnalpenyesuaian::where(['f_post'=>'0','kdperiode'=>$kdperiode])
                            ->get();        
        if(count($datajurnals)>0){
                Postingjurnalpenyesuaian::postingjurnal($datajurnals,$kdperiode);         
                return redirect()->route('postingjurnalpenyesuaian')
                       ->with('success', 'Posting Jurnal Penyesuian  sukses');  

        }
        else {
            return redirect()->route('postingjurnalpenyesuaian')
                       ->with('success', 'Data Jurnal tidak ada');  

        }          
    }
    public function postingjurnal($datajurnals,$kdperiode){
            foreach ($datajurnals as $data) {
                    $notrans=$data->notrans;

                    $kdtransaksi=$data->kdtransaksi;
                    $tgltrans=$data->tgltrans;
                    $keterangan=$data->keterangan;
                    $debet=$data->debet;
                    $kredit=$data->kredit;
                    $jumlah=$data->jumlah;
          
                 //insert lapjurnal
                    $lapjurnal = new M_lapjurnalpenyesuaian;
                    $lapjurnal->notrans = $notrans;
                    $lapjurnal->tgltrans = $tgltrans;
                    $lapjurnal->kdperiode = $kdperiode;   
                    $lapjurnal->kdpst=Session::get('kdpst');                 
                    $lapjurnal->kdakun = $debet;
                    $lapjurnal->posreff = $kredit;
                    $lapjurnal->keterangan = $keterangan;
                    $lapjurnal->debet = $jumlah;            
                    $lapjurnal->kredit = 0;            
                    $lapjurnal->save(); 
                    $lapjurnal = new M_lapjurnalpenyesuaian;
                    $lapjurnal->notrans = $notrans;
                    $lapjurnal->kdpst=Session::get('kdpst');   
                    $lapjurnal->tgltrans = $tgltrans;
                    $lapjurnal->kdperiode = $kdperiode; 
                    $lapjurnal->kdakun = $kredit;
                    $lapjurnal->posreff = $debet;
                    $lapjurnal->keterangan = $keterangan;
                    $lapjurnal->debet = 0;            
                    $lapjurnal->kredit = $jumlah;            
                    $lapjurnal->save(); 

                    $subtransaksi=M_subtransaksi::where('kdtransaksi',$kdtransaksi)->get();
                    if (count($subtransaksi)>0) {
                        $kdakun_d=$subtransaksi->kdakun_d;
                        $kdakun_k=$subtransaksi->kdakun_k;
                        $lapjurnal = new M_lapjurnalpenyesuaian;
                        $lapjurnal->notrans = $notrans;
                        $lapjurnal->kdpst=Session::get('kdpst');
                        $lapjurnal->tgltrans = $tgltrans;
                        $lapjurnal->kdperiode = $kdperiode;  
                        $lapjurnal->kdakun = $kdakun_d;
                        $lapjurnal->posreff = $kdakun_k;
                        $lapjurnal->keterangan = $keterangan;
                        $lapjurnal->debet = $jumlah;            
                        $lapjurnal->kredit = 0;            
                        $lapjurnal->save(); 
                        $lapjurnal = new M_lapjurnalpenyesuaian;
                        $lapjurnal->notrans = $notrans;
                        $lapjurnal->tgltrans = $tgltrans;
                        $lapjurnal->kdpst=Session::get('kdpst');   
                        $lapjurnal->kdperiode = $kdperiode;  
                        $lapjurnal->kdakun = $kdakun_k;
                        $lapjurnal->posreff = $kdakun_d;
                        $lapjurnal->keterangan = $keterangan;
                        $lapjurnal->debet = 0;            
                        $lapjurnal->kredit = $jumlah;            
                        $lapjurnal->save(); 
                    }
                    M_jurnalpenyesuaian::where('notrans',$notrans)->update(['f_post'=>'1']);
            }          
            
    }




}
