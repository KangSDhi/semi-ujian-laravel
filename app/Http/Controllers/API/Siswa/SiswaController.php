<?php

namespace App\Http\Controllers\API\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(){
        $siswa = User::join('jurusan', 'users.jurusan_id', 'jurusan.id')
            ->select(DB::raw('users.id, 
            users.NISN as nisn, 
            users.name as nama_siswa,
            jurusan.nama as nama_jurusan,
            users.password_dec'))
            ->where('role_id', 2)
            ->get();
        
        return response()->json([
            "code"  => 200,
            "data"  => $siswa
        ], 200);
    }
}
