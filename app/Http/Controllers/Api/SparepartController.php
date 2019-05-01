<?php

namespace App\Http\Controllers\Api;

use App\Model\Sparepart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;


class SparepartController extends Controller
{
    // 'nama','tipe','kode_penempatan','stok','stok_optimal','harga','gambar_url'
    function BuatBaru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'tipe' => 'required',
            'kode_penempatan' => 'required',
            'stok' => 'required|numeric',
            'stok_optimal' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_url' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $Sparepart = Sparepart::create($input);
        $gambar = $request->file('gambar_url')->store(
            'sparepart', 'public'
        );
        $gmb_split = explode('/' ,$gambar);
        $Sparepart['gambar_url'] = $gmb_split[1];
		$Sparepart->save();
        $success['info'] = 'Sparepart sudah dibuat!';
        $success['data'] = $Sparepart;

        return response()->json(['success' => $success], 200);
    }

    function SatuSparepart(Request $request, $id)
    {
        $success['data'] = Sparepart::find($id);
        return response()->json($success, 200);
    }

    function EditSparepart(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_jenis' => 'exists:jenis_motors,id',
            'fk_telepon' => 'exists:konsumens,telepon|max:14',
            'stok' => 'numeric',
            'stok_optimal' => 'numeric',
            'harga' => 'numeric',
            'gambar_url' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $Sparepart = Sparepart::find($id);
        $message = 'Mengedit ';
        if (is_null($Sparepart)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }

        if ($request->exists('nama')) {
            $Sparepart->nama = $input['nama'];
            $message = 'nama, ';
        }
        if ($request->exists('tipe')) {
            $Sparepart->tipe = $input['tipe'];
            $message .= 'tipe, ';
        }
        if ($request->exists('kode_penempatan')) {
            $Sparepart->kode_penempatan = $input['kode_penempatan'];
            $message .= 'kode_penempatan, ';
        }
        if ($request->exists('stok')) {
            $Sparepart->stok = $input['stok'];
            $message .= 'stok, ';
        }
        if ($request->exists('stok_optimal')) {
            $Sparepart->stok_optimal = $input['stok_optimal'];
            $message .= 'stok_optimal, ';
        }
        if ($request->exists('harga')) {
            $Sparepart->harga = $input['harga'];
            $message .= 'harga, ';
        }
        if ($request->exists('gambar_url')) {
            $gambar = $request->file('gambar_url')->store(
                'sparepart', 'public'
            );

            $deleted = Storage::disk('public')->delete($Sparepart->gambar_url);
            $nondel = $Sparepart->gambar_url;
            $Sparepart->gambar_url = $gambar;
            $message .= 'gambar_url, ';
            
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($Sparepart->save()) {
            $success['info'] = $message;
            $success['data'] = $Sparepart;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteSparepart(Request $request, $id)
    {
        $Sparepart = Sparepart::find($id);
        if (is_null($Sparepart)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($Sparepart->delete()) {
            Storage::disk('public')->delete($Sparepart->gambar_url);
            $success['data'] = $Sparepart;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaSparepart(Request $request)
    {
        $success['data'] = Sparepart::all();
        return response()->json($success, 200);
    }

    function create(Request $request)
    {                
        $input = $request->all();
        $data['nama'] = $input['NamaS'];
        $data['tipe'] = $input['TipeS'];
        $data['kode_penempatan'] = $input['KodeS'];
        $data['stok'] = $input['StokS'];
        $data['stok_optimal'] = $input['StokOS'];
        $data['merk'] = $input['MerkS'];
        $data['harga'] = $input['HargaS'];
        $data['gambar_url'] = $input['GambarS'];
        //$id = $_POST['IDS'];

        $sparepart = Sparepart::create($data);
        if ($sparepart) {
           return self::rok();
        }
        return self::rfail();
    }    

    function update(Request $request)
    {
        $input = $request->all();
        $sparepart = Sparepart::find($input['IDS']);        

        if (is_null($sparepart)) {            
            return self::rfail();
        }

        if ($request->exists('NamaS')) {
            $sparepart->nama = $input['NamaS'];
        }
        if ($request->exists('TipeS')) {
            $sparepart->tipe = $input['TipeS'];
        }
        if ($request->exists('KodeS')) {
            $sparepart->kode_penempatan = $input['KodeS'];
        }
        if ($request->exists('StokS')) {
            $sparepart->stok = $input['StokS'];
        }
        if ($request->exists('StokOS')) {
            $sparepart->stok_optimal = $input['StokOS'];
        }
        if ($request->exists('HargaS')) {
            $sparepart->harga = $input['HargaS'];
        }
        if ($request->exists('MerkS')) {
            $sparepart->merk = $input['MerkS'];
        }
        if ($request->exists('GambarS')) {
            $gambar = $request->file('GambarS')->store(
                'sparepart', 'public'
            );

            $deleted = Storage::disk('public')->delete($sparepart->gambar_url);
            $nondel = $sparepart->gambar_url;
            $sparepart->gambar_url = $gambar;            
        }

        if ($sparepart->save()) {
            return self::rok();
        }
        return self::rfail();
    }

    function delete(Request $request)
    {
        $input = $request->all();
        $sparepart = Sparepart::find($input['IDS']);
        
        if (is_null($sparepart)) {            
            return self::rfail();
        }
        if ($sparepart->delete()) {
            return self::rok();
        }
        return self::rfail();
    }

    function read(Request $request)
    {
        $success = Sparepart::all();
        return response()->json($success, 200);
    }
}
