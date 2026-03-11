<?php

namespace App\Http\Controllers;
use App\Models\M_dokter;

use Illuminate\Http\Request;

class ApiDokter extends Controller
{
    public function index()
    {
        $dokter = M_dokter::all();
        return $data=[
            'status' => 'success',
            'data' => $dokter
        ];
    }
    public function show($id)
    {
        $dokter = M_dokter::find($id);
        return $data=[
            'status' => 'success',
            'data' => $dokter
        ];
    }
    public function getdokter(Request $request)
    {
        $dokter = M_dokter::Where('namadokter', 'like', '%' . $request->namadokter . '%')
        ->get();
        return $data=[
            'status' => 'success',
            'data' => $dokter
        ];
    }
    public function caridokter(Request $request)
    {
        $dokter = M_dokter::where('kddokter',$request->kddokter)
        ->Where('kddokter',$request->kddokter)
        ->get();
        return $data=[
            'status' => 'success',
            'data' => $dokter
        ];
    }
}
