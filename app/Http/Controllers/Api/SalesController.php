<?php

namespace App\Http\Controllers\Api;

use App\Model\Sales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class SalesController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_supplier' => 'required|exists:suppliers,id',
            'nama' => 'required',
            'telepon' => 'required|max:14',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $Sales = Sales::create($input);
        $success['info'] = 'Sales sudah dibuat!';
        $success['data'] = $Sales;

        return response()->json(['success' => $success], 200);
    }

    function SatuSales(Request $request, $id)
    {
        $success['data'] = Sales::find($id);
        return response()->json($success, 200);
    }

    function EditSales(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_supplier' => 'exists:suppliers,id',
            'telepon' => 'max:14',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $Sales = Sales::find($id);
        $message = 'Mengedit ';
        if (is_null($Sales)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('fk_supplier')) {
            $Sales->fk_supplier = $input['fk_supplier'];
            $message = 'Jenis Supplier, ';
        }
        if ($request->exists('nama')) {
            $Sales->nama = $input['nama'];
            $message .= 'nama, ';
        }
        if ($request->exists('telepon')) {
            $Sales->telepon = $input['telepon'];
            $message .= 'Telepon Konsumen, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($Sales->save()) {
            $success['info'] = $message;
            $success['data'] = $Sales;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteSales(Request $request, $id)
    {
        $Sales = Sales::find($id);
        if (is_null($Sales)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($Sales->delete()) {
            $success['data'] = $Sales;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaSales(Request $request)
    {
        $success['data'] = Sales::all();
        return response()->json($success, 200);
    }
}
