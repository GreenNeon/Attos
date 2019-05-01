<?php

namespace App\Http\Controllers\Api;

use App\Model\Pemesanan;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PemesananController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_supplier' => 'required|exists:suppliers,id',
            'tanggal' => 'required|date',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $pemesanan = Pemesanan::create($input);
        $success['info'] = 'Pemesanan sudah dibuat!';
        $success['data'] = $pemesanan;

        return response()->json(['success' => $success], 200);
    }

    function SatuPemesanan(Request $request, $id)
    {
        $success['data'] = Pemesanan::find($id);
        return response()->json($success, 200);
    }

    function EditPemesanan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_supplier' => 'exists:suppliers,id',
            'tanggal' => 'date',
            'total' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $pemesanan = Pemesanan::find($id);
        $message = 'Mengedit ';
        if (is_null($pemesanan)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('fk_supplier')) {
            $pemesanan->fk_supplier = $input['fk_supplier'];
            $message = 'fk_supplier, ';
        }
        if ($request->exists('tanggal')) {
            $pemesanan->tanggal = $input['tanggal'];
            $message .= 'tanggal, ';
        }
        if ($request->exists('total')) {
            $pemesanan->total = $input['total'];
            $message .= 'total, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($pemesanan->save()) {
            $success['info'] = $message;
            $success['data'] = $pemesanan;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeletePemesanan(Request $request, $id)
    {
        $pemesanan = Pemesanan::find($id);
        if (is_null($pemesanan)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($pemesanan->delete()) {
            $success['data'] = $pemesanan;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaPemesanan(Request $request)
    {
        $success['data'] = Pemesanan::all();
        return response()->json($success, 200);
    }
}
