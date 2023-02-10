<?php

use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\HomeController;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\Api\PanicButtonController;
use App\Http\Controllers\Api\PemesananController;
use App\Http\Controllers\Api\RenovationController;
use App\Http\Controllers\Api\TiketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('updateprofil', [UserController::class, 'updateprofil']);

Route::get('tiket', [TiketController::class, 'index']);
Route::get('pemesanan', [PemesananController::class, 'index']);
Route::post('savepemesanan', [PemesananController::class, 'save']);
Route::post('uploadbukti', [PemesananController::class, 'uploadbukti']);
