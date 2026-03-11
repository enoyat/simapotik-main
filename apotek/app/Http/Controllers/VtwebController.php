<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\M_pembayaran;
use App\Models\M_order;
use Session;

use App\Veritrans\Veritrans;

class VtwebController extends Controller
{
    public function __construct()
    {   
        Veritrans::$serverKey = 'Mid-server-L7G83mZbVzin6AZXQvzNZGrA';

        //set Veritrans::$isProduction  value to true for production mode
        Veritrans::$isProduction = true;
    }
    public function notification()
    {
        $vt = new Veritrans;
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);
        if($result){
                $notif = $vt->status($result->order_id);
                $transaction =$result->transaction_status;
                $type = $result->payment_type;
                $order_id =$result->order_id;
                $fraud = $result->fraud_status; 

                $dataorder=M_pembayaran::where('order_id','=',$order_id)->get();
                foreach ($dataorder as $key ) {
                    $kdorder=$key->id_user;
                    # code...
                }
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
                            M_order::where('kdorder',$kdorder)->update([
                                        'tglverifikasi'=>date('Y-m-d'),'f_status'=> '1', 'f_proses'=> '1'  
                                        ]); 
                            M_pembayaran::where('id_user',$kdorder)->update([
                                        'status'=> '1' 
                                        ]); 
                             
         
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
                  }
                  else if ($transaction == 'expire') {
                            M_order::where('kdorder',$kdorder)->update([
                                        'f_cancel'=> '1' 
                                        ]); 
                  // TODO set payment status in merchant's database to 'expire'
                  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
                  }
                  else if ($transaction == 'cancel') {
                  // TODO set payment status in merchant's database to 'Denied'
                  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
                }
        }
        else {
                echo "<pre>tidak ada transaksi</pre>";
        }
       
    }
}    