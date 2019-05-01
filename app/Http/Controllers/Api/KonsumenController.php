<?php

namespace App\Http\Controllers\Api;

use App\Model\Konsumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class KonsumenController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required|unique:konsumens|max:14',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $konsumen = Konsumen::create($input);
        $success['info'] = 'Konsumen sudah dibuat!';
        $success['data'] = $konsumen;

        return response()->json(['success' => $success], 200);
    }

    function SatuKonsumen(Request $request, $id)
    {
        $success['data'] = Konsumen::find($id);
        return response()->json($success, 200);
    }

    function EditKonsumen(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'telepon' => 'unique:konsumens|max:14',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $konsumen = Konsumen::find($id);
        $message = 'Mengedit ';
        if(is_null($konsumen)){
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('nama')) {
            $konsumen->nama = $input['nama'];
            $message = 'Nama, ';
        }
        if ($request->exists('alamat')) {
            $konsumen->alamat = $input['alamat'];
            $message .= 'Alamat, ';
        }
        if ($request->exists('telepon')) {
            $konsumen->telepon = $input['telepon'];
            $message .= 'Telepon, ';
        }

        if(empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($konsumen->save()) {
            $success['info'] = $message;
            $success['data'] = $konsumen;
            return response()->json($success, 200);
        }

        return response()->json(['errors' => 'Gagal untuk edit ..'], 401);
    }

    function DeleteKonsumen(Request $request, $id)
    {
        $konsumen = Konsumen::find($id);
        if(is_null($konsumen)){
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
            
        if($konsumen->delete()){
            $success['data'] = $konsumen;
            return response()->json($success, 200);
         }        

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaKonsumen(Request $request)
    {
        $success['data'] = Konsumen::all();
        return response()->json($success, 200);
    }
}
