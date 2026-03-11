<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\M_mstagihan;
use App\Models\M_jurnaltagihan;



use session;

class Jurnaltagihan extends Controller
{

    public function show($id)
    {
        $tagihan = M_jurnaltagihan::with('get_registrasi')
                    ->where('kdregister',$id)
                    ->get();
        return view('jurnaltagihan.show', compact('tagihan')); //
    }

 
 public function inqueryVA($dataVA) {
        $id = 'UNTAGWS';
        $keyBTN = 'zi2RnanIv4zAk76KtARiNSDO9MnU24DK';
        $secret = 'bHnbWMlIPI';
        $url_create = 'https://vabtn.btn.co.id:9022/v1/untag/inqVA';

        $va=$dataVA['va'];
        $ref=$dataVA['ref'];
        //data
        $create_array = array(
            "ref" => $ref,
            "va" => $va
        );

        //For Body
        $create = '';
        $numItems = count($create_array);
        $i = 0;
        foreach ($create_array as $key => $value) {
            $create = $create . $key . '=' . $value;
            if (++$i !== $numItems) {
                $create = $create . '&';
            }
        }

        //For HMAC(SHA256)
        $init_sig = $id . ':' . json_encode($create_array) . ':' . $keyBTN;
        $sig = hash_hmac('sha256', $init_sig, $secret);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $create);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_create,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "key:" . $keyBTN,
                "id:" . $id,
                "signature:" . $sig
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $pesan="cURL Error #:" . $err;
        } else {
            $pesan= '<pre>' . $response . '</pre>';
        }
        return $pesan;
    }

  public function deleteVA($dataVA) {
        $id = 'UNTAGWS';
        $keyBTN = 'zi2RnanIv4zAk76KtARiNSDO9MnU24DK';
        $secret = 'bHnbWMlIPI';
        $url_create = 'https://vabtn.btn.co.id:9022/v1/untag/deleteVA';

        $va=$dataVA['va'];
        $ref=$dataVA['ref'];
        //data
        $create_array = array(
            "ref" => $ref,
            "va" => $va
        );

        //For Body
        $create = '';
        $numItems = count($create_array);
        $i = 0;
        foreach ($create_array as $key => $value) {
            $create = $create . $key . '=' . $value;
            if (++$i !== $numItems) {
                $create = $create . '&';
            }
        }

        //For HMAC(SHA256)
        $init_sig = $id . ':' . json_encode($create_array) . ':' . $keyBTN;
        $sig = hash_hmac('sha256', $init_sig, $secret);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $create);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_create,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "key:" . $keyBTN,
                "id:" . $id,
                "signature:" . $sig
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $pesan="cURL Error #:" . $err;
        } else {
            $pesan= '<pre>' . $response . '</pre>';
        }
        return $pesan;
    }

   public function hapusva(){
        return view('jurnaltagihan/hapusva');
   }
   public function gethapusva(Request $request){
        $tagihan=M_jurnaltagihan::where('nova',$request->nova)->get();
        if (count($tagihan)<1){
            return redirect()->route('jurnaltagihan.hapusva')
                         ->with('success', 'Data tidak ditemukan');
        }
        else {
            return view('jurnaltagihan/gethapusva')->with(['tagihan'=>$tagihan]);   
        }
   }
    public function inqva(){
      return view('jurnaltagihan/inqva');
   }
   public function getinqva(Request $request){
      $tagihan=M_jurnaltagihan::where('nova',$request->nova)->get();
      if (count($tagihan)<1){
      return redirect()->route('jurnaltagihan.inqva')
                   ->with('success', 'Data tidak ditemukan');
      }
      else {
           foreach ($tagihan as $key ) {
              $ref=$key->notagihan;
              $va=$key->nova;
           }
            $dataVA = array('ref' => $ref,
                              'va'=>$va,
                             );
            $exeva=Jurnaltagihan::inqueryVA($dataVA);
            return view('jurnaltagihan/getinqva')->with(['tagihan'=>$tagihan, 'success'=>$exeva]); 
      }
   }
   public function destroy($id){
        M_jurnaltagihan::where('notagihan',$id)->delete();
        return '{"status":"1"}';
   }
}
