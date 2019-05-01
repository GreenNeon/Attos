<?php

namespace App\Http\Controllers\Api;

use App\Model\DetailServis;
use App\Model\MontirKerja;

use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailServisController extends Controller
{
    function BuatBaru(Request $request)
    {
        // fk montir itu id pegawai bro!!
        $validator = Validator::make($request->all(), [
            'fk_jasa_servis' => 'required|exists:jasa_servis,id',
            'fk_transaksi' => 'required|exists:transaksis,id',
            'fk_kendaraan' => 'required|exists:kendaraans,id',
            'fk_montir' => 'required|exists:pegawais,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $inputmontir['fk_pegawai'] = $input['fk_montir'];
        $inputmontir['fk_kendaraan'] = $input['fk_kendaraan'];
        $montir = MontirKerja::create($inputmontir);
        $input['fk_montir'] = $montir->id;

        $detailservis = DetailServis::create($input);        
        $input['fk_montir'] = $montir->id;
        $harga = $detailservis->jasaservis->harga;
        $detailservis->total = $harga;
        $detailservis->save();

        $success['info'] = 'DetailServis dan MontirKerja sudah dibuat!';
        $success['data'] = $detailservis;
        $success['data-montir'] = $montir;

        return response()->json(['success' => $success], 200);
    }

    function SatuDetailServis(Request $request, $id)
    {
        $success['data'] = DetailServis::find($id);
        return response()->json($success, 200);
    }

    function SatuMontir(Request $request, $id)
    {
        $success['data'] = DetailServis::find($id)->montirkerja;
        return response()->json($success, 200);
    }

    function MajukanStatus(Request $request, $id)
    {
         $detail = DetailServis::find($id);
         if($detail->status < 3) {
            $detail->status += 1;
         } else {
            return response()->json(['errors' => 'Tidak bisa, status max ..'], 401);
         }
         $success['data'] = $detail;
        return response()->json($success, 200);
    }
    function MundurkanStatus(Request $request, $id)
    {
         $detail = DetailServis::find($id);
         if($detail->status > 0) {
            $detail->status -= 1;
        } else {
            return response()->json(['errors' => 'Tidak bisa, status minimal ..'], 401);
        }
         $success['data'] = $detail;
        return response()->json($success, 200);
    }

    function EditDetailServis(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fk_jasa_servis' => 'exists:jasaservis,id',
            'fk_transaksi' => 'exists:transaksis,id',
            'fk_kendaraan' => 'exists:kendaraans,id',
            'fk_montir' => 'exists:pegawais,id',
            'jumlah' => 'numeric',
            'total' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $detailservis = DetailServis::find($id);
        $message = 'Mengedit ';
        if (is_null($detailservis)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        } else if($detailservis->status == 2) {
            return response()->json(['errors' => 'Tidak bisa, sudah dikerjakan ..'], 401);
        }

        if ($request->exists('fk_jasa_servis')) {
            $detailservis->fk_jasa_servis = $input['fk_jasa_servis'];
            $message = 'fk_jasa_servis, ';
        }
        if ($request->exists('fk_transaksi')) {
            $detailservis->fk_transaksi = $input['fk_transaksi'];
            $message .= 'fk_transaksi, ';
        }
        if ($request->exists('fk_kendaraan')) {
            $montir = $detailservis->montirkerja;
            $montir->fk_kendaraan = $input['fk_kendaraan'];
            
            if (!$montir->save()) {
                return response()->json('Gagal untuk edit montir ..', 401);
            }
            $message .= 'fk_kendaraan, ';
        }
        if ($request->exists('fk_montir')) {
            $montir = $detailservis->montirkerja;
            $montir->fk_pegawai = $input['fk_montir'];
            
            if (!$montir->save()) {
                return response()->json('Gagal untuk edit montir ..', 401);
            }
            $message .= 'fk_montir, ';
        }
        if ($request->exists('jumlah')) {
            $detailservis->jumlah = $input['jumlah'];
            $message = 'jumlah, ';
        }
        if ($request->exists('total')) {
            $detailservis->total = $input['total'];
            $message = 'total, ';
        }

        if (empty($input)) {
            $message = "Tidak ada data yang diedit ..";
        }
        if ($detailservis->save()) {
            $success['info'] = $message;
            $success['data'] = $detailservis;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk edit ..', 401);
    }

    function DeleteDetailServis(Request $request, $id)
    {
        $detailservis = DetailServis::find($id);
        if (is_null($detailservis)) {
            return response()->json(['errors' => 'Tidak ditemukan ..'], 401);
        }
        if ($detailservis->delete()) {
            $success['data'] = $detailservis;
            return response()->json($success, 200);
        }

        return response()->json('Gagal untuk hapus ..', 401);
    }

    function SemuaDetailServis(Request $request)
    {
        $success['data'] = DetailServis::all();
        return response()->json($success, 200);
    }
}
