<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_sesionuser;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SesionuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sesionuser=M_sesionuser::where('tgltrans',date('Y-m-d'))->orderBy('tgltrans','desc')->get();
        return view('sesionuser.index',['sesionuser'=>$sesionuser]);
   //
    }
    public function getuser(Request $request){
        $users = User::where('name','LIKE', '%'.$request->search.'%')->get();


        $response = array();
        foreach ($users as $value) {
            $response[] = array(
                "id" => $value->email,
                "text" => $value->name
            );
        }

        return response()->json($response);
    }
    public function gennotrans()
    {
        $kode = M_sesionuser::max('idsesionuser');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 1, 4);

            $noUrut++;
        }
        $char = "J";
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
        $token=rand(100000,999999);
        $sesionuser=M_sesionuser::get();
        return view('sesionuser.formsesionuser',['sesionuser'=>$sesionuser,'token'=>$token]);
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
            'email'  => 'required',
            'token'  => 'required'
        ],
        [
          'email.required'      => 'nama belum di isi'
        ]);

        $sesionuser = new M_sesionuser;
        $sesionuser->tgltrans = date('Y-m-d');
        $sesionuser->email = $request->email;
        $sesionuser->token = $request->token;

        $simpan = $sesionuser->save();
        if($simpan){
                return redirect()->route('sesionuser')
                    ->with(['success'=>'sesionuser sukses disimpan']);
        } else {
            return redirect()->route('sesionuser')
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
        $order=M_sesionuser::find($id);
        return view('sesionuser.tiket',['order'=>$order]);
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
        $product = M_sesionuser::where('id',$id)->first();
        return view('sesionuser.formeditsesionuser',['datasesionuser' => $product]);
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
            'f_status'  => 'required'
        ],
        [
          'f_status.required'     => 'status belum dipilih',
        ]);

        $simpan=M_sesionuser::where('id',$request->id)->update([
                                        'f_status' => $request->f_status
                                        ]);

        if($simpan){
                return redirect()->route('sesionuser')
                    ->with(['success'=>'sesionuser sukses diubah']);
        } else {
            return redirect()->route('sesionuser')
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
        $id=$request->id;
        M_sesionuser::where('idsesionuser', '=', $id)->delete();
        return redirect()->back();       //
    }
}
