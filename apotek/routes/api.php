<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', 'App\Http\Controllers\ApiAuthController@login');

Route::get('barang', 'App\Http\Controllers\ApiBarang@index');
Route::get('barang/{id}', 'App\Http\Controllers\ApiBarang@show');
Route::post('barang/store', 'App\Http\Controllers\ApiBarang@store');
Route::post('barang/getbarang', 'App\Http\Controllers\ApiBarang@getbarang');
Route::post('barang/caribarang', 'App\Http\Controllers\ApiBarang@caribarang');

Route::get('customer', 'App\Http\Controllers\ApiCustomer@index');
Route::get('customer/{id}', 'App\Http\Controllers\ApiCustomer@show');
Route::post('customer/getcustomer', 'App\Http\Controllers\ApiCustomer@getcustomer');
Route::post('customer/caricustomer', 'App\Http\Controllers\Apicustomer@caricustomer');

Route::post('penjualan/store', 'App\Http\Controllers\ApiPenjualan@store');
Route::post('penjualan/storeitem', 'App\Http\Controllers\ApiPenjualan@storeitem');
Route::post('penjualan/storepending', 'App\Http\Controllers\ApiPenjualan@storepending');
Route::post('penjualan/storependingitem', 'App\Http\Controllers\ApiPenjualan@storependingitem');
Route::post('penjualan/getpending', 'App\Http\Controllers\ApiPenjualan@getpending');
Route::post('penjualan/getitempending', 'App\Http\Controllers\ApiPenjualan@getitempending');
Route::post('penjualan/getpendingitem', 'App\Http\Controllers\ApiPenjualan@getpendingitem');
Route::post('penjualan/hapuspending', 'App\Http\Controllers\ApiPenjualan@hapuspending');
Route::post('penjualan/storeresep', 'App\Http\Controllers\ApiPenjualan@storeresep');

Route::post('dokter', 'App\Http\Controllers\ApiDokter@index');
Route::get('dokter/{id}', 'App\Http\Controllers\ApiDokter@show');
Route::post('dokter/getdokter', 'App\Http\Controllers\ApiDokter@getdokter');
Route::post('dokter/caridokter', 'App\Http\Controllers\ApiDokter@caridokter');

Route::get('penjualan', 'App\Http\Controllers\ApiPenjualan@index'); 
Route::get('penjualan/{id}', 'App\Http\Controllers\ApiPenjualan@show');

Route::post('transaksi/getinvoice', [App\Http\Controllers\ApiTransaksi::class, 'getinvoice']);
Route::post('transaksi/detailinvoice', [App\Http\Controllers\ApiTransaksi::class, 'detailinvoice']);

