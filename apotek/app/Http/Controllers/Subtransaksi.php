<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_mstransaksi;
use App\Models\M_subtransaksi;
use App\Models\M_akun;
use Session;
use Illuminate\Support\Facades\DB;

class Subtransaksi extends Controller
{
    function gennotrans() {
        $kode =DB::table('subtransaksi')->max('kdsubtransaksi');    
                if(empty($kode)) {
                $noUrut = 1;
        }
        else {
            $noUrut = substr($kode, 3);
            $noUrut++;            
        }
        $char = "STR";
        $newID = $char . sprintf("%04s", $noUrut);
        return $newID;
    }
    public function tambah($id)
    {
        $kdtransaksi=$id;
        //dd($kdtransaksi);
         $msakuns=M_akun::where('kdpst',Session::get('globalkdpst'))->orderby('namaakun')->get();
        return view('subtransaksis.create',compact('msakuns','kdtransaksi'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'kdtransaksi' => 'required',
            'namasubtransaksi' => 'required',
            'kdakun_d' => 'required',
            'kdakun_k' => 'required'

        ]);
        $subtransaksi=new M_subtransaksi;
        $subtransaksi->kdsubtransaksi=Subtransaksi::gennotrans();  
        $subtransaksi->kdtransaksi=$request->kdtransaksi;   
        $subtransaksi->kdpst=Session::get('globalkdpst');
        $subtransaksi->namasubtransaksi=$request->namasubtransaksi;   
        $subtransaksi->kdakun_d=$request->kdakun_d;    
        $subtransaksi->kdakun_k=$request->kdakun_k;    
        $subtransaksi->save();    
        return redirect()->route('mstransaksis.index')
                        ->with('success','Sub Transaksi created successfully.');
        //
    }

    public function show($id)
    {
        $subtransaksis=M_subtransaksi::find($id);
        return view('subtransaksis.show',compact('subtransaksis'));
        //
    }
    public function edit($id)
    {
        $subtransaksis=M_subtransaksi::find($id);
        $msakuns=M_akun::where('kdpst',Session::get('globalkdpst'))->orderby('namaakun')->get();
        return view('subtransaksis.edit',compact('subtransaksis','msakuns'));
        //
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'kdsubtransaksi' => 'required',
            'kdtransaksi' => 'required',
            'namasubtransaksi' => 'required',
            'kdakun_d' => 'required',
            'kdakun_k' => 'required'

        ]);

        $subtransaksi=M_subtransaksi::find($id);
        $subtransaksi->kdtransaksi=$request->kdtransaksi;   
        $subtransaksi->kdpst=Session::get('globalkdpst');
        $subtransaksi->namasubtransaksi=$request->namasubtransaksi;   
        $subtransaksi->kdakun_d=$request->kdakun_d;    
        $subtransaksi->kdakun_k=$request->kdakun_k;    
        $subtransaksi->save();  

        return redirect()->route('mstransaksis.index')
                        ->with('success','Sub Transaksi updated successfully');
        //
    }
    public function destroy($id)
    {
        $subtransaksis=M_subtransaksi::find($id);
        $subtransaksis->delete();
        return redirect()->route('mstransaksis.index')
                        ->with('success','Sub Transaksi deleted successfully');
        //
    }
}
