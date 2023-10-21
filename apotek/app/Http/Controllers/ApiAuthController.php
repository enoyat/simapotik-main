<?php

namespace App\Http\Controllers;

use App\Models\M_sesionuser;
use App\Models\User;
use App\Models\M_toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),

        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            $cek = Auth::user();
            $toko=M_toko::first();
            $datauser=[
                'email' => $cek->email,
                'kdpst' => $cek->kdpst,
                'toko' => $toko->toko,
                'alamat' => $toko->alamat,
                'telpon' => $toko->telpon,
                'nim' => $cek->nim,
            ];
            $ceksession=M_sesionuser::where('email', Auth::user()->email)
            ->where('token', $request->input('token'))
            ->where('f_status', '1')
            ->where('tgltrans', date('Y-m-d'))
            ->get();
            if (count($ceksession) > 0) {
                return $data = [
                    'status' => 'success',
                    'data' => [$datauser]
                ];
            } else {
                return $data = [
                    'status' => 'failed',
                    'data' => [],
                ];
            }

        } else { // false
            return $data = [
                'status' => 'failed',
                'data' => [],
            ];
        }

    }

}
