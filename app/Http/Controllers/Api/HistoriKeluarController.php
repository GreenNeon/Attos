<?php

namespace App\Http\Controllers\Api;

use App\Model\HistoriKeluar;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoriKeluarController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_detail_sparepart' => 'required|exists:detail_spareparts,id',
            'fk_sparepart' => 'required|exists:spareparts,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric',
            'total' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $historiKeluar = HistoriKeluar::create($input);
        $historiKeluar->total = $historiKeluar->sparepart->harga*$historiKeluar->jumlah;
        $historiKeluar->save();

        $success['info'] = 'HistoriKeluar sudah dibuat!';
        $success['data'] = $historiKeluar;

        return response()->json(['success' => $success], 200);
    }

    function SatuHistoriKeluar(Request $request, $id)
    {
        $success['data'] = HistoriKeluar::find($id);
        return response()->json($success, 200);
    }

    function EditHistoriKeluar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_detail_sparepart' => 'exists:detail_spareparts,id',
            'fk_sparepart' => 'exists:spareparts,id',
            'tanggal' => 'date',
            'jumlah' => 'numeric',
            'total' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $historiKeluar = HistoriKeluar::find($id);
        $message = 'Mengedit ';
        if (is_null($historiKeluar)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('fk_detail_sparepart')) {
            $historiKeluar->fk_detail_sparepart = $input['fk_detail_sparepart'];
            $message = 'fk_detail_sparepart, ';
        }
        if ($request->exists('fk_sparepart')) {
            $historiKeluar->fk_sparepart = $input['fk_sparepart'];
            $message .= 'fk_sparepart, ';
        }
        if ($request->exists('tanggal')) {
            $historiKeluar->tanggal = $input['tanggal'];
            $message .= 'tanggal, ';
        }
        if ($request->exists('jumlah')) {
            $historiKeluar->jumlah = $input['jumlah'];
            $message .= 'jumlah, ';
        }
        if ($request->exists('total')) {
            $historiKeluar->total = $input['total'];
            $message .= 'total, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($historiKeluar->save()) {
            $success['info'] = $message;
            $success['data'] = $historiKeluar;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteHistoriKeluar(Request $request, $id)
    {
        $historiKeluar = HistoriKeluar::find($id);
        if (is_null($historiKeluar)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($historiKeluar->delete()) {
            $success['data'] = $historiKeluar;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaHistoriKeluar(Request $request)
    {
        $success['data'] = HistoriKeluar::all();
        return response()->json($success, 200);
    }
}
