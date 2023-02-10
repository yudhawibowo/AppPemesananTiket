<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KendaraanController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $kendaraan = "active";
            return view('dataKendaraan', compact('kendaraan'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function datakendaraan()
    {
        if (Auth::check()) {
            $data = Kendaraan::all();
            return $data;
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function addKendaraan(Request $request)
    {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }

        $nama = $request['nama'];
        $jenis = $request['jenis'];
        $nomor = $request['nomor'];

        $kendaraan = new Kendaraan();
        $kendaraan->nama = $nama;
        $kendaraan->nomor = $nomor;
        $kendaraan->jenis = $jenis;
        $kendaraan->save();

        return response()->json(['status' => "success", "message" => "Berhasil Input"]);
    }

    public function editkendaraan(Request $request)
    {
        $id = $request['id'];
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }

        $nama = $request['nama'];
        $jenis = $request['jenis'];
        $nomor = $request['nomor'];

        $kendaraan = Kendaraan::find($id);
        $kendaraan->nama = $nama;
        $kendaraan->nomor = $nomor;
        $kendaraan->jenis = $jenis;
        $kendaraan->save();

        return response()->json(['success' => "Berhasil Edit"]);
    }

    public function deletekendaraan(Request $request)
    {
        $id = $request['id'];
        $kendaraan = Kendaraan::find($id);
        $kendaraan->delete();
        return response()->json(['success' => "Berhasil Delete"]);
    }
}
