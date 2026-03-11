<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_dokter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokter=M_dokter::get();
        return view('dokter.dokter',['dokter'=>$dokter]);
   //
    }
    public function gennotrans()
    {
        $kode = M_dokter::max('iddokter');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 1, 4);

            $noUrut++;
        }
        $char = "C";
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
        $dokter=M_dokter::get();
        return view('dokter.formdokter',['dokter'=>$dokter]);
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
            'namadokter'  => 'required'
        ],
        [
          'namadokter.min'      => 'nama Minimal 5 karakter'
        ]);

        $dokter = new M_dokter;
        $dokter->namadokter = $request->namadokter;
        $simpan = $dokter->save();
        if($simpan){
                return redirect()->route('dokter.index')
                    ->with(['success'=>'dokter sukses disimpan']);
        } else {
            return redirect()->route('dokter.index')
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
        $product = M_dokter::where('iddokter',$id)->get();
       // dd($product);
        return view('dokter.formeditdokter',['datadokter' => $product]);
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
            'namadokter'  => 'required'
        ],
        [
          'iddokter.unique'     => 'iddokter sudah ada',
          'namadokter.min'      => 'nama Minimal 5 karakter',
        ]);

        $simpan=M_dokter::where('iddokter',$request->iddokter)->update([
                                        'namadokter' => $request->namadokter
                                        ]);

        if($simpan){
                return redirect()->route('dokter.index')
                    ->with(['success'=>'dokter sukses diubah']);
        } else {
            return redirect()->route('dokter.index')
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
        $id=$request->iddokter;
        M_dokter::where('iddokter', '=', $id)->delete();
        return redirect()->back();       //
    }
    public function getdokter(){
        $dokter = M_dokter::get();

        $response = array();
        foreach ($dokter as $value) {
            $response[] = array(
                "id" => $value->iddokter,
                "text" => $value->namadokter
            );
        }

        return response()->json($response);
    }
}
