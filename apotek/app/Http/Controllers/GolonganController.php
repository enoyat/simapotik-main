<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_golongan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $golongan=M_golongan::get();
        return view('golongan.golongan',['golongan'=>$golongan]);
   //
    }
    public function gennotrans()
    {
        $kode = M_golongan::max('idgolongan');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 1, 4);

            $noUrut++;
        }
        $char = "G";
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
        $golongan=M_golongan::get();
        return view('golongan.formgolongan',['golongan'=>$golongan]);
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
            'namagolongan'  => 'required'
        ],
        [
          'namagolongan.min'      => 'nama Minimal 5 karakter'
        ]);

        $golongan = new M_golongan;
        $golongan->idgolongan = $this->gennotrans();
        $golongan->namagolongan = $request->namagolongan;
        $simpan = $golongan->save();
        if($simpan){
                return redirect()->route('golongan.index')
                    ->with(['success'=>'golongan sukses disimpan']);
        } else {
            return redirect()->route('golongan.index')
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
        $product = M_golongan::where('idgolongan',$id)->get();
       // dd($product);
        return view('golongan.formeditgolongan',['datagolongan' => $product]);
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
            'namagolongan'  => 'required'
        ],
        [
          'idgolongan.unique'     => 'idgolongan sudah ada',
          'namagolongan.min'      => 'nama Minimal 5 karakter',
        ]);

        $simpan=M_golongan::where('idgolongan',$request->idgolongan)->update([
                                        'namagolongan' => $request->namagolongan
                                        ]);

        if($simpan){
                return redirect()->route('golongan.index')
                    ->with(['success'=>'golongan sukses diubah']);
        } else {
            return redirect()->route('golongan.index')
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
        $id=$request->idgolongan;
        M_golongan::where('idgolongan', '=', $id)->delete();
        return redirect()->back();       //
    }
}
