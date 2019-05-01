<?php

namespace App\Http\Controllers\Api;

use App\Model\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class PegawaiController extends Controller
{
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required|unique:pegawais|max:14',
            'gaji' => 'required|min:0|numeric',
            'username' => 'required|same:telepon',
            'password' => 'required',
            'role' => 'required',
            'fk_cabang' => 'required|exists:cabangs,id',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Pegawai::create($input);
        $success['info'] = 'Pegawai sudah dibuat!';
        $success['data'] = $user;
        $success['token'] =  $user->createToken('atosapi')->accessToken;

        return response()->json(['success' => $success], 200);
    }

    function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = Auth::user();

            $success['data'] = $user;
            $success['token'] =  $user->createToken('atosapi')->accessToken;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error' => 'Gagal untuk masuk ..'], 401);
        }
    }

    function InfoSaya(Request $request)
    {
        $user = Auth::user();
        $success['data'] = $user;
        return response()->json($success, 200);
    }

    function SatuPegawai(Request $request, $id)
    {
        $success['data'] = Pegawai::find($id);
        return response()->json($success, 200);
    }

    function EditPegawai(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'telepon' => 'unique:pegawais|max:14',
            'gaji' => 'min:0',
            'username' => 'same:telepon',
            'fk_cabang' => 'exists:cabangs,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $user = Pegawai::find($id);
        $message = 'Mengedit ';
        if (is_null($user)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('nama')) {
            $user->nama = $input['nama'];
            $message = 'Nama, ';
        }
        if ($request->exists('alamat')) {
            $user->alamat = $input['alamat'];
            $message .= 'Alamat, ';
        }
        if ($request->exists('telepon')) {
            $user->telepon = $input['telepon'];
            $message .= 'Telepon, ';
        }
        if ($request->exists('gaji')) {
            $user->gaji = $input['gaji'];
            $message .= 'Gaji, ';
        }
        if ($request->exists('password')) {
            $input['password'] = bcrypt($input['password']);
            $user->password = $input['password'];
            $message .= 'Password, ';
        }
        if ($request->exists('role')) {
            $user->role = $input['role'];
            $message .= 'Role, ';
        }
        if ($request->exists('fk_cabang')) {
            $user->fk_cabang = $input['fk_cabang'];
            $message .= 'Cabang, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($user->save()) {
            $success['info'] = $message;
            $success['data'] = $user;
            return response()->json($success, 200);
        }

        return response()->json(['errors' => 'Gagal untuk edit ..'], 401);
    }

    function DeletePegawai(Request $request, $id)
    {
        $user = Pegawai::find($id);
        if (is_null($user)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($user->delete()) {
            $success['data'] = $user;
            return response()->json($success, 200);
        }

        return response()->json(['errors' => 'Gagal untuk hapus ..'], 401);
    }

    function SemuaPegawai(Request $request)
    {
        $success['data'] = Pegawai::all();
        return response()->json($success, 200);
    }

    function Unauthorized()
    {
        return response()->json(['error' => 'Gunakan token untuk masuk dan mengambil data ..'], 401);
    }

    function loginmobile(Request $request)
    {        
        if (Auth::attempt(['username' => request('pegawai'), 'password' => request('sandi')])) {
            $user = Auth::user();

            $success = $user;
            $success['token'] =  $user->createToken('atosapi')->accessToken;
            return response()->json($success, 200);
        } else {
           return self::rfail();
        }
    }
    
    function read(Request $request)
    {
        $success = Pegawai::all();
        return response()->json($success, 200);
    }
}
