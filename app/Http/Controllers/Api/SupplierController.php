<?php

namespace App\Http\Controllers\Api;

use App\Model\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;


class SupplierController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $Supplier = Supplier::create($input);
        $success['info'] = 'Supplier sudah dibuat!';
        $success['data'] = $Supplier;

        return response()->json(['success' => $success], 200);
    }

    function SatuSupplier(Request $request, $id)
    {
        $success['data'] = Supplier::find($id);
        return response()->json($success, 200);
    }

    function EditSupplier(Request $request, $id)
    {
        $input = $request->all();
        $Supplier = Supplier::find($id);
        $message = 'Mengedit ';
        if (is_null($Supplier)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('nama')) {
            $Supplier->nama = $input['nama'];
            $message .= 'nama, ';
        }
        if ($request->exists('alamat')) {
            $Supplier->alamat = $input['alamat'];
            $message .= 'Alamat Konsumen, ';
        }
        if ($request->exists('telepon')) {
            $Supplier->telepon = $input['telepon'];
            $message .= 'telepon Konsumen, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($Supplier->save()) {
            $success['info'] = $message;
            $success['data'] = $Supplier;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteSupplier(Request $request, $id)
    {
        $Supplier = Supplier::find($id);
        if (is_null($Supplier)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($Supplier->delete()) {
            $success['data'] = $Supplier;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaSupplier(Request $request)
    {
        $success['data'] = Supplier::all();
        return response()->json($success, 200);
    }
}
