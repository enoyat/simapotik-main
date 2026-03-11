<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_akun;
use App\Models\M_trkelakun;
use App\Models\M_mahasiswa;

use Response;
use Validator;
use Hash;
use Session;
class DataCombo extends Controller
{
    //
    public function comboakun(Request $request){

        $akun=M_trkelakun::where('trkelakun.kdkelakun',$request->id)
                ->select('*')
                ->join('akun',['trkelakun.kdakun'=>'akun.kdakun'])
                ->orderby('trkelakun.kdakun')
                ->get();
       // dd($akun);
        return $akun->toJson(JSON_PRETTY_PRINT);
    }
    public function carimhs(Request $request){
        $mahasiswa = M_mahasiswa::where(['nim'=>$request->id,'kdpst'=>Session::get('kdpst')])->get();                    
        if(count($mahasiswa)>0){
            foreach ($mahasiswa as $key ) {
                Session::put('nim',$key->nim);
                Session::put('namamahasiswa',$key->namamahasiswa);
                # code...
            }
        }
        return $mahasiswa->toJson(JSON_PRETTY_PRINT);
    }
}
