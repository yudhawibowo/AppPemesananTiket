<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiketController extends Controller
{
    public function index(){
        $data = DB::table("tiket")->get();
        return $data;
    }
    
}
