<?php

namespace App\Http\Controllers\Api;

use App\Model\JasaServis;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JasaServisController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga' => 'numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $JasaServis = JasaServis::create($input);
        $success['info'] = 'JasaServis sudah dibuat!';
        $success['data'] = $JasaServis;

        return response()->json(['success' => $success], 200);
    }

    function SatuJasaServis(Request $request, $id)
    {
        $success['data'] = JasaServis::find($id);
        return response()->json($success, 200);
    }

    function EditJasaServis(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'harga' => 'numeric|min:0'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $JasaServis = JasaServis::find($id);
        $message = 'Mengedit ';
        if(is_null($JasaServis)){
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('nama')) {
            $JasaServis->nama = $input['nama'];
            $message = 'Nama, ';
        }
        if ($request->exists('harga')) {
            $JasaServis->harga = $input['harga'];
            $message .= 'Harga ';
        }

        if(empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($JasaServis->save()) {
            $success['info'] = $message;
            $success['data'] = $JasaServis;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteJasaServis(Request $request, $id)
    {
        $JasaServis = JasaServis::find($id);
        if(is_null($JasaServis)){
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

         if($JasaServis->delete()){
            $success['data'] = $JasaServis;
            return response()->json($success, 200);
         }        

         return response()->json(['errors' => 'Gagal untuk hapus ..'], 401);
        }

    function SemuaJasaServis(Request $request)
    {
        $success['data'] = JasaServis::all();
        return response()->json($success, 200);
    }

    function read(Request $request)
    {
        $success = JasaServis::all();
        return response()->json($success, 200);
    }
}
