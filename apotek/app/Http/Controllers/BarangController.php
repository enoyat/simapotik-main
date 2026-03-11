<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\M_golongan;
use Illuminate\Http\Request;
use App\Models\M_barang;
use App\Models\M_kategori;
use App\Models\M_jenis;
use App\Models\M_supplier;
use App\Models\M_stoklokasi;
use App\Models\M_stok;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class barangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function genkdbarang() {
        $kode =DB::table('barang')->whereRaw("substr(kdbarang,1,1) = 'B'")->max('kdbarang');    

        if(empty($kode)) {
                $noUrut = 1;
        }
        else {
            $noUrut = substr($kode, 1);
            $noUrut++;            
        }
        $char = "B";
        $newID = $char . sprintf("%010s", $noUrut);
        return $newID;
    }
    public function index()
    {
        $jenis=M_jenis::get();
        $kategori=M_kategori::get();
        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
        where('stok.idlokasi', "TOKO")->
        where('barang.namabarang', 'like', '%aa%')->
        where('stok.stok', '>=', 0)->paginate(10);
        return view('barang.index',['barang'=>$barang, 'kategori'=>$kategori, 'jenis'=>$jenis]);
   //
    }
    public function fetch(Request $request)
    {

        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
        where('stok.idlokasi', "TOKO")->
        where('barang.namabarang', 'like', '%'.$request->namabarang.'%')->
        where('stok.stok', '>=', 0)->get();

        return view('barang.fetch', ['barang' => $barang]);
        //
    }
  public function detail($kdbarang){
    $kategori=M_kategori::get();
    $product = M_barang::where('kdbarang',$kdbarang)->with('get_foto')->get();
    return view('detailbarang',['barang' => $product, 'kategori'=>$kategori]);
  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier=M_supplier::orderBy('namasupplier','asc')->get();
        $kategori=M_kategori::get();
        return view('barang.formbarang',['kategori'=>$kategori,'supplier'=>$supplier]);
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
            'kdbarang'    => 'required|min:5',
            'namabarang'  => 'required',
            'hargabeli'   => 'required',
            'kdkategori'  => 'required',
            'idgolongan' =>'required',
            'idjenis'=>'required',
            'barcode'=>'required',
            'idsupplier'=>'required',
        ],
        [
          'kdbarang.required'   => 'Kdbaranng tidak boleh kosong',
          'kdbarang.min'   => 'Kdbarang Minimal 5 karakter',
          'namabarang.min'      => 'nama Minimal 5 karakter',
          'hargabeli.numeric'   => 'Harga beli harus angka',
        ]);
        $cekbarang=M_barang::where('kdbarang',$request->kdbarang)->count();
        if($cekbarang>0){
            Alert::error('Kode barang sudah ada', 'Gagal');
            return redirect()->back()->withInput();
        }
       

        $barang = new M_barang;
        if ($request->otomatis=="1"){
            $kdbarang = $this->genkdbarang();            
        }
        else {
            $kdbarang = $request->kdbarang;
        }
       // dd($kdbarang);
        $barang->kdbarang = $kdbarang;
        $barang->barcode = $request->barcode;
        $barang->idjenis = $request->idjenis;
        $barang->idgolongan = $request->idgolongan;
        $barang->namabarang = $request->namabarang;
        $barang->hna = $request->hna;
        $barang->diskon = $request->diskon;
        $barang->ppn = $request->ppn;
        $barang->hargabeli = $request->hargabeli;
        $barang->hargaresep = $request->hargaresep;
        $barang->hargagrosir = $request->hargagrosir;
        $barang->hargahv = $request->hargahv;
        $barang->hna_ppn = $request->hna_ppn;
        $barang->marginresep = $request->marginresep;
        $barang->marginhv = $request->marginhv;
        $barang->idsupplier = $request->idsupplier;
        $barang->minstok = $request->minstok;
        $barang->bhp = $request->bhp;
        $barang->kdkategori = $request->kdkategori;
        $barang->kdpst = Session::get('globalkdpst');
        $barang->f_status=$request->f_status;
        $barang->satuan=$request->satuan;
        $simpan = $barang->save();
        $lokasi=M_stoklokasi::get();
        foreach($lokasi as $lok){
            $stok = new M_stok;
            $stok->kdbarang = $kdbarang;
            $stok->idlokasi = $lok->idlokasi;
            $stok->stok = 0;
            $stok->save();
        }

        if($simpan){
            alert::success('Sukses', 'Data Berhasil Disimpan');
                return redirect()->route('barang.index')
                    ->with(['success'=>'barang sukses disimpan']);
        } else {
            alert::error('Gagal', 'Data Gagal Disimpan');
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
        $jenis=M_jenis::get();
        $golongan = M_golongan::get();
        $supplier=M_supplier::orderBy('namasupplier','asc')->get();
        $kategori=M_kategori::get();
        $barang = M_barang::find($id);
        return view('barang.formeditbarang',['barang' => $barang, 'kategori'=>$kategori,'supplier'=>$supplier,'jenis'=>$jenis,'golongan'=>$golongan]);
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

       // dd($request->all());
        $request->validate([
            'namabarang'  => 'required',
            'kdkategori'  => 'required',
            'idgolongan' =>'required',
            'idjenis'=>'required',
            'barcode'=>'required',
            'idsupplier'=>'required',

        ]);

        $barang = M_barang::find($request->kdbarang);
        $barang->barcode = $request->barcode;
        $barang->idjenis = $request->idjenis;
        $barang->idgolongan = $request->idgolongan;
        $barang->namabarang = $request->namabarang;
        $barang->hna = $request->hna;
        $barang->diskon = $request->diskon;
        $barang->ppn = $request->ppn;
        $barang->hargabeli = $request->hargabeli;
        $barang->hargaresep = $request->hargaresep;
        $barang->hargagrosir = $request->hargagrosir;
        $barang->hargahv = $request->hargahv;
        $barang->hna_ppn = $request->hna_ppn;
        $barang->marginresep = $request->marginresep;
        $barang->marginhv = $request->marginhv;
        $barang->idsupplier = $request->idsupplier;
        $barang->minstok = $request->minstok;
        $barang->bhp = $request->bhp;
        $barang->kdkategori = $request->kdkategori;
        $barang->kdpst=Session::get('globalkdpst');
        $barang->f_status=$request->f_status;
        $barang->satuan=$request->satuan;
        $simpan = $barang->save();
        if($simpan){
            alert::success('Sukses', 'Data Berhasil Disimpan');
                return redirect()->route('barang.index')
                    ->with(['success'=>'barang sukses disimpan']);
        } else {
            alert::error('Gagal', 'Data Gagal Disimpan');
            return redirect()->route('barang.index')
                    ->with(['success', 'ada kesalahan simpan, coba beberapa saat lagi']);
        }       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
   
        try {
            $id=$request->kdbarang;
            $mfoto=M_barang::find($id);
            $destinationPath = 'assets/inventory/';
            File::delete($destinationPath.$mfoto->foto);
            M_stok::where('kdbarang', '=', $id)->delete();
            M_barang::where('kdbarang', '=', $id)->delete();

            Alert::success('Sukses', 'Data Berhasil Dihapus');

           } catch(QueryException $ex){
                Alert::error('Gagal', 'Barang tidak bisa dihapus karena masih digunakan');
                return redirect()->route('barang.index');
           }



        return redirect()->back();       //
    }
    public function getjenis(Request $request){
        $jenis = M_jenis::where('namajenis', 'LIKE', '%'.$request->search.'%')->orderBy('namajenis', 'ASC')->get();

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
    public function getbarang(Request $request){
        $barang = M_barang::where('namabarang', 'LIKE', '%'.$request->search.'%')->orderBy('namabarang', 'ASC')->get();

        $response = array();
        foreach ($barang as $value) {
            $response[] = array(
                "id" => $value->kdbarang,
                "text" => $value->namabarang
            );
        }

        return response()->json($response);
    }
}
