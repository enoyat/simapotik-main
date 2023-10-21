<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_akun;
use App\Models\M_msakun;
use App\Models\M_ktgakun;
use App\Models\M_lapjurnal;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class Akun extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akuns = M_akun::where('kdpst',Session::get('globalkdpst'))->get();
        $i=0;
        return view('akuns.index')->with(['akuns'=>$akuns,'i'=>$i]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $akuns=M_akun::get();
        $msakuns=M_msakun::get();
        $ktgakuns=M_ktgakun::get();
        return view('akuns.create',compact('akuns','msakuns','ktgakuns'));

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
            'kdakun' => 'required|unique:akun|min:5|max:5',
            'namaakun' => 'required',
            'kdmsakun' => 'required',
            'kdktgakun' => 'required',
            'typeakun' => 'required',
            'posisi' => 'required',
            'f_bb' => 'required',
            'f_neraca' => 'required',
            'f_lk' => 'required',
        ]);
        $kdakun=$request->kdakun.Session::get('globalkdpst');
        $cekakun=M_akun::where('kdakun',$kdakun)->get();
        if(count($cekakun)>0){
            Alert::error('Kode Akun Sudah Ada', 'Error Message');
            return redirect()->route('akuns.create')
                        ->with('error','Kode Akun Sudah Ada');
        };
        $dataakun=new M_akun;
        $dataakun->kdakun=$kdakun;     
        $dataakun->namaakun=$request->namaakun;        
        $dataakun->kdpst=Session::get('globalkdpst');
        $dataakun->kdmsakun=$request->kdmsakun;
        $dataakun->kdktgakun=$request->kdktgakun;
        $dataakun->typeakun=$request->typeakun;
        $dataakun->posisi=$request->posisi;
        $dataakun->f_bb=$request->f_bb;
        $dataakun->f_neraca=$request->f_neraca;
        $dataakun->f_lk=$request->f_lk;
        $dataakun->f_lr=$request->f_lr;
        $dataakun->save();
        return redirect()->route('akuns.index')
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
        $akuns=M_akun::find($id);
        return view('akuns.show',compact('akuns'));
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
        $akuns=M_akun::find($id);
        $msakuns=M_msakun::get();
        $ktgakuns=M_ktgakun::get();
        $dataakuns=M_akun::get();

        return view('akuns.edit',compact('akuns','msakuns','ktgakuns','dataakuns'));
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
            'kdakun' => 'required',
            'namaakun' => 'required',
            'kdmsakun' => 'required',
            'kdktgakun' => 'required',
            'typeakun' => 'required',
            'posisi' => 'required',
            'f_bb' => 'required',
            'f_neraca' => 'required',
            'f_lk' => 'required'
        ]);

        $dataakun=M_akun::find($id);
        $dataakun->kdakun=$request->kdakun;     
        $dataakun->namaakun=$request->namaakun;                    
        $dataakun->kdpst=Session::get('globalkdpst');
        $dataakun->kdmsakun=$request->kdmsakun;
        $dataakun->kdktgakun=$request->kdktgakun;
        $dataakun->typeakun=$request->typeakun;
        $dataakun->posisi=$request->posisi;
        $dataakun->f_bb=$request->f_bb;
        $dataakun->f_neraca=$request->f_neraca;
        $dataakun->f_lk=$request->f_lk;
        $dataakun->f_lr=$request->f_lr;
        $dataakun->save();

        return redirect()->route('akuns.index')
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
        //cek 
        if (M_lapjurnal::where('kdakun', $id)->exists()) {
            return redirect()->route('akuns.index')
                        ->with('success','Akun ini sudah ada transaksi, tidak dapat dihapus');
                
                // post with the same slug already exists
        }

        $akuns=M_akun::find($id);
        $akuns->delete();
        return redirect()->route('akuns.index')
                        ->with('success','Post deleted successfully');
        //
    }
}
