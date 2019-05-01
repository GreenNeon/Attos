<?php

namespace App\Http\Controllers\Api;

use App\Model\Cabang;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CabangController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required|unique:cabangs|max:14',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $cabang = Cabang::create($input);
        $success['info'] = 'Cabang sudah dibuat!';
        $success['data'] = $cabang;

        return response()->json(['success' => $success], 200);
    }

    function SatuCabang(Request $request, $id)
    {
        $success['data'] = Cabang::find($id);
        return response()->json($success, 200);
    }

    function EditCabang(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'telepon' => 'unique:cabangs|max:14',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $cabang = Cabang::find($id);
        $message = 'Mengedit ';
        if (is_null($cabang)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('nama')) {
            $cabang->nama = $input['nama'];
            $message = 'Nama, ';
        }
        if ($request->exists('alamat')) {
            $cabang->alamat = $input['alamat'];
            $message .= 'Alamat, ';
        }
        if ($request->exists('telepon')) {
            $cabang->telepon = $input['telepon'];
            $message .= 'Telepon, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($cabang->save()) {
            $success['info'] = $message;
            $success['data'] = $cabang;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteCabang(Request $request, $id)
    {
        $cabang = Cabang::find($id);
        if (is_null($cabang)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($cabang->delete()) {
            $success['data'] = $cabang;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaCabang(Request $request)
    {
        $success['data'] = Cabang::all();
        return response()->json($success, 200);
    }

    private function rok(){
        $success['message'] = 'success';
        $success['value'] = '1';
        return response()->json($success, 200);
    }

    private function rfail(){
        $success['message'] = 'error';
        $success['value'] = '1';
        return response()->json($success, 200);
    }

    function create(Request $request)
    {        
        $input = $request->all();
        $data['nama'] = $input['NamaCabang'];
        $data['telepon'] = $input['No_TelpCabang'];
        $data['alamat'] = $input['AlamatCabang'];

        $cabang = Cabang::create($data);
        if ($cabang) {
           return self::rok();
        }
        return self::rfail();
    }    

    function update(Request $request)
    {
        $input = $request->all();
        $cabang = Cabang::find($input['IDCabang']);        

        if (is_null($cabang)) {            
            return self::rfail();
        }

        if ($request->exists('NamaCabang')) {
            $cabang->nama = $input['NamaCabang'];
        }
        if ($request->exists('AlamatCabang')) {
            $cabang->alamat = $input['AlamatCabang'];
        }
        if ($request->exists('No_TelpCabang')) {
            $cabang->telepon = $input['No_TelpCabang'];
        }

        if ($cabang->save()) {
            return self::rok();
        }
        return self::rfail();
    }

    function delete(Request $request)
    {
        $input = $request->all();
        $cabang = Cabang::find($input['IDCabang']);
        
        if (is_null($cabang)) {            
            return self::rfail();
        }
        if ($cabang->delete()) {
            return self::rok();
        }
        return self::rfail();
    }

    function read(Request $request)
    {
        $success = Cabang::all();
        return response()->json($success, 200);
    }
}
