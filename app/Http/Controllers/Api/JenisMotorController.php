<?php

namespace App\Http\Controllers\Api;

use App\Model\JenisMotor;
use App\Model\SparepartTipeMotor;
use Illuminate\Support\Facades\DB;

use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisMotorController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipe' => 'required',
            'merk' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $jenismotor = JenisMotor::create($input);
        $success['info'] = 'JenisMotor sudah dibuat!';
        $success['data'] = $jenismotor;

        return response()->json(['success' => $success], 200);
    }

    function DariSparepart(Request $request, $idSparepart)
    {
        $data = DB::table('sparepart_tipe_motors')->join('jenis_motors', 'sparepart_tipe_motors.fk_jenis_motor', '=', 'jenis_motors.id')->select('sparepart_tipe_motors.*', 'jenis_motors.tipe')->where('fk_sparepart', $idSparepart)->get();
        if(is_null($data)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        $success['data'] = $data;
        return response()->json($success, 200);
    }

    function SatuJenisMotor(Request $request, $id)
    {
        $success['data'] = JenisMotor::find($id);
        return response()->json($success, 200);
    }

    function EditJenisMotor(Request $request, $id)
    {
        $input = $request->all();
        $jenismotor = JenisMotor::find($id);
        $message = 'Mengedit ';
        if (is_null($jenismotor)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('tipe')) {
            $jenismotor->tipe = $input['tipe'];
            $message = 'Tipe, ';
        }
        if ($request->exists('merk')) {
            $jenismotor->merk = $input['merk'];
            $message .= 'Merk ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($jenismotor->save()) {
            $success['info'] = $message;
            $success['data'] = $jenismotor;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteJenisMotor(Request $request, $id)
    {
        $jenismotor = JenisMotor::find($id);
        if (is_null($jenismotor)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        
        if ($jenismotor->delete()) {
            $success['data'] = $jenismotor;
            return response()->json($success, 200);
        }

        return response()->json(['errors' => 'Gagal untuk hapus ..'], 401);
    }

    function SemuaJenisMotor(Request $request)
    {
        $success['data'] = JenisMotor::all();
        return response()->json($success, 200);
    }
}
