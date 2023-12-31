<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;

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

Route::get('/practice',[PracticeController::class,'sample']);
Route::get('/practice2',[PracticeController::class,'sample2']);
Route::get('/practice3',[PracticeController::class,'sample3']);
Route::get('/getPractice',[PracticeController::class,'getPractice']);

Route::get('/movies',[MovieController::class,'index']);

//トップ画面
Route::get('/admin/movies',[MovieController::class,'index'])->name('admin.movies');
//新規作成画面
Route::get('/admin/movies/create',[MovieController::class,'create']);
//新規作成処理
Route::get('/admin/movies/store',[MovieController::class,'store']);
Route::post('/admin/movies/store',[MovieController::class,'store']);
Route::patch('/admin/movies/store',[MovieController::class,'store']);
//編集画面
Route::get('/admin/movies/{id}/edit',[MovieController::class,'edit']);
//更新処理
Route::get('/admin/movies/{id}/update',[MovieController::class,'update']);
Route::post('/admin/movies/{id}/update',[MovieController::class,'update']);
Route::patch('/admin/movies/{id}/update',[MovieController::class,'update']);
//削除処理
Route::get('/admin/movies/{id}/destroy',[MovieController::class,'destroy']);
Route::post('/admin/movies/{id}/destroy',[MovieController::class,'destroy']);
Route::delete('/admin/movies/{id}/destroy',[MovieController::class,'destroy']);