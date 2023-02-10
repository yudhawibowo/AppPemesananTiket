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
Route::post('datatiket', [TiketController::class, 'datatiket']);
Route::post('addtiket', [TiketController::class, 'addtiket']);
Route::post('edittiket', [TiketController::class, 'edittiket']);
Route::post('deletetiket', [TiketController::class, 'deletetiket']);

Route::get('pemesanan', [PemesananController::class, 'index']);
Route::get('pemesanan-selesai', [PemesananController::class, 'selesai']);
Route::post('konfirmasi-pemesanan', [PemesananController::class, 'konfirmasi']);
Route::post('datapemesanan', [PemesananController::class, 'datapemesanan']);
Route::post('deletepemesanan', [PemesananController::class, 'deletepemesanan']);
Route::get('laporan', [PemesananController::class, 'laporan']);
Route::post('datalaporan', [PemesananController::class, 'datalaporan']);




Route::post('datauserregistrasi', [UserController::class, 'datauserregistrasi']);
Route::post('dataalamat', [UserController::class, 'dataalamat']);

Route::post('acceptuser', [UserController::class, 'acceptuser']);
Route::post('addalamat', [UserController::class, 'addalamat']);
Route::post('editalamat', [UserController::class, 'editalamat']);
Route::post('deletealamat', [UserController::class, 'deletealamat']);

Route::get('group', [GroupController::class, 'index']);
Route::post('datagroup', [GroupController::class, 'datagroup']);
Route::post('addgroup', [GroupController::class, 'addgroup']);
Route::post('editgroup', [GroupController::class, 'editgroup']);
Route::post('deletegroup', [GroupController::class, 'deletegroup']);

Route::get('service', [ServiceController::class, 'index']);
Route::get('detailservice/{id}', [ServiceController::class, 'detail']);
Route::post('dataservice', [ServiceController::class, 'dataservice']);
Route::post('deleteservice', [ServiceController::class, 'deleteservice']);
Route::post('datadetailservice', [ServiceController::class, 'datadetailservice']);
Route::post('addservice', [ServiceController::class, 'addservice']);
Route::post('updateservice', [ServiceController::class, 'updateservice']);

Route::get('banner', [BannerController::class, 'index']);
Route::get('pengajuan-banner', [BannerController::class, 'pengajuanbanner']);
Route::post('datapengajuanbanner', [BannerController::class, 'datapengajuanbanner']);
Route::post('ubahstatuspengajuanbanner', [BannerController::class, 'ubahstatuspengajuanbanner']);
Route::get('detailbanner/{id}', [BannerController::class, 'detail']);
Route::post('databanner', [BannerController::class, 'databanner']);
Route::post('deletebanner', [BannerController::class, 'deletebanner']);
Route::post('datadetailbanner', [BannerController::class, 'datadetailbanner']);
Route::post('addbanner', [BannerController::class, 'addbanner']);
Route::post('updatebanner', [BannerController::class, 'updatebanner']);

Route::get('event', [EventController::class, 'index']);
Route::get('detailevent/{id}', [EventController::class, 'detail']);
Route::get('responseevent/{id}', [EventController::class, 'response']);
Route::post('dataevent', [EventController::class, 'dataevent']);
Route::post('dataresponseevent', [EventController::class, 'dataresponseevent']);
Route::post('deleteevent', [EventController::class, 'deleteevent']);
Route::post('datadetailevent', [EventController::class, 'datadetailevent']);
Route::post('addevent', [EventController::class, 'addevent']);
Route::post('updateevent', [EventController::class, 'updateevent']);

Route::get('news', [NewsController::class, 'index']);
Route::get('detailnews/{id}', [NewsController::class, 'detail']);
Route::post('datanews', [NewsController::class, 'datanews']);
Route::post('deletenews', [NewsController::class, 'deletenews']);
Route::post('datadetailnews', [NewsController::class, 'datadetailnews']);
Route::post('addnews', [NewsController::class, 'addnews']);
Route::post('updatenews', [NewsController::class, 'updatenews']);

Route::get('complaint', [ComplaintController::class, 'index']);
Route::post('datacomplaint', [ComplaintController::class, 'datacomplaint']);
Route::post('sendfeedback', [ComplaintController::class, 'sendfeedback']);

Route::get('pengajuanrenovasi', [RenovationController::class, 'pengajuan']);
Route::get('underconstructionrenovasi', [RenovationController::class, 'underconstruction']);
Route::get('laporanrenovasi', [RenovationController::class, 'laporan']);
Route::get('renovasiditolak', [RenovationController::class, 'ditolak']);

Route::post('datarenovasi', [RenovationController::class, 'datarenovasi']);
Route::post('ubahstatusrenovasi', [RenovationController::class, 'ubahstatus']);

Route::get('setting', [SettingsController::class, 'index']);
Route::post('datasetting', [SettingsController::class, 'datasetting']);
Route::post('updatesetting', [SettingsController::class, 'updatesetting']);

Route::get('submission', [SubmissionController::class, 'index']);
Route::post('datasubmission', [SubmissionController::class, 'datasubmission']);
Route::post('ubahstatussubmission', [SubmissionController::class, 'ubahstatus']);

Route::get('panicbutton', [PanicbuttonController::class, 'index']);
Route::post('datapanicbutton', [PanicButtonController::class, 'datapanicbutton']);

Route::get('notification', [NotificationController::class, 'index']);
Route::post('sendnotification', [NotificationController::class, 'sendnotification']);
Route::post('datanotifikasi', [NotificationController::class, 'datanotifikasi']);

Route::get('profil', [AuthController::class, 'profil']);
Route::post('dataprofil', [AuthController::class, 'dataprofil']);
Route::post('updatepassword', [AuthController::class, 'updatepassword']);
Route::post('resetpassword', [AuthController::class, 'resetpassword']);
