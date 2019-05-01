<?php

namespace App\Http\Controllers\Api;

use App\Model\Kendaraan;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KendaraanController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_plat' => 'required',
            'fk_jenis' => 'required|exists:jenis_motors,id',
            'fk_telepon' => 'required|exists:konsumens,telepon|max:14',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $Kendaraan = Kendaraan::create($input);
        $success['info'] = 'Kendaraan sudah dibuat!';
        $success['data'] = $Kendaraan;

        return response()->json(['success' => $success], 200);
    }

    function SatuKendaraan(Request $request, $id)
    {
        $success['data'] = Kendaraan::find($id);
        return response()->json($success, 200);
    }

    function EditKendaraan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_jenis' => 'exists:jenis_motors,id',
            'fk_telepon' => 'exists:konsumens,telepon|max:14',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $Kendaraan = Kendaraan::find($id);
        $message = 'Mengedit ';
        if (is_null($Kendaraan)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('fk_jenis')) {
            $Kendaraan->fk_jenis = $input['fk_jenis'];
            $message = 'Jenis Motor, ';
        }
        if ($request->exists('noplat')) {
            $Kendaraan->alamat = $input['noplat'];
            $message .= 'noplat, ';
        }
        if ($request->exists('fk_telepon')) {
            $Kendaraan->fk_telepon = $input['fk_telepon'];
            $message .= 'Telepon Konsumen, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($Kendaraan->save()) {
            $success['info'] = $message;
            $success['data'] = $Kendaraan;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteKendaraan(Request $request, $id)
    {
        $Kendaraan = Kendaraan::find($id);
        if (is_null($Kendaraan)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($Kendaraan->delete()) {
            $success['data'] = $Kendaraan;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaKendaraan(Request $request)
    {
        $success['data'] = Kendaraan::all();
        return response()->json($success, 200);
    }
}
