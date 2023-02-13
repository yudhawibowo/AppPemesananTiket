<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $pemesanan = "active";
            return view('dataPemesanan', compact('pemesanan'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function laporan()
    {
        if (Auth::check()) {
            $laporan = "active";
            return view('dataLaporan', compact('laporan'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }


    public function datapemesanan()
    {
        if (Auth::check()) {
            $data = Pemesanan::with(["user"])->where("status", 0)->get();
            return $data;
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function datalaporan()
    {
        if (Auth::check()) {
            $data = Pemesanan::with(["user"])->select("*", DB::raw("date_format(created_at, '%d/%m/%Y %H:%i:%s') as tanggal_pemesanan"), DB::raw("date_format(updated_at, '%d/%m/%Y %H:%i:%s') as tanggal_konfirmasi"))->where("status", 1)->get();
            return $data;
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function konfirmasi(Request $request)
    {
        $id = $request['id'];
        $pemesanan = Pemesanan::find($id);
        $pemesanan->status = 1;
        $pemesanan->save();

        return response()->json(['success' => "Berhasil Submit"]);
    }

    public function deletepemesanan(Request $request)
    {
        $id = $request['id'];
        $tiket = Pemesanan::find($id);
        $tiket->delete();
        return response()->json(['success' => "Berhasil Delete"]);
    }

}
