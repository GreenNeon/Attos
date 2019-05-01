<?php

namespace App\Http\Controllers\Api;

use App\Model\HistoriMasuk;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoriMasukController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_pemesanan' => 'required|exists:pemesanans,id',
            'fk_sparepart' => 'required|exists:spareparts,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'total' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $historiMasuk = HistoriMasuk::create($input);
        $historiMasuk->total = $historiMasuk->sparepart->harga*$historiMasuk->jumlah;
        $historiMasuk->save();

        $success['info'] = 'HistoriMasuk sudah dibuat!';
        $success['data'] = $historiMasuk;

        return response()->json(['success' => $success], 200);
    }

    function SatuHistoriMasuk(Request $request, $id)
    {
        $success['data'] = HistoriMasuk::find($id);
        return response()->json($success, 200);
    }

    function EditHistoriMasuk(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_pemesanan' => 'exists:pemesanans,id',
            'fk_sparepart' => 'exists:spareparts,id',
            'tanggal' => 'date',
            'jumlah' => 'numeric',
            'total' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $historiMasuk = HistoriMasuk::find($id);
        $message = 'Mengedit ';
        if (is_null($historiMasuk)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('fk_pemesanan')) {
            $historiMasuk->fk_pemesanan = $input['fk_pemesanan'];
            $message = 'fk_pemesanan, ';
        }
        if ($request->exists('fk_sparepart')) {
            $historiMasuk->fk_sparepart = $input['fk_sparepart'];
            $message .= 'fk_sparepart, ';
        }
        if ($request->exists('tanggal')) {
            $historiMasuk->tanggal = $input['tanggal'];
            $message .= 'tanggal, ';
        }
        if ($request->exists('jumlah')) {
            $historiMasuk->jumlah = $input['jumlah'];
            $message .= 'jumlah, ';
        }
        if ($request->exists('total')) {
            $historiMasuk->total = $input['total'];
            $message .= 'total, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($historiMasuk->save()) {
            $success['info'] = $message;
            $success['data'] = $historiMasuk;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteHistoriMasuk(Request $request, $id)
    {
        $historiMasuk = HistoriMasuk::find($id);
        if (is_null($historiMasuk)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($historiMasuk->delete()) {
            $success['data'] = $historiMasuk;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaHistoriMasuk(Request $request)
    {
        $success['data'] = HistoriMasuk::all();
        return response()->json($success, 200);
    }
}
