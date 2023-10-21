<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\M_golongan;
use Illuminate\Http\Request;
use App\Models\M_obat;
use App\Models\M_kategori;
use App\Models\M_jenis;
use App\Models\M_supplier;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori=M_kategori::get();
        $obat = M_obat::with('get_kategori')->get();
        return view('obat.index',['obat' => $obat, 'kategori'=>$kategori]);
   //
    }
  public function detail($kdobat){
    $kategori=M_kategori::get();
    $product = M_obat::where('kdobat',$kdobat)->with('get_foto')->get();
    return view('detailobat',['obat' => $product, 'kategori'=>$kategori]);
  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier=M_supplier::get();
        $kategori=M_kategori::get();
        return view('obat.formobat',['kategori'=>$kategori,'supplier'=>$supplier]);
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
            'kdobat'    => 'required|min:5|max:5',
            'namaobat'  => 'required',
            'hargabeli'   => 'required',
            'kdkategori'  => 'required'
        ],
        [
          'kdobat.required'   => 'Kdbaranng tidak boleh kosong',
          'kdobat.min'   => 'Kdobat Minimal 5 karakter',
          'kdobat.max'   => 'Kdobat Maximal 5 karakter',
          'namaobat.min'      => 'nama Minimal 5 karakter',
          'hargabeli.numeric'   => 'Harga beli harus angka',
        ]);
        $cekobat=M_obat::where('kdobat',$request->kdobat)->count();
        if($cekobat>0){
            Alert::error('Kode obat sudah ada', 'Gagal');
            return redirect()->back()->withInput();
        }

        $obat = new M_obat;
        $obat->kdobat = $request->kdobat;
        $obat->barcode = $request->barcode;
        $obat->idjenis = $request->idjenis;
        $obat->idgolongan = $request->idgolongan;
        $obat->namaobat = $request->namaobat;
        $obat->hna = $request->hna;
        $obat->diskon = $request->diskon;
        $obat->ppn = $request->ppn;
        $obat->hargabeli = $request->hargabeli;
        $obat->hargaresep = $request->hargaresep;
        $obat->hargagrosir = $request->hargagrosir;
        $obat->hargahv = $request->hargahv;
        $obat->hna_ppn = $request->hna_ppn;
        $obat->marginresep = $request->marginresep;
        $obat->marginhv = $request->marginhv;
        $obat->idsupplier = $request->idsupplier;
        $obat->minstok = $request->minstok;
        $obat->bhp = $request->bhp;
        $obat->kdkategori = $request->kdkategori;
        $obat->stok = 0;
        $simpan = $obat->save();
        if($simpan){
                return redirect()->route('obat.index')
                    ->with(['success'=>'obat sukses disimpan']);
        } else {
            return redirect()->route('obat.index')
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
        $supplier=M_supplier::get();
        $kategori=M_kategori::get();
        $obat = M_obat::find($id);
        return view('obat.formeditobat',['obat' => $obat, 'kategori'=>$kategori,'supplier'=>$supplier]);
       //
    }

    public function uploadgallery(Request $request){
        $file = $request->filefoto;
        $pathUpload = 'assets/inventory';

        $extension = $file->getClientOriginalExtension();
        $filename = time().".".$extension;
        $file->move($pathUpload,$filename);
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
            'namaobat'  => 'required',
            'deskripsi'   => 'required',
            'hargabeli'   => 'required',
            'hargajual'   => 'required',
            'kdkategori'  => 'required'
        ],
        [
          'kdobat.unique'     => 'Kdobat sudah ada',
          'namaobat.min'      => 'nama Minimal 5 karakter',
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
        $simpan=M_obat::where('kdobat',$request->kdobat)->update([
                                        'namaobat' => $request->namaobat,
                                        'deskripsi' => $request->deskripsi,
                                        'foto' => $filename,
                                        'berat' => $request->berat,
                                        'hargabeli' => $request->hargabeli,
                                        'hargajual' => $request->hargajual,
                                        'kdkategori' => $request->kdkategori
                                        ]);

        if($simpan){
                return redirect()->route('obat.index')
                    ->with(['success'=>'obat sukses diubah']);
        } else {
            return redirect()->route('obat.index')
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
        $id=$request->kdobat;
        $mfoto=M_obat::find($id);
        $destinationPath = 'assets/inventory/';
        File::delete($destinationPath.$mfoto->foto);
        M_obat::where('kdobat', '=', $id)->delete();

        return redirect()->back();       //
    }
    public function getjenis(){
        $jenis = M_jenis::get();

        $response = array();
        foreach ($jenis as $value) {
            $response[] = array(
                "id" => $value->idjenis,
                "text" => $value->namajenis
            );
        }

        return response()->json($response);
    }
    public function getgolongan(){
        $golongan = M_golongan::get();

        $response = array();
        foreach ($golongan as $value) {
            $response[] = array(
                "id" => $value->idgolongan,
                "text" => $value->namagolongan
            );
        }

        return response()->json($response);
    }
}
