<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_barang;
use App\Models\M_kategori;
use App\Models\M_keranjang;
use App\Models\M_fotobarang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori=M_kategori::get();
        $barang = M_barang::with('get_foto','get_kategori')->where('kdpst',Session::get('globalkdpst'))->get();
        return view('barang.barang',['barang' => $barang, 'kategori'=>$kategori]);
   //
    }
  public function detail($kdbarang){
    $kategori=M_kategori::where('kdpst',Session::get('globalkdpst'))->get();
    $product = M_barang::where('kdbarang',$kdbarang)->with('get_foto')->where('kdpst',Session::get('globalkdpst'))->get();
    return view('detailbarang',['barang' => $product, 'kategori'=>$kategori]);
  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori=M_kategori::where('kdpst',Session::get('globalkdpst'))->get();
        return view('barang.formbarang',['kategori'=>$kategori]);
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
            'kdbarang'    => 'required|min:5|max:5',
            'namabarang'  => 'required',
            'deskripsi'   => 'required',
            'filefoto'        => 'required',
            'hargabeli'   => 'required',
            'hargajual'   => 'required',
            'kdkategori'  => 'required'
        ],
        [
          'kdbarang.required'   => 'Kdbaranng tidak boleh kosong',
          'kdbarang.min'   => 'Kdbarang Minimal 5 karakter',
          'kdbarang.max'   => 'Kdbarang Maximal 5 karakter',
          'namabarang.min'      => 'nama Minimal 5 karakter',
          'deskripsi.required'  => 'deskrisi harus ada',
          'filefoto.required'       => 'foto harus ada',
          'hargabeli.numeric'   => 'Harga beli harus angka',
          'hargajual.numeric'   => 'Harga Jual harus angka'
        ]);
        $kdbarang=$request->kdbarang.Session::get('globalkdpst');
        $cekbarang=M_barang::where('kdbarang',$kdbarang)->count();
        if($cekbarang>0){
            Alert::error('Kode barang sudah ada', 'Gagal');
            return redirect()->back()->withInput();
        }
        $file = $request->filefoto;
        $pathUpload = 'assets/inventory';

        $extension = $file->getClientOriginalExtension();
        $filename = time().".".$extension;
        $file->move($pathUpload,$filename);

        $barang = new M_barang;
        $barang->kdbarang = $kdbarang;
        $barang->namabarang = $request->namabarang;
        $barang->deskripsi = $request->deskripsi;
        $barang->foto = $filename;
        $barang->berat = $request->berat;
        $barang->hargabeli = $request->hargabeli;
        $barang->hargajual = $request->hargajual;
        $barang->kdkategori = $request->kdkategori;
        $barang->stok = 0;
        $barang->kdpst = Session::get('globalkdpst');
        $simpan = $barang->save();
        if($simpan){
                return redirect()->route('barang.index')
                    ->with(['success'=>'Barang sukses disimpan']);
        } else {
            return redirect()->route('barang.index')
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
        $kategori=M_kategori::where('kdpst',Session::get('globalkdpst'))->get();
        $product = M_barang::where('kdbarang',$id)->where('kdpst',Session::get('globalkdpst'))->get();
       // dd($product);
        return view('barang.formeditbarang',['databarang' => $product, 'kategori'=>$kategori]);
       //
    }

    public function uploadgallery(Request $request){
        $file = $request->filefoto;
        $pathUpload = 'assets/inventory';

        $extension = $file->getClientOriginalExtension();
        $filename = time().".".$extension;
        $file->move($pathUpload,$filename);
        $gallery = new M_fotobarang;
        $gallery->kdbarang = $request->kdbarang;
        $gallery->foto = $filename;
        $gallery->save();
        return redirect()->back();
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
            'namabarang'  => 'required',
            'deskripsi'   => 'required',
            'hargabeli'   => 'required',
            'hargajual'   => 'required',
            'kdkategori'  => 'required'
        ],
        [
          'kdbarang.unique'     => 'Kdbarang sudah ada',
          'namabarang.min'      => 'nama Minimal 5 karakter',
          'deskripsi.required'  => 'deskrisi harus ada',
          'hargabeli.numeric'   => 'Harga beli harus angka',
          'hargajual.numeric'   => 'Harga Jual harus angka'
        ]);

        if(!empty($request->filefoto)) {
             $file = $request->filefoto;
            $pathUpload = 'assets/inventory';

            $extension = $file->getClientOriginalExtension();
            $filename = time().".".$extension;
            $file->move($pathUpload,$filename);
        }
        else {
            $filename=$request->fotolama;
        }
        $simpan=M_barang::where('kdbarang',$request->kdbarang)->update([
                                        'namabarang' => $request->namabarang,
                                        'deskripsi' => $request->deskripsi,
                                        'foto' => $filename,
                                        'berat' => $request->berat,
                                        'hargabeli' => $request->hargabeli,
                                        'hargajual' => $request->hargajual,
                                        'kdkategori' => $request->kdkategori
                                        ]);

        if($simpan){
                return redirect()->route('barang.index')
                    ->with(['success'=>'Barang sukses diubah']);
        } else {
            return redirect()->route('barang.index')
                    ->with(['success', 'ada kesalahan simpan, coba beberapa saat lagi']);
        }         //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapusgallery($id) {
        $mfoto=M_fotobarang::find($id);
        $destinationPath = 'assets/inventory/';
        File::delete($destinationPath.$mfoto->foto);
        M_fotobarang::where('kdfoto', '=', $id)->delete();
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $id=$request->kdbarang;
        $mfoto=M_barang::find($id);
        $destinationPath = 'assets/inventory/';
        File::delete($destinationPath.$mfoto->foto);
        M_barang::where('kdbarang', '=', $id)->delete();
        M_fotobarang::where('kdbarang', '=', $id)->delete();

        return redirect()->back();       //
    }
}
