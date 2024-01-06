<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_jenis;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis=M_jenis::get();
        return view('jenis.jenis',['jenis'=>$jenis]);
   //
    }
    public function gennotrans()
    {
        $kode = M_jenis::max('idjenis');
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
        $jenis=M_jenis::get();
        return view('jenis.formjenis',['jenis'=>$jenis]);
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
            'namajenis'  => 'required'
        ],
        [
          'namajenis.min'      => 'nama Minimal 5 karakter'
        ]);

        $jenis = new M_jenis;
        $jenis->idjenis = $this->gennotrans();
        $jenis->namajenis = $request->namajenis;
        $simpan = $jenis->save();
        if($simpan){
                return redirect()->route('jenis.index')
                    ->with(['success'=>'jenis sukses disimpan']);
        } else {
            return redirect()->route('jenis.index')
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
        $product = M_jenis::where('idjenis',$id)->get();
       // dd($product);
        return view('jenis.formeditjenis',['datajenis' => $product]);
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
            'namajenis'  => 'required'
        ],
        [
          'idjenis.unique'     => 'idjenis sudah ada',
          'namajenis.min'      => 'nama Minimal 5 karakter',
        ]);

        $simpan=M_jenis::where('idjenis',$request->idjenis)->update([
                                        'namajenis' => $request->namajenis
                                        ]);

        if($simpan){
                return redirect()->route('jenis.index')
                    ->with(['success'=>'jenis sukses diubah']);
        } else {
            return redirect()->route('jenis.index')
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
        $id=$request->idjenis;
        M_jenis::where('idjenis', '=', $id)->delete();
        return redirect()->back();       //
    }
}
