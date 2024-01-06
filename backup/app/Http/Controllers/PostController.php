<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_posttoken;
use App\Models\M_jurnaltagihan;
use App\Models\M_jurnalpembayaran;
use App\Models\M_databayar;
use App\Models\M_detailbayar;
use App\Models\M_mstransaksi;


use Illuminate\Support\Facades\DB;

use Carbon;
class PostController extends Controller
{
    public function index(){
        return [
            'error' => false,
            'data' => M_jurnaltagihan::all()
        ];
    }
    function genkode_pembayaran() {
        $kode =DB::table('jurnalpembayaran')->max('nobayar');    
                if(empty($kode)) {
                $noUrut = 1;
        }
        else {
            $noUrut = substr($kode, 1);
            $noUrut++;            
        }
        $char = "P";
        $newID = $char . sprintf("%019s", $noUrut);
        return $newID;
    }
    public function show($id){
        $post = M_jurnaltagihan::where('nova',$id)->get();
        if(empty($post)){
            return [
                'error' => 'Tagihan data not found'
            ];
        }

        return [
            'error' => false,
            'data' => $post
        ];
    }  //
    public function store(Request $request){
        $nova = $request->va;
        $jumlah = $request->amount;
        $post = M_databayar::where(['va'=>$nova])->get();
        if((empty($post)) || (count($post)<1)){
            return [
                'rsp' => '001',
                'rspdesc' => 'Account VA Not Found'
            ];
        }
        foreach ($post as $key ){
            $kdbayar=$key->kdbayar;
            $nim=$key->nim;
            $modebayar=$key->modebayar;
        }     
        if ($modebayar=="F") {
                $postdetails = M_detailbayar::where('kdbayar',$kdbayar)->get();
                foreach ($postdetails as $postdetail) {
                        $idbayar=$postdetail->idbayar;
                        $notagihan=$postdetail->notagihan;                
                        $jmlhrsbayar=$postdetail->jumlah;
                        //update detailbayar
                        M_detailbayar::where('idbayar',$idbayar)->update(['f_bayar'=>'1']);

                        //get tagihan
                        $datatagihans=M_jurnaltagihan::where('notagihan',$notagihan)->get();
                        foreach ($datatagihans as $datatagihan) {
                            $dataharusbayar=$datatagihan->jumlah;
                            $kdpst=$datatagihan->kdpst;                            
                            $keterangan=$datatagihan->keterangan;
                            $kdtransaksi=$datatagihan->kdtransaksi;
                            $kdtransaksilawan=$datatagihan->kdtransaksilawan;

                        }              
                        $post=M_jurnaltagihan::find($notagihan);
                        $post->bayar = $dataharusbayar;
                        $post->sisa = 0;                         
                        $post->f_lunas = '1';
                        $post->save();

                        $jurnalpembayaran = new M_jurnalpembayaran;
                        $jurnalpembayaran->nobayar = PostController::genkode_pembayaran();      
                        $jurnalpembayaran->notagihan = $notagihan;
                        $jurnalpembayaran->kdtransaksi = $kdtransaksi;
                        $jurnalpembayaran->kdpst = $kdpst;
                        //get transaksi lawan
                        $post=M_mstransaksi::find($kdtransaksilawan);
                        $debet=$post->kdakun_d;
                        $kredit=$post->kdakun_k;

                        $jurnalpembayaran->kdtransaksi = $kdtransaksilawan;
                        $jurnalpembayaran->debet = $debet;
                        $jurnalpembayaran->kredit = $kredit;                
                        $jurnalpembayaran->tgltrans = Carbon\Carbon::now();
                        $jurnalpembayaran->nim = $nim;
                        $jurnalpembayaran->keterangan = $keterangan;
                        $jurnalpembayaran->jumlah = $dataharusbayar;
                        $jurnalpembayaran->va = $nova;                        
                        $simpanpembayaran = $jurnalpembayaran->save();   
                        


                }
                M_databayar::where('kdbayar',$kdbayar)->update(['f_bayar'=>'1','f_status'=>'1']);
                return [
                    'ref' => $nova,            
                    'rsp' => '000',
                    'rspdesc' => 'Success'
                ];
         }
        if ($modebayar=="P") {

                $postdetails = M_detailbayar::where('kdbayar',$kdbayar)->get();
                foreach ($postdetails as $postdetail) {
                        $idbayar=$postdetail->idbayar;
                        $notagihan=$postdetail->notagihan;                
                        $jmlhrsbayar=$postdetail->jumlah;
                        //get tagihan
                        $datatagihans=M_jurnaltagihan::where('notagihan',$notagihan)->get();
                        foreach ($datatagihans as $datatagihan) {
                            $kdpst=$datatagihan->kdpst;
                            $dataharusbayar=$datatagihan->jumlah;
                            $databayar=$datatagihan->bayar;
                            $datasisa=$datatagihan->sisa;
                            $keterangan=$datatagihan->keterangan;
                            $kdtransaksilawan=$datatagihan->kdtransaksilawan;

                        }
                        $bayar=$databayar+$jumlah;
                        $sisa=$dataharusbayar-$bayar;
                        if ($dataharusbayar==$bayar) {
                            $f_lunas='1';
                            M_databayar::where('kdbayar',$kdbayar)->update(['f_bayar'=>'1','f_status'=>'1']);
                        }
                        else {
                            $f_lunas='0';
                        }               
                        $post=M_jurnaltagihan::find($notagihan);
                        $post->bayar = $bayar;
                        $post->sisa = $sisa;                         
                        $post->f_lunas = $f_lunas;
                        $post->save();

                        //get transaksi lawan
                        $post=M_mstransaksi::find($kdtransaksilawan);
                        $debet=$post->kdakun_d;
                        $kredit=$post->kdakun_k;

                        $jurnalpembayaran = new M_jurnalpembayaran;
                        $jurnalpembayaran->nobayar = PostController::genkode_pembayaran();      
                        $jurnalpembayaran->notagihan = $notagihan;
                        $jurnalpembayaran->kdtransaksi = $kdtransaksilawan;
                        $jurnalpembayaran->kdpst = $kdpst;

                        $jurnalpembayaran->debet = $debet;
                        $jurnalpembayaran->kredit = $kredit;                
                        $jurnalpembayaran->tgltrans = Carbon\Carbon::now();
                        $jurnalpembayaran->nim = $nim;
                        $jurnalpembayaran->keterangan = $keterangan;
                        $jurnalpembayaran->jumlah = $jumlah;
                        $jurnalpembayaran->va = $nova;
                        $simpanpembayaran = $jurnalpembayaran->save();   


                }
                return [
                    'ref' => $nova,            
                    'rsp' => '000',
                    'rspdesc' => 'Success'
                ];
         }


    }  //

}
