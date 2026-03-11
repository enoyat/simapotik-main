<?php

namespace App\Http\Controllers;

use App\Models\M_akun;
use App\Models\M_ktgtransaksi;
use App\Models\M_mstransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MStransaksi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gennotrans()
    {
        $kode = M_mstransaksi::max('kdtransaksi');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 2, 4);

            $noUrut++;
        }
        $char = "TR";
        $newID = $char . sprintf("%04s", $noUrut).Session::get('globalkdpst');
        return $newID;
    }
    public function index()
    {
        $mstransaksis = M_mstransaksi::where('kdpst', Session::get('globalkdpst'))->get();
        $ktgtransaksis = M_ktgtransaksi::get();
        $i = 0;
        return view('mstransaksis.index', compact('mstransaksis', 'i', 'ktgtransaksis'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $msakuns = M_akun::where('kdpst', Session::get('globalkdpst'))->orderby('namaakun')->get();
        $ktgtransaksis = M_ktgtransaksi::get();
        return view('mstransaksis.create', compact('msakuns', 'ktgtransaksis'));

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
            'namatransaksi' => 'required',
            'kdakun_d' => 'required',
            'kdakun_k' => 'required',

        ]);
        $transaksi = new M_mstransaksi;
        $transaksi->kdtransaksi = MStransaksi::gennotrans();
        $transaksi->kdpst = Session::get('globalkdpst');
        $transaksi->namatransaksi = $request->namatransaksi;
        $transaksi->kdakun_d = $request->kdakun_d;
        $transaksi->kdakun_k = $request->kdakun_k;
        $transaksi->kdktgtransaksi = $request->kdktgtransaksi;
        $transaksi->save();

        return redirect()->route('mstransaksis.index')
            ->with('success', 'Transaksi created successfully.');
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
        $mstransaksis = M_mstransaksi::find($id);
        $ktgtransaksis = M_ktgtransaksi::get();
        return view('mstransaksis.show', compact('mstransaksis', 'ktgtransaksis'));
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
        $mstransaksis = M_mstransaksi::find($id);
        $ktgtransaksis = M_ktgtransaksi::get();
        $msakuns = M_akun::where('kdpst', Session::get('globalkdpst'))->orderby('namaakun')->get();
        return view('mstransaksis.edit', compact('mstransaksis', 'msakuns', 'ktgtransaksis'));
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
            'kdtransaksi' => 'required',
            'namatransaksi' => 'required',
            'kdakun_d' => 'required',
            'kdakun_k' => 'required',

        ]);

        $mstransaksis = M_mstransaksi::find($id);
        $mstransaksis->kdpst = Session::get('globalkdpst');
        $mstransaksis->namatransaksi = $request->namatransaksi;
        $mstransaksis->kdakun_d = $request->kdakun_d;
        $mstransaksis->kdakun_k = $request->kdakun_k;
        $mstransaksis->kdktgtransaksi = $request->kdktgtransaksi;
        $mstransaksis->save();

        return redirect()->route('mstransaksis.index')
            ->with('success', 'Transaksi updated successfully');
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
        $mstransaksis = M_mstransaksi::find($id);
        $mstransaksis->delete();
        return redirect()->route('mstransaksis.index')
            ->with('success', 'Transaksi deleted successfully');
        //
    }
}
