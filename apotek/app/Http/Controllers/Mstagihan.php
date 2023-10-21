<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_akun;
use App\Models\M_mstagihan;
use App\Models\M_mstransaksi;
use Session;

class Mstagihan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mstagihans = M_mstagihan::where('kdpst',Session::get('kdpst'))->get();
        $i=0;
        return view('mstagihan.index',compact('mstagihans','i'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mstransaksis=M_mstransaksi::where('kdpst',Session::get('kdpst'))->orderby('namatransaksi')->get();
        return view('mstagihan.create',compact('mstransaksis'));

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
            'namatagihan' => 'required',
            'kdtransaksi' => 'required',
            'kdtransaksilawan' => 'required',
            'jumlah' => 'required',
            'modebayar' => 'required',


        ]);
        $datatagihan=new M_mstagihan;
        $datatagihan->kdtagihan=$request->kdtagihan;     
        $datatagihan->namatagihan=$request->namatagihan;        
        $datatagihan->kdpst=Session::get('kdpst');
        $datatagihan->kdtransaksi=$request->kdtransaksi;
        $datatagihan->kdtransaksilawan=$request->kdtransaksilawan;
        $datatagihan->jumlah=$request->jumlah;
        $datatagihan->modebayar=$request->modebayar;

        $datatagihan->save();

        return redirect()->route('mstagihan.index')
                        ->with('success','Post created successfully.');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mstagihans = M_mstagihan::find($id);
        return view('mstagihan.show',compact('mstagihans'));
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
        $mstagihans = M_mstagihan::find($id);
        $mstransaksis=M_mstransaksi::where('kdpst',Session::get('kdpst'))->get();

        return view('mstagihan.edit',compact('mstagihans','mstransaksis'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
             'kdtagihan' => 'required',
            'namatagihan' => 'required',
            'kdtransaksi' => 'required',
            'kdtransaksilawan' => 'required',
            'jumlah' => 'required'

        ]);

        $datatagihan=M_mstagihan::find($id);
        $datatagihan->namatagihan=$request->namatagihan;        
        $datatagihan->kdpst=Session::get('kdpst');
        $datatagihan->kdtransaksi=$request->kdtransaksi;
        $datatagihan->kdtransaksilawan=$request->kdtransaksilawan;
        $datatagihan->jumlah=$request->jumlah;
        $datatagihan->modebayar=$request->modebayar;
        $datatagihan->save();
        return redirect()->route('mstagihan.index')
                        ->with('success','Post updated successfully');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mstagihan=M_mstagihan::find($id);
        $mstagihan->delete();
        return redirect()->route('mstagihan.index')
                        ->with('success','Post deleted successfully');
        //
    }
}
