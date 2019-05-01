<?php

namespace App\Http\Controllers\Api;

use App\Model\DetailSparepart;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailSparepartController extends Controller
{
    //['fk_transaksi','fk_sparepart','jumlah','total'];
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_transaksi' => 'required|exists:transaksis,id',
            'fk_sparepart' => 'required|exists:spareparts,id',
            'jumlah' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $detailsparepart = DetailSparepart::create($input);
        $sparepart = $detailsparepart->sparepart;
		$sparepart->stok -= $detailsparepart->jumlah;
        $detailsparepart->total = $detailsparepart->jumlah * $sparepart->harga;
        $detailsparepart->save();
        $success['info'] = 'DetailSparepart sudah dibuat!';
        $success['data'] = $detailsparepart;

        return response()->json(['success' => $success], 200);
    }

    function SatuDetailSparepart(Request $request, $id)
    {
        $success['data'] = DetailSparepart::find($id);
        return response()->json($success, 200);
    }

    function EditDetailSparepart(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_transaksi' => 'exists:transaksis,id',
            'fk_sparepart' => 'exists:spareparts,id',
            'fk_montir' => 'exists:montir_kerjas,id',
            'jumlah' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $detailsparepart = DetailSparepart::find($id);
        $message = 'Mengedit ';
        if (is_null($detailsparepart)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('fk_transaksi')) {
            $detailsparepart->fk_transaksi = $input['fk_transaksi'];
            $message = 'fk_transaksi, ';
        }
        if ($request->exists('fk_sparepart')) {
            $detailsparepart->fk_sparepart = $input['fk_sparepart'];
            $message .= 'fk_sparepart, ';
        }
        if ($request->exists('fk_montir')) {
            $detailsparepart->fk_montir = $input['fk_montir'];
            $message .= 'fk_montir, ';
        }
        if ($request->exists('jumlah')) {
            $detailsparepart->jumlah = $input['jumlah'];
            $message .= 'jumlah, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($detailsparepart->save()) {
            $success['info'] = $message;
            $success['data'] = $detailsparepart;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteDetailSparepart(Request $request, $id)
    {
        $detailsparepart = DetailSparepart::find($id);
        if (is_null($detailsparepart)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($detailsparepart->delete()) {
            $success['data'] = $detailsparepart;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaDetailSparepart(Request $request)
    {
        $success['data'] = DetailSparepart::all();
        return response()->json($success, 200);
    }
}
