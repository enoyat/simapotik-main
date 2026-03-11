<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_jenispasien;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class JenispasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenispasien=M_jenispasien::get();
        return view('jenispasien.jenispasien',['jenispasien'=>$jenispasien]);
   //
    }
    public function gennotrans()
    {
        $kode = M_jenispasien::max('idjenispasien');
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
        $jenispasien=M_jenispasien::get();
        return view('jenispasien.formjenispasien',['jenispasien'=>$jenispasien]);
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
            'namajenispasien'  => 'required'
        ],
        [
          'namajenispasien.min'      => 'nama Minimal 5 karakter'
        ]);

        $jenispasien = new M_jenispasien;
        $jenispasien->namajenispasien = $request->namajenispasien;
        $simpan = $jenispasien->save();
        if($simpan){
                return redirect()->route('jenispasien.index')
                    ->with(['success'=>'jenispasien sukses disimpan']);
        } else {
            return redirect()->route('jenispasien.index')
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
        $product = M_jenispasien::where('idjenispasien',$id)->get();
       // dd($product);
        return view('jenispasien.formeditjenispasien',['datajenispasien' => $product]);
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
            'namajenispasien'  => 'required'
        ],
        [
          'idjenispasien.unique'     => 'idjenispasien sudah ada',
          'namajenispasien.min'      => 'nama Minimal 5 karakter',
        ]);

        $simpan=M_jenispasien::where('idjenispasien',$request->idjenispasien)->update([
                                        'namajenispasien' => $request->namajenispasien
                                        ]);

        if($simpan){
                return redirect()->route('jenispasien.index')
                    ->with(['success'=>'jenispasien sukses diubah']);
        } else {
            return redirect()->route('jenispasien.index')
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
        $id=$request->idjenispasien;
        M_jenispasien::where('idjenispasien', '=', $id)->delete();
        return redirect()->back();       //
    }
    public function getjenispasien(){
        $jenispasien = M_jenispasien::get();

        $response = array();
        foreach ($jenispasien as $value) {
            $response[] = array(
                "id" => $value->idjenispasien,
                "text" => $value->namajenispasien
            );
        }

        return response()->json($response);
    }
}
