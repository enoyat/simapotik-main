<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_mstagihan;
use App\Models\M_mahasiswa;
use App\Models\M_jurnaltagihan;
use App\Models\M_jurnalumum;
use App\Models\M_jurnalpembayaran;
use App\Models\M_msjurnal;
use App\Models\M_lapjurnal;

use App\Models\M_mstransaksi;

use App\Models\M_subtransaksi;
use Illuminate\Validation\Rule;

use Response;
use Validator;
use Hash;
use Session;
use Carbon;

class Postingjurnal extends Controller
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
        return view('postingjurnal.index',compact('msjurnals'));
    }
    public function create() {
        return view('postingjurnal.create');
    }

    public function posting(Request $request) {
        $kdjurnal=$request->kdjurnal;
        $bulan=$request->bulan;
        $namabulan=Postingjurnal::getnamabulan($bulan);
        $tahun=$request->tahun;

        if ($kdjurnal=='JU'){
            $datajurnals=M_jurnalumum::where(['f_post'=>'0','kdpst'=>Session::get('globalkdpst')])
                                ->whereMonth('tgltrans', $bulan)
                                ->whereYear('tgltrans',$tahun)    
                                ->get();        
            if(count($datajurnals)>0){
                    Postingjurnal::postingjurnal($datajurnals,$kdjurnal);         
                    return redirect()->route('postingjurnal')
                           ->with('success', 'Posting Jurnal Umum sukses');  

            }
            else {
                return redirect()->route('postingjurnal')
                           ->with('success', 'Data Jurnal tidak ada');  

            }
 
        }
        if ($kdjurnal=='JPM'){
            $datajurnals=M_jurnaltagihan::where(['f_post'=>'0','f_aktif'=>'1','kdpst'=>Session::get('globalkdpst')])
                                ->whereMonth('tgltrans', $bulan)
                                ->whereYear('tgltrans',$tahun)    
                                ->get();        
            if(count($datajurnals)>0){
                    Postingjurnal::postingjurnal($datajurnals,$kdjurnal);         
                    return redirect()->route('postingjurnal')
                           ->with('success', 'Posting Jurnal Piutang Mahasiswa sukses');  

            }
            else {
                return redirect()->route('postingjurnal')
                           ->with('success', 'Data Jurnal tidak ada');  

            }
 
        }  
        if ($kdjurnal=='JBM'){
            $datajurnals=M_jurnalpembayaran::where(['f_post'=>'0', 'kdpst'=>Session::get('globalkdpst')])
                                ->whereMonth('tgltrans', $bulan)
                                ->whereYear('tgltrans',$tahun)    
                                ->get();        
            if(count($datajurnals)>0){
                    Postingjurnal::postingjurnal($datajurnals,$kdjurnal);         
                    return redirect()->route('postingjurnal')
                           ->with('success', 'Posting Jurnal Pembayaran Mahasiswa sukses');  

            }
            else {
                return redirect()->route('postingjurnal')
                           ->with('success', 'Data Jurnal tidak ada');  

            }
 
        }    
    }
    public function postingjurnal($datajurnals,$kdjurnal){
            foreach ($datajurnals as $data) {
                    if($kdjurnal=='JU') {
                        $notrans=$data->notrans;
                    }
                    if($kdjurnal=='JPM') {
                        $notrans=$data->notagihan;
                    }  
                    if($kdjurnal=='JBM') {
                        $notrans=$data->nobayar;
                    }                 
                    $kdtransaksi=$data->kdtransaksi;
                    $tgltrans=$data->tgltrans;
                    $keterangan=$data->keterangan;
                    $debet=$data->debet;
                    $kredit=$data->kredit;
                    $jumlah=$data->jumlah;
          
                 //insert lapjurnal
                    $lapjurnal = new M_lapjurnal;
                    $lapjurnal->notrans = $notrans;
                    $lapjurnal->tgltrans = $tgltrans;
                    $lapjurnal->kdpst=Session::get('globalkdpst');
                    $lapjurnal->kdakun = $debet;
                    $lapjurnal->posreff = $kredit;
                    $lapjurnal->keterangan = $keterangan;
                    $lapjurnal->debet = $jumlah;            
                    $lapjurnal->kredit = 0;            
                    $lapjurnal->save(); 
                    $lapjurnal = new M_lapjurnal;
                    $lapjurnal->notrans = $notrans;
                    $lapjurnal->tgltrans = $tgltrans;
                    $lapjurnal->kdpst=Session::get('globalkdpst');
                    $lapjurnal->kdakun = $kredit;
                    $lapjurnal->posreff = $debet;
                    $lapjurnal->keterangan = $keterangan;
                    $lapjurnal->debet = 0;            
                    $lapjurnal->kredit = $jumlah;            
                    $lapjurnal->save(); 

                    $subtransaksis=M_subtransaksi::where('kdtransaksi',$kdtransaksi)->get();
                    if(count($subtransaksis)>0){
                        foreach ($subtransaksis as $subtransaksi) {
                            $kdakun_d=$subtransaksi->kdakun_d;
                            $kdakun_k=$subtransaksi->kdakun_k;
                        }
                        $lapjurnal = new M_lapjurnal;
                        $lapjurnal->notrans = $notrans;
                        $lapjurnal->tgltrans = $tgltrans;
                        $lapjurnal->kdpst=Session::get('globalkdpst');
                        $lapjurnal->kdakun = $kdakun_d;
                        $lapjurnal->posreff = $kdakun_k;
                        $lapjurnal->keterangan = $keterangan;
                        $lapjurnal->debet = $jumlah;            
                        $lapjurnal->kredit = 0;            
                        $lapjurnal->save(); 
                        $lapjurnal = new M_lapjurnal;
                        $lapjurnal->notrans = $notrans;
                        $lapjurnal->kdpst=Session::get('globalkdpst');
                        $lapjurnal->tgltrans = $tgltrans;
                        $lapjurnal->kdakun = $kdakun_k;
                        $lapjurnal->posreff = $kdakun_d;
                        $lapjurnal->keterangan = $keterangan;
                        $lapjurnal->debet = 0;            
                        $lapjurnal->kredit = $jumlah;            
                        $lapjurnal->save(); 
                    }
                    if($kdjurnal=='JU'){
                        M_jurnalumum::where('notrans',$notrans)->update(['f_post'=>'1']);
                    }
                    if($kdjurnal=='JPM'){
                        M_jurnaltagihan::where('notagihan',$notrans)->update(['f_post'=>'1']);
                    }
                    if($kdjurnal=='JBM'){
                        M_jurnalpembayaran::where('nobayar',$notrans)->update(['f_post'=>'1']);
                    }  
            }          
            
    }




}
