<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_register;
use App\Models\M_jalur;
use App\Models\M_fakultas;
use App\Models\M_prodi;
use App\Models\M_jadwal;
use App\Models\M_pengumuman;
use App\Models\M_trjawaban;

use App\Models\User;

use Illuminate\Support\Facades\DB;

use Response;
use Validator;
use Hash;
use Session;

class Official extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('official/dashboard');

        //
    }
    public function getall(Request $request){
        if(!empty($request->thsms)){
            $peserta=M_register::where('thsms',$request->thsms)->with('get_prodi','get_jalur')->get();
        }
        else {
            $peserta=M_register::with('get_prodi','get_jalur')->get();
        }
        $jadwal=M_jadwal::get();                    
        return view ('official/officialpeserta')->with(['title'=>"Daftar Pendaftar Mahasiswa Baru",'peserta'=>$peserta,'jadwal'=>$jadwal]);

    }
    public function verujian($kdregister){
            
            $trjawaban = M_trjawaban::where([
                'kdregister' => $kdregister
            ])->first();
            if($trjawaban) {
            }
            else {
                M_trjawaban::create(['kdregister'=>$kdregister]);
            }

            $shark = M_register::find($kdregister);
            //$shark->name       = Input::get('name');
            $shark->f_cbt      = '1';
            $shark->f_ujian      = '0';

            $shark->save();
            if(!empty($request->thsms)){
                $peserta=M_register::where('thsms',$request->thsms)->with('get_prodi','get_jalur')->get();
            }
            else {
                $peserta=M_register::with('get_prodi','get_jalur')->get();
            }            
            $jadwal=M_jadwal::get();   
            return redirect()->route('officialpeserta')
                    ->with(['title'=>"Daftar Pendaftar Mahasiswa Baru",'peserta'=>$peserta,'jadwal'=>$jadwal]);                 
    }
    public function terima($kdregister){
        //hitung WDU
            $peserta=M_register::where('kdregister',$kdregister)
                    ->with('get_prodi','get_jalur')->get();

            foreach ($peserta as $key ) {
                    $kdregister=$key->kdregister;
                    $nama=$key->nama;
                    $alamat=$key->alamat;
                    $namaprodi=$key->get_prodi->nmpst;
                    $kdregister=$key->kdregister;
                    $wdu=$key->get_prodi->wdu;                 
                    $spp=$key->get_prodi->spp;
                    $sks=$key->get_prodi->sks;
                    $poliklinik=$key->get_prodi->poliklinik;
                    $prodikem=$key->get_prodi->prodikem;
                    $lab=$key->get_prodi->lab;         
                    $norek_wdu=$key->get_prodi->norek_wdu;     

                    $totalwdu=$wdu+$spp+$sks+$poliklinik+$prodikem+$lab;
                    # code...
            }



            $shark = M_register::find($kdregister);
            //$shark->name       = Input::get('name');
            $shark->f_terima      = '1';
            $shark->jmlwdu      = $totalwdu;            
            $shark->save();
            $datetime = date('Y-m-d H:i:s');

            $topik="Hasil Ujian $nama alamat $alamat";
            $strtotalwdu=number_format($totalwdu);
            $isi=
            "<h3 style='text-align:center'>Selamat....</h3><p style='text-align:center'>Peserta Ujian yang bernama <b>$nama</b>, alamat $alamat dinyatakan <b>DITERIMA</b><br>
            sebagai mahasiswa UNTAG Semarang Program Studi $namaprodi. Selanjutnya silahkan melakukan wajib daftar ulang (WDU) dengan melengkapi syarat-syarat yang telah ditentukan yakni membayar sebesar <b>Rp. $strtotalwdu</b>  atau minimal <b>Rp. 4.000.000,- (Empat Juta Rupiah)</b>. Silahkan melakukan Registrasi atau Daftar ulang di link <a href='http://registrasi.untagsmg.id'>registrasi.untagsmg.id</a>  Terima kasih<br></p>";

                $set = array(
                    'datetime' => $datetime,
                    'topik' => $topik,
                    'isi' => $isi,
                    'kdregister'=>$kdregister
                );
            $simpan=M_pengumuman::create(['kdregister' =>$kdregister,
                'datetime' => $datetime,
                'topik' => $topik,
                'isi' => $isi
            ]);

            if(!empty($request->thsms)){
                $peserta=M_register::where('thsms',$request->thsms)->with('get_prodi','get_jalur')->get();
            }
            else {
                $peserta=M_register::with('get_prodi','get_jalur')->get();
            }            
            $jadwal=M_jadwal::get();                    
            return redirect()->route('officialpeserta')
                    ->with(['title'=>"Daftar Pendaftar Mahasiswa Baru",'peserta'=>$peserta,'jadwal'=>$jadwal]);    
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        M_register::where('kdregister', '=', $id)->delete();
        M_trjawaban::where('kdregister', '=', $id)->delete();
        M_pengumuman::where('kdregister', '=', $id)->delete();
        User::where('kdregister', '=', $id)->delete();
        return redirect()->route('officialpeserta')
            ->with('success', 'Peserta Berhasil Dihapus');
        //

    }
}
