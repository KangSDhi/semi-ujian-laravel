<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Test\TestController as Test;
use App\Http\Controllers\API\Auth\AuthController as Auth;
use App\Http\Controllers\API\Error\ErrorController as Error;
use App\Http\Controllers\API\Soal\SoalController as Soal;
use App\Http\Controllers\API\Siswa\SiswaController as Siswa;
use App\Http\Controllers\API\Jurusan\JurusanController as Jurusan;
use App\Http\Controllers\API\Tingkat\TingkatController as Tingkat;
use App\Http\Controllers\API\Kelas\KelasController as Kelas;
use App\Http\Controllers\API\Chart\SiswaChartController as SiswaChart;

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
    Route::get('/soal/user', [Soal::class, 'getSoalByUser']);
    Route::get('/logout', [Auth::class, 'logout']);
});

Route::middleware(['auth:jwt', 'cekrole.admin'])->prefix('admin')->group(function(){
    Route::get('/siswa', [Siswa::class, 'index']);
    Route::post('/siswa/create', [Siswa::class, 'create']);
    Route::post('/siswa/create/batch', [Siswa::class, 'batchCreate']);
    Route::put('/siswa/update', [Siswa::class, 'update']);
    Route::delete('/siswa/delete/{id}', [Siswa::class, 'destroy']);
    Route::get('/soal', [Soal::class, 'getSoalJoinJurusanTingkat']);
    Route::post('/soal/create', [Soal::class, 'create']);
    Route::put('/soal/update', [Soal::class, 'update']);
    Route::delete('/soal/delete/{id}', [Soal::class, 'destroy']);
    Route::get('/jurusan', [Jurusan::class, 'index']);
    Route::post('/jurusan/create', [Jurusan::class, 'create']);
    Route::put('/jurusan/update', [Jurusan::class, 'update']);
    Route::delete('/jurusan/delete/{id}', [Jurusan::class, 'destroy']);
    Route::get('/tingkat', [Tingkat::class, 'index']);
    Route::post('/tingkat/create', [Tingkat::class, 'create']);
    Route::delete('/tingkat/delete/{id}', [Tingkat::class, 'destroy']);
    Route::put('/tingkat/update', [Tingkat::class, 'update']);
    Route::get('/kelas', [Kelas::class, 'index']);
    Route::get('/kelas/tingkat-jurusan', [Kelas::class, 'getKelasByJoinTingkatAndJurusan']);
    Route::post('/kelas/create', [Kelas::class, 'create']);
    Route::put('/kelas/update', [Kelas::class, 'update']);
    Route::delete('kelas/delete/{id}', [Kelas::class, 'destroy']);
    Route::get('/chart/siswa/total/tingkat/jurusan', [SiswaChart::class, 'chartSiswaTotalTingkatJurusan']);
    Route::get('/logout', [Auth::class, 'logout']);
});
