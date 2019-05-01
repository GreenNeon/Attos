<?php

namespace App\Http\Controllers\Api;

use App\Model\DetailDetailPemesanan;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailDetailPemesananController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_pemesanan' => 'required|exists:pemesanans,id',
            'fk_sparepart' => 'required|exists:spareparts,id',
            'jumlah' => 'required|date',
            'total' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $detail = DetailPemesanan::create($input);
        $detail->nama = $detail->sparepart->nama;
        $detail->save();
        $success['info'] = 'DetailPemesanan sudah dibuat!';
        $success['data'] = $detail;

        return response()->json(['success' => $success], 200);
    }

    function SatuDetailPemesanan(Request $request, $id)
    {
        $success['data'] = DetailPemesanan::find($id);
        return response()->json($success, 200);
    }

    function EditDetailPemesanan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_pemesanan' => 'exists:pemesanans,id',
            'fk_sparepart' => 'exists:spareparts,id',
            'jumlah' => 'date',
            'total' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $detail = DetailPemesanan::find($id);
        $message = 'Mengedit ';
        if (is_null($detail)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('fk_pemesanan')) {
            $detail->fk_pemesanan = $input['fk_pemesanan'];
            $message = 'fk_pemesanan, ';
        }
        if ($request->exists('fk_sparepart')) {
            $detail->fk_sparepart = $input['fk_sparepart'];
            $message .= 'fk_sparepart, ';
        }
        if ($request->exists('jumlah')) {
            $detail->jumlah = $input['jumlah'];
            $message .= 'jumlah, ';
        }
        if ($request->exists('total')) {
            $detail->total = $input['total'];
            $message .= 'total, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($detail->save()) {
            $success['info'] = $message;
            $success['data'] = $detail;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteDetailPemesanan(Request $request, $id)
    {
        $detail = DetailPemesanan::find($id);
        if (is_null($detail)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($detail->delete()) {
            $success['data'] = $detail;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaDetailPemesanan(Request $request)
    {
        $success['data'] = DetailPemesanan::all();
        return response()->json($success, 200);
    }
}
