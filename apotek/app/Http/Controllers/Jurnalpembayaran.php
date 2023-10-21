<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\M_register;
use App\Models\M_registrasi;
use App\Models\M_jalur;
use App\Models\M_fakultas;
use App\Models\M_prodi;
use App\Models\M_jadwal;
use App\Models\M_pengumuman;
use App\Models\M_trjawaban;
use App\Models\M_npm;
use App\Models\User;
use App\Models\M_jurnaltagihan;
use App\Models\M_jurnalpembayaran;


use session;

class Jurnalpembayaran extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $pembayaran = M_jurnalpembayaran::with('get_registrasi')
                    ->where('kdregister',$id)
                    ->get();
        return view('jurnalpembayaran.show', compact('pembayaran')); //
    }
    public function infopembayaranregistrasi($id)
    {
        $tagihan = M_jurnaltagihan::with('get_registrasi')
                    ->where('kdregister',$id)
                    ->get();

        $pembayaran = M_jurnalpembayaran::with('get_registrasi')
                    ->where('kdregister',$id)
                    ->get();
        return view('infopembayaranregistrasi', compact('pembayaran','tagihan')); //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        //
    }
}
