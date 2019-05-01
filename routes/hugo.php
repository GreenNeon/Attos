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

// ROUTE CABANG CREATE , SHOW, UPDATE, DELETE
Route::prefix('sparepart')->group(function () {
    Route::post('create', 'Api\SparepartController@create');
    Route::get('read', 'Api\SparepartController@read');
    Route::post('update', 'Api\SparepartController@update');
    Route::post('delete', 'Api\SparepartController@delete');
});

Route::prefix('pegawai')->group(function () {
    Route::post('login', 'Api\PegawaiController@loginmobile');
    Route::get('read', 'Api\PegawaiController@read');
});