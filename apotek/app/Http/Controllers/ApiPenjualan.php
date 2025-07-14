<?php

namespace App\Http\Controllers;

use App\Models\M_detailbayar;
use App\Models\M_detailpenjualan;
use App\Models\M_detailresep;
use App\Models\M_jurnalumum;
use App\Models\M_mstransaksi;
use App\Models\M_pendingdetailpenjualan;
use App\Models\M_pendingpenjualan;
use App\Models\M_penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiPenjualan extends Controller
{
    public function index()
    {
        $barang = M_penjualan::where('kdpst', '')->get();
        return $data = [
            'status' => 'success',
            'data' => $barang,
        ];
    }
    public function show($id)
    {
        $barang = M_penjualan::find($id);
        return $data = [
            'status' => 'success',
            'data' => $barang,
        ];
    }
    public function gennotrans()
    {
        $kode = DB::table('jurnalumum')->max('notrans');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = "JUM";
        $newID = $char . sprintf("%017s", $noUrut);
        return $newID;
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'idcustomer' => 'required',
            'total' => 'required',
            'email' => 'required',
            'modebayar' => 'required',
            'tgltrans' => 'required',
            'tipepenjualan' => 'required',
            'Items' => 'required|array',
            'Items.*.kdbarang' => 'required',
            'Items.*.qty' => 'required',
        ]);

        $jam = date("h:i");
        if ($request->idcustomer == "P0001") {
            $jenispenjualan = "R";
        } else {
            $jenispenjualan = "N";
        }
        // Lakukan penyimpanan ke database (contoh)
        // Misalnya, simpan ke tabel penjualan dan tabel item
        $penjualanId = DB::table('penjualan')->insertGetId([
            'idcustomer' => $validatedData['idcustomer'],
            'total' => $validatedData['total'],
            'email' => $validatedData['email'],
            'modebayar' => $validatedData['modebayar'],
            'tgltrans' =>  date("Y-m-d"),
            'tipepenjualan' => $validatedData['tipepenjualan'],
            'jam' => $jam,
            'jenispenjualan' => $jenispenjualan,

        ]);

        foreach ($validatedData['Items'] as $item) {
            DB::table('detailpenjualan')->insert([
                'idpenjualan' => $penjualanId,
                'kdbarang' => $item['kdbarang'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'diskonpersen' => $item['diskonpersen'],
                'diskon' => $item['diskon'],
                'jumlah' => $item['jumlah'],
                'idlokasi' => $item['idlokasi'],
            ]);
        }

        // Kembalikan respon sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'id' => $penjualanId,
        ], 201);
    }

    public function storepending(Request $request)
    {
        DB::beginTransaction();
        try {

            $jam = date("h:i");
            $penjualan = new M_pendingpenjualan;
            $penjualan->tgltrans = date("Y-m-d");
            $penjualan->jam = $jam;
            $penjualan->idcustomer = $request->idcustomer;
            $penjualan->total = $request->total;
            $penjualan->email = $request->email;
            $penjualan->modebayar = $request->modebayar;
            $penjualan->tipepenjualan = $request->tipepenjualan;
            $penjualan->save();
            $lastid = $penjualan->id;

            DB::commit();
            return $data = [
                'status' => 'success',
                'data' => [
                    'lastid' => $lastid,
                ]
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return $data = [
                'status' => 'error',
                'data' => [
                    'status' => 'error',
                    $e->getMessage()
                ],
            ];
        }
    }

    public function storependingitem(Request $request)
    {
        DB::beginTransaction();
        try {
            M_pendingdetailpenjualan::create([
                'idpenjualan' => $request->idpenjualan,
                'kdbarang' => $request->kdbarang,
                'qty' => $request->qty,
                'harga' => $request->harga,
                'diskonpersen' => $request->diskonpersen,
                'diskon' => $request->diskon,
                'jumlah' => $request->jumlah,
                'idlokasi' => $request->idlokasi,
            ]);

            DB::commit();
            return $data = [
                'status' => 'success',
                'data' => [
                    'lastid' =>  $request->lastid,
                ]
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return $data = [
                'status' => 'error',
                'data' => [
                    'status' => 'error',
                    $e->getMessage()
                ],
            ];
        }
    }
    public function getpending(Request $request)
    {
        $pending = M_pendingpenjualan::with('get_customer')->where('email', $request->email)->get();
        return $data = [
            'status' => 'success',
            'data' => $pending,
        ];
    }
    public function getpendingitem(Request $request)
    {
        $pending = M_pendingpenjualan::with('get_customer')->where('id', $request->id)->get();
        return $data = [
            'status' => 'success',
            'data' => $pending,
        ];
    }
    public function getitempending(Request $request)
    {
        $itempending = M_pendingdetailpenjualan::with('get_barang')->where('idpenjualan', $request->id)->get();
        return $data = [
            'status' => 'success',
            'data' => $itempending,
        ];
    }
    public function hapuspending(Request $request)
    {
        $pending = M_pendingpenjualan::where('id', $request->id)->delete();
        $itempending = M_pendingdetailpenjualan::where('idpenjualan', $request->id)->delete();
        return $data = [
            'status' => 'success',
            'data' => [],
        ];
    }

    public function storeresep(Request $request)
    {
        DB::beginTransaction();
        try {

            $detailresep = new M_detailresep();
            $detailresep->idpenjualan = $request->idpenjualan;
            $detailresep->idjenispasien = $request->idjenispasien;
            $detailresep->namapasien = $request->namapasien;
            $detailresep->iddokter = $request->iddokter;
            $detailresep->idpoly = $request->idpoly;
            $detailresep->noresep = $request->idpenjualan;
            $detailresep->admresep = '0';
            $detailresep->admracik = '0';
            $detailresep->save();

            DB::commit();
            return $data = [
                'status' => 'success',
                'data' => [
                    'lastid' => $request->idpenjualan,
                ]
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return $data = [
                'status' => 'error',
                'data' => [
                    'status' => 'error',
                    $e->getMessage()
                ],
            ];
        }
    }
}
