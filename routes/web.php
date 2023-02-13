<?php

use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\PanicButtonController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\RenovationController;
use App\Http\Controllers\TiketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',  [AuthController::class, 'dashboard']);
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::post('datadashboard', [HomeController::class, 'data']);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

Route::get('user', [UserController::class, 'index']);
Route::get('detailuser/{id}', [UserController::class, 'detailuser']);
Route::post('datauser', [UserController::class, 'datauser']);
Route::post('adduser', [UserController::class, 'adduser']);
Route::post('edituser', [UserController::class, 'edituser']);
Route::post('deleteuser', [UserController::class, 'deleteuser']);
Route::post('datadetailuser', [UserController::class, 'datadetailuser']);

Route::get('kendaraan', [KendaraanController::class, 'index']);
Route::post('datakendaraan', [KendaraanController::class, 'datakendaraan']);
Route::post('addkendaraan', [KendaraanController::class, 'addkendaraan']);
Route::post('editkendaraan', [KendaraanController::class, 'editkendaraan']);
Route::post('deletekendaraan', [KendaraanController::class, 'deletekendaraan']);

Route::get('tiket', [TiketController::class, 'index']);
Route::get('tiketmasuk', [TiketController::class, 'indextiketmasuk']);
Route::post('datatiket', [TiketController::class, 'datatiket']);
Route::post('datatiketmasuk', [TiketController::class, 'datatiketmasuk']);
Route::post('addtiket', [TiketController::class, 'addtiket']);
Route::post('edittiket', [TiketController::class, 'edittiket']);
Route::post('edittiketmasuk', [TiketController::class, 'edittiketmasuk']);
Route::post('deletetiket', [TiketController::class, 'deletetiket']);

Route::get('pemesanan', [PemesananController::class, 'index']);
Route::get('pemesanan-selesai', [PemesananController::class, 'selesai']);
Route::post('konfirmasi-pemesanan', [PemesananController::class, 'konfirmasi']);
Route::post('datapemesanan', [PemesananController::class, 'datapemesanan']);
Route::post('deletepemesanan', [PemesananController::class, 'deletepemesanan']);
Route::get('laporan', [PemesananController::class, 'laporan']);
Route::post('datalaporan', [PemesananController::class, 'datalaporan']);