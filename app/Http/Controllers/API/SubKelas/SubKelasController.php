<?php

namespace App\Http\Controllers\API\SubKelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubKelas;

class SubKelasController extends Controller
{
    public function index(){
        $subKelas = SubKelas::orderBy('nama_sub_kelas', 'asc')->get();

        return response()->json([
            "code"  => 200,
            "data"  => $subKelas
        ], 200);
    }
}
