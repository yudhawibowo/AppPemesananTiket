<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index(Request $request){
        $id_user  = $request->id_user;
        $data = DB::table("pemesanan")
        ->select("*", "pemesanan.id as id", DB::raw("date_format(pemesanan.created_at, '%d/%m/%Y %H:%i:%s') as tanggal"))
        ->where("id_user", $id_user)->get();
        return $data;
    }

    public function orderdetail(Request $request){
        $id  = $request->id;
        $data = DB::table("pemesanan_detail")
        ->select("*", "pemesanan_detail.id as id")
        ->join("tiket", "tiket.id", "=", "pemesanan_detail.id_tiket")
        ->where("id_pemesanan", $id)->get();
        return $data;
    }

    public function save(Request $request)
    {
        $id_user = $request['id_user'];
        $total_qty = $request['qty'];
        $total_harga = $request['total'];
        $metode_bayar = $request['metode_bayar'];
        $qrcode = $request['qrcode'];
        $dataTiket = json_decode($request['dataTiket'], false);

        $namafile = "default.png";
        if ($qrcode) {
            $extention = $qrcode->getClientOriginalExtension();
            $tujuan_upload = 'img/qrcode/';
            $namafile = '' . date('Ymdhis') . '.' . $extention;
            $qrcode->move($tujuan_upload, $namafile);
        }

        $pemesanan = new Pemesanan();
        $pemesanan->id_user = $id_user;
        $pemesanan->qr_code = $namafile; 
        $pemesanan->total_qty = $total_qty;
        $pemesanan->total_harga = $total_harga;
        $pemesanan->metode_bayar = $metode_bayar;
        $pemesanan->save();

        for($i=0;$i<count($dataTiket);$i++){
            $tiket = $dataTiket[$i];
            $detail = new PemesananDetail();
            $detail->id_pemesanan = $pemesanan->id;
            $detail->id_tiket = $tiket->idTiket;
            $detail->qty = $tiket->qty;
            $detail->save();
        }

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
