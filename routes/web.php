<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SheetsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReservationController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');



require __DIR__.'/auth.php';

Route::get('/practice',[PracticeController::class,'sample']);
Route::get('/practice2',[PracticeController::class,'sample2']);
Route::get('/practice3',[PracticeController::class,'sample3']);
Route::get('/getPractice',[PracticeController::class,'getPractice']);


//映画一覧画面
Route::get('/admin/movies',[MovieController::class,'adminIndex'])->name('admin.movies');
Route::post('/admin/movies',[MovieController::class,'adminIndex'])->name('admin.movies');

//映画新規作成画面
Route::get('/admin/movies/create',[MovieController::class,'create']);
//映画新規作成処理
Route::get('/admin/movies/store',[MovieController::class,'store']);
Route::post('/admin/movies/store',[MovieController::class,'store']);
Route::patch('/admin/movies/store',[MovieController::class,'store']);

//映画編集画面
Route::get('/admin/movies/{id}/edit',[MovieController::class,'edit']);
//映画更新処理
Route::get('/admin/movies/{id}/update',[MovieController::class,'update']);
Route::post('/admin/movies/{id}/update',[MovieController::class,'update']);
Route::patch('/admin/movies/{id}/update',[MovieController::class,'update']);

//映画削除処理
Route::get('/admin/movies/{id}/destroy',[MovieController::class,'destroy']);
Route::post('/admin/movies/{id}/destroy',[MovieController::class,'destroy']);
Route::delete('/admin/movies/{id}/destroy',[MovieController::class,'destroy']);

//詳細画面
Route::get('admin/movies/{id}',[ScheduleController::class,'detail']);



//スケジュール新規作成画面
Route::get('/admin/movies/{id}/schedules/create',[ScheduleController::class,'create']);
//スケジュール新規作成処理
Route::get('/admin/movies/{id}/schedules/store',[ScheduleController::class,'store']);
Route::post('/admin/movies/{id}/schedules/store',[ScheduleController::class,'store']);
Route::patch('/admin/movies/{id}/schedules/store',[ScheduleController::class,'store']);




//スケジュール一覧画面
Route::get('/admin/schedules',[ScheduleController::class,'index'])->name('admin.schedules');
Route::get('/admin/schedules/{id}',[ScheduleController::class,'indexSingle']);

//スケジュール編集画面
Route::get('/admin/schedules/{id}/edit',[ScheduleController::class,'edit']);
//スケジュール更新処理
Route::get('/admin/schedules/{id}/update',[ScheduleController::class,'update']);
Route::post('/admin/schedules/{id}/update',[ScheduleController::class,'update']);
Route::patch('/admin/schedules/{id}/update',[ScheduleController::class,'update']);

//スケジュール削除処理
Route::get('/admin/schedules/{id}/destroy',[ScheduleController::class,'destroy']);
Route::post('/admin/schedules/{id}/destroy',[ScheduleController::class,'destroy']);
Route::delete('/admin/schedules/{id}/destroy',[ScheduleController::class,'destroy']);




//予約管理関連
Route::get('/admin/reservations/',[ReservationController::class,'index'])->name('admin.reservations');
Route::get('/admin/reservations/create',[ReservationController::class,'reservationsAdminCreate']);
Route::get('/admin/reservations/getScheduleList',[ReservationController::class,'getScheduleList']);
Route::get('/admin/reservations/getSheetList',[ReservationController::class,'getSheetList']);
Route::post('/admin/reservations/',[ReservationController::class,'adminReservationsStore']);
Route::delete('/admin/reservations/{reservations_id}/',[ReservationController::class,'destroy']);
Route::get('/admin/reservations/{reservations_id}/edit',[ReservationController::class,'edit']);
Route::get('/admin/reservations/{reservations_id}/',[ReservationController::class,'edit']);
Route::put('/admin/reservations/{reservations_id}/',[ReservationController::class,'update']);
Route::patch('/admin/reservations/{reservations_id}/',[ReservationController::class,'update']);




//座席画面
Route::get('/sheets',[SheetsController::class,'index']);

//座席予約
Route::group(['middleware' => 'auth'], function() {
    //座席予約画面
    Route::get('/movies/{movie_id}/schedules/{schedule_id}/sheets',[ReservationController::class,'sheets']);
    //座席予約作成画面
    Route::get('/movies/{movie_id}/schedules/{schedule_id}/reservations/create',[ReservationController::class,'reservationsCreate']);
    //座席予約作成処理
    Route::get('/reservations/store',[ReservationController::class,'reservationsStore']);
    Route::post('/reservations/store',[ReservationController::class,'reservationsStore']);
});

//動画一覧
Route::get('/movies',[MovieController::class,'index'])->name('user.movies');
Route::get('movies/{id}',[ScheduleController::class,'detail']);


