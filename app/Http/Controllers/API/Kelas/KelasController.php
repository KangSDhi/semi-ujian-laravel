<?php

namespace App\Http\Controllers\API\Kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index(){
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return response()->json([
            "code"  => 200,
            "data"  => $kelas
        ], 200);
    }
}
