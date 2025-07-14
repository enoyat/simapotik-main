<?php

namespace App\Http\Controllers;

use App\Models\M_customer;

use Illuminate\Http\Request;

class ApiCustomer extends Controller
{
    public function index()
    {
        $customer = M_customer::all();
        return $data = [
            'status' => 'success',
            'data' => $customer
        ];
    }
    public function show($id)
    {
        $customer = M_customer::find($id);
        return $data = [
            'status' => 'success',
            'data' => $customer
        ];
    }
    public function getcustomer(Request $request)
    {
        $customer = M_customer::Where('namacustomer', 'like', '%' . $request->namacustomer . '%')
            ->get();
        // $customer = M_customer::Where('namacustomer', 'like', '%' . "har" . '%')
        //     ->get();
        return $data = [
            'status' => 'success',
            'data' => $customer,
            'keyword' => $request->namacustomer
        ];
    }
    public function caricustomer(Request $request)
    {
        $customer = M_customer::where('kdcustomer', $request->kdcustomer)
            ->Where('kdcustomer', $request->kdcustomer)
            ->get();
        return $data = [
            'status' => 'success',
            'data' => $customer
        ];
    }
}
