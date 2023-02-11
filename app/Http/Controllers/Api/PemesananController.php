<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index(Request $request){
        $id_user  = $request->id_user;
        $data = DB::table("pemesanan")
        ->select("*", "pemesanan.id as id", DB::raw("date_format(pemesanan.created_at, '%d/%m/%Y %H:%i:%s') as tanggal"))
        ->join("tiket", "tiket.id", "=", "pemesanan.id_tiket")
        ->where("id_user", $id_user)->get();
        return $data;
    }

    public function save(Request $request)
    {
        $id_user = $request['id_user'];
        $id_tiket = $request['id_tiket'];
        $qrcode = $request['qrcode'];

        $namafile = "default.png";
        if ($qrcode) {
            $extention = $qrcode->getClientOriginalExtension();
            $tujuan_upload = 'img/qrcode/';
            $namafile = '' . date('Ymdhis') . '.' . $extention;
            $qrcode->move($tujuan_upload, $namafile);
        }

        $pemesanan = new Pemesanan();
        $pemesanan->id_user = $id_user;
        $pemesanan->id_tiket = $id_tiket;
        $pemesanan->qr_code = $namafile; 
        $pemesanan->save();

        return response()->json(['status' => "success", 'message' => 'Berhasil Upload', 'data' => $pemesanan->id]);
    }


    public function uploadbukti(Request $request)
    {
        $photo = $request['photo'];
        $id = $request->id;
        $namafile = "";
        if ($photo) {
            $extention = $photo->getClientOriginalExtension();
            $tujuan_upload = 'img/bukti/';
            $namafile =  $id . date('Ymdhis') . '.' . $extention;
            $photo->move($tujuan_upload, $namafile);
            $data = Pemesanan::find($id);
            $data->bukti = $namafile;
            $data->save();
        }
        return response()->json(['status' => "success", 'message' => 'Berhasil Upload', 'data' => $namafile]);
    }

}
