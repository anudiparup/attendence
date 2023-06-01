<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\AttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login',[UserController::class,'loginUser']);
Route::post('insertIntoAttendanceFromCMIS',[AttendanceController::class,'insertIntoAttendanceFromCMIS']);
Route::post('UpdateAttendance',[AttendanceController::class,'UpdateAttendance']);
Route::post('insertIntoAttendanceFromCMISFromExcel',[AttendanceController::class,'insertIntoAttendanceFromCMISFromExcel']);

Route::get('fetchDataForCheckingRedis',[AttendanceController::class,'fetchDataForCheckingRedis']);

Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[UserController::class,'userDetails']);
    Route::get('logout',[UserController::class,'logout']);
    Route::post('store-attendance',[AttendanceController::class,'storeAttendance']);
    Route::get('fetch-attendance/{user_id}/{cur_month}/{cur_year}',[AttendanceController::class,'fetchAttendance']);
    Route::get('fetch-attendance-based-on-currentdate/{user_id}/{cur_date?}',[AttendanceController::class,'fetchAttendanceBasedOnCurrentDate']);
    
});
