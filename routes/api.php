<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('dasbor', 'DasborController@chart');
Route::get('transaksi/buku', 'TransaksiController@getDataBukuApi');
Route::get('retur/{id}/buku', 'ReturController@getDataBukuApi');
Route::get('pengadaan/buku', 'PengadaanController@getDataBukuApi');
Route::post('laporan/penjualan', 'LaporanController@penjualan');
Route::post('laporan/pembelian', 'LaporanController@pembelian');