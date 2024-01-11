<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Index\IndexController as Index;
use App\Http\Controllers\Auth\AuthController as Auth;
use App\Http\Controllers\Error\ErrorController as Error;
use App\Http\Controllers\Admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\Siswa\DashboardController as DashboardSiswa;
use App\Http\Controllers\Siswa\SoalController as SoalSiswa;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{any?}', [Index::class, 'index'])->where('any', '^(?!api\/)[\/\w\.-]*');

// Route::middleware(['guest'])->group(function(){
//     Route::get('/', [Auth::class, 'index'])->name('get.login');
//     Route::post('/login', [Auth::class, 'login'])->name('post.login');

//     Route::get('/aksesditolak', [Error::class, 'accessDenied'])->name('get.accessdenied');
// });

// Route::middleware(['auth:jwt', 'cekrole.admin'])->prefix('admin')->name('admin.')->group(function(){
//     Route::get('/dashboard', [DashboardAdmin::class, 'index'])->name('get.dashboard');
// });

// Route::middleware(['auth:jwt', 'cekrole.siswa'])->prefix('siswa')->name('siswa.')->group(function(){
//     Route::get('/dashboard', [DashboardSiswa::class, 'index'])->name('get.dashboard');
//     Route::get('/soal', [SoalSiswa::class, 'getDataSoal'])->name('get.soal');
//     Route::get('/logout', [Auth::class, 'logout'])->name('get.logout');
// });
