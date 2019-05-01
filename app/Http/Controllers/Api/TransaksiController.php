<?php

namespace App\Http\Controllers\Api;

use App\Model\Transaksi;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PegawaiKerja;

class TransaksiController extends Controller
{
    //Untuk CS
    
    function BuatBaru(Request $request)
    {
        $customreq = $request->all();
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
            'fk_pegawai' => 'required|exists:pegawais,id',
            'fk_telepon' => 'required|exists:konsumens,telepon',
            'fk_cabang' => 'required|exists:cabangs,id',
            'tanggal' => 'required|date',
            'subtotal' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $transaksi = Transaksi::create($input);
        $inputkerja['fk_transaksi'] = $transaksi->id;
        $inputkerja['fk_pegawai'] = $input['fk_pegawai'];
        
        $pegawaikerja = PegawaiKerja::create($inputkerja);
        
        $success['info'] = 'Transaksi sudah dibuat!';
        $success['data'] = $transaksi;
        $success['data-pegawai'] = $pegawaikerja;

        return response()->json(['success' => $success], 200);
    }

    //Untuk Kasir
    function Bayar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'diskon' => 'required|numeric|gte:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $transaksi = Transaksi::find($id);
        $transaksi->diskon = $input['diskon'];
		$kembalian = $transaksi->subtotal-$transaksi->diskon;
		$transaksi->total = $kembalian;
        if ($transaksi->save()) {			
            $success['info'] = 'Berhasil Membayar!';
            $success['data'] = $transaksi;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function SatuTransaksi(Request $request, $id)
    {
        $success['data'] = Transaksi::find($id);
        return response()->json($success, 200);
    }
    
    function SemuaPegawai(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        $success['data'] = $transaksi->pegawaikerja;
        return response()->json($success, 200);
    }
    function TotalSemua(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        $success['sparepart'] = sizeof($transaksi->detailsparepart);
        $success['servis'] = sizeof($transaksi->detailservis);
        return response()->json($success, 200);
    }

    function EditTransaksi(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_telepon' => 'exists:konsumens,telepon',
            'fk_cabang' => 'exists:cabangs,id',
            'fk_pegawai' => 'exists:pegawais,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $transaksi = Transaksi::find($id);

        $message = 'Mengedit ';
        if (is_null($transaksi)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        else if($transaksi->diskon > -1) {
            return response()->json(['errors' => 'Tidak bisa, sudah dibayar ..'], 401);
        }

        if ($request->exists('kode')) {
            $transaksi->kode = $input['kode'];
            $message = 'kode, ';
        }
        if ($request->exists('fk_telepon')) {
            $transaksi->fk_telepon = $input['fk_telepon'];
            $message .= 'fk_telepon, ';
        }
        if ($request->exists('fk_cabang')) {
            $transaksi->fk_cabang = $input['fk_cabang'];
            $message .= 'fk_cabang, ';
        }
        if ($request->exists('fk_pegawai')) {
            $pegawaikerja = $transaksi->pegawaikerja;
            $pegawaikerja->fk_pegawai = $input['fk_pegawai'];
            
            if (!$pegawaikerja->save()) {
                return response()->json('Gagal untuk edit montir ..', 401);
            }
            $message .= 'fk_pegawai, ';
        }
        
        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($transaksi->save()) {
            $success['info'] = $message;
            $success['data'] = $transaksi;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteTransaksi(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        if (is_null($transaksi)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($transaksi->delete()) {
            $success['data'] = $transaksi;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaTransaksi(Request $request)
    {
        $success['data'] = Transaksi::all();
        return response()->json($success, 200);
    }

    function SemuaBayar(Request $request)
    {
        $success['data'] = Transaksi::all()->where('diskon','=',-1);
        return response()->json($success, 200);
    }

    function SemuaDetailServis(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        $success['data'] = $transaksi->detailservis;
        return response()->json($success, 200);
    }

    function SemuaDetailSparepart(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        $success['data'] = $transaksi->detailsparepart;
        return response()->json($success, 200);
    }
}
