<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\ApiMahasiswaController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [ApiMahasiswaController::class, 'login']);
Route::post('/logout', [ApiMahasiswaController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('mahasiswas', [ApiMahasiswaController::class, 'index']);
    Route::get('mahasiswas/{id}', [ApiMahasiswaController::class, 'show']);
    Route::post('mahasiswas', [ApiMahasiswaController::class, 'store']);
    Route::put('mahasiswas/{id}', [ApiMahasiswaController::class, 'update']);
    Route::delete('mahasiswas/{id}', [ApiMahasiswaController::class, 'destroy']);
    
});

