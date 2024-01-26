<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Test\TestController as Test;
use App\Http\Controllers\API\Auth\AuthController as Auth;
use App\Http\Controllers\API\Error\ErrorController as Error;
use App\Http\Controllers\API\Siswa\SoalController as SoalSiswa;
use App\Http\Controllers\API\Siswa\SiswaController as Siswa;
use App\Http\Controllers\API\Jurusan\JurusanController as Jurusan;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test', [Test::class, 'index']);
Route::post('/login', [Auth::class, 'login']);

Route::get('/error401', [Error::class, 'error401'])->name('get.error.401');

Route::middleware(['auth:jwt'])->prefix('check')->group(function(){
    Route::get('/auth', [Auth::class, 'check']);
});

Route::middleware(['auth:jwt', 'cekrole.siswa'])->prefix('siswa')->group(function(){
    Route::get('/data-soal', [SoalSiswa::class, 'soal']);
    Route::get('/logout', [Auth::class, 'logout']);
});

Route::middleware(['auth:jwt', 'cekrole.admin'])->prefix('admin')->group(function(){
    Route::get('/siswa', [Siswa::class, 'index']);
    Route::post('/siswa/create', [Siswa::class, 'create']);
    Route::post('/siswa/create/batch', [Siswa::class, 'batchCreate']);
    Route::put('/siswa/update', [Siswa::class, 'update']);
    Route::get('/siswa/delete/{id}', [Siswa::class, 'destroy']);
    Route::get('/jurusan', [Jurusan::class, 'index']);
    Route::get('/logout', [Auth::class, 'logout']);
});