<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\M_barang;
use App\Models\M_kategori;
use App\Models\User;
use App\Models\M_keranjang;
use App\Models\M_order;
use App\Models\M_detorder;
use App\Models\M_pembayaran;
use Session;

use App\Veritrans\Midtrans;

class SnapController extends Controller
{
    public function __construct()
    {   
        Midtrans::$serverKey = 'Mid-server-L7G83mZbVzin6AZXQvzNZGrA';
        //set is production to true for production mode
        Midtrans::$isProduction = true;
    }

    public function snap()
    {
        $dataorder=M_order::where('kdorder',Session::get('kdorder'))->get();
        $jmlkeranjang=count(M_keranjang::where('kdmember',Session::get('kdmember'))->get());
        return view ('snap_checkout')->with(['dataorder'=>$dataorder,  'jmlkeranjang'=>$jmlkeranjang]);  

    }

    public function token() 
    {
        error_log('masuk ke snap token dri ajax');
        $dorder=M_order::where('kdorder',Session::get('kdorder'))
                        ->with('get_member')->get();       
        foreach ($dorder as $key ) {
            $kdorder=$key->kdorder;
            $total=$key->total;
            $kdmember=$key->kdmember;
            $namamember=$key->get_member->namamember;
            $nohp=$key->get_member->nohp;
            $alamat=$key->alamatpenerima;
            $email=$key->get_member->email;
        };


        $midtrans = new Midtrans;

        $transaction_details = array(
            'order_id'      => uniqid(),
            'gross_amount'  => $total
        );

        // Populate items
        $items = [
            array(
                  'id' => $kdmember,
                  'price' => $total,
                  'quantity' => 1,
                  'name' => "Pembelian an.".$namamember
            )
        ];

        // Populate customer's billing address
        $billing_address = array(
            'first_name'    => "Sugiyatno",
            'last_name'     => "Skom",
            'address'       => "Gg Mushola No. 4 Papringan",
            'city'          => "Yogyakarta",
            'postal_code'   => "55281",
            'phone'         => "082227131797",
            'country_code'  => 'IDN'
            );

        // Populate customer's shipping address
        $shipping_address = array(
            'first_name'    => "ezymart.id",
            'last_name'     => "online",
            'address'       => "Empire Regency No. 2 ",
            'city'          => "Yogyakarta",
            'postal_code'   => "55162",
            'phone'         => "082286265758",
            'country_code'  => 'IDN'
            );

        // Populate customer's Info
        $customer_details = array(
          'first_name'    => $namamember,
          'last_name'     => "-",
          'email'         => $email,
          'phone'         => $nohp,
          'billing_address'  => $billing_address,
          'shipping_address' => $shipping_address
            );

        // Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit'       => 'hour', 
            'duration'   => 2
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $items,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );
    
        try
        {
            $snap_token = $midtrans->getSnapToken($transaction_data);
            //return redirect($vtweb_url);
            echo $snap_token;
        } 
        catch (Exception $e) 
        {   
            return $e->getMessage;
        }
    }

    public function finish(Request $request)
    {
        $result = $request->input('result_data');
        $result = json_decode($result);

        if(isset($result->va_numbers[0]->bank)){
            $bank = $result->va_numbers[0]->bank;
        }else{
            $bank = "-";
        }

        if(isset($result->va_numbers[0]->va_number)){
            $va_number = $result->va_numbers[0]->va_number;
        }else{
            $va_number = "-";
        }

        if(isset($result->bca_va_number)){
            $bca_va_number = $result->bca_va_number;
        }else{
            $bca_va_number = "-";
        }

        if(isset($result->bill_key)){
            $bill_key = $result->bill_key;
        }else{
            $bill_key = "-";
        }

        if(isset($result->biller_code)){
            $biller_code = $result->biller_code;
        }else{
            $biller_code = "-";
        }

        if(isset($result->permata_va_number)){
            $permata_va_number = $result->permata_va_number;
        }else{
            $permata_va_number = "-";
        }

        if(isset($result->fraud_status)){
            $fraud_status = $result->fraud_status;
        }else{
            $fraud_status = "-";
        }


        if(isset($result->pdf_url)){
            $pdf_url = $result->pdf_url;
        }else{
            $pdf_url = "-";
        }

        if(isset($result->payment_code)){
            $payment_code = $result->payment_code;
        }else{
            $payment_code = "-";
        }


        $user =Session::get('kdorder');
        $coba = strtotime($result->transaction_time);

        $batas = date('Y-m-d H:i:s', strtotime('+1 day ',$coba));
        $simpanorder=M_pembayaran::create([
                    'transaction_id' => $result->transaction_id,
                    'order_id' => $result->order_id,
                    'gross_amount' => $result->gross_amount,
                    'payment_type' => $result->payment_type,
                    'transaction_time' => $result->transaction_time,
                    'transaction_status' => $result->transaction_status,
                    'fraud_status' => $result->fraud_status,
                    'pdf_url' => $pdf_url,
                    'finish_redirect_url' => $result->finish_redirect_url,
                    //tiap bank beda beda
                    'batas_pembayaran' => $batas,
                    'payment_code' => $payment_code,
                    'permata_va_number' => $permata_va_number,
                    'bank' => $bank,
                    'bill_key' => $bill_key,
                    'va_number' => $va_number,
                    'biller_code' => $biller_code,
                    'bca_va_number' => $bca_va_number,
                    'id_user' => $user,
                    'status' => "0"               
        ]);
        $data['finish'] = json_decode('result_data');

        $shark = M_order::find(Session::get('kdorder'));
        $shark->f_proses      = '0';
        $shark->va      = $va_number;

        $shark->save();
        
        return redirect()->route('order')
                        ->with('success', 'Pesanan Sukses' );

    }

    public function notification()
    {
        $midtrans = new Midtrans;
        echo 'test notification handler';
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);

        if($result){
        $notif = $midtrans->status($result->order_id);
        }

        error_log(print_r($result,TRUE));

        /*
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
          // For credit card transaction, we need to check whether transaction is challenge by FDS or not
          if ($type == 'credit_card'){
            if($fraud == 'challenge'){
              // TODO set payment status in merchant's database to 'Challenge by FDS'
              // TODO merchant should decide whether this transaction is authorized or not in MAP
              echo "Transaction order_id: " . $order_id ." is challenged by FDS";
              } 
              else {
              // TODO set payment status in merchant's database to 'Success'
              echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
              }
            }
          }
        else if ($transaction == 'settlement'){
          // TODO set payment status in merchant's database to 'Settlement'
          echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
          } 
          else if($transaction == 'pending'){
          // TODO set payment status in merchant's database to 'Pending'
          echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
          } 
          else if ($transaction == 'deny') {
          // TODO set payment status in merchant's database to 'Denied'
          echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }*/
   
    }
}    