<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_akun;
use App\Models\M_kelakun;
use App\Models\M_trkelakun;
use validator;
use Illuminate\Validation\Rule;
class Kelompokakun extends Controller
{
    public function index() {
        $mkelakuns=M_kelakun::pluck('nmkelakun', 'kdkelakun');  
       return view('kelompokakun.index',compact('mkelakuns')); 
    }
    public function tambah($id)
    {
        $kdkelakun=$id;
        //dd($kdtransaksi);
        $msakuns=M_akun::get();
        return view('kelompokakun.create',compact('msakuns','kdkelakun'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'kdkelakun' => 'required',
            'kdakun' => ['required',
                         Rule::unique('trkelakun')
                                    ->where('kdakun', $request->kdakun)
                                    ->where('kdkelakun', $request->kdkelakun)
                            ]
        ]);

         M_trkelakun::create($request->all());

        return redirect()->route('kelompokakuns.index')
                        ->with('success','created successfully.');
        //
    }

    public function hapus($id)
    {
       // dd($id);
        $trkelakun=M_trkelakun::find($id);
        $trkelakun->delete();
        return redirect()->route('kelompokakuns.index')
                        ->with('success','deleted successfully');
        //
    }
}
