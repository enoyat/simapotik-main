<?php

namespace App\Http\Controllers;

use App\Models\M_barang;
use Illuminate\Http\Request;

class ApiBarang extends Controller
{

    public function show($id)
    {
        $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
            where('stok.idlokasi', 'TOKO')->
            Where('barang.kdbarang', $id)->first();

        //  $barang = M_barang::find($id);
        return response()->json([
            'success' => 'success',
            'data' => $barang,
        ], 200);

    }
    public function getbarang(Request $request)
    {
        if ($request->nim == "1000") {
            $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
                where('stok.idlokasi', $request->idlokasi)->
                Where('namabarang', 'like', '%' . $request->namabarang . '%')->
                where('stok.stok', '>=', 0)->
                where('f_status', "AKTIF")->
                where('idgolongan',"!=","G0004")->
                where('idgolongan',"!=","G0006")

                ->get();
                return $data = [
                    'status' => 'success',
                    'data' => $barang,
                ];

        } else {
            $barang = M_barang::join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')->
                where('stok.idlokasi', $request->idlokasi)->
                Where('namabarang', 'like', '%' . $request->namabarang . '%')->
                where('stok.stok', '>=', 0)->
                where('f_status', "AKTIF")
                ->get();

            // $barang = M_barang::where('kdpst',$request->kdpst)
            // ->Where('namabarang', 'like', '%' . $request->namabarang . '%')

            // ->get();
            return $data = [
                'status' => 'success',
                'data' => $barang,
            ];
        }
    }
    // public function caribarang(Request $request)
    // {
    //     $barang = M_barang::where('kdbarang',$request->kdbarang)
    //     ->Where('kdbarang',$request->kdbarang)
    //     ->get();
    //     return $data=[
    //         'status' => 'success',
    //         'data' => $barang
    //     ];
    // }
    public function caribarang(Request $request)
    {
        $barang = M_barang::where('barang.kdbarang', $request->kdbarang)
            ->join('stok', 'barang.kdbarang', '=', 'stok.kdbarang')
            ->where('stok.idlokasi', $request->idlokasi)
            ->get();
        return response()->json([
            'success' => 'success',
            'data' => $barang,
        ], 200);

    }

}
