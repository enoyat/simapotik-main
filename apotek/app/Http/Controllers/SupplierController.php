<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_supplier;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier=M_supplier::get();
        return view('supplier.supplier',['supplier'=>$supplier]);
   //
    }
    public function gennotrans()
    {
        $kode = M_supplier::max('idsupplier');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 1, 4);

            $noUrut++;
        }
        $char = "S";
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
        $supplier=M_supplier::get();
        return view('supplier.formsupplier',['supplier'=>$supplier]);
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
            'namasupplier'  => 'required'
        ],
        [
          'namasupplier.min'      => 'nama Minimal 5 karakter'
        ]);

        $supplier = new M_supplier;
        $supplier->idsupplier = $this->gennotrans();
        $supplier->namasupplier = $request->namasupplier;
        $supplier->kdpst = Session::get('globalkdpst');
        $simpan = $supplier->save();
        if($simpan){
                return redirect()->route('supplier.index')
                    ->with(['success'=>'supplier sukses disimpan']);
        } else {
            return redirect()->route('supplier.index')
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
        $product = M_supplier::where('idsupplier',$id)->get();
       // dd($product);
        return view('supplier.formeditsupplier',['datasupplier' => $product]);
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
            'namasupplier'  => 'required'
        ],
        [
          'idsupplier.unique'     => 'idsupplier sudah ada',
          'namasupplier.min'      => 'nama Minimal 5 karakter',
        ]);

        $simpan=M_supplier::where('idsupplier',$request->idsupplier)->update([
                                        'namasupplier' => $request->namasupplier,
                                        'kdpst' => Session::get('globalkdpst')
                                        ]);

        if($simpan){
                return redirect()->route('supplier.index')
                    ->with(['success'=>'supplier sukses diubah']);
        } else {
            return redirect()->route('supplier.index')
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
        $id=$request->idsupplier;
        M_supplier::where('idsupplier', '=', $id)->delete();
        return redirect()->back();       //
    }
    public function getsupplier(Request $request){
        $supplier = M_supplier::where('namasupplier', 'LIKE', '%'.$request->search.'%')->orderBy('namasupplier', 'ASC')->get();

        $response = array();
        foreach ($supplier as $value) {
            $response[] = array(
                "id" => $value->idsupplier,
                "text" => $value->namasupplier
            );
        }

        return response()->json($response);
    }
}
