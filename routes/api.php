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


Route::get('unlogin', ['as' => 'unlogin', 'uses' => 'Api\PegawaiController@Unauthorized']);
// ROUTE PEGAWAI CREATE , SHOW, UPDATE, DELETE
Route::prefix('pegawai')->group(function () {
    Route::post('masuk', 'Api\PegawaiController@Login');
    Route::post('buatbaru', 'Api\PegawaiController@BuatBaru');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('infosaya', 'Api\PegawaiController@InfoSaya');
        Route::get('semua', 'Api\PegawaiController@SemuaPegawai');
        Route::get('satu/{id}', 'Api\PegawaiController@SatuPegawai');
        Route::post('edit/{id}', 'Api\PegawaiController@EditPegawai');
        Route::get('hapus/{id}', 'Api\PegawaiController@DeletePegawai');
    });
});

// ROUTE CABANG CREATE , SHOW, UPDATE, DELETE
Route::prefix('cabang')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\CabangController@BuatBaru');
        Route::get('semua', 'Api\CabangController@SemuaCabang');
        Route::get('satu/{id}', 'Api\CabangController@SatuCabang');
        Route::post('edit/{id}', 'Api\CabangController@EditCabang');
        Route::get('hapus/{id}', 'Api\CabangController@DeleteCabang');
    });
});
// ROUTE JASA SERVIS CREATE , SHOW, UPDATE, DELETE
Route::prefix('jasaservis')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\JasaServisController@BuatBaru');
        Route::get('semua', 'Api\JasaServisController@SemuaJasaServis');
        Route::get('satu/{id}', 'Api\JasaServisController@SatuJasaServis');
        Route::post('edit/{id}', 'Api\JasaServisController@EditJasaServis');
        Route::get('hapus/{id}', 'Api\JasaServisController@DeleteJasaServis');
    });
});

// ROUTE SPAREPART CREATE , SHOW, UPDATE, DELETE
Route::prefix('sparepart')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\SparepartController@BuatBaru');
        Route::get('semua', 'Api\SparepartController@SemuaSparepart');
        Route::get('satu/{id}', 'Api\SparepartController@SatuSparepart');
        Route::post('edit/{id}', 'Api\SparepartController@EditSparepart');
        Route::get('hapus/{id}', 'Api\SparepartController@DeleteSparepart');
    });
});

// ROUTE JENIS MOTOR CREATE , SHOW, UPDATE, DELETE
Route::prefix('jenismotor')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\JenisMotorController@BuatBaru');
        Route::get('semua', 'Api\JenisMotorController@SemuaJenisMotor');
        Route::get('satu/{id}', 'Api\JenisMotorController@SatuJenisMotor');
        Route::post('edit/{id}', 'Api\JenisMotorController@EditJenisMotor');
        Route::get('hapus/{id}', 'Api\JenisMotorController@DeleteJenisMotor');
        Route::get('darisparepart/{idSparepart}', 'Api\JenisMotorController@DariSparepart');
    });
});
// ROUTE Sales CREATE , SHOW, UPDATE, DELETE
Route::prefix('sales')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\SalesController@BuatBaru');
        Route::get('semua', 'Api\SalesController@SemuaSales');
        Route::get('satu/{id}', 'Api\SalesController@SatuSales');
        Route::post('edit/{id}', 'Api\SalesController@EditSales');
        Route::get('hapus/{id}', 'Api\SalesController@DeleteSales');
    });
});
// ROUTE SUPPLIER CREATE , SHOW, UPDATE, DELETE
Route::prefix('supplier')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\SupplierController@BuatBaru');
        Route::get('semua', 'Api\SupplierController@SemuaSupplier');
        Route::get('satu/{id}', 'Api\SupplierController@SatuSupplier');
        Route::post('edit/{id}', 'Api\SupplierController@EditSupplier');
        Route::get('hapus/{id}', 'Api\SupplierController@DeleteSupplier');
    });
});

// ROUTE Konsumen CREATE , SHOW, UPDATE, DELETE
Route::prefix('konsumen')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\KonsumenController@BuatBaru');
        Route::get('semua', 'Api\KonsumenController@SemuaKonsumen');
        Route::get('satu/{id}', 'Api\KonsumenController@SatuKonsumen');
        Route::post('edit/{id}', 'Api\KonsumenController@EditKonsumen');
        Route::get('hapus/{id}', 'Api\KonsumenController@DeleteKonsumen');
    });
});

// ROUTE Kendaraan CREATE , SHOW, UPDATE, DELETE
Route::prefix('kendaraan')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\KendaraanController@BuatBaru');
        Route::get('semua', 'Api\KendaraanController@SemuaKendaraan');
        Route::get('satu/{id}', 'Api\KendaraanController@SatuKendaraan');
        Route::post('edit/{id}', 'Api\KendaraanController@EditKendaraan');
        Route::get('hapus/{id}', 'Api\KendaraanController@DeleteKendaraan');
    });
});

// ROUTE Transaksi CREATE , SHOW, UPDATE, DELETE
Route::prefix('transaksi')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\TransaksiController@BuatBaru');
        Route::post('bayar/{id}', 'Api\TransaksiController@Bayar');
        Route::get('total/{id}', 'Api\TransaksiController@TotalSemua');
        Route::get('semuabayar', 'Api\TransaksiController@SemuaBayar');
        Route::get('semua', 'Api\TransaksiController@SemuaTransaksi');
        Route::get('semuasparepart/{id}', 'Api\TransaksiController@SemuaDetailSparepart');
        Route::get('semuaservis/{id}', 'Api\TransaksiController@SemuaDetailServis');
        Route::get('semuapegawai/{id}', 'Api\TransaksiController@SemuaPegawai');
        Route::get('satu/{id}', 'Api\TransaksiController@SatuTransaksi');
        Route::post('edit/{id}', 'Api\TransaksiController@EditTransaksi');
        Route::get('hapus/{id}', 'Api\TransaksiController@DeleteTransaksi');
    });
});

// ROUTE DetailServis CREATE , SHOW, UPDATE, DELETE
Route::prefix('detailservis')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\DetailServisController@BuatBaru');
        Route::get('semua', 'Api\DetailServisController@SemuaDetailServis');
        Route::get('satumontir/{id}', 'Api\DetailServisController@SatuMontir');
        Route::get('statusmaju/{id}', 'Api\DetailServisController@MajukanStatus');
        Route::get('statusmundur/{id}', 'Api\DetailServisController@MundurkanStatus');
        Route::get('satu/{id}', 'Api\DetailServisController@SatuDetailServis');
        Route::post('edit/{id}', 'Api\DetailServisController@EditDetailServis');
        Route::get('hapus/{id}', 'Api\DetailServisController@DeleteDetailServis');
    });
});

// ROUTE DetailSparepart CREATE , SHOW, UPDATE, DELETE
Route::prefix('detailsparepart')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('buatbaru', 'Api\DetailSparepartController@BuatBaru');
        Route::get('semua', 'Api\DetailSparepartController@SemuaDetailSparepart');
        Route::get('satu/{id}', 'Api\DetailSparepartController@SatuDetailSparepart');
        Route::post('edit/{id}', 'Api\DetailSparepartController@EditDetailSparepart');
        Route::get('hapus/{id}', 'Api\DetailSparepartController@DeleteDetailSparepart');
    });
});
