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