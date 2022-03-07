<?php

use App\Http\Controllers\Api\HosToHostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::apiResource('/check', HosToHostController::class);
Route::post('/polis/store', [HosToHostController::class, 'pengajuanPolis']);
Route::post('/akseptasi/{id}', [HosToHostController::class, 'akseptasi']);
Route::post('/check', [HosToHostController::class, 'cekRate']);
Route::get('/cetak/{id}', [HosToHostController::class, 'cetak']);
Route::get('/show/{id}', [HosToHostController::class, 'show']);
Route::post('/branch/store', [HosToHostController::class, 'storeBranch']);
