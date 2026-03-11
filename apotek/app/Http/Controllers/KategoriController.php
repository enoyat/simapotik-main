<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_kategori;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori=M_kategori::where('kdpst',Session::get('globalkdpst'))->get();
        return view('kategori.kategori',['kategori'=>$kategori]);
   //
    }
    public function gennotrans()
    {
        $kode = M_kategori::max('kdkategori');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 1, 4);

            $noUrut++;
        }
        $char = "K";
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
        $kategori=M_kategori::where('kdpst',Session::get('globalkdpst'))->get();
        return view('kategori.formkategori',['kategori'=>$kategori]);
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
            'namakategori'  => 'required'
        ],
        [
          'namakategori.min'      => 'nama Minimal 5 karakter'
        ]);

        $kategori = new M_kategori;
        $kategori->kdkategori = $this->gennotrans();
        $kategori->namakategori = $request->namakategori;
        $kategori->kdpst = Session::get('globalkdpst');
        $simpan = $kategori->save();
        if($simpan){
                return redirect()->route('kategori.index')
                    ->with(['success'=>'kategori sukses disimpan']);
        } else {
            return redirect()->route('kategori.index')
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
        $product = M_kategori::where('kdkategori',$id)->get();
       // dd($product);
        return view('kategori.formeditkategori',['datakategori' => $product]);
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
            'namakategori'  => 'required'
        ],
        [
          'kdkategori.unique'     => 'Kdkategori sudah ada',
          'namakategori.min'      => 'nama Minimal 5 karakter',
        ]);

        $simpan=M_kategori::where('kdkategori',$request->kdkategori)->update([
                                        'namakategori' => $request->namakategori
                                        ]);

        if($simpan){
                return redirect()->route('kategori.index')
                    ->with(['success'=>'kategori sukses diubah']);
        } else {
            return redirect()->route('kategori.index')
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
        $id=$request->kdkategori;
        try {
            $hapus=M_kategori::where('kdkategori', '=', $id)->delete();
            return redirect()->route('kategori.index')
                    ->with(['success' => 'kategori sukses dihapus']);
            //Your code
           } catch(QueryException $ex){
                Alert::error('Gagal', 'Kategori tidak bisa dihapus karena masih digunakan');
                return redirect()->route('kategori.index');
                //dd($ex->getMessage());
           }
        
    }
}
