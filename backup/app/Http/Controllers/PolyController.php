<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_poly;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class PolyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poly=M_poly::get();
        return view('poly.poly',['poly'=>$poly]);
   //
    }
    public function gennotrans()
    {
        $kode = M_poly::max('idpoly');
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
        $poly=M_poly::get();
        return view('poly.formpoly',['poly'=>$poly]);
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
            'namapoly'  => 'required'
        ],
        [
          'namapoly.min'      => 'nama Minimal 5 karakter'
        ]);

        $poly = new M_poly;
        $poly->namapoly = $request->namapoly;
        $simpan = $poly->save();
        if($simpan){
                return redirect()->route('poly.index')
                    ->with(['success'=>'poly sukses disimpan']);
        } else {
            return redirect()->route('poly.index')
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
        $product = M_poly::where('idpoly',$id)->get();
       // dd($product);
        return view('poly.formeditpoly',['datapoly' => $product]);
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
            'namapoly'  => 'required'
        ],
        [
          'idpoly.unique'     => 'idpoly sudah ada',
          'namapoly.min'      => 'nama Minimal 5 karakter',
        ]);

        $simpan=M_poly::where('idpoly',$request->idpoly)->update([
                                        'namapoly' => $request->namapoly
                                        ]);

        if($simpan){
                return redirect()->route('poly.index')
                    ->with(['success'=>'poly sukses diubah']);
        } else {
            return redirect()->route('poly.index')
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
        $id=$request->idpoly;
        M_poly::where('idpoly', '=', $id)->delete();
        return redirect()->back();       //
    }
    public function getpoly(){
        $poly = M_poly::get();

        $response = array();
        foreach ($poly as $value) {
            $response[] = array(
                "id" => $value->idpoly,
                "text" => $value->namapoly
            );
        }

        return response()->json($response);
    }
}
