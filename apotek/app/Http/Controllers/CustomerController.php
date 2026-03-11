<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_customer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer=M_customer::get();
        return view('customer.customer',['customer'=>$customer]);
   //
    }
    public function gennotrans()
    {
        $kode = M_customer::where('idcustomer', 'LIKE', 'C%')->max('idcustomer');
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
        $customer=M_customer::get();
        return view('customer.formcustomer',['customer'=>$customer]);
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
            'namacustomer'  => 'required'
        ],
        [
          'namacustomer.min'      => 'nama Minimal 5 karakter'
        ]);

        $customer = new M_customer;
        $customer->idcustomer = $this->gennotrans();
        $customer->namacustomer = $request->namacustomer;
        $customer->kategori= $request->kategori;
        $simpan = $customer->save();
        if($simpan){
                return redirect()->route('customer.index')
                    ->with(['success'=>'customer sukses disimpan']);
        } else {
            return redirect()->route('customer.index')
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
        $product = M_customer::where('idcustomer',$id)->get();
       // dd($product);
        return view('customer.formeditcustomer',['datacustomer' => $product]);
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
            'namacustomer'  => 'required'
        ],
        [
          'idcustomer.unique'     => 'idcustomer sudah ada',
          'namacustomer.min'      => 'nama Minimal 5 karakter',
        ]);

        $simpan=M_customer::where('idcustomer',$request->idcustomer)->update([
                                        'namacustomer' => $request->namacustomer,
                                        'kategori' => $request->kategori,
                                        ]);

        if($simpan){
                return redirect()->route('customer.index')
                    ->with(['success'=>'customer sukses diubah']);
        } else {
            return redirect()->route('customer.index')
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
        $id=$request->idcustomer;
        M_customer::where('idcustomer', '=', $id)->delete();
        return redirect()->back();       //
    }
    public function getcustomer(Request $request){
        $customer = M_customer::where('namacustomer', 'LIKE', '%'.$request->search.'%')->orderBy('namacustomer', 'ASC')->get();

        $response = array();
        foreach ($customer as $value) {
            $response[] = array(
                "id" => $value->idcustomer,
                "text" => $value->namacustomer
            );
        }

        return response()->json($response);
    }
}
