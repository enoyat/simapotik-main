<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_stoklokasi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;


class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stoklokasi=M_stoklokasi::get();
        return view('stoklokasi.stoklokasi',['stoklokasi'=>$stoklokasi]);
   //
    }
    public function gennotrans()
    {
        $kode = M_stoklokasi::max('idlokasi');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 1, 4);

            $noUrut++;
        }
        $char = "J";
        $newID = $char.sprintf("%04s", $noUrut);
        return $newID;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stoklokasi=M_stoklokasi::get();
        return view('stoklokasi.formstoklokasi',['stoklokasi'=>$stoklokasi]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'idlokasi'  => 'required|unique:stoklokasi',
            'namalokasi'  => 'required'
        ],
        [
            'idlokasi.required'     => 'idlokasi harus diisi',
            'idlokasi.unique'     => 'Kode Lokasi sudah ada',
          'namalokasi.required'      => 'nama lokasi harus diisi',
        ]);

        $stoklokasi = new M_stoklokasi;
        $stoklokasi->idlokasi = $request->idlokasi;
        $stoklokasi->namalokasi = $request->namalokasi;
        $simpan = $stoklokasi->save();
        DB::statement('call sp_add_gudang(:xidlokasi)',['xidlokasi'=>$request->idlokasi]);
        if($simpan){
                return redirect()->route('stoklokasi.index')
                    ->with(['success'=>'stoklokasi sukses disimpan']);
        } else {
            return redirect()->route('stoklokasi.index')
                    ->with(['success', 'ada kesalahan simpan, coba beberapa saat lagi']);
        }
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
        $product = M_stoklokasi::where('idlokasi',$id)->get();
       // dd($product);
        return view('stoklokasi.formeditstoklokasi',['datastoklokasi' => $product]);
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $request->validate([
            'namalokasi'  => 'required'
        ],
        [
          'idlokasi.unique'     => 'idlokasi sudah ada',
          'namalokasi.min'      => 'nama Minimal 5 karakter',
        ]);

        $simpan=M_stoklokasi::where('idlokasi',$request->idlokasi)->update([
                                        'namalokasi' => $request->namalokasi
                                        ]);

        if($simpan){
                return redirect()->route('stoklokasi.index')
                    ->with(['success'=>'stoklokasi sukses diubah']);
        } else {
            return redirect()->route('stoklokasi.index')
                    ->with(['success', 'ada kesalahan simpan, coba beberapa saat lagi']);
        }         //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->idlokasi;
        M_stoklokasi::where('idlokasi', '=', $id)->delete();
        return redirect()->back();       //
    }
}
