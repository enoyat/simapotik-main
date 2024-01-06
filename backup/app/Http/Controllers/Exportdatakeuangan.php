<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_register;
use App\Models\M_registrasi;
use App\Models\M_jalur;
use App\Models\M_fakultas;
use App\Models\M_prodi;
use App\Models\M_jadwal;
use App\Models\M_jadwalregistrasi;
use App\Models\M_pengumuman;
use App\Models\M_trjawaban;
use App\Models\M_npm;
use App\Models\User;

use App\Models\M_jurnaltagihan;
use App\Models\M_jurnalpembayaran;

use Illuminate\Support\Facades\DB;

use Response;
use Validator;
use Hash;
use Session;
class Exportdatakeuangan extends Controller
{
	public function index(){
		$set=M_jadwalregistrasi::get();
		return view('official/keuangan/laporan')
				->with(['set'=>$set ]);
	}
	
	public function rpttagihan(){
		$set=M_jadwalregistrasi::get();
		return view('official/keuangan/rpttagihan')
				->with(['set'=>$set ]);
	}
	public function rpttagihanregistrasi(){
		$set=M_jadwalregistrasi::get();
		$fakultas = M_fakultas::pluck('namafakultas', 'kdfak');   

		return view('official/keuangan/rpttagihanregistrasi')
				->with(['set'=>$set,'fakultas'=>$fakultas ]);
	}
	public function laporantagihan(Request $request) {
		$request->validate([
			'tgl1'  => 'required',
			'tgl2'  => 'required'

		]);
		$tgl1=$request->tgl1;
		$tgl2=$request->tgl2;		

		$jurnaltagihan= M_jurnaltagihan::select("*")
							->whereBetween('tgltrans',[$tgl1,$tgl2])
							->get();
							
		if(count($jurnaltagihan)<1){
        return redirect()->route('rpttagihan')
                    ->with('success', 'Tidak ada data tagihan' );

		} 
		else {
			return view('official/keuangan/laporantagihan')
					->with(['title'=>'Laporan Tagihan Mahasiswa','tgl1'=>$tgl1, 'tgl2'=>$tgl2, 'jurnaltagihan'=>$jurnaltagihan]);
		}
	}
	public function laporantagihanregistrasi(Request $request) {
		$request->validate([
			'tgl1'  => 'required',
			'tgl2'  => 'required'

		]);
		$tgl1=$request->tgl1;
		$tgl2=$request->tgl2;	
		$kdfak=$request->kdfak;	

		$jurnaltagihan=DB::table('jurnaltagihan')
                ->join('registrasi', 'jurnaltagihan.kdregister','=','registrasi.kdregister')		
                ->join('prodi', 'prodi.kdpst','=','registrasi.kdpst')
                ->join('fakultas', 'prodi.kdfak','=','fakultas.kdfak')
                ->select('jurnaltagihan.*','registrasi.namalengkap','registrasi.kdpst', 'prodi.kdfak', 'fakultas.namafakultas')
                ->where('fakultas.kdfak',$kdfak)
                ->whereBetween('tgltrans',[$tgl1,$tgl2])
                ->get();
      //  dd($jurnaltagihan);
	//	$jurnaltagihan= M_jurnaltagihan::select("*")
	//						->whereBetween('tgltrans',[$tgl1,$tgl2])
	//						->get();
							
		if(count($jurnaltagihan)<1){
        return redirect()->route('rpttagihanregistrasi')
                    ->with('success', 'Tidak ada data tagihan' );

		} 
		else {
			return view('official/keuangan/laporantagihanregistrasi')
					->with(['title'=>'Laporan Tagihan Mahasiswa','tgl1'=>$tgl1, 'tgl2'=>$tgl2, 'jurnaltagihan'=>$jurnaltagihan]);
		}
	}
	public function rptpembayaran(){
		$set=M_jadwalregistrasi::get();
		return view('official/keuangan/rptpembayaran')
				->with(['set'=>$set ]);
	}
	public function laporanpembayaran(Request $request) {
		$request->validate([
			'tgl1'  => 'required',
			'tgl2'  => 'required'

		]);
		$tgl1=$request->tgl1;
		$tgl2=$request->tgl2;		
		$jurnalpembayaran= M_jurnalpembayaran::select("*")
							->whereBetween('tgltrans',[$tgl1,$tgl2])
							->get();

		return view('official/keuangan/laporanpembayaran')
				->with(['title'=>'Laporan Pembayaran Mahasiswa','tgl1'=>$tgl1, 'tgl2'=>$tgl2, 'jurnalpembayaran'=>$jurnalpembayaran]);
	}
	public function rptpembayaranpermhs(){
		$set=M_jadwalregistrasi::get();
		return view('official/keuangan/rptpembayaranpermhs')
				->with(['set'=>$set ]);
	}
	public function carinama(Request $request) {
		$request->validate([
			'nama'  => 'required'
		]);
		$nama=$request->nama;
		$datamhs= M_register::where('nama', 'like', '%' . $nama . '%')->get();
		return view('official/keuangan/carinama')
				->with(['title'=>'Cari Nama','datamhs'=>$datamhs]);
	}
	
	public function laporanpembayaranpermhs($kdregister) {
		$datamhs= M_registrasi::where('kdregister',$kdregister)->get();

		$jurnaltagihan= M_jurnalpembayaran::select("*")
							->where('kdregister',$kdregister)
							->get();

		return view('official/keuangan/laporanpembayaranpermhs')
				->with(['title'=>'Laporan Pembayaran Mahasiswa','datamhs'=>$datamhs, 'jurnaltagihan'=>$jurnaltagihan]);
	}

    //
}
